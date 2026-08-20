@extends('layouts.public')

@section('title', 'Direct Mode - OnlyFreshers')

@php
    $activePage = 'direct-mode';
@endphp

@push('styles')
<style>
    .direct-mode-page,
    .direct-mode-page * {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .direct-mode-page h1,
    .direct-mode-page h2,
    .direct-mode-page h3 {
        font-weight: 700;
    }
</style>
@endpush

@section('content')
    <main class="direct-mode-page bg-white">
    <section class="bg-[#f3f8ff] px-4 py-5 sm:px-6 lg:px-8">
        <div class="mx-auto grid w-full max-w-7xl overflow-hidden rounded-lg bg-[#edf5ff] shadow-[0_10px_28px_rgba(7,95,228,0.10)] lg:h-[330px] lg:grid-cols-[minmax(0,0.95fr)_minmax(420px,1.05fr)] lg:items-stretch">
            <div class="flex min-h-[250px] flex-col items-start justify-center px-6 py-9 sm:px-9 lg:h-full lg:min-h-0 lg:px-12">
                <p class="mb-2 text-[13px] font-black uppercase tracking-[.05em] text-[#075fe4]">{{ $hero['eyebrow'] }}</p>
                <h1 class="mb-3 text-[30px] leading-tight text-[#061942] sm:text-[38px] lg:text-[44px]">{{ $hero['title'] }}</h1>
                <p class="mb-6 max-w-md text-[14px] font-semibold leading-6 text-[#34445e] sm:text-[15px]">{{ $hero['text'] }}</p>
                <a href="{{ $hero['href'] }}" class="inline-flex h-11 min-w-[132px] items-center justify-center rounded-md bg-[#075fe4] px-6 text-[13px] font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.20)] transition hover:bg-[#0554cc]">{{ $hero['button'] }}</a>
            </div>

            <div class="relative flex min-h-[250px] items-center justify-center px-6 py-7 sm:min-h-[280px] lg:h-full lg:min-h-0">
                <img src="{{ asset($hero['image']) }}" alt="{{ $hero['title'] }}" class="h-full max-h-[280px] w-full object-contain lg:max-h-[300px]">
            </div>
        </div>
    </section>
    <section class="bg-white px-5 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="mb-1 flex items-center gap-1.5 text-[18px] text-[#061942]">{{ $jobsHeader['title'] }} <span class="grid h-4 w-4 place-items-center rounded-full border border-[#9bb7dc] text-[10px] font-bold text-[#075fe4]">i</span></h2>
                    <p class="text-[12px] font-semibold text-[#34445e]">{{ $jobsHeader['text'] }}</p>
                </div>
                <a href="{{ $jobsHeader['href'] }}" class="inline-flex h-8 shrink-0 items-center gap-2 rounded-full border border-[#075fe4] bg-white px-4 text-[11px] font-bold text-[#075fe4]">
                    <span class="grid h-4 w-4 place-items-center rounded-full border border-[#075fe4] text-[9px]">i</span>
                    {{ $jobsHeader['button'] }}
                </a>
            </div>

            <div class="grid gap-0 overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_8px_20px_rgba(6,25,66,0.04)] md:grid-cols-2 xl:grid-cols-4">
                @foreach ($directStats as $item)
                    <article class="flex min-h-[88px] items-center gap-4 border-b border-[#edf2f8] px-5 py-4 md:border-r xl:border-b-0 xl:last:border-r-0">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-md bg-[#edf5ff] text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">
                            @if ($item['icon'] === 'plus')
                                <span class="text-[30px] font-light leading-none">+</span>
                            @else
                                @include('components.public.icon', ['name' => $item['icon']])
                            @endif
                        </span>
                        <span>
                            @if ($item['value'] !== '')
                                <strong class="block text-[22px] leading-none text-[#061942]">{{ $item['value'] }}</strong>
                            @endif
                            <span class="block max-w-[120px] text-[11px] font-bold leading-4 text-[#061942]">{{ $item['label'] }}</span>
                        </span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white px-5 pb-12 sm:px-6 lg:px-8">
        <div class="mx-auto grid w-full max-w-7xl gap-6 px-5 sm:px-6 lg:grid-cols-[minmax(0,1fr)_310px] lg:px-8">
            <div class="min-w-0">
                <div class="mb-4 grid gap-3 md:grid-cols-[minmax(0,1fr)_190px_190px_100px]">
                    <div class="flex h-10 items-center gap-2 rounded-md border border-[#dce7f8] bg-white px-3 text-[#6f7d90]">
                        <span class="[&>svg]:h-4 [&>svg]:w-4">@include('components.public.icon', ['name' => 'search'])</span>
                        <span class="text-[11px] font-semibold">{{ $filterLabels['search'] }}</span>
                    </div>
                    <select class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[11px] font-semibold text-[#34445e]">
                        <option>{{ $filterLabels['locations'] }}</option>
                        @foreach ($directLocations as $location)
                            <option>{{ $location }}</option>
                        @endforeach
                    </select>
                    <select class="h-10 rounded-md border border-[#dce7f8] bg-white px-3 text-[11px] font-semibold text-[#34445e]"><option>{{ $filterLabels['roles'] }}</option></select>
                    <button class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#075fe4]" type="button">@include('components.public.icon', ['name' => 'search']) {{ $filterLabels['button'] }}</button>
                </div>

                <div class="grid gap-3">
                    @foreach ($directJobs as $job)
                        <article class="grid gap-4 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_5px_15px_rgba(6,25,66,0.035)] sm:grid-cols-[76px_minmax(0,1fr)_135px_104px] sm:items-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-md bg-white text-[20px] font-black text-[#075fe4]">{{ $job['logo'] }}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1 text-[14px] text-[#061942]">{{ $job['title'] }}</h3>
                                <p class="mb-2 text-[12px] font-semibold text-[#34445e]">{{ $job['company'] }}</p>
                                <div class="mb-2 flex flex-wrap gap-3 text-[11px] font-semibold text-[#34445e]">
                                    <span>{{ $job['location'] }}</span>
                                    <span>{{ $job['type'] }}</span>
                                    <span>{{ $job['exp'] }}</span>
                                </div>
                                <p class="text-[10px] font-semibold text-[#6f7d90]">{{ $job['posted'] }}</p>
                            </div>
                            <div class="text-left sm:text-center">
                                <p class="mb-2 text-[10px] font-semibold text-[#6f7d90]">{{ $jobLabels['match'] }}</p>
                                <span class="inline-flex rounded-full px-4 py-1 text-[10px] font-bold {{ $job['fitClass'] }}">{{ $job['fit'] }}</span>
                            </div>
                            <div class="flex items-center gap-3 sm:block sm:text-right">
                                <a href="{{ $jobLabels['apply_href'] }}" class="inline-flex h-9 min-w-[88px] items-center justify-center rounded-md bg-[#075fe4] px-4 text-[11px] font-bold text-white">{{ $jobLabels['apply'] }}</a>
                                <p class="mt-2 text-[10px] font-semibold text-[#075fe4]">{{ $jobLabels['credit'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-center">
                    <a href="/direct-mode/jobs" class="inline-flex h-9 items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-6 text-[11px] font-bold text-[#075fe4]">{{ $filterLabels['load_more'] }}</a>
                </div>
            </div>

            <aside class="grid content-start gap-4">
                <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5">
                    <h2 class="mb-4 text-[14px] text-[#061942]">{{ $analysisPanel['title'] }}</h2>
                    <div class="mb-4 flex justify-center">
                        <svg viewBox="0 0 180 150" class="h-[155px] w-full max-w-[230px]" aria-hidden="true">
                            <polygon points="90,18 146,58 124,126 56,126 34,58" fill="#edf5ff" stroke="#d6e4fb" stroke-width="1"></polygon>
                            <polygon points="90,30 134,62 116,116 64,116 46,62" fill="rgba(7,95,228,.12)" stroke="#075fe4" stroke-width="2"></polygon>
                            <text x="90" y="12" text-anchor="middle" font-size="10" font-weight="700" fill="#061942">{{ $analysisPanel['labels'][0] }}</text>
                            <text x="154" y="62" font-size="10" font-weight="700" fill="#061942">{{ $analysisPanel['labels'][1] }}</text>
                            <text x="112" y="143" font-size="10" font-weight="700" fill="#061942">{{ $analysisPanel['labels'][2] }}</text>
                            <text x="8" y="138" font-size="10" font-weight="700" fill="#061942">{{ $analysisPanel['labels'][3] }}</text>
                            <text x="0" y="62" font-size="10" font-weight="700" fill="#061942">{{ $analysisPanel['labels'][4] }}</text>
                        </svg>
                    </div>
                    <div class="mb-3 flex items-center justify-between text-[12px] font-bold">
                        <span class="text-[#061942]">{{ $analysisPanel['match_label'] }}</span>
                        <span class="text-[#075fe4]">★★★★☆</span>
                        <span class="text-[#0b8b67]">{{ $analysisPanel['fit'] }}</span>
                    </div>
                    <p class="mb-4 text-[11px] font-semibold leading-5 text-[#34445e]">{{ $analysisPanel['text'] }}</p>
                    <a href="{{ $analysisPanel['href'] }}" class="inline-flex h-9 w-full items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#075fe4]">{{ $analysisPanel['button'] }}</a>
                </section>

                <section class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5">
                    <h2 class="mb-4 text-[14px] text-[#061942]">{{ $tipsPanel['title'] }}</h2>
                    <ul class="mb-4 grid gap-2 text-[11px] font-semibold text-[#061942]">
                        @foreach ($applicationTips as $tip)
                            <li class="flex gap-2"><span class="font-bold text-[#0b8b67]">✓</span><span>{{ $tip }}</span></li>
                        @endforeach
                    </ul>
                    <a href="{{ $tipsPanel['href'] }}" class="text-[11px] font-bold text-[#075fe4]">{{ $tipsPanel['button'] }}</a>
                </section>
            </aside>
        </div>
    </section>

    <section class="bg-white px-5 pb-14 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-6 text-center">
                <h2 class="mb-2 text-[22px] text-[#061942]">{{ $creditsHeader['title'] }}</h2>
                <p class="text-[12px] font-semibold text-[#34445e]">{{ $creditsHeader['text'] }}</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($creditPlans as $plan)
                    <article class="relative rounded-lg border bg-white px-5 pb-5 pt-5 text-center shadow-[0_6px_18px_rgba(6,25,66,.04)] {{ $plan['popular'] ? 'border-[#075fe4] ring-1 ring-[#075fe4]' : 'border-[#dce7f8]' }}">
                        @if ($plan['popular'])
                            <span class="absolute left-1/2 top-0 inline-flex h-6 min-w-[96px] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#075fe4] px-4 text-[10px] font-bold text-white">{{ $planLabels['popular'] }}</span>
                        @endif
                        <h3 class="mb-3 text-[14px] text-[#061942]">{{ $plan['name'] }}</h3>
                        <p class="text-[31px] font-black leading-none text-[#075fe4]">{{ $plan['credits'] }}</p>
                        <p class="mb-4 text-[10px] font-bold text-[#075fe4]">{{ $planLabels['credits'] }}</p>
                        <p class="text-[27px] font-black leading-none text-[#061942]">{{ $plan['price'] }}</p>
                        <p class="mb-4 text-[10px] font-semibold text-[#34445e]">{{ $plan['period'] }}</p>
                        <a href="{{ $planLabels['buy_href'] }}" class="mb-5 inline-flex h-9 w-full items-center justify-center rounded-md border border-[#075fe4] px-4 text-[11px] font-bold transition {{ $plan['button'] === 'Current Plan' ? 'bg-white text-[#075fe4]' : 'bg-[#075fe4] text-white hover:bg-[#0554cc]' }}">{{ $plan['button'] }}</a>
                        <ul class="grid gap-2 text-left text-[10px] font-semibold leading-4 text-[#061942]">
                            @foreach ($plan['items'] as $item)
                                <li class="flex gap-2"><span class="font-bold text-[#0b8b67]">✓</span><span>{{ $item }}</span></li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-[11px] font-semibold text-[#34445e]">
                @foreach ($creditTrustItems as $item)
                    @if (! $loop->first)
                        <span>|</span>
                    @endif
                    <span>{{ $item }}</span>
                @endforeach
            </div>
        </div>
    </section>
    </main>
@endsection
