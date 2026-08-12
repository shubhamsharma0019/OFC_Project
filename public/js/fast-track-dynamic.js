(function () {
    const tokenKeys = ['ofc_auth_token', 'onlyfreshers_token', 'auth_token', 'token'];
    const userKeys = ['ofc_auth_user', 'onlyfreshers_user', 'auth_user', 'user'];

    function token() {
        for (const key of tokenKeys) {
            const value = localStorage.getItem(key);
            if (value) return value;
        }
        return '';
    }

    function user() {
        for (const key of userKeys) {
            try {
                const value = JSON.parse(localStorage.getItem(key) || 'null');
                if (value) return value.user || value.data || value;
            } catch (_) {}
        }
        return {};
    }

    function headers(json) {
        const base = { Accept: 'application/json' };
        if (json) base['Content-Type'] = 'application/json';
        if (token()) base.Authorization = 'Bearer ' + token();
        return base;
    }

    async function request(url, options) {
        const response = await fetch(url, Object.assign({ headers: headers(false) }, options || {}));
        const contentType = response.headers.get('content-type') || '';
        const data = contentType.includes('application/json') ? await response.json() : await response.text();
        if (!response.ok) {
            const message = data && (data.message || data.error) ? (data.message || data.error) : 'Request failed';
            const error = new Error(message);
            error.status = response.status;
            error.data = data;
            throw error;
        }
        return data;
    }

    function getJson(url) {
        return request(url);
    }

    function postJson(url, body) {
        return request(url, {
            method: 'POST',
            headers: headers(true),
            body: JSON.stringify(body || {}),
        });
    }

    function esc(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
        });
    }

    function money(value) {
        const amount = Number(value || 0);
        if (!amount) return 'Free';
        return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 }).format(amount);
    }

    function date(value) {
        if (!value) return '-';
        return new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function initials(value) {
        return String(value || 'FT').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'FT';
    }

    function course(enrollment) {
        return enrollment && (enrollment.course || enrollment.course_details || enrollment);
    }

    function courseName(item) {
        return item && (item.title || item.name || item.course_name || 'Fast Track Course');
    }

    function courseText(item) {
        return item && (item.description || item.short_description || item.overview || 'Industry-focused Fast Track course.');
    }

    function courseDuration(item) {
        return item && (item.duration || item.course_duration || (item.duration_months ? item.duration_months + ' Months' : 'Flexible'));
    }

    function courseMode(item) {
        return item && (item.training_mode || item.mode || 'Online Live');
    }

    function partnerName(item) {
        const partner = item && (item.training_partner_profile || item.trainingPartnerProfile || item.partner);
        return partner && (partner.institute_name || partner.company_name || partner.name) ? (partner.institute_name || partner.company_name || partner.name) : 'OnlyFreshers Partner';
    }

    function progress(enrollment) {
        const raw = enrollment && (enrollment.training_progress || enrollment.trainingProgress || {});
        return Number(raw.progress_percentage || raw.percentage || enrollment.progress_percentage || enrollment.progress || 0);
    }

    function statusText(value) {
        return String(value || 'not_started').replace(/_/g, ' ').replace(/\b\w/g, (char) => char.toUpperCase());
    }

    function selectedCourseId() {
        return new URLSearchParams(location.search).get('course') || localStorage.getItem('fast_track_course_id') || '';
    }

    function rememberCourse(id) {
        if (id) localStorage.setItem('fast_track_course_id', id);
    }

    function emptyState(title, text, href, label) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="mx-auto mb-3 grid h-16 w-16 place-items-center rounded-full bg-[#eaf2ff] text-lg font-black text-[#075fe4]">FT</div>
            <h3 class="mb-2 text-base font-bold text-[#061942]">${esc(title)}</h3>
            <p class="mb-5 text-sm text-[#334b83]">${esc(text)}</p>
            ${href ? `<a class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" href="${href}">${esc(label || 'Continue')}</a>` : ''}
        </article>`;
    }

    function apiData(result, key) {
        return result && result.data ? (key ? result.data[key] : result.data) : result;
    }

    async function enrollments() {
        const result = await getJson('/api/fresher/enrollments');
        return apiData(result, 'enrollments') || [];
    }

    function setChrome() {
        const currentUser = user();
        const name = currentUser.name || currentUser.full_name || currentUser.email;
        const nameEl = document.getElementById('fastTrackStudentName');
        if (name && nameEl) nameEl.textContent = name;

        getJson('/api/notifications/unread-count').then((result) => {
            const count = apiData(result, 'unread_count') ?? apiData(result, 'count') ?? 0;
            const el = document.getElementById('fastTrackNotificationCount');
            if (el) el.textContent = count;
        }).catch(() => {});

        const logout = document.getElementById('fastTrackLogout');
        if (logout) {
            logout.addEventListener('click', function (event) {
                event.preventDefault();
                getJson('/api/auth/profile').then(function () {
                    return fetch('/api/auth/logout', { method: 'POST', headers: headers(false) });
                }).catch(function () {}).finally(function () {
                    tokenKeys.concat(userKeys).forEach((key) => localStorage.removeItem(key));
                    localStorage.removeItem('fast_track_course_id');
                    window.location.href = '/fast-track/login';
                });
            });
        }
    }

    window.FastTrack = {
        token, user, getJson, postJson, esc, money, date, initials, course, courseName, courseText,
        courseDuration, courseMode, partnerName, progress, statusText, selectedCourseId, rememberCourse,
        emptyState, apiData, enrollments,
    };

    setChrome();
})();
