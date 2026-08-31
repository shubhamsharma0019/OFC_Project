
@php
    $user = $user ?? ['name' => 'Fresher', 'avatar' => '/student.svg', 'notifications' => 0];
    $menuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'url' => '/direct-mode/dashboard', 'icon' => 'home'],
        ['key' => 'profile', 'title' => 'My Profile', 'url' => '/direct-mode/profile', 'icon' => 'user'],
        ['key' => 'jobs', 'title' => 'Jobs and Internships', 'url' => '/direct-mode/jobs', 'icon' => 'briefcase'],
        ['key' => 'applications', 'title' => 'My Applications', 'url' => '/direct-mode/applications', 'icon' => 'file'],
        ['key' => 'interviews', 'title' => 'Interviews', 'url' => '/direct-mode/interviews', 'icon' => 'clock'],
        ['key' => 'offers', 'title' => 'Offers', 'url' => '/direct-mode/offers', 'icon' => 'trophy'],
        ['key' => 'activity', 'title' => 'Activity', 'url' => '/direct-mode/activity', 'icon' => 'activity'],
        ['key' => 'settings', 'title' => 'Settings', 'url' => '/direct-mode/settings', 'icon' => 'settings'],
        ['key' => 'logout', 'title' => 'Logout', 'url' => '/direct-mode/logout', 'icon' => 'logout'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Direct Mode - OnlyFreshers')</title>
    @include('components.common.auth-storage')
    <style>
        *{box-sizing:border-box}body{margin:0;height:100vh;overflow:hidden;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input,select,textarea{font:inherit}.shell{height:100vh;overflow:hidden;display:grid;grid-template-columns:250px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{position:sticky;top:0;height:100vh;min-width:0;overflow:hidden;background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:82px;display:flex;align-items:center;padding:0 34px;border-bottom:1px solid #d8e4f7}.brand img{display:block;width:200px;max-width:100%;height:auto;object-fit:contain;object-position:left center}.menu{flex:1;min-height:0;overflow:hidden;padding:24px 18px 12px;display:grid;align-content:start;gap:8px}.menu-item{min-height:46px;border-radius:8px;display:flex;align-items:center;gap:15px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f;white-space:nowrap}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:18px;padding:18px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:96px;position:relative}.rocket:before{content:"";position:absolute;left:50%;top:13px;width:66px;height:66px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:translateX(-50%) rotate(35deg)}.rocket:after{content:"";position:absolute;left:34px;right:34px;bottom:5px;height:18px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:36px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 20px;cursor:pointer}.main{height:100vh;min-width:0;overflow-y:auto;display:grid;grid-template-rows:82px minmax(0,max-content)}.topbar{position:sticky;top:0;z-index:20;background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:1fr minmax(320px,603px) 1fr;align-items:center;gap:26px;padding:0 38px}.hamb{font-size:25px;line-height:1;color:#06123f}.search-wrap{position:relative;min-width:0}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%;min-width:0;color:#26375e}.search-panel{display:none;position:absolute;left:0;right:0;top:54px;z-index:50;border:1px solid #d8e4f7;border-radius:10px;background:#fff;box-shadow:0 18px 34px rgba(6,25,66,.12);overflow:hidden}.search-panel.show{display:block}.search-state{padding:15px 16px;color:#526287;font-size:13px}.search-result{display:grid;grid-template-columns:42px minmax(0,1fr) auto;gap:12px;align-items:center;padding:12px 14px;border-top:1px solid #eef3fb}.search-result:first-child{border-top:0}.search-result:hover{background:#f7fbff}.search-result-icon{width:38px;height:38px;border-radius:9px;background:#eaf2ff;color:#064cff;display:grid;place-items:center}.search-result-icon svg{width:19px;height:19px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.search-result h3{margin:0 0 5px;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.search-result p{margin:0;color:#526287;font-size:12px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.search-badge{border:1px solid #d8e4f7;border-radius:999px;padding:5px 9px;color:#064cff;font-size:11px;font-weight:800}.top-user{justify-self:end;display:flex;align-items:center;gap:14px;min-width:0}.top-bell{position:relative;border:0;background:transparent;color:#06123f;padding:0;cursor:pointer}.top-bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.top-avatar{width:48px;height:48px;flex:0 0 48px;border-radius:50%;border:5px solid #e6eefb;background:center top/cover no-repeat}.top-user strong{max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.page{min-width:0;padding:24px 28px 26px}.welcome{margin:0 0 18px 4px}.welcome small{font-size:13px;color:#526287}.welcome h1{margin:4px 0 0;font-size:22px;line-height:1.2}.footer{min-height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:14px 32px;font-size:13px;color:#26375e}.footer nav{display:flex;flex-wrap:wrap;align-items:center;gap:16px 26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1240px){.shell{grid-template-columns:1fr}.sidebar{display:none}.topbar{grid-template-columns:32px minmax(0,1fr) auto}.top-user strong{display:none}}@media(max-width:760px){.main{grid-template-rows:auto minmax(0,1fr) auto}.topbar{grid-template-columns:1fr auto;gap:14px;padding:14px}.hamb{display:none}.search-wrap{grid-column:1/-1;grid-row:2}.search-top{width:100%}.top-user{grid-column:2;grid-row:1}.page{padding:16px}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start}.footer{padding:16px}.footer i{display:none}}
    </style>
    @stack('styles')
    <style>
        body,
        body * {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
            font-weight: 500 !important;
        }
        .topbar{grid-template-columns:40px minmax(360px,760px) minmax(260px,1fr)!important;gap:22px!important}
        .topbar>div:first-child{width:40px!important}
        .search-wrap{justify-self:start!important;width:min(760px,100%)!important}
        .top-user{gap:20px!important}
        .top-bell{margin-right:8px!important}
        .top-user{position:relative!important}
        .top-user-menu{display:none;position:absolute;right:0;top:62px;z-index:60;width:230px;border:1px solid #d8e4f7;border-radius:10px;background:#fff;box-shadow:0 18px 34px rgba(6,25,66,.12);overflow:hidden}
        .top-user-menu.show{display:block}
        .top-user-menu strong,.top-user-menu small{display:block;max-width:none!important;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .top-user-head{padding:13px 14px;border-bottom:1px solid #eef3fb}
        .top-user-head small{margin-top:4px;color:#526287;font-size:12px}
        .top-user-menu a,.top-user-menu button{width:100%;height:42px;border:0;background:#fff;display:flex;align-items:center;gap:10px;padding:0 14px;color:#06123f;font-size:13px;font-weight:800;cursor:pointer;text-align:left}
        .top-user-menu a:hover,.top-user-menu button:hover{background:#f7fbff;color:#064cff}
        .mobile-nav-toggle{display:none;width:42px;height:42px;align-items:center;justify-content:center;border:1px solid #cbd8ee;border-radius:9px;background:#fff;color:#06123f;cursor:pointer}
        .mobile-nav-toggle svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
        .mobile-direct-nav{display:none}
        .shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}
        .shell>.sidebar{position:sticky!important;top:0!important;height:100vh!important;min-width:0!important;overflow:hidden!important;background:#fff!important;border-right:1px solid #d8e4f7!important;display:flex!important;flex-direction:column!important;justify-content:flex-start!important}
        .shell>.sidebar .brand{height:82px!important;display:flex!important;align-items:center!important;padding:0 34px!important;border-bottom:1px solid #d8e4f7!important}
        .shell>.sidebar .brand img{display:block!important;width:200px!important;max-width:100%!important;height:auto!important;object-fit:contain!important;object-position:left center!important}
        .shell>.sidebar .menu{flex:1 1 auto!important;min-height:0!important;max-height:none!important;overflow:hidden!important;padding:24px 18px 12px!important;display:grid!important;align-content:start!important;gap:8px!important}
        .shell>.sidebar,
        .shell>.sidebar *{font-family:Inter,Arial,Helvetica,sans-serif!important}
        .shell>.sidebar .menu-item{min-height:46px!important;height:auto!important;border-radius:8px!important;display:flex!important;align-items:center!important;gap:15px!important;padding:0 18px!important;font-size:14px!important;font-weight:500!important;position:relative!important;color:#06123f!important;white-space:nowrap!important}
        .shell>.sidebar .menu-item.active{background:#eaf2ff!important;color:#064cff!important}
        .shell>.sidebar .menu-item.active:before{content:""!important;position:absolute!important;left:0!important;top:11px!important;bottom:11px!important;width:3px!important;background:#064cff!important;border-radius:6px!important}
        @media(max-width:900px){
            html,body{width:100%;overflow-x:hidden}
            .shell{grid-template-columns:1fr!important}
            .shell>.sidebar{display:none!important}
            .shell,.main,.topbar{width:100%!important;max-width:100%!important;min-width:0!important}
            .main{height:100vh!important;overflow-y:auto!important;grid-template-rows:auto minmax(0,max-content)!important}
            .topbar{height:auto!important;min-height:74px!important;grid-template-columns:42px minmax(0,1fr) auto!important;grid-template-rows:auto auto!important;gap:12px 14px!important;padding:12px 14px!important}
            .topbar>div:first-child{display:none!important}
            .mobile-nav-toggle{display:inline-flex!important;grid-column:1!important;grid-row:1!important}
            .search-wrap{grid-column:1 / -1!important;grid-row:2!important;width:100%!important;justify-self:stretch!important}
            .search-top{width:100%!important;max-width:100%!important;min-width:0!important}
            .search-panel{top:52px!important}
            .top-user{grid-column:3!important;grid-row:1!important;justify-self:end!important;gap:12px!important}
            .top-avatar{width:42px!important;height:42px!important;flex-basis:42px!important;border-width:4px!important}
            .top-user-menu{top:54px!important;right:0!important}
            .mobile-direct-nav{display:none;position:sticky;top:0;z-index:19;border-bottom:1px solid #d8e4f7;background:#fff;padding:10px 12px;box-shadow:0 16px 28px rgba(6,25,66,.08)}
            .mobile-direct-nav.show{display:block}
            .mobile-direct-nav nav{display:grid;grid-template-columns:1fr;gap:8px}
            .mobile-direct-nav a{min-height:42px;border:1px solid #d8e4f7;border-radius:9px;background:#fff;display:flex;align-items:center;gap:12px;padding:0 13px;color:#06123f;font-size:13px;font-weight:800}
            .mobile-direct-nav a.active{border-color:#9fc1f8;background:#eaf2ff;color:#064cff}
            .mobile-direct-nav .icon{width:20px;height:20px}
            .mobile-direct-nav .icon svg{width:20px;height:20px}
            .page,.assess-page{width:100%!important;max-width:100%!important;min-width:0!important;padding-left:14px!important;padding-right:14px!important;overflow-x:hidden}
            .welcome{width:100%!important;max-width:100%!important;min-width:0!important;margin-left:0!important;margin-right:0!important}
            .layout,.content-grid,.hero,.metrics,.stats,.settings-body,.offer-grid,.chart-wrap,.page-grid{width:100%!important;max-width:100%!important;min-width:0!important;grid-template-columns:minmax(0,1fr)!important}
            .panel,.card,.main-card,.side-card,.jobs-panel,.apps-panel,.settings-card,.offer-card,.section,.chart-card,.overview,.table-card,.other,.form-card{width:100%!important;max-width:100%!important;min-width:0!important}
            .tabs,.meta-row,.title-row,.welcome-bar,.side-head,.section-head,.form-head{max-width:100%!important;min-width:0!important}
            .table{max-width:100%!important;overflow-x:auto!important}
            .row,.application,.other-row{max-width:100%!important}
            input,select,textarea{max-width:100%!important;min-width:0!important}
            .search-top input{width:0!important;flex:1 1 0!important}
        }
        @media(max-width:520px){
            .topbar{padding:10px 12px!important}
            .top-user{gap:9px!important}
            .mobile-nav-toggle{width:38px!important;height:38px!important}
            .top-bell{margin-right:2px!important}
            .top-avatar{width:38px!important;height:38px!important;flex-basis:38px!important}
            .top-user-menu{width:min(230px,calc(100vw - 24px))!important}
            .search-top{height:42px!important;padding:0 12px!important;gap:10px!important}
            .search-top input{font-size:13px!important}
            .page,.dashboard,.profile-page,.assess-page{padding-left:12px!important;padding-right:12px!important}
        }
        body.direct-assessment-page .shell{display:block!important;grid-template-columns:1fr!important}
        body.direct-assessment-page .shell>.sidebar,
        body.direct-assessment-page .topbar,
        body.direct-assessment-page [data-mobile-direct-nav]{display:none!important}
        body.direct-assessment-page .main{display:block!important;height:100vh!important;overflow-y:auto!important}
    </style>
</head>
<body class="{{ ($activePage ?? '') === 'assessments' ? 'direct-assessment-page' : '' }}">
    <div class="shell">
        <aside class="sidebar">
            <div>
                <a class="brand" href="/"><img src="/ofclogo1.svg" alt="OnlyFreshers" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><span style="display:none;align-items:center;gap:10px;color:#075fe4;font-size:22px;font-weight:800"><b style="display:grid;place-items:center;width:38px;height:38px;border-radius:10px;background:#075fe4;color:#fff;font-size:16px">OF</b>OnlyFreshers</span></a>
                <nav class="menu">
                    @foreach ($menuItems as $item)
                        <a class="menu-item {{ ($activePage ?? '') === $item['key'] ? 'active' : '' }}" href="{{ $item['key'] === 'logout' ? '/' : $item['url'] }}" @if ($item['key'] === 'logout') data-direct-logout @endif>
                            @if ($item['key'] === 'offers')
                                <span class="icon"><svg viewBox="0 0 24 24"><path d="M8 21h8"></path><path d="M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4"></path><path d="M19 5h2v3a4 4 0 0 1-4 4"></path></svg></span>
                            @else
                                <span class="icon" data-icon="{{ $item['icon'] }}"></span>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>
        <main class="main">
            <header class="topbar">
                <div></div>
                <button class="mobile-nav-toggle" type="button" data-mobile-nav-toggle aria-label="Open navigation" aria-expanded="false">
                    <svg viewBox="0 0 24 24"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path></svg>
                </button>
                <div class="search-wrap" data-direct-search>
                    <label class="search-top"><span class="icon" data-icon="search"></span><input type="search" placeholder="Search jobs, companies, skills..." data-global-search autocomplete="off"></label>
                    <div class="search-panel" data-search-results></div>
                </div>
                <div class="top-user">
                    <button class="top-bell" type="button" data-ofc-notification-trigger aria-label="Notifications"><b data-ofc-notification-badge style="{{ (int) ($user['notifications'] ?? 0) > 0 ? '' : 'display:none' }}">{{ (int) ($user['notifications'] ?? 0) > 0 ? $user['notifications'] : '' }}</b><span class="icon" data-icon="bell"></span></button>
                    <div class="top-avatar" style="background-image:url('{{ $user['avatar'] }}')"></div>
                    <strong data-top-user-name>{{ $user['name'] }}</strong>
                    <button class="icon" type="button" data-user-menu-toggle aria-label="Open user menu" style="border:0;background:transparent;color:inherit;cursor:pointer"><span data-icon="chevron"></span></button>
                    <div class="top-user-menu" data-user-menu>
                        <div class="top-user-head">
                            <strong data-menu-user-name>{{ $user['name'] }}</strong>
                            <small data-menu-user-email>Loading account...</small>
                        </div>
                        <a href="/direct-mode/profile"><span class="icon" data-icon="user"></span>My Profile</a>
                        <a href="/direct-mode/activity"><span class="icon" data-icon="bell"></span>Notifications</a>
                        <button type="button" data-direct-logout><span class="icon" data-icon="logout"></span>Logout</button>
                    </div>
                </div>
            </header>
            <div class="mobile-direct-nav" data-mobile-direct-nav>
                <nav>
                    @foreach ($menuItems as $item)
                        <a class="{{ ($activePage ?? '') === $item['key'] ? 'active' : '' }}" href="{{ $item['key'] === 'logout' ? '/' : $item['url'] }}" @if ($item['key'] === 'logout') data-direct-logout @endif>
                            @if ($item['key'] === 'offers')
                                <span class="icon"><svg viewBox="0 0 24 24"><path d="M8 21h8"></path><path d="M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4"></path><path d="M19 5h2v3a4 4 0 0 1-4 4"></path></svg></span>
                            @else
                                <span class="icon" data-icon="{{ $item['icon'] }}"></span>
                            @endif
                            {{ $item['title'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
            @yield('content')
            
        </main>
    </div>
    <script>
        (() => {
            const loginUrl = '/direct-mode/login';
            const authKeys = [
                'onlyfreshers_token',
                'onlyfreshers_user',
                'ofc_fresher_token',
                'ofc_fresher_user',
                'ofc_auth_token',
                'ofc_auth_user',
            ];
            const parseJson = value => {
                try {
                    return JSON.parse(value || 'null');
                } catch (error) {
                    return null;
                }
            };
            const directSession = () => {
                const sessions = [
                    [localStorage.getItem('onlyfreshers_token'), parseJson(localStorage.getItem('onlyfreshers_user'))],
                    [localStorage.getItem('ofc_fresher_token'), parseJson(localStorage.getItem('ofc_fresher_user'))],
                    [localStorage.getItem('ofc_auth_token'), parseJson(localStorage.getItem('ofc_auth_user'))],
                ];

                return sessions.find(([token, user]) => token && user?.role === 'fresher') || null;
            };
            const hasDirectSession = () => Boolean(directSession());
            const redirectIfLoggedOut = () => {
                if (!hasDirectSession()) {
                    authKeys.forEach(key => localStorage.removeItem(key));
                    window.location.replace(loginUrl);
                }
            };

            redirectIfLoggedOut();
            window.addEventListener('pageshow', redirectIfLoggedOut);
            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'visible') redirectIfLoggedOut();
            });
        })();

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
    @include('components.common.notification-popup')
    @stack('scripts')
    <script>
        document.querySelectorAll('.sidebar [data-icon], .topbar [data-icon]').forEach(el => {
            const icon = window.directModeIcons && window.directModeIcons[el.dataset.icon];
            if (icon) el.innerHTML = icon;
        });
    </script>
    <script>
        (() => {
            const parseJson = value => {
                try {
                    return JSON.parse(value || 'null');
                } catch (error) {
                    return null;
                }
            };
            const directSession = [
                [localStorage.getItem('onlyfreshers_token'), parseJson(localStorage.getItem('onlyfreshers_user'))],
                [localStorage.getItem('ofc_fresher_token'), parseJson(localStorage.getItem('ofc_fresher_user'))],
                [localStorage.getItem('ofc_auth_token'), parseJson(localStorage.getItem('ofc_auth_user'))],
            ].find(([sessionToken, sessionUser]) => sessionToken && sessionUser?.role === 'fresher') || [];
            const token = directSession[0] || '';
            const storedUser = directSession[1] || null;
            const headers = { Accept: 'application/json', ...(token ? { Authorization: `Bearer ${token}` } : {}) };
            const searchInput = document.querySelector('[data-global-search]');
            const searchPanel = document.querySelector('[data-search-results]');
            const userName = document.querySelector('[data-top-user-name]');
            const menuUserName = document.querySelector('[data-menu-user-name]');
            const menuUserEmail = document.querySelector('[data-menu-user-email]');
            const avatar = document.querySelector('.top-avatar');
            const unreadBadge = document.querySelector('.top-bell b');
            const userMenu = document.querySelector('[data-user-menu]');
            const userMenuToggle = document.querySelector('[data-user-menu-toggle]');
            const mobileNav = document.querySelector('[data-mobile-direct-nav]');
            const mobileNavToggle = document.querySelector('[data-mobile-nav-toggle]');
            const icon = name => window.directModeIcons?.[name] || '';
            const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
            const setUnreadBadge = count => {
                if (!unreadBadge) return;
                const value = Number(count || 0);
                unreadBadge.textContent = value;
                unreadBadge.style.display = value > 0 ? 'grid' : 'none';
            };
            const debounce = (fn, wait = 250) => {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => fn(...args), wait);
                };
            };

            const profilePhotoUrl = profile => {
                const photo = profile?.profile_photo || profile?.profilePhoto || '';
                if (!photo) return '/student.svg';
                if (/^(https?:)?\/\//.test(photo) || photo.startsWith('data:') || photo.startsWith('/')) return photo;
                return `/storage/${photo}`;
            };

            const setTopUser = (user, profile = null) => {
                const activeUser = user || storedUser;
                if (!activeUser) return;
                const name = activeUser.name || 'Direct Mode Fresher';
                if (userName) userName.textContent = name;
                if (menuUserName) menuUserName.textContent = name;
                if (menuUserEmail) menuUserEmail.textContent = activeUser.email || activeUser.role || 'Fresher account';
                if (avatar) {
                    avatar.style.backgroundImage = `url('${profilePhotoUrl(profile)}')`;
                    avatar.title = name;
                }
            };

            const getJson = async url => {
                const response = await fetch(url, { headers });
                const data = await response.json().catch(() => ({}));
                if (!response.ok) throw new Error(data.message || 'Unable to load data.');
                return data.data;
            };

            const loadTopbar = async () => {
                setTopUser(storedUser);
                if (!token) return;
                try {
                    const [authProfile, fresherProfile, unread] = await Promise.all([
                        getJson('/api/auth/profile').catch(() => null),
                        getJson('/api/fresher/profile').catch(() => null),
                        getJson('/api/notifications/unread-count').catch(() => ({ unread_count: 0 })),
                    ]);
                    setTopUser(authProfile?.user || fresherProfile?.user, fresherProfile?.profile);
                    setUnreadBadge(unread?.unread_count ?? 0);
                } catch (error) {
                    setTopUser(storedUser);
                }
            };

            const renderSearchState = message => {
                if (!searchPanel) return;
                searchPanel.innerHTML = `<div class="search-state">${esc(message)}</div>`;
                searchPanel.classList.add('show');
            };

            const renderSearchResults = (jobs, term) => {
                if (!searchPanel) return;
                if (!term) {
                    searchPanel.classList.remove('show');
                    searchPanel.innerHTML = '';
                    return;
                }
                if (!jobs.length) {
                    renderSearchState('No matching jobs, companies or skills found.');
                    return;
                }
                searchPanel.innerHTML = jobs.slice(0, 6).map(job => {
                    const company = job.company_profile || job.companyProfile || {};
                    const companyName = company.company_name || 'Company';
                    const meta = [companyName, job.location, job.required_skills].filter(Boolean).join(' - ');
                    return `<a class="search-result" href="/direct-mode/jobs?search=${encodeURIComponent(term)}" data-search-result>
                        <span class="search-result-icon">${icon('briefcase')}</span>
                        <span><h3>${esc(job.title || 'Job role')}</h3><p>${esc(meta || 'Direct Mode opportunity')}</p></span>
                        <span class="search-badge">${esc((job.hiring_mode || 'direct').replace('_', ' '))}</span>
                    </a>`;
                }).join('');
                searchPanel.classList.add('show');
            };

            const runSearch = debounce(async () => {
                const term = searchInput?.value.trim() || '';
                if (!term) {
                    searchPanel?.classList.remove('show');
                    return;
                }
                renderSearchState('Searching...');
                try {
                    const data = await getJson(`/api/jobs?search=${encodeURIComponent(term)}`);
                    const jobs = (data.jobs || []).filter(job => String(job.hiring_mode || 'direct').toLowerCase().includes('direct'));
                    renderSearchResults(jobs, term);
                } catch (error) {
                    renderSearchState(error.message);
                }
            }, 250);

            if (searchInput) {
                searchInput.addEventListener('input', runSearch);
                searchInput.addEventListener('keydown', event => {
                    const term = searchInput.value.trim();
                    if (event.key === 'Enter' && term) {
                        event.preventDefault();
                        window.location.href = `/direct-mode/jobs?search=${encodeURIComponent(term)}`;
                    }
                    if (event.key === 'Escape') {
                        searchPanel?.classList.remove('show');
                    }
                });
                document.addEventListener('click', event => {
                    if (!event.target.closest('[data-direct-search]')) {
                        searchPanel?.classList.remove('show');
                    }
                });
            }

            userMenuToggle?.addEventListener('click', event => {
                event.stopPropagation();
                userMenu?.classList.toggle('show');
                mobileNav?.classList.remove('show');
                mobileNavToggle?.setAttribute('aria-expanded', 'false');
            });

            mobileNavToggle?.addEventListener('click', event => {
                event.stopPropagation();
                const isOpen = mobileNav?.classList.toggle('show');
                mobileNavToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                userMenu?.classList.remove('show');
            });

            document.addEventListener('click', event => {
                if (!event.target.closest('.top-user')) {
                    userMenu?.classList.remove('show');
                }
                if (!event.target.closest('[data-mobile-direct-nav]') && !event.target.closest('[data-mobile-nav-toggle]')) {
                    mobileNav?.classList.remove('show');
                    mobileNavToggle?.setAttribute('aria-expanded', 'false');
                }
            });

            function directModeLogout(event) {
                event?.preventDefault();
                const logoutToken = localStorage.getItem('onlyfreshers_token') || localStorage.getItem('ofc_fresher_token') || localStorage.getItem('ofc_auth_token') || token;
                [
                    'onlyfreshers_token',
                    'onlyfreshers_user',
                    'onlyfreshers_mode',
                    'onlyfreshers_direct_profile_extra',
                    'onlyfreshers_settings_prefs',
                    'onlyfreshers_offer_statuses',
                    'onlyfreshers_saved_jobs',
                    'onlyfreshers_saved_searches',
                    'ofc_fresher_token',
                    'ofc_fresher_user',
                    'ofc_auth_token',
                    'ofc_auth_user',
                    'fast_track_course_id',
                ].forEach(key => localStorage.removeItem(key));
                sessionStorage.setItem('ofc_logged_out', '1');
                localStorage.setItem('ofc_logged_out', '1');
                sessionStorage.setItem('ofc_fresher_logged_out', '1');
                localStorage.setItem('ofc_fresher_logged_out', '1');
                try {
                    if (logoutToken) {
                        fetch('/api/auth/logout', {
                            method: 'POST',
                            keepalive: true,
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${logoutToken}`,
                            },
                            body: '{}',
                        }).catch(() => {});
                    }
                } catch (error) {
                    // Local logout should still continue when the token has already expired.
                }
                window.location.replace('/');
            }

            document.querySelectorAll('[data-direct-logout]').forEach(logout => {
                logout.addEventListener('click', directModeLogout);
            });

            loadTopbar();
        })();
    </script>
</body>
</html>
