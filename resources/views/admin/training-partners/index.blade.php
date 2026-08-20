@extends('layouts.admin')

@section('title', 'Training Partners - OnlyFreshers Admin')
@section('pageTitle', 'Training Partners')
@section('breadcrumb', 'Dashboard > Training Partners')

@php
    $activePage = 'training-partners';
@endphp

@push('styles')
<style>
    .admin-training-partners-page,
    .admin-training-partners-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }

    @media (max-width: 767px) {
        .admin-training-partners-table-wrap {
            display: none;
        }

        .admin-training-partner-mobile-list {
            display: grid;
        }
    }

    @media (min-width: 768px) {
        .admin-training-partner-mobile-list {
            display: none;
        }
    }
</style>
@endpush

@section('content')
    <section class="admin-training-partners-page grid gap-5">
        <div id="partnerStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading training partners...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search training partner...">
                <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Approval</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select>
            </div>
            <div class="admin-training-partners-table-wrap overflow-x-auto">
                <table class="w-full min-w-[980px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Institute</th><th class="px-5 py-4">Location</th><th class="px-5 py-4">Contact</th><th class="px-5 py-4">Approval</th><th class="px-5 py-4">User</th><th class="px-5 py-4">Actions</th></tr></thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="6">Loading training partners...</td></tr></tbody>
                </table>
            </div>
            <div id="adminMobileRows" class="admin-training-partner-mobile-list gap-3 p-4">
                <div class="rounded-lg border border-[#edf2fb] p-4 text-sm text-[#52607a]">Loading training partners...</div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const partnerStats = document.getElementById('partnerStats');
    const adminRows = document.getElementById('adminRows');
    const adminMobileRows = document.getElementById('adminMobileRows');
    const adminSearch = document.getElementById('adminSearch');
    const statusFilter = document.getElementById('statusFilter');
    let partners = [];

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function badgeClass(status) { if (status === 'approved' || status === 'active') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'rejected' || status === 'blocked') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    const statIcons = {
        total: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l9-4 9 4-9 4-9-4z"></path><path d="M7 10v5c0 1.5 2.3 3 5 3s5-1.5 5-3v-5"></path></svg>',
        approved: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>',
        pending: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>',
        blocked: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="m5.7 5.7 12.6 12.6"></path></svg>',
    };
    function statCard(label, value, tone) {
        const key = label === 'Total Partners' ? 'total' : (label === 'Blocked Users' ? 'blocked' : label.toLowerCase());
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[key] || statIcons.total}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function filteredPartners() {
        const query = adminSearch.value.trim().toLowerCase();
        const status = statusFilter.value;
        return partners.filter((partner) => {
            const text = [partner.institute_name, partner.email, partner.phone, partner.location, partner.user?.email, partner.approval_status, partner.user?.status].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (!status || partner.approval_status === status);
        });
    }
    function renderStats() {
        partnerStats.innerHTML = [
            statCard('Total Partners', number(partners.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Approved', number(partners.filter((item) => item.approval_status === 'approved').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Pending', number(partners.filter((item) => item.approval_status === 'pending').length), 'bg-[#fff4df] text-[#b86500]'),
            statCard('Blocked Users', number(partners.filter((item) => item.user?.status === 'blocked').length), 'bg-[#fff0f1] text-[#ff1f2f]'),
        ].join('');
    }
    function renderRows() {
        const rows = filteredPartners();
        renderStats();
        if (!rows.length) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No training partners found.</td></tr>';
            adminMobileRows.innerHTML = '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm text-[#52607a]">No training partners found.</div>';
            return;
        }
        adminRows.innerHTML = rows.map((partner) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(partner.institute_name || partner.user?.name || 'Training Partner')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.website || '-')}</span></td>
            <td class="px-5 py-4">${escapeHtml(partner.location || '-')}</td>
            <td class="px-5 py-4">${escapeHtml(partner.email || partner.user?.email || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.phone || partner.user?.mobile || '')}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(partner.approval_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(partner.approval_status)}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(partner.user?.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(partner.user?.status || '-')}</span></td>
            <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-partner rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${partner.id}">View</button><button class="approve-partner rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${partner.id}">Approve</button><button class="reject-partner rounded-md border border-[#ff1f2f] px-3 py-2 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${partner.id}">Reject</button><button class="toggle-user rounded-md border border-[#dce7f8] px-3 py-2 text-xs font-bold text-[#24344f]" type="button" data-id="${partner.id}" data-status="${partner.user?.status === 'active' ? 'blocked' : 'active'}">${partner.user?.status === 'active' ? 'Block' : 'Activate'}</button></div></td>
        </tr>`).join('');
        adminMobileRows.innerHTML = rows.map((partner) => {
            const name = partner.institute_name || partner.user?.name || 'Training Partner';
            const initial = String(name).slice(0, 1).toUpperCase();

            return `<article class="rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_8px_18px_rgba(6,25,66,.04)]">
                <div class="mb-4 flex items-start gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-sm font-bold text-[#075fe4]">${escapeHtml(initial)}</span>
                    <div class="min-w-0 flex-1">
                        <h3 class="break-words text-[15px] font-semibold text-[#061942]">${escapeHtml(name)}</h3>
                        <p class="mt-1 break-all text-xs text-[#52607a]">${escapeHtml(partner.email || partner.user?.email || '-')}</p>
                    </div>
                    <span class="shrink-0 rounded-md ${badgeClass(partner.approval_status)} px-2.5 py-1 text-[11px] font-bold capitalize">${escapeHtml(partner.approval_status)}</span>
                </div>
                <div class="grid gap-2 text-xs text-[#52607a]">
                    <div><span class="font-semibold text-[#061942]">Location:</span> ${escapeHtml(partner.location || '-')}</div>
                    <div><span class="font-semibold text-[#061942]">Phone:</span> ${escapeHtml(partner.phone || partner.user?.mobile || '-')}</div>
                    <div><span class="font-semibold text-[#061942]">Website:</span> ${escapeHtml(partner.website || '-')}</div>
                    <div><span class="font-semibold text-[#061942]">User:</span> <span class="rounded-md ${badgeClass(partner.user?.status)} px-2 py-0.5 text-[11px] font-bold capitalize">${escapeHtml(partner.user?.status || '-')}</span></div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <button class="view-partner h-9 rounded-md border border-[#075fe4] px-3 text-xs font-bold text-[#075fe4]" type="button" data-id="${partner.id}">View</button>
                    <button class="approve-partner h-9 rounded-md border border-[#078346] px-3 text-xs font-bold text-[#078346]" type="button" data-id="${partner.id}">Approve</button>
                    <button class="reject-partner h-9 rounded-md border border-[#ff1f2f] px-3 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${partner.id}">Reject</button>
                    <button class="toggle-user h-9 rounded-md border border-[#dce7f8] px-3 text-xs font-bold text-[#24344f]" type="button" data-id="${partner.id}" data-status="${partner.user?.status === 'active' ? 'blocked' : 'active'}">${partner.user?.status === 'active' ? 'Block' : 'Activate'}</button>
                </div>
            </article>`;
        }).join('');
    }
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadPartners() {
        try {
            const payload = await requestJson('/api/admin/training-partners');
            if (!payload) return;
            partners = payload.data?.training_partners || [];
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="6">' + escapeHtml(error.message || 'Training partners load nahi ho paaye.') + '</td></tr>';
            adminMobileRows.innerHTML = '<div class="rounded-lg border border-[#ffd7d7] p-4 text-sm text-[#ff1f2f]">' + escapeHtml(error.message || 'Training partners load nahi ho paaye.') + '</div>';
        }
    }
    adminSearch.addEventListener('input', renderRows);
    statusFilter.addEventListener('change', renderRows);
    async function handlePartnerAction(event) {
        const view = event.target.closest('.view-partner');
        const approve = event.target.closest('.approve-partner');
        const reject = event.target.closest('.reject-partner');
        const toggle = event.target.closest('.toggle-user');
        const id = view?.dataset.id || approve?.dataset.id || reject?.dataset.id || toggle?.dataset.id;
        if (!id) return;
        if (view) { localStorage.setItem('ofc_selected_admin_training_partner_id', id); window.location.href = '/admin/training-partners/show'; return; }
        event.target.disabled = true;
        try {
            if (approve) await requestJson(`/api/admin/training-partners/${id}/approve`, { method: 'POST' });
            if (reject) {
                const reason = prompt('Rejection reason?') || 'Rejected by admin.';
                await requestJson(`/api/admin/training-partners/${id}/reject`, { method: 'POST', body: JSON.stringify({ rejection_reason: reason }) });
            }
            if (toggle) await requestJson(`/api/admin/training-partners/${id}/user-status`, { method: 'PATCH', body: JSON.stringify({ status: toggle.dataset.status }) });
            await loadPartners();
        } catch (error) { alert(error.message || 'Action failed.'); event.target.disabled = false; }
    }
    adminRows.addEventListener('click', handlePartnerAction);
    adminMobileRows.addEventListener('click', handlePartnerAction);
    loadPartners();
</script>
@endpush
