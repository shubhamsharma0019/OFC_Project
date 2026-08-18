@extends('layouts.public')

@section('title', 'Fast Track Program - OnlyFreshers')

@php
    $activePage = 'fast-track';
@endphp

@push('styles')
<style>
    .fast-track-page,
    .fast-track-page * {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .fast-track-page h1,
    .fast-track-page h2,
    .fast-track-page h3 {
        font-weight: 700;
    }
</style>
@endpush

@section('content')
    <main class="fast-track-page bg-white">
    <section class="bg-[#f3f8ff] px-4 py-5 sm:px-6 lg:px-8">
        <div class="mx-auto grid w-full max-w-7xl overflow-hidden rounded-lg bg-[#edf5ff] shadow-[0_10px_28px_rgba(7,95,228,0.10)] lg:h-[330px] lg:grid-cols-[minmax(0,0.95fr)_minmax(420px,1.05fr)] lg:items-stretch">
            <div class="flex min-h-[250px] flex-col items-start justify-center px-6 py-9 sm:px-9 lg:h-full lg:min-h-0 lg:px-12">
                <p class="mb-2 text-[13px] font-black uppercase tracking-[.05em] text-[#075fe4]">{{ $hero['eyebrow'] }}</p>
                <h1 class="mb-3 text-[30px] leading-tight text-[#061942] sm:text-[38px] lg:text-[44px]">{{ $hero['title'] }}</h1>
                <p class="mb-6 max-w-md text-[14px] font-semibold leading-6 text-[#34445e] sm:text-[15px]">{{ $hero['text'] }}</p>
                <a href="{{ $hero['href'] }}" class="inline-flex h-11 min-w-[170px] items-center justify-center rounded-md bg-[#075fe4] px-6 text-[13px] font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.20)] transition hover:bg-[#0554cc]">{{ $hero['button'] }}</a>
            </div>

            <div class="relative flex min-h-[250px] items-center justify-center bg-white px-6 py-7 sm:min-h-[280px] lg:h-full lg:min-h-0">
                <img src="{{ asset($hero['image']) }}" alt="{{ $hero['title'] }}" class="h-full max-h-[280px] w-full object-contain lg:max-h-[300px]">
            </div>
        </div>
        <div id="fastTrackStats" class="hidden"></div>
    </section>
    <section class="bg-white pb-10 pt-8">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="mb-1 text-[26px] font-bold leading-tight text-[#061942]">{{ $programHeader['title'] }}</h2>
                <p class="text-[13px] font-semibold text-[#34445e]">{{ $programHeader['text'] }}</p>
            </div>

            <div class="mb-8 grid gap-5 lg:grid-cols-6 lg:gap-0">
                @foreach ($fastTrackSteps as $index => $step)
                    <article class="relative flex items-start gap-3 lg:block lg:text-center">
                        @if ($index < count($fastTrackSteps) - 1)
                            <span class="absolute left-[24px] top-6 hidden h-px w-full bg-[#d8e1ee] lg:block"></span>
                        @endif
                        <div class="relative z-10 mx-0 grid h-12 w-12 shrink-0 place-items-center rounded-full text-sm font-bold text-white shadow-[0_8px_16px_rgba(6,25,66,0.12)] lg:mx-auto" style="background-color: {{ $step['color'] }}">
                            @if ($index < 2)
                                {{ $step['step'] }}
                            @else
                                <span class="[&>svg]:h-5 [&>svg]:w-5">@include('components.public.icon', ['name' => $step['icon']])</span>
                            @endif
                        </div>
                        <div class="pt-1 lg:pt-3">
                            <h3 class="mb-1 text-[12px] font-bold text-[#061942]">{{ $step['step'] }}. {{ $step['title'] }}</h3>
                            <p class="mx-auto max-w-[125px] text-[11px] font-semibold leading-4 text-[#34445e]">{{ $step['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mb-4 flex items-end justify-between gap-4">
                <div>
                    <h2 class="mb-1 text-[20px] font-bold text-[#061942]">{{ $trackHeader['title'] }}</h2>
                    <p class="text-[13px] font-semibold text-[#34445e]">{{ $trackHeader['text'] }}</p>
                </div>
                <a href="{{ $trackHeader['href'] }}" class="hidden shrink-0 items-center gap-2 text-[13px] font-bold text-[#075fe4] sm:inline-flex">{{ $trackHeader['button'] }} <span aria-hidden="true">-&gt;</span></a>
            </div>

            <div id="careerTracks" class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($careerTracks as $track)
                    <article class="rounded-lg border border-[#dce7f8] bg-white px-4 py-5 text-center shadow-[0_6px_18px_rgba(6,25,66,0.05)]">
                        <div class="mx-auto mb-4 grid h-[58px] w-[58px] place-items-center rounded-full text-white shadow-[0_10px_20px_rgba(6,25,66,0.14)] [&>svg]:h-7 [&>svg]:w-7" style="background-color: {{ $track['color'] }}">
                            @include('components.public.icon', ['name' => $track['icon']])
                        </div>
                        <h3 class="mb-2 text-[14px] font-bold leading-tight text-[#061942]">{{ $track['title'] }}</h3>
                        <p class="mx-auto mb-3 min-h-[48px] max-w-[190px] text-[11px] font-semibold leading-4 text-[#34445e]">{{ $track['text'] }}</p>
                        <p class="mb-2 text-[11px] font-bold text-[#061942]">{{ $trackLabels['skills'] }}</p>
                        <div class="mb-4 flex min-h-[52px] flex-wrap items-start justify-center gap-2">
                            @foreach ($track['skills'] as $skill)
                                <span class="rounded-full bg-[#f2f5f9] px-2.5 py-1 text-[10px] font-semibold text-[#34445e]">{{ $skill }}</span>
                            @endforeach
                        </div>
                        <a href="{{ $trackLabels['href'] }}" class="inline-flex h-8 min-w-[132px] items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#07518f] transition hover:bg-[#f3f8ff]">{{ $trackLabels['details'] }}</a>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="mb-1 text-[18px] font-bold text-[#061942]">{{ $assessmentHeader['title'] }}</h2>
                        <p class="text-[12px] font-semibold text-[#34445e]">{{ $assessmentHeader['text'] }}</p>
                    </div>
                    <a href="{{ $assessmentHeader['href'] }}" class="hidden shrink-0 items-center gap-2 text-[12px] font-bold text-[#07518f] sm:inline-flex">{{ $assessmentHeader['button'] }} <span aria-hidden="true">-&gt;</span></a>
                </div>

                <div class="grid gap-4 xl:grid-cols-[1.18fr_28px_1fr_.78fr] xl:items-stretch">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,0.04)]">
                        <div class="mb-4">
                            <h3 class="text-[12px] font-bold text-[#061942]">{{ $assessmentCards['initial']['title'] }} <span class="font-semibold text-[#34445e]">{{ $assessmentCards['initial']['subtitle'] }}</span></h3>
                            <p class="mt-1 text-[10px] font-semibold text-[#6f7d90]">{{ $assessmentCards['initial']['date'] }}</p>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-[120px_minmax(0,1fr)] sm:items-center">
                            <div class="text-center">
                                <div class="mx-auto grid h-[92px] w-[92px] place-items-center rounded-full bg-[conic-gradient(#075fe4_0_40%,#e4e9f1_40%_100%)]">
                                    <div class="grid h-[74px] w-[74px] place-items-center rounded-full bg-[#f4f7fb] text-[23px] font-bold text-[#061942]">{{ $assessmentCards['initial']['score'] }}</div>
                                </div>
                                <p class="mt-3 text-[10px] font-bold text-[#34445e]">{{ $assessmentCards['initial']['score_label'] }}</p>
                            </div>
                            <div class="grid gap-3">
                                @foreach ($initialScores as $score)
                                    <div class="grid grid-cols-[120px_minmax(0,1fr)_34px] items-center gap-3">
                                        <span class="text-[11px] font-semibold text-[#061942]">{{ $score['label'] }}</span>
                                        <span class="h-1.5 overflow-hidden rounded-full bg-[#e6edf6]"><span class="block h-full rounded-full bg-[#075fe4]" style="width: {{ $score['value'] }}%"></span></span>
                                        <span class="text-right text-[10px] font-bold text-[#34445e]">{{ $score['value'] }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <div class="hidden items-center justify-center text-[34px] font-light text-[#9aa9bc] xl:flex" aria-hidden="true">&gt;</div>

                    <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,0.04)]">
                        <div class="mb-4">
                            <h3 class="text-[12px] font-bold text-[#061942]">{{ $assessmentCards['final']['title'] }} <span class="font-semibold text-[#34445e]">{{ $assessmentCards['final']['subtitle'] }}</span></h3>
                            <p class="mt-1 text-[10px] font-semibold text-[#6f7d90]">{{ $assessmentCards['final']['date'] }}</p>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-[120px_minmax(0,1fr)] sm:items-center">
                            <div class="text-center">
                                <div class="mx-auto grid h-[92px] w-[92px] place-items-center rounded-full bg-[#e7ebf1]">
                                    <div class="grid h-[74px] w-[74px] place-items-center rounded-full bg-[#f4f7fb] text-[23px] font-bold text-[#061942]">{{ $assessmentCards['final']['score'] }}</div>
                                </div>
                                <p class="mt-3 text-[10px] font-bold text-[#34445e]">{{ $assessmentCards['final']['score_label'] }}</p>
                            </div>
                            <div class="grid gap-3">
                                @foreach ($assessmentLabels as $label)
                                    <div class="grid grid-cols-[120px_minmax(0,1fr)_18px] items-center gap-3">
                                        <span class="text-[11px] font-semibold text-[#061942]">{{ $label }}</span>
                                        <span class="h-1.5 rounded-full bg-[#e6edf6]"></span>
                                        <span class="text-right text-[10px] font-bold text-[#9aa9bc]">{{ $assessmentCards['final']['empty_value'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <aside class="rounded-lg border border-[#f3dfb8] bg-[#fff9ed] p-5 shadow-[0_8px_18px_rgba(125,83,0,0.06)]">
                        <h3 class="mb-3 text-[13px] font-bold text-[#9a6700]">{{ $companyProfileBox['title'] }}</h3>
                        <ul class="mb-4 grid gap-3 text-[11px] font-semibold leading-4 text-[#061942]">
                            @foreach ($companyProfileBox['items'] as $item)
                                <li class="flex gap-2"><span class="font-bold text-[#1a8c62]">&#10003;</span><span><strong>{{ $item['title'] }}</strong>@if ($item['text'])<br><span class="text-[#34445e]">{{ $item['text'] }}</span>@endif</span></li>
                            @endforeach
                        </ul>
                        <a href="{{ $companyProfileBox['href'] }}" class="inline-flex h-8 min-w-[132px] items-center justify-center rounded-md border border-[#d8c8a2] bg-white px-4 text-[11px] font-bold text-[#07518f] transition hover:bg-[#f7f2e7]">{{ $companyProfileBox['button'] }}</a>
                    </aside>
                </div>
            </div>

            <div class="mt-10">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="mb-1 text-[18px] font-bold text-[#061942]">{{ $partnersHeader['title'] }}</h2>
                        <p class="text-[12px] font-semibold text-[#34445e]">{{ $partnersHeader['text'] }}</p>
                    </div>
                    <a href="{{ $partnersHeader['href'] }}" class="hidden shrink-0 items-center gap-2 text-[12px] font-bold text-[#07518f] sm:inline-flex">{{ $partnersHeader['button'] }} <span aria-hidden="true">-&gt;</span></a>
                </div>

                <div class="grid gap-4 md:grid-cols-3 xl:grid-cols-6">
                    @foreach ($partners as $partner)
                        <article class="flex min-h-[94px] flex-col items-center justify-center rounded-lg border border-[#dce7f8] bg-white px-4 py-3 text-center shadow-[0_6px_16px_rgba(6,25,66,0.04)]">
                            <div class="mb-2 flex min-h-[34px] items-center justify-center gap-1.5">
                                <span class="text-[22px] font-black leading-none" style="color: {{ $partner['color'] }}">{{ $partner['name'] }}</span>
                            </div>
                            <p class="mb-2 text-[9px] font-bold leading-none text-[#6f7d90]">{{ $partner['sub'] }}</p>
                            <p class="text-[12px] font-bold text-[#061942]">{{ $partner['score'] }} <span class="text-[#f3a51d]">★</span></p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-5 grid gap-4 rounded-lg bg-[#f8fbff] px-4 py-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($partnerBenefits as $benefit)
                        <article class="flex items-center gap-4">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full border border-[#bcd0eb] bg-white text-[#07518f] [&>svg]:h-5 [&>svg]:w-5">@include('components.public.icon', ['name' => $benefit['icon']])</span>
                            <span>
                                <strong class="block text-[11px] font-bold text-[#07518f]">{{ $benefit['title'] }}</strong>
                                <span class="block text-[10px] font-semibold text-[#34445e]">{{ $benefit['text'] }}</span>
                            </span>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white pb-8">
        <div class="mx-auto grid w-full max-w-7xl gap-8 px-5 sm:px-6 lg:px-8 xl:grid-cols-[1fr_390px]">
            <div>
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="mb-1 text-[22px] font-bold text-[#061942]">{{ $plansHeader['title'] }}</h2>
                        <p class="text-[12px] font-semibold text-[#34445e]">{{ $plansHeader['text'] }}</p>
                    </div>
                    <p class="hidden items-center gap-1.5 text-[12px] font-bold text-[#07518f] sm:flex">
                        <span class="grid h-4 w-4 place-items-center rounded-sm border border-[#9bb7dc] bg-[#edf5ff] text-[10px]">₹</span>
                        {{ $plansHeader['emi'] }}
                    </p>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($fastTrackPlans as $plan)
                        <article class="relative rounded-lg border bg-white px-5 pb-5 pt-4 text-center shadow-[0_6px_18px_rgba(6,25,66,0.05)] {{ $plan['popular'] ? 'border-[#075fe4] ring-1 ring-[#075fe4]' : 'border-[#dce7f8]' }}">
                            @if ($plan['popular'])
                                <span class="absolute left-1/2 top-0 inline-flex h-7 min-w-[116px] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#075fe4] px-4 text-[11px] font-bold text-white shadow-[0_8px_16px_rgba(7,95,228,0.2)]">{{ $planLabels['popular'] }}</span>
                            @endif
                            <h3 class="mb-2 text-[15px] font-bold text-[#061942]">{{ $plan['name'] }}</h3>
                            <p class="mx-auto mb-3 min-h-[32px] max-w-[175px] text-[11px] font-semibold leading-4 text-[#34445e]">{{ $plan['desc'] }}</p>
                            <p class="mb-1 text-[25px] font-black leading-none text-[#061942]">₹{{ $plan['price'] }}</p>
                            <p class="mb-3 text-[10px] font-bold text-[#075fe4]">{{ $planLabels['taxes'] }}</p>
                            <a href="{{ $planLabels['href'] }}" class="mb-4 inline-flex h-8 min-w-[132px] items-center justify-center rounded-md bg-[#075fe4] px-4 text-[11px] font-bold text-white shadow-[0_8px_15px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">{{ $planLabels['button'] }}</a>
                            <ul class="grid gap-2 text-left text-[11px] font-semibold text-[#061942]">
                                @foreach ($plan['items'] as $item)
                                    <li class="flex items-start gap-2"><span class="font-bold text-[#1a8c62]">✓</span><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </article>
                    @endforeach
                </div>
            </div>

            <aside class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,0.05)]">
                <h2 class="mb-4 text-[16px] font-bold text-[#061942]">{{ $faqHeader['title'] }}</h2>
                <div class="grid gap-2">
                    @foreach ($fastTrackFaqs as $faq)
                        <button type="button" class="flex h-10 w-full items-center justify-between rounded-md border border-[#e7eef8] bg-white px-3 text-left text-[12px] font-bold text-[#07518f]">
                            <span>{{ $faq }}</span>
                            <span class="text-[#6f7d90]">⌄</span>
                        </button>
                    @endforeach
                </div>
                <a href="{{ $faqHeader['href'] }}" class="mt-4 inline-flex h-10 w-full items-center justify-center rounded-md border border-[#cfdceb] bg-white px-4 text-[12px] font-bold text-[#07518f] transition hover:bg-[#f3f8ff]">{{ $faqHeader['button'] }}</a>
            </aside>
        </div>
    </section>

    <section class="bg-white pb-[55px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl border border-[#cfe0ff] bg-[linear-gradient(135deg,#eef5ff,#f8fbff)] px-5 py-7 text-center shadow-[0_20px_44px_rgba(7,95,228,0.11)] sm:px-8">
                <span class="pointer-events-none absolute -left-16 -top-20 h-44 w-44 rounded-full bg-[#dcecff]/80 blur-3xl"></span>
                <span class="pointer-events-none absolute -right-16 -bottom-20 h-48 w-48 rounded-full bg-[#cfe4ff]/80 blur-3xl"></span>
                <div class="relative mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($points as $point)
                        <div class="group flex min-h-[96px] items-center gap-4 rounded-xl border border-white/80 bg-white/72 p-4 text-left text-[15px] font-bold text-[#061942] shadow-[inset_0_1px_0_rgba(255,255,255,0.95),0_12px_24px_rgba(7,95,228,0.08)] backdrop-blur transition hover:-translate-y-0.5 hover:shadow-[inset_0_1px_0_rgba(255,255,255,0.95),0_18px_32px_rgba(7,95,228,0.13)]">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[linear-gradient(135deg,#075fe4,#17a6a8)] text-white shadow-[0_10px_20px_rgba(7,95,228,0.2)] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $point['icon']])</span>
                            <span>{{ $point['text'] }}</span>
                        </div>
                    @endforeach
                </div>

                <a href="/fast-track/register" class="relative inline-flex h-12 items-center justify-center rounded-xl bg-[#075fe4] px-8 text-sm font-bold text-white shadow-[0_14px_28px_rgba(7,95,228,0.24)] transition hover:-translate-y-0.5 hover:bg-[#0554cc]">
                    Start Your Fast Track Journey ->
                </a>
            </div>
        </div>
    </section>
    </main>
@endsection

@push('scripts')
<script>
    const fastTrackStats = document.getElementById('fastTrackStats');
    const careerTracks = document.getElementById('careerTracks');

    function esc(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char]);
    }

    function dataOf(result, key) {
        return result && result.data ? (key ? result.data[key] : result.data) : result;
    }

    function initials(value) {
        return String(value || 'FT').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'FT';
    }

    async function getJson(url) {
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Request failed');
        return result;
    }

    function skillTags(course) {
        return String(course.skills_covered || course.category || '').split(/[,|]/).map((skill) => skill.trim()).filter(Boolean).slice(0, 4);
    }

    function renderStats(courses, partners, jobs) {
        const icons = {
            courses: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
            partners: '<svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><path d="M14 8h7M14 12h7M14 16h5"></path></svg>',
            jobs: '<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="13" rx="2"></rect><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M4 13h16"></path></svg>',
        };
        fastTrackStats.innerHTML = [
            [icons.courses, 'Active Courses', courses.length],
            [icons.partners, 'Training Partners', partners.length],
            [icons.jobs, 'Fast Track Jobs', jobs.length],
        ].map((item) => `<article class="group relative overflow-hidden rounded-xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#edf5ff)] p-4 shadow-[0_14px_30px_rgba(7,95,228,0.11)] transition hover:-translate-y-0.5 hover:shadow-[0_18px_36px_rgba(7,95,228,0.16)]">
            <span class="pointer-events-none absolute inset-x-0 bottom-0 h-1 bg-[#075fe4]"></span>
            <span class="pointer-events-none absolute -right-7 -top-8 h-24 w-24 rounded-full bg-[#d7e8ff]/80 blur-2xl"></span>
            <span class="relative flex items-center justify-between gap-3">
                <span class="inline-grid h-12 w-12 place-items-center rounded-xl border border-[#cfe0ff] bg-white text-[#075fe4] shadow-[0_8px_16px_rgba(7,95,228,0.08)] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${item[0]}</span>
                <strong class="font-['Inter'] text-4xl font-semibold leading-none text-[#061942]">${item[2]}</strong>
            </span>
            <span class="relative mt-4 block text-sm font-semibold text-[#34445e]">${item[1]}</span>
        </article>`).join('');
    }

    function renderTracks(courses) {
        if (!courses.length) {
            careerTracks.innerHTML = '<article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">No active Fast Track courses found.</article>';
            return;
        }

        careerTracks.innerHTML = courses.slice(0, 6).map((course, index) => {
            const partner = course.training_partner_profile || {};
            const iconClasses = ['bg-[#eff5ff] text-[#075fe4]', 'bg-[#eafaf8] text-[#17a6a8]', 'bg-[#fff0e2] text-[#f37a22]'][index % 3];
            const tags = skillTags(course);
            return `<article class="group relative overflow-hidden rounded-2xl border border-[#cfe0ff] bg-[linear-gradient(145deg,#ffffff,#f7fbff)] p-6 shadow-[0_16px_34px_rgba(7,95,228,0.08)] transition hover:-translate-y-1 hover:border-[#9fc0f8] hover:shadow-[0_24px_46px_rgba(7,95,228,0.14)]">
                <span class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-[linear-gradient(90deg,#075fe4,#17a6a8)]"></span>
                <span class="pointer-events-none absolute -right-12 -top-16 h-36 w-36 rounded-full bg-[#dcecff]/80 blur-2xl transition group-hover:bg-[#cfe4ff]"></span>
                <div class="relative flex items-start gap-5">
                    <div class="flex h-[78px] w-[78px] shrink-0 items-center justify-center rounded-2xl ${iconClasses} text-2xl font-black shadow-[inset_0_0_0_1px_rgba(255,255,255,0.7),0_12px_24px_rgba(7,95,228,0.08)]">${esc(initials(course.course_name))}</div>
                    <div class="min-w-0 flex-1">
                        <h3 class="mb-2 font-['Inter'] text-xl font-semibold leading-snug text-[#061942]">${esc(course.course_name || 'Fast Track Course')}</h3>
                        <p class="mb-3 text-xs font-bold uppercase tracking-[.7px] text-[#075fe4]">${esc(partner.institute_name || 'Training Partner')}</p>
                        <p class="mb-4 text-sm font-semibold leading-[1.65] text-[#34445e]">${esc(course.description || 'Industry-ready training for freshers.')}</p>
                    </div>
                </div>
                <div class="relative mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full border border-[#dce7f8] bg-white px-3 py-1.5 text-xs font-semibold text-[#34445e]">${esc(course.duration || 'Flexible Duration')}</span>
                    <span class="rounded-full border border-[#dce7f8] bg-white px-3 py-1.5 text-xs font-semibold text-[#34445e]">${esc(course.mode || 'Online')}</span>
                    <span class="rounded-full border border-[#dce7f8] bg-white px-3 py-1.5 text-xs font-semibold text-[#34445e]">${course.certificate_available ? 'Certificate' : 'Fast Track'}</span>
                </div>
                <div class="relative mt-4 flex flex-wrap gap-2">
                    ${tags.length ? tags.map((tag) => `<span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(tag)}</span>`).join('') : `<span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(course.category || 'Fast Track')}</span>`}
                </div>
                <div class="relative mt-5 flex items-center justify-between gap-4">
                    <span class="font-['Inter'] text-lg font-semibold text-[#061942]">${esc(course.fees ? '₹' + course.fees : 'Fast Track')}</span>
                    <a href="/courses/show?course=${esc(course.id)}" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">View Details</a>
                </div>
            </article>`;
        }).join('');
    }

    Promise.all([
        getJson('/api/courses'),
        getJson('/api/training-partners?per_page=100'),
        getJson('/api/jobs?hiring_mode=fast_track'),
    ]).then(([coursesResult, partnersResult, jobsResult]) => {
        const courses = dataOf(coursesResult, 'courses') || [];
        const partnersPage = dataOf(partnersResult, 'training_partners') || {};
        const partners = Array.isArray(partnersPage) ? partnersPage : (partnersPage.data || []);
        const jobs = dataOf(jobsResult, 'jobs') || [];
        renderStats(courses, partners, jobs);
    }).catch((error) => {
        console.warn(error.message || 'Fast Track data load nahi ho paaya.');
    });
</script>
@endpush
