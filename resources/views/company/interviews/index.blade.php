@extends('layouts.company')

@section('title', 'Interviews - OnlyFreshers')
@section('pageTitle', 'Interviews')
@section('pageSubtitle', 'Schedule and manage interviews with candidates.')

@php
    $activePage = 'interviews';

    $interviews = [
        ['name' => 'Rohit Kumar', 'email' => 'rohit.kumar@email.com', 'job' => 'Full Stack Developer', 'type' => 'Technical', 'interviewer' => 'Amit Sharma', 'role' => 'Tech Lead', 'date' => '05 Jun 2024', 'time' => '11:00 AM', 'status' => 'Scheduled', 'avatar' => 'RK', 'interviewerAvatar' => 'A'],
        ['name' => 'Priya Singh', 'email' => 'priya.singh@email.com', 'job' => 'Full Stack Developer', 'type' => 'HR Round', 'interviewer' => 'Ritika Verma', 'role' => 'HR Manager', 'date' => '06 Jun 2024', 'time' => '02:00 PM', 'status' => 'Scheduled', 'avatar' => 'PS', 'interviewerAvatar' => 'R'],
        ['name' => 'Aman Sharma', 'email' => 'aman.sharma@email.com', 'job' => 'React Developer', 'type' => 'Technical', 'interviewer' => 'Sandeep Joshi', 'role' => 'Senior Developer', 'date' => '06 Jun 2024', 'time' => '04:00 PM', 'status' => 'Completed', 'avatar' => 'AS', 'interviewerAvatar' => 'S'],
        ['name' => 'Sneha Patel', 'email' => 'sneha.patel@email.com', 'job' => 'UI/UX Designer', 'type' => 'Design Test', 'interviewer' => 'Pooja Mehta', 'role' => 'Design Lead', 'date' => '07 Jun 2024', 'time' => '10:30 AM', 'status' => 'Completed', 'avatar' => 'SP', 'interviewerAvatar' => 'P'],
        ['name' => 'Karan Mehta', 'email' => 'karan.mehta@email.com', 'job' => 'Backend Developer', 'type' => 'Technical', 'interviewer' => 'Vikram Singh', 'role' => 'Tech Lead', 'date' => '07 Jun 2024', 'time' => '01:30 PM', 'status' => 'Cancelled', 'avatar' => 'KM', 'interviewerAvatar' => 'V'],
        ['name' => 'Anjali Verma', 'email' => 'anjali.verma@email.com', 'job' => 'UI/UX Designer', 'type' => 'HR Round', 'interviewer' => 'Ritika Verma', 'role' => 'HR Manager', 'date' => '08 Jun 2024', 'time' => '11:00 AM', 'status' => 'Scheduled', 'avatar' => 'AV', 'interviewerAvatar' => 'R'],
    ];

    $jobs = ['All Jobs', 'Full Stack Developer', 'React Developer', 'UI/UX Designer', 'Backend Developer'];
    $interviewers = ['All Interviewers', 'Amit Sharma', 'Ritika Verma', 'Sandeep Joshi', 'Pooja Mehta', 'Vikram Singh'];

    $typeClasses = [
        'Technical' => 'bg-[#eaf2ff] text-[#075fe4]',
        'HR Round' => 'bg-[#dbf8e9] text-[#00a65a]',
        'Design Test' => 'bg-[#f1e6ff] text-[#8a35db]',
    ];

    $statusClasses = [
        'Scheduled' => 'bg-[#fff0d1] text-[#c86b00]',
        'Completed' => 'bg-[#dbf8e9] text-[#00a65a]',
        'Cancelled' => 'bg-[#ffe8eb] text-[#ff3045]',
    ];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
        <div class="mb-[22px] flex flex-col gap-[18px] border-b border-[#dce7f8] pb-3.5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-wrap gap-x-6 gap-y-2 xl:gap-x-[34px]" role="tablist" aria-label="Interview status tabs">
                <button class="interview-tab border-b-[3px] border-[#075fe4] px-3.5 py-2.5 text-[13px] font-semibold text-[#075fe4]" data-status="All" type="button">All Interviews (<span id="allCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="Scheduled" type="button">Scheduled (<span id="scheduledCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="Completed" type="button">Completed (<span id="completedCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="Cancelled" type="button">Cancelled (<span id="cancelledCount">0</span>)</button>
            </div>

            <a href="/company/interviews/create" class="inline-flex h-[42px] w-[180px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">+ Schedule Interview</a>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_190px_240px_120px]">
            <input id="searchInput" type="search" placeholder="Search by candidate name or job role..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($jobs as $job)
                    <option>{{ $job }}</option>
                @endforeach
            </select>

            <select id="interviewerFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($interviewers as $person)
                    <option>{{ $person }}</option>
                @endforeach
            </select>

            <button type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Filters
            </button>
        </div>

        <div class="overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[980px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Interview Type</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Interviewer</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Date & Time</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Status</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interviews as $interview)
                        <tr class="interview-row border-b border-[#edf2fb] last:border-b-0" data-name="{{ strtolower($interview['name'].' '.$interview['job']) }}" data-job="{{ $interview['job'] }}" data-interviewer="{{ $interview['interviewer'] }}" data-status="{{ $interview['status'] }}">
                            <td class="px-4 py-4 align-middle text-[13px]">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">{{ $interview['avatar'] }}</div>
                                    <div class="min-w-0">
                                        <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">{{ $interview['name'] }}</h3>
                                        <p class="text-xs text-[#52607a]">{{ $interview['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 align-middle text-[13px] text-[#061942]">{{ $interview['job'] }}</td>
                            <td class="px-4 py-4 align-middle text-[13px]">
                                <span class="inline-flex h-[30px] min-w-[72px] items-center justify-center rounded-lg px-2.5 text-xs font-bold {{ $typeClasses[$interview['type']] }}">{{ $interview['type'] }}</span>
                            </td>
                            <td class="px-4 py-4 align-middle text-[13px]">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-[34px] w-[34px] shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#075fe4] to-[#9b51e0] text-xs font-bold text-white">{{ $interview['interviewerAvatar'] }}</div>
                                    <div class="min-w-0">
                                        <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">{{ $interview['interviewer'] }}</h3>
                                        <p class="text-xs text-[#52607a]">{{ $interview['role'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 align-middle text-[13px] text-[#061942]"><div class="mb-1.5">{{ $interview['date'] }}</div><span>{{ $interview['time'] }}</span></td>
                            <td class="px-4 py-4 align-middle text-[13px]">
                                <span class="inline-flex h-[30px] min-w-[72px] items-center justify-center rounded-lg px-2.5 text-xs font-bold {{ $statusClasses[$interview['status']] }}">{{ $interview['status'] }}</span>
                            </td>
                            <td class="px-4 py-4 align-middle text-[13px]"><a href="/company/interviews/show" class="text-[22px] leading-none text-[#061942]" aria-label="View interview details">&#8942;</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Showing 1 to 6 of 8 interviews</span>
            <div class="flex items-center gap-2.5">
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8249;</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#075fe4] bg-[#075fe4] font-bold text-white" type="button">1</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">2</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8250;</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const rows = document.querySelectorAll('.interview-row');
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const interviewerFilter = document.getElementById('interviewerFilter');
    const resultText = document.getElementById('resultText');
    let activeStatus = 'All';

    function count(status) {
        if (status === 'All') return rows.length;
        return Array.from(rows).filter(function (row) { return row.dataset.status === status; }).length;
    }

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        const job = jobFilter.value;
        const interviewer = interviewerFilter.value;
        let visible = 0;

        rows.forEach(function (row) {
            const matchesStatus = activeStatus === 'All' || row.dataset.status === activeStatus;
            const matchesSearch = row.dataset.name.includes(search);
            const matchesJob = job === 'All Jobs' || row.dataset.job === job;
            const matchesInterviewer = interviewer === 'All Interviewers' || row.dataset.interviewer === interviewer;
            const show = matchesStatus && matchesSearch && matchesJob && matchesInterviewer;
            row.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        resultText.textContent = 'Showing 1 to ' + visible + ' of 8 interviews';
    }

    document.getElementById('allCount').textContent = count('All');
    document.getElementById('scheduledCount').textContent = count('Scheduled');
    document.getElementById('completedCount').textContent = count('Completed');
    document.getElementById('cancelledCount').textContent = count('Cancelled');

    document.querySelectorAll('.interview-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.interview-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#24344f]');
            });

            tab.classList.remove('border-transparent', 'text-[#24344f]');
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            activeStatus = tab.dataset.status;
            filterRows();
        });
    });

    searchInput.addEventListener('input', filterRows);
    jobFilter.addEventListener('change', filterRows);
    interviewerFilter.addEventListener('change', filterRows);
</script>
@endpush



