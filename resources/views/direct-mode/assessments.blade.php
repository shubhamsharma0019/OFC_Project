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
    $summary = [
        ['title' => 'Assessments Taken', 'value' => '3', 'note' => '+1 this week', 'icon' => 'users', 'tone' => 'green'],
        ['title' => 'Average Score', 'value' => '60%', 'note' => 'Good', 'icon' => 'calendar', 'tone' => 'purple'],
        ['title' => 'Rank', 'value' => 'Top 40%', 'note' => 'Keep it up!', 'icon' => 'trophy', 'tone' => 'orange'],
    ];
    $skills = [
        ['name' => 'Technical Skills', 'score' => 60],
        ['name' => 'Aptitude', 'score' => 70],
        ['name' => 'Communication', 'score' => 50],
    ];
    $recent = [
        ['name' => 'Technical Assessment', 'sub' => 'HTML, CSS, JavaScript', 'category' => 'Technical Skills', 'score' => '60%', 'date' => '10 May 2024', 'icon' => 'code', 'tone' => 'blue'],
        ['name' => 'Aptitude Test', 'sub' => 'Quantitative & Logical', 'category' => 'Aptitude', 'score' => '70%', 'date' => '08 May 2024', 'icon' => 'plus', 'tone' => 'green'],
        ['name' => 'Communication Test', 'sub' => 'Verbal & Written', 'category' => 'Communication', 'score' => '50%', 'date' => '05 May 2024', 'icon' => 'message', 'tone' => 'purple'],
    ];
    $tips = [
        ['title' => 'Practice Technical MCQs', 'text' => 'Solve more problems daily', 'icon' => 'target', 'tone' => 'green'],
        ['title' => 'Improve Aptitude', 'text' => 'Focus on speed and accuracy', 'icon' => 'book', 'tone' => 'purple'],
        ['title' => 'Work on Communication', 'text' => 'Practice verbal and written skills', 'icon' => 'message', 'tone' => 'orange'],
    ];
@endphp

@php $activePage = 'assessments'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Assessments - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f6faff;font-weight:500}a{text-decoration:none;color:inherit}button,input{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:250px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f0f6ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:84px;display:flex;align-items:center;padding:0 32px;border-bottom:1px solid #d8e4f7}.brand img{width:202px}.menu{padding:25px 21px 12px;display:grid;gap:9px}.menu-item{height:48px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.stat-icon svg,.tip-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:34px 21px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:48px;top:18px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:28px;right:16px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 15px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:40px;border:1px solid #064cff;border-radius:7px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 20px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:84px 1fr auto}.topbar{height:84px;background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,580px) 1fr;align-items:center;gap:34px;padding:0 32px}.hamb{font-size:25px}.search{height:47px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.user strong{font-size:14px}.page{padding:25px 26px 18px}.welcome{margin:0 0 12px 18px}.welcome small{font-size:13px}.welcome h1{margin:5px 0 0;font-size:22px}.panel{border:1px solid #d8e4f7;border-radius:16px;background:rgba(255,255,255,.74);padding:17px;box-shadow:0 18px 38px rgba(6,25,66,.04)}.hero{display:grid;grid-template-columns:1fr repeat(3,242px);gap:12px;align-items:center;margin-bottom:12px}.hero-title{padding-left:9px}.hero-title h2{font-size:30px;margin:0 0 13px}.hero-title p{margin:0;color:#26375e;font-size:15px}.stat{height:98px;border:1px solid #d8e4f7;border-radius:12px;background:#fff;display:grid;grid-template-columns:58px 1fr;align-items:center;gap:14px;padding:18px}.stat-icon,.tip-icon{width:50px;height:50px;border-radius:12px;display:grid;place-items:center}.green{background:#e6f7ed;color:#15a65d}.purple{background:#efe7ff;color:#844bea}.orange{background:#fff1df;color:#f3a334}.blue{background:#eaf2ff;color:#064cff}.stat h3{margin:0 0 6px;font-size:13px}.stat strong{display:block;font-size:28px;line-height:1}.stat span{font-size:12px;color:#008a35;font-weight:800}.tabs{height:46px;width:735px;max-width:100%;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:repeat(5,1fr);overflow:hidden;margin:8px 0 16px}.tab{border:0;background:transparent;color:#17234f;font-size:14px;position:relative}.tab.active{color:#064cff;font-weight:800}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#064cff}.content-grid{display:grid;grid-template-columns:minmax(0,1fr) 388px;gap:18px}.card{background:#fff;border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.card h2{margin:0;font-size:17px}.overview{padding:22px;display:grid;grid-template-columns:235px 1px 1fr;gap:38px;align-items:center}.divider{height:225px;background:#d8e4f7}.ring-wrap{text-align:center}.ring{width:134px;height:134px;border-radius:50%;background:conic-gradient(#0b59ff 0 60%,#dfe7f5 60%);display:grid;place-items:center;position:relative;margin:18px auto 14px}.ring:before{content:"";position:absolute;inset:17px;background:#fff;border-radius:50%}.ring strong{position:relative;font-size:30px}.ring-wrap h3{margin:0 0 8px;font-size:16px}.ring-wrap b{color:#008a35;font-size:15px}.skill-box h3{font-size:15px;margin:0 0 24px}.skill{display:grid;grid-template-columns:130px 1fr 42px;align-items:center;gap:20px;margin:22px 0;font-size:14px}.bar{height:7px;border-radius:20px;background:#e4ebf6;overflow:hidden}.bar span{display:block;height:100%;background:#0b59ff;border-radius:inherit}.outline{height:40px;border:1px solid #064cff;border-radius:7px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 18px;cursor:pointer}.table-card{margin-top:14px;padding:17px 20px}.card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}.card-head a{font-size:13px;color:#064cff;font-weight:800}.table{border:1px solid #d8e4f7;border-radius:8px;overflow:hidden}.row{display:grid;grid-template-columns:1.65fr 1fr .6fr .8fr 1fr .9fr;align-items:center;min-height:58px;border-bottom:1px solid #e8eef8;padding:0 12px;font-size:12px}.row:last-child{border-bottom:0}.head{background:#fbfdff;font-weight:800;min-height:32px}.assessment{display:flex;align-items:center;gap:11px}.sq{width:32px;height:32px;border-radius:6px;color:#fff;display:grid;place-items:center}.sq.blue{background:#2567f5}.sq.green{background:#20ad62}.sq.purple{background:#8c63ee}.assessment strong{display:block;font-size:13px}.assessment span,.muted{color:#3d4c77}.badge{width:72px;height:26px;border:1px solid #bde6ce;border-radius:5px;background:#e8f8ef;color:#008a35;display:grid;place-items:center;font-weight:800;font-size:11px}.side{display:grid;gap:14px}.side-card{padding:22px}.recommend{height:164px;border:1px solid #cce3dc;border-radius:10px;background:linear-gradient(135deg,#eff9f3,#f8fbff);display:grid;grid-template-columns:80px 1fr;align-items:center;gap:18px;padding:18px;margin-top:18px}.medal{width:70px;height:70px;border-radius:50%;background:#bfeccc;color:#21aa60;display:grid;place-items:center}.recommend h3{margin:0 0 9px;font-size:17px}.recommend p{margin:0 0 18px;color:#3d4c77;font-size:13px;line-height:1.4}.tips{display:grid;gap:22px;margin:24px 0}.tip{display:grid;grid-template-columns:48px 1fr;gap:12px;align-items:center}.tip h3{margin:0 0 6px;font-size:13px}.tip p{margin:0;color:#3d4c77;font-size:13px}.center{display:flex;justify-content:center}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1250px){.shell{grid-template-columns:1fr}.sidebar{display:none}.hero{grid-template-columns:1fr}.content-grid{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.row{grid-template-columns:1.4fr .8fr .5fr .7fr .8fr .8fr}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.hero{gap:10px}.content-grid,.overview{grid-template-columns:1fr}.divider{display:none}.row{grid-template-columns:1fr;gap:7px;padding:12px}.head{display:none}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px;padding:16px}.footer i{display:none}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:25px 26px 30px!important}.panel{max-width:100%;overflow:hidden}.hero{grid-template-columns:minmax(0,1fr) repeat(3,minmax(190px,242px))}.content-grid{align-items:start}.table{max-width:100%;overflow-x:auto}.row{min-width:860px}@media(max-width:1250px){.hero{grid-template-columns:1fr!important}.row{min-width:760px}}</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1>{{ $user['name'] }}!</h1></div>
                <div class="panel">
                    <div class="hero">
                        <div class="hero-title"><h2>Assessments</h2><p>Track your assessment progress and improve your skills</p></div>
                        @foreach ($summary as $item)
                            <article class="stat"><span class="stat-icon {{ $item['tone'] }}" data-icon="{{ $item['icon'] }}"></span><div><h3>{{ $item['title'] }}</h3><strong>{{ $item['value'] }}</strong><span>{{ $item['note'] }}</span></div></article>
                        @endforeach
                    </div>
                    <div class="tabs">
                        <button class="tab active" type="button">All Assessments</button>
                        <button class="tab" type="button">Technical Skills</button>
                        <button class="tab" type="button">Aptitude</button>
                        <button class="tab" type="button">Communication</button>
                        <button class="tab" type="button">Completed</button>
                    </div>
                    <div class="content-grid">
                        <div>
                            <article class="card overview">
                                <div class="ring-wrap"><h2>Assessment Overview</h2><div class="ring"><strong>60%</strong></div><h3>Overall Score</h3><b>Good!</b></div>
                                <div class="divider"></div>
                                <div class="skill-box">
                                    <h3>Skill Performance <span class="icon" data-icon="info"></span></h3>
                                    @foreach ($skills as $skill)
                                        <div class="skill"><span>{{ $skill['name'] }}</span><div class="bar"><span style="width:{{ $skill['score'] }}%"></span></div><strong>{{ $skill['score'] }}%</strong></div>
                                    @endforeach
                                    <button class="outline" type="button">View Detailed Analysis</button>
                                </div>
                            </article>
                            <article class="card table-card">
                                <div class="card-head"><h2>Recent Assessments</h2><a href="#">View All</a></div>
                                <div class="table">
                                    <div class="row head"><span>Assessment</span><span>Category</span><span>Score</span><span>Status</span><span>Date</span><span>Action</span></div>
                                    @foreach ($recent as $item)
                                        <div class="row">
                                            <div class="assessment"><span class="sq {{ $item['tone'] }}" data-icon="{{ $item['icon'] }}"></span><div><strong>{{ $item['name'] }}</strong><span>{{ $item['sub'] }}</span></div></div>
                                            <span class="muted">{{ $item['category'] }}</span><strong>{{ $item['score'] }}</strong><span class="badge">Completed</span><span class="muted">{{ $item['date'] }}</span><button class="outline" type="button">View Report</button>
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        </div>
                        <aside class="side">
                            <article class="card side-card">
                                <h2>Recommended for You</h2>
                                <div class="recommend"><span class="medal" data-icon="award"></span><div><h3>Full Stack Development</h3><p>Learn in-demand skills and become job ready.</p><button class="outline" type="button">Explore Career Track</button></div></div>
                            </article>
                            <article class="card side-card">
                                <h2>Tips to Improve Score</h2>
                                <div class="tips">
                                    @foreach ($tips as $tip)
                                        <div class="tip"><span class="tip-icon {{ $tip['tone'] }}" data-icon="{{ $tip['icon'] }}"></span><div><h3>{{ $tip['title'] }}</h3><p>{{ $tip['text'] }}</p></div></div>
                                    @endforeach
                                </div>
                                <div class="center"><button class="outline" type="button">View All Tips</button></div>
                            </article>
                        </aside>
                    </div>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>',users:'<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-8 0v2"></path><circle cx="12" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',trophy:'<svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4M19 5h2v3a4 4 0 0 1-4 4"></path></svg>',info:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4M12 8h.01"></path></svg>',code:'<svg viewBox="0 0 24 24"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M14 4l-4 16"></path></svg>',plus:'<svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>',message:'<svg viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"></path></svg>',award:'<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"></circle><path d="M8.5 12.5 7 22l5-3 5 3-1.5-9.5"></path></svg>',target:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="5"></circle><circle cx="12" cy="12" r="1"></circle></svg>',book:'<svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5Z"></path></svg>'};
        document.querySelectorAll('[data-icon]').forEach(el=>{el.innerHTML=icons[el.dataset.icon]||''});
    </script>
@endpush



