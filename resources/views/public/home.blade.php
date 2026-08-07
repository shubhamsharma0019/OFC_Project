@extends('layouts.public')

@section('title', 'OnlyFreshers')

@php
    $activePage = 'home';

    $directPoints = ['Create profile', 'Browse jobs and apply', 'Upload resume', 'Company reviews profile', 'Give initial assessment'];
    $fastTrackPoints = ['Give initial assessment', 'Give final assessment', 'Get recommended career track', 'Earn certificate', 'Enroll in a course', 'Apply for Fast Track jobs'];
    $partners = [
        ['name' => 'NEXORA', 'type' => 'TECHNOLOGIES'],
        ['name' => 'CodeVista', 'type' => 'ACADEMY'],
        ['name' => 'Skillance', 'type' => 'LEARNING'],
        ['name' => 'Logixperts', 'type' => 'INSTITUTE'],
        ['name' => 'DataVance', 'type' => 'ACADEMY'],
        ['name' => 'CloudKnot', 'type' => 'TECHNOLOGIES'],
    ];
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
            </div>

            <div class="flex min-h-[260px] items-center justify-center lg:min-h-[320px]">
                @if (file_exists(public_path('student.svg')))
                    <img src="{{ asset('student.svg') }}" alt="Students" class="block h-auto max-h-[320px] w-full max-w-[560px] object-contain">
                @else
                    <div class="flex h-[260px] w-full max-w-[560px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-5xl font-bold text-[#075fe4] shadow-[0_18px_40px_rgba(6,25,66,0.06)] lg:h-[320px]">
                        OF
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white py-[45px]">
        <div class="mx-auto grid w-full max-w-7xl gap-6 px-5 sm:px-6 lg:grid-cols-2 lg:px-8">
            <article class="flex flex-col items-center gap-6 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-start">
                <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#f1f6ff] text-4xl font-bold text-[#075fe4]">
                    @if (file_exists(public_path('direct.svg')))
                        <img src="{{ asset('direct.svg') }}" alt="Direct Mode" class="h-full w-full rounded-full object-contain">
                    @else
                        DM
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="mb-[15px] text-center text-xl font-semibold text-[#061942] sm:text-left">Direct Mode</h2>
                    <ul class="grid gap-3 text-sm font-medium text-[#293850] sm:grid-cols-2">
                        @foreach ($directPoints as $point)
                            <li class="flex gap-2 before:font-extrabold before:text-[#075fe4] before:content-['?']">{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            </article>

            <article class="flex flex-col items-center gap-6 rounded-lg border border-[#f5d4ba] bg-[#fffaf5] p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-start">
                <div class="flex h-[105px] w-[105px] shrink-0 items-center justify-center rounded-full bg-[#fff0e2] text-[#f37a22] [&>svg]:h-12 [&>svg]:w-12">@include('components.public.icon', ['name' => 'rocket'])</div>
                <div class="min-w-0 flex-1">
                    <h2 class="mb-[15px] text-center text-xl font-semibold text-[#061942] sm:text-left">Fast Track Mode</h2>
                    <ul class="grid gap-3 text-sm font-medium text-[#293850] sm:grid-cols-2">
                        @foreach ($fastTrackPoints as $point)
                            <li class="flex gap-2 before:font-extrabold before:text-[#f37a22] before:content-['?']">{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            </article>
        </div>
    </section>

    <section class="bg-white py-[45px] text-center">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <h2 class="mb-[22px] text-[22px] font-semibold text-[#061942]">Trusted Training Partners</h2>

            <div class="mb-5 grid gap-[22px] sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                @foreach ($partners as $partner)
                    <div class="rounded-lg border border-[#dce7f8] bg-white px-3 py-4 text-sm font-semibold text-[#061942] shadow-[0_10px_22px_rgba(6,25,66,0.04)]">
                        {{ $partner['name'] }}
                        <small class="mt-1 block text-[9px] font-medium uppercase tracking-[1px] text-[#4d5c75]">{{ $partner['type'] }}</small>
                    </div>
                @endforeach
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