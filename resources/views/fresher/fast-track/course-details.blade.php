@extends('layouts.fast-track')

@section('title', 'Course Details')

@php
    $activePage = 'details';
@endphp

@push('styles')
<style>
    .course-detail-shell {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
    }

    .course-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff 0%, #f4f8ff 100%);
    }

    .course-hero::after {
        content: "";
        position: absolute;
        inset: 0 0 auto auto;
        width: 220px;
        height: 220px;
        border-radius: 999px;
        background: rgba(7, 95, 228, .07);
        transform: translate(70px, -95px);
        pointer-events: none;
    }

    .course-hero > * {
        position: relative;
        z-index: 1;
    }

    .course-cover {
        display: grid;
        height: 136px;
        width: 136px;
        place-items: center;
        border-radius: 8px;
        background: #071743;
        color: #fff;
        box-shadow: 0 16px 32px rgba(6, 25, 66, .14);
    }

    .course-detail-grid {
        display: grid;
        gap: 12px;
    }

    @media (min-width: 768px) {
        .course-detail-grid {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }
    }

    .course-fact {
        border-radius: 8px;
        background: rgba(255, 255, 255, .75);
        padding: 12px;
    }

    .course-fact span {
        display: block;
        color: #526287;
        font-size: 12px;
        font-weight: 700;
    }

    .course-fact b {
        display: block;
        min-width: 0;
        overflow: hidden;
        margin-top: 7px;
        color: #061942;
        font-size: 14px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .course-action-box {
        border-radius: 8px;
        border: 1px solid #dce7f8;
        background: #fff;
        padding: 18px;
    }

    .course-tab {
        position: relative;
        border-bottom: 0 !important;
    }

    .course-tab::after {
        content: "";
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        height: 3px;
        border-radius: 999px 999px 0 0;
        background: transparent;
    }

    .course-tab.text-\[\#075fe4\]::after {
        background: #075fe4;
    }

    .highlight-row {
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
        border-bottom: 1px solid #e6eef8;
        padding: 16px 0;
    }

    .highlight-row:last-child {
        border-bottom: 0;
    }
</style>
@endpush

@section('content')
    <section class="space-y-6">
        <a class="inline-flex items-center gap-2 text-sm font-bold text-[#075fe4] hover:text-[#064fc0]" href="/fast-track/courses">
            <span aria-hidden="true">&lt;</span>
            Back to Courses
        </a>

        <div>
            <h1 class="text-[26px] font-bold leading-tight text-[#061942]">Course Details</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Explore course details, curriculum, partner information, and enrollment status.</p>
        </div>

        <div id="courseMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <article id="courseDetailsHero" class="course-detail-shell course-hero grid gap-7 p-6 xl:grid-cols-[154px_minmax(0,1fr)_300px] xl:items-center">
            <div class="text-sm text-[#334b83] xl:col-span-3">Loading course details...</div>
        </article>

        <div class="grid gap-6 xl:grid-cols-[1.25fr_1fr]">
            <article class="course-detail-shell overflow-hidden">
                <div class="flex gap-7 overflow-x-auto border-b border-[#dce7f8] bg-[#fbfdff] px-6">
                    @foreach (['about' => 'About Course', 'curriculum' => 'Curriculum', 'partner' => 'Partner', 'faqs' => 'FAQs'] as $key => $label)
                        <button class="course-tab shrink-0 border-b-[3px] px-0 py-4 text-sm font-bold {{ $loop->first ? 'border-[#075fe4] text-[#075fe4]' : 'border-transparent text-[#334b83]' }}" type="button" data-tab="{{ $key }}">{{ $label }}</button>
                    @endforeach
                </div>

                <div class="min-h-[305px] p-6 sm:p-7">
                    <div class="course-panel" data-panel="about"><p class="text-sm text-[#334b83]">Loading...</p></div>
                    <div class="course-panel hidden" data-panel="curriculum"><p class="text-sm text-[#334b83]">Loading...</p></div>
                    <div class="course-panel hidden" data-panel="partner"><p class="text-sm text-[#334b83]">Loading...</p></div>
                    <div class="course-panel hidden" data-panel="faqs"><p class="text-sm text-[#334b83]">Loading...</p></div>
                </div>
            </article>

            <article class="course-detail-shell p-6 sm:p-7">
                <h2 class="mb-4 text-base font-bold text-[#061942]">Course Highlights</h2>
                <div id="courseHighlights"><p class="text-sm text-[#334b83]">Loading highlights...</p></div>
            </article>
        </div>

        <article class="course-detail-shell p-5 sm:p-6">
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const courseDetailsHero = document.getElementById('courseDetailsHero');
    const courseMessage = document.getElementById('courseMessage');
    const courseHighlights = document.getElementById('courseHighlights');
    const selectedCourseId = FastTrack.selectedCourseId();
    let currentCourse = null;
    let currentEnrollment = null;
    const detailIcons = {
        course: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
        institute: '<svg viewBox="0 0 24 24"><path d="M3 21h18"></path><path d="M5 21V8l7-4 7 4v13"></path><path d="M9 21v-6h6v6"></path><path d="M9 10h.01M12 10h.01M15 10h.01"></path></svg>',
        mode: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M8 21h8"></path><path d="M12 17v4"></path></svg>',
        support: '<svg viewBox="0 0 24 24"><path d="M4 12a8 8 0 0 1 16 0"></path><path d="M4 12v4a2 2 0 0 0 2 2h1v-7H6a2 2 0 0 0-2 2Z"></path><path d="M20 12v4a2 2 0 0 1-2 2h-1v-7h1a2 2 0 0 1 2 2Z"></path><path d="M13 20h3a4 4 0 0 0 4-4"></path></svg>',
        certificate: '<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3Z"></path><path d="M9 8h6M9 12h6"></path></svg>',
    };

    function detailIcon(name, size = 'h-10 w-10') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${detailIcons[name] || detailIcons.course}</span>`;
    }

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
            ['institute', 'Approved Training Partner', FastTrack.partnerName(course)],
            ['mode', 'Learning Mode', FastTrack.courseMode(course)],
            ['support', 'Career Support', 'Fast Track job-ready training'],
            ['certificate', 'Certificate Path', 'Training + final assessment'],
        ].map((item) => `<div class="highlight-row">${detailIcon(item[0])}<div><h3 class="mb-1.5 text-sm font-bold text-[#061942]">${FastTrack.esc(item[1])}</h3><p class="text-xs leading-5 text-[#536484]">${FastTrack.esc(item[2])}</p></div></div>`).join('');
    }
    function renderHero(course) {
        const title = FastTrack.courseName(course);
        const status = enrollmentStatus();
        courseDetailsHero.innerHTML = `
            <div class="course-cover [&>svg]:h-16 [&>svg]:w-16 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${detailIcons.course}</div>
            <div class="min-w-0">
                <h2 class="mb-3 flex flex-wrap items-center gap-2 text-xl font-bold text-[#061942]">
                    <span>${FastTrack.esc(title)}</span>
                    <span class="inline-flex rounded-md bg-[#eee7ff] px-2.5 py-1 text-[11px] font-bold text-[#7744eb]">${FastTrack.esc(status.label)}</span>
                </h2>
                <p class="mb-6 text-sm leading-6 text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                <div class="course-detail-grid">
                    <div class="course-fact"><span>Duration</span><b>${FastTrack.esc(FastTrack.courseDuration(course))}</b></div>
                    <div class="course-fact"><span>Fees</span><b>${FastTrack.money(fee(course))}</b></div>
                    <div class="course-fact"><span>Mode</span><b class="capitalize">${FastTrack.esc(FastTrack.courseMode(course))}</b></div>
                    <div class="course-fact"><span>Partner</span><b>${FastTrack.esc(FastTrack.partnerName(course))}</b></div>
                    <div class="course-fact"><span>Certificate</span><b>Yes</b></div>
                </div>
            </div>
            <div class="course-action-box">
                <p class="mb-4 text-left text-xs font-bold uppercase text-[#526287]">Enrollment Action</p>
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
        const payButton = document.getElementById('payBtn');
        if (payButton) {
            payButton.disabled = true;
            payButton.textContent = 'Processing...';
        }
        showMessage('Creating secure payment order...');

        FastTrack.postJson('/api/payments/razorpay/order', {
            purpose: 'course_enrollment',
            course_enrollment_id: currentEnrollment.id,
        }).then(function (result) {
            const order = FastTrack.apiData(result) || {};

            if (!window.Razorpay) {
                throw new Error('Razorpay checkout could not be loaded. Please refresh and try again.');
            }

            const checkout = new Razorpay({
                key: order.key,
                amount: order.amount,
                currency: order.currency,
                order_id: order.razorpay_order_id,
                name: order.name,
                description: order.description,
                prefill: order.prefill || {},
                method: {
                    card: true,
                    netbanking: true,
                    wallet: true,
                    upi: true,
                },
                handler: function (response) {
                    showMessage('Verifying payment...');
                    FastTrack.postJson('/api/payments/razorpay/verify', {
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                    }).then(function (verifyResult) {
                        currentEnrollment.payment_status = 'paid';
                        currentEnrollment.enrollment_status = 'enrolled';
                        showMessage('Payment successful. Training unlocked.');
                        refreshCourse();
                        const redirectTo = FastTrack.apiData(verifyResult, 'redirect_to');
                        if (redirectTo) window.location.href = redirectTo;
                    }).catch(function (error) {
                        showMessage(error.message || 'Payment verification failed.', 'error');
                        if (payButton) {
                            payButton.disabled = false;
                            payButton.textContent = 'Retry Payment';
                        }
                    });
                },
                modal: {
                    ondismiss: function () {
                        showMessage('Payment was cancelled. You can retry anytime.', 'error');
                        if (payButton) {
                            payButton.disabled = false;
                            payButton.textContent = 'Retry Payment';
                        }
                    },
                },
            });

            checkout.open();
        }).catch(function (error) {
            if (/already/i.test(error.message || '')) {
                currentEnrollment.payment_status = 'paid';
                currentEnrollment.enrollment_status = 'enrolled';
                showMessage('Payment already completed. Training unlocked.');
                refreshCourse();
                return;
            }
            showMessage(error.message || 'Payment failed.', 'error');
            if (payButton) {
                payButton.disabled = false;
                payButton.textContent = 'Retry Payment';
            }
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
