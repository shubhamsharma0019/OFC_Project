<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyJobController extends Controller
{
    /**
     * Logged-in company ki apni jobs return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company apni jobs dekh sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (! $companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $jobs = $companyProfile
            ->jobs()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Company jobs fetched successfully.',
            'data' => [
                'jobs' => $jobs,
            ],
        ]);
    }

    /**
     * Logged-in company ki single job details return karega.
     */
    public function show(
        Request $request,
        Job $job
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company job details dekh sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (! $companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        if ($job->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is job ko access nahi kar sakte.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Job details fetched successfully.',
            'data' => [
                'job' => $job,
            ],
        ]);
    }

    /**
     * Approved company nayi job create karegi.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company job create kar sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (! $companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Pehle company profile complete karein.',
            ], 422);
        }

        if ($companyProfile->approval_status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf approved company job create kar sakti hai.',
            ], 403);
        }

        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'required',
                'string',
            ],

            'required_skills' => [
                'nullable',
                'string',
            ],

            'qualification' => [
                'nullable',
                'string',
                'max:200',
            ],

            'location' => [
                'nullable',
                'string',
                'max:200',
            ],

            'salary' => [
                'nullable',
                'string',
                'max:100',
            ],

            'job_type' => [
                'nullable',
                'string',
                'max:50',
            ],

            'openings' => [
                'required',
                'integer',
                'min:1',
                'max:10000',
            ],

            'hiring_mode' => [
                'required',
                Rule::in([
                    'direct',
                    'fast_track',
                ]),
            ],

            'application_last_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'draft',
                    'active',
                ]),
            ],
        ]);

        $validatedData['company_profile_id'] = $companyProfile->id;

        $validatedData['status'] =
            $validatedData['status'] ?? 'draft';

        $job = Job::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => $job->status === 'active'
                ? 'Job published successfully.'
                : 'Job saved as draft successfully.',
            'data' => [
                'job' => $job,
            ],
        ], 201);
    }

    /**
     * Logged-in company apni job update karegi.
     */
    public function update(
        Request $request,
        Job $job
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company job update kar sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (! $companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        if ($job->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is job ko update nahi kar sakte.',
            ], 403);
        }

        $validatedData = $request->validate([
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'sometimes',
                'required',
                'string',
            ],

            'required_skills' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'qualification' => [
                'sometimes',
                'nullable',
                'string',
                'max:200',
            ],

            'location' => [
                'sometimes',
                'nullable',
                'string',
                'max:200',
            ],

            'salary' => [
                'sometimes',
                'nullable',
                'string',
                'max:100',
            ],

            'job_type' => [
                'sometimes',
                'nullable',
                'string',
                'max:50',
            ],

            'openings' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                'max:10000',
            ],

            'hiring_mode' => [
                'sometimes',
                'required',
                Rule::in([
                    'direct',
                    'fast_track',
                ]),
            ],

            'application_last_date' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:today',
            ],

            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    'draft',
                    'active',
                    'inactive',
                ]),
            ],
        ]);

        $job->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Job updated successfully.',
            'data' => [
                'job' => $job->fresh(),
            ],
        ]);
    }

    /**
     * Logged-in company apni job ka status change karegi.
     */
    public function changeStatus(
        Request $request,
        Job $job
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company job status change kar sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (! $companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        if ($job->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is job ka status change nahi kar sakte.',
            ], 403);
        }

        $validatedData = $request->validate([
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

        $job->update([
            'status' => $validatedData['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job status updated successfully.',
            'data' => [
                'job' => $job->fresh(),
            ],
        ]);
    }
}