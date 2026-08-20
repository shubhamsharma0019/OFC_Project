<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use App\Models\Certificate;
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
            ->with('result')
            ->latest('updated_at')
            ->first();

        $finalAssessment = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('assessment_type', 'final')
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
        $directCareerEligible =
            $assessmentResult &&
            $overallScore >= $internshipEligibilityScore;
        $freeApplicationCredits = (int) config(
            'onlyfreshers.direct_mode.free_application_credits',
            500
        );
        $applicationCreditCost = (int) config(
            'onlyfreshers.direct_mode.application_credit_cost',
            1
        );
        $usedApplicationCredits =
            (clone $applicationQuery)->count() * $applicationCreditCost;
        $remainingApplicationCredits = max(
            0,
            $freeApplicationCredits - $usedApplicationCredits
        );

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
                            ->count(),

                    'interview_scheduled_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'interview_scheduled'
                            )
                            ->count(),

                    'hired_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'hired'
                            )
                            ->count(),

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
                        'eligible_paths' => [
                            'jobs' => $directCareerEligible,
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

                'recent_certificates' => $certificates,
            ],
        ]);
    }
}
