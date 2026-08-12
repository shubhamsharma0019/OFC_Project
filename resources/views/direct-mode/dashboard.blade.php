@php
    $activePage = 'dashboard';
    $stats = [
        ['key' => 'applications', 'title' => 'Applied Jobs', 'value' => 0, 'note' => '0 this week', 'tone' => 'blue-soft', 'icon' => 'briefcase'],
        ['key' => 'assessments', 'title' => 'Assessments', 'value' => 0, 'note' => 'Not Started', 'tone' => 'green-soft', 'icon' => 'users'],
        ['key' => 'interviews', 'title' => 'Interviews', 'value' => 0, 'note' => 'Upcoming', 'tone' => 'purple-soft', 'icon' => 'calendar'],
        ['key' => 'offers', 'title' => 'Offers', 'value' => 0, 'note' => 'Keep applying', 'tone' => 'orange-soft', 'icon' => 'trophy'],
    ];
    $profileItems = [
        ['key' => 'basic', 'label' => 'Basic Information'],
        ['key' => 'education', 'label' => 'Education'],
        ['key' => 'skills', 'label' => 'Skills'],
        ['key' => 'resume', 'label' => 'Resume Upload'],
        ['key' => 'certifications', 'label' => 'Certifications'],
        ['key' => 'work', 'label' => 'Work Experience'],
    ];
    $skills = [
        ['key' => 'technical', 'name' => 'Technical Skills'],
        ['key' => 'aptitude', 'name' => 'Aptitude'],
        ['key' => 'communication', 'name' => 'Communication'],
    ];
    $actions = [
        ['title' => 'Complete Profile', 'icon' => 'user', 'url' => '/direct-mode/profile'],
        ['title' => 'Take Assessment', 'icon' => 'clipboard', 'url' => '/direct-mode/assessments'],
        ['title' => 'Browse Jobs', 'icon' => 'briefcase', 'url' => '/direct-mode/jobs'],
        ['title' => 'My Applications', 'icon' => 'file', 'url' => '/direct-mode/applications'],
        ['title' => 'Interview Schedule', 'icon' => 'calendar', 'url' => '/direct-mode/interviews'],
        ['title' => 'Offers', 'icon' => 'trophy', 'url' => '/direct-mode/offers'],
    ];
@endphp

@extends('layouts.direct-mode')

@section('title', 'Dashboard - Direct Mode')

@push('styles')
<style>
    .dashboard{padding:20px 24px 28px}.dash-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:16px}.card{background:#fff;border:1px solid #dce7f8;border-radius:12px;box-shadow:0 10px 24px rgba(6,25,66,.04)}.stat-card{min-height:112px;padding:18px 26px;display:grid;grid-template-columns:52px minmax(0,1fr);gap:24px;align-items:center}.stat-icon,.dash-icon{width:52px;height:52px;border-radius:14px;display:grid;place-items:center}.stat-icon svg,.dash-icon svg{width:27px;height:27px;fill:none!important;stroke:currentColor!important;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}.stat-card>div{min-width:0;display:grid;align-content:center}.blue-soft{background:#eaf2ff;color:#075fe4}.green-soft{background:#e1f8ec;color:#17a85d}.purple-soft{background:#efe7ff;color:#6d42e8}.orange-soft{background:#fff0dc;color:#f59b18}.stat-card h2{margin:0 0 8px;font-size:13px;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.stat-card strong{display:block;font-size:28px;line-height:.95;margin:0 0 9px}.stat-card small{display:block;color:#07883f;font-size:12px;line-height:1.2;font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.middle{display:grid;grid-template-columns:1.15fr 1fr 1.08fr;gap:14px;margin-bottom:16px}.section{padding:22px}.section h2{margin:0 0 18px;font-size:16px}.profile-box{display:grid;grid-template-columns:155px 1fr;gap:24px;align-items:center}.ring{width:132px;height:132px;border-radius:50%;display:grid;place-items:center;position:relative;background:conic-gradient(#075fe4 0 var(--value,0%),#e8edf6 var(--value,0%))}.ring.score{width:104px;height:104px}.ring:before{content:"";position:absolute;inset:17px;background:#fff;border-radius:50%}.ring span{position:relative;font-size:29px}.ring.score span{font-size:20px}.check-list{display:grid;gap:12px}.check-row{display:flex;align-items:center;gap:10px;color:#44577e;font-size:12px}.check{width:16px;height:16px;border-radius:50%;border:1px solid #9cafcd;display:grid;place-items:center;font-size:11px}.check.done{border:0;background:#19a85e;color:#fff}.score-wrap{display:grid;grid-template-columns:120px 1fr;align-items:center;gap:18px}.skill-row{display:grid;grid-template-columns:95px 1fr 36px;gap:10px;align-items:center;margin:13px 0;font-size:12px;font-weight:700}.bar{height:7px;border-radius:20px;background:#e8edf6;overflow:hidden}.bar span{display:block;height:100%;background:#075fe4}.notif-list{display:grid;gap:16px}.notif{display:grid;grid-template-columns:38px 1fr auto;gap:12px;align-items:center}.notif .dash-icon{width:38px;height:38px;border-radius:10px}.notif h3{margin:0 0 5px;font-size:13px}.notif p,.notif time{margin:0;color:#44577e;font-size:12px}.view{float:right;color:#075fe4;font-size:12px;font-weight:800}.bottom{display:grid;grid-template-columns:1.45fr .75fr;gap:14px}.job-list{display:grid}.job-row{display:grid;grid-template-columns:52px 1fr auto;gap:16px;align-items:center;padding:16px 0;border-bottom:1px solid #e6eef8}.job-row:last-child{border-bottom:0}.logo{width:48px;height:48px;border-radius:7px;background:#06356f;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px}.job-row h3{margin:0 0 5px;font-size:14px}.job-row p{margin:0 0 10px;color:#44577e;font-size:12px}.meta{display:flex;gap:18px;flex-wrap:wrap;color:#44577e;font-size:12px}.status{display:inline-flex;padding:8px 12px;border-radius:7px;font-size:12px;font-weight:800;background:#eaf2ff;color:#075fe4}.status.purple{background:#efe7ff;color:#6d42e8}.status.orange{background:#fff0dc;color:#f04b20}.job-side{text-align:right;color:#44577e;font-size:12px}.jobs-footer{text-align:center;padding-top:12px}.jobs-footer a{color:#075fe4;font-weight:800;font-size:13px}.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}.quick{height:78px;border:1px solid #dce7f8;border-radius:9px;background:#fff;display:grid;place-items:center;text-align:center;color:#075fe4;font-size:11px;font-weight:800;padding:8px}.boost-panel{margin-top:14px;min-height:150px;border-radius:10px;background:#eaf2ff;display:flex;align-items:center;justify-content:space-between;padding:24px;overflow:hidden}.boost-panel h3{margin:0 0 8px;color:#075fe4;font-size:17px;line-height:1.4}.boost-panel p{margin:0 0 16px;font-size:12px;color:#44577e}.rocket-mark{width:72px;height:72px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg);flex:0 0 auto}.empty{padding:18px 0;color:#44577e;font-size:12px}.dashboard-error{display:none;margin-bottom:14px;border:1px solid #ffd0d7;background:#fff1f2;color:#c8102e;border-radius:9px;padding:12px 14px;font-size:13px;font-weight:700}@media(max-width:1200px){.middle,.bottom{grid-template-columns:1fr}.dash-stats{grid-template-columns:repeat(2,1fr)}}@media(max-width:720px){.dashboard{padding:14px}.dash-stats{grid-template-columns:1fr}.profile-box,.score-wrap{grid-template-columns:1fr}.quick-grid{grid-template-columns:repeat(2,1fr)}.job-row{grid-template-columns:1fr}.job-side{text-align:left}}
</style>
@endpush

@section('content')
<section class="dashboard" data-dashboard>
    <div class="dashboard-error" data-dashboard-error></div>
    <div class="dash-stats">
        @foreach ($stats as $item)
            <article class="card stat-card" data-stat="{{ $item['key'] }}"><span class="stat-icon {{ $item['tone'] }}" data-icon="{{ $item['icon'] }}"></span><div><h2>{{ $item['title'] }}</h2><strong data-stat-value>{{ $item['value'] }}</strong><small data-stat-note>{{ $item['note'] }}</small></div></article>
        @endforeach
    </div>
    <div class="middle">
        <article class="card section">
            <h2>Profile Completion</h2>
            <div class="profile-box"><div><div class="ring" data-profile-ring style="--value:0%"><span data-profile-percent>0%</span></div><a class="primary" href="/direct-mode/profile" style="margin-top:22px;background:#fff;color:#075fe4;border:1px solid #075fe4;display:inline-flex;align-items:center">Update Profile</a></div><div class="check-list"><strong style="font-size:12px" data-profile-message>Complete your profile to get better matches.</strong>@foreach ($profileItems as $item)<div class="check-row" data-profile-item="{{ $item['key'] }}"><span class="check"></span><span>{{ $item['label'] }}</span></div>@endforeach</div></div>
        </article>
        <article class="card section">
            <h2>Assessment Score</h2>
            <div class="score-wrap"><div class="ring score" data-score-ring style="--value:0%"><span data-score-percent>0%</span></div><div><strong data-score-title>Assessment pending</strong><p style="margin:8px 0 16px;color:#44577e;font-size:12px" data-score-note>Take your assessment to unlock better matches.</p></div></div>
            @foreach ($skills as $skill)<div class="skill-row" data-skill="{{ $skill['key'] }}"><span>{{ $skill['name'] }}</span><div class="bar"><span style="width:0%"></span></div><strong>0%</strong></div>@endforeach
            <a class="primary" href="/direct-mode/assessments" style="margin-top:12px;background:#fff;color:#075fe4;border:1px solid #075fe4;display:inline-flex;align-items:center">View Assessment</a>
        </article>
        <article class="card section">
            <h2>Latest Notifications <a class="view" href="/direct-mode/activity">View All</a></h2>
            <div class="notif-list" data-notifications><div class="empty">Loading notifications...</div></div>
        </article>
    </div>
    <div class="bottom">
        <article class="card section">
            <h2>Recently Applied Jobs <a class="view" href="/direct-mode/applications">View All</a></h2>
            <div class="job-list" data-applications><div class="empty">Loading applications...</div></div>
            <div class="jobs-footer"><a href="/direct-mode/applications">View All Applications</a></div>
        </article>
        <aside>
            <article class="card section"><h2>Quick Actions</h2><div class="quick-grid">@foreach ($actions as $item)<a class="quick" href="{{ $item['url'] }}"><span data-icon="{{ $item['icon'] }}"></span><span>{{ $item['title'] }}</span></a>@endforeach</div></article>
            <article class="boost-panel"><div><h3 data-boost-title>Boost your profile &<br>get hired faster!</h3><p data-boost-text>Complete your profile and increase your chances.</p><a class="primary" href="/direct-mode/profile" style="display:inline-flex;align-items:center" data-boost-action>Complete Profile</a></div><span class="rocket-mark"></span></article>
        </aside>
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    Object.assign(window.directModeIcons || {}, {
        briefcase:'<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M4 12h16"></path></svg>',
        users:'<svg viewBox="0 0 24 24"><circle cx="10" cy="8" r="3.5"></circle><path d="M3.5 20a6.5 6.5 0 0 1 13 0"></path><path d="M17 9a3 3 0 0 1 0 6"></path><path d="M18.5 17.5a5 5 0 0 1 2 2.5"></path></svg>',
        calendar:'<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 3v4M16 3v4M4 10h16"></path></svg>',
        trophy:'<svg viewBox="0 0 24 24"><path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"></path><path d="M8 6H4v2a4 4 0 0 0 4 4"></path><path d="M16 6h4v2a4 4 0 0 1-4 4"></path><path d="M12 13v5"></path><path d="M8 20h8"></path></svg>',
    });
    document.querySelectorAll('.stat-card [data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
    const token = localStorage.getItem('onlyfreshers_token');
    const storedUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || 'null');
    const headers = { Accept: 'application/json', ...(token ? { Authorization: `Bearer ${token}` } : {}) };
    const qs = selector => document.querySelector(selector);
    const qsa = selector => [...document.querySelectorAll(selector)];
    const clamp = value => Math.max(0, Math.min(100, Number(value) || 0));
    const text = (selector, value) => { const el = qs(selector); if (el) el.textContent = value; };
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
    const initials = value => String(value || 'OF').split(/\s+/).filter(Boolean).slice(0,2).map(part => part[0]).join('').toUpperCase();
    const label = value => String(value || '').replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
    const timeAgo = value => {
        if (!value) return '';
        const seconds = Math.max(1, Math.floor((Date.now() - new Date(value).getTime()) / 1000));
        if (seconds < 60) return `${seconds}s ago`;
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes}m ago`;
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return `${hours}h ago`;
        const days = Math.floor(hours / 24);
        if (days < 7) return `${days}d ago`;
        return `${Math.floor(days / 7)}w ago`;
    };

    const setStat = (key, value, note) => {
        const card = qs(`[data-stat="${key}"]`);
        if (!card) return;
        card.querySelector('[data-stat-value]').textContent = value ?? 0;
        card.querySelector('[data-stat-note]').textContent = note || '';
    };

    const setRing = (ringSelector, textSelector, value) => {
        const score = clamp(value);
        const ring = qs(ringSelector);
        if (ring) ring.style.setProperty('--value', `${score}%`);
        text(textSelector, `${score}%`);
    };

    const setTopUser = (user, unreadCount) => {
        const name = user?.name || storedUser?.name || 'Fresher';
        const topName = qs('.top-user strong');
        const bell = qs('.top-bell b');
        const avatar = qs('.top-avatar');
        if (topName) topName.textContent = name;
        if (bell) bell.textContent = unreadCount ?? 0;
        if (avatar) {
            avatar.style.backgroundImage = `url('/student.svg')`;
            avatar.setAttribute('title', name);
        }
    };

    const renderProfile = profile => {
        const completion = clamp(profile?.profile_completion);
        setRing('[data-profile-ring]', '[data-profile-percent]', completion);
        text('[data-profile-message]', completion >= 80 ? 'Great! Your profile is almost complete.' : 'Complete your profile to get better matches.');
        const done = {
            basic: true,
            education: Boolean(profile?.qualification),
            skills: Boolean(profile?.skills),
            resume: Boolean(profile?.resume_uploaded),
            certifications: false,
            work: false,
        };
        qsa('[data-profile-item]').forEach(row => {
            const mark = row.querySelector('.check');
            const isDone = Boolean(done[row.dataset.profileItem]);
            mark.classList.toggle('done', isDone);
            mark.innerHTML = isDone ? '&#10003;' : '';
        });
        const boostTitle = qs('[data-boost-title]');
        if (boostTitle) boostTitle.innerHTML = completion >= 80 ? 'Your profile is<br>looking strong!' : 'Boost your profile &<br>get hired faster!';
        text('[data-boost-text]', completion >= 80 ? 'Browse jobs matched to your profile.' : 'Complete your profile and increase your chances.');
        const action = qs('[data-boost-action]');
        if (action && completion >= 80) {
            action.textContent = 'Browse Jobs';
            action.href = '/direct-mode/jobs';
        }
    };

    const renderAssessment = assessment => {
        const result = assessment?.result || {};
        const total = clamp(result.percentage ?? result.score_percentage ?? result.total_score ?? 0);
        setRing('[data-score-ring]', '[data-score-percent]', total);
        text('[data-score-title]', total ? (total >= 70 ? 'Good job!' : 'Keep improving!') : 'Assessment pending');
        text('[data-score-note]', total ? 'Keep improving.' : 'Take your assessment to unlock better matches.');
        const values = {
            technical: result.technical_score ?? result.technical_skills ?? total,
            aptitude: result.aptitude_score ?? total,
            communication: result.communication_score ?? total,
        };
        qsa('[data-skill]').forEach(row => {
            const value = clamp(values[row.dataset.skill]);
            row.querySelector('.bar span').style.width = `${value}%`;
            row.querySelector('strong').textContent = `${value}%`;
        });
    };

    const renderApplications = applications => {
        const box = qs('[data-applications]');
        if (!box) return;
        if (!applications?.length) {
            box.innerHTML = '<div class="empty">No applications yet. Browse jobs and apply directly.</div>';
            return;
        }
        box.innerHTML = applications.map(item => {
            const job = item.job || {};
            const company = job.company_profile || job.companyProfile || {};
            const companyName = company.company_name || 'Company';
            const status = item.application_status || 'under_review';
            const tone = status === 'shortlisted' ? 'purple' : status === 'interview_scheduled' ? 'orange' : '';
            return `<div class="job-row"><span class="logo">${esc(initials(companyName))}</span><div><h3>${esc(job.title || 'Job Role')}</h3><p>${esc(companyName)}</p><div class="meta"><span>${esc(job.location || 'Location not added')}</span><span>${esc(job.job_type || 'Fresher')}</span><span>${esc(job.salary || 'Salary not disclosed')}</span></div></div><div class="job-side"><p>${esc(timeAgo(item.applied_at))}</p><span class="status ${tone}">${esc(label(status))}</span></div></div>`;
        }).join('');
    };

    const renderNotifications = notifications => {
        const box = qs('[data-notifications]');
        if (!box) return;
        if (!notifications?.length) {
            box.innerHTML = '<div class="empty">No notifications yet.</div>';
            return;
        }
        const iconByType = { job: 'briefcase', interview: 'calendar', assessment: 'file', application: 'bell' };
        const toneByType = { job: 'green-soft', interview: 'purple-soft', assessment: 'orange-soft', application: 'blue-soft' };
        box.innerHTML = notifications.slice(0, 4).map(item => {
            const icon = iconByType[item.type] || 'bell';
            const tone = toneByType[item.type] || 'blue-soft';
            return `<div class="notif"><span class="dash-icon ${tone}" data-icon="${icon}"></span><div><h3>${esc(item.title)}</h3><p>${esc(item.message)}</p></div><time>${esc(timeAgo(item.created_at))}</time></div>`;
        }).join('');
        qsa('[data-notifications] [data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
    };

    const showError = message => {
        const box = qs('[data-dashboard-error]');
        if (!box) return;
        box.style.display = 'block';
        box.textContent = message;
    };

    const getJson = async url => {
        const response = await fetch(url, { headers });
        const data = await response.json().catch(() => ({}));
        if (!response.ok) throw new Error(data.message || 'Unable to load dashboard data.');
        return data.data;
    };

    const loadDashboard = async () => {
        setTopUser(storedUser, 0);
        if (!token) {
            showError('Please login again to load your dashboard data.');
            return;
        }
        try {
            const [dashboard, notificationData, unreadData] = await Promise.all([
                getJson('/api/fresher/dashboard'),
                getJson('/api/notifications?per_page=4').catch(() => ({ notifications: { data: [] } })),
                getJson('/api/notifications/unread-count').catch(() => ({ unread_count: 0 })),
            ]);
            const stats = dashboard.statistics || {};
            const assessment = dashboard.initial_assessment;
            const applications = dashboard.recent_applications || [];
            const notifications = notificationData.notifications?.data || [];
            const assessmentDone = assessment ? 1 : 0;
            setTopUser(dashboard.user, unreadData.unread_count);
            setStat('applications', stats.total_applications, `${stats.under_review_applications || 0} under review`);
            setStat('assessments', assessmentDone, assessment ? '1 Completed' : 'Not Started');
            setStat('interviews', stats.scheduled_interviews, 'Upcoming');
            setStat('offers', stats.hired_applications, stats.hired_applications ? 'Congratulations!' : 'Keep applying');
            renderProfile(dashboard.profile);
            renderAssessment(assessment);
            renderApplications(applications);
            renderNotifications(notifications);
        } catch (error) {
            showError(error.message);
            setTopUser(storedUser, 0);
        }
    };

    loadDashboard();
})();
</script>
@endpush
