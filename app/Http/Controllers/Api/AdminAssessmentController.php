<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAssessmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admin can access assessments.',
            ], 403);
        }

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:200'],
            'assessment_type' => ['nullable', Rule::in(['initial', 'final'])],
            'status' => ['nullable', Rule::in(['in_progress', 'submitted'])],
            'result' => ['nullable', Rule::in(['pass', 'fail'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $attempts = AssessmentAttempt::query()
            ->with([
                'fresherProfile.user:id,name,email,mobile,role,status',
                'courseEnrollment.course.trainingPartnerProfile.user:id,name,email,mobile,role,status',
                'result',
            ])
            ->when($validated['search'] ?? null, function ($query, string $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->whereHas('fresherProfile.user', function ($userQuery) use ($search) {
                            $userQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('courseEnrollment.course', function ($courseQuery) use ($search) {
                            $courseQuery
                                ->where('course_name', 'like', "%{$search}%")
                                ->orWhere('category', 'like', "%{$search}%")
                                ->orWhereHas('trainingPartnerProfile', function ($partnerQuery) use ($search) {
                                    $partnerQuery->where('institute_name', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->when(
                $validated['assessment_type'] ?? null,
                fn($query, string $type) => $query->where('assessment_type', $type)
            )
            ->when(
                $validated['status'] ?? null,
                fn($query, string $status) => $query->where('status', $status)
            )
            ->when($validated['result'] ?? null, function ($query, string $result) {
                $query->whereHas('result', fn($resultQuery) => $resultQuery->where('result', $result));
            })
            ->latest('submitted_at')
            ->latest('started_at')
            ->paginate($validated['per_page'] ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Assessments fetched successfully.',
            'data' => [
                'assessments' => $attempts,
            ],
        ]);
    }
}
