@extends('layouts.company')

@section('title', 'Hired Candidates - OnlyFreshers')
@section('pageTitle', 'Hired Candidates')
@section('pageSubtitle', 'View and manage all candidates you have hired.')

@php
    $activePage = 'hired';

    $hires = [
        ['name' => 'Rohit Kumar', 'email' => 'rohit.kumar@email.com', 'job' => 'Full Stack Developer', 'department' => 'Engineering', 'date' => '03 Jun 2024', 'package' => 'Rs. 6.00 LPA', 'status' => 'Active', 'avatar' => 'RK'],
        ['name' => 'Priya Singh', 'email' => 'priya.singh@email.com', 'job' => 'Full Stack Developer', 'department' => 'Engineering', 'date' => '04 Jun 2024', 'package' => 'Rs. 5.50 LPA', 'status' => 'Active', 'avatar' => 'PS'],
        ['name' => 'Aman Sharma', 'email' => 'aman.sharma@email.com', 'job' => 'React Developer', 'department' => 'Engineering', 'date' => '06 Jun 2024', 'package' => 'Rs. 6.25 LPA', 'status' => 'Active', 'avatar' => 'AS'],
        ['name' => 'Sneha Patel', 'email' => 'sneha.patel@email.com', 'job' => 'UI/UX Designer', 'department' => 'Design', 'date' => '07 Jun 2024', 'package' => 'Rs. 4.80 LPA', 'status' => 'Active', 'avatar' => 'SP'],
        ['name' => 'Karan Mehta', 'email' => 'karan.mehta@email.com', 'job' => 'Backend Developer', 'department' => 'Engineering', 'date' => '08 Jun 2024', 'package' => 'Rs. 6.00 LPA', 'status' => 'Active', 'avatar' => 'KM'],
        ['name' => 'Anjali Verma', 'email' => 'anjali.verma@email.com', 'job' => 'UI/UX Designer', 'department' => 'Design', 'date' => '10 Jun 2024', 'package' => 'Rs. 4.75 LPA', 'status' => 'Active', 'avatar' => 'AV'],
    ];

    $jobs = ['All Jobs', 'Full Stack Developer', 'React Developer', 'UI/UX Designer', 'Backend Developer'];
    $departments = ['All Departments', 'Engineering', 'Design'];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div class="mb-[26px] grid grid-cols-1 gap-[18px] lg:grid-cols-[minmax(0,1fr)_220px_220px_120px]">
            <input id="searchInput" type="search" placeholder="Search by name or job role..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($jobs as $job)
                    <option>{{ $job }}</option>
                @endforeach
            </select>

            <select id="departmentFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($departments as $department)
                    <option>{{ $department }}</option>
                @endforeach
            </select>

            <button type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Filters
            </button>
        </div>

        <div class="overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[900px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Department</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Date of Joining</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Package</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Status</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hires as $hire)
                        <tr class="hire-row border-b border-[#edf2fb] last:border-b-0" data-name="{{ strtolower($hire['name'].' '.$hire['job']) }}" data-job="{{ $hire['job'] }}" data-department="{{ $hire['department'] }}">
                            <td class="px-4 py-[18px] align-middle text-[13px]">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">{{ $hire['avatar'] }}</div>
                                    <div class="min-w-0">
                                        <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">{{ $hire['name'] }}</h3>
                                        <p class="text-xs text-[#52607a]">{{ $hire['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-[18px] align-middle text-[13px] text-[#061942]">{{ $hire['job'] }}</td>
                            <td class="px-4 py-[18px] align-middle text-[13px] text-[#24344f]">{{ $hire['department'] }}</td>
                            <td class="px-4 py-[18px] align-middle text-[13px] text-[#24344f]">{{ $hire['date'] }}</td>
                            <td class="px-4 py-[18px] align-middle text-[13px] font-bold text-[#061942]">{{ $hire['package'] }}</td>
                            <td class="px-4 py-[18px] align-middle text-[13px]">
                                <span class="inline-flex h-[30px] min-w-[62px] items-center justify-center rounded-lg bg-[#dbf8e9] px-3 text-xs font-bold text-[#00a65a]">{{ $hire['status'] }}</span>
                            </td>
                            <td class="px-4 py-[18px] align-middle text-[13px]">
                                <a href="/company/applications/show" class="text-[22px] leading-none text-[#061942]" aria-label="View candidate details">&#8942;</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Showing 1 to 6 of 6 hired candidates</span>
            <div class="flex items-center gap-2.5">
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8249;</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#075fe4] bg-[#075fe4] font-bold text-white" type="button">1</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8250;</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const departmentFilter = document.getElementById('departmentFilter');
    const rows = document.querySelectorAll('.hire-row');
    const resultText = document.getElementById('resultText');

    function filterHires() {
        const search = searchInput.value.toLowerCase();
        const job = jobFilter.value;
        const department = departmentFilter.value;
        let count = 0;

        rows.forEach(function (row) {
            const matchSearch = row.dataset.name.includes(search);
            const matchJob = job === 'All Jobs' || row.dataset.job === job;
            const matchDepartment = department === 'All Departments' || row.dataset.department === department;
            const show = matchSearch && matchJob && matchDepartment;

            row.style.display = show ? '' : 'none';
            if (show) count++;
        });

        resultText.textContent = 'Showing 1 to ' + count + ' of 6 hired candidates';
    }

    searchInput.addEventListener('input', filterHires);
    jobFilter.addEventListener('change', filterHires);
    departmentFilter.addEventListener('change', filterHires);
</script>
@endpush

