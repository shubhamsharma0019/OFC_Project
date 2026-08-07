@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
    $menuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'url' => '/direct-mode/dashboard', 'icon' => 'home'],
        ['key' => 'profile', 'title' => 'My Profile', 'url' => '/direct-mode/profile', 'icon' => 'user'],
        ['key' => 'assessments', 'title' => 'Assessments', 'url' => '/direct-mode/assessments', 'icon' => 'clipboard'],
        ['key' => 'jobs', 'title' => 'Jobs', 'url' => '/direct-mode/jobs', 'icon' => 'briefcase'],
        ['key' => 'applications', 'title' => 'My Applications', 'url' => '/direct-mode/applications', 'icon' => 'file'],
        ['key' => 'interviews', 'title' => 'Interviews', 'url' => '/direct-mode/interviews', 'icon' => 'clock'],
        ['key' => 'offers', 'title' => 'Offers', 'url' => '/direct-mode/offers', 'icon' => 'trophy'],
        ['key' => 'activity', 'title' => 'Activity', 'url' => '/direct-mode/activity', 'icon' => 'activity'],
        ['key' => 'settings', 'title' => 'Settings', 'url' => '/direct-mode/settings', 'icon' => 'settings'],
        ['key' => 'logout', 'title' => 'Logout', 'url' => '#', 'icon' => 'logout'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Direct Mode - OnlyFreshers')</title>
    <style>
        *{box-sizing:border-box}body{margin:0;height:100vh;overflow:hidden;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input,select,textarea{font:inherit}.shell{height:100vh;overflow:hidden;display:grid;grid-template-columns:250px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{position:sticky;top:0;height:100vh;min-width:0;overflow:hidden;background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column;justify-content:space-between}.brand{height:82px;display:flex;align-items:center;padding:0 34px;border-bottom:1px solid #d8e4f7}.brand img{display:block;width:200px;max-width:100%;height:auto;object-fit:contain;object-position:left center}.menu{max-height:calc(100vh - 300px);overflow-y:auto;padding:24px 18px 12px;display:grid;gap:8px}.menu-item{min-height:46px;border-radius:8px;display:flex;align-items:center;gap:15px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f;white-space:nowrap}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:18px;padding:18px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:96px;position:relative}.rocket:before{content:"";position:absolute;left:50%;top:13px;width:66px;height:66px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:translateX(-50%) rotate(35deg)}.rocket:after{content:"";position:absolute;left:34px;right:34px;bottom:5px;height:18px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:36px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 20px;cursor:pointer}.main{height:100vh;min-width:0;overflow-y:auto;display:grid;grid-template-rows:82px minmax(0,max-content)}.topbar{position:sticky;top:0;z-index:20;background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:1fr minmax(320px,603px) 1fr;align-items:center;gap:26px;padding:0 38px}.hamb{font-size:25px;line-height:1;color:#06123f}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%;min-width:0;color:#26375e}.top-user{justify-self:end;display:flex;align-items:center;gap:14px;min-width:0}.top-bell{position:relative;border:0;background:transparent;color:#06123f;padding:0;cursor:pointer}.top-bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.top-avatar{width:48px;height:48px;flex:0 0 48px;border-radius:50%;border:5px solid #e6eefb;background:center top/cover no-repeat}.top-user strong{max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.page{min-width:0;padding:24px 28px 26px}.welcome{margin:0 0 18px 4px}.welcome small{font-size:13px;color:#526287}.welcome h1{margin:4px 0 0;font-size:22px;line-height:1.2}.footer{min-height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:14px 32px;font-size:13px;color:#26375e}.footer nav{display:flex;flex-wrap:wrap;align-items:center;gap:16px 26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1240px){.shell{grid-template-columns:1fr}.sidebar{display:none}.topbar{grid-template-columns:32px minmax(0,1fr) auto}.top-user strong{display:none}}@media(max-width:760px){.main{grid-template-rows:auto minmax(0,1fr) auto}.topbar{grid-template-columns:1fr auto;gap:14px;padding:14px}.hamb{display:none}.search-top{grid-column:1/-1;grid-row:2}.top-user{grid-column:2;grid-row:1}.page{padding:16px}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start}.footer{padding:16px}.footer i{display:none}}
    </style>
    @stack('styles')
</head>
<body>
    <div class="shell">
        <aside class="sidebar">
            <div>
                <a class="brand" href="/direct-mode/dashboard"><img src="/ofclogo1.svg" alt="OnlyFreshers" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><span style="display:none;align-items:center;gap:10px;color:#075fe4;font-size:22px;font-weight:800"><b style="display:grid;place-items:center;width:38px;height:38px;border-radius:10px;background:#075fe4;color:#fff;font-size:16px">OF</b>OnlyFreshers</span></a>
                <nav class="menu">
                    @foreach ($menuItems as $item)
                        <a class="menu-item {{ ($activePage ?? '') === $item['key'] ? 'active' : '' }}" href="{{ $item['url'] }}"><span class="icon" data-icon="{{ $item['icon'] }}"></span>{{ $item['title'] }}</a>
                    @endforeach
                </nav>
            </div>
            <div class="boost">
                <div class="rocket"></div>
                <h3>Complete your profile<br>get better matches!</h3>
                <p>A complete profile gets you 3x more job opportunities.</p>
                <button class="primary" type="button">Improve Profile</button>
            </div>
        </aside>
        <main class="main">
            <header class="topbar">
                <div></div>
                <label class="search-top"><span class="icon" data-icon="search"></span><input type="search" placeholder="Search jobs, companies, skills..."></label>
                <div class="top-user"><button class="top-bell" type="button" aria-label="Notifications"><b>{{ $user['notifications'] }}</b><span class="icon" data-icon="bell"></span></button><div class="top-avatar" style="background-image:url('{{ $user['avatar'] }}')"></div><strong>{{ $user['name'] }}</strong><span class="icon" data-icon="chevron"></span></div>
            </header>
            @yield('content')
            
        </main>
    </div>
    <script>
        window.directModeIcons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',bookmark:'<svg viewBox="0 0 24 24"><path d="M19 21 12 17 5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>'};
        Object.assign(window.directModeIcons,{
            users:'<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-8 0v2"></path><circle cx="12" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path></svg>',
            calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',
            trophy:'<svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4M19 5h2v3a4 4 0 0 1-4 4"></path></svg>'
            ,
            clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',
            logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',
            chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',
            star:'<svg viewBox="0 0 24 24"><path d="m12 2 3 7 7 .6-5.4 4.7 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.6 9 9l3-7Z"></path></svg>',
            download:'<svg viewBox="0 0 24 24"><path d="M12 3v12"></path><path d="m7 10 5 5 5-5"></path><path d="M5 21h14"></path></svg>',
            shield:'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>',
            phone:'<svg viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"></path></svg>',
            check:'<svg viewBox="0 0 24 24"><path d="m20 6-11 11-5-5"></path></svg>',
            lock:'<svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V7a4 4 0 0 1 8 0v4"></path></svg>',
            mail:'<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>'
        });
        document.querySelectorAll('[data-icon]').forEach(el=>{el.innerHTML=window.directModeIcons[el.dataset.icon]||el.innerHTML});
    </script>
    @stack('scripts')
</body>
</html>

