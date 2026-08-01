<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicTrainingPartnerController extends Controller
{
    /**
     * Public ke liye approved Training Partners ki list.
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:200',
            ],
            'location' => [
                'nullable',
                'string',
                'max:150',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $trainingPartners = TrainingPartnerProfile::query()
            ->where('approval_status', 'approved')
            ->whereHas('user', function ($query) {
                $query
                    ->where('role', 'training_partner')
                    ->where('status', 'active');
            })
            ->with([
                'user:id,name,email,mobile,role,status',

                'courses' => function ($query) {
                    $query
                        ->where('status', 'active')
                        ->latest();
                },
            ])
            ->withCount([
                'courses as active_courses_count' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->when(
                $validated['search'] ?? null,
                function ($query, string $search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('institute_name', 'like', "%{$search}%")
                            ->orWhere('about_institute', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%")
                            ->orWhereHas(
                                'courses',
                                function ($courseQuery) use ($search) {
                                    $courseQuery
                                        ->where('status', 'active')
                                        ->where(function ($activeCourseQuery) use ($search) {
                                            $activeCourseQuery
                                                ->where(
                                                    'course_name',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'category',
                                                    'like',
                                                    "%{$search}%"
                                                )
                                                ->orWhere(
                                                    'skills_covered',
                                                    'like',
                                                    "%{$search}%"
                                                );
                                        });
                                }
                            );
                    });
                }
            )
            ->when(
                $validated['location'] ?? null,
                function ($query, string $location) {
                    $query->where(
                        'location',
                        'like',
                        "%{$location}%"
                    );
                }
            )
            ->latest()
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Training partners fetched successfully.',
            'data' => [
                'training_partners' => $trainingPartners,
            ],
        ]);
    }

    /**
     * Public ke liye single approved Training Partner details.
     */
    public function show(
        TrainingPartnerProfile $trainingPartnerProfile
    ): JsonResponse {
        $trainingPartnerProfile->load([
            'user:id,name,email,mobile,role,status',

            'courses' => function ($query) {
                $query
                    ->where('status', 'active')
                    ->withCount('enrollments')
                    ->latest();
            },
        ]);

        $isAvailablePublicly =
            $trainingPartnerProfile->approval_status === 'approved'
            && $trainingPartnerProfile->user
            && $trainingPartnerProfile->user->role === 'training_partner'
            && $trainingPartnerProfile->user->status === 'active';

        if (!$isAvailablePublicly) {
            return response()->json([
                'success' => false,
                'message' => 'Training partner not found.',
            ], 404);
        }

        $trainingPartnerProfile->loadCount([
            'courses as active_courses_count' => function ($query) {
                $query->where('status', 'active');
            },
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Training partner details fetched successfully.',
            'data' => [
                'training_partner' => $trainingPartnerProfile,
            ],
        ]);
    }
}