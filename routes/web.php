<?php

use App\Http\Controllers\CompanyDashboardPageController;
use App\Models\CompanyResumeAssignment;
use App\Models\FresherProfile;
use App\Http\Controllers\PublicPageController;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [PublicPageController::class, 'home']);

Route::get('/about', [PublicPageController::class, 'about']);

Route::view('/login', 'auth.role-selection', ['mode' => 'login']);
Route::view('/register', 'auth.role-selection', ['mode' => 'register']);

Route::get('/job', [PublicPageController::class, 'companies']);
Route::get('/jobs', [PublicPageController::class, 'companies']);
Route::view('/job/show', 'public.jobs.show');
Route::view('/jobs/show', 'public.jobs.show');

Route::get('/fast-track', [PublicPageController::class, 'fastTrack']);
Route::view('/fast-track/how-it-works', 'public.fast-track.how-it-works');
Route::view('/fast-track/login', 'fast-track.login');
Route::redirect('/fast-track/register', '/direct-mode/flow-selection');

Route::view('/admin/forgot-password', 'auth.forgot-password', ['role' => 'admin', 'loginUrl' => '/admin/login']);

Route::get('/direct-mode', [PublicPageController::class, 'directMode']);
Route::view('/direct-mode/login', 'direct-mode.login');
Route::view('/direct-mode/register', 'direct-mode.register');
Route::view('/direct-mode/forgot-password', 'auth.forgot-password', ['role' => 'fresher', 'loginUrl' => '/direct-mode/login']);

Route::view('/fresher/login', 'direct-mode.login');
Route::view('/fresher/register', 'direct-mode.register');
Route::view('/fresher/forgot-password', 'auth.forgot-password', ['role' => 'fresher', 'loginUrl' => '/direct-mode/login']);

Route::view('/company/login', 'direct-mode.login');
Route::view('/company/register', 'direct-mode.register');
Route::view('/company/forgot-password', 'auth.forgot-password', ['role' => 'company', 'loginUrl' => '/company/login']);

Route::view('/training-partner/login', 'direct-mode.login');
Route::view('/training-partner/register', 'direct-mode.register');
Route::view('/training-partner/forgot-password', 'auth.forgot-password', ['role' => 'training_partner', 'loginUrl' => '/training-partner/login']);

Route::redirect('/training-partners/login', '/training-partner/login');
Route::redirect('/training-partners/register', '/training-partner/register');
Route::redirect('/traning-partner/login', '/training-partner/login');
Route::redirect('/traning-partner/register', '/training-partner/register');
Route::redirect('/traning-partner/forgot-password', '/training-partner/forgot-password');
Route::redirect('/traning-partner/{path}', '/training-partner/{path}')
    ->where('path', '.*');

Route::view('/direct-mode/dashboard', 'direct-mode.dashboard');
Route::view('/direct-mode/profile', 'direct-mode.profile');
Route::view('/direct-mode/flow-selection', 'direct-mode.assessments');
Route::redirect('/direct-mode/assessments', '/direct-mode/flow-selection');
Route::view('/direct-mode/jobs', 'direct-mode.jobs');
Route::view('/direct-mode/jobs/{slug}', 'direct-mode.job-details');
Route::view('/direct-mode/applications', 'direct-mode.applications');
Route::view('/direct-mode/interviews', 'direct-mode.interviews');
Route::view('/direct-mode/offers', 'direct-mode.offers');
Route::view('/direct-mode/activity', 'direct-mode.activity');
Route::view('/direct-mode/settings', 'direct-mode.settings');
Route::view('/direct-mode/logout', 'direct-mode.logout');

Route::redirect('/fresher/dashboard', '/direct-mode/dashboard');
Route::redirect('/fresher/profile', '/direct-mode/profile');
Route::redirect('/fresher/assessments', '/direct-mode/flow-selection');
Route::redirect('/fresher/jobs', '/direct-mode/jobs');
Route::redirect('/fresher/applications', '/direct-mode/applications');
Route::redirect('/fresher/interviews', '/direct-mode/interviews');
Route::redirect('/fresher/offers', '/direct-mode/offers');
Route::redirect('/fresher/activity', '/direct-mode/activity');
Route::redirect('/fresher/settings', '/direct-mode/settings');

Route::view('/fast-track/dashboard', 'fresher.fast-track.index');
Route::view('/fast-track/profile', 'fresher.profile.show');
Route::view('/fast-track/profile/edit', 'fresher.profile.show', ['editMode' => true]);
Route::view('/fast-track/courses', 'fresher.fast-track.courses');
Route::redirect('/fast-track/assessment', '/direct-mode/flow-selection');
Route::view('/fast-track/final-assessment', 'fresher.final-assessment.index');
Route::view('/fast-track/course-details', 'fresher.fast-track.course-details');
Route::view('/fast-track/training', 'fresher.fast-track.training');
Route::view('/fast-track/training-progress', 'fresher.fast-track.training-progress');
Route::view('/fast-track/job-recommendations', 'fresher.fast-track.job-recommendations');
Route::view('/fast-track/applications', 'fresher.fast-track.applications');
Route::view('/fast-track/certificate', 'fresher.fast-track.certificate');
Route::view('/fast-track/notifications', 'fresher.fast-track.notifications');
Route::view('/fast-track/settings', 'fresher.fast-track.settings');

Route::get('/training-partners', [PublicPageController::class, 'trainingPartners']);
Route::view('/training-partners/show', 'public.training-partners.show');

Route::get('/courses', [PublicPageController::class, 'courses']);
Route::get('/courses/show', [PublicPageController::class, 'courseShow']);

Route::view('/certificates/verify', 'public.certificates.verify');


/*
|--------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------
*/

Route::get('/company/dashboard-preview', CompanyDashboardPageController::class);
Route::get('/company/dashboard', CompanyDashboardPageController::class);
Route::view('/company/credits-welcome', 'company.credits-welcome');
Route::view('/company/billing', 'company.billing.index');
Route::view('/company/resumes', 'company.resumes.index');
Route::get('/company/resumes/open-assigned', function (Request $request) {
    return openAssignedCompanyResume($request, false);
});
Route::get('/company/resumes/download-assigned', function (Request $request) {
    return openAssignedCompanyResume($request, true);
});

Route::view('/company/profile', 'company.profile.show');
Route::view('/company/profile/edit', 'company.profile.edit');

Route::view('/company/post-job', 'company.jobs.create');
Route::view('/company/jobs', 'company.jobs.index');
Route::view('/company/jobs/show', 'company.jobs.show');
Route::view('/company/jobs/edit', 'company.jobs.edit');
Route::view('/company/jobs/preview', 'company.jobs.preview');

Route::view('/company/applications', 'company.applications.index');
Route::view('/company/applications/show', 'company.applications.show');
Route::get('/company/resumes/open', function (Request $request) {
    abort_unless(companyCanAccessBulkResumes($request), 403);

    $path = trim((string) $request->query('path', ''));

    abort_if($path === '' || str_contains($path, '..') || ! str_starts_with($path, 'fresher/resumes/'), 404);
    abort_unless(Storage::disk('public')->exists($path), 404);

    $absolutePath = Storage::disk('public')->path($path);
    $fileName = basename($path);
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $contentTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    return response()->file($absolutePath, [
        'Content-Type' => $contentTypes[$extension] ?? 'application/octet-stream',
        'Content-Disposition' => 'inline; filename="' . addslashes($fileName) . '"',
        'Cache-Control' => 'private, max-age=0, must-revalidate',
        'Pragma' => 'public',
    ]);
});
Route::get('/company/resumes/download', function (Request $request) {
    abort_unless(companyCanAccessBulkResumes($request), 403);

    $path = trim((string) $request->query('path', ''));

    abort_if($path === '' || str_contains($path, '..') || ! str_starts_with($path, 'fresher/resumes/'), 404);
    abort_unless(Storage::disk('public')->exists($path), 404);

    return Storage::disk('public')->download($path);
});
Route::view('/company/shortlisted', 'company.applications.shortlisted');

if (! function_exists('companyCanAccessBulkResumes')) {
    function companyCanAccessBulkResumes(Request $request): bool
    {
        $token = trim((string) $request->query('token', ''));

        if ($token === '') {
            return false;
        }

        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken?->tokenable;
        $plan = strtolower((string) $user?->companyProfile?->subscription_plan);

        return $user?->role === 'company'
            && in_array($plan, ['custom', 'customized', 'customised'], true);
    }
}

if (! function_exists('openAssignedCompanyResume')) {
    function openAssignedCompanyResume(Request $request, bool $download)
    {
        $token = trim((string) $request->query('token', ''));
        $profileId = (int) $request->query('fresher_profile_id', 0);

        if ($token === '' || $profileId <= 0) {
            abort(404);
        }

        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken?->tokenable;
        $companyProfile = $user?->companyProfile;

        abort_unless($user?->role === 'company' && $companyProfile, 403);
        abort_unless($companyProfile->approval_status === 'approved', 403);
        abort_unless($companyProfile->hiring_intent === 'resume_only', 403);

        $resumeProfile = FresherProfile::query()
            ->whereKey($profileId)
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->firstOrFail();

        $assignment = CompanyResumeAssignment::query()
            ->where('company_profile_id', $companyProfile->id)
            ->where('fresher_profile_id', $resumeProfile->id)
            ->first();

        abort_unless($assignment, 403);

        if (! companyResumeAlreadyCharged($assignment) && (int) $companyProfile->job_credits < 50) {
            return redirect('/company/billing?reason=resume-credits-over');
        }

        DB::transaction(function () use ($companyProfile, $assignment, $download) {
            $lockedAssignment = $assignment->newQuery()
                ->whereKey($assignment->id)
                ->lockForUpdate()
                ->firstOrFail();
            $chargedAtColumn = $download ? 'resume_downloaded_at' : 'resume_opened_at';

            if (companyResumeAlreadyCharged($lockedAssignment)) {
                if (! $lockedAssignment->{$chargedAtColumn}) {
                    $lockedAssignment->forceFill([
                        $chargedAtColumn => now(),
                    ])->save();
                }

                return;
            }

            $lockedProfile = $companyProfile->newQuery()
                ->whereKey($companyProfile->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_if((int) $lockedProfile->job_credits < 50, 402, 'Resume credits are over.');

            $lockedProfile->decrement('job_credits', 50);
            $lockedProfile->increment('total_job_credits_used', 50);

            $lockedAssignment->forceFill([
                $chargedAtColumn => now(),
            ])->save();
        });

        $path = $resumeProfile->resume;

        abort_if(str_contains($path, '..') || ! str_starts_with($path, 'fresher/resumes/'), 404);
        abort_unless(Storage::disk('public')->exists($path), 404);

        if ($download) {
            return Storage::disk('public')->download($path);
        }

        $absolutePath = Storage::disk('public')->path($path);
        $fileName = basename($path);
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $contentTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return response()->file($absolutePath, [
            'Content-Type' => $contentTypes[$extension] ?? 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . addslashes($fileName) . '"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public',
        ]);
    }
}

if (! function_exists('companyResumeAlreadyCharged')) {
    function companyResumeAlreadyCharged(CompanyResumeAssignment $assignment): bool
    {
        foreach ([
            'resume_opened_at',
            'resume_downloaded_at',
            'shortlisted_at',
            'interview_sent_at',
            'interview_completed_at',
            'final_status_sent_at',
        ] as $column) {
            if (filled($assignment->{$column})) {
                return true;
            }
        }

        return false;
    }
}

Route::view('/company/interviews', 'company.interviews.index');
Route::view('/company/interviews/create', 'company.interviews.create');
Route::view('/company/interviews/show', 'company.interviews.show');

Route::view('/company/hired', 'company.hired.index');

Route::view('/company/notifications', 'company.notifications.index');
Route::view('/company/settings', 'company.settings.index');

Route::view('/company/approval/pending', 'company.approval.pending');
Route::view('/company/approval/rejected', 'company.approval.rejected');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::view('/admin/dashboard', 'admin.dashboard');

Route::view('/admin/freshers', 'admin.freshers.index');
Route::view('/admin/freshers/show', 'admin.freshers.show');

Route::view('/admin/companies', 'admin.companies.index');
Route::view('/admin/companies/show', 'admin.companies.show');
Route::view('/admin/resumes', 'admin.resumes.index');

Route::view('/admin/training-partners', 'admin.training-partners.index');
Route::view('/admin/training-partners/show', 'admin.training-partners.show');

Route::view('/admin/jobs', 'admin.jobs.index');
Route::view('/admin/jobs/show', 'admin.jobs.show');

Route::view('/admin/courses', 'admin.courses.index');
Route::view('/admin/courses/show', 'admin.courses.show');

Route::view('/admin/applications', 'admin.applications.index');
Route::view('/admin/applications/show', 'admin.applications.show');

Route::view('/admin/enrollments', 'admin.enrollments.index');
Route::view('/admin/enrollments/show', 'admin.enrollments.show');

Route::view('/admin/assessments', 'admin.assessments.index');
Route::view('/admin/assessments/create', 'admin.assessments.create');
Route::view('/admin/assessments/edit', 'admin.assessments.edit');

Route::view('/admin/reports', 'admin.reports.index');
Route::view('/admin/notifications', 'admin.notifications.index');
Route::view('/admin/settings', 'admin.settings.index');
Route::view('/admin/system-logs', 'admin.system-logs.index');

Route::view('/admin/login', 'auth.login');


/*
|--------------------------------------------------------------------------
| Training Partner Routes
|--------------------------------------------------------------------------
*/

Route::view('/training-partner/dashboard', 'training-partner.dashboard');

Route::view('/training-partner/profile', 'training-partner.profile.show');
Route::view('/training-partner/profile/edit', 'training-partner.profile.edit');

Route::view('/training-partner/approval/pending', 'training-partner.approval.pending');
Route::view('/training-partner/approval/rejected', 'training-partner.approval.rejected');

Route::view('/training-partner/courses', 'training-partner.courses.index');
Route::view('/training-partner/add-course', 'training-partner.courses.create');
Route::view('/training-partner/courses/show', 'training-partner.courses.show');
Route::view('/training-partner/courses/edit', 'training-partner.courses.edit');

Route::view('/training-partner/enrollments', 'training-partner.enrollments.index');
Route::view('/training-partner/enrollments/show', 'training-partner.enrollments.show');

Route::view('/training-partner/training-progress', 'training-partner.training-progress.index');

Route::view('/training-partner/progress/show', 'training-partner.progress.show');
Route::view('/training-partner/progress/edit', 'training-partner.progress.edit');

Route::view('/training-partner/assessments', 'training-partner.assessments.index');

Route::view('/training-partner/certificates', 'training-partner.certificates.index');
Route::view('/training-partner/certificates/show', 'training-partner.certificates.show');

Route::view('/training-partner/reports', 'training-partner.reports.index');
Route::view('/training-partner/payouts', 'training-partner.payouts.index');
Route::view('/training-partner/notifications', 'training-partner.notifications.index');
Route::view('/training-partner/settings', 'training-partner.settings.index');

Route::view('/training-partner/students', 'training-partner.students.index');
Route::view('/training-partner/students/show', 'training-partner.students.show');
