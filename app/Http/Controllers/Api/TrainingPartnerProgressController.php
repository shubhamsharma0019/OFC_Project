<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use App\Models\TrainingPartnerProfile;
use App\Models\TrainingProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingPartnerProgressController extends Controller
{
    /**
     * Logged-in training partner ke courses me enrolled freshers ki list.
     */
    public function enrollments(Request $request): JsonResponse
    {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile(
            $request
        );

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access enrollments.',
            ], 403);
        }

        $enrollments = CourseEnrollment::query()
            ->whereHas('course', function ($query) use (
                $trainingPartnerProfile
            ) {
                $query->where(
                    'training_partner_profile_id',
                    $trainingPartnerProfile->id
                );
            })
            ->whereIn('enrollment_status', [
                'pending',
                'enrolled',
                'completed',
            ])
            ->with([
                'course',
                'fresherProfile.user',
                'trainingProgress',
            ])
            ->latest('enrollment_date')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Course enrollments fetched successfully.',
            'data' => [
                'enrollments' => $enrollments,
            ],
        ]);
    }

    /**
     * Selected enrollment aur uski progress details.
     */
    public function show(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile(
            $request
        );

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access training progress.',
            ], 403);
        }

        $courseEnrollment->load([
            'course',
            'fresherProfile.user',
            'trainingProgress',
        ]);

        if (
            !$courseEnrollment->course ||
            $courseEnrollment->course->training_partner_profile_id
                !== $trainingPartnerProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this enrollment.',
            ], 403);
        }

        if ($courseEnrollment->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Training progress is available only after successful payment.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Training progress details fetched successfully.',
            'data' => [
                'enrollment' => $courseEnrollment,
            ],
        ]);
    }

    /**
     * Training progress create ya update karega.
     */
    public function update(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile(
            $request
        );

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can update training progress.',
            ], 403);
        }

        $courseEnrollment->load('course');

        if (
            !$courseEnrollment->course ||
            $courseEnrollment->course->training_partner_profile_id
                !== $trainingPartnerProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this enrollment.',
            ], 403);
        }

        if ($courseEnrollment->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Training cannot start until payment is completed.',
            ], 422);
        }

        if ($courseEnrollment->enrollment_status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Training progress cannot be updated for a cancelled enrollment.',
            ], 422);
        }

        $validated = $request->validate([
            'progress_percentage' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'short_remark' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        $progressPercentage = $validated['progress_percentage'];

        if ($progressPercentage === 0) {
            $currentStatus = 'not_started';
            $completionDate = null;
        } elseif ($progressPercentage === 100) {
            $currentStatus = 'completed';
            $completionDate = now()->toDateString();
        } else {
            $currentStatus = 'in_progress';
            $completionDate = null;
        }

        $result = DB::transaction(function () use (
            $courseEnrollment,
            $validated,
            $progressPercentage,
            $currentStatus,
            $completionDate
        ) {
            $trainingProgress = TrainingProgress::updateOrCreate(
                [
                    'course_enrollment_id' => $courseEnrollment->id,
                ],
                [
                    'progress_percentage' => $progressPercentage,
                    'current_status' => $currentStatus,
                    'short_remark' => $validated['short_remark'] ?? null,
                    'completion_date' => $completionDate,
                ]
            );

            if ($currentStatus === 'completed') {
                $courseEnrollment->update([
                    'training_status' => 'completed',
                    'enrollment_status' => 'completed',
                ]);
            } elseif ($currentStatus === 'in_progress') {
                $courseEnrollment->update([
                    'training_status' => 'in_progress',
                    'enrollment_status' => 'enrolled',
                ]);
            } else {
                $courseEnrollment->update([
                    'training_status' => 'not_started',
                    'enrollment_status' => 'enrolled',
                ]);
            }

            return [
                'training_progress' => $trainingProgress->fresh(),
                'enrollment' => $courseEnrollment->fresh(),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Training progress updated successfully.',
            'data' => $result,
        ]);
    }

    /**
     * Logged-in approved training partner profile return karega.
     */
    private function getApprovedTrainingPartnerProfile(
        Request $request
    ): ?TrainingPartnerProfile {
        $user = $request->user();

        if (!$user || $user->role !== 'training_partner') {
            return null;
        }

        return TrainingPartnerProfile::query()
            ->where('user_id', $user->id)
            ->where('approval_status', 'approved')
            ->first();
    }
}
