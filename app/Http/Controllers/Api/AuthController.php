<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Fresher, Company aur Training Partner register karenge.
     */
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'mobile' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'fresher',
                    'company',
                    'training_partner',
                ]),
            ],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'mobile' => $validatedData['mobile'] ?? null,
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'status' => 'active',
        ]);

        if ($user->role === 'fresher') {
            $user->fresherProfile()->create([
                'phone' => $validatedData['mobile'] ?? null,
                'profile_completion' => filled($validatedData['mobile'] ?? null) ? 13 : 0,
                'direct_mode_credits' => 250,
                'total_direct_mode_credits_used' => 0,
            ]);
        }

        if ($user->role === 'company') {
            $companyProfile = $user->companyProfile()->create([
                'company_name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['mobile'] ?? null,
                'job_credits' => 500,
                'total_job_credits_used' => 0,
            ]);

            $this->notifyAdminsAboutCompanyRegistration($companyProfile->company_name);
        }

        $token = $user
            ->createToken('onlyfreshers-auth-token')
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Account registered successfully.',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }

    /**
     * Sabhi roles login karenge.
     */
    public function login(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        if (! Auth::attempt([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Email ya password incorrect hai.',
            ], 401);
        }

        $user = Auth::user();

        if ($user->status === 'blocked') {
            Auth::logout();

            return response()->json([
                'success' => false,
                'message' => 'Aapka account blocked hai.',
            ], 403);
        }

        $token = $user
            ->createToken('onlyfreshers-auth-token')
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
                'dashboard' => $this->dashboardByRole($user->role),
            ],
        ]);
    }

    /**
     * Logged-in user ki details return karega.
     */
    public function profile(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Authenticated user fetched successfully.',
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = $request->user();

        if (! Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password incorrect hai.',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ]);
    }

    /**
     * Current token logout karega.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
    }

    /**
     * Sabhi devices ke tokens delete karega.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()
            ->tokens()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'All devices se logout successful.',
        ]);
    }

    /**
     * Role ke according frontend dashboard path return karega.
     */
    private function dashboardByRole(string $role): string
    {
        return match ($role) {
            'fresher' => '/fresher/dashboard',
            'company' => '/company/dashboard',
            'training_partner' => '/training-partner/dashboard',
            'admin' => '/admin/dashboard',
            default => '/',
        };
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
}
