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
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg></span>
                            <span><b class="mb-1.5 block text-sm text-[#061942]">Explore Fast Track Courses</b><small class="text-xs leading-5 text-[#536484]">Choose a course that matches your recommended track.</small></span>
                            <span class="text-lg font-bold text-[#075fe4]">&gt;</span>
                        </a>
                        <a class="grid grid-cols-[42px_minmax(0,1fr)_16px] items-center gap-4" href="/fast-track/profile">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg></span>
                            <span><b class="mb-1.5 block text-sm text-[#061942]">Complete Profile</b><small class="text-xs leading-5 text-[#536484]">A complete profile improves your training and hiring journey.</small></span>
                            <span class="text-lg font-bold text-[#075fe4]">&gt;</span>
                        </a>
                        <a class="grid grid-cols-[42px_minmax(0,1fr)_16px] items-center gap-4" href="/fast-track/training">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3Z"></path></svg></span>
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
    let initialAnswers = [];
    let currentQuestionIndex = 0;
    let questionTimer = null;
    const questionDuration = 8;
    let questionTimeLeft = questionDuration;
    const assessmentIcons = {
        assessment: '<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 13h6M9 17h3"></path></svg>',
        courses: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
        profile: '<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg>',
        training: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3Z"></path></svg>',
        track: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',
        check: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>',
    };

    function assessmentIcon(name, size = 'h-10 w-10') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${assessmentIcons[name] || assessmentIcons.assessment}</span>`;
    }

    function scoreValue(value) { return Math.max(0, Math.min(100, Number(value || 0))); }
    function resultRows(result) {
        return [
            ['Technical Skills', scoreValue(result.technical_score), '#075fe4'],
            ['Aptitude', scoreValue(result.aptitude_score), '#19a85b'],
            ['Communication', scoreValue(result.communication_score), '#7744eb'],
        ];
    }
    function showStart(message) {
        assessmentStatus.innerHTML = `<div class="grid gap-6 xl:grid-cols-[150px_minmax(0,1fr)_260px] xl:items-center"><div class="grid h-[105px] w-[120px] place-items-center rounded-xl bg-[#eaf2ff] text-[#075fe4] [&>svg]:h-14 [&>svg]:w-14 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${assessmentIcons.assessment}</div><div><h2 class="mb-3 text-lg font-bold text-[#061942]">Assessment Pending</h2><p class="text-sm font-medium text-[#334b83]">${FastTrack.esc(message || 'Start your initial assessment to get a recommended track.')}</p></div><button id="startInitialAssessmentBtn" class="h-11 rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="button">Start Assessment</button></div>`;
        document.getElementById('startInitialAssessmentBtn').addEventListener('click', startInitialAssessment);
    }
    function renderResult(result, submittedAt) {
        const overall = scoreValue(result.overall_score || result.score_percentage || result.score);
        resultSections.classList.remove('hidden');
        assessmentStatus.innerHTML = `<div class="grid gap-6 xl:grid-cols-[150px_minmax(0,1fr)_260px] xl:items-center"><div class="grid h-[105px] w-[120px] place-items-center rounded-xl bg-[#eaf2ff] text-[#075fe4] [&>svg]:h-14 [&>svg]:w-14 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${assessmentIcons.assessment}</div><div><div class="mb-4 flex items-center text-lg font-bold text-[#0a8f3f]"><span class="mr-3 grid h-7 w-7 place-items-center rounded-full bg-[#19a85b] text-white [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-[3] [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${assessmentIcons.check}</span>Assessment Completed</div><p class="mb-5 text-sm font-medium text-[#334b83]">Submitted on ${FastTrack.esc(FastTrack.date(submittedAt))}</p><a class="inline-flex h-[38px] items-center rounded-md border border-[#075fe4] bg-white px-6 text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" href="/fast-track/courses">Explore Courses</a></div><div class="border-[#dce7f8] text-center xl:border-l xl:pl-8"><h3 class="mb-4 text-sm font-bold text-[#061942]">Overall Score</h3><div class="inline-flex h-[105px] w-[105px] items-center justify-center rounded-full" style="background:conic-gradient(#075fe4 0 ${overall}%, #e9edf5 ${overall}% 100%);"><span class="flex h-[76px] w-[76px] items-center justify-center rounded-full bg-white text-[22px] font-bold text-[#061942]">${overall}%</span></div></div></div>`;
        const rows = resultRows(result);
        skillResults.innerHTML = rows.map((item) => `<div class="grid items-center gap-3 text-sm sm:grid-cols-[130px_minmax(0,1fr)_42px] sm:gap-4"><span class="font-medium text-[#061942]">${FastTrack.esc(item[0])}</span><div class="h-2 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full" style="width:${item[1]}%;background:${item[2]};"></span></div><strong class="font-bold text-[#061942]">${item[1]}%</strong></div>`).join('');
        const gradient = rows.map((item, index) => `${item[2]} ${(index * 100) / rows.length}% ${((index + 1) * 100) / rows.length}%`).join(', ');
        subjectPerformance.innerHTML = `<div class="mx-auto flex h-40 w-40 items-center justify-center rounded-full" style="background:conic-gradient(${gradient});"><span class="flex h-[102px] w-[102px] flex-col items-center justify-center rounded-full bg-white text-center text-xl font-bold leading-tight text-[#061942]">${overall}%<small class="text-xs font-medium text-[#334b83]">Overall</small></span></div><div class="grid gap-4">${rows.map((item) => `<div class="grid grid-cols-[12px_minmax(0,1fr)_42px] items-center gap-3 text-sm"><span class="h-[11px] w-[11px] rounded-full" style="background:${item[2]};"></span><span class="font-medium text-[#334b83]">${FastTrack.esc(item[0])}</span><strong class="font-bold text-[#061942]">${item[1]}%</strong></div>`).join('')}</div>`;
        recommendedTracks.innerHTML = `<div class="grid gap-4 rounded-lg border border-[#dce7f8] p-4 lg:grid-cols-[54px_minmax(0,1fr)_95px_92px] lg:items-center">${assessmentIcon('track')}<div><h3 class="mb-2 text-sm font-bold text-[#061942]">${FastTrack.esc(result.recommended_track || 'Fast Track Courses')} <span class="ml-2 inline-flex rounded-md bg-[#eee7ff] px-2 py-1 text-[10px] font-bold text-[#7744eb]">${FastTrack.esc(result.result || 'result')}</span></h3><p class="text-xs leading-5 text-[#536484]">Recommended from your technical, aptitude, and communication performance.</p></div><div><small class="text-xs text-[#536484]">Match Score</small><div class="text-[21px] font-black text-[#0a8f3f]">${overall}%</div></div><a href="/fast-track/courses" class="inline-flex h-[38px] items-center justify-center rounded-md bg-[#075fe4] px-4 text-sm font-bold text-white">Explore</a></div>`;
    }
    function questionOptions(question) {
        return [['A', question.option_a], ['B', question.option_b], ['C', question.option_c], ['D', question.option_d]].filter((item) => item[1]);
    }
    function stopQuestionTimer() {
        if (questionTimer) {
            clearInterval(questionTimer);
            questionTimer = null;
        }
    }
    function updateQuestionTimer() {
        const timerText = document.getElementById('initialQuestionTimerText');
        const timerBar = document.getElementById('initialQuestionTimerBar');

        if (timerText) {
            timerText.textContent = questionTimeLeft + 's';
        }

        if (timerBar) {
            timerBar.style.width = ((questionTimeLeft / questionDuration) * 100) + '%';
        }
    }
    function startQuestionTimer() {
        stopQuestionTimer();
        questionTimeLeft = questionDuration;
        updateQuestionTimer();

        questionTimer = setInterval(() => {
            questionTimeLeft -= 1;
            updateQuestionTimer();

            if (questionTimeLeft <= 0) {
                goToNextQuestion();
            }
        }, 1000);
    }
    function renderCurrentQuestion() {
        const question = initialQuestions[currentQuestionIndex];

        if (!question) {
            submitInitialAssessment();
            return;
        }

        const options = questionOptions(question);
        const selectedAnswer = initialAnswers[currentQuestionIndex]?.selected_option || '';

        initialAssessmentRunner.innerHTML = `<div class="space-y-5"><div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"><div><h2 class="text-lg font-bold text-[#061942]">Assessment Questions</h2><p class="mt-2 text-sm text-[#334b83]">Question ${currentQuestionIndex + 1} of ${initialQuestions.length}. Select one option in ${questionDuration} seconds.</p></div><div class="shrink-0 rounded-md border border-[#dce7f8] bg-[#f7faff] px-4 py-2 text-center"><span class="block text-[11px] font-bold uppercase text-[#536484]">Time Left</span><strong id="initialQuestionTimerText" class="text-xl font-black text-[#075fe4]">${questionDuration}s</strong></div></div><div class="h-2 overflow-hidden rounded-full bg-[#e9edf5]"><span id="initialQuestionTimerBar" class="block h-full rounded-full bg-[#075fe4] transition-all duration-300" style="width:100%;"></span></div><fieldset class="rounded-lg border border-[#e6eef8] p-4"><legend class="mb-4 text-base font-bold leading-6 text-[#061942]">${currentQuestionIndex + 1}. ${FastTrack.esc(question.question)}</legend><div class="grid gap-3">${options.map((option) => `<label class="flex cursor-pointer gap-3 rounded-md border border-[#e6eef8] p-3 text-sm text-[#334b83] hover:border-[#075fe4] hover:bg-[#f7faff]"><input class="mt-1" type="radio" name="current_question" value="${option[0]}" ${selectedAnswer === option[0] ? 'checked' : ''}><span><b>${option[0]}.</b> ${FastTrack.esc(option[1])}</span></label>`).join('')}</div></fieldset><div class="flex items-center justify-between gap-3"><span class="text-sm font-semibold text-[#334b83]">${Math.round(((currentQuestionIndex + 1) / initialQuestions.length) * 100)}% complete</span><button id="nextInitialQuestionBtn" class="h-10 rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="button">${currentQuestionIndex + 1 === initialQuestions.length ? 'Submit' : 'Next'}</button></div></div>`;
        document.querySelectorAll('[name="current_question"]').forEach((input) => {
            input.addEventListener('change', () => {
                initialAnswers[currentQuestionIndex] = {
                    question_id: question.id,
                    selected_option: input.value,
                };
                goToNextQuestion();
            });
        });
        document.getElementById('nextInitialQuestionBtn').addEventListener('click', goToNextQuestion);
        startQuestionTimer();
    }
    function goToNextQuestion() {
        const question = initialQuestions[currentQuestionIndex];
        const checked = document.querySelector('[name="current_question"]:checked');

        stopQuestionTimer();

        if (question) {
            initialAnswers[currentQuestionIndex] = {
                question_id: question.id,
                selected_option: checked ? checked.value : null,
            };
        }

        currentQuestionIndex += 1;

        if (currentQuestionIndex >= initialQuestions.length) {
            submitInitialAssessment();
            return;
        }

        renderCurrentQuestion();
    }
    function renderQuestions() {
        initialAssessmentRunner.classList.remove('hidden');
        assessmentStatus.classList.add('hidden');
        initialAnswers = initialQuestions.map((question) => ({
            question_id: question.id,
            selected_option: null,
        }));
        currentQuestionIndex = 0;
        renderCurrentQuestion();
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
    function submitInitialAssessment() {
        stopQuestionTimer();
        const answers = initialQuestions.map((question, index) => ({
            question_id: question.id,
            selected_option: initialAnswers[index]?.selected_option || null,
        }));
        initialAssessmentRunner.innerHTML = '<p class="text-sm font-semibold text-[#334b83]">Submitting assessment...</p>';
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
