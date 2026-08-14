@extends('layouts.admin')

@section('title', 'Freshers Management - OnlyFreshers Admin')
@section('pageTitle', 'Freshers Management')
@section('breadcrumb', 'Dashboard > Freshers')

@php
    $activePage = 'freshers';
@endphp

@push('styles')
<style>
    .admin-freshers-page,
    .admin-freshers-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-freshers-page grid gap-5">
        <div id="fresherStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading freshers...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search fresher...">
                <select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Status</option><option value="active">Active</option><option value="blocked">Blocked</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[920px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">Fresher</th><th class="px-5 py-4">Qualification</th><th class="px-5 py-4">City</th><th class="px-5 py-4">Profile</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr>
                    </thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="6">Loading freshers...</td></tr></tbody>
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
    const fresherStats = document.getElementById('fresherStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const statusFilter = document.getElementById('statusFilter');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let freshers = [];
    let currentPage = 1;
    let lastPage = 1;
    let searchTimer = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function badgeClass(status) { return status === 'active' ? 'bg-[#e8f8ef] text-[#078346]' : 'bg-[#fff0f1] text-[#ff1f2f]'; }
    const statIcons = {
        page: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16h16V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8M8 17h5"></path></svg>',
        active: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path><path d="m17 11 2 2 4-5"></path></svg>',
        blocked: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="m5.7 5.7 12.6 12.6"></path></svg>',
        profiles: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg>',
    };
    function statCard(label, value, tone) {
        const key = label === 'This Page' ? 'page' : label.toLowerCase();
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[key] || statIcons.profiles}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function renderStats() {
        fresherStats.innerHTML = [
            statCard('This Page', number(freshers.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Active', number(freshers.filter((item) => item.status === 'active').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Blocked', number(freshers.filter((item) => item.status === 'blocked').length), 'bg-[#fff0f1] text-[#ff1f2f]'),
            statCard('Profiles', number(freshers.filter((item) => item.fresher_profile).length), 'bg-[#f3ecff] text-[#5b20e6]'),
        ].join('');
    }
    function renderRows() {
        renderStats();
        if (!freshers.length) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No freshers found.</td></tr>'; return; }
        adminRows.innerHTML = freshers.map((fresher) => {
            const profile = fresher.fresher_profile || {};
            const completion = profile.profile_completion || 0;
            return `<tr>
                <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(fresher.name)}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(fresher.email || fresher.mobile || '-')}</span></td>
                <td class="px-5 py-4">${escapeHtml(profile.qualification || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(profile.college_name || '')}</span></td>
                <td class="px-5 py-4">${escapeHtml(profile.city || '-')}</td>
                <td class="px-5 py-4"><div class="mb-1 text-xs font-bold text-[#061942]">${completion}%</div><div class="h-2 w-28 overflow-hidden rounded-full bg-[#eaf2ff]"><div class="h-full rounded-full bg-[#075fe4]" style="width:${completion}%"></div></div></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(fresher.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(fresher.status)}</span></td>
                <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-fresher rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${fresher.id}">View</button><button class="toggle-status rounded-md border border-[#dce7f8] px-3 py-2 text-xs font-bold text-[#24344f]" type="button" data-id="${fresher.id}" data-status="${fresher.status === 'active' ? 'blocked' : 'active'}">${fresher.status === 'active' ? 'Block' : 'Activate'}</button></div></td>
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
    async function loadFreshers(page = 1) {
        try {
            const params = new URLSearchParams({ page, per_page: 10 });
            if (adminSearch.value.trim()) params.set('search', adminSearch.value.trim());
            if (statusFilter.value) params.set('status', statusFilter.value);
            const response = await fetch('/api/admin/freshers?' + params.toString(), { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/admin/login'; return; }
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Freshers load nahi ho paaye.');
            const paginator = payload.data?.freshers || {};
            freshers = paginator.data || [];
            setPagination(paginator);
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="6">' + escapeHtml(error.message || 'Freshers load nahi ho paaye.') + '</td></tr>';
        }
    }
    async function updateStatus(id, status) {
        const response = await fetch(`/api/admin/freshers/${id}/status`, { method: 'PATCH', headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token }, body: JSON.stringify({ status }) });
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Status update nahi ho paaya.');
        return payload;
    }
    adminSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadFreshers(1), 350); });
    statusFilter.addEventListener('change', () => loadFreshers(1));
    prevPage.addEventListener('click', () => loadFreshers(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadFreshers(Math.min(lastPage, currentPage + 1)));
    adminRows.addEventListener('click', async (event) => {
        const view = event.target.closest('.view-fresher');
        const toggle = event.target.closest('.toggle-status');
        if (view?.dataset.id) { localStorage.setItem('ofc_selected_admin_fresher_id', view.dataset.id); window.location.href = '/admin/freshers/show'; return; }
        if (!toggle?.dataset.id) return;
        toggle.disabled = true;
        try { await updateStatus(toggle.dataset.id, toggle.dataset.status); await loadFreshers(currentPage); } catch (error) { alert(error.message || 'Status update nahi ho paaya.'); toggle.disabled = false; }
    });
    loadFreshers();
</script>
@endpush
