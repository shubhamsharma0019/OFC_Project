<?php

use App\Http\Controllers\CompanyDashboardPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
});

Route::view('/about', 'public.about');
Route::view('/job', 'public.jobs.index');
Route::view('/jobs', 'public.jobs.index');
Route::view('/job/show', 'public.jobs.show');
Route::view('/jobs/show', 'public.jobs.show');
Route::view('/fast-track', 'public.fast-track.index');
Route::view('/fast-track/how-it-works', 'public.fast-track.how-it-works');
Route::view('/fast-track/login', 'fast-track.login');
Route::redirect('/direct-mode', '/direct-mode/login');
Route::view('/direct-mode/login', 'direct-mode.login');
Route::view('/direct-mode/register', 'direct-mode.register');
Route::view('/company/login', 'direct-mode.login');
Route::view('/company/register', 'direct-mode.register');
Route::view('/training-partner/login', 'direct-mode.login');
Route::view('/training-partner/register', 'direct-mode.register');
Route::view('/direct-mode/dashboard', 'direct-mode.dashboard');
Route::view('/direct-mode/profile', 'direct-mode.profile');
Route::view('/direct-mode/assessments', 'direct-mode.assessments');
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
Route::redirect('/fresher/assessments', '/direct-mode/assessments');
Route::redirect('/fresher/jobs', '/direct-mode/jobs');
Route::redirect('/fresher/applications', '/direct-mode/applications');
Route::redirect('/fresher/interviews', '/direct-mode/interviews');
Route::redirect('/fresher/offers', '/direct-mode/offers');
Route::redirect('/fresher/activity', '/direct-mode/activity');
Route::redirect('/fresher/settings', '/direct-mode/settings');
Route::view('/fast-track/dashboard', 'fresher.fast-track.index');
Route::view('/fast-track/profile', 'fresher.profile.show');
Route::view('/fast-track/courses', 'fresher.fast-track.courses');
Route::view('/fast-track/assessment', 'fresher.fast-track.assessment');
Route::view('/fast-track/final-assessment', 'fresher.final-assessment.index');
Route::view('/fast-track/course-details', 'fresher.fast-track.course-details');
Route::view('/fast-track/training', 'fresher.fast-track.training');
Route::view('/fast-track/training-progress', 'fresher.fast-track.training-progress');
Route::view('/fast-track/job-recommendations', 'fresher.fast-track.job-recommendations');
Route::view('/fast-track/applications', 'fresher.fast-track.applications');
Route::view('/fast-track/certificate', 'fresher.fast-track.certificate');
Route::view('/training-partners', 'public.training-partners.index');
Route::view('/training-partners/show', 'public.training-partners.show');
Route::view('/courses', 'public.courses.index');
Route::view('/courses/show', 'public.courses.show');
Route::view('/certificates/verify', 'public.certificates.verify');


Route::get('/company/dashboard-preview', CompanyDashboardPageController::class);
Route::get('/company/dashboard', CompanyDashboardPageController::class);
Route::view('/company/profile', 'company.profile.show');
Route::view('/company/post-job', 'company.jobs.create');
Route::view('/company/jobs', 'company.jobs.index');
Route::view('/company/applications', 'company.applications.index');
Route::view('/company/shortlisted', 'company.applications.shortlisted');
Route::view('/company/interviews', 'company.interviews.index');
Route::view('/company/hired', 'company.hired.index');
Route::view('/company/notifications', 'company.notifications.index');
Route::view('/company/settings', 'company.settings.index');
Route::view('/company/profile/edit', 'company.profile.edit');
Route::view('/company/approval/pending', 'company.approval.pending');
Route::view('/company/approval/rejected', 'company.approval.rejected');
Route::view('/company/jobs/show', 'company.jobs.show');
Route::view('/company/jobs/edit', 'company.jobs.edit');
Route::view('/company/jobs/preview', 'company.jobs.preview');
Route::view('/company/applications/show', 'company.applications.show');
Route::view('/company/interviews/create', 'company.interviews.create');
Route::view('/company/interviews/show', 'company.interviews.show');
Route::view('/admin/dashboard', 'admin.dashboard');
Route::view('/admin/freshers', 'admin.freshers.index');
Route::view('/admin/freshers/show', 'admin.freshers.show');
Route::view('/admin/companies', 'admin.companies.index');
Route::view('/admin/companies/show', 'admin.companies.show');
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


Route::view('/training-partner/dashboard', 'training-partner.dashboard');


Route::view('/training-partner/profile', 'training-partner.profile.show');


Route::view('/training-partner/courses', 'training-partner.courses.index');
Route::view('/training-partner/enrollments', 'training-partner.enrollments.index');
Route::view('/training-partner/training-progress', 'training-partner.training-progress.index');
Route::view('/training-partner/assessments', 'training-partner.assessments.index');
Route::view('/training-partner/certificates', 'training-partner.certificates.index');
Route::view('/training-partner/reports', 'training-partner.reports.index');
Route::view('/training-partner/payouts', 'training-partner.payouts.index');
Route::view('/training-partner/notifications', 'training-partner.notifications.index');
Route::view('/training-partner/add-course', 'training-partner.courses.create');









Route::view('/training-partner/profile/edit', 'training-partner.profile.edit');
Route::view('/training-partner/approval/pending', 'training-partner.approval.pending');
Route::view('/training-partner/approval/rejected', 'training-partner.approval.rejected');
Route::view('/training-partner/courses/show', 'training-partner.courses.show');
Route::view('/training-partner/courses/edit', 'training-partner.courses.edit');
Route::view('/training-partner/enrollments/show', 'training-partner.enrollments.show');
Route::view('/training-partner/certificates/show', 'training-partner.certificates.show');
Route::view('/training-partner/progress/show', 'training-partner.progress.show');
Route::view('/training-partner/progress/edit', 'training-partner.progress.edit');
Route::view('/training-partner/students', 'training-partner.students.index');
Route::view('/training-partner/students/show', 'training-partner.students.show');













