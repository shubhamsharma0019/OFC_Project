@extends('layouts.admin')

@section('title', 'Applications - OnlyFreshers Admin')
@section('pageTitle', 'Applications')
@section('breadcrumb', 'Dashboard > Applications')

@php
    $activePage = 'applications';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="applicationStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading applications...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 lg:flex-row lg:items-center lg:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none lg:max-w-xs" type="search" placeholder="Search candidate, job or company...">
                <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]">
                    <option value="">All Status</option>
                    <option value="applied">Applied</option>
                    <option value="under_review">Under Review</option>
                    <option value="shortlisted">Shortlisted</option>
                    <option value="interview_scheduled">Interview Scheduled</option>
                    <option value="hired">Hired</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1040px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">Candidate</th><th class="px-5 py-4">Job</th><th class="px-5 py-4">Company</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Applied</th><th class="px-5 py-4">Action</th></tr>
                    </thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        <tr><td class="px-5 py-5" colspan="6">Loading applications...</td></tr>
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
    const applicationStats = document.getElementById('applicationStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const statusFilter = document.getElementById('statusFilter');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let applications = [];
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
        if (status === 'hired' || status === 'shortlisted') return 'bg-[#e8f8ef] text-[#078346]';
        if (status === 'rejected') return 'bg-[#fff0f1] text-[#ff1f2f]';
        if (status === 'interview_scheduled') return 'bg-[#eaf2ff] text-[#075fe4]';
        return 'bg-[#fff4df] text-[#b86500]';
    }
    function statCard(labelText, value, tone) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-xs font-black ${tone}">${escapeHtml(labelText.slice(0, 2).toUpperCase())}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(labelText)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function renderStats() {
        applicationStats.innerHTML = [
            statCard('This Page', number(applications.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Shortlisted', number(applications.filter((item) => item.application_status === 'shortlisted').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Interviews', number(applications.filter((item) => item.interview || item.application_status === 'interview_scheduled').length), 'bg-[#f2e9ff] text-[#6f34ff]'),
            statCard('Hired', number(applications.filter((item) => item.application_status === 'hired').length), 'bg-[#e8f8ef] text-[#078346]'),
        ].join('');
    }
    function renderRows() {
        renderStats();
        if (!applications.length) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No applications found.</td></tr>';
            return;
        }
        adminRows.innerHTML = applications.map((application) => {
            const user = application.fresher_profile?.user || {};
            const job = application.job || {};
            const company = job.company_profile || {};
            return `<tr>
                <td class="px-5 py-4"><div class="flex items-center gap-3"><span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-sm font-black text-[#075fe4]">${escapeHtml(initials(user.name))}</span><div><strong class="block text-[#061942]">${escapeHtml(user.name || 'Candidate')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</span></div></div></td>
                <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(job.title || '-')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(job.location || '-')}</span></td>
                <td class="px-5 py-4">${escapeHtml(company.company_name || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(company.user?.email || '')}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(application.application_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(application.application_status))}</span></td>
                <td class="px-5 py-4">${escapeHtml(formatDate(application.applied_at || application.created_at))}</td>
                <td class="px-5 py-4"><button class="view-application rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${application.id}">View</button></td>
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
    async function loadApplications(page = 1) {
        try {
            const params = new URLSearchParams({ page, per_page: 10 });
            if (adminSearch.value.trim()) params.set('search', adminSearch.value.trim());
            if (statusFilter.value) params.set('application_status', statusFilter.value);
            const payload = await requestJson('/api/admin/applications?' + params.toString());
            if (!payload) return;
            const paginator = payload.data?.applications || {};
            applications = paginator.data || [];
            setPagination(paginator);
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="6">' + escapeHtml(error.message || 'Applications load nahi ho paayi.') + '</td></tr>';
        }
    }
    adminSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadApplications(1), 350); });
    statusFilter.addEventListener('change', () => loadApplications(1));
    prevPage.addEventListener('click', () => loadApplications(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadApplications(Math.min(lastPage, currentPage + 1)));
    adminRows.addEventListener('click', (event) => {
        const view = event.target.closest('.view-application');
        if (!view?.dataset.id) return;
        localStorage.setItem('ofc_selected_admin_application_id', view.dataset.id);
        window.location.href = '/admin/applications/show';
    });
    loadApplications();
</script>
@endpush
