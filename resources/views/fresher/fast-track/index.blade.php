@extends('layouts.fast-track')

@section('title', 'Dashboard - Fast Track')

@php
    $activePage = 'dashboard';
@endphp

@section('content')
    <section class="space-y-6">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Dashboard</h1>
        </div>

        <div>
            <p class="mb-2 text-base font-medium text-[#24344f]">Welcome back,</p>
            <h2 id="welcomeName" class="text-[22px] font-bold leading-tight text-[#061942]">Fresher!</h2>
        </div>

        <div class="grid items-start gap-8 xl:grid-cols-[500px_minmax(0,1fr)]">
            <div class="space-y-5">
                <div id="dashboardStatsGrid" class="grid gap-5 sm:grid-cols-2">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2">Loading dashboard...</article>
                </div>

                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Quick Actions</h3>
                    <div id="quickActions" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <p class="text-sm text-[#334b83] sm:col-span-2 xl:col-span-4">Loading actions...</p>
                    </div>
                </article>
            </div>

            <div class="space-y-8">
                <article class="rounded-lg border border-[#dce7f8] bg-white px-6 py-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:px-7">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Recent Activity</h3>
                    <div id="recentActivity">
                        <p class="text-sm text-[#334b83]">Loading activity...</p>
                    </div>
                </article>

                <article id="latestTrainingCard" class="relative flex min-h-[220px] items-center overflow-hidden rounded-lg border border-[#dce7f8] bg-gradient-to-r from-white to-[#eef5ff] p-8 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="relative z-10 max-w-[360px]">
                        <h3 class="mb-4 text-[22px] font-bold text-[#061942]">Fast Track Your Career</h3>
                        <p class="mb-6 text-[15px] leading-6 text-[#24344f]">Enroll in Fast Track Courses and get placed in top companies.</p>
                        <a href="/fast-track/courses" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]">Explore Courses</a>
                    </div>
                    <div class="absolute bottom-7 right-12 hidden h-[155px] w-[155px] rotate-[-28deg] items-center justify-center rounded-full bg-[#e1edff] text-[58px] font-black text-[#075fe4] sm:flex">^</div>
                </article>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const welcomeName = document.getElementById('welcomeName');
    const dashboardStatsGrid = document.getElementById('dashboardStatsGrid');
    const quickActions = document.getElementById('quickActions');
    const recentActivity = document.getElementById('recentActivity');
    const latestTrainingCard = document.getElementById('latestTrainingCard');

    function circleCard(label, value, color) {
        const safeValue = Math.max(0, Math.min(100, Number(value || 0)));
        return `<article class="flex min-h-[190px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white p-6 text-center shadow-[0_10px_24px_rgba(6,25,66,.04)]"><div><div class="mx-auto mb-4 flex h-[116px] w-[116px] items-center justify-center rounded-full" style="background:conic-gradient(${color} 0 ${safeValue}%, #e9edf5 ${safeValue}% 100%);"><span class="flex h-[86px] w-[86px] items-center justify-center rounded-full bg-white text-[28px] font-bold text-[#061942]">${safeValue}%</span></div><h3 class="text-base font-medium leading-snug text-[#061942]">${FastTrack.esc(label)}</h3></div></article>`;
    }
    function smallCard(icon, label, value) {
        return `<article class="grid min-h-[125px] grid-cols-[64px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]"><span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">${icon}</span><div><div class="mb-1 text-[26px] font-bold leading-none text-[#061942]">${FastTrack.esc(value)}</div><p class="text-sm leading-snug text-[#24344f]">${FastTrack.esc(label)}</p></div></article>`;
    }
    function actionCard(icon, title, url, done) {
        return `<a class="flex min-h-[132px] flex-col items-center justify-center gap-3 rounded-lg border ${done ? 'border-[#bcebd0] bg-[#f2fff7]' : 'border-[#dce7f8] bg-white'} px-4 text-center text-sm font-bold leading-snug text-[#061942] transition hover:border-[#075fe4] hover:bg-[#eff5ff] hover:text-[#075fe4]" href="${url}"><span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">${icon}</span><span>${FastTrack.esc(title)}</span><small class="text-xs ${done ? 'text-[#078346]' : 'text-[#536484]'}">${done ? 'Done' : 'Pending'}</small></a>`;
    }
    function activityItem(icon, title, date) {
        return `<div class="grid grid-cols-[44px_minmax(0,1fr)] items-center gap-4 border-b border-[#e5edf8] py-4 text-sm last:border-b-0 sm:grid-cols-[44px_minmax(0,1fr)_auto]"><span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">${icon}</span><span class="font-semibold text-[#061942]">${FastTrack.esc(title)}</span><time class="col-start-2 whitespace-nowrap text-[#24344f] sm:col-start-auto">${FastTrack.esc(date || '-')}</time></div>`;
    }
    function renderDashboard(data, unread) {
        const user = data.user || FastTrack.user() || {};
        const profile = data.profile || {};
        const stats = data.statistics || {};
        const assessment = data.initial_assessment || null;
        const result = assessment?.result || {};
        const score = result.overall_score || result.score_percentage || result.score || 0;
        const latestEnrollment = data.latest_course_enrollment || null;

        welcomeName.textContent = (user.name || user.email || 'Fresher') + '!';
        localStorage.setItem('ofc_auth_user', JSON.stringify(user));

        dashboardStatsGrid.innerHTML = [
            circleCard('Profile Completion', profile.profile_completion || 0, '#19a85b'),
            circleCard('Assessment Score', score, '#7744eb'),
            smallCard('TR', 'Current Training', stats.active_trainings || stats.total_course_enrollments || 0),
            smallCard('NT', 'Notifications', unread || 0),
        ].join('');

        quickActions.innerHTML = [
            actionCard('CP', 'Complete Profile', '/fast-track/profile', Number(profile.profile_completion || 0) >= 100),
            actionCard('GA', 'Initial Assessment', '/fast-track/assessment', !!assessment),
            actionCard('EF', 'Explore Fast Track', '/fast-track/courses', !!latestEnrollment),
            actionCard('VT', 'View Training', '/fast-track/training', Number(stats.total_course_enrollments || 0) > 0),
        ].join('');

        const activities = [];
        if (profile.profile_id) activities.push(['PR', 'Profile loaded successfully', profile.qualification || profile.city || 'Profile active']);
        if (assessment) activities.push(['AS', 'Initial assessment completed', FastTrack.date(assessment.submitted_at)]);
        (data.recent_applications || []).forEach((item) => activities.push(['AP', 'Applied for ' + FastTrack.courseName(item.job || { course_name: item.job?.title || 'Job' }), FastTrack.date(item.applied_at)]));
        (data.recent_certificates || []).forEach((item) => activities.push(['CE', 'Certificate earned', FastTrack.date(item.created_at)]));
        if (latestEnrollment) activities.push(['EN', 'Enrolled in ' + FastTrack.courseName(latestEnrollment.course), FastTrack.date(latestEnrollment.enrollment_date)]);
        recentActivity.innerHTML = activities.length ? activities.slice(0, 6).map((item) => activityItem(item[0], item[1], item[2])).join('') : '<p class="text-sm text-[#334b83]">No recent activity yet.</p>';

        if (latestEnrollment?.course) {
            const progress = FastTrack.progress(latestEnrollment);
            latestTrainingCard.innerHTML = `<div class="relative z-10 w-full max-w-[420px]"><h3 class="mb-3 text-[22px] font-bold text-[#061942]">${FastTrack.esc(FastTrack.courseName(latestEnrollment.course))}</h3><p class="mb-4 text-[15px] leading-6 text-[#24344f]">${FastTrack.esc(FastTrack.partnerName(latestEnrollment.course))}</p><div class="mb-5 h-3 overflow-hidden rounded-full bg-[#dce7f8]"><div class="h-full rounded-full bg-[#075fe4]" style="width:${progress}%"></div></div><div class="flex flex-wrap gap-3"><a href="/fast-track/training-progress" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">View Progress</a><a href="/fast-track/course-details?course=${encodeURIComponent(latestEnrollment.course.id)}" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-white px-6 text-sm font-bold text-[#075fe4]">Course Details</a></div></div>`;
        }
    }
    function renderProfileMissing() {
        dashboardStatsGrid.innerHTML = [
            circleCard('Profile Completion', 0, '#19a85b'),
            circleCard('Assessment Score', 0, '#7744eb'),
            smallCard('TR', 'Current Training', 0),
            smallCard('NT', 'Notifications', 0),
        ].join('');
        quickActions.innerHTML = [
            actionCard('CP', 'Complete Profile', '/fast-track/profile', false),
            actionCard('GA', 'Initial Assessment', '/fast-track/assessment', false),
            actionCard('EF', 'Explore Fast Track', '/fast-track/courses', false),
            actionCard('VT', 'View Training', '/fast-track/training', false),
        ].join('');
        recentActivity.innerHTML = '<p class="text-sm text-[#334b83]">Complete your profile to unlock dashboard activity.</p>';
    }
    Promise.all([
        FastTrack.getJson('/api/fresher/dashboard').catch((error) => ({ error })),
        FastTrack.getJson('/api/notifications/unread-count').catch(() => ({ data: { unread_count: 0 } })),
    ]).then(function (responses) {
        const dashboardResponse = responses[0];
        const unread = FastTrack.apiData(responses[1], 'unread_count') || 0;
        if (dashboardResponse.error) {
            renderProfileMissing();
            return;
        }
        renderDashboard(FastTrack.apiData(dashboardResponse) || {}, unread);
    }).catch(renderProfileMissing);
</script>
@endpush
