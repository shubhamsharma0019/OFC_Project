@extends('layouts.admin')

@section('title', 'Admin Dashboard - OnlyFreshers')
@section('pageTitle', 'Dashboard')
@section('breadcrumb', 'Overview')

@php
    $activePage = 'dashboard';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="dashboardStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading dashboard...</article>
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.35fr_.95fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-[#061942]">Platform Overview</h2>
                    <span id="totalRevenue" class="text-sm font-bold text-[#075fe4]">Rs. 0 Revenue</span>
                </div>
                <div id="platformOverview" class="grid min-h-64 items-end gap-3 rounded-lg bg-[#f8fbff] p-5 sm:grid-cols-6">
                    <div class="text-sm text-[#52607a] sm:col-span-6">Loading overview...</div>
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#061942]">Approval Queue</h2>
                <div id="approvalQueue" class="grid gap-3">
                    <div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">Loading approvals...</div>
                </div>
            </article>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 class="text-lg font-bold text-[#061942]">Recent Activity</h2>
                    <a href="/admin/notifications" class="text-xs font-bold text-[#075fe4]">View Notifications</a>
                </div>
                <div id="recentActivity" class="grid gap-3">
                    <div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">Loading activity...</div>
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#061942]">Recent Enrollments</h2>
                <div id="recentEnrollments" class="grid gap-3">
                    <div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">Loading enrollments...</div>
                </div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const dashboardStats = document.getElementById('dashboardStats');
    const platformOverview = document.getElementById('platformOverview');
    const approvalQueue = document.getElementById('approvalQueue');
    const recentActivity = document.getElementById('recentActivity');
    const recentEnrollments = document.getElementById('recentEnrollments');
    const totalRevenue = document.getElementById('totalRevenue');

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function money(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function timeAgo(dateValue) {
        if (!dateValue) return '';
        const diff = Date.now() - new Date(dateValue).getTime();
        const days = Math.floor(diff / 86400000);
        if (days <= 0) return 'Today';
        if (days === 1) return '1 day ago';
        return days + ' days ago';
    }
    function statCard(label, value, tone, hint = '') {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-lg text-xs font-black ${tone}">${escapeHtml(label.slice(0, 2).toUpperCase())}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2>${hint ? `<p class="mt-2 text-xs font-bold text-[#078346]">${escapeHtml(hint)}</p>` : ''}</article>`;
    }
    function itemCard(title, meta, status = '', url = '') {
        const content = `<div class="min-w-0"><h3 class="truncate text-sm font-bold text-[#061942]">${escapeHtml(title)}</h3><p class="mt-1 text-xs text-[#52607a]">${escapeHtml(meta)}</p></div>${status ? `<span class="shrink-0 rounded-md bg-[#eaf2ff] px-2.5 py-1 text-[11px] font-bold capitalize text-[#075fe4]">${escapeHtml(statusText(status))}</span>` : ''}`;
        const cls = 'grid grid-cols-[minmax(0,1fr)_auto] items-center gap-3 rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#24344f]';
        return url ? `<a href="${url}" class="${cls} no-underline">${content}</a>` : `<div class="${cls}">${content}</div>`;
    }
    function renderStats(stats) {
        dashboardStats.innerHTML = [
            statCard('Freshers', number(stats.total_freshers), 'bg-[#eaf2ff] text-[#075fe4]', number(stats.active_users) + ' active users'),
            statCard('Companies', number(stats.total_companies), 'bg-[#e8f8ef] text-[#078346]', number(stats.pending_companies) + ' pending'),
            statCard('Jobs Posted', number(stats.total_jobs), 'bg-[#fff4df] text-[#b86500]', number(stats.active_jobs) + ' active'),
            statCard('Training Partners', number(stats.total_training_partners), 'bg-[#f3ecff] text-[#5b20e6]', number(stats.pending_training_partners) + ' pending'),
        ].join('');
    }
    function renderOverview(stats) {
        const rows = [
            ['Users', stats.total_users],
            ['Jobs', stats.total_jobs],
            ['Courses', stats.total_courses],
            ['Applications', stats.total_job_applications],
            ['Enrollments', stats.total_course_enrollments],
            ['Certificates', stats.total_certificates],
        ];
        const max = Math.max(1, ...rows.map((row) => Number(row[1] || 0)));
        totalRevenue.textContent = money(stats.total_payment_amount) + ' Revenue';
        platformOverview.innerHTML = rows.map(([label, value]) => {
            const height = Math.max(10, Math.round((Number(value || 0) / max) * 100));
            return `<div class="grid h-full min-h-[210px] grid-rows-[1fr_auto_auto] gap-2"><div class="flex items-end"><div class="w-full rounded-t-md bg-[#075fe4]" style="height:${height}%"></div></div><strong class="text-center text-sm text-[#061942]">${number(value)}</strong><span class="text-center text-[11px] font-bold text-[#52607a]">${escapeHtml(label)}</span></div>`;
        }).join('');
    }
    function renderApprovals(stats) {
        approvalQueue.innerHTML = [
            itemCard('Pending Companies', number(stats.pending_companies) + ' company profiles waiting', 'pending', '/admin/companies'),
            itemCard('Pending Training Partners', number(stats.pending_training_partners) + ' partner profiles waiting', 'pending', '/admin/training-partners'),
            itemCard('Rejected Companies', number(stats.rejected_companies) + ' rejected profiles', 'rejected', '/admin/companies'),
            itemCard('Rejected Training Partners', number(stats.rejected_training_partners) + ' rejected profiles', 'rejected', '/admin/training-partners'),
        ].join('');
    }
    function renderActivity(data) {
        const companies = data.recent_companies || [];
        const partners = data.recent_training_partners || [];
        const jobs = data.recent_jobs || [];
        const rows = [
            ...companies.map((item) => itemCard(item.company_name || item.user?.name || 'Company', 'Company profile - ' + timeAgo(item.created_at), item.approval_status, '/admin/companies/show')),
            ...partners.map((item) => itemCard(item.institute_name || item.user?.name || 'Training Partner', 'Training partner - ' + timeAgo(item.created_at), item.approval_status, '/admin/training-partners/show')),
            ...jobs.map((item) => itemCard(item.job_title || 'Job', (item.company_profile?.company_name || 'Company') + ' - ' + (item.applications_count || 0) + ' applications', item.status, '/admin/jobs/show')),
        ].slice(0, 7);
        recentActivity.innerHTML = rows.length ? rows.join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No recent activity found.</div>';
    }
    function renderEnrollments(rows) {
        recentEnrollments.innerHTML = rows.length ? rows.map((item) => itemCard(
            item.fresher_profile?.user?.name || 'Fresher',
            (item.course?.course_name || 'Course') + ' - ' + timeAgo(item.enrollment_date),
            item.enrollment_status,
            '/admin/enrollments/show'
        )).join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No enrollments found.</div>';
    }
    async function loadDashboard() {
        try {
            const response = await fetch('/api/admin/dashboard', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/admin/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { throw new Error(payload.message || 'Admin access required.'); }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Dashboard load nahi ho paaya.');
            const data = payload.data || {};
            const stats = data.statistics || {};
            renderStats(stats);
            renderOverview(stats);
            renderApprovals(stats);
            renderActivity(data);
            renderEnrollments(data.recent_enrollments || []);
        } catch (error) {
            dashboardStats.innerHTML = '<article class="rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-2 xl:col-span-4">' + escapeHtml(error.message || 'Dashboard load nahi ho paaya.') + '</article>';
        }
    }
    loadDashboard();
</script>
@endpush
