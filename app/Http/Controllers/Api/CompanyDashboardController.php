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
            ->withCount('applications')
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
                    'rejection_reason' =>
                        $companyProfile->rejection_reason,
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

                'upcoming_interviews' => $upcomingInterviews,

                'recent_jobs' => $recentJobs,

                'recent_applications' => $recentApplications,
            ],
        ]);
    }
}