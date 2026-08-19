@extends('layouts.training-partner')

@section('title', 'Assessments')

@php
    $activePage = 'assessments';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Assessments</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View final assessment attempts and results for your enrolled students.</p>
            </div>
            <a href="/training-partner/training-progress" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Training Progress</a>
        </div>

        <div id="assessmentStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading assessments...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="assessmentSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search student or course...">
                <select id="assessmentFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Results</option><option value="pass">Pass</option><option value="fail">Fail</option><option value="pending">Pending Result</option><option value="in_progress">In Progress</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1060px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Student</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Attempt</th><th class="px-5 py-4">Score</th><th class="px-5 py-4">Result</th><th class="px-5 py-4">Certificate</th><th class="px-5 py-4">Action</th></tr></thead>
                    <tbody id="assessmentTable" class="divide-y divide-[#e7ebf5] text-[#26375f]"><tr><td class="px-5 py-5" colspan="7">Loading assessments...</td></tr></tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const assessmentStats = document.getElementById('assessmentStats');
    const assessmentTable = document.getElementById('assessmentTable');
    const assessmentSearch = document.getElementById('assessmentSearch');
    const assessmentFilter = document.getElementById('assessmentFilter');
    let assessments = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function resultStatus(item) { if (item.status === 'in_progress') return 'in_progress'; return item.result?.result || 'pending'; }
    function badgeClass(status) {
        if (status === 'pass' || status === 'generated') return 'bg-[#e2f9ea] text-[#05843e]';
        if (status === 'fail') return 'bg-[#fff4f4] text-[#b42318]';
        if (status === 'submitted') return 'bg-[#eaf2ff] text-[#075fe4]';
        return 'bg-[#fff0de] text-[#d06d00]';
    }
    function studentName(item) { return item.fresher_profile?.user?.name || 'Fresher #' + (item.fresher_profile?.id || item.id); }
    function studentEmail(item) { return item.fresher_profile?.user?.email || item.fresher_profile?.phone || '-'; }
    function courseName(item) { return item.course_enrollment?.course?.course_name || '-'; }
    function statCard(label, value, icon) { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-[#5b20e6]">${window.trainingPartnerMetricIcon(icon)}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`; }
    function filteredAssessments() {
        const query = assessmentSearch.value.trim().toLowerCase();
        const filter = assessmentFilter.value;
        return assessments.filter((item) => {
            const status = resultStatus(item);
            const text = [studentName(item), studentEmail(item), courseName(item), status, item.status].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (filter === 'all' || status === filter);
        });
    }
    function renderStats() {
        assessmentStats.innerHTML = [
            statCard('Total Attempts', assessments.length, 'TA'),
            statCard('Submitted', assessments.filter((item) => item.status === 'submitted').length, 'SB'),
            statCard('Passed', assessments.filter((item) => item.result?.result === 'pass').length, 'PS'),
            statCard('Pending Result', assessments.filter((item) => !item.result).length, 'PR'),
        ].join('');
    }
    function renderAssessments() {
        const rows = filteredAssessments();
        renderStats();
        if (!rows.length) { assessmentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No assessment records found.</td></tr>'; return; }
        assessmentTable.innerHTML = rows.map((item) => {
            const status = resultStatus(item);
            const cert = item.course_enrollment?.certificate;
            return `<tr>
                <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(studentName(item))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(studentEmail(item))}</span></td>
                <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(courseName(item))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(item.course_enrollment?.course?.training_mode || '')}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(item.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(item.status))}</span><span class="mt-2 block text-xs text-[#526287]">${formatDate(item.submitted_at || item.started_at)}</span></td>
                <td class="px-5 py-4"><strong class="text-[#071544]">${item.result?.overall_score ?? '-'}</strong><span class="text-xs text-[#526287]"> / 100</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(status))}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(cert ? 'generated' : 'pending')} px-3 py-1 text-xs font-bold">${cert ? 'Generated' : 'Pending'}</span></td>
                <td class="px-5 py-4"><button class="view-enrollment rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button" data-id="${item.course_enrollment_id || item.course_enrollment?.id || ''}">Progress</button></td>
            </tr>`;
        }).join('');
    }
    async function loadAssessments() {
        try {
            const response = await fetch('/api/training-partner/assessments', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Assessments load nahi ho paaye.');
            assessments = payload.data?.assessments || [];
            renderAssessments();
        } catch (error) {
            assessmentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Assessments load nahi ho paaye.') + '</td></tr>';
        }
    }
    assessmentSearch.addEventListener('input', renderAssessments);
    assessmentFilter.addEventListener('change', renderAssessments);
    assessmentTable.addEventListener('click', (event) => {
        const button = event.target.closest('.view-enrollment');
        if (!button?.dataset.id) return;
        localStorage.setItem('ofc_selected_training_enrollment_id', button.dataset.id);
        window.location.href = '/training-partner/progress/show';
    });
    loadAssessments();
</script>
@endpush
