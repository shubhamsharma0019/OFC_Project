<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminEnrollmentController extends Controller
{
    /**
     * Admin ko saare course enrollments ki list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access course enrollments.',
            ], 403);
        }

        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:200',
            ],
            'enrollment_status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'enrolled',
                    'completed',
                    'cancelled',
                ]),
            ],
            'payment_status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'paid',
                    'failed',
                ]),
            ],
            'training_status' => [
                'nullable',
                Rule::in([
                    'not_started',
                    'in_progress',
                    'completed',
                ]),
            ],
            'course_id' => [
                'nullable',
                'integer',
                'exists:courses,id',
            ],
            'training_partner_profile_id' => [
                'nullable',
                'integer',
                'exists:training_partner_profiles,id',
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

        $enrollments = CourseEnrollment::query()
            ->with([
                'fresherProfile.user:id,name,email,mobile,role,status',
                'course.trainingPartnerProfile.user:id,name,email,mobile,role,status',
                'payments',
                'trainingProgress',
                'certificate',
            ])
            ->when(
                $validated['search'] ?? null,
                function ($query, string $search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->whereHas(
                                'fresherProfile.user',
                                function ($userQuery) use ($search) {
                                    $userQuery
                                        ->where('name', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%");
                                }
                            )
                            ->orWhereHas(
                                'course',
                                function ($courseQuery) use ($search) {
                                    $courseQuery
                                        ->where('course_name', 'like', "%{$search}%")
                                        ->orWhere('category', 'like', "%{$search}%")
                                        ->orWhereHas(
                                            'trainingPartnerProfile',
                                            function ($partnerQuery) use ($search) {
                                                $partnerQuery->where(
                                                    'institute_name',
                                                    'like',
                                                    "%{$search}%"
                                                );
                                            }
                                        );
                                }
                            );
                    });
                }
            )
            ->when(
                $validated['enrollment_status'] ?? null,
                function ($query, string $status) {
                    $query->where('enrollment_status', $status);
                }
            )
            ->when(
                $validated['payment_status'] ?? null,
                function ($query, string $status) {
                    $query->where('payment_status', $status);
                }
            )
            ->when(
                $validated['training_status'] ?? null,
                function ($query, string $status) {
                    $query->where('training_status', $status);
                }
            )
            ->when(
                $validated['course_id'] ?? null,
                function ($query, int $courseId) {
                    $query->where('course_id', $courseId);
                }
            )
            ->when(
                $validated['training_partner_profile_id'] ?? null,
                function ($query, int $trainingPartnerProfileId) {
                    $query->whereHas(
                        'course',
                        function ($courseQuery) use ($trainingPartnerProfileId) {
                            $courseQuery->where(
                                'training_partner_profile_id',
                                $trainingPartnerProfileId
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
            ->latest('enrollment_date')
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Course enrollments fetched successfully.',
            'data' => [
                'enrollments' => $enrollments,
            ],
        ]);
    }

    /**
     * Admin single enrollment ki complete details dekhega.
     */
    public function show(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access enrollment details.',
            ], 403);
        }

        $courseEnrollment->load([
            'fresherProfile.user',
            'course.trainingPartnerProfile.user',
            'payments',
            'trainingProgress',
            'certificate',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course enrollment details fetched successfully.',
            'data' => [
                'enrollment' => $courseEnrollment,
            ],
        ]);
    }
}