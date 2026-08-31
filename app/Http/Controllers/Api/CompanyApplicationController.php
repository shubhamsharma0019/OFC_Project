<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyApplicationController extends Controller
{
    /**
     * Logged-in company ki jobs par aayi saari applications return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company applications dekh sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $applications = JobApplication::query()
            ->whereHas('job', function ($query) use ($companyProfile) {
                $query->where(
                    'company_profile_id',
                    $companyProfile->id
                );
            })
            ->with([
                'job:id,company_profile_id,title,hiring_mode,status,location,job_type',
                'fresherProfile:id,user_id,profile_photo,phone,city,qualification,college_name,passing_year,skills,resume,profile_completion,preferred_job_category',
                'fresherProfile.assessmentAttempts' => function ($query) {
                    $query->where('status', 'submitted')->latest('submitted_at');
                },
                'fresherProfile.assessmentAttempts.result',
                'fresherProfile.courseEnrollments.course:id,course_name,category,training_mode',
                'fresherProfile.user:id,name,email,role,status',
            ])
            ->latest('applied_at')
            ->get();

        $applications->each(fn (JobApplication $application) => $this->attachCandidateSummary($application));

        return response()->json([
            'success' => true,
            'message' => 'Company applications fetched successfully.',
            'data' => [
                'applications' => $applications,
            ],
        ]);
    }

    /**
     * Logged-in company single application ki details dekhegi.
     */
    public function show(
        Request $request,
        JobApplication $jobApplication
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company application details dekh sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $jobApplication->load([
            'job:id,company_profile_id,title,description,required_skills,qualification,location,salary,job_type,hiring_mode,status',
            'fresherProfile:id,user_id,profile_photo,phone,city,qualification,college_name,passing_year,skills,resume,profile_completion',
            'fresherProfile.assessmentAttempts' => function ($query) {
                $query->where('status', 'submitted')->latest('submitted_at');
            },
            'fresherProfile.assessmentAttempts.result',
            'fresherProfile.courseEnrollments.course:id,course_name,category,training_mode',
            'fresherProfile.user:id,name,email,role,status',
            'interview',
        ]);

        if (
            $jobApplication->job->company_profile_id
            !== $companyProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is application ko access nahi kar sakte.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Application details fetched successfully.',
            'data' => [
                'application' => $this->attachCandidateSummary($jobApplication),
            ],
        ]);
    }

    private function attachCandidateSummary(JobApplication $application): JobApplication
    {
        $profile = $application->fresherProfile;

        if (! $profile) {
            return $application;
        }

        $attempts = $profile->assessmentAttempts ?? collect();
        $initialAttempt = $attempts->firstWhere('assessment_type', 'initial');
        $finalAttempt = $attempts->firstWhere('assessment_type', 'final');
        $latestCourse = ($profile->courseEnrollments ?? collect())->first()?->course;
        $flow = $application->job?->hiring_mode ?? 'direct';

        $application->setAttribute('candidate_summary', [
            'flow' => $flow,
            'course' => $latestCourse?->course_name ?? $profile->qualification,
            'course_category' => $latestCourse?->category,
            'preferred_role' => $profile->preferred_job_category,
            'initial_score' => $initialAttempt?->result?->overall_score,
            'final_score' => $flow === 'fast_track' ? $finalAttempt?->result?->overall_score : null,
            'initial_result' => $initialAttempt?->result,
            'final_result' => $flow === 'fast_track' ? $finalAttempt?->result : null,
        ]);

        return $application;
    }

    /**
     * Company application ka status update karegi.
     */
    public function updateStatus(
        Request $request,
        JobApplication $jobApplication
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company application status update kar sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $jobApplication->load(['job', 'fresherProfile.user']);

        if (
            $jobApplication->job->company_profile_id
            !== $companyProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is application ka status update nahi kar sakte.',
            ], 403);
        }

        if (in_array($jobApplication->application_status, ['hired', 'rejected'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'This application already has a final status and cannot be updated.',
            ], 422);
        }

        $validatedData = $request->validate([
            'application_status' => [
                'required',
                Rule::in([
                    'under_review',
                    'shortlisted',
                    'rejected',
                ]),
            ],
        ]);

        $jobApplication->update([
            'application_status' =>
                $validatedData['application_status'],
        ]);

        if ($jobApplication->fresherProfile?->user_id) {
            $statusLabel = str_replace('_', ' ', $validatedData['application_status']);
            Notification::create([
                'user_id' => $jobApplication->fresherProfile->user_id,
                'type' => 'application_status',
                'title' => 'Application Status Updated',
                'message' => "Your application for {$jobApplication->job->title} is now {$statusLabel}.",
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully.',
            'data' => [
                'application' => $jobApplication->fresh(),
            ],
        ]);
    }



}
