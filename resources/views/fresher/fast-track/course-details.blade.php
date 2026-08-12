@extends('layouts.fast-track')

@section('title', 'Course Details')

@php
    $activePage = 'details';
@endphp

@section('content')
    <section class="space-y-5">
        <a class="inline-flex text-sm font-bold text-[#075fe4] hover:text-[#064fc0]" href="/fast-track/courses">&lt; Back to Courses</a>

        <div>
            <h1 class="text-[26px] font-bold leading-tight text-[#061942]">Course Details</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Explore course details, curriculum, partner information, and enrollment status.</p>
        </div>

        <div id="courseMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <article id="courseDetailsHero" class="grid gap-7 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] xl:grid-cols-[140px_minmax(0,1fr)_300px] xl:items-center">
            <div class="text-sm text-[#334b83] xl:col-span-3">Loading course details...</div>
        </article>

        <div class="grid gap-5 xl:grid-cols-[1.25fr_1fr]">
            <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <div class="flex gap-7 overflow-x-auto border-b border-[#dce7f8] px-5">
                    @foreach (['about' => 'About Course', 'curriculum' => 'Curriculum', 'partner' => 'Partner', 'faqs' => 'FAQs'] as $key => $label)
                        <button class="course-tab shrink-0 border-b-[3px] px-0 py-4 text-sm font-bold {{ $loop->first ? 'border-[#075fe4] text-[#075fe4]' : 'border-transparent text-[#334b83]' }}" type="button" data-tab="{{ $key }}">{{ $label }}</button>
                    @endforeach
                </div>

                <div class="min-h-[270px] p-6">
                    <div class="course-panel" data-panel="about"><p class="text-sm text-[#334b83]">Loading...</p></div>
                    <div class="course-panel hidden" data-panel="curriculum"><p class="text-sm text-[#334b83]">Loading...</p></div>
                    <div class="course-panel hidden" data-panel="partner"><p class="text-sm text-[#334b83]">Loading...</p></div>
                    <div class="course-panel hidden" data-panel="faqs"><p class="text-sm text-[#334b83]">Loading...</p></div>
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-4 text-base font-bold text-[#061942]">Course Highlights</h2>
                <div id="courseHighlights"><p class="text-sm text-[#334b83]">Loading highlights...</p></div>
            </article>
        </div>

        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:p-6">
            <h2 class="mb-5 text-base font-bold text-[#061942]">Who Should Enroll?</h2>
            <div class="flex flex-wrap gap-4 sm:gap-5">
                @foreach (['Freshers', 'Engineering Students', 'Career Switchers', 'Working Professionals'] as $item)
                    <span class="inline-flex min-h-[42px] min-w-[160px] items-center justify-center rounded-lg border border-[#dce7f8] px-4 text-sm font-bold text-[#075fe4]">{{ $item }}</span>
                @endforeach
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const courseDetailsHero = document.getElementById('courseDetailsHero');
    const courseMessage = document.getElementById('courseMessage');
    const courseHighlights = document.getElementById('courseHighlights');
    const selectedCourseId = FastTrack.selectedCourseId();
    let currentCourse = null;
    let currentEnrollment = null;

    document.querySelectorAll('.course-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.course-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#334b83]');
            });
            document.querySelectorAll('.course-panel').forEach(function (panel) {
                panel.classList.add('hidden');
            });
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            tab.classList.remove('border-transparent', 'text-[#334b83]');
            document.querySelector('[data-panel="' + tab.dataset.tab + '"]').classList.remove('hidden');
        });
    });

    function fee(course) { return course.fees || course.fee || course.price || course.course_fee || course.amount; }
    function showMessage(message, type = 'success') {
        courseMessage.textContent = message;
        courseMessage.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }
    function skills(course) {
        return String(course.skills_covered || course.skills || course.curriculum || '').split(/,|\n/).map((item) => item.trim()).filter(Boolean);
    }
    function enrollmentStatus() {
        if (!currentEnrollment) return { label: 'Not Enrolled', paid: false, enrolled: false };
        return {
            label: FastTrack.statusText(currentEnrollment.payment_status === 'paid' ? 'paid' : currentEnrollment.enrollment_status),
            paid: currentEnrollment.payment_status === 'paid',
            enrolled: true,
        };
    }
    function renderPanels(course) {
        const partner = course.training_partner_profile || {};
        const skillList = skills(course);
        document.querySelector('[data-panel="about"]').innerHTML = `
            <h3 class="mb-3 text-base font-bold text-[#061942]">About this Course</h3>
            <p class="mb-5 text-sm leading-7 text-[#061942]">${FastTrack.esc(FastTrack.courseText(course))}</p>
            <h3 class="mb-4 text-base font-bold text-[#061942]">What You Will Learn</h3>
            <div class="grid gap-x-9 gap-y-3 sm:grid-cols-2">${skillList.length ? skillList.slice(0, 12).map((item) => `<div class="flex items-center gap-2 text-sm font-medium text-[#061942]"><span class="font-black text-[#0a8f3f]">✓</span><span>${FastTrack.esc(item)}</span></div>`).join('') : '<div class="text-sm text-[#334b83]">Curriculum will be shared by the training partner.</div>'}</div>`;
        document.querySelector('[data-panel="curriculum"]').innerHTML = `<h3 class="mb-3 text-base font-bold text-[#061942]">Curriculum</h3><p class="text-sm leading-7 text-[#061942]">${FastTrack.esc(course.skills_covered || 'Detailed curriculum will be shared after enrollment.')}</p>`;
        document.querySelector('[data-panel="partner"]').innerHTML = `<h3 class="mb-3 text-base font-bold text-[#061942]">${FastTrack.esc(FastTrack.partnerName(course))}</h3><p class="text-sm leading-7 text-[#061942]">${FastTrack.esc(partner.about_institute || 'Approved OnlyFreshers training partner.')}</p><div class="mt-4 grid gap-3 sm:grid-cols-2"><span class="text-sm text-[#334b83]">Location <b class="block text-[#061942]">${FastTrack.esc(partner.location || '-')}</b></span><span class="text-sm text-[#334b83]">Website <b class="block text-[#061942]">${FastTrack.esc(partner.website || '-')}</b></span></div>`;
        document.querySelector('[data-panel="faqs"]').innerHTML = '<h3 class="mb-3 text-base font-bold text-[#061942]">FAQs</h3><p class="text-sm leading-7 text-[#061942]">Enroll in the course, complete payment, track training progress, then unlock final assessment and certificate.</p>';

        courseHighlights.innerHTML = [
            ['IM', 'Approved Training Partner', FastTrack.partnerName(course)],
            ['LS', 'Learning Mode', FastTrack.courseMode(course)],
            ['PA', 'Career Support', 'Fast Track job-ready training'],
            ['IC', 'Certificate Path', 'Training + final assessment'],
        ].map((item) => `<div class="grid grid-cols-[40px_minmax(0,1fr)] gap-4 border-b border-[#e6eef8] py-4 last:border-b-0"><span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">${item[0]}</span><div><h3 class="mb-1.5 text-sm font-bold text-[#061942]">${FastTrack.esc(item[1])}</h3><p class="text-xs leading-5 text-[#536484]">${FastTrack.esc(item[2])}</p></div></div>`).join('');
    }
    function renderHero(course) {
        const title = FastTrack.courseName(course);
        const status = enrollmentStatus();
        courseDetailsHero.innerHTML = `
            <div class="grid h-[126px] w-[126px] place-items-center rounded-lg bg-[#071743] text-3xl font-black text-white">${FastTrack.initials(title)}</div>
            <div class="min-w-0">
                <h2 class="mb-3 flex flex-wrap items-center gap-2 text-xl font-bold text-[#061942]">
                    <span>${FastTrack.esc(title)}</span>
                    <span class="inline-flex rounded-md bg-[#eee7ff] px-2.5 py-1 text-[11px] font-bold text-[#7744eb]">${FastTrack.esc(status.label)}</span>
                </h2>
                <p class="mb-6 text-sm leading-6 text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                <div class="grid gap-4 text-xs text-[#334b83] sm:grid-cols-2 lg:grid-cols-5">
                    <span>Duration<b class="mt-2 block text-sm font-bold text-[#061942]">${FastTrack.esc(FastTrack.courseDuration(course))}</b></span>
                    <span>Fees<b class="mt-2 block text-sm font-bold text-[#061942]">${FastTrack.money(fee(course))}</b></span>
                    <span>Mode<b class="mt-2 block text-sm font-bold capitalize text-[#061942]">${FastTrack.esc(FastTrack.courseMode(course))}</b></span>
                    <span>Partner<b class="mt-2 block truncate text-sm font-bold text-[#061942]">${FastTrack.esc(FastTrack.partnerName(course))}</b></span>
                    <span>Certificate<b class="mt-2 block text-sm font-bold text-[#061942]">Yes</b></span>
                </div>
            </div>
            <div class="border-t border-[#dce7f8] pt-5 text-center xl:border-l xl:border-t-0 xl:pl-6 xl:pt-0">
                <button id="enrollBtn" class="${status.enrolled ? 'hidden' : 'inline-flex'} mb-3 h-[42px] w-full items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#064fc0]" type="button">Enroll Now</button>
                <button id="payBtn" class="${status.enrolled && !status.paid ? 'inline-flex' : 'hidden'} mb-3 h-[42px] w-full items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#064fc0]" type="button">Pay & Confirm</button>
                <a id="trainingBtn" class="${status.paid ? 'inline-flex' : 'hidden'} mb-3 h-[42px] w-full items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#064fc0]" href="/fast-track/training">Go to Training</a>
                <a class="inline-flex h-[42px] w-full items-center justify-center rounded-lg border border-[#075fe4] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" href="/fast-track/training-progress">Training Progress</a>
            </div>`;
        document.getElementById('enrollBtn')?.addEventListener('click', enrollCourse);
        document.getElementById('payBtn')?.addEventListener('click', payCourse);
    }
    function refreshCourse() {
        renderHero(currentCourse);
        renderPanels(currentCourse);
    }
    function loadEnrollmentState(courseId) {
        return FastTrack.enrollments().then(function (enrollments) {
            currentEnrollment = enrollments.find((item) => String(item.course_id || item.course?.id) === String(courseId)) || null;
        }).catch(function () {
            currentEnrollment = null;
        });
    }
    function enrollCourse() {
        showMessage('Creating enrollment...');
        FastTrack.postJson('/api/fresher/courses/' + currentCourse.id + '/enroll')
            .then(function (result) {
                currentEnrollment = FastTrack.apiData(result, 'enrollment') || null;
                showMessage('Enrollment created. Please complete payment to unlock training.');
                refreshCourse();
            })
            .catch(function (error) {
                const existing = error.data?.data?.enrollment;
                if (existing?.id) {
                    currentEnrollment = existing;
                    showMessage('You are already enrolled in this course.');
                    refreshCourse();
                    return;
                }
                showMessage(error.message || 'Enrollment failed.', 'error');
            });
    }
    function payCourse() {
        if (!currentEnrollment?.id) return;
        showMessage('Confirming payment...');
        FastTrack.postJson('/api/fresher/enrollments/' + currentEnrollment.id + '/payment', {
            transaction_id: 'FT-' + Date.now(),
            payment_status: 'success',
        }).then(function (result) {
            const paymentData = FastTrack.apiData(result) || {};
            currentEnrollment = paymentData.enrollment || currentEnrollment;
            currentEnrollment.payment_status = 'paid';
            currentEnrollment.enrollment_status = 'enrolled';
            showMessage('Payment successful. Training unlocked.');
            refreshCourse();
        }).catch(function (error) {
            if (/already/i.test(error.message || '')) {
                currentEnrollment.payment_status = 'paid';
                currentEnrollment.enrollment_status = 'enrolled';
                showMessage('Payment already completed. Training unlocked.');
                refreshCourse();
                return;
            }
            showMessage(error.message || 'Payment failed.', 'error');
        });
    }
    function loadCourse() {
        const request = selectedCourseId ? FastTrack.getJson('/api/courses/' + selectedCourseId) : FastTrack.getJson('/api/courses');
        request.then(function (result) {
            currentCourse = selectedCourseId ? FastTrack.apiData(result, 'course') : ((FastTrack.apiData(result, 'courses') || [])[0]);
            if (!currentCourse) throw new Error('Course not found.');
            FastTrack.rememberCourse(currentCourse.id);
            return loadEnrollmentState(currentCourse.id);
        }).then(refreshCourse).catch(function (error) {
            courseDetailsHero.innerHTML = '<div class="xl:col-span-3">' + FastTrack.emptyState('Course details load nahi ho paaye', error.message || 'Please open a course from listing.', '/fast-track/courses', 'Back to Courses') + '</div>';
        });
    }
    loadCourse();
</script>
@endpush
