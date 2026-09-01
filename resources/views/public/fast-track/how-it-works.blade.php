@extends('layouts.public')

@section('title', 'How Fast Track Works - OnlyFreshers')

@php
    $activePage = 'fast-track';
    $steps = [
        ['title' => 'Enroll', 'text' => 'Choose a career track and create your fresher profile.', 'icon' => 'document'],
        ['title' => 'Initial Assessment', 'text' => 'Complete the first test so companies can see your current skills.', 'icon' => 'target'],
        ['title' => 'Training', 'text' => 'Learn with verified training partners and improve job-ready skills.', 'icon' => 'training'],
        ['title' => 'Final Assessment', 'text' => 'Take the final assessment after training completion.', 'icon' => 'chart'],
        ['title' => 'Certificate', 'text' => 'Get your training certificate and improved profile report.', 'icon' => 'certificate'],
        ['title' => 'Get Hired', 'text' => 'Companies view your resume, scores and final report for hiring.', 'icon' => 'briefcase'],
    ];
@endphp

@section('content')
    <main class="bg-white">
        <section class="bg-[#f3f8ff] px-5 py-10 sm:px-6 lg:px-8">
            <div class="mx-auto grid w-full max-w-7xl items-center gap-8 lg:grid-cols-[minmax(0,0.95fr)_minmax(360px,1.05fr)]">
                <div>
                    <p class="mb-3 text-[13px] font-black uppercase tracking-[.05em] text-[#075fe4]">Fast Track Program</p>
                    <h1 class="mb-4 max-w-2xl font-['Inter'] text-[34px] font-bold leading-tight text-[#061942] sm:text-[44px]">How Fast Track Works</h1>
                    <p class="max-w-xl text-[15px] font-semibold leading-7 text-[#34445e]">Fast Track helps freshers build skills, prove improvement through assessments, and show companies a stronger hiring profile.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="/fast-track/login?next=/fast-track/courses" class="inline-flex h-11 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.20)]">Explore Tracks</a>
                        <a href="/direct-mode/flow-selection" class="inline-flex h-11 items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-6 text-sm font-bold text-[#075fe4]">Start Assessment</a>
                    </div>
                </div>
                <div class="flex justify-center">
                    <img src="{{ asset('fast-track-program-hero.png') }}" alt="Fast Track Program" class="h-auto max-h-[320px] w-full max-w-[560px] object-contain">
                </div>
            </div>
        </section>

        <section class="px-5 py-10 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-7xl">
                <div class="mb-7 text-center">
                    <h2 class="font-['Inter'] text-[26px] font-bold text-[#061942]">Complete Journey</h2>
                    <p class="mt-2 text-sm font-semibold text-[#34445e]">From enrollment to company-ready profile in six clear steps.</p>
                </div>
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($steps as $index => $step)
                        <article class="min-h-[150px] rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_8px_20px_rgba(6,25,66,0.05)]">
                            <div class="mb-4 flex items-center gap-3">
                                <span class="grid h-11 w-11 place-items-center rounded-full bg-[#eaf2ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5">
                                    @include('components.public.icon', ['name' => $step['icon']])
                                </span>
                                <span class="text-xs font-bold text-[#075fe4]">Step {{ $index + 1 }}</span>
                            </div>
                            <h3 class="mb-2 font-['Inter'] text-lg font-bold text-[#061942]">{{ $step['title'] }}</h3>
                            <p class="text-sm font-semibold leading-6 text-[#34445e]">{{ $step['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
