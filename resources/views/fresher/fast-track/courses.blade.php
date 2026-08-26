@extends('layouts.fast-track')

@section('title', 'Fast Track Courses')

@php
    $activePage = 'courses';
    $benefits = [
        ['title' => 'Job Ready Faster', 'text' => 'Industry-focused curriculum designed to get you job-ready quickly.', 'icon' => 'briefcase'],
        ['title' => 'Industry Certified', 'text' => 'Earn recognized certificates that boost your career opportunities.', 'icon' => 'certificate'],
        ['title' => 'Expert Mentors', 'text' => 'Learn from industry experts and get guidance at every step.', 'icon' => 'mentor'],
        ['title' => 'Career Support', 'text' => 'Get placement assistance and interview preparation support.', 'icon' => 'support'],
    ];
    $benefitIcons = [
        'briefcase' => '<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="13" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M4 13h16"></path></svg>',
        'certificate' => '<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3Z"></path><path d="M9 8h6M9 12h6"></path></svg>',
        'mentor' => '<svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><path d="M16 11l2 2 3-4"></path><path d="M14 19h7"></path></svg>',
        'support' => '<svg viewBox="0 0 24 24"><path d="M4 12a8 8 0 0 1 16 0"></path><path d="M4 12v4a2 2 0 0 0 2 2h1v-7H6a2 2 0 0 0-2 2Z"></path><path d="M20 12v4a2 2 0 0 1-2 2h-1v-7h1a2 2 0 0 1 2 2Z"></path><path d="M13 20h3a4 4 0 0 0 4-4"></path></svg>',
    ];
@endphp

@push('styles')
<style>
    .course-stat-card {
        position: relative;
        overflow: hidden;
        min-height: 118px;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        padding: 22px 24px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    .course-stat-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: #075fe4;
    }

    .course-card {
        display: flex;
        min-height: 390px;
        flex-direction: column;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        padding: 22px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .course-card:hover {
        transform: translateY(-2px);
        border-color: #a9c6f4;
        box-shadow: 0 18px 34px rgba(6, 25, 66, .08);
    }

    .course-badge {
        display: inline-flex;
        width: fit-content;
        max-width: 100%;
        align-items: center;
        border-radius: 999px;
        background: #eef4ff;
        padding: 6px 11px;
        color: #075fe4;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .course-avatar {
        display: grid;
        height: 58px;
        width: 58px;
        place-items: center;
        border-radius: 8px;
        color: #fff;
        font-size: 15px;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(6, 25, 66, .12);
    }

    .course-meta-panel {
        margin-top: auto;
        margin-bottom: 18px;
        display: grid;
        gap: 10px;
        border-radius: 8px;
        background: #f7faff;
        padding: 14px;
    }

    .course-meta-row {
        display: grid;
        grid-template-columns: 82px minmax(0, 1fr);
        align-items: center;
        gap: 14px;
        color: #334b83;
        font-size: 13px;
    }

    .course-meta-row strong {
        min-width: 0;
        overflow: hidden;
        text-align: right;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #061942;
        font-weight: 700;
    }
</style>
@endpush

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
                        <span class="grid h-[52px] w-[52px] shrink-0 place-items-center rounded-full bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">{!! $benefitIcons[$benefit['icon']] !!}</span>
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
                <h3 class="mb-2 text-base font-bold text-[#061942]">Choose a Fast Track course</h3>
                <p class="text-xs leading-5 text-[#536484]">Explore approved courses, enroll, complete training, then unlock your final assessment.</p>
            </div>
            <a class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#064fc0]" href="/fast-track/training">My Training</a>
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
    const initialTrack = new URLSearchParams(window.location.search).get('track') || '';
    let preferredJobCategory = '';
    let fastTrackCourses = [];
    if (initialTrack && courseSearchInput) courseSearchInput.value = initialTrack;

    function statCard(label, value) {
        return `<article class="course-stat-card">
            <p class="text-sm font-bold text-[#334b83]">${FastTrack.esc(label)}</p>
            <h2 class="mt-3 text-[34px] font-bold leading-none text-[#061942]">${FastTrack.esc(value)}</h2>
            <span class="mt-3 block h-1.5 w-12 rounded-full bg-[#075fe4]"></span>
        </article>`;
    }
    function courseFee(course) {
        return course.fees || course.fee || course.price || course.course_fee || course.amount;
    }
    function categoryTerms(category) {
        const value = String(category || '').toLowerCase();
        if (value.includes('data')) return ['data analyst', 'data', 'sql', 'excel', 'power bi', 'analytics'];
        if (value.includes('software') || value.includes('developer')) return ['software', 'developer', 'laravel', 'php', 'react', 'javascript', 'python'];
        if (value.includes('ui') || value.includes('ux') || value.includes('design')) return ['ui', 'ux', 'designer', 'figma', 'wireframe'];
        if (value.includes('marketing')) return ['marketing', 'seo', 'social media', 'content', 'analytics'];
        return value ? [value] : [];
    }
    function filteredCourses() {
        const query = (courseSearchInput.value || '').toLowerCase();
        const mode = modeFilter.value;
        const categoryKeywords = categoryTerms(preferredJobCategory);
        return fastTrackCourses.filter(function (course) {
            const text = [
                FastTrack.courseName(course),
                FastTrack.courseText(course),
                FastTrack.partnerName(course),
                course.category,
                course.skills_covered,
            ].join(' ').toLowerCase();
            const modeValue = String(course.training_mode || course.mode || '').toLowerCase();
            return (!query || text.includes(query)) && (!categoryKeywords.length || categoryKeywords.some((term) => text.includes(term))) && (!mode || modeValue === mode);
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
            courseGrid.innerHTML = '<div class="sm:col-span-2 xl:col-span-4">' + FastTrack.emptyState('No courses available', 'Approved Fast Track courses will appear here according to your filters.', '/fast-track/dashboard', 'Back to Dashboard') + '</div>';
            return;
        }

        courseGrid.innerHTML = courses.map(function (course, index) {
            const title = FastTrack.courseName(course);
            const text = FastTrack.courseText(course);
            const accent = index % 3 === 0 ? '#071743' : index % 3 === 1 ? '#7744eb' : '#0a8f3f';
            return `
                <article class="course-card">
                    <div class="mb-5 flex items-start justify-between gap-4">
                        <span class="course-avatar" style="background:${accent};">${FastTrack.initials(title)}</span>
                        <span class="course-badge">${FastTrack.esc(course.category || FastTrack.partnerName(course))}</span>
                    </div>

                    <h3 class="mb-3 min-h-[52px] text-[18px] font-bold leading-snug text-[#061942]">${FastTrack.esc(title)}</h3>
                    <p class="mb-5 line-clamp-3 text-sm leading-6 text-[#334b83]">${FastTrack.esc(text)}</p>

                    <div class="course-meta-panel">
                        <div class="course-meta-row"><span>Partner</span><strong>${FastTrack.esc(FastTrack.partnerName(course))}</strong></div>
                        <div class="course-meta-row"><span>Duration</span><strong>${FastTrack.esc(FastTrack.courseDuration(course))}</strong></div>
                        <div class="course-meta-row"><span>Fees</span><strong>${FastTrack.money(courseFee(course))}</strong></div>
                        <div class="course-meta-row"><span>Mode</span><strong class="capitalize">${FastTrack.esc(FastTrack.courseMode(course))}</strong></div>
                    </div>

                    <a class="inline-flex h-[44px] items-center justify-center rounded-lg border border-[#075fe4] text-sm font-bold transition ${index === 0 ? 'bg-[#075fe4] text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] hover:bg-[#064fc0]' : 'bg-white text-[#075fe4] hover:bg-[#eff5ff]'}" href="/fast-track/course-details?course=${encodeURIComponent(course.id)}" data-course-id="${FastTrack.esc(course.id)}">View Details</a>
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
        if (preferredJobCategory) params.set('job_category', preferredJobCategory);
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
    FastTrack.getJson('/api/fresher/dashboard')
        .then(function (result) {
            const profile = (FastTrack.apiData(result) || {}).profile || {};
            preferredJobCategory = profile.preferred_job_category || '';
            if (!courseSearchInput.value && preferredJobCategory) {
                courseSearchInput.value = preferredJobCategory;
            }
        })
        .catch(function () {})
        .finally(loadCourses);
</script>
@endpush
