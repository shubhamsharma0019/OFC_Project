<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CompanyProfile;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\TrainingPartnerProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Admin dashboard summary.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can access this dashboard.',
            ], 403);
        }

        $successfulPaymentAmount = Payment::query()
            ->where('payment_status', 'success')
            ->sum('amount');

        $recentCompanies = CompanyProfile::query()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentTrainingPartners = TrainingPartnerProfile::query()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentJobs = Job::query()
            ->with([
                'companyProfile',
            ])
            ->withCount('applications')
            ->latest()
            ->limit(5)
            ->get();

        $recentEnrollments = CourseEnrollment::query()
            ->with([
                'fresherProfile.user',
                'course.trainingPartnerProfile',
                'trainingProgress',
                'certificate',
            ])
            ->latest('enrollment_date')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Admin dashboard fetched successfully.',
            'data' => [
                'admin' => $user,

                'statistics' => [
                    'total_users' => User::query()->count(),

                    'active_users' => User::query()
                        ->where('status', 'active')
                        ->count(),

                    'blocked_users' => User::query()
                        ->where('status', 'blocked')
                        ->count(),

                    'total_freshers' => User::query()
                        ->where('role', 'fresher')
                        ->count(),

                    'total_companies' => User::query()
                        ->where('role', 'company')
                        ->count(),

                    'total_training_partners' => User::query()
                        ->where('role', 'training_partner')
                        ->count(),

                    'total_admins' => User::query()
                        ->where('role', 'admin')
                        ->count(),

                    'company_profiles' =>
                        CompanyProfile::query()->count(),

                    'pending_companies' =>
                        CompanyProfile::query()
                            ->where('approval_status', 'pending')
                            ->count(),

                    'approved_companies' =>
                        CompanyProfile::query()
                            ->where('approval_status', 'approved')
                            ->count(),

                    'rejected_companies' =>
                        CompanyProfile::query()
                            ->where('approval_status', 'rejected')
                            ->count(),

                    'training_partner_profiles' =>
                        TrainingPartnerProfile::query()->count(),

                    'pending_training_partners' =>
                        TrainingPartnerProfile::query()
                            ->where('approval_status', 'pending')
                            ->count(),

                    'approved_training_partners' =>
                        TrainingPartnerProfile::query()
                            ->where('approval_status', 'approved')
                            ->count(),

                    'rejected_training_partners' =>
                        TrainingPartnerProfile::query()
                            ->where('approval_status', 'rejected')
                            ->count(),

                    'total_jobs' => Job::query()->count(),

                    'active_jobs' => Job::query()
                        ->where('status', 'active')
                        ->count(),

                    'inactive_jobs' => Job::query()
                        ->where('status', 'inactive')
                        ->count(),

                    'total_courses' => Course::query()->count(),

                    'active_courses' => Course::query()
                        ->where('status', 'active')
                        ->count(),

                    'inactive_courses' => Course::query()
                        ->where('status', 'inactive')
                        ->count(),

                    'removed_courses' => Course::query()
                        ->where('status', 'removed')
                        ->count(),

                    'total_job_applications' =>
                        JobApplication::query()->count(),

                    'hired_applications' =>
                        JobApplication::query()
                            ->where('application_status', 'hired')
                            ->count(),

                    'rejected_applications' =>
                        JobApplication::query()
                            ->where('application_status', 'rejected')
                            ->count(),

                    'total_course_enrollments' =>
                        CourseEnrollment::query()->count(),

                    'pending_enrollments' =>
                        CourseEnrollment::query()
                            ->where('enrollment_status', 'pending')
                            ->count(),

                    'completed_enrollments' =>
                        CourseEnrollment::query()
                            ->where('enrollment_status', 'completed')
                            ->count(),

                    'paid_enrollments' =>
                        CourseEnrollment::query()
                            ->where('payment_status', 'paid')
                            ->count(),

                    'successful_payments' =>
                        Payment::query()
                            ->where('payment_status', 'success')
                            ->count(),

                    'failed_payments' =>
                        Payment::query()
                            ->where('payment_status', 'failed')
                            ->count(),

                    'total_payment_amount' => number_format(
                        (float) $successfulPaymentAmount,
                        2,
                        '.',
                        ''
                    ),

                    'total_certificates' =>
                        Certificate::query()->count(),
                ],

                'recent_companies' => $recentCompanies,

                'recent_training_partners' =>
                    $recentTrainingPartners,

                'recent_jobs' => $recentJobs,

                'recent_enrollments' => $recentEnrollments,
            ],
        ]);
    }
}