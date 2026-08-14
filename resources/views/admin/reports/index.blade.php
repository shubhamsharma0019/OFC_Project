@extends('layouts.admin')

@section('title', 'Reports - OnlyFreshers Admin')
@section('pageTitle', 'Reports')
@section('breadcrumb', 'Dashboard > Reports')

@php
    $activePage = 'reports';
@endphp

@push('styles')
<style>
    .admin-reports-page,
    .admin-reports-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-reports-page grid gap-5">
        <div id="reportStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading reports...</article>
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.1fr_.9fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-[#061942]">Platform Overview</h2>
                        <p class="mt-1 text-sm text-[#52607a]">Dashboard data se generated report snapshot.</p>
                    </div>
                    <select id="categoryFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]">
                        <option value="">All Reports</option>
                        <option value="users">Users</option>
                        <option value="jobs">Jobs</option>
                        <option value="courses">Courses</option>
                        <option value="finance">Finance</option>
                    </select>
                </div>
                <div id="reportRows" class="grid gap-3">
                    <p class="text-sm text-[#52607a]">Loading report rows...</p>
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="text-lg font-bold text-[#061942]">Approval Queue</h2>
                <p class="mt-1 text-sm text-[#52607a]">Companies aur training partners pending approvals.</p>
                <div id="approvalQueue" class="mt-5 grid gap-3">
                    <p class="text-sm text-[#52607a]">Loading approval queue...</p>
                </div>
            </article>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="text-lg font-bold text-[#061942]">Recent Jobs</h2>
                <div id="recentJobs" class="mt-4 grid gap-3"><p class="text-sm text-[#52607a]">Loading recent jobs...</p></div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="text-lg font-bold text-[#061942]">Recent Enrollments</h2>
                <div id="recentEnrollments" class="mt-4 grid gap-3"><p class="text-sm text-[#52607a]">Loading recent enrollments...</p></div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const reportStats = document.getElementById('reportStats');
    const reportRows = document.getElementById('reportRows');
    const approvalQueue = document.getElementById('approvalQueue');
    const recentJobs = document.getElementById('recentJobs');
    const recentEnrollments = document.getElementById('recentEnrollments');
    const categoryFilter = document.getElementById('categoryFilter');
    let reports = [];

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function currency(value) { return '₹' + Number(value || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }); }
    function pct(value, total) { return total > 0 ? Math.round((value / total) * 100) : 0; }
    function tone(index) { return ['bg-[#eaf2ff] text-[#075fe4]', 'bg-[#e8f8ef] text-[#078346]', 'bg-[#fff4df] text-[#b86500]', 'bg-[#f3ecff] text-[#5b20e6]'][index % 4]; }
    const statIcons = {
        'Total Users': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'Active Users': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/><path d="M15 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/></svg>',
        'Revenue': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="M6 13h7a5 5 0 0 0 0-10"/><path d="m6 13 8 8"/></svg>',
        'Certificates': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H7a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z"/><path d="M15 2v6h6"/><path d="M9 12h6"/><path d="M9 15h4"/></svg>',
    };
    function statCard(label, value, index) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone(index)} [&>svg]:h-5 [&>svg]:w-5">${statIcons[label] || statIcons['Total Users']}</span><p class="mt-4 text-xs text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function reportCard(report) {
        return `<div class="rounded-lg border border-[#e4ecf8] p-4">
            <div class="flex items-start justify-between gap-4">
                <div><h3 class="font-bold text-[#061942]">${escapeHtml(report.name)}</h3><p class="mt-1 text-sm text-[#52607a]">${escapeHtml(report.description)}</p></div>
                <span class="rounded-md bg-[#e8f8ef] px-3 py-1 text-xs font-bold text-[#078346]">${escapeHtml(report.status)}</span>
            </div>
            <div class="mt-4 h-2 overflow-hidden rounded-full bg-[#eaf2ff]"><div class="h-full rounded-full bg-[#075fe4]" style="width:${report.percent}%"></div></div>
            <div class="mt-3 flex items-center justify-between text-xs font-bold text-[#52607a]"><span>${escapeHtml(report.metric)}</span><span>${report.percent}%</span></div>
        </div>`;
    }
    function queueItem(title, count, total) {
        const percent = pct(count, total);
        return `<div class="rounded-lg border border-[#e4ecf8] p-4"><div class="flex items-center justify-between"><p class="font-bold text-[#061942]">${escapeHtml(title)}</p><strong class="text-lg text-[#075fe4]">${number(count)}</strong></div><div class="mt-3 h-2 overflow-hidden rounded-full bg-[#eaf2ff]"><div class="h-full rounded-full bg-[#b86500]" style="width:${percent}%"></div></div><p class="mt-2 text-xs font-bold text-[#52607a]">${percent}% pending</p></div>`;
    }
    function listItem(title, meta, value) {
        return `<div class="rounded-lg border border-[#e4ecf8] p-4"><div class="flex items-start justify-between gap-4"><div><p class="font-bold text-[#061942]">${escapeHtml(title)}</p><p class="mt-1 text-xs text-[#52607a]">${escapeHtml(meta)}</p></div><strong class="text-sm text-[#075fe4]">${escapeHtml(value)}</strong></div></div>`;
    }
    function renderReports(category = '') {
        const filtered = category ? reports.filter((report) => report.category === category) : reports;
        reportRows.innerHTML = filtered.length ? filtered.map(reportCard).join('') : '<p class="text-sm text-[#52607a]">No reports found.</p>';
    }
    function renderDashboard(data) {
        const stats = data.statistics || {};
        const totalUsers = Number(stats.total_users || 0);
        const totalProfiles = Number(stats.company_profiles || 0) + Number(stats.training_partner_profiles || 0);

        reportStats.innerHTML = [
            statCard('Total Users', number(stats.total_users), 0),
            statCard('Active Users', number(stats.active_users), 1),
            statCard('Revenue', currency(stats.total_payment_amount), 2),
            statCard('Certificates', number(stats.total_certificates), 3),
        ].join('');

        reports = [
            { category: 'users', name: 'User Growth Report', description: `${number(stats.total_freshers)} freshers, ${number(stats.total_companies)} companies, ${number(stats.total_training_partners)} training partners.`, metric: `${number(stats.active_users)} active users`, percent: pct(stats.active_users, totalUsers), status: 'Live' },
            { category: 'users', name: 'Approval Pipeline', description: 'Company aur training partner approval queue summary.', metric: `${number(Number(stats.pending_companies || 0) + Number(stats.pending_training_partners || 0))} pending approvals`, percent: pct(Number(stats.pending_companies || 0) + Number(stats.pending_training_partners || 0), totalProfiles), status: 'Live' },
            { category: 'jobs', name: 'Hiring Funnel', description: `${number(stats.total_job_applications)} applications, ${number(stats.hired_applications)} hired, ${number(stats.rejected_applications)} rejected.`, metric: `${number(stats.hired_applications)} hired`, percent: pct(stats.hired_applications, stats.total_job_applications), status: 'Live' },
            { category: 'jobs', name: 'Job Activity Report', description: `${number(stats.active_jobs)} active jobs out of ${number(stats.total_jobs)} total jobs.`, metric: `${number(stats.active_jobs)} active`, percent: pct(stats.active_jobs, stats.total_jobs), status: 'Live' },
            { category: 'courses', name: 'Course Performance', description: `${number(stats.active_courses)} active courses and ${number(stats.total_course_enrollments)} total enrollments.`, metric: `${number(stats.completed_enrollments)} completed`, percent: pct(stats.completed_enrollments, stats.total_course_enrollments), status: 'Live' },
            { category: 'finance', name: 'Revenue Summary', description: `${number(stats.successful_payments)} successful payments and ${number(stats.failed_payments)} failed payments.`, metric: currency(stats.total_payment_amount), percent: pct(stats.successful_payments, Number(stats.successful_payments || 0) + Number(stats.failed_payments || 0)), status: 'Live' },
        ];
        renderReports(categoryFilter.value);

        approvalQueue.innerHTML = [
            queueItem('Pending Companies', stats.pending_companies, stats.company_profiles),
            queueItem('Pending Training Partners', stats.pending_training_partners, stats.training_partner_profiles),
        ].join('');

        recentJobs.innerHTML = data.recent_jobs?.length
            ? data.recent_jobs.map((job) => listItem(job.title || 'Job', `${job.company_profile?.company_name || 'Company'} - ${job.location || '-'}`, `${number(job.applications_count)} apps`)).join('')
            : '<p class="text-sm text-[#52607a]">No recent jobs found.</p>';

        recentEnrollments.innerHTML = data.recent_enrollments?.length
            ? data.recent_enrollments.map((item) => listItem(item.fresher_profile?.user?.name || 'Learner', `${item.course?.course_name || 'Course'} - ${formatDate(item.enrollment_date)}`, item.enrollment_status || '-')).join('')
            : '<p class="text-sm text-[#52607a]">No recent enrollments found.</p>';
    }
    async function loadReports() {
        try {
            const response = await fetch('/api/admin/dashboard', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/admin/login'; return; }
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Reports load nahi ho paaye.');
            renderDashboard(payload.data || {});
        } catch (error) {
            reportStats.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-2 xl:col-span-4">' + escapeHtml(error.message || 'Reports load nahi ho paaye.') + '</article>';
            reportRows.innerHTML = '<p class="text-sm text-[#ff1f2f]">Reports data load nahi ho paaya.</p>';
            approvalQueue.innerHTML = '<p class="text-sm text-[#ff1f2f]">Approval queue load nahi ho paayi.</p>';
            recentJobs.innerHTML = '<p class="text-sm text-[#ff1f2f]">Recent jobs load nahi ho paaye.</p>';
            recentEnrollments.innerHTML = '<p class="text-sm text-[#ff1f2f]">Recent enrollments load nahi ho paaye.</p>';
        }
    }
    categoryFilter.addEventListener('change', () => renderReports(categoryFilter.value));
    loadReports();
</script>
@endpush
