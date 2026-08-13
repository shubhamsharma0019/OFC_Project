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

@section('content')
    <section class="bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-10 lg:py-[55px]">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-2 lg:gap-[50px] lg:px-8">
            <div class="text-center lg:text-left">
                <h1 class="m-0 text-[40px] font-semibold leading-[1.08] text-[#061942] sm:text-5xl lg:text-[54px]">
                    Direct <span class="text-[#075fe4]">Mode</span>
                </h1>
                <p class="mt-[18px] max-w-2xl text-lg font-medium leading-[1.7] text-[#34445e] lg:text-[19px]">
                    Direct Mode lets job-ready freshers apply to verified jobs after completing profile and initial assessment.
                </p>
                <a href="/direct-mode/register" class="mt-7 inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">
                    Get Started
                </a>
            </div>

            <div class="flex min-h-[240px] items-center justify-center lg:min-h-[260px]">
                @if (file_exists(public_path('direct.svg')))
                    <img src="{{ asset('direct.svg') }}" alt="Direct Mode" class="block h-[240px] w-full max-w-[520px] object-contain sm:h-[260px]">
                @else
                    <div class="flex h-[240px] w-full max-w-[520px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-5xl font-bold text-[#075fe4] shadow-[0_18px_40px_rgba(6,25,66,0.06)]">
                        DM
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white py-9 lg:py-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:grid-cols-2 lg:grid-cols-4 lg:p-7">
                @foreach ($steps as $index => $step)
                    <article class="text-center">
                        <div class="mx-auto mb-3.5 flex h-[58px] w-[58px] items-center justify-center rounded-full border border-[#dce7f8] bg-[#eff5ff] text-lg font-black text-[#075fe4]">
                            {{ $index + 1 }}
                        </div>
                        <h3 class="mb-2 text-sm font-semibold text-[#061942]">{{ $step['title'] }}</h3>
                        <p class="text-[13px] font-medium leading-[1.6] text-[#34445e]">{{ $step['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
