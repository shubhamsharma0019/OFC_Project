@php
    $activePage = 'assessments';
    $tabs = [
        ['key' => 'all', 'label' => 'All Assessments'],
        ['key' => 'technical', 'label' => 'Technical Skills'],
        ['key' => 'aptitude', 'label' => 'Aptitude'],
        ['key' => 'communication', 'label' => 'Communication'],
        ['key' => 'completed', 'label' => 'Completed'],
    ];
@endphp

@extends('layouts.direct-mode')

@section('title', 'Flow Selection - Direct Mode')

@push('styles')
<style>
    .assess-page{padding:25px 26px 30px;background:linear-gradient(135deg,#fbfdff,#f0f6ff);min-height:calc(100vh - 82px)}.welcome{margin:0 0 12px 18px}.welcome small{font-size:13px}.welcome h1{margin:5px 0 0;font-size:22px}.panel{border:1px solid #d8e4f7;border-radius:16px;background:rgba(255,255,255,.74);padding:17px;box-shadow:0 18px 38px rgba(6,25,66,.04);overflow:hidden}.hero{display:grid;grid-template-columns:minmax(0,1fr) repeat(3,minmax(190px,242px));gap:12px;align-items:center;margin-bottom:12px}.hero-title{padding-left:9px}.hero-title h2{font-size:30px;margin:0 0 13px}.hero-title p{margin:0;color:#26375e;font-size:15px}.stat{height:98px;border:1px solid #d8e4f7;border-radius:12px;background:#fff;display:grid;grid-template-columns:58px minmax(0,1fr);align-items:center;gap:14px;padding:18px}.stat-icon,.tip-icon{width:50px;height:50px;border-radius:12px;display:grid;place-items:center}.stat-icon svg,.tip-icon svg,.sq svg,.medal svg{width:22px;height:22px;fill:none!important;stroke:currentColor!important;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}.green{background:#e6f7ed;color:#15a65d}.purple{background:#efe7ff;color:#844bea}.orange{background:#fff1df;color:#f3a334}.blue{background:#eaf2ff;color:#064cff}.stat h3{margin:0 0 6px;font-size:13px}.stat strong{display:block;font-size:28px;line-height:1}.stat span{font-size:12px;color:#008a35;font-weight:800}.tabs{height:46px;width:735px;max-width:100%;border:1px solid #d8e4f7;border-radius:8px;background:#fff;display:grid;grid-template-columns:repeat(5,minmax(0,1fr));overflow:hidden;margin:8px 0 16px}.tab{border:0;background:transparent;color:#17234f;font-size:14px;position:relative;cursor:pointer}.tab.active{color:#064cff;font-weight:800}.tab.active:after{content:"";position:absolute;left:0;right:0;bottom:0;height:2px;background:#064cff}.content-grid{display:grid;grid-template-columns:minmax(0,1fr) 388px;gap:18px}.card{background:#fff;border:1px solid #d8e4f7;border-radius:13px;box-shadow:0 16px 32px rgba(6,25,66,.04)}.card h2{margin:0;font-size:17px}.overview{padding:22px;display:grid;grid-template-columns:235px 1px 1fr;gap:38px;align-items:center}.divider{height:225px;background:#d8e4f7}.ring-wrap{text-align:center}.ring{width:134px;height:134px;border-radius:50%;background:conic-gradient(#0b59ff 0 var(--value,0%),#dfe7f5 var(--value,0%));display:grid;place-items:center;position:relative;margin:18px auto 14px}.ring:before{content:"";position:absolute;inset:17px;background:#fff;border-radius:50%}.ring strong{position:relative;font-size:30px}.ring-wrap h3{margin:0 0 8px;font-size:16px}.ring-wrap b{color:#008a35;font-size:15px}.skill-box h3{font-size:15px;margin:0 0 24px}.skill{display:grid;grid-template-columns:130px 1fr 42px;align-items:center;gap:20px;margin:22px 0;font-size:14px}.bar{height:7px;border-radius:20px;background:#e4ebf6;overflow:hidden}.bar span{display:block;height:100%;background:#0b59ff;border-radius:inherit}.outline{height:40px;border:1px solid #064cff;border-radius:7px;background:#fff;color:#064cff;font-size:13px;font-weight:800;padding:0 18px;cursor:pointer}.outline:disabled,.primary:disabled{opacity:.65;cursor:not-allowed}.table-card{margin-top:14px;padding:17px 20px}.card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}.card-head a{font-size:13px;color:#064cff;font-weight:800}.table{border:1px solid #d8e4f7;border-radius:8px;overflow-x:auto}.row{display:grid;grid-template-columns:1.65fr 1fr .6fr .8fr 1fr .9fr;align-items:center;min-height:58px;border-bottom:1px solid #e8eef8;padding:0 12px;font-size:12px;min-width:860px}.row:last-child{border-bottom:0}.head{background:#fbfdff;font-weight:800;min-height:32px}.assessment{display:flex;align-items:center;gap:11px}.sq{width:32px;height:32px;border-radius:6px;color:#fff;display:grid;place-items:center}.sq.blue{background:#2567f5}.sq.green{background:#20ad62}.sq.purple{background:#8c63ee}.assessment strong{display:block;font-size:13px}.assessment span,.muted{color:#3d4c77}.badge{width:82px;height:26px;border:1px solid #bde6ce;border-radius:5px;background:#e8f8ef;color:#008a35;display:grid;place-items:center;font-weight:800;font-size:11px}.side{display:grid;gap:14px}.side-card{padding:22px}.recommend{min-height:164px;border:1px solid #cce3dc;border-radius:10px;background:linear-gradient(135deg,#eff9f3,#f8fbff);display:grid;grid-template-columns:80px 1fr;align-items:center;gap:18px;padding:18px;margin-top:18px}.medal{width:70px;height:70px;border-radius:50%;background:#bfeccc;color:#21aa60;display:grid;place-items:center}.recommend h3{margin:0 0 9px;font-size:17px}.recommend p{margin:0 0 18px;color:#3d4c77;font-size:13px;line-height:1.4}.tips{display:grid;gap:22px;margin:24px 0}.tip{display:grid;grid-template-columns:48px 1fr;gap:12px;align-items:center}.tip h3{margin:0 0 6px;font-size:13px}.tip p{margin:0;color:#3d4c77;font-size:13px}.center{display:flex;justify-content:center}.assessment-runner{display:none;margin-bottom:16px;padding:20px}.assessment-runner.active{display:block}.question{border:1px solid #d8e4f7;border-radius:10px;padding:16px;margin:12px 0}.question h3{margin:0 0 12px;font-size:14px}.options{display:grid;gap:9px}.option{border:1px solid #d8e4f7;border-radius:8px;padding:10px 12px;display:flex;gap:10px;align-items:center;cursor:pointer}.empty,.alert{padding:16px;color:#3d4c77;font-size:13px}.alert{display:none;margin-bottom:12px;border-radius:9px;font-weight:800}.alert.error{display:block;background:#fff1f2;border:1px solid #ffd0d7;color:#c8102e}.alert.success{display:block;background:#ecfdf3;border:1px solid #baf0ce;color:#087443}@media(max-width:1250px){.hero{grid-template-columns:1fr}.content-grid{grid-template-columns:1fr}.row{min-width:760px}}@media(max-width:760px){.assess-page{padding:14px}.overview{grid-template-columns:1fr}.divider{display:none}.tabs{grid-template-columns:1fr;height:auto}.tab{height:42px}.recommend{grid-template-columns:1fr}}
</style>
<style>
    .tabs{min-height:46px!important;height:auto!important}.tab{min-width:0!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:7px!important;padding:0 10px!important;white-space:nowrap!important}.tab b{min-width:20px;height:20px;border-radius:999px;background:#eef4ff;color:#064cff;display:none;place-items:center;font-size:11px;line-height:20px}.tab.has-count b{display:grid}.tab span{overflow:hidden;text-overflow:ellipsis}.tab.active b{background:#064cff;color:#fff}
    .content-grid{grid-template-columns:1fr!important}.side{display:none!important}.stat{min-width:0!important;grid-template-columns:64px minmax(0,1fr)!important;gap:16px!important;overflow:hidden!important;align-items:center!important;justify-items:start!important}.stat-icon{width:54px!important;height:54px!important;align-self:center!important;justify-self:center!important;display:grid!important;place-items:center!important;padding:0!important;line-height:0!important;margin:auto!important;background:#eef5ff!important;color:#0b63f6!important;border:1px solid #d9e8ff!important;box-shadow:inset 0 1px 0 rgba(255,255,255,.9),0 10px 22px rgba(11,99,246,.08)!important}.stat-icon svg{width:22px!important;height:22px!important;display:block!important;margin:0!important;position:relative!important;top:0!important;left:0!important;transform:none!important;vertical-align:middle!important}.stat div{min-width:0!important;overflow:hidden!important}.stat h3{white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important}.stat strong{font-size:clamp(24px,1.9vw,30px)!important;line-height:1!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:clip!important}.stat span{display:block!important;white-space:nowrap!important;overflow:hidden!important;text-overflow:ellipsis!important;line-height:1.2!important}
    body .sidebar,body .topbar,body [data-mobile-direct-nav]{display:none!important}
    body .shell{grid-template-columns:1fr!important}
    body .main{height:100vh!important;grid-template-rows:minmax(0,max-content)!important}
    body .assess-page{min-height:100vh!important;padding:24px 26px 34px!important}
    body .welcome{display:none!important}
    body .panel{width:100%;max-width:none;margin:0}
    @media(max-width:760px){body .assess-page{padding:14px!important}}
</style>
@endpush

@section('content')
<section class="assess-page">
    <div class="welcome"><small>Welcome back,</small><h1 data-user-name>Fresher!</h1></div>
    <div class="alert" data-alert></div>
    <div class="panel">
        <div class="hero">
            <div class="hero-title"><h2>Choose Your Flow</h2><p>Complete the initial check, then choose Jobs, Internships or Fast Track Mode.</p></div>
            <article class="stat"><span class="stat-icon green" data-icon="users"></span><div><h3>Assessments Taken</h3><strong data-stat="taken">0</strong><span data-note="taken">Not started</span></div></article>
            <article class="stat"><span class="stat-icon purple" data-icon="calendar"></span><div><h3>Average Score</h3><strong data-stat="score">0%</strong><span data-note="score">Pending</span></div></article>
            <article class="stat"><span class="stat-icon orange" data-icon="trophy"></span><div><h3>Rank</h3><strong data-stat="rank">Top 100%</strong><span data-note="rank">Start now</span></div></article>
        </div>
        <div class="tabs">
            @foreach ($tabs as $tab)
                <button class="tab {{ $loop->first ? 'active' : '' }}" type="button" data-filter="{{ $tab['key'] }}"><span>{{ $tab['label'] }}</span><b data-tab-count="{{ $tab['key'] }}"></b></button>
            @endforeach
        </div>
        <article class="card assessment-runner" data-runner>
            <div class="card-head"><h2 data-runner-title>Initial Assessment</h2><button class="outline" type="button" data-close-runner>Close</button></div>
            <div data-questions></div>
            <div data-runner-actions style="display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap">
                <button class="outline" type="button" data-prev-section>Previous</button>
                <button class="primary" type="button" data-next-section>Next: Aptitude</button>
                <button class="primary" type="button" data-submit-assessment>Submit Assessment</button>
            </div>
        </article>
        <div class="content-grid">
            <div>
                <article class="card overview">
                    <div class="ring-wrap"><h2>Assessment Overview</h2><div class="ring" data-score-ring style="--value:0%"><strong data-overall-score>0%</strong></div><h3>Overall Score</h3><b data-score-label>Pending</b></div>
                    <div class="divider"></div>
                    <div class="skill-box">
                        <h3>Skill Performance <span class="icon" data-icon="info"></span></h3>
                        <div class="skill" data-skill="technical"><span>Technical Skills</span><div class="bar"><span style="width:0%"></span></div><strong>0%</strong></div>
                        <div class="skill" data-skill="aptitude"><span>Aptitude</span><div class="bar"><span style="width:0%"></span></div><strong>0%</strong></div>
                        <div class="skill" data-skill="communication"><span>Communication</span><div class="bar"><span style="width:0%"></span></div><strong>0%</strong></div>
                        <button class="outline" type="button" data-start-assessment>Start Assessment</button>
                        <div class="mode-actions" data-mode-actions style="display:none;margin-top:14px;gap:10px;flex-wrap:wrap">
                            <button class="outline" type="button" data-choose-mode="direct">Continue with Jobs</button>
                            <button class="outline" type="button" data-choose-mode="internship">Continue with Internships</button>
                            <button class="outline" type="button" data-choose-mode="fast_track">Continue with Fast Track Mode</button>
                        </div>
                    </div>
                </article>
                <article class="card table-card">
                    <div class="card-head"><h2>Recent Assessments</h2><a href="#" data-view-all>View All</a></div>
                    <div class="table">
                        <div class="row head"><span>Assessment</span><span>Category</span><span>Score</span><span>Status</span><span>Date</span><span>Action</span></div>
                        <div data-recent><div class="empty">Loading assessments...</div></div>
                    </div>
                </article>
            </div>
            <aside class="side">
                <article class="card side-card">
                    <h2>Recommended for You</h2>
                    <div class="recommend"><span class="medal" data-icon="award"></span><div><h3 data-track-title>Initial Assessment</h3><p data-track-text>Complete your assessment to unlock recommendations.</p><button class="outline" type="button" data-track-action>Start Assessment</button></div></div>
                </article>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    Object.assign(window.directModeIcons || {}, {
        users:'<svg viewBox="0 0 24 24"><circle cx="10" cy="8" r="3.5"></circle><path d="M3.5 20a6.5 6.5 0 0 1 13 0"></path><path d="M17 9a3 3 0 0 1 0 6"></path></svg>',
        calendar:'<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 3v4M16 3v4M4 10h16"></path></svg>',
        trophy:'<svg viewBox="0 0 24 24"><path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"></path><path d="M8 6H4v2a4 4 0 0 0 4 4"></path><path d="M16 6h4v2a4 4 0 0 1-4 4"></path><path d="M12 13v5"></path><path d="M8 20h8"></path></svg>',
        info:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4M12 8h.01"></path></svg>',
        code:'<svg viewBox="0 0 24 24"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M14 4l-4 16"></path></svg>',
        plus:'<svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>',
        message:'<svg viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"></path></svg>',
        award:'<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"></circle><path d="M8.5 12.5 7 22l5-3 5 3-1.5-9.5"></path></svg>',
        target:'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="5"></circle><circle cx="12" cy="12" r="1"></circle></svg>',
        book:'<svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5Z"></path></svg>',
    });
    document.querySelectorAll('[data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });

    const token = localStorage.getItem('onlyfreshers_token');
    const storedUser = JSON.parse(localStorage.getItem('onlyfreshers_user') || 'null');
    const headers = { Accept: 'application/json', ...(token ? { Authorization: `Bearer ${token}` } : {}) };
    const syncAssessmentChrome = () => {
        document.body.classList.toggle('assessment-onboarding', !localStorage.getItem('onlyfreshers_selected_mode'));
    };
    syncAssessmentChrome();
    let activeFilter = 'all';
    let dashboard = null;
    let currentAttempt = null;
    let questions = [];
    let runnerCategory = 'technical';
    let answersByQuestion = {};
    let currentQuestionIndex = 0;
    let questionTimer = null;
    const questionDuration = 8;
    let questionTimeLeft = questionDuration;
    const qs = s => document.querySelector(s);
    const qsa = s => [...document.querySelectorAll(s)];
    const esc = v => String(v ?? '').replace(/[&<>"']/g, c => {
        const map = { '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;' };
        return c === "'" ? '&#039;' : map[c];
    });
    const clamp = v => Math.max(0, Math.min(100, Number(v) || 0));
    const label = v => String(v || '').replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    const date = v => v ? new Date(v).toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' }) : '-';
    const retakeDate = assessment => assessment?.retake_available_at
        ? new Date(assessment.retake_available_at).toLocaleDateString('en-IN', { day:'2-digit', month:'short', year:'numeric' })
        : '';
    const alert = (msg, type = 'error') => {
        const el = qs('[data-alert]');
        el.textContent = msg || '';
        el.className = msg ? `alert ${type}` : 'alert';
        if (msg) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
    const getJson = async url => { const r = await fetch(url, { headers }); const j = await r.json().catch(() => ({})); if (!r.ok) throw new Error(j.message || 'Request failed.'); return j.data; };
    const postJson = async (url, payload = {}) => { const r = await fetch(url, { method:'POST', headers:{...headers,'Content-Type':'application/json'}, body:JSON.stringify(payload) }); const j = await r.json().catch(() => ({})); if (!r.ok) throw new Error(j.message || 'Request failed.'); return j.data; };
    const setSkill = (key, value) => { const row = qs(`[data-skill="${key}"]`); const score = clamp(value); row.querySelector('.bar span').style.width = `${score}%`; row.querySelector('strong').textContent = `${score}%`; };
    const scoreLabel = score => score >= 80 ? 'Excellent!' : score >= 60 ? 'Good!' : score > 0 ? 'Keep improving!' : 'Pending';
    const renderOverview = data => {
        const result = data?.initial_assessment?.result;
        const scoreByFilter = {
            all: result?.overall_score,
            completed: result?.overall_score,
            technical: result?.technical_score,
            aptitude: result?.aptitude_score,
            communication: result?.communication_score,
        };
        const overall = clamp(scoreByFilter[activeFilter]);
        const labelByFilter = {
            all: 'Overall Score',
            completed: 'Overall Score',
            technical: 'Technical Skills',
            aptitude: 'Aptitude',
            communication: 'Communication',
        };
        qs('[data-score-ring]').style.setProperty('--value', `${overall}%`);
        qs('[data-overall-score]').textContent = `${overall}%`;
        qs('.ring-wrap h3').textContent = labelByFilter[activeFilter] || 'Overall Score';
        qs('[data-score-label]').textContent = scoreLabel(overall);
        qs('[data-stat="taken"]').textContent = data?.initial_assessment ? '1' : '0';
        qs('[data-note="taken"]').textContent = data?.initial_assessment ? 'Completed' : 'Not started';
        qs('[data-stat="score"]').textContent = `${overall}%`;
        qs('[data-note="score"]').textContent = scoreLabel(overall).replace('!', '');
        qs('[data-stat="rank"]').textContent = overall ? `Top ${Math.max(1, 100 - overall)}%` : 'Top 100%';
        qs('[data-note="rank"]').textContent = overall ? 'Keep it up!' : 'Start now';
        setSkill('technical', result?.technical_score);
        setSkill('aptitude', result?.aptitude_score);
        setSkill('communication', result?.communication_score);
        const assessment = data?.initial_assessment;
        const recommended = assessment?.recommended_mode || null;
        const eligiblePaths = assessment?.eligible_paths || {};
        const directAllowed = eligiblePaths.direct ?? eligiblePaths.jobs ?? true;
        const retakeAt = retakeDate(assessment);
        qs('[data-track-title]').textContent = result
            ? (recommended === 'fast_track' ? 'Fast Track Mode Recommended' : 'Jobs & Internships Unlocked')
            : 'Initial Assessment';
        qs('[data-track-text]').textContent = result
            ? (!directAllowed
                ? `Your score is below the Direct Mode requirement. Choose Fast Track Mode now. You can retake for Direct Mode${retakeAt ? ` after ${retakeAt}` : ' after 1 month'}.`
                : 'Your score unlocks Jobs & Internships. Choose the path that fits your goal.')
            : 'Complete your initial assessment to know whether Jobs, Internships or Fast Track Mode fits you better.';
        qs('[data-track-action]').textContent = result ? 'Choose Your Path' : 'Start Assessment';
        const startButton = qs('[data-start-assessment]');
        if (startButton) {
            startButton.disabled = Boolean(result && !assessment?.can_retake_initial_assessment);
            startButton.textContent = result && !assessment?.can_retake_initial_assessment
                ? (retakeAt ? `Retake after ${retakeAt}` : 'Retake after 1 month')
                : 'Start Assessment';
        }
        renderModeActions(data?.initial_assessment);
    };
    const renderModeActions = assessment => {
        const wrap = qs('[data-mode-actions]');
        if (!wrap) return;
        const result = assessment?.result;
        wrap.style.display = result ? 'flex' : 'none';
        if (!result) return;
        const recommended = assessment?.recommended_mode || 'direct';
        const eligiblePaths = assessment?.eligible_paths || {};
        const directAllowed = eligiblePaths.direct ?? eligiblePaths.jobs ?? true;
        const internshipAllowed = eligiblePaths.internships ?? directAllowed;
        qsa('[data-choose-mode]').forEach(button => {
            const mode = button.dataset.chooseMode;
            const isRecommended = mode === recommended || (recommended === 'direct' && mode === 'internship');
            button.className = isRecommended ? 'primary' : 'outline';
            button.disabled = false;
            if (mode === 'direct') {
                button.disabled = !directAllowed;
                button.textContent = directAllowed
                    ? `Continue with Jobs${isRecommended ? ' (Recommended)' : ''}`
                    : 'Direct locked for 1 month';
            } else if (mode === 'internship') {
                button.disabled = !internshipAllowed;
                button.textContent = internshipAllowed
                    ? `Continue with Internships${isRecommended ? ' (Recommended)' : ''}`
                    : 'Internships locked for 1 month';
            } else {
                button.textContent = `Continue with Fast Track Mode${isRecommended ? ' (Recommended)' : ''}`;
            }
        });
    };
    const renderTabCounts = () => {
        const rows = recentRows();
        const counts = {
            all: rows.length,
            technical: rows.filter(r => r.category === 'technical').length,
            aptitude: rows.filter(r => r.category === 'aptitude').length,
            communication: rows.filter(r => r.category === 'communication').length,
            completed: rows.filter(r => r.status === 'submitted').length,
        };
        Object.entries(counts).forEach(([key, value]) => {
            const badge = qs(`[data-tab-count="${key}"]`);
            const tab = qs(`[data-filter="${key}"]`);
            if (!badge || !tab) return;
            badge.textContent = value;
            tab.classList.toggle('has-count', value > 0);
        });
    };
    const recentRows = () => {
        const attempt = dashboard?.initial_assessment;
        if (!attempt) return [];
        const result = attempt.result || {};
        return [
            { name:'Technical Assessment', sub:'Technical Skills', category:'technical', score:result.technical_score, status:attempt.status, date:attempt.submitted_at, icon:'code', tone:'blue' },
            { name:'Aptitude Test', sub:'Quantitative & Logical', category:'aptitude', score:result.aptitude_score, status:attempt.status, date:attempt.submitted_at, icon:'plus', tone:'green' },
            { name:'Communication Test', sub:'Verbal & Written', category:'communication', score:result.communication_score, status:attempt.status, date:attempt.submitted_at, icon:'message', tone:'purple' },
        ];
    };
    const renderRecent = () => {
        let rows = recentRows();
        if (activeFilter !== 'all') rows = rows.filter(r => activeFilter === 'completed' ? r.status === 'submitted' : r.category === activeFilter);
        qs('[data-recent]').innerHTML = rows.length ? rows.map(r => `<div class="row"><div class="assessment"><span class="sq ${r.tone}" data-icon="${r.icon}"></span><div><strong>${esc(r.name)}</strong><span>${esc(r.sub)}</span></div></div><span class="muted">${esc(label(r.category))}</span><strong>${clamp(r.score)}%</strong><span class="badge">${esc(label(r.status))}</span><span class="muted">${esc(date(r.date))}</span><button class="outline" type="button" data-report="${esc(r.category)}">View Report</button></div>`).join('') : '<div class="empty">No assessments found for this filter.</div>';
        qsa('[data-recent] [data-icon]').forEach(el => { el.innerHTML = window.directModeIcons[el.dataset.icon] || el.innerHTML; });
        qsa('[data-report]').forEach(btn => btn.addEventListener('click', () => showReport(btn.dataset.report)));
        renderOverview(dashboard);
    };
    const showReport = category => {
        const result = dashboard?.initial_assessment?.result;
        if (!result) {
            alert('Complete the assessment first to view report.');
            return;
        }
        const rows = [
            ['Overall Score', result.overall_score],
            ['Technical Skills', result.technical_score],
            ['Aptitude', result.aptitude_score],
            ['Communication', result.communication_score],
            ['Recommended Track', result.recommended_track || 'Initial Assessment'],
            ['Result', label(result.result)],
        ];
        qs('[data-runner-title]').textContent = 'Assessment Report';
        qs('[data-questions]').innerHTML = `<div class="question"><h3>Detailed Analysis</h3><div class="options">${rows.map(([k, v]) => `<div class="option"><strong style="min-width:150px">${esc(k)}</strong><span>${typeof v === 'number' ? `${clamp(v)}%` : esc(v)}</span></div>`).join('')}</div></div>`;
        qs('[data-runner-actions]').style.display = 'none';
        qs('[data-runner]').classList.add('active');
        qs('[data-runner]').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
    const categoryLabels = { technical: 'Technical Skills', aptitude: 'Aptitude', communication: 'Communication' };
    const categoryOrder = ['technical', 'aptitude', 'communication'];
    const categoryQuestions = category => questions.filter(q => q.category === category);
    const answeredCount = category => categoryQuestions(category).filter(q => answersByQuestion[q.id]).length;
    const currentCategoryComplete = () => currentQuestionIndex >= categoryQuestions(runnerCategory).length - 1;
    const stopQuestionTimer = () => {
        if (questionTimer) {
            clearInterval(questionTimer);
            questionTimer = null;
        }
    };
    const updateQuestionTimer = () => {
        const text = qs('[data-question-timer-text]');
        const bar = qs('[data-question-timer-bar]');
        if (text) text.textContent = `${questionTimeLeft}s`;
        if (bar) bar.style.width = `${(questionTimeLeft / questionDuration) * 100}%`;
    };
    const startQuestionTimer = () => {
        stopQuestionTimer();
        questionTimeLeft = questionDuration;
        updateQuestionTimer();
        questionTimer = setInterval(() => {
            questionTimeLeft -= 1;
            updateQuestionTimer();
            if (questionTimeLeft <= 0) {
                moveQuestion(1);
            }
        }, 1000);
    };
    const syncRunnerActions = () => {
        const currentIndex = categoryOrder.indexOf(runnerCategory);
        const previousButton = qs('[data-prev-section]');
        const nextButton = qs('[data-next-section]');
        const submitButton = qs('[data-submit-assessment]');
        const isLast = currentIndex === categoryOrder.length - 1;
        const isComplete = currentCategoryComplete();

        previousButton.style.display = currentIndex > 0 ? '' : 'none';
        previousButton.disabled = currentIndex <= 0;
        nextButton.style.display = isLast ? 'none' : '';
        nextButton.disabled = !isComplete;
        submitButton.style.display = isLast ? '' : 'none';
        submitButton.disabled = !isComplete;

        if (!isLast) {
            const nextCategory = categoryOrder[currentIndex + 1];
            nextButton.textContent = `Next: ${categoryLabels[nextCategory]}`;
        }
    };
    const renderQuestions = () => {
        qs('[data-runner-actions]').style.display = 'none';
        const currentQuestions = categoryQuestions(runnerCategory);
        const currentQuestion = currentQuestions[currentQuestionIndex];
        const nav = categoryOrder.map(category => {
            const total = categoryQuestions(category).length;
            const done = answeredCount(category);
            return `<button class="tab ${runnerCategory === category ? 'active' : ''} ${done ? 'has-count' : ''}" type="button" data-runner-category="${category}"><span>${categoryLabels[category]}</span><b>${done}/${total}</b></button>`;
        }).join('');
        qs('[data-runner-title]').textContent = `${categoryLabels[runnerCategory]} Assessment`;
        qs('[data-questions]').innerHTML = `<div class="tabs" style="width:100%;margin-bottom:14px">${nav}</div>${currentQuestion ? `<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px;flex-wrap:wrap"><strong class="muted">Question ${currentQuestionIndex + 1} of ${currentQuestions.length}</strong><div style="min-width:112px;border:1px solid #d8e4f7;border-radius:8px;background:#f8fbff;padding:8px 12px;text-align:center"><span style="display:block;font-size:11px;font-weight:800;color:#3d4c77">Time Left</span><b data-question-timer-text style="font-size:22px;color:#064cff">${questionDuration}s</b></div></div><div class="bar" style="height:8px;margin-bottom:14px"><span data-question-timer-bar style="width:100%"></span></div><div class="question"><h3>${currentQuestionIndex + 1}. ${esc(currentQuestion.question)}</h3><div class="options">${['A','B','C','D'].map(opt => `<label class="option"><input type="radio" name="q_${currentQuestion.id}" value="${opt}" ${answersByQuestion[currentQuestion.id] === opt ? 'checked' : ''}><span>${opt}. ${esc(currentQuestion['option_' + opt.toLowerCase()])}</span></label>`).join('')}</div></div><div style="display:flex;justify-content:flex-end;margin-top:12px"><button class="primary" type="button" data-next-question>${runnerCategory === 'communication' && currentQuestionIndex === currentQuestions.length - 1 ? 'Submit' : 'Next Question'}</button></div>` : '<div class="empty">No questions found for this category.</div>'}`;
        qsa('[data-runner-category]').forEach(btn => btn.addEventListener('click', () => {
            alert('');
            runnerCategory = btn.dataset.runnerCategory;
            currentQuestionIndex = 0;
            renderQuestions();
        }));
        qsa('[data-questions] input[type="radio"]').forEach(input => input.addEventListener('change', () => {
            answersByQuestion[input.name.replace('q_', '')] = input.value;
            moveQuestion(1);
        }));
        const nextQuestionButton = qs('[data-next-question]');
        if (nextQuestionButton) nextQuestionButton.addEventListener('click', () => moveQuestion(1));
        syncRunnerActions();
        if (currentQuestion) startQuestionTimer();
    };
    const moveQuestion = direction => {
        const currentQuestions = categoryQuestions(runnerCategory);
        const nextQuestionIndex = currentQuestionIndex + direction;
        stopQuestionTimer();

        if (nextQuestionIndex >= 0 && nextQuestionIndex < currentQuestions.length) {
            currentQuestionIndex = nextQuestionIndex;
            renderQuestions();
            return;
        }

        if (direction > 0) {
            const nextCategoryIndex = categoryOrder.indexOf(runnerCategory) + 1;
            if (nextCategoryIndex < categoryOrder.length) {
                runnerCategory = categoryOrder[nextCategoryIndex];
                currentQuestionIndex = 0;
                renderQuestions();
                return;
            }
            submitAssessment();
        }
    };
    const moveSection = direction => {
        const currentIndex = categoryOrder.indexOf(runnerCategory);
        if (direction > 0 && !currentCategoryComplete()) {
            return alert(`Please complete all ${categoryLabels[runnerCategory]} questions before continuing.`);
        }
        const nextIndex = currentIndex + direction;
        if (nextIndex < 0 || nextIndex >= categoryOrder.length) return;
        alert('');
        runnerCategory = categoryOrder[nextIndex];
        currentQuestionIndex = 0;
        renderQuestions();
        qs('[data-runner]').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
    const startAssessment = async () => {
        alert('');
        if (!token) return alert('Please login again to start assessment.');
        try {
            const startButton = qs('[data-start-assessment]');
            const trackButton = qs('[data-track-action]');
            startButton.disabled = true;
            trackButton.disabled = true;
            startButton.textContent = 'Starting...';
            const start = await postJson('/api/fresher/assessment/start');
            currentAttempt = start.attempt;
            const questionData = await getJson(`/api/fresher/assessment/${currentAttempt.id}/questions`);
            questions = questionData.questions || [];
            answersByQuestion = {};
            runnerCategory = 'technical';
            currentQuestionIndex = 0;
            if (!questions.length) {
                alert('No active questions are available right now.');
                return;
            }
            renderQuestions();
            qs('[data-runner-actions]').style.display = 'none';
            qs('[data-runner]').classList.add('active');
            qs('[data-runner]').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (e) {
            alert(e.message);
        } finally {
            const startButton = qs('[data-start-assessment]');
            const trackButton = qs('[data-track-action]');
            startButton.disabled = false;
            trackButton.disabled = false;
            startButton.textContent = 'Start Assessment';
        }
    };
    const submitAssessment = async () => {
        stopQuestionTimer();
        const answers = questions.map(q => ({ question_id: q.id, selected_option: answersByQuestion[q.id] || null }));
        try {
            qs('[data-submit-assessment]').disabled = true;
            qs('[data-submit-assessment]').textContent = 'Submitting...';
            await postJson(`/api/fresher/assessment/${currentAttempt.id}/submit`, { answers });
            alert('Assessment submitted successfully.', 'success');
            qs('[data-runner]').classList.remove('active');
            await load();
        } catch (e) {
            alert(e.message);
        } finally {
            qs('[data-submit-assessment]').disabled = false;
            qs('[data-submit-assessment]').textContent = 'Submit Assessment';
        }
    };
    const load = async () => {
        if (storedUser?.name) {
            qs('[data-user-name]').textContent = `${storedUser.name}!`;
            const topName = document.querySelector('.top-user strong');
            if (topName) topName.textContent = storedUser.name;
        }
        if (!token) {
            alert('Please login again to load assessment data.');
            renderRecent();
            return;
        }
        try {
            dashboard = await getJson('/api/fresher/dashboard');
            qs('[data-user-name]').textContent = `${dashboard.user?.name || storedUser?.name || 'Fresher'}!`;
            renderOverview(dashboard);
            renderTabCounts();
            renderRecent();
        } catch (e) {
            alert(e.message);
            renderRecent();
        }
    };
    qsa('[data-filter]').forEach(btn => btn.addEventListener('click', () => { activeFilter = btn.dataset.filter; qsa('[data-filter]').forEach(b => b.classList.toggle('active', b === btn)); renderOverview(dashboard); renderRecent(); }));
    qs('[data-start-assessment]').addEventListener('click', startAssessment);
    qs('[data-track-action]').addEventListener('click', () => {
        if (dashboard?.initial_assessment) {
            const actions = qs('[data-mode-actions]');
            if (actions) {
                actions.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
        startAssessment();
    });
    qsa('[data-choose-mode]').forEach(button => button.addEventListener('click', () => {
        const chosen = button.dataset.chooseMode;
        const eligiblePaths = dashboard?.initial_assessment?.eligible_paths || {};
        const directAllowed = eligiblePaths.direct ?? eligiblePaths.jobs ?? true;
        const internshipAllowed = eligiblePaths.internships ?? directAllowed;
        if (chosen === 'direct' && !directAllowed) {
            alert('Your assessment score is below the Direct Mode requirement. Please continue with Fast Track Mode.');
            return;
        }
        if (chosen === 'internship' && !internshipAllowed) {
            alert('Your assessment score is below the internship requirement. Please continue with Fast Track Mode.');
            return;
        }
        localStorage.setItem('onlyfreshers_selected_mode', chosen);
        syncAssessmentChrome();
        window.location.href = chosen === 'fast_track'
            ? '/fast-track/dashboard'
            : (chosen === 'internship' ? '/direct-mode/jobs?type=internship' : '/direct-mode/dashboard');
    }));
    qs('[data-submit-assessment]').addEventListener('click', submitAssessment);
    qs('[data-next-section]').addEventListener('click', () => moveSection(1));
    qs('[data-prev-section]').addEventListener('click', () => moveSection(-1));
    qs('[data-close-runner]').addEventListener('click', () => {
        stopQuestionTimer();
        qs('[data-runner]').classList.remove('active');
        qs('[data-runner-actions]').style.display = 'none';
        syncRunnerActions();
    });
    qs('[data-view-all]').addEventListener('click', e => { e.preventDefault(); activeFilter = 'all'; qsa('[data-filter]').forEach(b => b.classList.toggle('active', b.dataset.filter === 'all')); renderOverview(dashboard); renderRecent(); });
    load();
})();
</script>
@endpush
