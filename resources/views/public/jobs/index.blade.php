@extends('layouts.public')

@section('title', 'For Companies - OnlyFreshers')

@php
    $activePage = 'companies';

    $benefits = [
        ['icon' => 'users', 'title' => 'Verified Fresher Profiles', 'text' => 'Access candidates with profile details, skills and assessment insights.'],
        ['icon' => 'chart', 'title' => 'Initial & Final Assessment', 'text' => 'Compare candidate readiness with structured assessment reports.'],
        ['icon' => 'training', 'title' => 'Fast Track Talent', 'text' => 'Hire trained and certified freshers from trusted training partners.'],
        ['icon' => 'briefcase', 'title' => 'Simple Job Management', 'text' => 'Post openings, review applications and shortlist candidates faster.'],
    ];

    $steps = [
        ['title' => 'Register Company', 'text' => 'Create your company account and submit basic verification details.'],
        ['title' => 'Post Requirements', 'text' => 'Publish direct or Fast Track jobs with skills, location and openings.'],
        ['title' => 'Review Candidates', 'text' => 'See applications, assessments, certificates and profile match details.'],
        ['title' => 'Shortlist & Hire', 'text' => 'Move candidates through interviews and hiring decisions from one place.'],
    ];

    $plans = [
        ['name' => 'Direct Hiring', 'price' => 'Free', 'text' => 'Post jobs and receive fresher applications directly.', 'items' => ['Company profile', 'Direct job posting', 'Application tracking']],
        ['name' => 'Fast Track Hiring', 'price' => 'Verified', 'text' => 'Hire trained candidates with assessment and certification data.', 'items' => ['Certified candidates', 'Final assessment report', 'Training completion proof']],
        ['name' => 'Campus Partner', 'price' => 'Custom', 'text' => 'Build recurring fresher hiring pipelines with OnlyFreshers.', 'items' => ['Bulk hiring support', 'Dedicated coordination', 'Priority candidate access']],
    ];
@endphp

@push('styles')
<style>
    .companies-page,
    .companies-page * {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .companies-page h1,
    .companies-page h2,
    .companies-page h3 {
        font-weight: 700;
    }
</style>
@endpush

@section('content')
    <main class="companies-page bg-white">
        <section class="bg-white px-4 py-5 sm:px-6 lg:px-8">
            <div class="mx-auto grid w-full max-w-7xl gap-5 rounded-lg border border-[#dbe8fb] bg-[#edf5ff] p-4 shadow-[0_8px_24px_rgba(7,95,228,0.08)] lg:grid-cols-[minmax(0,1fr)_740px] lg:items-center">
                <div class="px-2 py-2">
                    <h1 class="mb-2 text-[20px] leading-tight text-[#061942]">Welcome back, TechNova Solutions! 👋</h1>
                    <p class="mb-5 text-[13px] font-semibold text-[#34445e]">Find and hire the best fresher talent for your team.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="/company/post-job" class="inline-flex h-10 min-w-[122px] items-center justify-center rounded-md bg-[#075fe4] px-5 text-[12px] font-bold text-white shadow-[0_8px_15px_rgba(7,95,228,0.16)] transition hover:bg-[#0554cc]">Post a Job</a>
                        <a href="/company/applications" class="inline-flex h-10 min-w-[145px] items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-5 text-[12px] font-bold text-[#075fe4] transition hover:bg-[#f3f8ff]">View Candidates</a>
                    </div>
                </div>

                <div class="grid gap-3 rounded-lg bg-white p-3 shadow-[0_2px_12px_rgba(6,25,66,0.04)] sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['label' => 'Free Job Posting', 'value' => '3 / 3', 'sub' => 'Used', 'note' => 'Resets on 01 Jun 2024', 'icon' => 'document', 'color' => '#075fe4'],
                        ['label' => 'Direct Mode', 'value' => '5 / 5', 'sub' => 'Free Resumes', 'note' => 'Per Job Posting', 'icon' => 'users', 'color' => '#2563eb'],
                        ['label' => 'Fast Track Mode', 'value' => '2 / 2', 'sub' => 'Free Resumes', 'note' => 'Per Job Posting', 'icon' => 'users', 'color' => '#18a66f'],
                        ['label' => 'Total Active Jobs', 'value' => '2', 'sub' => '', 'note' => 'View All Jobs ->', 'icon' => 'briefcase', 'color' => '#8239d7'],
                    ] as $stat)
                        <article class="grid min-h-[112px] grid-cols-[minmax(0,1fr)_46px] gap-3 rounded-md bg-white px-3 py-3">
                            <div>
                                <p class="mb-2 text-[10px] font-bold text-[#061942]">{{ $stat['label'] }}</p>
                                <p class="text-[26px] font-bold leading-none text-[#061942]">{{ $stat['value'] }}</p>
                                @if ($stat['sub'])
                                    <p class="mt-1 text-[10px] font-semibold text-[#34445e]">{{ $stat['sub'] }}</p>
                                @endif
                                <p class="mt-3 text-[9px] font-semibold {{ str_contains($stat['note'], 'View') ? 'text-[#075fe4]' : 'text-[#6f7d90]' }}">{{ $stat['note'] }}</p>
                            </div>
                            <span class="grid h-10 w-10 place-items-center rounded-full bg-[#edf5ff] [&>svg]:h-5 [&>svg]:w-5" style="color: {{ $stat['color'] }}">
                                @include('components.public.icon', ['name' => $stat['icon']])
                            </span>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="px-5 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-7xl">
                <div class="mb-6 text-center">
                    <h2 class="mb-2 text-[22px] text-[#061942]">How Hiring Works on OnlyFreshers</h2>
                    <span class="mx-auto block h-1 w-8 rounded-full bg-[#075fe4]"></span>
                </div>

                <div class="mb-8 grid gap-5 lg:grid-cols-2">
                    <article class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,.04)] sm:grid-cols-[74px_minmax(0,1fr)]">
                        <span class="grid h-16 w-16 place-items-center rounded-full border-2 border-[#075fe4] bg-[#edf5ff] text-[#075fe4] [&>svg]:h-9 [&>svg]:w-9">@include('components.public.icon', ['name' => 'briefcase'])</span>
                        <div>
                            <h3 class="mb-3 text-[14px] uppercase text-[#075fe4]">Direct Mode</h3>
                            <ul class="mb-3 grid gap-2 text-[12px] font-semibold text-[#34445e]">
                                <li class="flex gap-2"><span class="text-[#075fe4]">✓</span><span>Post a job and get resumes of suitable freshers.</span></li>
                                <li class="flex gap-2"><span class="text-[#075fe4]">✓</span><span>Get Initial Track Analysis with each resume.</span></li>
                                <li class="flex gap-2"><span class="text-[#075fe4]">✓</span><span>Shortlist and connect with the best candidates.</span></li>
                            </ul>
                            <p class="text-[12px] font-bold text-[#075fe4]">5 Free Resumes per Job Posting</p>
                        </div>
                    </article>

                    <article class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,.04)] sm:grid-cols-[74px_minmax(0,1fr)]">
                        <span class="grid h-16 w-16 place-items-center rounded-full bg-[#dff6ef] text-[#0b9b6b] [&>svg]:h-9 [&>svg]:w-9">@include('components.public.icon', ['name' => 'users'])</span>
                        <div>
                            <h3 class="mb-3 text-[14px] uppercase text-[#0b9b6b]">Fast Track Mode</h3>
                            <ul class="mb-3 grid gap-2 text-[12px] font-semibold text-[#34445e]">
                                <li class="flex gap-2"><span class="text-[#0b9b6b]">✓</span><span>Get candidates trained by verified training partners.</span></li>
                                <li class="flex gap-2"><span class="text-[#0b9b6b]">✓</span><span>Receive Initial & Final Assessment of each candidate.</span></li>
                                <li class="flex gap-2"><span class="text-[#0b9b6b]">✓</span><span>Hire job-ready freshers with enhanced skills.</span></li>
                            </ul>
                            <p class="text-[12px] font-bold text-[#0b9b6b]">2 Free Resumes per Job Posting</p>
                        </div>
                    </article>
                </div>

                <h2 class="mb-4 text-center text-[20px] text-[#061942]">Your Hiring Summary</h2>
                <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                    @foreach ([
                        ['label' => 'Total Jobs Posted', 'value' => '2', 'sub' => 'Active Jobs', 'icon' => 'briefcase', 'color' => '#075fe4'],
                        ['label' => 'Total Applicants', 'value' => '56', 'sub' => 'Across all jobs', 'icon' => 'users', 'color' => '#2563eb'],
                        ['label' => 'Shortlisted Candidates', 'value' => '12', 'sub' => 'Across all jobs', 'icon' => 'check', 'color' => '#0b9b6b'],
                        ['label' => 'Interviews Scheduled', 'value' => '5', 'sub' => 'Upcoming interviews', 'icon' => 'document', 'color' => '#8239d7'],
                        ['label' => 'Hires Made', 'value' => '3', 'sub' => 'Congrats!', 'icon' => 'users', 'color' => '#8239d7'],
                    ] as $summary)
                        <article class="grid grid-cols-[minmax(0,1fr)_42px] items-center rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_5px_15px_rgba(6,25,66,.035)]">
                            <div>
                                <p class="mb-2 text-[10px] font-bold text-[#34445e]">{{ $summary['label'] }}</p>
                                <p class="text-[26px] font-bold leading-none text-[#061942]">{{ $summary['value'] }}</p>
                                <p class="mt-2 text-[10px] font-semibold text-[#6f7d90]">{{ $summary['sub'] }}</p>
                            </div>
                            <span class="grid h-10 w-10 place-items-center rounded-full bg-[#edf5ff] [&>svg]:h-5 [&>svg]:w-5" style="color: {{ $summary['color'] }}">@include('components.public.icon', ['name' => $summary['icon']])</span>
                        </article>
                    @endforeach
                </div>

                <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_6px_18px_rgba(6,25,66,.04)]">
                    <div class="flex items-center justify-between border-b border-[#edf2f8] px-5 py-4">
                        <h2 class="text-[16px] text-[#061942]">Recent Job Postings</h2>
                        <a href="/company/jobs" class="text-[12px] font-bold text-[#075fe4]">View All Jobs -></a>
                    </div>
                    @foreach ([
                        ['icon' => 'code', 'title' => 'Software Developer (Fresher)', 'meta' => 'Engineering · Full-time · Bangalore, India', 'date' => 'Posted on 10 May 2024', 'applications' => '28', 'shortlisted' => '8', 'direct' => '5 / 5 Used', 'fast' => '2 / 2 Used'],
                        ['icon' => 'chart', 'title' => 'Data Analyst (Fresher)', 'meta' => 'Analytics · Full-time · Pune, India', 'date' => 'Posted on 07 May 2024', 'applications' => '18', 'shortlisted' => '4', 'direct' => '5 / 5 Used', 'fast' => '2 / 2 Used'],
                    ] as $job)
                        <article class="grid gap-4 border-b border-[#edf2f8] px-5 py-4 last:border-b-0 lg:grid-cols-[minmax(0,1fr)_90px_90px_160px_130px] lg:items-center">
                            <div class="flex min-w-0 gap-4">
                                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-lg bg-[#8239d7] text-white [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $job['icon']])</span>
                                <div class="min-w-0">
                                    <h3 class="mb-1 truncate text-[13px] text-[#061942]">{{ $job['title'] }}</h3>
                                    <p class="mb-1 text-[11px] font-semibold text-[#34445e]">{{ $job['meta'] }}</p>
                                    <p class="text-[10px] font-semibold text-[#6f7d90]">{{ $job['date'] }}</p>
                                </div>
                            </div>
                            <div><p class="text-[10px] font-semibold text-[#6f7d90]">Applications</p><strong class="text-[18px] text-[#061942]">{{ $job['applications'] }}</strong></div>
                            <div><p class="text-[10px] font-semibold text-[#6f7d90]">Shortlisted</p><strong class="text-[18px] text-[#061942]">{{ $job['shortlisted'] }}</strong></div>
                            <div>
                                <p class="mb-1 text-center text-[10px] font-bold text-[#061942]">Free Resumes</p>
                                <div class="grid grid-cols-2 gap-2 text-center text-[10px] font-semibold text-[#34445e]">
                                    <span>Direct Mode<br><strong class="text-[#061942]">{{ $job['direct'] }}</strong></span>
                                    <span>Fast Track Mode<br><strong class="text-[#061942]">{{ $job['fast'] }}</strong></span>
                                </div>
                            </div>
                            <a href="/company/applications" class="inline-flex h-8 items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[10px] font-bold text-[#075fe4]">View Applicants</a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-5 flex flex-col gap-4 rounded-lg border border-dashed border-[#8eb4ef] bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#edf5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5">@include('components.public.icon', ['name' => 'users'])</span>
                        <span><strong class="block text-[13px] text-[#075fe4]">You've used all your free job postings!</strong><span class="text-[11px] font-semibold text-[#34445e]">Post more jobs and connect with more talented freshers.</span></span>
                    </div>
                    <a href="/company/register" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-[12px] font-bold text-white">View Hiring Packages</a>
                </div>
            </div>
        </section>

        <section class="bg-white px-5 py-8 sm:px-6 lg:px-8 lg:pb-14">
            <div class="mx-auto w-full max-w-7xl rounded-lg bg-[#f8fbff] px-5 py-6 shadow-[0_8px_24px_rgba(6,25,66,.04)]">
                <div class="mb-7 text-center">
                    <h2 class="mb-1 text-[20px] text-[#061942]">Choose a Hiring Package</h2>
                    <p class="text-[12px] font-semibold text-[#34445e]">Post more jobs and access more resumes to hire the best talent.</p>
                </div>

                <div class="grid gap-5 lg:grid-cols-4">
                    @php
                        $packages = [
                            ['name' => 'Starter', 'desc' => 'Perfect for getting started', 'price' => '₹1,999', 'period' => '/month', 'button' => 'Choose Starter', 'popular' => false, 'items' => ['10 Job Postings', '50 Direct Mode Resumes (5 per job extra)', '20 Fast Track Mode Resumes (2 per job extra)', 'Candidate Contact Access', 'Email Support']],
                            ['name' => 'Growth', 'desc' => 'Scale your hiring', 'price' => '₹4,999', 'period' => '/month', 'button' => 'Choose Growth', 'popular' => true, 'items' => ['25 Job Postings', '150 Direct Mode Resumes (6 per job extra)', '60 Fast Track Mode Resumes (2.5 per job extra)', 'Candidate Contact Access', 'Priority Support']],
                            ['name' => 'Professional', 'desc' => 'For active hiring teams', 'price' => '₹9,999', 'period' => '/month', 'button' => 'Choose Professional', 'popular' => false, 'items' => ['60 Job Postings', '400 Direct Mode Resumes (7 per job extra)', '160 Fast Track Mode Resumes (2.5 per job extra)', 'Candidate Contact Access', 'Priority Support', 'Dedicated Account Manager']],
                            ['name' => 'Enterprise', 'desc' => 'For large scale hiring', 'price' => 'Custom', 'period' => 'Contact Sales', 'button' => 'Contact Sales', 'popular' => false, 'items' => ['Unlimited Job Postings', 'Custom Resume Access', 'Dedicated Account Manager', 'Bulk Hiring Solutions', 'API Access', 'Custom Integrations']],
                        ];
                    @endphp

                    @foreach ($packages as $package)
                        <article class="relative rounded-lg border bg-white px-6 pb-6 pt-5 text-center shadow-[0_6px_18px_rgba(6,25,66,.04)] {{ $package['popular'] ? 'border-[#075fe4] ring-1 ring-[#075fe4]' : 'border-[#dce7f8]' }}">
                            @if ($package['popular'])
                                <span class="absolute left-1/2 top-0 inline-flex h-6 min-w-[118px] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#075fe4] px-4 text-[10px] font-bold text-white">Most Popular</span>
                            @endif
                            <h3 class="mb-1 text-[15px] text-[#061942]">{{ $package['name'] }}</h3>
                            <p class="mb-4 text-[10px] font-semibold text-[#34445e]">{{ $package['desc'] }}</p>
                            <p class="text-[31px] font-black leading-none text-[#061942]">{{ $package['price'] }}</p>
                            <p class="mb-5 text-[10px] font-semibold text-[#34445e]">{{ $package['period'] }}</p>

                            <ul class="mb-6 grid gap-2 text-left text-[11px] font-semibold leading-4 text-[#061942]">
                                @foreach ($package['items'] as $item)
                                    <li class="flex gap-2"><span class="font-bold text-[#0b9b6b]">✓</span><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>

                            <a href="{{ $package['name'] === 'Enterprise' ? '/company/register' : '/company/register' }}" class="inline-flex h-10 w-full items-center justify-center rounded-md border border-[#075fe4] px-4 text-[12px] font-bold transition {{ $package['popular'] ? 'bg-[#075fe4] text-white hover:bg-[#0554cc]' : 'bg-white text-[#075fe4] hover:bg-[#f3f8ff]' }}">{{ $package['button'] }}</a>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8 rounded-lg border border-[#dce7f8] bg-white px-5 py-5 shadow-[0_6px_18px_rgba(6,25,66,.035)]">
                    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_230px_1px_230px_170px] lg:items-center">
                        <div>
                            <h3 class="mb-2 text-[15px] text-[#061942]">Additional Resume Packs</h3>
                            <p class="text-[11px] font-semibold text-[#34445e]">Need more resumes without upgrading your plan?</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-[#edf5ff] text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => 'document'])</span>
                            <span>
                                <strong class="block text-[13px] text-[#061942]">Direct Mode Resumes</strong>
                                <span class="text-[22px] font-black text-[#061942]">₹300</span>
                                <span class="text-[12px] font-semibold text-[#34445e]"> / 5 Resumes</span>
                            </span>
                        </div>
                        <span class="hidden h-12 w-px bg-[#cfdceb] lg:block"></span>
                        <div class="flex items-center gap-4">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-[#e4f8ef] text-[#0b9b6b] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => 'users'])</span>
                            <span>
                                <strong class="block text-[13px] text-[#061942]">Fast Track Mode Resumes</strong>
                                <span class="text-[22px] font-black text-[#061942]">₹400</span>
                                <span class="text-[12px] font-semibold text-[#34445e]"> / 5 Resumes</span>
                            </span>
                        </div>
                        <a href="/company/register" class="inline-flex h-11 items-center justify-center rounded-md border border-[#075fe4] bg-white px-6 text-[12px] font-bold text-[#075fe4] transition hover:bg-[#f3f8ff]">Buy Now</a>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 rounded-lg bg-[#f8fbff] px-5 py-5 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'shield', 'title' => '100% Verified Freshers', 'text' => 'All candidates are verified'],
                        ['icon' => 'document', 'title' => 'Initial & Final Assessment', 'text' => 'Make data-driven hiring decisions'],
                        ['icon' => 'users', 'title' => 'Trained & Job-Ready Talent', 'text' => 'Hire with confidence'],
                        ['icon' => 'target', 'title' => 'Save Time & Cost', 'text' => 'Streamlined hiring process'],
                    ] as $item)
                        <article class="flex items-center gap-4 xl:border-r xl:border-[#e7eef8] xl:pr-5 xl:last:border-r-0">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-[#edf5ff] text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $item['icon']])</span>
                            <span>
                                <strong class="block text-[13px] text-[#061942]">{{ $item['title'] }}</strong>
                                <span class="block text-[11px] font-semibold text-[#34445e]">{{ $item['text'] }}</span>
                            </span>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
