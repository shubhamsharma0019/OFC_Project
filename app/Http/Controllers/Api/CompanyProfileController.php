<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
                'message' => 'Only companies can access this API.',
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
                'message' => 'Only companies can save their profile.',
            ], 403);
        }

        $existingProfile = $user->companyProfile;

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
                Rule::unique('users', 'email')->ignore($user->id),
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

            'hiring_intent' => [
                'nullable',
                Rule::in([
                    'job_posting',
                    'resume_only',
                ]),
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
                'hiring_intent',
            ]) ?? [],
            $validatedData
        );

        $profileData['approval_status'] = $existingProfile?->approval_status === 'approved'
            ? 'approved'
            : 'pending';
        $profileData['rejection_reason'] = null;

        if (! $existingProfile) {
            $profileData['job_credits'] = 500;
            $profileData['total_job_credits_used'] = 0;
            $profileData['hiring_intent'] = $validatedData['hiring_intent'] ?? 'job_posting';
        }

        $profile = $user->companyProfile()->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            $profileData
        );

        $user->update([
            'name' => $profileData['company_name'],
            'email' => $profileData['email'] ?: $user->email,
            'mobile' => $profileData['phone'] ?: $user->mobile,
        ]);

        if (! $existingProfile) {
            $this->notifyAdminsAboutCompanyRegistration($profile->company_name);
        }

        return response()->json([
            'success' => true,
            'message' => $existingProfile
                ? 'Company profile updated successfully.'
                : 'Company profile created successfully.',
            'data' => [
                'profile' => $profile->fresh(),
                'user' => $user->fresh(),
            ],
        ]);
    }

    private function notifyAdminsAboutCompanyRegistration(string $companyName): void
    {
        User::query()
            ->where('role', 'admin')
            ->where('status', 'active')
            ->pluck('id')
            ->each(function (int $adminId) use ($companyName) {
                Notification::create([
                    'user_id' => $adminId,
                    'type' => 'company_registration',
                    'title' => 'New Company Registration',
                    'message' => "{$companyName} has registered and is waiting for approval.",
                    'is_read' => false,
                ]);
            });
    }

    public function subscribe(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only companies can purchase subscriptions.',
            ], 403);
        }

        $validatedData = $request->validate([
            'plan' => [
                'required',
                Rule::in([
                    'basic',
                    'premium',
                    'enterprise',
                ]),
            ],
        ]);

        $profile = $user->companyProfile;

        if (! $profile) {
            return response()->json([
                'success' => false,
                'message' => 'Pehle company profile complete karein.',
            ], 422);
        }

        $creditsByPlan = [
            'basic' => 500,
            'premium' => 2500,
            'enterprise' => 5000,
        ];

        $profile = DB::transaction(function () use ($profile, $validatedData, $creditsByPlan) {
            $lockedProfile = $profile->newQuery()
                ->whereKey($profile->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedProfile->update([
                'job_credits' => $lockedProfile->job_credits + $creditsByPlan[$validatedData['plan']],
                'subscription_plan' => $validatedData['plan'],
                'subscribed_at' => now(),
            ]);

            return $lockedProfile->fresh();
        });

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully. You can post jobs again.',
            'data' => [
                'profile' => $profile,
                'credits_added' => $creditsByPlan[$validatedData['plan']],
                'redirect_to' => '/company/post-job',
            ],
        ]);
    }
}
