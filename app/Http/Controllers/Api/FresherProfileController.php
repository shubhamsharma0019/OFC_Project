<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FresherProfileController extends Controller
{
    /**
     * Logged-in fresher ki profile return karega.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf fresher is API ko access kar sakta hai.',
            ], 403);
        }

        $profile = $user->fresherProfile;

        return response()->json([
            'success' => true,
            'message' => $profile
                ? 'Fresher profile fetched successfully.'
                : 'Fresher profile abhi complete nahi hai.',
            'data' => [
                'user' => $user,
                'profile' => $profile,
            ],
        ]);
    }

    /**
     * Fresher profile create ya update karega.
     */
    public function save(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf fresher apni profile save kar sakta hai.',
            ], 403);
        }

        $validatedData = $request->validate([
            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'qualification' => [
                'nullable',
                'string',
                'max:150',
            ],

            'college_name' => [
                'nullable',
                'string',
                'max:200',
            ],

            'passing_year' => [
                'nullable',
                'integer',
                'digits:4',
                'min:1900',
                'max:2100',
            ],

            'skills' => [
                'nullable',
                'string',
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'resume' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
        ]);

        $existingProfile = $user->fresherProfile;

        if ($request->hasFile('profile_photo')) {
            if ($existingProfile?->profile_photo) {
                Storage::disk('public')
                    ->delete($existingProfile->profile_photo);
            }

            $validatedData['profile_photo'] = $request
                ->file('profile_photo')
                ->store('fresher/profile-photos', 'public');
        }

        if ($request->hasFile('resume')) {
            if ($existingProfile?->resume) {
                Storage::disk('public')
                    ->delete($existingProfile->resume);
            }

            $validatedData['resume'] = $request
                ->file('resume')
                ->store('fresher/resumes', 'public');
        }

        $profileData = array_merge(
            $existingProfile?->only([
                'phone',
                'city',
                'qualification',
                'college_name',
                'passing_year',
                'skills',
                'profile_photo',
                'resume',
            ]) ?? [],
            $validatedData
        );

        $profileData['profile_completion'] =
            $this->calculateProfileCompletion($profileData);

        $profile = $user->fresherProfile()->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            $profileData
        );

        return response()->json([
            'success' => true,
            'message' => $existingProfile
                ? 'Fresher profile updated successfully.'
                : 'Fresher profile created successfully.',
            'data' => [
                'profile' => $profile->fresh(),
            ],
        ]);
    }

    /**
     * Filled profile fields ke according completion percentage calculate karega.
     */
    private function calculateProfileCompletion(array $profileData): int
    {
        $fields = [
            'phone',
            'city',
            'qualification',
            'college_name',
            'passing_year',
            'skills',
            'profile_photo',
            'resume',
        ];

        $completedFields = collect($fields)
            ->filter(function (string $field) use ($profileData) {
                return filled($profileData[$field] ?? null);
            })
            ->count();

        return (int) round(
            ($completedFields / count($fields)) * 100
        );
    }
}