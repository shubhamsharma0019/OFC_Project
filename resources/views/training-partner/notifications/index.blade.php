@extends('layouts.training-partner')

@section('title', 'Notifications')

@php
    $activePage = 'notifications';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Notifications</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Stay updated with latest activity and announcements.</p>
            </div>
            <button id="markAllBtn" class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white" type="button">Mark All Read</button>
        </div>

        <div id="notificationStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading notifications...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="notificationSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search notifications...">
                <select id="notificationFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Notifications</option><option value="unread">Unread</option><option value="read">Read</option></select>
            </div>
            <div id="notificationList" class="divide-y divide-[#e7ebf5]"><div class="p-5 text-sm text-[#526287]">Loading notifications...</div></div>
            <div id="pagination" class="hidden items-center justify-between border-t border-[#e7ebf5] p-4 text-sm text-[#526287]">
                <button id="prevPage" class="rounded-md border border-[#cfd8eb] px-4 py-2 text-xs font-bold text-[#26375f]" type="button">Previous</button>
                <span id="pageInfo" class="font-bold text-[#071544]"></span>
                <button id="nextPage" class="rounded-md border border-[#cfd8eb] px-4 py-2 text-xs font-bold text-[#26375f]" type="button">Next</button>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const notificationStats = document.getElementById('notificationStats');
    const notificationList = document.getElementById('notificationList');
    const notificationSearch = document.getElementById('notificationSearch');
    const notificationFilter = document.getElementById('notificationFilter');
    const markAllBtn = document.getElementById('markAllBtn');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let notifications = [];
    let currentPage = 1;
    let lastPage = 1;

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleString('en-IN', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-'; }
    function typeClass(type) { if (type === 'success' || type === 'certificate') return 'bg-[#e2f9ea] text-[#05843e]'; if (type === 'warning' || type === 'approval') return 'bg-[#fff0de] text-[#d06d00]'; if (type === 'error') return 'bg-[#fff4f4] text-[#b42318]'; return 'bg-[#eaf2ff] text-[#075fe4]'; }
    function statCard(label, value, icon) { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">${icon}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`; }
    function filteredNotifications() {
        const query = notificationSearch.value.trim().toLowerCase();
        const filter = notificationFilter.value;
        return notifications.filter((item) => {
            const text = [item.title, item.message, item.type].join(' ').toLowerCase();
            const readMatch = filter === 'all' || (filter === 'read' && item.is_read) || (filter === 'unread' && !item.is_read);
            return (!query || text.includes(query)) && readMatch;
        });
    }
    function renderStats() {
        notificationStats.innerHTML = [
            statCard('Total', notifications.length, 'TN'),
            statCard('Unread', notifications.filter((item) => !item.is_read).length, 'UR'),
            statCard('Read', notifications.filter((item) => item.is_read).length, 'RD'),
            statCard('This Page', currentPage + ' / ' + lastPage, 'PG'),
        ].join('');
    }
    function renderNotifications() {
        const rows = filteredNotifications();
        renderStats();
        if (!rows.length) { notificationList.innerHTML = '<div class="p-5 text-sm text-[#526287]">No notifications found.</div>'; return; }
        notificationList.innerHTML = rows.map((item) => `<div class="grid gap-3 p-5 sm:grid-cols-[48px_minmax(0,1fr)_auto] sm:items-start ${item.is_read ? 'bg-white' : 'bg-[#fbfdff]'}">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl ${typeClass(item.type)} text-xs font-black">${escapeHtml(String(item.type || 'NT').slice(0, 2).toUpperCase())}</span>
            <div class="min-w-0"><div class="flex flex-wrap items-center gap-2"><h2 class="text-sm font-bold text-[#071544]">${escapeHtml(item.title)}</h2>${item.is_read ? '<span class="rounded-md bg-[#f3f6fb] px-2 py-1 text-[11px] font-bold text-[#526287]">Read</span>' : '<span class="rounded-md bg-[#fff0de] px-2 py-1 text-[11px] font-bold text-[#d06d00]">Unread</span>'}</div><p class="mt-2 text-sm leading-relaxed text-[#526287]">${escapeHtml(item.message)}</p><p class="mt-2 text-xs text-[#8190ad]">${formatDate(item.created_at)}</p></div>
            <button class="mark-read rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6] ${item.is_read ? 'hidden' : ''}" type="button" data-id="${item.id}">Mark Read</button>
        </div>`).join('');
    }
    async function apiPatch(url) {
        const response = await fetch(url, { method: 'PATCH', headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/training-partner/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Notification update nahi ho paayi.');
        return payload;
    }
    async function loadNotifications(page = 1) {
        try {
            const response = await fetch(`/api/notifications?page=${page}&per_page=10`, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Notifications load nahi ho paayi.');
            const paginator = payload.data?.notifications || {};
            notifications = paginator.data || [];
            currentPage = paginator.current_page || 1;
            lastPage = paginator.last_page || 1;
            pagination.classList.toggle('hidden', lastPage <= 1);
            pagination.classList.toggle('flex', lastPage > 1);
            pageInfo.textContent = 'Page ' + currentPage + ' of ' + lastPage;
            prevPage.disabled = currentPage <= 1;
            nextPage.disabled = currentPage >= lastPage;
            renderNotifications();
        } catch (error) {
            notificationList.innerHTML = '<div class="p-5 text-sm font-bold text-[#b42318]">' + escapeHtml(error.message || 'Notifications load nahi ho paayi.') + '</div>';
        }
    }
    notificationSearch.addEventListener('input', renderNotifications);
    notificationFilter.addEventListener('change', renderNotifications);
    prevPage.addEventListener('click', () => loadNotifications(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadNotifications(Math.min(lastPage, currentPage + 1)));
    notificationList.addEventListener('click', async (event) => {
        const button = event.target.closest('.mark-read');
        if (!button?.dataset.id) return;
        button.disabled = true;
        try { await apiPatch(`/api/notifications/${button.dataset.id}/read`); await loadNotifications(currentPage); } catch (error) { alert(error.message || 'Notification update nahi ho paayi.'); button.disabled = false; }
    });
    markAllBtn.addEventListener('click', async () => {
        markAllBtn.disabled = true;
        markAllBtn.textContent = 'Updating...';
        try { await apiPatch('/api/notifications/read-all'); await loadNotifications(currentPage); } catch (error) { alert(error.message || 'Notifications update nahi ho paayi.'); }
        markAllBtn.disabled = false;
        markAllBtn.textContent = 'Mark All Read';
    });
    loadNotifications();
</script>
@endpush
