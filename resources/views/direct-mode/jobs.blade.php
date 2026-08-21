@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
    $menuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => 'home', 'url' => '/direct-mode/dashboard'],
        ['key' => 'profile', 'title' => 'My Profile', 'icon' => 'user', 'url' => '/direct-mode/profile'],
        ['key' => 'jobs', 'title' => 'Jobs and Internships', 'icon' => 'briefcase', 'url' => '/direct-mode/jobs'],
        ['key' => 'applications', 'title' => 'My Applications', 'icon' => 'file', 'url' => '/direct-mode/applications'],
        ['key' => 'interviews', 'title' => 'Interviews', 'icon' => 'clock', 'url' => '/direct-mode/interviews'],
        ['key' => 'offers', 'title' => 'Offers', 'icon' => 'chart', 'url' => '/direct-mode/offers'],
        ['key' => 'activity', 'title' => 'Activity', 'icon' => 'activity', 'url' => '/direct-mode/activity'],
        ['key' => 'settings', 'title' => 'Settings', 'icon' => 'settings', 'url' => '/direct-mode/settings'],
        ['key' => 'logout', 'title' => 'Logout', 'icon' => 'logout', 'url' => '/direct-mode/logout'],
    ];
@endphp

@php $activePage = 'jobs'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Jobs and Internships - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input,select{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:250px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:74px;display:flex;align-items:center;padding:0 32px;border-bottom:1px solid #d8e4f7}.brand img{width:202px}.menu{padding:30px 18px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.insight-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:50px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:30px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:36px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 19px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:74px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,600px) 1fr;align-items:center;gap:30px;padding:0 32px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.user strong{font-size:14px}.page{padding:24px 24px 18px}.welcome{margin:0 0 8px 8px}.welcome small{font-size:13px}.welcome h1{margin:4px 0 0;font-size:21px}.layout{display:grid;grid-template-columns:minmax(0,1fr) 303px;gap:14px}.card{background:rgba(255,255,255,.88);border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.jobs-panel{padding:18px}.jobs-head h2{margin:0 0 7px;font-size:26px}.jobs-head p{margin:0 0 19px;color:#43517b;font-size:15px}.filters-row{display:grid;grid-template-columns:minmax(260px,1fr) 112px 110px 120px 100px;gap:15px;align-items:center}.input,.select{height:40px;border:1px solid #d8e4f7;border-radius:7px;background:#fff;color:#26375e;display:flex;align-items:center;gap:12px;padding:0 13px;font-size:13px}.select{justify-content:space-between}.meta-row{display:flex;justify-content:space-between;align-items:center;margin:20px 0 14px;color:#34436f;font-size:13px}.sort{display:flex;align-items:center;gap:8px}.sort b{color:#064cff;font-size:12px}.job-list{display:grid;gap:14px}.job{min-height:102px;border:1px solid #d8e4f7;border-radius:10px;background:#fff;display:grid;grid-template-columns:74px 1fr 90px 94px 90px 38px;gap:16px;align-items:center;padding:16px;cursor:pointer}.job:hover{border-color:#9bb8ff;box-shadow:0 12px 24px rgba(6,25,66,.07)}.logo{width:68px;height:68px;border-radius:8px;color:#fff;display:grid;place-items:center;text-align:center;font-weight:900}.logo strong{font-size:28px;line-height:.9}.logo span{font-size:11px}.navy{background:#102d68}.orange{background:linear-gradient(135deg,#ff8b29,#ff4d08)}.black{background:#181b21}.purple{background:linear-gradient(135deg,#7b4be8,#4522aa)}.green{background:linear-gradient(135deg,#12b665,#05773d)}.job-main h3{margin:0 0 8px;font-size:16px}.job-main p{margin:0 0 13px;font-size:14px}.job-meta{display:flex;gap:24px;flex-wrap:wrap;color:#657197;font-size:12px}.tag{height:25px;border:1px solid #bde6ce;background:#e8f8ef;color:#008a35;border-radius:5px;display:grid;place-items:center;font-size:11px;font-weight:800}.posted{align-self:start;justify-self:end;color:#657197;font-size:12px}.outline{height:36px;border:1px solid #064cff;border-radius:6px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;cursor:pointer}.save{width:36px;padding:0}.pages{display:flex;justify-content:center;gap:8px;margin-top:18px}.page-btn{width:30px;height:30px;border:1px solid #d8e4f7;border-radius:6px;background:#fff;color:#06123f}.page-btn.active{background:#064cff;color:#fff;border-color:#064cff}.side{display:grid;gap:12px}.side-card{padding:17px}.side-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:15px}.side-head h2{margin:0;font-size:16px}.side-head a{font-size:12px;color:#064cff;font-weight:800}.field{margin-bottom:12px}.field label{display:block;font-size:13px;margin-bottom:7px}.field select{width:100%;height:34px;border:1px solid #d8e4f7;border-radius:6px;background:#fff;color:#26375e;padding:0 11px;font-size:12px}.checks{display:flex;gap:14px;align-items:center;font-size:12px;margin:5px 0 20px}.checks label{display:flex;gap:8px;align-items:center}.checks input{accent-color:#064cff}.wide{width:100%;height:34px}.insights{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.insight{height:54px;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:34px 1fr;align-items:center;gap:10px;padding:8px}.insight-icon{width:30px;height:30px;border-radius:8px;display:grid;place-items:center}.blue-soft{background:#eaf2ff;color:#064cff}.green-soft{background:#e8f8ef;color:#10a45c}.insight strong{display:block;font-size:16px}.insight span{font-size:11px}.saved{display:grid}.saved-row{display:grid;grid-template-columns:1fr 20px;gap:10px;align-items:center;padding:12px 0;border-bottom:1px solid #e7edf7}.saved-row:last-child{border-bottom:0}.saved-row strong{display:block;font-size:12px}.saved-row span{font-size:12px;color:#008a35;font-weight:800}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1240px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.filters-row{grid-template-columns:1fr 1fr 1fr}.job{grid-template-columns:74px 1fr 100px 100px}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.filters-row{grid-template-columns:1fr}.job{grid-template-columns:1fr;gap:10px}.posted{justify-self:start}.job-meta{gap:10px}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px;padding:16px}.footer i{display:none}}
        .job{grid-template-columns:74px minmax(190px,1fr) 92px minmax(260px,auto)}
        .job-actions{display:grid;gap:12px;justify-items:end;min-width:0}
        .action-row{display:flex;align-items:center;justify-content:flex-end;gap:12px;max-width:100%}
        .job .outline,.job .primary{white-space:nowrap;min-width:86px;padding-left:11px;padding-right:11px}
        .job .save{min-width:36px;width:36px;padding:0}
        @media(max-width:1240px){.job{grid-template-columns:74px minmax(190px,1fr) 92px minmax(260px,auto)}}
        @media(max-width:980px){.job{grid-template-columns:74px minmax(0,1fr);align-items:start}.job .tag,.job-actions{grid-column:2;justify-self:start;justify-items:start}.action-row{justify-content:flex-start;flex-wrap:wrap}.posted{justify-self:start}}
        @media(max-width:760px){.job .outline,.job .primary{width:max-content;max-width:100%}.job .tag,.job-actions{grid-column:auto}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 24px 30px!important}.layout{align-items:start}.jobs-panel,.side-card{max-width:100%;overflow:hidden}.filters-row{grid-template-columns:minmax(280px,1fr) repeat(3,minmax(128px,150px)) minmax(116px,128px)!important;gap:12px!important}.input,.select{height:42px!important;min-width:0!important}.input input{width:100%!important;min-width:0!important;border:0!important;outline:0!important;background:transparent!important;color:#06123f!important;font-weight:600!important}.input input:focus{outline:0!important;box-shadow:none!important}.job{grid-template-columns:74px minmax(180px,1fr) 92px minmax(250px,auto)!important}.job-actions{min-width:0}.action-row{flex-wrap:wrap}.job-meta .icon{vertical-align:middle;margin-right:4px}.select select,.sort select{border:0;outline:0;background:transparent;width:100%;min-width:0;height:100%;color:#06123f;font-weight:700;appearance:none;cursor:pointer;padding:0 28px 0 0}.select select:focus,.sort select:focus{outline:0!important;box-shadow:none!important}.select select option,.sort select option{background:#fff!important;color:#06123f!important;font-weight:600!important;padding:8px 10px!important}.select{position:relative;overflow:visible!important;background:#fff!important}.select .icon{position:absolute;right:10px;pointer-events:none}.meta-row{display:grid!important;grid-template-columns:minmax(0,1fr) auto!important;gap:16px!important}.sort{display:grid!important;grid-template-columns:auto minmax(150px,190px) 18px!important;align-items:center!important}.alert{display:none;margin:0 0 14px;padding:11px 13px;border-radius:8px;border:1px solid #bcd3ff;background:#eef5ff;color:#06123f;font-size:13px;font-weight:700}.alert.show{display:block}.empty{border:1px dashed #cbd8ee;border-radius:10px;background:#fbfdff;padding:26px;text-align:center;color:#43517b}.primary[disabled],.outline[disabled]{opacity:.65;cursor:not-allowed}.save.saved{background:#eaf2ff;color:#064cff}.job.applied{border-color:#bde6ce}.job.applied .tag{background:#e8f8ef;color:#008a35}.logo img{width:100%;height:100%;object-fit:cover;border-radius:8px}.logo.generated{background:#102d68}.top-filter{min-width:0}.top-filter option{font-weight:600}.saved-row{cursor:pointer}.saved-row.empty-saved{grid-template-columns:1fr;color:#657197}.insights{grid-template-columns:repeat(2,minmax(0,1fr))!important}.insight{height:auto!important;min-height:64px!important;grid-template-columns:36px minmax(0,1fr)!important;align-items:center!important;gap:8px!important;padding:10px!important;overflow:hidden!important}.insight>div{min-width:0!important;display:grid!important;gap:2px!important;align-content:center!important}.insight strong{line-height:1!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important}.insight span:not(.insight-icon){display:block!important;font-size:11px!important;line-height:1.18!important;white-space:normal!important;overflow-wrap:anywhere!important}.insight-icon{width:32px!important;height:32px!important;align-self:center!important;justify-self:center!important}.insight-icon svg{stroke:#064cff!important;fill:none!important}@media(max-width:1240px){.layout{grid-template-columns:1fr!important}.filters-row{grid-template-columns:repeat(3,minmax(0,1fr))!important}.job{grid-template-columns:74px minmax(0,1fr)!important}.job .tag,.job-actions{grid-column:2;justify-self:start;justify-items:start}.action-row{justify-content:flex-start}}@media(max-width:760px){.filters-row,.meta-row{grid-template-columns:1fr!important}.sort{grid-template-columns:auto minmax(0,1fr) 18px!important}.job .tag,.job-actions{grid-column:auto}.job{grid-template-columns:1fr!important}.logo{width:58px;height:58px}.action-row{gap:8px}}</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1 data-user-name>{{ $user['name'] }}!</h1></div>
                <div class="layout">
                    <section class="card jobs-panel">
                        <div class="alert" data-alert></div>
                        <div class="jobs-head"><h2>Jobs and Internships</h2><p>Explore and apply to the best jobs and internships</p></div>
                        <div class="filters-row">
                            <label class="input"><span class="icon" data-icon="search"></span><input data-search type="search" placeholder="Search job title or company"></label>
                            <label class="select top-filter"><select data-top-location><option value="">Location</option></select><span class="icon" data-icon="chevron"></span></label>
                            <label class="select top-filter"><select data-top-role><option value="">Job Role</option></select><span class="icon" data-icon="chevron"></span></label>
                            <label class="select top-filter"><select data-top-experience><option value="">Experience</option><option value="fresher">Fresher</option><option value="full">Full Time</option><option value="part">Part Time</option><option value="internship">Internship</option></select><span class="icon" data-icon="chevron"></span></label>
                            <button class="outline" data-filter-button type="button"><span class="icon" data-icon="filter"></span>Filters</button>
                        </div>
                        <div class="meta-row"><span data-count>Loading jobs...</span><span class="sort">Sort by: <select data-sort><option value="relevant">Most Relevant</option><option value="newest">Newest</option><option value="salary_high">Salary High</option><option value="salary_low">Salary Low</option><option value="company">Company</option></select><span class="icon" data-icon="chevron"></span></span></div>
                        <div class="job-list" data-job-list>
                            <div class="empty">Loading direct mode jobs...</div>
                        </div>
                        <div class="pages" data-pages></div>
                    </section>
                    <aside class="side">
                        <article class="card side-card">
                            <div class="side-head"><h2>Filters</h2><a href="#" data-clear-filters>Clear All</a></div>
                            <div class="field"><label>Job Role</label><select data-role-filter><option value="">All Roles</option></select></div>
                            <div class="field"><label>Location</label><select data-location-filter><option value="">All Locations</option></select></div>
                            <div class="field"><label>Experience</label><select data-experience-filter><option value="">All Experience</option><option value="fresher">Fresher</option><option value="full">Full Time</option><option value="part">Part Time</option><option value="internship">Internship</option></select></div>
                            <div class="field"><label>Salary Range</label><select data-salary-filter><option value="">All Salary</option><option value="0-4">Up to Rs 4 LPA</option><option value="4-7">Rs 4 - Rs 7 LPA</option><option value="7-10">Rs 7 - Rs 10 LPA</option><option value="10">Rs 10+ LPA</option></select></div>
                            <div class="field"><label>Job Type</label><div class="checks"><label><input data-job-type value="full" type="checkbox" checked>Full Time</label><label><input data-job-type value="part" type="checkbox">Part Time</label><label><input data-job-type value="internship" type="checkbox">Internship</label></div></div>
                            <button class="primary wide" data-apply-filters type="button">Apply Filters</button>
                        </article>
                        <article class="card side-card">
                            <div class="side-head"><h2>Quick Insights</h2></div>
                            <div class="insights">
                                <div class="insight"><span class="insight-icon blue-soft" data-icon="briefcase"></span><div><strong data-insight="active">0</strong><span>Active Jobs</span></div></div>
                                <div class="insight"><span class="insight-icon blue-soft" data-icon="flame"></span><div><strong data-insight="today">0</strong><span>New Today</span></div></div>
                                <div class="insight"><span class="insight-icon green-soft" data-icon="leaf"></span><div><strong data-insight="direct">0</strong><span>Direct Mode Jobs</span></div></div>
                                <div class="insight"><span class="insight-icon blue-soft" data-icon="shield"></span><div><strong data-insight="match">0%</strong><span>Profile Match Jobs</span></div></div>
                            </div>
                        </article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>','chevron-right':'<svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"></path></svg>',pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>',filter:'<svg viewBox="0 0 24 24"><path d="M4 4h16l-6 7v7l-4 2v-9L4 4Z"></path></svg>',bookmark:'<svg viewBox="0 0 24 24"><path d="M19 21 12 17 5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"></path></svg>',flame:'<svg viewBox="0 0 24 24"><path d="M8.5 14.5A3.5 3.5 0 0 0 12 21a5 5 0 0 0 5-5c0-4-3-6-3-10-2 1-4 4-4 7 0 0-1.5-1-1.5-3.5C6.5 11 5 13 5 16a7 7 0 0 0 7 7"></path></svg>',leaf:'<svg viewBox="0 0 24 24"><path d="M11 20A7 7 0 0 1 4 13c0-6 8-10 16-10 0 8-4 16-10 16"></path><path d="M4 21c4-6 8-9 16-18"></path></svg>',shield:'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => Array.from(document.querySelectorAll(selector));
        const token = localStorage.getItem('onlyfreshers_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || '{}'); } catch (error) { authUser = {}; }

        const state = {
            jobs: [],
            applications: [],
            filtered: [],
            page: 1,
            perPage: 5,
            savedJobs: JSON.parse(localStorage.getItem('onlyfreshers_saved_jobs') || '[]'),
            savedSearches: JSON.parse(localStorage.getItem('onlyfreshers_saved_searches') || '[]'),
            profileKeywords: [],
        };

        function hydrateIcons(root = document) {
            root.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = icons[el.dataset.icon] || ''; });
        }

        function showAlert(message, type = 'info') {
            const alert = $('[data-alert]');
            if (!alert) return;
            alert.textContent = message;
            alert.style.borderColor = type === 'error' ? '#ffc1c1' : '#bcd3ff';
            alert.style.background = type === 'error' ? '#fff3f3' : '#eef5ff';
            alert.classList.add('show');
            window.setTimeout(() => alert.classList.remove('show'), 3500);
        }

        function apiHeaders() {
            return {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
            };
        }

        function company(job) {
            return job.company_profile || job.companyProfile || {};
        }

        function companyName(job) {
            return company(job).company_name || job.company_name || 'Company';
        }

        function logoText(job) {
            return companyName(job).split(/\s+/).filter(Boolean).slice(0, 2).map(word => word[0]).join('').toUpperCase() || 'OF';
        }

        function postedAt(job) {
            const raw = job.created_at || job.updated_at;
            if (!raw) return 'Recently posted';
            const diff = Math.max(0, Date.now() - new Date(raw).getTime());
            const hours = Math.floor(diff / 3600000);
            if (hours < 1) return 'Posted just now';
            if (hours < 24) return `Posted ${hours}h ago`;
            const days = Math.floor(hours / 24);
            return `Posted ${days}d ago`;
        }

        function jobMode(job) {
            return String(job.hiring_mode || 'direct').replace('_', ' ');
        }

        function jobType(job) {
            return String(job.job_type || 'Full Time').replace('_', ' ');
        }

        function normalize(value) {
            return String(value || '').toLowerCase();
        }

        function salaryNumber(job) {
            const numbers = String(job.salary || '').match(/\d+(\.\d+)?/g);
            return numbers ? Number(numbers[numbers.length - 1]) : 0;
        }

        function matchesProfile(job) {
            if (!state.profileKeywords.length) return false;
            const haystack = normalize([job.title, job.required_skills, job.qualification, companyName(job)].join(' '));
            return state.profileKeywords.some(keyword => keyword && haystack.includes(keyword));
        }

        function isApplied(job) {
            return state.applications.some(application => Number(application.job_id || application.job?.id) === Number(job.id));
        }

        function applicationFor(job) {
            return state.applications.find(application => Number(application.job_id || application.job?.id) === Number(job.id));
        }

        function isClosedForCandidate(job) {
            const application = applicationFor(job);
            return ['hired', 'rejected'].includes(String(application?.application_status || '').toLowerCase());
        }

        function isSaved(job) {
            return state.savedJobs.includes(Number(job.id));
        }

        function populateSelect(select, values, label) {
            const current = select.value;
            select.innerHTML = `<option value="">${label}</option>` + values.map(value => `<option value="${escapeAttr(value)}">${escapeHtml(value)}</option>`).join('');
            if (values.includes(current)) select.value = current;
        }

        function buildFilters() {
            const locations = [...new Set(state.jobs.map(job => job.location).filter(Boolean))].sort();
            const roles = [...new Set(state.jobs.map(job => job.title).filter(Boolean))].sort();
            const experienceValues = [...new Set(state.jobs.map(job => jobType(job)).filter(Boolean))].sort();
            populateSelect($('[data-top-location]'), locations, 'Location');
            populateSelect($('[data-location-filter]'), locations, 'All Locations');
            populateSelect($('[data-top-role]'), roles, 'Job Role');
            populateSelect($('[data-role-filter]'), roles, 'All Roles');
            populateSelect($('[data-top-experience]'), experienceValues, 'Experience');
            populateSelect($('[data-experience-filter]'), experienceValues, 'All Experience');
            renderJobTypeChecks(experienceValues);
        }

        function renderJobTypeChecks(values) {
            const wrap = document.querySelector('.checks');
            if (!wrap) return;
            const normalized = values.length ? values : ['Full Time'];
            const activeValues = $$('[data-job-type]:checked').map(input => input.value);
            wrap.innerHTML = normalized.map((value, index) => {
                const checked = activeValues.length ? activeValues.includes(value) : index === 0;
                return `<label><input data-job-type value="${escapeAttr(value)}" type="checkbox" ${checked ? 'checked' : ''}>${escapeHtml(value)}</label>`;
            }).join('');
            $$('[data-job-type]').forEach(input => input.addEventListener('change', () => applyFilters()));
        }

        function activeFilters() {
            return {
                search: $('[data-search]').value.trim(),
                role: $('[data-role-filter]').value || $('[data-top-role]').value,
                location: $('[data-location-filter]').value || $('[data-top-location]').value,
                experience: $('[data-experience-filter]').value || $('[data-top-experience]').value,
                salary: $('[data-salary-filter]').value,
                jobTypes: $$('[data-job-type]:checked').map(input => input.value),
                sort: $('[data-sort]').value,
            };
        }

        function applyFilters({ saveSearch = false } = {}) {
            const filters = activeFilters();
            let jobs = state.jobs.filter(job => normalize(jobMode(job)).includes('direct') && !isClosedForCandidate(job));
            if (filters.search) {
                const term = normalize(filters.search);
                jobs = jobs.filter(job => normalize([job.title, companyName(job), job.location, job.required_skills, job.qualification].join(' ')).includes(term));
            }
            if (filters.role) jobs = jobs.filter(job => normalize(job.title) === normalize(filters.role));
            if (filters.location) jobs = jobs.filter(job => normalize(job.location).includes(normalize(filters.location)));
            if (filters.experience) jobs = jobs.filter(job => normalize(jobType(job)) === normalize(filters.experience) || normalize(job.qualification).includes(normalize(filters.experience)));
            if (filters.salary) {
                jobs = jobs.filter(job => {
                    const salary = salaryNumber(job);
                    if (filters.salary === '0-4') return salary <= 4;
                    if (filters.salary === '4-7') return salary >= 4 && salary <= 7;
                    if (filters.salary === '7-10') return salary >= 7 && salary <= 10;
                    return salary >= 10;
                });
            }
            if (filters.jobTypes.length) {
                const typeAliases = {
                    full: ['full', 'full time', 'full-time'],
                    part: ['part', 'part time', 'part-time'],
                    internship: ['internship', 'intern', 'internships'],
                };
                jobs = jobs.filter(job => {
                    const value = normalize(jobType(job));
                    return filters.jobTypes.some(type => (typeAliases[type] || [type]).includes(value));
                });
            }

            const sorters = {
                newest: (a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0),
                salary_high: (a, b) => salaryNumber(b) - salaryNumber(a),
                salary_low: (a, b) => salaryNumber(a) - salaryNumber(b),
                company: (a, b) => companyName(a).localeCompare(companyName(b)),
                relevant: (a, b) => Number(matchesProfile(b)) - Number(matchesProfile(a)) || new Date(b.created_at || 0) - new Date(a.created_at || 0),
            };
            jobs.sort(sorters[filters.sort] || sorters.relevant);
            state.filtered = jobs;
            state.page = 1;
            if (saveSearch) saveCurrentSearch(filters, jobs.length);
            render();
        }

        function render() {
            renderJobs();
            renderPages();
            renderInsights();
            renderSavedSearches();
        }

        function renderJobs() {
            const list = $('[data-job-list]');
            const count = $('[data-count]');
            const total = state.filtered.length;
            count.textContent = total ? `Showing ${total} jobs and internships` : 'Showing 0 jobs and internships';
            if (!total) {
                list.innerHTML = '<div class="empty">No direct mode jobs match these filters.</div>';
                return;
            }
            const start = (state.page - 1) * state.perPage;
            const pageJobs = state.filtered.slice(start, start + state.perPage);
            list.innerHTML = pageJobs.map(job => jobCard(job)).join('');
            hydrateIcons(list);
            bindJobButtons(list);
        }

        function jobCard(job) {
            const applied = isApplied(job);
            const saved = isSaved(job);
            const companyLogo = company(job).company_logo;
            const logo = companyLogo
                ? `<img src="${escapeAttr(companyLogo)}" alt="${escapeAttr(companyName(job))}">`
                : `<div><strong>${escapeHtml(logoText(job))}</strong><span>${escapeHtml(companyName(job).slice(0, 8))}</span></div>`;
            return `
                <article class="job ${applied ? 'applied' : ''}" data-job-id="${job.id}">
                    <div class="logo generated">${logo}</div>
                    <div class="job-main">
                        <h3>${escapeHtml(job.title || 'Untitled Job')}</h3>
                        <p>${escapeHtml(companyName(job))}</p>
                        <div class="job-meta">
                            <span><span class="icon" data-icon="pin"></span>${escapeHtml(job.location || 'Location not shared')}</span>
                            <span><span class="icon" data-icon="briefcase"></span>${escapeHtml(jobType(job))}</span>
                            <span>${escapeHtml(job.salary || 'Salary not disclosed')}</span>
                        </div>
                    </div>
                    <span class="tag">${applied ? 'Applied' : escapeHtml(titleCase(jobMode(job)))}</span>
                    <div class="job-actions">
                        <span class="posted">${escapeHtml(postedAt(job))}</span>
                        <div class="action-row">
                            <button class="outline" data-view-details type="button">View Details</button>
                            <button class="primary" data-apply-job type="button" ${applied ? 'disabled' : ''}>${applied ? 'Applied' : 'Apply Now'}</button>
                            <button class="outline save ${saved ? 'saved' : ''}" data-save-job type="button" title="${saved ? 'Saved' : 'Save job'}"><span class="icon" data-icon="bookmark"></span></button>
                        </div>
                    </div>
                </article>`;
        }

        function bindJobButtons(root) {
            root.querySelectorAll('.job').forEach(card => {
                const id = card.dataset.jobId;
                card.addEventListener('click', () => window.location.href = `/direct-mode/jobs/${id}`);
                card.querySelector('[data-view-details]').addEventListener('click', event => {
                    event.stopPropagation();
                    window.location.href = `/direct-mode/jobs/${id}`;
                });
                card.querySelector('[data-apply-job]').addEventListener('click', event => {
                    event.stopPropagation();
                    applyToJob(Number(id), event.currentTarget);
                });
                card.querySelector('[data-save-job]').addEventListener('click', event => {
                    event.stopPropagation();
                    toggleSavedJob(Number(id));
                });
            });
        }

        function renderPages() {
            const pages = $('[data-pages]');
            const totalPages = Math.ceil(state.filtered.length / state.perPage);
            if (totalPages <= 1) {
                pages.innerHTML = '';
                return;
            }
            let html = `<button class="page-btn" data-page="${Math.max(1, state.page - 1)}" type="button">&lt;</button>`;
            for (let page = 1; page <= totalPages; page += 1) {
                html += `<button class="page-btn ${page === state.page ? 'active' : ''}" data-page="${page}" type="button">${page}</button>`;
            }
            html += `<button class="page-btn" data-page="${Math.min(totalPages, state.page + 1)}" type="button">&gt;</button>`;
            pages.innerHTML = html;
            pages.querySelectorAll('[data-page]').forEach(button => button.addEventListener('click', () => {
                state.page = Number(button.dataset.page);
                renderJobs();
                renderPages();
            }));
        }

        function renderInsights() {
            const directJobs = state.jobs.filter(job => normalize(jobMode(job)).includes('direct'));
            const today = new Date().toDateString();
            const newToday = directJobs.filter(job => job.created_at && new Date(job.created_at).toDateString() === today).length;
            const matched = directJobs.filter(matchesProfile).length;
            $('[data-insight="active"]').textContent = directJobs.length;
            $('[data-insight="today"]').textContent = newToday;
            $('[data-insight="direct"]').textContent = directJobs.length;
            $('[data-insight="match"]').textContent = directJobs.length ? `${Math.round((matched / directJobs.length) * 100)}%` : '0%';
        }

        function renderSavedSearches() {
            const wrap = $('[data-saved-searches]');
            if (!wrap) return;
            if (!state.savedSearches.length) {
                wrap.innerHTML = '<a class="saved-row empty-saved"><div><strong>No saved searches yet</strong><span>Apply filters to save one</span></div></a>';
                return;
            }
            wrap.innerHTML = state.savedSearches.slice(0, 4).map((search, index) => `
                <a class="saved-row" data-saved-index="${index}">
                    <div><strong>${escapeHtml(search.label)}</strong><span>${search.count} matching jobs</span></div>
                    <span class="icon" data-icon="chevron-right"></span>
                </a>`).join('');
            hydrateIcons(wrap);
            wrap.querySelectorAll('[data-saved-index]').forEach(row => row.addEventListener('click', () => restoreSearch(state.savedSearches[Number(row.dataset.savedIndex)])));
        }

        function saveCurrentSearch(filters, count) {
            const parts = [filters.search, filters.role, filters.location, filters.experience, filters.salary].filter(Boolean);
            if (!parts.length) return;
            const label = parts.join(' in ');
            state.savedSearches = [{ label, count, filters }, ...state.savedSearches.filter(item => item.label !== label)].slice(0, 6);
            localStorage.setItem('onlyfreshers_saved_searches', JSON.stringify(state.savedSearches));
            renderSavedSearches();
        }

        function restoreSearch(saved) {
            $('[data-search]').value = saved.filters.search || '';
            $('[data-role-filter]').value = saved.filters.role || '';
            $('[data-top-role]').value = saved.filters.role || '';
            $('[data-location-filter]').value = saved.filters.location || '';
            $('[data-top-location]').value = saved.filters.location || '';
            $('[data-experience-filter]').value = saved.filters.experience || '';
            $('[data-top-experience]').value = saved.filters.experience || '';
            $('[data-salary-filter]').value = saved.filters.salary || '';
            applyFilters();
        }

        async function applyToJob(jobId, button) {
            if (!token) {
                showAlert('Apply karne ke liye pehle login karein.', 'error');
                return;
            }
            button.disabled = true;
            button.textContent = 'Applying...';
            try {
                const response = await fetch(`/api/fresher/jobs/${jobId}/apply`, { method: 'POST', headers: apiHeaders(), body: '{}' });
                const payload = await response.json();
                if (response.status === 402) {
                    showAlert(payload.message || 'Direct Mode credits khatam ho gaye hain.', 'error');
                    setTimeout(() => {
                        window.location.href = payload.data?.redirect_to || '/direct-mode/dashboard#credits';
                    }, 900);
                    return;
                }
                if (!response.ok || payload.success === false) throw new Error(payload.message || 'Application submit nahi ho payi.');
                state.applications.unshift({ job_id: jobId, ...(payload.data?.application || {}) });
                const remainingCredits = payload.data?.credits?.remaining;
                showAlert(remainingCredits === undefined
                    ? 'Application submit ho gayi. My Applications page par status track hoga.'
                    : `Application submit ho gayi. ${remainingCredits} Direct Mode credits remaining.`);
                renderJobs();
            } catch (error) {
                showAlert(error.message, 'error');
                button.disabled = false;
                button.textContent = 'Apply Now';
            }
        }

        function toggleSavedJob(jobId) {
            state.savedJobs = isSaved({ id: jobId })
                ? state.savedJobs.filter(id => id !== jobId)
                : [...state.savedJobs, jobId];
            localStorage.setItem('onlyfreshers_saved_jobs', JSON.stringify(state.savedJobs));
            renderJobs();
        }

        async function loadProfileKeywords() {
            const localExtra = JSON.parse(localStorage.getItem('onlyfreshers_direct_profile_extra') || '{}');
            const words = [authUser.name, localExtra.preferred_role, localExtra.skills, localExtra.qualification];
            if (token) {
                try {
                    const response = await fetch('/api/fresher/profile', { headers: apiHeaders() });
                    const payload = await response.json();
                    const profile = payload.data?.profile || payload.data?.fresher_profile || payload.data || {};
                    words.push(profile.skills, profile.qualification, profile.preferred_role);
                } catch (error) {}
            }
            state.profileKeywords = words.join(',').split(/[,|]/).map(word => normalize(word.trim())).filter(Boolean);
        }

        async function enforceFresherJourney() {
            if (!token) {
                window.location.href = '/direct-mode/login';
                return false;
            }

            try {
                const response = await fetch('/api/fresher/dashboard', { headers: apiHeaders() });
                const payload = await response.json();
                if (!response.ok || payload.success === false) {
                    window.location.href = '/direct-mode/flow-selection';
                    return false;
                }

                const assessment = payload.data?.initial_assessment;

                if (!assessment || assessment.status !== 'submitted') {
                    window.location.href = '/direct-mode/flow-selection';
                    return false;
                }

                const selectedMode = localStorage.getItem('onlyfreshers_selected_mode');
                if (assessment.recommended_mode === 'fast_track') {
                    localStorage.setItem('onlyfreshers_selected_mode', 'fast_track');
                    window.location.href = '/fast-track/dashboard';
                    return false;
                }
                if (selectedMode === 'fast_track') {
                    window.location.href = '/fast-track/dashboard';
                    return false;
                }
                if (!['direct', 'internship'].includes(selectedMode)) {
                    window.location.href = '/direct-mode/flow-selection';
                    return false;
                }

                return true;
            } catch (error) {
                window.location.href = '/direct-mode/flow-selection';
                return false;
            }
        }

        async function loadApplications() {
            if (!token) return;
            try {
                const response = await fetch('/api/fresher/applications', { headers: apiHeaders() });
                const payload = await response.json();
                state.applications = payload.data?.applications || [];
            } catch (error) {
                state.applications = [];
            }
        }

        async function loadJobs() {
            try {
                const response = await fetch('/api/jobs?hiring_mode=direct', { headers: { 'Accept': 'application/json' } });
                const payload = await response.json();
                state.jobs = payload.data?.jobs || [];
                buildFilters();
                const initialSearch = new URLSearchParams(window.location.search).get('search') || '';
                const initialType = new URLSearchParams(window.location.search).get('type') || '';
                if (initialSearch) {
                    $('[data-search]').value = initialSearch;
                    const headerSearch = document.querySelector('[data-global-search]') || document.querySelector('.search-top input');
                    if (headerSearch) headerSearch.value = initialSearch;
                }
                if (normalize(initialType) === 'internship') {
                    const topExperience = $('[data-top-experience]');
                    const experienceFilter = $('[data-experience-filter]');
                    if (topExperience) topExperience.value = 'internship';
                    if (experienceFilter) experienceFilter.value = 'internship';
                    $$('[data-job-type]').forEach(input => {
                        input.checked = input.value === 'internship';
                    });
                    localStorage.setItem('onlyfreshers_selected_mode', 'internship');
                }
                applyFilters();
            } catch (error) {
                $('[data-job-list]').innerHTML = '<div class="empty">Jobs load nahi ho pa rahe. Backend API check karein.</div>';
                $('[data-count]').textContent = 'Showing 0 jobs and internships';
            }
        }

        function wireControls() {
            const syncPair = (first, second) => {
                first.addEventListener('change', () => { second.value = first.value; applyFilters(); });
                second.addEventListener('change', () => { first.value = second.value; applyFilters({ saveSearch: true }); });
            };
            syncPair($('[data-top-location]'), $('[data-location-filter]'));
            syncPair($('[data-top-role]'), $('[data-role-filter]'));
            syncPair($('[data-top-experience]'), $('[data-experience-filter]'));
            $('[data-search]').addEventListener('input', debounce(() => applyFilters(), 250));
            $('[data-search]').addEventListener('keydown', event => {
                if (event.key === 'Enter') applyFilters({ saveSearch: true });
            });
            const headerSearch = document.querySelector('.search-top input');
            if (headerSearch) {
                headerSearch.addEventListener('input', debounce(() => {
                    $('[data-search]').value = headerSearch.value;
                    applyFilters();
                }, 250));
                $('[data-search]').addEventListener('input', () => { headerSearch.value = $('[data-search]').value; });
            }
            $('[data-sort]').addEventListener('change', () => applyFilters());
            $('[data-salary-filter]').addEventListener('change', () => applyFilters({ saveSearch: true }));
            $$('[data-job-type]').forEach(input => input.addEventListener('change', () => applyFilters()));
            $('[data-filter-button]').addEventListener('click', () => applyFilters({ saveSearch: true }));
            $('[data-apply-filters]').addEventListener('click', () => applyFilters({ saveSearch: true }));
            $('[data-clear-filters]').addEventListener('click', event => {
                event.preventDefault();
                $('[data-search]').value = '';
                $$('[data-top-location],[data-location-filter],[data-top-role],[data-role-filter],[data-top-experience],[data-experience-filter],[data-salary-filter]').forEach(select => { select.value = ''; });
                $$('[data-job-type]').forEach((input, index) => { input.checked = index === 0; });
                applyFilters();
            });
            const clearSaved = $('[data-clear-saved]');
            if (clearSaved) {
                clearSaved.addEventListener('click', event => {
                    event.preventDefault();
                    state.savedSearches = [];
                    localStorage.setItem('onlyfreshers_saved_searches', '[]');
                    renderSavedSearches();
                });
            }
        }

        function updateUserChrome() {
            const name = authUser.name || 'Fresher';
            const heading = $('[data-user-name]');
            if (heading) heading.textContent = `${name}!`;
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

        function debounce(callback, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => callback(...args), wait);
            };
        }

        hydrateIcons();
        updateUserChrome();
        wireControls();
        enforceFresherJourney().then(allowed => {
            if (allowed) Promise.all([loadProfileKeywords(), loadApplications()]).then(loadJobs);
        });
    </script>
@endpush
