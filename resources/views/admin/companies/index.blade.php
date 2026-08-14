@extends('layouts.admin')

@section('title', 'Companies - OnlyFreshers Admin')
@section('pageTitle', 'Companies')
@section('breadcrumb', 'Dashboard > Companies')

@php
    $activePage = 'companies';
@endphp

@push('styles')
<style>
    .admin-companies-page,
    .admin-companies-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-companies-page grid gap-5">
        <div id="companyStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading companies...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search company...">
                <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Approval</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Company</th><th class="px-5 py-4">Industry</th><th class="px-5 py-4">Contact</th><th class="px-5 py-4">Approval</th><th class="px-5 py-4">User</th><th class="px-5 py-4">Actions</th></tr></thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="6">Loading companies...</td></tr></tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const companyStats = document.getElementById('companyStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const statusFilter = document.getElementById('statusFilter');
    let companies = [];

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function badgeClass(status) { if (status === 'approved' || status === 'active') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'rejected' || status === 'blocked') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    const statIcons = {
        total: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16"></path><path d="M15 9h4a1 1 0 0 1 1 1v11"></path><path d="M8 8h3M8 12h3M8 16h3"></path></svg>',
        approved: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>',
        pending: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>',
        blocked: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="m5.7 5.7 12.6 12.6"></path></svg>',
    };
    function statCard(label, value, tone) {
        const key = label === 'Total Companies' ? 'total' : (label === 'Blocked Users' ? 'blocked' : label.toLowerCase());
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[key] || statIcons.total}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function filteredCompanies() {
        const query = adminSearch.value.trim().toLowerCase();
        const status = statusFilter.value;
        return companies.filter((company) => {
            const text = [company.company_name, company.email, company.phone, company.industry, company.user?.email, company.approval_status, company.user?.status].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (!status || company.approval_status === status);
        });
    }
    function renderStats() {
        companyStats.innerHTML = [
            statCard('Total Companies', number(companies.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Approved', number(companies.filter((item) => item.approval_status === 'approved').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Pending', number(companies.filter((item) => item.approval_status === 'pending').length), 'bg-[#fff4df] text-[#b86500]'),
            statCard('Blocked Users', number(companies.filter((item) => item.user?.status === 'blocked').length), 'bg-[#fff0f1] text-[#ff1f2f]'),
        ].join('');
    }
    function renderRows() {
        const rows = filteredCompanies();
        renderStats();
        if (!rows.length) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No companies found.</td></tr>'; return; }
        adminRows.innerHTML = rows.map((company) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(company.company_name || company.user?.name || 'Company')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(company.website || company.address || '-')}</span></td>
            <td class="px-5 py-4">${escapeHtml(company.industry || '-')}</td>
            <td class="px-5 py-4">${escapeHtml(company.email || company.user?.email || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(company.phone || company.user?.mobile || '')}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(company.approval_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(company.approval_status)}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(company.user?.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(company.user?.status || '-')}</span></td>
            <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-company rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${company.id}">View</button><button class="approve-company rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${company.id}">Approve</button><button class="reject-company rounded-md border border-[#ff1f2f] px-3 py-2 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${company.id}">Reject</button><button class="toggle-user rounded-md border border-[#dce7f8] px-3 py-2 text-xs font-bold text-[#24344f]" type="button" data-id="${company.id}" data-status="${company.user?.status === 'active' ? 'blocked' : 'active'}">${company.user?.status === 'active' ? 'Block' : 'Activate'}</button></div></td>
        </tr>`).join('');
    }
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadCompanies() {
        try {
            const payload = await requestJson('/api/admin/companies');
            if (!payload) return;
            companies = payload.data?.companies || [];
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="6">' + escapeHtml(error.message || 'Companies load nahi ho paayi.') + '</td></tr>';
        }
    }
    adminSearch.addEventListener('input', renderRows);
    statusFilter.addEventListener('change', renderRows);
    adminRows.addEventListener('click', async (event) => {
        const view = event.target.closest('.view-company');
        const approve = event.target.closest('.approve-company');
        const reject = event.target.closest('.reject-company');
        const toggle = event.target.closest('.toggle-user');
        const id = view?.dataset.id || approve?.dataset.id || reject?.dataset.id || toggle?.dataset.id;
        if (!id) return;
        if (view) { localStorage.setItem('ofc_selected_admin_company_id', id); window.location.href = '/admin/companies/show'; return; }
        event.target.disabled = true;
        try {
            if (approve) await requestJson(`/api/admin/companies/${id}/approve`, { method: 'POST' });
            if (reject) {
                const reason = prompt('Rejection reason?') || 'Rejected by admin.';
                await requestJson(`/api/admin/companies/${id}/reject`, { method: 'POST', body: JSON.stringify({ rejection_reason: reason }) });
            }
            if (toggle) await requestJson(`/api/admin/companies/${id}/user-status`, { method: 'PATCH', body: JSON.stringify({ status: toggle.dataset.status }) });
            await loadCompanies();
        } catch (error) { alert(error.message || 'Action failed.'); event.target.disabled = false; }
    });
    loadCompanies();
</script>
@endpush
