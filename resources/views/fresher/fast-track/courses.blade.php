@extends('layouts.fast-track')

@section('title', 'Fast Track Courses')

@php
    $activePage = 'courses';
    $benefits = [
        ['title' => 'Job Ready Faster', 'text' => 'Industry-focused curriculum designed to get you job-ready quickly.', 'icon' => 'JR'],
        ['title' => 'Industry Certified', 'text' => 'Earn recognized certificates that boost your career opportunities.', 'icon' => 'IC'],
        ['title' => 'Expert Mentors', 'text' => 'Learn from industry experts and get guidance at every step.', 'icon' => 'EM'],
        ['title' => 'Career Support', 'text' => 'Get placement assistance and interview preparation support.', 'icon' => 'CS'],
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h1 class="text-[29px] font-bold leading-tight text-[#061942]">Fast Track Courses</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">Choose a career track to start your learning journey and get job-ready faster.</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-[250px_170px_150px]">
                <input class="h-11 w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm text-[#061942] outline-none placeholder:text-[#6f7ea0]" id="courseSearchInput" placeholder="Search courses...">
                <select id="modeFilter" class="h-11 rounded-lg border border-[#dce7f8] bg-white px-4 text-sm text-[#061942] outline-none">
                    <option value="">All Modes</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                    <option value="hybrid">Hybrid</option>
                </select>
                <button class="h-11 rounded-lg border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" id="clearFilters" type="button">Clear</button>
            </div>
        </div>

        <div id="courseStats" class="grid gap-4 sm:grid-cols-3">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-3">Loading courses...</article>
        </div>

        <div>
            <h2 class="mb-4 text-lg font-bold text-[#061942]">Available Career Tracks</h2>
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4" id="courseGrid">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center text-sm text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2 xl:col-span-4">Loading approved Fast Track courses...</article>
            </div>
        </div>

        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:p-7">
            <h2 class="mb-5 text-lg font-bold text-[#061942]">Why Choose Fast Track Courses?</h2>
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($benefits as $benefit)
                    <div class="grid grid-cols-[54px_minmax(0,1fr)] items-center gap-4 xl:border-r xl:border-[#dce7f8] xl:pr-5 xl:last:border-r-0">
                        <span class="grid h-[52px] w-[52px] place-items-center rounded-full bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">{{ $benefit['icon'] }}</span>
                        <div>
                            <h3 class="mb-2 text-sm font-bold text-[#061942]">{{ $benefit['title'] }}</h3>
                            <p class="text-xs leading-5 text-[#536484]">{{ $benefit['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="flex flex-col gap-5 rounded-lg border border-[#dce7f8] bg-[#eaf2ff] p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:px-9 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="mb-2 text-base font-bold text-[#061942]">Not sure which course is right for you?</h3>
                <p class="text-xs leading-5 text-[#536484]">Take the initial assessment and get personalized track recommendations.</p>
            </div>
            <a class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#064fc0]" href="/fast-track/assessment">Take Assessment</a>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const courseSearchInput = document.getElementById('courseSearchInput');
    const modeFilter = document.getElementById('modeFilter');
    const clearFilters = document.getElementById('clearFilters');
    const courseGrid = document.getElementById('courseGrid');
    const courseStats = document.getElementById('courseStats');
    let fastTrackCourses = [];

    function statCard(label, value) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]"><p class="text-xs font-bold text-[#52607a]">${FastTrack.esc(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${FastTrack.esc(value)}</h2></article>`;
    }
    function courseFee(course) {
        return course.fees || course.fee || course.price || course.course_fee || course.amount;
    }
    function filteredCourses() {
        const query = (courseSearchInput.value || '').toLowerCase();
        const mode = modeFilter.value;
        return fastTrackCourses.filter(function (course) {
            const text = [
                FastTrack.courseName(course),
                FastTrack.courseText(course),
                FastTrack.partnerName(course),
                course.category,
                course.skills_covered,
            ].join(' ').toLowerCase();
            const modeValue = String(course.training_mode || course.mode || '').toLowerCase();
            return (!query || text.includes(query)) && (!mode || modeValue === mode);
        });
    }
    function renderStats(courses) {
        const online = courses.filter((course) => String(course.training_mode || '').toLowerCase() === 'online').length;
        const partners = new Set(courses.map((course) => course.training_partner_profile_id || course.training_partner_profile?.id).filter(Boolean)).size;
        courseStats.innerHTML = [
            statCard('Active Courses', courses.length),
            statCard('Training Partners', partners),
            statCard('Online Courses', online),
        ].join('');
    }
    function renderCourses() {
        const courses = filteredCourses();
        renderStats(fastTrackCourses);
        if (!courses.length) {
            courseGrid.innerHTML = '<div class="sm:col-span-2 xl:col-span-4">' + FastTrack.emptyState('No courses available', 'Approved Fast Track courses will appear here according to your filters.', '/fast-track/assessment', 'Take Assessment') + '</div>';
            return;
        }

        courseGrid.innerHTML = courses.map(function (course, index) {
            const title = FastTrack.courseName(course);
            const text = FastTrack.courseText(course);
            return `
                <article class="flex min-h-[360px] flex-col rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <span class="mb-5 grid h-[54px] w-[54px] place-items-center rounded-lg text-sm font-black text-white" style="background:${index % 3 === 0 ? '#071743' : index % 3 === 1 ? '#7744eb' : '#0a8f3f'};">${FastTrack.initials(title)}</span>
                    <span class="mb-4 inline-flex self-start rounded-md bg-[#eee7ff] px-2.5 py-1 text-[11px] font-bold text-[#7744eb]">${FastTrack.esc(course.category || FastTrack.partnerName(course))}</span>
                    <h3 class="mb-3 text-base font-bold text-[#061942]">${FastTrack.esc(title)}</h3>
                    <p class="mb-5 line-clamp-4 text-sm leading-6 text-[#334b83]">${FastTrack.esc(text)}</p>
                    <div class="mt-auto mb-5 grid gap-3 text-sm">
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Partner</span><strong class="truncate font-medium text-[#061942]">${FastTrack.esc(FastTrack.partnerName(course))}</strong></div>
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Duration</span><strong class="font-medium text-[#061942]">${FastTrack.esc(FastTrack.courseDuration(course))}</strong></div>
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Fees</span><strong class="font-medium text-[#061942]">${FastTrack.money(courseFee(course))}</strong></div>
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Mode</span><strong class="font-medium capitalize text-[#061942]">${FastTrack.esc(FastTrack.courseMode(course))}</strong></div>
                    </div>
                    <a class="inline-flex h-[42px] items-center justify-center rounded-lg border border-[#075fe4] text-sm font-bold transition ${index === 0 ? 'bg-[#075fe4] text-white hover:bg-[#064fc0]' : 'bg-white text-[#075fe4] hover:bg-[#eff5ff]'}" href="/fast-track/course-details?course=${encodeURIComponent(course.id)}" data-course-id="${FastTrack.esc(course.id)}">View Details</a>
                </article>
            `;
        }).join('');

        courseGrid.querySelectorAll('[data-course-id]').forEach(function (link) {
            link.addEventListener('click', function () {
                FastTrack.rememberCourse(this.dataset.courseId);
            });
        });
    }
    function loadCourses() {
        const params = new URLSearchParams();
        if (courseSearchInput.value.trim()) params.set('search', courseSearchInput.value.trim());
        if (modeFilter.value) params.set('training_mode', modeFilter.value);
        courseGrid.innerHTML = '<article class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center text-sm text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2 xl:col-span-4">Loading approved Fast Track courses...</article>';
        FastTrack.getJson('/api/courses?' + params.toString())
            .then(function (result) {
                fastTrackCourses = FastTrack.apiData(result, 'courses') || [];
                renderCourses();
            })
            .catch(function (error) {
                courseGrid.innerHTML = '<div class="sm:col-span-2 xl:col-span-4">' + FastTrack.emptyState('Courses load nahi ho paaye', error.message || 'Please retry after some time.', null, '') + '</div>';
                courseStats.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-3">Course API load nahi ho paayi.</article>';
            });
    }
    let searchTimer = null;
    courseSearchInput.addEventListener('input', function () { clearTimeout(searchTimer); searchTimer = setTimeout(loadCourses, 350); });
    modeFilter.addEventListener('change', loadCourses);
    clearFilters.addEventListener('click', function () {
        courseSearchInput.value = '';
        modeFilter.value = '';
        loadCourses();
    });
    loadCourses();
</script>
@endpush
