@extends('layouts.fast-track')

@section('title', 'My Training')

@php
    $activePage = 'training';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $courses = [
        ['title' => 'Full Stack Development', 'text' => 'Build modern web applications', 'status' => 'In Progress', 'progress' => 45, 'color' => '#24249c'],
        ['title' => 'Data Science & Analytics', 'text' => 'Analyze data and build solutions', 'status' => 'In Progress', 'progress' => 30, 'color' => '#6041db'],
        ['title' => 'Digital Marketing', 'text' => 'Master online marketing skills', 'status' => 'Not Started', 'progress' => 0, 'color' => '#44bda9'],
        ['title' => 'Backend Development', 'text' => 'Learn server-side development', 'status' => 'Not Started', 'progress' => 0, 'color' => '#ffad34'],
    ];

    $activity = [
        ['title' => 'Completed lesson "HTML Forms and Inputs"', 'course' => 'Full Stack Development', 'time' => '2 hours ago', 'icon' => 'OK'],
        ['title' => 'Started lesson "Data Cleaning Basics"', 'course' => 'Data Science & Analytics', 'time' => '1 day ago', 'icon' => 'ST'],
        ['title' => 'Enrolled in "Digital Marketing"', 'course' => '', 'time' => '3 days ago', 'icon' => 'EN'],
        ['title' => 'Completed lesson "Introduction to React"', 'course' => 'Full Stack Development', 'time' => '5 days ago', 'icon' => 'OK'],
    ];

    $overall = 38;
@endphp

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">My Training</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">Continue learning and track your enrolled courses.</p>
            </div>
            <a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" href="/fast-track/courses">Browse Courses</a>
        </div>

        <div class="flex gap-8 overflow-x-auto border-b border-[#dce7f8]">
            <button class="training-tab shrink-0 border-b-[3px] border-[#075fe4] pb-3 text-sm font-bold text-[#075fe4]" type="button" data-filter="all">Enrolled Courses</button>
            <button class="training-tab shrink-0 border-b-[3px] border-transparent pb-3 text-sm font-bold text-[#334b83]" type="button" data-filter="progress">Learning Progress</button>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4" id="trainingGrid">
            @foreach ($courses as $course)
                @php
                    $initials = collect(explode(' ', $course['title']))->map(fn ($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('');
                @endphp
                <article class="training-card overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]" data-progress="{{ $course['progress'] }}">
                    <div class="relative h-[135px] p-4" style="background: linear-gradient(135deg, {{ $course['color'] }}, #dff5ff);">
                        <span class="inline-flex rounded-lg {{ $course['progress'] > 0 ? 'bg-[#e6fff0] text-[#05843e]' : 'bg-white/90 text-[#334b83]' }} px-3 py-1.5 text-xs font-bold">{{ $course['status'] }}</span>
                        <span class="float-right rounded-full bg-white px-2.5 py-2 text-xs font-black text-[#075fe4]">{{ $course['progress'] }}%</span>
                        <h4 class="absolute bottom-7 left-5 text-4xl font-black text-white">{{ $initials }}</h4>
                    </div>
                    <div class="p-5">
                        <h3 class="mb-2 text-base font-bold text-[#061942]">{{ $course['title'] }}</h3>
                        <p class="mb-5 text-sm leading-6 text-[#334b83]">{{ $course['text'] }}</p>
                        <div class="mb-3 h-2 overflow-hidden rounded-full bg-[#e9edf5]">
                            <span class="block h-full rounded-full bg-[#075fe4]" style="width: {{ $course['progress'] }}%;"></span>
                        </div>
                        <small class="text-xs font-medium text-[#334b83]">{{ $course['progress'] }}% Completed</small>
                        <div class="mt-5 grid grid-cols-[1fr_44px] gap-3">
                            <a class="inline-flex h-[38px] items-center justify-center rounded-lg border border-[#075fe4] text-sm font-bold {{ $loop->first ? 'bg-[#075fe4] text-white' : 'bg-white text-[#075fe4] hover:bg-[#eff5ff]' }}" href="/fast-track/course-details">{{ $course['progress'] ? 'Continue Learning' : 'Start Learning' }}</a>
                            <button class="h-[38px] rounded-lg border border-[#dce7f8] bg-white text-xs font-black text-[#061942] hover:bg-[#f5f8ff]" type="button">BM</button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.05fr_1fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 flex items-center gap-3 text-lg font-bold text-[#061942]"><span class="grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">OP</span> Overall Progress</h2>
                <div class="grid items-center gap-7 md:grid-cols-[180px_minmax(0,1fr)]">
                    <div class="flex h-[150px] w-[150px] items-center justify-center rounded-full" style="background: conic-gradient(#075fe4 0 {{ $overall }}%, #e9edf5 {{ $overall }}% 100%);">
                        <span class="flex h-[110px] w-[110px] flex-col items-center justify-center rounded-full bg-white text-center text-[26px] font-black leading-tight text-[#061942]">{{ $overall }}%<small class="text-xs font-bold text-[#536484]">Overall</small></span>
                    </div>
                    <div class="grid gap-4">
                        <p class="text-sm font-medium text-[#334b83]">Keep going! You are doing great.</p>
                        <div class="grid grid-cols-[1fr_auto] gap-5 text-sm"><span>Courses Enrolled</span><strong>4</strong></div>
                        <div class="grid grid-cols-[1fr_auto] gap-5 text-sm"><span>Courses Completed</span><strong>0</strong></div>
                        <div class="grid grid-cols-[1fr_auto] gap-5 text-sm"><span>Total Lessons Completed</span><strong>28/74</strong></div>
                        <div class="grid grid-cols-[1fr_auto] gap-5 text-sm"><span>Total Study Time</span><strong>12h 45m</strong></div>
                    </div>
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-5 flex items-center gap-3 text-lg font-bold text-[#061942]"><span class="grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">RA</span> Recent Activity <a class="ml-auto text-xs font-bold text-[#075fe4]" href="#">View All</a></h2>
                <div>
                    @foreach ($activity as $item)
                        <div class="grid grid-cols-[38px_minmax(0,1fr)] items-center gap-4 border-b border-[#e6eef8] py-3 last:border-b-0 sm:grid-cols-[38px_minmax(0,1fr)_auto]">
                            <span class="grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                            <div>
                                <h3 class="mb-1 text-sm font-bold text-[#061942]">{{ $item['title'] }}</h3>
                                <p class="text-xs text-[#536484]">{{ $item['course'] }}</p>
                            </div>
                            <time class="col-start-2 text-xs text-[#536484] sm:col-start-auto">{{ $item['time'] }}</time>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.training-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.training-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#334b83]');
            });

            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            tab.classList.remove('border-transparent', 'text-[#334b83]');

            document.querySelectorAll('.training-card').forEach(function (card) {
                const progress = Number(card.dataset.progress || 0);
                card.classList.toggle('hidden', tab.dataset.filter === 'progress' && progress <= 0);
            });
        });
    });
</script>
@endpush
