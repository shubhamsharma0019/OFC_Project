@extends('layouts.company')

@section('title', 'Applications - OnlyFreshers')
@section('pageTitle', 'Applications')
@section('pageSubtitle', 'Review all applications received for your posted jobs.')

@php
    $activePage = 'applications';

    $applications = [
        ['name' => 'Rohit Kumar', 'email' => 'rohit.kumar@email.com', 'job' => 'Full Stack Developer', 'posted' => '01 Jun 2024', 'experience' => '0 - 1 Year', 'status' => 'New', 'date' => '02 Jun 2024', 'avatar' => 'RK'],
        ['name' => 'Anjali Verma', 'email' => 'anjali.verma@email.com', 'job' => 'UI/UX Designer', 'posted' => '10 May 2024', 'experience' => '1 - 2 Years', 'status' => 'Under Review', 'date' => '01 Jun 2024', 'avatar' => 'AV'],
        ['name' => 'Priya Singh', 'email' => 'priya.singh@email.com', 'job' => 'Full Stack Developer', 'posted' => '01 Jun 2024', 'experience' => '0 - 1 Year', 'status' => 'Shortlisted', 'date' => '31 May 2024', 'avatar' => 'PS'],
        ['name' => 'Aman Sharma', 'email' => 'aman.sharma@email.com', 'job' => 'React Developer', 'posted' => '25 May 2024', 'experience' => '0 - 1 Year', 'status' => 'Shortlisted', 'date' => '29 May 2024', 'avatar' => 'AS'],
        ['name' => 'Sneha Patel', 'email' => 'sneha.patel@email.com', 'job' => 'UI/UX Designer', 'posted' => '10 May 2024', 'experience' => '1 - 3 Years', 'status' => 'Rejected', 'date' => '30 May 2024', 'avatar' => 'SP'],
        ['name' => 'Karan Mehta', 'email' => 'karan.mehta@email.com', 'job' => 'Backend Developer', 'posted' => '05 Jun 2024', 'experience' => '1 - 3 Years', 'status' => 'New', 'date' => '06 Jun 2024', 'avatar' => 'KM'],
    ];

    $jobs = ['All Jobs', 'Full Stack Developer', 'UI/UX Designer', 'React Developer', 'Backend Developer'];
    $statuses = ['All Status', 'New', 'Under Review', 'Shortlisted', 'Rejected'];

    $statusClasses = [
        'New' => 'bg-[#eaf2ff] text-[#075fe4]',
        'Under Review' => 'bg-[#eaf2ff] text-[#075fe4]',
        'Shortlisted' => 'bg-[#dbf8e9] text-[#00a65a]',
        'Rejected' => 'bg-[#ffe8eb] text-[#ff3045]',
    ];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div class="mb-[26px] grid grid-cols-1 gap-[18px] lg:grid-cols-[170px_170px_minmax(0,1fr)_120px]">
            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($jobs as $job)
                    <option>{{ $job }}</option>
                @endforeach
            </select>

            <select id="statusFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($statuses as $status)
                    <option>{{ $status }}</option>
                @endforeach
            </select>

            <input id="searchInput" type="search" placeholder="Search by name or skills..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <button type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#24344f] transition hover:bg-[#f5f9ff]">
                Filters
            </button>
        </div>

        <div class="overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[900px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Experience</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Status</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Applied Date</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody id="applicationBody">
                    @foreach ($applications as $app)
                        <tr class="application-row border-b border-[#edf2fb] last:border-b-0" data-name="{{ strtolower($app['name'].' '.$app['email']) }}" data-job="{{ $app['job'] }}" data-status="{{ $app['status'] }}">
                            <td class="px-5 py-[18px] align-middle text-[13px]">
                                <div class="flex items-center gap-3.5">
                                    <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">
                                        {{ $app['avatar'] }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">{{ $app['name'] }}</h3>
                                        <p class="text-xs text-[#52607a]">{{ $app['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-[18px] align-middle text-[13px]">
                                <div>
                                    <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">{{ $app['job'] }}</h3>
                                    <p class="text-xs text-[#52607a]">Posted on {{ $app['posted'] }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-[18px] align-middle text-[13px] text-[#24344f]">{{ $app['experience'] }}</td>
                            <td class="px-5 py-[18px] align-middle text-[13px]">
                                <span class="inline-flex h-[30px] min-w-[68px] items-center justify-center rounded-lg px-3 text-xs font-bold {{ $statusClasses[$app['status']] }}">
                                    {{ $app['status'] }}
                                </span>
                            </td>
                            <td class="px-5 py-[18px] align-middle text-[13px] text-[#24344f]">{{ $app['date'] }}</td>
                            <td class="px-5 py-[18px] align-middle text-[13px]">
                                <a href="/company/applications/show" class="text-[22px] leading-none text-[#061942]" aria-label="View application details">&#8942;</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Showing 1 to 6 of 56 applications</span>
            <div class="flex items-center gap-2.5">
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8249;</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#075fe4] bg-[#075fe4] font-bold text-white" type="button">1</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">2</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">3</button>
                <span>...</span>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">10</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8250;</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const jobFilter = document.getElementById('jobFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.application-row');
    const resultText = document.getElementById('resultText');

    function filterApplications() {
        const job = jobFilter.value;
        const status = statusFilter.value;
        const search = searchInput.value.toLowerCase();
        let count = 0;

        rows.forEach(function (row) {
            const matchJob = job === 'All Jobs' || row.dataset.job === job;
            const matchStatus = status === 'All Status' || row.dataset.status === status;
            const matchSearch = row.dataset.name.includes(search);
            const show = matchJob && matchStatus && matchSearch;

            row.style.display = show ? '' : 'none';
            if (show) count++;
        });

        resultText.textContent = 'Showing 1 to ' + count + ' of 56 applications';
    }

    jobFilter.addEventListener('change', filterApplications);
    statusFilter.addEventListener('change', filterApplications);
    searchInput.addEventListener('input', filterApplications);
</script>
@endpush

