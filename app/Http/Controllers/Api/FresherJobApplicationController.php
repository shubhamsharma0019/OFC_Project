<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FresherJobApplicationController extends Controller
{
    /**
     * Logged-in fresher ki saari applications return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf fresher apni applications dekh sakta hai.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (! $fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile nahi mili.',
            ], 422);
        }

        $applications = $fresherProfile
            ->jobApplications()
            ->with([
                'job:id,company_profile_id,title,location,salary,job_type,hiring_mode,status',
                'job.companyProfile:id,company_name,company_logo',
                'interview',
            ])
            ->latest('applied_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Fresher applications fetched successfully.',
            'data' => [
                'applications' => $applications,
            ],
        ]);
    }

    /**
     * Logged-in fresher active job par apply karega.
     */
    public function apply(
        Request $request,
        Job $job
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf fresher job ke liye apply kar sakta hai.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (! $fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Pehle fresher profile complete karein.',
            ], 422);
        }

        $isFastTrackJob = $job->hiring_mode === 'fast_track';

        if (
            empty($fresherProfile->phone) ||
            empty($fresherProfile->qualification) ||
            empty($fresherProfile->skills) ||
            (! $isFastTrackJob && empty($fresherProfile->resume))
        ) {
            return response()->json([
                'success' => false,
                'message' => $isFastTrackJob
                    ? 'Job apply karne se pehle profile details aur skills complete karein.'
                    : 'Job apply karne se pehle profile details, skills aur resume complete karein.',
            ], 422);
        }

        $assessmentSubmitted = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('assessment_type', 'initial')
            ->where('status', 'submitted')
            ->exists();

        if (! $isFastTrackJob && ! $assessmentSubmitted) {
            return response()->json([
                'success' => false,
                'message' => 'Job apply karne se pehle initial assessment complete karein.',
            ], 422);
        }

        if ($job->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Ye job abhi active nahi hai.',
            ], 422);
        }

        if (
            $job->application_last_date &&
            $job->application_last_date->lt(today())
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Is job ki application last date expire ho chuki hai.',
            ], 422);
        }

        $alreadyApplied = JobApplication::query()
            ->where('job_id', $job->id)
            ->where('fresher_profile_id', $fresherProfile->id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is job ke liye pehle hi apply kar chuke hain.',
            ], 422);
        }

        $application = JobApplication::create([
            'job_id' => $job->id,
            'fresher_profile_id' => $fresherProfile->id,
            'application_status' => 'applied',
            'applied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job application submitted successfully.',
            'data' => [
                'application' => $application,
            ],
        ], 201);
    }
}
