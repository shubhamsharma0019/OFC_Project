<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminSettingsController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can access settings.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Admin settings fetched successfully.',
            'data' => [
                'admin' => $admin,
                'preferences' => [
                    'email_notifications' => true,
                    'security_alerts' => true,
                    'approval_alerts' => true,
                ],
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can update settings.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($admin->id),
            ],
            'mobile' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!empty($validated['password']) && !Hash::check($validated['current_password'], $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The current password is incorrect.',
            ], 422);
        }

        $admin->forceFill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Admin settings updated successfully.',
            'data' => [
                'admin' => $admin->fresh(),
            ],
        ]);
    }
}
