<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainingPartnerAssessmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile($request);

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access assessments.',
            ], 403);
        }

        $attempts = AssessmentAttempt::query()
            ->where('assessment_type', 'final')
            ->whereHas('courseEnrollment.course', function ($query) use ($trainingPartnerProfile) {
                $query->where('training_partner_profile_id', $trainingPartnerProfile->id);
            })
            ->with([
                'result',
                'fresherProfile.user',
                'courseEnrollment.course',
                'courseEnrollment.trainingProgress',
                'courseEnrollment.certificate',
            ])
            ->latest('started_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Assessments fetched successfully.',
            'data' => [
                'assessments' => $attempts,
            ],
        ]);
    }

    private function getApprovedTrainingPartnerProfile(Request $request): ?TrainingPartnerProfile
    {
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
