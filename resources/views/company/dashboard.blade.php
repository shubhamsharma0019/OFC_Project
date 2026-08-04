@extends('layouts.company')

@section('title', 'Company Dashboard - OnlyFreshers')

@section('pageTitle', 'Company Dashboard')

@section(
    'pageSubtitle',
    'Overview of your hiring activities and company updates.'
)

@php
    $activePage = 'dashboard';

    $stats = [
        [
            'label' => 'Jobs Posted',
            'value' => '31',
            'link' => 'View all',
            'icon' => 'briefcase',
            'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
        ],
        [
            'label' => 'Applications',
            'value' => '56',
            'link' => 'View all',
            'icon' => 'users',
            'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
        ],
        [
            'label' => 'Shortlisted',
            'value' => '12',
            'link' => 'View all',
            'icon' => 'star',
            'iconClasses' => 'bg-[#fff5e6] text-[#ff9c22]',
        ],
        [
            'label' => 'Interviews',
            'value' => '5',
            'link' => 'View all',
            'icon' => 'calendar',
            'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
        ],
        [
            'label' => 'Hired',
            'value' => '3',
            'link' => 'View all',
            'icon' => 'user-check',
            'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
        ],
    ];

    $activities = [
        [
            'title' => 'New application received for UI/UX Designer',
            'time' => '2 min ago',
            'icon' => 'briefcase',
            'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
        ],
        [
            'title' => '3 candidates shortlisted for React Developer',
            'time' => '1 hour ago',
            'icon' => 'user',
            'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
        ],
        [
            'title' => 'Interview scheduled with Rohit Kumar',
            'time' => '3 hours ago',
            'icon' => 'calendar',
            'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
        ],
        [
            'title' => 'Anjali Verma hired for UI/UX Designer',
            'time' => '1 day ago',
            'icon' => 'user-check',
            'iconClasses' => 'bg-[#fff5e6] text-[#ff9c22]',
        ],
        [
            'title' => 'Invoice generated for Premium Plan',
            'time' => '2 days ago',
            'icon' => 'file',
            'iconClasses' => 'bg-[#fff0f5] text-[#ef3061]',
        ],
    ];

    $quickActions = [
        [
            'title' => 'Post a New Job',
            'text' => 'Find the best talent for your company',
            'icon' => 'briefcase',
            'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
        ],
        [
            'title' => 'View Applications',
            'text' => 'Review candidates who applied',
            'icon' => 'users',
            'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
        ],
        [
            'title' => 'Shortlist Candidates',
            'text' => 'Pick the best matches',
            'icon' => 'star',
            'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
        ],
        [
            'title' => 'Schedule Interview',
            'text' => 'Connect with candidates',
            'icon' => 'calendar',
            'iconClasses' => 'bg-[#fff5e6] text-[#ff9c22]',
        ],
    ];
@endphp

@section('content')

    {{-- Welcome card --}}
    <section
        class="mb-5 min-h-[170px] rounded-lg border border-[#dce7f8]
               bg-white px-5 py-[30px]
               shadow-[0_10px_24px_rgba(6,25,66,0.04)]
               sm:px-8 sm:py-12"
    >
        <h2 class="mb-2.5 text-[22px] font-bold leading-tight text-[#061942]">
            Welcome back,

            <strong class="block text-[27px] font-bold sm:text-[28px]">
                TechNova Solutions 👋
            </strong>
        </h2>

        <p class="text-sm text-[#34445e]">
            Here's what's happening today.
        </p>
    </section>

    {{-- Statistics --}}
    <section
        class="mb-[22px] grid grid-cols-1 gap-5
               md:grid-cols-2
               xl:grid-cols-5"
    >
        @foreach ($stats as $stat)
            <article
                class="flex min-h-[142px] min-w-0 items-center justify-center gap-[18px]
                       rounded-lg border border-[#dce7f8] bg-white p-[22px]
                       shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
            >
                <div
                    class="flex h-[58px] w-[58px] shrink-0 items-center justify-center
                           rounded-full {{ $stat['iconClasses'] }}"
                >
                    <div
                        class="h-7 w-7
                               [&>svg]:h-full [&>svg]:w-full
                               [&>svg]:fill-none
                               [&>svg]:stroke-current
                               [&>svg]:stroke-2
                               [&>svg]:[stroke-linecap:round]
                               [&>svg]:[stroke-linejoin:round]"
                    >
                        @include('components.company.icon', [
                            'icon' => $stat['icon'],
                        ])
                    </div>
                </div>

                <div class="min-w-0">
                    <h3 class="mb-[5px] text-[25px] font-bold text-[#061942]">
                        {{ $stat['value'] }}
                    </h3>

                    <p class="mb-[15px] text-xs text-[#34445e]">
                        {{ $stat['label'] }}
                    </p>

                    <a
                        href="{{ match($stat['label']) { 'Jobs Posted' => '/company/jobs', 'Applications' => '/company/applications', 'Shortlisted' => '/company/shortlisted', 'Interviews' => '/company/interviews', 'Hired' => '/company/hired', default => '/company/dashboard' } }}" class="text-xs font-bold text-[#075fe4]
                               hover:underline"
                    >
                        {{ $stat['link'] }}
                    </a>
                </div>
            </article>
        @endforeach
    </section>

    {{-- Bottom content --}}
    <section
        class="grid grid-cols-1 gap-5
               xl:grid-cols-[1.1fr_0.9fr]"
    >
        {{-- Recent activities --}}
        <div
            class="min-w-0 rounded-lg border border-[#dce7f8] bg-white p-6
                   shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
        >
            <h2 class="mb-[18px] text-lg font-bold text-[#061942]">
                Recent Activities
            </h2>

            <div>
                @foreach ($activities as $activity)
                    <div
                        class="grid grid-cols-[42px_minmax(0,1fr)] items-center gap-x-[18px]
                               border-b border-[#edf2fb] px-2 py-[11px]
                               last:border-b-0
                               sm:grid-cols-[48px_minmax(0,1fr)_auto]"
                    >
                        <div
                            class="flex h-[42px] w-[42px] items-center justify-center
                                   rounded-[9px] {{ $activity['iconClasses'] }}"
                        >
                            <div
                                class="h-5 w-5
                                       [&>svg]:h-full [&>svg]:w-full
                                       [&>svg]:fill-none
                                       [&>svg]:stroke-current
                                       [&>svg]:stroke-2
                                       [&>svg]:[stroke-linecap:round]
                                       [&>svg]:[stroke-linejoin:round]"
                            >
                                @include('components.company.icon', [
                                    'icon' => $activity['icon'],
                                ])
                            </div>
                        </div>

                        <h3 class="text-xs font-bold text-[#061942]">
                            {{ $activity['title'] }}
                        </h3>

                        <time
                            class="col-start-2 whitespace-nowrap text-xs text-[#34445e]
                                   sm:col-start-auto"
                        >
                            {{ $activity['time'] }}
                        </time>
                    </div>
                @endforeach
            </div>

            <a href="/company/notifications" class="mx-auto mt-[22px] flex h-[42px] w-[170px] items-center justify-center rounded-lg border border-[#bfd4f5] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">View All Activities</a>
        </div>

        {{-- Quick actions --}}
        <div
            class="min-w-0 rounded-lg border border-[#dce7f8] bg-white p-6
                   shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
        >
            <h2 class="mb-[18px] text-lg font-bold text-[#061942]">
                Quick Actions
            </h2>

            <div class="grid gap-3">
                @foreach ($quickActions as $action)
                    <a
                        href="{{ match($action['title']) { 'Post a New Job' => '/company/post-job', 'View Applications' => '/company/applications', 'Shortlist Candidates' => '/company/shortlisted', 'Schedule Interview' => '/company/interviews/create', default => '/company/dashboard' } }}" class="grid min-h-[76px]
                               grid-cols-[52px_minmax(0,1fr)_auto]
                               items-center gap-4 rounded-lg
                               border border-[#dce7f8] bg-white
                               px-[18px] py-[13px]
                               shadow-[0_10px_24px_rgba(6,25,66,0.04)]
                               transition
                               hover:-translate-y-0.5
                               hover:border-[#bfd4f5]
                               hover:shadow-[0_12px_28px_rgba(6,25,66,0.08)]"
                    >
                        <div
                            class="flex h-[58px] w-[58px] shrink-0 items-center justify-center
                                   rounded-full {{ $action['iconClasses'] }}"
                        >
                            <div
                                class="h-7 w-7
                                       [&>svg]:h-full [&>svg]:w-full
                                       [&>svg]:fill-none
                                       [&>svg]:stroke-current
                                       [&>svg]:stroke-2
                                       [&>svg]:[stroke-linecap:round]
                                       [&>svg]:[stroke-linejoin:round]"
                            >
                                @include('components.company.icon', [
                                    'icon' => $action['icon'],
                                ])
                            </div>
                        </div>

                        <div class="min-w-0">
                            <h3 class="mb-[5px] text-[13px] font-bold text-[#061942]">
                                {{ $action['title'] }}
                            </h3>

                            <p class="text-xs text-[#34445e]">
                                {{ $action['text'] }}
                            </p>
                        </div>

                        <span class="text-[30px] leading-none text-[#061942]">
                            &#8250;
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

@endsection
