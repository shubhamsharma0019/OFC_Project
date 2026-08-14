@extends('layouts.public')

@section('title', 'Fast Track Program - OnlyFreshers')

@php
    $activePage = 'fast-track';

    $points = [
        ['icon' => 'learn', 'text' => 'Industry-relevant learning'],
        ['icon' => 'users', 'text' => 'Expert training partners'],
        ['icon' => 'certificate', 'text' => 'Final assessment & certificate'],
        ['icon' => 'briefcase', 'text' => 'Better job opportunities'],
    ];
@endphp

@section('content')
    <section class="relative overflow-hidden bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-10 lg:py-[55px]">
        <div class="pointer-events-none absolute -left-24 top-1/2 hidden h-[300px] w-[430px] -translate-y-1/2 rounded-full bg-[#dcecff]/65 blur-3xl lg:block"></div>
        <div class="pointer-events-none absolute left-0 top-0 hidden h-full w-[46%] bg-[radial-gradient(circle_at_14%_28%,rgba(207,228,255,0.48)_0%,rgba(244,249,255,0.42)_34%,rgba(255,255,255,0)_72%)] lg:block"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-[52%] bg-[radial-gradient(circle_at_78%_28%,rgba(207,228,255,0.56)_0%,rgba(244,248,255,0.48)_38%,rgba(255,255,255,0)_76%)] lg:block"></div>
        <div class="relative mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-2 lg:gap-[50px] lg:px-8">
            <div class="text-center lg:text-left">
                <h1 class="m-0 text-[40px] font-semibold leading-[1.08] text-[#061942] sm:text-5xl lg:text-[54px]">
                    Fast Track <span class="text-[#075fe4]">Program</span>
                </h1>
                <p class="mt-[18px] max-w-2xl text-lg font-medium leading-[1.7] text-[#34445e] lg:text-[19px]">
                    Learn in-demand skills, get trained by verified partners, and become job-ready.
                </p>
                <div id="fastTrackStats" class="mt-7 grid gap-4 sm:grid-cols-3">
                    <article class="rounded-xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#edf5ff)] p-4 shadow-[0_14px_30px_rgba(7,95,228,0.11)]"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Active Courses</span></article>
                    <article class="rounded-xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#edf5ff)] p-4 shadow-[0_14px_30px_rgba(7,95,228,0.11)]"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Training Partners</span></article>
                    <article class="rounded-xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#edf5ff)] p-4 shadow-[0_14px_30px_rgba(7,95,228,0.11)]"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Fast Track Jobs</span></article>
                </div>
            </div>

            <div class="flex min-h-[240px] items-center justify-center lg:min-h-[260px]">
                <img src="{{ asset('fast-track-hero-girl.png') }}" alt="Fast Track student learning online" class="block h-[260px] w-full max-w-[560px] rounded-lg object-cover object-center shadow-[0_18px_40px_rgba(6,25,66,0.08)] sm:h-[300px] lg:h-[330px]">
            </div>
        </div>
    </section>

    <section class="bg-white pb-10 pt-10">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <h2 class="mb-9 text-center text-2xl font-semibold text-[#061942]">Explore Career Tracks</h2>

            <div id="careerTracks" class="grid gap-8 lg:grid-cols-3">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">Loading career tracks...</article>
            </div>
        </div>
    </section>

    <section class="bg-white pb-[55px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl border border-[#cfe0ff] bg-[linear-gradient(135deg,#eef5ff,#f8fbff)] px-5 py-7 text-center shadow-[0_20px_44px_rgba(7,95,228,0.11)] sm:px-8">
                <span class="pointer-events-none absolute -left-16 -top-20 h-44 w-44 rounded-full bg-[#dcecff]/80 blur-3xl"></span>
                <span class="pointer-events-none absolute -right-16 -bottom-20 h-48 w-48 rounded-full bg-[#cfe4ff]/80 blur-3xl"></span>
                <div class="relative mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($points as $point)
                        <div class="group flex min-h-[96px] items-center gap-4 rounded-xl border border-white/80 bg-white/72 p-4 text-left text-[15px] font-bold text-[#061942] shadow-[inset_0_1px_0_rgba(255,255,255,0.95),0_12px_24px_rgba(7,95,228,0.08)] backdrop-blur transition hover:-translate-y-0.5 hover:shadow-[inset_0_1px_0_rgba(255,255,255,0.95),0_18px_32px_rgba(7,95,228,0.13)]">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[linear-gradient(135deg,#075fe4,#17a6a8)] text-white shadow-[0_10px_20px_rgba(7,95,228,0.2)] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $point['icon']])</span>
                            <span>{{ $point['text'] }}</span>
                        </div>
                    @endforeach
                </div>

                <a href="/fast-track/register" class="relative inline-flex h-12 items-center justify-center rounded-xl bg-[#075fe4] px-8 text-sm font-bold text-white shadow-[0_14px_28px_rgba(7,95,228,0.24)] transition hover:-translate-y-0.5 hover:bg-[#0554cc]">
                    Start Your Fast Track Journey ->
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const fastTrackStats = document.getElementById('fastTrackStats');
    const careerTracks = document.getElementById('careerTracks');

    function esc(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char]);
    }

    function dataOf(result, key) {
        return result && result.data ? (key ? result.data[key] : result.data) : result;
    }

    function initials(value) {
        return String(value || 'FT').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'FT';
    }

    async function getJson(url) {
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Request failed');
        return result;
    }

    function skillTags(course) {
        return String(course.skills_covered || course.category || '').split(/[,|]/).map((skill) => skill.trim()).filter(Boolean).slice(0, 4);
    }

    function renderStats(courses, partners, jobs) {
        const icons = {
            courses: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
            partners: '<svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><path d="M14 8h7M14 12h7M14 16h5"></path></svg>',
            jobs: '<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="13" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M4 13h16"></path></svg>',
        };
        fastTrackStats.innerHTML = [
            [icons.courses, 'Active Courses', courses.length],
            [icons.partners, 'Training Partners', partners.length],
            [icons.jobs, 'Fast Track Jobs', jobs.length],
        ].map((item) => `<article class="group relative overflow-hidden rounded-xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#edf5ff)] p-4 shadow-[0_14px_30px_rgba(7,95,228,0.11)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_36px_rgba(7,95,228,0.16)]">
            <span class="pointer-events-none absolute inset-x-0 bottom-0 h-1 bg-[#075fe4]"></span>
            <span class="pointer-events-none absolute -right-7 -top-8 h-24 w-24 rounded-full bg-[#d7e8ff]/80 blur-2xl"></span>
            <span class="relative flex items-center justify-between gap-3">
                <span class="inline-grid h-12 w-12 place-items-center rounded-xl border border-[#cfe0ff] bg-white text-[#075fe4] shadow-[0_8px_16px_rgba(7,95,228,0.08)] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${item[0]}</span>
                <strong class="font-['Inter'] text-4xl font-semibold leading-none text-[#061942]">${item[2]}</strong>
            </span>
            <span class="relative mt-4 block text-sm font-semibold text-[#34445e]">${item[1]}</span>
        </article>`).join('');
    }

    function renderTracks(courses) {
        if (!courses.length) {
            careerTracks.innerHTML = '<article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">No active Fast Track courses found.</article>';
            return;
        }

        careerTracks.innerHTML = courses.slice(0, 6).map((course, index) => {
            const partner = course.training_partner_profile || {};
            const iconClasses = ['bg-[#eff5ff] text-[#075fe4]', 'bg-[#eafaf8] text-[#17a6a8]', 'bg-[#fff0e2] text-[#f37a22]'][index % 3];
            const tags = skillTags(course);
            return `<article class="group relative overflow-hidden rounded-2xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#f7fbff)] p-6 shadow-[0_16px_34px_rgba(7,95,228,0.08)] transition hover:-translate-y-1 hover:border-[#9fc0f8] hover:shadow-[0_24px_46px_rgba(7,95,228,0.14)]">
                <span class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-[linear-gradient(90deg,#075fe4,#17a6a8)]"></span>
                <span class="pointer-events-none absolute -right-12 -top-16 h-36 w-36 rounded-full bg-[#dcecff]/80 blur-2xl transition group-hover:bg-[#cfe4ff]"></span>
                <div class="relative flex items-start gap-5">
                    <div class="flex h-[78px] w-[78px] shrink-0 items-center justify-center rounded-2xl ${iconClasses} text-2xl font-black shadow-[inset_0_0_0_1px_rgba(255,255,255,0.7),0_12px_24px_rgba(7,95,228,0.08)]">${esc(initials(course.course_name))}</div>
                    <div class="min-w-0 flex-1">
                        <h3 class="mb-2 font-['Inter'] text-xl font-semibold leading-snug text-[#061942]">${esc(course.course_name || 'Fast Track Course')}</h3>
                        <p class="mb-3 text-xs font-bold uppercase tracking-[.7px] text-[#075fe4]">${esc(partner.institute_name || 'Training Partner')}</p>
                        <p class="mb-4 text-sm font-semibold leading-[1.65] text-[#34445e]">${esc(course.description || 'Industry-ready training for freshers.')}</p>
                    </div>
                </div>
                <div class="relative mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full border border-[#dce7f8] bg-white px-3 py-1.5 text-xs font-semibold text-[#34445e]">${esc(course.duration || 'Flexible Duration')}</span>
                    <span class="rounded-full border border-[#dce7f8] bg-white px-3 py-1.5 text-xs font-semibold text-[#34445e]">${esc(course.mode || 'Online')}</span>
                    <span class="rounded-full border border-[#dce7f8] bg-white px-3 py-1.5 text-xs font-semibold text-[#34445e]">${course.certificate_available ? 'Certificate' : 'Fast Track'}</span>
                </div>
                <div class="relative mt-4 flex flex-wrap gap-2">
                    ${tags.length ? tags.map((tag) => `<span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(tag)}</span>`).join('') : `<span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(course.category || 'Fast Track')}</span>`}
                </div>
                <div class="relative mt-5 flex items-center justify-between gap-4">
                    <span class="font-['Inter'] text-lg font-semibold text-[#061942]">${esc(course.fees ? '₹' + course.fees : 'Fast Track')}</span>
                    <a href="/courses/show?course=${esc(course.id)}" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">View Details</a>
                </div>
            </article>`;
        }).join('');
    }

    Promise.all([
        getJson('/api/courses'),
        getJson('/api/training-partners?per_page=100'),
        getJson('/api/jobs?hiring_mode=fast_track'),
    ]).then(([coursesResult, partnersResult, jobsResult]) => {
        const courses = dataOf(coursesResult, 'courses') || [];
        const partnersPage = dataOf(partnersResult, 'training_partners') || {};
        const partners = Array.isArray(partnersPage) ? partnersPage : (partnersPage.data || []);
        const jobs = dataOf(jobsResult, 'jobs') || [];
        renderStats(courses, partners, jobs);
        renderTracks(courses);
    }).catch((error) => {
        careerTracks.innerHTML = `<article class="rounded-lg border border-[#ffd6a8] bg-[#fff8ef] p-6 text-sm font-semibold text-[#8a5200] lg:col-span-3">${esc(error.message || 'Fast Track data load nahi ho paaya.')}</article>`;
    });
</script>
@endpush
