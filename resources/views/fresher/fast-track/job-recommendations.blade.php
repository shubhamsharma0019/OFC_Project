@extends('layouts.fast-track')

@section('title', 'Job Recommendations')

@php
    $activePage = 'jobs';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $jobs = [
        ['title' => 'Frontend Developer', 'company' => 'Microsoft', 'logo' => 'MS', 'location' => 'Bangalore, India', 'posted' => 'Posted 2 days ago', 'type' => 'Full Time', 'experience' => '0-2 Yrs', 'mode' => 'On-site', 'saved' => true],
        ['title' => 'Software Engineer', 'company' => 'IndiaMART InterMESH Ltd.', 'logo' => 'IM', 'location' => 'Noida, India', 'posted' => 'Posted 3 days ago', 'type' => 'Full Time', 'experience' => '1-3 Yrs', 'mode' => 'Hybrid', 'saved' => false],
        ['title' => 'Backend Developer', 'company' => 'Swiggy', 'logo' => 'SW', 'location' => 'Bangalore, India', 'posted' => 'Posted 1 day ago', 'type' => 'Full Time', 'experience' => '0-3 Yrs', 'mode' => 'On-site', 'saved' => true],
        ['title' => 'Junior Software Developer', 'company' => 'Zoho Corporation', 'logo' => 'ZH', 'location' => 'Chennai, India', 'posted' => 'Posted 5 days ago', 'type' => 'Full Time', 'experience' => '0-1 Yrs', 'mode' => 'On-site', 'saved' => true],
        ['title' => 'Associate Software Engineer', 'company' => 'PhonePe', 'logo' => 'PP', 'location' => 'Bangalore, India', 'posted' => 'Posted 6 days ago', 'type' => 'Full Time', 'experience' => '0-2 Yrs', 'mode' => 'Hybrid', 'saved' => false],
    ];

    $savedJobs = [
        ['title' => 'Frontend Developer', 'company' => 'Microsoft', 'logo' => 'MS', 'location' => 'Bangalore, India'],
        ['title' => 'Backend Developer', 'company' => 'Swiggy', 'logo' => 'SW', 'location' => 'Bangalore, India'],
        ['title' => 'Junior Software Developer', 'company' => 'Zoho Corporation', 'logo' => 'ZH', 'location' => 'Chennai, India'],
    ];
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Job Recommendations</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Discover jobs that match your skills and interests.</p>
        </div>

        <div class="flex gap-8 overflow-x-auto border-b border-[#dce7f8]">
            @foreach (['Recommended Jobs', 'All Jobs', 'Saved Jobs', 'Applied Jobs'] as $tab)
                <button class="shrink-0 border-b-[3px] px-4 pb-3 text-sm font-bold {{ $loop->first ? 'border-[#075fe4] text-[#075fe4]' : 'border-transparent text-[#334b83]' }}" type="button">{{ $tab }}</button>
            @endforeach
        </div>

        <div class="grid gap-3 lg:grid-cols-[1.8fr_repeat(3,180px)_120px]">
            <input id="jobSearchInput" class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83] outline-none placeholder:text-[#6f7ea0]" placeholder="Search by job title, company or skills">
            <select class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83]"><option>All Locations</option></select>
            <select class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83]"><option>All Job Types</option></select>
            <select class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83]"><option>Experience Level</option></select>
            <button class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm font-bold text-[#075fe4]" type="button">Filters</button>
        </div>

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_330px]">
            <div>
                <div class="grid gap-3" id="jobList">
                    @foreach ($jobs as $job)
                        <article class="job-card grid gap-4 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[82px_minmax(0,1fr)_auto_34px] lg:items-center" data-search="{{ strtolower($job['title'].' '.$job['company'].' '.$job['location']) }}">
                            <span class="grid h-[76px] w-[76px] place-items-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-sm font-black text-[#075fe4]">{{ $job['logo'] }}</span>
                            <div class="min-w-0">
                                <h2 class="mb-2 text-base font-bold text-[#061942]">{{ $job['title'] }}</h2>
                                <p class="mb-2 text-sm font-medium text-[#334b83]">{{ $job['company'] }} <strong class="text-[#075fe4]">Verified</strong></p>
                                <div class="flex flex-wrap gap-3 text-xs font-medium text-[#334b83]"><span>{{ $job['location'] }}</span><span>|</span><span>{{ $job['posted'] }}</span></div>
                            </div>
                            <div>
                                <div class="mb-4 flex flex-wrap gap-2">
                                    <span class="rounded-lg bg-[#e8f8ef] px-3 py-1.5 text-xs font-bold text-[#05843e]">{{ $job['type'] }}</span>
                                    <span class="rounded-lg bg-[#efeaff] px-3 py-1.5 text-xs font-bold text-[#673de6]">{{ $job['experience'] }}</span>
                                    <span class="rounded-lg px-3 py-1.5 text-xs font-bold {{ $job['mode'] === 'Hybrid' ? 'bg-[#fff2d8] text-[#b66b00]' : 'bg-[#eaf2ff] text-[#0b57bd]' }}">{{ $job['mode'] }}</span>
                                </div>
                                <a class="inline-flex h-[38px] items-center justify-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white hover:bg-[#064fc0]" href="#">View Details</a>
                            </div>
                            <button class="text-xl font-black text-[#061942]" type="button" aria-label="Save job">{{ $job['saved'] ? 'S' : 'B' }}</button>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 flex flex-wrap justify-center gap-2">
                    @foreach (['Previous', '1', '2', '3', '4', '5', '...', '20', 'Next'] as $page)
                        <button class="min-h-[38px] min-w-[38px] rounded-md border border-[#cfe0ff] px-3 text-sm font-bold {{ $page === '1' ? 'bg-[#075fe4] text-white' : 'bg-white text-[#061942]' }}" type="button">{{ $page }}</button>
                    @endforeach
                </div>
            </div>

            <aside>
                <article class="mb-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-base font-bold text-[#061942]">Saved Jobs</h2>
                        <a class="text-xs font-bold text-[#075fe4]" href="#">View All</a>
                    </div>
                    <div class="grid gap-4">
                        @foreach ($savedJobs as $job)
                            <div class="grid grid-cols-[54px_minmax(0,1fr)_34px] items-center gap-3">
                                <span class="grid h-[54px] w-[54px] place-items-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-[11px] font-black text-[#075fe4]">{{ $job['logo'] }}</span>
                                <div class="min-w-0">
                                    <h3 class="mb-1 truncate text-sm font-bold text-[#061942]">{{ $job['title'] }}</h3>
                                    <p class="text-xs leading-5 text-[#334b83]">{{ $job['company'] }}<br>{{ $job['location'] }}</p>
                                </div>
                                <button class="text-lg font-black text-[#061942]" type="button">S</button>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <span class="mb-3 grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">JA</span>
                    <h2 class="mb-2 text-base font-bold text-[#061942]">Job Alerts</h2>
                    <p class="mb-5 text-sm leading-6 text-[#334b83]">Get notified about new job opportunities that match your preferences.</p>
                    @foreach (['Alert Status', 'Email Notifications', 'Daily Digest'] as $item)
                        <div class="my-3 flex items-center justify-between text-sm font-medium text-[#061942]"><span>{{ $item }}</span><span class="relative h-[18px] w-[34px] rounded-full bg-[#075fe4] after:absolute after:right-0.5 after:top-0.5 after:h-[14px] after:w-[14px] after:rounded-full after:bg-white"></span></div>
                    @endforeach
                    <button class="mt-3 h-[38px] w-full rounded-md border border-[#075fe4] bg-white text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" type="button">Manage Preferences</button>
                </article>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const jobSearchInput = document.getElementById('jobSearchInput');
    if (jobSearchInput) {
        jobSearchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.job-card').forEach(function (card) {
                card.classList.toggle('hidden', !card.dataset.search.includes(query));
            });
        });
    }

    const jobList = document.getElementById('jobList');
    let appliedJobIds = new Set();

    function renderJobs(jobs) {
        if (!jobList) return;
        if (!jobs.length) {
            jobList.innerHTML = FastTrack.emptyState('No Fast Track jobs found', 'Fast Track eligible jobs will appear here after companies publish them.', '/fast-track/certificate', 'View Certificate');
            return;
        }
        jobList.innerHTML = jobs.map(function (job) {
            const company = job.company_profile || job.company || {};
            const companyName = company.company_name || company.name || job.company_name || 'Company';
            const search = (job.title + ' ' + companyName + ' ' + (job.location || '')).toLowerCase();
            const applied = appliedJobIds.has(Number(job.id)) || appliedJobIds.has(String(job.id));
            return `<article class="job-card grid gap-4 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[82px_minmax(0,1fr)_auto] lg:items-center" data-search="${FastTrack.esc(search)}">
                <span class="grid h-[76px] w-[76px] place-items-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-sm font-black text-[#075fe4]">${FastTrack.initials(companyName)}</span>
                <div class="min-w-0">
                    <h2 class="mb-2 text-base font-bold text-[#061942]">${FastTrack.esc(job.title || 'Fast Track Role')}</h2>
                    <p class="mb-2 text-sm font-medium text-[#334b83]">${FastTrack.esc(companyName)} <strong class="text-[#075fe4]">Verified</strong></p>
                    <div class="flex flex-wrap gap-3 text-xs font-medium text-[#334b83]"><span>${FastTrack.esc(job.location || 'India')}</span><span>|</span><span>${FastTrack.date(job.created_at)}</span></div>
                </div>
                <div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span class="rounded-lg bg-[#e8f8ef] px-3 py-1.5 text-xs font-bold text-[#05843e]">${FastTrack.esc(job.job_type || 'Full Time')}</span>
                        <span class="rounded-lg bg-[#efeaff] px-3 py-1.5 text-xs font-bold text-[#673de6]">${FastTrack.esc(job.experience || job.experience_level || 'Fresher')}</span>
                        <span class="rounded-lg bg-[#eaf2ff] px-3 py-1.5 text-xs font-bold text-[#0b57bd]">Fast Track</span>
                    </div>
                    <button class="apply-job-btn inline-flex h-[38px] items-center justify-center rounded-md ${applied ? 'bg-[#e6fff0] text-[#05843e]' : 'bg-[#075fe4] text-white hover:bg-[#064fc0]'} px-5 text-sm font-bold" type="button" data-job-id="${FastTrack.esc(job.id)}" ${applied ? 'disabled' : ''}>${applied ? 'Applied' : 'Apply Now'}</button>
                </div>
            </article>`;
        }).join('');

        jobList.querySelectorAll('.apply-job-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                button.textContent = 'Applying...';
                FastTrack.postJson('/api/fresher/jobs/' + button.dataset.jobId + '/apply')
                    .then(function () {
                        button.textContent = 'Applied';
                        button.disabled = true;
                        button.className = button.className.replace('bg-[#075fe4] text-white hover:bg-[#064fc0]', 'bg-[#e6fff0] text-[#05843e]');
                    })
                    .catch(function (error) {
                        button.textContent = error.status === 409 ? 'Applied' : 'Apply Now';
                        if (error.status === 409) button.disabled = true;
                    });
            });
        });
    }

    Promise.all([
        FastTrack.getJson('/api/fresher/applications').catch(() => ({ data: { applications: [] } })),
        FastTrack.getJson('/api/jobs?hiring_mode=fast_track'),
    ]).then(function (responses) {
        const applications = FastTrack.apiData(responses[0], 'applications') || [];
        appliedJobIds = new Set(applications.map((item) => item.job_id || (item.job && item.job.id)).filter(Boolean));
        renderJobs(FastTrack.apiData(responses[1], 'jobs') || []);
    }).catch(function () {
        if (jobList) jobList.insertAdjacentHTML('afterbegin', '<div class="rounded-lg border border-[#ffd6a8] bg-[#fff8ef] p-4 text-sm font-semibold text-[#8a5200]">Live jobs data nahi aa pa raha. Static preview retained hai.</div>');
    });
</script>
@endpush
