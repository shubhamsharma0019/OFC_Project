@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
    $tabs = ['Job Description', 'About Company', 'Requirements', 'Benefits', 'Reviews'];
@endphp

@php $activePage = 'jobs'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Job Details - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:242px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:74px;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #d8e4f7}.brand img{width:200px}.menu{padding:30px 16px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.detail-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:50px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:30px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:36px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 22px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:74px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,555px) 1fr;align-items:center;gap:30px;padding:0 30px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.page{padding:20px 28px}.back{display:inline-flex;align-items:center;gap:8px;color:#064cff;font-size:13px;font-weight:800;margin-bottom:16px}.layout{display:grid;grid-template-columns:minmax(0,1fr) 370px;gap:22px}.card{background:#fff;border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.detail{padding:22px 24px}.hero{display:grid;grid-template-columns:124px 1fr auto;gap:30px;align-items:start;padding-bottom:26px;border-bottom:1px solid #d8e4f7}.logo{width:122px;height:122px;border-radius:9px;color:#fff;display:grid;place-items:center;text-align:center;font-weight:900}.logo strong{font-size:48px;line-height:1}.logo span{font-size:20px}.navy{background:#102d68}.orange{background:linear-gradient(135deg,#ff8b29,#ff4d08)}.black{background:#181b21}.purple{background:linear-gradient(135deg,#7b4be8,#4522aa)}.green{background:linear-gradient(135deg,#12b665,#05773d)}.title h1{margin:4px 0 12px;font-size:28px}.title h2{margin:0 0 20px;font-size:17px}.tag{height:27px;border:1px solid #bde6ce;background:#e8f8ef;color:#008a35;border-radius:6px;display:inline-grid;place-items:center;font-size:12px;font-weight:800;padding:0 14px;margin-left:14px}.meta{display:flex;gap:28px;flex-wrap:wrap;color:#5a668f;font-size:13px}.hero-actions{text-align:right;display:grid;gap:18px;justify-items:end}.outline{height:36px;border:1px solid #064cff;border-radius:6px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;cursor:pointer}.tabs{height:49px;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:repeat(5,1fr);margin-bottom:22px}.tab{border:0;background:transparent;color:#3f4c77;font-weight:700;position:relative}.tab.active{color:#064cff}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:2px;background:#064cff}.section{border-bottom:1px solid #e5ecf7;padding:0 0 22px;margin-bottom:20px}.section h2{font-size:17px;margin:0 0 14px}.section p{margin:0;color:#3d4b76;line-height:1.7;font-size:14px;max-width:760px}.section li{margin:9px 0;color:#3d4b76;font-size:14px}.section li::marker{color:#064cff}.skills{display:flex;gap:12px;flex-wrap:wrap}.skill{height:28px;border:1px solid #d8e4f7;border-radius:6px;background:#fbfdff;color:#34436f;display:inline-flex;align-items:center;padding:0 18px;font-size:12px}.info-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin:20px 0}.info{height:68px;border:1px solid #d8e4f7;border-radius:8px;display:grid;grid-template-columns:42px 1fr;gap:12px;align-items:center;padding:13px}.detail-icon{color:#064cff}.info span{display:block;color:#657197;font-size:12px}.info strong{font-size:13px}.cta{border:1px solid #064cff;border-radius:8px;background:#fbfdff;display:flex;align-items:center;justify-content:space-between;gap:18px;padding:18px 24px}.cta-copy{display:flex;align-items:center;gap:18px}.send{width:44px;height:44px;border-radius:50%;background:#eaf2ff;color:#064cff;display:grid;place-items:center}.cta h3{margin:0 0 7px;font-size:16px}.cta p{margin:0;color:#3d4b76;font-size:13px}.side{display:grid;gap:18px}.side-card{padding:20px}.side-card h2{margin:0 0 18px;font-size:18px}.company{display:grid;grid-template-columns:64px 1fr;gap:18px;align-items:center;margin-bottom:24px}.company .logo{width:64px;height:64px}.company .logo strong{font-size:32px}.company h3{margin:0 0 7px}.company p,.company span{margin:0;color:#3d4b76;font-size:13px}.company-list{display:grid;gap:18px;margin-bottom:22px}.company-row{display:grid;grid-template-columns:28px 1fr 1fr;gap:12px;color:#3d4b76;font-size:13px}.similar-head{display:flex;justify-content:space-between;align-items:center}.similar-head a{color:#064cff;font-size:12px;font-weight:800}.similar{display:grid;grid-template-columns:62px 1fr 34px;gap:14px;align-items:center;padding:14px 0;border-bottom:1px solid #e5ecf7}.similar:last-child{border-bottom:0}.similar .logo{width:56px;height:56px}.similar .logo strong{font-size:26px}.similar h3{margin:0 0 6px;font-size:14px}.similar p{margin:0 0 8px;color:#3d4b76;font-size:13px}.similar small{display:block;color:#657197;margin-top:6px}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1200px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.info-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.hero,.info-grid{grid-template-columns:1fr}.hero-actions{text-align:left;justify-items:start}.tabs{grid-template-columns:1fr;height:auto}.tab{height:40px}.cta,.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px}.footer{padding:16px}.footer i{display:none}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:20px 28px 30px!important}.layout{align-items:start}.detail,.side-card{max-width:100%;overflow:hidden}.hero{grid-template-columns:122px minmax(0,1fr) minmax(190px,auto)}.hero-actions div{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap}.tabs{max-width:100%;overflow-x:auto}.info-grid{grid-template-columns:repeat(4,minmax(0,1fr));align-items:stretch}.info{height:auto;min-height:68px;grid-template-columns:42px minmax(0,1fr);align-content:center}.info strong{display:block;line-height:1.25;overflow-wrap:break-word;word-break:normal}.info span:not(.detail-icon){line-height:1.2}.detail-icon{align-self:center;justify-self:center}.similar{grid-template-columns:56px minmax(0,1fr) 34px}.similar h3,.similar p,.similar small{overflow-wrap:anywhere}.alert{display:none;margin:0 0 14px;padding:11px 13px;border-radius:8px;border:1px solid #bcd3ff;background:#eef5ff;color:#06123f;font-size:13px;font-weight:700}.alert.show{display:block}.logo img{width:100%;height:100%;object-fit:cover;border-radius:9px}.primary[disabled],.outline[disabled]{opacity:.65;cursor:not-allowed}.saved{background:#eaf2ff;color:#064cff}.tab-panel{display:none}.tab-panel.active{display:block}.empty{border:1px dashed #cbd8ee;border-radius:10px;background:#fbfdff;padding:22px;text-align:center;color:#43517b}.company-row b{overflow-wrap:anywhere}.similar .outline{height:34px}.reviews-list{display:grid;gap:12px}.review{border:1px solid #e5ecf7;border-radius:8px;padding:12px;color:#3d4b76;font-size:13px}.review strong{display:block;color:#06123f;margin-bottom:5px}.cta{display:grid!important;grid-template-columns:minmax(0,1fr) 140px;align-items:center}.cta-copy{min-width:0}.cta .primary{width:140px;min-width:140px;white-space:normal;line-height:1.15;padding:0 18px}.cta h3,.cta p{overflow-wrap:break-word}@media(max-width:1200px){.layout{grid-template-columns:1fr!important}.hero{grid-template-columns:122px minmax(0,1fr)!important}.hero-actions{grid-column:1/-1;text-align:left!important;justify-items:start!important}.hero-actions div{justify-content:flex-start}.info-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important}}@media(max-width:760px){.hero,.info-grid{grid-template-columns:1fr!important}.logo{width:86px!important;height:86px!important}.logo strong{font-size:34px!important}.tabs{grid-template-columns:1fr!important;height:auto!important}.tab{height:40px}.cta{grid-template-columns:1fr!important;align-items:flex-start!important}.cta .primary{width:max-content;min-width:130px}}</style>
@endpush

@section('content')
<section class="page">
                <a class="back" href="/direct-mode/jobs"><span class="icon" data-icon="arrow-left"></span>Back to Jobs</a>
                <div class="layout">
                    <article class="card detail">
                        <div class="alert" data-alert></div>
                        <div class="hero">
                            <div class="logo navy" data-job-logo><div><strong>OF</strong><span>Job</span></div></div>
                            <div class="title"><h1><span data-job-title>Loading Job...</span> <span class="tag" data-job-mode>Direct Mode</span></h1><h2 data-company-name>Company</h2><div class="meta"><span><span class="icon" data-icon="pin"></span><span data-job-location>Location</span></span><span><span class="icon" data-icon="briefcase"></span><span data-job-type>Job Type</span></span><span data-job-salary>Salary</span></div></div>
                            <div class="hero-actions"><span data-job-posted>Loading...</span><div><button class="outline" data-save-job type="button"><span class="icon" data-icon="bookmark"></span><span data-save-text>Save Job</span></button> <button class="primary" data-apply-job type="button">Apply Now</button></div></div>
                        </div>
                        <div class="tabs">@foreach ($tabs as $tab)<button class="tab {{ $loop->first ? 'active' : '' }}" data-tab="{{ \Illuminate\Support\Str::slug($tab) }}" type="button">{{ $tab }}</button>@endforeach</div>
                        <div data-panel="job-description" class="tab-panel active">
                            <section class="section"><h2>Job Overview</h2><p data-job-description>Loading job overview from backend...</p></section>
                            <section class="section"><h2>Key Responsibilities</h2><ul data-responsibilities><li>Loading responsibilities...</li></ul></section>
                            <section><h2>Required Skills</h2><div class="skills" data-skills><span class="skill">Loading</span></div></section>
                        </div>
                        <div data-panel="about-company" class="tab-panel">
                            <section class="section"><h2>About Company</h2><p data-company-description>Loading company details...</p></section>
                        </div>
                        <div data-panel="requirements" class="tab-panel">
                            <section class="section"><h2>Requirements</h2><ul data-requirements><li>Loading requirements...</li></ul></section>
                        </div>
                        <div data-panel="benefits" class="tab-panel">
                            <section class="section"><h2>Benefits</h2><ul data-benefits><li>Loading benefits...</li></ul></section>
                        </div>
                        <div data-panel="reviews" class="tab-panel">
                            <section class="section"><h2>Reviews</h2><div class="reviews-list" data-reviews><div class="review"><strong>No reviews yet</strong><span>Company reviews will appear here when available.</span></div></div></section>
                        </div>
                        <div class="info-grid" data-info-grid></div>
                        <div class="cta"><div class="cta-copy"><span class="send" data-icon="send"></span><div><h3>Ready to take the next step?</h3><p data-cta-copy>Apply now and get noticed by the hiring team.</p></div></div><button class="primary" data-apply-job type="button">Apply Now</button></div>
                    </article>
                    <aside class="side">
                        <article class="card side-card">
                            <h2>About Company</h2>
                            <div class="company"><div class="logo navy" data-company-logo><strong>OF</strong></div><div><h3 data-side-company>Company</h3><p data-company-industry>Industry</p><span data-company-rating>Profile from backend</span></div></div>
                            <div class="company-list" data-company-list></div>
                            <button class="outline" data-company-profile type="button" style="width:100%">View Company Profile</button>
                        </article>
                        <article class="card side-card">
                            <div class="similar-head"><h2>Similar Jobs</h2><a href="/direct-mode/jobs">View All</a></div>
                            <div data-similar-jobs><div class="empty">Loading similar jobs...</div></div>
                        </article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>','arrow-left':'<svg viewBox="0 0 24 24"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>',pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>',bookmark:'<svg viewBox="0 0 24 24"><path d="M19 21 12 17 5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"></path></svg>',cap:'<svg viewBox="0 0 24 24"><path d="m22 10-10-5-10 5 10 5 10-5Z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path></svg>',money:'<svg viewBox="0 0 24 24"><path d="M12 3c4 4 7 8 7 12a7 7 0 0 1-14 0c0-4 3-8 7-12Z"></path><path d="M9 14h6M12 11v6"></path></svg>',send:'<svg viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4 20-7Z"></path><path d="M22 2 11 13"></path></svg>',users:'<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-8 0v2"></path><circle cx="12" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path></svg>',calendar:'<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>',globe:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"></path></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => Array.from(document.querySelectorAll(selector));
        const token = localStorage.getItem('onlyfreshers_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || '{}'); } catch (error) { authUser = {}; }
        const jobId = location.pathname.split('/').filter(Boolean).pop();
        const state = {
            job: null,
            similar: [],
            applications: [],
            savedJobs: JSON.parse(localStorage.getItem('onlyfreshers_saved_jobs') || '[]'),
        };

        function hydrateIcons(root = document) {
            root.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = icons[el.dataset.icon] || ''; });
        }

        function apiHeaders() {
            return {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
            };
        }

        function company(job = state.job || {}) {
            return job.company_profile || job.companyProfile || {};
        }

        function companyName(job = state.job || {}) {
            return company(job).company_name || job.company_name || 'Company';
        }

        function logoText(job = state.job || {}) {
            return companyName(job).split(/\s+/).filter(Boolean).slice(0, 2).map(word => word[0]).join('').toUpperCase() || 'OF';
        }

        function jobMode(job = state.job || {}) {
            return String(job.hiring_mode || 'direct').replace('_', ' ');
        }

        function jobType(job = state.job || {}) {
            return String(job.job_type || 'Full Time').replace('_', ' ');
        }

        function postedAt(job = state.job || {}) {
            const raw = job.created_at || job.updated_at;
            if (!raw) return 'Recently posted';
            const diff = Math.max(0, Date.now() - new Date(raw).getTime());
            const hours = Math.floor(diff / 3600000);
            if (hours < 1) return 'Posted just now';
            if (hours < 24) return `Posted ${hours}h ago`;
            return `Posted ${Math.floor(hours / 24)}d ago`;
        }

        function splitList(value, fallback = []) {
            if (Array.isArray(value)) return value.filter(Boolean);
            const parts = String(value || '').split(/[\n,;|]+/).map(item => item.trim()).filter(Boolean);
            return parts.length ? parts : fallback;
        }

        function isApplied() {
            return state.applications.some(application => Number(application.job_id || application.job?.id) === Number(state.job?.id));
        }

        function isSaved() {
            return state.savedJobs.includes(Number(state.job?.id));
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

        function renderLogo(target, job, compact = false) {
            const companyLogo = company(job).company_logo;
            target.className = 'logo navy';
            target.innerHTML = companyLogo
                ? `<img src="${escapeAttr(companyLogo)}" alt="${escapeAttr(companyName(job))}">`
                : compact
                    ? `<strong>${escapeHtml(logoText(job))}</strong>`
                    : `<div><strong>${escapeHtml(logoText(job))}</strong><span>${escapeHtml(companyName(job).slice(0, 8))}</span></div>`;
        }

        function renderJob() {
            const job = state.job;
            if (!job) return;
            renderLogo($('[data-job-logo]'), job);
            renderLogo($('[data-company-logo]'), job, true);
            $('[data-job-title]').textContent = job.title || 'Untitled Job';
            $('[data-job-mode]').textContent = titleCase(jobMode(job));
            $('[data-company-name]').textContent = companyName(job);
            $('[data-side-company]').textContent = companyName(job);
            $('[data-job-location]').textContent = job.location || 'Location not shared';
            $('[data-job-type]').textContent = jobType(job);
            $('[data-job-salary]').textContent = job.salary || 'Salary not disclosed';
            $('[data-job-posted]').textContent = postedAt(job);
            $('[data-company-industry]').textContent = company(job).industry || job.industry || 'Industry not shared';
            $('[data-company-rating]').textContent = company(job).website ? company(job).website : 'Company profile';
            $('[data-job-description]').textContent = job.description || `${job.title || 'This role'} is open for freshers. Read the requirements and apply directly from this page.`;
            $('[data-company-description]').textContent = company(job).description || `${companyName(job)} is hiring freshers through OnlyFreshers Direct Mode.`;
            $('[data-cta-copy]').textContent = `Apply for ${job.title || 'this job'} at ${companyName(job)} and track the status in My Applications.`;

            renderList('[data-responsibilities]', splitList(job.responsibilities, [
                `Work on ${job.title || 'assigned role'} responsibilities with the hiring team.`,
                'Complete assigned tasks and communicate progress clearly.',
                'Follow company standards and deliver quality work.',
            ]));
            renderList('[data-requirements]', splitList(job.qualification, ['Freshers can apply', 'Relevant qualification preferred']).concat(splitList(job.required_skills)));
            renderList('[data-benefits]', splitList(job.benefits, ['Direct application tracking', 'Verified company opportunity', 'Fresher-friendly hiring flow']));
            renderSkills(splitList(job.required_skills, ['Communication', 'Problem Solving']));
            renderInfoGrid(job);
            renderCompanyList(job);
            renderApplySaveState();
            document.title = `${job.title || 'Job Details'} - Direct Mode`;
        }

        function renderList(selector, items) {
            $(selector).innerHTML = [...new Set(items)].filter(Boolean).map(item => `<li>${escapeHtml(item)}</li>`).join('') || '<li>Details not shared yet.</li>';
        }

        function renderSkills(skills) {
            $('[data-skills]').innerHTML = skills.map(skill => `<span class="skill">${escapeHtml(skill)}</span>`).join('') || '<span class="skill">Not specified</span>';
        }

        function renderInfoGrid(job) {
            const lastDate = job.application_last_date ? new Date(job.application_last_date).toLocaleDateString() : 'Not specified';
            const details = [
                ['Job Type', jobType(job), 'briefcase'],
                ['Openings', job.openings || 'Not specified', 'users'],
                ['Qualification', job.qualification || 'Not specified', 'cap'],
                ['Salary', job.salary || 'Not disclosed', 'money'],
                ['Location', job.location || 'Not shared', 'pin'],
                ['Apply Before', lastDate, 'calendar'],
                ['Hiring Mode', titleCase(jobMode(job)), 'briefcase'],
                ['Status', titleCase(job.status || 'active'), 'file'],
            ];
            $('[data-info-grid]').innerHTML = details.map(([label, value, icon]) => `<div class="info"><span class="detail-icon" data-icon="${icon}"></span><div><span>${escapeHtml(label)}</span><strong>${escapeHtml(value)}</strong></div></div>`).join('');
            hydrateIcons($('[data-info-grid]'));
        }

        function renderCompanyList(job) {
            const data = [
                ['Company Size', company(job).company_size || 'Not shared', 'users'],
                ['Founded', company(job).founded_year || 'Not shared', 'calendar'],
                ['Industry', company(job).industry || 'Not shared', 'file'],
                ['Headquarters', company(job).address || job.location || 'Not shared', 'pin'],
                ['Website', company(job).website || 'Not shared', 'globe'],
            ];
            $('[data-company-list]').innerHTML = data.map(([label, value, icon]) => `<div class="company-row"><span class="icon" data-icon="${icon}"></span><span>${escapeHtml(label)}</span><b>${escapeHtml(value)}</b></div>`).join('');
            hydrateIcons($('[data-company-list]'));
        }

        function renderSimilarJobs() {
            const wrap = $('[data-similar-jobs]');
            const similar = state.similar.filter(job => Number(job.id) !== Number(state.job?.id)).slice(0, 3);
            if (!similar.length) {
                wrap.innerHTML = '<div class="empty">No similar direct mode jobs found.</div>';
                return;
            }
            wrap.innerHTML = similar.map(job => `
                <a class="similar" href="/direct-mode/jobs/${job.id}">
                    <div class="logo navy"><strong>${escapeHtml(logoText(job))}</strong></div>
                    <div><h3>${escapeHtml(job.title || 'Untitled Job')}</h3><p>${escapeHtml(companyName(job))}</p><small>${escapeHtml(job.location || 'Location')} - ${escapeHtml(jobType(job))}</small><small>${escapeHtml(job.salary || 'Salary not disclosed')}</small></div>
                    <span class="outline" style="width:34px;padding:0"><span class="icon" data-icon="bookmark"></span></span>
                </a>`).join('');
            hydrateIcons(wrap);
        }

        function renderApplySaveState() {
            const applied = isApplied();
            $$('[data-apply-job]').forEach(button => {
                button.disabled = applied;
                button.textContent = applied ? 'Applied' : 'Apply Now';
            });
            $$('[data-save-job]').forEach(button => {
                button.classList.toggle('saved', isSaved());
                const text = button.querySelector('[data-save-text]');
                if (text) text.textContent = isSaved() ? 'Saved' : 'Save Job';
            });
        }

        async function applyToJob(button) {
            if (!token) {
                showAlert('Apply karne ke liye pehle login karein.', 'error');
                return;
            }
            button.disabled = true;
            button.textContent = 'Applying...';
            try {
                const response = await fetch(`/api/fresher/jobs/${state.job.id}/apply`, { method: 'POST', headers: apiHeaders(), body: '{}' });
                const payload = await response.json();
                if (!response.ok || payload.success === false) throw new Error(payload.message || 'Application submit nahi ho payi.');
                state.applications.unshift({ job_id: state.job.id, ...(payload.data?.application || {}) });
                showAlert('Application submit ho gayi. My Applications page par status track hoga.');
                renderApplySaveState();
            } catch (error) {
                showAlert(error.message, 'error');
                renderApplySaveState();
            }
        }

        function toggleSave() {
            const id = Number(state.job?.id);
            if (!id) return;
            state.savedJobs = isSaved()
                ? state.savedJobs.filter(savedId => savedId !== id)
                : [...state.savedJobs, id];
            localStorage.setItem('onlyfreshers_saved_jobs', JSON.stringify(state.savedJobs));
            renderApplySaveState();
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
                if (selectedMode !== 'direct') {
                    window.location.href = '/direct-mode/flow-selection';
                    return false;
                }

                return true;
            } catch (error) {
                window.location.href = '/direct-mode/flow-selection';
                return false;
            }
        }

        async function loadJob() {
            try {
                const response = await fetch(`/api/jobs/${jobId}`, { headers: { 'Accept': 'application/json' } });
                const payload = await response.json();
                if (!response.ok || payload.success === false) throw new Error(payload.message || 'Job details nahi mile.');
                state.job = payload.data?.job;
                await loadSimilarJobs();
                renderJob();
                renderSimilarJobs();
            } catch (error) {
                $('[data-job-description]').textContent = error.message;
                showAlert(error.message, 'error');
            }
        }

        async function loadSimilarJobs() {
            try {
                const params = new URLSearchParams({ hiring_mode: 'direct' });
                if (state.job?.location) params.set('location', state.job.location);
                const response = await fetch(`/api/jobs?${params.toString()}`, { headers: { 'Accept': 'application/json' } });
                const payload = await response.json();
                let jobs = payload.data?.jobs || [];
                if (jobs.length <= 1) {
                    const fallback = await fetch('/api/jobs?hiring_mode=direct', { headers: { 'Accept': 'application/json' } });
                    const fallbackPayload = await fallback.json();
                    jobs = fallbackPayload.data?.jobs || [];
                }
                state.similar = jobs;
            } catch (error) {
                state.similar = [];
            }
        }

        function wireTabs() {
            $$('.tab').forEach(tab => tab.addEventListener('click', () => {
                $$('.tab').forEach(item => item.classList.remove('active'));
                $$('.tab-panel').forEach(panel => panel.classList.remove('active'));
                tab.classList.add('active');
                $(`[data-panel="${tab.dataset.tab}"]`)?.classList.add('active');
            }));
        }

        function wireActions() {
            $$('[data-apply-job]').forEach(button => button.addEventListener('click', () => applyToJob(button)));
            $$('[data-save-job]').forEach(button => button.addEventListener('click', toggleSave));
            $('[data-company-profile]').addEventListener('click', () => {
                if (company(state.job).website) {
                    const website = company(state.job).website;
                    window.open(/^https?:\/\//i.test(website) ? website : `https://${website}`, '_blank');
                } else {
                    document.querySelector('[data-tab="about-company"]').click();
                }
            });
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
        wireTabs();
        wireActions();
        enforceFresherJourney().then(allowed => {
            if (allowed) loadApplications().then(loadJob);
        });
    </script>
@endpush
