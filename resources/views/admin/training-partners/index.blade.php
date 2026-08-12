@extends('layouts.admin')

@section('title', 'Training Partners - OnlyFreshers Admin')
@section('pageTitle', 'Training Partners')
@section('breadcrumb', 'Dashboard > Training Partners')

@php
    $activePage = 'training-partners';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="partnerStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading training partners...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search training partner...">
                <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Approval</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Institute</th><th class="px-5 py-4">Location</th><th class="px-5 py-4">Contact</th><th class="px-5 py-4">Approval</th><th class="px-5 py-4">User</th><th class="px-5 py-4">Actions</th></tr></thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="6">Loading training partners...</td></tr></tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const partnerStats = document.getElementById('partnerStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const statusFilter = document.getElementById('statusFilter');
    let partners = [];

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function badgeClass(status) { if (status === 'approved' || status === 'active') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'rejected' || status === 'blocked') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    function statCard(label, value, tone) { return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-xs font-black ${tone}">${escapeHtml(label.slice(0, 2).toUpperCase())}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`; }
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
        if (!rows.length) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No training partners found.</td></tr>'; return; }
        adminRows.innerHTML = rows.map((partner) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(partner.institute_name || partner.user?.name || 'Training Partner')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.website || '-')}</span></td>
            <td class="px-5 py-4">${escapeHtml(partner.location || '-')}</td>
            <td class="px-5 py-4">${escapeHtml(partner.email || partner.user?.email || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.phone || partner.user?.mobile || '')}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(partner.approval_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(partner.approval_status)}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(partner.user?.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(partner.user?.status || '-')}</span></td>
            <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-partner rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${partner.id}">View</button><button class="approve-partner rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${partner.id}">Approve</button><button class="reject-partner rounded-md border border-[#ff1f2f] px-3 py-2 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${partner.id}">Reject</button><button class="toggle-user rounded-md border border-[#dce7f8] px-3 py-2 text-xs font-bold text-[#24344f]" type="button" data-id="${partner.id}" data-status="${partner.user?.status === 'active' ? 'blocked' : 'active'}">${partner.user?.status === 'active' ? 'Block' : 'Activate'}</button></div></td>
        </tr>`).join('');
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
        }
    }
    adminSearch.addEventListener('input', renderRows);
    statusFilter.addEventListener('change', renderRows);
    adminRows.addEventListener('click', async (event) => {
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
    });
    loadPartners();
</script>
@endpush
