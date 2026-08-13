@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
@endphp

@php $activePage = 'activity'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Activity - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:238px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:72px;display:flex;align-items:center;padding:0 28px;border-bottom:1px solid #d8e4f7}.brand img{width:200px}.menu{padding:30px 16px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.stat-icon svg,.small-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:50px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:30px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:34px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 20px}.main{min-width:0;display:grid;grid-template-rows:72px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,570px) 1fr;align-items:center;gap:30px;padding:0 30px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.page{padding:20px 34px 16px}.welcome{margin:0 0 12px 4px}.welcome small{font-size:13px}.welcome h1{margin:4px 0 0;font-size:21px}.layout{display:grid;grid-template-columns:minmax(0,1fr) 364px;gap:18px}.card{background:rgba(255,255,255,.92);border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.main-card{padding:18px}.title-row{display:flex;justify-content:space-between;gap:20px;align-items:start;margin-bottom:22px}.title h2{margin:0 0 8px;font-size:25px}.title p{margin:0;color:#43517b;font-size:14px}.outline{height:36px;border:1px solid #d8e4f7;border-radius:7px;background:#fff;color:#06123f;font-size:13px;font-weight:800;padding:0 14px;display:inline-flex;align-items:center;gap:8px}.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:18px}.stat{height:92px;border:1px solid #d8e4f7;border-radius:10px;background:#fff;display:grid;grid-template-columns:50px 1fr;align-items:center;gap:14px;padding:18px}.stat-icon{width:46px;height:46px;border-radius:12px;display:grid;place-items:center;color:#fff}.blue{background:#0b5cff}.green{background:#12a866}.purple{background:#7a45e8}.orange{background:#ff6a00}.stat strong{font-size:24px;display:block}.stat span{font-size:12px;color:#43517b}.stat small{font-size:11px;color:#008a35}.stat small.down{color:#e01e37}.section{padding:22px 24px;margin-bottom:14px}.section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}.section h2{margin:0;font-size:17px}.section-head a{color:#064cff;font-size:13px;font-weight:800}.timeline{display:grid;gap:0;padding-left:42px;position:relative}.timeline:before{content:"";position:absolute;left:17px;top:28px;bottom:28px;width:1px;background:#d8e4f7}.activity-row{display:grid;grid-template-columns:1fr auto;gap:18px;position:relative;padding:9px 0 13px}.activity-row .small-icon{position:absolute;left:-42px;top:7px;width:34px;height:34px;border-radius:50%;display:grid;place-items:center}.activity-row h3{margin:0 0 7px;font-size:13px}.activity-row p{margin:0;color:#26375e;font-size:12px;line-height:1.4}.activity-row time{font-size:12px;color:#43517b}.blue-soft{background:#eaf2ff;color:#064cff}.green-soft{background:#e8f8ef;color:#0da65c}.purple-soft{background:#efe7ff;color:#6c3ad7}.orange-soft{background:#fff2df;color:#f07800}.red-soft{background:#fff0f1;color:#e01e37}.chart-card{padding:18px 24px}.chart-wrap{display:grid;grid-template-columns:minmax(0,1fr) 190px;gap:24px;align-items:end}.chart-box{height:160px;position:relative}.legend{border:1px solid #e4ebf6;border-radius:8px;padding:13px 16px;display:grid;gap:15px}.legend-row{display:grid;grid-template-columns:12px 1fr auto;align-items:center;gap:10px;font-size:12px}.dot{width:8px;height:8px;border-radius:50%}.legend-total{display:flex;justify-content:space-between;font-weight:900;margin-top:8px}.side{display:grid;gap:14px}.side-card{padding:20px}.side-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px}.side-head h2,.side-card h2{margin:0;font-size:17px}.side-head a{color:#064cff;font-size:12px;font-weight:800}.interview{display:grid;grid-template-columns:58px 1fr;gap:14px;margin-bottom:24px}.logo{width:56px;height:56px;border-radius:8px;color:#fff;display:grid;place-items:center;text-align:center;font-weight:900}.logo strong{font-size:24px;line-height:.9}.logo span{font-size:10px}.navy{background:#102d68}.black{background:#181b21}.interview h3{margin:0 0 8px;font-size:14px}.interview p{margin:0 0 12px;color:#26375e;font-size:13px}.meta{display:flex;gap:16px;flex-wrap:wrap;color:#43517b;font-size:12px}.tag{height:22px;border-radius:5px;background:#dce9ff;color:#064cff;display:inline-grid;place-items:center;padding:0 10px;font-size:11px;font-weight:800;margin-top:8px}.notice{display:grid;grid-template-columns:38px 1fr auto;gap:12px;align-items:start;margin-bottom:18px}.notice h3{margin:0 0 5px;font-size:12px}.notice p{margin:0;color:#26375e;font-size:12px;line-height:1.35}.notice time{font-size:11px;color:#43517b}.achievement{text-align:center;padding:10px 12px}.badge-art{width:96px;height:80px;margin:0 auto 12px;background:linear-gradient(135deg,#0b5cff,#2c75ff);clip-path:polygon(50% 0,88% 16%,88% 63%,50% 100%,12% 63%,12% 16%);display:grid;place-items:center;color:#fff}.achievement h3{margin:0 0 9px;font-size:14px}.achievement p{margin:0 0 18px;color:#43517b;font-size:12px}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1240px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.stats{grid-template-columns:repeat(2,1fr)}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.title-row,.chart-wrap{grid-template-columns:1fr;display:grid}.stats{grid-template-columns:1fr}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px;padding:16px}.footer i{display:none}}
        .side-card .interview{grid-template-columns:58px minmax(0,1fr);align-items:start;margin-bottom:24px}
        .side-card .interview>div:nth-child(2){min-width:0}
        .side-card .interview h3{margin:0 0 7px;font-size:14px;line-height:1.2}
        .side-card .interview p{margin:0 0 10px;font-size:13px;line-height:1.2}
        .side-card .interview .meta{display:grid;grid-template-columns:1fr 1fr;gap:8px 12px;font-size:12px}
        .side-card .interview .meta span{display:inline-flex;align-items:center;gap:5px;white-space:nowrap}
        .side-card .interview .meta .icon{width:16px;height:16px}
        .side-card .interview .meta .icon svg{width:16px;height:16px}
        .side-card .interview .tag{display:inline-flex;width:max-content;margin-top:9px}
        @media(max-width:420px){.side-card .interview .meta{grid-template-columns:1fr}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 28px 32px!important}.layout{grid-template-columns:minmax(0,1fr) minmax(320px,364px)!important;align-items:start}.main-card,.section,.chart-card,.side-card{max-width:100%;overflow:hidden}.stats{grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.stat{min-width:0;grid-template-columns:46px minmax(0,1fr);gap:12px;padding:14px}.stat div,.activity-row div,.notice div,.interview div,.legend-row span{min-width:0}.stat span,.stat small,.activity-row h3,.activity-row p,.notice h3,.notice p,.interview h3,.interview p{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.title-row{align-items:center}.title{min-width:0}.chart-wrap{grid-template-columns:minmax(0,1fr) minmax(170px,190px)}.chart-box{min-width:0}.side{min-width:0}.side-card .interview{grid-template-columns:58px minmax(0,1fr);align-items:start}.side-card .interview .meta{display:grid;grid-template-columns:1fr 1fr;gap:8px 12px}.side-card .interview .meta span{display:inline-flex;align-items:center;gap:5px;white-space:nowrap}.notice{grid-template-columns:38px minmax(0,1fr) 44px}.timeline{min-width:0}.activity-row{grid-template-columns:minmax(0,1fr) 58px}.outline{white-space:nowrap}@media(max-width:1360px){.layout{grid-template-columns:1fr!important}.side{grid-template-columns:repeat(3,minmax(0,1fr));align-items:start}.chart-wrap{grid-template-columns:minmax(0,1fr) 220px}}@media(max-width:980px){.stats{grid-template-columns:repeat(2,minmax(0,1fr))!important}.side{grid-template-columns:1fr}.chart-wrap{grid-template-columns:1fr}.title-row{display:grid;grid-template-columns:1fr;gap:12px}.title-row .outline{justify-self:start}}@media(max-width:640px){.stats,.side{grid-template-columns:1fr!important}.stat span,.stat small,.activity-row h3,.activity-row p,.notice h3,.notice p,.interview h3,.interview p{white-space:normal}.activity-row{grid-template-columns:1fr}.activity-row time{justify-self:start}.notice{grid-template-columns:38px minmax(0,1fr)}.notice time{grid-column:2}.timeline{padding-left:38px}.timeline:before{left:15px}}
.activity-shell-fix{}
.page{padding:22px 30px 34px!important}.layout{display:grid!important;grid-template-columns:minmax(0,1fr) 360px!important;gap:20px!important}.layout>div{min-width:0;display:grid;gap:16px}.main-card{padding:20px!important}.title-row{display:grid!important;grid-template-columns:minmax(0,1fr) auto;align-items:start!important;margin-bottom:20px!important}.stats{grid-template-columns:repeat(4,minmax(150px,1fr))!important;gap:12px!important}.stat{height:auto!important;min-height:96px!important;padding:16px!important;align-items:center!important}.stat span,.stat small,.activity-row h3,.activity-row p,.notice h3,.notice p,.interview h3,.interview p{white-space:normal!important;overflow:visible!important;text-overflow:clip!important}.stat small{display:block;margin-top:6px}.section{padding:20px 22px!important;margin-bottom:0!important}.timeline{padding-left:44px!important}.activity-row{grid-template-columns:minmax(0,1fr) auto!important;gap:16px!important;padding:10px 0 16px!important}.activity-row time{white-space:nowrap}.chart-card{padding:20px 22px!important}.chart-wrap{grid-template-columns:minmax(0,1fr) 210px!important;gap:22px!important;align-items:center!important}.chart-box{height:180px!important}.side{display:grid!important;grid-template-columns:1fr!important;gap:16px!important;align-content:start}.side-card{padding:18px!important}.side-card .interview{grid-template-columns:58px minmax(0,1fr)!important;gap:14px!important;margin-bottom:20px!important}.side-card .interview:last-child{margin-bottom:0!important}.side-card .interview .meta{grid-template-columns:1fr!important;gap:7px!important}.notice{grid-template-columns:38px minmax(0,1fr) auto!important;gap:12px!important}.notice time{white-space:nowrap}.achievement{padding:8px 8px 4px!important}@media(max-width:1360px){.layout{grid-template-columns:1fr!important}.side{grid-template-columns:repeat(3,minmax(0,1fr))!important}.stats{grid-template-columns:repeat(4,minmax(0,1fr))!important}.chart-wrap{grid-template-columns:minmax(0,1fr) 220px!important}}@media(max-width:1100px){.stats{grid-template-columns:repeat(2,minmax(0,1fr))!important}.side{grid-template-columns:1fr!important}.chart-wrap{grid-template-columns:1fr!important}.chart-box{height:220px!important}}@media(max-width:700px){.page{padding:16px!important}.title-row{grid-template-columns:1fr!important}.title-row .outline{justify-self:start}.stats{grid-template-columns:1fr!important}.activity-row{grid-template-columns:1fr!important}.activity-row time{justify-self:start}.notice{grid-template-columns:38px minmax(0,1fr)!important}.notice time{grid-column:2;justify-self:start}.timeline{padding-left:38px!important}.timeline:before{left:15px!important}}
.empty{border:1px dashed #cbd8ee;border-radius:10px;background:#fbfdff;padding:24px;text-align:center;color:#43517b}.bar-chart{height:100%;display:grid;grid-template-columns:repeat(7,1fr);align-items:end;gap:12px;padding:16px 8px 28px;border-left:1px solid #e4ebf6;border-bottom:1px solid #e4ebf6}.bar{position:relative;min-height:8px;background:#0b5cff;border-radius:5px 5px 0 0}.bar span{position:absolute;left:50%;bottom:-24px;transform:translateX(-50%);font-size:11px;color:#43517b}.logo img{width:100%;height:100%;object-fit:cover;border-radius:8px}.outline{cursor:pointer}.stat-icon{align-self:center;justify-self:center}
</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1 data-user-name>{{ $user['name'] }}!</h1></div>
                <div class="layout">
                    <div>
                        <section class="card main-card"><div class="title-row"><div class="title"><h2>Activity Dashboard</h2><p>Track your progress, updates and important activities</p></div><button class="outline" data-date-filter type="button"><span class="icon" data-icon="calendar"></span><span data-today-label>Today</span><span class="icon" data-icon="chevron"></span></button></div><div class="stats" data-stats></div></section>
                        <section class="card section"><div class="section-head"><h2>Recent Activity</h2><a href="#" data-view-all-activity>View All Activity</a></div><div class="timeline" data-timeline><div class="empty">Loading activity...</div></div></section>
                        <section class="card chart-card"><div class="section-head"><h2>Weekly Activity Overview</h2></div><div class="chart-wrap"><div class="chart-box" data-chart><div class="empty">Loading chart...</div></div><div><div class="legend" data-legend></div><div class="legend-total"><span>Total</span><b data-total>0</b></div></div></div></section>
                    </div>
                    <aside class="side">
                        <article class="card side-card"><div class="side-head"><h2>Upcoming Interviews</h2><a href="/direct-mode/interviews">View All</a></div><div data-upcoming-interviews><div class="empty">Loading interviews...</div></div></article>
                        <article class="card side-card"><div class="side-head"><h2>Recent Notifications</h2><a href="#" data-view-notifications>View All</a></div><div data-notifications><div class="empty">Loading notifications...</div></div><a class="outline" data-all-notifications href="#" style="width:100%;border-color:transparent;color:#064cff">View All Notifications</a></article>
                        <article class="card side-card"><h2>Recent Achievements</h2><div class="achievement" data-achievement></div></article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',send:'<svg viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4 20-7Z"></path><path d="M22 2 11 13"></path></svg>',star:'<svg viewBox="0 0 24 24"><path d="m12 2 3 7 7 .6-5.4 4.7 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.6 9 9l3-7Z"></path></svg>',x:'<svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg>',trophy:'<svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4M19 5h2v3a4 4 0 0 1-4 4"></path></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const token = localStorage.getItem('onlyfreshers_token') || localStorage.getItem('ofc_auth_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || localStorage.getItem('ofc_auth_user') || '{}'); } catch (error) { authUser = {}; }
        const state = { dashboard: {}, applications: [], notifications: [], activities: [], certificates: [], unreadCount: 0, dateMode: 'today' };

        function hydrateIcons(root = document) {
            root.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = icons[el.dataset.icon] || ''; });
        }

        function headers() {
            return { 'Accept': 'application/json', ...(token ? { 'Authorization': `Bearer ${token}` } : {}) };
        }

        function job(app) {
            return app.job || {};
        }

        function company(app) {
            return job(app).company_profile || job(app).companyProfile || {};
        }

        function companyName(app) {
            return company(app).company_name || job(app).company_name || 'Company';
        }

        function interviewJob(interview) {
            return (interview.job_application || interview.jobApplication || {}).job || {};
        }

        function interviewCompany(interview) {
            const j = interviewJob(interview);
            return j.company_profile || j.companyProfile || {};
        }

        function interviewCompanyName(interview) {
            return interviewCompany(interview).company_name || 'Company';
        }

        function timeAgo(raw) {
            if (!raw) return 'Recently';
            const diff = Math.max(0, Date.now() - new Date(raw).getTime());
            const hours = Math.floor(diff / 3600000);
            if (hours < 1) return 'Just now';
            if (hours < 24) return `${hours}h ago`;
            const days = Math.floor(hours / 24);
            if (days < 7) return `${days}d ago`;
            return `${Math.floor(days / 7)}w ago`;
        }

        function formatDate(raw) {
            if (!raw) return 'Date not shared';
            return new Date(raw).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        function formatTime(raw) {
            if (!raw) return 'Time not shared';
            const [hour, minute] = String(raw).split(':');
            const date = new Date();
            date.setHours(Number(hour || 0), Number(minute || 0), 0, 0);
            return date.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
        }

        function statusActivity(app) {
            const status = String(app.application_status || 'applied').toLowerCase();
            const map = {
                applied: ['Application Submitted', `You applied for ${job(app).title || 'a job'} at ${companyName(app)}`, 'send', 'blue-soft'],
                under_review: ['Application Under Review', `${job(app).title || 'Your application'} is being reviewed by ${companyName(app)}`, 'briefcase', 'blue-soft'],
                shortlisted: ['Shortlisted', `You have been shortlisted for ${job(app).title || 'a role'} at ${companyName(app)}`, 'star', 'green-soft'],
                interview_scheduled: ['Interview Scheduled', `Your interview for ${job(app).title || 'a role'} at ${companyName(app)} has been scheduled`, 'calendar', 'purple-soft'],
                hired: ['Offer Received', `Congratulations! You have received an offer for ${job(app).title || 'a role'} at ${companyName(app)}`, 'briefcase', 'orange-soft'],
                rejected: ['Application Rejected', `${job(app).title || 'Application'} at ${companyName(app)}`, 'x', 'red-soft'],
            };
            const [title, text, icon, tone] = map[status] || map.applied;
            return { title, text, icon, tone, time: timeAgo(app.updated_at || app.applied_at || app.created_at), raw: app.updated_at || app.applied_at || app.created_at };
        }

        function buildActivities() {
            const applicationActivities = state.applications.map(statusActivity);
            const notificationActivities = state.notifications.map(note => ({
                title: note.title || 'Notification',
                text: note.message || note.body || note.description || '',
                time: timeAgo(note.created_at),
                raw: note.created_at,
                icon: 'bell',
                tone: note.is_read ? 'blue-soft' : 'orange-soft',
            }));
            const interviewActivities = (state.dashboard.upcoming_interviews || []).map(interview => ({
                title: 'Interview Scheduled',
                text: `${interviewJob(interview).title || 'Interview'} at ${interviewCompanyName(interview)} on ${formatDate(interview.interview_date)}`,
                time: timeAgo(interview.created_at || interview.updated_at || interview.interview_date),
                raw: interview.created_at || interview.updated_at || interview.interview_date,
                icon: 'calendar',
                tone: 'purple-soft',
            }));
            const certificateActivities = state.certificates.map(certificate => ({
                title: 'Certificate Earned',
                text: certificate.course_enrollment?.course?.course_name || 'Fast Track certificate generated',
                time: timeAgo(certificate.created_at),
                raw: certificate.created_at,
                icon: 'trophy',
                tone: 'green-soft',
            }));
            state.activities = [...applicationActivities, ...notificationActivities, ...interviewActivities, ...certificateActivities]
                .sort((a, b) => new Date(b.raw || 0) - new Date(a.raw || 0));
        }

        function render() {
            buildActivities();
            renderStats();
            renderTimeline(6);
            renderChart();
            renderUpcomingInterviews();
            renderNotifications(3);
            renderAchievement();
        }

        function renderStats() {
            const stats = state.dashboard.statistics || {};
            const interviews = state.dashboard.upcoming_interviews || [];
            const items = [
                [state.activities.length, 'Total Activities', 'from your latest updates', 'chart', 'blue'],
                [stats.total_applications ?? state.applications.length, 'Applications Updated', 'live application status', 'briefcase', 'green'],
                [interviewsThisWeek(interviews), 'Interviews This Week', 'scheduled interviews', 'calendar', 'purple'],
                [state.unreadCount || state.notifications.filter(note => !note.is_read).length, 'New Notifications', 'unread notifications', 'bell', 'orange'],
            ];
            $('[data-stats]').innerHTML = items.map(([value, label, note, icon, tone]) => `<div class="stat"><span class="stat-icon ${tone}" data-icon="${icon}"></span><div><strong>${value}</strong><span>${label}</span><small>${note}</small></div></div>`).join('');
            hydrateIcons($('[data-stats]'));
        }

        function renderTimeline(limit) {
            const timeline = $('[data-timeline]');
            const items = state.activities.slice(0, limit);
            if (!items.length) {
                timeline.innerHTML = '<div class="empty">No recent activity yet.</div>';
                return;
            }
            timeline.innerHTML = items.map(item => `<div class="activity-row"><span class="small-icon ${item.tone}" data-icon="${item.icon}"></span><div><h3>${escapeHtml(item.title)}</h3><p>${escapeHtml(item.text)}</p></div><time>${escapeHtml(item.time)}</time></div>`).join('');
            hydrateIcons(timeline);
        }

        function renderChart() {
            const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            const values = labels.map((_, index) => {
                return state.activities.filter(item => {
                    const date = item.raw ? new Date(item.raw) : null;
                    return date && date.getDay() === ((index + 1) % 7);
                }).length;
            });
            const max = Math.max(...values, 1);
            $('[data-chart]').innerHTML = `<div class="bar-chart">${values.map((value, index) => `<div class="bar" style="height:${Math.max(8, (value / max) * 100)}%"><span>${labels[index]}</span></div>`).join('')}</div>`;
            const legend = [
                ['Applications', state.applications.length, '#0b5cff'],
                ['Interview Updates', state.dashboard.upcoming_interviews?.length || 0, '#12a866'],
                ['Offers', state.applications.filter(app => ['hired', 'offered'].includes(String(app.application_status).toLowerCase())).length, '#ff8a00'],
                ['Notifications', state.notifications.length, '#7a45e8'],
            ];
            $('[data-legend]').innerHTML = legend.map(([label, value, color]) => `<div class="legend-row"><span class="dot" style="background:${color}"></span><span>${label}</span><b>${value}</b></div>`).join('');
            $('[data-total]').textContent = state.activities.length;
        }

        function renderUpcomingInterviews() {
            const wrap = $('[data-upcoming-interviews]');
            const interviews = (state.dashboard.upcoming_interviews || []).slice().sort((a, b) => interviewDateValue(a) - interviewDateValue(b)).slice(0, 3);
            if (!interviews.length) {
                wrap.innerHTML = '<div class="empty">No upcoming interviews.</div>';
                return;
            }
            wrap.innerHTML = interviews.map(interview => {
                const j = interviewJob(interview);
                const logo = logoHtml(interviewCompanyName(interview), interviewCompany(interview).company_logo);
                return `<div class="interview"><div class="logo navy">${logo}</div><div><h3>${escapeHtml(j.title || 'Interview')}</h3><p>${escapeHtml(interviewCompanyName(interview))}</p><div class="meta"><span><span class="icon" data-icon="calendar"></span>${escapeHtml(formatDate(interview.interview_date))}</span><span><span class="icon" data-icon="clock"></span>${escapeHtml(formatTime(interview.interview_time))}</span></div><span class="tag">${escapeHtml(interview.meeting_link ? 'Video Interview' : (interview.interview_mode || 'Interview'))}</span></div></div>`;
            }).join('');
            hydrateIcons(wrap);
        }

        function renderNotifications(limit) {
            const wrap = $('[data-notifications]');
            const notes = state.notifications.slice(0, limit);
            if (!notes.length) {
                wrap.innerHTML = '<div class="empty">No notifications yet.</div>';
                return;
            }
            wrap.innerHTML = notes.map(note => `<div class="notice"><span class="small-icon ${note.is_read ? 'blue-soft' : 'orange-soft'}" data-icon="bell"></span><div><h3>${escapeHtml(note.title || 'Notification')}</h3><p>${escapeHtml(note.message || note.body || '')}</p></div><time>${escapeHtml(timeAgo(note.created_at))}</time></div>`).join('');
            hydrateIcons(wrap);
        }

        function renderAchievement() {
            const profile = state.dashboard.profile || {};
            $('[data-achievement]').innerHTML = `<div class="badge-art"><span class="icon" data-icon="trophy"></span></div><h3>${achievementTitle(profile)}</h3><p>${achievementText(profile)}</p><a class="outline" href="/direct-mode/profile" style="width:100%;color:#064cff;border-color:#064cff">View Achievements</a>`;
            hydrateIcons($('[data-achievement]'));
        }

        function achievementTitle(profile) {
            const firstName = (authUser.name || state.dashboard.user?.name || 'Fresher').split(' ')[0] || 'Fresher';
            const stats = state.dashboard.statistics || {};
            if ((stats.hired_applications || 0) > 0) return `Offer unlocked, ${escapeHtml(firstName)}!`;
            if ((stats.interview_scheduled_applications || 0) > 0) return `Interview ready, ${escapeHtml(firstName)}!`;
            if (Number(profile.profile_completion || 0) >= 80) return `Profile strong, ${escapeHtml(firstName)}!`;
            return `Great going, ${escapeHtml(firstName)}!`;
        }

        function achievementText(profile) {
            const stats = state.dashboard.statistics || {};
            if ((stats.hired_applications || 0) > 0) return 'You have an offer update. Review your offers and next steps.';
            if ((stats.interview_scheduled_applications || 0) > 0) return 'You have interview activity. Prepare and track interview updates.';
            return `Your profile is ${Number(profile.profile_completion || 0)}% complete. Keep applying and tracking your progress.`;
        }

        function logoHtml(name, logo) {
            if (logo) return `<img src="${escapeAttr(logo)}" alt="${escapeAttr(name)}">`;
            const initials = String(name || 'OF').split(/\s+/).filter(Boolean).slice(0, 2).map(word => word[0]).join('').toUpperCase();
            return `<div><strong>${escapeHtml(initials)}</strong><span>${escapeHtml(String(name || 'OF').slice(0, 8))}</span></div>`;
        }

        async function loadData() {
            if (!token) {
                render();
                return;
            }
            const requests = [
                fetch('/api/fresher/dashboard', { headers: headers() }).then(response => response.json()).catch(() => ({})),
                fetch('/api/fresher/applications', { headers: headers() }).then(response => response.json()).catch(() => ({})),
                fetch('/api/notifications?per_page=12', { headers: headers() }).then(response => response.json()).catch(() => ({})),
                fetch('/api/notifications/unread-count', { headers: headers() }).then(response => response.json()).catch(() => ({})),
                fetch('/api/fresher/certificates', { headers: headers() }).then(response => response.json()).catch(() => ({})),
            ];
            const [dashboard, applications, notifications, unread, certificates] = await Promise.all(requests);
            state.dashboard = dashboard.data || {};
            state.applications = applications.data?.applications || state.dashboard.recent_applications || [];
            const paginated = notifications.data?.notifications;
            state.notifications = paginated?.data || notifications.data?.notifications || [];
            state.unreadCount = unread.data?.unread_count || 0;
            state.certificates = certificates.data?.certificates || state.dashboard.recent_certificates || [];
            render();
        }

        function wireControls() {
            $('[data-view-all-activity]').addEventListener('click', event => { event.preventDefault(); renderTimeline(state.activities.length); });
            $('[data-view-notifications]').addEventListener('click', event => { event.preventDefault(); renderNotifications(state.notifications.length); });
            $('[data-all-notifications]').addEventListener('click', event => { event.preventDefault(); renderNotifications(state.notifications.length); });
            $('[data-date-filter]').addEventListener('click', () => {
                state.dateMode = state.dateMode === 'today' ? 'week' : 'today';
                $('[data-today-label]').textContent = state.dateMode === 'today' ? new Date().toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : 'This Week';
                renderTimeline(state.dateMode === 'today' ? 6 : state.activities.length);
            });
            const headerSearch = document.querySelector('.search-top input');
            if (headerSearch) {
                headerSearch.addEventListener('keydown', event => {
                    if (event.key === 'Enter' && headerSearch.value.trim()) {
                        window.location.href = `/direct-mode/jobs?search=${encodeURIComponent(headerSearch.value.trim())}`;
                    }
                });
            }
        }

        function updateUserChrome() {
            const name = authUser.name || 'Fresher';
            $('[data-user-name]').textContent = `${name}!`;
            $('[data-today-label]').textContent = new Date().toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
            const topUser = document.querySelector('.top-user strong, .user strong');
            if (topUser) topUser.textContent = name;
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]));
        }

        function escapeAttr(value) {
            return escapeHtml(value).replace(/`/g, '&#096;');
        }

        function interviewDateValue(interview) {
            return new Date(`${interview.interview_date || ''}T${interview.interview_time || '00:00'}`).getTime() || 0;
        }

        function interviewsThisWeek(interviews) {
            const now = new Date();
            const start = new Date(now);
            start.setDate(now.getDate() - now.getDay());
            start.setHours(0, 0, 0, 0);
            const end = new Date(start);
            end.setDate(start.getDate() + 7);
            return interviews.filter(interview => {
                const value = interviewDateValue(interview);
                return value >= start.getTime() && value < end.getTime();
            }).length;
        }

        hydrateIcons();
        updateUserChrome();
        wireControls();
        loadData();
    </script>
@endpush
