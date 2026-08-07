@extends('layouts.fast-track')

@section('title', 'Initial Assessment - Fast Track')

@php
    $activePage = 'assessment';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $results = [
        ['name' => 'Technical Skills', 'score' => 60, 'color' => '#075fe4'],
        ['name' => 'Aptitude', 'score' => 70, 'color' => '#19a85b'],
        ['name' => 'Communication', 'score' => 50, 'color' => '#7744eb'],
        ['name' => 'Problem Solving', 'score' => 62, 'color' => '#ffad28'],
        ['name' => 'Logical Reasoning', 'score' => 55, 'color' => '#ff6565'],
    ];

    $tracks = [
        ['title' => 'Full Stack Development', 'text' => 'Build modern web applications and advance your career.', 'score' => 85, 'tag' => 'Most Popular', 'icon' => 'FS'],
        ['title' => 'Data Science & Analytics', 'text' => 'Analyze data and build impactful solutions.', 'score' => 75, 'tag' => '', 'icon' => 'DS'],
    ];

    $nextSteps = [
        ['title' => 'Explore Fast Track Courses', 'text' => 'Choose a course that matches your goals.', 'icon' => 'EX'],
        ['title' => 'Improve Your Skills', 'text' => 'Access recommended learning resources.', 'icon' => 'IM'],
        ['title' => 'Take Final Assessment', 'text' => 'Complete the final assessment to get certified.', 'icon' => 'FA'],
    ];

    $average = round(collect($results)->avg('score'));
    $segment = 100 / count($results);
    $start = 0;
    $gradientParts = [];

    foreach ($results as $result) {
        $end = $start + $segment;
        $gradientParts[] = $result['color'].' '.$start.'% '.$end.'%';
        $start = $end;
    }
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Initial Assessment</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Complete the assessment to discover your skills and get personalized course recommendations.</p>
        </div>

        <article class="grid gap-6 rounded-lg border border-[#dce7f8] bg-white px-6 py-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] xl:grid-cols-[150px_minmax(0,1fr)_260px] xl:items-center xl:px-8">
            <div class="grid h-[105px] w-[120px] place-items-center rounded-xl bg-[#eaf2ff] text-[32px] font-black text-[#075fe4]">IA</div>
            <div>
                <div class="mb-4 flex items-center text-lg font-bold text-[#0a8f3f]"><span class="mr-3 grid h-6 w-6 place-items-center rounded-full bg-[#19a85b] text-xs font-black text-white">✓</span>Assessment Completed</div>
                <p class="mb-5 text-sm font-medium text-[#334b83]">Submitted on 12 May 2024, 10:30 AM</p>
                <button class="h-[38px] rounded-md border border-[#075fe4] bg-white px-6 text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" type="button">View Details</button>
            </div>
            <div class="border-[#dce7f8] text-center xl:border-l xl:pl-8">
                <h3 class="mb-4 text-sm font-bold text-[#061942]">Overall Score</h3>
                <div class="inline-flex h-[105px] w-[105px] items-center justify-center rounded-full" style="background: conic-gradient(#075fe4 0 60%, #e9edf5 60% 100%);">
                    <span class="flex h-[76px] w-[76px] items-center justify-center rounded-full bg-white text-[22px] font-bold text-[#061942]">60%</span>
                </div>
            </div>
        </article>

        <div class="grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 text-base font-bold text-[#061942]">Skill Assessment Results</h2>
                <div class="space-y-5">
                    @foreach ($results as $item)
                        <div class="grid items-center gap-3 text-sm sm:grid-cols-[130px_minmax(0,1fr)_42px] sm:gap-4">
                            <span class="font-medium text-[#061942]">{{ $item['name'] }}</span>
                            <div class="h-2 overflow-hidden rounded-full bg-[#e9edf5]">
                                <span class="block h-full rounded-full" style="width: {{ $item['score'] }}%; background: {{ $item['color'] }};"></span>
                            </div>
                            <strong class="font-bold text-[#061942]">{{ $item['score'] }}%</strong>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 text-base font-bold text-[#061942]">Subject Wise Performance</h2>
                <div class="grid items-center gap-6 lg:grid-cols-[210px_minmax(0,1fr)]">
                    <div class="mx-auto flex h-40 w-40 items-center justify-center rounded-full" style="background: conic-gradient({{ implode(', ', $gradientParts) }});">
                        <span class="flex h-[102px] w-[102px] flex-col items-center justify-center rounded-full bg-white text-center text-xl font-bold leading-tight text-[#061942]">{{ $average }}%<small class="text-xs font-medium text-[#334b83]">Overall</small></span>
                    </div>
                    <div class="grid gap-4">
                        @foreach ($results as $item)
                            <div class="grid grid-cols-[12px_minmax(0,1fr)_42px] items-center gap-3 text-sm">
                                <span class="h-[11px] w-[11px] rounded-full" style="background: {{ $item['color'] }};"></span>
                                <span class="font-medium text-[#334b83]">{{ $item['name'] }}</span>
                                <strong class="font-bold text-[#061942]">{{ $item['score'] }}%</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </article>
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.45fr_1fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-3 text-base font-bold text-[#061942]">Recommended for You</h2>
                <p class="mb-5 text-sm leading-6 text-[#536484]">Based on your performance, we recommend the following career tracks.</p>
                <div class="grid gap-3">
                    @foreach ($tracks as $track)
                        <div class="grid gap-4 rounded-lg border border-[#dce7f8] p-4 lg:grid-cols-[54px_minmax(0,1fr)_95px_92px] lg:items-center">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $track['icon'] }}</span>
                            <div>
                                <h3 class="mb-2 text-sm font-bold text-[#061942]">{{ $track['title'] }} @if ($track['tag'])<span class="ml-2 inline-flex rounded-md bg-[#eee7ff] px-2 py-1 text-[10px] font-bold text-[#7744eb]">{{ $track['tag'] }}</span>@endif</h3>
                                <p class="text-xs leading-5 text-[#536484]">{{ $track['text'] }}</p>
                            </div>
                            <div><small class="text-xs text-[#536484]">Match Score</small><div class="text-[21px] font-black text-[#0a8f3f]">{{ $track['score'] }}%</div></div>
                            <a href="/fast-track/courses" class="inline-flex h-[38px] items-center justify-center rounded-md bg-[#075fe4] px-4 text-sm font-bold text-white">Explore</a>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 text-base font-bold text-[#061942]">What's Next?</h2>
                <div class="grid gap-5">
                    @foreach ($nextSteps as $step)
                        <div class="grid grid-cols-[42px_minmax(0,1fr)_16px] items-center gap-4">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $step['icon'] }}</span>
                            <div>
                                <h3 class="mb-1.5 text-sm font-bold text-[#061942]">{{ $step['title'] }}</h3>
                                <p class="text-xs leading-5 text-[#536484]">{{ $step['text'] }}</p>
                            </div>
                            <span class="text-lg font-bold text-[#075fe4]">&gt;</span>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection
