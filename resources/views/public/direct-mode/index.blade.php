@extends('layouts.public')

@section('title', 'Direct Mode - OnlyFreshers')

@php
    $activePage = 'direct-mode';
    $steps = [
        ['title' => 'Create Fresher Profile', 'text' => 'Register, add education, skills, and resume.'],
        ['title' => 'Complete Initial Assessment', 'text' => 'Your score decides the recommended path.'],
        ['title' => 'Choose Your Mode', 'text' => 'Continue with Direct Mode or Fast Track after results.'],
        ['title' => 'Apply to Jobs', 'text' => 'Apply only after profile and assessment are complete.'],
    ];
@endphp

@push('styles')
<style>
    .direct-mode-page,
    .direct-mode-page * {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .direct-mode-page h1,
    .direct-mode-page h2,
    .direct-mode-page h3 {
        font-weight: 700;
    }
</style>
@endpush

@section('content')
    <main class="direct-mode-page bg-white">
    <section class="bg-white px-4 py-5 sm:px-6 lg:px-8">
        <div class="mx-auto grid w-full max-w-7xl gap-4 rounded-lg border border-[#dbe8fb] bg-[#edf5ff] p-3 shadow-[0_8px_24px_rgba(7,95,228,0.08)] lg:grid-cols-[1.05fr_1.35fr] lg:items-center">
            <article class="flex items-center gap-5 rounded-lg bg-[#eef5ff] px-5 py-4">
                <img src="{{ asset('fast-track-hero-girl.png') }}" alt="Ananya Gupta" class="h-[108px] w-[108px] shrink-0 rounded-full border border-white object-cover object-top shadow-[0_8px_18px_rgba(6,25,66,0.12)]">
                <div class="min-w-0">
                    <p class="mb-1 text-[13px] font-bold leading-none text-[#061942]">Welcome,</p>
                    <h1 class="mb-2 truncate text-[25px] leading-tight text-[#061942]">Ananya Gupta</h1>
                    <p class="mb-4 inline-flex items-center gap-1.5 text-[13px] font-bold text-[#075fe4]">
                        <span class="grid h-4 w-4 place-items-center rounded-full bg-[#075fe4] text-[10px] text-white">✓</span>
                        Verified Fresher
                    </p>
                    <p class="mb-1 text-[13px] font-semibold text-[#061942]">B.Tech - Computer Science</p>
                    <p class="flex items-center gap-1.5 text-[13px] font-semibold text-[#34445e]">
                        <span class="[&>svg]:h-3.5 [&>svg]:w-3.5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2">@include('components.public.icon', ['name' => 'location'])</span>
                        Delhi, India
                    </p>
                </div>
            </article>

            <article class="grid gap-5 rounded-lg border border-[#e0e9f6] bg-white px-6 py-5 shadow-[0_2px_12px_rgba(6,25,66,0.04)] md:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] md:items-center">
                <div class="flex items-center gap-5">
                    <span class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-[#edf5ff] text-[#075fe4] [&>svg]:h-8 [&>svg]:w-8">@include('components.public.icon', ['name' => 'data'])</span>
                    <div>
                        <p class="mb-2 text-[11px] font-black uppercase tracking-[.04em] text-[#061942]">Free Application Credits</p>
                        <p class="text-[30px] font-bold leading-none text-[#061942]">500</p>
                        <p class="mt-1 text-[13px] font-semibold text-[#34445e]">Available</p>
                    </div>
                </div>

                <div class="border-t border-[#e7eef8] pt-4 md:border-l md:border-t-0 md:pl-6 md:pt-0">
                    <h2 class="mb-2 text-[14px] text-[#061942]">Apply to jobs for FREE!</h2>
                    <p class="mb-3 max-w-[330px] text-[12px] font-semibold leading-5 text-[#34445e]">You get 500 free application credits under Direct Mode to apply for jobs.</p>
                    <a href="/direct-mode/register" class="text-[12px] font-bold text-[#075fe4]">Learn More</a>
                </div>
            </article>
        </div>
    </section>

    <section class="bg-white px-5 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="mb-1 flex items-center gap-1.5 text-[18px] text-[#061942]">Apply Jobs (Direct Mode) <span class="grid h-4 w-4 place-items-center rounded-full border border-[#9bb7dc] text-[10px] font-bold text-[#075fe4]">i</span></h2>
                    <p class="text-[12px] font-semibold text-[#34445e]">Companies receive your resume along with Initial Track Analysis to find the right match.</p>
                </div>
                <a href="/direct-mode" class="inline-flex h-8 shrink-0 items-center gap-2 rounded-full border border-[#075fe4] bg-white px-4 text-[11px] font-bold text-[#075fe4]">
                    <span class="grid h-4 w-4 place-items-center rounded-full border border-[#075fe4] text-[9px]">i</span>
                    How Direct Mode Works
                </a>
            </div>

            <div class="grid gap-0 overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_8px_20px_rgba(6,25,66,0.04)] md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['icon' => 'users', 'value' => '500', 'label' => 'Free Credits Available'],
                    ['icon' => 'chart', 'value' => '0', 'label' => 'Applications Used'],
                    ['icon' => 'chart', 'value' => '500', 'label' => 'Applications Remaining'],
                    ['icon' => 'plus', 'value' => '', 'label' => 'Purchase Credits To Apply More'],
                ] as $item)
                    <article class="flex min-h-[88px] items-center gap-4 border-b border-[#edf2f8] px-5 py-4 md:border-r xl:border-b-0 xl:last:border-r-0">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-md bg-[#edf5ff] text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">
                            @if ($item['icon'] === 'plus')
                                <span class="text-[30px] font-light leading-none">+</span>
                            @else
                                @include('components.public.icon', ['name' => $item['icon']])
                            @endif
                        </span>
                        <span>
                            @if ($item['value'] !== '')
                                <strong class="block text-[22px] leading-none text-[#061942]">{{ $item['value'] }}</strong>
                            @endif
                            <span class="block max-w-[120px] text-[11px] font-bold leading-4 text-[#061942]">{{ $item['label'] }}</span>
                        </span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-5 pb-12 sm:px-6 lg:px-8">
        <div class="mx-auto grid w-full max-w-7xl gap-6 px-5 sm:px-6 lg:grid-cols-[minmax(0,1fr)_310px] lg:px-8">
            <div class="min-w-0">
                <div class="mb-4 grid gap-3 md:grid-cols-[minmax(0,1fr)_190px_190px_100px]">
                    <div class="flex h-10 items-center gap-2 rounded-md border border-[#dce7f8] bg-white px-3 text-[#6f7d90]">
                        <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => 'search'])</span>
                        <span class="text-[11px] font-semibold">Search job title, keyword or company</span>
                    </div>
                    <select class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[11px] font-semibold text-[#34445e]"><option>All Locations</option></select>
                    <select class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[11px] font-semibold text-[#34445e]"><option>All Job Roles</option></select>
                    <button class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#075fe4]" type="button">@include('components.public.icon', ['name' => 'search']) Filters</button>
                </div>

                <div class="grid gap-3">
                    @foreach ([
                        ['logo' => 'tcs', 'company' => 'Tata Consultancy Services', 'title' => 'Software Engineer', 'location' => 'Mumbai, India', 'type' => 'Full-time', 'exp' => '0 - 1 Year', 'posted' => 'Posted 2 days ago', 'fit' => 'Good Fit', 'fitClass' => 'bg-[#dff6ef] text-[#0b8b67]'],
                        ['logo' => 'Infosys', 'company' => 'Infosys', 'title' => 'Associate Developer', 'location' => 'Bangalore, India', 'type' => 'Full-time', 'exp' => '0 - 1 Year', 'posted' => 'Posted 1 day ago', 'fit' => 'Good Fit', 'fitClass' => 'bg-[#dff6ef] text-[#0b8b67]'],
                        ['logo' => 'wipro', 'company' => 'Wipro', 'title' => 'Graduate Engineer Trainee', 'location' => 'Chennai, India', 'type' => 'Full-time', 'exp' => '0 - 1 Year', 'posted' => 'Posted 3 days ago', 'fit' => 'Average Fit', 'fitClass' => 'bg-[#fff1d8] text-[#d57a00]'],
                        ['logo' => 'HCL', 'company' => 'HCL Technologies', 'title' => 'Software Trainee', 'location' => 'Noida, India', 'type' => 'Full-time', 'exp' => '0 - 1 Year', 'posted' => 'Posted 5 days ago', 'fit' => 'Good Fit', 'fitClass' => 'bg-[#dff6ef] text-[#0b8b67]'],
                    ] as $job)
                        <article class="grid gap-4 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_5px_15px_rgba(6,25,66,0.035)] sm:grid-cols-[76px_minmax(0,1fr)_135px_104px] sm:items-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-md bg-white text-[20px] font-black text-[#075fe4]">{{ $job['logo'] }}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1 text-[14px] text-[#061942]">{{ $job['title'] }}</h3>
                                <p class="mb-2 text-[12px] font-semibold text-[#34445e]">{{ $job['company'] }}</p>
                                <div class="mb-2 flex flex-wrap gap-3 text-[11px] font-semibold text-[#34445e]">
                                    <span>{{ $job['location'] }}</span>
                                    <span>{{ $job['type'] }}</span>
                                    <span>{{ $job['exp'] }}</span>
                                </div>
                                <p class="text-[10px] font-semibold text-[#6f7d90]">{{ $job['posted'] }}</p>
                            </div>
                            <div class="text-left sm:text-center">
                                <p class="mb-2 text-[10px] font-semibold text-[#6f7d90]">Initial Track Match</p>
                                <span class="inline-flex rounded-full px-4 py-1 text-[10px] font-bold {{ $job['fitClass'] }}">{{ $job['fit'] }}</span>
                            </div>
                            <div class="flex items-center gap-3 sm:block sm:text-right">
                                <a href="/direct-mode/login" class="inline-flex h-9 min-w-[88px] items-center justify-center rounded-md bg-[#075fe4] px-4 text-[11px] font-bold text-white">Apply Now</a>
                                <p class="mt-2 text-[10px] font-semibold text-[#075fe4]">1 Credit</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    <a href="/direct-mode/jobs" class="inline-flex h-9 items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-6 text-[11px] font-bold text-[#075fe4]">Load More Jobs</a>
                </div>
            </div>

            <aside class="grid content-start gap-4">
                <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5">
                    <h2 class="mb-4 text-[14px] text-[#061942]">Your Initial Track Analysis</h2>
                    <div class="mb-4 flex justify-center">
                        <svg viewBox="0 0 180 150" class="h-[155px] w-full max-w-[230px]" aria-hidden="true">
                            <polygon points="90,18 146,58 124,126 56,126 34,58" fill="#edf5ff" stroke="#d6e4fb" stroke-width="1"></polygon>
                            <polygon points="90,30 134,62 116,116 64,116 46,62" fill="rgba(7,95,228,.12)" stroke="#075fe4" stroke-width="2"></polygon>
                            <text x="90" y="12" text-anchor="middle" font-size="10" font-weight="700" fill="#061942">Technical</text>
                            <text x="90" y="24" text-anchor="middle" font-size="9" fill="#061942">Skills</text>
                            <text x="154" y="62" font-size="10" font-weight="700" fill="#061942">Aptitude</text>
                            <text x="112" y="143" font-size="10" font-weight="700" fill="#061942">Communication</text>
                            <text x="8" y="138" font-size="10" font-weight="700" fill="#061942">Learning Ability</text>
                            <text x="0" y="62" font-size="10" font-weight="700" fill="#061942">Attitude</text>
                        </svg>
                    </div>
                    <div class="mb-3 flex items-center justify-between text-[12px] font-bold">
                        <span class="text-[#061942]">Overall Match</span>
                        <span class="text-[#075fe4]">★★★★☆</span>
                        <span class="text-[#0b8b67]">Good Fit</span>
                    </div>
                    <p class="mb-4 text-[11px] font-semibold leading-5 text-[#34445e]">Improve your score with Fast Track Program</p>
                    <a href="/fast-track" class="inline-flex h-9 w-full items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#075fe4]">Explore Fast Track Program</a>
                </section>

                <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5">
                    <h2 class="mb-4 text-[14px] text-[#061942]">Application Tips</h2>
                    <ul class="mb-4 grid gap-2 text-[11px] font-semibold text-[#061942]">
                        @foreach (['Fill your profile completely', 'Upload an updated resume', 'Check your Initial Track Analysis', 'Apply to jobs that match your skills'] as $tip)
                            <li class="flex gap-2"><span class="font-bold text-[#0b8b67]">✓</span><span>{{ $tip }}</span></li>
                        @endforeach
                    </ul>
                    <a href="/direct-mode" class="text-[11px] font-bold text-[#075fe4]">View All Tips</a>
                </section>
            </aside>
        </div>
    </section>

    <section class="bg-white px-5 pb-14 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-6 text-center">
                <h2 class="mb-2 text-[22px] text-[#061942]">Apply More Jobs with Additional Credits</h2>
                <p class="text-[12px] font-semibold text-[#34445e]">You get 500 FREE credits to apply for jobs under Direct Mode. Need more? Choose a plan that suits you.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ([
                    ['name' => 'Starter', 'credits' => '500', 'price' => '₹0', 'period' => 'FREE', 'button' => 'Current Plan', 'popular' => false, 'items' => ['Apply to 500 jobs', 'Valid for 30 days', 'For Direct Mode only']],
                    ['name' => 'Basic', 'credits' => '1,000', 'price' => '₹249', 'period' => 'Valid for 60 days', 'button' => 'Buy Now', 'popular' => false, 'items' => ['Apply to 1,000 jobs', 'Valid for 60 days', 'For Direct Mode only']],
                    ['name' => 'Pro', 'credits' => '2,500', 'price' => '₹499', 'period' => 'Valid for 90 days', 'button' => 'Buy Now', 'popular' => true, 'items' => ['Apply to 2,500 jobs', 'Valid for 90 days', 'For Direct Mode only', 'Priority Support']],
                    ['name' => 'Premium', 'credits' => '5,000', 'price' => '₹899', 'period' => 'Valid for 120 days', 'button' => 'Buy Now', 'popular' => false, 'items' => ['Apply to 5,000 jobs', 'Valid for 120 days', 'For Direct Mode only', 'Priority Support']],
                    ['name' => 'Ultimate', 'credits' => '10,000', 'price' => '₹1,499', 'period' => 'Valid for 180 days', 'button' => 'Buy Now', 'popular' => false, 'items' => ['Apply to 10,000 jobs', 'Valid for 180 days', 'For Direct Mode only', 'Priority Support']],
                ] as $plan)
                    <article class="relative rounded-lg border bg-white px-5 pb-5 pt-5 text-center shadow-[0_6px_18px_rgba(6,25,66,.04)] {{ $plan['popular'] ? 'border-[#075fe4] ring-1 ring-[#075fe4]' : 'border-[#dce7f8]' }}">
                        @if ($plan['popular'])
                            <span class="absolute left-1/2 top-0 inline-flex h-6 min-w-[96px] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#075fe4] px-4 text-[10px] font-bold text-white">Popular</span>
                        @endif
                        <h3 class="mb-3 text-[14px] text-[#061942]">{{ $plan['name'] }}</h3>
                        <p class="text-[31px] font-black leading-none text-[#075fe4]">{{ $plan['credits'] }}</p>
                        <p class="mb-4 text-[10px] font-bold text-[#075fe4]">Credits</p>
                        <p class="text-[27px] font-black leading-none text-[#061942]">{{ $plan['price'] }}</p>
                        <p class="mb-4 text-[10px] font-semibold text-[#34445e]">{{ $plan['period'] }}</p>
                        <a href="/direct-mode/register" class="mb-5 inline-flex h-9 w-full items-center justify-center rounded-md border border-[#075fe4] px-4 text-[11px] font-bold transition {{ $plan['button'] === 'Current Plan' ? 'bg-white text-[#075fe4]' : 'bg-[#075fe4] text-white hover:bg-[#0554cc]' }}">{{ $plan['button'] }}</a>
                        <ul class="grid gap-2 text-left text-[10px] font-semibold leading-4 text-[#061942]">
                            @foreach ($plan['items'] as $item)
                                <li class="flex gap-2"><span class="font-bold text-[#0b8b67]">✓</span><span>{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-[11px] font-semibold text-[#34445e]">
                <span>Secure Payments</span>
                <span>|</span>
                <span>Instant Credit</span>
                <span>|</span>
                <span>No Auto Renewal</span>
                <span>|</span>
                <span>Use Anytime</span>
            </div>
        </div>
    </section>
    </main>
@endsection
