<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminJobController extends Controller
{
    /**
     * Admin ko saare jobs ki list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access jobs.',
            ], 403);
        }

        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:200',
            ],
            'status' => [
                'nullable',
                Rule::in([
                    'draft',
                    'active',
                    'inactive',
                    'removed',
                ]),
            ],
            'hiring_mode' => [
                'nullable',
                Rule::in([
                    'direct',
                    'fast_track',
                ]),
            ],
            'company_profile_id' => [
                'nullable',
                'integer',
                'exists:company_profiles,id',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $jobs = Job::query()
            ->with([
                'companyProfile.user:id,name,email,mobile,role,status',
            ])
            ->withCount('applications')
            ->when(
                $validated['search'] ?? null,
                function ($query, string $search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('required_skills', 'like', "%{$search}%")
                            ->orWhere('qualification', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%")
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
                    });
                }
            )
            ->when(
                $validated['status'] ?? null,
                function ($query, string $status) {
                    $query->where('status', $status);
                }
            )
            ->when(
                $validated['hiring_mode'] ?? null,
                function ($query, string $hiringMode) {
                    $query->where('hiring_mode', $hiringMode);
                }
            )
            ->when(
                $validated['company_profile_id'] ?? null,
                function ($query, int $companyProfileId) {
                    $query->where(
                        'company_profile_id',
                        $companyProfileId
                    );
                }
            )
            ->latest()
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Jobs fetched successfully.',
            'data' => [
                'jobs' => $jobs,
            ],
        ]);
    }

    /**
     * Admin single job ki complete details dekhega.
     */
    public function show(
        Request $request,
        Job $job
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access job details.',
            ], 403);
        }

        $job->load([
            'companyProfile.user',

            'applications' => function ($query) {
                $query->latest();
            },

            'applications.fresherProfile.user',

            'applications.interview',
        ]);

        $job->loadCount('applications');

        return response()->json([
            'success' => true,
            'message' => 'Job details fetched successfully.',
            'data' => [
                'job' => $job,
            ],
        ]);
    }

    /**
     * Admin job ka status update karega.
     */
    public function updateStatus(
        Request $request,
        Job $job
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can update job status.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'active',
                    'inactive',
                    'removed',
                ]),
            ],
        ]);

        if ($job->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => "Job is already {$validated['status']}.",
                'data' => [
                    'job' => $job->load('companyProfile'),
                ],
            ]);
        }

        $job->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job status updated successfully.',
            'data' => [
                'job' => $job
                    ->fresh()
                    ->load('companyProfile'),
            ],
        ]);
    }
}