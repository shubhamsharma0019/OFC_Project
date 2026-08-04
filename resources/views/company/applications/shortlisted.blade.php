@extends('layouts.company')

@section('title', 'Shortlisted Candidates - OnlyFreshers')
@section('pageTitle', 'Shortlisted Candidates')
@section('pageSubtitle', 'View and manage all candidates you have shortlisted.')

@php
    $activePage = 'shortlisted';

    $candidates = [
        ['name' => 'Rohit Kumar', 'role' => 'Full Stack Developer', 'education' => 'Tech', 'experience' => '0 - 1 Year', 'score' => 85, 'date' => '02 Jun 2024', 'avatar' => 'RK'],
        ['name' => 'Priya Singh', 'role' => 'Full Stack Developer', 'education' => 'Tech', 'experience' => '0 - 1 Year', 'score' => 78, 'date' => '31 May 2024', 'avatar' => 'PS'],
        ['name' => 'Aman Sharma', 'role' => 'React Developer', 'education' => 'BCA', 'experience' => '0 - 1 Year', 'score' => 75, 'date' => '29 May 2024', 'avatar' => 'AS'],
        ['name' => 'Sneha Patel', 'role' => 'Full Stack Developer', 'education' => 'BCA', 'experience' => '0 - 1 Year', 'score' => 45, 'date' => '30 May 2024', 'avatar' => 'SP'],
    ];

    $jobs = ['All Jobs', 'Full Stack Developer', 'React Developer'];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div class="mb-[26px] grid grid-cols-1 gap-[18px] lg:grid-cols-[minmax(0,1fr)_240px_120px_190px]">
            <input id="searchInput" type="search" placeholder="Search by name or skills..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($jobs as $job)
                    <option>{{ $job }}</option>
                @endforeach
            </select>

            <button type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Filters
            </button>

            <button id="viewAll" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                View All Shortlisted
            </button>
        </div>

        <div id="candidateList" class="grid gap-3">
            @foreach ($candidates as $candidate)
                @php
                    $scoreColor = $candidate['score'] < 50 ? '#ff4d57' : '#33c477';
                    $trackColor = $candidate['score'] < 50 ? '#ffd9dc' : '#d9f2e5';
                @endphp

                <article class="candidate-row grid min-h-[126px] grid-cols-1 gap-5 rounded-lg border border-[#dce7f8] p-5 lg:grid-cols-[minmax(0,1fr)_180px_170px] lg:items-center lg:gap-6" data-name="{{ strtolower($candidate['name'].' '.$candidate['role'].' '.$candidate['education']) }}" data-job="{{ $candidate['role'] }}">
                    <div class="flex items-center gap-5 sm:gap-[22px]">
                        <div class="flex h-[72px] w-[72px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-base font-bold text-[#075fe4] sm:h-[86px] sm:w-[86px] sm:text-lg">
                            {{ $candidate['avatar'] }}
                        </div>

                        <div class="min-w-0">
                            <h3 class="mb-2 text-base font-bold text-[#061942]">{{ $candidate['name'] }}</h3>
                            <p class="mb-2 text-sm text-[#24344f]">{{ $candidate['role'] }}</p>
                            <div class="flex flex-wrap gap-3 text-[13px] text-[#24344f]">
                                <span>{{ $candidate['education'] }}</span>
                                <span>&bull;</span>
                                <span>{{ $candidate['experience'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 text-xs font-bold text-[#061942]">Match Score</p>
                        <div class="relative flex h-[82px] w-[82px] items-center justify-center rounded-full text-base font-bold {{ $scoreRingClass }}">
                            <span class="absolute inset-[7px] rounded-full bg-white"></span>
                            <span class="relative z-10">{{ $candidate['score'] }}%</span>
                        </div>
                    </div>

                    <div class="text-[13px] leading-relaxed text-[#061942]">
                        Shortlisted on<br>
                        {{ $candidate['date'] }}
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Showing 1 to 4 of 12 shortlisted candidates</span>
            <div class="flex items-center gap-2.5">
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8249;</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#075fe4] bg-[#075fe4] font-bold text-white" type="button">1</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">2</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">3</button>
                <span>...</span>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">3</button>
                <button class="h-[38px] min-w-[38px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#24344f]" type="button">&#8250;</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const rows = document.querySelectorAll('.candidate-row');
    const resultText = document.getElementById('resultText');

    function filterCandidates() {
        const search = searchInput.value.toLowerCase();
        const job = jobFilter.value;
        let count = 0;

        rows.forEach(function (row) {
            const matchesSearch = row.dataset.name.includes(search);
            const matchesJob = job === 'All Jobs' || row.dataset.job === job;
            const show = matchesSearch && matchesJob;

            row.classList.toggle('hidden', !show);
            if (show) count++;
        });

        resultText.textContent = 'Showing 1 to ' + count + ' of 12 shortlisted candidates';
    }

    searchInput.addEventListener('input', filterCandidates);
    jobFilter.addEventListener('change', filterCandidates);
    document.getElementById('viewAll').addEventListener('click', function () {
        searchInput.value = '';
        jobFilter.value = 'All Jobs';
        filterCandidates();
    });
</script>
@endpush
