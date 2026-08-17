@php
    $activePage = 'dashboard';
    $stats = [
        ['key' => 'applications', 'title' => 'Applied Jobs', 'value' => 0, 'note' => '0 this week', 'tone' => 'blue-soft', 'icon' => 'briefcase'],
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
    .dashboard{padding:20px 24px 28px}.dash-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-bottom:20px}.card{background:#fff;border:1px solid #dce7f8;border-radius:12px;box-shadow:0 10px 24px rgba(6,25,66,.04)}.stat-card{min-height:118px;padding:20px 26px;display:grid;grid-template-columns:58px minmax(0,1fr);gap:22px;align-items:center}.stat-icon,.dash-icon{width:58px;height:58px;border-radius:16px;display:grid;place-items:center}.stat-icon svg,.dash-icon svg{width:28px;height:28px;fill:none!important;stroke:currentColor!important;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}.stat-card>div{min-width:0;display:grid;align-content:center}.blue-soft{background:#eaf2ff;color:#075fe4}.green-soft{background:#e1f8ec;color:#17a85d}.purple-soft{background:#efe7ff;color:#6d42e8}.orange-soft{background:#fff0dc;color:#f59b18}.stat-card h2{margin:0 0 8px;font-size:14px;line-height:1.2;white-space:normal;overflow-wrap:anywhere}.stat-card strong{display:block;font-size:31px;line-height:.95;margin:0 0 10px}.stat-card small{display:block;color:#07883f;font-size:13px;line-height:1.2;font-weight:800;white-space:normal;overflow-wrap:anywhere}.middle{display:grid;grid-template-columns:minmax(0,1.08fr) minmax(0,.92fr);gap:18px;margin-bottom:20px;align-items:stretch}.section{padding:24px 28px}.section h2{margin:0 0 22px;font-size:17px}.profile-box{display:grid;grid-template-columns:190px minmax(0,1fr);gap:30px;align-items:center;min-height:230px}.ring{width:142px;height:142px;border-radius:50%;display:grid;place-items:center;position:relative;background:conic-gradient(#075fe4 0 var(--value,0%),#e8edf6 var(--value,0%))}.ring.score{width:104px;height:104px}.ring:before{content:"";position:absolute;inset:20px;background:#fff;border-radius:50%}.ring span{position:relative;font-size:31px}.ring.score span{font-size:20px}.check-list{display:grid;gap:13px;align-content:center}.check-row{display:flex;align-items:center;gap:12px;color:#24406f;font-size:14px}.check{width:18px;height:18px;border-radius:50%;border:1px solid #9cafcd;display:grid;place-items:center;font-size:11px;flex:0 0 auto}.check.done{border:0;background:#19a85e;color:#fff}.score-wrap{display:grid;grid-template-columns:120px 1fr;align-items:center;gap:18px}.skill-row{display:grid;grid-template-columns:95px 1fr 36px;gap:10px;align-items:center;margin:13px 0;font-size:12px;font-weight:700}.bar{height:7px;border-radius:20px;background:#e8edf6;overflow:hidden}.bar span{display:block;height:100%;background:#075fe4}.notif-list{display:grid;gap:10px;align-content:start;min-height:230px}.notif{display:grid;grid-template-columns:38px minmax(0,1fr) auto;gap:12px;align-items:center}.notif .dash-icon{width:38px;height:38px;border-radius:10px}.notif h3{margin:0 0 5px;font-size:13px;overflow-wrap:anywhere}.notif p,.notif time{margin:0;color:#44577e;font-size:12px;overflow-wrap:anywhere}.view{float:right;color:#075fe4;font-size:12px;font-weight:800}.bottom{display:grid;grid-template-columns:1.45fr .75fr;gap:14px;margin-bottom:18px}.job-list{display:grid}.job-row{display:grid;grid-template-columns:52px minmax(0,1fr) auto;gap:16px;align-items:center;padding:16px 0;border-bottom:1px solid #e6eef8}.job-row:last-child{border-bottom:0}.logo{width:48px;height:48px;border-radius:7px;background:#06356f;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px}.job-row h3{margin:0 0 5px;font-size:14px;overflow-wrap:anywhere}.job-row p{margin:0 0 10px;color:#44577e;font-size:12px;overflow-wrap:anywhere}.meta{display:flex;gap:18px;flex-wrap:wrap;color:#44577e;font-size:12px}.status{display:inline-flex;padding:8px 12px;border-radius:7px;font-size:12px;font-weight:800;background:#eaf2ff;color:#075fe4}.status.purple{background:#efe7ff;color:#6d42e8}.status.orange{background:#fff0dc;color:#f04b20}.job-side{text-align:right;color:#44577e;font-size:12px}.jobs-footer{text-align:center;padding-top:12px}.jobs-footer a{color:#075fe4;font-weight:800;font-size:13px}.quick-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}.quick{height:auto;min-height:78px;border:1px solid #dce7f8;border-radius:9px;background:#fff;display:grid;place-items:center;text-align:center;color:#075fe4;font-size:11px;line-height:1.2;font-weight:800;padding:8px;overflow:hidden;overflow-wrap:anywhere}.boost-panel{margin-top:18px;min-height:150px;border-radius:10px;background:#eaf2ff;display:flex;align-items:center;justify-content:space-between;padding:24px;overflow:hidden}.boost-panel h3{margin:0 0 8px;color:#075fe4;font-size:17px;line-height:1.4}.boost-panel p{margin:0 0 16px;font-size:12px;color:#44577e}.rocket-mark{width:72px;height:72px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg);flex:0 0 auto}.empty{padding:18px 0;color:#24406f;font-size:13px}.dashboard-error{display:none;margin-bottom:14px;border:1px solid #ffd0d7;background:#fff1f2;color:#c8102e;border-radius:9px;padding:12px 14px;font-size:13px;font-weight:700}@media(max-width:1200px){.middle,.bottom{grid-template-columns:1fr}.dash-stats{grid-template-columns:repeat(2,1fr)}}@media(max-width:720px){.dashboard{padding:14px}.dash-stats{grid-template-columns:1fr}.profile-box,.score-wrap{grid-template-columns:1fr}.quick-grid{grid-template-columns:repeat(2,1fr)}.job-row{grid-template-columns:1fr}.job-side{text-align:left}}
    .dashboard,.dashboard *{min-width:0}.middle,.bottom,.dash-stats,.quick-grid{width:100%;max-width:100%}.direct-hero{position:relative;display:grid;grid-template-columns:1.05fr 1.25fr;gap:14px;margin-bottom:16px;border:1px solid #dbe8fb;border-radius:12px;background:linear-gradient(135deg,#edf5ff,#f8fbff);padding:12px;box-shadow:0 12px 30px rgba(7,95,228,.10);overflow:hidden}.direct-hero:before{content:"";position:absolute;right:-70px;top:-90px;width:230px;height:230px;border-radius:50%;background:rgba(7,95,228,.08);filter:blur(10px)}.direct-hero>*{position:relative}.direct-hero-profile{display:flex;align-items:center;gap:18px;border-radius:10px;background:rgba(238,245,255,.9);padding:14px 18px}.direct-hero-avatar{width:86px;height:86px;flex:0 0 auto;border-radius:50%;border:3px solid #fff;background:#eef4ff url('/fast-track-hero-girl.png') center top/cover no-repeat;box-shadow:0 10px 22px rgba(6,25,66,.14)}.direct-hero-profile small{display:block;margin-bottom:4px;font-size:12px;font-weight:800;color:#061942}.direct-hero-profile h1{margin:0 0 8px;font-size:23px;line-height:1.1}.verified-line{display:inline-flex;align-items:center;gap:6px;margin-bottom:12px;color:#075fe4;font-size:12px;font-weight:800}.verified-line b{display:grid;place-items:center;width:16px;height:16px;border-radius:50%;background:#075fe4;color:#fff;font-size:10px}.direct-hero-profile p{margin:0 0 4px;font-size:12px;font-weight:700;color:#34445e}.direct-hero-actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}.hero-btn{display:inline-flex;height:32px;align-items:center;justify-content:center;border-radius:7px;padding:0 13px;font-size:11px;font-weight:900}.hero-btn.primary-hero{background:#075fe4;color:#fff}.hero-btn.secondary-hero{border:1px solid #9bb7dc;background:#fff;color:#075fe4}.direct-hero-info{display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:18px;border:1px solid #e0e9f6;border-radius:10px;background:#fff;padding:18px 22px;box-shadow:0 4px 16px rgba(6,25,66,.05)}.credit-mini{display:flex;align-items:center;gap:16px}.credit-mini .dash-icon{width:52px;height:52px;border-radius:50%;background:#edf5ff;color:#075fe4}.credit-mini small,.apply-copy small{display:block;margin-bottom:7px;font-size:10px;font-weight:900;text-transform:uppercase;color:#061942}.credit-mini strong{display:block;font-size:28px;line-height:1;color:#061942}.credit-mini span{font-size:12px;font-weight:700;color:#34445e}.apply-copy{border-left:1px solid #e7eef8;padding-left:20px}.apply-copy h2{margin:0 0 8px;font-size:14px}.apply-copy p{margin:0 0 10px;max-width:300px;font-size:12px;font-weight:700;line-height:1.55;color:#34445e}.apply-copy a{font-size:12px;font-weight:800;color:#075fe4}.dash-stats{grid-template-columns:repeat(3,minmax(0,1fr))!important}.section{overflow:hidden}.stat-card{overflow:hidden;border-radius:10px!important;background:#fff!important;box-shadow:0 8px 20px rgba(6,25,66,.04)!important;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease}.stat-card:hover,.quick:hover{transform:translateY(-2px);border-color:#9bb7dc;box-shadow:0 14px 28px rgba(7,95,228,.10)!important}.notif{align-items:start}.notif time{white-space:nowrap}.section h2{line-height:1.25}.profile-box>div:first-child,.score-wrap>div:first-child{display:grid;justify-items:center}.primary{justify-content:center}.quick span:last-child{max-width:100%;overflow-wrap:anywhere}.quick{transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease}.boost-panel{background:linear-gradient(135deg,#eaf2ff,#dff6ef)!important;border:1px solid #cfe0ff;box-shadow:0 12px 28px rgba(7,95,228,.08)}.boost-panel .primary{box-shadow:0 8px 16px rgba(7,95,228,.16)}.job-row{transition:background .18s ease}.job-row:hover{background:#f8fbff}@media(max-width:1450px){.direct-hero{grid-template-columns:1fr}.dash-stats{grid-template-columns:repeat(3,minmax(0,1fr))!important}.stat-card{padding:18px;gap:16px}.middle{grid-template-columns:minmax(0,1fr) minmax(0,.9fr);align-items:stretch}.middle .section:nth-child(3){grid-column:1 / -1}.notif-list{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.bottom{grid-template-columns:minmax(0,1fr) minmax(300px,.42fr)}}@media(max-width:1180px){.dash-stats{grid-template-columns:repeat(2,minmax(0,1fr))!important}.middle,.bottom{grid-template-columns:1fr}.middle .section:nth-child(3){grid-column:auto}.notif-list{grid-template-columns:1fr}.quick-grid{grid-template-columns:repeat(3,minmax(0,1fr))}.boost-panel{margin-bottom:16px}}@media(max-width:760px){.dashboard{padding:14px!important}.direct-hero-profile,.direct-hero-info{grid-template-columns:1fr;display:grid}.direct-hero-profile{justify-items:center;text-align:center}.direct-hero-actions{justify-content:center}.apply-copy{border-left:0;border-top:1px solid #e7eef8;padding-left:0;padding-top:16px}.dash-stats{grid-template-columns:repeat(2,minmax(0,1fr))!important;gap:10px}.stat-card{min-height:92px;grid-template-columns:42px minmax(0,1fr);gap:10px;padding:14px}.stat-icon,.dash-icon{width:42px;height:42px;border-radius:12px}.stat-icon svg,.dash-icon svg{width:22px;height:22px}.stat-card h2{font-size:12px;margin-bottom:6px}.stat-card strong{font-size:24px;margin-bottom:6px}.stat-card small{font-size:11px}.section{padding:16px}.profile-box{grid-template-columns:1fr;justify-items:center;text-align:left}.check-list{width:100%}.score-wrap{grid-template-columns:92px minmax(0,1fr);gap:14px}.ring{width:116px;height:116px}.ring.score{width:88px;height:88px}.ring.score span{font-size:18px}.skill-row{grid-template-columns:minmax(88px,.8fr) minmax(0,1fr) 44px;gap:8px}.notif{grid-template-columns:38px minmax(0,1fr);gap:10px}.notif time{grid-column:2;white-space:normal}.job-row{grid-template-columns:48px minmax(0,1fr);align-items:start}.job-side{grid-column:2;text-align:left}.quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.boost-panel{align-items:flex-start;padding:18px}.rocket-mark{width:58px;height:58px}}@media(max-width:520px){.dash-stats{grid-template-columns:1fr!important}.score-wrap{grid-template-columns:1fr;justify-items:center;text-align:center}.skill-row{grid-template-columns:1fr 1fr 42px;width:100%}.quick-grid{grid-template-columns:1fr}.job-row{grid-template-columns:1fr}.job-side{grid-column:auto}.boost-panel{display:grid;grid-template-columns:1fr;gap:14px}.rocket-mark{display:none}.view{float:none;display:inline-flex;margin-left:8px}}
</style>
<style>
    .dashboard .dash-stats {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 18px !important;
        margin-bottom: 20px !important;
    }
    .dashboard .stat-card {
        min-height: 118px !important;
        grid-template-columns: 58px minmax(0, 1fr) !important;
        gap: 22px !important;
        padding: 20px 26px !important;
        align-items: center !important;
    }
    .dashboard .stat-icon {
        width: 58px !important;
        height: 58px !important;
        border-radius: 16px !important;
    }
    .dashboard .stat-card h2 {
        margin-bottom: 8px !important;
        font-size: 14px !important;
    }
    .dashboard .stat-card strong {
        margin-bottom: 10px !important;
        font-size: 31px !important;
    }
    .dashboard .stat-card small {
        font-size: 13px !important;
    }
    .dashboard .middle {
        grid-template-columns: minmax(0, 1.08fr) minmax(0, .92fr) !important;
        gap: 18px !important;
        align-items: stretch !important;
        margin-bottom: 20px !important;
    }
    .dashboard .middle .section {
        min-height: 345px;
        padding: 24px 28px !important;
    }
    .dashboard .profile-box {
        grid-template-columns: 190px minmax(0, 1fr) !important;
        gap: 30px !important;
        align-items: center !important;
        min-height: 250px;
    }
    .dashboard .profile-box > div:first-child {
        align-self: center;
    }
    .dashboard .ring {
        width: 142px !important;
        height: 142px !important;
    }
    .dashboard .ring span {
        font-size: 31px !important;
    }
    .dashboard .check-list {
        align-content: center !important;
        gap: 13px !important;
    }
    .dashboard .check-row {
        gap: 12px !important;
        font-size: 14px !important;
        color: #24406f !important;
    }
    .dashboard .check {
        width: 18px !important;
        height: 18px !important;
        flex: 0 0 auto;
    }
    .dashboard .notif-list {
        min-height: 250px;
        align-content: start;
    }
    .dashboard .empty {
        padding: 28px 0 !important;
        font-size: 13px !important;
        color: #24406f !important;
    }
    @media (max-width: 1180px) {
        .dashboard .middle {
            grid-template-columns: 1fr !important;
        }
        .dashboard .dash-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 760px) {
        .dashboard .profile-box {
            grid-template-columns: 1fr !important;
            justify-items: center;
        }
        .dashboard .dash-stats {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@section('content')
<section class="dashboard" data-dashboard>
    <div class="dashboard-error" data-dashboard-error></div>
    <section class="direct-hero">
        <article class="direct-hero-profile">
            <span class="direct-hero-avatar" aria-hidden="true"></span>
            <div>
                <small>Welcome,</small>
                <h1 data-dashboard-name>Fresher</h1>
                <span class="verified-line"><b>✓</b> Verified Fresher</span>
                <p data-dashboard-education>B.Tech - Computer Science</p>
                <p data-dashboard-location>Delhi, India</p>
                <div class="direct-hero-actions">
                    <a class="hero-btn primary-hero" href="/direct-mode/jobs">Apply Jobs</a>
                    <a class="hero-btn secondary-hero" href="/direct-mode/profile">Update Profile</a>
                </div>
            </div>
        </article>
        <article class="direct-hero-info">
            <div class="credit-mini">
                <span class="dash-icon" data-icon="briefcase"></span>
                <div>
                    <small>Direct Mode</small>
                    <strong data-direct-app-count>0</strong>
                    <span>Applications</span>
                </div>
            </div>
            <div class="apply-copy">
                <small>Apply to Jobs</small>
                <h2>Keep applying to matching roles</h2>
                <p>Your Direct Mode dashboard tracks profile readiness, job applications, interviews and offers.</p>
                <a href="/direct-mode/jobs">Browse Jobs</a>
            </div>
        </article>
    </section>
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
            <article class="card section"><h2>Quick Actions</h2><div class="quick-grid" data-quick-actions>@foreach ($actions as $item)<a class="quick" href="{{ $item['url'] }}"><span data-icon="{{ $item['icon'] }}"></span><span>{{ $item['title'] }}</span></a>@endforeach</div></article>
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

    const numberFrom = (...values) => {
        for (const value of values) {
            if (value !== undefined && value !== null && value !== '') return Number(value) || 0;
        }
        return 0;
    };

    const listFrom = value => {
        if (Array.isArray(value)) return value;
        if (Array.isArray(value?.data)) return value.data;
        if (Array.isArray(value?.notifications)) return value.notifications;
        if (Array.isArray(value?.notifications?.data)) return value.notifications.data;
        return [];
    };

    const setTopUser = (user, unreadCount) => {
        const name = user?.name || storedUser?.name || 'Fresher';
        const topName = qs('.top-user strong');
        const bell = qs('.top-bell b');
        const avatar = qs('.top-avatar');
        text('[data-dashboard-name]', name);
        if (topName) topName.textContent = name;
        if (bell) bell.textContent = unreadCount ?? 0;
        if (avatar) {
            avatar.style.backgroundImage = `url('/student.svg')`;
            avatar.setAttribute('title', name);
        }
    };

    const storageUrl = path => {
        if (!path) return '';
        if (/^(https?:)?\/\//.test(path) || String(path).startsWith('/')) return path;
        return `/storage/${path}`;
    };

    const hydrateHeroProfile = (profile, user) => {
        text('[data-dashboard-name]', user?.name || storedUser?.name || 'Fresher');
        text('[data-dashboard-education]', profile?.qualification || 'Qualification not added');
        text('[data-dashboard-location]', profile?.city || profile?.location || 'Location not added');

        const photo = storageUrl(profile?.profile_photo);
        const heroAvatar = qs('.direct-hero-avatar');
        if (heroAvatar && photo) {
            heroAvatar.style.backgroundImage = `url('${photo}')`;
        }
    };

    const renderProfile = profile => {
        const completion = clamp(profile?.profile_completion);
        hydrateHeroProfile(profile, null);
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

    const renderQuickActions = dashboard => {
        const box = qs('[data-quick-actions]');
        if (!box) return;
        const stats = dashboard?.statistics || {};
        const profile = dashboard?.profile || {};
        const profileDone = clamp(profile.profile_completion) >= 80;
        const items = [
            { title: profileDone ? 'View Profile' : 'Complete Profile', icon: 'user', url: '/direct-mode/profile' },
            { title: Number(stats.total_applications || 0) ? 'Browse More Jobs' : 'Browse Jobs', icon: 'briefcase', url: '/direct-mode/jobs' },
            { title: `My Applications${stats.total_applications ? ` (${stats.total_applications})` : ''}`, icon: 'file', url: '/direct-mode/applications' },
            { title: `Interview Schedule${stats.scheduled_interviews ? ` (${stats.scheduled_interviews})` : ''}`, icon: 'calendar', url: '/direct-mode/interviews' },
            { title: `Offers${stats.hired_applications ? ` (${stats.hired_applications})` : ''}`, icon: 'trophy', url: '/direct-mode/offers' },
        ];
        box.innerHTML = items.map(item => `<a class="quick" href="${esc(item.url)}"><span data-icon="${esc(item.icon)}"></span><span>${esc(item.title)}</span></a>`).join('');
        box.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
    };

    const renderNotifications = notifications => {
        const box = qs('[data-notifications]');
        if (!box) return;
        const items = listFrom(notifications);
        if (!items.length) {
            box.innerHTML = '<div class="empty">No notifications yet.</div>';
            return;
        }
        const iconByType = { job: 'briefcase', interview: 'calendar', assessment: 'file', application: 'bell' };
        const toneByType = { job: 'green-soft', interview: 'purple-soft', assessment: 'orange-soft', application: 'blue-soft' };
        box.innerHTML = items.slice(0, 4).map(item => {
            const icon = iconByType[item.type] || 'bell';
            const tone = toneByType[item.type] || 'blue-soft';
            return `<div class="notif"><span class="dash-icon ${tone}" data-icon="${icon}"></span><div><h3>${esc(item.title || 'Notification')}</h3><p>${esc(item.message || item.body || item.description || '')}</p></div><time>${esc(timeAgo(item.created_at || item.updated_at))}</time></div>`;
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
            const journey = await getJson('/api/fresher/dashboard');
            const journeyAssessment = journey.initial_assessment;

            if (!journeyAssessment || journeyAssessment.status !== 'submitted') {
                window.location.href = '/direct-mode/flow-selection';
                return;
            }

            const selectedMode = localStorage.getItem('onlyfreshers_selected_mode');
            if (journeyAssessment.recommended_mode === 'fast_track') {
                localStorage.setItem('onlyfreshers_selected_mode', 'fast_track');
                window.location.href = '/fast-track/dashboard';
                return;
            }
            if (selectedMode === 'fast_track') {
                window.location.href = '/fast-track/dashboard';
                return;
            }
            if (selectedMode !== 'direct') {
                window.location.href = '/direct-mode/flow-selection';
                return;
            }

            const [dashboard, applicationData, notificationData, unreadData, profileData] = await Promise.all([
                Promise.resolve(journey),
                getJson('/api/fresher/applications').catch(() => ({ applications: [] })),
                getJson('/api/notifications?per_page=4').catch(() => ({ notifications: { data: [] } })),
                getJson('/api/notifications/unread-count').catch(() => ({ unread_count: 0 })),
                getJson('/api/fresher/profile').catch(() => ({})),
            ]);
            const stats = dashboard.statistics || {};
            const profile = profileData.profile || profileData.fresher_profile || dashboard.profile || {};
            const applications = (applicationData.applications || dashboard.recent_applications || []).slice(0, 5);
            const notifications = listFrom(notificationData.notifications || notificationData);
            setTopUser(dashboard.user, unreadData.unread_count);
            hydrateHeroProfile(profile, dashboard.user);
            setStat('applications', stats.total_applications, `${stats.under_review_applications || 0} under review`);
            text('[data-direct-app-count]', stats.total_applications ?? 0);
            setStat('interviews', stats.scheduled_interviews, 'Upcoming');
            setStat('offers', stats.hired_applications, stats.hired_applications ? 'Congratulations!' : 'Keep applying');
            renderProfile(profile);
            renderApplications(applications);
            renderQuickActions(dashboard);
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
