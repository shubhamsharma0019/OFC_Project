@extends('layouts.public')

@section('title', 'Fast Track Program - OnlyFreshers')

@php
    $activePage = 'fast-track';

    $steps = [
        ['number' => 1, 'icon' => 'document', 'title' => 'Initial Assessment', 'text' => 'Evaluate your skills and career goals.'],
        ['number' => 2, 'icon' => 'target', 'title' => 'Recommended Career Track', 'text' => 'Get a personalized career track.'],
        ['number' => 3, 'icon' => 'training', 'title' => 'Training with Partners', 'text' => 'Learn from verified training partners.'],
        ['number' => 4, 'icon' => 'check', 'title' => 'Final Assessment', 'text' => 'Prove your skills with assessment.'],
        ['number' => 5, 'icon' => 'certificate', 'title' => 'Certificate', 'text' => 'Earn your certificate of completion.'],
        ['number' => 6, 'icon' => 'briefcase', 'title' => 'Get Hired', 'text' => 'Apply to top companies and start.'],
    ];

    $points = [
        ['icon' => 'learn', 'text' => 'Industry-relevant learning'],
        ['icon' => 'users', 'text' => 'Expert training partners'],
        ['icon' => 'certificate', 'text' => 'Final assessment & certificate'],
        ['icon' => 'briefcase', 'text' => 'Better job opportunities'],
    ];
@endphp

@section('content')
    <section class="bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-10 lg:py-[55px]">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-2 lg:gap-[50px] lg:px-8">
            <div class="text-center lg:text-left">
                <h1 class="m-0 text-[40px] font-semibold leading-[1.08] text-[#061942] sm:text-5xl lg:text-[54px]">
                    Fast Track <span class="text-[#075fe4]">Program</span>
                </h1>
                <p class="mt-[18px] max-w-2xl text-lg font-medium leading-[1.7] text-[#34445e] lg:text-[19px]">
                    Learn in-demand skills, get trained by verified partners, and become job-ready.
                </p>
                <div id="fastTrackStats" class="mt-7 grid gap-3 sm:grid-cols-3">
                    <article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 text-center shadow-[0_10px_22px_rgba(6,25,66,0.04)] lg:text-left"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Active Courses</span></article>
                    <article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 text-center shadow-[0_10px_22px_rgba(6,25,66,0.04)] lg:text-left"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Training Partners</span></article>
                    <article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 text-center shadow-[0_10px_22px_rgba(6,25,66,0.04)] lg:text-left"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Fast Track Jobs</span></article>
                </div>
            </div>

            <div class="flex min-h-[240px] items-center justify-center lg:min-h-[260px]">
                @if (file_exists(public_path('study.svg')))
                    <img src="{{ asset('study.svg') }}" alt="Fast Track Study" class="block h-[240px] w-full max-w-[520px] object-contain sm:h-[260px]">
                @else
                    <div class="flex h-[240px] w-full max-w-[520px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-5xl font-bold text-[#075fe4] shadow-[0_18px_40px_rgba(6,25,66,0.06)] sm:h-[260px]">
                        FT
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white py-9 lg:py-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:grid-cols-2 lg:grid-cols-6 lg:p-7">
                @foreach ($steps as $step)
                    <article class="text-center">
                        <div class="mx-auto mb-3.5 flex h-[65px] w-[65px] items-center justify-center rounded-full border border-[#dce7f8] bg-[#eff5ff] text-[#075fe4] [&>svg]:h-7 [&>svg]:w-7">
                            @include('components.public.icon', ['name' => $step['icon']])
                        </div>
                        <h3 class="mb-2 text-sm font-semibold text-[#061942]">
                            <span class="mr-1.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#075fe4] text-xs text-white">{{ $step['number'] }}</span>{{ $step['title'] }}
                        </h3>
                        <p class="text-[13px] font-medium leading-[1.6] text-[#34445e]">{{ $step['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white pb-10">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <h2 class="mb-5 text-center text-2xl font-semibold text-[#061942]">Explore Career Tracks</h2>

            <div id="careerTracks" class="grid gap-[22px] lg:grid-cols-3">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">Loading career tracks...</article>
            </div>
        </div>
    </section>

    <section class="bg-white pb-[55px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-[#dce7f8] bg-[#eaf2ff] px-5 py-[22px] text-center sm:px-10">
                <div class="mb-5 grid gap-[22px] sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($points as $point)
                        <div class="flex items-center gap-3 text-left text-[15px] font-bold text-[#061942]">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $point['icon']])</span>
                            <span>{{ $point['text'] }}</span>
                        </div>
                    @endforeach
                </div>

                <a href="/fast-track/register" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">
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
        fastTrackStats.innerHTML = [
            ['AC', 'Active Courses', courses.length],
            ['TP', 'Training Partners', partners.length],
            ['FJ', 'Fast Track Jobs', jobs.length],
        ].map((item) => `<article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 text-center shadow-[0_10px_22px_rgba(6,25,66,0.04)] lg:text-left"><span class="mb-2 inline-grid h-8 w-8 place-items-center rounded-md bg-[#eaf2ff] text-[10px] font-black text-[#075fe4]">${item[0]}</span><strong class="block text-2xl font-bold text-[#061942]">${item[2]}</strong><span class="text-xs font-bold text-[#34445e]">${item[1]}</span></article>`).join('');
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
            return `<article class="flex flex-col gap-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row lg:flex-col xl:flex-row">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[14px] ${iconClasses} text-lg font-black">${esc(initials(course.course_name))}</div>
                <div class="min-w-0">
                    <h3 class="mb-2 text-lg font-semibold text-[#061942]">${esc(course.course_name || 'Fast Track Course')}</h3>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[.5px] text-[#075fe4]">${esc(partner.institute_name || 'Training Partner')}</p>
                    <p class="mb-3 text-sm font-medium leading-[1.6] text-[#34445e]">${esc(course.description || 'Industry-ready training for freshers.')}</p>
                    <div class="mb-3.5 flex flex-wrap gap-2">
                        ${tags.length ? tags.map((tag) => `<span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(tag)}</span>`).join('') : `<span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(course.category || 'Fast Track')}</span>`}
                    </div>
                    <a href="/courses/show?course=${esc(course.id)}" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">View Details</a>
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
