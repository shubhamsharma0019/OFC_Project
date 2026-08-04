@extends('layouts.training-partner')

@section('title', 'Training Partner Dashboard')

@php
    $activePage = 'dashboard';
    $partnerName = 'CodeAcademy';

    $stats = [
        ['label' => 'Total Courses', 'value' => '12', 'hint' => 'Active', 'icon' => 'TC'],
        ['label' => 'Total Enrollments', 'value' => '1,250', 'hint' => 'All Courses', 'icon' => 'TE'],
        ['label' => 'Active Students', 'value' => '820', 'hint' => 'Currently Learning', 'icon' => 'AS'],
        ['label' => 'Completed Students', 'value' => '430', 'hint' => 'All Courses', 'icon' => 'CS'],
    ];

    $activities = [
        ['title' => 'New Course Added', 'text' => 'React for Beginners', 'time' => '2 min ago', 'icon' => 'NC'],
        ['title' => 'New Enrollment', 'text' => 'Ananya Gupta enrolled in Full Stack Development', 'time' => '15 min ago', 'icon' => 'NE'],
        ['title' => 'Progress Updated', 'text' => 'Priya Singh completed 40% in React', 'time' => '30 min ago', 'icon' => 'PU'],
        ['title' => 'Assessment Submitted', 'text' => 'Rohit Kumar submitted in HTML Assignment', 'time' => '1 hour ago', 'icon' => 'AS'],
    ];

    $chart = [
        ['label' => '1 May', 'value' => 250],
        ['label' => '8 May', 'value' => 760],
        ['label' => '15 May', 'value' => 1050],
        ['label' => '22 May', 'value' => 780],
        ['label' => '26 May', 'value' => 1320],
        ['label' => '29 May', 'value' => 1580],
    ];

    $performance = [
        ['label' => 'Total Enrollments', 'value' => '1,250', 'growth' => '12%', 'icon' => 'TE'],
        ['label' => 'Course Completions', 'value' => '430', 'growth' => '15%', 'icon' => 'CC'],
        ['label' => 'Assessments Submitted', 'value' => '980', 'growth' => '10%', 'icon' => 'AS'],
    ];

    $actions = [
        ['title' => 'Add New Course', 'text' => 'Create and publish a new course', 'icon' => '+', 'url' => '/training-partner/add-course'],
        ['title' => 'View Enrollments', 'text' => 'See all students and their progress', 'icon' => 'EN', 'url' => '/training-partner/enrollments'],
        ['title' => 'Review Assessments', 'text' => 'Evaluate and provide feedback', 'icon' => 'RA', 'url' => '/training-partner/assessments'],
        ['title' => 'Check Reports', 'text' => 'View detailed reports and analytics', 'icon' => 'RP', 'url' => '/training-partner/reports'],
    ];
@endphp

@section('content')
    <div class="mb-6">
        <h1 class="mb-2.5 text-[30px] font-extrabold leading-tight text-[#0a1748]">Training Partner Dashboard</h1>
        <p class="m-0 text-[15px] text-[#526287]">Welcome back, <strong class="text-[#5b2ce1]">{{ $partnerName }}!</strong></p>
    </div>

    <section class="mb-[18px] grid grid-cols-1 gap-[18px] md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <article class="grid min-h-[142px] grid-cols-[62px_minmax(0,1fr)] items-center gap-[18px] rounded-[10px] border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)] max-[720px]:min-h-[110px]">
                <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">{{ $stat['icon'] }}</span>
                <div class="min-w-0">
                    <p class="mb-3 text-[13px] text-[#526287]">{{ $stat['label'] }}</p>
                    <h2 class="mb-3 text-[30px] font-extrabold leading-none text-[#0a1748]">{{ $stat['value'] }}</h2>
                    <small class="text-[13px] font-extrabold text-[#089845]">{{ $stat['hint'] }}</small>
                </div>
            </article>
        @endforeach
    </section>

    <section class="mb-[18px] grid grid-cols-1 gap-[18px] xl:grid-cols-[1fr_1.14fr]">
        <article class="rounded-[10px] border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="mb-[18px] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">RA</span>
                    <h2 class="m-0 text-[17px] font-extrabold text-[#0a1748]">Recent Activity</h2>
                </div>
                <a href="/training-partner/notifications" class="text-xs font-extrabold text-[#5b2ce1]">View All Activity</a>
            </div>

            <div class="relative grid before:absolute before:bottom-6 before:left-1.5 before:top-6 before:w-px before:bg-[#dddff0]">
                @foreach ($activities as $activity)
                    <div class="relative grid grid-cols-[56px_minmax(0,1fr)_auto] items-center gap-3.5 border-b border-[#edf0f8] py-3.5 last:border-b-0 max-[720px]:grid-cols-[48px_minmax(0,1fr)]">
                        <span class="absolute left-[-21px] h-1.5 w-1.5 rounded-full bg-[#d9d0ff]"></span>
                        <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1] max-[720px]:h-12 max-[720px]:w-12">{{ $activity['icon'] }}</span>
                        <div class="min-w-0">
                            <h3 class="mb-[7px] text-sm font-extrabold text-[#0a1748]">{{ $activity['title'] }}</h3>
                            <p class="m-0 text-xs text-[#526287]">{{ $activity['text'] }}</p>
                        </div>
                        <time class="text-xs text-[#526287] max-[720px]:col-start-2">{{ $activity['time'] }}</time>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="rounded-[10px] border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="mb-[18px] flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">CP</span>
                    <h2 class="m-0 text-[17px] font-extrabold text-[#0a1748]">Course Performance Overview</h2>
                </div>
                <select id="courseFilter" class="h-9 rounded-[7px] border border-[#dddff0] bg-white px-3 text-xs font-extrabold text-[#26375f] outline-none">
                    <option>All Courses</option>
                    <option>React for Beginners</option>
                    <option>Full Stack Development</option>
                </select>
            </div>

            <div class="pb-1.5 pt-0.5">
                <div class="mb-3 text-[13px] font-extrabold text-[#0a1748]">Enrollment Trend (This Month)</div>
                <svg class="h-[190px] w-full" id="chart" viewBox="0 0 620 190" preserveAspectRatio="none"></svg>
            </div>

            <div class="mt-3.5 grid overflow-hidden rounded-[9px] border border-[#dddff0] md:grid-cols-3">
                @foreach ($performance as $item)
                    <div class="grid grid-cols-[50px_minmax(0,1fr)] items-center gap-3 border-b border-[#dddff0] p-4 last:border-b-0 md:border-b-0 md:border-r md:last:border-r-0">
                        <span class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">{{ $item['icon'] }}</span>
                        <div class="min-w-0">
                            <strong class="text-[15px] font-extrabold text-[#0a1748]">{{ $item['value'] }}</strong>
                            <p class="my-[3px] text-[11px] text-[#526287]">{{ $item['label'] }}</p>
                            <small class="text-[11px] font-extrabold text-[#08a04b]">? {{ $item['growth'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <article class="mt-[18px] rounded-[10px] border border-[#dddff0] bg-white p-[22px] shadow-[0_12px_26px_rgba(50,35,120,.05)]">
        <div class="mb-4 flex items-center gap-3.5">
            <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] bg-[#f0eaff] text-[11px] font-black text-[#5b2ce1]">QA</span>
            <h2 class="m-0 text-[17px] font-extrabold text-[#0a1748]">Quick Actions</h2>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($actions as $action)
                <a class="grid grid-cols-[56px_minmax(0,1fr)_22px] items-center gap-3 rounded-[9px] border border-[#dddff0] bg-white p-[18px] text-inherit no-underline" href="{{ $action['url'] }}">
                    <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-[14px] {{ $loop->first ? 'bg-[#7b45ee] text-[28px] text-white' : 'bg-[#f0eaff] text-[11px] text-[#5b2ce1]' }} font-black">{{ $action['icon'] }}</span>
                    <div class="min-w-0">
                        <h3 class="mb-1.5 text-sm font-extrabold text-[#0a1748]">{{ $action['title'] }}</h3>
                        <p class="m-0 text-xs leading-normal text-[#526287]">{{ $action['text'] }}</p>
                    </div>
                    <span class="text-[22px] font-black text-[#5b2ce1]">›</span>
                </a>
            @endforeach
        </div>
    </article>
@endsection

@push('scripts')
    <script>
        const chartData = @json($chart);

        function renderChart(data) {
            const svg = document.getElementById('chart');
            const max = Math.max(...data.map(item => item.value));
            const points = data.map((item, index) => {
                const x = 38 + index * ((620 - 76) / (data.length - 1));
                const y = 150 - (item.value / max) * 120;
                return { ...item, x, y };
            });
            const line = points.map(point => `${point.x},${point.y}`).join(' ');
            const area = `38,150 ${line} ${points[points.length - 1].x},150`;

            svg.innerHTML = `
                <defs><linearGradient id="fillPurple" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#7b45ee" stop-opacity=".22"/><stop offset="1" stop-color="#7b45ee" stop-opacity="0"/></linearGradient></defs>
                <line x1="38" y1="30" x2="38" y2="150" stroke="#e5e9f4"/>
                <line x1="38" y1="150" x2="592" y2="150" stroke="#e5e9f4"/>
                <text x="8" y="34" font-size="11" fill="#526287">1.5K</text><text x="16" y="92" font-size="11" fill="#526287">1K</text><text x="16" y="150" font-size="11" fill="#526287">500</text>
                <polygon points="${area}" fill="url(#fillPurple)"></polygon>
                <polyline points="${line}" fill="none" stroke="#6a2df0" stroke-width="3"></polyline>
                ${points.map(point => `<circle cx="${point.x}" cy="${point.y}" r="5" fill="#6a2df0"></circle><text x="${point.x - 18}" y="178" font-size="11" fill="#526287">${point.label}</text>`).join('')}
            `;
        }

        document.getElementById('courseFilter')?.addEventListener('change', event => {
            const shifted = event.target.value === 'All Courses'
                ? chartData
                : chartData.map((item, index) => ({ ...item, value: Math.max(120, item.value - (index + 1) * 80) }));
            renderChart(shifted);
        });

        renderChart(chartData);
    </script>
@endpush
