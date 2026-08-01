<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminFresherController extends Controller
{
    /**
     * Saare Fresher users ki list.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can access freshers.',
            ], 403);
        }

        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:255',
            ],
            'status' => [
                'nullable',
                Rule::in([
                    'active',
                    'blocked',
                ]),
            ],
            'profile_completion' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $query = User::query()
            ->where('role', 'fresher')
            ->with([
                'fresherProfile',
            ]);

        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhereHas(
                        'fresherProfile',
                        function ($profileQuery) use ($search) {
                            $profileQuery
                                ->where('phone', 'like', "%{$search}%")
                                ->orWhere(
                                    'city',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'qualification',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'college_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'skills',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (isset($validated['profile_completion'])) {
            $query->whereHas(
                'fresherProfile',
                function ($profileQuery) use ($validated) {
                    $profileQuery->where(
                        'profile_completion',
                        '>=',
                        $validated['profile_completion']
                    );
                }
            );
        }

        $freshers = $query
            ->latest()
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Freshers fetched successfully.',
            'data' => [
                'freshers' => $freshers,
            ],
        ]);
    }

    /**
     * Single Fresher ki complete details.
     */
    public function show(
        Request $request,
        User $fresher
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can access fresher details.',
            ], 403);
        }

        if ($fresher->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a fresher.',
            ], 422);
        }

        $fresher->load([
            'fresherProfile.assessmentAttempts.result',

            'fresherProfile.jobApplications.job.companyProfile',

            'fresherProfile.jobApplications.interview',

            'fresherProfile.courseEnrollments.course.trainingPartnerProfile',

            'fresherProfile.courseEnrollments.payments',

            'fresherProfile.courseEnrollments.trainingProgress',

            'fresherProfile.courseEnrollments.certificate',

            'fresherProfile.certificates.finalAssessmentResult',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fresher details fetched successfully.',
            'data' => [
                'fresher' => $fresher,
            ],
        ]);
    }

    /**
     * Fresher user ka active/blocked status update karega.
     */
    public function updateStatus(
        Request $request,
        User $fresher
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can update fresher status.',
            ], 403);
        }

        if ($fresher->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not a fresher.',
            ], 422);
        }

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'active',
                    'blocked',
                ]),
            ],
        ]);

        if ($fresher->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => "Fresher is already {$validated['status']}.",
                'data' => [
                    'fresher' => $fresher->load(
                        'fresherProfile'
                    ),
                ],
            ]);
        }

        $fresher->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'blocked') {
            $fresher->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $validated['status'] === 'active'
                ? 'Fresher activated successfully.'
                : 'Fresher blocked successfully.',
            'data' => [
                'fresher' => $fresher
                    ->fresh()
                    ->load('fresherProfile'),
            ],
        ]);
    }
}