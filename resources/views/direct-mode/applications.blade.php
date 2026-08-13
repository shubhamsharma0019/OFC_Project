@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
@endphp

@php $activePage = 'applications'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Applications - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:238px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:74px;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #d8e4f7}.brand img{width:200px}.menu{padding:30px 16px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.summary-icon svg,.action-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:50px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:30px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:34px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 19px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:74px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,540px) 1fr;align-items:center;gap:30px;padding:0 30px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.page{padding:24px 28px 10px}.welcome{margin:0 0 12px 4px}.welcome small{font-size:13px}.welcome h1{margin:4px 0 0;font-size:21px}.layout{display:grid;grid-template-columns:minmax(0,1fr) 336px;gap:20px}.card{background:rgba(255,255,255,.9);border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.apps-panel{padding:17px}.page-title h2{margin:0 0 8px;font-size:26px}.page-title p{margin:0 0 18px;color:#43517b;font-size:14px}.tabs{height:44px;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:repeat(6,1fr);overflow:hidden;margin-bottom:24px}.tab{border:0;background:transparent;color:#34436f;font-weight:700;font-size:13px;position:relative}.tab.active{color:#064cff}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#064cff}.meta-row{display:flex;justify-content:space-between;align-items:center;color:#34436f;font-size:13px;margin-bottom:16px}.sort{display:flex;gap:8px;align-items:center}.sort b{color:#064cff;font-size:12px}.app-list{display:grid;gap:10px}.application{border:1px solid #d8e4f7;border-radius:10px;background:#fff;padding:14px 18px;display:grid;grid-template-columns:78px minmax(0,1fr) 126px 88px 100px 38px;gap:16px;align-items:center}.logo{width:68px;height:68px;border-radius:8px;color:#fff;display:grid;place-items:center;text-align:center;font-weight:900}.logo strong{font-size:28px;line-height:.9}.logo span{font-size:11px}.navy{background:#102d68}.orange{background:linear-gradient(135deg,#ff8b29,#ff4d08)}.black{background:#181b21}.purple-logo{background:linear-gradient(135deg,#7b4be8,#4522aa)}.app-main h3{margin:0 0 8px;font-size:16px}.app-main p{margin:0 0 12px;font-size:14px}.job-meta{display:flex;gap:24px;flex-wrap:wrap;color:#657197;font-size:12px}.pill{height:25px;border-radius:5px;display:grid;place-items:center;font-size:12px;font-weight:800;padding:0 14px}.pill.blue{border:1px solid #b8ceff;background:#eaf2ff;color:#064cff}.pill.purple{border:1px solid #d7c7ff;background:#efe7ff;color:#6c3ad7}.pill.orange{border:1px solid #ffd4a1;background:#fff2df;color:#f07800}.pill.red{border:1px solid #ffb8bd;background:#fff0f1;color:#e01e37}.applied{align-self:start;justify-self:end;color:#657197;font-size:12px}.outline{height:34px;border:1px solid #064cff;border-radius:6px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap}.save{width:36px;min-width:36px;padding:0}.progress{grid-column:2 / 5;display:grid;grid-template-columns:repeat(4,1fr);align-items:start;gap:0;margin-top:6px;position:relative}.progress:before{content:"";position:absolute;left:12px;right:12px;top:8px;height:1px;background:#d6dfef}.step{position:relative;display:grid;gap:6px;justify-items:start;font-size:11px;color:#4c5b85;z-index:1}.step i{width:13px;height:13px;border-radius:50%;border:1px solid #b8c7de;background:#fff;display:block}.step.done i{background:#13aa61;border-color:#13aa61}.step.active i{border:3px solid #064cff}.step.orange i{border:3px solid #ff8a00}.step.red i{border:2px solid #ff3045;position:relative}.step.red i:after{content:"x";position:absolute;left:2px;top:-4px;color:#ff3045;font-weight:900}.step b{color:#06123f}.load-row{display:flex;align-items:center;justify-content:space-between;margin-top:9px;color:#4c5b85;font-size:13px}.load{width:132px}.side{display:grid;gap:18px}.side-card{padding:18px}.side-card h2{margin:0 0 18px;font-size:17px}.summary{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.summary-card{height:72px;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:44px 1fr;align-items:center;gap:10px;padding:12px}.summary-icon,.action-icon{width:38px;height:38px;border-radius:50%;display:grid;place-items:center}.blue-soft{background:#eaf2ff;color:#064cff}.orange-soft{background:#fff2df;color:#f07800}.purple-soft{background:#efe7ff;color:#6c3ad7}.red-soft{background:#fff0f1;color:#e01e37}.summary-card strong{display:block;font-size:20px}.summary-card span{font-size:11px;color:#26375e}.activity-head,.side-head{display:flex;align-items:center;justify-content:space-between}.activity-head a,.side-head a{color:#064cff;font-size:12px;font-weight:800}.activity{display:grid}.activity-row{display:grid;grid-template-columns:30px 1fr auto;gap:12px;padding:13px 0;border-bottom:1px solid #e7edf7}.activity-row:last-child{border-bottom:0}.activity-row h3{margin:0 0 6px;font-size:12px}.activity-row p,.activity-row time{margin:0;color:#4c5b85;font-size:11px}.actions{display:grid;gap:10px}.quick{height:44px;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:34px 1fr 18px;gap:10px;align-items:center;padding:7px 10px}.quick h3{margin:0 0 4px;font-size:12px}.quick p{margin:0;color:#4c5b85;font-size:11px}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1220px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.application{grid-template-columns:78px minmax(0,1fr) 126px 88px}.progress{grid-column:2 / -1}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.tabs{grid-template-columns:repeat(2,1fr);height:auto}.tab{height:40px}.application{grid-template-columns:1fr}.progress{grid-column:auto}.applied{justify-self:start}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px;padding:16px}.footer i{display:none}}
        .step.stage-orange i{border:3px solid #ff8a00}
        .progress .step{background:transparent}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 28px 30px!important}.layout{align-items:start}.apps-panel,.side-card{max-width:100%;overflow:hidden}.tabs{max-width:100%;overflow-x:auto}.application{grid-template-columns:78px minmax(220px,1fr) minmax(112px,126px) 88px minmax(96px,100px) 38px}.app-main{min-width:0}.app-main h3,.app-main p{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.progress{grid-column:2 / -1;min-width:0}.summary{grid-template-columns:repeat(2,minmax(0,1fr))!important}.summary-card{height:auto!important;min-height:74px!important;grid-template-columns:42px minmax(0,1fr)!important;gap:9px!important;overflow:hidden!important}.summary-card>div{min-width:0!important}.summary-card strong{line-height:1!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important}.summary-card span:not(.summary-icon){display:block!important;line-height:1.18!important;white-space:normal!important;overflow-wrap:anywhere!important}.summary-icon,.action-icon{align-self:center!important;justify-self:center!important}.activity-row,.quick{min-width:0}.quick{height:auto!important;min-height:46px!important;grid-template-columns:34px minmax(0,1fr) 18px!important;overflow:hidden!important}.quick h3,.quick p,.activity-row h3,.activity-row p{white-space:normal!important;overflow-wrap:anywhere!important}.empty{border:1px dashed #cbd8ee;border-radius:10px;background:#fbfdff;padding:26px;text-align:center;color:#43517b}.logo img{width:100%;height:100%;object-fit:cover;border-radius:8px}.save.saved{background:#eaf2ff;color:#064cff}.sort select{border:0;outline:0;background:transparent;color:#064cff;font-size:12px;font-weight:800;appearance:none}.alert{display:none;margin:0 0 14px;padding:11px 13px;border-radius:8px;border:1px solid #bcd3ff;background:#eef5ff;color:#06123f;font-size:13px;font-weight:700}.alert.show{display:block}@media(max-width:1220px){.layout{grid-template-columns:1fr!important}.application{grid-template-columns:78px minmax(0,1fr) minmax(112px,126px) 88px!important}.progress{grid-column:2 / -1!important}}@media(max-width:760px){.application{grid-template-columns:1fr!important}.progress{grid-column:auto!important;grid-template-columns:repeat(2,1fr)}.tabs{grid-template-columns:repeat(2,minmax(160px,1fr))}.app-main h3,.app-main p{white-space:normal}.summary{grid-template-columns:1fr!important}}</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1 data-user-name>{{ $user['name'] }}!</h1></div>
                <div class="layout">
                    <section class="card apps-panel">
                        <div class="alert" data-alert></div>
                        <div class="page-title"><h2>My Applications</h2><p>Track the status of your job applications</p></div>
                        <div class="tabs"><button class="tab active" data-status="" type="button">All Applications</button><button class="tab" data-status="under_review" type="button">Under Review</button><button class="tab" data-status="shortlisted" type="button">Shortlisted</button><button class="tab" data-status="interview_scheduled" type="button">Interview Scheduled</button><button class="tab" data-status="offered" type="button">Offered</button><button class="tab" data-status="rejected" type="button">Rejected</button></div>
                        <div class="meta-row"><span data-count>Loading applications...</span><span class="sort">Sort by: <select data-sort><option value="recent">Recently Applied</option><option value="oldest">Oldest Applied</option><option value="status">Status</option><option value="company">Company</option></select><span class="icon" data-icon="chevron"></span></span></div>
                        <div class="app-list" data-app-list>
                            <div class="empty">Loading your applications...</div>
                        </div>
                        <div class="load-row"><span data-page-count>Showing 0 of 0 applications</span><button class="outline load" data-load-more type="button">Load More <span class="icon" data-icon="chevron"></span></button></div>
                    </section>
                    <aside class="side">
                        <article class="card side-card"><h2>Application Summary</h2><div class="summary" data-summary></div></article>
                        <article class="card side-card"><div class="activity-head"><h2>Recent Activity</h2><a href="#" data-view-activity>View All</a></div><div class="activity" data-activity></div></article>
                        <article class="card side-card"><h2>Quick Actions</h2><div class="actions" data-actions></div></article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>','chevron-right':'<svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"></path></svg>',pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>',bookmark:'<svg viewBox="0 0 24 24"><path d="M19 21 12 17 5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"></path></svg>',star:'<svg viewBox="0 0 24 24"><path d="m12 2 3 7 7 .6-5.4 4.7 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.6 9 9l3-7Z"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',dot:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle></svg>',x:'<svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => Array.from(document.querySelectorAll(selector));
        const token = localStorage.getItem('onlyfreshers_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || '{}'); } catch (error) { authUser = {}; }
        const state = {
            applications: [],
            filtered: [],
            status: '',
            visible: 4,
            savedJobs: JSON.parse(localStorage.getItem('onlyfreshers_saved_jobs') || '[]'),
        };
        const statusMeta = {
            applied: ['Applied', 'blue', 1],
            under_review: ['Under Review', 'blue', 1],
            shortlisted: ['Shortlisted', 'purple', 2],
            interview_scheduled: ['Interview Scheduled', 'orange', 3],
            selected: ['Shortlisted', 'purple', 2],
            offered: ['Offered', 'orange', 4],
            hired: ['Offered', 'orange', 4],
            rejected: ['Rejected', 'red', 3],
        };

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

        function statusKey(app) {
            return String(app.application_status || 'applied').toLowerCase();
        }

        function statusInfo(app) {
            return statusMeta[statusKey(app)] || [titleCase(statusKey(app).replaceAll('_', ' ')), 'blue', 1];
        }

        function logoText(app) {
            return companyName(app).split(/\s+/).filter(Boolean).slice(0, 2).map(word => word[0]).join('').toUpperCase() || 'OF';
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

        function applyFilters() {
            const sort = $('[data-sort]').value;
            let list = state.status ? state.applications.filter(app => statusKey(app) === state.status) : [...state.applications];
            const sorters = {
                recent: (a, b) => new Date(b.applied_at || b.created_at || 0) - new Date(a.applied_at || a.created_at || 0),
                oldest: (a, b) => new Date(a.applied_at || a.created_at || 0) - new Date(b.applied_at || b.created_at || 0),
                status: (a, b) => statusKey(a).localeCompare(statusKey(b)),
                company: (a, b) => companyName(a).localeCompare(companyName(b)),
            };
            list.sort(sorters[sort] || sorters.recent);
            state.filtered = list;
            render();
        }

        function render() {
            renderList();
            renderSummary();
            renderActivity();
            renderActions();
        }

        function renderList() {
            const list = $('[data-app-list]');
            const total = state.filtered.length;
            const shown = Math.min(state.visible, total);
            $('[data-count]').textContent = total ? `Showing ${total} applications` : 'Showing 0 applications';
            $('[data-page-count]').textContent = `Showing ${shown} of ${total} applications`;
            $('[data-load-more]').style.display = shown < total ? 'inline-flex' : 'none';
            if (!total) {
                list.innerHTML = '<div class="empty">No applications found for this status. Apply to jobs from the Jobs page.</div>';
                return;
            }
            list.innerHTML = state.filtered.slice(0, shown).map(applicationCard).join('');
            hydrateIcons(list);
            bindCards(list);
        }

        function applicationCard(app) {
            const j = job(app);
            const [label, tone, stage] = statusInfo(app);
            const rejected = tone === 'red';
            const companyLogo = company(app).company_logo;
            const logo = companyLogo
                ? `<img src="${escapeAttr(companyLogo)}" alt="${escapeAttr(companyName(app))}">`
                : `<div><strong>${escapeHtml(logoText(app))}</strong><span>${escapeHtml(companyName(app).slice(0, 8))}</span></div>`;
            return `
                <article class="application" data-job-id="${j.id || ''}">
                    <div class="logo navy">${logo}</div>
                    <div class="app-main"><h3>${escapeHtml(j.title || 'Untitled Job')}</h3><p>${escapeHtml(companyName(app))}</p><div class="job-meta"><span><span class="icon" data-icon="pin"></span>${escapeHtml(j.location || 'Location not shared')}</span><span><span class="icon" data-icon="briefcase"></span>${escapeHtml((j.job_type || 'Full Time').replace('_', ' '))}</span><span>${escapeHtml(j.salary || 'Salary not disclosed')}</span></div></div>
                    <span class="pill ${tone}">${escapeHtml(label)}</span>
                    <span class="applied">Applied ${escapeHtml(timeAgo(app.applied_at || app.created_at))}</span>
                    <a class="outline" href="/direct-mode/jobs/${j.id || ''}">View Details</a>
                    <button class="outline save ${state.savedJobs.includes(Number(j.id)) ? 'saved' : ''}" data-save type="button"><span class="icon" data-icon="bookmark"></span></button>
                    <div class="progress">${['Applied', 'Shortlisted', 'Interview', 'Offered'].map((name, index) => stepHtml(index + 1, stage, rejected, tone, name)).join('')}</div>
                </article>`;
        }

        function stepHtml(step, stage, rejected, tone, name) {
            let cls = '';
            if (rejected) cls = step < stage ? 'done' : (step === stage ? 'red' : '');
            else cls = step < stage ? 'done' : (step === stage ? (tone === 'orange' ? 'stage-orange' : 'active') : '');
            return `<span class="step ${cls}"><i></i><b>${name}</b></span>`;
        }

        function renderSummary() {
            const count = key => state.applications.filter(app => statusKey(app) === key).length;
            const underReview = count('under_review') + count('applied');
            const items = [
                [state.applications.length, 'Total Applications', 'briefcase', 'blue-soft'],
                [underReview, 'Under Review', 'clock', 'blue-soft'],
                [count('shortlisted') + count('selected'), 'Shortlisted', 'star', 'orange-soft'],
                [count('interview_scheduled'), 'Interview Scheduled', 'calendar', 'orange-soft'],
            ];
            $('[data-summary]').innerHTML = items.map(([value, label, icon, tone]) => `<div class="summary-card"><span class="summary-icon ${tone}" data-icon="${icon}"></span><div><strong>${value}</strong><span>${label}</span></div></div>`).join('');
            hydrateIcons($('[data-summary]'));
        }

        function renderActivity(limit = 4) {
            const rows = state.applications.slice(0, limit).map(app => {
                const [label, tone] = statusInfo(app);
                const icon = tone === 'red' ? 'x' : tone === 'orange' ? 'calendar' : tone === 'purple' ? 'star' : 'dot';
                const soft = tone === 'red' ? 'red-soft' : tone === 'orange' ? 'orange-soft' : tone === 'purple' ? 'purple-soft' : 'blue-soft';
                return `<div class="activity-row"><span class="action-icon ${soft}" data-icon="${icon}"></span><div><h3>${escapeHtml(label)}</h3><p>${escapeHtml(job(app).title || 'Job')} at ${escapeHtml(companyName(app))}</p></div><time>${escapeHtml(timeAgo(app.applied_at || app.updated_at || app.created_at))}</time></div>`;
            }).join('');
            $('[data-activity]').innerHTML = rows || '<div class="empty">No recent application activity.</div>';
            hydrateIcons($('[data-activity]'));
        }

        function renderActions() {
            const actions = [
                ['Update Resume', 'Keep your profile updated', 'file', '/direct-mode/profile'],
                ['Browse Jobs', 'Find more job opportunities', 'briefcase', '/direct-mode/jobs'],
                ['Application Settings', 'Manage your preferences', 'settings', '/direct-mode/settings'],
            ];
            $('[data-actions]').innerHTML = actions.map(([title, text, icon, url]) => `<a class="quick" href="${url}"><span class="action-icon blue-soft" data-icon="${icon}"></span><div><h3>${title}</h3><p>${text}</p></div><span class="icon" data-icon="chevron-right"></span></a>`).join('');
            hydrateIcons($('[data-actions]'));
        }

        function bindCards(root) {
            root.querySelectorAll('[data-save]').forEach(button => button.addEventListener('click', event => {
                const id = Number(event.currentTarget.closest('.application').dataset.jobId);
                state.savedJobs = state.savedJobs.includes(id) ? state.savedJobs.filter(saved => saved !== id) : [...state.savedJobs, id];
                localStorage.setItem('onlyfreshers_saved_jobs', JSON.stringify(state.savedJobs));
                renderList();
            }));
        }

        async function loadApplications() {
            if (!token) {
                $('[data-app-list]').innerHTML = '<div class="empty">Applications dekhne ke liye pehle login karein.</div>';
                $('[data-count]').textContent = 'Showing 0 applications';
                renderSummary(); renderActivity(); renderActions();
                return;
            }
            try {
                const response = await fetch('/api/fresher/applications', { headers: headers() });
                const payload = await response.json();
                if (!response.ok || payload.success === false) throw new Error(payload.message || 'Applications load nahi ho pa rahi.');
                state.applications = payload.data?.applications || [];
                applyFilters();
            } catch (error) {
                $('[data-app-list]').innerHTML = `<div class="empty">${escapeHtml(error.message)}</div>`;
                $('[data-count]').textContent = 'Showing 0 applications';
                renderSummary(); renderActivity(); renderActions();
            }
        }

        function wireControls() {
            $$('.tab').forEach(tab => tab.addEventListener('click', () => {
                $$('.tab').forEach(item => item.classList.remove('active'));
                tab.classList.add('active');
                state.status = tab.dataset.status;
                state.visible = 4;
                applyFilters();
            }));
            $('[data-sort]').addEventListener('change', applyFilters);
            $('[data-load-more]').addEventListener('click', () => { state.visible += 4; renderList(); });
            $('[data-view-activity]').addEventListener('click', event => { event.preventDefault(); renderActivity(state.applications.length); });
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
            return String(value || '').replace(/\b\w/g, char => char.toUpperCase());
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
        loadApplications();
    </script>
@endpush


