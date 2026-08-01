<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Payment;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainingPartnerDashboardController extends Controller
{
    /**
     * Logged-in Training Partner ka dashboard summary.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user || $user->role !== 'training_partner') {
            return response()->json([
                'success' => false,
                'message' => 'Only training partners can access this dashboard.',
            ], 403);
        }

        $trainingPartnerProfile = TrainingPartnerProfile::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Training Partner profile not found.',
            ], 404);
        }

        $courseQuery = Course::query()
            ->where(
                'training_partner_profile_id',
                $trainingPartnerProfile->id
            );

        $enrollmentQuery = CourseEnrollment::query()
            ->whereHas('course', function ($query) use (
                $trainingPartnerProfile
            ) {
                $query->where(
                    'training_partner_profile_id',
                    $trainingPartnerProfile->id
                );
            });

        $paymentQuery = Payment::query()
            ->whereHas('courseEnrollment.course', function ($query) use (
                $trainingPartnerProfile
            ) {
                $query->where(
                    'training_partner_profile_id',
                    $trainingPartnerProfile->id
                );
            });

        $certificateQuery = Certificate::query()
            ->whereHas(
                'courseEnrollment.course',
                function ($query) use ($trainingPartnerProfile) {
                    $query->where(
                        'training_partner_profile_id',
                        $trainingPartnerProfile->id
                    );
                }
            );

        $recentCourses = Course::query()
            ->where(
                'training_partner_profile_id',
                $trainingPartnerProfile->id
            )
            ->withCount('enrollments')
            ->latest()
            ->limit(5)
            ->get();

        $recentEnrollments = CourseEnrollment::query()
            ->whereHas('course', function ($query) use (
                $trainingPartnerProfile
            ) {
                $query->where(
                    'training_partner_profile_id',
                    $trainingPartnerProfile->id
                );
            })
            ->with([
                'course',
                'fresherProfile.user',
                'trainingProgress',
                'certificate',
            ])
            ->latest('enrollment_date')
            ->limit(5)
            ->get();

        $recentCertificates = Certificate::query()
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
            ->limit(5)
            ->get();

        $successfulPaymentAmount = (clone $paymentQuery)
            ->where('payment_status', 'success')
            ->sum('amount');

        return response()->json([
            'success' => true,
            'message' => 'Training Partner dashboard fetched successfully.',
            'data' => [
                'user' => $user,

                'training_partner_profile' => [
                    'profile_id' => $trainingPartnerProfile->id,
                    'institute_name' =>
                        $trainingPartnerProfile->institute_name,
                    'location' =>
                        $trainingPartnerProfile->location,
                    'website' =>
                        $trainingPartnerProfile->website,
                    'approval_status' =>
                        $trainingPartnerProfile->approval_status,
                    'rejection_reason' =>
                        $trainingPartnerProfile->rejection_reason,
                ],

                'statistics' => [
                    'total_courses' =>
                        (clone $courseQuery)->count(),

                    'active_courses' =>
                        (clone $courseQuery)
                            ->where('status', 'active')
                            ->count(),

                    'inactive_courses' =>
                        (clone $courseQuery)
                            ->where('status', 'inactive')
                            ->count(),

                    'removed_courses' =>
                        (clone $courseQuery)
                            ->where('status', 'removed')
                            ->count(),

                    'total_enrollments' =>
                        (clone $enrollmentQuery)->count(),

                    'pending_enrollments' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'enrollment_status',
                                'pending'
                            )
                            ->count(),

                    'enrolled_students' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'enrollment_status',
                                'enrolled'
                            )
                            ->count(),

                    'completed_enrollments' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'enrollment_status',
                                'completed'
                            )
                            ->count(),

                    'paid_enrollments' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'payment_status',
                                'paid'
                            )
                            ->count(),

                    'active_trainings' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'training_status',
                                'in_progress'
                            )
                            ->count(),

                    'completed_trainings' =>
                        (clone $enrollmentQuery)
                            ->where(
                                'training_status',
                                'completed'
                            )
                            ->count(),

                    'successful_payments' =>
                        (clone $paymentQuery)
                            ->where(
                                'payment_status',
                                'success'
                            )
                            ->count(),

                    'total_payment_amount' =>
                        number_format(
                            (float) $successfulPaymentAmount,
                            2,
                            '.',
                            ''
                        ),

                    'total_certificates' =>
                        (clone $certificateQuery)->count(),
                ],

                'recent_courses' => $recentCourses,

                'recent_enrollments' => $recentEnrollments,

                'recent_certificates' => $recentCertificates,
            ],
        ]);
    }
}