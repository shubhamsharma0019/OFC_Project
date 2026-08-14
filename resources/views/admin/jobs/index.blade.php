@extends('layouts.admin')

@section('title', 'Jobs - OnlyFreshers Admin')
@section('pageTitle', 'Jobs')
@section('breadcrumb', 'Dashboard > Jobs')

@php
    $activePage = 'jobs';
@endphp

@push('styles')
<style>
    .admin-jobs-page,
    .admin-jobs-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-jobs-page grid gap-5">
        <div id="jobStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading jobs...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 lg:flex-row lg:items-center lg:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none lg:max-w-xs" type="search" placeholder="Search job...">
                <div class="flex flex-col gap-2 sm:flex-row">
                    <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Status</option><option value="draft">Draft</option><option value="active">Active</option><option value="inactive">Inactive</option><option value="removed">Removed</option></select>
                    <select id="modeFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Modes</option><option value="direct">Direct</option><option value="fast_track">Fast Track</option></select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1040px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Job</th><th class="px-5 py-4">Company</th><th class="px-5 py-4">Type</th><th class="px-5 py-4">Mode</th><th class="px-5 py-4">Applications</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr></thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="7">Loading jobs...</td></tr></tbody>
                </table>
            </div>
            <div id="pagination" class="hidden items-center justify-between border-t border-[#edf2fb] p-4 text-sm text-[#52607a]"><button id="prevPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Previous</button><span id="pageInfo" class="font-bold text-[#061942]"></span><button id="nextPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Next</button></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const jobStats = document.getElementById('jobStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const statusFilter = document.getElementById('statusFilter');
    const modeFilter = document.getElementById('modeFilter');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let jobs = [];
    let currentPage = 1;
    let lastPage = 1;
    let searchTimer = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { if (status === 'active') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'removed') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    const statIcons = {
        page: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16h16V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8M8 17h5"></path></svg>',
        active: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5h6v2M4 12h16"></path><path d="m15 16 2 2 4-5"></path></svg>',
        draft: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>',
        removed: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 15H6L5 6"></path><path d="M10 11v6M14 11v6"></path></svg>',
    };
    function statCard(label, value, tone) {
        const key = label === 'This Page' ? 'page' : label.toLowerCase();
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[key] || statIcons.page}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function renderStats() {
        jobStats.innerHTML = [
            statCard('This Page', number(jobs.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Active', number(jobs.filter((item) => item.status === 'active').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Draft', number(jobs.filter((item) => item.status === 'draft').length), 'bg-[#fff4df] text-[#b86500]'),
            statCard('Removed', number(jobs.filter((item) => item.status === 'removed').length), 'bg-[#fff0f1] text-[#ff1f2f]'),
        ].join('');
    }
    function renderRows() {
        renderStats();
        if (!jobs.length) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="7">No jobs found.</td></tr>'; return; }
        adminRows.innerHTML = jobs.map((job) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(job.title)}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(job.location || '-')} - Last ${escapeHtml(job.application_last_date || '-')}</span></td>
            <td class="px-5 py-4">${escapeHtml(job.company_profile?.company_name || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(job.company_profile?.user?.email || '')}</span></td>
            <td class="px-5 py-4 capitalize">${escapeHtml(statusText(job.job_type))}<span class="mt-1 block text-xs text-[#52607a]">${number(job.openings)} openings</span></td>
            <td class="px-5 py-4 capitalize">${escapeHtml(statusText(job.hiring_mode))}</td>
            <td class="px-5 py-4 font-bold text-[#061942]">${number(job.applications_count)}</td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(job.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(job.status))}</span></td>
            <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-job rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${job.id}">View</button><button class="status-job rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${job.id}" data-status="active">Activate</button><button class="status-job rounded-md border border-[#ff1f2f] px-3 py-2 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${job.id}" data-status="removed">Remove</button></div></td>
        </tr>`).join('');
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
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadJobs(page = 1) {
        try {
            const params = new URLSearchParams({ page, per_page: 10 });
            if (adminSearch.value.trim()) params.set('search', adminSearch.value.trim());
            if (statusFilter.value) params.set('status', statusFilter.value);
            if (modeFilter.value) params.set('hiring_mode', modeFilter.value);
            const payload = await requestJson('/api/admin/jobs?' + params.toString());
            if (!payload) return;
            const paginator = payload.data?.jobs || {};
            jobs = paginator.data || [];
            setPagination(paginator);
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="7">' + escapeHtml(error.message || 'Jobs load nahi ho paaye.') + '</td></tr>';
        }
    }
    adminSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadJobs(1), 350); });
    statusFilter.addEventListener('change', () => loadJobs(1));
    modeFilter.addEventListener('change', () => loadJobs(1));
    prevPage.addEventListener('click', () => loadJobs(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadJobs(Math.min(lastPage, currentPage + 1)));
    adminRows.addEventListener('click', async (event) => {
        const view = event.target.closest('.view-job');
        const status = event.target.closest('.status-job');
        if (view?.dataset.id) { localStorage.setItem('ofc_selected_admin_job_id', view.dataset.id); window.location.href = '/admin/jobs/show'; return; }
        if (!status?.dataset.id) return;
        status.disabled = true;
        try { await requestJson(`/api/admin/jobs/${status.dataset.id}/status`, { method: 'PATCH', body: JSON.stringify({ status: status.dataset.status }) }); await loadJobs(currentPage); } catch (error) { alert(error.message || 'Status update nahi ho paaya.'); status.disabled = false; }
    });
    loadJobs();
</script>
@endpush
