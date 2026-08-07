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
    <section class="bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-12 lg:py-[60px]">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-[0.92fr_1fr] lg:gap-[55px] lg:px-8">
            <div class="text-center lg:text-left">
                <h1 class="m-0 text-[40px] font-semibold leading-[1.1] text-[#061942] sm:text-5xl lg:text-[52px]">
                    About <span class="text-[#075fe4]">OnlyFreshers</span>
                </h1>
                <p class="mt-[18px] max-w-2xl text-lg font-medium leading-[1.7] text-[#24344f] lg:text-[21px]">
                    OnlyFreshers connects freshers, companies, and training partners in one place.
                </p>
            </div>

            <div class="min-w-0">
                @if (file_exists(public_path('student.svg')))
                    <img src="{{ asset('student.svg') }}" alt="OnlyFreshers students" class="mx-auto block h-[260px] w-full object-contain sm:h-[310px]">
                @else
                    <div class="mx-auto flex h-[260px] w-full max-w-[520px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-5xl font-bold text-[#075fe4] shadow-[0_18px_40px_rgba(6,25,66,0.06)] sm:h-[310px]">
                        OF
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white pb-12 pt-8 lg:-mt-7 lg:pb-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid gap-[22px] lg:grid-cols-3">
                @foreach ($infoCards as $card)
                    <article class="flex flex-col gap-[18px] rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-center sm:gap-[22px]">
                        <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[22px] font-extrabold text-[#075fe4]">
                            {{ $card['icon'] }}
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
                        <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[22px] font-extrabold text-[#075fe4]">
                            {{ $card['icon'] }}
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