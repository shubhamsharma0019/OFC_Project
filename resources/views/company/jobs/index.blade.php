@extends('layouts.company')

@section('title', 'My Jobs - OnlyFreshers')
@section('pageTitle', 'My Jobs')
@section('pageSubtitle', 'Manage and view all your posted jobs.')

@php
    $activePage = 'jobs';

    $defaultJobs = [
        ['title' => 'Full Stack Developer', 'experience' => '0 - 1 Year', 'location' => 'Bangalore', 'applications' => 56, 'status' => 'Active', 'date' => '01 Jun 2024'],
        ['title' => 'React Developer', 'experience' => '0 - 1 Year', 'location' => 'Remote', 'applications' => 32, 'status' => 'Active', 'date' => '25 May 2024'],
        ['title' => 'UI/UX Designer', 'experience' => '0 - 1 Year', 'location' => 'Bangalore', 'applications' => 18, 'status' => 'Active', 'date' => '10 May 2024'],
        ['title' => 'Backend Developer', 'experience' => '1 - 3 Years', 'location' => 'Hyderabad', 'applications' => 0, 'status' => 'Draft', 'date' => '05 Jun 2024'],
        ['title' => 'DevOps Engineer', 'experience' => '2 - 4 Years', 'location' => 'Pune', 'applications' => 0, 'status' => 'Draft', 'date' => '02 Jun 2024'],
        ['title' => 'Data Analyst', 'experience' => '0 - 1 Year', 'location' => 'Bangalore', 'applications' => 27, 'status' => 'Closed', 'date' => '20 Apr 2024'],
    ];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
        <div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-x-6 gap-y-2 sm:gap-x-9" role="tablist" aria-label="Job status tabs">
                <button class="job-tab border-b-[3px] border-[#075fe4] px-4 py-3 text-sm font-semibold text-[#075fe4]" data-status="Active" type="button">
                    Active (<span id="activeCount">0</span>)
                </button>
                <button class="job-tab border-b-[3px] border-transparent px-4 py-3 text-sm font-semibold text-[#24344f]" data-status="Draft" type="button">
                    Draft (<span id="draftCount">0</span>)
                </button>
                <button class="job-tab border-b-[3px] border-transparent px-4 py-3 text-sm font-semibold text-[#24344f]" data-status="Closed" type="button">
                    Closed (<span id="closedCount">0</span>)
                </button>
            </div>

            <a href="/company/post-job" class="inline-flex h-[42px] w-[148px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                + Post New Job
            </a>
        </div>

        <div id="jobList" class="overflow-hidden rounded-lg border border-[#dce7f8]"></div>
    </section>
@endsection

@push('scripts')
<script>
    const defaultJobs = @json($defaultJobs);
    const savedJobs = JSON.parse(localStorage.getItem('companyJobs') || '[]');
    const allJobs = savedJobs.concat(defaultJobs);
    const jobList = document.getElementById('jobList');

    const statusClasses = {
        Active: 'bg-[#dbf8e9] text-[#00a65a]',
        Draft: 'bg-[#eaf2ff] text-[#075fe4]',
        Closed: 'bg-[#edf2fb] text-[#52607a]'
    };

    function countJobs(status) {
        return allJobs.filter(function (job) { return job.status === status; }).length;
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>'"]/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#039;',
                '"': '&quot;'
            }[char];
        });
    }

    function renderJobs(status) {
        jobList.innerHTML = '';

        const filteredJobs = allJobs.filter(function (job) {
            return job.status === status;
        });

        if (!filteredJobs.length) {
            jobList.innerHTML = '<div class="p-8 text-center text-sm text-[#52607a]">No jobs found.</div>';
            return;
        }

        filteredJobs.forEach(function (job) {
            const dateLabel = job.status === 'Draft' ? 'Last edited on ' : job.status === 'Closed' ? 'Closed on ' : 'Posted on ';
            const row = document.createElement('div');

            row.className = 'grid grid-cols-1 gap-4 border-b border-[#dce7f8] px-[18px] py-5 last:border-b-0 sm:grid-cols-[minmax(0,1fr)_auto_36px] sm:items-center sm:gap-[22px]';
            row.innerHTML = `
                <div class="min-w-0">
                    <h3 class="mb-2.5 text-base font-bold text-[#061942]">${escapeHtml(job.title)}</h3>
                    <div class="mb-2 flex flex-wrap gap-2.5 text-[13px] text-[#24344f]"><span>${escapeHtml(job.experience)}</span><span>&bull;</span><span>${escapeHtml(job.location)}</span></div>
                    <div class="text-[13px] text-[#061942]">${Number(job.applications || 0)} Applications</div>
                </div>
                <div class="sm:text-right">
                    <div class="mb-3 inline-flex h-[34px] min-w-16 items-center justify-center rounded-[10px] px-3 text-xs font-bold ${statusClasses[job.status] || statusClasses.Closed}">${escapeHtml(job.status)}</div>
                    <div class="text-[13px] text-[#24344f]">${dateLabel}${escapeHtml(job.date)}</div>
                </div>
                <a href="/company/jobs/show" class="text-2xl leading-none text-[#061942] sm:justify-self-center" aria-label="View job details">&#8942;</a>
            `;
            jobList.appendChild(row);
        });
    }

    document.getElementById('activeCount').textContent = countJobs('Active');
    document.getElementById('draftCount').textContent = countJobs('Draft');
    document.getElementById('closedCount').textContent = countJobs('Closed');

    document.querySelectorAll('.job-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.job-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#24344f]');
            });

            tab.classList.remove('border-transparent', 'text-[#24344f]');
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            renderJobs(tab.dataset.status);
        });
    });

    renderJobs('Active');
</script>
@endpush

