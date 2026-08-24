<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCompanyController extends Controller
{
    /**
     * Admin ko saari companies ki list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin companies ko manage kar sakta hai.',
            ], 403);
        }

        $companies = CompanyProfile::query()
            ->with([
                'user:id,name,email,mobile,role,status',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Companies fetched successfully.',
            'data' => [
                'companies' => $companies,
            ],
        ]);
    }

    /**
     * Admin single company ki complete details dekhega.
     */
    public function show(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company details dekh sakta hai.',
            ], 403);
        }

        $companyProfile->load([
            'user',

            'jobs' => function ($query) {
                $query
                    ->withCount('applications')
                    ->latest();
            },

            'jobs.applications.fresherProfile.user',

            'jobs.applications.interview',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Company details fetched successfully.',
            'data' => [
                'company' => $companyProfile,
            ],
        ]);
    }

    /**
     * Admin company profile ko approve karega.
     */
    public function approve(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company ko approve kar sakta hai.',
            ], 403);
        }

        if ($companyProfile->approval_status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Company is already approved.',
                'data' => [
                    'company' => $companyProfile->load('user'),
                ],
            ], 422);
        }

        $companyProfile->update([
            'approval_status' => 'approved',
            'rejection_reason' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Company approved successfully.',
            'data' => [
                'company' => $companyProfile
                    ->fresh()
                    ->load('user'),
            ],
        ]);
    }

    /**
     * Admin company profile ko reject karega.
     */
    public function reject(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company ko reject kar sakta hai.',
            ], 403);
        }

        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $companyProfile->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Company rejected successfully.',
            'data' => [
                'company' => $companyProfile
                    ->fresh()
                    ->load('user'),
            ],
        ]);
    }

    /**
     * Company user account ko active ya blocked karega.
     */
    public function updateUserStatus(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company user status update kar sakta hai.',
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

        $companyUser = $companyProfile->user;

        if (!$companyUser) {
            return response()->json([
                'success' => false,
                'message' => 'Company user account not found.',
            ], 404);
        }

        if ($companyUser->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Linked user is not a company user.',
            ], 422);
        }

        if ($companyUser->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => "Company user is already {$validated['status']}.",
                'data' => [
                    'company' => $companyProfile->load('user'),
                ],
            ]);
        }

        $companyUser->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'blocked') {
            $companyUser->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $validated['status'] === 'active'
                ? 'Company user activated successfully.'
                : 'Company user blocked successfully.',
            'data' => [
                'company' => $companyProfile
                    ->fresh()
                    ->load('user'),
            ],
        ]);
    }
}
