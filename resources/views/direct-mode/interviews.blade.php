@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
@endphp

@php $activePage = 'interviews'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Interviews - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:238px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:76px;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #d8e4f7}.brand img{width:200px}.menu{padding:30px 16px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.metric-icon svg,.tip-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:50px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:30px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:34px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 21px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:76px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,560px) 1fr;align-items:center;gap:30px;padding:0 30px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.page{padding:24px 30px 16px}.welcome-bar{display:flex;align-items:center;justify-content:space-between;margin:0 0 14px 4px}.welcome small{font-size:13px}.welcome h1{margin:4px 0 0;font-size:21px}.outline{height:36px;border:1px solid #064cff;border-radius:6px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap}.layout{display:grid;grid-template-columns:minmax(0,1fr) 372px;gap:16px}.card{background:rgba(255,255,255,.9);border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.main-card{padding:17px}.title h2{margin:0 0 10px;font-size:25px}.title p{margin:0 0 14px;color:#43517b;font-size:14px}.metrics{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:16px}.metric{height:86px;border:1px solid #d8e4f7;border-radius:10px;background:#fff;display:grid;grid-template-columns:50px 1fr;align-items:center;gap:14px;padding:16px}.metric-icon,.tip-icon{width:46px;height:46px;border-radius:10px;display:grid;place-items:center}.blue-soft{background:#eaf2ff;color:#064cff}.purple-soft{background:#efe7ff;color:#6c3ad7}.orange-soft{background:#fff2df;color:#f07800}.red-soft{background:#fff0f1;color:#e01e37}.green-soft{background:#e8f8ef;color:#0da65c}.metric strong{display:block;font-size:22px}.metric b{display:block;color:#008a35;font-size:12px}.metric span{display:block;font-size:12px;color:#43517b}.section{border:1px solid #d8e4f7;border-radius:10px;background:#fff;padding:17px 20px;margin-bottom:14px}.section h2{margin:0 0 16px;font-size:16px}.interview{display:grid;grid-template-columns:76px minmax(0,1fr) 90px 118px 118px;gap:16px;align-items:center;padding:16px 0;border-top:1px solid #e7edf7}.interview:first-of-type{border-top:0}.logo{width:68px;height:68px;border-radius:8px;color:#fff;display:grid;place-items:center;text-align:center;font-weight:900}.logo strong{font-size:28px;line-height:.9}.logo span{font-size:11px}.navy{background:#102d68}.orange{background:linear-gradient(135deg,#ff8b29,#ff4d08)}.black{background:#181b21}.purple-logo{background:linear-gradient(135deg,#7b4be8,#4522aa)}.info h3{margin:0 0 8px;font-size:16px}.info p{margin:0 0 14px;font-size:13px}.meta{display:flex;gap:24px;flex-wrap:wrap;color:#536188;font-size:12px}.people{display:flex;align-items:center;gap:8px;margin-top:20px;color:#536188;font-size:12px}.face{width:22px;height:22px;border-radius:50%;background:#eaf2ff;color:#064cff;display:grid;place-items:center;font-size:10px;font-weight:800;border:1px solid #d8e4f7;margin-left:-5px}.badge{height:24px;border:1px solid #bde6ce;background:#e8f8ef;color:#008a35;border-radius:5px;display:grid;place-items:center;font-size:11px;font-weight:800;padding:0 12px}.countdown{text-align:right;color:#43517b;font-size:12px}.countdown strong{display:block;color:#064cff;font-size:18px;margin-top:4px}.past-row{display:grid;grid-template-columns:64px 1fr 88px 106px;gap:16px;align-items:center;padding:14px 0;border-top:1px solid #e7edf7}.past-row:first-of-type{border-top:0}.past-row .logo{width:58px;height:58px}.past-row .logo strong{font-size:24px}.view-past{text-align:center;color:#064cff;font-weight:800;font-size:13px;margin-top:14px}.side{display:grid;gap:16px}.side-card{padding:20px}.side-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}.side-head h2,.side-card h2{margin:0;font-size:17px}.side-head a{font-size:12px;color:#064cff;font-weight:800}.cal-nav{display:flex;align-items:center;justify-content:space-between;margin:8px 0 18px}.square{width:38px;height:38px;border:1px solid #d8e4f7;border-radius:7px;background:#fff;display:grid;place-items:center;color:#064cff}.calendar{display:grid;grid-template-columns:repeat(7,1fr);gap:18px 16px;text-align:center;font-size:13px}.day-name{font-weight:800;color:#26375e}.muted{color:#a4aec6}.day{position:relative;height:20px}.day.active{color:#fff;background:#064cff;border-radius:50%;width:31px;height:31px;display:grid;place-items:center;margin:-5px auto}.day.mark{color:#6c3ad7;background:#efe7ff;border-radius:50%;width:31px;height:31px;display:grid;place-items:center;margin:-5px auto}.day.mark:after{content:"";position:absolute;bottom:-4px;width:6px;height:6px;border-radius:50%;background:#064cff}.tips{display:grid;gap:18px;margin:22px 0}.tip{display:grid;grid-template-columns:46px 1fr;gap:14px;align-items:center}.tip h3{margin:0 0 7px;font-size:13px}.tip p{margin:0;color:#43517b;font-size:12px;line-height:1.4}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1220px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.metrics{grid-template-columns:repeat(2,1fr)}.interview{grid-template-columns:76px 1fr 90px 118px}.past-row{grid-template-columns:64px 1fr 88px}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.welcome-bar{flex-direction:column;align-items:flex-start;gap:12px}.metrics,.interview,.past-row{grid-template-columns:1fr}.countdown{text-align:left}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px;padding:16px}.footer i{display:none}}
        .interview{grid-template-columns:76px minmax(0,1fr) 90px 118px 126px}
        .interview .primary,.interview .outline,.past-row .outline{white-space:nowrap;min-width:112px;padding-left:14px;padding-right:14px}
        @media(max-width:1220px){.interview{grid-template-columns:76px minmax(0,1fr) 90px 126px}}
        @media(max-width:760px){.interview .primary,.interview .outline,.past-row .outline{width:max-content;max-width:100%}}

body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 28px 32px!important}.layout{grid-template-columns:minmax(0,1fr) minmax(320px,372px)!important;align-items:start}.main-card,.side-card{max-width:100%;overflow:hidden}.metrics{grid-template-columns:repeat(4,minmax(0,1fr))}.metric{min-width:0}.metric div{min-width:0}.metric b,.metric span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.section{max-width:100%;overflow:hidden}.interview{grid-template-columns:76px minmax(220px,1fr) 90px 112px 112px 118px!important;gap:14px}.interview .info,.past-row .info{min-width:0}.info h3,.info p{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.meta{gap:14px}.meta span{display:inline-flex;align-items:center;gap:5px;min-width:0}.past-row{grid-template-columns:64px minmax(220px,1fr) 90px 118px!important}.calendar{gap:16px 12px}.side{min-width:0}@media(max-width:1320px){.layout{grid-template-columns:1fr!important}.interview{grid-template-columns:76px minmax(0,1fr) 90px 112px 118px!important}.interview .primary{grid-column:2 / -1;justify-self:start}.past-row{grid-template-columns:64px minmax(0,1fr) 90px 118px!important}}@media(max-width:760px){.metrics{grid-template-columns:1fr!important}.interview,.past-row{grid-template-columns:1fr!important}.info h3,.info p{white-space:normal}.interview .primary{grid-column:auto}.calendar{gap:14px 8px}}
.interview{grid-template-columns:72px minmax(0,1fr) 96px 108px 128px!important;grid-template-rows:auto auto;column-gap:16px;row-gap:10px;align-items:center}.interview>.logo,.interview>.info,.interview>.badge,.interview>.countdown{grid-row:1 / span 2}.interview>.outline{grid-column:5;grid-row:1;width:128px;min-width:0;padding:0 10px}.interview>.primary{grid-column:5;grid-row:2;width:128px;min-width:0;padding:0 10px}.countdown{text-align:center;justify-self:center;min-width:96px}.countdown strong{white-space:nowrap}.badge{width:96px;padding:0 8px;justify-self:center}.people{margin-top:14px;min-height:22px}.main-card{min-width:0}.section{padding:17px 18px}.layout{grid-template-columns:minmax(0,1fr) 340px!important;gap:18px}.side-card{padding:18px}.calendar{gap:16px 10px;align-items:center}.tips{gap:15px}.past-row{grid-template-columns:60px minmax(0,1fr) 96px 128px!important;column-gap:16px}.past-row>.outline{width:128px;min-width:0;padding:0 10px}.metric{grid-template-columns:46px minmax(0,1fr);gap:12px;padding:14px}.metrics{align-items:stretch}.metric{height:86px}.metric-icon{align-self:center;justify-self:center}.empty{border:1px dashed #cbd8ee;border-radius:10px;background:#fbfdff;padding:24px;text-align:center;color:#43517b}.logo{justify-self:center}.logo img{width:100%;height:100%;object-fit:cover;border-radius:8px}.day.has-interview{color:#6c3ad7;background:#efe7ff;border-radius:50%;width:31px;height:31px;display:grid;place-items:center;margin:-5px auto}.day.has-interview:after{content:"";position:absolute;bottom:-4px;width:6px;height:6px;border-radius:50%;background:#064cff}.day.today{color:#fff;background:#064cff;border-radius:50%;width:31px;height:31px;display:grid;place-items:center;margin:-5px auto}.tip{align-items:start}.tip-icon{margin-top:2px;flex:0 0 46px}.cal-nav strong{text-align:center;min-width:150px}.square{flex:0 0 38px}@media(max-width:1440px){.layout{grid-template-columns:1fr!important}.side{grid-template-columns:1fr 1fr;align-items:start}.interview{grid-template-columns:72px minmax(0,1fr) 96px 108px 128px!important}.past-row{grid-template-columns:60px minmax(0,1fr) 96px 128px!important}}@media(max-width:900px){.side{grid-template-columns:1fr}.metrics{grid-template-columns:repeat(2,minmax(0,1fr))!important}.interview{grid-template-columns:68px minmax(0,1fr) 112px!important;grid-template-rows:auto auto auto;align-items:center}.interview>.logo{grid-column:1;grid-row:1 / span 2}.interview>.info{grid-column:2;grid-row:1 / span 2}.interview>.badge{grid-column:3;grid-row:1;width:112px}.interview>.countdown{grid-column:3;grid-row:2;min-width:112px}.interview>.outline{grid-column:2;grid-row:3;width:128px}.interview>.primary{grid-column:3;grid-row:3;width:128px}.past-row{grid-template-columns:58px minmax(0,1fr) 112px!important}.past-row>.outline{grid-column:2 / -1;justify-self:start}}@media(max-width:620px){.metrics,.side,.interview,.past-row{grid-template-columns:1fr!important}.interview>.logo,.interview>.info,.interview>.badge,.interview>.countdown,.interview>.outline,.interview>.primary,.past-row>.outline{grid-column:auto;grid-row:auto;width:max-content;max-width:100%;justify-self:start}.countdown{text-align:left}.info h3,.info p{white-space:normal}.meta{gap:10px}.welcome-bar{align-items:flex-start}.metric{height:auto;min-height:78px}.calendar{gap:14px 8px}}
</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome-bar"><div class="welcome"><small>Welcome back,</small><h1 data-user-name>{{ $user['name'] }}!</h1></div><button class="outline" data-calendar-view type="button"><span class="icon" data-icon="calendar"></span>Calendar View</button></div>
                <div class="layout">
                    <section class="card main-card">
                        <div class="title"><h2>Interviews</h2><p>Manage your upcoming and past interviews</p></div>
                        <div class="metrics" data-metrics></div>
                        <article class="section">
                            <h2>Upcoming Interviews</h2>
                            <div data-upcoming><div class="empty">Loading upcoming interviews...</div></div>
                        </article>
                        <article class="section">
                            <h2>Past Interviews</h2>
                            <div data-past><div class="empty">Loading past interviews...</div></div>
                            <a class="view-past" data-view-past href="#">View All Past Interviews</a>
                        </article>
                    </section>
                    <aside class="side">
                        <article class="card side-card">
                            <div class="side-head"><h2>Interview Calendar</h2><a href="#" data-full-calendar>View Full Calendar</a></div>
                            <div class="cal-nav"><button class="square" data-prev-month type="button">&lt;</button><strong data-month-label>Calendar</strong><button class="square" data-next-month type="button">&gt;</button></div>
                            <div class="calendar" data-calendar></div>
                        </article>
                        <article class="card side-card"><h2>Tips to Prepare</h2><div class="tips" data-tips></div><button class="outline" data-view-tips type="button" style="width:100%">View All Tips</button></article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>','check-square':'<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"></rect><path d="m9 12 2 2 4-4"></path></svg>',x:'<svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg>',video:'<svg viewBox="0 0 24 24"><path d="M16 13 22 17V7l-6 4Z"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>',building:'<svg viewBox="0 0 24 24"><path d="M3 21h18M5 21V5h10v16M15 9h4v12M8 8h3M8 12h3M8 16h3"></path></svg>',book:'<svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5Z"></path></svg>',trophy:'<svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4M19 5h2v3a4 4 0 0 1-4 4"></path></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => Array.from(document.querySelectorAll(selector));
        const token = localStorage.getItem('onlyfreshers_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || '{}'); } catch (error) { authUser = {}; }
        const state = { interviews: [], applications: [], calendarDate: new Date() };

        function hydrateIcons(root = document) {
            root.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = icons[el.dataset.icon] || ''; });
        }

        function headers() {
            return { 'Accept': 'application/json', ...(token ? { 'Authorization': `Bearer ${token}` } : {}) };
        }

        function application(interview) {
            return interview.job_application || interview.jobApplication || {};
        }

        function job(interview) {
            return application(interview).job || {};
        }

        function company(interview) {
            return job(interview).company_profile || job(interview).companyProfile || {};
        }

        function companyName(interview) {
            return company(interview).company_name || job(interview).company_name || 'Company';
        }

        function logoText(interview) {
            return companyName(interview).split(/\s+/).filter(Boolean).slice(0, 2).map(word => word[0]).join('').toUpperCase() || 'OF';
        }

        function interviewDate(interview) {
            return interview.interview_date ? new Date(`${interview.interview_date}T${interview.interview_time || '00:00'}`) : null;
        }

        function isUpcoming(interview) {
            const date = interviewDate(interview);
            return date && date >= startOfToday() && !['completed', 'cancelled'].includes(String(interview.status || '').toLowerCase());
        }

        function isPast(interview) {
            return !isUpcoming(interview);
        }

        function startOfToday() {
            const date = new Date();
            date.setHours(0, 0, 0, 0);
            return date;
        }

        function formatDate(date) {
            if (!date) return 'Date not shared';
            return date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric', weekday: 'short' });
        }

        function formatTime(time) {
            if (!time) return 'Time not shared';
            const [hour, minute] = String(time).split(':');
            const date = new Date();
            date.setHours(Number(hour || 0), Number(minute || 0), 0, 0);
            return date.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit' });
        }

        function countdown(interview) {
            const date = interviewDate(interview);
            if (!date) return 'TBD';
            const days = Math.ceil((date - startOfToday()) / 86400000);
            if (days <= 0) return 'Today';
            if (days === 1) return '1 Day';
            return `${days} Days`;
        }

        function modeLabel(interview) {
            if (interview.meeting_link) return 'Video Interview';
            if (interview.interview_location) return interview.interview_location;
            return String(interview.interview_mode || 'Interview').replace('_', ' ');
        }

        function render() {
            const upcoming = state.interviews.filter(isUpcoming).sort((a, b) => interviewDate(a) - interviewDate(b));
            const past = state.interviews.filter(isPast).sort((a, b) => (interviewDate(b) || 0) - (interviewDate(a) || 0));
            renderMetrics(upcoming, past);
            renderUpcoming(upcoming);
            renderPast(past);
            renderCalendar();
            renderTips();
        }

        function renderMetrics(upcoming, past) {
            const completed = state.interviews.filter(item => String(item.status).toLowerCase() === 'completed').length;
            const cancelled = state.interviews.filter(item => String(item.status).toLowerCase() === 'cancelled').length;
            const rescheduled = state.interviews.filter(item => String(item.status).toLowerCase() === 'rescheduled').length;
            const items = [
                [upcoming.length, 'Upcoming', 'Interviews', 'calendar', 'blue-soft'],
                [completed || past.length, 'Completed', 'Interviews', 'check-square', 'purple-soft'],
                [rescheduled, 'Rescheduled', 'Interviews', 'clock', 'orange-soft'],
                [cancelled, 'Cancelled', 'Interviews', 'x', 'red-soft'],
            ];
            $('[data-metrics]').innerHTML = items.map(([value, title, sub, icon, tone]) => `<div class="metric"><span class="metric-icon ${tone}" data-icon="${icon}"></span><div><strong>${value}</strong><b>${title}</b><span>${sub}</span></div></div>`).join('');
            hydrateIcons($('[data-metrics]'));
        }

        function renderUpcoming(items) {
            const wrap = $('[data-upcoming]');
            if (!items.length) {
                wrap.innerHTML = '<div class="empty">No upcoming interviews scheduled yet.</div>';
                return;
            }
            wrap.innerHTML = items.map(interview => `
                <div class="interview" data-job-id="${job(interview).id || ''}">
                    <div class="logo navy">${logoHtml(interview)}</div>
                    <div class="info"><h3>${escapeHtml(job(interview).title || 'Interview')}</h3><p>${escapeHtml(companyName(interview))}</p><div class="meta"><span><span class="icon" data-icon="calendar"></span>${escapeHtml(formatDate(interviewDate(interview)))}</span><span><span class="icon" data-icon="clock"></span>${escapeHtml(formatTime(interview.interview_time))}</span><span><span class="icon" data-icon="video"></span>${escapeHtml(modeLabel(interview))}</span></div><div class="people">Interviewers:<span class="face">${escapeHtml(companyName(interview)[0] || 'C')}</span><span class="face">HR</span></div></div>
                    <span class="badge">${escapeHtml(titleCase(interview.status || 'scheduled'))}</span>
                    <div class="countdown">Interview in<strong>${escapeHtml(countdown(interview))}</strong></div>
                    <button class="outline" data-detail type="button">View Details</button>
                    <button class="primary" data-prepare type="button">Prepare Now</button>
                </div>`).join('');
            hydrateIcons(wrap);
            bindInterviewActions(wrap);
        }

        function renderPast(items) {
            const wrap = $('[data-past]');
            const shown = items.slice(0, 3);
            if (!shown.length) {
                wrap.innerHTML = '<div class="empty">No past interviews yet.</div>';
                return;
            }
            wrap.innerHTML = shown.map(interview => `
                <div class="past-row" data-job-id="${job(interview).id || ''}">
                    <div class="logo navy">${logoHtml(interview)}</div>
                    <div class="info"><h3>${escapeHtml(job(interview).title || 'Interview')}</h3><p>${escapeHtml(companyName(interview))}</p><div class="meta"><span><span class="icon" data-icon="calendar"></span>${escapeHtml(formatDate(interviewDate(interview)))}</span><span><span class="icon" data-icon="clock"></span>${escapeHtml(formatTime(interview.interview_time))}</span><span><span class="icon" data-icon="video"></span>${escapeHtml(modeLabel(interview))}</span></div></div>
                    <span class="badge">${escapeHtml(titleCase(interview.status || 'Completed'))}</span>
                    <button class="outline" data-feedback type="button">View Feedback</button>
                </div>`).join('');
            hydrateIcons(wrap);
            bindInterviewActions(wrap);
        }

        function logoHtml(interview) {
            const logo = company(interview).company_logo;
            return logo ? `<img src="${escapeAttr(logo)}" alt="${escapeAttr(companyName(interview))}">` : `<div><strong>${escapeHtml(logoText(interview))}</strong><span>${escapeHtml(companyName(interview).slice(0, 8))}</span></div>`;
        }

        function bindInterviewActions(root) {
            root.querySelectorAll('[data-detail],[data-feedback]').forEach(button => button.addEventListener('click', event => {
                const id = event.currentTarget.closest('[data-job-id]').dataset.jobId;
                if (id) window.location.href = `/direct-mode/jobs/${id}`;
            }));
            root.querySelectorAll('[data-prepare]').forEach(button => button.addEventListener('click', () => {
                document.querySelector('[data-tips]')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }));
        }

        function renderCalendar() {
            const date = new Date(state.calendarDate.getFullYear(), state.calendarDate.getMonth(), 1);
            const month = date.getMonth();
            const year = date.getFullYear();
            $('[data-month-label]').textContent = date.toLocaleDateString('en-IN', { month: 'long', year: 'numeric' });
            const firstDay = date.getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const prevDays = new Date(year, month, 0).getDate();
            const marks = new Set(state.interviews.map(interview => interviewDate(interview)).filter(Boolean).filter(item => item.getMonth() === month && item.getFullYear() === year).map(item => item.getDate()));
            let cells = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].map(day => `<span class="day-name">${day}</span>`);
            for (let i = firstDay - 1; i >= 0; i -= 1) cells.push(`<span class="day muted">${prevDays - i}</span>`);
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day += 1) {
                const cls = [
                    day === today.getDate() && month === today.getMonth() && year === today.getFullYear() ? 'today' : '',
                    marks.has(day) ? 'has-interview' : '',
                ].join(' ');
                cells.push(`<span class="day ${cls}">${day}</span>`);
            }
            while (cells.length % 7 !== 0) cells.push(`<span class="day muted">${cells.length % 7}</span>`);
            $('[data-calendar]').innerHTML = cells.join('');
        }

        function renderTips() {
            const tips = [
                ['Research the Company', 'Understand their products, values and latest updates.', 'building', 'blue-soft'],
                ['Review Job Description', 'Focus on role skills, responsibilities and required qualification.', 'clipboard', 'green-soft'],
                ['Practice Common Questions', 'Prepare your intro, project explanation and fresher basics.', 'book', 'purple-soft'],
                ['Test Your Setup', 'Check internet, camera, microphone and meeting link before time.', 'trophy', 'orange-soft'],
            ];
            $('[data-tips]').innerHTML = tips.map(([title, text, icon, tone]) => `<div class="tip"><span class="tip-icon ${tone}" data-icon="${icon}"></span><div><h3>${title}</h3><p>${text}</p></div></div>`).join('');
            hydrateIcons($('[data-tips]'));
        }

        async function loadData() {
            if (!token) {
                state.interviews = [];
                render();
                return;
            }
            try {
                const dashboard = await fetch('/api/fresher/dashboard', { headers: headers() });
                const payload = await dashboard.json();
                if (payload.success === false) throw new Error(payload.message || 'Dashboard load nahi hua.');
                const data = payload.data || {};
                const upcoming = data.upcoming_interviews || [];
                const recent = (data.recent_applications || []).map(app => app.interview ? { ...app.interview, job_application: app } : null).filter(Boolean);
                const merged = [...upcoming, ...recent];
                state.interviews = merged.filter((item, index, list) => list.findIndex(candidate => candidate.id === item.id) === index);
                render();
            } catch (error) {
                state.interviews = [];
                render();
            }
        }

        function wireControls() {
            $('[data-prev-month]').addEventListener('click', () => { state.calendarDate.setMonth(state.calendarDate.getMonth() - 1); renderCalendar(); });
            $('[data-next-month]').addEventListener('click', () => { state.calendarDate.setMonth(state.calendarDate.getMonth() + 1); renderCalendar(); });
            $('[data-calendar-view]').addEventListener('click', () => document.querySelector('[data-calendar]')?.scrollIntoView({ behavior: 'smooth', block: 'center' }));
            $('[data-full-calendar]').addEventListener('click', event => { event.preventDefault(); document.querySelector('[data-calendar]')?.scrollIntoView({ behavior: 'smooth', block: 'center' }); });
            $('[data-view-past]').addEventListener('click', event => { event.preventDefault(); window.location.href = '/direct-mode/applications'; });
            $('[data-view-tips]').addEventListener('click', () => document.querySelector('[data-tips]')?.scrollIntoView({ behavior: 'smooth', block: 'center' }));
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
            const topUser = document.querySelector('.top-user strong, .user strong');
            if (topUser) topUser.textContent = name;
        }

        function titleCase(value) {
            return String(value || '').replaceAll('_', ' ').replace(/\b\w/g, char => char.toUpperCase());
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]));
        }

        function escapeAttr(value) {
            return escapeHtml(value).replace(/`/g, '&#096;');
        }

        hydrateIcons();
        updateUserChrome();
        wireControls();
        loadData();
    </script>
@endpush




