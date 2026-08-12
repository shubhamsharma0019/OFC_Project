@extends('layouts.company')

@section('title', 'Notifications - OnlyFreshers')
@section('pageTitle', 'Notifications')
@section('pageSubtitle', 'Stay updated with the latest activities and alerts.')

@php
    $activePage = 'notifications';
@endphp

@section('content')
    <section class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <div class="flex flex-wrap items-center gap-x-5 gap-y-3 border-b border-[#dce7f8] px-[22px] pt-4">
            <button class="notification-tab border-b-[3px] border-[#075fe4] pb-3.5 text-[13px] font-bold text-[#075fe4]" type="button" data-filter="all">All (0)</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="unread">Unread (0)</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="applications">Applications (0)</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="interviews">Interviews (0)</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="system">System (0)</button>

            <button id="markRead" class="mb-4 h-[38px] rounded-lg bg-[#075fe4] px-[18px] text-xs font-bold text-white transition hover:bg-[#0554cc] disabled:cursor-not-allowed disabled:opacity-60 sm:ml-auto" type="button" disabled>
                Mark all as read
            </button>
        </div>

        <div id="notificationList">
            <div class="px-[22px] py-8 text-sm text-[#334b83]">Loading notifications...</div>
        </div>

        <div class="flex flex-col gap-4 border-t border-[#edf2fb] px-[22px] py-4 text-xs text-[#334b83] sm:flex-row sm:items-center sm:justify-between">
            <span id="showingText">Showing 0 notifications</span>
            <div id="pagination" class="flex gap-2.5"></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const tabs = document.querySelectorAll('.notification-tab');
    const list = document.getElementById('notificationList');
    const showingText = document.getElementById('showingText');
    const pagination = document.getElementById('pagination');
    const markReadButton = document.getElementById('markRead');

    let activeFilter = 'all';
    let notifications = [];
    let currentPage = 1;
    let lastPage = 1;

    const typeStyles = {
        applications: { icon: 'bg-[#eaf2ff] text-[#075fe4]', tag: 'bg-[#eaf2ff] text-[#075fe4]', label: 'Applications' },
        application: { icon: 'bg-[#eaf2ff] text-[#075fe4]', tag: 'bg-[#eaf2ff] text-[#075fe4]', label: 'Applications' },
        interviews: { icon: 'bg-[#eef9f2] text-[#00a65a]', tag: 'bg-[#e9f9ef] text-[#00a65a]', label: 'Interviews' },
        interview: { icon: 'bg-[#eef9f2] text-[#00a65a]', tag: 'bg-[#e9f9ef] text-[#00a65a]', label: 'Interviews' },
        system: { icon: 'bg-[#fff4df] text-[#ff9800]', tag: 'bg-[#fff1dc] text-[#ff9800]', label: 'System' },
    };

    function authHeaders() {
        return {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
        };
    }

    function normalizeType(type) {
        const value = (type || 'system').toLowerCase();
        if (value.includes('application') || value.includes('shortlist')) return 'applications';
        if (value.includes('interview')) return 'interviews';
        return 'system';
    }

    function initials(text) {
        return (text || 'Notification').split(/\s+/).map((word) => word[0]).join('').slice(0, 2).toUpperCase();
    }

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"']/g, (character) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[character]);
    }

    function timeAgo(dateValue) {
        if (!dateValue) return '';
        const seconds = Math.max(1, Math.floor((Date.now() - new Date(dateValue).getTime()) / 1000));
        const units = [
            ['year', 31536000],
            ['month', 2592000],
            ['day', 86400],
            ['hour', 3600],
            ['min', 60],
        ];
        for (const [label, size] of units) {
            const value = Math.floor(seconds / size);
            if (value >= 1) return value + ' ' + label + (value > 1 && label !== 'min' ? 's' : '') + ' ago';
        }
        return 'Just now';
    }

    function filteredNotifications() {
        return notifications.filter((notice) => {
            const type = normalizeType(notice.type);
            return activeFilter === 'all'
                || type === activeFilter
                || (activeFilter === 'unread' && !notice.is_read);
        });
    }

    function updateTabs() {
        const counts = {
            all: notifications.length,
            unread: notifications.filter((notice) => !notice.is_read).length,
            applications: notifications.filter((notice) => normalizeType(notice.type) === 'applications').length,
            interviews: notifications.filter((notice) => normalizeType(notice.type) === 'interviews').length,
            system: notifications.filter((notice) => normalizeType(notice.type) === 'system').length,
        };

        tabs.forEach((tab) => {
            const labels = {
                all: 'All',
                unread: 'Unread',
                applications: 'Applications',
                interviews: 'Interviews',
                system: 'System',
            };
            tab.textContent = labels[tab.dataset.filter] + ' (' + counts[tab.dataset.filter] + ')';
        });

        markReadButton.disabled = counts.unread === 0;
        document.querySelectorAll('[data-company-notification-count]').forEach((badge) => {
            badge.textContent = counts.unread;
            badge.classList.toggle('hidden', counts.unread === 0);
        });
        document.dispatchEvent(new CustomEvent('company-notifications-updated'));
    }

    function renderList() {
        const visible = filteredNotifications();
        updateTabs();

        if (!visible.length) {
            list.innerHTML = '<div class="px-[22px] py-8 text-sm text-[#334b83]">No notifications found.</div>';
            showingText.textContent = 'Showing 0 notifications';
            return;
        }

        list.innerHTML = visible.map((notice) => {
            const type = normalizeType(notice.type);
            const styles = typeStyles[type] || typeStyles.system;
            const unreadDot = notice.is_read ? 'bg-transparent' : 'bg-[#075fe4]';
            const title = notice.title || 'Notification';
            const message = notice.message || '';

            return `
                <article class="notification-row grid grid-cols-[12px_44px_minmax(0,1fr)] gap-3.5 border-b border-[#edf2fb] px-[22px] py-[18px] last:border-b-0 md:grid-cols-[16px_58px_minmax(0,1fr)_110px_90px] md:items-center" data-id="${notice.id}" data-type="${type}" data-read="${notice.is_read ? 'true' : 'false'}">
                    <span class="mt-5 h-[9px] w-[9px] rounded-full ${unreadDot} md:mt-0"></span>
                    <span class="flex h-12 w-12 items-center justify-center rounded-full text-[11px] font-extrabold ${styles.icon}">${escapeHtml(initials(title))}</span>
                    <div class="min-w-0">
                        <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">${escapeHtml(title)}</h3>
                        <p class="mb-1.5 text-xs leading-relaxed text-[#334b83]">${escapeHtml(message)}</p>
                        <span class="inline-flex rounded-md px-2.5 py-1 text-[11px] ${styles.tag}">${escapeHtml(styles.label)}</span>
                    </div>
                    <span class="hidden text-right text-xs text-[#334b83] md:block">${timeAgo(notice.created_at)}</span>
                    <button class="mark-single ${notice.is_read ? 'invisible' : ''} rounded-lg border border-[#dce7f8] px-2.5 py-2 text-xs font-bold text-[#075fe4] md:block" type="button">Read</button>
                </article>
            `;
        }).join('');

        showingText.textContent = 'Showing 1 to ' + visible.length + ' of ' + visible.length + ' notifications';
    }

    function renderPagination() {
        pagination.innerHTML = '';
        if (lastPage <= 1) return;

        const previous = document.createElement('button');
        previous.className = 'h-[34px] w-[34px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#061942] disabled:opacity-50';
        previous.textContent = '<';
        previous.disabled = currentPage <= 1;
        previous.addEventListener('click', () => loadNotifications(currentPage - 1));
        pagination.appendChild(previous);

        for (let page = 1; page <= lastPage; page++) {
            const button = document.createElement('button');
            button.className = 'h-[34px] w-[34px] rounded-lg border font-bold ' + (page === currentPage ? 'border-[#075fe4] bg-[#075fe4] text-white' : 'border-[#dce7f8] bg-white text-[#061942]');
            button.textContent = page;
            button.addEventListener('click', () => loadNotifications(page));
            pagination.appendChild(button);
        }

        const next = document.createElement('button');
        next.className = 'h-[34px] w-[34px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#061942] disabled:opacity-50';
        next.textContent = '>';
        next.disabled = currentPage >= lastPage;
        next.addEventListener('click', () => loadNotifications(currentPage + 1));
        pagination.appendChild(next);
    }

    async function loadNotifications(page = 1) {
        if (!token) {
            window.location.href = '/company/login';
            return;
        }

        try {
            const response = await fetch('/api/notifications?per_page=10&page=' + page, { headers: authHeaders() });
            if (response.status === 401) {
                window.location.href = '/company/login';
                return;
            }
            const payload = await response.json();
            const paginated = payload.data?.notifications || {};
            notifications = paginated.data || [];
            currentPage = paginated.current_page || 1;
            lastPage = paginated.last_page || 1;
            renderList();
            renderPagination();
        } catch (error) {
            list.innerHTML = '<div class="px-[22px] py-8 text-sm text-[#b42318]">Notifications load nahi ho paayi. Please refresh karke check karein.</div>';
        }
    }

    async function markNotificationRead(id) {
        await fetch('/api/notifications/' + id + '/read', {
            method: 'PATCH',
            headers: authHeaders(),
        });
        const item = notifications.find((notice) => String(notice.id) === String(id));
        if (item) item.is_read = true;
        renderList();
    }

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabs.forEach((item) => {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]', 'font-bold');
                item.classList.add('border-transparent', 'text-[#24344f]');
            });
            tab.classList.remove('border-transparent', 'text-[#24344f]');
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]', 'font-bold');
            activeFilter = tab.dataset.filter;
            renderList();
        });
    });

    list.addEventListener('click', (event) => {
        const button = event.target.closest('.mark-single');
        if (!button) return;
        const row = button.closest('.notification-row');
        if (row?.dataset.id) markNotificationRead(row.dataset.id);
    });

    markReadButton.addEventListener('click', async () => {
        markReadButton.disabled = true;
        await fetch('/api/notifications/read-all', {
            method: 'PATCH',
            headers: authHeaders(),
        });
        notifications = notifications.map((notice) => ({ ...notice, is_read: true }));
        renderList();
    });

    loadNotifications();
</script>
@endpush
