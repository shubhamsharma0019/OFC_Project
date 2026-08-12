@extends('layouts.fast-track')

@section('title', 'Training Progress')

@php
    $activePage = 'progress';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $cards = [
        ['label' => 'Enrolled Courses', 'value' => '4', 'link' => 'View Courses', 'icon' => 'EC'],
        ['label' => 'Courses Completed', 'value' => '1', 'link' => 'View Certificate', 'icon' => 'CC'],
        ['label' => 'Lessons Completed', 'value' => '28/74', 'link' => 'View Lessons', 'icon' => 'LC'],
        ['label' => 'Total Study Time', 'value' => '12h 45m', 'link' => 'View Reports', 'icon' => 'ST'],
    ];

    $skills = [
        ['name' => 'HTML & CSS', 'score' => 80],
        ['name' => 'JavaScript', 'score' => 65],
        ['name' => 'React.js', 'score' => 50],
        ['name' => 'Node.js', 'score' => 40],
        ['name' => 'MongoDB', 'score' => 35],
        ['name' => 'Problem Solving', 'score' => 60],
    ];

    $courses = [
        ['name' => 'Full Stack Development', 'duration' => '12 Months', 'progress' => 45, 'status' => 'In Progress', 'last' => 'Today, 10:30 AM', 'icon' => 'FS'],
        ['name' => 'Data Science & Analytics', 'duration' => '10 Months', 'progress' => 30, 'status' => 'In Progress', 'last' => 'Yesterday, 6:15 PM', 'icon' => 'DS'],
        ['name' => 'Digital Marketing', 'duration' => '6 Months', 'progress' => 0, 'status' => 'Not Started', 'last' => '-', 'icon' => 'DM'],
        ['name' => 'Backend Development', 'duration' => '10 Months', 'progress' => 0, 'status' => 'Not Started', 'last' => '-', 'icon' => 'BD'],
    ];

    $overall = [
        'percent' => 38,
        'message' => 'Keep going! You are doing great.',
        'items' => [
            ['label' => 'Completed', 'value' => '1 Course', 'icon' => 'CC'],
            ['label' => 'In Progress', 'value' => '2 Courses', 'icon' => 'IP'],
            ['label' => 'Not Started', 'value' => '1 Course', 'icon' => 'NS'],
            ['label' => 'Lessons Completed', 'value' => '28 / 74', 'icon' => 'LC'],
            ['label' => 'Total Study Time', 'value' => '12h 45m', 'icon' => 'ST'],
        ],
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Training Progress</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Track your learning journey and monitor your progress.</p>
        </div>

        <div id="progressStats" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($cards as $card)
                <article class="grid grid-cols-[62px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <span class="grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">{{ $card['icon'] }}</span>
                    <div class="min-w-0">
                        <h2 class="mb-1 text-2xl font-bold text-[#061942]">{{ $card['value'] }}</h2>
                        <p class="mb-2 text-sm font-medium text-[#334b83]">{{ $card['label'] }}</p>
                        <a class="text-xs font-bold text-[#075fe4]" href="#">{{ $card['link'] }} -&gt;</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 text-base font-bold text-[#061942]">Overall Progress</h2>
                <div class="grid items-center gap-6 lg:grid-cols-[190px_minmax(0,1fr)]">
                    <div class="flex h-40 w-40 items-center justify-center rounded-full" style="background: conic-gradient(#075fe4 0 {{ $overall['percent'] }}%, #e9edf5 {{ $overall['percent'] }}% 100%);">
                        <div class="flex h-[118px] w-[118px] flex-col items-center justify-center rounded-full bg-white text-center">
                            <strong class="text-[26px] font-black leading-none text-[#061942]">{{ $overall['percent'] }}%</strong>
                            <small class="mt-2 text-sm font-medium text-[#334b83]">Overall</small>
                        </div>
                    </div>

                    <div class="grid gap-4 border-[#dce7f8] lg:border-l lg:pl-6">
                        @foreach ($overall['items'] as $item)
                            <div class="grid grid-cols-[28px_minmax(0,1fr)_auto] items-center gap-3 text-sm">
                                <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                                <span class="font-medium text-[#334b83]">{{ $item['label'] }}</span>
                                <strong class="font-bold text-[#061942]">{{ $item['value'] }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-5 rounded-lg bg-[#eef5ff] p-4 text-sm font-medium text-[#334b83]">{{ $overall['message'] }}</div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 flex items-center text-base font-bold text-[#061942]">Skill Progress <a class="ml-auto text-xs font-bold text-[#075fe4]" href="#">View All</a></h2>
                <div class="space-y-5">
                    @foreach ($skills as $skill)
                        <div class="grid items-center gap-3 text-sm sm:grid-cols-[120px_minmax(0,1fr)_42px] sm:gap-5">
                            <strong class="font-bold text-[#061942]">{{ $skill['name'] }}</strong>
                            <div class="h-2 overflow-hidden rounded-full bg-[#e9edf5]">
                                <span class="block h-full rounded-full bg-[#075fe4]" style="width: {{ $skill['score'] }}%;"></span>
                            </div>
                            <strong class="font-bold text-[#061942]">{{ $skill['score'] }}%</strong>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="mb-4 flex items-center justify-between gap-4">
                <h2 class="text-base font-bold text-[#061942]">Course Progress</h2>
                <a class="text-xs font-bold text-[#075fe4]" href="/fast-track/courses">View All Courses</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse text-sm">
                    <thead>
                        <tr class="text-left text-[#334b83]">
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Course Name</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Progress</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Percent</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Status</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Last Studied</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody id="progressTableBody">
                        @foreach ($courses as $course)
                            <tr>
                                <td class="border-t border-[#e6eef8] px-3 py-3">
                                    <div class="flex items-center gap-4">
                                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-[#061942] text-[10px] font-black text-white">{{ $course['icon'] }}</span>
                                        <div>
                                            <strong class="font-bold text-[#061942]">{{ $course['name'] }}</strong><br>
                                            <span class="text-xs text-[#536484]">{{ $course['duration'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-t border-[#e6eef8] px-3 py-3">
                                    <div class="h-2 min-w-[130px] overflow-hidden rounded-full bg-[#e9edf5]">
                                        <span class="block h-full rounded-full bg-[#075fe4]" style="width: {{ $course['progress'] }}%;"></span>
                                    </div>
                                </td>
                                <td class="border-t border-[#e6eef8] px-3 py-3 font-bold text-[#061942]">{{ $course['progress'] }}%</td>
                                <td class="border-t border-[#e6eef8] px-3 py-3">
                                    <span class="inline-flex rounded-md px-3 py-1.5 text-xs font-bold {{ $course['status'] === 'Not Started' ? 'bg-[#eef2f8] text-[#334b83]' : 'bg-[#e6fff0] text-[#05843e]' }}">{{ $course['status'] }}</span>
                                </td>
                                <td class="border-t border-[#e6eef8] px-3 py-3 text-[#536484]">{{ $course['last'] }}</td>
                                <td class="border-t border-[#e6eef8] px-3 py-3 text-right text-xl font-bold text-[#075fe4]">...</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const progressStats = document.getElementById('progressStats');
    const progressTableBody = document.getElementById('progressTableBody');

    function renderProgressPage(enrollments) {
        const completed = enrollments.filter((item) => item.enrollment_status === 'completed' || item.training_status === 'completed').length;
        const avg = enrollments.length ? Math.round(enrollments.reduce((sum, item) => sum + FastTrack.progress(item), 0) / enrollments.length) : 0;

        if (progressStats) {
            const stats = [
                ['EC', 'Enrolled Courses', enrollments.length, '/fast-track/training'],
                ['CC', 'Courses Completed', completed, '/fast-track/certificate'],
                ['LC', 'Lessons Completed', avg + '%', '#'],
                ['OP', 'Overall Progress', avg + '%', '#'],
            ];
            progressStats.innerHTML = stats.map(function (stat) {
                return `<article class="grid grid-cols-[62px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <span class="grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">${stat[0]}</span>
                    <div class="min-w-0"><h2 class="mb-1 text-2xl font-bold text-[#061942]">${stat[2]}</h2><p class="mb-2 text-sm font-medium text-[#334b83]">${stat[1]}</p><a class="text-xs font-bold text-[#075fe4]" href="${stat[3]}">View -></a></div>
                </article>`;
            }).join('');
        }

        if (progressTableBody) {
            if (!enrollments.length) {
                progressTableBody.innerHTML = `<tr><td colspan="6" class="border-t border-[#e6eef8] px-3 py-8 text-center text-sm text-[#334b83]">No training progress yet.</td></tr>`;
                return;
            }
            progressTableBody.innerHTML = enrollments.map(function (enrollment) {
                const course = FastTrack.course(enrollment);
                const progress = FastTrack.progress(enrollment);
                return `<tr>
                    <td class="border-t border-[#e6eef8] px-3 py-3"><div class="flex items-center gap-4"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-[#061942] text-[10px] font-black text-white">${FastTrack.initials(FastTrack.courseName(course))}</span><div><strong class="font-bold text-[#061942]">${FastTrack.esc(FastTrack.courseName(course))}</strong><br><span class="text-xs text-[#536484]">${FastTrack.esc(FastTrack.courseDuration(course))}</span></div></div></td>
                    <td class="border-t border-[#e6eef8] px-3 py-3"><div class="h-2 min-w-[130px] overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#075fe4]" style="width:${progress}%;"></span></div></td>
                    <td class="border-t border-[#e6eef8] px-3 py-3 font-bold text-[#061942]">${progress}%</td>
                    <td class="border-t border-[#e6eef8] px-3 py-3"><span class="inline-flex rounded-md px-3 py-1.5 text-xs font-bold bg-[#e6fff0] text-[#05843e]">${FastTrack.esc(FastTrack.statusText(enrollment.training_status || enrollment.enrollment_status))}</span></td>
                    <td class="border-t border-[#e6eef8] px-3 py-3 text-[#536484]">${FastTrack.date(enrollment.updated_at)}</td>
                    <td class="border-t border-[#e6eef8] px-3 py-3 text-right"><a class="font-bold text-[#075fe4]" href="/fast-track/course-details?course=${encodeURIComponent(course.id || '')}">Open</a></td>
                </tr>`;
            }).join('');
        }
    }

    FastTrack.enrollments().then(renderProgressPage).catch(function () {});
</script>
@endpush
