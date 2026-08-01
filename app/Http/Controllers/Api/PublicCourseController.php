<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublicCourseController extends Controller
{
    /**
     * Public/Fresher ke liye active courses list.
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:200',
            ],

            'category' => [
                'nullable',
                'string',
                'max:150',
            ],

            'training_mode' => [
                'nullable',
                'string',
                Rule::in([
                    'online',
                    'offline',
                    'hybrid',
                ]),
            ],
        ]);

        $courses = Course::query()
            ->with([
                'trainingPartnerProfile:id,institute_name,institute_logo,location,website,approval_status',
            ])
            ->where('status', 'active')
            ->whereHas(
                'trainingPartnerProfile',
                fn ($query) => $query->where(
                    'approval_status',
                    'approved'
                )
            )
            ->when(
                isset($validated['search']),
                function ($query) use ($validated) {
                    $search = $validated['search'];

                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where(
                                'course_name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'skills_covered',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'description',
                                'like',
                                "%{$search}%"
                            );
                    });
                }
            )
            ->when(
                isset($validated['category']),
                fn ($query) => $query->where(
                    'category',
                    $validated['category']
                )
            )
            ->when(
                isset($validated['training_mode']),
                fn ($query) => $query->where(
                    'training_mode',
                    $validated['training_mode']
                )
            )
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active courses fetched successfully.',
            'data' => [
                'courses' => $courses,
            ],
        ]);
    }

    /**
     * Public/Fresher ke liye single active course details.
     */
    public function show(Course $course): JsonResponse
    {
        if ($course->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Course not found.',
            ], 404);
        }

        $course->load([
            'trainingPartnerProfile:id,institute_name,institute_logo,email,phone,location,website,about_institute,approval_status',
        ]);

        if (
            !$course->trainingPartnerProfile ||
            $course->trainingPartnerProfile->approval_status !== 'approved'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Course details fetched successfully.',
            'data' => [
                'course' => $course,
            ],
        ]);
    }
}