@extends('layouts.fast-track')

@section('title', 'Final Assessment')

@php
    $activePage = 'final';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $summary = [
        'title' => 'Ready for Final Assessment?',
        'text' => 'You have completed the required training. Attempt the final assessment and get certified.',
        'stats' => [
            ['label' => 'Lessons Completed', 'value' => '28/74', 'icon' => 'LC'],
            ['label' => 'Courses Enrolled', 'value' => '4', 'icon' => 'CE'],
            ['label' => 'Total Study Time', 'value' => '12h 45m', 'icon' => 'ST'],
        ],
    ];

    $overview = [
        ['label' => 'Total Questions', 'value' => '60', 'icon' => 'TQ'],
        ['label' => 'Passing Marks', 'value' => '60%', 'icon' => 'PM'],
        ['label' => 'Time Duration', 'value' => '90 Minutes', 'icon' => 'TD'],
        ['label' => 'Total Attempts Allowed', 'value' => '3', 'icon' => 'TA'],
        ['label' => 'Current Attempts Used', 'value' => '0', 'icon' => 'CU'],
    ];

    $tips = [
        'Go through all the course materials thoroughly.',
        'Practice all quizzes and assignments.',
        'Focus on weak topics and improve your understanding.',
        'Manage your time effectively during the assessment.',
        'Ensure a stable internet connection before starting the test.',
    ];

    $attempts = [];
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Final Assessment</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Take the final assessment to test your knowledge and earn your certificate.</p>
        </div>

        <article id="finalAssessmentRunner" class="hidden rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]"></article>

        <article class="grid gap-6 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[165px_minmax(0,1fr)] xl:grid-cols-[165px_minmax(0,1fr)_repeat(3,170px)] xl:items-center">
            <div class="hidden h-32 items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-white text-[42px] font-black text-[#075fe4] sm:flex">FA</div>

            <div>
                <h2 class="mb-3 text-lg font-bold text-[#061942]">{{ $summary['title'] }}</h2>
                <p class="mb-5 max-w-xl text-sm leading-7 text-[#334b83]">{{ $summary['text'] }}</p>
                <a href="/fast-track/final-assessment/questions" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]">Start Final Assessment</a>
            </div>

            @foreach ($summary['stats'] as $item)
                <div class="flex min-h-[118px] flex-col justify-center border-t border-[#dce7f8] pt-4 xl:border-l xl:border-t-0 xl:pl-7 xl:pt-0">
                    <span class="mb-3 grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                    <strong class="text-[22px] font-bold text-[#061942]">{{ $item['value'] }}</strong>
                    <span class="mt-2 text-sm font-medium text-[#334b83]">{{ $item['label'] }}</span>
                </div>
            @endforeach
        </article>

        <div class="grid gap-5 xl:grid-cols-[1fr_1.28fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-5 text-lg font-bold text-[#061942]">Assessment Overview</h2>
                <div class="grid gap-4">
                    @foreach ($overview as $item)
                        <div class="grid grid-cols-[34px_minmax(0,1fr)_auto] items-center gap-4 text-sm">
                            <span class="grid h-[34px] w-[34px] place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                            <span class="font-semibold text-[#334b83]">{{ $item['label'] }}</span>
                            <strong class="text-right font-bold text-[#061942]">{{ $item['value'] }}</strong>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[minmax(0,1fr)_190px] lg:items-center">
                <div>
                    <h2 class="mb-5 text-lg font-bold text-[#061942]">Preparation Tips</h2>
                    <div class="grid gap-4">
                        @foreach ($tips as $tip)
                            <div class="flex items-start gap-3 text-sm leading-6 text-[#334b83]">
                                <span class="mt-1 grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-[#16a35a] text-[11px] font-black text-white">✓</span>
                                <span>{{ $tip }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hidden h-[150px] items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-[#fff4df] text-[44px] font-black text-[#075fe4] lg:flex">BK</div>
            </article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="p-5">
                <h2 class="text-lg font-bold text-[#061942]">Assessment Attempts</h2>
            </div>

            <div class="overflow-x-auto">
                <div class="grid min-w-[760px] grid-cols-[1.2fr_2fr_1.5fr_1.5fr_1.5fr] border-y border-[#e6eef8] px-4 py-3 text-xs font-bold text-[#061942]">
                    <span>Attempt No.</span>
                    <span>Date & Time</span>
                    <span>Score</span>
                    <span>Status</span>
                    <span>Certificate</span>
                </div>

                @forelse ($attempts as $attempt)
                    <div class="grid min-w-[760px] grid-cols-[1.2fr_2fr_1.5fr_1.5fr_1.5fr] border-b border-[#e6eef8] px-4 py-4 text-sm text-[#334b83] last:border-b-0">
                        <span>{{ $attempt['no'] }}</span>
                        <span>{{ $attempt['date'] }}</span>
                        <span>{{ $attempt['score'] }}</span>
                        <span>{{ $attempt['status'] }}</span>
                        <span>{{ $attempt['certificate'] }}</span>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center">
                        <div class="mx-auto mb-3 grid h-[86px] w-[86px] place-items-center rounded-full bg-[#eaf2ff] text-2xl font-black text-[#075fe4]">NA</div>
                        <h3 class="mb-2 text-base font-bold text-[#061942]">No attempts yet!</h3>
                        <p class="mb-5 text-sm text-[#334b83]">Start your final assessment to evaluate your learning.</p>
                        <a href="/fast-track/final-assessment/questions" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white">Start Now</a>
                    </div>
                @endforelse
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const finalAssessmentRunner = document.getElementById('finalAssessmentRunner');
    let finalEnrollment = null;
    let finalAttemptId = null;
    let finalQuestions = [];

    function renderFinalLock(enrollments) {
        const completed = enrollments.find(function (item) {
            return (item.training_status === 'completed' || item.enrollment_status === 'completed') && (item.payment_status === 'paid' || item.payment_status === 'success');
        });
        finalEnrollment = completed;
        if (!finalAssessmentRunner) return;
        finalAssessmentRunner.classList.remove('hidden');
        if (!completed) {
            finalAssessmentRunner.innerHTML = `<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="text-lg font-bold text-[#061942]">Final Assessment Locked</h2><p class="mt-2 text-sm text-[#334b83]">Complete paid training first. Training partner progress must reach 100% before final assessment opens.</p></div><a class="h-10 rounded-md bg-[#075fe4] px-5 py-2.5 text-sm font-bold text-white" href="/fast-track/training-progress">View Progress</a></div>`;
            return;
        }
        finalAssessmentRunner.innerHTML = `<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="text-lg font-bold text-[#061942]">Ready: ${FastTrack.esc(FastTrack.courseName(FastTrack.course(completed)))}</h2><p class="mt-2 text-sm text-[#334b83]">Training is complete. Start the real final assessment to generate certificate eligibility.</p></div><button id="startFinalAssessmentBtn" class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" type="button">Start Final Assessment</button></div>`;
        document.getElementById('startFinalAssessmentBtn').addEventListener('click', startFinalAssessment);
    }

    function renderFinalQuestions() {
        finalAssessmentRunner.innerHTML = `<form id="finalAssessmentForm" class="space-y-5">${finalQuestions.map(function (question, index) {
            const options = question.options || [question.option_a, question.option_b, question.option_c, question.option_d].filter(Boolean);
            return `<fieldset class="rounded-lg border border-[#e6eef8] p-4"><legend class="mb-3 text-sm font-bold text-[#061942]">${index + 1}. ${FastTrack.esc(question.question || question.title)}</legend>${options.map(function (option, optionIndex) { return `<label class="mb-2 flex gap-3 text-sm text-[#334b83]"><input class="mt-1" type="radio" name="fq_${question.id}" value="${optionIndex + 1}" required><span>${FastTrack.esc(option.text || option)}</span></label>`; }).join('')}</fieldset>`;
        }).join('')}<button class="h-10 rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="submit">Submit Final Assessment</button></form>`;
        document.getElementById('finalAssessmentForm').addEventListener('submit', submitFinalAssessment);
    }

    function startFinalAssessment() {
        finalAssessmentRunner.innerHTML = '<p class="text-sm font-semibold text-[#334b83]">Starting final assessment...</p>';
        FastTrack.postJson('/api/fresher/enrollments/' + finalEnrollment.id + '/final-assessment/start')
            .then(function (result) {
                const attempt = FastTrack.apiData(result, 'attempt') || FastTrack.apiData(result);
                finalAttemptId = attempt.id;
                return FastTrack.getJson('/api/fresher/final-assessment/' + finalAttemptId + '/questions');
            })
            .then(function (result) {
                finalQuestions = FastTrack.apiData(result, 'questions') || [];
                renderFinalQuestions();
            })
            .catch(function (error) {
                finalAssessmentRunner.innerHTML = `<p class="text-sm font-semibold text-[#8a5200]">${FastTrack.esc(error.message || 'Final assessment could not start.')}</p>`;
            });
    }

    function submitFinalAssessment(event) {
        event.preventDefault();
        const answers = finalQuestions.map(function (question) {
            const checked = event.target.querySelector('[name="fq_' + question.id + '"]:checked');
            return { question_id: question.id, selected_option: checked ? checked.value : null };
        });
        FastTrack.postJson('/api/fresher/final-assessment/' + finalAttemptId + '/submit', { answers: answers })
            .then(function () { return FastTrack.getJson('/api/fresher/final-assessment/' + finalAttemptId + '/result'); })
            .then(function (result) {
                const data = FastTrack.apiData(result, 'result') || FastTrack.apiData(result);
                finalAssessmentRunner.innerHTML = `<div><h2 class="text-lg font-bold text-[#061942]">Final Assessment Submitted</h2><p class="mt-2 text-sm text-[#334b83]">Score: <strong class="text-[#061942]">${FastTrack.esc(data.score_percentage || data.score || 0)}%</strong>. Certificate status will update automatically after passing.</p><a class="mt-5 inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" href="/fast-track/certificate">View Certificate</a></div>`;
            })
            .catch(function (error) { alert(error.message || 'Submit failed'); });
    }

    FastTrack.enrollments().then(renderFinalLock).catch(function () {});
</script>
@endpush
