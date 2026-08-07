@extends('layouts.fast-track')

@section('title', 'Final Assessment')

@php
    $activePage = 'final';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $summary = [
        'title' => 'Ready for Final Assessment?',
        'text' => 'You have completed the required training. Attempt the final assessment and get certified.',
        'stats' => [
            ['label' => 'Lessons Completed', 'value' => '28/74', 'icon' => 'LC'],
            ['label' => 'Courses Enrolled', 'value' => '4', 'icon' => 'CE'],
            ['label' => 'Total Study Time', 'value' => '12h 45m', 'icon' => 'ST'],
        ],
    ];

    $overview = [
        ['label' => 'Total Questions', 'value' => '60', 'icon' => 'TQ'],
        ['label' => 'Passing Marks', 'value' => '60%', 'icon' => 'PM'],
        ['label' => 'Time Duration', 'value' => '90 Minutes', 'icon' => 'TD'],
        ['label' => 'Total Attempts Allowed', 'value' => '3', 'icon' => 'TA'],
        ['label' => 'Current Attempts Used', 'value' => '0', 'icon' => 'CU'],
    ];

    $tips = [
        'Go through all the course materials thoroughly.',
        'Practice all quizzes and assignments.',
        'Focus on weak topics and improve your understanding.',
        'Manage your time effectively during the assessment.',
        'Ensure a stable internet connection before starting the test.',
    ];

    $attempts = [];
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Final Assessment</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Take the final assessment to test your knowledge and earn your certificate.</p>
        </div>

        <article class="grid gap-6 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[165px_minmax(0,1fr)] xl:grid-cols-[165px_minmax(0,1fr)_repeat(3,170px)] xl:items-center">
            <div class="hidden h-32 items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-white text-[42px] font-black text-[#075fe4] sm:flex">FA</div>

            <div>
                <h2 class="mb-3 text-lg font-bold text-[#061942]">{{ $summary['title'] }}</h2>
                <p class="mb-5 max-w-xl text-sm leading-7 text-[#334b83]">{{ $summary['text'] }}</p>
                <a href="/fast-track/final-assessment/questions" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]">Start Final Assessment</a>
            </div>

            @foreach ($summary['stats'] as $item)
                <div class="flex min-h-[118px] flex-col justify-center border-t border-[#dce7f8] pt-4 xl:border-l xl:border-t-0 xl:pl-7 xl:pt-0">
                    <span class="mb-3 grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                    <strong class="text-[22px] font-bold text-[#061942]">{{ $item['value'] }}</strong>
                    <span class="mt-2 text-sm font-medium text-[#334b83]">{{ $item['label'] }}</span>
                </div>
            @endforeach
        </article>

        <div class="grid gap-5 xl:grid-cols-[1fr_1.28fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-5 text-lg font-bold text-[#061942]">Assessment Overview</h2>
                <div class="grid gap-4">
                    @foreach ($overview as $item)
                        <div class="grid grid-cols-[34px_minmax(0,1fr)_auto] items-center gap-4 text-sm">
                            <span class="grid h-[34px] w-[34px] place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                            <span class="font-semibold text-[#334b83]">{{ $item['label'] }}</span>
                            <strong class="text-right font-bold text-[#061942]">{{ $item['value'] }}</strong>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[minmax(0,1fr)_190px] lg:items-center">
                <div>
                    <h2 class="mb-5 text-lg font-bold text-[#061942]">Preparation Tips</h2>
                    <div class="grid gap-4">
                        @foreach ($tips as $tip)
                            <div class="flex items-start gap-3 text-sm leading-6 text-[#334b83]">
                                <span class="mt-1 grid h-[18px] w-[18px] shrink-0 place-items-center rounded-full bg-[#16a35a] text-[11px] font-black text-white">✓</span>
                                <span>{{ $tip }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hidden h-[150px] items-center justify-center rounded-xl bg-gradient-to-br from-[#eef5ff] to-[#fff4df] text-[44px] font-black text-[#075fe4] lg:flex">BK</div>
            </article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="p-5">
                <h2 class="text-lg font-bold text-[#061942]">Assessment Attempts</h2>
            </div>

            <div class="overflow-x-auto">
                <div class="grid min-w-[760px] grid-cols-[1.2fr_2fr_1.5fr_1.5fr_1.5fr] border-y border-[#e6eef8] px-4 py-3 text-xs font-bold text-[#061942]">
                    <span>Attempt No.</span>
                    <span>Date & Time</span>
                    <span>Score</span>
                    <span>Status</span>
                    <span>Certificate</span>
                </div>

                @forelse ($attempts as $attempt)
                    <div class="grid min-w-[760px] grid-cols-[1.2fr_2fr_1.5fr_1.5fr_1.5fr] border-b border-[#e6eef8] px-4 py-4 text-sm text-[#334b83] last:border-b-0">
                        <span>{{ $attempt['no'] }}</span>
                        <span>{{ $attempt['date'] }}</span>
                        <span>{{ $attempt['score'] }}</span>
                        <span>{{ $attempt['status'] }}</span>
                        <span>{{ $attempt['certificate'] }}</span>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center">
                        <div class="mx-auto mb-3 grid h-[86px] w-[86px] place-items-center rounded-full bg-[#eaf2ff] text-2xl font-black text-[#075fe4]">NA</div>
                        <h3 class="mb-2 text-base font-bold text-[#061942]">No attempts yet!</h3>
                        <p class="mb-5 text-sm text-[#334b83]">Start your final assessment to evaluate your learning.</p>
                        <a href="/fast-track/final-assessment/questions" class="inline-flex h-10 items-center justify-center rounded-md bg-[#075fe4] px-6 text-sm font-bold text-white">Start Now</a>
                    </div>
                @endforelse
            </div>
        </article>
    </section>
@endsection
