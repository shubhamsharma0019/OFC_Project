@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
@endphp

@php $activePage = 'settings'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Settings - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input,textarea{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:252px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:78px;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #d8e4f7}.brand img{width:200px}.menu{padding:30px 16px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.action-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:50px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:30px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:36px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 20px}.main{min-width:0;display:grid;grid-template-rows:78px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,560px) 1fr;align-items:center;gap:30px;padding:0 30px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.page{padding:24px 28px 16px}.welcome{margin:0 0 14px 4px}.welcome small{font-size:13px}.welcome h1{margin:4px 0 0;font-size:21px}.layout{display:grid;grid-template-columns:minmax(0,1fr) 364px;gap:20px}.card{background:rgba(255,255,255,.92);border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.settings-card{padding:22px}.title h2{margin:0 0 10px;font-size:25px}.title p{margin:0 0 24px;color:#43517b;font-size:14px}.settings-body{display:grid;grid-template-columns:180px 1fr;gap:16px}.settings-nav{display:grid;gap:9px;align-content:start}.settings-tab{height:46px;border:0;border-radius:7px;background:transparent;color:#26375e;display:flex;align-items:center;gap:14px;padding:0 16px;font-size:13px;font-weight:700;text-align:left}.settings-tab.active{background:#eef4ff;color:#064cff;border-left:3px solid #064cff}.form-card{border:1px solid #d8e4f7;border-radius:10px;padding:28px 30px}.form-head{display:flex;justify-content:space-between;gap:16px;align-items:start;margin-bottom:28px}.form-head h2{margin:0 0 10px;font-size:19px}.form-head p{margin:0;color:#26375e;font-size:13px}.outline{height:36px;border:1px solid #064cff;border-radius:6px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 16px;display:inline-flex;align-items:center;gap:8px;white-space:nowrap}.profile-form{display:grid;grid-template-columns:136px 1fr 1fr;gap:26px 20px}.photo label,.field label,.about label{display:block;margin-bottom:10px;font-size:12px;font-weight:800}.photo{text-align:left}.photo-img{width:104px;height:104px;border-radius:50%;background:url('{{ $user['avatar'] }}') center top/cover;border:1px solid #d8e4f7;margin:0 0 12px 4px}.photo small{display:block;color:#43517b;font-size:10px;line-height:1.4}.field-box{height:40px;border:1px solid #d8e4f7;border-radius:6px;background:#fff;display:flex;align-items:center;gap:10px;padding:0 13px;color:#26375e;font-size:13px}.field-box input{border:0;outline:0;background:transparent;width:100%;color:#06123f}.field-box .chev{margin-left:auto}.about{grid-column:2 / 4}.about textarea{width:100%;height:92px;border:1px solid #d8e4f7;border-radius:6px;background:#fff;color:#26375e;resize:none;padding:14px;line-height:1.45}.save-row{grid-column:2 / 4;display:flex;justify-content:flex-end}.side{display:grid;gap:18px}.side-card{padding:20px}.side-card h2{margin:0 0 18px;font-size:17px}.quick-list,.security-list{display:grid;gap:10px}.quick,.security-row{border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:40px 1fr 18px;gap:12px;align-items:center;padding:12px}.action-icon{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:#eaf2ff;color:#064cff}.quick h3,.security-row h3{margin:0 0 5px;font-size:13px}.quick p,.security-row p{margin:0;color:#43517b;font-size:11px}.completion-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}.completion-head b{color:#064cff;font-size:12px}.progress{height:8px;background:#dfe7f5;border-radius:20px;overflow:hidden;margin-bottom:14px}.progress span{display:block;width:85%;height:100%;background:#064cff}.complete-text{text-align:center;color:#26375e;font-size:13px;line-height:1.45;margin:0 0 14px}.verified{color:#0da65c;margin-left:auto}.security-row{grid-template-columns:40px 1fr 18px}.green-soft{background:#e8f8ef;color:#0da65c}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1250px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}}@media(max-width:860px){.settings-body,.profile-form{grid-template-columns:1fr}.about,.save-row{grid-column:auto}.settings-nav{grid-template-columns:1fr 1fr}.photo-img{margin-left:0}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.form-head,.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px}.footer{padding:16px}.footer i{display:none}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 28px 34px!important}.layout{grid-template-columns:minmax(0,1fr) minmax(320px,364px)!important;gap:20px!important;align-items:start}.settings-card,.side-card,.form-card{max-width:100%;overflow:hidden}.settings-card{padding:22px!important}.settings-body{grid-template-columns:190px minmax(0,1fr)!important;gap:18px!important}.settings-nav{min-width:0}.settings-tab{min-width:0;width:100%;padding:0 14px}.settings-tab .icon{width:20px;height:20px}.form-card{padding:24px!important}.form-head{align-items:flex-start}.form-head>div{min-width:0}.profile-form{grid-template-columns:128px minmax(0,1fr) minmax(0,1fr)!important;gap:22px 18px!important}.field,.about{min-width:0}.field-box{min-width:0}.field-box input{min-width:0;text-overflow:ellipsis}.photo-img{width:96px!important;height:96px!important}.about{grid-column:2 / 4!important}.save-row{grid-column:2 / 4!important}.side{display:grid!important;grid-template-columns:1fr!important;gap:18px!important;min-width:0}.quick,.security-row{height:auto!important;min-height:62px!important;grid-template-columns:40px minmax(0,1fr) 18px!important;overflow:hidden!important}.quick div,.security-row div{min-width:0}.quick h3,.quick p,.security-row h3,.security-row p{white-space:normal!important;overflow:visible!important;text-overflow:clip!important;overflow-wrap:anywhere!important;line-height:1.2!important}.completion-head{gap:12px}.completion-head h2{margin:0}.completion-head b{white-space:nowrap}.outline,.primary{white-space:nowrap}@media(max-width:1360px){.layout{grid-template-columns:1fr!important}.side{grid-template-columns:repeat(3,minmax(0,1fr))!important}.settings-body{grid-template-columns:190px minmax(0,1fr)!important}}@media(max-width:1080px){.side{grid-template-columns:1fr!important}.settings-body{grid-template-columns:1fr!important}.settings-nav{grid-template-columns:repeat(3,minmax(0,1fr));display:grid}.settings-tab{height:44px}.profile-form{grid-template-columns:128px minmax(0,1fr) minmax(0,1fr)!important}}@media(max-width:760px){.settings-nav{grid-template-columns:1fr 1fr}.profile-form{grid-template-columns:1fr!important}.about,.save-row{grid-column:auto!important}.form-head{display:grid;grid-template-columns:1fr;gap:12px}.save-row{justify-content:flex-start}.completion-head{align-items:flex-start;flex-direction:column}.primary{width:100%}}@media(max-width:480px){.settings-nav{grid-template-columns:1fr}.settings-card,.form-card,.side-card{padding:16px!important}}
.alert{display:none;margin:0 0 14px;padding:11px 13px;border-radius:8px;border:1px solid #bcd3ff;background:#eef5ff;color:#06123f;font-size:13px;font-weight:700}.alert.show{display:block}.panel{display:none}.panel.active{display:block}.toggle-row{display:grid;grid-template-columns:minmax(0,1fr) 48px;gap:16px;align-items:center;padding:14px 0;border-bottom:1px solid #e7edf7}.toggle-row:last-child{border-bottom:0}.toggle-row h3{margin:0 0 5px;font-size:13px}.toggle-row p{margin:0;color:#43517b;font-size:12px}.switch{width:44px;height:24px;border-radius:20px;background:#dfe7f5;position:relative;border:0}.switch:before{content:"";position:absolute;width:18px;height:18px;border-radius:50%;background:#fff;left:3px;top:3px;box-shadow:0 1px 4px rgba(0,0,0,.14)}.switch.on{background:#064cff}.switch.on:before{left:23px}.danger{border-color:#ffb8bd!important;color:#e01e37!important}.photo-img img{width:100%;height:100%;object-fit:cover;border-radius:50%}.field-box select{border:0;outline:0;background:transparent;width:100%;color:#06123f}.field-box input:not([readonly]),.about textarea:not([readonly]){color:#06123f}.primary[disabled],.outline[disabled]{opacity:.65;cursor:not-allowed}
.linked-row{grid-template-columns:minmax(0,1fr) minmax(104px,max-content)!important}.linked-row .outline{min-width:104px;justify-content:center;padding:0 14px}
</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1 data-user-name>{{ $user['name'] }}!</h1></div>
                <div class="layout">
                    <section class="card settings-card">
                        <div class="alert" data-alert></div>
                        <div class="title"><h2>Settings</h2><p>Manage your account preferences and security settings</p></div>
                        <div class="settings-body">
                            <nav class="settings-nav" data-settings-nav></nav>
                            <article class="form-card">
                                <div class="form-head"><div><h2 data-panel-title>Account Settings</h2><p data-panel-copy>Update your personal information and account details</p></div><button class="outline" data-edit-profile type="button"><span class="icon" data-icon="edit"></span>Edit Profile</button></div>
                                <div data-panel-root></div>
                            </article>
                        </div>
                    </section>
                    <aside class="side">
                        <article class="card side-card"><h2>Quick Actions</h2><div class="quick-list" data-quick-actions></div></article>
                        <article class="card side-card"><div class="completion-head"><h2>Profile Completion</h2><b data-completion-text>0% Completed</b></div><div class="progress"><span data-completion-bar></span></div><p class="complete-text" data-completion-copy>Complete your profile to get better job recommendations.</p><button class="outline" data-complete-now type="button" style="width:100%">Complete Now</button></article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>','chevron-right':'<svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"></path></svg>',lock:'<svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V7a4 4 0 0 1 8 0v4"></path></svg>',mail:'<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>',key:'<svg viewBox="0 0 24 24"><circle cx="7" cy="15" r="4"></circle><path d="M10 12 21 1M15 6l3 3M17 4l3 3"></path></svg>',link:'<svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7 0l2-2a5 5 0 0 0-7-7l-1 1"></path><path d="M14 11a5 5 0 0 0-7 0l-2 2a5 5 0 0 0 7 7l1-1"></path></svg>',trash:'<svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 15H6L5 6"></path></svg>',edit:'<svg viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',download:'<svg viewBox="0 0 24 24"><path d="M12 3v12"></path><path d="m7 10 5 5 5-5"></path><path d="M5 21h14"></path></svg>',monitor:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="12" rx="2"></rect><path d="M8 21h8M12 16v5"></path></svg>',message:'<svg viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"></path></svg>',shield:'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>',phone:'<svg viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"></path></svg>',check:'<svg viewBox="0 0 24 24"><path d="m20 6-11 11-5-5"></path></svg>',x:'<svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const token = localStorage.getItem('onlyfreshers_token') || localStorage.getItem('ofc_auth_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || localStorage.getItem('ofc_auth_user') || '{}'); } catch (error) { authUser = {}; }
        const state = {
            user: authUser,
            profile: {},
            dashboard: {},
            active: 'account',
            editing: false,
            prefs: JSON.parse(localStorage.getItem('onlyfreshers_settings_prefs') || '{}'),
        };
        const tabs = [
            ['account', 'Account Settings', 'user'],
            ['notifications', 'Notifications', 'bell'],
            ['password', 'Change Password', 'key'],
            ['linked', 'Linked Accounts', 'link'],
            ['deactivate', 'Deactivate Account', 'trash'],
        ];

        function hydrateIcons(root = document) {
            root.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = icons[el.dataset.icon] || ''; });
        }

        function headers(json = false) {
            return {
                'Accept': 'application/json',
                ...(json ? { 'Content-Type': 'application/json' } : {}),
                ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
            };
        }

        function showAlert(message, type = 'info') {
            const alert = $('[data-alert]');
            alert.textContent = message;
            alert.style.borderColor = type === 'error' ? '#ffc1c1' : '#bcd3ff';
            alert.style.background = type === 'error' ? '#fff3f3' : '#eef5ff';
            alert.classList.add('show');
            setTimeout(() => alert.classList.remove('show'), 3500);
        }

        function renderNav() {
            $('[data-settings-nav]').innerHTML = tabs.map(([key, title, icon]) => `<button class="settings-tab ${key === state.active ? 'active' : ''}" data-tab="${key}" type="button"><span class="icon" data-icon="${icon}"></span>${title}</button>`).join('');
            hydrateIcons($('[data-settings-nav]'));
            document.querySelectorAll('[data-tab]').forEach(button => button.addEventListener('click', () => {
                state.active = button.dataset.tab;
                state.editing = false;
                render();
            }));
        }

        function render() {
            renderNav();
            const titles = {
                account: ['Account Settings', 'Update your personal information and account details'],
                notifications: ['Notifications', 'Manage alerts for jobs, applications and interviews'],
                password: ['Change Password', 'Update your account password'],
                linked: ['Linked Accounts', 'Connect or manage external accounts'],
                deactivate: ['Deactivate Account', 'Temporarily disable or close your account'],
            };
            $('[data-panel-title]').textContent = titles[state.active][0];
            $('[data-panel-copy]').textContent = titles[state.active][1];
            $('[data-edit-profile]').style.display = state.active === 'account' ? 'inline-flex' : 'none';
            const renderers = { account: renderAccount, notifications: renderNotifications, password: renderPassword, linked: renderLinked, deactivate: renderDeactivate };
            renderers[state.active]();
            renderSide();
            hydrateIcons();
        }

        function renderAccount() {
            const readonly = state.editing ? '' : 'readonly';
            const disabled = state.editing ? '' : 'disabled';
            const p = state.profile;
            const resumeText = p.resume ? 'Uploaded' : 'Not uploaded';
            $('[data-panel-root]').innerHTML = `
                <div class="profile-form">
                    <div class="photo"><label>Profile Photo</label><div class="photo-img">${profilePhotoUrl(p) ? `<img src="${escapeAttr(profilePhotoUrl(p))}" alt="Profile photo">` : ''}</div><small>JPG, PNG or GIF. Max size 2MB.</small></div>
                    ${field('Full Name', 'name', state.user.name || '', 'readonly')}
                    ${field('Phone Number', 'phone', p.phone || '', readonly, '+91')}
                    ${field('Email Address', 'email', state.user.email || '', 'readonly')}
                    ${field('Location', 'city', p.city || '', readonly)}
                    ${selectField('Highest Education', 'qualification', p.qualification || '', ['B.Tech / BE', 'BCA', 'MCA', 'B.Sc', 'Diploma', 'Other'], disabled)}
                    ${field('College Name', 'college_name', p.college_name || '', readonly)}
                    ${field('Passing Year', 'passing_year', p.passing_year || '', readonly)}
                    ${field('Resume Status', 'resume_status', resumeText, 'readonly')}
                    <div class="about"><label>Skills</label><textarea data-input="skills" ${readonly}>${escapeHtml(p.skills || '')}</textarea></div>
                    <div class="save-row"><button class="primary" data-save-profile type="button" ${state.editing ? '' : 'disabled'}>Save Changes</button></div>
                </div>`;
            $('[data-save-profile]')?.addEventListener('click', saveProfile);
        }

        function field(label, key, value, readonly, prefix = '', icon = '') {
            return `<div class="field"><label>${label}</label><div class="field-box">${icon ? `<span class="icon" data-icon="${icon}"></span>` : ''}${prefix ? `<span>${prefix}</span>` : ''}<input data-input="${key}" value="${escapeAttr(value)}" ${readonly}></div></div>`;
        }

        function selectField(label, key, value, options, disabled) {
            return `<div class="field"><label>${label}</label><div class="field-box"><select data-input="${key}" ${disabled}>${['', ...options].map(option => `<option value="${escapeAttr(option)}" ${option === value ? 'selected' : ''}>${escapeHtml(option || 'Select')}</option>`).join('')}</select><span class="icon chev" data-icon="chevron"></span></div></div>`;
        }

        function renderNotifications() {
            panelToggles([
                ['job_alerts', 'Job Alerts', 'Notify me about matching direct mode jobs', true],
                ['application_updates', 'Application Updates', 'Status changes for applied jobs', true],
                ['interview_reminders', 'Interview Reminders', 'Upcoming interview reminders', true],
                ['offer_updates', 'Offer Updates', 'Offer and onboarding updates', true],
            ]);
        }

        function panelToggles(items) {
            $('[data-panel-root]').innerHTML = items.map(([key, title, text, fallback]) => `<div class="toggle-row"><div><h3>${title}</h3><p>${text}</p></div><button class="switch ${state.prefs[key] ?? fallback ? 'on' : ''}" data-pref="${key}" type="button"></button></div>`).join('');
            document.querySelectorAll('[data-pref]').forEach(button => button.addEventListener('click', () => {
                const key = button.dataset.pref;
                state.prefs[key] = !(state.prefs[key] ?? true);
                localStorage.setItem('onlyfreshers_settings_prefs', JSON.stringify(state.prefs));
                render();
            }));
        }

        function renderPassword() {
            $('[data-panel-root]').innerHTML = `
                <div class="profile-form">
                    ${field('Current Password', 'current_password', '', '')}
                    ${field('New Password', 'new_password', '', '')}
                    ${field('Confirm Password', 'confirm_password', '', '')}
                    <div class="save-row"><button class="primary" data-password-save type="button">Update Password</button></div>
                </div>`;
            $('[data-password-save]').addEventListener('click', () => showAlert('Password update ke liye backend endpoint required hai.', 'error'));
        }

        function renderLinked() {
            $('[data-panel-root]').innerHTML = `
                <div class="toggle-row linked-row"><div><h3>Google Account</h3><p>${state.user.email || 'Not connected'}</p></div><button class="outline" type="button">Connected</button></div>
                <div class="toggle-row linked-row"><div><h3>LinkedIn</h3><p>Connect LinkedIn profile for better visibility</p></div><button class="outline" type="button">Connect</button></div>`;
        }

        function renderDeactivate() {
            $('[data-panel-root]').innerHTML = `
                <div class="toggle-row"><div><h3>Deactivate Account</h3><p>Your profile and applications will be hidden until you reactivate.</p></div><button class="outline danger" data-deactivate type="button">Deactivate</button></div>`;
            $('[data-deactivate]').addEventListener('click', () => showAlert('Account deactivation endpoint backend me add karna hoga.', 'error'));
        }

        function renderSide() {
            const completion = Math.max(0, Math.min(100, Number(state.dashboard.profile?.profile_completion || state.profile.profile_completion || 0)));
            const stats = state.dashboard.statistics || {};
            const assessment = state.dashboard.initial_assessment || {};
            const recommendedMode = assessment.recommended_mode || localStorage.getItem('onlyfreshers_selected_mode') || 'direct';
            const jobsUrl = recommendedMode === 'fast_track' ? '/fast-track/dashboard' : '/direct-mode/jobs';
            $('[data-completion-text]').textContent = `${completion}% Completed`;
            $('[data-completion-bar]').style.width = `${completion}%`;
            $('[data-completion-copy]').textContent = completion >= 100 ? 'Your profile is complete and ready for applications.' : 'Complete your profile to unlock better job matches.';
            $('[data-quick-actions]').innerHTML = [
                ['Update Resume', state.profile.resume ? 'Resume uploaded' : 'Upload your latest resume', 'file', '/direct-mode/profile'],
                ['Browse Jobs', recommendedMode === 'fast_track' ? 'Continue Fast Track journey' : 'Explore Direct Mode jobs', 'briefcase', jobsUrl],
                ['My Applications', `${Number(stats.total_applications || 0)} applications submitted`, 'file', '/direct-mode/applications'],
                ['Interviews', `${Number(stats.scheduled_interviews || 0)} scheduled interviews`, 'calendar', '/direct-mode/interviews'],
            ].map(([title, text, icon, url]) => `<a class="quick" href="${url}"><span class="action-icon" data-icon="${icon}"></span><div><h3>${title}</h3><p>${text}</p></div><span class="icon" data-icon="chevron-right"></span></a>`).join('');
        }

        async function saveProfile() {
            const data = readInputs();
            if (!token) {
                showAlert('Profile save karne ke liye login required hai.', 'error');
                return;
            }
            try {
                const response = await fetch('/api/fresher/profile', {
                    method: 'POST',
                    headers: headers(true),
                    body: JSON.stringify({
                        phone: data.phone,
                        city: data.city,
                        qualification: data.qualification,
                        college_name: data.college_name,
                        passing_year: data.passing_year || null,
                        skills: data.skills,
                    }),
                });
                const payload = await response.json();
                if (!response.ok || payload.success === false) throw new Error(payload.message || 'Profile save nahi hua.');
                localStorage.setItem('onlyfreshers_user', JSON.stringify(state.user));
                state.editing = false;
                showAlert('Settings save ho gayi.');
                await loadData();
            } catch (error) {
                showAlert(error.message, 'error');
            }
        }

        function readInputs() {
            const result = {};
            document.querySelectorAll('[data-input]').forEach(input => { result[input.dataset.input] = input.value; });
            return result;
        }

        async function loadData() {
            if (token) {
                const [profileRes, dashboardRes] = await Promise.all([
                    fetch('/api/fresher/profile', { headers: headers() }).then(res => res.json()).catch(() => ({})),
                    fetch('/api/fresher/dashboard', { headers: headers() }).then(res => res.json()).catch(() => ({})),
                ]);
                state.profile = profileRes.data?.profile || profileRes.data?.fresher_profile || {};
                state.dashboard = dashboardRes.data || {};
                state.user = profileRes.data?.user || state.dashboard.user || state.user;
            }
            updateUserChrome();
            render();
        }

        function wireControls() {
            $('[data-edit-profile]').addEventListener('click', () => {
                state.editing = !state.editing;
                render();
            });
            $('[data-complete-now]').addEventListener('click', () => window.location.href = '/direct-mode/profile');
            const headerSearch = document.querySelector('.search-top input');
            if (headerSearch) {
                headerSearch.addEventListener('keydown', event => {
                    if (event.key === 'Enter' && headerSearch.value.trim()) window.location.href = `/direct-mode/jobs?search=${encodeURIComponent(headerSearch.value.trim())}`;
                });
            }
        }

        function updateUserChrome() {
            const name = state.user.name || 'Fresher';
            $('[data-user-name]').textContent = `${name}!`;
            const topUser = document.querySelector('.top-user strong, .user strong');
            if (topUser) topUser.textContent = name;
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char]));
        }

        function escapeAttr(value) {
            return escapeHtml(value).replace(/`/g, '&#096;');
        }

        function profilePhotoUrl(profile) {
            const photo = profile?.profile_photo || '';
            if (!photo) return '';
            if (/^(https?:)?\/\//.test(photo) || photo.startsWith('data:') || photo.startsWith('/')) return photo;
            return `/storage/${photo}`;
        }

        hydrateIcons();
        wireControls();
        loadData();
    </script>
@endpush
