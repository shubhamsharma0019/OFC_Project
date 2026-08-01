<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResult;
use App\Models\Certificate;
use App\Models\CourseEnrollment;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TrainingPartnerCertificateController extends Controller
{
    /**
     * Completed course aur passed final assessment ke baad
     * certificate generate karega.
     */
    public function generate(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile(
            $request
        );

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can generate certificates.',
            ], 403);
        }

        $courseEnrollment->load([
            'course',
            'fresherProfile.user',
            'trainingProgress',
            'certificate',
        ]);

        if (
            !$courseEnrollment->course ||
            $courseEnrollment->course->training_partner_profile_id
                !== $trainingPartnerProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to generate a certificate for this enrollment.',
            ], 403);
        }

        if ($courseEnrollment->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Certificate cannot be generated before successful payment.',
            ], 422);
        }

        if (
            $courseEnrollment->training_status !== 'completed' ||
            $courseEnrollment->enrollment_status !== 'completed'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Complete the training before generating the certificate.',
            ], 422);
        }

        if (
            !$courseEnrollment->trainingProgress ||
            $courseEnrollment->trainingProgress->current_status !== 'completed' ||
            $courseEnrollment->trainingProgress->progress_percentage !== 100
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Training progress must be 100% completed.',
            ], 422);
        }

        if ($courseEnrollment->certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate has already been generated for this enrollment.',
                'data' => [
                    'certificate' => $courseEnrollment->certificate,
                ],
            ], 422);
        }

        $finalAssessmentResult = AssessmentResult::query()
            ->where('result', 'pass')
            ->whereHas('attempt', function ($query) use (
                $courseEnrollment
            ) {
                $query
                    ->where(
                        'course_enrollment_id',
                        $courseEnrollment->id
                    )
                    ->where('assessment_type', 'final')
                    ->where('status', 'submitted');
            })
            ->with('attempt')
            ->latest('id')
            ->first();

        if (!$finalAssessmentResult) {
            return response()->json([
                'success' => false,
                'message' => 'A passed final assessment is required before certificate generation.',
            ], 422);
        }

        $fresherProfile = $courseEnrollment->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        $completionDate = $courseEnrollment
            ->trainingProgress
            ->completion_date;

        $certificate = DB::transaction(function () use (
            $courseEnrollment,
            $fresherProfile,
            $trainingPartnerProfile,
            $finalAssessmentResult,
            $completionDate
        ) {
            $certificateNumber = $this->generateCertificateNumber();

            $certificateFile = $this->createCertificateFile(
                $certificateNumber,
                $fresherProfile->user?->name ?? 'Fresher',
                $courseEnrollment->course->course_name,
                $trainingPartnerProfile->institute_name,
                (string) $completionDate,
                (string) $finalAssessmentResult->overall_score
            );

            return Certificate::create([
                'fresher_profile_id' => $fresherProfile->id,
                'course_enrollment_id' => $courseEnrollment->id,
                'final_assessment_result_id' => $finalAssessmentResult->id,
                'certificate_number' => $certificateNumber,
                'certificate_file' => $certificateFile,
                'completion_date' => $completionDate,
            ]);
        });

        $certificate->load([
            'fresherProfile.user',
            'courseEnrollment.course.trainingPartnerProfile',
            'finalAssessmentResult',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Certificate generated successfully.',
            'data' => [
                'certificate' => $certificate,
                'certificate_url' => Storage::disk('public')->url(
                    $certificate->certificate_file
                ),
            ],
        ], 201);
    }

    /**
     * Logged-in Training Partner ke generated certificates.
     */
    public function index(Request $request): JsonResponse
    {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile(
            $request
        );

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access certificates.',
            ], 403);
        }

        $certificates = Certificate::query()
            ->whereHas(
                'courseEnrollment.course',
                function ($query) use ($trainingPartnerProfile) {
                    $query->where(
                        'training_partner_profile_id',
                        $trainingPartnerProfile->id
                    );
                }
            )
            ->with([
                'fresherProfile.user',
                'courseEnrollment.course',
                'finalAssessmentResult',
            ])
            ->latest()
            ->get()
            ->map(function (Certificate $certificate) {
                $certificate->certificate_url =
                    Storage::disk('public')->url(
                        $certificate->certificate_file
                    );

                return $certificate;
            });

        return response()->json([
            'success' => true,
            'message' => 'Certificates fetched successfully.',
            'data' => [
                'certificates' => $certificates,
            ],
        ]);
    }

    /**
     * Training Partner ka single certificate.
     */
    public function show(
        Request $request,
        Certificate $certificate
    ): JsonResponse {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile(
            $request
        );

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access certificates.',
            ], 403);
        }

        $certificate->load([
            'fresherProfile.user',
            'courseEnrollment.course.trainingPartnerProfile',
            'courseEnrollment.trainingProgress',
            'finalAssessmentResult',
        ]);

        if (
            !$certificate->courseEnrollment ||
            !$certificate->courseEnrollment->course ||
            $certificate->courseEnrollment
                ->course
                ->training_partner_profile_id
                !== $trainingPartnerProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this certificate.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Certificate details fetched successfully.',
            'data' => [
                'certificate' => $certificate,
                'certificate_url' => Storage::disk('public')->url(
                    $certificate->certificate_file
                ),
            ],
        ]);
    }

    /**
     * Unique certificate number generate karega.
     */
    private function generateCertificateNumber(): string
    {
        do {
            $certificateNumber = 'OF-CERT-'
                . now()->format('Y')
                . '-'
                . strtoupper(Str::random(10));
        } while (
            Certificate::query()
                ->where(
                    'certificate_number',
                    $certificateNumber
                )
                ->exists()
        );

        return $certificateNumber;
    }

    /**
     * Public storage me basic HTML certificate file create karega.
     */
    private function createCertificateFile(
        string $certificateNumber,
        string $fresherName,
        string $courseName,
        string $trainingPartnerName,
        string $completionDate,
        string $overallScore
    ): string {
        $safeCertificateNumber = e($certificateNumber);
        $safeFresherName = e($fresherName);
        $safeCourseName = e($courseName);
        $safeTrainingPartnerName = e($trainingPartnerName);
        $safeCompletionDate = e($completionDate);
        $safeOverallScore = e($overallScore);

        $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$safeCertificateNumber}</title>
    <style>
        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }

        .certificate {
            max-width: 900px;
            margin: auto;
            padding: 70px;
            text-align: center;
            background: #ffffff;
            border: 12px solid #071044;
            box-sizing: border-box;
        }

        h1 {
            color: #071044;
            font-size: 48px;
            margin-bottom: 12px;
        }

        h2 {
            color: #5b2eff;
            font-size: 34px;
        }

        p {
            color: #34405f;
            font-size: 19px;
            line-height: 1.7;
        }

        .number {
            margin-top: 45px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>

        <p>This certificate is proudly presented to</p>

        <h2>{$safeFresherName}</h2>

        <p>
            for successfully completing the course
            <strong>{$safeCourseName}</strong>
            conducted by
            <strong>{$safeTrainingPartnerName}</strong>.
        </p>

        <p>
            Final Assessment Score:
            <strong>{$safeOverallScore}%</strong>
        </p>

        <p>
            Completion Date:
            <strong>{$safeCompletionDate}</strong>
        </p>

        <p class="number">
            Certificate Number:
            <strong>{$safeCertificateNumber}</strong>
        </p>
    </div>
</body>
</html>
HTML;

        $filePath = 'certificates/'
            . $certificateNumber
            . '.html';

        Storage::disk('public')->put(
            $filePath,
            $html
        );

        return $filePath;
    }

    /**
     * Logged-in approved Training Partner profile.
     */
    private function getApprovedTrainingPartnerProfile(
        Request $request
    ): ?TrainingPartnerProfile {
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