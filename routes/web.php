<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/company/dashboard-preview', 'company.dashboard');
Route::view('/company/dashboard', 'company.dashboard');
Route::view('/company/profile', 'company.profile.show');
Route::view('/company/post-job', 'company.jobs.create');
Route::view('/company/jobs', 'company.jobs.index');
Route::view('/company/applications', 'company.applications.index');
Route::view('/company/shortlisted', 'company.applications.shortlisted');
Route::view('/company/interviews', 'company.interviews.index');
Route::view('/company/hired', 'company.hired.index');
Route::view('/company/billing', 'company.billing.index');
Route::view('/company/messages', 'company.messages.index');
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
