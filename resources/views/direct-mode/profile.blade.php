@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
    $menuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => 'home', 'url' => '/direct-mode/dashboard'],
        ['key' => 'profile', 'title' => 'My Profile', 'icon' => 'user', 'url' => '/direct-mode/profile'],
        ['key' => 'assessments', 'title' => 'Assessments', 'icon' => 'clipboard', 'url' => '/direct-mode/assessments'],
        ['key' => 'jobs', 'title' => 'Jobs', 'icon' => 'briefcase', 'url' => '/direct-mode/jobs'],
        ['key' => 'applications', 'title' => 'My Applications', 'icon' => 'file', 'url' => '/direct-mode/applications'],
        ['key' => 'interviews', 'title' => 'Interviews', 'icon' => 'clock', 'url' => '/direct-mode/interviews'],
        ['key' => 'offers', 'title' => 'Offers', 'icon' => 'trophy', 'url' => '/direct-mode/offers'],
        ['key' => 'activity', 'title' => 'Activity', 'icon' => 'activity', 'url' => '/direct-mode/activity'],
        ['key' => 'settings', 'title' => 'Settings', 'icon' => 'settings', 'url' => '/direct-mode/settings'],
        ['key' => 'logout', 'title' => 'Logout', 'icon' => 'logout', 'url' => '#'],
    ];
    $tabs = ['Personal Info', 'Education', 'Skills', 'Experience', 'Certificates', 'Resume', 'Social Links'];
    $completionItems = [
        ['label' => 'Basic Information', 'done' => true],
        ['label' => 'Education', 'done' => true],
        ['label' => 'Skills', 'done' => true],
        ['label' => 'Resume Upload', 'done' => true],
        ['label' => 'Work Experience', 'done' => false],
        ['label' => 'Social Links', 'done' => false],
    ];
    $quickStats = [
        ['label' => 'Applied Jobs', 'value' => '12', 'icon' => 'briefcase'],
        ['label' => 'Interviews', 'value' => '3', 'icon' => 'calendar'],
        ['label' => 'Offers', 'value' => '1', 'icon' => 'star'],
        ['label' => 'Profile Views', 'value' => '245', 'icon' => 'eye'],
    ];
@endphp

@php $activePage = 'profile'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Profile - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#050d3d;background:#f5f9ff;font-weight:500}a{text-decoration:none;color:inherit}button,input,textarea,select{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:250px minmax(0,1fr);background:linear-gradient(135deg,#f8fbff 0%,#eef5ff 100%)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:82px;display:flex;align-items:center;padding:0 34px;border-bottom:1px solid #d8e4f7}.brand img{width:200px;display:block}.menu{padding:24px 18px 12px;display:grid;gap:8px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:15px;padding:0 18px;color:#081343;font-size:14px;font-weight:700;position:relative}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:12px;bottom:12px;width:3px;border-radius:5px;background:#064cff}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto;color:currentColor}.icon svg,.topbar svg,.field svg,.stat-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:26px 19px 14px;padding:18px 16px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:118px;position:relative;margin-bottom:10px}.rocket:before{content:"";position:absolute;left:44px;top:22px;width:78px;height:78px;background:linear-gradient(135deg,#0c65ff,#1536df);clip-path:polygon(50% 0,83% 20%,70% 70%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,30% 70%,17% 20%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:38px;right:20px;bottom:9px;height:22px;background:#dce8ff;border-radius:50%}.boost h3{margin:0 0 9px;font-size:16px;line-height:1.2}.boost p{margin:0 0 16px;color:#26375e;font-size:13px;line-height:1.35}.primary{height:40px;border:1px solid #064cff;border-radius:7px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 20px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:82px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:1fr minmax(320px,603px) 1fr;align-items:center;gap:26px;padding:0 38px}.search{height:45px;border:1px solid #cbd8ee;border-radius:7px;display:flex;align-items:center;gap:13px;padding:0 17px;color:#26375e;background:#fbfdff}.search input{width:100%;border:0;outline:0;background:transparent;color:#26375e}.user{justify-self:end;display:flex;align-items:center;gap:22px}.bell{position:relative;border:0;background:transparent;color:#07113d;padding:0;cursor:pointer}.bell span{position:absolute;right:-7px;top:-10px;width:18px;height:18px;border-radius:50%;background:#064cff;color:#fff;font-size:11px;display:flex;align-items:center;justify-content:center;font-weight:800}.top-avatar,.profile-avatar{background-image:url('{{ $user['avatar'] }}');background-size:cover;background-position:center top}.top-avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb}.user-name{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:800}.page{padding:28px 28px 14px}.page-grid{display:grid;grid-template-columns:minmax(0,1fr) 328px;gap:18px}.title-row{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:18px}.title-row h1{margin:0 0 4px;font-size:30px;line-height:1;font-weight:900}.title-row p{margin:0;color:#26375e;font-size:17px}.outline{height:38px;border:1px solid #064cff;border-radius:7px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 17px;display:inline-flex;align-items:center;gap:8px;cursor:pointer}.tabs{height:46px;border:1px solid #d8e4f7;border-radius:9px;background:rgba(255,255,255,.86);display:grid;grid-template-columns:repeat(7,1fr);overflow:hidden;margin-bottom:18px}.tab{border:0;background:transparent;color:#081343;font-size:13px;font-weight:600;cursor:pointer;position:relative}.tab.active{color:#064cff;font-weight:800}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#064cff}.card{background:rgba(255,255,255,.92);border:1px solid #d8e4f7;border-radius:14px;box-shadow:0 18px 38px rgba(6,25,66,.05)}.profile-card{padding:22px 30px 20px}.card h2{margin:0 0 22px;font-size:20px}.intro{display:grid;grid-template-columns:160px 1fr auto;align-items:center;gap:26px;margin-bottom:18px}.avatar-wrap{position:relative;width:132px;height:132px;margin-left:18px}.profile-avatar{width:132px;height:132px;border-radius:50%;border:12px solid #dce6f8}.camera{position:absolute;right:-4px;bottom:10px;width:42px;height:42px;border-radius:50%;border:2px solid #064cff;background:#fff;color:#064cff;display:grid;place-items:center}.identity h3{margin:0 0 6px;font-size:24px}.verified{display:inline-flex;width:18px;height:18px;border-radius:50%;background:#064cff;color:#fff;align-items:center;justify-content:center;font-size:12px;margin-left:8px}.identity p{margin:0 0 13px;color:#26375e}.status-pill{display:inline-flex;align-items:center;gap:8px;border-radius:8px;background:#dff6ee;color:#0b2c39;padding:7px 12px;font-size:13px}.dot{width:10px;height:10px;border-radius:50%;background:#16b779}.form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px 34px}.group label{display:block;margin-bottom:7px;font-size:13px;font-weight:800}.field{height:40px;border:1px solid #cbd8ee;border-radius:7px;background:#fff;display:flex;align-items:center;gap:14px;padding:0 14px;color:#111a46;font-size:14px}.field span{color:#1f2b55}.field .chev{margin-left:auto;color:#07113d}.about{grid-column:1/-1}.about .field{height:auto;min-height:92px;align-items:flex-start;padding-top:12px;position:relative}.about textarea{width:100%;height:64px;border:0;outline:0;resize:none;color:#111a46;background:transparent;line-height:1.35}.count{position:absolute;right:12px;bottom:10px;font-size:12px;color:#26375e}.actions{display:flex;gap:17px;margin-top:16px}.actions .primary{width:188px}.actions .outline{width:138px;justify-content:center}.right-col{display:grid;gap:14px}.side-card{padding:24px}.side-title{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px}.side-title h2{margin:0;font-size:18px}.side-title a{color:#064cff;font-size:12px;font-weight:800}.completion{display:grid;grid-template-columns:122px 1fr;gap:22px;align-items:center}.ring{width:116px;height:116px;border-radius:50%;background:conic-gradient(#064cff 0 75%,#dfe7f5 75%);display:grid;place-items:center;position:relative}.ring:before{content:"";position:absolute;inset:10px;background:#fff;border-radius:50%}.ring strong{position:relative;font-size:28px}.check-list{display:grid;gap:13px;font-size:13px}.check-list strong{font-size:13px;line-height:1.3}.check-row{display:flex;align-items:center;gap:11px;color:#1f2b55}.check{width:16px;height:16px;border:1px solid #657397;border-radius:50%;display:grid;place-items:center;font-size:11px}.check.done{background:#16a66a;border-color:#16a66a;color:#fff}.resume-file{display:grid;grid-template-columns:56px 1fr 20px;gap:16px;align-items:center;margin-bottom:18px}.pdf{width:56px;height:56px;border-radius:8px;background:#eef4ff;color:#064cff;display:grid;place-items:center;font-weight:900;border:0}.resume-file h3{margin:0 0 7px;font-size:13px}.resume-file p{margin:0;color:#4b5d84;font-size:12px}.replace{width:186px;margin:0 auto;justify-content:center;display:flex}.stats{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}.stat{height:72px;border:1px solid #d8e4f7;border-radius:9px;background:#fff;display:grid;grid-template-columns:45px 1fr;align-items:center;gap:10px;padding:11px}.stat-icon{width:38px;height:38px;border-radius:50%;background:#eef4ff;color:#064cff;display:grid;place-items:center}.stat strong{display:block;font-size:22px}.stat span{font-size:11px}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 30px;color:#081343;font-size:13px}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa;display:block}@media(max-width:1180px){.shell{grid-template-columns:1fr}.sidebar{display:none}.topbar{grid-template-columns:1fr auto}.search{grid-column:1}.page-grid{grid-template-columns:1fr}.intro{grid-template-columns:145px 1fr}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.user{justify-self:start}.page{padding:18px 14px}.title-row{flex-direction:column}.tabs{grid-template-columns:repeat(2,1fr);height:auto}.tab{height:42px}.intro,.form,.completion{grid-template-columns:1fr}.avatar-wrap{margin-left:0}.edit-photo{justify-self:start}.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px;padding:16px}.footer i{display:none}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important}.footer{display:none!important}.page{min-width:0;padding:28px 28px 30px!important}</style>
@endpush

@section('content')
<section class="page">
                <div class="page-grid">
                    <div>
                        <div class="title-row">
                            <div><h1>My Profile</h1><p>Keep your profile updated to get better job opportunities.</p></div>
                            <button class="outline" type="button"><span class="icon" data-icon="eye"></span>Preview Profile</button>
                        </div>
                        <div class="tabs">
                            @foreach ($tabs as $tab)
                                <button class="tab {{ $loop->first ? 'active' : '' }}" type="button">{{ $tab }}</button>
                            @endforeach
                        </div>
                        <article class="card profile-card">
                            <h2>Personal Information</h2>
                            <div class="intro">
                                <div class="avatar-wrap"><div class="profile-avatar"></div><span class="camera"><span class="icon" data-icon="camera"></span></span></div>
                                <div class="identity">
                                    <h3>Ananya Gupta <span class="verified">&#10003;</span></h3>
                                    <p>B.Tech Computer Science&nbsp; | &nbsp;Fresher</p>
                                    <span class="status-pill"><span class="dot"></span>Open to Work</span>
                                </div>
                                <button class="outline edit-photo" type="button"><span class="icon" data-icon="camera"></span>Edit Photo</button>
                            </div>
                            <div class="form">
                                <div class="group"><label>Full Name</label><div class="field"><span class="icon" data-icon="user"></span><span>Ananya Gupta</span></div></div>
                                <div class="group"><label>Location</label><div class="field"><span class="icon" data-icon="pin"></span><span>Bangalore, Karnataka</span><span class="chev icon" data-icon="chevron"></span></div></div>
                                <div class="group"><label>Email Address</label><div class="field"><span class="icon" data-icon="mail"></span><span>ananya@example.com</span></div></div>
                                <div class="group"><label>Qualification</label><div class="field"><span class="icon" data-icon="cap"></span><span>B.Tech (Computer Science)</span><span class="chev icon" data-icon="chevron"></span></div></div>
                                <div class="group"><label>Phone Number</label><div class="field"><span class="icon" data-icon="phone"></span><span>9876543210</span></div></div>
                                <div class="group"><label>Passing Year</label><div class="field"><span class="icon" data-icon="calendar"></span><span>2024</span><span class="chev icon" data-icon="chevron"></span></div></div>
                                <div class="group"><label>Date of Birth</label><div class="field"><span class="icon" data-icon="calendar"></span><span>12 Mar 2003</span></div></div>
                                <div class="group"><label>Preferred Job Role</label><div class="field"><span class="icon" data-icon="briefcase"></span><span>Full Stack Developer</span><span class="chev icon" data-icon="chevron"></span></div></div>
                                <div class="group about"><label>About Me</label><div class="field"><textarea>Passionate about web development and problem solving. Eager to start my career in a growth-focused organization where I can apply my skills and learn new technologies.</textarea><span class="count">156/500</span></div></div>
                            </div>
                            <div class="actions"><button class="primary" type="button"><span class="icon" data-icon="save"></span>Save Changes</button><button class="outline" type="button">Cancel</button></div>
                        </article>
                    </div>
                    <aside class="right-col">
                        <article class="card side-card">
                            <div class="side-title"><h2>Profile Completion</h2><a href="#">View Details</a></div>
                            <div class="completion">
                                <div class="ring"><strong>75%</strong></div>
                                <div class="check-list">
                                    <strong>Great! Your profile is almost complete.</strong>
                                    @foreach ($completionItems as $item)
                                        <div class="check-row"><span class="check {{ $item['done'] ? 'done' : '' }}">{!! $item['done'] ? '&#10003;' : '' !!}</span>{{ $item['label'] }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                        <article class="card side-card">
                            <div class="side-title"><h2>Resume</h2></div>
                            <div class="resume-file"><span class="pdf">PDF</span><div><h3>Ananya_Gupta_Resume.pdf</h3><p>Uploaded on 12 Jun 2024</p></div><span class="icon" data-icon="trash"></span></div>
                            <button class="outline replace" type="button"><span class="icon" data-icon="upload"></span>Replace Resume</button>
                        </article>
                        <article class="card side-card">
                            <div class="side-title"><h2>Quick Stats</h2></div>
                            <div class="stats">
                                @foreach ($quickStats as $stat)
                                    <div class="stat"><span class="stat-icon" data-icon="{{ $stat['icon'] }}"></span><div><strong>{{ $stat['value'] }}</strong><span>{{ $stat['label'] }}</span></div></div>
                                @endforeach
                            </div>
                        </article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',trophy:'<svg viewBox="0 0 24 24"><path d="M8 21h8M12 17v4"></path><path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path><path d="M5 5H3v3a4 4 0 0 0 4 4M19 5h2v3a4 4 0 0 1-4 4"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>',eye:'<svg viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>',camera:'<svg viewBox="0 0 24 24"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"></path><circle cx="12" cy="13" r="3"></circle></svg>',pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>',mail:'<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>',cap:'<svg viewBox="0 0 24 24"><path d="m22 10-10-5-10 5 10 5 10-5Z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path></svg>',phone:'<svg viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',save:'<svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"></path><path d="M17 21v-8H7v8M7 3v5h8"></path></svg>',trash:'<svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 15H6L5 6"></path></svg>',upload:'<svg viewBox="0 0 24 24"><path d="M12 3v12"></path><path d="m7 8 5-5 5 5"></path><path d="M5 21h14"></path></svg>',star:'<svg viewBox="0 0 24 24"><path d="m12 2 3 7 7 .6-5.4 4.7 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.6 9 9l3-7Z"></path></svg>'};
        document.querySelectorAll('[data-icon]').forEach(el=>{el.innerHTML=icons[el.dataset.icon]||el.innerHTML});
    </script>
@endpush



