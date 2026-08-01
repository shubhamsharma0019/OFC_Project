<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrainingPartnerCourseController extends Controller
{
    /**
     * Logged-in training partner ke courses ki list.
     */
    public function index(Request $request): JsonResponse
    {
        $profile = $this->getApprovedTrainingPartnerProfile($request);

        if ($profile instanceof JsonResponse) {
            return $profile;
        }

        $courses = Course::query()
            ->where('training_partner_profile_id', $profile->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Training partner courses fetched successfully.',
            'data' => [
                'courses' => $courses,
            ],
        ]);
    }

    /**
     * Logged-in training partner ke single course ki details.
     */
    public function show(
        Request $request,
        Course $course
    ): JsonResponse {
        $profile = $this->getApprovedTrainingPartnerProfile($request);

        if ($profile instanceof JsonResponse) {
            return $profile;
        }

        if ($course->training_partner_profile_id !== $profile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this course.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Course details fetched successfully.',
            'data' => [
                'course' => $course,
            ],
        ]);
    }

    /**
     * Approved training partner naya course create karega.
     */
    public function store(Request $request): JsonResponse
    {
        $profile = $this->getApprovedTrainingPartnerProfile($request);

        if ($profile instanceof JsonResponse) {
            return $profile;
        }

        $validated = $request->validate([
            'course_name' => [
                'required',
                'string',
                'max:200',
            ],

            'category' => [
                'nullable',
                'string',
                'max:150',
            ],

            'description' => [
                'required',
                'string',
                'max:5000',
            ],

            'duration' => [
                'required',
                'string',
                'max:100',
            ],

            'fees' => [
                'required',
                'numeric',
                'min:0',
            ],

            'training_mode' => [
                'required',
                'string',
                Rule::in([
                    'online',
                    'offline',
                    'hybrid',
                ]),
            ],

            'start_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],

            'skills_covered' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'status' => [
                'sometimes',
                'string',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);

        $validated['training_partner_profile_id'] = $profile->id;
        $validated['status'] = $validated['status'] ?? 'active';

        $course = Course::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully.',
            'data' => [
                'course' => $course,
            ],
        ], 201);
    }

    /**
     * Existing course update karega.
     */
    public function update(
        Request $request,
        Course $course
    ): JsonResponse {
        $profile = $this->getApprovedTrainingPartnerProfile($request);

        if ($profile instanceof JsonResponse) {
            return $profile;
        }

        if ($course->training_partner_profile_id !== $profile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this course.',
            ], 403);
        }

        $validated = $request->validate([
            'course_name' => [
                'sometimes',
                'string',
                'max:200',
            ],

            'category' => [
                'sometimes',
                'nullable',
                'string',
                'max:150',
            ],

            'description' => [
                'sometimes',
                'string',
                'max:5000',
            ],

            'duration' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'fees' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'training_mode' => [
                'sometimes',
                'string',
                Rule::in([
                    'online',
                    'offline',
                    'hybrid',
                ]),
            ],

            'start_date' => [
                'sometimes',
                'nullable',
                'date',
            ],

            'skills_covered' => [
                'sometimes',
                'nullable',
                'string',
                'max:5000',
            ],

            'status' => [
                'sometimes',
                'string',
                Rule::in([
                    'active',
                    'inactive',
                    'removed',
                ]),
            ],
        ]);

        if (empty($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide at least one field to update.',
            ], 422);
        }

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully.',
            'data' => [
                'course' => $course->fresh(),
            ],
        ]);
    }

    /**
     * Course status active, inactive ya removed karega.
     */
    public function updateStatus(
        Request $request,
        Course $course
    ): JsonResponse {
        $profile = $this->getApprovedTrainingPartnerProfile($request);

        if ($profile instanceof JsonResponse) {
            return $profile;
        }

        if ($course->training_partner_profile_id !== $profile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this course status.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in([
                    'active',
                    'inactive',
                    'removed',
                ]),
            ],
        ]);

        $course->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course status updated successfully.',
            'data' => [
                'course' => $course->fresh(),
            ],
        ]);
    }

    /**
     * Approved training partner profile return karega.
     */
    private function getApprovedTrainingPartnerProfile(
        Request $request
    ): TrainingPartnerProfile|JsonResponse {
        $user = $request->user();

        if ($user->role !== 'training_partner') {
            return response()->json([
                'success' => false,
                'message' => 'Only training partners can manage courses.',
            ], 403);
        }

        $profile = $user->trainingPartnerProfile;

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your training partner profile first.',
            ], 422);
        }

        if ($profile->approval_status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Your training partner profile must be approved before managing courses.',
                'data' => [
                    'approval_status' => $profile->approval_status,
                    'rejection_reason' => $profile->rejection_reason,
                ],
            ], 403);
        }

        return $profile;
    }
}