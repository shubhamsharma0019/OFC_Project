@extends('layouts.training-partner')

@section('title', 'Training Partner Dashboard')

@php
    $activePage = 'dashboard';
@endphp

@section('content')
    <div class="mb-6">
        <h1 class="mb-2.5 text-[30px] font-extrabold leading-tight text-[#0a1748]">Training Partner Dashboard</h1>
    </div>

    <article class="mb-[18px] flex flex-col gap-5 rounded-[10px] border border-[#d8cdfa] bg-[#f3edff] px-6 py-6 shadow-[0_12px_26px_rgba(50,35,120,.05)] md:flex-row md:items-center md:px-8">
        <div
            id="partnerLogoAvatar"
            class="grid h-[96px] w-[96px] shrink-0 place-items-center overflow-hidden rounded-[18px] border-2 border-white bg-gradient-to-br from-[#7b45ee] to-[#0ea5a8] bg-cover bg-center bg-no-repeat text-2xl font-black text-white shadow-[0_10px_22px_rgba(50,35,120,.14)]"
            aria-hidden="true"
        >
            TP
        </div>

        <div class="min-w-0 flex-1">
            <p class="mb-1 text-sm font-extrabold leading-tight text-[#0a1748]">Welcome,</p>
            <h2 id="welcomeName" class="mb-3 break-words text-[26px] font-black leading-tight text-[#0a1748]">Training Partner</h2>

            <div class="mb-4 inline-flex items-center gap-2 text-sm font-extrabold text-[#5b2ce1]">
                <span class="grid h-4 w-4 place-items-center rounded-full bg-[#5b2ce1] text-white">
                    <svg class="h-3 w-3 fill-none stroke-current stroke-[3] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m5 12 4 4L19 6"></path>
                    </svg>
                </span>
                Verified Training Partner
            </div>

            <p id="partnerEmail" class="mb-2 text-sm font-extrabold leading-tight text-[#0a1748]">Institute profile completed</p>
            <p id="partnerLocation" class="flex items-center gap-1.5 text-sm font-semibold leading-tight text-[#26375f]">
                <svg class="h-4 w-4 shrink-0 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span>Location</span>
            </p>
        </div>

        <div
            id="partnerLogoPreviewWrap"
            class="hidden w-full shrink-0 overflow-hidden rounded-[10px] border border-white/80 bg-white shadow-[0_12px_28px_rgba(50,35,120,.12)] md:h-[132px] md:w-[220px]"
        >
            <img
                id="partnerLogoPreview"
                class="h-full w-full object-cover object-center"
                src=""
                alt="Institution logo"
            >
        </div>
    </article>

    <section id="dashboardStats" class="mb-[18px] grid grid-cols-1 gap-[18px] md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-[10px] border border-[#dddff0] bg-white p-6 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] md:col-span-2 xl:col-span-4">Loading dashboard...</article>
    </section>

    <section class="mb-[18px] grid grid-cols-1 gap-[18px] xl:grid-cols-[1fr_1.14fr]">
        <article class="rounded-[10px] border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="mb-[18px] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">RA</span>
                    <h2 class="m-0 text-[17px] font-extrabold text-[#0a1748]">Recent Activity</h2>
                </div>
                <a href="/training-partner/notifications" class="text-xs font-extrabold text-[#5b2ce1]">View All Activity</a>
            </div>
            <div id="recentActivity" class="relative grid before:absolute before:bottom-6 before:left-1.5 before:top-6 before:w-px before:bg-[#dddff0]">
                <div class="py-4 text-sm text-[#526287]">Loading activity...</div>
            </div>
        </article>

        <article class="rounded-[10px] border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="mb-[18px] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[#5b2ce1]">
                        <svg class="h-5 w-5 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 4v5c0 4-3 7-7 9-4-2-7-5-7-9V7z"></path><path d="m9 12 2 2 4-5"></path></svg>
                    </span>
                    <h2 class="m-0 text-[17px] font-extrabold text-[#0a1748]">Course Performance Overview</h2>
                </div>
                <select id="courseFilter" class="h-9 rounded-[7px] border border-[#dddff0] bg-white px-3 text-xs font-extrabold text-[#26375f] outline-none">
                    <option value="">All Courses</option>
                </select>
            </div>

            <div class="pb-1.5 pt-0.5">
                <div class="mb-3 text-[13px] font-extrabold text-[#0a1748]">Enrollment Trend (This Month)</div>
                <svg class="h-[190px] w-full" id="enrollmentTrendChart" viewBox="0 0 620 190" preserveAspectRatio="none"></svg>
            </div>

            <div class="mt-3.5 grid overflow-hidden rounded-[9px] border border-[#dddff0] md:grid-cols-3">
                <div class="grid grid-cols-[50px_minmax(0,1fr)] items-center gap-3 border-b border-[#dddff0] p-4 md:border-b-0 md:border-r">
                    <span class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">PE</span>
                    <div class="min-w-0"><strong id="paidEnrollments" class="text-[15px] font-extrabold text-[#0a1748]">0</strong><p class="my-[3px] text-[11px] text-[#526287]">Paid Enrollments</p></div>
                </div>
                <div class="grid grid-cols-[50px_minmax(0,1fr)] items-center gap-3 border-b border-[#dddff0] p-4 md:border-b-0 md:border-r">
                    <span class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">CT</span>
                    <div class="min-w-0"><strong id="completedTrainings" class="text-[15px] font-extrabold text-[#0a1748]">0</strong><p class="my-[3px] text-[11px] text-[#526287]">Completed Trainings</p></div>
                </div>
                <div class="grid grid-cols-[50px_minmax(0,1fr)] items-center gap-3 p-4">
                    <span class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">RS</span>
                    <div class="min-w-0"><strong id="totalRevenue" class="text-[15px] font-extrabold text-[#0a1748]">Rs. 0</strong><p class="my-[3px] text-[11px] text-[#526287]">Successful Revenue</p></div>
                </div>
            </div>
        </article>
    </section>

    <article class="mt-[18px] rounded-[10px] border border-[#dddff0] bg-white p-[22px] shadow-[0_12px_26px_rgba(50,35,120,.05)]">
        <div class="mb-4 flex items-center gap-3.5">
            <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">QA</span>
            <h2 class="m-0 text-[17px] font-extrabold text-[#0a1748]">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <a class="grid grid-cols-[56px_minmax(0,1fr)_22px] items-center gap-3 rounded-[9px] border border-[#dddff0] bg-white p-[18px] text-inherit no-underline" href="/training-partner/add-course"><span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#7b45ee] text-[28px] font-black text-white">+</span><div class="min-w-0"><h3 class="mb-1.5 text-sm font-extrabold text-[#0a1748]">Add New Course</h3><p class="m-0 text-xs leading-normal text-[#526287]">Create and publish a new course</p></div><span class="text-[22px] font-black text-[#5b2ce1]">›</span></a>
            <a class="grid grid-cols-[56px_minmax(0,1fr)_22px] items-center gap-3 rounded-[9px] border border-[#dddff0] bg-white p-[18px] text-inherit no-underline" href="/training-partner/courses"><span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">CR</span><div class="min-w-0"><h3 class="mb-1.5 text-sm font-extrabold text-[#0a1748]">My Courses</h3><p class="m-0 text-xs leading-normal text-[#526287]">Manage courses and status</p></div><span class="text-[22px] font-black text-[#5b2ce1]">›</span></a>
            <a class="grid grid-cols-[56px_minmax(0,1fr)_22px] items-center gap-3 rounded-[9px] border border-[#dddff0] bg-white p-[18px] text-inherit no-underline" href="/training-partner/enrollments"><span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">EN</span><div class="min-w-0"><h3 class="mb-1.5 text-sm font-extrabold text-[#0a1748]">View Enrollments</h3><p class="m-0 text-xs leading-normal text-[#526287]">See students and progress</p></div><span class="text-[22px] font-black text-[#5b2ce1]">›</span></a>
            <a class="grid grid-cols-[56px_minmax(0,1fr)_22px] items-center gap-3 rounded-[9px] border border-[#dddff0] bg-white p-[18px] text-inherit no-underline" href="/training-partner/certificates"><span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">CT</span><div class="min-w-0"><h3 class="mb-1.5 text-sm font-extrabold text-[#0a1748]">Certificates</h3><p class="m-0 text-xs leading-normal text-[#526287]">Generate and view certificates</p></div><span class="text-[22px] font-black text-[#5b2ce1]">›</span></a>
        </div>
    </article>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    let dashboardData = null;

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"']/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[character]);
    }
    function formatNumber(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function initials(value) {
        return String(value || 'TP').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'TP';
    }
    function storageUrl(path) {
        if (!path) return '';
        const value = String(path);
        if (/^(https?:)?\/\//.test(value) || value.startsWith('data:') || value.startsWith('/')) return value;
        return '/storage/' + value.replace(/^\/?storage\//, '');
    }
    function timeAgo(dateValue) {
        if (!dateValue) return '';
        const days = Math.floor(Math.max(1, (Date.now() - new Date(dateValue).getTime()) / 1000) / 86400);
        if (days === 0) return 'Today';
        if (days === 1) return '1 day ago';
        return days + ' days ago';
    }
    function statCard(label, value, hint, icon) {
        return `<article class="grid min-h-[142px] grid-cols-[62px_minmax(0,1fr)] items-center gap-[18px] rounded-[10px] border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)] max-[720px]:min-h-[110px]"><span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[#5b2ce1]">${window.trainingPartnerMetricIcon(icon)}</span><div class="min-w-0"><p class="mb-3 text-[13px] text-[#526287]">${escapeHtml(label)}</p><h2 class="mb-3 text-[30px] font-extrabold leading-none text-[#0a1748]">${escapeHtml(value)}</h2><small class="text-[13px] font-extrabold text-[#089845]">${escapeHtml(hint)}</small></div></article>`;
    }
    function activityItem(title, text, time, icon) {
        return `<div class="relative grid grid-cols-[56px_minmax(0,1fr)_auto] items-center gap-3.5 border-b border-[#edf0f8] py-3.5 last:border-b-0 max-[720px]:grid-cols-[48px_minmax(0,1fr)]"><span class="absolute left-[-21px] h-1.5 w-1.5 rounded-full bg-[#d9d0ff]"></span><span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1] max-[720px]:h-12 max-[720px]:w-12">${escapeHtml(icon)}</span><div class="min-w-0"><h3 class="mb-[7px] text-sm font-extrabold text-[#0a1748]">${escapeHtml(title)}</h3><p class="m-0 text-xs text-[#526287]">${escapeHtml(text)}</p></div><time class="text-xs text-[#526287] max-[720px]:col-start-2">${escapeHtml(time)}</time></div>`;
    }
    function enrollmentBucketLabel(dateValue) {
        const date = dateValue ? new Date(dateValue) : new Date();
        return date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short' });
    }
    function buildTrendData(courseId) {
        const enrollments = dashboardData?.recent_enrollments || [];
        const selected = enrollments.filter((enrollment) => !courseId || String(enrollment.course_id) === String(courseId) || String(enrollment.course?.id) === String(courseId));
        const bucketMap = new Map();
        selected.forEach((enrollment) => {
            const label = enrollmentBucketLabel(enrollment.enrollment_date);
            bucketMap.set(label, (bucketMap.get(label) || 0) + 1);
        });
        const rows = [...bucketMap.entries()].slice(0, 6).map(([label, value]) => ({ label, value }));
        if (rows.length) return rows;
        return [
            { label: '1 May', value: 0 },
            { label: '8 May', value: 0 },
            { label: '15 May', value: 0 },
            { label: '22 May', value: 0 },
            { label: '26 May', value: 0 },
            { label: '29 May', value: 0 },
        ];
    }
    function renderEnrollmentTrend(courseId) {
        const svg = document.getElementById('enrollmentTrendChart');
        const data = buildTrendData(courseId);
        const max = Math.max(1, ...data.map((item) => item.value));
        const points = data.map((item, index) => {
            const x = 38 + index * ((620 - 76) / Math.max(1, data.length - 1));
            const y = 150 - (item.value / max) * 118;
            return { ...item, x, y };
        });
        const line = points.map((point) => `${point.x},${point.y}`).join(' ');
        const area = `38,150 ${line} ${points[points.length - 1].x},150`;
        const mid = Math.ceil(max / 2);
        svg.innerHTML = `
            <defs><linearGradient id="fillPurple" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#7b45ee" stop-opacity=".22"/><stop offset="1" stop-color="#7b45ee" stop-opacity="0"/></linearGradient></defs>
            <line x1="38" y1="30" x2="38" y2="150" stroke="#e5e9f4"></line>
            <line x1="38" y1="150" x2="592" y2="150" stroke="#e5e9f4"></line>
            <text x="8" y="34" font-size="11" fill="#526287">${formatNumber(max)}</text>
            <text x="16" y="92" font-size="11" fill="#526287">${formatNumber(mid)}</text>
            <text x="22" y="150" font-size="11" fill="#526287">0</text>
            <polygon points="${area}" fill="url(#fillPurple)"></polygon>
            <polyline points="${line}" fill="none" stroke="#6a2df0" stroke-width="3"></polyline>
            ${points.map((point) => `<circle cx="${point.x}" cy="${point.y}" r="5" fill="#6a2df0"></circle><text x="${point.x - 18}" y="178" font-size="11" fill="#526287">${escapeHtml(point.label)}</text>`).join('')}
        `;
    }
    function setPartnerProfileCard(user, profile) {
        const name = profile.institute_name || user?.name || 'Training Partner';
        const logo = storageUrl(profile.institute_logo || profile.logo || profile.image);
        const avatar = document.getElementById('partnerLogoAvatar');
        const previewWrap = document.getElementById('partnerLogoPreviewWrap');
        const preview = document.getElementById('partnerLogoPreview');

        document.getElementById('welcomeName').textContent = name;
        document.getElementById('partnerEmail').textContent = profile.email || user?.email || 'Institute profile completed';
        document.getElementById('partnerLocation').querySelector('span').textContent = profile.location || 'Location not added';

        avatar.textContent = initials(name);
        avatar.title = name;
        avatar.style.backgroundImage = '';
        previewWrap.classList.add('hidden');
        previewWrap.classList.remove('md:block');
        preview.removeAttribute('src');

        if (logo) {
            const image = new Image();
            image.onload = function () {
                avatar.textContent = '';
                avatar.style.backgroundImage = `url("${logo.replace(/"/g, '\\"')}")`;
                preview.src = logo;
                preview.alt = name + ' institution logo';
                previewWrap.classList.remove('hidden');
                previewWrap.classList.add('md:block');
            };
            image.onerror = function () {
                avatar.textContent = initials(name);
                avatar.style.backgroundImage = '';
                previewWrap.classList.add('hidden');
                previewWrap.classList.remove('md:block');
                preview.removeAttribute('src');
            };
            image.src = logo;
        }
    }
    function renderDashboard(data) {
        const profile = data.training_partner_profile || {};
        const stats = data.statistics || {};
        const courses = data.recent_courses || [];
        const enrollments = data.recent_enrollments || [];
        const certificates = data.recent_certificates || [];
        localStorage.setItem('ofc_training_partner_profile', JSON.stringify(profile));
        document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: profile }));
        setPartnerProfileCard(data.user || {}, profile);
        document.getElementById('dashboardStats').innerHTML = [
            statCard('Total Courses', formatNumber(stats.total_courses), formatNumber(stats.active_courses) + ' Active', 'TC'),
            statCard('Total Enrollments', formatNumber(stats.total_enrollments), formatNumber(stats.pending_enrollments) + ' Pending', 'TE'),
            statCard('Active Students', formatNumber(stats.enrolled_students), formatNumber(stats.active_trainings) + ' Currently Learning', 'AS'),
            statCard('Certificates', formatNumber(stats.total_certificates), formatNumber(stats.completed_trainings) + ' Completed Training', 'CT'),
        ].join('');
        const activity = [
            ...courses.map((course) => activityItem('Course Added', course.course_name, timeAgo(course.created_at), 'CR')),
            ...enrollments.map((enrollment) => activityItem('New Enrollment', (enrollment.fresher_profile?.user?.name || 'Student') + ' enrolled in ' + (enrollment.course?.course_name || 'Course'), timeAgo(enrollment.enrollment_date), 'EN')),
            ...certificates.map((certificate) => activityItem('Certificate Generated', (certificate.fresher_profile?.user?.name || 'Student') + ' completed ' + (certificate.course_enrollment?.course?.course_name || 'Course'), timeAgo(certificate.created_at), 'CF')),
        ].slice(0, 6);
        document.getElementById('recentActivity').innerHTML = activity.length ? activity.join('') : '<div class="py-4 text-sm text-[#526287]">No recent activity yet.</div>';
        document.getElementById('courseFilter').innerHTML = '<option value="">All Courses</option>' + courses.map((course) => `<option value="${course.id}">${escapeHtml(course.course_name)}</option>`).join('');
        renderEnrollmentTrend('');
        document.getElementById('paidEnrollments').textContent = formatNumber(stats.paid_enrollments);
        document.getElementById('completedTrainings').textContent = formatNumber(stats.completed_trainings);
        document.getElementById('totalRevenue').textContent = 'Rs. ' + formatNumber(stats.total_payment_amount || 0);
    }
    async function loadDashboard() {
        try {
            const response = await fetch('/api/training-partner/dashboard', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            if (response.status === 404) { window.location.href = '/training-partner/profile/edit'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = (payload.data?.approval_status === 'rejected') ? '/training-partner/approval/rejected' : '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Dashboard load nahi ho paaya.');
            dashboardData = payload.data || {};
            renderDashboard(dashboardData);
        } catch (error) {
            document.getElementById('dashboardStats').innerHTML = '<article class="rounded-[10px] border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm text-[#b42318] md:col-span-2 xl:col-span-4">' + escapeHtml(error.message || 'Dashboard load nahi ho paaya.') + '</article>';
        }
    }
    document.getElementById('courseFilter')?.addEventListener('change', (event) => renderEnrollmentTrend(event.target.value));
    loadDashboard();
</script>
@endpush
