@extends('layouts.fast-track')

@section('title', 'Fast Track Courses')

@php
    $activePage = 'courses';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $courses = [
        ['title' => 'Full Stack Development', 'badge' => 'Most Popular', 'text' => 'Build modern web applications from scratch and become a full stack developer.', 'duration' => '12 Months', 'fees' => 'Rs.14,999', 'mode' => 'Online Live', 'icon' => 'FS', 'color' => '#071743'],
        ['title' => 'Data Science & Analytics', 'badge' => '', 'text' => 'Learn data analysis, visualization and machine learning to solve real-world problems.', 'duration' => '10 Months', 'fees' => 'Rs.16,999', 'mode' => 'Online Live', 'icon' => 'DS', 'color' => '#7744eb'],
        ['title' => 'Digital Marketing', 'badge' => '', 'text' => 'Master SEO, Social Media, Google Ads and more to grow businesses online.', 'duration' => '6 Months', 'fees' => 'Rs.9,999', 'mode' => 'Online Live', 'icon' => 'DM', 'color' => '#0a8f3f'],
        ['title' => 'Backend Development', 'badge' => '', 'text' => 'Learn server-side development, databases, APIs and scalable architecture.', 'duration' => '10 Months', 'fees' => 'Rs.13,999', 'mode' => 'Online Live', 'icon' => 'BD', 'color' => '#ff9800'],
    ];

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
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <input class="h-11 w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm text-[#061942] outline-none placeholder:text-[#6f7ea0] sm:w-[250px]" id="courseSearchInput" placeholder="Search courses...">
                <button class="h-11 rounded-lg border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" id="courseFilterBtn" type="button">Filter</button>
            </div>
        </div>

        <div>
            <h2 class="mb-4 text-lg font-bold text-[#061942]">Popular Career Tracks</h2>
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4" id="courseGrid">
                @foreach ($courses as $course)
                    <article class="course-card flex min-h-[360px] flex-col rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]" data-title="{{ strtolower($course['title'].' '.$course['text']) }}" data-duration="{{ $course['duration'] }}">
                        <span class="mb-5 grid h-[54px] w-[54px] place-items-center rounded-lg text-sm font-black text-white" style="background: {{ $course['color'] }};">{{ $course['icon'] }}</span>

                        @if ($course['badge'])
                            <span class="mb-4 inline-flex self-start rounded-md bg-[#eee7ff] px-2.5 py-1 text-[11px] font-bold text-[#7744eb]">{{ $course['badge'] }}</span>
                        @endif

                        <h3 class="mb-3 text-base font-bold text-[#061942]">{{ $course['title'] }}</h3>
                        <p class="mb-5 text-sm leading-6 text-[#334b83]">{{ $course['text'] }}</p>

                        <div class="mt-auto mb-5 grid gap-3 text-sm">
                            <div class="flex justify-between gap-4 text-[#334b83]"><span>Duration</span><strong class="font-medium text-[#061942]">{{ $course['duration'] }}</strong></div>
                            <div class="flex justify-between gap-4 text-[#334b83]"><span>Fees</span><strong class="font-medium text-[#061942]">{{ $course['fees'] }}</strong></div>
                            <div class="flex justify-between gap-4 text-[#334b83]"><span>Mode</span><strong class="font-medium text-[#061942]">{{ $course['mode'] }}</strong></div>
                        </div>

                        <a class="inline-flex h-[42px] items-center justify-center rounded-lg border border-[#075fe4] text-sm font-bold transition {{ $loop->first ? 'bg-[#075fe4] text-white hover:bg-[#064fc0]' : 'bg-white text-[#075fe4] hover:bg-[#eff5ff]' }}" href="/fast-track/course-details">View Details</a>
                    </article>
                @endforeach
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
                <p class="text-xs leading-5 text-[#536484]">Take our career guidance quiz and get personalized course recommendations.</p>
            </div>
            <button class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#064fc0]" type="button">Take Career Quiz</button>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const courseSearchInput = document.getElementById('courseSearchInput');
    const courseFilterBtn = document.getElementById('courseFilterBtn');
    const courseGrid = document.getElementById('courseGrid');
    let fastTrackCourses = [];

    function filterCourses(mode) {
        const query = (courseSearchInput ? courseSearchInput.value : '').toLowerCase();

        document.querySelectorAll('.course-card').forEach(function (card) {
            const matchesSearch = card.dataset.title.includes(query);
            const matchesFilter = mode === 'long' ? (card.dataset.duration.includes('10') || card.dataset.duration.includes('12')) : true;
            card.classList.toggle('hidden', !(matchesSearch && matchesFilter));
        });
    }

    if (courseSearchInput) {
        courseSearchInput.addEventListener('input', function () {
            filterCourses('all');
        });
    }

    if (courseFilterBtn) {
        courseFilterBtn.addEventListener('click', function () {
            filterCourses('long');
        });
    }

    function renderDynamicCourses(courses) {
        if (!courseGrid) return;
        if (!courses.length) {
            courseGrid.innerHTML = '<div class="sm:col-span-2 xl:col-span-4">' + FastTrack.emptyState('No courses available', 'Approved Fast Track courses will appear here.', '/fast-track/assessment', 'Take Assessment') + '</div>';
            return;
        }

        courseGrid.innerHTML = courses.map(function (course, index) {
            const title = FastTrack.courseName(course);
            const text = FastTrack.courseText(course);
            const fee = course.fee || course.price || course.course_fee || course.amount;
            return `
                <article class="course-card flex min-h-[360px] flex-col rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]" data-title="${FastTrack.esc((title + ' ' + text + ' ' + FastTrack.partnerName(course)).toLowerCase())}" data-duration="${FastTrack.esc(FastTrack.courseDuration(course))}">
                    <span class="mb-5 grid h-[54px] w-[54px] place-items-center rounded-lg text-sm font-black text-white" style="background:${index % 2 ? '#7744eb' : '#071743'};">${FastTrack.initials(title)}</span>
                    ${index === 0 ? '<span class="mb-4 inline-flex self-start rounded-md bg-[#eee7ff] px-2.5 py-1 text-[11px] font-bold text-[#7744eb]">Recommended</span>' : ''}
                    <h3 class="mb-3 text-base font-bold text-[#061942]">${FastTrack.esc(title)}</h3>
                    <p class="mb-5 text-sm leading-6 text-[#334b83]">${FastTrack.esc(text)}</p>
                    <div class="mt-auto mb-5 grid gap-3 text-sm">
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Duration</span><strong class="font-medium text-[#061942]">${FastTrack.esc(FastTrack.courseDuration(course))}</strong></div>
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Fees</span><strong class="font-medium text-[#061942]">${FastTrack.money(fee)}</strong></div>
                        <div class="flex justify-between gap-4 text-[#334b83]"><span>Mode</span><strong class="font-medium text-[#061942]">${FastTrack.esc(FastTrack.courseMode(course))}</strong></div>
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

    FastTrack.getJson('/api/courses')
        .then(function (result) {
            fastTrackCourses = FastTrack.apiData(result, 'courses') || [];
            renderDynamicCourses(fastTrackCourses);
        })
        .catch(function () {
            if (courseGrid) courseGrid.insertAdjacentHTML('afterbegin', '<div class="sm:col-span-2 xl:col-span-4 rounded-lg border border-[#ffd6a8] bg-[#fff8ef] p-4 text-sm font-semibold text-[#8a5200]">Live course data nahi aa pa raha. Static preview retained hai.</div>');
        });
</script>
@endpush
