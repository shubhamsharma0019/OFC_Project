@extends('layouts.public')

@section('title', 'Training Partners - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@push('styles')
<style>
    .training-partners-page,
    .training-partners-page * {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .training-partners-page h1,
    .training-partners-page h2,
    .training-partners-page h3 {
        font-weight: 700;
    }
    .partner-filter-panel {
        border: 1px solid #cfe0ff;
        border-radius: 18px;
        background: linear-gradient(145deg, #ffffff, #f3f8ff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .08);
    }
    .partner-card {
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-height: 292px;
        border: 1px solid #cfe0ff;
        border-radius: 20px;
        background: linear-gradient(145deg, #ffffff, #f7fbff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .09);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .partner-card:hover {
        transform: translateY(-6px);
        border-color: #9fc0f8;
        box-shadow: 0 26px 52px rgba(7, 95, 228, .15);
    }
    .partner-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #075fe4, #17a6a8);
    }
    .partner-card:after {
        content: "";
        position: absolute;
        right: -52px;
        top: -58px;
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background: rgba(220, 236, 255, .86);
        filter: blur(22px);
        pointer-events: none;
    }
    .partner-badge {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        font-size: 23px;
        font-weight: 900;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .75), 0 12px 24px rgba(7, 95, 228, .08);
    }
    .partner-chip {
        border: 1px solid #cfe0ff;
        border-radius: 999px;
        background: #fff;
        padding: 7px 12px;
        color: #075fe4;
        font-size: 12px;
        font-weight: 800;
    }
    .partner-meta {
        border: 1px solid #dce7f8;
        border-radius: 14px;
        background: rgba(255, 255, 255, .78);
        padding: 12px 14px;
        color: #34445e;
        font-size: 13px;
        font-weight: 700;
        text-align: right;
    }
    .partner-card-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .partner-card-button {
        display: inline-flex;
        width: 100%;
        height: 44px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 12px;
        background: #075fe4;
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(7, 95, 228, .18);
        transition: background .2s ease;
    }
    .partner-card-button:hover { background: #0554cc; }
</style>
@endpush

@section('content')
    <main class="training-partners-page bg-white">
        <section class="bg-[#f3f8ff] px-4 py-5 sm:px-6 lg:px-8">
            <div class="mx-auto grid w-full max-w-7xl overflow-hidden rounded-lg bg-[#eef5ff] shadow-[0_8px_24px_rgba(7,95,228,0.08)] lg:grid-cols-[1fr_520px]">
                <div class="relative z-10 px-6 py-6 sm:px-8 lg:py-8">
                    <h1 class="mb-2 text-[30px] font-bold leading-tight text-[#061942] sm:text-[34px]">{{ $trainingHero['title'] }}</h1>
                    <p class="mb-6 max-w-[650px] text-[13px] font-semibold leading-5 text-[#24344f]">{{ $trainingHero['text'] }}</p>

                    <form method="GET" action="{{ url('/training-partners') }}" class="mb-6 grid max-w-[610px] gap-3 sm:grid-cols-[1fr_170px]">
                        <input type="hidden" name="category" value="{{ $currentFilters['category'] }}">
                        <input type="hidden" name="level" value="{{ $currentFilters['level'] }}">
                        <label class="flex h-11 items-center gap-2 rounded-md border border-[#c7d8f2] bg-white px-4 text-[#6f7d90] shadow-[0_3px_10px_rgba(6,25,66,0.04)]">
                            <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => 'search'])</span>
                            <input name="q" value="{{ $currentFilters['q'] }}" placeholder="{{ $trainingHero['search'] }}" class="min-w-0 flex-1 bg-transparent text-[12px] font-semibold text-[#34445e] outline-none placeholder:text-[#6f7d90]">
                        </label>
                        <select name="location" onchange="this.form.submit()" class="h-11 rounded-md border border-[#c7d8f2] bg-white px-4 text-[12px] font-semibold text-[#24344f] shadow-[0_3px_10px_rgba(6,25,66,0.04)] outline-none">
                            <option value="">{{ $trainingHero['location'] }}</option>
                            @foreach ($filterOptions['locations'] as $location)
                                <option value="{{ $location }}" @selected($currentFilters['location'] === $location)>{{ $location }}</option>
                            @endforeach
                        </select>
                    </form>

                    <div class="grid max-w-[760px] gap-3 rounded-lg bg-white/78 p-3 shadow-[0_5px_18px_rgba(6,25,66,0.04)] sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($trainingHeroBenefits as $benefit)
                            <div class="flex items-center gap-3">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-[#e8f1ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => $benefit['icon']])</span>
                                <span>
                                    <strong class="block text-[10px] font-bold leading-tight text-[#07518f]">{{ $benefit['title'] }}</strong>
                                    <span class="block text-[9px] font-semibold leading-tight text-[#34445e]">{{ $benefit['text'] }}</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <span id="partnerHeroCount" class="hidden">...</span>
                </div>
                <div class="relative min-h-[260px] lg:min-h-[300px]">
                    <div class="absolute inset-0 bg-[linear-gradient(90deg,#eef5ff_0%,rgba(238,245,255,0.82)_10%,rgba(238,245,255,0)_34%)]"></div>
                    <img src="{{ asset($trainingHero['image']) }}" alt="{{ $trainingHero['title'] }}" class="h-full w-full object-cover object-center">
                </div>
            </div>
        </section>
        <div class="mx-auto w-full max-w-7xl px-5 py-8 sm:px-6 lg:px-8 lg:pb-[60px]">
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[13px] font-bold text-[#061942]">{{ $trainingFilters['count_prefix'] }} {{ $partnerCount }} {{ $trainingFilters['count_suffix'] }}</p>
                <form method="GET" action="{{ url('/training-partners') }}" class="grid gap-3 sm:grid-cols-[190px_190px_110px]">
                    <input type="hidden" name="q" value="{{ $currentFilters['q'] }}">
                    <input type="hidden" name="location" value="{{ $currentFilters['location'] }}">
                    <select name="category" class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[12px] font-semibold text-[#34445e] outline-none">
                        <option value="">{{ $trainingFilters['category'] }}</option>
                        @foreach ($filterOptions['categories'] as $category)
                            <option value="{{ $category }}" @selected($currentFilters['category'] === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    <select name="level" class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[12px] font-semibold text-[#34445e] outline-none">
                        <option value="">{{ $trainingFilters['level'] }}</option>
                        @foreach ($filterOptions['levels'] as $level)
                            <option value="{{ $level }}" @selected($currentFilters['level'] === $level)>{{ $level }}</option>
                        @endforeach
                    </select>
                    <button class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[#b9cff0] bg-white px-4 text-[12px] font-bold text-[#075fe4]" type="submit">@include('components.public.icon', ['name' => 'search']) {{ $trainingFilters['button'] }}</button>
                </form>
            </div>

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_285px]">
                <div class="grid gap-3">
                    @forelse ($courseRows as $row)
                        <article class="grid gap-4 overflow-hidden rounded-lg border border-[#d6e4f7] bg-[linear-gradient(135deg,#ffffff_0%,#ffffff_58%,#f8fbff_100%)] p-4 shadow-[0_10px_26px_rgba(6,25,66,0.06)] transition hover:-translate-y-0.5 hover:border-[#aac6ef] hover:shadow-[0_16px_34px_rgba(6,25,66,0.10)] xl:grid-cols-[170px_minmax(0,1fr)_150px_200px_130px]">
                            <div class="flex flex-col justify-between rounded-md border border-[#edf2f8] bg-[#f8fbff] p-3 xl:min-h-[205px]">
                                <div>
                                    <strong class="block text-[22px] font-black leading-tight text-[#176aa6]">{{ $row['logo'] }}</strong>
                                    <span class="block text-[9px] font-bold text-[#6f7d90]">{{ $row['sub'] }}</span>
                                </div>
                                <p class="mt-3 text-[10px] font-bold text-[#061942]">{{ $row['rating'] }} <span class="text-[#f3a51d]">{{ $courseLabels['rating_symbol'] }}</span> <span class="font-semibold text-[#6f7d90]">({{ $row['reviews'] }} {{ $courseLabels['reviews'] }})</span></p>
                            </div>
                            <div class="min-w-0 py-1">
                                <h2 class="mb-1.5 text-[14px] font-bold text-[#061942]">{{ $row['title'] }}</h2>
                                <div class="mb-2 flex flex-wrap gap-2 text-[10px] font-bold text-[#34445e]">
                                    <span class="rounded-full bg-[#edf5ff] px-2.5 py-1">{{ $row['city'] }}</span>
                                    <span class="rounded-full bg-[#edf5ff] px-2.5 py-1">{{ $row['mode'] }}</span>
                                </div>
                                <p class="mb-3 line-clamp-2 text-[11px] font-semibold leading-5 text-[#34445e]">{{ $row['text'] }}</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($row['tags'] as $tag)
                                        <span class="rounded-md border border-[#e4ecf7] bg-white px-2.5 py-1 text-[9px] font-bold text-[#34445e]">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="rounded-md border border-[#edf2f8] bg-white p-3">
                                <p class="text-[10px] font-semibold text-[#6f7d90]">{{ $courseLabels['joining_fee'] }}</p>
                                <p class="mb-4 text-[16px] font-black text-[#0b9b6b]">{{ $courseLabels['currency'] }}{{ $row['join'] }}</p>
                                <p class="text-[10px] font-semibold text-[#6f7d90]">{{ $courseLabels['package_fee'] }}</p>
                                <p class="text-[16px] font-black text-[#061942]">{{ $courseLabels['currency'] }}{{ $row['fee'] }}</p>
                            </div>
                            <ul class="grid content-start gap-2 rounded-md border border-[#edf2f8] bg-[#fbfdff] p-3 text-[10px] font-semibold text-[#061942]">
                                @foreach ($row['features'] as $feature)
                                    <li class="flex gap-2"><span class="mt-0.5 grid h-4 w-4 shrink-0 place-items-center rounded-full bg-[#e3f7ef] text-[9px] font-bold text-[#0b9b6b]">{{ $courseLabels['check_symbol'] }}</span><span>{{ $feature }}</span></li>
                                @endforeach
                            </ul>
                            <div class="flex items-end xl:justify-end">
                                <a href="{{ $courseLabels['details_href'] }}" class="inline-flex h-9 min-w-[118px] items-center justify-center rounded-md border border-[#8eb4ef] bg-white px-4 text-[10px] font-bold text-[#075fe4] shadow-[0_6px_14px_rgba(7,95,228,0.08)] transition hover:border-[#075fe4] hover:bg-[#075fe4] hover:text-white">{{ $courseLabels['details'] }}</a>
                            </div>
                        </article>
                    @empty
                        <article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-[12px] font-semibold text-[#34445e] shadow-[0_6px_18px_rgba(6,25,66,0.04)]">
                            {{ $courseLabels['empty'] }}
                        </article>
                    @endforelse

                    <div class="flex justify-center {{ count($courseRows) ? '' : 'hidden' }}">
                        <a href="{{ $courseLabels['load_more_href'] }}" class="inline-flex h-10 items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-5 text-[12px] font-bold text-[#075fe4]">{{ $courseLabels['load_more'] }} {{ $courseLabels['arrow'] }}</a>
                    </div>
                </div>

                <aside class="grid content-start gap-4 lg:sticky lg:top-24">
                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-4 text-[13px] font-bold text-[#061942]">{{ $sidebarLabels['reasons_title'] }}</h2>
                        <ul class="grid gap-3 text-[10px] font-semibold text-[#061942]">
                            @foreach ($fastTrackReasons as $item)
                                <li class="flex items-center gap-2"><span class="grid h-3.5 w-3.5 shrink-0 place-items-center rounded-full bg-[#0b9b6b] text-[8px] font-bold text-white">{{ $courseLabels['check_symbol'] }}</span><span>{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </section>

                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-4 text-[13px] font-bold text-[#061942]">{{ $sidebarLabels['popular_title'] }}</h2>
                        @foreach ($popularCourses as $index => $course)
                            <a href="{{ $sidebarLabels['popular_href'] }}" class="mb-3 flex items-center gap-3 rounded-md transition hover:bg-white last:mb-0">
                                <span class="grid h-8 w-8 shrink-0 place-items-center rounded-md text-[10px] font-black text-white {{ $popularCourseColors[$index % count($popularCourseColors)] }}">{{ substr($course[0], 0, 2) }}</span>
                                <span><strong class="block text-[10px] font-bold text-[#061942]">{{ $course[0] }}</strong><span class="text-[9px] font-semibold text-[#6f7d90]">{{ $course[1] }}</span></span>
                            </a>
                        @endforeach
                        <a href="{{ $sidebarLabels['popular_href'] }}" class="mt-3 inline-flex text-[10px] font-bold text-[#075fe4]">{{ $sidebarLabels['popular_button'] }} {{ $courseLabels['arrow'] }}</a>
                    </section>

                    <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 shadow-[0_6px_18px_rgba(6,25,66,0.035)]">
                        <h2 class="mb-4 text-[13px] font-bold text-[#061942]">{{ $sidebarLabels['steps_title'] }}</h2>
                        @foreach ($trainingSteps as $step => $item)
                            <div class="mb-4 flex gap-3 last:mb-0">
                                <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-[#075fe4] text-[11px] font-bold text-white">{{ $step + 1 }}</span>
                                <span><strong class="block text-[10px] font-bold text-[#061942]">{{ $item[0] }}</strong><span class="block text-[9px] font-semibold leading-4 text-[#34445e]">{{ $item[1] }}</span></span>
                            </div>
                        @endforeach
                    </section>

                </aside>
            </div>

            <div class="mt-6 grid gap-0 overflow-hidden rounded-lg border border-[#edf2f8] bg-[#f8fbff] px-4 py-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($trainingBenefits as $benefit)
                    <article class="flex min-h-[58px] items-center gap-3 px-4 py-2 xl:border-r xl:border-[#e7eef8] xl:last:border-r-0">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-md text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $benefit[0]])</span>
                        <span><strong class="block text-[10px] font-bold leading-tight text-[#075fe4]">{{ $benefit[1] }}</strong><span class="block text-[9px] font-semibold leading-tight text-[#34445e]">{{ $benefit[2] }}</span></span>
                    </article>
                @endforeach
            </div>
        </div>
    </main>
@endsection

