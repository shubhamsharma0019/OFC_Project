@extends('layouts.public')

@section('title', $course['title'] . ' - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@section('content')
    <main class="bg-white px-5 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-5xl">
            <a href="/courses" class="mb-5 inline-flex text-[12px] font-bold text-[#075fe4]">{{ $detailLabels['back'] }}</a>
            <article class="rounded-lg border border-[#d6e4f7] bg-white p-6 shadow-[0_10px_26px_rgba(6,25,66,0.06)]">
                <div class="mb-6 flex flex-col gap-5 sm:flex-row sm:items-start">
                    <span class="grid h-16 w-16 shrink-0 place-items-center rounded-lg text-white [&>svg]:h-8 [&>svg]:w-8" style="background-color: {{ $course['color'] }}">@include('components.public.icon', ['name' => $course['icon']])</span>
                    <div>
                        <h1 class="mb-2 text-[30px] font-bold leading-tight text-[#061942]">{{ $course['title'] }}</h1>
                        <p class="text-[13px] font-bold text-[#075fe4]">{{ $course['partner'] }} · {{ $course['location'] }}</p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_280px]">
                    <div>
                        <h2 class="mb-3 text-[18px] font-bold text-[#061942]">{{ $detailLabels['overview'] }}</h2>
                        <p class="mb-6 text-[14px] font-semibold leading-7 text-[#34445e]">{{ $course['text'] }}</p>
                        <h2 class="mb-3 text-[18px] font-bold text-[#061942]">{{ $detailLabels['skills'] }}</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($course['skills'] as $skill)
                                <span class="rounded-md border border-[#e4ecf7] bg-white px-3 py-1.5 text-[11px] font-bold text-[#34445e]">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    <aside class="rounded-lg border border-[#edf2f8] bg-[#f8fbff] p-5">
                        <dl class="grid gap-4 text-[12px] font-semibold text-[#34445e]">
                            <div><dt class="text-[#6f7d90]">{{ $detailLabels['partner'] }}</dt><dd class="mt-1 font-bold text-[#061942]">{{ $course['partner'] }}</dd></div>
                            <div><dt class="text-[#6f7d90]">{{ $detailLabels['duration'] }}</dt><dd class="mt-1 font-bold text-[#061942]">{{ $course['duration'] }}</dd></div>
                            <div><dt class="text-[#6f7d90]">{{ $detailLabels['mode'] }}</dt><dd class="mt-1 font-bold text-[#061942]">{{ $course['mode'] }}</dd></div>
                            <div><dt class="text-[#6f7d90]">{{ $detailLabels['fee'] }}</dt><dd class="mt-1 text-[20px] font-black text-[#0b9b6b]">{{ $detailLabels['currency'] }}{{ $course['fee'] }}</dd></div>
                        </dl>
                        <a href="/fast-track/register" class="mt-5 inline-flex h-10 w-full items-center justify-center rounded-md bg-[#075fe4] px-4 text-[12px] font-bold text-white">{{ $detailLabels['enroll'] }}</a>
                    </aside>
                </div>
            </article>
        </div>
    </main>
@endsection
