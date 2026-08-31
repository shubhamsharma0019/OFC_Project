@extends('layouts.company')

@section('title', 'Applications - OnlyFreshers')
@section('pageTitle', 'Applications')
@section('pageSubtitle', 'Review all applications received for your posted jobs.')

@php $activePage = 'applications'; @endphp

@push('styles')
<style>
    .company-applications-table-wrap {
        max-height: calc(100vh - 300px);
        overflow: auto;
    }

    .company-applications-table-wrap table {
        table-layout: fixed;
    }

    .company-applications-table-wrap th,
    .company-applications-table-wrap td {
        vertical-align: middle;
    }

    .company-applications-table-wrap .candidate-cell {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .company-applications-table-wrap .candidate-email {
        display: block;
        max-width: 210px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .company-applications-table-wrap .action-cell {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 118px;
        white-space: nowrap;
    }

        .company-applications-table-wrap .score-cell {
            min-width: 94px;
        }

        .bulk-resume-viewer {
            display: none;
            margin-bottom: 18px;
            border: 1px solid #dce7f8;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .bulk-resume-viewer.active {
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            min-height: 560px;
        }

        .bulk-resume-list {
            border-right: 1px solid #dce7f8;
            background: #f8fbff;
            overflow: auto;
            max-height: 680px;
        }

        .bulk-resume-item {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #e8eef8;
            background: transparent;
            padding: 13px 14px;
            text-align: left;
            cursor: pointer;
        }

        .bulk-resume-item.active {
            background: #eaf2ff;
            color: #075fe4;
        }

        .bulk-resume-frame {
            width: 100%;
            height: 680px;
            border: 0;
            background: #fff;
        }

    @media (min-width: 641px) {
        .company-applications-table-wrap table {
            min-width: 1180px !important;
        }
    }

        @media (max-width: 640px) {
        .company-applications-page {
            padding: 14px !important;
        }

        .company-applications-filters {
            gap: 10px !important;
            margin-bottom: 14px !important;
        }

        .company-applications-filters select,
        .company-applications-filters input,
            .company-applications-filters button {
                width: 100%;
            }

            .bulk-resume-viewer.active {
                grid-template-columns: 1fr;
            }

            .bulk-resume-list {
                max-height: 220px;
                border-right: 0;
                border-bottom: 1px solid #dce7f8;
            }

            .bulk-resume-frame {
                height: 520px;
            }

        .company-applications-table-wrap {
            overflow: visible !important;
            border: 0 !important;
        }

        .company-applications-table-wrap table,
        .company-applications-table-wrap thead,
        .company-applications-table-wrap tbody,
        .company-applications-table-wrap tr,
        .company-applications-table-wrap td {
            display: block;
            width: 100%;
        }

        .company-applications-table-wrap table {
            min-width: 0 !important;
        }

        .company-applications-table-wrap thead {
            display: none;
        }

        .company-applications-table-wrap tbody {
            display: grid;
            gap: 12px;
        }

        .company-applications-table-wrap tr {
            overflow: hidden;
            border: 1px solid #dce7f8 !important;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 10px 22px rgba(6, 25, 66, .05);
        }

        .company-applications-table-wrap td {
            display: grid;
            grid-template-columns: minmax(82px, 32%) minmax(0, 1fr);
            gap: 10px;
            align-items: start;
            border-bottom: 1px solid #edf2fb;
            padding: 10px 12px !important;
            font-size: 12px !important;
            line-height: 1.4;
            word-break: break-word;
        }

        .company-applications-table-wrap td:last-child {
            border-bottom: 0;
        }

        .company-applications-table-wrap td::before {
            content: attr(data-label);
            color: #52607a;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .company-applications-table-wrap td:first-child {
            display: block;
            padding: 12px !important;
        }

        .company-applications-table-wrap td:first-child::before,
        .company-applications-table-wrap td[colspan]::before {
            display: none;
        }

        .company-applications-table-wrap td[colspan] {
            display: block;
            text-align: center;
        }

        .company-application-action {
            display: inline-flex;
            min-height: 34px;
            width: 100%;
            align-items: center;
            justify-content: center;
            border: 1px solid #075fe4;
            border-radius: 8px;
            color: #075fe4 !important;
            font-size: 13px !important;
            font-weight: 700;
        }

        .company-application-action::after {
            content: 'View';
        }

        .company-application-action {
            font-size: 0 !important;
        }
    }
</style>
@endpush

@section('content')
    <section class="company-applications-page rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div id="bulkResumePanel" class="mb-4 hidden rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#061942]">Bulk Resume Access</h3>
                    <p id="bulkResumeNote" class="mt-1 text-xs font-semibold text-[#52607a]">Available with Custom plan.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button id="selectAllVisible" type="button" class="h-9 rounded-lg border border-[#9fc0f5] bg-white px-4 text-xs font-bold text-[#075fe4]">Select Visible</button>
                    <button id="clearSelection" type="button" class="h-9 rounded-lg border border-[#dce7f8] bg-white px-4 text-xs font-bold text-[#24344f]">Clear</button>
                    <button id="openSelectedResumes" type="button" class="h-9 rounded-lg bg-[#075fe4] px-4 text-xs font-bold text-white">Open Resumes</button>
                </div>
            </div>
        </div>

        <div id="bulkResumeViewer" class="bulk-resume-viewer">
            <div>
                <div class="flex items-center justify-between border-b border-[#dce7f8] bg-white px-4 py-3">
                    <h3 class="text-sm font-bold text-[#061942]">Selected Resumes</h3>
                    <button id="closeBulkViewer" type="button" class="text-xs font-bold text-[#075fe4]">Close</button>
                </div>
                <div id="bulkResumeList" class="bulk-resume-list"></div>
            </div>
            <div>
                <div class="flex items-center justify-between border-b border-[#dce7f8] px-4 py-3">
                    <div>
                        <h3 id="bulkResumeTitle" class="text-sm font-bold text-[#061942]">Resume Preview</h3>
                        <p id="bulkResumeMeta" class="mt-1 text-xs text-[#52607a]">Select a candidate.</p>
                    </div>
                    <a id="bulkResumeDownload" href="#" class="hidden h-9 items-center rounded-lg border border-[#9fc0f5] px-4 text-xs font-bold text-[#075fe4]">Download</a>
                </div>
                <iframe id="bulkResumeFrame" class="bulk-resume-frame" title="Resume preview"></iframe>
            </div>
        </div>

        <div class="company-applications-filters mb-[26px] grid grid-cols-1 gap-[14px] lg:grid-cols-4">
            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Jobs</option>
            </select>

            <select id="statusFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Status</option>
                <option value="applied">Applied</option>
                <option value="under_review">Under Review</option>
                <option value="shortlisted">Shortlisted</option>
                <option value="interview_scheduled">Interview Scheduled</option>
                <option value="hired">Hired</option>
                <option value="rejected">Rejected</option>
            </select>

            <select id="flowFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Flows</option>
                <option value="direct">Direct</option>
                <option value="fast_track">Fast Track</option>
            </select>

            <select id="courseFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Courses</option>
            </select>

            <select id="locationFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Locations</option>
            </select>

            <select id="letterFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Letters</option>
            </select>

            <input id="minInitialScore" type="number" min="0" max="100" placeholder="Min Initial %" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
            <input id="minFinalScore" type="number" min="0" max="100" placeholder="Min Final %" class="hidden h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <input id="searchInput" type="search" placeholder="Search by name, email, job or skills..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <button id="resetFilters" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#24344f] transition hover:bg-[#f5f9ff]">
                Reset
            </button>
        </div>

        <div class="company-applications-table-wrap overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[900px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[58px] w-[86px] px-5 text-left text-[13px] font-bold text-[#24344f]">Select</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Profile</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Scores</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Status</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Applied Date</th>
                        <th class="h-[58px] w-[140px] px-5 text-left text-[13px] font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody id="applicationBody">
                    <tr><td colspan="8" class="px-5 py-8 text-center text-sm font-bold text-[#52607a]">Loading applications...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Loading applications...</span>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const jobFilter = document.getElementById('jobFilter');
    const statusFilter = document.getElementById('statusFilter');
    const flowFilter = document.getElementById('flowFilter');
    const courseFilter = document.getElementById('courseFilter');
    const locationFilter = document.getElementById('locationFilter');
    const letterFilter = document.getElementById('letterFilter');
    const minInitialScore = document.getElementById('minInitialScore');
    const minFinalScore = document.getElementById('minFinalScore');
    const searchInput = document.getElementById('searchInput');
    const applicationBody = document.getElementById('applicationBody');
    const resultText = document.getElementById('resultText');
    const bulkResumePanel = document.getElementById('bulkResumePanel');
    const bulkResumeNote = document.getElementById('bulkResumeNote');
    const bulkResumeViewer = document.getElementById('bulkResumeViewer');
    const bulkResumeList = document.getElementById('bulkResumeList');
    const bulkResumeFrame = document.getElementById('bulkResumeFrame');
    const bulkResumeTitle = document.getElementById('bulkResumeTitle');
    const bulkResumeMeta = document.getElementById('bulkResumeMeta');
    const bulkResumeDownload = document.getElementById('bulkResumeDownload');
    let applications = [];
    let filteredApplications = [];
    let selectedApplicationIds = new Set();
    let companyProfile = null;

    const statusClasses = {
        applied: 'bg-[#eaf2ff] text-[#075fe4]',
        under_review: 'bg-[#eaf2ff] text-[#075fe4]',
        shortlisted: 'bg-[#dbf8e9] text-[#00a65a]',
        interview_scheduled: 'bg-[#f0edff] text-[#6c50ff]',
        hired: 'bg-[#e8fbf3] text-[#00ad6f]',
        rejected: 'bg-[#ffe8eb] text-[#ff3045]',
    };

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
    }[char]));
    const formatStatus = (status) => String(status || '').replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
    const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    const initials = (name) => String(name || 'C').split(' ').map((part) => part.charAt(0)).join('').slice(0, 2).toUpperCase();
    const normalize = (value) => String(value || '').trim().toLowerCase();
    const numberValue = (value) => Number(value ?? 0) || 0;
    const summary = (app) => app.candidate_summary || {};
    const candidateName = (app) => app.fresher_profile?.user?.name || 'Candidate';
    const candidateFlow = (app) => normalize(summary(app).flow || app.job?.hiring_mode || 'direct').replace(' ', '_');
    const candidateCourse = (app) => summary(app).course || app.fresher_profile?.qualification || '';
    const candidateLocation = (app) => app.fresher_profile?.city || app.job?.location || '';
    const candidateResume = (app) => app.fresher_profile?.resume || '';
    const scoreText = (value) => value !== null && value !== undefined && value !== '' ? `${Math.round(Number(value))}%` : '-';
    const hasCustomPlanAccess = () => ['custom', 'customized', 'customised'].includes(normalize(companyProfile?.subscription_plan));
    const advancedFilterFields = () => [flowFilter, courseFilter, locationFilter, letterFilter, minInitialScore, minFinalScore];
    const resumeOpenUrl = (path) => `/company/resumes/open?path=${encodeURIComponent(path)}&token=${encodeURIComponent(token)}`;
    const resumeDownloadUrl = (path) => `/company/resumes/download?path=${encodeURIComponent(path)}&token=${encodeURIComponent(token)}`;

    async function guardCompanyFlow() {
        if (!token) {
            window.location.href = '/company/login';
            return false;
        }

        const response = await fetch('/api/company/profile', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });

        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            window.location.href = '/company/login';
            return false;
        }

        const result = await response.json();
        const profile = result.data?.profile;

        if (!profile) {
            window.location.href = '/company/profile/edit';
            return false;
        }

        companyProfile = profile;
        localStorage.setItem('ofc_company_profile', JSON.stringify(profile));
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));

        if (profile.approval_status === 'pending') {
            window.location.href = '/company/approval/pending';
            return false;
        }

        if (profile.approval_status === 'rejected') {
            window.location.href = '/company/approval/rejected';
            return false;
        }

        if (profile.hiring_intent === 'resume_only') {
            window.location.href = '/company/resumes';
            return false;
        }

        return true;
    }

    function populateJobs() {
        const jobs = [...new Map(applications.map((app) => [app.job?.id, app.job]).filter(([id]) => id)).values()];
        jobFilter.innerHTML = '<option value="all">All Jobs</option>' + jobs.map((job) => `<option value="${job.id}">${escapeHtml(job.title)}</option>`).join('');
        populateFilterOptions(courseFilter, applications.map(candidateCourse).filter(Boolean), 'All Courses');
        populateFilterOptions(locationFilter, applications.map(candidateLocation).filter(Boolean), 'All Locations');
        const letters = [...new Set(applications.map((app) => candidateName(app).charAt(0).toUpperCase()).filter(Boolean))].sort();
        letterFilter.innerHTML = '<option value="all">All Letters</option>' + letters.map((letter) => `<option value="${escapeHtml(letter)}">${escapeHtml(letter)}</option>`).join('');
    }

    function populateFilterOptions(select, values, label) {
        const current = select.value;
        const options = [...new Set(values)].sort();
        select.innerHTML = `<option value="all">${label}</option>` + options.map((value) => `<option value="${escapeHtml(value)}">${escapeHtml(value)}</option>`).join('');
        if (options.includes(current)) select.value = current;
    }

    function syncBulkPanel() {
        const advanced = hasCustomPlanAccess();
        bulkResumePanel.classList.remove('hidden');
        bulkResumeNote.textContent = advanced
            ? `${selectedApplicationIds.size} selected. You can open resumes from Direct and Fast Track candidates.`
            : 'Custom plan required for bulk resumes, Direct + Fast Track filters and assessment scores.';
        document.getElementById('selectAllVisible').disabled = !advanced;
        document.getElementById('clearSelection').disabled = !advanced;
        document.getElementById('openSelectedResumes').disabled = !advanced || selectedApplicationIds.size === 0;
        advancedFilterFields().forEach((field) => {
            field.disabled = !advanced;
            field.classList.toggle('opacity-60', !advanced);
            field.classList.toggle('cursor-not-allowed', !advanced);
        });
    }

    function selectedResumeApplications() {
        return applications
            .filter((app) => selectedApplicationIds.has(Number(app.id)) && candidateResume(app))
            .sort((a, b) => candidateName(a).localeCompare(candidateName(b)));
    }

    function openResumeInViewer(app) {
        const resume = candidateResume(app);
        const appSummary = summary(app);
        bulkResumeTitle.textContent = candidateName(app);
        bulkResumeMeta.textContent = `${formatStatus(candidateFlow(app))} | Initial: ${scoreText(appSummary.initial_score)}${candidateFlow(app) === 'fast_track' ? ` | Final: ${scoreText(appSummary.final_score)}` : ''}`;
        bulkResumeFrame.src = resumeOpenUrl(resume);
        bulkResumeDownload.href = resumeDownloadUrl(resume);
        bulkResumeDownload.classList.remove('hidden');
        bulkResumeDownload.classList.add('inline-flex');
        document.querySelectorAll('[data-preview-resume]').forEach((button) => {
            button.classList.toggle('active', Number(button.dataset.previewResume) === Number(app.id));
        });
    }

    function renderBulkResumeViewer() {
        const selected = selectedResumeApplications();

        if (!selected.length) {
            showBulkMessage('Select at least one candidate with a resume.');
            return;
        }

        bulkResumeViewer.classList.add('active');
        bulkResumeList.innerHTML = selected.map((app, index) => {
            const appSummary = summary(app);
            return `
                <button class="bulk-resume-item ${index === 0 ? 'active' : ''}" type="button" data-preview-resume="${app.id}">
                    <strong class="block text-sm">${escapeHtml(candidateName(app))}</strong>
                    <span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(formatStatus(candidateFlow(app)))} | Initial ${escapeHtml(scoreText(appSummary.initial_score))}${candidateFlow(app) === 'fast_track' ? ` | Final ${escapeHtml(scoreText(appSummary.final_score))}` : ''}</span>
                </button>`;
        }).join('');
        document.querySelectorAll('[data-preview-resume]').forEach((button) => {
            button.addEventListener('click', () => {
                const app = selected.find((item) => Number(item.id) === Number(button.dataset.previewResume));
                if (app) openResumeInViewer(app);
            });
        });
        openResumeInViewer(selected[0]);
        bulkResumeViewer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function showBulkMessage(message) {
        bulkResumeViewer.classList.add('active');
        bulkResumeList.innerHTML = `<div class="p-4 text-sm font-bold text-[#52607a]">${escapeHtml(message)}</div>`;
        bulkResumeTitle.textContent = 'Resume Preview';
        bulkResumeMeta.textContent = message;
        bulkResumeFrame.removeAttribute('src');
        bulkResumeDownload.classList.add('hidden');
        bulkResumeDownload.classList.remove('inline-flex');
    }

    function renderApplications() {
        const selectedJob = jobFilter.value;
        const selectedStatus = statusFilter.value;
        const advanced = hasCustomPlanAccess();
        const selectedFlow = advanced ? flowFilter.value : 'all';
        minFinalScore.classList.toggle('hidden', !advanced || selectedFlow !== 'fast_track');
        if (selectedFlow !== 'fast_track') minFinalScore.value = '';
        const selectedCourse = advanced ? courseFilter.value : 'all';
        const selectedLocation = advanced ? locationFilter.value : 'all';
        const selectedLetter = advanced ? letterFilter.value : 'all';
        const minimumInitial = advanced ? Number(minInitialScore.value || 0) : 0;
        const minimumFinal = advanced ? Number(minFinalScore.value || 0) : 0;
        const search = searchInput.value.trim().toLowerCase();

        const filtered = applications.filter((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const appSummary = summary(app);
            const haystack = [user.name, user.email, profile.skills, profile.qualification, profile.city, job.title, appSummary.preferred_role, candidateCourse(app), candidateFlow(app)].join(' ').toLowerCase();

            return (selectedJob === 'all' || String(job.id) === selectedJob)
                && (selectedStatus === 'all' || app.application_status === selectedStatus)
                && (selectedFlow === 'all' || candidateFlow(app) === selectedFlow)
                && (selectedCourse === 'all' || normalize(candidateCourse(app)) === normalize(selectedCourse))
                && (selectedLocation === 'all' || normalize(candidateLocation(app)).includes(normalize(selectedLocation)))
                && (selectedLetter === 'all' || candidateName(app).toUpperCase().startsWith(selectedLetter))
                && (!minimumInitial || numberValue(appSummary.initial_score) >= minimumInitial)
                && (!minimumFinal || numberValue(appSummary.final_score) >= minimumFinal)
                && haystack.includes(search);
        });
        filteredApplications = filtered;

        if (!filtered.length) {
            applicationBody.innerHTML = '<tr><td colspan="8" class="px-5 py-8 text-center text-sm text-[#52607a]">No applications found.</td></tr>';
            resultText.textContent = `Showing 0 of ${applications.length} applications`;
            syncBulkPanel();
            return;
        }

        applicationBody.innerHTML = filtered.map((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const status = app.application_status || 'applied';
            const appSummary = summary(app);
            const resume = candidateResume(app);
            const checked = selectedApplicationIds.has(Number(app.id));

            return `
                <tr class="border-b border-[#edf2fb] last:border-b-0">
                    <td class="px-5 py-[18px] align-middle text-[13px]" data-label="Select">
                        <input type="checkbox" data-select-application="${app.id}" ${checked ? 'checked' : ''} ${!advanced || !resume ? 'disabled' : ''} class="h-4 w-4 accent-[#075fe4]">
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px]" data-label="Candidate">
                        <div class="candidate-cell">
                            <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">${escapeHtml(initials(user.name))}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h3>
                                <p class="candidate-email text-xs text-[#52607a]" title="${escapeHtml(user.email || '-')}">${escapeHtml(user.email || '-')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px]" data-label="Job Role">
                        <div>
                            <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(job.title || '-')}</h3>
                            <p class="text-xs text-[#52607a]">${escapeHtml(formatStatus(candidateFlow(app)))}</p>
                        </div>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px] text-[#24344f]" data-label="Profile">
                        <div class="break-words">${escapeHtml(candidateCourse(app) || profile.qualification || '-')}</div>
                        <div class="mt-1 text-xs text-[#52607a]">${escapeHtml(profile.city || '')}</div>
                    </td>
                    <td class="score-cell px-5 py-[18px] align-middle text-[13px] text-[#24344f]" data-label="Scores">
                        ${advanced ? `<div class="font-bold text-[#061942]">Initial: ${escapeHtml(scoreText(appSummary.initial_score))}</div>${candidateFlow(app) === 'fast_track' ? `<div class="mt-1 text-xs font-bold text-[#52607a]">Final: ${escapeHtml(scoreText(appSummary.final_score))}</div>` : ''}` : '<span class="text-xs font-bold text-[#52607a]">Upgrade to view</span>'}
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px]" data-label="Status">
                        <span class="inline-flex h-[30px] min-w-[68px] items-center justify-center rounded-lg px-3 text-xs font-bold ${statusClasses[status] || statusClasses.applied}">${escapeHtml(formatStatus(status))}</span>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px] text-[#24344f]" data-label="Applied">${formatDate(app.applied_at || app.created_at)}</td>
                    <td class="px-5 py-[18px] align-middle text-[13px]" data-label="Action">
                        <div class="action-cell">
                        ${advanced && resume ? `<button type="button" data-open-single-resume="${app.id}" class="text-xs font-bold text-[#075fe4]">Resume</button>` : ''}
                        <a href="/company/applications/show" data-application-id="${app.id}" class="application-link company-application-action text-[22px] leading-none text-[#061942]" aria-label="View application details">&#8942;</a>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        document.querySelectorAll('.application-link').forEach((link) => {
            link.addEventListener('click', () => {
                localStorage.setItem('ofc_selected_company_application_id', link.dataset.applicationId);
            });
        });
        document.querySelectorAll('[data-select-application]').forEach((input) => {
            input.addEventListener('change', () => {
                const id = Number(input.dataset.selectApplication);
                if (input.checked) selectedApplicationIds.add(id);
                else selectedApplicationIds.delete(id);
                syncBulkPanel();
            });
        });
        document.querySelectorAll('[data-open-single-resume]').forEach((button) => {
            button.addEventListener('click', () => {
                const app = applications.find((item) => Number(item.id) === Number(button.dataset.openSingleResume));
                if (!app) return;
                selectedApplicationIds.add(Number(app.id));
                renderBulkResumeViewer();
                renderApplications();
            });
        });

        resultText.textContent = `Showing ${filtered.length} of ${applications.length} applications`;
        syncBulkPanel();
    }

    async function loadApplications() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;

        const response = await fetch('/api/company/applications', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load applications.');
        }

        applications = result.data.applications || [];
        populateJobs();
        renderApplications();
    }

    jobFilter.addEventListener('change', renderApplications);
    statusFilter.addEventListener('change', renderApplications);
    searchInput.addEventListener('input', renderApplications);
    [flowFilter, courseFilter, locationFilter, letterFilter, minInitialScore, minFinalScore].forEach((input) => {
        input.addEventListener('input', renderApplications);
        input.addEventListener('change', renderApplications);
    });
    document.getElementById('selectAllVisible').addEventListener('click', () => {
        if (!hasCustomPlanAccess()) return;
        filteredApplications.forEach((app) => {
            if (candidateResume(app)) selectedApplicationIds.add(Number(app.id));
        });
        renderApplications();
    });
    document.getElementById('clearSelection').addEventListener('click', () => {
        selectedApplicationIds.clear();
        renderApplications();
    });
    document.getElementById('openSelectedResumes').addEventListener('click', () => {
        if (!hasCustomPlanAccess()) return;
        renderBulkResumeViewer();
    });
    document.getElementById('closeBulkViewer').addEventListener('click', () => {
        bulkResumeViewer.classList.remove('active');
        bulkResumeFrame.removeAttribute('src');
    });
    document.getElementById('resetFilters').addEventListener('click', () => {
        jobFilter.value = 'all';
        statusFilter.value = 'all';
        flowFilter.value = 'all';
        courseFilter.value = 'all';
        locationFilter.value = 'all';
        letterFilter.value = 'all';
        minInitialScore.value = '';
        minFinalScore.value = '';
        searchInput.value = '';
        selectedApplicationIds.clear();
        renderApplications();
    });

    loadApplications().catch((error) => {
        applicationBody.innerHTML = `<tr><td colspan="6" class="px-5 py-8 text-center text-sm text-[#ff3045]">${escapeHtml(error.message || 'Unable to load applications.')}</td></tr>`;
        resultText.textContent = 'Unable to load applications.';
    });
</script>
@endpush
