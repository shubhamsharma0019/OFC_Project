<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Payment;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingPartnerReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile($request);

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access reports.',
            ], 403);
        }

        $courseQuery = Course::query()
            ->where('training_partner_profile_id', $trainingPartnerProfile->id);

        $enrollmentQuery = CourseEnrollment::query()
            ->whereHas('course', function ($query) use ($trainingPartnerProfile) {
                $query->where('training_partner_profile_id', $trainingPartnerProfile->id);
            });

        $paymentQuery = Payment::query()
            ->whereHas('courseEnrollment.course', function ($query) use ($trainingPartnerProfile) {
                $query->where('training_partner_profile_id', $trainingPartnerProfile->id);
            });

        $courseReports = Course::query()
            ->where('training_partner_profile_id', $trainingPartnerProfile->id)
            ->withCount([
                'enrollments',
                'enrollments as paid_enrollments_count' => function ($query) {
                    $query->where('payment_status', 'paid');
                },
                'enrollments as completed_trainings_count' => function ($query) {
                    $query->where('training_status', 'completed');
                },
                'enrollments as certificates_count' => function ($query) {
                    $query->whereHas('certificate');
                },
            ])
            ->with('enrollments.payments')
            ->latest()
            ->get()
            ->map(function (Course $course) {
                $course->revenue = (float) $course
                    ->enrollments
                    ->flatMap
                    ->payments
                    ->where('payment_status', 'success')
                    ->sum('amount');

                unset($course->enrollments);

                return $course;
            });

        $monthlyRevenue = (clone $paymentQuery)
            ->selectRaw('DATE_FORMAT(payment_date, "%Y-%m") as month, SUM(amount) as amount, COUNT(*) as payments')
            ->where('payment_status', 'success')
            ->whereNotNull('payment_date')
            ->groupBy(DB::raw('DATE_FORMAT(payment_date, "%Y-%m")'))
            ->orderBy('month')
            ->limit(12)
            ->get();

        $recentPayments = (clone $paymentQuery)
            ->with([
                'courseEnrollment.course',
                'courseEnrollment.fresherProfile.user',
            ])
            ->latest('payment_date')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Reports fetched successfully.',
            'data' => [
                'summary' => [
                    'total_courses' => (clone $courseQuery)->count(),
                    'active_courses' => (clone $courseQuery)->where('status', 'active')->count(),
                    'total_enrollments' => (clone $enrollmentQuery)->count(),
                    'paid_enrollments' => (clone $enrollmentQuery)->where('payment_status', 'paid')->count(),
                    'completed_trainings' => (clone $enrollmentQuery)->where('training_status', 'completed')->count(),
                    'certificates' => (clone $enrollmentQuery)->whereHas('certificate')->count(),
                    'total_revenue' => (float) (clone $paymentQuery)->where('payment_status', 'success')->sum('amount'),
                ],
                'course_reports' => $courseReports,
                'monthly_revenue' => $monthlyRevenue,
                'recent_payments' => $recentPayments,
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
