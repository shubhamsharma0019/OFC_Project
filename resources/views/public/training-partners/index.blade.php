@extends('layouts.public')

@section('title', 'Training Partners - OnlyFreshers')

@php
    $activePage = 'training-partners';

    $partners = [
        ['icon' => 'N', 'iconClass' => 'bg-[#eff5ff] text-[#075fe4]', 'name' => 'NEXORA', 'type' => 'TECHNOLOGIES', 'rating' => '4.6', 'location' => 'Bangalore, India', 'tags' => ['Full Stack Development', 'Data Analytics', 'UI/UX Design'], 'text' => 'Industry-focused programs designed to build in-demand skills and real-world experience.'],
        ['icon' => 'CV', 'iconClass' => 'bg-[#eafaf8] text-[#17a078]', 'name' => 'CodeVista', 'type' => 'ACADEMY', 'rating' => '4.7', 'location' => 'Pune, India', 'tags' => ['Full Stack Development', 'Data Science', 'DevOps'], 'text' => 'Hands-on training with real-time projects and expert mentorship.'],
        ['icon' => 'SL', 'iconClass' => 'bg-[#f1efff] text-[#5142b9]', 'name' => 'Skillance', 'type' => 'LEARNING', 'rating' => '4.5', 'location' => 'Hyderabad, India', 'tags' => ['Python Programming', 'Cloud Computing', 'AI/ML'], 'text' => 'Career-aligned courses to help freshers transition into top tech roles.'],
        ['icon' => 'LX', 'iconClass' => 'bg-[#fff0e2] text-[#f37a22]', 'name' => 'Logixperts', 'type' => 'INSTITUTE', 'rating' => '4.6', 'location' => 'Noida, India', 'tags' => ['Software Testing', 'Automation Testing', 'QA & QC'], 'text' => 'Practical learning approach with industry use-cases and certification support.'],
        ['icon' => 'DV', 'iconClass' => 'bg-[#eafaff] text-[#159abd]', 'name' => 'DataVance', 'type' => 'ACADEMY', 'rating' => '4.6', 'location' => 'Mumbai, India', 'tags' => ['Data Analytics', 'Business Intelligence', 'SQL'], 'text' => 'Data-driven training programs to turn freshers into analytics professionals.'],
        ['icon' => 'CM', 'iconClass' => 'bg-[#eff5ff] text-[#075fe4]', 'name' => 'CloudMindz', 'type' => 'TECHNOLOGIES', 'rating' => '4.5', 'location' => 'Chennai, India', 'tags' => ['Cloud Computing', 'AWS', 'DevOps'], 'text' => 'Cloud and DevOps training with hands-on labs and real-world projects.'],
    ];

    $stats = ['Popular Course Areas' => '5+', 'Students Trained' => '25,000+', 'Placement Support' => 'Yes', 'Certification' => 'Yes'];
    $courses = [
        ['icon' => 'FS', 'title' => 'Full Stack Development', 'text' => 'Learn end-to-end web development using modern technologies.', 'meta' => '4 - 6 Months|Online / Live Classes'],
        ['icon' => 'DS', 'title' => 'Data Science & Analytics', 'text' => 'Master data analysis, machine learning, and visualization techniques.', 'meta' => '4 - 6 Months|Online / Live Classes'],
        ['icon' => 'ST', 'title' => 'Software Testing', 'text' => 'Learn manual and automation testing with real-world projects.', 'meta' => '2 - 3 Months|Online / Live Classes'],
    ];
    $whyItems = [
        ['icon' => 'TR', 'title' => 'Industry-relevant Training', 'text' => 'Curriculum designed by industry experts with real-world applications.'],
        ['icon' => 'EX', 'title' => 'Experienced Trainers', 'text' => 'Learn from professionals with years of hands-on experience.'],
        ['icon' => 'LV', 'title' => 'Live Interactive Sessions', 'text' => 'Engaging live classes with doubt-solving and hands-on practice.'],
        ['icon' => 'CT', 'title' => 'Certificate on Completion', 'text' => 'Earn a recognized certificate to boost your career opportunities.'],
    ];
@endphp

@section('content')
    <main class="bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-12 lg:pb-[60px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div id="partnerListing">
                <h1 class="m-0 text-[32px] font-semibold leading-tight text-[#061942] sm:text-[42px]">Our Trusted <span class="text-[#075fe4]">Training Partners</span></h1>
                <p class="mb-6 mt-2.5 max-w-3xl text-base font-medium text-[#34445e]">Explore our verified and industry-aligned training partners who help freshers build job-ready skills.</p>

                <div class="mb-6 grid gap-3.5 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,0.04)] lg:grid-cols-[1.3fr_1fr_1fr_160px] lg:gap-6">
                    <input class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4]" type="text" placeholder="Search by partner or course">
                    <select class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4]"><option>All Categories</option><option>Full Stack Development</option><option>Data Analytics</option><option>Cloud Computing</option></select>
                    <select class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4]"><option>All Locations</option><option>Bangalore</option><option>Pune</option><option>Hyderabad</option></select>
                    <button class="h-[46px] rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]" type="button">Search</button>
                </div>

                <div class="grid gap-[22px] lg:grid-cols-3">
                    @foreach ($partners as $partner)
                        <article class="rounded-lg border border-[#dce7f8] bg-white px-6 pb-[22px] pt-7 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                            <div class="mb-[18px] flex flex-col gap-[18px] sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex items-center gap-[13px]">
                                    <div class="flex h-[58px] w-[58px] shrink-0 items-center justify-center rounded-[10px] text-xl font-extrabold {{ $partner['iconClass'] }}">{{ $partner['icon'] }}</div>
                                    <h2 class="m-0 text-[22px] font-semibold leading-tight text-[#061942]">{{ $partner['name'] }}<small class="mt-1 block text-[11px] font-medium uppercase tracking-[2px] text-[#24344f]">{{ $partner['type'] }}</small></h2>
                                </div>
                                <div class="text-sm font-medium text-[#34445e] sm:text-right">
                                    <div class="font-bold text-[#061942]">Star {{ $partner['rating'] }}</div>
                                    <div class="mt-2">{{ $partner['location'] }}</div>
                                </div>
                            </div>
                            <div class="mb-4 flex flex-wrap gap-2">
                                @foreach ($partner['tags'] as $tag)
                                    <span class="rounded-md border border-[#a9c5f6] bg-[#f8fbff] px-3 py-1.5 text-xs font-bold text-[#075fe4]">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <p class="mb-[18px] text-sm font-medium leading-[1.7] text-[#34445e]">{{ $partner['text'] }}</p>
                            <button class="mx-auto block h-10 w-[170px] rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" onclick="showPartnerDetail()">View Details</button>
                        </article>
                    @endforeach
                </div>

                <div class="mt-[26px] text-center">
                    <a href="#" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-6 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">View All Partners</a>
                </div>
            </div>

            <div id="partnerDetail" class="hidden">
                <button class="mb-[22px] inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" onclick="showPartnerListing()">Back to Partners</button>

                <div class="mb-[22px] grid gap-8 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:grid-cols-[minmax(0,1fr)_420px] lg:gap-[45px] lg:p-7">
                    <div class="flex flex-col gap-6 sm:flex-row sm:gap-8">
                        <div class="flex h-[135px] w-40 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-[46px] font-extrabold text-[#17a078]">CV</div>
                        <div>
                            <h1 class="mb-3.5 text-[30px] font-semibold text-[#061942] sm:text-[34px]">CodeVista Academy</h1>
                            <div class="mb-[18px] flex gap-[18px] text-[15px] font-bold text-[#075fe4]"><span>Star 4.7</span><span>120 Reviews</span></div>
                            <div class="mb-5 text-base font-medium text-[#34445e]">Bangalore, Karnataka, India</div>
                            <p class="mb-[22px] max-w-[520px] text-base font-medium leading-[1.8] text-[#24344f]">CodeVista Academy is a leading training partner dedicated to empowering freshers and professionals with industry-relevant skills. Our expert-led programs focus on practical learning, real-world projects, and career support to help you build a successful future in tech.</p>
                            <a href="#" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]">Visit Website</a>
                        </div>
                    </div>

                    <div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-[18px]">
                        @foreach ($stats as $label => $value)
                            <div class="flex justify-between gap-5 border-b border-[#dce7f8] py-4 text-sm font-bold text-[#24344f] last:border-b-0"><span>{{ $label }}</span><span class="text-lg font-extrabold text-[#061942]">{{ $value }}</span></div>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-[22px] lg:grid-cols-[1.3fr_1fr]">
                    <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Popular Courses</h2>
                        <div class="grid gap-3 md:grid-cols-3">
                            @foreach ($courses as $course)
                                <article class="rounded-lg border border-[#dce7f8] p-4">
                                    <div class="mb-3 flex h-[50px] w-[50px] items-center justify-center rounded-[10px] bg-[#eff5ff] font-extrabold text-[#075fe4]">{{ $course['icon'] }}</div>
                                    <h3 class="mb-2 text-base font-semibold text-[#061942]">{{ $course['title'] }}</h3>
                                    <p class="text-sm font-medium leading-[1.7] text-[#34445e]">{{ $course['text'] }}</p>
                                    <div class="mt-3.5 text-[13px] font-semibold leading-[1.8] text-[#24344f]">{!! str_replace('|', '<br>', e($course['meta'])) !!}</div>
                                </article>
                            @endforeach
                        </div>
                        <a href="#" class="mx-auto mt-[18px] flex h-10 w-[220px] items-center justify-center rounded-lg border border-[#a9c5f6] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Explore All Courses</a>
                    </div>

                    <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Why Learn with CodeVista Academy?</h2>
                        @foreach ($whyItems as $item)
                            <div class="mb-5 flex gap-3.5 last:mb-0">
                                <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[13px] font-extrabold text-[#075fe4]">{{ $item['icon'] }}</div>
                                <div>
                                    <h3 class="mb-2 text-base font-semibold text-[#061942]">{{ $item['title'] }}</h3>
                                    <p class="text-sm font-medium leading-[1.7] text-[#34445e]">{{ $item['text'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    function showPartnerDetail() {
        document.getElementById('partnerListing').classList.add('hidden');
        document.getElementById('partnerDetail').classList.remove('hidden');
        window.scrollTo(0, 0);
    }

    function showPartnerListing() {
        document.getElementById('partnerListing').classList.remove('hidden');
        document.getElementById('partnerDetail').classList.add('hidden');
        window.scrollTo(0, 0);
    }
</script>
@endpush