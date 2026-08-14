@extends('layouts.admin')

@section('title', 'Admin Dashboard - OnlyFreshers')
@section('pageTitle', 'Dashboard')
@section('breadcrumb', 'Overview')

@php
    $activePage = 'dashboard';
@endphp

@push('styles')
<style>
    .admin-dashboard-page,
    .admin-dashboard-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-dashboard-page grid gap-6">
        <div id="dashboardStats" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-[#dce7f8] bg-white p-6 text-sm text-[#52607a] shadow-[0_18px_38px_rgba(6,25,66,.06)] sm:col-span-2 xl:col-span-4">Loading dashboard...</article>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.35fr_.95fr]">
            <article class="overflow-hidden rounded-2xl border border-[#dce7f8] bg-white shadow-[0_18px_42px_rgba(6,25,66,.07)]">
                <div class="flex flex-col gap-2 border-b border-[#edf3fb] bg-[linear-gradient(135deg,#ffffff,#f7fbff)] px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-[#061942]">Platform Overview</h2>
                        <p class="mt-1 text-xs font-semibold text-[#52607a]">Live platform metrics at a glance</p>
                    </div>
                    <span id="totalRevenue" class="inline-flex h-9 items-center rounded-full bg-[#eaf2ff] px-4 text-sm font-bold text-[#075fe4]">Rs. 0 Revenue</span>
                </div>
                <div id="platformOverview" class="grid min-h-72 items-end gap-4 bg-[#fbfdff] p-6 sm:grid-cols-6">
                    <div class="text-sm text-[#52607a] sm:col-span-6">Loading overview...</div>
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-[#dce7f8] bg-white shadow-[0_18px_42px_rgba(6,25,66,.07)]">
                <div class="border-b border-[#edf3fb] bg-[linear-gradient(135deg,#ffffff,#f7fbff)] px-6 py-5">
                    <h2 class="text-xl font-bold text-[#061942]">Approval Queue</h2>
                    <p class="mt-1 text-xs font-semibold text-[#52607a]">Profiles that need admin action</p>
                </div>
                <div id="approvalQueue" class="grid gap-3 p-6">
                    <div class="rounded-xl border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">Loading approvals...</div>
                </div>
            </article>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <article class="overflow-hidden rounded-2xl border border-[#dce7f8] bg-white shadow-[0_18px_42px_rgba(6,25,66,.07)]">
                <div class="flex items-center justify-between gap-3 border-b border-[#edf3fb] bg-[linear-gradient(135deg,#ffffff,#f7fbff)] px-6 py-5">
                    <div>
                        <h2 class="text-xl font-bold text-[#061942]">Recent Activity</h2>
                        <p class="mt-1 text-xs font-semibold text-[#52607a]">Latest companies, partners and jobs</p>
                    </div>
                    <a href="/admin/notifications" class="inline-flex h-9 items-center rounded-full bg-[#eaf2ff] px-4 text-xs font-bold text-[#075fe4]">View Notifications</a>
                </div>
                <div id="recentActivity" class="grid gap-3 p-6">
                    <div class="rounded-xl border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">Loading activity...</div>
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-[#dce7f8] bg-white shadow-[0_18px_42px_rgba(6,25,66,.07)]">
                <div class="border-b border-[#edf3fb] bg-[linear-gradient(135deg,#ffffff,#f7fbff)] px-6 py-5">
                    <h2 class="text-xl font-bold text-[#061942]">Recent Enrollments</h2>
                    <p class="mt-1 text-xs font-semibold text-[#52607a]">Fresh course enrollment activity</p>
                </div>
                <div id="recentEnrollments" class="grid gap-3 p-6">
                    <div class="rounded-xl border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">Loading enrollments...</div>
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
    const statIcons = {
        freshers: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><circle cx="17" cy="9" r="2.5"></circle><path d="M14 19c0-2.4 1.8-4 4-4"></path></svg>',
        companies: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16"></path><path d="M15 9h4a1 1 0 0 1 1 1v11"></path><path d="M8 8h3M8 12h3M8 16h3"></path></svg>',
        jobs: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5h6v2M4 12h16"></path></svg>',
        training: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l9-4 9 4-9 4-9-4z"></path><path d="M7 10v5c0 1.5 2.3 3 5 3s5-1.5 5-3v-5"></path></svg>',
    };
    function statCard(label, value, tone, hint = '') {
        const key = label === 'Jobs Posted' ? 'jobs' : (label === 'Training Partners' ? 'training' : label.toLowerCase());
        const icon = statIcons[key] || statIcons.freshers;
        return `<article class="group relative overflow-hidden rounded-2xl border border-[#dce7f8] bg-white p-6 shadow-[0_18px_38px_rgba(6,25,66,.06)] transition hover:-translate-y-0.5 hover:shadow-[0_24px_48px_rgba(6,25,66,.1)]">
            <span class="pointer-events-none absolute -right-10 -top-10 h-28 w-28 rounded-full bg-[#eaf2ff]/70 blur-2xl"></span>
            <div class="relative flex items-start justify-between gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl shadow-[inset_0_0_0_1px_rgba(255,255,255,.72)] [&>svg]:h-6 [&>svg]:w-6 ${tone}">${icon}</span>
                ${hint ? `<span class="rounded-full bg-[#ecfdf3] px-3 py-1 text-[11px] font-bold text-[#078346]">${escapeHtml(hint)}</span>` : ''}
            </div>
            <p class="relative mt-5 text-xs font-bold uppercase tracking-[.04em] text-[#52607a]">${escapeHtml(label)}</p>
            <h2 class="relative mt-2 text-4xl font-black leading-none text-[#061942]">${escapeHtml(value)}</h2>
        </article>`;
    }
    function itemCard(title, meta, status = '', url = '') {
        const statusTone = String(status).toLowerCase().includes('reject') ? 'bg-[#fff1f2] text-[#c8102e]' : 'bg-[#eaf2ff] text-[#075fe4]';
        const content = `<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eff5ff] text-xs font-black text-[#075fe4]">${escapeHtml(title.slice(0, 2).toUpperCase())}</span><div class="min-w-0"><h3 class="truncate text-sm font-bold text-[#061942]">${escapeHtml(title)}</h3><p class="mt-1 text-xs font-semibold text-[#52607a]">${escapeHtml(meta)}</p></div>${status ? `<span class="shrink-0 rounded-full px-3 py-1 text-[11px] font-bold capitalize ${statusTone}">${escapeHtml(statusText(status))}</span>` : ''}`;
        const cls = 'grid grid-cols-[auto_minmax(0,1fr)_auto] items-center gap-3 rounded-xl border border-[#edf2fb] bg-white p-4 text-sm font-semibold text-[#24344f] shadow-[0_8px_20px_rgba(6,25,66,.035)] transition hover:border-[#bfd4f5] hover:bg-[#fbfdff]';
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
            return `<div class="grid h-full min-h-[220px] grid-rows-[1fr_auto_auto] gap-2">
                <div class="flex items-end rounded-xl bg-[#eef5ff] px-3 pt-4">
                    <div class="w-full rounded-t-xl bg-[linear-gradient(180deg,#1d72f3,#075fe4)] shadow-[0_10px_20px_rgba(7,95,228,.18)]" style="height:${height}%"></div>
                </div>
                <strong class="text-center text-base text-[#061942]">${number(value)}</strong>
                <span class="text-center text-[11px] font-bold text-[#52607a]">${escapeHtml(label)}</span>
            </div>`;
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
