@extends('layouts.fast-track')

@section('title', 'Dashboard - Fast Track')

@php
    $activePage = 'dashboard';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $stats = [
        ['label' => 'Profile Completion', 'value' => 75, 'color' => '#19a85b'],
        ['label' => 'Assessment Score', 'value' => 60, 'color' => '#7744eb'],
    ];

    $smallStats = [
        ['label' => 'Current Training', 'value' => 1, 'icon' => 'TR'],
        ['label' => 'Notifications', 'value' => 3, 'icon' => 'NT'],
    ];

    $actions = [
        ['title' => 'Complete Profile', 'icon' => 'CP', 'url' => '/fast-track/profile'],
        ['title' => 'Give Assessment', 'icon' => 'GA', 'url' => '/fast-track/assessment'],
        ['title' => 'Explore Fast Track', 'icon' => 'EF', 'url' => '/fast-track/courses'],
        ['title' => 'View Training', 'icon' => 'VT', 'url' => '/fast-track/training'],
    ];

    $activities = [
        ['title' => 'Profile updated successfully', 'date' => '14 May 2024', 'icon' => 'PR'],
        ['title' => 'Assessment completed', 'date' => '12 May 2024', 'icon' => 'AS'],
        ['title' => 'Enrolled in Full Stack Development', 'date' => '10 May 2024', 'icon' => 'EN'],
        ['title' => 'Certificate of HTML Basics earned', 'date' => '08 May 2024', 'icon' => 'CE'],
        ['title' => 'Resume uploaded', 'date' => '05 May 2024', 'icon' => 'RS'],
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Dashboard</h1>
        </div>

        <div>
            <p class="mb-2 text-base font-medium text-[#24344f]">Welcome back,</p>
            <h2 class="text-[22px] font-bold leading-tight text-[#061942]">{{ $student['name'] }}!</h2>
        </div>

        <div class="grid items-start gap-8 xl:grid-cols-[500px_minmax(0,1fr)]">
            <div class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach ($stats as $stat)
                        <article class="flex min-h-[190px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white p-6 text-center shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                            <div>
                                <div class="mx-auto mb-4 flex h-[116px] w-[116px] items-center justify-center rounded-full" style="background: conic-gradient({{ $stat['color'] }} 0 {{ $stat['value'] }}%, #e9edf5 {{ $stat['value'] }}% 100%);">
                                    <span class="flex h-[86px] w-[86px] items-center justify-center rounded-full bg-white text-[28px] font-bold text-[#061942]">{{ $stat['value'] }}%</span>
                                </div>
                                <h3 class="text-base font-medium leading-snug text-[#061942]">{!! str_replace(' ', '<br>', e($stat['label'])) !!}</h3>
                            </div>
                        </article>
                    @endforeach

                    @foreach ($smallStats as $stat)
                        <article class="grid min-h-[125px] grid-cols-[64px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $stat['icon'] }}</span>
                            <div>
                                <div class="mb-1 text-[26px] font-bold leading-none text-[#061942]">{{ $stat['value'] }}</div>
                                <p class="text-sm leading-snug text-[#24344f]">{!! str_replace(' ', '<br>', e($stat['label'])) !!}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Quick Actions</h3>
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($actions as $action)
                            <a class="flex min-h-[132px] flex-col items-center justify-center gap-3 rounded-lg border border-[#dce7f8] px-4 text-center text-sm font-bold leading-snug text-[#061942] transition hover:border-[#075fe4] hover:bg-[#eff5ff] hover:text-[#075fe4]" href="{{ $action['url'] }}">
                                <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $action['icon'] }}</span>
                                <span>{{ $action['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </article>
            </div>

            <div class="space-y-8">
                <article class="rounded-lg border border-[#dce7f8] bg-white px-6 py-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:px-7">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Recent Activity</h3>
                    <div>
                        @foreach ($activities as $item)
                            <div class="grid grid-cols-[44px_minmax(0,1fr)] items-center gap-4 border-b border-[#e5edf8] py-4 text-sm last:border-b-0 sm:grid-cols-[44px_minmax(0,1fr)_auto]">
                                <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                                <span class="font-semibold text-[#061942]">{{ $item['title'] }}</span>
                                <time class="col-start-2 whitespace-nowrap text-[#24344f] sm:col-start-auto">{{ $item['date'] }}</time>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="relative flex min-h-[220px] items-center overflow-hidden rounded-lg border border-[#dce7f8] bg-gradient-to-r from-white to-[#eef5ff] p-8 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="relative z-10 max-w-[360px]">
                        <h3 class="mb-4 text-[22px] font-bold text-[#061942]">Fast Track Your Career</h3>
                        <p class="mb-6 text-[15px] leading-6 text-[#24344f]">Enroll in Fast Track Courses and get placed in top companies.</p>
                        <a href="/fast-track/courses" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]">Explore Courses</a>
                    </div>
                    <div class="absolute bottom-7 right-12 hidden h-[155px] w-[155px] rotate-[-28deg] items-center justify-center rounded-full bg-[#e1edff] text-[58px] font-black text-[#075fe4] sm:flex">^</div>
                </article>
            </div>
        </div>
    </section>
@endsection
