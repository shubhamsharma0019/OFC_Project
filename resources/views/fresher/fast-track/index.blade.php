@extends('layouts.fast-track')

@section('title', 'Dashboard - Fast Track')

@php
    $activePage = 'dashboard';
@endphp

@push('styles')
<style>
    .dashboard-chart-card {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #ffffff;
        min-height: 242px;
        padding: 22px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    .dashboard-panel {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    .dashboard-stat-card {
        min-height: 150px;
    }

    .dashboard-chart-card svg {
        display: block;
        width: 100%;
        min-height: 190px;
    }

    .quick-action-card {
        display: flex;
        min-height: 124px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #ffffff;
        padding: 14px;
        color: #061942;
        text-align: center;
        text-decoration: none;
        transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-1px);
        border-color: #9fc1f8;
        box-shadow: 0 14px 28px rgba(6, 25, 66, .08);
    }

    .quick-action-card.is-done {
        border-color: #bcebd0;
        background: #f4fff8;
    }

    .quick-action-card .action-status {
        display: inline-flex;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .latest-training-panel {
        border: 1px solid #cfe0f7;
        border-radius: 8px;
        background: linear-gradient(135deg, #ffffff 0%, #eef6ff 100%);
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    @media (min-width: 1280px) {
        .dashboard-main-grid {
            grid-template-columns: minmax(0, 1.05fr) minmax(420px, .95fr);
        }
    }
</style>
@endpush

@section('content')
    <section class="space-y-6">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Dashboard</h1>
        </div>

        <article class="flex flex-col gap-5 rounded-lg border border-[#cfe0f7] bg-[#eef6ff] px-6 py-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] md:flex-row md:items-center md:px-8">
            <div
                id="dashboardProfileAvatar"
                class="grid h-[96px] w-[96px] shrink-0 place-items-center overflow-hidden rounded-full border-2 border-white bg-gradient-to-br from-[#1769ff] to-[#17a6a8] bg-cover bg-center text-2xl font-black text-white shadow-[0_10px_22px_rgba(6,25,66,.14)]"
                aria-hidden="true"
            >
                FT
            </div>

            <div class="min-w-0 flex-1">
                <p class="mb-1 text-sm font-bold leading-tight text-[#061942]">Welcome,</p>
                <h2 id="welcomeName" class="mb-3 break-words text-[26px] font-black leading-tight text-[#061942]">Fresher</h2>

                <div class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#075fe4]">
                    <span class="grid h-4 w-4 place-items-center rounded-full bg-[#075fe4] text-white">
                        <svg class="h-3 w-3 fill-none stroke-current stroke-[3] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m5 12 4 4L19 6"></path>
                        </svg>
                    </span>
                    Verified Fresher
                </div>

                <p id="dashboardProfileCourse" class="mb-2 text-sm font-extrabold leading-tight text-[#061942]">B.Tech - Computer Science</p>
                <p id="dashboardProfileLocation" class="flex items-center gap-1.5 text-sm font-semibold leading-tight text-[#24344f]">
                    <svg class="h-4 w-4 shrink-0 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>Delhi, India</span>
                </p>
            </div>

            <div
                id="dashboardProfileImageWrap"
                class="hidden w-full shrink-0 overflow-hidden rounded-lg border border-white/80 bg-white shadow-[0_12px_28px_rgba(6,25,66,.12)] md:h-[132px] md:w-[220px]"
            >
                <img
                    id="dashboardProfileImage"
                    class="h-full w-full object-cover"
                    src=""
                    alt="Profile photo"
                >
            </div>
        </article>

        <div class="dashboard-main-grid grid items-start gap-6">
            <div class="space-y-6">
                <div id="dashboardStatsGrid" class="grid gap-4 sm:grid-cols-2">
                    <article class="dashboard-panel p-6 text-sm text-[#334b83] sm:col-span-2">
                        Loading dashboard...
                    </article>
                </div>

                <article class="dashboard-chart-card">
                    <div class="mb-5 flex items-center justify-between gap-3">
                        <h3 class="text-lg font-bold text-[#061942]">Learning Progress</h3>
                        <span id="learningProgressLabel" class="rounded-full bg-[#eaf2ff] px-3 py-1 text-xs font-bold text-[#075fe4]">Live</span>
                    </div>
                    <div id="learningProgressChart">
                        <p class="text-sm text-[#334b83]">Loading chart...</p>
                    </div>
                </article>

                <article class="dashboard-panel p-5">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Quick Actions</h3>

                    <div id="quickActions" class="grid gap-4 sm:grid-cols-2">
                        <p class="text-sm text-[#334b83] sm:col-span-2">
                            Loading actions...
                        </p>
                    </div>
                </article>
            </div>

            <div class="space-y-6">
                <article class="dashboard-chart-card">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Application Overview</h3>
                    <div id="applicationOverviewChart">
                        <p class="text-sm text-[#334b83]">Loading chart...</p>
                    </div>
                </article>

                <article class="dashboard-panel px-6 py-6 sm:px-7">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Recent Activity</h3>

                    <div id="recentActivity">
                        <p class="text-sm text-[#334b83]">Loading activity...</p>
                    </div>
                </article>

                <article
                    id="latestTrainingCard"
                    class="latest-training-panel relative flex min-h-[242px] items-center overflow-hidden p-7 sm:p-8"
                >
                    <div class="relative z-10 max-w-[360px]">
                        <h3 class="mb-4 text-[22px] font-bold text-[#061942]">
                            Fast Track Your Career
                        </h3>

                        <p class="mb-6 text-[15px] leading-6 text-[#24344f]">
                            Enroll in Fast Track Courses and get placed in top companies.
                        </p>

                        <a
                            href="/fast-track/courses"
                            class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]"
                        >
                            Explore Courses
                        </a>
                    </div>

                    <div class="absolute bottom-7 right-12 hidden h-[155px] w-[155px] rotate-[-12deg] items-center justify-center rounded-full bg-[#e1edff] text-[#075fe4] sm:flex">
                        <svg
                            class="h-20 w-20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M4 19V5"></path>
                            <path d="M4 19h16"></path>
                            <path d="M8 15l3-3 3 2 5-7"></path>
                        </svg>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const welcomeName = document.getElementById('welcomeName');
    const dashboardProfileAvatar = document.getElementById('dashboardProfileAvatar');
    const dashboardProfileCourse = document.getElementById('dashboardProfileCourse');
    const dashboardProfileLocation = document.getElementById('dashboardProfileLocation');
    const dashboardProfileImageWrap = document.getElementById('dashboardProfileImageWrap');
    const dashboardProfileImage = document.getElementById('dashboardProfileImage');
    const dashboardStatsGrid = document.getElementById('dashboardStatsGrid');
    const quickActions = document.getElementById('quickActions');
    const recentActivity = document.getElementById('recentActivity');
    const latestTrainingCard = document.getElementById('latestTrainingCard');
    const learningProgressChart = document.getElementById('learningProgressChart');
    const learningProgressLabel = document.getElementById('learningProgressLabel');
    const applicationOverviewChart = document.getElementById('applicationOverviewChart');

    const dashboardIcons = {
        profile: '<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg>',

        assessment: '<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 13h6M9 17h3"></path></svg>',

        training: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3z"></path></svg>',

        notification: '<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',

        course: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7z"></path></svg>',

        progress: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',

        enroll: '<svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><path d="M14 8h7M14 12h7M14 16h5"></path></svg>',

        certificate: '<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3z"></path><path d="M9 8h6M9 12h6"></path></svg>',
    };

    function icon(name) {
        return `
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">
                ${dashboardIcons[name] || dashboardIcons.course}
            </span>
        `;
    }

    function circleCard(label, value, color) {
        const safeValue = Math.max(
            0,
            Math.min(100, Number(value || 0))
        );

        return `
            <article class="dashboard-stat-card relative overflow-hidden rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <span class="absolute left-0 top-0 h-full w-1" style="background:${color};"></span>
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold leading-snug text-[#061942]">
                            ${FastTrack.esc(label)}
                        </h3>
                        <p class="mt-2 text-xs font-semibold text-[#526287]">
                            ${safeValue >= 80 ? 'Almost complete' : (safeValue > 0 ? 'Keep going' : 'Not started yet')}
                        </p>
                    </div>
                    <span class="text-[30px] font-bold leading-none text-[#061942]">
                        ${safeValue}%
                    </span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-[#edf3fb]">
                    <div class="h-full rounded-full" style="width:${safeValue}%;background:${color};"></div>
                </div>
            </article>
        `;
    }

    function metricCard(cardIcon, label, value, hint, tone = '#075fe4') {
        return `
            <article class="dashboard-stat-card relative overflow-hidden rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <span class="absolute left-0 top-0 h-full w-1" style="background:${tone};"></span>
                <div class="mb-4 flex items-center justify-between gap-4">
                    ${cardIcon}
                    <div class="text-[32px] font-bold leading-none text-[#061942]">
                        ${FastTrack.esc(value)}
                    </div>
                </div>
                <h3 class="text-sm font-bold leading-snug text-[#061942]">
                    ${FastTrack.esc(label)}
                </h3>
                <p class="mt-2 truncate text-xs font-semibold text-[#526287]">
                    ${FastTrack.esc(hint)}
                </p>
            </article>
        `;
    }

    function smallCard(cardIcon, label, value) {
        return `
            <article class="dashboard-stat-card grid grid-cols-[64px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                ${cardIcon}

                <div>
                    <div class="mb-1 text-[26px] font-bold leading-none text-[#061942]">
                        ${FastTrack.esc(value)}
                    </div>

                    <p class="text-sm leading-snug text-[#24344f]">
                        ${FastTrack.esc(label)}
                    </p>
                </div>
            </article>
        `;
    }

    function actionCard(cardIcon, title, url, done) {
        return `
            <a
                class="quick-action-card ${done ? 'is-done' : ''}"
                href="${url}"
            >
                ${cardIcon}
                <span class="max-w-[110px] text-sm font-bold leading-snug">${FastTrack.esc(title)}</span>
                <small class="action-status ${done ? 'bg-[#dbf8e8] text-[#078346]' : 'bg-[#fff4df] text-[#b86500]'}">${done ? 'Done' : 'Pending'}</small>
            </a>
        `;
    }

    function activityItem(activityIcon, title, date) {
        return `
            <div class="grid grid-cols-[44px_minmax(0,1fr)] items-center gap-4 border-b border-[#e5edf8] py-4 text-sm last:border-b-0 sm:grid-cols-[44px_minmax(0,1fr)_auto]">
                ${activityIcon}

                <span class="font-semibold text-[#061942]">
                    ${FastTrack.esc(title)}
                </span>

                <time class="col-start-2 whitespace-nowrap text-[#24344f] sm:col-start-auto">
                    ${FastTrack.esc(date || '-')}
                </time>
            </div>
        `;
    }

    function renderTrendChart(target, rows) {
        const data = rows.map((row) => ({
            label: row[0],
            value: Math.max(0, Math.min(100, Number(row[1] || 0))),
        }));
        const width = 520;
        const height = 220;
        const left = 38;
        const right = 18;
        const top = 18;
        const bottom = 36;
        const chartW = width - left - right;
        const chartH = height - top - bottom;
        const step = chartW / Math.max(1, data.length - 1);
        const points = data.map((item, index) => ({
            ...item,
            x: left + index * step,
            y: top + chartH - (item.value / 100) * chartH,
        }));
        const line = points.map((point) => `${point.x},${point.y}`).join(' ');
        const area = `${left},${top + chartH} ${line} ${width - right},${top + chartH}`;

        target.innerHTML = `<svg viewBox="0 0 ${width} ${height}" preserveAspectRatio="xMidYMid meet" aria-label="Learning progress chart">
            <defs>
                <linearGradient id="fastTrackProgressFill" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0" stop-color="#075fe4" stop-opacity=".18"></stop>
                    <stop offset="1" stop-color="#075fe4" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
            <line x1="${left}" y1="${top}" x2="${left}" y2="${top + chartH}" stroke="#e5edf8"></line>
            <line x1="${left}" y1="${top + chartH}" x2="${width - right}" y2="${top + chartH}" stroke="#dce7f8"></line>
            <line x1="${left}" y1="${top + chartH / 2}" x2="${width - right}" y2="${top + chartH / 2}" stroke="#eff4fb"></line>
            <text x="6" y="${top + 4}" font-size="11" fill="#526287">100</text>
            <text x="12" y="${top + chartH / 2 + 4}" font-size="11" fill="#526287">50</text>
            <text x="20" y="${top + chartH + 4}" font-size="11" fill="#526287">0</text>
            <polygon points="${area}" fill="url(#fastTrackProgressFill)"></polygon>
            <polyline points="${line}" fill="none" stroke="#075fe4" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${points.map((point) => `<circle cx="${point.x}" cy="${point.y}" r="5" fill="#075fe4" stroke="#cfe0ff" stroke-width="3"></circle><text x="${point.x - 20}" y="${height - 10}" font-size="10" fill="#526287">${FastTrack.esc(point.label)}</text>`).join('')}
        </svg>`;
    }

    function renderBarChart(target, rows) {
        const data = rows.map((row) => ({
            label: row[0],
            value: Number(row[1] || 0),
            color: row[2],
        }));
        const max = Math.max(1, ...data.map((item) => item.value));
        target.innerHTML = `<div class="grid gap-4">${data.map((item) => {
            const percent = Math.max(4, Math.round((item.value / max) * 100));
            return `<div>
                <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                    <span class="font-bold text-[#061942]">${FastTrack.esc(item.label)}</span>
                    <span class="font-bold text-[#24344f]">${FastTrack.esc(item.value)}</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-[#edf3fb]">
                    <div class="h-full rounded-full" style="width:${percent}%;background:${item.color};"></div>
                </div>
            </div>`;
        }).join('')}</div>`;
    }

    function profilePhotoUrl(profile) {
        const photo = profile && (
            profile.profile_photo ||
            profile.profilePhoto ||
            profile.photo ||
            profile.avatar
        );

        if (!photo) return '';
        if (/^(https?:)?\/\//.test(photo) || String(photo).startsWith('data:') || String(photo).startsWith('/')) return photo;
        return '/storage/' + photo;
    }

    function setDashboardProfileCard(user, profile) {
        const displayName =
            user.name ||
            user.full_name ||
            user.email ||
            'Fresher';

        const qualification =
            profile.qualification ||
            profile.highest_qualification ||
            profile.degree ||
            'B.Tech';

        const specialization =
            profile.specialization ||
            profile.branch ||
            profile.stream ||
            profile.course ||
            'Computer Science';

        const city = profile.city || profile.location || 'Delhi';
        const country = profile.country || 'India';
        const locationText = [city, country].filter(Boolean).join(', ');
        const photo = profilePhotoUrl(profile);

        welcomeName.textContent = displayName;
        dashboardProfileCourse.textContent = [qualification, specialization].filter(Boolean).join(' - ');
        dashboardProfileLocation.querySelector('span').textContent = locationText || 'Delhi, India';

        dashboardProfileAvatar.textContent = FastTrack.initials(displayName);
        dashboardProfileAvatar.title = displayName;
        dashboardProfileAvatar.style.backgroundImage = '';
        dashboardProfileImageWrap.classList.add('hidden');
        dashboardProfileImageWrap.classList.remove('md:block');
        dashboardProfileImage.removeAttribute('src');

        if (photo) {
            const image = new Image();
            image.onload = function () {
                dashboardProfileAvatar.textContent = '';
                dashboardProfileAvatar.style.backgroundImage = `url("${photo.replace(/"/g, '\\"')}")`;
                dashboardProfileImage.src = photo;
                dashboardProfileImage.alt = displayName + ' profile photo';
                dashboardProfileImageWrap.classList.remove('hidden');
                dashboardProfileImageWrap.classList.add('md:block');
            };
            image.onerror = function () {
                dashboardProfileAvatar.textContent = FastTrack.initials(displayName);
                dashboardProfileAvatar.style.backgroundImage = '';
                dashboardProfileImageWrap.classList.add('hidden');
                dashboardProfileImageWrap.classList.remove('md:block');
                dashboardProfileImage.removeAttribute('src');
            };
            image.src = photo;
        }
    }

    function renderDashboard(data, unread) {
        const user = data.user || FastTrack.user() || {};
        const profile = data.profile || {};
        const stats = data.statistics || {};
        const latestEnrollment = data.latest_course_enrollment || null;
        const assessment =
            data.initial_assessment ||
            data.latest_assessment ||
            data.assessment ||
            data.assessment_result ||
            null;
        const result = assessment?.result || {};
        const recommendedTrack = result.recommended_track || '';

        const rawScore = assessment
            ? (
                result.overall_score ??
                assessment.percentage ??
                assessment.percentage_score ??
                assessment.score_percentage ??
                assessment.score ??
                assessment.result?.percentage ??
                assessment.result?.score ??
                0
            )
            : 0;

        const score = Math.max(
            0,
            Math.min(100, Number(rawScore || 0))
        );

        setDashboardProfileCard(user, profile);

        localStorage.setItem(
            'ofc_auth_user',
            JSON.stringify(user)
        );
        localStorage.setItem('onlyfreshers_selected_mode', 'fast_track');

        dashboardStatsGrid.innerHTML = [
            circleCard(
                'Profile Completion',
                profile.profile_completion || 0,
                '#19a85b'
            ),

            circleCard(
                'Assessment Score',
                score,
                '#7744eb'
            ),

            metricCard(
                icon('training'),
                'Current Training',
                stats.active_trainings || stats.total_course_enrollments || 0,
                latestEnrollment ? FastTrack.courseName(latestEnrollment.course || {}) : 'No active course yet',
                '#075fe4'
            ),

            metricCard(
                icon('notification'),
                'Notifications',
                unread || 0,
                unread ? 'Unread updates waiting' : 'All caught up',
                '#7744eb'
            ),
        ].join('');

        const trainingProgress = latestEnrollment ? FastTrack.progress(latestEnrollment) : 0;
        learningProgressLabel.textContent = trainingProgress + '% training';
        renderTrendChart(learningProgressChart, [
            ['Profile', profile.profile_completion || 0],
            ['Assess', score],
            ['Enroll', latestEnrollment ? 45 : 0],
            ['Train', trainingProgress],
            ['Cert', Number(stats.total_certificates || stats.certificates || 0) > 0 ? 100 : trainingProgress],
        ]);

        renderBarChart(applicationOverviewChart, [
            ['Applications', stats.total_applications || 0, '#075fe4'],
            ['Shortlisted', stats.shortlisted_applications || 0, '#12b76a'],
            ['Interviews', stats.interview_scheduled_applications || stats.scheduled_interviews || 0, '#7744eb'],
            ['Completed Training', stats.completed_trainings || 0, '#f59a23'],
            ['Certificates', stats.total_certificates || stats.certificates || 0, '#0ea5a8'],
        ]);

        quickActions.innerHTML = [
            actionCard(
                icon('profile'),
                'Complete Profile',
                '/fast-track/profile',
                Number(profile.profile_completion || 0) >= 100
            ),

            actionCard(
                icon('course'),
                'Explore Fast Track',
                '/fast-track/courses',
                !!latestEnrollment
            ),

            actionCard(
                icon('progress'),
                'View Training',
                '/fast-track/training',
                Number(stats.total_course_enrollments || 0) > 0
            ),

            actionCard(
                icon('certificate'),
                'Certificate',
                '/fast-track/certificate',
                Number(stats.certificates || 0) > 0
            ),
        ].join('');

        const activities = [];

        if (profile.profile_id || profile.id) {
            activities.push([
                icon('profile'),
                'Profile loaded successfully',
                profile.qualification ||
                profile.city ||
                'Profile active'
            ]);
        }

        if (assessment) {
            activities.push([
                icon('assessment'),
                'Initial assessment completed',
                FastTrack.date(
                    assessment.submitted_at ||
                    assessment.completed_at ||
                    assessment.created_at
                )
            ]);
        }

        (data.recent_applications || []).forEach((item) => {
            const jobTitle =
                item.job?.title ||
                item.job?.course_name ||
                'Job';

            activities.push([
                icon('training'),
                'Applied for ' + jobTitle,
                FastTrack.date(
                    item.applied_at ||
                    item.created_at
                )
            ]);
        });

        (data.recent_certificates || []).forEach((item) => {
            activities.push([
                icon('certificate'),
                'Certificate earned',
                FastTrack.date(
                    item.created_at ||
                    item.issued_at
                )
            ]);
        });

        if (latestEnrollment) {
            activities.push([
                icon('enroll'),
                'Enrolled in ' +
                    FastTrack.courseName(
                        latestEnrollment.course || {}
                    ),
                FastTrack.date(
                    latestEnrollment.enrollment_date ||
                    latestEnrollment.created_at
                )
            ]);
        }

        recentActivity.innerHTML = activities.length
            ? activities
                .slice(0, 6)
                .map((item) =>
                    activityItem(
                        item[0],
                        item[1],
                        item[2]
                    )
                )
                .join('')
            : '<p class="text-sm text-[#334b83]">No recent activity yet.</p>';

        if (latestEnrollment?.course) {
            const progress = FastTrack.progress(latestEnrollment);
            const trainingStatus = (latestEnrollment.training_status || 'in_progress').replaceAll('_', ' ');

            latestTrainingCard.innerHTML = `
                <div class="relative z-10 w-full">
                    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <p class="mb-2 text-xs font-bold uppercase text-[#526287]">Current Training</p>
                            <h3 class="truncate text-[24px] font-bold leading-tight text-[#061942]">
                                ${FastTrack.esc(FastTrack.courseName(latestEnrollment.course))}
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-[#24344f]">
                                ${FastTrack.esc(FastTrack.partnerName(latestEnrollment.course))}
                            </p>
                        </div>
                        <span class="w-fit rounded-full bg-[#eaf2ff] px-3 py-1 text-xs font-bold capitalize text-[#075fe4]">
                            ${FastTrack.esc(trainingStatus)}
                        </span>
                    </div>

                    <div class="mb-5">
                        <div class="mb-2 flex items-center justify-between text-xs font-bold text-[#24344f]">
                            <span>Training Progress</span>
                            <span>${progress}%</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-[#dce7f8]">
                            <div class="h-full rounded-full bg-[linear-gradient(90deg,#075fe4,#17a6a8)]" style="width:${progress}%"></div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a
                            href="/fast-track/training-progress"
                            class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white"
                        >
                            View Progress
                        </a>

                        <a
                            href="/fast-track/course-details?course=${encodeURIComponent(latestEnrollment.course.id)}"
                            class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-white px-6 text-sm font-bold text-[#075fe4]"
                        >
                            Course Details
                        </a>

                    </div>
                </div>
            `;
        } else if (recommendedTrack) {
            latestTrainingCard.innerHTML = `<div class="relative z-10 w-full max-w-[460px]"><h3 class="mb-3 text-[22px] font-bold text-[#061942]">${FastTrack.esc(recommendedTrack)}</h3><p class="mb-2 text-[15px] leading-6 text-[#24344f]">Recommended from your initial assessment score.</p><p class="mb-5 text-sm font-bold text-[#075fe4]">Score: ${FastTrack.esc(result.overall_score || 0)}%</p><a href="/fast-track/courses?track=${encodeURIComponent(recommendedTrack)}" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]">View Recommended Courses</a></div><div class="absolute bottom-7 right-12 hidden h-[155px] w-[155px] rotate-[-28deg] items-center justify-center rounded-full bg-[#e1edff] text-[42px] font-black text-[#075fe4] sm:flex">RT</div>`;
        }
    }

    function renderProfileMissing() {
        dashboardStatsGrid.innerHTML = [
            circleCard(
                'Profile Completion',
                0,
                '#19a85b'
            ),

            circleCard(
                'Assessment Score',
                0,
                '#7744eb'
            ),

            metricCard(
                icon('training'),
                'Current Training',
                0,
                'No active course yet',
                '#075fe4'
            ),

            metricCard(
                icon('notification'),
                'Notifications',
                0,
                'All caught up',
                '#7744eb'
            ),
        ].join('');

        quickActions.innerHTML = [
            actionCard(
                icon('profile'),
                'Complete Profile',
                '/fast-track/profile',
                false
            ),

            actionCard(
                icon('course'),
                'Explore Fast Track',
                '/fast-track/courses',
                false
            ),

            actionCard(
                icon('progress'),
                'View Training',
                '/fast-track/training',
                false
            ),

            actionCard(
                icon('certificate'),
                'Certificate',
                '/fast-track/certificate',
                false
            ),
        ].join('');

        recentActivity.innerHTML =
            '<p class="text-sm text-[#334b83]">Complete your profile to unlock dashboard activity.</p>';
        renderTrendChart(learningProgressChart, [
            ['Profile', 0],
            ['Assess', 0],
            ['Enroll', 0],
            ['Train', 0],
            ['Cert', 0],
        ]);
        renderBarChart(applicationOverviewChart, [
            ['Applications', 0, '#075fe4'],
            ['Shortlisted', 0, '#12b76a'],
            ['Interviews', 0, '#7744eb'],
            ['Completed Training', 0, '#f59a23'],
            ['Certificates', 0, '#0ea5a8'],
        ]);
    }

    Promise.all([
        FastTrack
            .getJson('/api/fresher/dashboard')
            .catch((error) => ({ error })),

        FastTrack
            .getJson('/api/notifications/unread-count')
            .catch(() => ({
                data: {
                    unread_count: 0
                }
            })),

        FastTrack
            .getJson('/api/fresher/profile')
            .catch(() => ({
                data: {}
            })),
    ])
    .then(function (responses) {
        const dashboardResponse = responses[0];
        const profileResponse = responses[2];

        const unread =
            FastTrack.apiData(
                responses[1],
                'unread_count'
            ) || 0;

        if (dashboardResponse.error) {
            window.location.href = '/fast-track/profile';
            return;
        }
        const dashboard = FastTrack.apiData(dashboardResponse) || {};
        const profileData = FastTrack.apiData(profileResponse) || {};
        dashboard.user = profileData.user || dashboard.user;
        dashboard.profile = Object.assign({}, dashboard.profile || {}, profileData.profile || {});

        if (!dashboard.initial_assessment || dashboard.initial_assessment.status !== 'submitted') {
            localStorage.setItem('onlyfreshers_intended_mode', 'fast_track');
            localStorage.removeItem('onlyfreshers_selected_mode');
            window.location.href = '/direct-mode/flow-selection';
            return;
        }
        renderDashboard(dashboard, unread);
    }).catch(renderProfileMissing);
</script>
@endpush
