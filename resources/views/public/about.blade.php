@extends('layouts.public')

@section('title', $aboutMeta['page_title'])

@php
    $activePage = $aboutMeta['active_page'];
@endphp

@section('content')
    <section class="relative overflow-hidden bg-[linear-gradient(90deg,#fbfdff_0%,#ffffff_36%,#f4f9ff_64%,#e8f3ff_100%)] pb-[108px] pt-8">
        <div class="pointer-events-none absolute -left-28 -top-28 h-[260px] w-[260px] rounded-full border-[34px] border-[#dcecff]/60"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-[58%] bg-[radial-gradient(circle_at_76%_43%,rgba(207,228,255,0.78)_0%,rgba(226,240,255,0.58)_34%,rgba(255,255,255,0)_68%)] lg:block"></div>
        <div class="pointer-events-none absolute right-[8%] top-8 hidden h-[260px] w-[260px] rounded-full border border-white/75 bg-[#dcecff]/32 lg:block"></div>
        <div class="pointer-events-none absolute right-[36%] top-[74px] hidden h-[92px] w-[120px] opacity-35 [background-image:radial-gradient(#8db5ef_1px,transparent_1px)] [background-size:12px_12px] lg:block"></div>
        <div class="relative mx-auto grid w-full max-w-7xl items-center gap-5 px-5 text-center sm:px-6 lg:min-h-[270px] lg:grid-cols-[0.82fr_1.18fr] lg:gap-2 lg:px-8 lg:text-left">
            <div class="relative z-10 pb-2 lg:pl-4">
                <h1 class="m-0 font-['Inter'] text-[32px] font-semibold leading-[1.08] text-[#061942] sm:text-[42px] lg:text-[46px]">
                    {{ $aboutHero['title'] }} <span class="text-[#075fe4]">{{ $aboutHero['highlight'] }}</span>
                </h1>
                <p class="mx-auto mt-4 max-w-[520px] text-[15px] font-medium leading-[1.75] text-[#1e2f4d] sm:text-base lg:mx-0">
                    {{ $aboutHero['text'] }}
                </p>
            </div>

            <div class="relative z-10 flex min-h-[225px] items-end justify-center overflow-visible lg:min-h-[270px] lg:justify-end">
                <img src="{{ asset($aboutHero['image']) }}" alt="{{ $aboutHero['highlight'] }}" class="block h-auto max-h-[285px] w-full max-w-[660px] object-contain object-bottom lg:mr-[-24px] lg:max-h-[300px] xl:mr-[-42px]">
            </div>
        </div>
    </section>

    <section class="relative z-10 bg-white pb-12 pt-0 lg:-mt-[74px] lg:pb-[45px]">
        <div class="mx-auto w-full max-w-[1240px] px-5 sm:px-6 lg:px-8">
            <div class="grid gap-7 lg:grid-cols-[repeat(3,minmax(0,350px))] lg:justify-center lg:gap-10 xl:gap-12">
                @foreach ($infoCards as $card)
                    <article class="flex min-h-[116px] min-w-0 flex-col gap-4 rounded-[14px] border border-[#dbe8fb] bg-white/95 p-5 shadow-[0_16px_40px_rgba(7,95,228,0.12)] backdrop-blur sm:flex-row sm:items-center sm:gap-5">
                        <div class="flex h-[68px] w-[68px] shrink-0 items-center justify-center rounded-full border border-[#d6e6ff] bg-[#eff6ff] text-[#075fe4] shadow-[inset_0_0_0_6px_rgba(255,255,255,0.78),0_10px_22px_rgba(7,95,228,0.12)] [&>svg]:h-8 [&>svg]:w-8">
                            @include('components.public.icon', ['name' => $card['icon']])
                        </div>
                        <div class="min-w-0">
                            <h2 class="mb-2 text-base font-semibold text-[#061942]">{{ $card['title'] }}</h2>
                            <p class="text-xs font-medium leading-[1.7] text-[#24344f]">{{ $card['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-[42px] text-center">
                <h2 class="text-2xl font-semibold text-[#061942]">{{ $helpTitle }}</h2>
                <div class="mx-auto mt-2.5 {{ $aboutDecor['help_divider'] }} rounded-full {{ $aboutDecor['divider_color'] }}"></div>
            </div>

            <div class="mt-6 grid gap-[22px] lg:grid-cols-2">
                @foreach ($helpCards as $card)
                    <article class="flex flex-col gap-6 rounded-lg border {{ $card['classes'] }} p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row sm:items-center sm:gap-7">
                        <div class="flex h-[74px] w-[74px] shrink-0 items-center justify-center rounded-full {{ $card['iconClasses'] }} [&>svg]:h-8 [&>svg]:w-8">@include('components.public.icon', ['name' => $card['icon']])</div>
                        <div>
                            <h3 class="mb-[9px] text-lg font-semibold text-[#061942]">{{ $card['title'] }}</h3>
                            <ul class="list-disc space-y-1.5 pl-[18px] text-sm font-medium leading-[1.9] text-[#24344f] marker:text-[#075fe4]">
                                @foreach ($card['points'] as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-[42px] text-center">
                <h2 class="text-xl font-semibold text-[#061942]">{{ $trustTitle }}</h2>
                <div class="mx-auto mt-2 {{ $aboutDecor['trust_divider'] }} rounded-full {{ $aboutDecor['divider_color'] }}"></div>
            </div>

            <div class="mx-auto mt-5 grid max-w-[1120px] gap-5 lg:grid-cols-3">
                @foreach ($trustCards as $card)
                    <article class="flex min-h-[92px] flex-col gap-4 rounded-[10px] border border-[#dce7f8] bg-white px-5 py-4 shadow-[0_12px_28px_rgba(7,95,228,0.08)] sm:flex-row sm:items-center">
                        <div class="flex h-[58px] w-[58px] shrink-0 items-center justify-center rounded-full border border-[#d6e6ff] bg-[#f0f6ff] text-[#075fe4] shadow-[inset_0_0_0_5px_rgba(255,255,255,0.82),0_8px_18px_rgba(7,95,228,0.1)] [&>svg]:h-7 [&>svg]:w-7">
                            @include('components.public.icon', ['name' => $card['icon']])
                        </div>
                        <div class="min-w-0">
                            <h3 class="mb-1.5 text-sm font-semibold text-[#061942]">{{ $card['title'] }}</h3>
                            <p class="text-xs font-medium leading-[1.65] text-[#24344f]">{{ $card['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
