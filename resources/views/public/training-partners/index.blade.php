@extends('layouts.public')

@section('title', 'Training Partners - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@push('styles')
<style>
    .training-partners-page,
    .training-partners-page * {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .training-partners-page h1,
    .training-partners-page h2,
    .training-partners-page h3 {
        font-weight: 700;
    }
    .partner-filter-panel {
        border: 1px solid #cfe0ff;
        border-radius: 18px;
        background: linear-gradient(145deg, #ffffff, #f3f8ff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .08);
    }
    .partner-card {
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-height: 292px;
        border: 1px solid #cfe0ff;
        border-radius: 20px;
        background: linear-gradient(145deg, #ffffff, #f7fbff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .09);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .partner-card:hover {
        transform: translateY(-6px);
        border-color: #9fc0f8;
        box-shadow: 0 26px 52px rgba(7, 95, 228, .15);
    }
    .partner-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #075fe4, #17a6a8);
    }
    .partner-card:after {
        content: "";
        position: absolute;
        right: -52px;
        top: -58px;
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background: rgba(220, 236, 255, .86);
        filter: blur(22px);
        pointer-events: none;
    }
    .partner-badge {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        font-size: 23px;
        font-weight: 900;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .75), 0 12px 24px rgba(7, 95, 228, .08);
    }
    .partner-chip {
        border: 1px solid #cfe0ff;
        border-radius: 999px;
        background: #fff;
        padding: 7px 12px;
        color: #075fe4;
        font-size: 12px;
        font-weight: 800;
    }
    .partner-meta {
        border: 1px solid #dce7f8;
        border-radius: 14px;
        background: rgba(255, 255, 255, .78);
        padding: 12px 14px;
        color: #34445e;
        font-size: 13px;
        font-weight: 700;
        text-align: right;
    }
    .partner-card-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .partner-card-button {
        display: inline-flex;
        width: 100%;
        height: 44px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 12px;
        background: #075fe4;
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(7, 95, 228, .18);
        transition: background .2s ease;
    }
    .partner-card-button:hover { background: #0554cc; }
</style>
@endpush

@section('content')
    <main class="training-partners-page bg-white">
        <section class="bg-white px-4 py-5 sm:px-6 lg:px-8">
            <div class="mx-auto grid w-full max-w-7xl overflow-hidden rounded-lg bg-[#eef5ff] shadow-[0_8px_24px_rgba(7,95,228,0.08)] lg:grid-cols-[1fr_520px]">
                <div class="relative z-10 px-6 py-6 sm:px-8 lg:py-8">
                    <h1 class="mb-2 text-[30px] font-bold leading-tight text-[#061942] sm:text-[34px]">Our Trusted Training Partners</h1>
                    <p class="mb-6 max-w-[650px] text-[13px] font-semibold leading-5 text-[#24344f]">Learn, grow and get hired. Choose from industry-aligned courses offered by our verified training partners under Fast Track Program.</p>

                    <div class="mb-6 grid max-w-[610px] gap-3 sm:grid-cols-[1fr_170px]">
                        <div class="flex h-11 items-center gap-2 rounded-md border border-[#c7d8f2] bg-white px-4 text-[#6f7d90] shadow-[0_3px_10px_rgba(6,25,66,0.04)]">
                            <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => 'search'])</span>
                            <span class="text-[12px] font-semibold">Search training partner or course</span>
                        </div>
                        <div class="flex h-11 items-center justify-between rounded-md border border-[#c7d8f2] bg-white px-4 text-[#24344f] shadow-[0_3px_10px_rgba(6,25,66,0.04)]">
                            <span class="text-[12px] font-semibold">All Locations</span>
                            <span class="text-[12px] text-[#6f7d90]">⌄</span>
                        </div>
                    </div>

                    <div class="grid max-w-[760px] gap-3 rounded-lg bg-white/78 p-3 shadow-[0_5px_18px_rgba(6,25,66,0.04)] sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ([
                            ['icon' => 'shield', 'title' => 'Verified Partners', 'text' => 'Quality training you can trust'],
                            ['icon' => 'briefcase', 'title' => 'Industry Relevant Courses', 'text' => 'Designed for job roles'],
                            ['icon' => 'users', 'title' => 'Expert Trainers', 'text' => 'Learn from industry experts'],
                            ['icon' => 'chart', 'title' => 'Placement Support', 'text' => 'Better training, better jobs'],
                        ] as $benefit)
                            <div class="flex items-center gap-3">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-[#e8f1ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => $benefit['icon']])</span>
                                <span>
                                    <strong class="block text-[10px] font-bold leading-tight text-[#07518f]">{{ $benefit['title'] }}</strong>
                                    <span class="block text-[9px] font-semibold leading-tight text-[#34445e]">{{ $benefit['text'] }}</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <span id="partnerHeroCount" class="hidden">...</span>
                </div>
                <div class="relative min-h-[260px] lg:min-h-[300px]">
                    <div class="absolute inset-0 bg-[linear-gradient(90deg,#eef5ff_0%,rgba(238,245,255,0.82)_10%,rgba(238,245,255,0)_34%)]"></div>
                    <img src="{{ asset('training-partners-banner.png') }}" alt="Training partner students" class="h-full w-full object-cover object-center">
                </div>
            </div>
        </section>

        <div class="mx-auto w-full max-w-7xl px-5 py-8 sm:px-6 lg:px-8 lg:pb-[60px]">
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[13px] font-bold text-[#061942]">Showing 42 Training Partners</p>
                <div class="grid gap-3 sm:grid-cols-[190px_190px_110px]">
                    <select class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[12px] font-semibold text-[#34445e] outline-none"><option>All Categories</option></select>
                    <select class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[12px] font-semibold text-[#34445e] outline-none"><option>All Course Levels</option></select>
                    <button class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[#b9cff0] bg-white px-4 text-[12px] font-bold text-[#075fe4]" type="button">@include('components.public.icon', ['name' => 'search']) Filters</button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_285px]">
                <div class="grid gap-3">
                    @php
                        $courseRows = [
                            ['logo' => 'EXCELR', 'sub' => 'Raising Excellence', 'rating' => '4.6', 'reviews' => '1280', 'title' => 'Data Science & Analytics', 'city' => 'Bangalore, Karnataka', 'mode' => 'Classroom | Live Online', 'text' => 'Become a data expert and work with real-world data, analytics tools and dashboards.', 'join' => '999', 'fee' => '12,999', 'tags' => ['Python', 'SQL', 'Machine Learning', 'Power BI', '+2'], 'features' => ['60 Hours of Training', '80 Hours of Training', 'Hands-on Projects', 'Certificate of Completion', 'Placement Assistance']],
                            ['logo' => 'ENLITE', 'sub' => 'INSTITUTE', 'rating' => '4.5', 'reviews' => '980', 'title' => 'Full Stack Development', 'city' => 'Pune, Maharashtra', 'mode' => 'Classroom | Live Online', 'text' => 'Learn full stack web development from basics to deployment.', 'join' => '799', 'fee' => '10,999', 'tags' => ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js', '+2'], 'features' => ['80 Hours of Training', 'Live Projects', 'Certificate of Completion', 'Placement Assistance']],
                            ['logo' => 'iNeuron', 'sub' => 'Intelligence Pathway', 'rating' => '4.7', 'reviews' => '1640', 'title' => 'Cloud Computing (AWS)', 'city' => 'Online', 'mode' => 'Live Online', 'text' => 'Master AWS cloud services and build scalable cloud solutions.', 'join' => '999', 'fee' => '13,999', 'tags' => ['AWS', 'DevOps', 'Linux', 'Docker', '+1'], 'features' => ['50 Hours of Training', 'Real-time Labs', 'Certificate of Completion', 'Placement Assistance']],
                            ['logo' => 'Besant', 'sub' => 'Technologies', 'rating' => '4.4', 'reviews' => '870', 'title' => 'Digital Marketing', 'city' => 'Chennai, Tamil Nadu', 'mode' => 'Classroom | Live Online', 'text' => 'Learn digital marketing strategies and tools to grow brands and businesses.', 'join' => '699', 'fee' => '8,999', 'tags' => ['SEO', 'SEM', 'Social Media', 'Google Ads', '+2'], 'features' => ['50 Hours of Training', 'Live Projects', 'Certificate of Completion', 'Placement Assistance']],
                            ['logo' => 'TTA', 'sub' => 'The Tech Academy', 'rating' => '4.6', 'reviews' => '1120', 'title' => 'Python Programming', 'city' => 'Hyderabad, Telangana', 'mode' => 'Classroom | Live Online', 'text' => 'Learn Python programming from scratch and build real-world applications.', 'join' => '599', 'fee' => '7,999', 'tags' => ['Python', 'DSA', 'OOPs', 'Projects', '+1'], 'features' => ['45 Hours of Training', 'Hands-on Coding', 'Certificate of Completion', 'Placement Assistance']],
                            ['logo' => 'Teks academy', 'sub' => 'Transforming Life', 'rating' => '4.3', 'reviews' => '760', 'title' => 'Business Analytics', 'city' => 'Delhi, NCR', 'mode' => 'Live Online', 'text' => 'Turn data into insights and make better business decisions.', 'join' => '699', 'fee' => '9,999', 'tags' => ['Excel', 'SQL', 'Power BI', 'Tableau', '+1'], 'features' => ['45 Hours of Training', 'Case Studies', 'Certificate of Completion', 'Placement Assistance']],
                        ];
                    @endphp
                    @foreach ($courseRows as $row)
                        <article class="grid gap-4 rounded-lg border border-[#dce7f8] bg-white p-3 shadow-[0_6px_18px_rgba(6,25,66,0.04)] xl:grid-cols-[150px_minmax(0,1fr)_132px_175px_118px]">
                            <div class="flex flex-col justify-between border-b border-[#edf2f8] pb-3 xl:border-b-0 xl:border-r xl:pb-0 xl:pr-3">
                                <div>
                                    <strong class="block text-[22px] font-black leading-tight text-[#176aa6]">{{ $row['logo'] }}</strong>
                                    <span class="block text-[9px] font-bold text-[#6f7d90]">{{ $row['sub'] }}</span>
                                </div>
                                <p class="mt-3 text-[10px] font-bold text-[#061942]">{{ $row['rating'] }} <span class="text-[#f3a51d]">★</span> <span class="font-semibold text-[#6f7d90]">({{ $row['reviews'] }} Reviews)</span></p>
                            </div>
                            <div>
                                <h2 class="mb-1.5 text-[14px] font-bold text-[#061942]">{{ $row['title'] }}</h2>
                                <p class="mb-1 text-[10px] font-semibold text-[#34445e]">{{ $row['city'] }}</p>
                                <p class="mb-2 text-[10px] font-semibold text-[#34445e]">{{ $row['mode'] }}</p>
                                <p class="mb-2 line-clamp-2 text-[11px] font-semibold leading-4 text-[#34445e]">{{ $row['text'] }}</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($row['tags'] as $tag)
                                        <span class="rounded-md bg-[#f2f5f9] px-2 py-0.5 text-[9px] font-semibold text-[#34445e]">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold text-[#6f7d90]">Joining Fee</p>
                                <p class="mb-4 text-[16px] font-black text-[#0b9b6b]">₹{{ $row['join'] }}</p>
                                <p class="text-[10px] font-semibold text-[#6f7d90]">Package Fee (Per Course)</p>
                                <p class="text-[16px] font-black text-[#061942]">₹{{ $row['fee'] }}</p>
                            </div>
                            <ul class="grid content-start gap-1.5 text-[10px] font-semibold text-[#061942]">
                                @foreach ($row['features'] as $feature)
                                    <li class="flex gap-2"><span class="font-bold text-[#0b9b6b]">✓</span><span>{{ $feature }}</span></li>
                                @endforeach
                            </ul>
                            <div class="flex items-center xl:justify-end">
                                <a href="/courses" class="inline-flex h-8 min-w-[112px] items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[10px] font-bold text-[#075fe4] transition hover:bg-[#f3f8ff]">View Details</a>
                            </div>
                        </article>
                    @endforeach

                    <div class="flex justify-center">
                        <a href="/courses" class="inline-flex h-10 items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-5 text-[12px] font-bold text-[#075fe4]">Load More Partners ˅</a>
                    </div>
                </div>

                <aside class="grid content-start gap-4 lg:sticky lg:top-24">
                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-4 text-[13px] font-bold text-[#061942]">Why Join Fast Track Program?</h2>
                        <ul class="grid gap-3 text-[10px] font-semibold text-[#061942]">
                            @foreach (['Industry aligned training', 'Initial & Final assessment', 'Certification on completion', 'Enhanced job opportunities', 'Dedicated placement support'] as $item)
                                <li class="flex items-center gap-2"><span class="grid h-3.5 w-3.5 shrink-0 place-items-center rounded-full bg-[#0b9b6b] text-[8px] font-bold text-white">✓</span><span>{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </section>

                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-4 text-[13px] font-bold text-[#061942]">Popular Courses</h2>
                        @foreach ([
                            ['Data Science & Analytics', 'Starting at ₹12,999'],
                            ['Full Stack Development', 'Starting at ₹10,999'],
                            ['Cloud Computing (AWS)', 'Starting at ₹13,999'],
                            ['Digital Marketing', 'Starting at ₹8,999'],
                            ['Python Programming', 'Starting at ₹7,999'],
                        ] as $index => $course)
                            <a href="/courses" class="mb-3 flex items-center gap-3 rounded-md transition hover:bg-white last:mb-0">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-md text-[10px] font-black text-white {{ ['bg-[#35b99b]', 'bg-[#8239d7]', 'bg-[#2563eb]', 'bg-[#f59a23]', 'bg-[#21a391]'][$index] }}">{{ substr($course[0], 0, 2) }}</span>
                                <span><strong class="block text-[10px] font-bold text-[#061942]">{{ $course[0] }}</strong><span class="text-[9px] font-semibold text-[#6f7d90]">{{ $course[1] }}</span></span>
                            </a>
                        @endforeach
                        <a href="/courses" class="mt-3 inline-flex text-[10px] font-bold text-[#075fe4]">View All Courses -></a>
                    </section>

                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-4 text-[13px] font-bold text-[#061942]">How It Works?</h2>
                        @foreach ([['Choose a Course', 'Select a course that matches your career goals.'], ['Enroll & Pay', 'Pay joining fee and course package fee to enroll.'], ['Learn & Grow', 'Attend sessions, complete assignments and projects.'], ['Get Certified', 'Complete the course and get certified.'], ['Get Hired', 'Companies hire job-ready candidates like you.']] as $step => $item)
                            <div class="mb-4 flex gap-3 last:mb-0">
                                <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-[#075fe4] text-[11px] font-bold text-white">{{ $step + 1 }}</span>
                                <span><strong class="block text-[10px] font-bold text-[#061942]">{{ $item[0] }}</strong><span class="block text-[9px] font-semibold leading-4 text-[#34445e]">{{ $item[1] }}</span></span>
                            </div>
                        @endforeach
                    </section>

                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-2 text-[13px] font-bold text-[#061942]">Need Help Choosing?</h2>
                        <p class="mb-4 text-[10px] font-semibold leading-4 text-[#34445e]">Talk to our experts and find the right course for your career.</p>
                        <a href="/fast-track/register" class="inline-flex h-9 items-center justify-center gap-2 rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => 'users']) Talk to Expert</a>
                    </section>
                </aside>
            </div>

            <div class="mt-6 grid gap-0 overflow-hidden rounded-lg border border-[#edf2f8] bg-[#f8fbff] px-4 py-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ([['users', '100% Verified Trainers', 'Learn from industry experts'], ['training', 'Live Interactive Sessions', 'Real-time doubt solving'], ['learn', 'Hands-on Projects', 'Work on real-world projects'], ['briefcase', 'Placement Assistance', 'Get hired with confidence'], ['location', 'Flexible Learning', 'Classroom & Online options']] as $benefit)
                    <article class="flex min-h-[58px] items-center gap-3 px-4 py-2 xl:border-r xl:border-[#e7eef8] xl:last:border-r-0">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-md text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $benefit[0]])</span>
                        <span><strong class="block text-[10px] font-bold leading-tight text-[#075fe4]">{{ $benefit[1] }}</strong><span class="block text-[9px] font-semibold leading-tight text-[#34445e]">{{ $benefit[2] }}</span></span>
                    </article>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@push('unused-training-partner-scripts')
<script>
    const partnerListing = document.getElementById('partnerListing');
    const partnerDetail = document.getElementById('partnerDetail');
    const partnerGrid = document.getElementById('partnerGrid');
    const partnerDetailContent = document.getElementById('partnerDetailContent');
    const partnerCount = document.getElementById('partnerCount');
    const partnerHeroCount = document.getElementById('partnerHeroCount');
    const partnerSearch = document.getElementById('partnerSearch');
    const courseFilter = document.getElementById('courseFilter');
    const locationFilter = document.getElementById('locationFilter');
    const initialPartnerId = new URLSearchParams(window.location.search).get('partner');
    let partners = [];

    function esc(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char]);
    }

    function dataOf(result, key) {
        return result && result.data ? (key ? result.data[key] : result.data) : result;
    }

    function initials(value) {
        return String(value || 'TP').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'TP';
    }

    async function getJson(url) {
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Request failed');
        return result;
    }

    function coursesOf(partner) {
        return partner.courses || [];
    }

    function partnerText(partner) {
        return [
            partner.institute_name,
            partner.location,
            partner.about_institute,
            coursesOf(partner).map((course) => [course.course_name, course.category, course.skills_covered].join(' ')).join(' '),
        ].join(' ').toLowerCase();
    }

    function setOptions() {
        const categories = [...new Set(partners.flatMap((partner) => coursesOf(partner).map((course) => course.category)).filter(Boolean))].sort();
        const locations = [...new Set(partners.map((partner) => partner.location).filter(Boolean))].sort();
        courseFilter.innerHTML = '<option value="">All Categories</option>' + categories.map((item) => `<option value="${esc(item)}">${esc(item)}</option>`).join('');
        locationFilter.innerHTML = '<option value="">All Locations</option>' + locations.map((item) => `<option value="${esc(item)}">${esc(item)}</option>`).join('');
    }

    function filteredPartners() {
        const query = partnerSearch.value.trim().toLowerCase();
        const category = courseFilter.value;
        const location = locationFilter.value;
        return partners.filter((partner) => {
            const queryOk = !query || partnerText(partner).includes(query);
            const categoryOk = !category || coursesOf(partner).some((course) => course.category === category);
            const locationOk = !location || partner.location === location;
            return queryOk && categoryOk && locationOk;
        });
    }

    function renderPartners() {
        const rows = filteredPartners();
        partnerCount.textContent = rows.length + ' Training Partners Found';
        if (!rows.length) {
            partnerGrid.innerHTML = '<article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">No approved training partners found.</article>';
            return;
        }
        partnerGrid.innerHTML = rows.map((partner, index) => {
            const courses = coursesOf(partner);
            const tags = courses.flatMap((course) => [course.course_name, course.category]).filter(Boolean).slice(0, 4);
            const iconClass = ['bg-[#eff5ff] text-[#075fe4]', 'bg-[#eafaf8] text-[#17a078]', 'bg-[#f1efff] text-[#5142b9]', 'bg-[#fff0e2] text-[#f37a22]'][index % 4];
            return `<article class="partner-card px-5 pb-5 pt-6">
                <div class="relative z-10 mb-5 grid grid-cols-[minmax(0,1fr)_96px] gap-4">
                    <div class="flex min-w-0 items-start gap-4">
                        <div class="partner-badge shrink-0 ${iconClass}">${esc(initials(partner.institute_name))}</div>
                        <h2 class="partner-card-title m-0 min-w-0 font-['Inter'] text-[22px] font-semibold leading-tight text-[#061942]">${esc(partner.institute_name || 'Training Partner')}<small class="mt-1.5 block text-[11px] font-semibold uppercase tracking-[2px] text-[#075fe4]">${esc((partner.user && partner.user.name) || 'Approved Partner')}</small></h2>
                    </div>
                    <div class="partner-meta self-start">
                        <div class="font-bold text-[#061942]">${esc(partner.active_courses_count || courses.length)} Courses</div>
                        <div class="mt-1.5">${esc(partner.location || 'India')}</div>
                    </div>
                </div>
                <div class="relative z-10 mb-4 flex flex-wrap gap-2">${tags.length ? tags.map((tag) => `<span class="partner-chip">${esc(tag)}</span>`).join('') : '<span class="partner-chip">Fast Track</span>'}</div>
                <p class="relative z-10 mb-5 line-clamp-3 text-sm font-semibold leading-[1.75] text-[#34445e]">${esc(partner.about_institute || 'Verified training partner offering industry-ready courses for freshers.')}</p>
                <button class="view-partner partner-card-button relative z-10 mt-auto" type="button" data-id="${esc(partner.id)}">View Details</button>
            </article>`;
        }).join('');
    }

    function renderDetail(partner) {
        const courses = coursesOf(partner);
        partnerDetailContent.className = '';
        partnerDetailContent.innerHTML = `<div class="mb-[22px] grid gap-8 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:grid-cols-[minmax(0,1fr)_360px] lg:gap-[45px] lg:p-7">
            <div class="flex flex-col gap-6 sm:flex-row sm:gap-8">
                <div class="flex h-[135px] w-40 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-[46px] font-extrabold text-[#075fe4]">${esc(initials(partner.institute_name))}</div>
                <div>
                    <h1 class="mb-3.5 text-[30px] font-semibold text-[#061942] sm:text-[34px]">${esc(partner.institute_name || 'Training Partner')}</h1>
                    <div class="mb-[18px] flex flex-wrap gap-[18px] text-[15px] font-bold text-[#075fe4]"><span>Approved Partner</span><span>${esc(partner.active_courses_count || courses.length)} Courses</span></div>
                    <div class="mb-5 text-base font-medium text-[#34445e]">${esc(partner.location || 'India')}</div>
                    <p class="mb-[22px] max-w-[560px] text-base font-medium leading-[1.8] text-[#24344f]">${esc(partner.about_institute || 'Verified training partner dedicated to helping freshers build practical skills.')}</p>
                    ${partner.website ? `<a href="${esc(partner.website)}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]">Visit Website</a>` : ''}
                </div>
            </div>
            <div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-[18px]">
                ${statRow('Active Courses', partner.active_courses_count || courses.length)}
                ${statRow('Location', partner.location || '-')}
                ${statRow('Phone', partner.phone || partner.user?.mobile || '-')}
                ${statRow('Email', partner.email || partner.user?.email || '-')}
            </div>
        </div>
        <div class="grid gap-[22px] lg:grid-cols-[1.3fr_1fr]">
            <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Popular Courses</h2>
                <div class="grid gap-3 md:grid-cols-3">
                    ${courses.length ? courses.slice(0, 6).map(courseCard).join('') : '<p class="text-sm font-medium text-[#34445e]">No active courses found.</p>'}
                </div>
                <a href="/courses" class="mx-auto mt-[18px] flex h-10 w-[220px] items-center justify-center rounded-lg border border-[#a9c5f6] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Explore All Courses</a>
            </div>
            <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Why Learn Here?</h2>
                ${whyItem('TR', 'Industry-relevant Training', 'Curriculum aligned with active courses and practical skills.')}
                ${whyItem('EX', 'Verified Partner', 'Only approved training partners are visible publicly.')}
                ${whyItem('CT', 'Certificate Path', 'Complete training and final assessment to earn certificates.')}
            </div>
        </div>`;
    }

    function statRow(label, value) {
        return `<div class="flex justify-between gap-5 border-b border-[#dce7f8] py-4 text-sm font-bold text-[#24344f] last:border-b-0"><span>${esc(label)}</span><span class="text-right text-lg font-extrabold text-[#061942]">${esc(value)}</span></div>`;
    }

    function courseCard(course) {
        return `<article class="rounded-lg border border-[#dce7f8] p-4">
            <div class="mb-3 flex h-[50px] w-[50px] items-center justify-center rounded-[10px] bg-[#eff5ff] font-extrabold text-[#075fe4]">${esc(initials(course.course_name))}</div>
            <h3 class="mb-2 text-base font-semibold text-[#061942]">${esc(course.course_name || 'Course')}</h3>
            <p class="line-clamp-3 text-sm font-medium leading-[1.7] text-[#34445e]">${esc(course.description || 'Industry-ready course.')}</p>
            <div class="mt-3.5 text-[13px] font-semibold leading-[1.8] text-[#24344f]">${esc(course.duration || 'Flexible')}<br>${esc(course.training_mode || 'Online')}</div>
            <a href="/courses/show?course=${esc(course.id)}" class="mt-3 inline-flex h-9 items-center justify-center rounded-md border border-[#a9c5f6] px-3 text-xs font-bold text-[#075fe4]">View Course</a>
        </article>`;
    }

    function whyItem(icon, title, text) {
        return `<div class="mb-5 flex gap-3.5 last:mb-0"><div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[13px] font-extrabold text-[#075fe4]">${icon}</div><div><h3 class="mb-2 text-base font-semibold text-[#061942]">${esc(title)}</h3><p class="text-sm font-medium leading-[1.7] text-[#34445e]">${esc(text)}</p></div></div>`;
    }

    async function showPartnerDetail(id) {
        partnerListing.classList.add('hidden');
        partnerDetail.classList.remove('hidden');
        partnerDetailContent.className = 'rounded-lg border border-[#dce7f8] bg-white p-6 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,0.04)]';
        partnerDetailContent.textContent = 'Loading partner details...';
        window.scrollTo(0, 0);
        try {
            const result = await getJson('/api/training-partners/' + id);
            renderDetail(dataOf(result, 'training_partner'));
            history.replaceState(null, '', '/training-partners/show?partner=' + id);
        } catch (error) {
            partnerDetailContent.className = 'rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm text-[#b42318]';
            partnerDetailContent.textContent = error.message || 'Partner details load nahi ho paaye.';
        }
    }

    function showPartnerListing() {
        partnerListing.classList.remove('hidden');
        partnerDetail.classList.add('hidden');
        history.replaceState(null, '', '/training-partners');
        window.scrollTo(0, 0);
    }
    window.showPartnerListing = showPartnerListing;

    function loadPartners() {
        getJson('/api/training-partners?per_page=100').then((result) => {
            const page = dataOf(result, 'training_partners') || {};
            partners = Array.isArray(page) ? page : (page.data || []);
            partnerHeroCount.textContent = partners.length;
            setOptions();
            renderPartners();
            if (initialPartnerId) showPartnerDetail(initialPartnerId);
        }).catch((error) => {
            partnerHeroCount.textContent = '0';
            partnerCount.textContent = '0 Training Partners Found';
            partnerGrid.innerHTML = `<article class="rounded-lg border border-[#ffd6a8] bg-[#fff8ef] p-6 text-sm font-semibold text-[#8a5200] lg:col-span-3">${esc(error.message || 'Partners load nahi ho paaye.')}</article>`;
        });
    }

    document.getElementById('partnerSearchButton').addEventListener('click', renderPartners);
    document.getElementById('clearPartnerFilters').addEventListener('click', () => {
        partnerSearch.value = '';
        courseFilter.value = '';
        locationFilter.value = '';
        renderPartners();
    });
    [partnerSearch, courseFilter, locationFilter].forEach((input) => {
        input.addEventListener('input', renderPartners);
        input.addEventListener('change', renderPartners);
    });
    partnerGrid.addEventListener('click', (event) => {
        const button = event.target.closest('.view-partner');
        if (button) showPartnerDetail(button.dataset.id);
    });

    loadPartners();
</script>
@endpush
