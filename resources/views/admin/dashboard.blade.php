@extends('layouts.admin')

@section('title', 'Admin Dashboard - OnlyFreshers')
@section('pageTitle', 'Dashboard')
@section('breadcrumb', 'Overview')

@php
    $activePage = 'dashboard';
    $stats = [
        ['label' => 'Freshers', 'value' => '12,450', 'tone' => 'bg-[#eaf2ff] text-[#075fe4]'],
        ['label' => 'Companies', 'value' => '860', 'tone' => 'bg-[#e8f8ef] text-[#078346]'],
        ['label' => 'Jobs Posted', 'value' => '2,140', 'tone' => 'bg-[#fff4df] text-[#b86500]'],
        ['label' => 'Training Partners', 'value' => '128', 'tone' => 'bg-[#f3ecff] text-[#5b20e6]'],
    ];
    $activities = ['New company verification request received', 'React course was published', '42 new freshers registered', 'Monthly report generated'];
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-lg text-xs font-black {{ $stat['tone'] }}">{{ substr($stat['label'], 0, 2) }}</span>
                    <p class="mt-4 text-xs font-bold text-[#52607a]">{{ $stat['label'] }}</p>
                    <h2 class="mt-2 text-3xl font-bold text-[#061942]">{{ $stat['value'] }}</h2>
                </article>
            @endforeach
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.4fr_.9fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#061942]">Platform Overview</h2>
                <div class="grid h-64 items-end gap-3 rounded-lg bg-[#f8fbff] p-5 sm:grid-cols-6">
                    @foreach (['h-[45%]', 'h-[68%]', 'h-[52%]', 'h-[82%]', 'h-[74%]', 'h-[92%]'] as $barHeight)
                        <div class="rounded-t-md bg-[#075fe4] {{ $barHeight }}"></div>
                    @endforeach
                </div>
            </article>
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#061942]">Recent Activity</h2>
                <div class="grid gap-3">
                    @foreach ($activities as $activity)
                        <div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#24344f]">{{ $activity }}</div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection

