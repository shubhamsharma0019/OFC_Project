<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCourseController extends Controller
{
    /**
     * Admin ko saare courses ki list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access courses.',
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
                    'active',
                    'inactive',
                    'removed',
                ]),
            ],
            'training_mode' => [
                'nullable',
                Rule::in([
                    'online',
                    'offline',
                    'hybrid',
                ]),
            ],
            'training_partner_profile_id' => [
                'nullable',
                'integer',
                'exists:training_partner_profiles,id',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $courses = Course::query()
            ->with([
                'trainingPartnerProfile.user:id,name,email,mobile,role,status',
            ])
            ->withCount('enrollments')
            ->when(
                $validated['search'] ?? null,
                function ($query, string $search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('course_name', 'like', "%{$search}%")
                            ->orWhere('category', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('duration', 'like', "%{$search}%")
                            ->orWhere('skills_covered', 'like', "%{$search}%")
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
                $validated['training_mode'] ?? null,
                function ($query, string $trainingMode) {
                    $query->where('training_mode', $trainingMode);
                }
            )
            ->when(
                $validated['training_partner_profile_id'] ?? null,
                function ($query, int $trainingPartnerProfileId) {
                    $query->where(
                        'training_partner_profile_id',
                        $trainingPartnerProfileId
                    );
                }
            )
            ->latest()
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Courses fetched successfully.',
            'data' => [
                'courses' => $courses,
            ],
        ]);
    }

    /**
     * Admin single course ki complete details dekhega.
     */
    public function show(
        Request $request,
        Course $course
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access course details.',
            ], 403);
        }

        $course->load([
            'trainingPartnerProfile.user',

            'enrollments' => function ($query) {
                $query->latest();
            },

            'enrollments.fresherProfile.user',
            'enrollments.payments',
            'enrollments.trainingProgress',
            'enrollments.certificate',
        ]);

        $course->loadCount('enrollments');

        return response()->json([
            'success' => true,
            'message' => 'Course details fetched successfully.',
            'data' => [
                'course' => $course,
            ],
        ]);
    }

    /**
     * Admin course ka status update karega.
     */
    public function updateStatus(
        Request $request,
        Course $course
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can update course status.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'removed',
                ]),
            ],
        ]);

        if ($course->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => "Course is already {$validated['status']}.",
                'data' => [
                    'course' => $course->load('trainingPartnerProfile'),
                ],
            ]);
        }

        $course->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course status updated successfully.',
            'data' => [
                'course' => $course
                    ->fresh()
                    ->load('trainingPartnerProfile'),
            ],
        ]);
    }
}