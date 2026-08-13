@extends('layouts.public')

@section('title', 'OnlyFreshers')

@php
    $activePage = 'home';
@endphp

@section('content')
    <section class="bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-11 text-center lg:py-[60px] lg:text-left">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-2 lg:gap-[50px] lg:px-8">
            <div>
                <h1 class="m-0 text-[34px] font-semibold leading-[1.12] text-[#061942] sm:text-5xl lg:text-[54px] lg:leading-[1.08]">
                    Bridging Fresh Talent With <span class="text-[#075fe4]">Great Opportunities</span>
                </h1>
                <p class="mx-auto my-6 max-w-2xl text-[15px] font-medium leading-[1.7] text-[#34445e] sm:text-base lg:mx-0 lg:my-[22px] lg:text-[17px]">
                    OnlyFreshers is a job, training, and hiring platform that connects freshers with companies and training partners.
                </p>

                <div class="flex flex-col justify-center gap-3 sm:flex-row lg:justify-start">
                    <a href="/job" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#003f9e]">Browse Jobs</a>
                    <a href="/fast-track" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#f2b17e] bg-white px-6 text-sm font-bold text-[#f37a22] transition hover:bg-[#f37a22] hover:text-white">Explore Fast Track Program</a>
                </div>

                <div id="homeStats" class="mt-8 grid gap-3 sm:grid-cols-3">
                    <article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 shadow-[0_10px_22px_rgba(6,25,66,0.04)]"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Active Jobs</span></article>
                    <article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 shadow-[0_10px_22px_rgba(6,25,66,0.04)]"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Courses</span></article>
                    <article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 shadow-[0_10px_22px_rgba(6,25,66,0.04)]"><strong class="block text-2xl font-bold text-[#061942]">...</strong><span class="text-xs font-bold text-[#34445e]">Partners</span></article>
                </div>
            </div>

            <div class="flex min-h-[260px] items-center justify-center lg:min-h-[320px]">
                <img src="/build/assets/student.png" alt="Students" class="block h-auto max-h-[320px] w-full max-w-[560px] object-contain" onerror="this.onerror=null;this.src='/student.svg';">
            </div>
        </div>
    </section>

    <section class="bg-white py-[45px]">
        <div class="mx-auto grid w-full max-w-7xl gap-6 px-5 sm:px-6 lg:grid-cols-2 lg:px-8">
            <a href="/direct-mode" class="flex flex-col items-center gap-6 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] transition hover:-translate-y-0.5 hover:border-[#bfd4f5] hover:shadow-[0_16px_32px_rgba(6,25,66,0.08)] focus:outline-none focus:ring-2 focus:ring-[#075fe4] focus:ring-offset-2 sm:flex-row sm:items-start">
                <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#f1f6ff] text-4xl font-bold text-[#075fe4]">
                    @if (file_exists(public_path('direct.svg')))
                        <img src="{{ asset('direct.svg') }}" alt="Direct Mode" class="h-full w-full rounded-full object-contain">
                    @else
                        DM
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="mb-[15px] text-center text-xl font-semibold text-[#061942] sm:text-left">Direct Mode</h2>
                    <ul id="directPoints" class="grid gap-3 text-sm font-medium text-[#293850] sm:grid-cols-2">
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Create profile</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Browse jobs and apply</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Upload resume</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Company reviews profile</li>
                    </ul>
                </div>
            </a>

            <a href="/fast-track" class="flex flex-col items-center gap-6 rounded-lg border border-[#f5d4ba] bg-[#fffaf5] p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] transition hover:-translate-y-0.5 hover:border-[#f2b17e] hover:shadow-[0_16px_32px_rgba(6,25,66,0.08)] focus:outline-none focus:ring-2 focus:ring-[#f37a22] focus:ring-offset-2 sm:flex-row sm:items-start">
                <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center rounded-full bg-[#fff0e2] text-[#f37a22] [&>svg]:h-12 [&>svg]:w-12">@include('components.public.icon', ['name' => 'rocket'])</div>
                <div class="min-w-0 flex-1">
                    <h2 class="mb-[15px] text-center text-xl font-semibold text-[#061942] sm:text-left">Fast Track Mode</h2>
                    <ul id="fastTrackPoints" class="grid gap-3 text-sm font-medium text-[#293850] sm:grid-cols-2">
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Give initial assessment</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Enroll in a course</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Give final assessment</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Earn certificate</li>
                    </ul>
                </div>
            </a>
        </div>
    </section>

    <section class="bg-[#f7faff] py-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-[22px] font-semibold text-[#061942]">Latest Jobs</h2>
                    <p class="mt-2 text-sm font-medium text-[#4a5871]">Active openings posted by approved companies.</p>
                </div>
                <a href="/job" class="text-sm font-bold text-[#075fe4]">View All Jobs</a>
            </div>
            <div id="latestJobs" class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-semibold text-[#34445e]">Loading jobs...</article>
            </div>
        </div>
    </section>

    <section class="bg-white py-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-[22px] font-semibold text-[#061942]">Featured Fast Track Courses</h2>
                    <p class="mt-2 text-sm font-medium text-[#4a5871]">Courses from approved training partners.</p>
                </div>
                <a href="/courses" class="text-sm font-bold text-[#075fe4]">View All Courses</a>
            </div>
            <div id="featuredCourses" class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-semibold text-[#34445e]">Loading courses...</article>
            </div>
        </div>
    </section>

    <section class="bg-white py-[45px] text-center">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <h2 class="mb-[22px] text-[22px] font-semibold text-[#061942]">Trusted Training Partners</h2>

            <div id="trainingPartners" class="mb-5 grid gap-[22px] sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                <div class="rounded-lg border border-[#dce7f8] bg-white px-3 py-4 text-sm font-semibold text-[#061942] shadow-[0_10px_22px_rgba(6,25,66,0.04)]">Loading partners...</div>
            </div>

            <a href="/training-partners" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-6 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">View All Training Partners</a>
        </div>
    </section>

    <section class="bg-white pb-[55px] pt-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-6 rounded-lg border border-[#dce7f8] bg-white p-6 text-center shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:flex-row lg:px-[55px] lg:text-left">
                <div class="flex flex-col items-center gap-6 lg:flex-row">
                    <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center rounded-full bg-[#f1f6ff] text-[#075fe4] [&>svg]:h-12 [&>svg]:w-12">@include('components.public.icon', ['name' => 'company'])</div>
                    <div>
                        <h2 class="mb-1 text-xl font-semibold text-[#061942]">Hire Freshers with Confidence</h2>
                        <p class="text-sm font-medium leading-[1.5] text-[#4a5871] sm:text-base">Post jobs, review applications, shortlist candidates, and hire top talent.</p>
                    </div>
                </div>

                <a href="/company/post-job" class="inline-flex h-11 shrink-0 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#003f9e]">Post a Job</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const homeStats = document.getElementById('homeStats');
    const latestJobs = document.getElementById('latestJobs');
    const featuredCourses = document.getElementById('featuredCourses');
    const trainingPartners = document.getElementById('trainingPartners');

    function esc(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
        });
    }

    function dataOf(result, key) {
        return result && result.data ? (key ? result.data[key] : result.data) : result;
    }

    function initials(value) {
        return String(value || 'OF').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'OF';
    }

    function money(value) {
        const amount = Number(value || 0);
        if (!amount) return 'Free';
        return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 }).format(amount);
    }

    async function getJson(url) {
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Request failed');
        return result;
    }

    function renderStats(jobs, courses, partners) {
        homeStats.innerHTML = [
            ['AJ', 'Active Jobs', jobs.length],
            ['FC', 'Fast Track Courses', courses.length],
            ['TP', 'Training Partners', partners.length],
        ].map((item) => `<article class="rounded-lg border border-[#dce7f8] bg-white/80 p-4 shadow-[0_10px_22px_rgba(6,25,66,0.04)]"><span class="mb-2 inline-grid h-8 w-8 place-items-center rounded-md bg-[#eaf2ff] text-[10px] font-black text-[#075fe4]">${item[0]}</span><strong class="block text-2xl font-bold text-[#061942]">${item[2]}</strong><span class="text-xs font-bold text-[#34445e]">${item[1]}</span></article>`).join('');
    }

    function renderJobs(jobs) {
        latestJobs.innerHTML = jobs.length ? jobs.slice(0, 3).map((job) => {
            const company = job.company_profile || {};
            return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_22px_rgba(6,25,66,0.04)]">
                <div class="mb-4 flex items-start gap-3">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-sm font-black text-[#075fe4]">${initials(company.company_name || job.title)}</span>
                    <div class="min-w-0">
                        <h3 class="mb-1 truncate text-base font-bold text-[#061942]">${esc(job.title || 'Job Opening')}</h3>
                        <p class="text-sm font-medium text-[#34445e]">${esc(company.company_name || 'Company')}</p>
                    </div>
                </div>
                <p class="mb-4 line-clamp-2 text-sm leading-6 text-[#4a5871]">${esc(job.description || job.qualification || 'Apply for this fresher opportunity.')}</p>
                <div class="mb-4 flex flex-wrap gap-2 text-xs font-bold">
                    <span class="rounded-md bg-[#eaf2ff] px-2.5 py-1 text-[#075fe4]">${esc(job.location || 'India')}</span>
                    <span class="rounded-md bg-[#e8f8ef] px-2.5 py-1 text-[#05843e]">${esc(job.job_type || 'Full Time')}</span>
                    <span class="rounded-md bg-[#fff2d8] px-2.5 py-1 text-[#b66b00]">${esc(String(job.hiring_mode || 'direct').replace(/_/g, ' '))}</span>
                </div>
                <a href="/jobs/show?job=${esc(job.id)}" class="inline-flex h-10 items-center justify-center rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]">View Details</a>
            </article>`;
        }).join('') : '<article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-semibold text-[#34445e] lg:col-span-3">No active jobs found.</article>';
    }

    function renderCourses(courses) {
        featuredCourses.innerHTML = courses.length ? courses.slice(0, 3).map((course) => {
            const partner = course.training_partner_profile || {};
            return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_22px_rgba(6,25,66,0.04)]">
                <span class="mb-4 grid h-12 w-12 place-items-center rounded-lg bg-[#fff0e2] text-sm font-black text-[#f37a22]">${initials(course.course_name)}</span>
                <h3 class="mb-2 text-base font-bold text-[#061942]">${esc(course.course_name || 'Fast Track Course')}</h3>
                <p class="mb-3 text-sm font-medium text-[#34445e]">${esc(partner.institute_name || 'Training Partner')}</p>
                <p class="mb-4 line-clamp-2 text-sm leading-6 text-[#4a5871]">${esc(course.description || 'Industry-ready course for freshers.')}</p>
                <div class="mb-4 flex flex-wrap gap-2 text-xs font-bold">
                    <span class="rounded-md bg-[#eaf2ff] px-2.5 py-1 text-[#075fe4]">${esc(course.category || 'Course')}</span>
                    <span class="rounded-md bg-[#e8f8ef] px-2.5 py-1 text-[#05843e]">${money(course.fees)}</span>
                </div>
                <a href="/courses/show?course=${esc(course.id)}" class="inline-flex h-10 items-center justify-center rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]">View Course</a>
            </article>`;
        }).join('') : '<article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-semibold text-[#34445e] lg:col-span-3">No active courses found.</article>';
    }

    function renderPartners(partners) {
        trainingPartners.innerHTML = partners.length ? partners.slice(0, 6).map((partner) => `<a href="/training-partners/show?partner=${esc(partner.id)}" class="rounded-lg border border-[#dce7f8] bg-white px-3 py-4 text-sm font-semibold text-[#061942] shadow-[0_10px_22px_rgba(6,25,66,0.04)] transition hover:border-[#075fe4]">
            ${esc(partner.institute_name || partner.user?.name || 'Training Partner')}
            <small class="mt-1 block text-[9px] font-medium uppercase tracking-[1px] text-[#4d5c75]">${esc(partner.location || (partner.active_courses_count || 0) + ' Courses')}</small>
        </a>`).join('') : '<div class="rounded-lg border border-[#dce7f8] bg-white px-3 py-4 text-sm font-semibold text-[#061942] shadow-[0_10px_22px_rgba(6,25,66,0.04)] sm:col-span-2 lg:col-span-3 xl:col-span-6">No approved training partners found.</div>';
    }

    Promise.all([
        getJson('/api/jobs'),
        getJson('/api/courses'),
        getJson('/api/training-partners?per_page=6'),
    ]).then(([jobsResult, coursesResult, partnersResult]) => {
        const jobs = dataOf(jobsResult, 'jobs') || [];
        const courses = dataOf(coursesResult, 'courses') || [];
        const partnersPage = dataOf(partnersResult, 'training_partners') || {};
        const partners = Array.isArray(partnersPage) ? partnersPage : (partnersPage.data || []);
        renderStats(jobs, courses, partners);
        renderJobs(jobs);
        renderCourses(courses);
        renderPartners(partners);
    }).catch((error) => {
        const message = esc(error.message || 'Website data load nahi ho paaya.');
        latestJobs.innerHTML = `<article class="rounded-lg border border-[#ffd6a8] bg-[#fff8ef] p-5 text-sm font-semibold text-[#8a5200] lg:col-span-3">${message}</article>`;
        featuredCourses.innerHTML = '';
        trainingPartners.innerHTML = '';
    });
</script>
@endpush
