<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTrainingPartnerController extends Controller
{
    /**
     * Admin ke liye sabhi Training Partner profiles fetch karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access training partner profiles.',
            ], 403);
        }

        $trainingPartners = TrainingPartnerProfile::query()
            ->with([
                'user:id,name,email,mobile,role,status',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Training partners fetched successfully.',
            'data' => [
                'training_partners' => $trainingPartners,
            ],
        ]);
    }

    /**
     * Admin single Training Partner ki complete details dekhega.
     */
    public function show(
        Request $request,
        TrainingPartnerProfile $trainingPartnerProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access training partner details.',
            ], 403);
        }

        $trainingPartnerProfile->load([
            'user',

            'courses' => function ($query) {
                $query
                    ->withCount('enrollments')
                    ->latest();
            },

            'courses.enrollments.fresherProfile.user',
            'courses.enrollments.payments',
            'courses.enrollments.trainingProgress',
            'courses.enrollments.certificate',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Training partner details fetched successfully.',
            'data' => [
                'training_partner' => $trainingPartnerProfile,
            ],
        ]);
    }

    /**
     * Training Partner profile approve karega.
     */
    public function approve(
        Request $request,
        TrainingPartnerProfile $trainingPartnerProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can approve training partners.',
            ], 403);
        }

        if ($trainingPartnerProfile->approval_status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Training partner is already approved.',
                'data' => [
                    'training_partner' => $trainingPartnerProfile
                        ->load('user:id,name,email,mobile,role,status'),
                ],
            ], 422);
        }

        $trainingPartnerProfile->update([
            'approval_status' => 'approved',
            'rejection_reason' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Training partner approved successfully.',
            'data' => [
                'training_partner' => $trainingPartnerProfile
                    ->fresh()
                    ->load('user:id,name,email,mobile,role,status'),
            ],
        ]);
    }

    /**
     * Training Partner profile reject karega.
     */
    public function reject(
        Request $request,
        TrainingPartnerProfile $trainingPartnerProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can reject training partners.',
            ], 403);
        }

        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $trainingPartnerProfile->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Training partner rejected successfully.',
            'data' => [
                'training_partner' => $trainingPartnerProfile
                    ->fresh()
                    ->load('user:id,name,email,mobile,role,status'),
            ],
        ]);
    }

    /**
     * Training Partner user account ko active ya blocked karega.
     */
    public function updateUserStatus(
        Request $request,
        TrainingPartnerProfile $trainingPartnerProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can update training partner user status.',
            ], 403);
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

        $trainingPartnerUser = $trainingPartnerProfile->user;

        if (!$trainingPartnerUser) {
            return response()->json([
                'success' => false,
                'message' => 'Training Partner user account not found.',
            ], 404);
        }

        if ($trainingPartnerUser->role !== 'training_partner') {
            return response()->json([
                'success' => false,
                'message' => 'Linked user is not a Training Partner user.',
            ], 422);
        }

        if ($trainingPartnerUser->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => "Training Partner user is already {$validated['status']}.",
                'data' => [
                    'training_partner' => $trainingPartnerProfile
                        ->load('user:id,name,email,mobile,role,status'),
                ],
            ]);
        }

        $trainingPartnerUser->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'blocked') {
            $trainingPartnerUser->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $validated['status'] === 'active'
                ? 'Training Partner user activated successfully.'
                : 'Training Partner user blocked successfully.',
            'data' => [
                'training_partner' => $trainingPartnerProfile
                    ->fresh()
                    ->load('user:id,name,email,mobile,role,status'),
            ],
        ]);
    }
}