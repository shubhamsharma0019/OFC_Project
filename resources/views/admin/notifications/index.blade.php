@extends('layouts.admin')

@section('title', 'Notifications - OnlyFreshers Admin')
@section('pageTitle', 'Notifications')
@section('breadcrumb', 'Dashboard > Notifications')

@section('topbarExtra')
    <button id="markAllRead" class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="button">Mark All Read</button>
@endsection

@php
    $activePage = 'notifications';
@endphp

@push('styles')
<style>
    .admin-notifications-page,
    .admin-notifications-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }

    @media (max-width: 640px) {
        #markAllRead {
            height: 38px;
            padding-left: 12px !important;
            padding-right: 12px !important;
            font-size: 12px !important;
            white-space: nowrap;
        }

        .admin-notifications-page {
            gap: 14px;
        }

        .admin-notifications-page #notificationStats {
            gap: 12px;
        }

        .admin-notifications-page #notificationStats article {
            padding: 16px !important;
        }

        .admin-notifications-page #notificationStats h2 {
            font-size: 24px !important;
            line-height: 1.15 !important;
        }

        .admin-notifications-page .admin-notifications-toolbar {
            padding: 14px !important;
        }

        .admin-notifications-page .admin-notifications-toolbar select {
            width: 100%;
        }

        .admin-notifications-page .admin-notifications-table-wrap {
            overflow: visible !important;
        }

        .admin-notifications-page table,
        .admin-notifications-page thead,
        .admin-notifications-page tbody,
        .admin-notifications-page tr,
        .admin-notifications-page td {
            display: block;
            width: 100%;
        }

        .admin-notifications-page table {
            min-width: 0 !important;
        }

        .admin-notifications-page thead {
            display: none;
        }

        .admin-notifications-page tbody {
            padding: 10px;
            background: #f7fbff;
        }

        .admin-notifications-page tbody tr {
            border: 1px solid #d9e6f8;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 8px 18px rgba(6, 25, 66, .06);
            overflow: hidden;
        }

        .admin-notifications-page tbody tr + tr {
            margin-top: 10px;
        }

        .admin-notifications-page tbody td {
            display: grid;
            grid-template-columns: minmax(72px, 30%) minmax(0, 1fr);
            gap: 8px;
            align-items: start;
            border-bottom: 0;
            padding: 3px 12px !important;
            color: #1b315b;
            font-size: 10.5px !important;
            line-height: 1.35;
            word-break: break-word;
        }

        .admin-notifications-page tbody td:first-child {
            display: none;
        }

        .admin-notifications-page tbody td:nth-child(2) {
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) auto;
            align-items: center;
            gap: 9px;
            padding-top: 12px !important;
            padding-bottom: 7px !important;
        }

        .admin-notifications-page tbody td::before {
            content: attr(data-label);
            color: #061942;
            font-size: 10px;
            font-weight: 600 !important;
            letter-spacing: 0;
            text-transform: none;
        }

        .admin-notifications-page tbody td:nth-child(2)::before,
        .admin-notifications-page tbody td[data-label="Actions"]::before {
            display: none;
        }

        .admin-notifications-page .admin-notification-avatar {
            display: grid;
            width: 28px;
            height: 28px;
            place-items: center;
            border-radius: 999px;
            background: #eef5ff;
            color: #075fe4;
            font-size: 11px;
            font-weight: 600 !important;
            text-transform: uppercase;
        }

        .admin-notifications-page .admin-notification-title {
            min-width: 0;
        }

        .admin-notifications-page .admin-notification-title strong {
            overflow: hidden;
            font-size: 12px !important;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-notifications-page .admin-notification-title span,
        .admin-notifications-page .admin-notification-muted {
            overflow: hidden;
            color: #52607a;
            font-size: 9px !important;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-notifications-page .admin-notification-status {
            border-radius: 4px;
            padding: 4px 7px !important;
            font-size: 9px !important;
            line-height: 1;
        }

        .admin-notifications-page tbody td[colspan] {
            display: block;
            padding: 14px !important;
            font-size: 12px !important;
        }

        .admin-notifications-page tbody td[colspan]::before {
            display: none;
        }

        .admin-notifications-page tbody td[data-label="Actions"] {
            display: block;
            padding: 10px 12px 12px !important;
        }

        .admin-notifications-page .mark-read {
            min-height: 32px;
            width: 100%;
            padding: 7px 8px !important;
            font-size: 10px !important;
        }

        .admin-notifications-page #pagination {
            gap: 10px;
            padding: 12px !important;
        }

        .admin-notifications-page #pagination button {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        .admin-notifications-page #resultText {
            padding: 12px !important;
            font-size: 12px !important;
        }
    }
</style>
@endpush

@section('content')
    <section class="admin-notifications-page grid gap-5">
        <div id="notificationStats" class="grid gap-4 sm:grid-cols-3">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-3">Loading notifications...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="admin-notifications-toolbar flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="notificationSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search notification...">
                <select id="readFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]">
                    <option value="">All Notifications</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                </select>
            </div>
            <div class="admin-notifications-table-wrap overflow-x-auto">
                <table class="w-full min-w-[920px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">#</th><th class="px-5 py-4">Title</th><th class="px-5 py-4">Message</th><th class="px-5 py-4">Received</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr>
                    </thead>
                    <tbody id="notificationRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        <tr><td class="px-5 py-5" colspan="6">Loading notifications...</td></tr>
                    </tbody>
                </table>
            </div>
            <div id="pagination" class="hidden items-center justify-between border-t border-[#edf2fb] p-4 text-sm text-[#52607a]">
                <button id="prevPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Previous</button>
                <span id="pageInfo" class="font-bold text-[#061942]"></span>
                <button id="nextPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Next</button>
            </div>
            <div id="resultText" class="px-5 py-4 text-sm text-[#52607a]">Loading...</div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const notificationStats = document.getElementById('notificationStats');
    const notificationRows = document.getElementById('notificationRows');
    const notificationSearch = document.getElementById('notificationSearch');
    const readFilter = document.getElementById('readFilter');
    const markAllRead = document.getElementById('markAllRead');
    const resultText = document.getElementById('resultText');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let notifications = [];
    let unreadCount = 0;
    let currentPage = 1;
    let lastPage = 1;
    let total = 0;
    let filteredTotal = 0;
    let summary = { total: 0, unread: 0, read: 0, filtered: 0 };
    let searchTimer = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleString('en-IN', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }); }
    function valueOf(item, keys, fallback = '-') { for (const key of keys) if (item?.[key]) return item[key]; return fallback; }
    const statIcons = {
        Total: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
        Unread: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a2 2 0 0 1-2.06 0L2 7"/><circle cx="18" cy="18" r="3"/><path d="M18 16.8v1.4l.9.6"/></svg>',
        'This Page': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6"/><path d="M9 17h4"/></svg>',
    };
    function statCard(label, value, tone) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[label] || statIcons.Total}</span><p class="mt-4 text-xs text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function filteredNotifications() {
        return notifications;
    }
    function renderStats() {
        notificationStats.innerHTML = [
            statCard('Total', number(summary.total || total), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Unread', number(summary.unread || unreadCount), 'bg-[#fff4df] text-[#b86500]'),
            statCard('This Page', number(notifications.length), 'bg-[#e8f8ef] text-[#078346]'),
        ].join('');
        markAllRead.disabled = (summary.unread || unreadCount) <= 0;
    }
    function renderRows() {
        renderStats();
        const rows = filteredNotifications();
        resultText.textContent = `Showing ${number(rows.length)} of ${number(filteredTotal || total)} notifications`;
        if (!rows.length) {
            notificationRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="6">No notifications found.</td></tr>';
            return;
        }
        notificationRows.innerHTML = rows.map((item, index) => {
            const title = valueOf(item, ['title', 'heading', 'type'], 'Notification');
            const message = valueOf(item, ['message', 'body', 'description'], '-');
            const status = item.is_read ? 'Read' : 'Unread';
            return `<tr class="${item.is_read ? '' : 'bg-[#fbfdff]'}">
                <td class="px-5 py-4" data-label="#">${((currentPage - 1) * 10) + index + 1}</td>
                <td class="px-5 py-4 font-bold text-[#061942]" data-label="Title"><span class="admin-notification-avatar">${escapeHtml(String(title || 'N').slice(0, 1))}</span><span class="admin-notification-title"><strong class="block text-[#061942]">${escapeHtml(title)}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(formatDate(item.created_at))}</span></span><span class="admin-notification-status rounded-md ${item.is_read ? 'bg-[#eef2f8] text-[#24344f]' : 'bg-[#fff4df] text-[#b86500]'} px-3 py-1 text-xs font-bold">${status}</span></td>
                <td class="px-5 py-4" data-label="Message"><span class="admin-notification-muted line-clamp-2">${escapeHtml(message)}</span></td>
                <td class="px-5 py-4 text-[#52607a]" data-label="Received">${escapeHtml(formatDate(item.created_at))}</td>
                <td class="px-5 py-4" data-label="Status"><span class="rounded-md ${item.is_read ? 'bg-[#eef2f8] text-[#24344f]' : 'bg-[#fff4df] text-[#b86500]'} px-3 py-1 text-xs font-bold">${status}</span></td>
                <td class="px-5 py-4" data-label="Actions"><button class="mark-read rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4] disabled:cursor-not-allowed disabled:opacity-60" type="button" data-id="${item.id}" ${item.is_read ? 'disabled' : ''}>Mark Read</button></td>
            </tr>`;
        }).join('');
    }
    function setPagination(paginator) {
        currentPage = paginator.current_page || 1;
        lastPage = paginator.last_page || 1;
        total = paginator.total || notifications.length;
        filteredTotal = paginator.total || notifications.length;
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
    async function loadUnreadCount() {
        const payload = await requestJson('/api/notifications/unread-count');
        if (!payload) return;
        unreadCount = payload.data?.unread_count || 0;
    }
    async function loadNotifications(page = 1) {
        try {
            await loadUnreadCount();
            const params = new URLSearchParams({
                page,
                per_page: 10,
            });
            if (notificationSearch.value.trim()) params.set('search', notificationSearch.value.trim());
            if (readFilter.value) params.set('status', readFilter.value);

            const payload = await requestJson('/api/notifications?' + params.toString());
            if (!payload) return;
            const paginator = payload.data?.notifications || {};
            summary = payload.data?.summary || summary;
            total = summary.total || paginator.total || 0;
            filteredTotal = summary.filtered || paginator.total || 0;
            unreadCount = summary.unread ?? unreadCount;
            notifications = paginator.data || [];
            setPagination(paginator);
            renderRows();
        } catch (error) {
            notificationStats.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-3">' + escapeHtml(error.message || 'Notifications load nahi ho paayi.') + '</article>';
            notificationRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="6">Notifications load nahi ho paayi.</td></tr>';
            resultText.textContent = 'Unable to load notifications';
        }
    }
    notificationSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadNotifications(1), 300); });
    readFilter.addEventListener('change', () => loadNotifications(1));
    prevPage.addEventListener('click', () => loadNotifications(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadNotifications(Math.min(lastPage, currentPage + 1)));
    notificationRows.addEventListener('click', async (event) => {
        const button = event.target.closest('.mark-read');
        if (!button?.dataset.id) return;
        button.disabled = true;
        try {
            await requestJson('/api/notifications/' + button.dataset.id + '/read', { method: 'PATCH' });
            await loadNotifications(currentPage);
        } catch (error) {
            alert(error.message || 'Notification read mark nahi ho paayi.');
            button.disabled = false;
        }
    });
    markAllRead.addEventListener('click', async () => {
        markAllRead.disabled = true;
        try {
            await requestJson('/api/notifications/read-all', { method: 'PATCH' });
            await loadNotifications(currentPage);
        } catch (error) {
            alert(error.message || 'Notifications read mark nahi ho paayi.');
            markAllRead.disabled = false;
        }
    });
    loadNotifications();
</script>
@endpush
