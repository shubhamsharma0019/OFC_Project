<style>
    .ofc-notification-wrap{position:relative}
    .ofc-notification-pop{position:absolute;right:0;top:calc(100% + 12px);z-index:1400;display:none;width:min(360px,calc(100vw - 24px));overflow:hidden;border:1px solid #dce7f8;border-radius:12px;background:#fff;box-shadow:0 18px 42px rgba(6,25,66,.16);color:#061942}
    .ofc-notification-pop.show{display:block}
    .ofc-notification-head{display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid #edf2fb;padding:13px 14px}
    .ofc-notification-head strong{font-size:14px;font-weight:800!important}
    .ofc-notification-head button{border:0;background:transparent;color:#075fe4;font-size:12px;font-weight:800!important;cursor:pointer}
    .ofc-notification-list{display:grid;max-height:320px;overflow-y:auto}
    .ofc-notification-item{display:grid;gap:4px;border-bottom:1px solid #edf2fb;padding:12px 14px;text-decoration:none;color:#061942}
    .ofc-notification-item:last-child{border-bottom:0}
    .ofc-notification-item.unread{background:#f8fbff}
    .ofc-notification-item strong{font-size:13px;font-weight:800!important;line-height:1.25}
    .ofc-notification-item p{margin:0;color:#52607a;font-size:12px;line-height:1.45}
    .ofc-notification-item small{color:#7b89a4;font-size:11px}
    .ofc-notification-empty{padding:18px 14px;color:#52607a;font-size:13px;text-align:center}
    .ofc-notification-footer{display:flex;gap:8px;border-top:1px solid #edf2fb;padding:10px 12px}
    .ofc-notification-footer a{flex:1;border-radius:8px;background:#075fe4;padding:9px 10px;color:#fff;font-size:12px;font-weight:800!important;text-align:center;text-decoration:none}
    .ofc-notification-footer button{border:1px solid #cfd8eb;border-radius:8px;background:#fff;padding:9px 10px;color:#24344f;font-size:12px;font-weight:800!important;cursor:pointer}
    .ofc-notification-toast{position:fixed;right:18px;top:18px;z-index:1500;display:none;width:min(320px,calc(100vw - 24px));border:1px solid #cfe0ff;border-radius:12px;background:#fff;padding:12px 14px;box-shadow:0 18px 42px rgba(6,25,66,.16);cursor:pointer}
    .ofc-notification-toast.show{display:block}
    .ofc-notification-toast strong{display:block;margin-bottom:4px;font-size:13px;font-weight:800!important;color:#061942}
    .ofc-notification-toast p{margin:0;color:#52607a;font-size:12px;line-height:1.4}
    @media(max-width:640px){.ofc-notification-pop{position:fixed;left:12px;right:12px;top:72px;width:auto}.ofc-notification-toast{left:12px;right:12px;top:12px;width:auto}}
</style>
<script>
(() => {
    if (window.__ofcNotificationPopupReady) return;
    window.__ofcNotificationPopupReady = true;

    const tokenKeysForPath = () => {
        const path = window.location.pathname;
        if (path.startsWith('/company')) {
            return ['ofc_company_token', 'onlyfreshers_company_token', 'ofc_auth_token'];
        }
        if (path.startsWith('/training-partner') || path.startsWith('/traning-partner')) {
            return ['ofc_training_partner_token', 'ofc_auth_token'];
        }
        if (path.startsWith('/admin')) {
            return ['ofc_auth_token'];
        }
        return ['onlyfreshers_token', 'ofc_fresher_token', 'ofc_auth_token'];
    };
    const token = () => tokenKeysForPath().map(key => localStorage.getItem(key)).find(Boolean) || '';
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
    const dateText = value => value ? new Date(value).toLocaleString('en-IN', { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' }) : '';
    const pageUrl = () => {
        const path = window.location.pathname;
        if (path.startsWith('/company')) return '/company/notifications';
        if (path.startsWith('/training-partner') || path.startsWith('/traning-partner')) return '/training-partner/notifications';
        if (path.startsWith('/admin')) return '/admin/notifications';
        if (path.startsWith('/fast-track')) return '/fast-track/notifications';
        return '/direct-mode/activity';
    };
    const request = async (url, options = {}) => {
        const auth = token();
        if (!auth) throw new Error('Login required');
        const response = await fetch(url, {
            ...options,
            headers: {
                Accept: 'application/json',
                ...(options.body ? {'Content-Type':'application/json'} : {}),
                Authorization: `Bearer ${auth}`,
                ...(options.headers || {}),
            },
        });
        const payload = await response.json().catch(() => ({}));
        if (!response.ok || payload.success === false) throw new Error(payload.message || 'Unable to load notifications.');
        return payload;
    };
    const setBadges = count => {
        document.querySelectorAll('[data-ofc-notification-badge], [data-company-notification-count], #trainingPartnerNotificationBadge, #fastTrackNotificationCount, .top-bell b').forEach(badge => {
            badge.textContent = count > 0 ? count : '';
            badge.style.display = count > 0 ? 'grid' : 'none';
            badge.classList.toggle('hidden', count === 0);
        });
    };
    const buildShell = trigger => {
        let wrap = trigger.closest('.ofc-notification-wrap');
        if (!wrap) {
            wrap = document.createElement('span');
            wrap.className = 'ofc-notification-wrap';
            trigger.parentNode.insertBefore(wrap, trigger);
            wrap.appendChild(trigger);
        }
        let pop = wrap.querySelector('[data-ofc-notification-pop]');
        if (!pop) {
            pop = document.createElement('div');
            pop.className = 'ofc-notification-pop';
            pop.setAttribute('data-ofc-notification-pop', '');
            pop.innerHTML = `<div class="ofc-notification-head"><strong>Notifications</strong><button type="button" data-ofc-mark-all>Mark all read</button></div><div class="ofc-notification-list" data-ofc-notification-list><div class="ofc-notification-empty">Loading notifications...</div></div><div class="ofc-notification-footer"><a href="${pageUrl()}">View all</a><button type="button" data-ofc-close>Close</button></div>`;
            wrap.appendChild(pop);
        }
        return pop;
    };
    const render = (pop, items) => {
        const list = pop.querySelector('[data-ofc-notification-list]');
        if (!items.length) {
            list.innerHTML = '<div class="ofc-notification-empty">No notifications yet.</div>';
            return;
        }
        list.innerHTML = items.map(item => `<a class="ofc-notification-item ${item.is_read ? '' : 'unread'}" href="${pageUrl()}" data-ofc-note-id="${esc(item.id)}"><strong>${esc(item.title || 'Notification')}</strong><p>${esc(item.message || '')}</p><small>${esc(dateText(item.created_at))}</small></a>`).join('');
    };
    const load = async pop => {
        const payload = await request('/api/notifications?per_page=6');
        const notes = payload.data?.notifications?.data || [];
        const unread = Number(payload.data?.summary?.unread || notes.filter(item => !item.is_read).length || 0);
        render(pop, notes);
        setBadges(unread);
        return {notes, unread};
    };
    const refreshUnreadCount = async (remember = true) => {
        const payload = await request('/api/notifications/unread-count');
        const count = Number(payload.data?.unread_count || 0);
        setBadges(count);
        if (remember) sessionStorage.setItem('ofc_last_unread_count', String(count));
        return count;
    };
    const ensureToast = () => {
        let toast = document.querySelector('[data-ofc-notification-toast]');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'ofc-notification-toast';
            toast.setAttribute('data-ofc-notification-toast', '');
            document.body.appendChild(toast);
        }
        return toast;
    };
    const showToast = item => {
        if (!item) return;
        const toast = ensureToast();
        toast.dataset.ofcNoteId = item.id || '';
        toast.dataset.ofcNoteHref = pageUrl();
        toast.innerHTML = `<strong>${esc(item.title || 'New Notification')}</strong><p>${esc(item.message || '')}</p>`;
        toast.classList.add('show');
        clearTimeout(window.__ofcNotificationToastTimer);
        window.__ofcNotificationToastTimer = setTimeout(() => toast.classList.remove('show'), 4500);
    };
    const initTrigger = trigger => {
        if (trigger.dataset.ofcNotificationBound) return;
        trigger.dataset.ofcNotificationBound = '1';
        trigger.addEventListener('click', async event => {
            event.preventDefault();
            event.stopPropagation();
            const pop = buildShell(trigger);
            const willOpen = !pop.classList.contains('show');
            document.querySelectorAll('[data-ofc-notification-pop]').forEach(item => item.classList.remove('show'));
            if (!willOpen) return;
            pop.classList.add('show');
            try { await load(pop); } catch (error) { pop.querySelector('[data-ofc-notification-list]').innerHTML = `<div class="ofc-notification-empty">${esc(error.message)}</div>`; }
        });
    };
    document.addEventListener('click', async event => {
        const close = event.target.closest('[data-ofc-close]');
        if (close) close.closest('[data-ofc-notification-pop]')?.classList.remove('show');
        const markAll = event.target.closest('[data-ofc-mark-all]');
        if (markAll) {
            request('/api/notifications/read-all', {method:'PATCH', body:'{}'}).then(() => {
                setBadges(0);
                markAll.closest('[data-ofc-notification-pop]')?.classList.remove('show');
            }).catch(() => {});
        }
        const note = event.target.closest('[data-ofc-note-id]');
        if (note) {
            event.preventDefault();
            note.closest('[data-ofc-notification-pop]')?.classList.remove('show');
            document.querySelectorAll('[data-ofc-notification-pop]').forEach(item => item.classList.remove('show'));
            try {
                await request(`/api/notifications/${note.dataset.ofcNoteId}/read`, {method:'PATCH', body:'{}'});
                await refreshUnreadCount();
            } catch (error) {}
            window.location.href = note.getAttribute('href') || pageUrl();
            return;
        }
        const toast = event.target.closest('[data-ofc-notification-toast]');
        if (toast) {
            const noteId = toast.dataset.ofcNoteId;
            toast.classList.remove('show');
            if (noteId) {
                try {
                    await request(`/api/notifications/${noteId}/read`, {method:'PATCH', body:'{}'});
                    await refreshUnreadCount();
                } catch (error) {}
            }
            window.location.href = toast.dataset.ofcNoteHref || pageUrl();
            return;
        }
        if (!event.target.closest('.ofc-notification-wrap')) {
            document.querySelectorAll('[data-ofc-notification-pop]').forEach(item => item.classList.remove('show'));
        }
    });
    const boot = async () => {
        document.querySelectorAll('[data-ofc-notification-trigger], .top-bell, .company-notification-link').forEach(initTrigger);
        if (!token()) return;
        try {
            const old = Number(sessionStorage.getItem('ofc_last_unread_count') || 0);
            const count = await refreshUnreadCount(false);
            if (count > old) {
                const latest = await request('/api/notifications?per_page=1').catch(() => null);
                showToast(latest?.data?.notifications?.data?.[0]);
            }
            sessionStorage.setItem('ofc_last_unread_count', String(count));
        } catch (error) {}
    };
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
    setInterval(boot, 30000);
})();
</script>
