<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingPartnerProfileController extends Controller
{
    /**
     * Logged-in training partner ka profile fetch karega.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'training_partner') {
            return response()->json([
                'success' => false,
                'message' => 'Only training partners can access this profile.',
            ], 403);
        }

        $profile = $user->trainingPartnerProfile;

        return response()->json([
            'success' => true,
            'message' => 'Training partner profile fetched successfully.',
            'data' => [
                'user' => $user,
                'profile' => $profile,
            ],
        ]);
    }

    /**
     * Training partner profile create ya update karega.
     */
    public function save(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'training_partner') {
            return response()->json([
                'success' => false,
                'message' => 'Only training partners can manage this profile.',
            ], 403);
        }

        $validated = $request->validate([
            'institute_name' => [
                'required',
                'string',
                'max:200',
            ],

            'institute_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'location' => [
                'nullable',
                'string',
                'max:200',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

            'about_institute' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'verification_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        $existingProfile = TrainingPartnerProfile::query()
            ->where('user_id', $user->id)
            ->first();

        if ($request->hasFile('institute_logo')) {
            if (
                $existingProfile &&
                $existingProfile->institute_logo
            ) {
                Storage::disk('public')->delete(
                    $existingProfile->institute_logo
                );
            }

            $validated['institute_logo'] = $request
                ->file('institute_logo')
                ->store('training-partners/logos', 'public');
        }

        if ($request->hasFile('verification_document')) {
            if (
                $existingProfile &&
                $existingProfile->verification_document
            ) {
                Storage::disk('public')->delete(
                    $existingProfile->verification_document
                );
            }

            $validated['verification_document'] = $request
                ->file('verification_document')
                ->store(
                    'training-partners/documents',
                    'public'
                );
        }

        $validated['approval_status'] = 'pending';
        $validated['rejection_reason'] = null;

        $profile = TrainingPartnerProfile::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            $validated
        );

        $message = $existingProfile
            ? 'Training partner profile updated and submitted for approval successfully.'
            : 'Training partner profile created and submitted for approval successfully.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'profile' => $profile->fresh(),
            ],
        ], $existingProfile ? 200 : 201);
    }
}