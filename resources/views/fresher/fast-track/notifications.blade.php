@extends('layouts.fast-track')

@section('title', 'Notifications - Fast Track')

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-2xl font-bold text-[#061942]">Notifications</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">View your Fast Track updates, interviews and application alerts.</p>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#edf2fb] px-5 py-4">
                <h2 class="text-base font-bold text-[#061942]">Recent Notifications</h2>
                <button id="markAllRead" class="h-9 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button">Mark all read</button>
            </div>
            <div id="notificationsList" class="divide-y divide-[#edf2fb]">
                <div class="px-5 py-8 text-center text-sm font-semibold text-[#52607a]">Loading notifications...</div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(() => {
    const list = document.getElementById('notificationsList');
    const markAllRead = document.getElementById('markAllRead');
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
    const token = () => localStorage.getItem('onlyfreshers_token') || localStorage.getItem('ofc_fresher_token') || localStorage.getItem('ofc_auth_token') || '';
    const request = async (url, options = {}) => {
        const response = await fetch(url, {
            ...options,
            headers: {
                Accept: 'application/json',
                ...(options.body ? {'Content-Type': 'application/json'} : {}),
                Authorization: 'Bearer ' + token(),
                ...(options.headers || {}),
            },
        });
        const payload = await response.json().catch(() => ({}));
        if (!response.ok || payload.success === false) throw new Error(payload.message || 'Unable to load notifications.');
        return payload;
    };
    const setBadges = count => {
        document.querySelectorAll('[data-ofc-notification-badge], #fastTrackNotificationCount').forEach(badge => {
            badge.textContent = count > 0 ? count : '';
            badge.style.display = count > 0 ? 'grid' : 'none';
            badge.classList.toggle('hidden', count === 0);
        });
    };
    const refreshUnread = async () => {
        const payload = await request('/api/notifications/unread-count');
        setBadges(Number(payload.data?.unread_count || 0));
    };
    const render = items => {
        if (!items.length) {
            list.innerHTML = '<div class="px-5 py-8 text-center text-sm font-semibold text-[#52607a]">No notifications yet.</div>';
            return;
        }
        list.innerHTML = items.map(item => `
            <button class="grid w-full gap-1 border-0 bg-white px-5 py-4 text-left hover:bg-[#f8fbff] ${item.is_read ? '' : 'font-bold'}" type="button" data-note-id="${esc(item.id)}">
                <span class="text-sm font-bold text-[#061942]">${esc(item.title || 'Notification')}</span>
                <span class="text-sm leading-5 text-[#52607a]">${esc(item.message || '')}</span>
                <span class="text-xs text-[#7b89a4]">${item.created_at ? esc(new Date(item.created_at).toLocaleString('en-IN')) : ''}</span>
            </button>
        `).join('');
    };
    const load = async () => {
        try {
            const payload = await request('/api/notifications?per_page=30');
            const items = payload.data?.notifications?.data || [];
            render(items);
            await refreshUnread();
        } catch (error) {
            list.innerHTML = `<div class="px-5 py-8 text-center text-sm font-bold text-[#b42318]">${esc(error.message)}</div>`;
        }
    };
    list.addEventListener('click', async event => {
        const item = event.target.closest('[data-note-id]');
        if (!item) return;
        try {
            await request('/api/notifications/' + item.dataset.noteId + '/read', {method: 'PATCH', body: '{}'});
            item.classList.remove('font-bold');
            await refreshUnread();
        } catch (error) {}
    });
    markAllRead.addEventListener('click', async () => {
        markAllRead.disabled = true;
        try {
            await request('/api/notifications/read-all', {method: 'PATCH', body: '{}'});
            await load();
        } finally {
            markAllRead.disabled = false;
        }
    });
    load();
})();
</script>
@endpush
