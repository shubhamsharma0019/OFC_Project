@extends('layouts.fast-track')

@section('title', 'Dashboard - Fast Track')

@php
    $activePage = 'dashboard';
    $fastTrackSteps = [
        ['step' => '1', 'title' => 'Enroll', 'text' => 'Choose your track', 'icon' => 'learn', 'color' => '#25ad82'],
        ['step' => '2', 'title' => 'Initial Assessment', 'text' => 'Evaluate your current skills', 'icon' => 'target', 'color' => '#075fe4'],
        ['step' => '3', 'title' => 'Training', 'text' => 'Learn from our training partners', 'icon' => 'training', 'color' => '#cbd5e1'],
        ['step' => '4', 'title' => 'Final Assessment', 'text' => 'Showcase improved skills', 'icon' => 'chart', 'color' => '#cbd5e1'],
        ['step' => '5', 'title' => 'Certification', 'text' => 'Get certified & job ready', 'icon' => 'certificate', 'color' => '#cbd5e1'],
        ['step' => '6', 'title' => 'Get Hired', 'text' => 'Companies get your profile', 'icon' => 'users', 'color' => '#cbd5e1'],
    ];
    $careerTracks = [
        ['title' => 'Software Development', 'text' => 'Build your career in coding and software development.', 'icon' => 'code', 'color' => '#2563eb', 'skills' => ['Python', 'DSA', 'SQL', 'Git']],
        ['title' => 'Data Science & Analytics', 'text' => 'Become a data expert and work with real-world data.', 'icon' => 'data', 'color' => '#2fbf9b', 'skills' => ['Python', 'SQL', 'Excel', 'Power BI']],
        ['title' => 'Digital Marketing', 'text' => 'Learn digital strategies and grow brands online.', 'icon' => 'marketing', 'color' => '#f59a23', 'skills' => ['SEO', 'SEM', 'SMM', 'Analytics']],
        ['title' => 'Business & Finance', 'text' => 'Build a career in finance, analytics and management.', 'icon' => 'briefcase', 'color' => '#8239d7', 'skills' => ['Accounting', 'Excel', 'Modeling']],
        ['title' => 'Cloud Computing', 'text' => 'Learn cloud technologies and services.', 'icon' => 'cloud', 'color' => '#1f73ea', 'skills' => ['AWS', 'Azure', 'Linux', 'DevOps']],
    ];
    $partners = [
        ['name' => 'EXCELR', 'sub' => 'Raising Excellence', 'score' => '4.6', 'color' => '#176aa6'],
        ['name' => 'ENLITE', 'sub' => 'INSTITUTE', 'score' => '4.5', 'color' => '#111827'],
        ['name' => 'iNeuron', 'sub' => 'Intelligence Pathway', 'score' => '4.7', 'color' => '#2f64b2'],
        ['name' => 'Besant', 'sub' => 'Technologies', 'score' => '4.5', 'color' => '#176aa6'],
    ];
@endphp

@push('styles')
<style>
    .dashboard-chart-card {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #ffffff;
        min-height: 242px;
        padding: 22px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    .dashboard-panel {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    .dashboard-stat-card {
        min-height: 150px;
    }

    .dashboard-chart-card svg {
        display: block;
        width: 100%;
        min-height: 190px;
    }

    .quick-action-card {
        display: flex;
        min-height: 124px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #ffffff;
        padding: 14px;
        color: #061942;
        text-align: center;
        text-decoration: none;
        transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-1px);
        border-color: #9fc1f8;
        box-shadow: 0 14px 28px rgba(6, 25, 66, .08);
    }

    .quick-action-card.is-done {
        border-color: #bcebd0;
        background: #f4fff8;
    }

    .quick-action-card .action-status {
        display: inline-flex;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .latest-training-panel {
        border: 1px solid #cfe0f7;
        border-radius: 8px;
        background: linear-gradient(135deg, #ffffff 0%, #eef6ff 100%);
        box-shadow: 0 10px 24px rgba(6, 25, 66, .04);
    }

    .fast-track-dashboard-shell {
        margin-inline: auto;
        width: 100%;
        max-width: 1180px;
    }

    .dashboard-welcome-card {
        align-items: stretch;
    }

    @media (min-width: 1024px) {
        .fast-track-program-step .fast-track-step-line {
            left: 50% !important;
            top: 24px !important;
            width: 100% !important;
        }
    }

    @media (min-width: 1280px) {
        .dashboard-main-grid {
            grid-template-columns: minmax(0, 1fr) minmax(360px, .82fr);
        }
    }

    @media (max-width: 767px) {
        .dashboard-chart-card,
        .dashboard-panel {
            padding: 18px;
        }
    }

    @media (max-width: 640px) {
        .fast-track-dashboard-shell,
        .fast-track-dashboard-shell * {
            min-width: 0;
            max-width: 100%;
            box-sizing: border-box;
        }

        .fast-track-dashboard-shell {
            overflow-x: hidden;
        }

        .fast-track-dashboard-shell h1 {
            font-size: 24px !important;
            line-height: 1.15 !important;
        }

        .fast-track-dashboard-shell h2 {
            font-size: 20px !important;
            line-height: 1.2 !important;
        }

        .dashboard-welcome-card {
            padding: 16px !important;
            text-align: center;
        }

        #dashboardProfileAvatar {
            margin-left: auto;
            margin-right: auto;
            height: 74px !important;
            width: 74px !important;
        }

        #welcomeName {
            font-size: 22px !important;
        }

        #dashboardProfileLocation {
            justify-content: center;
        }

        .fast-track-program-panel {
            padding: 16px !important;
        }

        #fastTrackProgramSteps {
            gap: 14px !important;
        }

        .fast-track-program-step {
            display: grid !important;
            grid-template-columns: 48px minmax(0, 1fr);
            align-items: start;
            border: 1px solid #dce7f8;
            border-radius: 10px;
            background: #fff;
            padding: 12px;
            text-align: left !important;
        }

        .fast-track-step-marker {
            height: 42px !important;
            width: 42px !important;
        }

        .fast-track-program-step p {
            max-width: none !important;
        }

        .fast-track-section-head {
            flex-direction: column;
            align-items: stretch !important;
        }

        .fast-track-section-head a {
            display: inline-flex !important;
            width: 100%;
            justify-content: center;
            border: 1px solid #9fc1f8;
            border-radius: 8px;
            padding: 10px 12px;
        }

        #dynamicCareerTracks {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        #dynamicCareerTracks article {
            padding: 16px !important;
        }

        .fast-track-current-program,
        .fast-track-assessment-summary,
        .fast-track-partners-grid,
        .fast-track-benefits-grid {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        .fast-track-current-program > *,
        .fast-track-assessment-summary > *,
        .fast-track-partners-grid > *,
        .fast-track-benefits-grid > * {
            border-left: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #programProgressRows > div,
        .fast-track-timeline-row,
        .fast-track-score-row {
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 6px !important;
            align-items: start !important;
        }

        .fast-track-dashboard-shell [class*="grid-cols-["] {
            grid-template-columns: minmax(0, 1fr) !important;
        }

        .fast-track-dashboard-shell [class*="min-w-["] {
            min-width: 0 !important;
        }

        .fast-track-dashboard-shell a[class*="h-"],
        .fast-track-dashboard-shell button[class*="h-"] {
            min-height: 38px;
            height: auto;
        }
    }
</style>
@endpush

@section('content')
    <section class="fast-track-dashboard-shell space-y-5">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Dashboard</h1>
        </div>

        <article class="dashboard-welcome-card flex flex-col gap-5 rounded-lg border border-[#dbe8f8] bg-[#fbfdff] px-5 py-5 shadow-[0_10px_24px_rgba(6,25,66,.035)] md:flex-row md:items-center md:px-6">
            <div
                id="dashboardProfileAvatar"
                class="grid h-[88px] w-[88px] shrink-0 place-items-center overflow-hidden rounded-full border-2 border-white bg-gradient-to-br from-[#1769ff] to-[#17a6a8] bg-cover bg-center text-2xl font-black text-white shadow-[0_10px_22px_rgba(6,25,66,.14)]"
                aria-hidden="true"
            >
                FT
            </div>

            <div class="min-w-0 flex-1">
                <p class="mb-1 text-sm font-bold leading-tight text-[#061942]">Welcome,</p>
                <h2 id="welcomeName" class="mb-3 break-words text-[26px] font-black leading-tight text-[#061942]">Fresher</h2>

                <div class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-[#075fe4]">
                    <span class="grid h-4 w-4 place-items-center rounded-full bg-[#075fe4] text-white">
                        <svg class="h-3 w-3 fill-none stroke-current stroke-[3] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m5 12 4 4L19 6"></path>
                        </svg>
                    </span>
                    Verified Fresher
                </div>

                <p id="dashboardProfileCourse" class="mb-2 text-sm font-extrabold leading-tight text-[#061942]">B.Tech - Computer Science</p>
                <p id="dashboardProfileLocation" class="flex items-center gap-1.5 text-sm font-semibold leading-tight text-[#24344f]">
                    <svg class="h-4 w-4 shrink-0 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span>Delhi, India</span>
                </p>
            </div>

            <div
                id="dashboardProfileImageWrap"
                class="hidden w-full shrink-0 overflow-hidden rounded-lg border border-white/80 bg-white shadow-[0_12px_28px_rgba(6,25,66,.12)] md:h-[124px] md:w-[210px]"
            >
                <img
                    id="dashboardProfileImage"
                    class="h-full w-full object-cover"
                    src=""
                    alt="Profile photo"
                >
            </div>
        </article>

        <div class="hidden">
            <div id="dashboardStatsGrid"></div>
            <div id="learningProgressChart"></div>
            <span id="learningProgressLabel"></span>
            <div id="quickActions"></div>
            <div id="applicationOverviewChart"></div>
            <div id="recentActivity"></div>
            <div id="latestTrainingCard"></div>
        </div>

        <section class="fast-track-program-panel rounded-lg bg-white px-5 py-7 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:px-6">
            <div class="mb-7">
                <h2 class="mb-1 text-[26px] font-bold leading-tight text-[#061942]">Fast Track Program</h2>
                <p class="text-[13px] font-semibold text-[#34445e]">Get trained by verified training partners, improve your skills and get access to better job opportunities.</p>
            </div>

            <div id="fastTrackProgramSteps" class="mb-8 grid gap-5 lg:grid-cols-6 lg:gap-0">
                @foreach ($fastTrackSteps as $index => $step)
                    <article class="fast-track-program-step relative flex items-start gap-3 lg:block lg:text-center" data-step="{{ $index + 1 }}">
                        @if ($index < count($fastTrackSteps) - 1)
                            <span class="fast-track-step-line absolute left-[24px] top-6 hidden h-px w-full bg-[#d8e1ee] lg:block"></span>
                        @endif
                        <div class="fast-track-step-marker relative z-10 mx-0 grid h-12 w-12 shrink-0 place-items-center rounded-full text-sm font-bold text-white shadow-[0_8px_16px_rgba(6,25,66,0.12)] lg:mx-auto" style="background-color: {{ $step['color'] }}">
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

            <div class="fast-track-section-head mb-4 flex items-end justify-between gap-4">
                <div>
                    <h2 class="mb-1 text-[20px] font-bold text-[#061942]">Explore Career Tracks</h2>
                    <p class="text-[13px] font-semibold text-[#34445e]">Choose a career track that matches your interest and career goals.</p>
                </div>
                <a href="/fast-track/courses" class="hidden shrink-0 items-center gap-2 text-[13px] font-bold text-[#075fe4] sm:inline-flex">View All Tracks <span aria-hidden="true">-&gt;</span></a>
            </div>

            <div id="dynamicCareerTracks" class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($careerTracks as $track)
                    <article class="rounded-lg border border-[#dce7f8] bg-white px-4 py-5 text-center shadow-[0_6px_18px_rgba(6,25,66,0.05)]">
                        <div class="mx-auto mb-4 grid h-[58px] w-[58px] place-items-center rounded-full text-white shadow-[0_10px_20px_rgba(6,25,66,0.14)] [&>svg]:h-7 [&>svg]:w-7" style="background-color: {{ $track['color'] }}">
                            @include('components.public.icon', ['name' => $track['icon']])
                        </div>
                        <h3 class="mb-2 text-[14px] font-bold leading-tight text-[#061942]">{{ $track['title'] }}</h3>
                        <p class="mx-auto mb-3 min-h-[48px] max-w-[190px] text-[11px] font-semibold leading-4 text-[#34445e]">{{ $track['text'] }}</p>
                        <p class="mb-2 text-[11px] font-bold text-[#061942]">Key Skills</p>
                        <div class="mb-4 flex min-h-[52px] flex-wrap items-start justify-center gap-2">
                            @foreach ($track['skills'] as $skill)
                                <span class="rounded-full bg-[#f2f5f9] px-2.5 py-1 text-[10px] font-semibold text-[#34445e]">{{ $skill }}</span>
                            @endforeach
                        </div>
                        <a href="/fast-track/courses" class="inline-flex h-8 min-w-[132px] items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#07518f] transition hover:bg-[#f3f8ff]">View Details</a>
                    </article>
                @endforeach
            </div>

            <article class="mt-10 rounded-xl border border-[#dce7f8] bg-white px-5 py-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <div class="fast-track-current-program grid gap-6 xl:grid-cols-[1.05fr_.95fr_1.25fr] xl:divide-x xl:divide-[#e6eef9]">
                    <section class="xl:pr-6">
                        <h2 class="mb-4 text-[16px] font-bold text-[#075fe4]">Your Current Program</h2>
                        <div class="rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_6px_16px_rgba(6,25,66,0.04)]">
                            <div class="mb-5 flex items-center gap-4">
                                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-[#075fe4] text-white [&>svg]:h-6 [&>svg]:w-6 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">
                                    @include('components.public.icon', ['name' => 'code'])
                                </span>
                                <div class="min-w-0">
                                    <h3 id="currentProgramTitle" class="truncate text-[18px] font-bold text-[#061942]">Software Development</h3>
                                    <p class="mt-3 flex flex-wrap items-center gap-2 text-[12px] font-semibold text-[#34445e]">
                                        <span>Training Partner:</span>
                                        <strong id="currentProgramPartner" class="text-[18px] font-black leading-none text-[#176aa6]">EXCELR</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-3 text-[12px] font-bold text-[#34445e]">
                                <span id="currentProgramBatch">Batch: SD-2024-06-01</span>
                                <span id="currentProgramStatus" class="rounded-full bg-[#dff6ef] px-3 py-1 text-[11px] font-bold text-[#0b8b67]">Enrolled</span>
                            </div>
                        </div>
                    </section>

                    <section class="xl:px-6">
                        <h2 class="mb-4 text-[16px] font-bold text-[#075fe4]">Program Timeline</h2>
                        <div class="grid gap-3 text-[12px] font-semibold text-[#34445e]">
                            <div class="grid grid-cols-[22px_minmax(0,1fr)_auto] items-center gap-3">
                                <span class="text-[#526287]">@include('components.public.icon', ['name' => 'document'])</span>
                                <span>Start Date</span>
                                <strong id="programStartDate" class="font-bold text-[#061942]">01 Jun 2024</strong>
                            </div>
                            <div class="grid grid-cols-[22px_minmax(0,1fr)_auto] items-center gap-3">
                                <span class="text-[#526287]">@include('components.public.icon', ['name' => 'document'])</span>
                                <span>Expected End Date</span>
                                <strong id="programEndDate" class="font-bold text-[#061942]">15 Aug 2024</strong>
                            </div>
                            <div class="grid grid-cols-[22px_minmax(0,1fr)_auto] items-center gap-3">
                                <span class="text-[#526287]">@include('components.public.icon', ['name' => 'growth'])</span>
                                <span>Duration</span>
                                <strong id="programDuration" class="font-bold text-[#061942]">10 Weeks</strong>
                            </div>
                            <div class="grid grid-cols-[22px_minmax(0,1fr)_auto] items-center gap-3">
                                <span class="text-[#526287]">@include('components.public.icon', ['name' => 'training'])</span>
                                <span>Classes</span>
                                <strong id="programMode" class="font-bold text-[#061942]">Live Online</strong>
                            </div>
                        </div>
                        <a href="/fast-track/training" class="mt-5 inline-flex h-9 w-full items-center justify-center rounded-md border border-[#9fc1f8] bg-white px-4 text-[13px] font-bold text-[#075fe4] shadow-[0_6px_14px_rgba(7,95,228,0.08)] transition hover:bg-[#f3f8ff]">View Class Schedule</a>
                    </section>

                    <section class="xl:pl-6">
                        <h2 class="mb-4 text-[16px] font-bold text-[#075fe4]">Program Progress</h2>
                        <div id="programProgressRows" class="grid gap-4 text-[12px] font-semibold text-[#34445e]">
                            <div class="grid grid-cols-[116px_minmax(0,1fr)_auto] items-center gap-3">
                                <span>Initial Assessment</span>
                                <span id="initialAssessmentStatus" class="font-bold text-[#19a85b]">Completed</span>
                                <span class="grid h-5 w-5 place-items-center rounded-full bg-[#19a85b] text-[11px] font-bold text-white">&#10003;</span>
                            </div>
                            <div class="grid grid-cols-[116px_minmax(0,1fr)_auto] items-center gap-3">
                                <span>Training Progress</span>
                                <span class="h-2 overflow-hidden rounded-full bg-[#e4ebf4]"><span id="programProgressBar" class="block h-full w-[40%] rounded-full bg-[#075fe4]"></span></span>
                                <strong id="programProgressValue" class="font-bold text-[#061942]">40%</strong>
                            </div>
                            @foreach (['Final Assessment', 'Certification', 'Job Opportunities'] as $item)
                                <div class="grid grid-cols-[116px_minmax(0,1fr)_auto] items-center gap-3">
                                    <span>{{ $item }}</span>
                                    <span class="h-2 rounded-full bg-[#e4ebf4]"></span>
                                    <strong class="font-bold text-[#526287]">Upcoming</strong>
                                </div>
                            @endforeach
                        </div>
                        <a href="/fast-track/training-progress" class="mt-5 inline-flex h-9 w-full items-center justify-center rounded-md border border-[#9fc1f8] bg-white px-4 text-[13px] font-bold text-[#075fe4] shadow-[0_6px_14px_rgba(7,95,228,0.08)] transition hover:bg-[#f3f8ff]">View Full Progress</a>
                    </section>
                </div>
            </article>

            <div class="mt-10">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="mb-1 text-[18px] font-bold text-[#061942]">Assessment Summary</h2>
                        <p class="text-[12px] font-semibold text-[#34445e]">Improve your skills and see your growth with initial and final assessments.</p>
                    </div>
                    <a href="/fast-track/final-assessment" class="hidden shrink-0 items-center gap-2 text-[12px] font-bold text-[#07518f] sm:inline-flex">View Detailed Report <span aria-hidden="true">-&gt;</span></a>
                </div>

                <div class="grid gap-4 xl:grid-cols-[1.18fr_28px_1fr_.78fr] xl:items-stretch">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,0.04)]">
                        <div class="mb-4">
                            <h3 class="text-[12px] font-bold text-[#061942]">Initial Assessment <span class="font-semibold text-[#34445e]">(Before Training)</span></h3>
                            <p class="mt-1 text-[10px] font-semibold text-[#6f7d90]">Completed after profile verification</p>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-[120px_minmax(0,1fr)] sm:items-center">
                            <div class="text-center">
                                <div data-assessment-ring="initial" class="mx-auto grid h-[92px] w-[92px] place-items-center rounded-full bg-[conic-gradient(#075fe4_0_40%,#e4e9f1_40%_100%)]">
                                    <div data-assessment-overall="initial" class="grid h-[74px] w-[74px] place-items-center rounded-full bg-[#f4f7fb] text-[23px] font-bold text-[#061942]">40%</div>
                                </div>
                                <p class="mt-3 text-[10px] font-bold text-[#34445e]">Overall Score</p>
                            </div>
                            <div class="grid gap-3">
                                @foreach ([['technical', 'Technical Skills', 42], ['aptitude', 'Aptitude', 38], ['communication', 'Communication', 45], ['attitude', 'Attitude', 40], ['problem_solving', 'Problem Solving', 35]] as $score)
                                    <div class="grid grid-cols-[120px_minmax(0,1fr)_34px] items-center gap-3">
                                        <span class="text-[11px] font-semibold text-[#061942]">{{ $score[1] }}</span>
                                        <span class="h-1.5 overflow-hidden rounded-full bg-[#e6edf6]"><span data-assessment-bar="initial:{{ $score[0] }}" class="block h-full rounded-full bg-[#075fe4]" style="width: {{ $score[2] }}%"></span></span>
                                        <span data-assessment-score="initial:{{ $score[0] }}" class="text-right text-[10px] font-bold text-[#34445e]">{{ $score[2] }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <div class="hidden items-center justify-center text-[34px] font-light text-[#9aa9bc] xl:flex" aria-hidden="true">&gt;</div>

                    <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_6px_18px_rgba(6,25,66,0.04)]">
                        <div class="mb-4">
                            <h3 class="text-[12px] font-bold text-[#061942]">Final Assessment <span class="font-semibold text-[#34445e]">(After Training)</span></h3>
                            <p class="mt-1 text-[10px] font-semibold text-[#6f7d90]">To be taken after course completion</p>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-[120px_minmax(0,1fr)] sm:items-center">
                            <div class="text-center">
                                <div data-assessment-ring="final" class="mx-auto grid h-[92px] w-[92px] place-items-center rounded-full bg-[#e7ebf1]">
                                    <div data-assessment-overall="final" class="grid h-[74px] w-[74px] place-items-center rounded-full bg-[#f4f7fb] text-[23px] font-bold text-[#061942]">--%</div>
                                </div>
                                <p class="mt-3 text-[10px] font-bold text-[#34445e]">Overall Score</p>
                            </div>
                            <div class="grid gap-3">
                                @foreach ([['technical', 'Technical Skills'], ['aptitude', 'Aptitude'], ['communication', 'Communication'], ['attitude', 'Attitude'], ['problem_solving', 'Problem Solving']] as $score)
                                    <div class="grid grid-cols-[120px_minmax(0,1fr)_18px] items-center gap-3">
                                        <span class="text-[11px] font-semibold text-[#061942]">{{ $score[1] }}</span>
                                        <span class="h-1.5 overflow-hidden rounded-full bg-[#e6edf6]"><span data-assessment-bar="final:{{ $score[0] }}" class="block h-full rounded-full bg-[#075fe4]" style="width: 0%"></span></span>
                                        <span data-assessment-score="final:{{ $score[0] }}" class="text-right text-[10px] font-bold text-[#9aa9bc]">--</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>

                    <aside class="rounded-lg border border-[#f3dfb8] bg-[#fff9ed] p-5 shadow-[0_8px_18px_rgba(125,83,0,0.06)]">
                        <h3 class="mb-3 text-[13px] font-bold text-[#9a6700]">Companies Get You With</h3>
                        <ul class="mb-4 grid gap-3 text-[11px] font-semibold leading-4 text-[#061942]">
                            <li class="flex gap-2"><span class="font-bold text-[#1a8c62]">&#10003;</span><span><strong>Initial Assessment</strong><br><span class="text-[#34445e]">(Your Current Skills)</span></span></li>
                            <li class="flex gap-2"><span class="font-bold text-[#1a8c62]">&#10003;</span><span><strong>Final Assessment</strong><br><span class="text-[#34445e]">(Your Improved Skills)</span></span></li>
                            <li class="flex gap-2"><span class="font-bold text-[#1a8c62]">&#10003;</span><span><strong>Training Completion Certificate</strong></span></li>
                            <li class="flex gap-2"><span class="font-bold text-[#1a8c62]">&#10003;</span><span><strong>Industry Ready Profile</strong></span></li>
                        </ul>
                        <a href="/fast-track/how-it-works" class="inline-flex h-8 min-w-[132px] items-center justify-center rounded-md border border-[#d8c8a2] bg-white px-4 text-[11px] font-bold text-[#07518f] transition hover:bg-[#f7f2e7]">Know More</a>
                    </aside>
                </div>
            </div>

            <div class="mt-10">
                <div class="mb-4">
                    <h2 class="mb-1 text-[18px] font-bold text-[#061942]">Our Trusted Training Partners</h2>
                    <p class="text-[12px] font-semibold text-[#34445e]">Learn from the best. Get Certified. Get hired.</p>
                </div>

                <div id="dynamicTrainingPartners" class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($partners as $partner)
                        <article class="flex min-h-[94px] flex-col items-center justify-center rounded-lg border border-[#dce7f8] bg-white px-4 py-3 text-center shadow-[0_6px_16px_rgba(6,25,66,0.04)]">
                            <div class="mb-2 flex min-h-[34px] items-center justify-center gap-1.5">
                                <span class="text-[22px] font-black leading-none" style="color: {{ $partner['color'] }}">{{ $partner['name'] }}</span>
                            </div>
                            <p class="mb-2 text-[9px] font-bold leading-none text-[#6f7d90]">{{ $partner['sub'] }}</p>
                            <p class="text-[12px] font-bold text-[#061942]">{{ $partner['score'] }} <span class="text-[#f3a51d]">*</span></p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

    </section>
@endsection

@push('scripts')
<script>
    const welcomeName = document.getElementById('welcomeName');
    const dashboardProfileAvatar = document.getElementById('dashboardProfileAvatar');
    const dashboardProfileCourse = document.getElementById('dashboardProfileCourse');
    const dashboardProfileLocation = document.getElementById('dashboardProfileLocation');
    const dashboardProfileImageWrap = document.getElementById('dashboardProfileImageWrap');
    const dashboardProfileImage = document.getElementById('dashboardProfileImage');
    const dashboardStatsGrid = document.getElementById('dashboardStatsGrid');
    const quickActions = document.getElementById('quickActions');
    const recentActivity = document.getElementById('recentActivity');
    const latestTrainingCard = document.getElementById('latestTrainingCard');
    const learningProgressChart = document.getElementById('learningProgressChart');
    const learningProgressLabel = document.getElementById('learningProgressLabel');
    const applicationOverviewChart = document.getElementById('applicationOverviewChart');

    const dashboardIcons = {
        profile: '<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg>',

        assessment: '<svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 13h6M9 17h3"></path></svg>',

        training: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3z"></path></svg>',

        notification: '<svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>',

        course: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7z"></path></svg>',

        progress: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',

        enroll: '<svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><path d="M14 8h7M14 12h7M14 16h5"></path></svg>',

        certificate: '<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3z"></path><path d="M9 8h6M9 12h6"></path></svg>',
    };

    function icon(name) {
        return `
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">
                ${dashboardIcons[name] || dashboardIcons.course}
            </span>
        `;
    }

    function circleCard(label, value, color) {
        const safeValue = Math.max(
            0,
            Math.min(100, Number(value || 0))
        );

        return `
            <article class="dashboard-stat-card relative overflow-hidden rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <span class="absolute left-0 top-0 h-full w-1" style="background:${color};"></span>
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold leading-snug text-[#061942]">
                            ${FastTrack.esc(label)}
                        </h3>
                        <p class="mt-2 text-xs font-semibold text-[#526287]">
                            ${safeValue >= 80 ? 'Almost complete' : (safeValue > 0 ? 'Keep going' : 'Not started yet')}
                        </p>
                    </div>
                    <span class="text-[30px] font-bold leading-none text-[#061942]">
                        ${safeValue}%
                    </span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-[#edf3fb]">
                    <div class="h-full rounded-full" style="width:${safeValue}%;background:${color};"></div>
                </div>
            </article>
        `;
    }

    function metricCard(cardIcon, label, value, hint, tone = '#075fe4') {
        return `
            <article class="dashboard-stat-card relative overflow-hidden rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <span class="absolute left-0 top-0 h-full w-1" style="background:${tone};"></span>
                <div class="mb-4 flex items-center justify-between gap-4">
                    ${cardIcon}
                    <div class="text-[32px] font-bold leading-none text-[#061942]">
                        ${FastTrack.esc(value)}
                    </div>
                </div>
                <h3 class="text-sm font-bold leading-snug text-[#061942]">
                    ${FastTrack.esc(label)}
                </h3>
                <p class="mt-2 truncate text-xs font-semibold text-[#526287]">
                    ${FastTrack.esc(hint)}
                </p>
            </article>
        `;
    }

    function smallCard(cardIcon, label, value) {
        return `
            <article class="dashboard-stat-card grid grid-cols-[64px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                ${cardIcon}

                <div>
                    <div class="mb-1 text-[26px] font-bold leading-none text-[#061942]">
                        ${FastTrack.esc(value)}
                    </div>

                    <p class="text-sm leading-snug text-[#24344f]">
                        ${FastTrack.esc(label)}
                    </p>
                </div>
            </article>
        `;
    }

    function actionCard(cardIcon, title, url, done) {
        return `
            <a
                class="quick-action-card ${done ? 'is-done' : ''}"
                href="${url}"
            >
                ${cardIcon}
                <span class="max-w-[110px] text-sm font-bold leading-snug">${FastTrack.esc(title)}</span>
                <small class="action-status ${done ? 'bg-[#dbf8e8] text-[#078346]' : 'bg-[#fff4df] text-[#b86500]'}">${done ? 'Done' : 'Pending'}</small>
            </a>
        `;
    }

    function activityItem(activityIcon, title, date) {
        return `
            <div class="grid grid-cols-[44px_minmax(0,1fr)] items-center gap-4 border-b border-[#e5edf8] py-4 text-sm last:border-b-0 sm:grid-cols-[44px_minmax(0,1fr)_auto]">
                ${activityIcon}

                <span class="font-semibold text-[#061942]">
                    ${FastTrack.esc(title)}
                </span>

                <time class="col-start-2 whitespace-nowrap text-[#24344f] sm:col-start-auto">
                    ${FastTrack.esc(date || '-')}
                </time>
            </div>
        `;
    }

    function renderTrendChart(target, rows) {
        const data = rows.map((row) => ({
            label: row[0],
            value: Math.max(0, Math.min(100, Number(row[1] || 0))),
        }));
        const width = 520;
        const height = 220;
        const left = 38;
        const right = 18;
        const top = 18;
        const bottom = 36;
        const chartW = width - left - right;
        const chartH = height - top - bottom;
        const step = chartW / Math.max(1, data.length - 1);
        const points = data.map((item, index) => ({
            ...item,
            x: left + index * step,
            y: top + chartH - (item.value / 100) * chartH,
        }));
        const line = points.map((point) => `${point.x},${point.y}`).join(' ');
        const area = `${left},${top + chartH} ${line} ${width - right},${top + chartH}`;

        target.innerHTML = `<svg viewBox="0 0 ${width} ${height}" preserveAspectRatio="xMidYMid meet" aria-label="Learning progress chart">
            <defs>
                <linearGradient id="fastTrackProgressFill" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0" stop-color="#075fe4" stop-opacity=".18"></stop>
                    <stop offset="1" stop-color="#075fe4" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
            <line x1="${left}" y1="${top}" x2="${left}" y2="${top + chartH}" stroke="#e5edf8"></line>
            <line x1="${left}" y1="${top + chartH}" x2="${width - right}" y2="${top + chartH}" stroke="#dce7f8"></line>
            <line x1="${left}" y1="${top + chartH / 2}" x2="${width - right}" y2="${top + chartH / 2}" stroke="#eff4fb"></line>
            <text x="6" y="${top + 4}" font-size="11" fill="#526287">100</text>
            <text x="12" y="${top + chartH / 2 + 4}" font-size="11" fill="#526287">50</text>
            <text x="20" y="${top + chartH + 4}" font-size="11" fill="#526287">0</text>
            <polygon points="${area}" fill="url(#fastTrackProgressFill)"></polygon>
            <polyline points="${line}" fill="none" stroke="#075fe4" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${points.map((point) => `<circle cx="${point.x}" cy="${point.y}" r="5" fill="#075fe4" stroke="#cfe0ff" stroke-width="3"></circle><text x="${point.x - 20}" y="${height - 10}" font-size="10" fill="#526287">${FastTrack.esc(point.label)}</text>`).join('')}
        </svg>`;
    }

    function renderBarChart(target, rows) {
        const data = rows.map((row) => ({
            label: row[0],
            value: Number(row[1] || 0),
            color: row[2],
        }));
        const max = Math.max(1, ...data.map((item) => item.value));
        target.innerHTML = `<div class="grid gap-4">${data.map((item) => {
            const percent = Math.max(4, Math.round((item.value / max) * 100));
            return `<div>
                <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                    <span class="font-bold text-[#061942]">${FastTrack.esc(item.label)}</span>
                    <span class="font-bold text-[#24344f]">${FastTrack.esc(item.value)}</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-[#edf3fb]">
                    <div class="h-full rounded-full" style="width:${percent}%;background:${item.color};"></div>
                </div>
            </div>`;
        }).join('')}</div>`;
    }

    function profilePhotoUrl(profile) {
        const photo = profile && (
            profile.profile_photo ||
            profile.profilePhoto ||
            profile.photo ||
            profile.avatar
        );

        if (!photo) return '';
        if (/^(https?:)?\/\//.test(photo) || String(photo).startsWith('data:') || String(photo).startsWith('/')) return photo;
        return '/storage/' + photo;
    }

    function courseIconName(course) {
        const text = String((course && (course.category || course.course_name || course.title)) || '').toLowerCase();
        if (text.includes('data') || text.includes('analytics')) return 'data';
        if (text.includes('market')) return 'marketing';
        if (text.includes('cloud') || text.includes('aws')) return 'cloud';
        if (text.includes('business') || text.includes('finance')) return 'briefcase';
        return 'code';
    }

    function courseColorValue(course) {
        const iconName = courseIconName(course);
        return {
            data: '#2fbf9b',
            marketing: '#f59a23',
            cloud: '#1f73ea',
            briefcase: '#8239d7',
            code: '#2563eb',
        }[iconName] || '#2563eb';
    }

    function skillTagsFromCourse(course) {
        return String((course && (course.skills_covered || course.skills || course.category)) || '')
            .split(/[,|]/)
            .map((skill) => skill.trim())
            .filter(Boolean)
            .slice(0, 4);
    }

    function renderDynamicCareerTracks(courses) {
        const target = document.getElementById('dynamicCareerTracks');
        if (!target || !Array.isArray(courses) || !courses.length) return;

        target.innerHTML = courses.slice(0, 5).map((course) => {
            const iconName = courseIconName(course);
            const color = courseColorValue(course);
            const title = course.course_name || course.title || course.name || 'Fast Track Course';
            const text = course.description || course.short_description || 'Build job-ready skills with guided training.';
            const tags = skillTagsFromCourse(course);
            const detailUrl = course.id ? `/fast-track/course-details?course=${encodeURIComponent(course.id)}` : '/fast-track/courses';

            return `
                <article class="rounded-lg border border-[#dce7f8] bg-white px-4 py-5 text-center shadow-[0_6px_18px_rgba(6,25,66,0.05)]">
                    <div class="mx-auto mb-4 grid h-[58px] w-[58px] place-items-center rounded-full text-white shadow-[0_10px_20px_rgba(6,25,66,0.14)] [&>svg]:h-7 [&>svg]:w-7" style="background-color: ${color}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${dashboardIcons[iconName] || dashboardIcons.course}</svg>
                    </div>
                    <h3 class="mb-2 text-[14px] font-bold leading-tight text-[#061942]">${FastTrack.esc(title)}</h3>
                    <p class="mx-auto mb-3 min-h-[48px] max-w-[190px] text-[11px] font-semibold leading-4 text-[#34445e]">${FastTrack.esc(text)}</p>
                    <p class="mb-2 text-[11px] font-bold text-[#061942]">Key Skills</p>
                    <div class="mb-4 flex min-h-[52px] flex-wrap items-start justify-center gap-2">
                        ${(tags.length ? tags : ['Job Skills', 'Projects', 'Assessment']).map((skill) => `<span class="rounded-full bg-[#f2f5f9] px-2.5 py-1 text-[10px] font-semibold text-[#34445e]">${FastTrack.esc(skill)}</span>`).join('')}
                    </div>
                    <a href="${detailUrl}" class="inline-flex h-8 min-w-[132px] items-center justify-center rounded-md border border-[#9bb7dc] bg-white px-4 text-[11px] font-bold text-[#07518f] transition hover:bg-[#f3f8ff]">View Details</a>
                </article>
            `;
        }).join('');
    }

    function partnerColor(index) {
        return ['#176aa6', '#111827', '#2f64b2', '#176aa6', '#25ad82', '#8239d7'][index % 6];
    }

    function partnerSubtitle(partner) {
        const firstCourse = Array.isArray(partner.courses) ? partner.courses[0] : null;
        return partner.tagline ||
            partner.subtitle ||
            partner.location ||
            firstCourse?.category ||
            `${partner.active_courses_count || 0} Active Courses`;
    }

    function renderDynamicTrainingPartners(partners) {
        const target = document.getElementById('dynamicTrainingPartners');
        if (!target || !Array.isArray(partners) || !partners.length) return;

        target.innerHTML = partners.slice(0, 4).map((partner, index) => {
            const name = partner.institute_name || partner.user?.name || 'Training Partner';
            const sub = partnerSubtitle(partner);
            const rating = partner.rating || partner.average_rating || partner.score || '4.5';
            const color = partner.brand_color || partner.color || partnerColor(index);

            return `
                <article class="flex min-h-[94px] flex-col items-center justify-center rounded-lg border border-[#dce7f8] bg-white px-4 py-3 text-center shadow-[0_6px_16px_rgba(6,25,66,0.04)]">
                    <div class="mb-2 flex min-h-[34px] items-center justify-center gap-1.5">
                        <span class="text-[22px] font-black leading-none" style="color:${FastTrack.esc(color)}">${FastTrack.esc(name)}</span>
                    </div>
                    <p class="mb-2 text-[9px] font-bold uppercase leading-none text-[#6f7d90]">${FastTrack.esc(sub)}</p>
                    <p class="text-[12px] font-bold text-[#061942]">${FastTrack.esc(rating)} <span class="text-[#f3a51d]">*</span></p>
                </article>
            `;
        }).join('');
    }

    function updateProgramCard(data) {
        const latestEnrollment = data.latest_course_enrollment || null;
        if (!latestEnrollment) return;

        const course = latestEnrollment.course || {};
        const progress = FastTrack.progress(latestEnrollment);
        const status = FastTrack.statusText(latestEnrollment.training_status || latestEnrollment.status || 'enrolled');
        const enrollmentDate = latestEnrollment.enrollment_date || latestEnrollment.created_at;

        document.getElementById('currentProgramTitle').textContent = FastTrack.courseName(course);
        document.getElementById('currentProgramPartner').textContent = FastTrack.partnerName(course);
        document.getElementById('currentProgramBatch').textContent = 'Batch: ' + (latestEnrollment.batch_code || latestEnrollment.batch || ('FT-' + (course.id || '2024')));
        document.getElementById('currentProgramStatus').textContent = status;
        document.getElementById('programStartDate').textContent = FastTrack.date(enrollmentDate);
        document.getElementById('programEndDate').textContent = FastTrack.date(latestEnrollment.expected_completion_date || latestEnrollment.end_date);
        document.getElementById('programDuration').textContent = FastTrack.courseDuration(course);
        document.getElementById('programMode').textContent = FastTrack.courseMode(course);
        document.getElementById('programProgressBar').style.width = Math.max(0, Math.min(100, progress)) + '%';
        document.getElementById('programProgressValue').textContent = progress + '%';
    }

    function assessmentSubmitted(assessment) {
        if (!assessment) return false;
        return ['submitted', 'completed', 'passed'].includes(String(assessment.status || '').toLowerCase()) ||
            !!(assessment.submitted_at || assessment.completed_at || assessment.result);
    }

    function assessmentResult(assessment) {
        return assessment?.result || assessment || {};
    }

    function assessmentValue(result, key) {
        const aliases = {
            technical: ['technical_score', 'technical', 'technicalSkills', 'technical_skills'],
            aptitude: ['aptitude_score', 'aptitude'],
            communication: ['communication_score', 'communication'],
            attitude: ['attitude_score', 'attitude'],
            problem_solving: ['problem_solving_score', 'problemSolving', 'problem_solving'],
        };

        for (const field of aliases[key] || []) {
            if (result[field] !== undefined && result[field] !== null && result[field] !== '') {
                return Number(result[field]);
            }
        }

        return null;
    }

    function assessmentOverall(result) {
        const value =
            result.overall_score ??
            result.percentage ??
            result.percentage_score ??
            result.score_percentage ??
            result.score ??
            null;

        return value === null || value === '' ? null : Number(value);
    }

    function setAssessmentMetric(type, key, value, active) {
        const bar = document.querySelector(`[data-assessment-bar="${type}:${key}"]`);
        const label = document.querySelector(`[data-assessment-score="${type}:${key}"]`);
        const safeValue = value === null || Number.isNaN(value) ? null : Math.max(0, Math.min(100, Math.round(value)));

        if (bar) {
            bar.style.width = active && safeValue !== null ? `${safeValue}%` : '0%';
            bar.classList.toggle('bg-[#075fe4]', active && safeValue !== null);
            bar.classList.toggle('bg-[#d8e2f0]', !active || safeValue === null);
        }

        if (label) {
            label.textContent = active && safeValue !== null ? `${safeValue}%` : '--';
            label.classList.toggle('text-[#34445e]', active && safeValue !== null);
            label.classList.toggle('text-[#9aa9bc]', !active || safeValue === null);
        }
    }

    function renderAssessmentCard(type, assessment) {
        const active = assessmentSubmitted(assessment);
        const result = assessmentResult(assessment);
        const overall = active ? assessmentOverall(result) : null;
        const safeOverall = overall === null || Number.isNaN(overall) ? null : Math.max(0, Math.min(100, Math.round(overall)));
        const ring = document.querySelector(`[data-assessment-ring="${type}"]`);
        const score = document.querySelector(`[data-assessment-overall="${type}"]`);

        if (ring) {
            ring.style.background = active && safeOverall !== null
                ? `conic-gradient(#075fe4 0 ${safeOverall}%, #e4e9f1 ${safeOverall}% 100%)`
                : '#e7ebf1';
        }

        if (score) {
            score.textContent = active && safeOverall !== null ? `${safeOverall}%` : '--%';
        }

        ['technical', 'aptitude', 'communication', 'attitude', 'problem_solving'].forEach((key) => {
            setAssessmentMetric(type, key, assessmentValue(result, key), active);
        });
    }

    function renderAssessmentSummary(data) {
        renderAssessmentCard('initial', data.initial_assessment || data.latest_assessment || data.assessment || data.assessment_result || null);
        renderAssessmentCard('final', data.final_assessment || data.latest_final_assessment || null);
    }

    function progressRow(label, state, percent) {
        if (state === 'complete') {
            return `<div class="grid grid-cols-[116px_minmax(0,1fr)_auto] items-center gap-3">
                <span>${FastTrack.esc(label)}</span>
                <span class="font-bold text-[#19a85b]">Completed</span>
                <span class="grid h-5 w-5 place-items-center rounded-full bg-[#19a85b] text-[11px] font-bold text-white">&#10003;</span>
            </div>`;
        }

        if (state === 'progress') {
            const safePercent = Math.max(0, Math.min(100, Number(percent || 0)));
            return `<div class="grid grid-cols-[116px_minmax(0,1fr)_auto] items-center gap-3">
                <span>${FastTrack.esc(label)}</span>
                <span class="h-2 overflow-hidden rounded-full bg-[#e4ebf4]"><span class="block h-full rounded-full bg-[#075fe4]" style="width:${safePercent}%"></span></span>
                <strong class="font-bold text-[#061942]">${safePercent}%</strong>
            </div>`;
        }

        return `<div class="grid grid-cols-[116px_minmax(0,1fr)_auto] items-center gap-3">
            <span>${FastTrack.esc(label)}</span>
            <span class="h-2 rounded-full bg-[#e4ebf4]"></span>
            <strong class="font-bold text-[#526287]">Upcoming</strong>
        </div>`;
    }

    function syncProgramProgressRows(states) {
        const target = document.getElementById('programProgressRows');
        if (!target) return;

        target.innerHTML = [
            progressRow('Initial Assessment', states.initial ? 'complete' : 'upcoming'),
            progressRow('Training Progress', states.progress >= 100 ? 'complete' : (states.progress > 0 ? 'progress' : 'upcoming'), states.progress),
            progressRow('Final Assessment', states.final ? 'complete' : 'upcoming'),
            progressRow('Certification', states.certificate ? 'complete' : 'upcoming'),
            progressRow('Job Opportunities', states.job ? 'complete' : 'upcoming'),
        ].join('');
    }

    function syncProgramSteps(data) {
        const latestEnrollment = data.latest_course_enrollment || null;
        const assessment = data.initial_assessment || data.latest_assessment || data.assessment || data.assessment_result || null;
        const finalAssessment = data.final_assessment || data.latest_final_assessment || null;
        const stats = data.statistics || {};
        const progress = latestEnrollment ? FastTrack.progress(latestEnrollment) : 0;
        const certificates = Number(stats.total_certificates || stats.certificates || 0) + (Array.isArray(data.recent_certificates) ? data.recent_certificates.length : 0);
        const hiredApplications = Number(stats.hired_applications || stats.total_hired || stats.hired || 0) +
            (Array.isArray(data.recent_applications)
                ? data.recent_applications.filter((item) => String(item.application_status || item.status || '').toLowerCase() === 'hired').length
                : 0);

        const states = {
            initial: assessmentSubmitted(assessment),
            training: !!latestEnrollment || progress > 0 || Number(stats.total_course_enrollments || 0) > 0,
            progress,
            final: assessmentSubmitted(finalAssessment) || progress >= 100,
            certificate: certificates > 0,
            job: hiredApplications > 0,
        };

        let activeStep = 1;
        if (states.initial) activeStep = 2;
        if (states.initial && states.training) activeStep = 3;
        if (states.initial && states.training && states.final) activeStep = 4;
        if (states.initial && states.training && states.final && states.certificate) activeStep = 5;
        if (states.initial && states.training && states.final && states.certificate && states.job) activeStep = 6;

        syncProgramProgressRows(states);

        document.querySelectorAll('.fast-track-program-step').forEach((step) => {
            const stepNumber = Number(step.dataset.step || 0);
            const marker = step.querySelector('.fast-track-step-marker');
            const line = step.querySelector('.fast-track-step-line');
            const isActive = stepNumber <= activeStep;
            const isCurrent = stepNumber === activeStep;

            if (marker) {
                marker.style.backgroundColor = isActive ? (isCurrent ? '#075fe4' : '#25ad82') : '#cbd5e1';
                marker.style.boxShadow = isActive
                    ? '0 10px 22px rgba(7,95,228,0.18)'
                    : '0 8px 16px rgba(6,25,66,0.12)';
            }

            if (line) {
                line.style.backgroundColor = stepNumber < activeStep ? '#25ad82' : '#d8e1ee';
            }
        });
    }

    function setDashboardProfileCard(user, profile) {
        const displayName =
            user.name ||
            user.full_name ||
            user.email ||
            'Fresher';

        const qualification =
            profile.qualification ||
            profile.highest_qualification ||
            profile.degree ||
            'B.Tech';

        const specialization =
            profile.specialization ||
            profile.branch ||
            profile.stream ||
            profile.course ||
            'Computer Science';

        const city = profile.city || profile.location || 'Delhi';
        const country = profile.country || 'India';
        const locationText = [city, country].filter(Boolean).join(', ');
        const photo = profilePhotoUrl(profile);

        welcomeName.textContent = displayName;
        dashboardProfileCourse.textContent = [qualification, specialization].filter(Boolean).join(' - ');
        dashboardProfileLocation.querySelector('span').textContent = locationText || 'Delhi, India';

        dashboardProfileAvatar.textContent = FastTrack.initials(displayName);
        dashboardProfileAvatar.title = displayName;
        dashboardProfileAvatar.style.backgroundImage = '';
        dashboardProfileImageWrap.classList.add('hidden');
        dashboardProfileImageWrap.classList.remove('md:block');
        dashboardProfileImage.removeAttribute('src');

        if (photo) {
            const image = new Image();
            image.onload = function () {
                dashboardProfileAvatar.textContent = '';
                dashboardProfileAvatar.style.backgroundImage = `url("${photo.replace(/"/g, '\\"')}")`;
                dashboardProfileImage.src = photo;
                dashboardProfileImage.alt = displayName + ' profile photo';
                dashboardProfileImageWrap.classList.remove('hidden');
                dashboardProfileImageWrap.classList.add('md:block');
            };
            image.onerror = function () {
                dashboardProfileAvatar.textContent = FastTrack.initials(displayName);
                dashboardProfileAvatar.style.backgroundImage = '';
                dashboardProfileImageWrap.classList.add('hidden');
                dashboardProfileImageWrap.classList.remove('md:block');
                dashboardProfileImage.removeAttribute('src');
            };
            image.src = photo;
        }
    }

    function renderDashboard(data, unread) {
        const user = data.user || FastTrack.user() || {};
        const profile = data.profile || {};
        const stats = data.statistics || {};
        const latestEnrollment = data.latest_course_enrollment || null;
        const assessment =
            data.initial_assessment ||
            data.latest_assessment ||
            data.assessment ||
            data.assessment_result ||
            null;
        const result = assessment?.result || {};
        const recommendedTrack = result.recommended_track || '';

        const rawScore = assessment
            ? (
                result.overall_score ??
                assessment.percentage ??
                assessment.percentage_score ??
                assessment.score_percentage ??
                assessment.score ??
                assessment.result?.percentage ??
                assessment.result?.score ??
                0
            )
            : 0;

        const score = Math.max(
            0,
            Math.min(100, Number(rawScore || 0))
        );

        setDashboardProfileCard(user, profile);
        updateProgramCard(data);
        syncProgramSteps(data);
        renderAssessmentSummary(data);

        localStorage.setItem(
            'ofc_auth_user',
            JSON.stringify(user)
        );
        localStorage.setItem('onlyfreshers_selected_mode', 'fast_track');

        dashboardStatsGrid.innerHTML = [
            circleCard(
                'Profile Completion',
                profile.profile_completion || 0,
                '#19a85b'
            ),

            circleCard(
                'Assessment Score',
                score,
                '#7744eb'
            ),

            metricCard(
                icon('training'),
                'Current Training',
                stats.active_trainings || stats.total_course_enrollments || 0,
                latestEnrollment ? FastTrack.courseName(latestEnrollment.course || {}) : 'No active course yet',
                '#075fe4'
            ),

            metricCard(
                icon('notification'),
                'Notifications',
                unread || 0,
                unread ? 'Unread updates waiting' : 'All caught up',
                '#7744eb'
            ),
        ].join('');

        const trainingProgress = latestEnrollment ? FastTrack.progress(latestEnrollment) : 0;
        learningProgressLabel.textContent = trainingProgress + '% training';
        renderTrendChart(learningProgressChart, [
            ['Profile', profile.profile_completion || 0],
            ['Assess', score],
            ['Enroll', latestEnrollment ? 45 : 0],
            ['Train', trainingProgress],
            ['Cert', Number(stats.total_certificates || stats.certificates || 0) > 0 ? 100 : trainingProgress],
        ]);

        renderBarChart(applicationOverviewChart, [
            ['Applications', stats.total_applications || 0, '#075fe4'],
            ['Shortlisted', stats.shortlisted_applications || 0, '#12b76a'],
            ['Interviews', stats.interview_scheduled_applications || stats.scheduled_interviews || 0, '#7744eb'],
            ['Completed Training', stats.completed_trainings || 0, '#f59a23'],
            ['Certificates', stats.total_certificates || stats.certificates || 0, '#0ea5a8'],
        ]);

        quickActions.innerHTML = [
            actionCard(
                icon('profile'),
                'Complete Profile',
                '/fast-track/profile',
                Number(profile.profile_completion || 0) >= 100
            ),

            actionCard(
                icon('course'),
                'Explore Fast Track',
                '/fast-track/courses',
                !!latestEnrollment
            ),

            actionCard(
                icon('progress'),
                'View Training',
                '/fast-track/training',
                Number(stats.total_course_enrollments || 0) > 0
            ),

            actionCard(
                icon('certificate'),
                'Certificate',
                '/fast-track/certificate',
                Number(stats.certificates || 0) > 0
            ),
        ].join('');

        const activities = [];

        if (profile.profile_id || profile.id) {
            activities.push([
                icon('profile'),
                'Profile loaded successfully',
                profile.qualification ||
                profile.city ||
                'Profile active'
            ]);
        }

        if (assessment) {
            activities.push([
                icon('assessment'),
                'Initial assessment completed',
                FastTrack.date(
                    assessment.submitted_at ||
                    assessment.completed_at ||
                    assessment.created_at
                )
            ]);
        }

        (data.recent_applications || []).forEach((item) => {
            const jobTitle =
                item.job?.title ||
                item.job?.course_name ||
                'Job';

            activities.push([
                icon('training'),
                'Applied for ' + jobTitle,
                FastTrack.date(
                    item.applied_at ||
                    item.created_at
                )
            ]);
        });

        (data.recent_certificates || []).forEach((item) => {
            activities.push([
                icon('certificate'),
                'Certificate earned',
                FastTrack.date(
                    item.created_at ||
                    item.issued_at
                )
            ]);
        });

        if (latestEnrollment) {
            activities.push([
                icon('enroll'),
                'Enrolled in ' +
                    FastTrack.courseName(
                        latestEnrollment.course || {}
                    ),
                FastTrack.date(
                    latestEnrollment.enrollment_date ||
                    latestEnrollment.created_at
                )
            ]);
        }

        recentActivity.innerHTML = activities.length
            ? activities
                .slice(0, 6)
                .map((item) =>
                    activityItem(
                        item[0],
                        item[1],
                        item[2]
                    )
                )
                .join('')
            : '<p class="text-sm text-[#334b83]">No recent activity yet.</p>';

        if (latestEnrollment?.course) {
            const progress = FastTrack.progress(latestEnrollment);
            const trainingStatus = (latestEnrollment.training_status || 'in_progress').replaceAll('_', ' ');

            latestTrainingCard.innerHTML = `
                <div class="relative z-10 w-full">
                    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <p class="mb-2 text-xs font-bold uppercase text-[#526287]">Current Training</p>
                            <h3 class="truncate text-[24px] font-bold leading-tight text-[#061942]">
                                ${FastTrack.esc(FastTrack.courseName(latestEnrollment.course))}
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-[#24344f]">
                                ${FastTrack.esc(FastTrack.partnerName(latestEnrollment.course))}
                            </p>
                        </div>
                        <span class="w-fit rounded-full bg-[#eaf2ff] px-3 py-1 text-xs font-bold capitalize text-[#075fe4]">
                            ${FastTrack.esc(trainingStatus)}
                        </span>
                    </div>

                    <div class="mb-5">
                        <div class="mb-2 flex items-center justify-between text-xs font-bold text-[#24344f]">
                            <span>Training Progress</span>
                            <span>${progress}%</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-[#dce7f8]">
                            <div class="h-full rounded-full bg-[linear-gradient(90deg,#075fe4,#17a6a8)]" style="width:${progress}%"></div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a
                            href="/fast-track/training-progress"
                            class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white"
                        >
                            View Progress
                        </a>

                        <a
                            href="/fast-track/course-details?course=${encodeURIComponent(latestEnrollment.course.id)}"
                            class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-white px-6 text-sm font-bold text-[#075fe4]"
                        >
                            Course Details
                        </a>

                    </div>
                </div>
            `;
        } else if (recommendedTrack) {
            latestTrainingCard.innerHTML = `<div class="relative z-10 w-full max-w-[460px]"><h3 class="mb-3 text-[22px] font-bold text-[#061942]">${FastTrack.esc(recommendedTrack)}</h3><p class="mb-2 text-[15px] leading-6 text-[#24344f]">Recommended from your initial assessment score.</p><p class="mb-5 text-sm font-bold text-[#075fe4]">Score: ${FastTrack.esc(result.overall_score || 0)}%</p><a href="/fast-track/courses?track=${encodeURIComponent(recommendedTrack)}" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]">View Recommended Courses</a></div><div class="absolute bottom-7 right-12 hidden h-[155px] w-[155px] rotate-[-28deg] items-center justify-center rounded-full bg-[#e1edff] text-[42px] font-black text-[#075fe4] sm:flex">RT</div>`;
        }
    }

    function renderProfileMissing() {
        dashboardStatsGrid.innerHTML = [
            circleCard(
                'Profile Completion',
                0,
                '#19a85b'
            ),

            circleCard(
                'Assessment Score',
                0,
                '#7744eb'
            ),

            metricCard(
                icon('training'),
                'Current Training',
                0,
                'No active course yet',
                '#075fe4'
            ),

            metricCard(
                icon('notification'),
                'Notifications',
                0,
                'All caught up',
                '#7744eb'
            ),
        ].join('');

        quickActions.innerHTML = [
            actionCard(
                icon('profile'),
                'Complete Profile',
                '/fast-track/profile',
                false
            ),

            actionCard(
                icon('course'),
                'Explore Fast Track',
                '/fast-track/courses',
                false
            ),

            actionCard(
                icon('progress'),
                'View Training',
                '/fast-track/training',
                false
            ),

            actionCard(
                icon('certificate'),
                'Certificate',
                '/fast-track/certificate',
                false
            ),
        ].join('');

        recentActivity.innerHTML =
            '<p class="text-sm text-[#334b83]">Complete your profile to unlock dashboard activity.</p>';
        renderTrendChart(learningProgressChart, [
            ['Profile', 0],
            ['Assess', 0],
            ['Enroll', 0],
            ['Train', 0],
            ['Cert', 0],
        ]);
        renderBarChart(applicationOverviewChart, [
            ['Applications', 0, '#075fe4'],
            ['Shortlisted', 0, '#12b76a'],
            ['Interviews', 0, '#7744eb'],
            ['Completed Training', 0, '#f59a23'],
            ['Certificates', 0, '#0ea5a8'],
        ]);
    }

    Promise.all([
        FastTrack
            .getJson('/api/fresher/dashboard')
            .catch((error) => ({ error })),

        FastTrack
            .getJson('/api/notifications/unread-count')
            .catch(() => ({
                data: {
                    unread_count: 0
                }
            })),

        FastTrack
            .getJson('/api/fresher/profile')
            .catch(() => ({
                data: {}
            })),

        FastTrack
            .getJson('/api/courses')
            .catch(() => ({
                data: {
                    courses: []
                }
            })),

        FastTrack
            .getJson('/api/training-partners?per_page=4')
            .catch(() => ({
                data: {
                    training_partners: {
                        data: []
                    }
                }
            })),
    ])
    .then(function (responses) {
        const dashboardResponse = responses[0];
        const profileResponse = responses[2];
        const coursesResponse = responses[3];
        const partnersResponse = responses[4];

        const unread =
            FastTrack.apiData(
                responses[1],
                'unread_count'
            ) || 0;

        if (dashboardResponse.error) {
            window.location.href = '/fast-track/profile';
            return;
        }
        const dashboard = FastTrack.apiData(dashboardResponse) || {};
        const profileData = FastTrack.apiData(profileResponse) || {};
        const courses = FastTrack.apiData(coursesResponse, 'courses') || [];
        const partnersPaginator = FastTrack.apiData(partnersResponse, 'training_partners') || {};
        const partners = Array.isArray(partnersPaginator) ? partnersPaginator : (partnersPaginator.data || []);
        dashboard.user = profileData.user || dashboard.user;
        dashboard.profile = Object.assign({}, dashboard.profile || {}, profileData.profile || {});

        if (!dashboard.initial_assessment || dashboard.initial_assessment.status !== 'submitted') {
            localStorage.setItem('onlyfreshers_intended_mode', 'fast_track');
            localStorage.removeItem('onlyfreshers_selected_mode');
            window.location.href = '/direct-mode/flow-selection';
            return;
        }
        renderDynamicCareerTracks(courses);
        renderDynamicTrainingPartners(partners);
        renderDashboard(dashboard, unread);
    }).catch(renderProfileMissing);
</script>
@endpush
