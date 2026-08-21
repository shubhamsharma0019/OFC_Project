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
    .dashboard .direct-credit-hero {
        grid-template-columns: minmax(0, 1fr) minmax(330px, .95fr);
        gap: 12px;
        margin-bottom: 16px;
        border-color: #dbe8fb;
        border-radius: 12px;
        background: linear-gradient(135deg, #eaf3ff, #f6fbff);
        padding: 12px;
        box-shadow: 0 12px 28px rgba(7, 95, 228, .08);
    }
    .dashboard .direct-credit-hero:before {
        display: none;
    }
    .dashboard .direct-credit-hero .direct-hero-profile {
        gap: 18px;
        border-radius: 10px;
        background: transparent;
        padding: 0 4px;
    }
    .dashboard .direct-credit-hero .direct-hero-avatar {
        width: 88px;
        height: 88px;
        border: 3px solid #fff;
        box-shadow: 0 10px 22px rgba(6, 25, 66, .12);
    }
    .dashboard .direct-credit-hero .direct-hero-profile small {
        margin-bottom: 3px;
        font-size: 10px;
        line-height: 1;
        color: #061942;
    }
    .dashboard .direct-credit-hero .direct-hero-profile h1 {
        margin-bottom: 5px;
        font-size: 19px;
        line-height: 1.08;
    }
    .dashboard .direct-credit-hero .verified-line {
        margin-bottom: 10px;
        font-size: 10px;
    }
    .dashboard .direct-credit-hero .verified-line b {
        width: 14px;
        height: 14px;
        font-size: 8px;
    }
    .dashboard .direct-credit-hero .direct-hero-profile p {
        margin-bottom: 3px;
        font-size: 10px;
        line-height: 1.15;
    }
    .dashboard .direct-credit-hero .direct-hero-info {
        grid-template-columns: minmax(145px, .8fr) minmax(0, 1fr);
        gap: 18px;
        border: 0;
        border-radius: 10px;
        background: rgba(255, 255, 255, .78);
        padding: 18px 20px;
        box-shadow: none;
    }
    .dashboard .direct-credit-hero .credit-mini {
        gap: 14px;
    }
    .dashboard .direct-credit-hero .credit-mini .dash-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #eaf2ff;
    }
    .dashboard .direct-credit-hero .credit-mini small {
        margin-bottom: 6px;
        font-size: 8px;
        line-height: 1.15;
    }
    .dashboard .direct-credit-hero .credit-mini strong {
        font-size: 28px;
        line-height: .9;
    }
    .dashboard .direct-credit-hero .credit-mini span {
        display: block;
        margin-top: 4px;
        font-size: 11px;
        line-height: 1;
        color: #061942;
    }
    .dashboard .direct-credit-hero .apply-copy {
        padding-left: 20px;
        border-left: 1px solid #dfe8f7;
    }
    .dashboard .direct-credit-hero .apply-copy h2 {
        margin-bottom: 8px;
        font-size: 12px;
        line-height: 1.15;
    }
    .dashboard .direct-credit-hero .apply-copy p {
        margin-bottom: 8px;
        max-width: 260px;
        font-size: 10px;
        line-height: 1.35;
    }
    .dashboard .direct-credit-hero .apply-copy a {
        font-size: 10px;
    }
    .dashboard .direct-apply-strip {
        margin-bottom: 18px;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #fff;
        padding: 18px 22px 20px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .035);
    }
    .dashboard .direct-apply-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }
    .dashboard .direct-apply-head h2 {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0 0 8px;
        font-size: 18px;
        line-height: 1.15;
        color: #061942;
    }
    .dashboard .direct-info-dot {
        display: inline-grid;
        width: 14px;
        height: 14px;
        place-items: center;
        border-radius: 50%;
        border: 1px solid #9fc1f8;
        color: #075fe4;
        font-size: 9px;
        font-weight: 900;
    }
    .dashboard .direct-apply-head p {
        margin: 0;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
        color: #34445e;
    }
    .dashboard .direct-help-btn {
        display: inline-flex;
        height: 34px;
        shrink: 0;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid #075fe4;
        border-radius: 999px;
        background: #fff;
        padding: 0 14px;
        color: #075fe4;
        font-size: 11px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard .direct-help-btn .direct-info-dot {
        width: 16px;
        height: 16px;
        border-color: #075fe4;
        font-size: 10px;
    }
    .dashboard .direct-credit-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        border: 1px solid #dce7f8;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }
    .dashboard .direct-credit-cell {
        display: grid;
        grid-template-columns: 50px minmax(0, 1fr);
        align-items: center;
        gap: 14px;
        min-height: 84px;
        padding: 16px 22px;
        border-right: 1px solid #dce7f8;
    }
    .dashboard .direct-credit-cell:last-child {
        border-right: 0;
    }
    .dashboard .direct-credit-icon {
        position: relative;
        display: flex;
        width: 50px;
        height: 50px;
        align-items: center;
        justify-content: center;
        align-self: center;
        justify-self: center;
        line-height: 0;
        border-radius: 8px;
        background: #edf5ff;
        color: #075fe4;
    }
    .dashboard .direct-credit-icon svg {
        position: absolute;
        top: 50%;
        left: 50%;
        display: block;
        width: 24px;
        height: 24px;
        flex: 0 0 auto;
        margin: 0;
        transform: translate(-50%, -50%);
        overflow: hidden;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .dashboard .direct-credit-cell strong {
        display: block;
        margin-bottom: 4px;
        font-size: 20px;
        line-height: 1;
        color: #061942;
    }
    .dashboard .direct-credit-cell span {
        display: block;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.35;
        color: #061942;
    }
    .dashboard .direct-credit-cell small {
        display: block;
        margin-top: 2px;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.25;
        color: #34445e;
    }
    .dashboard .direct-jobs-widget {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 300px;
        gap: 16px;
        margin-bottom: 20px;
    }
    .dashboard .direct-job-board,
    .dashboard .track-analysis-panel,
    .dashboard .application-tips-panel {
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .035);
    }
    .dashboard .direct-job-board {
        padding: 16px;
    }
    .dashboard .direct-job-filters {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(150px, .55fr) minmax(150px, .55fr) 92px;
        gap: 10px;
        margin-bottom: 14px;
    }
    .dashboard .direct-filter-control {
        display: flex;
        height: 36px;
        align-items: center;
        gap: 8px;
        border: 1px solid #dce7f8;
        border-radius: 7px;
        background: #fff;
        padding: 0 12px;
        color: #526287;
        font-size: 10px;
        font-weight: 800;
    }
    .dashboard .direct-filter-control span:first-child {
        display: inline-flex;
        width: 14px;
        height: 14px;
        color: #075fe4;
    }
    .dashboard .direct-filter-control strong {
        min-width: 0;
        flex: 1;
        overflow: hidden;
        color: #061942;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .dashboard .direct-filter-control input,
    .dashboard .direct-filter-control select {
        min-width: 0;
        flex: 1;
        border: 0;
        outline: 0;
        background: transparent;
        color: #061942;
        font: inherit;
        font-size: 10px;
        font-weight: 800;
        appearance: none;
    }
    .dashboard .direct-filter-control input::placeholder {
        color: #061942;
        opacity: 1;
    }
    .dashboard .direct-filter-control svg {
        width: 14px;
        height: 14px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .dashboard .direct-job-list {
        overflow: hidden;
        border: 1px solid #eef3fb;
        border-radius: 10px;
    }
    .dashboard .direct-job-card {
        display: grid;
        grid-template-columns: 58px minmax(0, 1fr) 128px 94px 24px;
        align-items: center;
        gap: 14px;
        min-height: 86px;
        padding: 14px 16px;
        border-bottom: 1px solid #eef3fb;
    }
    .dashboard .direct-job-card:last-child {
        border-bottom: 0;
    }
    .dashboard .direct-company-logo {
        display: grid;
        width: 56px;
        height: 56px;
        place-items: center;
        border: 1px solid #e8eff9;
        border-radius: 8px;
        background: #fff;
        font-size: 18px;
        font-weight: 900;
        letter-spacing: -.02em;
    }
    .dashboard .direct-company-logo.tcs { color: #e64d1d; }
    .dashboard .direct-company-logo.infosys { color: #1570d4; font-size: 15px; }
    .dashboard .direct-company-logo.wipro { color: #4d2ccf; font-size: 14px; }
    .dashboard .direct-company-logo.hcl { color: #0052cc; font-size: 16px; font-style: italic; }
    .dashboard .direct-job-main h3 {
        margin: 0 0 5px;
        font-size: 13px;
        line-height: 1.15;
        color: #061942;
    }
    .dashboard .direct-job-main p {
        margin: 0 0 7px;
        font-size: 11px;
        font-weight: 700;
        color: #34445e;
    }
    .dashboard .direct-job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 6px;
        color: #526287;
        font-size: 9px;
        font-weight: 800;
    }
    .dashboard .direct-job-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .dashboard .direct-job-posted {
        font-size: 9px;
        font-weight: 700;
        color: #526287;
    }
    .dashboard .track-pill {
        display: inline-flex;
        min-width: 108px;
        height: 23px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #eef3fb;
        color: #526287;
        font-size: 9px;
        font-weight: 900;
    }
    .dashboard .direct-match-stack {
        display: grid;
        justify-items: center;
        gap: 7px;
    }
    .dashboard .fit-pill {
        display: inline-flex;
        min-width: 82px;
        height: 22px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #dff8ec;
        color: #07883f;
        font-size: 9px;
        font-weight: 900;
    }
    .dashboard .fit-pill.average {
        background: #fff1dc;
        color: #d77500;
    }
    .dashboard .direct-job-action {
        display: grid;
        gap: 6px;
        justify-items: center;
    }
    .dashboard .direct-job-action a {
        display: inline-flex;
        width: 88px;
        height: 30px;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: #075fe4;
        color: #fff;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard .direct-job-action small {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #061942;
        font-size: 10px;
        font-weight: 800;
    }
    .dashboard .bookmark-icon {
        align-self: start;
        color: #526287;
    }
    .dashboard .bookmark-icon svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
    }
    .dashboard .load-more-wrap {
        display: flex;
        justify-content: center;
        padding-top: 18px;
    }
    .dashboard .load-more-wrap a {
        display: inline-flex;
        height: 34px;
        min-width: 150px;
        align-items: center;
        justify-content: center;
        border: 1px solid #9fc1f8;
        border-radius: 7px;
        background: #fff;
        color: #075fe4;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard .direct-analysis-side {
        display: grid;
        gap: 14px;
    }
    .dashboard .track-analysis-panel {
        padding: 18px 18px 16px;
        text-align: center;
    }
    .dashboard .track-analysis-panel h3,
    .dashboard .application-tips-panel h3 {
        margin: 0 0 14px;
        font-size: 12px;
        line-height: 1.2;
        color: #061942;
    }
    .dashboard .radar-wrap {
        margin: 0 auto 14px;
        width: 190px;
        max-width: 100%;
    }
    .dashboard .match-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        border-top: 1px solid #e7eef8;
        padding-top: 12px;
        font-size: 10px;
        font-weight: 900;
        color: #061942;
    }
    .dashboard .stars {
        color: #075fe4;
        letter-spacing: 1px;
    }
    .dashboard .good-fit-text {
        color: #07883f;
        font-size: 10px;
    }
    .dashboard .improve-copy {
        margin: 12px 0;
        font-size: 10px;
        font-weight: 700;
        color: #34445e;
    }
    .dashboard .analysis-cta {
        display: inline-flex;
        width: 100%;
        height: 34px;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: #eaf2ff;
        color: #075fe4;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard .application-tips-panel {
        padding: 16px 18px;
    }
    .dashboard .tips-list {
        display: grid;
        gap: 9px;
        margin: 0 0 12px;
        padding: 0;
        list-style: none;
    }
    .dashboard .tips-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.25;
        color: #061942;
    }
    .dashboard .tips-list b {
        display: grid;
        width: 14px;
        height: 14px;
        flex: 0 0 auto;
        place-items: center;
        border-radius: 50%;
        background: #07883f;
        color: #fff;
        font-size: 8px;
    }
    .dashboard .tips-link {
        color: #075fe4;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard .credits-pricing-section {
        margin-bottom: 20px;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #fff;
        padding: 22px 18px 16px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .035);
    }
    .dashboard .credits-pricing-head {
        margin-bottom: 18px;
        text-align: center;
    }
    .dashboard .credits-pricing-head h2 {
        margin: 0 0 8px;
        font-size: 21px;
        line-height: 1.2;
        color: #061942;
    }
    .dashboard .credits-pricing-head p {
        margin: 0;
        font-size: 11px;
        font-weight: 700;
        color: #34445e;
    }
    .dashboard .credits-plan-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
    }
    .dashboard .credits-plan-card {
        position: relative;
        min-height: 260px;
        border: 1px solid #cfe0ff;
        border-radius: 9px;
        background: #fff;
        padding: 18px 20px 16px;
        text-align: center;
        box-shadow: 0 8px 18px rgba(6, 25, 66, .035);
    }
    .dashboard .credits-plan-card.popular {
        border-color: #075fe4;
        box-shadow: inset 0 0 0 1px #075fe4, 0 10px 24px rgba(7, 95, 228, .09);
    }
    .dashboard .popular-ribbon {
        position: absolute;
        left: 50%;
        top: -10px;
        display: inline-flex;
        min-width: 76px;
        height: 22px;
        transform: translateX(-50%);
        align-items: center;
        justify-content: center;
        border-radius: 0 0 7px 7px;
        background: #075fe4;
        color: #fff;
        font-size: 10px;
        font-weight: 900;
    }
    .dashboard .credits-plan-card h3 {
        margin: 0 0 12px;
        font-size: 13px;
        line-height: 1.15;
        color: #061942;
    }
    .dashboard .credits-amount {
        margin-bottom: 12px;
    }
    .dashboard .credits-amount strong {
        display: block;
        color: #075fe4;
        font-size: 28px;
        line-height: .95;
    }
    .dashboard .credits-amount span {
        display: block;
        margin-top: 4px;
        color: #075fe4;
        font-size: 10px;
        font-weight: 800;
    }
    .dashboard .credits-price {
        margin-bottom: 10px;
    }
    .dashboard .credits-price strong {
        display: block;
        color: #061942;
        font-size: 24px;
        line-height: 1;
    }
    .dashboard .credits-price span {
        display: block;
        margin-top: 5px;
        color: #34445e;
        font-size: 9px;
        font-weight: 800;
    }
    .dashboard .credits-plan-btn {
        display: inline-flex;
        width: 100%;
        height: 32px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 5px;
        background: #075fe4;
        color: #fff;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard .credits-plan-btn.current {
        background: #edf5ff;
        color: #075fe4;
    }
    .dashboard .credits-features {
        display: grid;
        gap: 9px;
        margin: 18px 0 0;
        padding: 0;
        list-style: none;
        text-align: left;
    }
    .dashboard .credits-features li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.25;
        color: #061942;
    }
    .dashboard .credits-features b {
        display: grid;
        width: 14px;
        height: 14px;
        flex: 0 0 auto;
        place-items: center;
        border-radius: 50%;
        background: #0b8b67;
        color: #fff;
        font-size: 8px;
    }
    .dashboard .credits-trust-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0;
        margin-top: 18px;
        color: #34445e;
        font-size: 11px;
        font-weight: 800;
    }
    .dashboard .credits-trust-row span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 12px;
        border-right: 1px solid #9cafcd;
    }
    .dashboard .credits-trust-row span:last-child {
        border-right: 0;
    }
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
        .dashboard .direct-credit-hero {
            grid-template-columns: 1fr;
        }
        .dashboard .direct-credit-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .dashboard .direct-credit-cell:nth-child(2) {
            border-right: 0;
        }
        .dashboard .direct-credit-cell:nth-child(-n + 2) {
            border-bottom: 1px solid #dce7f8;
        }
        .dashboard .middle {
            grid-template-columns: 1fr !important;
        }
        .dashboard .direct-jobs-widget {
            grid-template-columns: 1fr;
        }
        .dashboard .dash-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 760px) {
        .dashboard .direct-apply-head {
            display: grid;
        }
        .dashboard .direct-credit-row {
            grid-template-columns: 1fr;
        }
        .dashboard .direct-credit-cell {
            border-right: 0;
            border-bottom: 1px solid #dce7f8;
        }
        .dashboard .direct-credit-cell:last-child {
            border-bottom: 0;
        }
        .dashboard .direct-job-filters,
        .dashboard .direct-job-card {
            grid-template-columns: 1fr;
        }
        .dashboard .credits-plan-grid {
            grid-template-columns: 1fr;
        }
        .dashboard .direct-job-action {
            justify-items: start;
        }
        .dashboard .direct-credit-hero .direct-hero-info {
            grid-template-columns: 1fr;
        }
        .dashboard .direct-credit-hero .apply-copy {
            border-left: 0;
            border-top: 1px solid #dfe8f7;
            padding-left: 0;
            padding-top: 14px;
        }
        .dashboard .profile-box {
            grid-template-columns: 1fr !important;
            justify-items: center;
        }
        .dashboard .dash-stats {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 640px) {
        .dashboard {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            padding: 12px !important;
        }

        .dashboard .direct-credit-hero,
        .dashboard .direct-apply-strip,
        .dashboard .direct-jobs-widget,
        .dashboard .credits-pricing-section,
        .dashboard .card,
        .dashboard .section,
        .dashboard .direct-job-board,
        .dashboard .track-analysis-panel,
        .dashboard .application-tips-panel {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .dashboard .direct-credit-hero {
            grid-template-columns: 1fr !important;
            gap: 12px;
            padding: 12px;
        }

        .dashboard .direct-credit-hero .direct-hero-profile {
            display: grid;
            justify-items: center;
            gap: 12px;
            padding: 12px;
            text-align: center;
        }

        .dashboard .direct-credit-hero .direct-hero-avatar {
            width: 72px;
            height: 72px;
        }

        .dashboard .direct-credit-hero .direct-hero-profile h1 {
            font-size: 20px;
            overflow-wrap: anywhere;
        }

        .dashboard .direct-credit-hero .direct-hero-info {
            grid-template-columns: 1fr !important;
            gap: 12px;
            padding: 14px;
        }

        .dashboard .direct-credit-hero .credit-mini {
            justify-content: center;
            text-align: left;
        }

        .dashboard .direct-credit-hero .apply-copy {
            border-left: 0;
            border-top: 1px solid #dfe8f7;
            padding: 12px 0 0;
            text-align: center;
        }

        .dashboard .direct-credit-hero .apply-copy p {
            max-width: none;
        }

        .dashboard .direct-apply-strip,
        .dashboard .direct-job-board,
        .dashboard .credits-pricing-section {
            padding: 14px;
        }

        .dashboard .direct-apply-head {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .dashboard .direct-apply-head h2,
        .dashboard .credits-pricing-head h2 {
            font-size: 18px;
            line-height: 1.25;
        }

        .dashboard .direct-help-btn,
        .dashboard .load-more-wrap a,
        .dashboard .analysis-cta,
        .dashboard .hero-btn {
            width: 100%;
        }

        .dashboard .direct-credit-row {
            grid-template-columns: 1fr !important;
        }

        .dashboard .direct-credit-cell {
            grid-template-columns: 42px minmax(0, 1fr);
            min-height: 72px;
            padding: 13px 14px;
            border-right: 0;
            border-bottom: 1px solid #dce7f8;
        }

        .dashboard .direct-credit-cell:last-child {
            border-bottom: 0;
        }

        .dashboard .direct-credit-icon {
            width: 42px;
            height: 42px;
        }

        .dashboard .direct-job-filters {
            grid-template-columns: 1fr !important;
        }

        .dashboard .direct-filter-control {
            width: 100%;
            min-width: 0;
        }

        .dashboard .direct-job-card {
            grid-template-columns: 48px minmax(0, 1fr) !important;
            gap: 12px;
            align-items: start;
            padding: 13px;
        }

        .dashboard .direct-company-logo {
            width: 48px;
            height: 48px;
            font-size: 15px;
        }

        .dashboard .direct-match-stack,
        .dashboard .direct-job-action,
        .dashboard .bookmark-icon {
            grid-column: 2;
            justify-items: start;
            align-self: start;
        }

        .dashboard .direct-match-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .dashboard .direct-job-action {
            width: 100%;
        }

        .dashboard .direct-job-action a {
            width: 100%;
            max-width: 180px;
        }

        .dashboard .load-more-wrap {
            display: grid;
            gap: 10px;
        }

        .dashboard .load-more-wrap a {
            margin-left: 0 !important;
        }

        .dashboard .radar-wrap {
            width: min(190px, 100%);
        }

        .dashboard .match-row {
            display: grid;
            grid-template-columns: 1fr;
            justify-items: center;
            text-align: center;
        }

        .dashboard .credits-plan-grid {
            grid-template-columns: 1fr !important;
            gap: 12px;
        }

        .dashboard .credits-plan-card {
            min-height: 0;
            padding: 18px 16px 16px;
        }

        .dashboard .credits-trust-row {
            display: grid;
            justify-content: stretch;
            gap: 8px;
            text-align: center;
        }

        .dashboard .credits-trust-row span {
            justify-content: center;
            border-right: 0;
            padding: 0;
        }
    }

    @media (max-width: 420px) {
        .dashboard .direct-job-card {
            grid-template-columns: 1fr !important;
        }

        .dashboard .direct-match-stack,
        .dashboard .direct-job-action,
        .dashboard .bookmark-icon {
            grid-column: auto;
        }

        .dashboard .direct-credit-hero .credit-mini {
            display: grid;
            justify-items: center;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<section class="dashboard" data-dashboard>
    <div class="dashboard-error" data-dashboard-error></div>
    <section class="direct-hero direct-credit-hero">
        <article class="direct-hero-profile">
            <span class="direct-hero-avatar" aria-hidden="true"></span>
            <div>
                <small>Welcome,</small>
                <h1 data-dashboard-name>Fresher</h1>
                <span class="verified-line"><b>✓</b> Verified Fresher</span>
                <p data-dashboard-education>B.Tech - Computer Science</p>
                <p data-dashboard-location>Delhi, India</p>
            </div>
        </article>
        <article class="direct-hero-info">
            <div class="credit-mini">
                <span class="dash-icon" data-icon="database"></span>
                <div>
                    <small>Free Application Credits</small>
                    <strong data-direct-credit-count>0</strong>
                    <span>Available</span>
                </div>
            </div>
            <div class="apply-copy">
                <h2>Apply to jobs & internships for FREE!</h2>
                <p>You get <strong data-direct-free-copy>free application credits</strong> after Initial Assessment to apply for jobs or internships.</p>
                <a href="/direct-mode/jobs">Learn More</a>
            </div>
        </article>
    </section>
    <section class="direct-apply-strip">
        <div class="direct-apply-head">
            <div>
                <h2>Apply Jobs & Internships (Direct Mode) <span class="direct-info-dot">i</span></h2>
                <p>Companies receive your resume along with Initial Track Analysis to find the right match.</p>
            </div>
            <a class="direct-help-btn" href="/direct-mode/jobs"><span class="direct-info-dot">i</span> How Direct Mode Works</a>
        </div>
        <div class="direct-credit-row">
            <article class="direct-credit-cell">
                <span class="direct-credit-icon" data-icon="share"></span>
                <div>
                    <strong data-direct-free-count>0</strong>
                    <span>Free Credits</span>
                    <small>Available</small>
                </div>
            </article>
            <article class="direct-credit-cell">
                <span class="direct-credit-icon" data-icon="cart"></span>
                <div>
                    <strong data-direct-used-count>0</strong>
                    <span>Applications</span>
                    <small>Used</small>
                </div>
            </article>
            <article class="direct-credit-cell">
                <span class="direct-credit-icon" data-icon="cart-check"></span>
                <div>
                    <strong data-direct-remaining-count>0</strong>
                    <span>Applications</span>
                    <small>Remaining</small>
                </div>
            </article>
            <a class="direct-credit-cell" href="/direct-mode/jobs" style="text-decoration:none">
                <span class="direct-credit-icon" data-icon="plus"></span>
                <div>
                    <span>Purchase Credits</span>
                    <small>To Apply More</small>
                </div>
            </a>
        </div>
    </section>
    <section class="direct-jobs-widget">
        <div class="direct-job-board">
            <div class="direct-job-filters">
                <label class="direct-filter-control">
                    <span data-icon="search"></span>
                    <input data-direct-job-search type="search" placeholder="Search job, internship, keyword or company" aria-label="Search jobs and internships">
                </label>
                <label class="direct-filter-control">
                    <select data-direct-location-filter aria-label="Filter by location">
                        <option value="">All Locations</option>
                    </select>
                    <span data-icon="chevron-down"></span>
                </label>
                <label class="direct-filter-control">
                    <select data-direct-type-filter aria-label="Filter by job type">
                        <option value="">All Job Roles</option>
                        <option value="Internship">Internship</option>
                    </select>
                    <span data-icon="chevron-down"></span>
                </label>
                <button class="direct-filter-control" type="button">
                    <span data-icon="filter"></span>
                    <strong>Filters</strong>
                </button>
            </div>

            <div class="direct-job-list" data-direct-job-list>
                <div class="empty">Loading jobs...</div>
            </div>
            <div class="load-more-wrap">
                <a href="/direct-mode/jobs">Load More Jobs</a>
                <a href="/direct-mode/jobs?type=internship" style="margin-left:10px">View Internships</a>
            </div>
        </div>

        <aside class="direct-analysis-side">
            <article class="track-analysis-panel">
                <h3>Your Initial Track Analysis</h3>
                <div class="radar-wrap">
                    <svg viewBox="0 0 220 190" aria-hidden="true">
                        <polygon points="110,18 190,156 30,156" fill="#f4f8ff" stroke="#d6e5ff" stroke-width="1.5"></polygon>
                        <polygon data-radar-polygon points="110,48 158,128 62,128" fill="#eaf2ff" stroke="#075fe4" stroke-width="2"></polygon>
                        <g data-radar-points fill="#075fe4">
                            <circle cx="110" cy="48" r="3"></circle><circle cx="158" cy="128" r="3"></circle><circle cx="62" cy="128" r="3"></circle>
                        </g>
                        <g fill="#061942" font-size="10" font-weight="800" text-anchor="middle">
                            <text x="110" y="10">Technical</text><text x="110" y="22">Skills</text>
                            <text x="199" y="165">Aptitude</text>
                            <text x="30" y="165">Communication</text>
                        </g>
                    </svg>
                </div>
                <div class="match-row">
                    <span>Overall Match</span>
                    <span class="stars" data-analysis-stars>&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    <span class="good-fit-text" data-analysis-fit>Good Fit</span>
                </div>
                <p class="improve-copy">Improve your score with Fast Track Program</p>
                <a class="analysis-cta" href="/fast-track/dashboard">Explore Fast Track Program</a>
            </article>

            <article class="application-tips-panel">
                <h3>Application Tips</h3>
                <ul class="tips-list">
                    <li><b>&#10003;</b> Fill your profile completely</li>
                    <li><b>&#10003;</b> Upload an updated resume</li>
                    <li><b>&#10003;</b> Check your Initial Track Analysis</li>
                    <li><b>&#10003;</b> Score 50+ to access jobs and internships</li>
                    <li><b>&#10003;</b> Apply to roles that match your skills</li>
                </ul>
                <a class="tips-link" href="/direct-mode/jobs">View All Tips</a>
            </article>
        </aside>
    </section>
    <section class="credits-pricing-section" id="credits">
        <div class="credits-pricing-head">
            <h2>Apply More Jobs with Additional Credits</h2>
            <p data-credit-pricing-copy>You get free credits to apply for jobs under Direct Mode. Need more? Choose a plan that suits you.</p>
        </div>
        <div class="credits-plan-grid" data-credit-plans>
            <div class="empty">Loading credit plans...</div>
        </div>
        <div class="credits-trust-row">
            <span><i data-icon="shield"></i> Secure Payments</span>
            <span>Instant Credit</span>
            <span>No Auto Renewal</span>
            <span>Use Anytime</span>
        </div>
    </section>
</section>
@endsection

@push('scripts')
<script>
(() => {
    Object.assign(window.directModeIcons || {}, {
        briefcase:'<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M4 12h16"></path></svg>',
        database:'<svg viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="7" ry="3"></ellipse><path d="M5 5v6c0 1.66 3.13 3 7 3s7-1.34 7-3V5"></path><path d="M5 11v6c0 1.66 3.13 3 7 3s7-1.34 7-3v-6"></path></svg>',
        share:'<svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><path d="m8.6 10.6 6.8-4.2"></path><path d="m8.6 13.4 6.8 4.2"></path></svg>',
        cart:'<svg viewBox="0 0 24 24"><circle cx="9" cy="20" r="1.7"></circle><circle cx="18" cy="20" r="1.7"></circle><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L21 8H7"></path><path d="M14 8v5"></path><path d="M11.5 10.5H16.5"></path></svg>',
        'cart-check':'<svg viewBox="0 0 24 24"><circle cx="9" cy="20" r="1.7"></circle><circle cx="18" cy="20" r="1.7"></circle><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L21 8H7"></path><path d="m11 12 2 2 4-5"></path></svg>',
        plus:'<svg viewBox="0 0 24 24"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>',
        search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 4 4"></path></svg>',
        filter:'<svg viewBox="0 0 24 24"><path d="M4 5h16"></path><path d="M7 12h10"></path><path d="M10 19h4"></path></svg>',
        'chevron-down':'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>',
        'map-pin':'<svg viewBox="0 0 24 24"><path d="M12 21s7-4.4 7-11a7 7 0 0 0-14 0c0 6.6 7 11 7 11Z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>',
        bookmark:'<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-4-6 4V3Z"></path></svg>',
        shield:'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-5"></path></svg>',
        users:'<svg viewBox="0 0 24 24"><circle cx="10" cy="8" r="3.5"></circle><path d="M3.5 20a6.5 6.5 0 0 1 13 0"></path><path d="M17 9a3 3 0 0 1 0 6"></path><path d="M18.5 17.5a5 5 0 0 1 2 2.5"></path></svg>',
        calendar:'<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 3v4M16 3v4M4 10h16"></path></svg>',
        trophy:'<svg viewBox="0 0 24 24"><path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"></path><path d="M8 6H4v2a4 4 0 0 0 4 4"></path><path d="M16 6h4v2a4 4 0 0 1-4 4"></path><path d="M12 13v5"></path><path d="M8 20h8"></path></svg>',
    });
    document.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
    const token = localStorage.getItem('onlyfreshers_token');
    const storedUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || 'null');
    const headers = { Accept: 'application/json', ...(token ? { Authorization: `Bearer ${token}` } : {}) };
    const qs = selector => document.querySelector(selector);
    const qsa = selector => [...document.querySelectorAll(selector)];
    const directJobState = { jobs: [], dashboard: {} };
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

    const companyLogoLabel = companyName => {
        const normalized = String(companyName || '').trim();
        if (!normalized) return 'OF';
        if (/tata|tcs/i.test(normalized)) return 'tcs';
        if (/infosys/i.test(normalized)) return 'Infosys';
        if (/wipro/i.test(normalized)) return 'wipro';
        if (/hcl/i.test(normalized)) return 'HCL';
        return initials(normalized);
    };

    const companyLogoClass = companyName => {
        const normalized = String(companyName || '').toLowerCase();
        if (normalized.includes('tata') || normalized.includes('tcs')) return 'tcs';
        if (normalized.includes('infosys')) return 'infosys';
        if (normalized.includes('wipro')) return 'wipro';
        if (normalized.includes('hcl')) return 'hcl';
        return '';
    };

    const experienceText = job => {
        const min = job?.experience_min ?? job?.min_experience;
        const max = job?.experience_max ?? job?.max_experience;
        if (min !== undefined && max !== undefined && min !== null && max !== null) return `${min} - ${max} Year`;
        if (job?.experience) return job.experience;
        return '0 - 1 Year';
    };

    const fitForScore = score => {
        const value = Number(score || 0);
        if (value >= 70) return 'Good Fit';
        if (value >= 45) return 'Average Fit';
        return 'Needs Review';
    };

    const normalized = value => String(value || '').trim().toLowerCase();

    const populateDirectJobFilters = jobs => {
        const locationSelect = qs('[data-direct-location-filter]');
        const typeSelect = qs('[data-direct-type-filter]');
        if (locationSelect) {
            const current = locationSelect.value;
            const locations = [...new Set((jobs || []).map(job => job.location).filter(Boolean))].sort();
            locationSelect.innerHTML = '<option value="">All Locations</option>' + locations.map(location => `<option value="${esc(location)}">${esc(location)}</option>`).join('');
            locationSelect.value = locations.includes(current) ? current : '';
        }
        if (typeSelect) {
            const current = typeSelect.value;
            const types = [...new Set((jobs || []).map(job => job.job_type).filter(Boolean))].sort();
            const merged = [...new Set(['Internship', ...types])];
            typeSelect.innerHTML = '<option value="">All Job Roles</option>' + merged.map(type => `<option value="${esc(type)}">${esc(type)}</option>`).join('');
            typeSelect.value = merged.includes(current) ? current : '';
        }
    };

    const filteredDirectJobs = () => {
        const term = normalized(qs('[data-direct-job-search]')?.value);
        const location = normalized(qs('[data-direct-location-filter]')?.value);
        const type = normalized(qs('[data-direct-type-filter]')?.value);
        return directJobState.jobs.filter(job => {
            const company = job.company_profile || job.companyProfile || {};
            const searchable = normalized([
                job.title,
                job.required_skills,
                job.qualification,
                job.location,
                job.job_type,
                company.company_name,
                company.industry,
            ].filter(Boolean).join(' '));
            return (!term || searchable.includes(term))
                && (!location || normalized(job.location).includes(location))
                && (!type || normalized(job.job_type) === type);
        });
    };

    const refreshDirectJobs = () => {
        renderDirectJobs(filteredDirectJobs(), directJobState.dashboard);
    };

    const renderDirectJobs = (jobs, dashboard) => {
        const box = qs('[data-direct-job-list]');
        if (!box) return;
        const result = dashboard?.initial_assessment?.result || {};
        const score = Number(result.overall_score || 0);
        const fit = fitForScore(score || 72);
        const rows = Array.isArray(jobs) ? jobs.slice(0, 4) : [];
        if (!rows.length) {
            box.innerHTML = '<div class="empty">No active Direct Mode jobs found right now.</div>';
            return;
        }
        box.innerHTML = rows.map(job => {
            const company = job.company_profile || job.companyProfile || {};
            const companyName = company.company_name || job.company_name || 'Company';
            const fitClass = fit === 'Average Fit' || fit === 'Needs Review' ? 'average' : '';
            const href = `/direct-mode/jobs/${job.id || ''}`;
            return `<article class="direct-job-card">
                <span class="direct-company-logo ${esc(companyLogoClass(companyName))}">${esc(companyLogoLabel(companyName))}</span>
                <div class="direct-job-main">
                    <h3>${esc(job.title || 'Job Role')}</h3>
                    <p>${esc(companyName)}</p>
                    <div class="direct-job-meta">
                        <span data-icon="map-pin"></span><span>${esc(job.location || 'Location not added')}</span>
                        <span data-icon="briefcase"></span><span>${esc(job.job_type || 'Full-time')}</span>
                        <span>${esc(experienceText(job))}</span>
                    </div>
                    <div class="direct-job-posted">${esc(timeAgo(job.created_at || job.updated_at) || 'Posted recently')}</div>
                </div>
                <div class="direct-match-stack">
                    <span class="track-pill">Initial Track Match</span>
                    <span class="fit-pill ${fitClass}">${esc(fit)}</span>
                </div>
                <div class="direct-job-action">
                    <a href="${esc(href)}">Apply Now</a>
                    <small><span data-icon="database"></span> 1 Credit</small>
                </div>
                <span class="bookmark-icon" data-icon="bookmark"></span>
            </article>`;
        }).join('');
        box.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
    };

    const renderAnalysis = dashboard => {
        const result = dashboard?.initial_assessment?.result || {};
        const scores = [
            Number(result.technical_score || 0),
            Number(result.aptitude_score || 0),
            Number(result.communication_score || 0),
        ].map(value => value || 60);
        const center = [110, 110];
        const outer = [[110, 18], [190, 156], [30, 156]];
        const points = outer.map((point, index) => {
            const ratio = Math.max(.18, Math.min(1, scores[index] / 100));
            return [
                center[0] + (point[0] - center[0]) * ratio,
                center[1] + (point[1] - center[1]) * ratio,
            ];
        });
        const polygon = qs('[data-radar-polygon]');
        const pointsGroup = qs('[data-radar-points]');
        if (polygon) polygon.setAttribute('points', points.map(point => point.map(num => num.toFixed(1)).join(',')).join(' '));
        if (pointsGroup) pointsGroup.innerHTML = points.map(point => `<circle cx="${point[0].toFixed(1)}" cy="${point[1].toFixed(1)}" r="3"></circle>`).join('');

        const overall = Number(result.overall_score || 0);
        const stars = Math.max(1, Math.min(5, Math.round((overall || 72) / 20)));
        text('[data-analysis-stars]', '★'.repeat(stars) + '☆'.repeat(5 - stars));
        text('[data-analysis-fit]', fitForScore(overall || 72));
    };

    const creditPlans = [
        { key: 'starter', name: 'Starter', credits: '250', price: '₹0', validity: 'FREE', button: 'Current Plan', current: true, popular: false, features: ['Apply to 5 jobs', '50 credits per application', 'For Direct Mode only'] },
        { key: 'basic', name: 'Basic', credits: '1,000', price: '₹249', validity: 'Valid for 60 days', button: 'Buy Now', current: false, popular: false, features: ['Apply to 20 jobs', 'Valid for 60 days', 'For Direct Mode only'] },
        { key: 'pro', name: 'Pro', credits: '2,500', price: '₹499', validity: 'Valid for 90 days', button: 'Buy Now', current: false, popular: true, features: ['Apply to 50 jobs', 'Valid for 90 days', 'For Direct Mode only', 'Priority Support'] },
        { key: 'premium', name: 'Premium', credits: '5,000', price: '₹899', validity: 'Valid for 120 days', button: 'Buy Now', current: false, popular: false, features: ['Apply to 100 jobs', 'Valid for 120 days', 'For Direct Mode only', 'Priority Support'] },
        { key: 'ultimate', name: 'Ultimate', credits: '10,000', price: '₹1,499', validity: 'Valid for 180 days', button: 'Buy Now', current: false, popular: false, features: ['Apply to 200 jobs', 'Valid for 180 days', 'For Direct Mode only', 'Priority Support'] },
    ];

    const renderCreditPlans = () => {
        const box = qs('[data-credit-plans]');
        if (!box) return;
        box.innerHTML = creditPlans.map(plan => `<article class="credits-plan-card ${plan.popular ? 'popular' : ''}">
            ${plan.popular ? '<span class="popular-ribbon">Popular</span>' : ''}
            <h3>${esc(plan.name)}</h3>
            <div class="credits-amount"><strong>${esc(plan.credits)}</strong><span>Credits</span></div>
            <div class="credits-price"><strong>${esc(plan.price)}</strong><span>${esc(plan.validity)}</span></div>
            <button class="credits-plan-btn ${plan.current ? 'current' : ''}" data-credit-plan="${esc(plan.key)}" type="button" ${plan.current ? 'disabled' : ''}>${esc(plan.button)}</button>
            <ul class="credits-features">${plan.features.map(feature => `<li><b>&#10003;</b>${esc(feature)}</li>`).join('')}</ul>
        </article>`).join('');
        box.querySelectorAll('[data-credit-plan]:not([disabled])').forEach(button => {
            button.addEventListener('click', () => buyDirectModeCredits(button));
        });
    };

    async function buyDirectModeCredits(button) {
        if (!token) {
            window.location.href = '/direct-mode/login';
            return;
        }

        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Activating...';

        try {
            const response = await fetch('/api/fresher/direct-mode/subscribe', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({ plan: button.dataset.creditPlan }),
            });
            const payload = await response.json();

            if (!response.ok || payload.success === false) {
                throw new Error(payload.message || 'Credits activate nahi ho paaye.');
            }

            if (payload.data?.profile) {
                localStorage.setItem('onlyfreshers_profile', JSON.stringify(payload.data.profile));
            }

            window.location.href = payload.data?.redirect_to || '/direct-mode/jobs';
        } catch (error) {
            showError(error.message || 'Something went wrong.');
            button.disabled = false;
            button.textContent = originalText;
        }
    }

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
        renderCreditPlans();
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
            if (!['direct', 'internship'].includes(selectedMode)) {
                window.location.href = '/direct-mode/flow-selection';
                return;
            }

            const [dashboard, applicationData, notificationData, unreadData, profileData, jobsData] = await Promise.all([
                Promise.resolve(journey),
                getJson('/api/fresher/applications').catch(() => ({ applications: [] })),
                getJson('/api/notifications?per_page=4').catch(() => ({ notifications: { data: [] } })),
                getJson('/api/notifications/unread-count').catch(() => ({ unread_count: 0 })),
                getJson('/api/fresher/profile').catch(() => ({})),
                getJson('/api/jobs?hiring_mode=direct').catch(() => ({ jobs: [] })),
            ]);
            const stats = dashboard.statistics || {};
            const profile = profileData.profile || profileData.fresher_profile || dashboard.profile || {};
            const applications = (applicationData.applications || dashboard.recent_applications || []).slice(0, 5);
            const notifications = listFrom(notificationData.notifications || notificationData);
            const directJobs = jobsData.jobs || [];
            directJobState.jobs = directJobs;
            directJobState.dashboard = dashboard;
            populateDirectJobFilters(directJobs);
            setTopUser(dashboard.user, unreadData.unread_count);
            hydrateHeroProfile(profile, dashboard.user);
            renderAnalysis(dashboard);
            refreshDirectJobs();
            setStat('applications', stats.total_applications, `${stats.under_review_applications || 0} under review`);
            const credits = dashboard.direct_mode_credits || {};
            const freeCredits = Number(credits.free ?? 0);
            const usedCredits = Number(credits.used ?? stats.total_applications ?? 0);
            const remainingCredits = Number(credits.remaining ?? Math.max(0, freeCredits - usedCredits));
            const creditCost = Number(credits.application_cost || 1);
            text('[data-direct-credit-count]', remainingCredits);
            text('[data-direct-free-count]', freeCredits);
            text('[data-direct-free-copy]', `${freeCredits.toLocaleString('en-IN')} free application credits`);
            text('[data-credit-pricing-copy]', `You get ${freeCredits.toLocaleString('en-IN')} FREE credits to apply for jobs under Direct Mode. Need more? Choose a plan that suits you.`);
            text('[data-direct-used-count]', usedCredits);
            text('[data-direct-remaining-count]', remainingCredits);
            qsa('.direct-job-action small').forEach(el => {
                el.innerHTML = `<span data-icon="database"></span> ${creditCost} Credit`;
            });
            qsa('.direct-job-action [data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
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

    qs('[data-direct-job-search]')?.addEventListener('input', refreshDirectJobs);
    qs('[data-direct-location-filter]')?.addEventListener('change', refreshDirectJobs);
    qs('[data-direct-type-filter]')?.addEventListener('change', refreshDirectJobs);

    loadDashboard();
})();
</script>
@endpush
