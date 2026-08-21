@extends('layouts.admin')

@section('title', 'Assessments - OnlyFreshers Admin')
@section('pageTitle', 'Assessments')
@section('breadcrumb', 'Dashboard > Assessments')

@php
    $activePage = 'assessments';
@endphp

@push('styles')
<style>
    .admin-assessments-page,
    .admin-assessments-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }

    @media (max-width: 640px) {
        .admin-assessments-page {
            gap: 14px;
        }

        .admin-assessments-page #assessmentStats {
            gap: 12px;
        }

        .admin-assessments-page #assessmentStats article {
            padding: 16px !important;
        }

        .admin-assessments-page #assessmentStats h2 {
            font-size: 24px !important;
            line-height: 1.15 !important;
        }

        .admin-assessments-page .admin-assessments-toolbar {
            padding: 14px !important;
        }

        .admin-assessments-page .admin-assessments-filters,
        .admin-assessments-page .admin-assessments-filters select {
            width: 100%;
        }

        .admin-assessments-page .admin-assessments-table-wrap {
            overflow: visible !important;
        }

        .admin-assessments-page table,
        .admin-assessments-page thead,
        .admin-assessments-page tbody,
        .admin-assessments-page tr,
        .admin-assessments-page td {
            display: block;
            width: 100%;
        }

        .admin-assessments-page table {
            min-width: 0 !important;
        }

        .admin-assessments-page thead {
            display: none;
        }

        .admin-assessments-page tbody {
            padding: 10px;
            background: #f7fbff;
        }

        .admin-assessments-page tbody tr {
            border: 1px solid #d9e6f8;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 8px 18px rgba(6, 25, 66, .06);
            overflow: hidden;
        }

        .admin-assessments-page tbody tr + tr {
            margin-top: 10px;
        }

        .admin-assessments-page tbody td {
            display: grid;
            grid-template-columns: minmax(72px, 30%) minmax(0, 1fr);
            gap: 8px;
            align-items: start;
            border-bottom: 0;
            padding: 3px 12px !important;
            color: #1b315b;
            font-size: 10.5px !important;
            line-height: 1.35;
            word-break: break-word;
        }

        .admin-assessments-page tbody td:first-child {
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) auto;
            align-items: center;
            gap: 9px;
            padding-top: 12px !important;
            padding-bottom: 7px !important;
        }

        .admin-assessments-page tbody td::before {
            content: attr(data-label);
            color: #061942;
            font-size: 10px;
            font-weight: 600 !important;
            letter-spacing: 0;
            text-transform: none;
        }

        .admin-assessments-page tbody td:first-child::before {
            display: none;
        }

        .admin-assessments-page .admin-assessment-avatar {
            display: grid;
            width: 28px;
            height: 28px;
            place-items: center;
            border-radius: 999px;
            background: #eef5ff;
            color: #075fe4;
            font-size: 10px;
            font-weight: 600 !important;
            text-transform: uppercase;
        }

        .admin-assessments-page .admin-assessment-title {
            min-width: 0;
        }

        .admin-assessments-page .admin-assessment-title strong {
            overflow: hidden;
            font-size: 12px !important;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-assessments-page .admin-assessment-title span,
        .admin-assessments-page .admin-assessment-muted {
            overflow: hidden;
            color: #52607a;
            font-size: 9px !important;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-assessments-page .admin-assessment-status {
            border-radius: 4px;
            padding: 4px 7px !important;
            font-size: 9px !important;
            line-height: 1;
        }

        .admin-assessments-page tbody td[colspan] {
            display: block;
            padding: 14px !important;
            font-size: 12px !important;
        }

        .admin-assessments-page tbody td[colspan]::before {
            display: none;
        }

        .admin-assessments-page #pagination {
            gap: 10px;
            padding: 12px !important;
        }

        .admin-assessments-page #pagination button {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
    }
</style>
@endpush

@section('topbarExtra')
    <a href="/admin/assessments/create" class="inline-flex h-10 items-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)]">+ Add New</a>
@endsection

@section('content')
    <section class="admin-assessments-page grid gap-5">
        <div id="assessmentStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading assessments...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="admin-assessments-toolbar flex flex-col gap-3 border-b border-[#edf2fb] p-4 xl:flex-row xl:items-center xl:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none xl:max-w-xs" type="search" placeholder="Search learner, course or partner...">
                <div class="admin-assessments-filters grid gap-2 sm:grid-cols-3">
                    <select id="typeFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Types</option><option value="initial">Initial</option><option value="final">Final</option></select>
                    <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Status</option><option value="in_progress">In Progress</option><option value="submitted">Submitted</option></select>
                    <select id="resultFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Results</option><option value="pass">Pass</option><option value="fail">Fail</option></select>
                </div>
            </div>
            <div class="admin-assessments-table-wrap overflow-x-auto">
                <table class="w-full min-w-[1060px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">Learner</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Type</th><th class="px-5 py-4">Score</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Submitted</th></tr>
                    </thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        <tr><td class="px-5 py-5" colspan="6">Loading assessments...</td></tr>
                    </tbody>
                </table>
            </div>
            <div id="pagination" class="hidden items-center justify-between border-t border-[#edf2fb] p-4 text-sm text-[#52607a]">
                <button id="prevPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Previous</button>
                <span id="pageInfo" class="font-bold text-[#061942]"></span>
                <button id="nextPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Next</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const assessmentStats = document.getElementById('assessmentStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const resultFilter = document.getElementById('resultFilter');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let assessments = [];
    let currentPage = 1;
    let lastPage = 1;
    let searchTimer = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function label(value) { return String(value || '-').replaceAll('_', ' '); }
    function initials(name) { return String(name || 'OF').trim().split(/\s+/).slice(0, 2).map((part) => part[0] || '').join('').toUpperCase() || 'OF'; }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }); }
    function badgeClass(status) {
        if (status === 'pass' || status === 'submitted') return 'bg-[#e8f8ef] text-[#078346]';
        if (status === 'fail') return 'bg-[#fff0f1] text-[#ff1f2f]';
        return 'bg-[#fff4df] text-[#b86500]';
    }
    const statIcons = {
        page: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16h16V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8M8 17h5"></path></svg>',
        submitted: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>',
        progress: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>',
        passed: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9z"></path></svg>',
    };
    function statCard(labelText, value, tone) {
        const key = labelText === 'This Page' ? 'page' : (labelText === 'In Progress' ? 'progress' : labelText.toLowerCase());
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[key] || statIcons.page}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(labelText)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function renderStats() {
        assessmentStats.innerHTML = [
            statCard('This Page', number(assessments.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Submitted', number(assessments.filter((item) => item.status === 'submitted').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('In Progress', number(assessments.filter((item) => item.status === 'in_progress').length), 'bg-[#fff4df] text-[#b86500]'),
            statCard('Passed', number(assessments.filter((item) => item.result?.result === 'pass').length), 'bg-[#f3ecff] text-[#5b20e6]'),
        ].join('');
    }
    function renderRows() {
        renderStats();
        if (!assessments.length) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No assessments found.</td></tr>';
            return;
        }
        adminRows.innerHTML = assessments.map((attempt) => {
            const user = attempt.fresher_profile?.user || {};
            const course = attempt.course_enrollment?.course || {};
            const partner = course.training_partner_profile || {};
            const score = attempt.result?.overall_score ?? '-';
            const result = attempt.result?.result || attempt.status;
            return `<tr>
                <td class="px-5 py-4" data-label="Learner"><span class="admin-assessment-avatar">${escapeHtml(initials(user.name))}</span><span class="admin-assessment-title"><strong class="block text-[#061942]">${escapeHtml(user.name || 'Learner')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</span></span><span class="admin-assessment-status rounded-md ${badgeClass(result)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(result))}</span></td>
                <td class="px-5 py-4" data-label="Course"><strong class="block text-[#061942]">${escapeHtml(course.course_name || 'Direct Assessment')}</strong><span class="admin-assessment-muted mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.institute_name || course.category || '-')}</span></td>
                <td class="px-5 py-4 capitalize" data-label="Type">${escapeHtml(label(attempt.assessment_type))}</td>
                <td class="px-5 py-4 font-bold text-[#061942]" data-label="Score">${escapeHtml(score)}${score === '-' ? '' : '/100'}<span class="admin-assessment-muted mt-1 block text-xs font-medium text-[#52607a]">${escapeHtml(attempt.result?.recommended_track || '')}</span></td>
                <td class="px-5 py-4" data-label="Status"><span class="rounded-md ${badgeClass(result)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(result))}</span></td>
                <td class="px-5 py-4" data-label="Submitted">${escapeHtml(formatDate(attempt.submitted_at || attempt.started_at))}</td>
            </tr>`;
        }).join('');
    }
    function setPagination(paginator) {
        currentPage = paginator.current_page || 1;
        lastPage = paginator.last_page || 1;
        pageInfo.textContent = 'Page ' + currentPage + ' of ' + lastPage;
        prevPage.disabled = currentPage <= 1;
        nextPage.disabled = currentPage >= lastPage;
        pagination.classList.toggle('hidden', lastPage <= 1);
        pagination.classList.toggle('flex', lastPage > 1);
    }
    async function requestJson(url) {
        const response = await fetch(url, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadAssessments(page = 1) {
        try {
            const params = new URLSearchParams({ page, per_page: 10 });
            if (adminSearch.value.trim()) params.set('search', adminSearch.value.trim());
            if (typeFilter.value) params.set('assessment_type', typeFilter.value);
            if (statusFilter.value) params.set('status', statusFilter.value);
            if (resultFilter.value) params.set('result', resultFilter.value);
            const payload = await requestJson('/api/admin/assessments?' + params.toString());
            if (!payload) return;
            const paginator = payload.data?.assessments || {};
            assessments = paginator.data || [];
            setPagination(paginator);
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="6">' + escapeHtml(error.message || 'Assessments load nahi ho paaye.') + '</td></tr>';
        }
    }
    adminSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadAssessments(1), 350); });
    [typeFilter, statusFilter, resultFilter].forEach((filter) => filter.addEventListener('change', () => loadAssessments(1)));
    prevPage.addEventListener('click', () => loadAssessments(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadAssessments(Math.min(lastPage, currentPage + 1)));
    loadAssessments();
</script>
@endpush
