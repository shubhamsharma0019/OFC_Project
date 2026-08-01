<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminApplicationController extends Controller
{
    /**
     * Admin ko saari job applications ki list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access job applications.',
            ], 403);
        }

        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:200',
            ],
            'application_status' => [
                'nullable',
                Rule::in([
                    'applied',
                    'under_review',
                    'shortlisted',
                    'interview_scheduled',
                    'hired',
                    'rejected',
                ]),
            ],
            'job_id' => [
                'nullable',
                'integer',
                'exists:jobs,id',
            ],
            'company_profile_id' => [
                'nullable',
                'integer',
                'exists:company_profiles,id',
            ],
            'fresher_profile_id' => [
                'nullable',
                'integer',
                'exists:fresher_profiles,id',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $applications = JobApplication::query()
            ->with([
                'job.companyProfile.user:id,name,email,mobile,role,status',
                'fresherProfile.user:id,name,email,mobile,role,status',
                'interview',
            ])
            ->when(
                $validated['search'] ?? null,
                function ($query, string $search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->whereHas(
                                'job',
                                function ($jobQuery) use ($search) {
                                    $jobQuery
                                        ->where('title', 'like', "%{$search}%")
                                        ->orWhereHas(
                                            'companyProfile',
                                            function ($companyQuery) use ($search) {
                                                $companyQuery->where(
                                                    'company_name',
                                                    'like',
                                                    "%{$search}%"
                                                );
                                            }
                                        );
                                }
                            )
                            ->orWhereHas(
                                'fresherProfile.user',
                                function ($userQuery) use ($search) {
                                    $userQuery
                                        ->where('name', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%");
                                }
                            );
                    });
                }
            )
            ->when(
                $validated['application_status'] ?? null,
                function ($query, string $status) {
                    $query->where('application_status', $status);
                }
            )
            ->when(
                $validated['job_id'] ?? null,
                function ($query, int $jobId) {
                    $query->where('job_id', $jobId);
                }
            )
            ->when(
                $validated['company_profile_id'] ?? null,
                function ($query, int $companyProfileId) {
                    $query->whereHas(
                        'job',
                        function ($jobQuery) use ($companyProfileId) {
                            $jobQuery->where(
                                'company_profile_id',
                                $companyProfileId
                            );
                        }
                    );
                }
            )
            ->when(
                $validated['fresher_profile_id'] ?? null,
                function ($query, int $fresherProfileId) {
                    $query->where(
                        'fresher_profile_id',
                        $fresherProfileId
                    );
                }
            )
            ->latest('applied_at')
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Job applications fetched successfully.',
            'data' => [
                'applications' => $applications,
            ],
        ]);
    }

    /**
     * Admin single job application ki complete details dekhega.
     */
    public function show(
        Request $request,
        JobApplication $jobApplication
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access job application details.',
            ], 403);
        }

        $jobApplication->load([
            'job.companyProfile.user',
            'fresherProfile.user',
            'interview',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job application details fetched successfully.',
            'data' => [
                'application' => $jobApplication,
            ],
        ]);
    }
}