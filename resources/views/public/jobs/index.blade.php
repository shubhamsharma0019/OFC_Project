@extends('layouts.public')

@section('title', 'Jobs - OnlyFreshers')

@php
    $activePage = 'jobs';

    $jobs = [
        ['logo' => 'TN', 'title' => 'Software Development Engineer', 'company' => 'TechNova Solutions', 'location' => 'Bengaluru, India', 'type' => 'Full Time', 'experience' => '0 - 2 Years', 'description' => 'Build scalable web applications and collaborate with cross-functional teams.', 'posted' => 'Posted 2 days ago'],
        ['logo' => 'FA', 'title' => 'Graduate Analyst', 'company' => 'FinEdge Analytics', 'location' => 'Mumbai, India', 'type' => 'Full Time', 'experience' => '0 - 1 Year', 'description' => 'Analyze business data, create insights, and support decision-making.', 'posted' => 'Posted 3 days ago'],
        ['logo' => 'UX', 'title' => 'Junior UI/UX Designer', 'company' => 'PixelCraft Studios', 'location' => 'Pune, India', 'type' => 'Full Time', 'experience' => '0 - 2 Years', 'description' => 'Design intuitive user interfaces and experiences for web and mobile apps.', 'posted' => 'Posted 5 days ago'],
        ['logo' => 'DA', 'title' => 'Data Analyst Trainee', 'company' => 'Insitech Solutions', 'location' => 'Hyderabad, India', 'type' => 'Full Time', 'experience' => '0 - 1 Year', 'description' => 'Work with datasets to extract insights and assist in building dashboards.', 'posted' => 'Posted 1 week ago'],
    ];

    $filters = [
        ['title' => 'Job Type', 'items' => ['Full Time', 'Part Time', 'Internship', 'Contract'], 'more' => true],
        ['title' => 'Experience Level', 'items' => ['Fresher', '0 - 1 Year', '1 - 3 Years', '3 - 5 Years', '5+ Years']],
        ['title' => 'Work Mode', 'items' => ['On-site', 'Hybrid', 'Remote']],
    ];

    $description = [
        'Work on end-to-end development of web applications.',
        'Collaborate with cross-functional teams to define and deliver features.',
        'Write clean, efficient, and well-documented code.',
        'Troubleshoot, debug, and optimize application performance.',
    ];

    $requirements = [
        "Bachelor's degree in Computer Science or related field.",
        'Strong problem-solving skills and a keen eye for detail.',
        'Good understanding of data structures, algorithms, and OOP concepts.',
        'Basic knowledge of web technologies such as HTML, CSS, JavaScript.',
    ];

    $skills = ['JavaScript', 'React.js', 'HTML', 'CSS', 'Git', 'REST APIs'];
    $benefits = [['HI', 'Health Insurance'], ['FW', 'Flexible Work'], ['LG', 'Learning & Growth'], ['PB', 'Performance Bonus']];
    $overview = [
        'Job Type' => 'Full Time',
        'Experience' => 'Fresher',
        'Location' => 'Noida, India',
        'Industry' => 'IT Services',
        'Salary' => 'Rs. 3.5 - 5 LPA',
    ];
@endphp

@section('content')
    <main class="bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-10 lg:py-[42px] lg:pb-[65px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div id="listingView">
                <h1 class="m-0 text-[28px] font-semibold text-[#061942] sm:text-[34px]">Find Your Dream Job</h1>
                <p class="mb-6 mt-2 text-base font-medium text-[#34445e]">Explore the latest job openings and start your career today.</p>

                <div class="mb-[18px] grid gap-3.5 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,0.04)] lg:grid-cols-[1.3fr_1fr_1fr_160px] lg:gap-6">
                    <input class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]" type="text" placeholder="Search job title or keyword">
                    <select class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        <option>All Categories</option>
                        <option>Development</option>
                        <option>Analytics</option>
                        <option>Design</option>
                    </select>
                    <select class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        <option>All Locations</option>
                        <option>Bengaluru</option>
                        <option>Mumbai</option>
                        <option>Noida</option>
                    </select>
                    <button class="h-[46px] rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]" type="button">Search</button>
                </div>

                <div class="grid gap-[22px] lg:grid-cols-[230px_minmax(0,1fr)] lg:gap-[35px]">
                    <aside class="rounded-lg border border-[#dce7f8] bg-white p-[18px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h3 class="mb-[18px] text-base font-semibold text-[#061942]">Filters</h3>

                        @foreach ($filters as $filter)
                            <div class="mb-3.5 border-b border-[#dce7f8] pb-3.5 last:mb-0 last:border-b-0 last:pb-0">
                                <p class="mb-2.5 text-[13px] font-semibold text-[#061942]">{{ $filter['title'] }}</p>
                                @foreach ($filter['items'] as $item)
                                    <label class="mb-2 block text-sm font-medium text-[#24344f]"><input type="checkbox" class="mr-2 accent-[#075fe4]">{{ $item }}</label>
                                @endforeach
                                @if (!empty($filter['more']))
                                    <a href="#" class="text-[13px] font-bold text-[#075fe4]">Show more</a>
                                @endif
                            </div>
                        @endforeach

                        <div class="pt-3.5">
                            <p class="mb-2.5 text-[13px] font-semibold text-[#061942]">Location</p>
                            <input class="mb-2.5 h-[46px] w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d]" type="text" placeholder="Search location">
                            @foreach (['Bengaluru', 'Hyderabad', 'Pune', 'Noida', 'Remote'] as $location)
                                <label class="mb-2 block text-sm font-medium text-[#24344f]"><input type="checkbox" class="mr-2 accent-[#075fe4]">{{ $location }}</label>
                            @endforeach
                        </div>
                    </aside>

                    <section class="min-w-0">
                        <div class="mb-2.5 flex flex-col gap-3 text-sm font-bold text-[#061942] sm:flex-row sm:items-center sm:justify-between">
                            <span>{{ count($jobs) }} Jobs Found</span>
                            <select class="h-[46px] w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none sm:w-[150px]">
                                <option>Newest First</option>
                                <option>Oldest First</option>
                            </select>
                        </div>

                        <div class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                            @foreach ($jobs as $job)
                                <article class="grid gap-4 border-b border-[#dce7f8] p-[18px] last:border-b-0 sm:grid-cols-[75px_minmax(0,1fr)] lg:grid-cols-[75px_minmax(0,1fr)_135px] lg:items-center lg:gap-[22px] lg:p-6">
                                    <div class="flex h-[70px] w-[70px] items-center justify-center rounded-lg border border-[#dce7f8] bg-[#fbfdff] text-[22px] font-semibold text-[#075fe4]">{{ $job['logo'] }}</div>
                                    <div class="min-w-0">
                                        <h2 class="mb-1.5 text-lg font-semibold text-[#061942]">{{ $job['title'] }}</h2>
                                        <div class="mb-2 flex flex-wrap gap-x-3.5 gap-y-1 text-sm font-medium text-[#52607a]">
                                            <span>{{ $job['company'] }}</span>
                                            <span>{{ $job['location'] }}</span>
                                            <span>{{ $job['type'] }}</span>
                                            <span>{{ $job['experience'] }}</span>
                                        </div>
                                        <p class="text-sm font-medium leading-[1.6] text-[#24344f]">{{ $job['description'] }}</p>
                                    </div>
                                    <div class="sm:col-start-2 lg:col-start-auto lg:text-right">
                                        <div class="mb-4 text-[13px] font-medium text-[#52607a] lg:mb-7">{{ $job['posted'] }}</div>
                                        <button class="inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" onclick="showDetail()">View Details</button>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>

            <div id="detailView" class="hidden">
                <button class="mb-6 inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" onclick="showListing()">Back to Jobs</button>

                <div class="grid gap-7 lg:grid-cols-[minmax(0,1fr)_320px] lg:gap-[70px] lg:items-start">
                    <div class="min-w-0">
                        <h1 class="mb-[18px] text-[28px] font-semibold leading-tight text-[#061942] sm:text-[34px]">Software Development Engineer</h1>

                        <div class="mb-[22px] flex items-center gap-3 text-[17px] font-bold text-[#061942]">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#eff5ff] text-[13px] font-extrabold text-[#075fe4]">CO</span>
                            <span>ABC Technologies</span>
                        </div>

                        <div class="mb-7 flex flex-wrap gap-[18px] text-[15px] font-medium text-[#52607a]">
                            <span>Noida, India</span>
                            <span>Full Time</span>
                            <span>Fresher</span>
                            <span>Posted 2 days ago</span>
                        </div>

                        <p class="max-w-[720px] text-base font-medium leading-[1.8] text-[#24344f]">
                            Join our engineering team to build scalable, high-performance web applications that solve real-world problems and create meaningful impact.
                        </p>

                        <div class="border-b border-[#dce7f8] py-[22px]">
                            <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Job Description</h2>
                            <ul class="list-disc space-y-1 pl-5 text-[15px] font-medium leading-[1.8] text-[#24344f] marker:text-[#075fe4]">
                                @foreach ($description as $item)<li>{{ $item }}</li>@endforeach
                            </ul>
                        </div>

                        <div class="border-b border-[#dce7f8] py-[22px]">
                            <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Requirements</h2>
                            <ul class="list-disc space-y-1 pl-5 text-[15px] font-medium leading-[1.8] text-[#24344f] marker:text-[#075fe4]">
                                @foreach ($requirements as $item)<li>{{ $item }}</li>@endforeach
                            </ul>
                        </div>

                        <div class="border-b border-[#dce7f8] py-[22px]">
                            <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Key Skills</h2>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach ($skills as $skill)
                                    <span class="rounded-lg border border-[#a9c5f6] bg-white px-[18px] py-2 text-sm font-bold text-[#075fe4]">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="py-[22px]">
                            <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Benefits</h2>
                            <div class="flex flex-wrap gap-x-[35px] gap-y-3">
                                @foreach ($benefits as [$icon, $benefit])
                                    <div class="text-[15px] font-semibold text-[#24344f]"><span class="mr-2 inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#eff5ff] text-[13px] font-extrabold text-[#075fe4]">{{ $icon }}</span>{{ $benefit }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <aside class="min-w-0">
                        <div class="mb-[22px] rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                            <a href="#" class="mb-3 flex h-11 w-full items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#003f9e]">Apply Now</a>
                            <a href="#" class="flex h-11 w-full items-center justify-center rounded-lg border border-[#a9c5f6] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Save Job</a>
                        </div>

                        <div class="rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                            <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Job Overview</h2>
                            @foreach ($overview as $label => $value)
                                <div class="flex items-center justify-between gap-4 border-b border-[#dce7f8] py-3.5 text-sm font-medium text-[#24344f] last:border-b-0">
                                    <span>{{ $label }}</span>
                                    <strong class="text-right font-bold text-[#061942]">{{ $value }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    function showDetail() {
        document.getElementById('listingView').classList.add('hidden');
        document.getElementById('detailView').classList.remove('hidden');
        window.scrollTo(0, 0);
    }

    function showListing() {
        document.getElementById('listingView').classList.remove('hidden');
        document.getElementById('detailView').classList.add('hidden');
        window.scrollTo(0, 0);
    }
</script>
@endpush