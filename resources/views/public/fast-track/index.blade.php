@extends('layouts.public')

@section('title', 'Fast Track Program - OnlyFreshers')

@php
    $activePage = 'fast-track';

    $steps = [
        ['number' => 1, 'icon' => 'document', 'title' => 'Initial Assessment', 'text' => 'Evaluate your skills and career goals.'],
        ['number' => 2, 'icon' => 'target', 'title' => 'Recommended Career Track', 'text' => 'Get a personalized career track.'],
        ['number' => 3, 'icon' => 'training', 'title' => 'Training with Partners', 'text' => 'Learn from verified training partners.'],
        ['number' => 4, 'icon' => 'check', 'title' => 'Final Assessment', 'text' => 'Prove your skills with assessment.'],
        ['number' => 5, 'icon' => 'certificate', 'title' => 'Certificate', 'text' => 'Earn your certificate of completion.'],
        ['number' => 6, 'icon' => 'briefcase', 'title' => 'Get Hired', 'text' => 'Apply to top companies and start.'],
    ];

    $tracks = [
        [
            'icon' => 'code',
            'iconClass' => 'bg-[#eff5ff] text-[#075fe4]',
            'title' => 'Full Stack Development',
            'text' => 'Build end-to-end web applications and modern solutions.',
            'tags' => ['HTML', 'CSS', 'JavaScript', 'React'],
        ],
        [
            'icon' => 'data',
            'iconClass' => 'bg-[#eafaf8] text-[#17a6a8]',
            'title' => 'Data Science & Analytics',
            'text' => 'Turn data into insights and build intelligent solutions.',
            'tags' => ['Python', 'SQL', 'Machine Learning'],
        ],
        [
            'icon' => 'marketing',
            'iconClass' => 'bg-[#fff0e2] text-[#f37a22]',
            'title' => 'Digital Marketing',
            'text' => 'Grow brands and businesses in the digital world.',
            'tags' => ['SEO', 'Google Ads', 'Social Media'],
        ],
    ];

    $points = [
        ['icon' => 'learn', 'text' => 'Industry-relevant learning'],
        ['icon' => 'users', 'text' => 'Expert training partners'],
        ['icon' => 'certificate', 'text' => 'Final assessment & certificate'],
        ['icon' => 'briefcase', 'text' => 'Better job opportunities'],
    ];
@endphp

@section('content')
    <section class="bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-10 lg:py-[55px]">
        <div class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-2 lg:gap-[50px] lg:px-8">
            <div class="text-center lg:text-left">
                <h1 class="m-0 text-[40px] font-semibold leading-[1.08] text-[#061942] sm:text-5xl lg:text-[54px]">
                    Fast Track <span class="text-[#075fe4]">Program</span>
                </h1>
                <p class="mt-[18px] max-w-2xl text-lg font-medium leading-[1.7] text-[#34445e] lg:text-[19px]">
                    Learn in-demand skills, get trained by verified partners, and become job-ready.
                </p>
            </div>

            <div class="flex min-h-[240px] items-center justify-center lg:min-h-[260px]">
                @if (file_exists(public_path('study.svg')))
                    <img src="{{ asset('study.svg') }}" alt="Fast Track Study" class="block h-[240px] w-full max-w-[520px] object-contain sm:h-[260px]">
                @else
                    <div class="flex h-[240px] w-full max-w-[520px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-5xl font-bold text-[#075fe4] shadow-[0_18px_40px_rgba(6,25,66,0.06)] sm:h-[260px]">
                        FT
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white py-9 lg:py-[45px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid gap-5 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:grid-cols-2 lg:grid-cols-6 lg:p-7">
                @foreach ($steps as $step)
                    <article class="text-center">
                        <div class="mx-auto mb-3.5 flex h-[65px] w-[65px] items-center justify-center rounded-full border border-[#dce7f8] bg-[#eff5ff] text-[#075fe4] [&>svg]:h-7 [&>svg]:w-7">
                            @include('components.public.icon', ['name' => $step['icon']])
                        </div>
                        <h3 class="mb-2 text-sm font-semibold text-[#061942]">
                            <span class="mr-1.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#075fe4] text-xs text-white">{{ $step['number'] }}</span>{{ $step['title'] }}
                        </h3>
                        <p class="text-[13px] font-medium leading-[1.6] text-[#34445e]">{{ $step['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white pb-10">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <h2 class="mb-5 text-center text-2xl font-semibold text-[#061942]">Explore Career Tracks</h2>

            <div class="grid gap-[22px] lg:grid-cols-3">
                @foreach ($tracks as $track)
                    <article class="flex flex-col gap-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] sm:flex-row lg:flex-col xl:flex-row">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[14px] {{ $track['iconClass'] }} [&>svg]:h-8 [&>svg]:w-8">
                            @include('components.public.icon', ['name' => $track['icon']])
                        </div>
                        <div class="min-w-0">
                            <h3 class="mb-2 text-lg font-semibold text-[#061942]">{{ $track['title'] }}</h3>
                            <p class="mb-3 text-sm font-medium leading-[1.6] text-[#34445e]">{{ $track['text'] }}</p>
                            <div class="mb-3.5 flex flex-wrap gap-2">
                                @foreach ($track['tags'] as $tag)
                                    <span class="rounded-md bg-[#dbeafe] px-3 py-1.5 text-xs font-bold text-[#075fe4]">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <a href="#" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">View Details</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white pb-[55px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-[#dce7f8] bg-[#eaf2ff] px-5 py-[22px] text-center sm:px-10">
                <div class="mb-5 grid gap-[22px] sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($points as $point)
                        <div class="flex items-center gap-3 text-left text-[15px] font-bold text-[#061942]">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6">@include('components.public.icon', ['name' => $point['icon']])</span>
                            <span>{{ $point['text'] }}</span>
                        </div>
                    @endforeach
                </div>

                <a href="#" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">
                    Start Your Fast Track Journey ->
                </a>
            </div>
        </div>
    </section>
@endsection