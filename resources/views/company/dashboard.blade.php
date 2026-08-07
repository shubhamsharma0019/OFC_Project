@extends('layouts.company')

@section('title', 'Company Dashboard - OnlyFreshers')
@section('pageTitle', 'Company Dashboard')
@section('pageSubtitle', 'Overview of your hiring activities and company updates.')

@php $activePage = 'dashboard'; @endphp

@section('content')
    <section class="mb-5 min-h-[150px] rounded-lg border border-[#dce7f8] bg-white px-5 py-7 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:px-8 sm:py-10">
        <h2 class="mb-2.5 text-[22px] font-bold leading-tight text-[#061942]">
            Welcome back,
            <strong id="welcomeCompanyName" class="block break-words text-[27px] font-bold sm:text-[28px]">Company</strong>
        </h2>
        <p id="dashboardStatus" class="text-sm text-[#34445e]">Loading dashboard...</p>
    </section>

    <section id="statsGrid" class="mb-[22px] grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-5"></section>

    <section class="grid grid-cols-1 gap-5 xl:grid-cols-[1.1fr_0.9fr]">
        <div class="min-w-0 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
            <h2 class="mb-[18px] text-lg font-bold text-[#061942]">Recent Activities</h2>
            <div id="recentActivities" class="grid gap-1">
                <p class="text-sm text-[#52607a]">Loading recent activity...</p>
            </div>
            <a href="/company/notifications" class="mx-auto mt-[22px] flex h-[42px] w-[170px] items-center justify-center rounded-lg border border-[#bfd4f5] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">View All Activities</a>
        </div>

        <div class="min-w-0 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
            <h2 class="mb-[18px] text-lg font-bold text-[#061942]">Quick Actions</h2>
            <div id="quickActions" class="grid gap-3"></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const statsGrid = document.getElementById('statsGrid');
    const recentActivities = document.getElementById('recentActivities');
    const quickActions = document.getElementById('quickActions');

    const iconSvg = {
        briefcase: '<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5h8v2"></path></svg>',
        users: '<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-8 0v2"></path><circle cx="12" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path></svg>',
        star: '<svg viewBox="0 0 24 24"><path d="M12 3l2.7 5.4 6 .9-4.3 4.2 1 6-5.4-2.8-5.4 2.8 1-6-4.3-4.2 6-.9z"></path></svg>',
        calendar: '<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 3v4M16 3v4M4 10h16"></path></svg>',
        userCheck: '<svg viewBox="0 0 24 24"><path d="M8 21v-2a4 4 0 0 1 8 0v2"></path><circle cx="12" cy="7" r="4"></circle><path d="M17 11l2 2 4-5"></path></svg>',
        file: '<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',
    };

    const statMeta = [
        ['Jobs Posted', 'total_jobs', '/company/jobs', 'briefcase', 'bg-[#eaf2ff] text-[#075fe4]'],
        ['Applications', 'total_applications', '/company/applications', 'users', 'bg-[#e8fbf3] text-[#00ad6f]'],
        ['Shortlisted', 'shortlisted_applications', '/company/shortlisted', 'star', 'bg-[#fff5e6] text-[#ff9c22]'],
        ['Interviews', 'scheduled_interviews', '/company/interviews', 'calendar', 'bg-[#f0edff] text-[#6c50ff]'],
        ['Hired', 'hired_applications', '/company/hired', 'userCheck', 'bg-[#e8fbf3] text-[#00ad6f]'],
    ];

    const actions = [
        ['Post a New Job', 'Find the best talent for your company', '/company/post-job', 'briefcase', 'bg-[#eaf2ff] text-[#075fe4]'],
        ['View Applications', 'Review candidates who applied', '/company/applications', 'users', 'bg-[#e8fbf3] text-[#00ad6f]'],
        ['Shortlist Candidates', 'Pick the best matches', '/company/shortlisted', 'star', 'bg-[#f0edff] text-[#6c50ff]'],
        ['Schedule Interview', 'Connect with candidates', '/company/interviews/create', 'calendar', 'bg-[#fff5e6] text-[#ff9c22]'],
    ];

    const iconWrap = (icon, classes) => `
        <div class="flex h-[58px] w-[58px] shrink-0 items-center justify-center rounded-full ${classes}">
            <div class="h-7 w-7 [&>svg]:h-full [&>svg]:w-full [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${iconSvg[icon]}</div>
        </div>
    `;

    const formatStatus = (status) => (status || '').replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
    const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '';

    function renderStats(statistics) {
        statsGrid.innerHTML = statMeta.map(([label, key, url, icon, classes]) => `
            <article class="flex min-h-[142px] min-w-0 items-center justify-center gap-[18px] rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                ${iconWrap(icon, classes)}
                <div class="min-w-0">
                    <h3 class="mb-[5px] text-[25px] font-bold text-[#061942]">${statistics?.[key] ?? 0}</h3>
                    <p class="mb-[15px] text-xs text-[#34445e]">${label}</p>
                    <a href="${url}" class="text-xs font-bold text-[#075fe4] hover:underline">View all</a>
                </div>
            </article>
        `).join('');
    }

    function renderActivities(data) {
        const activities = [];

        for (const application of data.recent_applications || []) {
            const candidate = application.fresher_profile?.user?.name || 'Candidate';
            const job = application.job?.title || 'job';
            activities.push({
                title: `${candidate} applied for ${job}`,
                time: formatDate(application.applied_at || application.created_at),
                icon: 'users',
                classes: 'bg-[#e8fbf3] text-[#00ad6f]',
            });
        }

        for (const job of data.recent_jobs || []) {
            activities.push({
                title: `${job.title || 'Job'} has ${job.applications_count || 0} applications`,
                time: formatDate(job.created_at),
                icon: 'briefcase',
                classes: 'bg-[#eaf2ff] text-[#075fe4]',
            });
        }

        for (const interview of data.upcoming_interviews || []) {
            const candidate = interview.job_application?.fresher_profile?.user?.name || 'Candidate';
            activities.push({
                title: `Interview scheduled with ${candidate}`,
                time: [interview.interview_date, interview.interview_time].filter(Boolean).join(' '),
                icon: 'calendar',
                classes: 'bg-[#f0edff] text-[#6c50ff]',
            });
        }

        if (!activities.length) {
            recentActivities.innerHTML = '<p class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 text-sm text-[#52607a]">No recent activity yet.</p>';
            return;
        }

        recentActivities.innerHTML = activities.slice(0, 7).map((activity) => `
            <div class="grid grid-cols-[42px_minmax(0,1fr)] items-center gap-x-[18px] border-b border-[#edf2fb] px-2 py-[11px] last:border-b-0 sm:grid-cols-[48px_minmax(0,1fr)_auto]">
                <div class="flex h-[42px] w-[42px] items-center justify-center rounded-[9px] ${activity.classes}">
                    <div class="h-5 w-5 [&>svg]:h-full [&>svg]:w-full [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${iconSvg[activity.icon]}</div>
                </div>
                <h3 class="min-w-0 break-words text-xs font-bold text-[#061942]">${activity.title}</h3>
                <time class="col-start-2 whitespace-nowrap text-xs text-[#34445e] sm:col-start-auto">${activity.time || ''}</time>
            </div>
        `).join('');
    }

    function renderActions() {
        quickActions.innerHTML = actions.map(([title, text, url, icon, classes]) => `
            <a href="${url}" class="grid min-h-[76px] grid-cols-[52px_minmax(0,1fr)_auto] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white px-[18px] py-[13px] shadow-[0_10px_24px_rgba(6,25,66,0.04)] transition hover:-translate-y-0.5 hover:border-[#bfd4f5] hover:shadow-[0_12px_28px_rgba(6,25,66,0.08)]">
                ${iconWrap(icon, classes)}
                <div class="min-w-0">
                    <h3 class="mb-[5px] text-[13px] font-bold text-[#061942]">${title}</h3>
                    <p class="text-xs text-[#34445e]">${text}</p>
                </div>
                <span class="text-[30px] leading-none text-[#061942]">&#8250;</span>
            </a>
        `).join('');
    }

    async function loadDashboard() {
        if (!token) {
            window.location.href = '/company/login';
            return;
        }

        const response = await fetch('/api/company/dashboard', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
        });

        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            window.location.href = '/company/login';
            return;
        }

        if (response.status === 404) {
            window.location.href = '/company/profile/edit';
            return;
        }

        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load dashboard.');
        }

        const data = result.data;
        const profile = data.company_profile;

        localStorage.setItem('ofc_company_profile', JSON.stringify(profile));

        if (profile.approval_status === 'pending') {
            window.location.href = '/company/approval/pending';
            return;
        }

        if (profile.approval_status === 'rejected') {
            window.location.href = '/company/approval/rejected';
            return;
        }

        document.getElementById('welcomeCompanyName').textContent = profile.company_name || data.user?.name || 'Company';
        document.getElementById('dashboardStatus').textContent = `Approval: ${formatStatus(profile.approval_status)}. Here's what's happening today.`;
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));

        renderStats(data.statistics);
        renderActivities(data);
        renderActions();
    }

    renderStats({});
    renderActions();
    loadDashboard().catch((error) => {
        document.getElementById('dashboardStatus').textContent = error.message || 'Unable to load dashboard.';
        recentActivities.innerHTML = '<p class="rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-4 text-sm text-[#ff3045]">Unable to load recent activity.</p>';
    });
</script>
@endpush
