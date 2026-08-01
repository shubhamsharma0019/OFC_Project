<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FresherCourseEnrollmentController extends Controller
{
    /**
     * Fresher ko active course me enroll karega.
     */
    public function enroll(
        Request $request,
        Course $course
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can enroll in courses.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your fresher profile first.',
            ], 422);
        }

        if ($course->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'This course is not available for enrollment.',
            ], 422);
        }

        $course->load('trainingPartnerProfile');

        if (
            !$course->trainingPartnerProfile ||
            $course->trainingPartnerProfile->approval_status !== 'approved'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This course is not available for enrollment.',
            ], 422);
        }

        $existingEnrollment = CourseEnrollment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'success' => false,
                'message' => 'You are already enrolled in this course.',
                'data' => [
                    'enrollment' => $existingEnrollment,
                ],
            ], 422);
        }

        $enrollment = CourseEnrollment::create([
            'fresher_profile_id' => $fresherProfile->id,
            'course_id' => $course->id,
            'enrollment_date' => now(),
            'enrollment_status' => 'pending',
            'payment_status' => 'pending',
            'training_status' => 'not_started',
        ]);

        $enrollment->load([
            'course.trainingPartnerProfile:id,institute_name,institute_logo,location,approval_status',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course enrollment created successfully.',
            'data' => [
                'enrollment' => $enrollment,
            ],
        ], 201);
    }

    /**
     * Logged-in fresher ki saari course enrollments.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access course enrollments.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        $enrollments = CourseEnrollment::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->with([
                'course.trainingPartnerProfile:id,institute_name,institute_logo,location,website,approval_status',
                'trainingProgress',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Fresher course enrollments fetched successfully.',
            'data' => [
                'enrollments' => $enrollments,
            ],
        ]);
    }

    /**
     * Logged-in fresher ki single enrollment details.
     */
    public function show(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access course enrollments.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if (
            $courseEnrollment->fresher_profile_id
            !== $fresherProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this enrollment.',
            ], 403);
        }

        $courseEnrollment->load([
            'course.trainingPartnerProfile:id,institute_name,institute_logo,email,phone,location,website,about_institute,approval_status',
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