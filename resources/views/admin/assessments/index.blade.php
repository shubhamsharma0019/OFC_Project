@extends('layouts.admin')

@section('title', 'Assessments - OnlyFreshers Admin')
@section('pageTitle', 'Assessments')
@section('breadcrumb', 'Dashboard > Assessments')

@php
    $activePage = 'assessments';
@endphp

@section('topbarExtra')
    <a href="/admin/assessments/create" class="inline-flex h-10 items-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)]">+ Add New</a>
@endsection

@section('content')
    <section class="grid gap-5">
        <div id="assessmentStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading assessments...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 xl:flex-row xl:items-center xl:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none xl:max-w-xs" type="search" placeholder="Search learner, course or partner...">
                <div class="grid gap-2 sm:grid-cols-3">
                    <select id="typeFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Types</option><option value="initial">Initial</option><option value="final">Final</option></select>
                    <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Status</option><option value="in_progress">In Progress</option><option value="submitted">Submitted</option></select>
                    <select id="resultFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Results</option><option value="pass">Pass</option><option value="fail">Fail</option></select>
                </div>
            </div>
            <div class="overflow-x-auto">
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
    function statCard(labelText, value, tone) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-xs font-black ${tone}">${escapeHtml(labelText.slice(0, 2).toUpperCase())}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(labelText)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
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
                <td class="px-5 py-4"><div class="flex items-center gap-3"><span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-sm font-black text-[#075fe4]">${escapeHtml(initials(user.name))}</span><div><strong class="block text-[#061942]">${escapeHtml(user.name || 'Learner')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</span></div></div></td>
                <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(course.course_name || 'Direct Assessment')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.institute_name || course.category || '-')}</span></td>
                <td class="px-5 py-4 capitalize">${escapeHtml(label(attempt.assessment_type))}</td>
                <td class="px-5 py-4 font-bold text-[#061942]">${escapeHtml(score)}${score === '-' ? '' : '/100'}<span class="mt-1 block text-xs font-medium text-[#52607a]">${escapeHtml(attempt.result?.recommended_track || '')}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(result)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(result))}</span></td>
                <td class="px-5 py-4">${escapeHtml(formatDate(attempt.submitted_at || attempt.started_at))}</td>
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
