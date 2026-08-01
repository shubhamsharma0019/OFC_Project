<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
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
                'job:id,company_profile_id,title,hiring_mode,status',
                'fresherProfile:id,user_id,profile_photo,phone,city,qualification,college_name,passing_year,skills,resume,profile_completion',
                'fresherProfile.user:id,name,email,role,status',
            ])
            ->latest('applied_at')
            ->get();

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
                'application' => $jobApplication,
            ],
        ]);
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

        $jobApplication->load('job');

        if (
            $jobApplication->job->company_profile_id
            !== $companyProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is application ka status update nahi kar sakte.',
            ], 403);
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

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully.',
            'data' => [
                'application' => $jobApplication->fresh(),
            ],
        ]);
    }



}