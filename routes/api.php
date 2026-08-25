<?php

use App\Http\Controllers\Api\AdminApplicationController;
use App\Http\Controllers\Api\AdminAssessmentController;
use App\Http\Controllers\Api\AdminAssessmentQuestionController;
use App\Http\Controllers\Api\AdminCompanyController;
use App\Http\Controllers\Api\AdminCourseController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminEnrollmentController;
use App\Http\Controllers\Api\AdminFresherController;
use App\Http\Controllers\Api\AdminJobController;
use App\Http\Controllers\Api\AdminSettingsController;
use App\Http\Controllers\Api\AdminSystemLogController;
use App\Http\Controllers\Api\AdminTrainingPartnerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyApplicationController;
use App\Http\Controllers\Api\CompanyDashboardController;
use App\Http\Controllers\Api\CompanyInterviewController;
use App\Http\Controllers\Api\CompanyJobController;
use App\Http\Controllers\Api\CompanyProfileController;
use App\Http\Controllers\Api\FresherAssessmentController;
use App\Http\Controllers\Api\FresherCertificateController;
use App\Http\Controllers\Api\FresherCourseEnrollmentController;
use App\Http\Controllers\Api\FresherCoursePaymentController;
use App\Http\Controllers\Api\FresherDashboardController;
use App\Http\Controllers\Api\FresherFinalAssessmentController;
use App\Http\Controllers\Api\FresherJobApplicationController;
use App\Http\Controllers\Api\FresherProfileController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PublicCertificateController;
use App\Http\Controllers\Api\PublicCourseController;
use App\Http\Controllers\Api\PublicJobController;
use App\Http\Controllers\Api\PublicTrainingPartnerController;
use App\Http\Controllers\Api\TrainingPartnerAssessmentController;
use App\Http\Controllers\Api\TrainingPartnerCertificateController;
use App\Http\Controllers\Api\TrainingPartnerCourseController;
use App\Http\Controllers\Api\TrainingPartnerDashboardController;
use App\Http\Controllers\Api\TrainingPartnerPayoutController;
use App\Http\Controllers\Api\TrainingPartnerProfileController;
use App\Http\Controllers\Api\TrainingPartnerProgressController;
use App\Http\Controllers\Api\TrainingPartnerReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Authentication Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'resetPassword']);
});

/*
|--------------------------------------------------------------------------
| Public Job Routes
|--------------------------------------------------------------------------
*/

Route::prefix('jobs')->group(function () {
    Route::get('/', [PublicJobController::class, 'index']);
    Route::get('/{job}', [PublicJobController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Public Course Routes
|--------------------------------------------------------------------------
*/

Route::prefix('courses')->group(function () {
    Route::get('/', [PublicCourseController::class, 'index']);
    Route::get('/{course}', [PublicCourseController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Public Training Partner Routes
|--------------------------------------------------------------------------
*/

Route::prefix('training-partners')->group(function () {
    Route::get(
        '/',
        [PublicTrainingPartnerController::class, 'index']
    );

    Route::get(
        '/{trainingPartnerProfile}',
        [PublicTrainingPartnerController::class, 'show']
    );
});

/*
|--------------------------------------------------------------------------
| Public Certificate Verification Route
|--------------------------------------------------------------------------
*/

Route::get(
    '/certificates/verify/{certificateNumber}',
    [PublicCertificateController::class, 'verify']
);

/*
|--------------------------------------------------------------------------
| Protected Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')
    ->prefix('auth')
    ->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::patch('/password', [AuthController::class, 'updatePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });

/*
|--------------------------------------------------------------------------
| Protected Application Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Fresher Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('fresher')->group(function () {
        Route::get(
            '/profile',
            [FresherProfileController::class, 'show']
        );

        Route::post(
            '/profile',
            [FresherProfileController::class, 'save']
        );

        Route::post(
            '/direct-mode/subscribe',
            [FresherProfileController::class, 'subscribeDirectMode']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Fresher Dashboard Route
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fresher/dashboard',
        [FresherDashboardController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Fresher Initial Assessment Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('fresher/assessment')->group(function () {
        Route::post(
            '/start',
            [FresherAssessmentController::class, 'start']
        );

        Route::get(
            '/{attempt}/questions',
            [FresherAssessmentController::class, 'questions']
        );

        Route::post(
            '/{attempt}/submit',
            [FresherAssessmentController::class, 'submit']
        );

        Route::get(
            '/{attempt}/result',
            [FresherAssessmentController::class, 'result']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Fresher Job Application Routes
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/fresher/jobs/{job}/apply',
        [FresherJobApplicationController::class, 'apply']
    );

    Route::get(
        '/fresher/applications',
        [FresherJobApplicationController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Fresher Course Enrollment Routes
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/fresher/courses/{course}/enroll',
        [FresherCourseEnrollmentController::class, 'enroll']
    );

    Route::get(
        '/fresher/enrollments',
        [FresherCourseEnrollmentController::class, 'index']
    );

    Route::get(
        '/fresher/enrollments/{courseEnrollment}',
        [FresherCourseEnrollmentController::class, 'show']
    );

    /*
    |--------------------------------------------------------------------------
    | Fresher Course Payment Routes
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/fresher/enrollments/{courseEnrollment}/payment',
        [FresherCoursePaymentController::class, 'pay']
    );

    Route::get(
        '/fresher/enrollments/{courseEnrollment}/payments',
        [FresherCoursePaymentController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Fresher Final Assessment Routes
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/fresher/enrollments/{courseEnrollment}/final-assessment/start',
        [FresherFinalAssessmentController::class, 'start']
    );

    Route::get(
        '/fresher/final-assessment/{attempt}/questions',
        [FresherFinalAssessmentController::class, 'questions']
    );

    Route::post(
        '/fresher/final-assessment/{attempt}/submit',
        [FresherFinalAssessmentController::class, 'submit']
    );

    Route::get(
        '/fresher/final-assessment/{attempt}/result',
        [FresherFinalAssessmentController::class, 'result']
    );

    /*
    |--------------------------------------------------------------------------
    | Fresher Certificate Routes
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/fresher/certificates',
        [FresherCertificateController::class, 'index']
    );

    Route::get(
        '/fresher/certificates/{certificate}',
        [FresherCertificateController::class, 'show']
    );

    Route::get(
        '/fresher/certificates/{certificate}/download',
        [FresherCertificateController::class, 'download']
    );

    /*
    |--------------------------------------------------------------------------
    | Company Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('company')->group(function () {
        Route::get(
            '/profile',
            [CompanyProfileController::class, 'show']
        );

        Route::post(
            '/profile',
            [CompanyProfileController::class, 'save']
        );

        Route::post(
            '/subscribe',
            [CompanyProfileController::class, 'subscribe']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Company Dashboard Route
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/company/dashboard',
        [CompanyDashboardController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Company Job Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('company/jobs')->group(function () {
        Route::get(
            '/',
            [CompanyJobController::class, 'index']
        );

        Route::post(
            '/',
            [CompanyJobController::class, 'store']
        );

        Route::get(
            '/{job}',
            [CompanyJobController::class, 'show']
        );

        Route::put(
            '/{job}',
            [CompanyJobController::class, 'update']
        );

        Route::patch(
            '/{job}/status',
            [CompanyJobController::class, 'changeStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Company Application Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('company/applications')->group(function () {
        Route::get(
            '/',
            [CompanyApplicationController::class, 'index']
        );

        Route::get(
            '/{jobApplication}',
            [CompanyApplicationController::class, 'show']
        );

        Route::patch(
            '/{jobApplication}/status',
            [CompanyApplicationController::class, 'updateStatus']
        );

        Route::post(
            '/{jobApplication}/interview',
            [CompanyInterviewController::class, 'store']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Company Interview Routes
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/company/interviews',
        [CompanyInterviewController::class, 'index']
    );

    Route::patch(
        '/company/interviews/{interview}',
        [CompanyInterviewController::class, 'update']
    );

    Route::patch(
        '/company/interviews/{interview}/status',
        [CompanyInterviewController::class, 'updateStatus']
    );

    /*
    |--------------------------------------------------------------------------
    | Training Partner Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('training-partner')->group(function () {
        Route::get(
            '/profile',
            [TrainingPartnerProfileController::class, 'show']
        );

        Route::post(
            '/profile',
            [TrainingPartnerProfileController::class, 'save']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Training Partner Dashboard Route
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/training-partner/dashboard',
        [TrainingPartnerDashboardController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Training Partner Course Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('training-partner/courses')->group(function () {
        Route::get(
            '/',
            [TrainingPartnerCourseController::class, 'index']
        );

        Route::post(
            '/',
            [TrainingPartnerCourseController::class, 'store']
        );

        Route::get(
            '/{course}',
            [TrainingPartnerCourseController::class, 'show']
        );

        Route::put(
            '/{course}',
            [TrainingPartnerCourseController::class, 'update']
        );

        Route::patch(
            '/{course}/status',
            [TrainingPartnerCourseController::class, 'updateStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Training Partner Enrollment Progress Routes
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/training-partner/enrollments',
        [TrainingPartnerProgressController::class, 'enrollments']
    );

    Route::get(
        '/training-partner/enrollments/{courseEnrollment}/progress',
        [TrainingPartnerProgressController::class, 'show']
    );

    Route::patch(
        '/training-partner/enrollments/{courseEnrollment}/progress',
        [TrainingPartnerProgressController::class, 'update']
    );

    Route::get(
        '/training-partner/assessments',
        [TrainingPartnerAssessmentController::class, 'index']
    );

    Route::get(
        '/training-partner/reports',
        [TrainingPartnerReportController::class, 'index']
    );

    Route::get(
        '/training-partner/payouts',
        [TrainingPartnerPayoutController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Training Partner Certificate Routes
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/training-partner/enrollments/{courseEnrollment}/certificate',
        [TrainingPartnerCertificateController::class, 'generate']
    );

    Route::get(
        '/training-partner/certificates',
        [TrainingPartnerCertificateController::class, 'index']
    );

    Route::get(
        '/training-partner/certificates/{certificate}',
        [TrainingPartnerCertificateController::class, 'show']
    );

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Route
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Admin Fresher Management Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/freshers')->group(function () {
        Route::get(
            '/',
            [AdminFresherController::class, 'index']
        );

        Route::get(
            '/{fresher}',
            [AdminFresherController::class, 'show']
        );

        Route::patch(
            '/{fresher}/status',
            [AdminFresherController::class, 'updateStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Company Management Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/companies')->group(function () {
        Route::get(
            '/',
            [AdminCompanyController::class, 'index']
        );

        Route::get(
            '/{companyProfile}',
            [AdminCompanyController::class, 'show']
        );

        Route::post(
            '/{companyProfile}/approve',
            [AdminCompanyController::class, 'approve']
        );

        Route::post(
            '/{companyProfile}/reject',
            [AdminCompanyController::class, 'reject']
        );

        Route::patch(
            '/{companyProfile}/user-status',
            [AdminCompanyController::class, 'updateUserStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Training Partner Management Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/training-partners')->group(function () {
        Route::get(
            '/',
            [AdminTrainingPartnerController::class, 'index']
        );

        Route::get(
            '/{trainingPartnerProfile}',
            [AdminTrainingPartnerController::class, 'show']
        );

        Route::post(
            '/{trainingPartnerProfile}/approve',
            [AdminTrainingPartnerController::class, 'approve']
        );

        Route::post(
            '/{trainingPartnerProfile}/reject',
            [AdminTrainingPartnerController::class, 'reject']
        );

        Route::patch(
            '/{trainingPartnerProfile}/user-status',
            [AdminTrainingPartnerController::class, 'updateUserStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Assessment Question Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/assessment/questions')->group(function () {
        Route::get(
            '/',
            [AdminAssessmentQuestionController::class, 'index']
        );

        Route::post(
            '/',
            [AdminAssessmentQuestionController::class, 'store']
        );

        Route::put(
            '/{question}',
            [AdminAssessmentQuestionController::class, 'update']
        );

        Route::patch(
            '/{question}/status',
            [AdminAssessmentQuestionController::class, 'updateStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Job Management Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/jobs')->group(function () {
        Route::get(
            '/',
            [AdminJobController::class, 'index']
        );

        Route::get(
            '/{job}',
            [AdminJobController::class, 'show']
        );

        Route::patch(
            '/{job}/status',
            [AdminJobController::class, 'updateStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Course Management Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/courses')->group(function () {
        Route::get(
            '/',
            [AdminCourseController::class, 'index']
        );

        Route::get(
            '/{course}',
            [AdminCourseController::class, 'show']
        );

        Route::patch(
            '/{course}/status',
            [AdminCourseController::class, 'updateStatus']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Application Monitoring Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/applications')->group(function () {
        Route::get(
            '/',
            [AdminApplicationController::class, 'index']
        );

        Route::get(
            '/{jobApplication}',
            [AdminApplicationController::class, 'show']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Enrollment Monitoring Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/enrollments')->group(function () {
        Route::get(
            '/',
            [AdminEnrollmentController::class, 'index']
        );

        Route::get(
            '/{courseEnrollment}',
            [AdminEnrollmentController::class, 'show']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Assessment Monitoring Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/assessments')->group(function () {
        Route::get(
            '/',
            [AdminAssessmentController::class, 'index']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Settings Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/settings')->group(function () {
        Route::get(
            '/',
            [AdminSettingsController::class, 'show']
        );

        Route::put(
            '/',
            [AdminSettingsController::class, 'update']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Admin System Log Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/system-logs')->group(function () {
        Route::get(
            '/',
            [AdminSystemLogController::class, 'index']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Notification Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('notifications')->group(function () {
        Route::get(
            '/',
            [NotificationController::class, 'index']
        );

        Route::get(
            '/unread-count',
            [NotificationController::class, 'unreadCount']
        );

        Route::patch(
            '/read-all',
            [NotificationController::class, 'markAllAsRead']
        );

        Route::patch(
            '/{notification}/read',
            [NotificationController::class, 'markAsRead']
        );
    });
});
