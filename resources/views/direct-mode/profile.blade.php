@php
    $activePage = 'profile';
    $tabs = ['Personal Info', 'Education', 'Skills', 'Experience', 'Certificates', 'Resume', 'Social Links'];
    $completionItems = [
        ['key' => 'basic', 'label' => 'Basic Information'],
        ['key' => 'education', 'label' => 'Education'],
        ['key' => 'skills', 'label' => 'Skills'],
        ['key' => 'resume', 'label' => 'Resume Upload'],
        ['key' => 'work', 'label' => 'Work Experience'],
        ['key' => 'social', 'label' => 'Social Links'],
    ];
    $quickStats = [
        ['key' => 'applications', 'label' => 'Applied Jobs', 'value' => '0', 'icon' => 'briefcase'],
        ['key' => 'interviews', 'label' => 'Interviews', 'value' => '0', 'icon' => 'calendar'],
        ['key' => 'offers', 'label' => 'Offers', 'value' => '0', 'icon' => 'star'],
        ['key' => 'views', 'label' => 'Profile Views', 'value' => '0', 'icon' => 'eye'],
    ];
@endphp

@extends('layouts.direct-mode')

@section('title', 'Profile - Direct Mode')

@push('styles')
<style>
    .profile-page{padding:28px 28px 30px;background:linear-gradient(135deg,#f8fbff 0%,#eef5ff 100%);min-height:calc(100vh - 82px);overflow-x:hidden}.page-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(300px,328px);gap:18px;align-items:start}.title-row{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:18px}.title-row h1{margin:0 0 4px;font-size:30px;line-height:1;font-weight:900}.title-row p{margin:0;color:#26375e;font-size:17px}.outline{height:38px;border:1px solid #064cff;border-radius:7px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 17px;display:inline-flex;align-items:center;gap:8px;cursor:pointer}.tabs{min-height:46px;border:1px solid #d8e4f7;border-radius:9px;background:rgba(255,255,255,.86);display:grid;grid-template-columns:repeat(7,minmax(0,1fr));overflow:hidden;margin-bottom:18px}.tab{min-width:0;border:0;background:transparent;color:#081343;font-size:13px;font-weight:600;cursor:pointer;position:relative;padding:0 8px;white-space:nowrap}.tab.active{color:#064cff;font-weight:800}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#064cff}.card{background:rgba(255,255,255,.92);border:1px solid #d8e4f7;border-radius:14px;box-shadow:0 18px 38px rgba(6,25,66,.05)}.profile-card{padding:22px 30px 20px;min-height:536px}.card h2{margin:0 0 22px;font-size:20px}.intro{display:grid;grid-template-columns:160px minmax(0,1fr) auto;align-items:center;gap:26px;margin-bottom:18px}.avatar-wrap{position:relative;width:132px;height:132px;margin-left:18px}.profile-avatar{width:132px;height:132px;border-radius:50%;border:12px solid #dce6f8;background:#eef4ff url('/student.svg') center top/cover no-repeat}.camera{position:absolute;right:-4px;bottom:10px;width:42px;height:42px;border-radius:50%;border:2px solid #064cff;background:#fff;color:#064cff;display:grid;place-items:center}.identity{min-width:0}.identity h3{margin:0 0 6px;font-size:24px;overflow-wrap:anywhere}.verified{display:inline-flex;width:18px;height:18px;border-radius:50%;background:#064cff;color:#fff;align-items:center;justify-content:center;font-size:12px;margin-left:8px}.identity p{margin:0 0 13px;color:#26375e;overflow-wrap:anywhere}.status-pill{display:inline-flex;align-items:center;gap:8px;border-radius:8px;background:#dff6ee;color:#0b2c39;padding:7px 12px;font-size:13px}.dot{width:10px;height:10px;border-radius:50%;background:#16b779}.form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px 34px}.group.hidden{display:none}.group label{display:block;margin-bottom:7px;font-size:13px;font-weight:800}.field{height:40px;border:1px solid #cbd8ee;border-radius:7px;background:#fff;display:flex;align-items:center;gap:14px;padding:0 14px;color:#111a46;font-size:14px}.field input,.field select{width:100%;height:100%;border:0;outline:0;background:transparent;color:#111a46;font-size:14px;min-width:0}.field input::placeholder,.field textarea::placeholder{color:#7a87a5}.field input[readonly]{color:#26375e}.field .chev{margin-left:auto;color:#07113d}.about,.wide{grid-column:1/-1}.about .field{height:auto;min-height:92px;align-items:flex-start;padding-top:12px;position:relative}.about textarea{width:100%;height:64px;border:0;outline:0;resize:none;color:#111a46;background:transparent;line-height:1.35}.count{position:absolute;right:12px;bottom:10px;font-size:12px;color:#26375e}.actions{display:flex;align-items:center;gap:17px;margin-top:16px}.actions .primary,.actions .outline{height:38px;display:inline-flex;align-items:center;justify-content:center;gap:8px;line-height:1;white-space:nowrap}.actions .primary{width:188px}.actions .primary .icon,.actions .outline .icon{display:inline-flex;width:18px;height:18px;align-items:center;justify-content:center;line-height:0}.actions .primary .icon svg,.actions .outline .icon svg{display:block;width:18px;height:18px}.actions .outline{width:138px}.right-col{display:grid;gap:14px;min-width:0}.side-card{padding:24px}.side-title{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px}.side-title h2{margin:0;font-size:18px}.side-title a{color:#064cff;font-size:12px;font-weight:800}.completion{display:grid;grid-template-columns:122px 1fr;gap:22px;align-items:center}.ring{width:116px;height:116px;border-radius:50%;background:conic-gradient(#064cff 0 var(--value,0%),#dfe7f5 var(--value,0%));display:grid;place-items:center;position:relative}.ring:before{content:"";position:absolute;inset:10px;background:#fff;border-radius:50%}.ring strong{position:relative;font-size:28px}.check-list{display:grid;gap:13px;font-size:13px}.check-list strong{font-size:13px;line-height:1.3}.check-row{display:flex;align-items:center;gap:11px;color:#1f2b55}.check{width:16px;height:16px;border:1px solid #657397;border-radius:50%;display:grid;place-items:center;font-size:11px}.check.done{background:#16a66a;border-color:#16a66a;color:#fff}.resume-file{display:grid;grid-template-columns:56px minmax(0,1fr) 24px;gap:16px;align-items:center;margin-bottom:18px}.pdf{width:56px;height:56px;border-radius:8px;background:#eef4ff;color:#064cff;display:grid;place-items:center;font-weight:900;border:0}.resume-file h3{margin:0 0 7px;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.resume-file p{margin:0;color:#4b5d84;font-size:12px}.replace{width:186px;margin:0 auto;justify-content:center;display:flex}.stats{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.stat{min-height:72px;border:1px solid #d8e4f7;border-radius:9px;background:#fff;display:grid;grid-template-columns:42px minmax(0,1fr);align-items:center;gap:12px;padding:12px 14px}.stat-icon{width:38px;height:38px;border-radius:50%;background:#eef4ff;color:#064cff;display:flex;align-items:center;justify-content:center;line-height:0}.stat-icon svg{display:block;width:21px;height:21px;fill:none!important;stroke:currentColor!important;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round;transform:translate(0,0)}.stat div{min-width:0}.stat strong{display:block;font-size:22px;line-height:1;margin:0 0 4px;text-align:left}.stat span{display:block;font-size:12px;line-height:1.25;text-align:left;overflow-wrap:anywhere}.profile-alert{display:none;margin-bottom:14px;border-radius:8px;padding:11px 13px;font-size:13px;font-weight:800}.profile-alert.error{display:block;background:#fff1f2;border:1px solid #ffd0d7;color:#c8102e}.profile-alert.success{display:block;background:#ecfdf3;border:1px solid #baf0ce;color:#087443}.hidden-file{display:none}.trash-btn{border:0;background:transparent;color:#06123f;cursor:pointer;padding:0}@media(max-width:1320px){.page-grid{grid-template-columns:minmax(0,1fr)}.right-col{grid-template-columns:repeat(3,minmax(0,1fr))}.completion{grid-template-columns:110px 1fr}.ring{width:104px;height:104px}}@media(max-width:900px){.right-col{grid-template-columns:1fr}.tabs{grid-template-columns:repeat(2,minmax(0,1fr))}.tab{height:42px}.intro,.form,.completion{grid-template-columns:1fr}.avatar-wrap{margin-left:0}.edit-photo{justify-self:start}}@media(max-width:760px){.profile-page{padding:18px 14px}.title-row{flex-direction:column}}
</style>
<style>
    .resume-upload-field{padding-right:8px}
    .resume-upload-field input{cursor:pointer}
    .inline-upload{height:30px;border:1px solid #064cff;border-radius:7px;background:#064cff;color:#fff;font-size:12px;font-weight:800;padding:0 12px;display:inline-flex;align-items:center;justify-content:center;gap:6px;white-space:nowrap;cursor:pointer}
    .inline-upload .icon,.inline-upload .icon svg{width:15px;height:15px}
    .stats .stat{grid-template-columns:48px minmax(0,1fr);justify-items:start;align-items:center;gap:14px;padding:14px 16px}
    .stats .stat-icon{width:48px;height:48px;margin:0 auto}
    .stats .stat-icon svg{width:22px;height:22px}
    .stats .stat strong{font-size:24px;text-align:left}
    .stats .stat span{max-width:74px;line-height:1.2}
    .stats .stat{display:flex;align-items:center;justify-content:center;gap:16px;padding:14px 12px}
    .stats .stat-icon{display:flex;align-items:center;justify-content:center;width:50px;height:50px;margin:0;flex:0 0 50px}
    .stats .stat-icon svg{display:block;width:23px;height:23px}
    .stats .stat div{width:72px;min-width:0;text-align:left}
    .stats .stat strong{font-size:24px;line-height:1;text-align:left}
    .stats .stat span{max-width:none;font-size:13px;line-height:1.2;text-align:left;word-break:normal;overflow-wrap:normal}
    .stats .stat{justify-content:flex-start;gap:12px;padding:14px 12px}
    .stats .stat-icon{width:48px;height:48px;flex-basis:48px}
    .stats .stat div{width:auto;min-width:0;flex:1 1 0}
    .stats .stat span{display:block;max-width:100%;overflow-wrap:break-word}
    .stats .stat{display:grid;grid-template-columns:64px minmax(62px,1fr);gap:8px;justify-items:center;align-items:center;padding:14px 10px}
    .stats .stat-icon{width:50px;height:50px;flex-basis:auto;justify-self:center}
    .stats .stat div{width:100%;min-width:0;flex:none;text-align:left}
    .stats .stat strong{font-size:24px;text-align:left}
    .stats .stat span{font-size:13px;line-height:1.15;text-align:left;overflow-wrap:anywhere}
    .stats .stat-icon{position:relative!important;display:block!important}
    .stats .stat-icon svg{position:absolute!important;left:50%!important;top:50%!important;width:23px!important;height:23px!important;transform:translate(-50%,-50%)!important}
    .stats{grid-template-columns:repeat(2,minmax(0,1fr))!important}
    .stats .stat{height:auto!important;min-height:80px!important;display:grid!important;grid-template-columns:52px minmax(0,1fr)!important;gap:10px!important;align-items:center!important;justify-items:stretch!important;padding:12px!important;overflow:hidden!important}
    .stats .stat-icon{width:48px!important;height:48px!important;justify-self:center!important;align-self:center!important;display:grid!important;place-items:center!important}
    .stats .stat div{width:auto!important;min-width:0!important;display:grid!important;gap:2px!important;align-content:center!important;text-align:left!important}
    .stats .stat strong{font-size:24px!important;line-height:1!important;margin:0!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important;text-align:left!important}
    .stats .stat span{display:block!important;max-width:100%!important;font-size:12px!important;line-height:1.15!important;white-space:normal!important;overflow-wrap:anywhere!important;word-break:normal!important;text-align:left!important}
</style>
@endpush

@section('content')
<section class="profile-page">
    <div class="page-grid">
        <div>
            <div class="title-row">
                <div><h1>My Profile</h1><p>Keep your profile updated to get better job opportunities.</p></div>
                <button class="outline" type="button" data-preview-profile><span class="icon" data-icon="eye"></span>Preview Profile</button>
            </div>
            <div class="profile-alert" data-profile-alert></div>
            <div class="tabs">
                @foreach ($tabs as $tab)
                    <button class="tab {{ $loop->first ? 'active' : '' }}" type="button" data-tab="{{ strtolower(str_replace(' ', '-', $tab)) }}">{{ $tab }}</button>
                @endforeach
            </div>
            <article class="card profile-card">
                <h2 data-section-title>Personal Information</h2>
                <div class="intro">
                    <div class="avatar-wrap"><div class="profile-avatar" data-profile-avatar></div><button class="camera" type="button" data-pick-photo><span class="icon" data-icon="camera"></span></button></div>
                    <div class="identity">
                        <h3><span data-profile-name>Ananya Gupta</span> <span class="verified">&#10003;</span></h3>
                        <p><span data-profile-qualification>B.Tech Computer Science</span>&nbsp; | &nbsp;<span data-profile-role>Fresher</span></p>
                        <span class="status-pill"><span class="dot"></span><span data-work-status>Open to Work</span></span>
                    </div>
                    <button class="outline edit-photo" type="button" data-pick-photo><span class="icon" data-icon="camera"></span>Edit Photo</button>
                </div>
                <div class="form" data-profile-form>
                    <input class="hidden-file" type="file" accept="image/*" data-photo-input>
                    <input class="hidden-file" type="file" accept=".pdf,.doc,.docx" data-resume-input>
                    <div class="group" data-section="personal-info"><label>Full Name</label><div class="field"><span class="icon" data-icon="user"></span><input name="name" type="text" value="Ananya Gupta" autocomplete="name" placeholder="Enter full name"></div></div>
                    <div class="group" data-section="personal-info"><label>Location</label><div class="field"><span class="icon" data-icon="pin"></span><input name="city" type="text" value="Bangalore, Karnataka" placeholder="City, State"><span class="chev icon" data-icon="chevron"></span></div></div>
                    <div class="group" data-section="personal-info"><label>Email Address</label><div class="field"><span class="icon" data-icon="mail"></span><input name="email" type="email" value="ananya@example.com" readonly></div></div>
                    <div class="group" data-section="education"><label>Qualification</label><div class="field"><span class="icon" data-icon="cap"></span><input name="qualification" type="text" value="B.Tech (Computer Science)" placeholder="Highest qualification"><span class="chev icon" data-icon="chevron"></span></div></div>
                    <div class="group" data-section="personal-info"><label>Phone Number</label><div class="field"><span class="icon" data-icon="phone"></span><input name="phone" type="tel" value="9876543210" autocomplete="tel" placeholder="Mobile number"></div></div>
                    <div class="group" data-section="education"><label>Passing Year</label><div class="field"><span class="icon" data-icon="calendar"></span><input name="passing_year" type="number" min="1900" max="2100" value="2024" placeholder="YYYY"><span class="chev icon" data-icon="chevron"></span></div></div>
                    <div class="group" data-section="personal-info"><label>Date of Birth</label><div class="field"><span class="icon" data-icon="calendar"></span><input name="date_of_birth" type="text" value="12 Mar 2003" placeholder="DD Mon YYYY"></div></div>
                    <div class="group" data-section="skills"><label>Preferred Job Role</label><div class="field"><span class="icon" data-icon="briefcase"></span><input name="preferred_role" type="text" value="Full Stack Developer" placeholder="Preferred job role"><span class="chev icon" data-icon="chevron"></span></div></div>
                    <div class="group about" data-section="personal-info"><label>About Me</label><div class="field"><textarea name="about" maxlength="500" placeholder="Write a short professional summary">Passionate about web development and problem solving. Eager to start my career in a growth-focused organization where I can apply my skills and learn new technologies.</textarea><span class="count" data-about-count>0/500</span></div></div>
                    <div class="group hidden" data-section="education"><label>College Name</label><div class="field"><span class="icon" data-icon="cap"></span><input name="college_name" type="text" placeholder="College or institute name"></div></div>
                    <div class="group hidden wide" data-section="skills"><label>Skills</label><div class="field"><span class="icon" data-icon="activity"></span><input name="skills" type="text" placeholder="Example: HTML, CSS, JavaScript, Laravel"></div></div>
                    <div class="group hidden wide" data-section="experience"><label>Work Experience</label><div class="field"><span class="icon" data-icon="briefcase"></span><input name="work_experience" type="text" placeholder="Internship, project, or fresher experience"></div></div>
                    <div class="group hidden wide" data-section="certificates"><label>Certificates</label><div class="field"><span class="icon" data-icon="file"></span><input name="certificates" type="text" placeholder="Certificate names or links"></div></div>
                    <div class="group hidden wide" data-section="resume"><label>Resume</label><div class="field resume-upload-field"><span class="icon" data-icon="upload"></span><input name="resume_label" type="text" readonly placeholder="Upload your resume"><button class="inline-upload" type="button" data-pick-resume><span class="icon" data-icon="upload"></span>Upload</button></div></div>
                    <div class="group hidden" data-section="social-links"><label>LinkedIn</label><div class="field"><span class="icon" data-icon="file"></span><input name="linkedin" type="url" placeholder="LinkedIn profile URL"></div></div>
                    <div class="group hidden" data-section="social-links"><label>GitHub / Portfolio</label><div class="field"><span class="icon" data-icon="file"></span><input name="portfolio" type="url" placeholder="GitHub or portfolio URL"></div></div>
                </div>
                <div class="actions"><button class="primary" type="button" data-save-profile><span class="icon" data-icon="save"></span>Save Changes</button><button class="outline" type="button" data-reset-profile>Cancel</button></div>
            </article>
        </div>
        <aside class="right-col">
            <article class="card side-card">
                <div class="side-title"><h2>Profile Completion</h2></div>
                <div class="completion">
                    <div class="ring" data-completion-ring style="--value:0%"><strong data-completion-percent>0%</strong></div>
                    <div class="check-list">
                        <strong data-completion-message>Complete your profile to get better matches.</strong>
                        @foreach ($completionItems as $item)
                            <div class="check-row" data-completion-item="{{ $item['key'] }}"><span class="check"></span>{{ $item['label'] }}</div>
                        @endforeach
                    </div>
                </div>
            </article>
            <article class="card side-card">
                <div class="side-title"><h2>Resume</h2></div>
                <div class="resume-file"><span class="pdf" data-resume-type>PDF</span><div><h3 data-resume-name>No resume uploaded</h3><p data-resume-date>Upload your latest resume</p></div><button class="trash-btn icon" data-remove-resume type="button" data-icon="trash"></button></div>
                <button class="outline replace" type="button" data-pick-resume><span class="icon" data-icon="upload"></span>Replace Resume</button>
            </article>
            <article class="card side-card">
                <div class="side-title"><h2>Quick Stats</h2></div>
                <div class="stats">
                    @foreach ($quickStats as $stat)
                        <div class="stat" data-quick-stat="{{ $stat['key'] }}"><span class="stat-icon" data-icon="{{ $stat['icon'] }}"></span><div><strong>{{ $stat['value'] }}</strong><span>{{ $stat['label'] }}</span></div></div>
                    @endforeach
                </div>
            </article>
        </aside>
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    Object.assign(window.directModeIcons || {}, {
        eye:'<svg viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
        camera:'<svg viewBox="0 0 24 24"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"></path><circle cx="12" cy="13" r="3"></circle></svg>',
        pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
        cap:'<svg viewBox="0 0 24 24"><path d="m22 10-10-5-10 5 10 5 10-5Z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path></svg>',
        save:'<svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"></path><path d="M17 21v-8H7v8M7 3v5h8"></path></svg>',
        trash:'<svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 15H6L5 6"></path></svg>',
        upload:'<svg viewBox="0 0 24 24"><path d="M12 3v12"></path><path d="m7 8 5-5 5 5"></path><path d="M5 21h14"></path></svg>',
        briefcase:'<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M4 12h16"></path></svg>',
        calendar:'<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 3v4M16 3v4M4 10h16"></path></svg>',
        star:'<svg viewBox="0 0 24 24"><path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"></path></svg>',
    });
    document.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
    const token = localStorage.getItem('onlyfreshers_token');
    const storedUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || 'null');
    const draftKey = 'onlyfreshers_direct_profile_extra';
    let profileSnapshot = null;
    let selectedPhoto = null;
    let selectedResume = null;
    let resumeRemoved = false;
    const qs = selector => document.querySelector(selector);
    const qsa = selector => [...document.querySelectorAll(selector)];
    const form = qs('[data-profile-form]');
    const headers = { Accept: 'application/json', ...(token ? { Authorization: `Bearer ${token}` } : {}) };
    const extra = () => JSON.parse(localStorage.getItem(draftKey) || '{}');
    const saveExtra = value => localStorage.setItem(draftKey, JSON.stringify({ ...extra(), ...value }));
    const field = name => form.querySelector(`[name="${name}"]`);
    const value = name => field(name)?.value?.trim() || '';
    const setValue = (name, val) => { const el = field(name); if (el) el.value = val || ''; };
    const setText = (selector, val) => { const el = qs(selector); if (el) el.textContent = val || ''; };
    const showAlert = (message, type = 'error') => { const el = qs('[data-profile-alert]'); el.textContent = message || ''; el.className = message ? `profile-alert ${type}` : 'profile-alert'; };
    const setTopUser = user => {
        const name = user?.name || storedUser?.name || 'Fresher';
        const topName = qs('.top-user strong');
        if (topName) topName.textContent = name;
    };
    const setTopAvatar = url => {
        const avatar = qs('.top-avatar');
        if (avatar && url) avatar.style.backgroundImage = `url('${url}')`;
    };
    const countAbout = () => setText('[data-about-count]', `${field('about').value.length}/500`);
    const setCompletion = (profile, extras) => {
        const completion = Math.max(0, Math.min(100, Number(profile?.profile_completion) || 0));
        qs('[data-completion-ring]').style.setProperty('--value', `${completion}%`);
        setText('[data-completion-percent]', `${completion}%`);
        setText('[data-completion-message]', completion >= 75 ? 'Great! Your profile is almost complete.' : 'Complete your profile to get better matches.');
        const done = {
            basic: Boolean(value('name') && value('email') && value('phone')),
            education: Boolean(profile?.qualification || value('qualification')),
            skills: Boolean(profile?.skills || extras.preferred_role || value('skills') || value('preferred_role')),
            resume: Boolean(profile?.resume && !resumeRemoved),
            work: Boolean(extras.work_experience || value('work_experience')),
            social: Boolean(extras.linkedin || extras.github || extras.portfolio || value('linkedin') || value('portfolio')),
        };
        qsa('[data-completion-item]').forEach(row => {
            const mark = row.querySelector('.check');
            const isDone = done[row.dataset.completionItem];
            mark.classList.toggle('done', isDone);
            mark.innerHTML = isDone ? '&#10003;' : '';
        });
    };
    const isProfileReadyForAssessment = profile => Boolean(
        profile?.phone &&
        profile?.qualification &&
        profile?.skills &&
        profile?.resume
    );
    const setResume = (profile, extras) => {
        const resume = resumeRemoved ? null : (selectedResume?.name || extras.resume_name || profile?.resume);
        setText('[data-resume-name]', resume ? String(resume).split('/').pop() : 'No resume uploaded');
        setText('[data-resume-date]', resume ? `Uploaded ${extras.resume_uploaded_at || 'recently'}` : 'Upload your latest resume');
        setText('[data-resume-type]', resume ? String(resume).split('.').pop().toUpperCase().slice(0, 3) : 'PDF');
        setValue('resume_label', resume ? String(resume).split('/').pop() : '');
    };
    const applyProfile = data => {
        const user = data?.user || storedUser || {};
        const profile = data?.profile || {};
        const extras = extra();
        profileSnapshot = { user, profile, extras };
        setTopUser(user);
        setValue('name', user.name || '');
        setValue('email', user.email || '');
        setValue('city', profile.city || extras.city || '');
        setValue('qualification', profile.qualification || '');
        setValue('college_name', profile.college_name || extras.college_name || '');
        setValue('phone', profile.phone || '');
        setValue('passing_year', profile.passing_year || '');
        setValue('date_of_birth', extras.date_of_birth || '');
        setValue('preferred_role', extras.preferred_role || profile.skills || '');
        setValue('skills', profile.skills || extras.skills || extras.preferred_role || '');
        setValue('work_experience', extras.work_experience || '');
        setValue('certificates', extras.certificates || '');
        setValue('linkedin', extras.linkedin || '');
        setValue('portfolio', extras.portfolio || '');
        field('about').value = extras.about || '';
        setText('[data-profile-name]', user.name || 'Fresher');
        setText('[data-profile-qualification]', profile.qualification || 'Qualification not added');
        setText('[data-profile-role]', extras.preferred_role || profile.skills || 'Fresher');
        if (profile.profile_photo) {
            const photoUrl = `/storage/${profile.profile_photo}`;
            qs('[data-profile-avatar]').style.backgroundImage = `url('${photoUrl}')`;
            setTopAvatar(photoUrl);
        }
        countAbout();
        setCompletion(profile, extras);
        setResume(profile, extras);
    };
    const getJson = async url => {
        const response = await fetch(url, { headers });
        const json = await response.json().catch(() => ({}));
        if (!response.ok) throw new Error(json.message || 'Unable to load profile.');
        return json.data;
    };
    const load = async () => {
        if (!token) {
            showAlert('Please login again to load your profile data.');
            applyProfile({ user: storedUser || {}, profile: {} });
            return;
        }
        try {
            const [profileData, dashboardData, unreadData] = await Promise.all([
                getJson('/api/fresher/profile'),
                getJson('/api/fresher/dashboard').catch(() => null),
                getJson('/api/notifications/unread-count').catch(() => ({ unread_count: 0 })),
            ]);
            applyProfile(profileData);
            const stats = dashboardData?.statistics || {};
            const map = {
                applications: stats.total_applications,
                interviews: stats.scheduled_interviews,
                offers: stats.hired_applications,
                views: stats.profile_views,
            };
            Object.entries(map).forEach(([key, val]) => {
                const el = qs(`[data-quick-stat="${key}"] strong`);
                if (el) el.textContent = Number(val || 0);
            });
            const bell = qs('.top-bell b');
            if (bell) {
                const unread = Number(unreadData.unread_count || 0);
                bell.textContent = unread;
                bell.style.display = unread > 0 ? 'grid' : 'none';
            }
        } catch (error) {
            showAlert(error.message);
            applyProfile({ user: storedUser || {}, profile: {} });
        }
    };
    const save = async () => {
        showAlert('');
        const extras = {
            city: value('city'),
            college_name: value('college_name'),
            date_of_birth: value('date_of_birth'),
            preferred_role: value('preferred_role'),
            skills: value('skills'),
            work_experience: value('work_experience'),
            certificates: value('certificates'),
            linkedin: value('linkedin'),
            portfolio: value('portfolio'),
            about: field('about').value.trim(),
            resume_name: selectedResume?.name || (resumeRemoved ? '' : extra().resume_name),
            resume_uploaded_at: selectedResume ? 'just now' : extra().resume_uploaded_at,
        };
        saveExtra(extras);
        if (!token) {
            showAlert('Please login again before saving profile.');
            return;
        }
        const payload = new FormData();
        payload.append('phone', value('phone'));
        payload.append('city', value('city'));
        payload.append('qualification', value('qualification'));
        payload.append('college_name', value('college_name'));
        payload.append('passing_year', value('passing_year'));
        payload.append('skills', value('skills') || value('preferred_role'));
        if (selectedPhoto) payload.append('profile_photo', selectedPhoto);
        if (selectedResume && !resumeRemoved) payload.append('resume', selectedResume);
        const button = qs('[data-save-profile]');
        button.disabled = true;
        button.textContent = 'Saving...';
        try {
            const response = await fetch('/api/fresher/profile', { method: 'POST', headers: { Accept: 'application/json', Authorization: `Bearer ${token}` }, body: payload });
            const json = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(json.message || 'Unable to save profile.');
            if (storedUser) {
                storedUser.name = value('name') || storedUser.name;
                localStorage.setItem('onlyfreshers_user', JSON.stringify(storedUser));
            }
            selectedPhoto = null;
            selectedResume = null;
            resumeRemoved = false;
            showAlert('Profile updated successfully.', 'success');
            await load();
            const updatedProfile = json.data?.profile || {};
            if (isProfileReadyForAssessment(updatedProfile)) {
                window.location.href = '/direct-mode/assessments';
            }
        } catch (error) {
            showAlert(error.message);
        } finally {
            button.disabled = false;
            button.innerHTML = '<span class="icon" data-icon="save"></span>Save Changes';
            button.querySelector('[data-icon]').innerHTML = window.directModeIcons.save || '';
        }
    };
    qsa('[data-pick-photo]').forEach(btn => btn.addEventListener('click', () => qs('[data-photo-input]').click()));
    qs('[data-photo-input]').addEventListener('change', event => {
        selectedPhoto = event.target.files[0] || null;
        if (selectedPhoto) {
            const previewUrl = URL.createObjectURL(selectedPhoto);
            qs('[data-profile-avatar]').style.backgroundImage = `url('${previewUrl}')`;
            setTopAvatar(previewUrl);
        }
    });
    qs('[data-pick-resume]').addEventListener('click', () => qs('[data-resume-input]').click());
    qs('[data-resume-input]').addEventListener('change', event => {
        selectedResume = event.target.files[0] || null;
        resumeRemoved = false;
        setResume(profileSnapshot?.profile || {}, extra());
    });
    qs('[data-remove-resume]').addEventListener('click', () => {
        selectedResume = null;
        resumeRemoved = true;
        saveExtra({ resume_name: '', resume_uploaded_at: '' });
        setResume({}, extra());
        setCompletion(profileSnapshot?.profile || {}, extra());
    });
    qs('[data-save-profile]').addEventListener('click', save);
    qs('[data-reset-profile]').addEventListener('click', () => profileSnapshot && applyProfile(profileSnapshot));
    field('about').addEventListener('input', countAbout);
    const switchTab = tab => {
        qsa('[data-tab]').forEach(button => button.classList.toggle('active', button.dataset.tab === tab));
        qsa('[data-section]').forEach(group => group.classList.toggle('hidden', group.dataset.section !== tab));
        const activeButton = qs(`[data-tab="${tab}"]`);
        setText('[data-section-title]', activeButton ? activeButton.textContent : 'Personal Information');
    };
    qsa('[data-tab]').forEach(button => button.addEventListener('click', () => switchTab(button.dataset.tab)));
    ['name','qualification','preferred_role','skills','phone','city','work_experience','linkedin','portfolio'].forEach(name => field(name)?.addEventListener('input', () => {
        setText('[data-profile-name]', value('name') || 'Fresher');
        setText('[data-profile-qualification]', value('qualification') || 'Qualification not added');
        setText('[data-profile-role]', value('preferred_role') || value('skills') || 'Fresher');
        setCompletion(profileSnapshot?.profile || {}, extra());
    }));
    qs('[data-preview-profile]').addEventListener('click', () => window.location.href = '/direct-mode/dashboard');
    qs('[data-view-details]')?.addEventListener('click', event => { event.preventDefault(); qs('.profile-card').scrollIntoView({ behavior: 'smooth', block: 'start' }); });
    switchTab('personal-info');
    load();
})();
</script>
@endpush
