<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FresherCertificateController extends Controller
{
    /**
     * Logged-in Fresher ke saare certificates.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access certificates.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        $certificates = Certificate::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->with([
                'courseEnrollment.course.trainingPartnerProfile',
                'courseEnrollment.trainingProgress',
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
            'message' => 'Fresher certificates fetched successfully.',
            'data' => [
                'certificates' => $certificates,
            ],
        ]);
    }

    /**
     * Logged-in Fresher ka single certificate.
     */
    public function show(
        Request $request,
        Certificate $certificate
    ): JsonResponse {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access certificates.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if ($certificate->fresher_profile_id !== $fresherProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this certificate.',
            ], 403);
        }

        $certificate->load([
            'fresherProfile.user',
            'courseEnrollment.course.trainingPartnerProfile',
            'courseEnrollment.trainingProgress',
            'finalAssessmentResult',
        ]);

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
     * Logged-in Fresher ka certificate download karega.
     */
    public function download(
        Request $request,
        Certificate $certificate
    ): JsonResponse|StreamedResponse {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can download certificates.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if ($certificate->fresher_profile_id !== $fresherProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to download this certificate.',
            ], 403);
        }

        if (
            !Storage::disk('public')->exists(
                $certificate->certificate_file
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Certificate file not found.',
            ], 404);
        }

        $extension = pathinfo(
            $certificate->certificate_file,
            PATHINFO_EXTENSION
        );

        $downloadName = $certificate->certificate_number
            . '.'
            . $extension;

        return Storage::disk('public')->download(
            $certificate->certificate_file,
            $downloadName
        );
    }
}