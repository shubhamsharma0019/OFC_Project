@extends('layouts.fast-track')

@section('title', 'Initial Assessment - Fast Track')

@php
    $activePage = 'assessment';
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Initial Assessment</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Complete the assessment to discover your skills and get personalized course recommendations.</p>
        </div>

        <article id="assessmentStatus" class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <p class="text-sm font-semibold text-[#334b83]">Loading assessment status...</p>
        </article>

        <article id="initialAssessmentRunner" class="hidden rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]"></article>

        <div id="resultSections" class="hidden space-y-5">
            <div class="grid gap-5 xl:grid-cols-2">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h2 class="mb-6 text-base font-bold text-[#061942]">Skill Assessment Results</h2>
                    <div id="skillResults" class="space-y-5"></div>
                </article>

                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h2 class="mb-6 text-base font-bold text-[#061942]">Subject Wise Performance</h2>
                    <div id="subjectPerformance" class="grid items-center gap-6 lg:grid-cols-[210px_minmax(0,1fr)]"></div>
                </article>
            </div>

            <div class="grid gap-5 xl:grid-cols-[1.45fr_1fr]">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h2 class="mb-3 text-base font-bold text-[#061942]">Recommended for You</h2>
                    <p class="mb-5 text-sm leading-6 text-[#536484]">Based on your performance, we recommend the following career track.</p>
                    <div id="recommendedTracks" class="grid gap-3"></div>
                </article>

                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h2 class="mb-6 text-base font-bold text-[#061942]">What's Next?</h2>
                    <div class="grid gap-5">
                        <a class="grid grid-cols-[42px_minmax(0,1fr)_16px] items-center gap-4" href="/fast-track/courses">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">EX</span>
                            <span><b class="mb-1.5 block text-sm text-[#061942]">Explore Fast Track Courses</b><small class="text-xs leading-5 text-[#536484]">Choose a course that matches your recommended track.</small></span>
                            <span class="text-lg font-bold text-[#075fe4]">&gt;</span>
                        </a>
                        <a class="grid grid-cols-[42px_minmax(0,1fr)_16px] items-center gap-4" href="/fast-track/profile">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">PR</span>
                            <span><b class="mb-1.5 block text-sm text-[#061942]">Complete Profile</b><small class="text-xs leading-5 text-[#536484]">A complete profile improves your training and hiring journey.</small></span>
                            <span class="text-lg font-bold text-[#075fe4]">&gt;</span>
                        </a>
                        <a class="grid grid-cols-[42px_minmax(0,1fr)_16px] items-center gap-4" href="/fast-track/training">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">TR</span>
                            <span><b class="mb-1.5 block text-sm text-[#061942]">Start Training</b><small class="text-xs leading-5 text-[#536484]">Enroll and pay to unlock training progress.</small></span>
                            <span class="text-lg font-bold text-[#075fe4]">&gt;</span>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const assessmentStatus = document.getElementById('assessmentStatus');
    const initialAssessmentRunner = document.getElementById('initialAssessmentRunner');
    const resultSections = document.getElementById('resultSections');
    const skillResults = document.getElementById('skillResults');
    const subjectPerformance = document.getElementById('subjectPerformance');
    const recommendedTracks = document.getElementById('recommendedTracks');
    let initialAttemptId = null;
    let initialQuestions = [];

    function scoreValue(value) { return Math.max(0, Math.min(100, Number(value || 0))); }
    function resultRows(result) {
        return [
            ['Technical Skills', scoreValue(result.technical_score), '#075fe4'],
            ['Aptitude', scoreValue(result.aptitude_score), '#19a85b'],
            ['Communication', scoreValue(result.communication_score), '#7744eb'],
        ];
    }
    function showStart(message) {
        assessmentStatus.innerHTML = `<div class="grid gap-6 xl:grid-cols-[150px_minmax(0,1fr)_260px] xl:items-center"><div class="grid h-[105px] w-[120px] place-items-center rounded-xl bg-[#eaf2ff] text-[32px] font-black text-[#075fe4]">IA</div><div><h2 class="mb-3 text-lg font-bold text-[#061942]">Assessment Pending</h2><p class="text-sm font-medium text-[#334b83]">${FastTrack.esc(message || 'Start your initial assessment to get a recommended track.')}</p></div><button id="startInitialAssessmentBtn" class="h-11 rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="button">Start Assessment</button></div>`;
        document.getElementById('startInitialAssessmentBtn').addEventListener('click', startInitialAssessment);
    }
    function renderResult(result, submittedAt) {
        const overall = scoreValue(result.overall_score || result.score_percentage || result.score);
        resultSections.classList.remove('hidden');
        assessmentStatus.innerHTML = `<div class="grid gap-6 xl:grid-cols-[150px_minmax(0,1fr)_260px] xl:items-center"><div class="grid h-[105px] w-[120px] place-items-center rounded-xl bg-[#eaf2ff] text-[32px] font-black text-[#075fe4]">IA</div><div><div class="mb-4 flex items-center text-lg font-bold text-[#0a8f3f]"><span class="mr-3 grid h-6 w-6 place-items-center rounded-full bg-[#19a85b] text-xs font-black text-white">✓</span>Assessment Completed</div><p class="mb-5 text-sm font-medium text-[#334b83]">Submitted on ${FastTrack.esc(FastTrack.date(submittedAt))}</p><a class="inline-flex h-[38px] items-center rounded-md border border-[#075fe4] bg-white px-6 text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" href="/fast-track/courses">Explore Courses</a></div><div class="border-[#dce7f8] text-center xl:border-l xl:pl-8"><h3 class="mb-4 text-sm font-bold text-[#061942]">Overall Score</h3><div class="inline-flex h-[105px] w-[105px] items-center justify-center rounded-full" style="background:conic-gradient(#075fe4 0 ${overall}%, #e9edf5 ${overall}% 100%);"><span class="flex h-[76px] w-[76px] items-center justify-center rounded-full bg-white text-[22px] font-bold text-[#061942]">${overall}%</span></div></div></div>`;
        const rows = resultRows(result);
        skillResults.innerHTML = rows.map((item) => `<div class="grid items-center gap-3 text-sm sm:grid-cols-[130px_minmax(0,1fr)_42px] sm:gap-4"><span class="font-medium text-[#061942]">${FastTrack.esc(item[0])}</span><div class="h-2 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full" style="width:${item[1]}%;background:${item[2]};"></span></div><strong class="font-bold text-[#061942]">${item[1]}%</strong></div>`).join('');
        const gradient = rows.map((item, index) => `${item[2]} ${(index * 100) / rows.length}% ${((index + 1) * 100) / rows.length}%`).join(', ');
        subjectPerformance.innerHTML = `<div class="mx-auto flex h-40 w-40 items-center justify-center rounded-full" style="background:conic-gradient(${gradient});"><span class="flex h-[102px] w-[102px] flex-col items-center justify-center rounded-full bg-white text-center text-xl font-bold leading-tight text-[#061942]">${overall}%<small class="text-xs font-medium text-[#334b83]">Overall</small></span></div><div class="grid gap-4">${rows.map((item) => `<div class="grid grid-cols-[12px_minmax(0,1fr)_42px] items-center gap-3 text-sm"><span class="h-[11px] w-[11px] rounded-full" style="background:${item[2]};"></span><span class="font-medium text-[#334b83]">${FastTrack.esc(item[0])}</span><strong class="font-bold text-[#061942]">${item[1]}%</strong></div>`).join('')}</div>`;
        recommendedTracks.innerHTML = `<div class="grid gap-4 rounded-lg border border-[#dce7f8] p-4 lg:grid-cols-[54px_minmax(0,1fr)_95px_92px] lg:items-center"><span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">${FastTrack.initials(result.recommended_track || 'FT')}</span><div><h3 class="mb-2 text-sm font-bold text-[#061942]">${FastTrack.esc(result.recommended_track || 'Fast Track Courses')} <span class="ml-2 inline-flex rounded-md bg-[#eee7ff] px-2 py-1 text-[10px] font-bold text-[#7744eb]">${FastTrack.esc(result.result || 'result')}</span></h3><p class="text-xs leading-5 text-[#536484]">Recommended from your technical, aptitude, and communication performance.</p></div><div><small class="text-xs text-[#536484]">Match Score</small><div class="text-[21px] font-black text-[#0a8f3f]">${overall}%</div></div><a href="/fast-track/courses" class="inline-flex h-[38px] items-center justify-center rounded-md bg-[#075fe4] px-4 text-sm font-bold text-white">Explore</a></div>`;
    }
    function renderQuestions() {
        initialAssessmentRunner.classList.remove('hidden');
        assessmentStatus.classList.add('hidden');
        initialAssessmentRunner.innerHTML = `<form id="initialAssessmentForm" class="space-y-5"><div><h2 class="text-lg font-bold text-[#061942]">Assessment Questions</h2><p class="mt-2 text-sm text-[#334b83]">Select one option for every question.</p></div>${initialQuestions.map((question, index) => {
            const options = [['A', question.option_a], ['B', question.option_b], ['C', question.option_c], ['D', question.option_d]].filter((item) => item[1]);
            return `<fieldset class="rounded-lg border border-[#e6eef8] p-4"><legend class="mb-3 text-sm font-bold text-[#061942]">${index + 1}. ${FastTrack.esc(question.question)}</legend>${options.map((option) => `<label class="mb-2 flex gap-3 text-sm text-[#334b83]"><input class="mt-1" type="radio" name="q_${question.id}" value="${option[0]}" required><span><b>${option[0]}.</b> ${FastTrack.esc(option[1])}</span></label>`).join('')}</fieldset>`;
        }).join('')}<button class="h-10 rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="submit">Submit Assessment</button></form>`;
        document.getElementById('initialAssessmentForm').addEventListener('submit', submitInitialAssessment);
    }
    function startInitialAssessment() {
        assessmentStatus.innerHTML = '<p class="text-sm font-semibold text-[#334b83]">Starting assessment...</p>';
        FastTrack.postJson('/api/fresher/assessment/start')
            .then((result) => {
                const attempt = FastTrack.apiData(result, 'attempt') || {};
                initialAttemptId = attempt.id;
                return FastTrack.getJson('/api/fresher/assessment/' + initialAttemptId + '/questions');
            })
            .then((result) => {
                initialQuestions = FastTrack.apiData(result, 'questions') || [];
                renderQuestions();
            })
            .catch((error) => showStart(error.message || 'Assessment could not start.'));
    }
    function submitInitialAssessment(event) {
        event.preventDefault();
        const answers = initialQuestions.map((question) => {
            const checked = event.target.querySelector('[name="q_' + question.id + '"]:checked');
            return { question_id: question.id, selected_option: checked ? checked.value : null };
        });
        FastTrack.postJson('/api/fresher/assessment/' + initialAttemptId + '/submit', { answers })
            .then((result) => {
                const data = FastTrack.apiData(result) || {};
                initialAssessmentRunner.classList.add('hidden');
                assessmentStatus.classList.remove('hidden');
                renderResult(data.result || {}, data.attempt?.submitted_at);
            })
            .catch((error) => alert(error.message || 'Submit failed'));
    }
    function loadAssessmentState() {
        FastTrack.getJson('/api/fresher/dashboard')
            .then((result) => {
                const data = FastTrack.apiData(result) || {};
                const assessment = data.initial_assessment;
                if (assessment?.result) {
                    renderResult(assessment.result, assessment.submitted_at);
                    return;
                }
                showStart('Start your first assessment to unlock recommended tracks.');
            })
            .catch((error) => showStart(error.message || 'Complete your profile before starting assessment.'));
    }
    loadAssessmentState();
</script>
@endpush
