@extends('layouts.fast-track')

@section('title', 'Final Assessment')

@php
    $activePage = 'final';
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Final Assessment</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Take the final assessment to test your knowledge and earn your certificate.</p>
        </div>

        <article id="finalSummary" class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <p class="text-sm text-[#334b83]">Loading final assessment eligibility...</p>
        </article>

        <article id="finalAssessmentRunner" class="hidden rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]"></article>

        <div class="grid gap-5 xl:grid-cols-[1fr_1.28fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-5 text-lg font-bold text-[#061942]">Assessment Overview</h2>
                <div id="assessmentOverview" class="grid gap-4">
                    <p class="text-sm text-[#334b83]">Loading overview...</p>
                </div>
            </article>

            <article class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[minmax(0,1fr)_190px] lg:items-center">
                <div>
                    <h2 class="mb-5 text-lg font-bold text-[#061942]">Preparation Tips</h2>
                    <div class="grid gap-4">
                        @foreach (['Go through all course materials thoroughly.', 'Practice quizzes and assignments.', 'Focus on weak topics before starting.', 'Keep a stable internet connection ready.', 'Submit only after answering every question.'] as $tip)
                            <div class="flex items-start gap-3 text-sm leading-6 text-[#334b83]">
                                <span class="mt-1 grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-[#16a35a] text-white [&>svg]:h-3 [&>svg]:w-3 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-[3] [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg></span>
                                <span>{{ $tip }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hidden h-[150px] items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-[#fff4df] text-[#075fe4] lg:flex [&>svg]:h-20 [&>svg]:w-20 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg></div>
            </article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="p-5">
                <h2 class="text-lg font-bold text-[#061942]">Eligible Trainings</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-4 py-3 text-left">Course</th><th class="px-4 py-3 text-left">Progress</th><th class="px-4 py-3 text-left">Payment</th><th class="px-4 py-3 text-left">Training</th><th class="px-4 py-3 text-left">Action</th></tr>
                    </thead>
                    <tbody id="eligibleRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        <tr><td class="px-4 py-5" colspan="5">Loading trainings...</td></tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const finalSummary = document.getElementById('finalSummary');
    const finalAssessmentRunner = document.getElementById('finalAssessmentRunner');
    const assessmentOverview = document.getElementById('assessmentOverview');
    const eligibleRows = document.getElementById('eligibleRows');
    let finalEnrollment = null;
    let finalAttemptId = null;
    let finalQuestions = [];
    let finalEnrollments = [];
    const finalIcons = {
        assessment: '<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 13h6M9 17h3"></path></svg>',
        questions: '<svg viewBox="0 0 24 24"><path d="M9.1 9a3 3 0 1 1 5.8 1c-.8 1.2-2.9 1.6-2.9 3"></path><path d="M12 17h.01"></path><circle cx="12" cy="12" r="9"></circle></svg>',
        passing: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>',
        attempts: '<svg viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-3-6.7"></path><path d="M21 3v6h-6"></path></svg>',
        paid: '<svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"></rect><path d="M3 10h18"></path><path d="M7 15h3"></path></svg>',
        eligible: '<svg viewBox="0 0 24 24"><path d="M12 3 4 7v6c0 5 3.5 7.5 8 8 4.5-.5 8-3 8-8V7l-8-4Z"></path><path d="m9 12 2 2 4-5"></path></svg>',
        progress: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',
        course: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
    };

    function finalIcon(name, size = 'h-[34px] w-[34px]') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${finalIcons[name] || finalIcons.assessment}</span>`;
    }

    function isCompletedEnrollment(item) {
        const progress = FastTrack.progress(item);
        return item.payment_status === 'paid'
            && (
                progress >= 100
                || (
                    item.training_status === 'completed'
                    && item.enrollment_status === 'completed'
                )
            );
    }
    function overviewItem(icon, label, value) {
        return `<div class="grid grid-cols-[34px_minmax(0,1fr)_auto] items-center gap-4 text-sm">${finalIcon(icon)}<span class="font-semibold text-[#334b83]">${FastTrack.esc(label)}</span><strong class="text-right font-bold text-[#061942]">${FastTrack.esc(value)}</strong></div>`;
    }
    function statusBadge(text, ok) {
        return `<span class="inline-flex rounded-md ${ok ? 'bg-[#e6fff0] text-[#05843e]' : 'bg-[#fff4df] text-[#b86500]'} px-3 py-1.5 text-xs font-bold">${FastTrack.esc(text)}</span>`;
    }
    function renderOverview(enrollments) {
        const completed = enrollments.filter(isCompletedEnrollment).length;
        const paid = enrollments.filter((item) => item.payment_status === 'paid').length;
        assessmentOverview.innerHTML = [
            overviewItem('questions', 'Total Questions', 'Dynamic'),
            overviewItem('passing', 'Passing Marks', '60%'),
            overviewItem('attempts', 'Total Attempts Allowed', '3'),
            overviewItem('paid', 'Paid Enrollments', paid),
            overviewItem('eligible', 'Eligible Trainings', completed),
        ].join('');
    }
    function renderRows(enrollments) {
        if (!enrollments.length) {
            eligibleRows.innerHTML = '<tr><td class="px-4 py-8 text-center text-sm text-[#334b83]" colspan="5">No enrollments found.</td></tr>';
            return;
        }
        eligibleRows.innerHTML = enrollments.map(function (enrollment) {
            const course = FastTrack.course(enrollment);
            const progress = FastTrack.progress(enrollment);
            const eligible = isCompletedEnrollment(enrollment);
            return `<tr>
                <td class="px-4 py-4"><strong class="block text-[#061942]">${FastTrack.esc(FastTrack.courseName(course))}</strong><span class="text-xs text-[#536484]">${FastTrack.esc(FastTrack.partnerName(course))}</span></td>
                <td class="px-4 py-4"><div class="mb-1 h-2 min-w-[120px] overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#075fe4]" style="width:${progress}%;"></span></div><span class="text-xs font-bold text-[#334b83]">${progress}%</span></td>
                <td class="px-4 py-4">${statusBadge(FastTrack.statusText(enrollment.payment_status), enrollment.payment_status === 'paid')}</td>
                <td class="px-4 py-4">${statusBadge(FastTrack.statusText(enrollment.training_status), enrollment.training_status === 'completed')}</td>
                <td class="px-4 py-4"><button class="start-final h-9 rounded-md ${eligible ? 'bg-[#075fe4] text-white' : 'border border-[#dce7f8] bg-white text-[#536484]'} px-4 text-xs font-bold" type="button" data-id="${enrollment.id}" ${eligible ? '' : 'disabled'}>${eligible ? 'Start' : 'Locked'}</button></td>
            </tr>`;
        }).join('');
    }
    function renderSummary(enrollments) {
        const eligible = enrollments.filter(isCompletedEnrollment);
        finalEnrollment = eligible[0] || null;
        if (!finalEnrollment) {
            finalSummary.innerHTML = `<div class="grid gap-6 lg:grid-cols-[165px_minmax(0,1fr)] lg:items-center"><div class="hidden h-32 items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-white text-[#075fe4] sm:grid [&>svg]:h-16 [&>svg]:w-16 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${finalIcons.assessment}</div><div><h2 class="mb-3 text-lg font-bold text-[#061942]">Final Assessment Locked</h2><p class="mb-5 max-w-xl text-sm leading-7 text-[#334b83]">Complete paid training first. Training partner progress must mark enrollment as completed before final assessment opens.</p><a href="/fast-track/training-progress" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white">View Progress</a></div></div>`;
            return;
        }
        const course = FastTrack.course(finalEnrollment);
        finalSummary.innerHTML = `<div class="grid gap-6 lg:grid-cols-[165px_minmax(0,1fr)_repeat(3,170px)] lg:items-center"><div class="hidden h-32 items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-white text-[#075fe4] sm:grid [&>svg]:h-16 [&>svg]:w-16 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${finalIcons.assessment}</div><div><h2 class="mb-3 text-lg font-bold text-[#061942]">Ready for Final Assessment</h2><p class="mb-5 max-w-xl text-sm leading-7 text-[#334b83]">${FastTrack.esc(FastTrack.courseName(course))} training is complete. Attempt final assessment and get certificate eligibility.</p><button id="summaryStartFinal" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="button">Start Final Assessment</button></div>${[
            ['progress', FastTrack.progress(finalEnrollment) + '%', 'Training Progress'],
            ['course', finalEnrollments.length, 'Courses Enrolled'],
            ['passing', '60%', 'Passing Marks'],
        ].map((item) => `<div class="flex min-h-[118px] flex-col justify-center border-t border-[#dce7f8] pt-4 lg:border-l lg:border-t-0 lg:pl-7 lg:pt-0">${finalIcon(item[0], 'mb-3 h-[54px] w-[54px] rounded-xl')}<strong class="text-[22px] font-bold text-[#061942]">${FastTrack.esc(item[1])}</strong><span class="mt-2 text-sm font-medium text-[#334b83]">${FastTrack.esc(item[2])}</span></div>`).join('')}</div>`;
        document.getElementById('summaryStartFinal')?.addEventListener('click', () => startFinalAssessment(finalEnrollment.id));
    }
    function renderFinalQuestions() {
        finalAssessmentRunner.classList.remove('hidden');
        finalSummary.classList.add('hidden');
        finalAssessmentRunner.innerHTML = `<form id="finalAssessmentForm" class="space-y-5"><div><h2 class="text-lg font-bold text-[#061942]">Final Assessment Questions</h2><p class="mt-2 text-sm text-[#334b83]">Select one option for every question.</p></div>${finalQuestions.map(function (question, index) {
            const options = [['A', question.option_a], ['B', question.option_b], ['C', question.option_c], ['D', question.option_d]].filter((item) => item[1]);
            return `<fieldset class="rounded-lg border border-[#e6eef8] p-4"><legend class="mb-3 text-sm font-bold text-[#061942]">${index + 1}. ${FastTrack.esc(question.question)}</legend>${options.map((option) => `<label class="mb-2 flex gap-3 text-sm text-[#334b83]"><input class="mt-1" type="radio" name="fq_${question.id}" value="${option[0]}" required><span><b>${option[0]}.</b> ${FastTrack.esc(option[1])}</span></label>`).join('')}</fieldset>`;
        }).join('')}<button class="h-10 rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white" type="submit">Submit Final Assessment</button></form>`;
        document.getElementById('finalAssessmentForm').addEventListener('submit', submitFinalAssessment);
    }
    function startFinalAssessment(enrollmentId) {
        finalAssessmentRunner.classList.remove('hidden');
        finalAssessmentRunner.innerHTML = '<p class="text-sm font-semibold text-[#334b83]">Starting final assessment...</p>';
        FastTrack.postJson('/api/fresher/enrollments/' + enrollmentId + '/final-assessment/start')
            .then(function (result) {
                const attempt = FastTrack.apiData(result, 'attempt') || {};
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
        FastTrack.postJson('/api/fresher/final-assessment/' + finalAttemptId + '/submit', { answers })
            .then(function (result) {
                const data = FastTrack.apiData(result) || {};
                const resultData = data.result || {};
                finalAssessmentRunner.innerHTML = `<div class="grid gap-5 md:grid-cols-[1fr_150px] md:items-center"><div><h2 class="text-lg font-bold text-[#061942]">Final Assessment Submitted</h2><p class="mt-2 text-sm text-[#334b83]">Score: <strong class="text-[#061942]">${FastTrack.esc(resultData.overall_score || 0)}%</strong>. Result: <strong class="text-[#061942]">${FastTrack.esc(resultData.result || '-')}</strong></p><a class="mt-5 inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" href="/fast-track/certificate">View Certificate</a></div><div class="mx-auto flex h-[120px] w-[120px] items-center justify-center rounded-full" style="background:conic-gradient(#075fe4 0 ${Number(resultData.overall_score || 0)}%, #e9edf5 ${Number(resultData.overall_score || 0)}% 100%);"><span class="flex h-[86px] w-[86px] items-center justify-center rounded-full bg-white text-xl font-black">${FastTrack.esc(resultData.overall_score || 0)}%</span></div></div>`;
            })
            .catch(function (error) { alert(error.message || 'Submit failed'); });
    }
    eligibleRows.addEventListener('click', function (event) {
        const button = event.target.closest('.start-final');
        if (!button?.dataset.id) return;
        startFinalAssessment(button.dataset.id);
    });
    FastTrack.enrollments()
        .then(function (enrollments) {
            finalEnrollments = enrollments || [];
            renderOverview(finalEnrollments);
            renderRows(finalEnrollments);
            renderSummary(finalEnrollments);
        })
        .catch(function (error) {
            finalSummary.innerHTML = '<p class="text-sm font-bold text-[#b42318]">' + FastTrack.esc(error.message || 'Final assessment data load nahi ho paaya.') + '</p>';
            assessmentOverview.innerHTML = '<p class="text-sm text-[#b42318]">Overview load nahi ho paaya.</p>';
            eligibleRows.innerHTML = '<tr><td class="px-4 py-5 text-[#b42318]" colspan="5">Trainings load nahi ho paaye.</td></tr>';
        });
</script>
@endpush
