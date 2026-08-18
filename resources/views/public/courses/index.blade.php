@extends('layouts.public')

@section('title', 'Courses - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@section('content')
    <main class="bg-white">
        <section class="bg-[#f3f8ff] px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-7xl rounded-lg bg-[#eef5ff] px-6 py-8 shadow-[0_8px_24px_rgba(7,95,228,0.08)] sm:px-8">
                <h1 class="mb-2 text-[32px] font-bold text-[#061942]">{{ $courseHero['title'] }}</h1>
                <p class="mb-6 max-w-2xl text-[14px] font-semibold leading-6 text-[#34445e]">{{ $courseHero['text'] }}</p>
                <form method="GET" action="{{ url('/courses') }}" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_190px_190px_110px]">
                    <label class="flex h-11 items-center gap-2 rounded-md border border-[#c7d8f2] bg-white px-4 text-[#6f7d90]">
                        <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => 'search'])</span>
                        <input name="q" value="{{ $currentFilters['q'] }}" placeholder="{{ $courseHero['search'] }}" class="min-w-0 flex-1 bg-transparent text-[12px] font-semibold text-[#34445e] outline-none placeholder:text-[#6f7d90]">
                    </label>
                    <select name="category" class="h-11 rounded-md border border-[#c7d8f2] bg-white px-3 text-[12px] font-semibold text-[#34445e] outline-none">
                        <option value="">{{ $courseFilters['category'] }}</option>
                        @foreach ($courseOptions['categories'] as $category)
                            <option value="{{ $category }}" @selected($currentFilters['category'] === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    <select name="mode" class="h-11 rounded-md border border-[#c7d8f2] bg-white px-3 text-[12px] font-semibold text-[#34445e] outline-none">
                        <option value="">{{ $courseFilters['mode'] }}</option>
                        @foreach ($courseOptions['modes'] as $mode)
                            <option value="{{ $mode }}" @selected($currentFilters['mode'] === $mode)>{{ $mode }}</option>
                        @endforeach
                    </select>
                    <button class="inline-flex h-11 items-center justify-center gap-2 rounded-md border border-[#075fe4] bg-[#075fe4] px-4 text-[12px] font-bold text-white" type="submit">@include('components.public.icon', ['name' => 'search']) {{ $courseFilters['button'] }}</button>
                </form>
            </div>
        </section>

        <section class="px-5 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-7xl">
                <p class="mb-5 text-[13px] font-bold text-[#061942]">{{ $courseFilters['count_prefix'] }} {{ $courseCount }} {{ $courseFilters['count_suffix'] }}</p>
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($courseCards as $course)
                        <article class="rounded-lg border border-[#d6e4f7] bg-white p-5 shadow-[0_10px_26px_rgba(6,25,66,0.06)] transition hover:-translate-y-0.5 hover:border-[#aac6ef] hover:shadow-[0_16px_34px_rgba(6,25,66,0.10)]">
                            <div class="mb-4 flex items-start gap-4">
                                <span class="grid h-14 w-14 shrink-0 place-items-center rounded-lg text-white [&>svg]:h-7 [&>svg]:w-7" style="background-color: {{ $course['color'] }}">@include('components.public.icon', ['name' => $course['icon']])</span>
                                <span>
                                    <h2 class="text-[17px] font-bold leading-tight text-[#061942]">{{ $course['title'] }}</h2>
                                    <span class="mt-1 block text-[11px] font-bold text-[#075fe4]">{{ $course['partner'] }}</span>
                                </span>
                            </div>
                            <p class="mb-4 line-clamp-3 text-[12px] font-semibold leading-5 text-[#34445e]">{{ $course['text'] }}</p>
                            <div class="mb-4 grid gap-2 text-[11px] font-semibold text-[#34445e] sm:grid-cols-2">
                                <span class="rounded-md bg-[#f3f8ff] px-3 py-2">{{ $courseLabels['duration'] }}: {{ $course['duration'] }}</span>
                                <span class="rounded-md bg-[#f3f8ff] px-3 py-2">{{ $courseLabels['mode'] }}: {{ $course['mode'] }}</span>
                                <span class="rounded-md bg-[#f3f8ff] px-3 py-2">{{ $courseLabels['partner'] }}: {{ $course['partner'] }}</span>
                                <span class="rounded-md bg-[#f3f8ff] px-3 py-2">{{ $courseLabels['fee'] }}: {{ $courseLabels['currency'] }}{{ $course['fee'] }}</span>
                            </div>
                            <div class="mb-5 flex flex-wrap gap-2">
                                @foreach ($course['skills'] as $skill)
                                    <span class="rounded-md border border-[#e4ecf7] bg-white px-2.5 py-1 text-[10px] font-bold text-[#34445e]">{{ $skill }}</span>
                                @endforeach
                            </div>
                            <a href="{{ $courseLabels['details_href'] }}?course={{ $course['id'] }}" class="inline-flex h-9 min-w-[118px] items-center justify-center rounded-md border border-[#8eb4ef] bg-white px-4 text-[11px] font-bold text-[#075fe4] transition hover:border-[#075fe4] hover:bg-[#075fe4] hover:text-white">{{ $courseLabels['details'] }}</a>
                        </article>
                    @empty
                        <article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-[12px] font-semibold text-[#34445e]">{{ $courseFilters['empty'] }}</article>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection
