<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class PublicCertificateController extends Controller
{
    /**
     * Certificate number ke basis par public verification.
     */
    public function verify(string $certificateNumber): JsonResponse
    {
        $certificate = Certificate::query()
            ->where('certificate_number', $certificateNumber)
            ->with([
                'fresherProfile.user',
                'courseEnrollment.course.trainingPartnerProfile',
                'courseEnrollment.trainingProgress',
                'finalAssessmentResult',
            ])
            ->first();

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate not found or invalid certificate number.',
                'data' => [
                    'is_valid' => false,
                ],
            ], 404);
        }

        $isValid = $certificate->courseEnrollment
            && $certificate->courseEnrollment->payment_status === 'paid'
            && $certificate->courseEnrollment->training_status === 'completed'
            && $certificate->courseEnrollment->enrollment_status === 'completed'
            && $certificate->courseEnrollment->trainingProgress
            && $certificate->courseEnrollment
                ->trainingProgress
                ->current_status === 'completed'
            && $certificate->courseEnrollment
                ->trainingProgress
                ->progress_percentage === 100
            && $certificate->finalAssessmentResult
            && $certificate->finalAssessmentResult->result === 'pass';

        if (!$isValid) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate verification failed.',
                'data' => [
                    'is_valid' => false,
                    'certificate_number' => $certificate->certificate_number,
                ],
            ], 422);
        }

        $certificateUrl = null;

        if (
            Storage::disk('public')->exists(
                $certificate->certificate_file
            )
        ) {
            $certificateUrl = Storage::disk('public')->url(
                $certificate->certificate_file
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Certificate verified successfully.',
            'data' => [
                'is_valid' => true,

                'certificate' => [
                    'certificate_number' =>
                        $certificate->certificate_number,

                    'fresher_name' =>
                        $certificate->fresherProfile
                            ?->user
                            ?->name,

                    'course_name' =>
                        $certificate->courseEnrollment
                            ?->course
                            ?->course_name,

                    'training_partner_name' =>
                        $certificate->courseEnrollment
                            ?->course
                            ?->trainingPartnerProfile
                            ?->institute_name,

                    'completion_date' =>
                        $certificate->completion_date,

                    'final_assessment_score' =>
                        $certificate->finalAssessmentResult
                            ?->overall_score,

                    'final_assessment_result' =>
                        $certificate->finalAssessmentResult
                            ?->result,

                    'certificate_url' => $certificateUrl,

                    'issued_at' => $certificate->created_at,
                ],
            ],
        ]);
    }
}