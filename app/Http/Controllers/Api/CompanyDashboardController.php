<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    /**
     * Logged-in Company ka dashboard summary.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user || $user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only companies can access this dashboard.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile not found.',
            ], 404);
        }

        $jobQuery = Job::query()
            ->where('company_profile_id', $companyProfile->id);

        $applicationQuery = JobApplication::query()
            ->whereHas('job', function ($query) use ($companyProfile) {
                $query->where(
                    'company_profile_id',
                    $companyProfile->id
                );
            });

        $upcomingInterviews = Interview::query()
            ->whereHas('jobApplication.job', function ($query) use (
                $companyProfile
            ) {
                $query->where(
                    'company_profile_id',
                    $companyProfile->id
                );
            })
            ->where('status', 'scheduled')
            ->with([
                'jobApplication.job',
                'jobApplication.fresherProfile.user',
            ])
            ->orderBy('interview_date')
            ->orderBy('interview_time')
            ->get();

        $recentJobs = Job::query()
            ->where('company_profile_id', $companyProfile->id)
            ->withCount([
                'applications',
                'applications as shortlisted_applications_count' => function ($query) {
                    $query->where('application_status', 'shortlisted');
                },
            ])
            ->latest()
            ->limit(5)
            ->get();

        $recentApplications = JobApplication::query()
            ->whereHas('job', function ($query) use ($companyProfile) {
                $query->where(
                    'company_profile_id',
                    $companyProfile->id
                );
            })
            ->with([
                'job',
                'fresherProfile.user',
                'interview',
            ])
            ->latest('applied_at')
            ->limit(5)
            ->get();

        $freeJobPostings = (int) config(
            'onlyfreshers.company.free_job_postings',
            3
        );
        $directModeFreeResumesPerJob = (int) config(
            'onlyfreshers.company.direct_mode_free_resumes_per_job',
            5
        );
        $fastTrackFreeResumesPerJob = (int) config(
            'onlyfreshers.company.fast_track_free_resumes_per_job',
            2
        );
        $usedJobPostings = (clone $jobQuery)->count();

        return response()->json([
            'success' => true,
            'message' => 'Company dashboard fetched successfully.',
            'data' => [
                'user' => $user,

                'company_profile' => [
                    'profile_id' => $companyProfile->id,
                    'company_name' => $companyProfile->company_name,
                    'industry' => $companyProfile->industry,
                    'approval_status' =>
                        $companyProfile->approval_status,
                    'hiring_intent' =>
                        $companyProfile->hiring_intent,
                    'rejection_reason' =>
                        $companyProfile->rejection_reason,
                    'job_credits' => $companyProfile->job_credits,
                    'job_post_credit_cost' => 50,
                    'total_job_credits_used' =>
                        $companyProfile->total_job_credits_used,
                    'subscription_plan' =>
                        $companyProfile->subscription_plan,
                    'subscribed_at' =>
                        optional($companyProfile->subscribed_at)->toIso8601String(),
                    'website' => $companyProfile->website,
                    'address' => $companyProfile->address,
                ],

                'statistics' => [
                    'total_jobs' =>
                        (clone $jobQuery)->count(),

                    'active_jobs' =>
                        (clone $jobQuery)
                            ->where('status', 'active')
                            ->count(),

                    'inactive_jobs' =>
                        (clone $jobQuery)
                            ->where('status', 'inactive')
                            ->count(),

                    'closed_or_removed_jobs' =>
                        (clone $jobQuery)
                            ->whereNotIn('status', [
                                'active',
                                'inactive',
                            ])
                            ->count(),

                    'total_applications' =>
                        (clone $applicationQuery)->count(),

                    'applied_applications' =>
                        (clone $applicationQuery)
                            ->where(
                                'application_status',
                                'applied'
                            )
                            ->count(),

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
                ],

                'free_limits' => [
                    'job_credits' => [
                        'remaining' => (int) $companyProfile->job_credits,
                        'initial' => 500,
                        'used' => (int) $companyProfile->total_job_credits_used,
                        'cost_per_post' => 50,
                        'can_post' => $companyProfile->job_credits >= 50,
                    ],
                    'job_postings' => [
                        'used' => min($usedJobPostings, $freeJobPostings),
                        'total' => $freeJobPostings,
                        'remaining' => max(
                            0,
                            $freeJobPostings - $usedJobPostings
                        ),
                        'recent_on' => optional(
                            (clone $jobQuery)->latest()->first()?->created_at
                        )->format('d M Y'),
                    ],
                    'direct_mode_resumes_per_job' => [
                        'used' => 0,
                        'total' => $directModeFreeResumesPerJob,
                        'remaining' => $directModeFreeResumesPerJob,
                    ],
                    'fast_track_resumes_per_job' => [
                        'used' => 0,
                        'total' => $fastTrackFreeResumesPerJob,
                        'remaining' => $fastTrackFreeResumesPerJob,
                    ],
                ],

                'dashboard_config' => config(
                    'onlyfreshers.company.dashboard',
                    []
                ),

                'upcoming_interviews' => $upcomingInterviews,

                'recent_jobs' => $recentJobs,

                'recent_applications' => $recentApplications,
            ],
        ]);
    }
}
