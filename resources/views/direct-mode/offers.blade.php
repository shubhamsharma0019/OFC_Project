@php
    $user = $user ?? ['name' => 'Ananya Gupta', 'avatar' => '/student.svg', 'notifications' => 3];
@endphp

@php $activePage = 'offers'; @endphp

@extends('layouts.direct-mode')

@section('title', 'Offers - Direct Mode')

@push('styles')
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:#f7fbff;font-weight:500}a{text-decoration:none;color:inherit}button,input{font:inherit}.shell{min-height:100vh;display:grid;grid-template-columns:224px minmax(0,1fr);background:linear-gradient(135deg,#fbfdff,#f1f7ff)}.sidebar{background:#fff;border-right:1px solid #d8e4f7;display:flex;flex-direction:column}.brand{height:76px;display:flex;align-items:center;padding:0 28px;border-bottom:1px solid #d8e4f7}.brand img{width:200px}.menu{padding:30px 14px 12px;display:grid;gap:9px}.menu-item{height:46px;border-radius:8px;display:flex;align-items:center;gap:17px;padding:0 18px;font-size:14px;font-weight:700;position:relative;color:#06123f}.menu-item.active{background:#eaf2ff;color:#064cff}.menu-item.active:before{content:"";position:absolute;left:0;top:11px;bottom:11px;width:3px;background:#064cff;border-radius:6px}.icon{width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg,.metric-icon svg,.side-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.boost{margin:31px 18px 18px;padding:20px;border-radius:9px;background:#eef5ff;text-align:center}.rocket{height:105px;position:relative}.rocket:before{content:"";position:absolute;left:46px;top:17px;width:70px;height:70px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg)}.rocket:after{content:"";position:absolute;left:26px;right:15px;bottom:6px;height:21px;border-radius:50%;background:#dce8ff}.boost h3{margin:0 0 10px;font-size:15px;line-height:1.25}.boost p{margin:0 0 16px;font-size:13px;line-height:1.35;color:#26375e}.primary{height:34px;border:1px solid #064cff;border-radius:6px;background:#064cff;color:#fff;font-size:13px;font-weight:800;padding:0 21px;cursor:pointer}.main{min-width:0;display:grid;grid-template-rows:76px 1fr auto}.topbar{background:#fff;border-bottom:1px solid #d8e4f7;display:grid;grid-template-columns:54px minmax(320px,560px) 1fr;align-items:center;gap:30px;padding:0 30px}.hamb{font-size:25px}.search-top{height:46px;border:1px solid #cbd8ee;border-radius:7px;background:#fbfdff;display:flex;align-items:center;gap:14px;padding:0 16px;color:#26375e}.search-top input{border:0;outline:0;background:transparent;width:100%}.user{justify-self:end;display:flex;align-items:center;gap:19px}.bell{position:relative;border:0;background:transparent;color:#06123f;padding:0}.bell b{position:absolute;right:-8px;top:-11px;background:#064cff;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;display:grid;place-items:center}.avatar{width:48px;height:48px;border-radius:50%;border:5px solid #e6eefb;background:url('{{ $user['avatar'] }}') center top/cover}.page{padding:24px 28px 16px}.welcome{margin:0 0 16px 4px}.welcome small{font-size:13px}.welcome h1{margin:4px 0 0;font-size:21px}.layout{display:grid;grid-template-columns:minmax(0,1fr) 322px;gap:16px}.card{background:rgba(255,255,255,.92);border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.main-card{padding:17px}.title h2{margin:0 0 10px;font-size:25px}.title p{margin:0 0 16px;color:#43517b;font-size:14px}.metrics{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:16px}.metric{height:92px;border:1px solid #d8e4f7;border-radius:10px;background:#fff;display:grid;grid-template-columns:50px 1fr;align-items:center;gap:14px;padding:16px}.metric-icon,.side-icon{width:46px;height:46px;border-radius:50%;display:grid;place-items:center}.green-soft{background:#e8f8ef;color:#0da65c}.blue-soft{background:#eaf2ff;color:#064cff}.purple-soft{background:#efe7ff;color:#6c3ad7}.orange-soft{background:#fff2df;color:#f07800}.red-soft{background:#fff0f1;color:#e01e37}.metric strong{display:block;font-size:22px}.metric b{display:block;font-size:12px}.metric span{display:block;color:#43517b;font-size:11px}.tabs{height:48px;border:1px solid #d8e4f7;border-radius:10px 10px 0 0;background:#fff;display:grid;grid-template-columns:repeat(4,1fr);overflow:hidden}.tab{border:0;background:transparent;color:#34436f;font-size:13px;font-weight:700;position:relative}.tab.active{color:#064cff}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#064cff}.offer-card{border:1px solid #d8e4f7;border-top:0;border-radius:0 0 10px 10px;background:#fff;padding:20px}.offer-head{display:grid;grid-template-columns:72px minmax(0,1fr) 110px;gap:18px;align-items:center}.logo{width:66px;height:66px;border-radius:8px;color:#fff;display:grid;place-items:center;text-align:center;font-weight:900}.logo strong{font-size:28px;line-height:.9}.logo span{font-size:11px}.navy{background:#102d68}.orange{background:linear-gradient(135deg,#ff8b29,#ff4d08)}.black{background:#181b21}.offer-info h3{margin:0 0 8px;font-size:16px}.offer-info p{margin:0 0 13px;font-size:13px}.meta{display:flex;gap:28px;flex-wrap:wrap;color:#536188;font-size:12px}.status{text-align:right}.pill{height:25px;border-radius:5px;display:inline-grid;place-items:center;font-size:12px;font-weight:800;padding:0 13px}.pill.green{border:1px solid #bde6ce;background:#e8f8ef;color:#008a35}.pill.purple{border:1px solid #d7c7ff;background:#efe7ff;color:#6c3ad7}.pill.gray{border:1px solid #d9deea;background:#f2f5fa;color:#43517b}.status small{display:block;color:#43517b;margin-top:12px}.offer-grid{display:grid;grid-template-columns:1.15fr .9fr;gap:8px;margin-top:18px}.box{border:1px solid #d8e4f7;border-radius:10px;padding:16px}.box h3{margin:0 0 16px;font-size:14px}.detail-row{display:grid;grid-template-columns:1fr 1.1fr;gap:10px;margin:12px 0;font-size:12px}.detail-row span{color:#536188}.detail-row b{font-size:12px}.red-text{color:#ff3045}.progress{display:grid;gap:20px}.step{display:grid;grid-template-columns:18px 1fr auto;gap:12px;align-items:center;font-size:12px;color:#536188}.dot{width:13px;height:13px;border-radius:50%;border:1px solid #b8c7de;background:#fff}.step.done .dot{background:#0da65c;border-color:#0da65c}.step.active .dot{border:3px solid #064cff}.step b{color:#06123f}.actions{display:flex;justify-content:space-between;gap:20px;margin-top:16px}.outline{height:34px;border:1px solid #064cff;border-radius:6px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 18px;display:inline-flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap}.other-title{font-size:14px;margin:18px 0 10px}.other{border:1px solid #d8e4f7;border-radius:10px;background:#fff;display:grid}.other-row{display:grid;grid-template-columns:72px 1fr 128px 20px;gap:18px;align-items:center;padding:16px 20px;border-bottom:1px solid #e7edf7}.other-row:last-child{border-bottom:0}.side{display:grid;gap:16px}.side-card{padding:20px}.side-card h2{margin:0 0 18px;font-size:17px}.summary-list{display:grid;gap:8px}.summary-row{height:68px;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:52px 1fr 18px;gap:12px;align-items:center;padding:11px}.summary-row strong{display:block;font-size:17px}.summary-row span{font-size:12px;color:#43517b}.next{display:grid;gap:20px;margin:24px 0}.next-row{display:grid;grid-template-columns:44px 1fr;gap:14px;align-items:center}.next-row h3{margin:0 0 7px;font-size:13px}.next-row p{margin:0;color:#43517b;font-size:12px;line-height:1.4}.docs{display:grid;gap:7px}.doc{height:50px;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:34px 1fr 22px;gap:10px;align-items:center;padding:8px 12px}.doc h3{margin:0 0 4px;font-size:13px}.doc p{margin:0;color:#43517b;font-size:11px}.footer{height:58px;border-top:1px solid #d8e4f7;background:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 32px;font-size:13px;color:#26375e}.footer nav{display:flex;gap:26px}.footer i{height:16px;width:1px;background:#7d8aaa}@media(max-width:1220px){.shell{grid-template-columns:1fr}.sidebar{display:none}.layout{grid-template-columns:1fr}.topbar{grid-template-columns:44px 1fr}.user{grid-column:2;justify-self:end}.metrics{grid-template-columns:repeat(2,1fr)}}@media(max-width:760px){.topbar{height:auto;grid-template-columns:1fr;padding:14px}.hamb{display:none}.user{grid-column:auto;justify-self:start}.page{padding:14px}.metrics,.offer-head,.offer-grid,.other-row{grid-template-columns:1fr}.status{text-align:left}.actions,.footer,.footer nav{height:auto;flex-direction:column;align-items:flex-start;gap:12px}.footer{padding:16px}.footer i{display:none}}
body{height:100vh!important;overflow:hidden!important}.shell{height:100vh!important;min-height:0!important;overflow:hidden!important;grid-template-columns:250px minmax(0,1fr)!important}.sidebar{position:sticky!important;top:0!important;height:100vh!important;overflow:hidden!important;justify-content:space-between!important}.menu{max-height:calc(100vh - 300px)!important;overflow-y:auto!important}.main{height:100vh!important;overflow-y:auto!important;grid-template-rows:82px minmax(0,max-content)!important}.topbar{position:sticky!important;top:0!important;z-index:20!important;height:82px!important;grid-template-columns:1fr minmax(320px,603px) 1fr!important;padding:0 38px!important}.footer{display:none!important}.page{min-width:0;padding:24px 28px 32px!important}.layout{grid-template-columns:minmax(0,1fr) minmax(300px,322px)!important;align-items:start}.main-card,.side-card,.offer-card,.other{max-width:100%;overflow:hidden}.metrics{grid-template-columns:repeat(4,minmax(0,1fr))}.metric{min-width:0;grid-template-columns:46px minmax(0,1fr);gap:12px;padding:14px}.metric div,.summary-row div,.doc div,.next-row div,.offer-info{min-width:0}.metric b,.metric span,.summary-row strong,.summary-row span,.doc h3,.doc p,.next-row h3,.next-row p,.offer-info h3,.offer-info p{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.offer-head{grid-template-columns:72px minmax(0,1fr) 126px}.meta{gap:14px}.meta span{display:inline-flex;align-items:center;gap:5px;min-width:0}.offer-grid{grid-template-columns:minmax(0,1.05fr) minmax(0,.95fr);gap:12px}.box{min-width:0}.detail-row{grid-template-columns:minmax(120px,.9fr) minmax(0,1.1fr)}.detail-row b{min-width:0;overflow-wrap:anywhere}.actions{justify-content:flex-start;flex-wrap:wrap;gap:10px}.actions .outline,.actions .primary{min-width:150px}.actions .outline:first-child{min-width:205px}.other-row{grid-template-columns:72px minmax(0,1fr) 132px 22px}.status{min-width:0}.status small{overflow-wrap:anywhere}.summary-row{grid-template-columns:48px minmax(0,1fr) 18px}.side{min-width:0}@media(max-width:1360px){.layout{grid-template-columns:1fr!important}.side{grid-template-columns:repeat(3,minmax(0,1fr));align-items:start}.offer-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:980px){.metrics{grid-template-columns:repeat(2,minmax(0,1fr))!important}.side{grid-template-columns:1fr}.offer-head,.other-row{grid-template-columns:64px minmax(0,1fr) 126px}.other-row>.icon{display:none}.offer-grid{grid-template-columns:1fr}.tabs{grid-template-columns:repeat(4,minmax(120px,1fr));overflow-x:auto}.status{text-align:left}}@media(max-width:640px){.metrics,.offer-head,.other-row{grid-template-columns:1fr!important}.metric b,.metric span,.offer-info h3,.offer-info p,.summary-row strong,.summary-row span,.doc h3,.doc p,.next-row h3,.next-row p{white-space:normal}.actions .outline,.actions .primary,.actions .outline:first-child{width:100%;min-width:0}.detail-row{grid-template-columns:1fr}.tabs{grid-template-columns:repeat(2,minmax(140px,1fr))}}
.empty{border:1px dashed #cbd8ee;border-radius:10px;background:#fbfdff;padding:26px;text-align:center;color:#43517b}.alert{display:none;margin:0 0 14px;padding:11px 13px;border-radius:8px;border:1px solid #bcd3ff;background:#eef5ff;color:#06123f;font-size:13px;font-weight:700}.alert.show{display:block}.logo img{width:100%;height:100%;object-fit:cover;border-radius:8px}.tab{cursor:pointer}.tab-count{font-size:11px;color:#657197;margin-left:4px}.pill.orange{border:1px solid #ffd4a1;background:#fff2df;color:#f07800}.pill.red{border:1px solid #ffb8bd;background:#fff0f1;color:#e01e37}.primary[disabled],.outline[disabled]{opacity:.65;cursor:not-allowed}
</style>
@endpush

@section('content')
<section class="page">
                <div class="welcome"><small>Welcome back,</small><h1 data-user-name>{{ $user['name'] }}!</h1></div>
                <div class="layout">
                    <section class="card main-card">
                        <div class="alert" data-alert></div>
                        <div class="title"><h2>Offers</h2><p>Track and manage your job offers</p></div>
                        <div class="metrics" data-metrics></div>
                        <div class="tabs"><button class="tab active" data-status="active" type="button">Active Offer</button><button class="tab" data-status="accepted" type="button">Accepted</button><button class="tab" data-status="declined" type="button">Declined</button><button class="tab" data-status="expired" type="button">Expired</button></div>
                        <div data-active-offer><article class="offer-card"><div class="empty">Loading offers...</div></article></div>
                        <h3 class="other-title">Other Offers</h3><div class="other" data-other-offers><div class="empty">Loading other offers...</div></div>
                    </section>
                    <aside class="side">
                        <article class="card side-card"><h2>Offer Summary</h2><div class="summary-list" data-summary></div></article>
                        <article class="card side-card"><h2>Next Steps</h2><div class="next" data-next-steps></div><button class="outline" data-onboarding type="button" style="width:100%">View Onboarding Guide</button></article>
                        <article class="card side-card"><h2>Important Documents</h2><div class="docs" data-documents></div></article>
                    </aside>
                </div>
            </section>
@endsection

@push('scripts')
<script>
        const icons={home:'<svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"></path><path d="M5 10v10h14V10"></path></svg>',user:'<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',clipboard:'<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 7h6M9 12h6"></path></svg>',briefcase:'<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',clock:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>',chart:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',activity:'<svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',settings:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path></svg>',logout:'<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5M21 12H9"></path></svg>',search:'<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',bell:'<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',chevron:'<svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>','chevron-right':'<svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"></path></svg>',pin:'<svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>','check-circle':'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>',x:'<svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg>',money:'<svg viewBox="0 0 24 24"><path d="M12 3c4 4 7 8 7 12a7 7 0 0 1-14 0c0-4 3-8 7-12Z"></path><path d="M9 14h6M12 11v6"></path></svg>',hourglass:'<svg viewBox="0 0 24 24"><path d="M6 2h12M6 22h12M7 2c0 6 10 6 10 12s-10 6-10 12"></path><path d="M17 2c0 6-10 6-10 12s10 6 10 12"></path></svg>',download:'<svg viewBox="0 0 24 24"><path d="M12 3v12"></path><path d="m7 10 5 5 5-5"></path><path d="M5 21h14"></path></svg>',circle:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="6"></circle></svg>'};
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => Array.from(document.querySelectorAll(selector));
        const token = localStorage.getItem('onlyfreshers_token') || '';
        let authUser = {};
        try { authUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || '{}'); } catch (error) { authUser = {}; }
        const state = {
            applications: [],
            offers: [],
            activeTab: 'active',
            localStatuses: JSON.parse(localStorage.getItem('onlyfreshers_offer_statuses') || '{}'),
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

        function salaryNumber(app) {
            const numbers = String(job(app).salary || '').match(/\d+(\.\d+)?/g);
            if (!numbers) return 0;
            const value = Number(numbers[numbers.length - 1]);
            return String(job(app).salary || '').toLowerCase().includes('lpa') ? value * 100000 : value;
        }

        function formatMoney(value) {
            return value ? `Rs ${Math.round(value).toLocaleString('en-IN')}` : 'Not disclosed';
        }

        function offerStatus(app) {
            const local = state.localStatuses[app.id];
            if (local) return local;
            const raw = String(app.application_status || '').toLowerCase();
            if (raw === 'hired' || raw === 'offered') return 'active';
            if (raw === 'accepted') return 'accepted';
            if (raw === 'rejected') return 'declined';
            return 'active';
        }

        function offerDate(app) {
            return app.updated_at || app.applied_at || app.created_at;
        }

        function validTill(app) {
            const date = new Date(offerDate(app) || Date.now());
            date.setDate(date.getDate() + 7);
            return date;
        }

        function logoText(app) {
            return companyName(app).split(/\s+/).filter(Boolean).slice(0, 2).map(word => word[0]).join('').toUpperCase() || 'OF';
        }

        function logoHtml(app) {
            const logo = company(app).company_logo;
            return logo ? `<img src="${escapeAttr(logo)}" alt="${escapeAttr(companyName(app))}">` : `<div><strong>${escapeHtml(logoText(app))}</strong><span>${escapeHtml(companyName(app).slice(0, 8))}</span></div>`;
        }

        function statusLabel(status) {
            return { active: 'Active Offer', accepted: 'Accepted', declined: 'Declined', expired: 'Expired' }[status] || 'Active Offer';
        }

        function statusTone(status) {
            return { active: 'green', accepted: 'purple', declined: 'red', expired: 'gray' }[status] || 'green';
        }

        function deriveOffers() {
            const offerStatuses = ['hired', 'offered', 'accepted'];
            state.offers = state.applications
                .filter(app => offerStatuses.includes(String(app.application_status || '').toLowerCase()) || state.localStatuses[app.id])
                .map(app => ({ app, status: offerStatus(app) }));
        }

        function render() {
            deriveOffers();
            renderMetrics();
            renderActiveOffer();
            renderOtherOffers();
            renderSummary();
            renderNextSteps();
            renderDocuments();
            renderTabCounts();
        }

        function renderMetrics() {
            const count = status => state.offers.filter(item => item.status === status).length;
            const items = [
                [count('active'), 'Active Offer', count('active') ? 'Congratulations!' : 'No active offer', 'briefcase', 'green-soft'],
                [0, 'Pending Offers', 'Awaiting response', 'clock', 'orange-soft'],
                [count('accepted'), 'Accepted Offers', count('accepted') ? 'Great choice!' : 'Not accepted yet', 'check-circle', 'purple-soft'],
                [count('declined'), 'Declined Offers', count('declined') ? 'Declined by you' : 'None declined', 'x', 'red-soft'],
            ];
            $('[data-metrics]').innerHTML = items.map(([value, title, sub, icon, tone]) => `<div class="metric"><span class="metric-icon ${tone}" data-icon="${icon}"></span><div><strong>${value}</strong><b>${title}</b><span>${sub}</span></div></div>`).join('');
            hydrateIcons($('[data-metrics]'));
        }

        function renderActiveOffer() {
            const visible = state.offers.filter(item => item.status === state.activeTab);
            const target = $('[data-active-offer]');
            if (!visible.length) {
                target.innerHTML = `<article class="offer-card"><div class="empty">No ${escapeHtml(statusLabel(state.activeTab).toLowerCase())} found.</div></article>`;
                return;
            }
            target.innerHTML = offerCard(visible[0].app, visible[0].status);
            hydrateIcons(target);
            bindOfferActions(target);
        }

        function offerCard(app, status) {
            const j = job(app);
            const valid = validTill(app);
            const daysLeft = Math.ceil((valid - new Date()) / 86400000);
            return `
                <article class="offer-card" data-app-id="${app.id}" data-job-id="${j.id || ''}">
                    <div class="offer-head"><div class="logo navy">${logoHtml(app)}</div><div class="offer-info"><h3>${escapeHtml(j.title || 'Job Offer')}</h3><p>${escapeHtml(companyName(app))}</p><div class="meta"><span><span class="icon" data-icon="pin"></span>${escapeHtml(j.location || 'Location not shared')}</span><span><span class="icon" data-icon="briefcase"></span>${escapeHtml((j.job_type || 'Full Time').replace('_', ' '))}</span><span>${escapeHtml(j.salary || 'Salary not disclosed')}</span></div></div><div class="status"><span class="pill ${statusTone(status)}">${escapeHtml(statusLabel(status))}</span><small>Offered on<br><b>${escapeHtml(formatDate(offerDate(app)))}</b></small></div></div>
                    <div class="offer-grid"><div class="box"><h3>Offer Details</h3>${detailRow('Role', j.title || 'Not shared')}${detailRow('Employment Type', (j.job_type || 'Full Time').replace('_', ' '))}${detailRow('Openings', j.openings || 'Not shared')}${detailRow('CTC Offered', j.salary || 'Not disclosed')}${detailRow('Joining Date', 'Shared by company after acceptance')}${detailRow('Offer Valid Till', `${formatDate(valid)} ${daysLeft >= 0 ? `(${daysLeft} days left)` : '(expired)'}`)}</div><div class="box"><h3>Offer Progress</h3><div class="progress">${progressStep('Offer Extended', formatDate(offerDate(app)), true)}${progressStep('Offer Under Review', formatDate(offerDate(app)), status === 'active')}${progressStep('Offer Accepted', status === 'accepted' ? formatDate(new Date()) : 'Pending', status === 'accepted')}${progressStep('Joined', 'Pending', false)}</div></div></div>
                    <div class="actions"><button class="outline" data-download type="button"><span class="icon" data-icon="download"></span>Download Offer Letter</button><button class="outline" data-more-time type="button">Request More Time</button><button class="primary" data-accept type="button" ${status !== 'active' ? 'disabled' : ''}>${status === 'accepted' ? 'Accepted' : 'Accept Offer'}</button></div>
                </article>`;
        }

        function renderOtherOffers() {
            const items = state.offers.filter((item, index) => index > 0 || item.status !== state.activeTab);
            const wrap = $('[data-other-offers]');
            if (!items.length) {
                wrap.innerHTML = '<div class="empty">No other offers yet.</div>';
                return;
            }
            wrap.innerHTML = items.map(({ app, status }) => {
                const j = job(app);
                return `<div class="other-row" data-job-id="${j.id || ''}"><div class="logo navy">${logoHtml(app)}</div><div class="offer-info"><h3>${escapeHtml(j.title || 'Job Offer')}</h3><p>${escapeHtml(companyName(app))}</p><div class="meta"><span><span class="icon" data-icon="pin"></span>${escapeHtml(j.location || 'Location')}</span><span><span class="icon" data-icon="briefcase"></span>${escapeHtml((j.job_type || 'Full Time').replace('_', ' '))}</span><span>${escapeHtml(j.salary || 'Salary not disclosed')}</span></div></div><div class="status"><span class="pill ${statusTone(status)}">${escapeHtml(statusLabel(status))}</span><small>${escapeHtml(statusLabel(status))} on ${escapeHtml(formatDate(offerDate(app)))}</small></div><span class="icon" data-icon="chevron-right"></span></div>`;
            }).join('');
            hydrateIcons(wrap);
            wrap.querySelectorAll('.other-row').forEach(row => row.addEventListener('click', () => {
                if (row.dataset.jobId) window.location.href = `/direct-mode/jobs/${row.dataset.jobId}`;
            }));
        }

        function renderSummary() {
            const salaries = state.offers.map(({ app }) => salaryNumber(app)).filter(Boolean);
            const highest = salaries.length ? Math.max(...salaries) : 0;
            const average = salaries.length ? salaries.reduce((sum, value) => sum + value, 0) / salaries.length : 0;
            const items = [
                [formatMoney(highest), 'Highest Offer', 'money', 'green-soft'],
                [state.offers.filter(item => item.status === 'active').length, 'Active Offer', 'briefcase', 'blue-soft'],
                [formatMoney(average), 'Average CTC', 'hourglass', 'purple-soft'],
            ];
            $('[data-summary]').innerHTML = items.map(([value, label, icon, tone]) => `<div class="summary-row"><span class="side-icon ${tone}" data-icon="${icon}"></span><div><strong>${escapeHtml(value)}</strong><span>${escapeHtml(label)}</span></div><span class="icon" data-icon="chevron-right"></span></div>`).join('');
            hydrateIcons($('[data-summary]'));
        }

        function renderNextSteps() {
            const steps = [
                ['Review Offer Letter', 'Go through offer details, CTC, role and validity.', 'green-soft'],
                ['Accept the Offer', 'Accept active offer before the validity date.', 'blue-soft'],
                ['Complete Onboarding', 'Submit required documents after acceptance.', 'orange-soft'],
            ];
            $('[data-next-steps]').innerHTML = steps.map(([title, text, tone]) => `<div class="next-row"><span class="side-icon ${tone}" data-icon="circle"></span><div><h3>${title}</h3><p>${text}</p></div></div>`).join('');
            hydrateIcons($('[data-next-steps]'));
        }

        function renderDocuments() {
            const docs = [
                ['Offer Letter', state.offers.length ? 'Generated from selected offer' : 'Available after offer'],
                ['Compensation Details', 'Based on offered salary/CTC'],
                ['Company Policy', 'Provided by company during onboarding'],
            ];
            $('[data-documents]').innerHTML = docs.map(([title, text]) => `<div class="doc"><span class="side-icon blue-soft" data-icon="file"></span><div><h3>${title}</h3><p>${text}</p></div><span class="icon" data-icon="download"></span></div>`).join('');
            hydrateIcons($('[data-documents]'));
        }

        function renderTabCounts() {
            $$('.tab').forEach(tab => {
                const status = tab.dataset.status;
                const label = tab.textContent.replace(/\s*\d+$/, '').replace(/\s*\(.+\)$/, '');
                tab.innerHTML = `${label} <span class="tab-count">${state.offers.filter(item => item.status === status).length}</span>`;
            });
        }

        function bindOfferActions(root) {
            root.querySelector('[data-download]')?.addEventListener('click', () => showAlert('Offer letter document backend me upload hote hi download available hoga.'));
            root.querySelector('[data-more-time]')?.addEventListener('click', () => showAlert('More time request company ko send karne ke liye backend endpoint required hai.'));
            root.querySelector('[data-accept]')?.addEventListener('click', event => {
                const appId = event.currentTarget.closest('[data-app-id]').dataset.appId;
                state.localStatuses[appId] = 'accepted';
                localStorage.setItem('onlyfreshers_offer_statuses', JSON.stringify(state.localStatuses));
                showAlert('Offer accepted locally. Backend accept-offer API add hote hi server me bhi sync hoga.');
                render();
            });
        }

        function detailRow(label, value) {
            return `<div class="detail-row"><span>${escapeHtml(label)}</span><b>${escapeHtml(value)}</b></div>`;
        }

        function progressStep(title, value, active) {
            return `<div class="step ${active ? 'active' : ''} ${title === 'Offer Extended' ? 'done' : ''}"><span class="dot"></span><b>${escapeHtml(title)}</b><span>${escapeHtml(value)}</span></div>`;
        }

        async function loadOffers() {
            if (!token) {
                render();
                $('[data-active-offer]').innerHTML = '<article class="offer-card"><div class="empty">Offers dekhne ke liye pehle login karein.</div></article>';
                return;
            }
            try {
                const response = await fetch('/api/fresher/applications', { headers: headers() });
                const payload = await response.json();
                if (!response.ok || payload.success === false) throw new Error(payload.message || 'Offers load nahi ho pa rahe.');
                state.applications = payload.data?.applications || [];
                render();
            } catch (error) {
                render();
                $('[data-active-offer]').innerHTML = `<article class="offer-card"><div class="empty">${escapeHtml(error.message)}</div></article>`;
            }
        }

        function wireControls() {
            $$('.tab').forEach(tab => tab.addEventListener('click', () => {
                $$('.tab').forEach(item => item.classList.remove('active'));
                tab.classList.add('active');
                state.activeTab = tab.dataset.status;
                renderActiveOffer();
            }));
            $('[data-onboarding]').addEventListener('click', () => window.location.href = '/direct-mode/profile');
            const headerSearch = document.querySelector('.search-top input');
            if (headerSearch) {
                headerSearch.addEventListener('keydown', event => {
                    if (event.key === 'Enter' && headerSearch.value.trim()) {
                        window.location.href = `/direct-mode/jobs?search=${encodeURIComponent(headerSearch.value.trim())}`;
                    }
                });
            }
        }

        function showAlert(message) {
            const alert = $('[data-alert]');
            alert.textContent = message;
            alert.classList.add('show');
            setTimeout(() => alert.classList.remove('show'), 3500);
        }

        function updateUserChrome() {
            const name = authUser.name || 'Fresher';
            $('[data-user-name]').textContent = `${name}!`;
            const topUser = document.querySelector('.top-user strong, .user strong');
            if (topUser) topUser.textContent = name;
        }

        function formatDate(raw) {
            if (!raw) return 'Not shared';
            return new Date(raw).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
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
        loadOffers();
    </script>
@endpush


