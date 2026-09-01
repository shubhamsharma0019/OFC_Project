<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use App\Models\Certificate;
use App\Models\CompanyResumeAssignment;
use App\Models\CourseEnrollment;
use App\Models\Interview;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FresherDashboardController extends Controller
{
    /**
     * Logged-in Fresher ka dashboard summary.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access this dashboard.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        $applicationQuery = JobApplication::query()
            ->where('fresher_profile_id', $fresherProfile->id);

        $enrollmentQuery = CourseEnrollment::query()
            ->where('fresher_profile_id', $fresherProfile->id);

        $initialAssessment = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('assessment_type', 'initial')
            ->where('created_at', '>=', $fresherProfile->created_at)
            ->with('result')
            ->latest('updated_at')
            ->first();

        $finalAssessment = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('assessment_type', 'final')
            ->where('created_at', '>=', $fresherProfile->created_at)
            ->with('result')
            ->latest('updated_at')
            ->first();

        $latestEnrollment = CourseEnrollment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->with([
                'course.trainingPartnerProfile',
                'trainingProgress',
                'certificate',
            ])
            ->latest('enrollment_date')
            ->first();

        $assessmentResult = $initialAssessment?->result;
        $directModeThreshold = (float) config(
            'onlyfreshers.assessment.direct_mode_threshold',
            50
        );
        $internshipEligibilityScore = (float) config(
            'onlyfreshers.assessment.internship_eligibility_score',
            50
        );
        $overallScore = (float) ($assessmentResult?->overall_score ?? 0);
        $recommendedMode = $assessmentResult
            ? ($overallScore >= $directModeThreshold ? 'direct' : 'fast_track')
            : null;
        $directModeEligible =
            $assessmentResult &&
            $overallScore >= $directModeThreshold;
        $directCareerEligible =
            $assessmentResult &&
            $overallScore >= $internshipEligibilityScore;
        $retakeCooldownDays = (int) config(
            'onlyfreshers.assessment.initial_retake_cooldown_days',
            30
        );
        $retakeAvailableAt = $initialAssessment?->submitted_at
            ? $initialAssessment->submitted_at->copy()->addDays($retakeCooldownDays)
            : null;
        $canRetakeInitialAssessment = !$assessmentResult ||
            $overallScore >= $directModeThreshold ||
            !$retakeAvailableAt ||
            now()->gte($retakeAvailableAt);
        $freeApplicationCredits = (int) config(
            'onlyfreshers.direct_mode.free_application_credits',
            250
        );
        $applicationCreditCost = (int) config(
            'onlyfreshers.direct_mode.application_credit_cost',
            50
        );
        $usedApplicationCredits = (int) $fresherProfile->total_direct_mode_credits_used;
        $remainingApplicationCredits = (int) $fresherProfile->direct_mode_credits;
        $directModePlan = $fresherProfile->direct_mode_subscription_plan;
        $directModeExpiresAt = $fresherProfile->direct_mode_subscription_expires_at;
        $directModeDaysRemaining = $directModeExpiresAt
            ? max(0, today()->diffInDays($directModeExpiresAt, false))
            : null;

        $upcomingInterviews = Interview::query()
            ->whereHas('jobApplication', function ($query) use (
                $fresherProfile
            ) {
                $query->where(
                    'fresher_profile_id',
                    $fresherProfile->id
                );
            })
            ->where('status', 'scheduled')
            ->with([
                'jobApplication.job.companyProfile',
            ])
            ->orderBy('interview_date')
            ->orderBy('interview_time')
            ->get();

        $resumeInterviews = CompanyResumeAssignment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->whereIn('status', ['interview_sent', 'interview_completed', 'hired', 'not_selected'])
            ->whereNotNull('interview_link')
            ->whereNotNull('interview_date')
            ->whereNotNull('interview_time')
            ->with([
                'companyProfile:id,company_name,company_logo',
            ])
            ->orderBy('interview_date')
            ->orderBy('interview_time')
            ->get()
            ->map(function (CompanyResumeAssignment $assignment) use ($fresherProfile) {
                $displayStatus = match ($assignment->status) {
                    'interview_sent' => 'scheduled',
                    'interview_completed' => 'completed',
                    default => $assignment->status,
                };

                return [
                    'id' => 'resume-' . $assignment->id,
                    'source' => 'resume_assignment',
                    'assignment_id' => $assignment->id,
                    'interview_date' => $assignment->interview_date?->format('Y-m-d'),
                    'interview_time' => $assignment->interview_time,
                    'interview_mode' => 'online',
                    'interview_location' => null,
                    'meeting_link' => $assignment->interview_link,
                    'status' => $displayStatus,
                    'assignment_status' => $assignment->status,
                    'company_joined_at' => optional($assignment->company_joined_at)->toIso8601String(),
                    'fresher_joined_at' => optional($assignment->fresher_joined_at)->toIso8601String(),
                    'both_joined' => filled($assignment->company_joined_at) && filled($assignment->fresher_joined_at),
                    'created_at' => $assignment->created_at,
                    'updated_at' => $assignment->updated_at,
                    'job_application' => [
                        'id' => 'resume-' . $assignment->id,
                        'job_id' => null,
                        'fresher_profile_id' => $fresherProfile->id,
                        'application_status' => 'interview_scheduled',
                        'job' => [
                            'id' => 'resume-' . $assignment->id,
                            'company_profile_id' => $assignment->company_profile_id,
                            'title' => 'Resume Shortlist Interview',
                            'company_profile' => $assignment->companyProfile,
                        ],
                    ],
                ];
            });

        $upcomingInterviews = $upcomingInterviews
            ->concat($resumeInterviews)
            ->sortBy(fn ($interview) => ($interview['interview_date'] ?? $interview->interview_date) . ' ' . ($interview['interview_time'] ?? $interview->interview_time))
            ->values();

        $recentApplications = JobApplication::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->with([
                'job.companyProfile',
                'interview',
            ])
            ->latest('applied_at')
            ->limit(5)
            ->get();

        $certificates = Certificate::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->with([
                'courseEnrollment.course.trainingPartnerProfile',
            ])
            ->latest()
            ->limit(5)
            ->get();

        $resumeAssignments = CompanyResumeAssignment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->whereIn('status', [
                'shortlisted',
                'interview_sent',
                'interview_completed',
                'hired',
                'not_selected',
            ])
            ->with([
                'companyProfile:id,company_name,company_logo,industry',
            ])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (CompanyResumeAssignment $assignment) => [
                'id' => 'resume-' . $assignment->id,
                'source' => 'resume_assignment',
                'assignment_id' => $assignment->id,
                'application_status' => match ($assignment->status) {
                    'interview_sent' => 'interview_scheduled',
                    'interview_completed' => 'interview_completed',
                    'not_selected' => 'rejected',
                    default => $assignment->status,
                },
                'status' => $assignment->status,
                'applied_at' => $assignment->created_at,
                'created_at' => $assignment->created_at,
                'updated_at' => $assignment->updated_at,
                'interview_link' => $assignment->interview_link,
                'interview_date' => $assignment->interview_date?->format('Y-m-d'),
                'interview_time' => $assignment->interview_time,
                'job' => [
                    'id' => 'resume-' . $assignment->id,
                    'title' => 'Resume Shortlist',
                    'hiring_mode' => 'resume_only',
                    'status' => 'active',
                    'location' => $fresherProfile->city,
                    'job_type' => $fresherProfile->preferred_job_category ?: 'Resume Access',
                    'company_profile' => $assignment->companyProfile,
                ],
            ]);

        $recentApplications = $recentApplications
            ->concat($resumeAssignments)
            ->sortByDesc(fn ($item) => $item['updated_at'] ?? $item->updated_at ?? $item['created_at'] ?? $item->created_at)
            ->values()
            ->take(5);

        $resumeShortlistedCount = CompanyResumeAssignment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->whereIn('status', [
                'shortlisted',
                'interview_sent',
                'interview_completed',
                'hired',
                'not_selected',
            ])
            ->count();

        $resumeInterviewCount = CompanyResumeAssignment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->whereIn('status', [
                'interview_sent',
                'interview_completed',
                'hired',
                'not_selected',
            ])
            ->count();

        $resumeHiredCount = CompanyResumeAssignment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('status', 'hired')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Fresher dashboard fetched successfully.',
            'data' => [
                'user' => $user,

                'profile' => [
                    'profile_id' => $fresherProfile->id,
                    'profile_completion' =>
                        $fresherProfile->profile_completion,
                    'city' => $fresherProfile->city,
                    'qualification' =>
                        $fresherProfile->qualification,
                    'skills' => $fresherProfile->skills,
                    'resume_uploaded' =>
                        !empty($fresherProfile->resume),
                    'direct_mode_subscription_plan' =>
                        $fresherProfile->direct_mode_subscription_plan,
                    'direct_mode_subscribed_at' =>
                        optional($fresherProfile->direct_mode_subscribed_at)->toIso8601String(),
                    'direct_mode_subscription_expires_at' =>
                        optional($directModeExpiresAt)->toIso8601String(),
                ],

                'statistics' => [
                    'total_applications' =>
                        (clone $applicationQuery)->count(),

                    'under_review_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'under_review'
                            )
                            ->count(),

                    'shortlisted_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'shortlisted'
                            )
                            ->count() + $resumeShortlistedCount,

                    'interview_scheduled_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'interview_scheduled'
                            )
                            ->count() + $resumeInterviewCount,

                    'hired_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'hired'
                            )
                            ->count() + $resumeHiredCount,

                    'rejected_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'rejected'
                            )
                            ->count(),

                    'scheduled_interviews' =>
                        $upcomingInterviews->count(),

                    'total_course_enrollments' =>
                        (clone $enrollmentQuery)->count(),

                    'active_trainings' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'training_status',
                                'in_progress'
                            )
                            ->count(),

                    'completed_trainings' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'training_status',
                                'completed'
                            )
                            ->count(),

                    'total_certificates' =>
                        Certificate::query()
                            ->where(
                                'fresher_profile_id',
                                $fresherProfile->id
                            )
                            ->count(),

                    'profile_views' => 0,
                ],

                'direct_mode_credits' => [
                    'free' => $freeApplicationCredits,
                    'used' => $usedApplicationCredits,
                    'remaining' => $remainingApplicationCredits,
                    'application_cost' => $applicationCreditCost,
                    'can_apply' =>
                        $remainingApplicationCredits >= $applicationCreditCost,
                    'active_plan' => $directModePlan,
                    'active_plan_label' => $directModePlan
                        ? ucfirst(str_replace('_', ' ', $directModePlan))
                        : 'Starter',
                    'subscribed_at' =>
                        optional($fresherProfile->direct_mode_subscribed_at)->toIso8601String(),
                    'valid_till' => optional($directModeExpiresAt)->toIso8601String(),
                    'days_remaining' => $directModeDaysRemaining,
                ],

                'initial_assessment' => $initialAssessment
                    ? [
                        'attempt_id' => $initialAssessment->id,
                        'status' => $initialAssessment->status,
                        'submitted_at' =>
                            $initialAssessment->submitted_at,
                        'result' => $assessmentResult,
                        'direct_mode_threshold' => $directModeThreshold,
                        'internship_eligibility_score' =>
                            $internshipEligibilityScore,
                        'recommended_mode' => $recommendedMode,
                        'can_retake_initial_assessment' =>
                            $canRetakeInitialAssessment,
                        'retake_available_at' =>
                            optional($retakeAvailableAt)->toIso8601String(),
                        'initial_retake_cooldown_days' =>
                            $retakeCooldownDays,
                        'eligible_paths' => [
                            'direct' => $directModeEligible,
                            'jobs' => $directModeEligible,
                            'internships' => $directCareerEligible,
                            'fast_track' => true,
                        ],
                    ]
                    : null,

                'final_assessment' => $finalAssessment
                    ? [
                        'attempt_id' => $finalAssessment->id,
                        'status' => $finalAssessment->status,
                        'submitted_at' => $finalAssessment->submitted_at,
                        'completed_at' => $finalAssessment->completed_at,
                        'result' => $finalAssessment->result,
                    ]
                    : null,

                'latest_course_enrollment' => $latestEnrollment,

                'upcoming_interviews' => $upcomingInterviews,

                'recent_applications' => $recentApplications,

                'recent_resume_assignments' => $resumeAssignments,

                'recent_certificates' => $certificates,
            ],
        ]);
    }
}
