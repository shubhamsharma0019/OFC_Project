@extends('layouts.admin')

@section('title', 'Company Details - OnlyFreshers Admin')
@section('pageTitle', 'Company Details')
@section('breadcrumb', 'Companies / Details')

@php
    $activePage = 'companies';
@endphp

@section('topbarExtra')
    <a href="/admin/companies" class="inline-flex h-10 items-center justify-center rounded-md border border-[#dce7f8] px-4 text-sm font-bold text-[#075fe4]">Back</a>
@endsection

@section('content')
    <section class="grid gap-5">
        <div id="detailAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#ff1f2f]"></div>
        <div id="companyDetail" class="grid gap-5"><article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)]">Loading company details...</article></div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const companyId = localStorage.getItem('ofc_selected_admin_company_id');
    const companyDetail = document.getElementById('companyDetail');
    const detailAlert = document.getElementById('detailAlert');

    if (!token) window.location.href = '/admin/login';
    if (!companyId) window.location.href = '/admin/companies';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { if (status === 'approved' || status === 'active' || status === 'hired') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'rejected' || status === 'blocked') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    function field(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><strong class="mt-2 block break-words text-sm text-[#061942]">${escapeHtml(value || '-')}</strong></div>`; }
    function miniStat(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#061942]">${number(value)}</h2></div>`; }
    function listItem(title, meta, status) { return `<div class="grid gap-2 rounded-lg border border-[#edf2fb] p-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center"><div><strong class="block text-sm text-[#061942]">${escapeHtml(title)}</strong><p class="mt-1 text-xs text-[#52607a]">${escapeHtml(meta)}</p></div><span class="w-max rounded-md ${badgeClass(status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(status))}</span></div>`; }
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    function renderCompany(company) {
        const jobs = company.jobs || [];
        const applications = jobs.flatMap((job) => job.applications || []);
        companyDetail.innerHTML = `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between"><div class="flex min-w-0 gap-4"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xl font-black text-[#075fe4]">${escapeHtml((company.company_name || 'C').slice(0, 1).toUpperCase())}</div><div class="min-w-0"><h2 class="text-2xl font-bold text-[#061942]">${escapeHtml(company.company_name || company.user?.name || 'Company')}</h2><p class="mt-1 text-sm text-[#52607a]">${escapeHtml(company.email || company.user?.email || '-')}</p><div class="mt-3 flex flex-wrap gap-2"><span class="rounded-md ${badgeClass(company.approval_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(company.approval_status)}</span><span class="rounded-md ${badgeClass(company.user?.status)} px-3 py-1 text-xs font-bold capitalize">User ${escapeHtml(company.user?.status || '-')}</span></div></div></div>
            <div class="flex flex-wrap gap-2"><button id="approveBtn" class="h-10 rounded-md border border-[#078346] px-4 text-sm font-bold text-[#078346]" type="button">Approve</button><button id="rejectBtn" class="h-10 rounded-md border border-[#ff1f2f] px-4 text-sm font-bold text-[#ff1f2f]" type="button">Reject</button><button id="userStatusBtn" class="h-10 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button" data-status="${company.user?.status === 'active' ? 'blocked' : 'active'}">${company.user?.status === 'active' ? 'Block User' : 'Activate User'}</button></div></div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${miniStat('Jobs', jobs.length)}${miniStat('Applications', applications.length)}${miniStat('Active Jobs', jobs.filter((j) => j.status === 'active').length)}${miniStat('Hired', applications.filter((a) => a.application_status === 'hired').length)}</div>
        </article>
        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Profile</h2><div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${field('Industry', company.industry)}${field('Phone', company.phone || company.user?.mobile)}${field('Website', company.website)}${field('Address', company.address)}${field('Joined', formatDate(company.created_at))}${field('Rejection Reason', company.rejection_reason)}${field('Description', company.description)}</div></article>
        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Jobs</h2><div class="grid gap-3">${jobs.length ? jobs.map((job) => listItem(job.job_title || 'Job', (job.location || '-') + ' - ' + (job.applications_count || 0) + ' applications', job.status)).join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No jobs found.</div>'}</div></article>`;
        document.getElementById('approveBtn').onclick = () => action(`/api/admin/companies/${companyId}/approve`, { method: 'POST' });
        document.getElementById('rejectBtn').onclick = () => { const reason = prompt('Rejection reason?') || 'Rejected by admin.'; action(`/api/admin/companies/${companyId}/reject`, { method: 'POST', body: JSON.stringify({ rejection_reason: reason }) }); };
        document.getElementById('userStatusBtn').onclick = (event) => action(`/api/admin/companies/${companyId}/user-status`, { method: 'PATCH', body: JSON.stringify({ status: event.target.dataset.status }) });
    }
    async function action(url, options) { try { await requestJson(url, options); await loadCompany(); } catch (error) { alert(error.message || 'Action failed.'); } }
    async function loadCompany() {
        try {
            const payload = await requestJson(`/api/admin/companies/${companyId}`);
            if (!payload) return;
            renderCompany(payload.data.company);
        } catch (error) {
            detailAlert.textContent = error.message || 'Company details could not be loaded.';
            detailAlert.classList.remove('hidden');
            companyDetail.innerHTML = '';
        }
    }
    loadCompany();
</script>
@endpush
