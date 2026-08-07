@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
    $menuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => 'home', 'url' => '/direct-mode/dashboard'],
        ['key' => 'profile', 'title' => 'My Profile', 'icon' => 'user', 'url' => '/direct-mode/profile'],
        ['key' => 'assessments', 'title' => 'Assessments', 'icon' => 'clipboard', 'url' => '/direct-mode/assessments'],
        ['key' => 'jobs', 'title' => 'Jobs', 'icon' => 'briefcase', 'url' => '/direct-mode/jobs'],
        ['key' => 'applications', 'title' => 'My Applications', 'icon' => 'file', 'url' => '/direct-mode/applications'],
        ['key' => 'interviews', 'title' => 'Interviews', 'icon' => 'clock', 'url' => '/direct-mode/interviews'],
        ['key' => 'offers', 'title' => 'Offers', 'icon' => 'chart', 'url' => '/direct-mode/offers'],
        ['key' => 'activity', 'title' => 'Activity', 'icon' => 'activity', 'url' => '/direct-mode/activity'],
        ['key' => 'settings', 'title' => 'Settings', 'icon' => 'settings', 'url' => '/direct-mode/settings'],
        ['key' => 'logout', 'title' => 'Logout', 'icon' => 'logout', 'url' => '#'],
    ];
    $jobs = $jobs ?? [
        ['title' => 'Frontend Developer', 'company' => 'TechNova Solutions', 'logo' => 'TS', 'sub' => 'TechNova', 'location' => 'Bangalore, Karnataka', 'exp' => '0 - 1 Year', 'salary' => 'Rs 4 - Rs 6 LPA', 'posted' => 'Posted 2h ago', 'tone' => 'navy'],
        ['title' => 'Software Engineer', 'company' => 'InfoByte', 'logo' => 'iB', 'sub' => 'InfoByte', 'location' => 'Hyderabad, Telangana', 'exp' => '0 - 2 Years', 'salary' => 'Rs 5 - Rs 8 LPA', 'posted' => 'Posted 1d ago', 'tone' => 'orange'],
        ['title' => 'React Developer', 'company' => 'CodeWave', 'logo' => 'CW', 'sub' => 'CodeWave', 'location' => 'Pune, Maharashtra', 'exp' => '0 - 2 Years', 'salary' => 'Rs 4 - Rs 7 LPA', 'posted' => 'Posted 2d ago', 'tone' => 'black'],
        ['title' => 'Backend Developer', 'company' => 'DataMinds', 'logo' => 'DT', 'sub' => 'DataMinds', 'location' => 'Remote', 'exp' => '1 - 3 Years', 'salary' => 'Rs 6 - Rs 10 LPA', 'posted' => 'Posted 3d ago', 'tone' => 'purple'],
        ['title' => 'Full Stack Developer', 'company' => 'QuickCode', 'logo' => 'QC', 'sub' => 'QuickCode', 'location' => 'Chennai, Tamil Nadu', 'exp' => '1 - 2 Years', 'salary' => 'Rs 5 - Rs 9 LPA', 'posted' => 'Posted 4d ago', 'tone' => 'green'],
    ];
    $jobs = collect($jobs)->map(function ($job) {
        $job['slug'] = $job['slug'] ?? \Illuminate\Support\Str::slug($job['title']);
        return $job;
    })->all();
    $insights = [
        ['value' => '28', 'label' => 'Active Jobs', 'icon' => 'briefcase', 'tone' => 'blue'],
        ['value' => '12', 'label' => 'New Today', 'icon' => 'flame', 'tone' => 'blue'],
        ['value' => '8', 'label' => 'Direct Mode Jobs', 'icon' => 'leaf', 'tone' => 'green'],
        ['value' => '95%', 'label' => 'Profile Match Jobs', 'icon' => 'shield', 'tone' => 'blue'],
    ];
@endphp

@php $activePage = 'jobs'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Jobs - Direct Mode')

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
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 24px 30px!important}.layout{align-items:start}.jobs-panel,.side-card{max-width:100%;overflow:hidden}.filters-row{grid-template-columns:minmax(220px,1fr) repeat(3,minmax(96px,120px)) minmax(92px,100px)}.job{grid-template-columns:74px minmax(180px,1fr) 92px minmax(250px,auto)!important}.job-actions{min-width:0}.action-row{flex-wrap:wrap}.job-meta .icon{vertical-align:middle;margin-right:4px}@media(max-width:1240px){.layout{grid-template-columns:1fr!important}.filters-row{grid-template-columns:repeat(3,minmax(0,1fr))!important}.job{grid-template-columns:74px minmax(0,1fr)!important}.job .tag,.job-actions{grid-column:2;justify-self:start;justify-items:start}.action-row{justify-content:flex-start}}@media(max-width:760px){.filters-row{grid-template-columns:1fr!important}.job .tag,.job-actions{grid-column:auto}.job{grid-template-columns:1fr!important}.logo{width:58px;height:58px}.action-row{gap:8px}}</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1>{{ $user['name'] }}!</h1></div>
                <div class="layout">
                    <section class="card jobs-panel">
                        <div class="jobs-head"><h2>Jobs</h2><p>Explore and apply to the best job opportunities</p></div>
                        <div class="filters-row">
                            <label class="input"><span class="icon" data-icon="search"></span><input type="search" placeholder="Search job title or company"></label>
                            <button class="select" type="button">Location <span class="icon" data-icon="chevron"></span></button>
                            <button class="select" type="button">Job Role <span class="icon" data-icon="chevron"></span></button>
                            <button class="select" type="button">Experience <span class="icon" data-icon="chevron"></span></button>
                            <button class="outline" type="button"><span class="icon" data-icon="filter"></span>Filters</button>
                        </div>
                        <div class="meta-row"><span>Showing 28 jobs</span><span class="sort">Sort by: <b>Most Relevant</b><span class="icon" data-icon="chevron"></span></span></div>
                        <div class="job-list">
                            @foreach ($jobs as $job)
                                <article class="job" onclick="window.location.href='/direct-mode/jobs/{{ $job['slug'] }}'">
                                    <div class="logo {{ $job['tone'] }}"><div><strong>{{ $job['logo'] }}</strong><span>{{ $job['sub'] }}</span></div></div>
                                    <div class="job-main"><h3>{{ $job['title'] }}</h3><p>{{ $job['company'] }}</p><div class="job-meta"><span><span class="icon" data-icon="pin"></span>{{ $job['location'] }}</span><span><span class="icon" data-icon="briefcase"></span>{{ $job['exp'] }}</span><span>{{ $job['salary'] }}</span></div></div>
                                    <span class="tag">Direct Mode</span>
                                    <div class="job-actions">
                                        <span class="posted">{{ $job['posted'] }}</span>
                                        <div class="action-row">
                                            <a class="outline" href="/direct-mode/jobs/{{ $job['slug'] }}" onclick="event.stopPropagation()">View Details</a>
                                            <button class="primary" type="button" onclick="event.stopPropagation()">Apply Now</button>
                                            <button class="outline save" type="button" onclick="event.stopPropagation()"><span class="icon" data-icon="bookmark"></span></button>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="pages"><button class="page-btn" type="button"><</button><button class="page-btn active" type="button">1</button><button class="page-btn" type="button">2</button><button class="page-btn" type="button">3</button><button class="page-btn" type="button">4</button><button class="page-btn" type="button">5</button><button class="page-btn" type="button">></button></div>
                    </section>
                    <aside class="side">
                        <article class="card side-card">
                            <div class="side-head"><h2>Filters</h2><a href="#">Clear All</a></div>
                            @foreach (['Job Role' => 'All Roles', 'Location' => 'All Locations', 'Experience' => 'All Experience', 'Salary Range' => 'All Salary'] as $label => $value)
                                <div class="field"><label>{{ $label }}</label><select><option>{{ $value }}</option></select></div>
                            @endforeach
                            <div class="field"><label>Job Type</label><div class="checks"><label><input type="checkbox" checked>Full Time</label><label><input type="checkbox">Part Time</label><label><input type="checkbox">Internship</label></div></div>
                            <button class="primary wide" type="button">Apply Filters</button>
                        </article>
                        <article class="card side-card">
                            <div class="side-head"><h2>Quick Insights</h2></div>
                            <div class="insights">
                                @foreach ($insights as $item)
                                    <div class="insight"><span class="insight-icon {{ $item['tone'] === 'green' ? 'green-soft' : 'blue-soft' }}" data-icon="{{ $item['icon'] }}"></span><div><strong>{{ $item['value'] }}</strong><span>{{ $item['label'] }}</span></div></div>
                                @endforeach
                            </div>
                        </article>
                        <article class="card side-card">
                            <div class="side-head"><h2>Saved Searches</h2><a href="#">View All</a></div>
                            <div class="saved"><a class="saved-row" href="#"><div><strong>Frontend Developer in Bangalore</strong><span>12 new jobs</span></div><span class="icon" data-icon="chevron-right"></span></a><a class="saved-row" href="#"><div><strong>React Developer</strong><span>6 new jobs</span></div><span class="icon" data-icon="chevron-right"></span></a></div>
                        </article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>','chevron-right':'<svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"></path></svg>',pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>',filter:'<svg viewBox="0 0 24 24"><path d="M4 4h16l-6 7v7l-4 2v-9L4 4Z"></path></svg>',bookmark:'<svg viewBox="0 0 24 24"><path d="M19 21 12 17 5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"></path></svg>',flame:'<svg viewBox="0 0 24 24"><path d="M8.5 14.5A3.5 3.5 0 0 0 12 21a5 5 0 0 0 5-5c0-4-3-6-3-10-2 1-4 4-4 7 0 0-1.5-1-1.5-3.5C6.5 11 5 13 5 16a7 7 0 0 0 7 7"></path></svg>',leaf:'<svg viewBox="0 0 24 24"><path d="M11 20A7 7 0 0 1 4 13c0-6 8-10 16-10 0 8-4 16-10 16"></path><path d="M4 21c4-6 8-9 16-18"></path></svg>',shield:'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>'};
        document.querySelectorAll('[data-icon]').forEach(el=>{el.innerHTML=icons[el.dataset.icon]||''});
    </script>
@endpush



