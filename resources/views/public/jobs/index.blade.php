@extends('layouts.public')

@section('title', 'Jobs - OnlyFreshers')

@php
    $activePage = 'jobs';
    $filters = [
        ['title' => 'Job Type', 'items' => ['Full Time', 'Part Time', 'Internship', 'Contract']],
        ['title' => 'Work Mode', 'items' => ['Direct', 'Fast Track']],
    ];
@endphp

@section('content')
    <main class="bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-10 lg:py-[42px] lg:pb-[65px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div id="listingView">
                <h1 class="m-0 text-[28px] font-semibold text-[#061942] sm:text-[34px]">Find Your Dream Job</h1>
                <p class="mb-6 mt-2 text-base font-medium text-[#34445e]">Explore the latest job openings and start your career today.</p>

                <div class="mb-[18px] grid gap-3.5 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,0.04)] lg:grid-cols-[1.3fr_1fr_1fr_160px] lg:gap-6">
                    <input id="searchInput" class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]" type="text" placeholder="Search job title or keyword">
                    <select id="modeSelect" class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        <option value="">All Categories</option>
                        <option value="direct">Direct Hiring</option>
                        <option value="fast_track">Fast Track</option>
                    </select>
                    <input id="locationInput" class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]" type="text" placeholder="All Locations">
                    <button id="searchButton" class="h-[46px] rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]" type="button">Search</button>
                </div>

                <div class="grid gap-[22px] lg:grid-cols-[230px_minmax(0,1fr)] lg:gap-[35px]">
                    <aside class="rounded-lg border border-[#dce7f8] bg-white p-[18px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h3 class="mb-[18px] text-base font-semibold text-[#061942]">Filters</h3>

                        @foreach ($filters as $filter)
                            <div class="mb-3.5 border-b border-[#dce7f8] pb-3.5 last:mb-0 last:border-b-0 last:pb-0">
                                <p class="mb-2.5 text-[13px] font-semibold text-[#061942]">{{ $filter['title'] }}</p>
                                @foreach ($filter['items'] as $item)
                                    <label class="mb-2 block text-sm font-medium text-[#24344f]"><input type="checkbox" class="mr-2 accent-[#075fe4]" disabled>{{ $item }}</label>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="pt-3.5">
                            <p class="mb-2.5 text-[13px] font-semibold text-[#061942]">Location</p>
                            <input id="sideLocationInput" class="mb-2.5 h-[46px] w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d]" type="text" placeholder="Search location">
                            @foreach (['Bengaluru', 'Hyderabad', 'Pune', 'Noida', 'Remote'] as $location)
                                <button type="button" class="location-chip mb-2 block text-sm font-medium text-[#24344f]" data-location="{{ $location }}">{{ $location }}</button>
                            @endforeach
                        </div>
                    </aside>

                    <section class="min-w-0">
                        <div class="mb-2.5 flex flex-col gap-3 text-sm font-bold text-[#061942] sm:flex-row sm:items-center sm:justify-between">
                            <span id="jobCount">Loading jobs...</span>
                            <select id="sortSelect" class="h-[46px] w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none sm:w-[150px]">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                        </div>

                        <div id="jobList" class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                            <div class="p-6 text-sm font-medium text-[#52607a]">Loading active jobs...</div>
                        </div>
                    </section>
                </div>
            </div>

            <div id="detailView" class="hidden">
                <button class="mb-6 inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" onclick="showListing()">Back to Jobs</button>
                <div id="jobDetail"></div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    let jobs = [];
    let selectedJob = null;

    const jobList = document.getElementById('jobList');
    const jobCount = document.getElementById('jobCount');
    const jobDetail = document.getElementById('jobDetail');
    const searchInput = document.getElementById('searchInput');
    const locationInput = document.getElementById('locationInput');
    const sideLocationInput = document.getElementById('sideLocationInput');
    const modeSelect = document.getElementById('modeSelect');
    const sortSelect = document.getElementById('sortSelect');

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"']/g, (character) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[character]);
    }

    function companyName(job) {
        return job.company_profile?.company_name || 'Company';
    }

    function initials(text) {
        return String(text || 'CO').split(/\s+/).map((word) => word[0]).join('').slice(0, 2).toUpperCase();
    }

    function humanDate(dateValue) {
        if (!dateValue) return 'Recently posted';
        const seconds = Math.max(1, Math.floor((Date.now() - new Date(dateValue).getTime()) / 1000));
        const days = Math.floor(seconds / 86400);
        if (days === 0) return 'Posted today';
        if (days === 1) return 'Posted 1 day ago';
        if (days < 30) return 'Posted ' + days + ' days ago';
        return new Date(dateValue).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function splitSkills(value) {
        return String(value || '').split(',').map((item) => item.trim()).filter(Boolean);
    }

    function buildQuery() {
        const params = new URLSearchParams();
        if (searchInput.value.trim()) params.set('search', searchInput.value.trim());
        const location = locationInput.value.trim() || sideLocationInput.value.trim();
        if (location) params.set('location', location);
        if (modeSelect.value) params.set('hiring_mode', modeSelect.value);
        return params.toString();
    }

    async function loadJobs() {
        jobList.innerHTML = '<div class="p-6 text-sm font-medium text-[#52607a]">Loading active jobs...</div>';
        jobCount.textContent = 'Loading jobs...';

        try {
            const response = await fetch('/api/jobs?' + buildQuery(), { headers: { 'Accept': 'application/json' } });
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Jobs load nahi ho paayi.');
            jobs = payload.data?.jobs || [];
            renderJobs();
        } catch (error) {
            jobList.innerHTML = '<div class="p-6 text-sm font-medium text-[#b42318]">' + escapeHtml(error.message) + '</div>';
            jobCount.textContent = '0 Jobs Found';
        }
    }

    function renderJobs() {
        const sorted = [...jobs].sort((a, b) => {
            const first = new Date(a.created_at || 0).getTime();
            const second = new Date(b.created_at || 0).getTime();
            return sortSelect.value === 'oldest' ? first - second : second - first;
        });

        jobCount.textContent = sorted.length + ' Jobs Found';

        if (!sorted.length) {
            jobList.innerHTML = '<div class="p-6 text-sm font-medium text-[#52607a]">No active jobs found.</div>';
            return;
        }

        jobList.innerHTML = sorted.map((job) => `
            <article class="grid gap-4 border-b border-[#dce7f8] p-[18px] last:border-b-0 sm:grid-cols-[75px_minmax(0,1fr)] lg:grid-cols-[75px_minmax(0,1fr)_135px] lg:items-center lg:gap-[22px] lg:p-6">
                <div class="flex h-[70px] w-[70px] items-center justify-center rounded-lg border border-[#dce7f8] bg-[#fbfdff] text-[22px] font-semibold text-[#075fe4]">${escapeHtml(initials(companyName(job)))}</div>
                <div class="min-w-0">
                    <h2 class="mb-1.5 text-lg font-semibold text-[#061942]">${escapeHtml(job.title)}</h2>
                    <div class="mb-2 flex flex-wrap gap-x-3.5 gap-y-1 text-sm font-medium text-[#52607a]">
                        <span>${escapeHtml(companyName(job))}</span>
                        <span>${escapeHtml(job.location || 'Location not added')}</span>
                        <span>${escapeHtml(job.job_type || 'Job Type')}</span>
                        <span>${escapeHtml(job.hiring_mode === 'fast_track' ? 'Fast Track' : 'Direct')}</span>
                    </div>
                    <p class="line-clamp-2 text-sm font-medium leading-[1.6] text-[#24344f]">${escapeHtml(job.description)}</p>
                </div>
                <div class="sm:col-start-2 lg:col-start-auto lg:text-right">
                    <div class="mb-4 text-[13px] font-medium text-[#52607a] lg:mb-7">${escapeHtml(humanDate(job.created_at))}</div>
                    <button class="view-job inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" data-id="${job.id}">View Details</button>
                </div>
            </article>
        `).join('');
    }

    async function showDetail(id) {
        document.getElementById('listingView').classList.add('hidden');
        document.getElementById('detailView').classList.remove('hidden');
        jobDetail.innerHTML = '<div class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm text-[#52607a]">Loading job details...</div>';
        window.scrollTo(0, 0);

        try {
            const response = await fetch('/api/jobs/' + id, { headers: { 'Accept': 'application/json' } });
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Job details load nahi ho paayi.');
            selectedJob = payload.data?.job;
            renderDetail(selectedJob);
        } catch (error) {
            jobDetail.innerHTML = '<div class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm text-[#b42318]">' + escapeHtml(error.message) + '</div>';
        }
    }

    function renderDetail(job) {
        const skills = splitSkills(job.required_skills);
        const company = job.company_profile || {};
        const descriptionItems = String(job.description || '').split(/\r?\n/).map((line) => line.trim()).filter(Boolean);

        jobDetail.innerHTML = `
            <div class="grid gap-7 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start lg:gap-[70px]">
                <div class="min-w-0">
                    <h1 class="mb-[18px] text-[28px] font-semibold leading-tight text-[#061942] sm:text-[34px]">${escapeHtml(job.title)}</h1>
                    <div class="mb-[22px] flex items-center gap-3 text-[17px] font-bold text-[#061942]">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#eff5ff] text-[13px] font-extrabold text-[#075fe4]">${escapeHtml(initials(company.company_name))}</span>
                        <span>${escapeHtml(company.company_name || 'Company')}</span>
                    </div>
                    <div class="mb-7 flex flex-wrap gap-[18px] text-[15px] font-medium text-[#52607a]">
                        <span>${escapeHtml(job.location || 'Location not added')}</span>
                        <span>${escapeHtml(job.job_type || 'Job Type')}</span>
                        <span>${escapeHtml(job.hiring_mode === 'fast_track' ? 'Fast Track' : 'Direct')}</span>
                        <span>${escapeHtml(humanDate(job.created_at))}</span>
                    </div>

                    <div class="border-b border-[#dce7f8] py-[22px]">
                        <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Job Description</h2>
                        ${descriptionItems.length ? '<ul class="list-disc space-y-1 pl-5 text-[15px] font-medium leading-[1.8] text-[#24344f] marker:text-[#075fe4]">' + descriptionItems.map((item) => '<li>' + escapeHtml(item) + '</li>').join('') + '</ul>' : '<p class="text-[15px] font-medium leading-[1.8] text-[#24344f]">No description added.</p>'}
                    </div>

                    <div class="border-b border-[#dce7f8] py-[22px]">
                        <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Requirements</h2>
                        <p class="text-[15px] font-medium leading-[1.8] text-[#24344f]">${escapeHtml(job.qualification || 'No qualification added.')}</p>
                    </div>

                    <div class="border-b border-[#dce7f8] py-[22px]">
                        <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Key Skills</h2>
                        <div class="flex flex-wrap gap-2.5">
                            ${skills.length ? skills.map((skill) => '<span class="rounded-lg border border-[#a9c5f6] bg-white px-[18px] py-2 text-sm font-bold text-[#075fe4]">' + escapeHtml(skill) + '</span>').join('') : '<span class="text-sm font-medium text-[#52607a]">No skills added.</span>'}
                        </div>
                    </div>
                </div>

                <aside class="min-w-0">
                    <div class="mb-[22px] rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <button type="button" class="mb-3 flex h-11 w-full items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#003f9e]">Apply Now</button>
                        <button type="button" class="flex h-11 w-full items-center justify-center rounded-lg border border-[#a9c5f6] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Save Job</button>
                    </div>

                    <div class="rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Job Overview</h2>
                        ${overviewRow('Job Type', job.job_type || '-')}
                        ${overviewRow('Hiring Mode', job.hiring_mode === 'fast_track' ? 'Fast Track' : 'Direct')}
                        ${overviewRow('Location', job.location || '-')}
                        ${overviewRow('Industry', company.industry || '-')}
                        ${overviewRow('Salary', job.salary || '-')}
                        ${overviewRow('Openings', job.openings || '1')}
                        ${overviewRow('Last Date', job.application_last_date ? new Date(job.application_last_date).toLocaleDateString('en-IN') : '-')}
                    </div>
                </aside>
            </div>
        `;
    }

    function overviewRow(label, value) {
        return '<div class="flex items-center justify-between gap-4 border-b border-[#dce7f8] py-3.5 text-sm font-medium text-[#24344f] last:border-b-0"><span>' + escapeHtml(label) + '</span><strong class="text-right font-bold text-[#061942]">' + escapeHtml(value) + '</strong></div>';
    }

    function showListing() {
        document.getElementById('listingView').classList.remove('hidden');
        document.getElementById('detailView').classList.add('hidden');
        window.scrollTo(0, 0);
    }

    document.getElementById('searchButton').addEventListener('click', loadJobs);
    sortSelect.addEventListener('change', renderJobs);
    searchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') loadJobs();
    });
    locationInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') loadJobs();
    });
    sideLocationInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            locationInput.value = sideLocationInput.value;
            loadJobs();
        }
    });
    document.querySelectorAll('.location-chip').forEach((button) => {
        button.addEventListener('click', () => {
            locationInput.value = button.dataset.location;
            sideLocationInput.value = button.dataset.location;
            loadJobs();
        });
    });
    jobList.addEventListener('click', (event) => {
        const button = event.target.closest('.view-job');
        if (button) showDetail(button.dataset.id);
    });

    loadJobs();
</script>
@endpush
