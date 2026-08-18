@extends('layouts.fast-track')

@section('title', 'Job Recommendations')

@php
    $activePage = 'jobs';
@endphp

@section('content')
    <section class="space-y-5">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Job Recommendations</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Discover jobs that match your skills and interests.</p>
        </div>

        <div class="flex gap-8 overflow-x-auto border-b border-[#dce7f8]">
            <button class="job-tab shrink-0 border-b-[3px] border-[#075fe4] px-4 pb-3 text-sm font-bold text-[#075fe4]" type="button" data-tab="recommended">Recommended Jobs</button>
            <button class="job-tab shrink-0 border-b-[3px] border-transparent px-4 pb-3 text-sm font-bold text-[#334b83]" type="button" data-tab="all">All Jobs</button>
            <button class="job-tab shrink-0 border-b-[3px] border-transparent px-4 pb-3 text-sm font-bold text-[#334b83]" type="button" data-tab="saved">Saved Jobs</button>
            <button class="job-tab shrink-0 border-b-[3px] border-transparent px-4 pb-3 text-sm font-bold text-[#334b83]" type="button" data-tab="applied">Applied Jobs</button>
        </div>

        <div class="grid gap-3 lg:grid-cols-[1.8fr_repeat(3,180px)_120px]">
            <input id="jobSearchInput" class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83] outline-none placeholder:text-[#6f7ea0]" placeholder="Search by job title, company or skills">
            <select id="jobLocationFilter" class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83]"><option value="">All Locations</option></select>
            <select id="jobTypeFilter" class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83]"><option value="">All Job Types</option></select>
            <select id="jobExperienceFilter" class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83]"><option value="">Experience Level</option></select>
            <button id="jobClearFilters" class="h-[42px] rounded-md border border-[#cfe0ff] bg-white px-4 text-sm font-bold text-[#075fe4]" type="button">Clear</button>
        </div>

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_330px]">
            <div>
                <div id="jobSummary" class="mb-3 text-sm font-bold text-[#061942]">Loading jobs...</div>
                <div class="grid gap-3" id="jobList">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center text-sm font-semibold text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)]">Loading jobs...</article>
                </div>
            </div>

            <aside class="space-y-4">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-base font-bold text-[#061942]">Saved Jobs</h2>
                        <button id="savedViewButton" class="text-xs font-bold text-[#075fe4]" type="button">View All</button>
                    </div>
                    <div id="savedJobsList" class="grid gap-4">
                        <p class="text-sm text-[#334b83]">Loading saved jobs...</p>
                    </div>
                </article>

                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <span class="mb-3 grid h-8 w-8 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-4 [&>svg]:w-4 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg></span>
                    <h2 class="mb-2 text-base font-bold text-[#061942]">Recommendation Match</h2>
                    <p id="recommendationText" class="mb-5 text-sm leading-6 text-[#334b83]">Recommendations are based on your assessment track, course skills and active Fast Track jobs.</p>
                    <div class="grid gap-3 text-sm font-medium text-[#061942]">
                        <div class="flex items-center justify-between"><span id="jobsCountLabel">Fast Track Jobs</span><strong id="fastTrackCount">0</strong></div>
                        <div class="flex items-center justify-between"><span>Applied</span><strong id="appliedCount">0</strong></div>
                        <div class="flex items-center justify-between"><span>Saved</span><strong id="savedCount">0</strong></div>
                    </div>
                </article>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const jobList = document.getElementById('jobList');
    const jobSummary = document.getElementById('jobSummary');
    const jobSearchInput = document.getElementById('jobSearchInput');
    const jobLocationFilter = document.getElementById('jobLocationFilter');
    const jobTypeFilter = document.getElementById('jobTypeFilter');
    const jobExperienceFilter = document.getElementById('jobExperienceFilter');
    const jobClearFilters = document.getElementById('jobClearFilters');
    const savedJobsList = document.getElementById('savedJobsList');
    const savedViewButton = document.getElementById('savedViewButton');
    const recommendationText = document.getElementById('recommendationText');
    const jobsCountLabel = document.getElementById('jobsCountLabel');
    const fastTrackCount = document.getElementById('fastTrackCount');
    const appliedCount = document.getElementById('appliedCount');
    const savedCount = document.getElementById('savedCount');
    const savedStorageKey = 'fast_track_saved_job_ids';

    let jobs = [];
    let applications = [];
    let profileSkills = [];
    let recommendedTrack = '';
    let hasCertificate = false;
    let usedAllJobsFallback = false;
    let activeTab = 'recommended';
    let savedJobIds = new Set(readSavedJobIds());
    const jobIcons = {
        company: '<svg viewBox="0 0 24 24"><path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-3"></path><path d="M9 9h.01M9 13h.01M9 17h.01M15 13h.01M15 17h.01"></path></svg>',
    };

    function readSavedJobIds() {
        try {
            return JSON.parse(localStorage.getItem(savedStorageKey) || '[]').map(String);
        } catch (_) {
            return [];
        }
    }

    function writeSavedJobIds() {
        localStorage.setItem(savedStorageKey, JSON.stringify(Array.from(savedJobIds)));
    }

    function companyName(job) {
        const company = job.company_profile || job.company || {};
        return company.company_name || company.name || job.company_name || 'Company';
    }

    function jobSkills(job) {
        const raw = job.required_skills || job.skills || '';
        if (Array.isArray(raw)) return raw.map((skill) => String(skill).trim()).filter(Boolean);
        return String(raw).split(/[,|]/).map((skill) => skill.trim()).filter(Boolean);
    }

    function jobText(job) {
        return [
            job.title,
            companyName(job),
            job.location,
            job.job_type,
            job.experience,
            job.experience_level,
            job.qualification,
            job.description,
            job.required_skills,
        ].join(' ').toLowerCase();
    }

    function applicationJobId(application) {
        return String(application.job_id || application.job?.id || '');
    }

    function applicationForJob(job) {
        return applications.find((application) => applicationJobId(application) === String(job.id));
    }

    function isApplied(job) {
        return Boolean(applicationForJob(job));
    }

    function matchScore(job) {
        const text = jobText(job);
        const skills = profileSkills.filter((skill) => text.includes(skill.toLowerCase()));
        const trackHit = recommendedTrack && text.includes(recommendedTrack.toLowerCase());
        const fastTrackHit = String(job.hiring_mode || '').toLowerCase().includes('fast');
        return (skills.length * 20) + (trackHit ? 35 : 0) + (fastTrackHit ? 15 : 0);
    }

    function sortedRecommended(list) {
        return list.slice().sort((left, right) => matchScore(right) - matchScore(left) || new Date(right.created_at || 0) - new Date(left.created_at || 0));
    }

    function uniqueOptions(values) {
        return [...new Set(values.filter(Boolean).map((value) => String(value).trim()).filter(Boolean))].sort();
    }

    function setSelectOptions(select, values, firstLabel) {
        const selected = select.value;
        select.innerHTML = `<option value="">${FastTrack.esc(firstLabel)}</option>` + values.map((value) => `<option value="${FastTrack.esc(value)}">${FastTrack.esc(value)}</option>`).join('');
        if (values.includes(selected)) select.value = selected;
    }

    function populateFilters() {
        setSelectOptions(jobLocationFilter, uniqueOptions(jobs.map((job) => job.location)), 'All Locations');
        setSelectOptions(jobTypeFilter, uniqueOptions(jobs.map((job) => job.job_type)), 'All Job Types');
        setSelectOptions(jobExperienceFilter, uniqueOptions(jobs.map((job) => job.experience || job.experience_level || job.qualification)), 'Experience Level');
    }

    function filteredJobs() {
        let rows = jobs.slice();
        if (activeTab === 'recommended') rows = sortedRecommended(rows);
        if (activeTab === 'saved') rows = rows.filter((job) => savedJobIds.has(String(job.id)));
        if (activeTab === 'applied') rows = rows.filter(isApplied);

        const query = jobSearchInput.value.trim().toLowerCase();
        const location = jobLocationFilter.value;
        const type = jobTypeFilter.value;
        const experience = jobExperienceFilter.value;

        return rows.filter((job) => {
            const text = jobText(job);
            return (!query || text.includes(query))
                && (!location || String(job.location || '') === location)
                && (!type || String(job.job_type || '') === type)
                && (!experience || String(job.experience || job.experience_level || job.qualification || '') === experience);
        });
    }

    function tabEmptyState() {
        if (activeTab === 'saved') return FastTrack.emptyState('No saved jobs yet', 'Save jobs from recommendations to review them later.', '', '');
        if (activeTab === 'applied') return FastTrack.emptyState('No applications yet', 'Apply to a Fast Track job to track it here.', '', '');
        return FastTrack.emptyState('No jobs found', hasCertificate ? 'No active jobs are available right now. Please check again after companies publish openings.' : 'Complete your certificate to unlock broader job recommendations.', hasCertificate ? '' : '/fast-track/certificate', hasCertificate ? '' : 'View Certificate');
    }

    function renderTabs() {
        document.querySelectorAll('.job-tab').forEach((button) => {
            const active = button.dataset.tab === activeTab;
            button.className = `job-tab shrink-0 border-b-[3px] px-4 pb-3 text-sm font-bold ${active ? 'border-[#075fe4] text-[#075fe4]' : 'border-transparent text-[#334b83]'}`;
        });
    }

    function badgeClass(value) {
        const text = String(value || '').toLowerCase();
        if (text.includes('remote')) return 'bg-[#eaf2ff] text-[#0b57bd]';
        if (text.includes('hybrid')) return 'bg-[#fff2d8] text-[#b66b00]';
        return 'bg-[#e8f8ef] text-[#05843e]';
    }

    function renderJobCard(job) {
        const applied = isApplied(job);
        const saved = savedJobIds.has(String(job.id));
        const application = applicationForJob(job);
        const score = Math.min(100, Math.max(45, matchScore(job) || 65));
        const skills = jobSkills(job).slice(0, 4);
        const description = job.description || job.qualification || 'Fast Track role for freshers.';

        return `<article class="job-card grid gap-4 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:grid-cols-[82px_minmax(0,1fr)_auto_38px] lg:items-center">
            <span class="grid h-[76px] w-[76px] shrink-0 place-items-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-[#075fe4] [&>svg]:h-8 [&>svg]:w-8 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${jobIcons.company}</span>
            <div class="min-w-0">
                <h2 class="mb-2 text-base font-bold text-[#061942]">${FastTrack.esc(job.title || 'Fast Track Role')}</h2>
                <p class="mb-2 text-sm font-medium text-[#334b83]">${FastTrack.esc(companyName(job))} <strong class="text-[#075fe4]">Verified</strong></p>
                <div class="mb-2 flex flex-wrap gap-3 text-xs font-medium text-[#334b83]">
                    <span>${FastTrack.esc(job.location || 'India')}</span><span>|</span><span>Posted ${FastTrack.date(job.created_at)}</span>
                </div>
                <p class="line-clamp-2 text-xs leading-5 text-[#536484]">${FastTrack.esc(description)}</p>
                <div class="mt-3 flex flex-wrap gap-2">${skills.map((skill) => `<span class="rounded-md bg-[#eef5ff] px-2.5 py-1 text-[11px] font-bold text-[#075fe4]">${FastTrack.esc(skill)}</span>`).join('')}</div>
            </div>
            <div>
                <div class="mb-4 flex flex-wrap justify-start gap-2 lg:justify-end">
                    <span class="rounded-lg bg-[#e8f8ef] px-3 py-1.5 text-xs font-bold text-[#05843e]">${FastTrack.esc(job.job_type || 'Full Time')}</span>
                    <span class="rounded-lg bg-[#efeaff] px-3 py-1.5 text-xs font-bold text-[#673de6]">${FastTrack.esc(job.experience || job.experience_level || 'Fresher')}</span>
                    <span class="rounded-lg ${badgeClass(job.hiring_mode)} px-3 py-1.5 text-xs font-bold">${FastTrack.esc(FastTrack.statusText(job.hiring_mode || 'Fast Track'))}</span>
                </div>
                <div class="mb-3 text-right text-xs font-bold text-[#334b83] max-lg:text-left">Match ${score}%</div>
                <div class="flex flex-wrap gap-2 lg:justify-end">
                    <a class="inline-flex h-[38px] items-center justify-center rounded-md border border-[#075fe4] bg-white px-4 text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" href="/jobs/show?job=${FastTrack.esc(job.id)}">Details</a>
                    <button class="apply-job-btn inline-flex h-[38px] items-center justify-center rounded-md ${applied ? 'bg-[#e6fff0] text-[#05843e]' : 'bg-[#075fe4] text-white hover:bg-[#064fc0]'} px-5 text-sm font-bold" type="button" data-job-id="${FastTrack.esc(job.id)}" ${applied ? 'disabled' : ''}>${applied ? FastTrack.statusText(application?.application_status || 'Applied') : 'Apply Now'}</button>
                </div>
            </div>
            <button class="save-job-btn grid h-9 w-9 place-items-center rounded-full border ${saved ? 'border-[#075fe4] bg-[#eaf2ff] text-[#075fe4]' : 'border-[#dce7f8] bg-white text-[#334b83]'} text-sm font-black" type="button" data-job-id="${FastTrack.esc(job.id)}" aria-label="Save job">${saved ? 'S' : '+'}</button>
        </article>`;
    }

    function renderSavedSidebar() {
        const savedJobs = jobs.filter((job) => savedJobIds.has(String(job.id))).slice(0, 4);
        savedJobsList.innerHTML = savedJobs.length ? savedJobs.map((job) => `<div class="grid grid-cols-[54px_minmax(0,1fr)_34px] items-center gap-3">
            <span class="grid h-[54px] w-[54px] shrink-0 place-items-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-[#075fe4] [&>svg]:h-6 [&>svg]:w-6 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${jobIcons.company}</span>
            <div class="min-w-0">
                <h3 class="mb-1 truncate text-sm font-bold text-[#061942]">${FastTrack.esc(job.title || 'Fast Track Role')}</h3>
                <p class="text-xs leading-5 text-[#334b83]">${FastTrack.esc(companyName(job))}<br>${FastTrack.esc(job.location || '')}</p>
            </div>
            <button class="save-job-btn text-lg font-black text-[#075fe4]" type="button" data-job-id="${FastTrack.esc(job.id)}">S</button>
        </div>`).join('') : '<p class="text-sm leading-6 text-[#334b83]">Saved jobs yahan dikhenge.</p>';
    }

    function renderCounts() {
        jobsCountLabel.textContent = usedAllJobsFallback ? 'Active Jobs' : 'Fast Track Jobs';
        fastTrackCount.textContent = jobs.length;
        appliedCount.textContent = applications.length;
        savedCount.textContent = savedJobIds.size;
        const skillsText = profileSkills.length ? profileSkills.slice(0, 4).join(', ') : 'your profile skills';
        recommendationText.textContent = usedAllJobsFallback
            ? `Certificate completed. Showing active jobs sorted using ${skillsText}.`
            : recommendedTrack
            ? `Recommended track: ${recommendedTrack}. Jobs are sorted using ${skillsText}.`
            : `Jobs are sorted using ${skillsText}, applications and active Fast Track openings.`;
    }

    function renderJobs() {
        renderTabs();
        renderCounts();
        renderSavedSidebar();
        const rows = filteredJobs();
        jobSummary.textContent = `${rows.length} ${activeTab === 'recommended' ? 'recommended' : activeTab} jobs found`;
        jobList.innerHTML = rows.length ? rows.map(renderJobCard).join('') : tabEmptyState();
        jobList.querySelectorAll('.apply-job-btn').forEach((button) => button.addEventListener('click', applyToJob));
        document.querySelectorAll('.save-job-btn').forEach((button) => button.addEventListener('click', toggleSavedJob));
    }

    async function applyToJob(event) {
        const button = event.currentTarget;
        const jobId = button.dataset.jobId;
        button.disabled = true;
        button.textContent = 'Applying...';
        try {
            const result = await FastTrack.postJson('/api/fresher/jobs/' + jobId + '/apply');
            const application = FastTrack.apiData(result, 'application') || {};
            applications.unshift(Object.assign(application, { job_id: Number(jobId), job: jobs.find((job) => String(job.id) === String(jobId)) }));
        } catch (error) {
            alert(error.message || 'Apply nahi ho paaya.');
            button.disabled = false;
            button.textContent = 'Apply Now';
            return;
        }
        renderJobs();
    }

    function toggleSavedJob(event) {
        const jobId = String(event.currentTarget.dataset.jobId);
        if (savedJobIds.has(jobId)) savedJobIds.delete(jobId);
        else savedJobIds.add(jobId);
        writeSavedJobIds();
        renderJobs();
    }

    function loadData() {
        Promise.all([
            FastTrack.getJson('/api/jobs?hiring_mode=fast_track'),
            FastTrack.getJson('/api/jobs').catch(() => ({ data: { jobs: [] } })),
            FastTrack.getJson('/api/fresher/applications').catch(() => ({ data: { applications: [] } })),
            FastTrack.getJson('/api/fresher/dashboard').catch(() => ({ data: {} })),
            FastTrack.getJson('/api/fresher/certificates').catch(() => ({ data: { certificates: [] } })),
        ]).then(function ([fastTrackJobsResult, allJobsResult, applicationsResult, dashboardResult, certificatesResult]) {
            const fastTrackJobs = FastTrack.apiData(fastTrackJobsResult, 'jobs') || [];
            const allJobs = FastTrack.apiData(allJobsResult, 'jobs') || [];
            const certificates = FastTrack.apiData(certificatesResult, 'certificates') || [];
            hasCertificate = certificates.length > 0;
            usedAllJobsFallback = hasCertificate && fastTrackJobs.length === 0 && allJobs.length > 0;
            jobs = usedAllJobsFallback ? allJobs : fastTrackJobs;
            applications = FastTrack.apiData(applicationsResult, 'applications') || [];
            const dashboard = FastTrack.apiData(dashboardResult) || {};
            const profile = dashboard.profile || {};
            const assessment = dashboard.initial_assessment || {};
            profileSkills = Array.isArray(profile.skills) ? profile.skills : String(profile.skills || '').split(/[,|]/).map((skill) => skill.trim()).filter(Boolean);
            recommendedTrack = assessment.recommended_track || '';
            populateFilters();
            renderJobs();
        }).catch(function (error) {
            jobSummary.textContent = 'Jobs load nahi ho paaye';
            jobList.innerHTML = FastTrack.emptyState('Jobs load nahi ho paaye', error.message || 'Please login again and try.', '/fast-track/login', 'Login');
            savedJobsList.innerHTML = '<p class="text-sm text-[#8a5200]">Saved jobs load nahi ho paaye.</p>';
        });
    }

    document.querySelectorAll('.job-tab').forEach((button) => button.addEventListener('click', function () {
        activeTab = button.dataset.tab;
        renderJobs();
    }));

    [jobSearchInput, jobLocationFilter, jobTypeFilter, jobExperienceFilter].forEach((input) => input.addEventListener('input', renderJobs));
    [jobLocationFilter, jobTypeFilter, jobExperienceFilter].forEach((input) => input.addEventListener('change', renderJobs));
    jobClearFilters.addEventListener('click', function () {
        jobSearchInput.value = '';
        jobLocationFilter.value = '';
        jobTypeFilter.value = '';
        jobExperienceFilter.value = '';
        renderJobs();
    });
    savedViewButton.addEventListener('click', function () {
        activeTab = 'saved';
        renderJobs();
    });

    loadData();
</script>
@endpush
