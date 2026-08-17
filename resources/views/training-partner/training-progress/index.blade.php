@extends('layouts.training-partner')

@section('title', 'Training Progress')

@php
    $activePage = 'progress';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Training Progress</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Track overall learning progress across courses and students.</p>
            </div>
            <a href="/training-partner/enrollments" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Enrollments</a>
        </div>

        <div id="progressStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading progress...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="progressSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search student or course...">
                <select id="progressFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Progress</option><option value="not_started">Not Started</option><option value="in_progress">In Progress</option><option value="completed">Completed</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Student</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Training Status</th><th class="px-5 py-4">Progress</th><th class="px-5 py-4">Remark</th><th class="px-5 py-4">Updated</th><th class="px-5 py-4">Action</th></tr></thead>
                    <tbody id="progressTable" class="divide-y divide-[#e7ebf5] text-[#26375f]"><tr><td class="px-5 py-5" colspan="7">Loading progress...</td></tr></tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token')
        || localStorage.getItem('onlyfreshers_token')
        || localStorage.getItem('training_partner_token')
        || localStorage.getItem('auth_token')
        || localStorage.getItem('token');
    const progressStats = document.getElementById('progressStats');
    const progressTable = document.getElementById('progressTable');
    const progressSearch = document.getElementById('progressSearch');
    const progressFilter = document.getElementById('progressFilter');
    let enrollments = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function badgeClass(status) { if (status === 'completed') return 'bg-[#e2f9ea] text-[#05843e]'; if (status === 'in_progress') return 'bg-[#eaf2ff] text-[#075fe4]'; return 'bg-[#fff0de] text-[#d06d00]'; }
    function studentName(item) { return item.fresher_profile?.user?.name || 'Fresher #' + (item.fresher_profile?.id || item.id); }
    function studentEmail(item) { return item.fresher_profile?.user?.email || item.fresher_profile?.phone || '-'; }
    function progressPercent(item) { return item.training_progress?.progress_percentage ?? (item.training_status === 'completed' ? 100 : 0); }
    function statCard(label, value, icon) { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">${icon}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`; }
    function filteredRows() {
        const query = progressSearch.value.trim().toLowerCase();
        const status = progressFilter.value;
        return enrollments.filter((item) => {
            const text = [studentName(item), studentEmail(item), item.course?.course_name, item.training_status, item.training_progress?.short_remark].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (status === 'all' || item.training_status === status);
        });
    }
    function renderStats() {
        const totalProgress = enrollments.reduce((sum, item) => sum + progressPercent(item), 0);
        progressStats.innerHTML = [
            statCard('Total Students', enrollments.length, 'TS'),
            statCard('In Progress', enrollments.filter((item) => item.training_status === 'in_progress').length, 'IP'),
            statCard('Completed', enrollments.filter((item) => item.training_status === 'completed').length, 'CP'),
            statCard('Average Progress', enrollments.length ? Math.round(totalProgress / enrollments.length) + '%' : '0%', 'AP'),
        ].join('');
    }
    function renderRows() {
        const rows = filteredRows();
        renderStats();
        if (!rows.length) { progressTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No progress records found.</td></tr>'; return; }
        progressTable.innerHTML = rows.map((item) => {
            const progress = progressPercent(item);
            return `<tr>
                <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(studentName(item))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(studentEmail(item))}</span></td>
                <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(item.course?.course_name || '-')}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(item.course?.training_mode || '')}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(item.training_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(item.training_status))}</span></td>
                <td class="px-5 py-4"><div class="mb-1 text-xs font-bold text-[#071544]">${progress}%</div><div class="h-2 w-32 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${progress}%"></div></div></td>
                <td class="max-w-[260px] px-5 py-4 text-xs text-[#526287]">${escapeHtml(item.training_progress?.short_remark || '-')}</td>
                <td class="px-5 py-4 text-xs text-[#526287]">${formatDate(item.training_progress?.updated_at || item.updated_at)}</td>
                <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-progress rounded-md border border-[#cfd8eb] px-3 py-2 text-xs font-bold text-[#26375f]" type="button" data-id="${item.id}">View</button><button class="edit-progress rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button" data-id="${item.id}">Edit</button></div></td>
            </tr>`;
        }).join('');
    }
    async function loadProgress() {
        try {
            const response = await fetch('/api/training-partner/enrollments', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Training progress load nahi ho paaya.');
            enrollments = payload.data?.enrollments || [];
            renderRows();
        } catch (error) {
            progressTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Training progress load nahi ho paaya.') + '</td></tr>';
        }
    }
    progressSearch.addEventListener('input', renderRows);
    progressFilter.addEventListener('change', renderRows);
    progressTable.addEventListener('click', (event) => {
        const view = event.target.closest('.view-progress');
        const edit = event.target.closest('.edit-progress');
        const id = view?.dataset.id || edit?.dataset.id;
        if (!id) return;
        localStorage.setItem('ofc_selected_training_enrollment_id', id);
        window.location.href = view ? '/training-partner/progress/show' : '/training-partner/progress/edit';
    });
    loadProgress();
</script>
@endpush
