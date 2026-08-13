<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    /**
     * Logged-in company ki profile return karega.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company is API ko access kar sakti hai.',
            ], 403);
        }

        $profile = $user->companyProfile;

        return response()->json([
            'success' => true,
            'message' => $profile
                ? 'Company profile fetched successfully.'
                : 'Company profile abhi complete nahi hai.',
            'data' => [
                'user' => $user,
                'profile' => $profile,
            ],
        ]);
    }

    /**
     * Company profile create ya update karega.
     */
    public function save(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company apni profile save kar sakti hai.',
            ], 403);
        }

        $existingProfile = $user->companyProfile;

        if ($existingProfile?->approval_status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Approved company profile ko directly update nahi kiya ja sakta.',
            ], 422);
        }

        $validatedData = $request->validate([
            'company_name' => [
                'required',
                'string',
                'max:200',
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

            'industry' => [
                'nullable',
                'string',
                'max:150',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'company_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('company_logo')) {
            if ($existingProfile?->company_logo) {
                Storage::disk('public')
                    ->delete($existingProfile->company_logo);
            }

            $validatedData['company_logo'] = $request
                ->file('company_logo')
                ->store('company/logos', 'public');
        }

        $profileData = array_merge(
            $existingProfile?->only([
                'company_name',
                'company_logo',
                'email',
                'phone',
                'industry',
                'website',
                'address',
                'description',
            ]) ?? [],
            $validatedData
        );

        /*
         * Rejected profile edit hone ke baad dobara pending ho jayegi.
         */
        $profileData['approval_status'] = 'pending';
        $profileData['rejection_reason'] = null;

        $profile = $user->companyProfile()->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            $profileData
        );

        return response()->json([
            'success' => true,
            'message' => $existingProfile
                ? 'Company profile updated successfully.'
                : 'Company profile created successfully.',
            'data' => [
                'profile' => $profile->fresh(),
            ],
        ]);
    }
}
