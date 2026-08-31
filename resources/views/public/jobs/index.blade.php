@extends('layouts.public')

@section('title', 'For Companies - OnlyFreshers')

@php
    $activePage = 'companies';
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
        <section class="bg-[#f3f8ff] px-4 py-5 sm:px-6 lg:px-8">
            <div class="mx-auto grid w-full max-w-7xl overflow-hidden rounded-lg bg-[#edf5ff] shadow-[0_10px_28px_rgba(7,95,228,0.10)] lg:h-[330px] lg:grid-cols-[minmax(0,0.95fr)_minmax(420px,1.05fr)] lg:items-stretch">
                <div class="flex min-h-[250px] flex-col items-start justify-center px-6 py-9 sm:px-9 lg:h-full lg:min-h-0 lg:px-12">
                    <h1 class="mb-3 text-[30px] leading-tight text-[#061942] sm:text-[38px] lg:text-[44px]">Hire Fresh Talent, Faster</h1>
                    <p class="mb-6 max-w-md text-[14px] font-semibold leading-6 text-[#34445e] sm:text-[15px]">Post jobs and connect with verified, job-ready freshers for your growing team.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="/company/post-job" class="inline-flex h-11 min-w-[132px] items-center justify-center rounded-md bg-[#075fe4] px-6 text-[13px] font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.20)] transition hover:bg-[#0554cc]">Post a Job</a>
                        <a href="/company/applications" class="inline-flex h-11 min-w-[148px] items-center justify-center rounded-md border border-[#8eb4ef] bg-white px-6 text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f3f8ff]">View Candidates</a>
                    </div>
                </div>

                <div class="relative flex min-h-[250px] items-center justify-center px-6 py-7 sm:min-h-[280px] lg:h-full lg:min-h-0">
                    <img src="{{ asset('company-hero.png') }}" alt="Company fresher hiring illustration" class="h-full max-h-[280px] w-full object-contain lg:max-h-[300px]">
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
                    @foreach ($hiringModes as $mode)
                        <article class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,.04)] sm:grid-cols-[74px_minmax(0,1fr)]">
                            <span class="grid h-16 w-16 place-items-center rounded-full {{ $mode['iconClasses'] }} [&>svg]:h-9 [&>svg]:w-9">@include('components.public.icon', ['name' => $mode['icon']])</span>
                            <div>
                                <h3 class="mb-3 text-[14px] uppercase" style="color: {{ $mode['color'] }}">{{ $mode['title'] }}</h3>
                                <ul class="mb-3 grid gap-2 text-[12px] font-semibold text-[#34445e]">
                                    @foreach ($mode['points'] as $point)
                                        <li class="flex gap-2"><span style="color: {{ $mode['color'] }}">&#10003;</span><span>{{ $point }}</span></li>
                                    @endforeach
                                </ul>
                                <p class="text-[12px] font-bold" style="color: {{ $mode['color'] }}">{{ $mode['note'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_6px_18px_rgba(6,25,66,.04)]">
                    <div class="flex items-center justify-between border-b border-[#edf2f8] px-5 py-4">
                        <h2 class="text-[16px] text-[#061942]">Recent Job Postings</h2>
                        <a href="/company/jobs" class="text-[12px] font-bold text-[#075fe4]">View All Jobs -></a>
                    </div>
                    @foreach ($recentJobs as $job)
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

            </div>
        </section>

        <section class="bg-white px-5 py-8 sm:px-6 lg:px-8 lg:pb-14">
            <div class="mx-auto w-full max-w-7xl rounded-lg bg-[#f8fbff] px-5 py-6 shadow-[0_8px_24px_rgba(6,25,66,.04)]">
                <div class="mb-7 text-center">
                    <h2 class="mb-1 text-[20px] text-[#061942]">Choose a Hiring Package</h2>
                    <p class="text-[12px] font-semibold text-[#34445e]">Post jobs, or choose Custom when you only need resume access after credits are over.</p>
                </div>

                <div class="grid gap-5 lg:grid-cols-4">
                    @foreach ($hiringPackages as $package)
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
                            <h3 class="mb-2 text-[15px] text-[#061942]">Custom Resume Access Plans</h3>
                            <p class="text-[11px] font-semibold text-[#34445e]">Need only resumes without job posting?</p>
                        </div>
                        @foreach ($resumePacks as $pack)
                            <div class="flex items-center gap-4">
                                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full {{ $pack['classes'] }} [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $pack['icon']])</span>
                                <span>
                                    <strong class="block text-[13px] text-[#061942]">{{ $pack['title'] }}</strong>
                                    <span class="text-[22px] font-black text-[#061942]">{{ $pack['price'] }}</span>
                                    <span class="text-[12px] font-semibold text-[#34445e]"> {{ $pack['unit'] }}</span>
                                </span>
                            </div>
                            @if (! $loop->last)
                                <span class="hidden h-12 w-px bg-[#cfdceb] lg:block"></span>
                            @endif
                        @endforeach                        <a href="/company/register" class="inline-flex h-11 items-center justify-center rounded-md border border-[#075fe4] bg-white px-6 text-[12px] font-bold text-[#075fe4] transition hover:bg-[#f3f8ff]">Buy Now</a>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 rounded-lg bg-[#f8fbff] px-5 py-5 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($companyTrustItems as $item)
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
