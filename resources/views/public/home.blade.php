@extends('layouts.public')

@section('title', 'OnlyFreshers')

@push('styles')
<style>
    @media (max-width: 640px) {
        html:has(.home-hero),
        body:has(.home-hero) {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        body:has(.home-hero) #public-site,
        body:has(.home-hero) main {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        body:has(.home-hero) main > section,
        body:has(.home-hero) main > section > div {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        body:has(.home-hero) header,
        body:has(.home-hero) footer {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        body:has(.home-hero) header > div,
        body:has(.home-hero) footer > div {
            width: 100% !important;
            max-width: 100% !important;
        }

        body:has(.home-hero) img,
        body:has(.home-hero) svg {
            max-width: 100% !important;
        }

        .home-hero {
            padding: 0 !important;
            background: linear-gradient(180deg, #fff 0%, #f3f8ff 100%) !important;
            overflow: hidden !important;
        }

        .home-hero-inner {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 16px !important;
            padding: 22px 14px 0 !important;
            text-align: center !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .home-hero-inner > * {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }

        .home-hero-title-desktop {
            display: none !important;
        }

        .home-hero-title-mobile {
            display: block !important;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 310px !important;
            font-size: clamp(24px, 7.2vw, 30px) !important;
            line-height: 1.12 !important;
            letter-spacing: 0 !important;
            text-align: center !important;
            white-space: normal !important;
            word-break: normal !important;
            overflow-wrap: anywhere !important;
        }

        .home-hero-title-mobile span {
            display: inline !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
        }

        .home-hero p {
            margin: 14px auto 16px !important;
            max-width: 320px !important;
            font-size: 12px !important;
            line-height: 1.5 !important;
            overflow-wrap: anywhere !important;
        }

        .home-hero-actions {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 10px !important;
            width: 100% !important;
            max-width: 340px !important;
            margin: 0 auto !important;
        }

        .home-hero-actions a {
            width: 100% !important;
            min-width: 0 !important;
            height: 44px !important;
        }

        .home-hero-media {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 285px !important;
            margin: 0 auto !important;
            padding: 0 0 24px !important;
            align-items: flex-end !important;
            overflow: hidden !important;
        }

        .home-hero-media > img {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            max-height: 300px !important;
            object-fit: contain !important;
            object-position: bottom center !important;
        }

        #homeStats {
            bottom: 12px !important;
            left: 50% !important;
            width: calc(100% - 24px) !important;
            max-width: 360px !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 8px !important;
            padding: 9px !important;
        }

        #homeStats article {
            gap: 7px !important;
            min-width: 0 !important;
        }

        #homeStats article > span:first-child {
            width: 30px !important;
            height: 30px !important;
        }

        #homeStats strong {
            font-size: 12px !important;
        }

        #homeStats small {
            font-size: 8px !important;
        }

        .home-mode-card {
            padding: 14px !important;
        }

        .home-mode-card ul {
            text-align: left !important;
        }

        .home-mode-card .home-mode-panel {
            width: 100% !important;
        }

        .home-steps-scroll {
            overflow: visible !important;
        }

        .home-steps-row {
            display: grid !important;
            min-width: 0 !important;
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 14px !important;
        }

        .home-steps-row > span {
            display: none !important;
        }

        .home-step-card {
            width: 100% !important;
            grid-template-columns: 54px minmax(0, 1fr) !important;
        }

        .home-company-grid article {
            min-height: 0 !important;
            padding: 16px !important;
        }

        .home-company-grid {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) !important;
        }

        .home-company-grid article,
        .home-company-grid article > span,
        .home-mode-card,
        .home-mode-panel {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }

        .home-mode-card {
            grid-template-columns: minmax(0, 1fr) !important;
            text-align: center !important;
            overflow: hidden !important;
        }

        .home-mode-panel [class*="grid-cols-"] {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        .home-mode-panel b,
        .home-mode-panel span {
            overflow-wrap: anywhere !important;
        }

        .home-company-grid article {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        .home-company-grid article:last-child {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .home-company-grid article:nth-child(3) > div,
        .home-company-grid article:nth-child(3) [class*="grid-cols-"] {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }

        .home-company-grid article:nth-child(3) [class*="grid-cols-"] {
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 6px !important;
        }

        .home-company-grid article:nth-child(3) [class*="grid-cols-"] > span,
        .home-company-grid article:nth-child(3) [class*="grid-cols-"] > b {
            text-align: left !important;
        }

        .home-company-grid article:nth-child(3) [class*="grid-cols-"] > span:empty {
            display: none !important;
        }

        .home-company-grid article:nth-child(3) [class*="grid-cols-"] > b {
            word-break: break-word !important;
        }

        .home-company-grid article:nth-child(3) .flex.justify-between {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 6px !important;
            text-align: center !important;
        }
    }

    @media (max-width: 380px) {
        .home-hero-title-mobile {
            max-width: 250px !important;
            font-size: 24px !important;
        }

        #homeStats {
            width: calc(100% - 18px) !important;
        }

        #homeStats article {
            gap: 6px !important;
        }
    }
    </style>
@endpush

@php
    $activePage = 'home';
    $homeStats = array_merge([
        'jobs_listed' => 0,
        'freshers_hired' => 0,
        'partner_companies' => 0,
        'top_brands' => 'Trusted',
    ], $homeStats ?? []);
    $statCards = [
        ['icon' => 'briefcase', 'label' => 'Jobs Listed', 'value' => $homeStats['jobs_listed'] . '+'],
        ['icon' => 'users', 'label' => 'Fresher Hired', 'value' => $homeStats['freshers_hired'] . '+'],
        ['icon' => 'training', 'label' => 'Partner Companies', 'value' => $homeStats['partner_companies'] . '+'],
        ['icon' => 'shield', 'label' => 'Top Brands', 'value' => $homeStats['top_brands']],
    ];
@endphp

@section('content')
    <section class="home-hero relative overflow-hidden bg-[linear-gradient(90deg,#ffffff_0%,#ffffff_42%,#f3f8ff_64%,#e9f3ff_100%)] pb-10 pt-5">
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-[linear-gradient(180deg,rgba(233,243,255,0)_0%,rgba(247,251,255,0.72)_42%,#f7fbff_100%)]"></div>
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-[linear-gradient(90deg,#f7fbff_0%,rgba(247,251,255,0.92)_34%,rgba(233,243,255,0.82)_68%,#e9f3ff_100%)]"></div>
        <div class="pointer-events-none absolute -left-24 top-1/2 hidden h-[260px] w-[360px] -translate-y-1/2 rounded-full bg-[#dcecff]/55 blur-3xl lg:block"></div>
        <div class="pointer-events-none absolute left-0 top-0 hidden h-full w-[46%] bg-[radial-gradient(circle_at_12%_18%,rgba(207,228,255,0.38)_0%,rgba(244,249,255,0.36)_30%,rgba(255,255,255,0)_68%)] lg:block"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-[58%] bg-[radial-gradient(circle_at_88%_8%,#cfe4ff_0%,#dcecff_28%,rgba(233,243,255,0.72)_48%,rgba(255,255,255,0)_78%)] lg:block"></div>
        <div class="pointer-events-none absolute inset-y-0 left-[38%] hidden w-[28%] bg-[linear-gradient(90deg,rgba(255,255,255,0),rgba(207,228,255,0.24),rgba(233,243,255,0))] blur-xl lg:block"></div>
        <div class="home-hero-inner relative mx-auto grid w-full max-w-7xl items-center gap-5 px-5 py-5 text-center sm:px-6 lg:min-h-[285px] lg:grid-cols-[0.9fr_1.18fr] lg:gap-3 lg:px-8 lg:py-0 lg:text-left">
            <div class="relative z-10">
                <h1 class="home-hero-title-desktop m-0 font-['Inter'] text-[31px] font-medium leading-[1.04] text-[#061942] sm:text-[42px] lg:text-[44px] xl:text-[49px]">
                    {{ $hero['title'] }} <span class="text-[#075fe4]">{{ $hero['highlight'] }}</span>
                </h1>
                <h1 class="home-hero-title-mobile m-0 hidden font-['Inter'] font-medium text-[#061942]">
                    Bridging Fresh<br>Talent With<br><span class="text-[#075fe4]">Great Opportunities</span>
                </h1>
                <p class="mx-auto my-4 max-w-[520px] text-[13px] font-semibold leading-[1.45] text-[#34445e] sm:text-sm lg:mx-0">
                    {{ $hero['text'] }}
                </p>

                <div class="home-hero-actions flex flex-col justify-center gap-3 sm:flex-row lg:justify-start">
                    <a href="{{ $hero['primary']['href'] }}" class="inline-flex h-10 min-w-[155px] items-center justify-center gap-2 rounded-md border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#003f9e]">
                        <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => $hero['primary']['icon']])</span>
                        {{ $hero['primary']['label'] }}
                    </a>
                    <a href="{{ $hero['secondary']['href'] }}" class="inline-flex h-10 min-w-[155px] items-center justify-center gap-2 rounded-md border border-[#8eb4ef] bg-white px-6 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]">
                        <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => $hero['secondary']['icon']])</span>
                        {{ $hero['secondary']['label'] }}
                    </a>
                </div>
            </div>

            <div class="home-hero-media relative z-10 flex min-h-[245px] items-end justify-center overflow-visible lg:min-h-[285px] lg:justify-end">
                <img src="{{ asset($hero['image']) }}" alt="{{ $hero['highlight'] }}" class="block h-auto max-h-[292px] w-full max-w-[700px] object-contain object-bottom lg:mr-[-28px] lg:max-h-[305px] xl:mr-[-46px]">
                <div id="homeStats" class="absolute bottom-4 left-1/2 grid w-[min(95%,590px)] -translate-x-1/2 grid-cols-2 gap-2 rounded-lg border border-[#dce7f8] bg-white/90 p-2.5 text-left shadow-[0_12px_26px_rgba(6,25,66,0.16)] backdrop-blur sm:grid-cols-4 lg:left-[56%]">
                    @foreach ($statCards as $statCard)
                        <article class="flex items-center gap-2">
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-[#eaf2ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4">
                                @include('components.public.icon', ['name' => $statCard['icon']])
                            </span>
                            <span>
                                <strong class="block text-[13px] font-extrabold leading-tight text-[#061942]">{{ $statCard['value'] }}</strong>
                                <small class="block text-[9px] font-semibold leading-tight text-[#34445e]">{{ $statCard['label'] }}</small>
                            </span>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[linear-gradient(180deg,#f7fbff_0%,#f7fbff_52px,#ffffff_170px)] py-[45px]">
        <div class="mx-auto w-full max-w-[1680px] px-4 sm:px-6 lg:px-8">
            <div class="mb-6 text-center">
                <h2 class="font-['Inter'] text-[26px] font-medium leading-tight text-[#061942]">Two Powerful Modes to Get Hired</h2>
                <p class="mt-2 text-sm font-semibold text-[#4a5871]">Choose the path that suits you best and start your career journey today.</p>
            </div>

            <div class="grid gap-5 lg:grid-cols-2">
                <a href="/direct-mode" class="home-mode-card group relative grid overflow-hidden rounded-xl border border-[#dce7f8] bg-[linear-gradient(135deg,#ffffff,#f7fbff)] p-4 shadow-[0_16px_36px_rgba(6,25,66,0.08)] transition hover:-translate-y-0.5 hover:shadow-[0_22px_46px_rgba(6,25,66,0.12)] focus:outline-none focus:ring-2 focus:ring-[#075fe4] focus:ring-offset-2 md:min-h-[218px] md:grid-cols-[132px_minmax(0,1fr)_260px] md:items-center md:gap-4">
                    <div class="flex justify-center md:justify-start">
                        <div class="flex h-[104px] w-[104px] items-center justify-center rounded-full bg-[#eaf2ff] text-[#075fe4] ring-6 ring-[#f4f8ff] [&>svg]:h-14 [&>svg]:w-14">@include('components.public.icon', ['name' => 'briefcase'])</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="mb-2 flex items-center justify-center gap-3 md:justify-start"><span class="grid h-8 w-8 place-items-center rounded-full bg-[#075fe4] text-sm font-black text-white">1</span><h3 class="font-['Inter'] text-lg font-medium uppercase tracking-wide text-[#075fe4]">Direct Mode</h3></div>
                        <p class="mb-3 max-w-[310px] text-sm font-semibold leading-5 text-[#293850] max-md:mx-auto">Apply directly to top companies for fresher job openings.</p>
                        <ul class="grid gap-2 text-sm font-semibold text-[#293850]">
                            @foreach ($directModePoints as $point)
                                <li class="flex items-start gap-2"><span class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full border border-[#9bbdf1] text-[#075fe4]">✓</span>{{ $point }}</li>
                            @endforeach
                        </ul>
                        <span class="mt-3 inline-flex h-9 min-w-[170px] items-center justify-center rounded-md border border-[#8eb4ef] bg-white text-sm font-bold text-[#075fe4] shadow-[0_8px_18px_rgba(7,95,228,0.08)]">Explore Jobs</span>
                    </div>
                    <div class="home-mode-panel mt-4 min-w-0 rounded-lg border border-[#e0e9f7] bg-white/80 p-3 text-left md:mt-0">
                        <h4 class="mb-2 font-['Inter'] text-sm font-medium text-[#075fe4]">Initial Track Analysis</h4>
                        <div class="grid gap-2 text-[11px] font-semibold text-[#293850]">
                            @foreach ($directAnalysis as $row)
                                <div class="grid grid-cols-[90px_minmax(0,1fr)_32px] items-center gap-2"><span>{{ $row['label'] }}</span><span class="h-1.5 rounded-full bg-[#dce7f8]"><span class="block h-full rounded-full bg-[#075fe4]" style="width: {{ $row['value'] }}%"></span></span><b>{{ $row['value'] }}%</b></div>
                            @endforeach
                            <div class="mt-1 flex items-center justify-between"><span>Overall Match</span><span class="font-black text-[#075fe4]">★★★★★ <small class="text-[#05843e]">(Good Fit)</small></span></div>
                        </div>
                        <p class="mt-3 text-xs font-semibold leading-5 text-[#536484]">This analysis helps companies quickly identify the right talent.</p>
                    </div>
                </a>

                <a href="/fast-track" class="home-mode-card group relative grid overflow-hidden rounded-xl border border-[#f5d4ba] bg-[linear-gradient(135deg,#ffffff,#fff8f0)] p-4 shadow-[0_16px_36px_rgba(80,40,0,0.08)] transition hover:-translate-y-0.5 hover:shadow-[0_22px_46px_rgba(80,40,0,0.12)] focus:outline-none focus:ring-2 focus:ring-[#f37a22] focus:ring-offset-2 md:min-h-[218px] md:grid-cols-[132px_minmax(0,1fr)_260px] md:items-center md:gap-4">
                    <div class="flex justify-center md:justify-start">
                        <div class="flex h-[104px] w-[104px] items-center justify-center rounded-full bg-[#fff0e2] text-[#f37a22] ring-6 ring-[#fff8f0] [&>svg]:h-14 [&>svg]:w-14">@include('components.public.icon', ['name' => 'rocket'])</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="mb-1.5 flex items-center justify-center gap-3 md:justify-start"><span class="grid h-8 w-8 place-items-center rounded-full bg-[#f37a22] text-sm font-black text-white">2</span><h3 class="font-['Inter'] text-lg font-medium uppercase tracking-wide text-[#f37a22]">Fast Track Mode</h3></div>
                        <p class="mb-2 max-w-[330px] text-[13px] font-semibold leading-5 text-[#293850] max-md:mx-auto">Get assessed, trained & certified by our partner training entities. Companies get candidates with initial & final assessment.</p>
                        <ul class="grid gap-1.5 text-[13px] font-semibold leading-5 text-[#293850]">
                            @foreach ($fastTrackPoints as $point)
                                <li class="flex items-start gap-2"><span class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full border border-[#f2b17e] text-[#f37a22]">✓</span>{{ $point }}</li>
                            @endforeach
                        </ul>
                        <span class="mt-2.5 inline-flex h-9 min-w-[220px] items-center justify-center rounded-md border border-[#f2b17e] bg-white text-sm font-bold text-[#f37a22] shadow-[0_8px_18px_rgba(243,122,34,0.08)]">Explore Fast Track Program</span>
                    </div>
                    <div class="home-mode-panel mt-4 min-w-0 rounded-lg border border-[#f7dcc6] bg-white/80 p-3 text-left md:mt-0">
                        <h4 class="mb-2 font-['Inter'] text-sm font-medium text-[#f37a22]">Assessment Overview</h4>
                        <div class="mb-2 grid grid-cols-[1fr_48px_16px_48px] gap-2 text-[10px] font-black text-[#536484]"><span></span><span>Initial</span><span></span><span>Final</span></div>
                        <div class="grid gap-2 text-[11px] font-semibold text-[#293850]">
                            @foreach ($fastTrackOverview as $row)
                                <div class="grid grid-cols-[1fr_48px_16px_48px] items-center gap-2"><span>{{ $row['label'] }}</span><b>{{ $row['initial'] }}</b><span>→</span><b class="text-[#075fe4]">{{ $row['final'] }}</b></div>
                            @endforeach
                        </div>
                        <p class="mt-3 text-xs font-semibold leading-5 text-[#536484]">Companies get job-ready candidates with improved skills, attitude & confidence.</p>
                    </div>
                </a>
            </div>

            <div class="mt-12 bg-white px-0 pb-2 pt-0">
                <h2 class="mb-6 text-center font-['Inter'] text-[20px] font-semibold leading-tight text-[#061942]">How Fast Track Mode Works</h2>
                <div class="home-steps-scroll overflow-x-auto px-0 py-2">
                    <div class="home-steps-row flex min-w-[1500px] items-start justify-center gap-0 xl:min-w-0">
                        @foreach ($fastTrackSteps as $index => $step)
                            <article class="home-step-card grid w-[216px] shrink-0 grid-cols-[64px_minmax(0,1fr)] items-start gap-3 text-left xl:w-auto xl:flex-1">
                                <span class="flex h-[60px] w-[60px] items-center justify-center rounded-full bg-[#eef5ff] text-[#075fe4] ring-4 ring-[#f8fbff] [&>svg]:h-8 [&>svg]:w-8">
                                    @include('components.public.icon', ['name' => $step['icon']])
                                </span>
                                <span class="min-w-0 pt-1">
                                    <strong class="block font-['Inter'] text-[15px] font-semibold leading-tight text-[#061942]">{{ $step['title'] }}</strong>
                                    <small class="mt-2 block max-w-[150px] text-[13px] font-semibold leading-[1.55] text-[#34445e]">{{ $step['text'] }}</small>
                                </span>
                            </article>

                            @if (! $loop->last)
                                <span class="flex w-[38px] shrink-0 justify-center pt-6 text-center text-[#075fe4]">
                                    <span class="relative block h-3 w-8">
                                        <i class="absolute left-0 top-1/2 h-px w-6 -translate-y-1/2 border-t-2 border-dotted border-[#7aa8ef]"></i>
                                        <b class="absolute right-0 top-1/2 h-2 w-2 -translate-y-1/2 rotate-45 border-r-2 border-t-2 border-[#075fe4]"></b>
                                    </span>
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="home-company-grid mt-12 grid overflow-hidden rounded-xl border border-[#d8eee8] bg-[#f8fffc] shadow-[0_12px_30px_rgba(16,90,72,0.06)] lg:grid-cols-[1.2fr_1.25fr_1.25fr_1.05fr_1.35fr]">
                <article class="grid min-h-[168px] grid-cols-[70px_minmax(0,1fr)] gap-5 border-b border-[#d8eee8] p-6 lg:border-b-0 lg:border-r">
                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-[#dff6ef] text-[#0b8b67] [&>svg]:h-9 [&>svg]:w-9">@include('components.public.icon', ['name' => 'company'])</span>
                    <span>
                        <h3 class="font-['Inter'] text-[17px] font-semibold text-[#061942]">For Companies</h3>
                        <p class="mt-3 max-w-[285px] text-[13px] font-semibold leading-6 text-[#1f2f45]">Hire job-ready freshers through Direct Mode or select skilled candidates from our Fast Track Program.</p>
                    </span>
                </article>

                <article class="min-h-[168px] border-b border-[#d8eee8] p-6 lg:border-b-0 lg:border-r">
                    <h3 class="font-['Inter'] text-[17px] font-semibold text-[#0b8b67]">What You Get in Fast Track Mode</h3>
                    <ul class="mt-3 grid gap-2 text-[13px] font-semibold leading-5 text-[#1f2f45]">
                        @foreach ($companyBenefits as $benefit)
                            <li class="flex gap-2"><span class="mt-1 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-[#17a673] text-[10px] text-white">✓</span>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </article>

                <article class="border-b border-[#d8eee8] bg-white px-4 py-3 lg:border-b-0 lg:border-r">
                    <div class="rounded-xl border border-[#e3f0ec] bg-[linear-gradient(180deg,#ffffff,#fbfffe)] p-3 shadow-[0_10px_24px_rgba(6,25,66,0.06)]">
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('fast-track-hero-girl.png') }}" alt="Fast Track candidate" class="h-[52px] w-[52px] rounded-lg object-cover object-top shadow-sm">
                        <span class="min-w-0">
                            <strong class="block font-['Inter'] text-[13px] font-semibold leading-tight text-[#061942]">{{ $candidateReport['name'] }}</strong>
                            <small class="mt-1 block text-[11px] font-semibold leading-tight text-[#34445e]">{{ $candidateReport['course'] }}</small>
                        </span>
                    </div>
                    <div class="grid grid-cols-[1fr_56px_18px_56px] items-center gap-x-2 rounded-lg bg-[#f7fbff] px-2 py-2 text-[9px] font-semibold leading-tight text-[#34445e]">
                        <span></span><b class="text-center text-[#061942]">Initial<br>Score</b><span></span><b class="text-center text-[#061942]">Final<br>Score</b>
                        @foreach ($candidateReport['rows'] as $row)
                            <span class="border-t border-[#e3edf9] py-1.5">{{ $row[0] }}</span><b class="border-t border-[#e3edf9] py-1.5 text-center">{{ $row[1] }}</b><span class="border-t border-[#e3edf9] py-1.5 text-center text-[#6b7890]">→</span><b class="border-t border-[#e3edf9] py-1.5 text-center text-[#061942]">{{ $row[2] }}</b>
                        @endforeach
                        <span>Overall Match</span><b class="text-center text-[#075fe4]">★★★★★<small class="block text-[8px] text-[#6b7890]">(Average Fit)</small></b><span class="text-center text-[#6b7890]">-&gt;</span><b class="text-center text-[#075fe4]">★★★★★<small class="block text-[8px] text-[#0b8b67]">(Strong Fit)</small></b>
                    </div>
                    <div class="mt-2 flex justify-between border-t border-[#edf4f2] pt-1.5 text-[9.5px] font-semibold text-[#075fe4]">
                        <span>View Full Report</span>
                        <span>Download Resume</span>
                    </div>
                    </div>
                </article>

                <article class="grid grid-cols-[58px_minmax(0,1fr)] gap-4 border-b border-[#d8eee8] p-5 lg:border-b-0 lg:border-r">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-[#dbf4ed] text-[#0b8b67] [&>svg]:h-8 [&>svg]:w-8">@include('components.public.icon', ['name' => 'training'])</span>
                    <span>
                        <h3 class="font-['Inter'] text-base font-semibold text-[#061942]">Our Training Partners</h3>
                        <p class="mt-2 text-xs font-semibold leading-5 text-[#34445e]">Industry-aligned training by trusted & verified partners.</p>
                        <a href="/training-partners" class="mt-3 inline-flex h-8 items-center justify-center rounded-md border border-[#9ed7c7] bg-white px-4 text-xs font-semibold text-[#0b8b67]">View All Partners</a>
                    </span>
                </article>

                <article class="grid grid-cols-2 gap-2 p-4 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
                    @foreach ($trainingPartnerLogos as $partnerLogo)
                        <span class="flex min-h-[48px] items-center justify-center rounded-md border border-[#d8eee8] bg-white px-2 text-center font-['Inter'] text-sm font-semibold text-[#35516f]">{{ $partnerLogo }}</span>
                    @endforeach
                </article>
            </div>

            <div class="hidden">
            <a href="/direct-mode" class="group relative flex flex-col items-center gap-6 overflow-hidden rounded-lg border border-[#dce7f8] bg-[linear-gradient(135deg,#ffffff,#f7fbff)] p-6 shadow-[0_16px_36px_rgba(6,25,66,0.08)] transition hover:-translate-y-0.5 hover:border-[#bfd4f5] hover:shadow-[0_22px_46px_rgba(6,25,66,0.12)] focus:outline-none focus:ring-2 focus:ring-[#075fe4] focus:ring-offset-2 sm:flex-row sm:items-start">
                <span class="pointer-events-none absolute inset-x-4 top-0 h-px bg-white/90"></span>
                <span class="pointer-events-none absolute -right-16 -top-20 h-44 w-44 rounded-full bg-[#eaf2ff]/70 blur-2xl transition group-hover:bg-[#dbeafe]"></span>
                <span class="pointer-events-none absolute inset-0 bg-[linear-gradient(115deg,rgba(255,255,255,0)_0%,rgba(255,255,255,.7)_45%,rgba(255,255,255,0)_62%)] opacity-0 transition group-hover:translate-x-6 group-hover:opacity-70"></span>
                <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#f1f6ff] text-4xl font-bold text-[#075fe4]">
                    @if (file_exists(public_path('direct.svg')))
                        <img src="{{ asset('direct.svg') }}" alt="Direct Mode" class="h-full w-full rounded-full object-contain">
                    @else
                        DM
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="mb-[15px] text-center font-['Inter'] text-xl font-medium text-[#061942] sm:text-left">Direct Mode</h2>
                    <ul id="directPoints" class="grid gap-3 text-sm font-medium text-[#293850] sm:grid-cols-2">
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Create profile</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Browse jobs and apply</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Upload resume</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['•']">Company reviews profile</li>
                    </ul>
                </div>
            </a>

            <a href="/fast-track" class="group relative flex flex-col items-center gap-6 overflow-hidden rounded-lg border border-[#f5d4ba] bg-[linear-gradient(135deg,#ffffff,#fff8f0)] p-6 shadow-[0_16px_36px_rgba(80,40,0,0.08)] transition hover:-translate-y-0.5 hover:border-[#f2b17e] hover:shadow-[0_22px_46px_rgba(80,40,0,0.12)] focus:outline-none focus:ring-2 focus:ring-[#f37a22] focus:ring-offset-2 sm:flex-row sm:items-start">
                <span class="pointer-events-none absolute inset-x-4 top-0 h-px bg-white/90"></span>
                <span class="pointer-events-none absolute -right-16 -top-20 h-44 w-44 rounded-full bg-[#fff0e2]/80 blur-2xl transition group-hover:bg-[#ffe2c4]"></span>
                <span class="pointer-events-none absolute inset-0 bg-[linear-gradient(115deg,rgba(255,255,255,0)_0%,rgba(255,255,255,.7)_45%,rgba(255,255,255,0)_62%)] opacity-0 transition group-hover:translate-x-6 group-hover:opacity-70"></span>
                <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center rounded-full bg-[#fff0e2] text-[#f37a22] [&>svg]:h-12 [&>svg]:w-12">@include('components.public.icon', ['name' => 'rocket'])</div>
                <div class="min-w-0 flex-1">
                    <h2 class="mb-[15px] text-center font-['Inter'] text-xl font-medium text-[#061942] sm:text-left">Fast Track Mode</h2>
                    <ul id="fastTrackPoints" class="grid gap-3 text-sm font-medium text-[#293850] sm:grid-cols-2">
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Give initial assessment</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Enroll in a course</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Give final assessment</li>
                        <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['•']">Earn certificate</li>
                    </ul>
                </div>
            </a>
            </div>
        </div>
    </section>

    <section class="bg-white pb-5 pt-5">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-6 rounded-lg border border-[#dce7f8] bg-white p-6 text-center shadow-[inset_0_1px_0_rgba(255,255,255,0.9),inset_0_0_38px_rgba(7,95,228,0.16),inset_0_-18px_34px_rgba(234,242,255,0.58),0_18px_42px_rgba(6,25,66,0.08)] lg:flex-row lg:px-[55px] lg:text-left">
                <div class="flex flex-col items-center gap-6 lg:flex-row">
                    <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center rounded-full bg-[#f1f6ff] text-[#075fe4] shadow-[inset_0_0_0_1px_rgba(7,95,228,0.06),0_12px_24px_rgba(7,95,228,0.08)] [&>svg]:h-12 [&>svg]:w-12">@include('components.public.icon', ['name' => 'company'])</div>
                    <div>
                        <h2 class="mb-1 font-['Inter'] text-xl font-medium text-[#061942]">{{ $companyCta['title'] }}</h2>
                        <p class="text-sm font-medium leading-[1.5] text-[#4a5871] sm:text-base">{{ $companyCta['text'] }}</p>
                    </div>
                </div>

                <a href="{{ $companyCta['href'] }}" class="inline-flex h-11 shrink-0 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#003f9e]">{{ $companyCta['button'] }}</a>
            </div>
        </div>
    </section>
@endsection
