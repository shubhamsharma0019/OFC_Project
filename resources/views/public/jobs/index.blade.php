@extends('layouts.public')

@section('title', 'Jobs - OnlyFreshers')

@php
    $activePage = 'jobs';
@endphp

@push('styles')
<style>
    .jobs-search-panel {
        border: 1px solid #cfe0ff;
        border-radius: 18px;
        background: linear-gradient(145deg, #ffffff, #f7fbff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .08);
    }
    .jobs-filter-card {
        border: 1px solid #cfe0ff;
        border-radius: 18px;
        background: linear-gradient(145deg, #ffffff, #f8fbff);
        box-shadow: 0 16px 34px rgba(7, 95, 228, .07);
    }
    .job-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #cfe0ff;
        border-radius: 18px;
        background: linear-gradient(145deg, #ffffff, #f7fbff);
        box-shadow: 0 16px 34px rgba(7, 95, 228, .08);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .job-card:hover {
        transform: translateY(-4px);
        border-color: #9fc0f8;
        box-shadow: 0 24px 46px rgba(7, 95, 228, .14);
    }
    .job-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #075fe4, #17a6a8);
    }
    .job-card:after {
        content: "";
        position: absolute;
        right: -52px;
        top: -60px;
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background: rgba(220, 236, 255, .82);
        filter: blur(22px);
        pointer-events: none;
    }
    .job-logo {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        border: 1px solid #cfe0ff;
        background: #fff;
        color: #075fe4;
        font-size: 24px;
        font-weight: 900;
        box-shadow: 0 12px 24px rgba(7, 95, 228, .08);
    }
    .job-pill {
        border-radius: 999px;
        background: #eaf2ff;
        color: #075fe4;
        padding: 6px 11px;
        font-size: 12px;
        font-weight: 800;
    }
</style>
@endpush

@section('content')
    <main class="relative overflow-hidden bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-10 lg:py-[42px] lg:pb-[65px]">
        <div class="pointer-events-none absolute -left-24 top-20 hidden h-[320px] w-[430px] rounded-full bg-[#dcecff]/62 blur-3xl lg:block"></div>
        <div class="pointer-events-none absolute right-0 top-0 hidden h-[380px] w-[55%] bg-[radial-gradient(circle_at_80%_20%,rgba(207,228,255,0.55)_0%,rgba(244,248,255,0.44)_38%,rgba(255,255,255,0)_76%)] lg:block"></div>
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div id="listingView">
                <div class="relative mb-8 max-w-3xl">
                    <h1 class="m-0 font-['Inter'] text-[38px] font-semibold leading-tight text-[#061942] sm:text-[52px]">Find Your <span class="text-[#075fe4]">Dream Job</span></h1>
                    <p class="mt-3 text-lg font-medium leading-[1.7] text-[#34445e]">Explore active fresher openings, filter by work mode, and apply to roles that match your skills.</p>
                </div>

                <div class="jobs-search-panel mb-6 grid gap-4 p-5 lg:grid-cols-[1.35fr_1fr_1fr_170px]">
                    <input id="searchInput" class="h-12 rounded-xl border border-[#cfe0ff] bg-white px-4 text-sm font-semibold text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4] focus:shadow-[0_0_0_3px_rgba(7,95,228,0.08)]" type="text" placeholder="Search job title or keyword">
                    <select id="categorySelect" class="h-12 rounded-xl border border-[#cfe0ff] bg-white px-4 text-sm font-semibold text-[#52607a] outline-none focus:border-[#075fe4] focus:shadow-[0_0_0_3px_rgba(7,95,228,0.08)]">
                        <option value="">All Categories</option>
                    </select>
                    <input id="locationInput" class="h-12 rounded-xl border border-[#cfe0ff] bg-white px-4 text-sm font-semibold text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4] focus:shadow-[0_0_0_3px_rgba(7,95,228,0.08)]" type="text" placeholder="All Locations">
                    <button id="searchButton" class="h-12 rounded-xl border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_22px_rgba(7,95,228,0.18)] transition hover:-translate-y-0.5 hover:bg-[#003f9e]" type="button">Search</button>
                </div>

                <div class="grid gap-[22px] lg:grid-cols-[250px_minmax(0,1fr)] lg:gap-[35px]">
                    <aside class="jobs-filter-card p-5 lg:sticky lg:top-24 lg:self-start">
                        <h3 class="mb-[18px] text-base font-semibold text-[#061942]">Filters</h3>

                        <div id="dynamicFilterGroups" class="text-sm font-medium text-[#52607a]">
                            Loading filters...
                        </div>

                        <div class="pt-3.5">
                            <p class="mb-2.5 text-[13px] font-semibold text-[#061942]">Location</p>
                            <input id="sideLocationInput" class="mb-2.5 h-[46px] w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d]" type="text" placeholder="Search location">
                            <div id="locationChips" class="grid gap-2"></div>
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

                        <div id="jobList" class="grid gap-5">
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
    let allJobs = [];
    let selectedJob = null;

    const jobList = document.getElementById('jobList');
    const jobCount = document.getElementById('jobCount');
    const jobDetail = document.getElementById('jobDetail');
    const searchInput = document.getElementById('searchInput');
    const locationInput = document.getElementById('locationInput');
    const sideLocationInput = document.getElementById('sideLocationInput');
    const categorySelect = document.getElementById('categorySelect');
    const sortSelect = document.getElementById('sortSelect');
    const dynamicFilterGroups = document.getElementById('dynamicFilterGroups');
    const locationChips = document.getElementById('locationChips');
    const initialParams = new URLSearchParams(window.location.search);

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

    function companyLogo(job) {
        const logo = job.company_profile?.company_logo || '';
        if (!logo) return '';
        if (/^(https?:)?\/\//.test(logo) || String(logo).startsWith('/')) return logo;
        return '/storage/' + logo;
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

    function dateText(dateValue) {
        return dateValue ? new Date(dateValue).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    }

    function applyLink(job) {
        return normalizeMode(job.hiring_mode) === 'fast_track' ? '/fast-track/login' : '/direct-mode/login';
    }

    function openingsLeft(job) {
        const total = Number(job.openings || 0);
        const hired = Number(job.hired_applications_count || 0);
        return total ? Math.max(0, total - hired) : 'Open';
    }

    function splitSkills(value) {
        return String(value || '').split(',').map((item) => item.trim()).filter(Boolean);
    }

    function normalizeMode(value) {
        return String(value || '').toLowerCase().replace(/\s+/g, '_');
    }

    function labelMode(value) {
        return normalizeMode(value) === 'fast_track' ? 'Fast Track' : 'Direct';
    }

    function unique(values) {
        return [...new Set(values.map((value) => String(value || '').trim()).filter(Boolean))].sort();
    }

    function setSelect(select, values, label) {
        const current = select.value;
        select.innerHTML = `<option value="">${escapeHtml(label)}</option>` + values.map((value) => `<option value="${escapeHtml(value)}">${escapeHtml(value)}</option>`).join('');
        if (values.includes(current)) select.value = current;
    }

    function renderLogo(job) {
        const logo = companyLogo(job);
        return logo
            ? `<img src="${escapeHtml(logo)}" alt="${escapeHtml(companyName(job))}" class="h-full w-full rounded-[18px] object-contain p-2" onerror="this.outerHTML='${escapeHtml(initials(companyName(job)))}'">`
            : escapeHtml(initials(companyName(job)));
    }

    function renderFilterGroup(title, name, items, formatter) {
        if (!items.length) return '';
        return `<div class="mb-3.5 border-b border-[#dce7f8] pb-3.5 last:mb-0 last:border-b-0 last:pb-0">
            <p class="mb-2.5 text-[13px] font-semibold text-[#061942]">${escapeHtml(title)}</p>
            ${items.map((item) => `<label class="mb-2 flex items-center text-sm font-medium text-[#24344f]"><input type="checkbox" class="sidebar-filter mr-2 accent-[#075fe4]" data-filter="${escapeHtml(name)}" value="${escapeHtml(item)}">${escapeHtml(formatter ? formatter(item) : item)}</label>`).join('')}
        </div>`;
    }

    function renderDynamicFilters() {
        const jobTypes = unique(allJobs.map((job) => job.job_type));
        const modes = unique(allJobs.map((job) => normalizeMode(job.hiring_mode))).filter(Boolean);
        const industries = unique(allJobs.map((job) => job.company_profile?.industry));
        const locations = unique(allJobs.map((job) => job.location)).slice(0, 8);

        setSelect(categorySelect, industries, 'All Categories');
        dynamicFilterGroups.innerHTML = [
            renderFilterGroup('Job Type', 'job_type', jobTypes),
            renderFilterGroup('Work Mode', 'hiring_mode', modes, labelMode),
            renderFilterGroup('Industry', 'industry', industries),
        ].filter(Boolean).join('') || '<p class="text-sm text-[#52607a]">No filters available.</p>';

        locationChips.innerHTML = locations.length
            ? locations.map((location) => `<button type="button" class="location-chip text-left text-sm font-medium text-[#24344f] transition hover:text-[#075fe4]" data-location="${escapeHtml(location)}">${escapeHtml(location)}</button>`).join('')
            : '<p class="text-sm text-[#52607a]">No locations available.</p>';

        document.querySelectorAll('.sidebar-filter').forEach((checkbox) => {
            checkbox.addEventListener('change', renderJobs);
        });

        document.querySelectorAll('.location-chip').forEach((button) => {
            button.addEventListener('click', () => {
                locationInput.value = button.dataset.location;
                sideLocationInput.value = button.dataset.location;
                renderJobs();
            });
        });
    }

    async function loadJobs() {
        jobList.innerHTML = '<div class="p-6 text-sm font-medium text-[#52607a]">Loading active jobs...</div>';
        jobCount.textContent = 'Loading jobs...';

        try {
            const response = await fetch('/api/jobs', { headers: { 'Accept': 'application/json' } });
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Jobs load nahi ho paayi.');
            allJobs = payload.data?.jobs || [];
            jobs = allJobs;
            renderDynamicFilters();
            if (initialParams.get('search')) searchInput.value = initialParams.get('search');
            if (initialParams.get('location')) {
                locationInput.value = initialParams.get('location');
                sideLocationInput.value = initialParams.get('location');
            }
            if (initialParams.get('category')) categorySelect.value = initialParams.get('category');
            renderJobs();
        } catch (error) {
            jobList.innerHTML = '<div class="p-6 text-sm font-medium text-[#b42318]">' + escapeHtml(error.message) + '</div>';
            jobCount.textContent = '0 Jobs Found';
        }
    }

    function renderJobs() {
        const checkedTypes = Array.from(document.querySelectorAll('.sidebar-filter[data-filter="job_type"]:checked')).map((item) => item.value.toLowerCase());
        const checkedModes = Array.from(document.querySelectorAll('.sidebar-filter[data-filter="hiring_mode"]:checked')).map((item) => normalizeMode(item.value));
        const checkedIndustries = Array.from(document.querySelectorAll('.sidebar-filter[data-filter="industry"]:checked')).map((item) => item.value.toLowerCase());
        const query = searchInput.value.trim().toLowerCase();
        const location = (locationInput.value.trim() || sideLocationInput.value.trim()).toLowerCase();
        const category = categorySelect.value.trim().toLowerCase();

        const filtered = allJobs.filter((job) => {
            const typeOk = !checkedTypes.length || checkedTypes.includes(String(job.job_type || '').toLowerCase());
            const modeOk = !checkedModes.length || checkedModes.includes(normalizeMode(job.hiring_mode));
            const industry = String(job.company_profile?.industry || '').toLowerCase();
            const industryOk = (!checkedIndustries.length || checkedIndustries.includes(industry)) && (!category || industry === category);
            const locationOk = !location || String(job.location || '').toLowerCase().includes(location);
            const searchable = [
                job.title,
                companyName(job),
                job.required_skills,
                job.qualification,
                job.description,
                job.location,
                job.job_type,
                labelMode(job.hiring_mode),
                job.company_profile?.industry,
            ].join(' ').toLowerCase();
            const searchOk = !query || searchable.includes(query);
            return typeOk && modeOk && industryOk && locationOk && searchOk;
        });

        const sorted = [...filtered].sort((a, b) => {
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
            <article class="job-card grid gap-4 p-5 sm:grid-cols-[82px_minmax(0,1fr)] lg:grid-cols-[82px_minmax(0,1fr)_150px] lg:items-center lg:gap-5 lg:p-6">
                <div class="job-logo relative z-10">${renderLogo(job)}</div>
                <div class="relative z-10 min-w-0">
                    <h2 class="mb-2 font-['Inter'] text-xl font-semibold text-[#061942]">${escapeHtml(job.title)}</h2>
                    <div class="mb-3 flex flex-wrap gap-2 text-sm font-medium text-[#52607a]">
                        <span class="job-pill">${escapeHtml(companyName(job))}</span>
                        <span class="job-pill">${escapeHtml(job.location || 'Location not added')}</span>
                        <span class="job-pill">${escapeHtml(job.job_type || 'Job Type')}</span>
                        <span class="job-pill">${escapeHtml(labelMode(job.hiring_mode))}</span>
                        ${job.company_profile?.industry ? `<span class="job-pill">${escapeHtml(job.company_profile.industry)}</span>` : ''}
                        <span class="job-pill">${escapeHtml(openingsLeft(job))} Openings</span>
                    </div>
                    <p class="line-clamp-2 text-sm font-semibold leading-[1.7] text-[#24344f]">${escapeHtml(job.description || job.qualification || 'Apply for this fresher opportunity.')}</p>
                </div>
                <div class="relative z-10 sm:col-start-2 lg:col-start-auto lg:text-right">
                    <div class="mb-4 text-[13px] font-semibold text-[#52607a] lg:mb-7">${escapeHtml(humanDate(job.created_at))}</div>
                    <button class="view-job inline-flex h-11 w-full items-center justify-center rounded-xl border border-[#075fe4] bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc] lg:w-auto" type="button" data-id="${job.id}">View Details</button>
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
                        <span>${escapeHtml(labelMode(job.hiring_mode))}</span>
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
                        <a href="${escapeHtml(applyLink(job))}" class="mb-3 flex h-11 w-full items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#003f9e]">Apply Now</a>
                        <a href="/jobs/show?job=${escapeHtml(job.id)}" class="flex h-11 w-full items-center justify-center rounded-lg border border-[#a9c5f6] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Open Detail Page</a>
                    </div>

                    <div class="rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Job Overview</h2>
                        ${overviewRow('Job Type', job.job_type || '-')}
                        ${overviewRow('Hiring Mode', labelMode(job.hiring_mode))}
                        ${overviewRow('Location', job.location || '-')}
                        ${overviewRow('Industry', company.industry || '-')}
                        ${overviewRow('Salary', job.salary || '-')}
                        ${overviewRow('Openings Left', openingsLeft(job))}
                        ${overviewRow('Last Date', dateText(job.application_last_date))}
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

    document.getElementById('searchButton').addEventListener('click', renderJobs);
    sortSelect.addEventListener('change', renderJobs);
    searchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') renderJobs();
    });
    locationInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') renderJobs();
    });
    sideLocationInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            locationInput.value = sideLocationInput.value;
            renderJobs();
        }
    });
    categorySelect.addEventListener('change', renderJobs);
    jobList.addEventListener('click', (event) => {
        const button = event.target.closest('.view-job');
        if (button) showDetail(button.dataset.id);
    });

    if (initialParams.get('job')) {
        showDetail(initialParams.get('job'));
    }
    loadJobs();
</script>
@endpush
