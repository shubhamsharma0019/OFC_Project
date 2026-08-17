@extends('layouts.public')

@section('title', 'About Us - OnlyFreshers')

@php
    $activePage = 'about';

    $infoCards = [
        ['icon' => 'target', 'title' => 'Our Mission', 'text' => 'To empower freshers by connecting them with the right opportunities, career-focused training, and industry partners.'],
        ['icon' => 'spark', 'title' => 'Our Vision', 'text' => 'To be the most trusted platform for freshers, enabling them to build successful and meaningful careers.'],
        ['icon' => 'briefcase', 'title' => 'What We Do', 'text' => 'We bridge the gap between talent and opportunity through jobs, training programs, and trusted partnerships.'],
    ];

    $trustCards = [
        ['icon' => 'check', 'title' => 'Verified Opportunities', 'text' => 'All job listings are verified to ensure legitimacy and trust.'],
        ['icon' => 'learn', 'title' => 'Industry-Aligned Training', 'text' => 'Learn the most in-demand skills from trusted training partners.'],
        ['icon' => 'growth', 'title' => 'Career Growth', 'text' => 'We help you build a strong foundation for a successful career.'],
    ];
@endphp

@section('content')
    <style>
        @media (max-width: 900px) {
            .about-hero-grid {
                grid-template-columns: 1fr !important;
                text-align: center;
            }
            .about-hero-grid > div:first-child {
                text-align: center !important;
            }
            .about-hero-grid > div:last-child {
                justify-content: center !important;
            }
            .about-hero-grid p {
                white-space: normal !important;
            }
        }
    </style>
    <section class="relative overflow-hidden py-8 lg:py-10" style="background:linear-gradient(110deg,#ffffff 0%,#f5faff 48%,#e3f0ff 100%);">
        <div class="pointer-events-none absolute -left-24 -top-24 h-56 w-56 rounded-full" style="border:1px solid rgba(7,95,228,.08);background:rgba(7,95,228,.03);"></div>
        <div class="pointer-events-none absolute bottom-0 right-0 h-full w-[48%] rounded-l-full" style="background:rgba(7,95,228,.08);"></div>
        <div class="pointer-events-none absolute right-[15%] top-8 h-32 w-32 rounded-full" style="border:1px solid rgba(7,95,228,.08);"></div>
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-16" style="background:linear-gradient(180deg,rgba(255,255,255,0),#ffffff);"></div>
        <div class="about-hero-grid relative z-10 mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8" style="display:grid;grid-template-columns:minmax(320px,.9fr) minmax(420px,1fr);align-items:center;gap:42px;">
            <div class="relative z-10 text-left">
                <h1 class="m-0 text-[32px] font-bold leading-tight sm:text-4xl lg:text-[42px]" style="color:#061942;">
                    About <span style="color:#075fe4;">OnlyFreshers</span>
                </h1>
                <p class="mt-4 text-sm font-medium leading-6 lg:text-[15px]" style="color:#24344f;max-width:430px;">
                    OnlyFreshers connects freshers, companies, and training partners in one place.
                </p>
            </div>

            <div class="relative z-10 flex min-h-[190px] w-full items-end justify-end overflow-hidden">
                <img src="{{ asset('build/assets/student.png') }}?v=2" alt="OnlyFreshers students" class="relative z-10 block h-[215px] w-full max-w-[560px] object-contain object-bottom">
            </div>
        </div>
    </section>

    <section class="bg-white pb-12" style="padding-top:56px;">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid gap-[22px] lg:grid-cols-3">
                @foreach ($infoCards as $card)
                    <article class="flex flex-col gap-[18px] rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-center sm:gap-[22px]">
                        <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[#075fe4] [&>svg]:h-8 [&>svg]:w-8">
                            @include('components.public.icon', ['name' => $card['icon']])
                        </div>
                        <div>
                            <h2 class="mb-[9px] text-lg font-semibold text-[#061942]">{{ $card['title'] }}</h2>
                            <p class="text-sm font-medium leading-[1.7] text-[#24344f]">{{ $card['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-[42px] text-center">
                <h2 class="text-2xl font-semibold text-[#061942]">How OnlyFreshers Helps</h2>
                <div class="mx-auto mt-2.5 h-[3px] w-[70px] rounded-full bg-[#075fe4]"></div>
            </div>

            <div class="mt-6 grid gap-[22px] lg:grid-cols-2">
                <article class="flex flex-col gap-6 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-center sm:gap-7">
                    <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[#075fe4] [&>svg]:h-8 [&>svg]:w-8">@include('components.public.icon', ['name' => 'briefcase'])</div>
                    <div>
                        <h3 class="mb-[9px] text-lg font-semibold text-[#061942]">Direct Mode</h3>
                        <ul class="list-disc space-y-1.5 pl-[18px] text-sm font-medium leading-[1.9] text-[#24344f] marker:text-[#075fe4]">
                            <li>Browse and apply to verified job openings.</li>
                            <li>Create your profile and showcase your skills.</li>
                            <li>Connect directly with top companies hiring freshers.</li>
                        </ul>
                    </div>
                </article>

                <article class="flex flex-col gap-6 rounded-lg border border-[#f5d4ba] bg-[#fffaf5] p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-center sm:gap-7">
                    <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full bg-[#fff0e2] text-[#f37a22] [&>svg]:h-8 [&>svg]:w-8">@include('components.public.icon', ['name' => 'rocket'])</div>
                    <div>
                        <h3 class="mb-[9px] text-lg font-semibold text-[#061942]">Fast Track Program</h3>
                        <ul class="list-disc space-y-1.5 pl-[18px] text-sm font-medium leading-[1.9] text-[#24344f] marker:text-[#075fe4]">
                            <li>Get industry-aligned training from trusted partners.</li>
                            <li>Improve your skills with practical learning.</li>
                            <li>Get recommended for jobs and career opportunities.</li>
                        </ul>
                    </div>
                </article>
            </div>

            <div class="mt-[42px] text-center">
                <h2 class="text-2xl font-semibold text-[#061942]">Why Freshers Trust OnlyFreshers</h2>
                <div class="mx-auto mt-2.5 h-[3px] w-[70px] rounded-full bg-[#075fe4]"></div>
            </div>

            <div class="mt-6 grid gap-[22px] lg:grid-cols-3">
                @foreach ($trustCards as $card)
                    <article class="flex flex-col gap-[18px] rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-center">
                        <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[#075fe4] [&>svg]:h-8 [&>svg]:w-8">
                            @include('components.public.icon', ['name' => $card['icon']])
                        </div>
                        <div>
                            <h3 class="mb-[9px] text-lg font-semibold text-[#061942]">{{ $card['title'] }}</h3>
                            <p class="text-sm font-medium leading-[1.7] text-[#24344f]">{{ $card['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
