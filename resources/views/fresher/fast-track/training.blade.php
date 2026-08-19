@extends('layouts.fast-track')

@section('title', 'My Training')

@php
    $activePage = 'training';
@endphp

@push('styles')
<style>
    .training-panel {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
    }

    .training-tabs {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        padding: 6px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .035);
    }

    .training-tab {
        border: 0 !important;
        border-radius: 7px;
        padding: 12px 16px;
        outline: none;
    }

    .training-tab:focus-visible {
        box-shadow: 0 0 0 3px rgba(7, 95, 228, .16);
    }

    .training-tab.text-\[\#075fe4\] {
        background: #eff5ff;
    }

    .training-card {
        display: grid;
        min-height: 226px;
        overflow: hidden;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .training-card:hover {
        transform: translateY(-2px);
        border-color: #a9c6f4;
        box-shadow: 0 18px 34px rgba(6, 25, 66, .08);
    }

    @media (min-width: 900px) {
        .training-card {
            grid-template-columns: 185px minmax(0, 1fr);
        }
    }

    .training-card-cover {
        position: relative;
        min-height: 150px;
        padding: 18px;
        background: linear-gradient(135deg, #071743, #dff5ff);
    }

    .training-card-cover::after {
        content: "";
        position: absolute;
        right: -36px;
        bottom: -42px;
        width: 118px;
        height: 118px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .22);
    }

    .training-progress-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        border-bottom: 1px solid #edf2fa;
        padding-bottom: 10px;
        color: #334b83;
        font-size: 13px;
    }

    .training-progress-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .learning-progress-card {
        display: grid;
        gap: 18px;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
    }

    @media (min-width: 900px) {
        .learning-progress-card {
            grid-template-columns: minmax(0, 1fr) 180px;
            align-items: center;
        }
    }
</style>
@endpush

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">My Training</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">Continue learning and track your enrolled courses.</p>
            </div>
            <a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" href="/fast-track/courses">Browse Courses</a>
        </div>

        <div class="training-tabs flex gap-2 overflow-x-auto">
            <button class="training-tab shrink-0 border-b-[3px] border-[#075fe4] pb-3 text-sm font-bold text-[#075fe4]" type="button" data-filter="all">Enrolled Courses</button>
            <button class="training-tab shrink-0 border-b-[3px] border-transparent pb-3 text-sm font-bold text-[#334b83]" type="button" data-filter="progress">Learning Progress</button>
            <button class="training-tab shrink-0 border-b-[3px] border-transparent pb-3 text-sm font-bold text-[#334b83]" type="button" data-filter="pending">Payment Pending</button>
        </div>

        <div class="grid gap-5 xl:grid-cols-2" id="trainingGrid">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center text-sm text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2 xl:col-span-4">Loading training...</article>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.05fr_1fr]">
            <article class="training-panel p-6">
                <h2 class="mb-6 flex items-center gap-3 text-lg font-bold text-[#061942]"><span class="grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg></span> Overall Progress</h2>
                <div id="overallTrainingProgress" class="text-sm text-[#334b83]">Loading overall progress...</div>
            </article>

            <article class="training-panel p-6">
                <h2 class="mb-5 flex items-center gap-3 text-lg font-bold text-[#061942]"><span class="grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M12 8v5l3 2"></path><circle cx="12" cy="12" r="9"></circle></svg></span> Recent Activity <a class="ml-auto text-xs font-bold text-[#075fe4]" href="/fast-track/training-progress">View All</a></h2>
                <div id="trainingActivity"><p class="text-sm text-[#334b83]">Loading activity...</p></div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const trainingGrid = document.getElementById('trainingGrid');
    const overallTrainingProgress = document.getElementById('overallTrainingProgress');
    const trainingActivity = document.getElementById('trainingActivity');
    let currentFilter = 'all';
    let trainingEnrollments = [];
    const trainingIcons = {
        course: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
        details: '<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><path d="m21 21-4.3-4.3"></path></svg>',
        training: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3Z"></path></svg>',
        complete: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>',
    };

    function trainingIcon(name, size = 'h-8 w-8') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${trainingIcons[name] || trainingIcons.training}</span>`;
    }

    function isPaid(enrollment) {
        return enrollment.payment_status === 'paid' || enrollment.enrollment_status === 'enrolled' || enrollment.enrollment_status === 'completed';
    }
    function badgeClass(enrollment, progress) {
        if (!isPaid(enrollment)) return 'bg-[#fff4df] text-[#b86500]';
        if (progress >= 100 || enrollment.training_status === 'completed') return 'bg-[#e6fff0] text-[#05843e]';
        return 'bg-[#eaf2ff] text-[#075fe4]';
    }
    function filteredEnrollments() {
        return trainingEnrollments.filter(function (enrollment) {
            const progress = FastTrack.progress(enrollment);
            if (currentFilter === 'progress') return progress > 0 || enrollment.training_status === 'in_progress';
            if (currentFilter === 'pending') return !isPaid(enrollment);
            return true;
        });
    }
    function renderCards() {
        const enrollments = filteredEnrollments();
        if (!enrollments.length) {
            trainingGrid.innerHTML = '<div class="sm:col-span-2 xl:col-span-4">' + FastTrack.emptyState(currentFilter === 'pending' ? 'No pending payments' : 'No training enrolled yet', currentFilter === 'pending' ? 'All visible enrollments are paid.' : 'Enroll in a Fast Track course to unlock training progress.', '/fast-track/courses', 'Browse Courses') + '</div>';
            return;
        }

        if (currentFilter === 'progress') {
            trainingGrid.innerHTML = enrollments.map(function (enrollment) {
                const course = FastTrack.course(enrollment);
                const title = FastTrack.courseName(course);
                const progress = FastTrack.progress(enrollment);
                const status = progress >= 100 ? 'Completed' : (progress > 0 ? 'In Progress' : 'Not Started');
                return `
                    <article class="learning-progress-card xl:col-span-2">
                        <div class="min-w-0">
                            <div class="mb-3 flex flex-wrap items-center gap-3">
                                ${trainingIcon(progress >= 100 ? 'complete' : 'training', 'h-10 w-10')}
                                <div class="min-w-0">
                                    <h3 class="truncate text-lg font-bold text-[#061942]">${FastTrack.esc(title)}</h3>
                                    <p class="mt-1 text-sm text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                                </div>
                            </div>
                            <div class="mb-3 h-3 overflow-hidden rounded-full bg-[#e9edf5]">
                                <span class="block h-full rounded-full bg-[linear-gradient(90deg,#075fe4,#17a6a8)]" style="width:${progress}%;"></span>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-bold text-[#334b83]">
                                <span>${progress}% Complete</span>
                                <span>${FastTrack.esc(status)}</span>
                                <span>Updated ${FastTrack.date(enrollment.updated_at || enrollment.enrollment_date)}</span>
                            </div>
                        </div>
                        <a class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white" href="/fast-track/training-progress">View Full Progress</a>
                    </article>`;
            }).join('');
            return;
        }

        trainingGrid.innerHTML = enrollments.map(function (enrollment, index) {
            const course = FastTrack.course(enrollment);
            const title = FastTrack.courseName(course);
            const progress = FastTrack.progress(enrollment);
            const paid = isPaid(enrollment);
            return `
                <article class="training-card" data-progress="${progress}" data-paid="${paid ? 'yes' : 'no'}">
                    <div class="training-card-cover" style="background:linear-gradient(135deg, ${index % 3 === 0 ? '#071743' : index % 3 === 1 ? '#6041db' : '#0a8f9d'}, #dff5ff);">
                        <div class="relative z-10 flex h-full flex-col justify-between">
                            <div class="flex items-start justify-between gap-3">
                                <span class="inline-flex rounded-lg ${badgeClass(enrollment, progress)} px-3 py-1.5 text-xs font-bold">${paid ? FastTrack.statusText(enrollment.training_status || 'not_started') : 'Payment Pending'}</span>
                                <span class="rounded-full bg-white px-3 py-2 text-xs font-bold text-[#075fe4]">${progress}%</span>
                            </div>
                            <div class="grid h-14 w-14 place-items-center rounded-xl bg-white/15 text-white backdrop-blur-sm [&>svg]:h-8 [&>svg]:w-8 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${trainingIcons.course}</div>
                        </div>
                    </div>
                    <div class="flex min-w-0 flex-col p-5">
                        <div class="mb-4 flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="mb-2 truncate text-lg font-bold text-[#061942]">${FastTrack.esc(title)}</h3>
                                <p class="line-clamp-2 text-sm leading-6 text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                            </div>
                        </div>
                        <div class="mb-3 h-2 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#075fe4]" style="width:${progress}%;"></span></div>
                        <div class="mb-4 flex items-center justify-between gap-4 text-xs font-bold text-[#334b83]">
                            <span>${progress}% Completed</span>
                            <span>${paid ? 'Unlocked' : 'Payment required'}</span>
                        </div>
                        <div class="mt-auto grid grid-cols-[1fr_44px] gap-3">
                            <a class="inline-flex h-[38px] items-center justify-center rounded-lg border border-[#075fe4] text-sm font-bold ${paid ? 'bg-[#075fe4] text-white' : 'bg-white text-[#075fe4]'}" href="${paid ? '/fast-track/training-progress' : '/fast-track/course-details?course=' + encodeURIComponent(course.id || '')}">${paid ? 'Continue Learning' : 'Pay Now'}</a>
                            <a class="grid h-[38px] place-items-center rounded-lg border border-[#dce7f8] bg-white text-[#061942] hover:bg-[#f5f8ff] [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]" href="/fast-track/course-details?course=${encodeURIComponent(course.id || '')}" aria-label="Course details">${trainingIcons.details}</a>
                        </div>
                    </div>
                </article>`;
        }).join('');
    }
    function renderOverall() {
        const total = trainingEnrollments.length;
        const completed = trainingEnrollments.filter((item) => item.training_status === 'completed' || FastTrack.progress(item) >= 100).length;
        const inProgress = trainingEnrollments.filter((item) => FastTrack.progress(item) > 0 && FastTrack.progress(item) < 100).length;
        const paid = trainingEnrollments.filter(isPaid).length;
        const avg = total ? Math.round(trainingEnrollments.reduce((sum, item) => sum + FastTrack.progress(item), 0) / total) : 0;

        overallTrainingProgress.innerHTML = `<div class="grid items-center gap-7 md:grid-cols-[180px_minmax(0,1fr)]">
            <div class="flex h-[150px] w-[150px] items-center justify-center rounded-full" style="background:conic-gradient(#075fe4 0 ${avg}%, #e9edf5 ${avg}% 100%);">
                <span class="flex h-[110px] w-[110px] flex-col items-center justify-center rounded-full bg-white text-center text-[26px] font-black leading-tight text-[#061942]">${avg}%<small class="text-xs font-bold text-[#536484]">Overall</small></span>
            </div>
            <div class="grid gap-4">
                <p class="text-sm font-medium text-[#334b83]">${total ? 'Keep going! Your training progress is updating from partner records.' : 'Enroll in a course to start your training journey.'}</p>
                <div class="grid gap-3">
                    <div class="training-progress-row"><span>Courses Enrolled</span><strong>${total}</strong></div>
                    <div class="training-progress-row"><span>Paid Enrollments</span><strong>${paid}</strong></div>
                    <div class="training-progress-row"><span>In Progress</span><strong>${inProgress}</strong></div>
                    <div class="training-progress-row"><span>Courses Completed</span><strong>${completed}</strong></div>
                </div>
            </div>
        </div>`;
    }
    function renderActivity() {
        if (!trainingEnrollments.length) {
            trainingActivity.innerHTML = '<p class="text-sm text-[#334b83]">No training activity yet.</p>';
            return;
        }
        trainingActivity.innerHTML = trainingEnrollments.slice(0, 5).map(function (enrollment) {
            const course = FastTrack.course(enrollment);
            const progress = FastTrack.progress(enrollment);
            const title = progress >= 100 ? 'Training completed' : (progress > 0 ? 'Training progress updated' : 'Course enrollment created');
            return `<div class="grid grid-cols-[38px_minmax(0,1fr)] items-center gap-4 border-b border-[#e6eef8] py-3 last:border-b-0 sm:grid-cols-[38px_minmax(0,1fr)_auto]">
                ${trainingIcon(progress >= 100 ? 'complete' : 'training')}
                <div><h3 class="mb-1 text-sm font-bold text-[#061942]">${FastTrack.esc(title)}</h3><p class="text-xs text-[#536484]">${FastTrack.esc(FastTrack.courseName(course))}</p></div>
                <time class="col-start-2 text-xs text-[#536484] sm:col-start-auto">${FastTrack.date(enrollment.updated_at || enrollment.enrollment_date)}</time>
            </div>`;
        }).join('');
    }
    function renderTraining() {
        renderCards();
        renderOverall();
        renderActivity();
    }
    document.querySelectorAll('.training-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.training-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#334b83]');
            });
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            tab.classList.remove('border-transparent', 'text-[#334b83]');
            currentFilter = tab.dataset.filter;
            renderCards();
        });
    });
    FastTrack.enrollments()
        .then(function (enrollments) {
            trainingEnrollments = enrollments || [];
            renderTraining();
        })
        .catch(function (error) {
            trainingGrid.innerHTML = '<div class="sm:col-span-2 xl:col-span-4">' + FastTrack.emptyState('Training load nahi ho paayi', error.message || 'Please retry after login.', '/fast-track/courses', 'Browse Courses') + '</div>';
            overallTrainingProgress.innerHTML = '<p class="text-sm text-[#b42318]">Training summary load nahi ho paayi.</p>';
            trainingActivity.innerHTML = '<p class="text-sm text-[#b42318]">Training activity load nahi ho paayi.</p>';
        });
</script>
@endpush
