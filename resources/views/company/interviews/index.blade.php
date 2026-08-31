@extends('layouts.company')

@section('title', 'Interviews - OnlyFreshers')
@section('pageTitle', 'Interviews')
@section('pageSubtitle', 'Schedule and manage interviews with candidates.')

@php $activePage = 'interviews'; @endphp

@push('styles')
<style>
    @media (max-width: 640px) {
        .company-interviews-page {
            padding: 14px !important;
        }

        .company-interviews-head {
            gap: 12px !important;
            margin-bottom: 14px !important;
        }

        .company-interview-tabs {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px !important;
            width: 100%;
        }

        .company-interview-tabs .interview-tab {
            border: 1px solid #dce7f8 !important;
            border-radius: 8px;
            padding: 9px 8px !important;
            background: #fff;
            font-size: 11px !important;
            text-align: center;
        }

        .company-interview-tabs .interview-tab.text-\[\#075fe4\] {
            border-color: #075fe4 !important;
            background: #eaf2ff;
        }

        .company-interviews-head > a,
        .company-interviews-filters select,
        .company-interviews-filters input,
        .company-interviews-filters button {
            width: 100% !important;
        }

        .company-interviews-filters {
            gap: 10px !important;
            margin-bottom: 14px !important;
        }

        .company-interviews-table-wrap {
            overflow: visible !important;
            border: 0 !important;
        }

        .company-interviews-table-wrap table,
        .company-interviews-table-wrap thead,
        .company-interviews-table-wrap tbody,
        .company-interviews-table-wrap tr,
        .company-interviews-table-wrap td {
            display: block;
            width: 100%;
        }

        .company-interviews-table-wrap table {
            min-width: 0 !important;
        }

        .company-interviews-table-wrap thead {
            display: none;
        }

        .company-interviews-table-wrap tbody {
            display: grid;
            gap: 12px;
        }

        .company-interviews-table-wrap tr {
            overflow: hidden;
            border: 1px solid #dce7f8 !important;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 10px 22px rgba(6, 25, 66, .05);
        }

        .company-interviews-table-wrap td {
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

        .company-interviews-table-wrap td:last-child {
            border-bottom: 0;
        }

        .company-interviews-table-wrap td::before {
            content: attr(data-label);
            color: #52607a;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .company-interviews-table-wrap td:first-child {
            display: block;
            padding: 12px !important;
        }

        .company-interviews-table-wrap td:first-child::before,
        .company-interviews-table-wrap td[colspan]::before {
            display: none;
        }

        .company-interviews-table-wrap td[colspan] {
            display: block;
            text-align: center;
        }

        .company-interview-actions {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px !important;
        }

        .company-interview-actions a,
        .company-interview-actions button {
            min-height: 34px;
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        #editInterviewModal {
            align-items: flex-start !important;
            overflow-y: auto;
        }
    }
</style>
@endpush

@section('content')
    <section class="company-interviews-page rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
        <div class="company-interviews-head mb-[22px] flex flex-col gap-[18px] border-b border-[#dce7f8] pb-3.5 xl:flex-row xl:items-center xl:justify-between">
            <div class="company-interview-tabs flex flex-wrap gap-x-6 gap-y-2 xl:gap-x-[34px]" role="tablist" aria-label="Interview status tabs">
                <button class="interview-tab border-b-[3px] border-[#075fe4] px-3.5 py-2.5 text-[13px] font-semibold text-[#075fe4]" data-status="all" type="button">All Interviews (<span id="allCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="scheduled" type="button">Scheduled (<span id="scheduledCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="completed" type="button">Completed (<span id="completedCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="cancelled" type="button">Cancelled (<span id="cancelledCount">0</span>)</button>
            </div>

            <a href="/company/applications" class="inline-flex h-[42px] w-[180px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">Applications</a>
        </div>

        <div class="company-interviews-filters mb-6 grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_190px_120px]">
            <input id="searchInput" type="search" placeholder="Search by candidate name or job role..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Jobs</option>
            </select>
            <button id="resetFilters" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">Reset</button>
        </div>

        <p id="interviewMessage" class="mb-4 hidden rounded-lg border px-4 py-3 text-sm font-bold"></p>

        <div class="company-interviews-table-wrap overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[980px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Mode</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Date & Time</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Status</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody id="interviewBody">
                    <tr><td colspan="6" class="px-5 py-8 text-center text-sm font-bold text-[#52607a]">Loading interviews...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Loading interviews...</span>
        </div>
    </section>

    <div id="editInterviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#061942]/45 px-4 py-6">
        <form id="editInterviewForm" class="w-full max-w-[560px] rounded-lg border border-[#dce7f8] bg-white p-5 shadow-2xl">
            <div class="mb-5 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-[#061942]">Edit Interview</h2>
                    <p id="editInterviewCandidate" class="mt-1 text-sm text-[#52607a]"></p>
                </div>
                <button id="closeEditInterview" type="button" class="grid h-9 w-9 place-items-center rounded-lg border border-[#dce7f8] text-lg font-bold text-[#52607a]">x</button>
            </div>

            <p id="editInterviewMessage" class="mb-4 hidden rounded-lg border px-4 py-3 text-sm font-bold"></p>

            <div class="grid gap-4 sm:grid-cols-2">
                <label class="grid gap-2 text-sm font-bold text-[#061942]">
                    Date
                    <input id="editInterviewDate" class="h-11 rounded-lg border border-[#dce7f8] px-3 text-sm font-medium outline-none focus:border-[#075fe4]" type="date" required>
                </label>

                <label class="grid gap-2 text-sm font-bold text-[#061942]">
                    Time
                    <input id="editInterviewTime" class="h-11 rounded-lg border border-[#dce7f8] px-3 text-sm font-medium outline-none focus:border-[#075fe4]" type="time" required>
                </label>

                <label class="grid gap-2 text-sm font-bold text-[#061942] sm:col-span-2">
                    Mode
                    <select id="editInterviewMode" class="h-11 rounded-lg border border-[#dce7f8] px-3 text-sm font-medium outline-none focus:border-[#075fe4]" required>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </label>

                <label id="editMeetingLinkWrap" class="grid gap-2 text-sm font-bold text-[#061942] sm:col-span-2">
                    Google Meet Link
                    <input id="editMeetingLink" class="h-11 rounded-lg border border-[#dce7f8] px-3 text-sm font-medium outline-none focus:border-[#075fe4]" type="url" placeholder="https://meet.google.com/abc-defg-hij">
                </label>

                <label id="editLocationWrap" class="hidden gap-2 text-sm font-bold text-[#061942] sm:col-span-2">
                    Location
                    <input id="editInterviewLocation" class="h-11 rounded-lg border border-[#dce7f8] px-3 text-sm font-medium outline-none focus:border-[#075fe4]" type="text" placeholder="Office address / venue">
                </label>
            </div>

            <div class="mt-5 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button id="cancelEditInterview" type="button" class="h-10 rounded-lg border border-[#dce7f8] px-5 text-sm font-bold text-[#52607a]">Cancel</button>
                <button id="saveEditInterview" type="submit" class="h-10 rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white">Save Changes</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_company_token') ||
        localStorage.getItem('onlyfreshers_company_token') ||
        localStorage.getItem('ofc_auth_token');
    const body = document.getElementById('interviewBody');
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const resultText = document.getElementById('resultText');
    const message = document.getElementById('interviewMessage');
    const editModal = document.getElementById('editInterviewModal');
    const editForm = document.getElementById('editInterviewForm');
    const editMessage = document.getElementById('editInterviewMessage');
    const editMode = document.getElementById('editInterviewMode');
    const editMeetingLinkWrap = document.getElementById('editMeetingLinkWrap');
    const editLocationWrap = document.getElementById('editLocationWrap');
    const saveEditInterview = document.getElementById('saveEditInterview');
    let interviews = [];
    let activeStatus = 'all';
    let editingInterviewId = null;

    const statusClasses = {
        scheduled: 'bg-[#fff0d1] text-[#c86b00]',
        completed: 'bg-[#dbf8e9] text-[#00a65a]',
        cancelled: 'bg-[#ffe8eb] text-[#ff3045]',
        hired: 'bg-[#dbf8e9] text-[#00a65a]',
        not_selected: 'bg-[#ffe8eb] text-[#ff3045]',
    };

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
    }[char]));
    const escapeAttr = (value) => escapeHtml(value).replace(/`/g, '&#096;');
    const formatStatus = (status) => String(status || '').replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
    const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    const initials = (name) => String(name || 'C').split(' ').map((part) => part.charAt(0)).join('').slice(0, 2).toUpperCase();
    const dateValue = (value) => value ? String(value).slice(0, 10) : '';
    const timeValue = (value) => value ? String(value).slice(0, 5) : '';

    function interviewDateTime(interview) {
        if (!interview.interview_date) return null;
        const datePart = String(interview.interview_date).split('T')[0];
        const date = new Date(`${datePart}T${interview.interview_time || '00:00'}`);
        return Number.isNaN(date.getTime()) ? null : date;
    }

    function meetingEnded(interview) {
        const status = String(interview.status || '').toLowerCase();
        if (['completed', 'cancelled'].includes(status)) return true;
        return false;
    }

    function showMessage(text, type = 'error') {
        message.textContent = text;
        message.className = `mb-4 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
    }

    function showEditMessage(text, type = 'error') {
        editMessage.textContent = text;
        editMessage.className = `mb-4 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
    }

    function clearEditMessage() {
        editMessage.textContent = '';
        editMessage.className = 'mb-4 hidden rounded-lg border px-4 py-3 text-sm font-bold';
    }

    function toggleEditModeFields() {
        const online = editMode.value === 'online';
        editMeetingLinkWrap.classList.toggle('hidden', !online);
        editMeetingLinkWrap.classList.toggle('grid', online);
        editLocationWrap.classList.toggle('hidden', online);
        editLocationWrap.classList.toggle('grid', !online);
        document.getElementById('editMeetingLink').required = online;
        document.getElementById('editInterviewLocation').required = !online;
    }

    function openEditInterview(interviewId) {
        const interview = interviews.find((item) => String(item.id) === String(interviewId));
        if (!interview) return;

        const app = interview.job_application || {};
        const user = app.fresher_profile?.user || {};
        const job = app.job || {};
        editingInterviewId = interview.id;
        clearEditMessage();

        document.getElementById('editInterviewCandidate').textContent = `${user.name || 'Candidate'} - ${job.title || 'Job Role'}`;
        document.getElementById('editInterviewDate').value = dateValue(interview.interview_date);
        document.getElementById('editInterviewTime').value = timeValue(interview.interview_time);
        editMode.value = interview.interview_mode || 'online';
        document.getElementById('editMeetingLink').value = interview.meeting_link || '';
        document.getElementById('editInterviewLocation').value = interview.interview_location || '';
        toggleEditModeFields();

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    }

    function closeEditInterview() {
        editingInterviewId = null;
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
        editForm.reset();
        clearEditMessage();
    }

    async function guardCompanyFlow() {
        if (!token) {
            window.location.href = '/company/login';
            return false;
        }
        const response = await fetch('/api/company/profile', { headers: { Accept: 'application/json', Authorization: `Bearer ${token}` } });
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
        return true;
    }

    function updateCounts() {
        document.getElementById('allCount').textContent = interviews.length;
        document.getElementById('scheduledCount').textContent = interviews.filter((interview) => interview.status === 'scheduled').length;
        document.getElementById('completedCount').textContent = interviews.filter((interview) => ['completed', 'hired', 'not_selected'].includes(interview.status)).length;
        document.getElementById('cancelledCount').textContent = interviews.filter((interview) => interview.status === 'cancelled').length;
    }

    function populateJobs() {
        const jobs = [...new Map(interviews.map((interview) => [interview.job_application?.job?.id, interview.job_application?.job]).filter(([id]) => id)).values()];
        jobFilter.innerHTML = '<option value="all">All Jobs</option>' + jobs.map((job) => `<option value="${job.id}">${escapeHtml(job.title)}</option>`).join('');
    }

    function filteredInterviews() {
        const search = searchInput.value.trim().toLowerCase();
        const selectedJob = jobFilter.value;
        return interviews.filter((interview) => {
            const app = interview.job_application || {};
            const user = app.fresher_profile?.user || {};
            const job = app.job || {};
            const haystack = [user.name, user.email, job.title, interview.interview_mode, interview.status].join(' ').toLowerCase();
            const matchesStatus = activeStatus === 'all' ||
                interview.status === activeStatus ||
                (activeStatus === 'completed' && ['hired', 'not_selected'].includes(interview.status));

            return matchesStatus
                && (selectedJob === 'all' || String(job.id) === selectedJob)
                && haystack.includes(search);
        });
    }

    function renderInterviews() {
        const filtered = filteredInterviews();
        if (!filtered.length) {
            body.innerHTML = '<tr><td colspan="6" class="px-5 py-8 text-center text-sm text-[#52607a]">No interviews found.</td></tr>';
            resultText.textContent = `Showing 0 of ${interviews.length} interviews`;
            return;
        }

        body.innerHTML = filtered.map((interview) => {
            const app = interview.job_application || {};
            const user = app.fresher_profile?.user || {};
            const job = app.job || {};
            const isResumeInterview = interview.source === 'resume_assignment';
            const place = interview.interview_mode === 'online' ? interview.meeting_link : interview.interview_location;
            const ended = meetingEnded(interview);
            const displayStatus = interview.status;
            const joinButton = interview.status === 'scheduled' && interview.interview_mode === 'online' && interview.meeting_link
                ? `<a href="${escapeAttr(interview.meeting_link)}" target="_blank" rel="noopener noreferrer" data-assignment-id="${interview.assignment_id || ''}" class="join-meet-action inline-flex rounded-lg border border-[#075fe4] bg-[#075fe4] px-3 py-2 text-xs font-bold text-white" title="Open Google Meet">Join Meet</a>`
                : '';
            const editButton = interview.status === 'scheduled' && !isResumeInterview
                ? `<button data-id="${interview.id}" class="edit-interview rounded-lg border border-[#9fc0f5] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button">Edit</button>`
                : '';
            const joinedNote = isResumeInterview && interview.status === 'scheduled'
                ? `<span class="text-xs font-bold text-[#52607a]">${interview.company_joined_at ? 'Company joined' : 'Company pending'} / ${interview.fresher_joined_at ? 'Fresher joined' : 'Fresher pending'}</span>`
                : '';
            const resumeActions = isResumeInterview && interview.status === 'scheduled'
                ? `<div class="company-interview-actions flex flex-wrap gap-2">
                    ${joinButton}
                    <button data-assignment-id="${interview.assignment_id}" class="resume-complete-action rounded-lg border border-[#b9e7c9] px-3 py-2 text-xs font-bold text-[#138a43] disabled:cursor-not-allowed disabled:opacity-50" type="button" ${interview.both_joined ? '' : 'disabled'}>Close Interview</button>
                    ${joinedNote}
                </div>`
                : isResumeInterview && interview.status === 'completed'
                    ? `<div class="company-interview-actions flex flex-wrap gap-2">
                        <button data-assignment-id="${interview.assignment_id}" data-status="hired" class="resume-final-action rounded-lg border border-[#b9e7c9] px-3 py-2 text-xs font-bold text-[#138a43]" type="button">Hired</button>
                        <button data-assignment-id="${interview.assignment_id}" data-status="not_selected" class="resume-final-action rounded-lg border border-[#ffd1d7] px-3 py-2 text-xs font-bold text-[#ff3045]" type="button">Not Selected</button>
                    </div>`
                    : (isResumeInterview ? (joinButton || '-') : '');

            return `
                <tr class="border-b border-[#edf2fb] last:border-b-0">
                    <td class="px-4 py-4 align-middle text-[13px]" data-label="Candidate">
                        <div class="flex items-center gap-3">
                            <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">${escapeHtml(initials(user.name))}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h3>
                                <p class="break-all text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 align-middle text-[13px] text-[#061942]" data-label="Job Role">${escapeHtml(job.title || '-')}</td>
                    <td class="px-4 py-4 align-middle text-[13px]" data-label="Mode"><div class="font-bold text-[#061942]">${escapeHtml(formatStatus(interview.interview_mode))}</div><div class="mt-1 max-w-[220px] break-all text-xs text-[#52607a]">${escapeHtml(place || '-')}</div></td>
                    <td class="px-4 py-4 align-middle text-[13px] text-[#061942]" data-label="Date & Time"><div class="mb-1.5">${formatDate(interview.interview_date)}</div><span>${escapeHtml(interview.interview_time || '-')}</span></td>
                    <td class="px-4 py-4 align-middle text-[13px]" data-label="Status"><span class="inline-flex h-[30px] min-w-[72px] items-center justify-center rounded-lg px-2.5 text-xs font-bold ${statusClasses[interview.status] || (ended ? statusClasses.completed : statusClasses.scheduled)}">${escapeHtml(formatStatus(displayStatus))}</span></td>
                    <td class="px-4 py-4 align-middle text-[13px]" data-label="Action">
                        ${isResumeInterview ? resumeActions : (interview.status === 'scheduled' ? `
                            <div class="company-interview-actions flex flex-wrap gap-2">
                                ${editButton}
                                ${joinButton}
                                <button data-id="${interview.id}" data-status="completed" data-application-status="hired" class="status-action rounded-lg border border-[#b9e7c9] px-3 py-2 text-xs font-bold text-[#138a43]" type="button">Hire</button>
                                <button data-id="${interview.id}" data-status="completed" data-application-status="rejected" class="status-action rounded-lg border border-[#ffd1d7] px-3 py-2 text-xs font-bold text-[#ff3045]" type="button">Reject</button>
                                <button data-id="${interview.id}" data-status="cancelled" class="status-action rounded-lg border border-[#dce7f8] px-3 py-2 text-xs font-bold text-[#52607a]" type="button">Cancel</button>
                            </div>
                        ` : (editButton || joinButton ? `<div class="company-interview-actions flex flex-wrap gap-2">${editButton}${joinButton}</div>` : '-'))}
                    </td>
                </tr>
            `;
        }).join('');

        document.querySelectorAll('.edit-interview').forEach((button) => {
            button.addEventListener('click', () => openEditInterview(button.dataset.id));
        });
        document.querySelectorAll('.status-action').forEach((button) => {
            button.addEventListener('click', () => updateInterviewStatus(button));
        });
        document.querySelectorAll('.resume-complete-action').forEach((button) => {
            button.addEventListener('click', () => completeResumeInterview(button));
        });
        document.querySelectorAll('.resume-final-action').forEach((button) => {
            button.addEventListener('click', () => updateResumeHiringStatus(button));
        });
        document.querySelectorAll('.join-meet-action[data-assignment-id]').forEach((link) => {
            link.addEventListener('click', () => markResumeInterviewJoined(link.dataset.assignmentId));
        });
        resultText.textContent = `Showing ${filtered.length} of ${interviews.length} interviews`;
    }

    async function updateInterview(event) {
        event.preventDefault();
        if (!editingInterviewId) return;

        saveEditInterview.disabled = true;
        saveEditInterview.textContent = 'Saving...';
        clearEditMessage();

        try {
            const payload = {
                interview_date: document.getElementById('editInterviewDate').value,
                interview_time: document.getElementById('editInterviewTime').value,
                interview_mode: editMode.value,
                meeting_link: editMode.value === 'online' ? document.getElementById('editMeetingLink').value.trim() : null,
                interview_location: editMode.value === 'offline' ? document.getElementById('editInterviewLocation').value.trim() : null,
            };

            const response = await fetch(`/api/company/interviews/${editingInterviewId}`, {
                method: 'PATCH',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(payload),
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Unable to update interview.');
            }

            closeEditInterview();
            showMessage(result.message || 'Interview updated.', 'success');
            await loadInterviews();
        } catch (error) {
            showEditMessage(error.message || 'Unable to update interview.');
        } finally {
            saveEditInterview.disabled = false;
            saveEditInterview.textContent = 'Save Changes';
        }
    }

    async function updateInterviewStatus(button) {
        button.disabled = true;
        try {
            const payload = { status: button.dataset.status };
            if (button.dataset.applicationStatus) {
                payload.application_status = button.dataset.applicationStatus;
            }
            const response = await fetch(`/api/company/interviews/${button.dataset.id}/status`, {
                method: 'PATCH',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(payload),
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Unable to update interview.');
            }
            showMessage(result.message || 'Interview updated.', 'success');
            await loadInterviews();
        } catch (error) {
            showMessage(error.message || 'Unable to update interview.');
        } finally {
            button.disabled = false;
        }
    }

    async function completeResumeInterview(button) {
        button.disabled = true;
        try {
            const response = await fetch(`/api/company/resumes/${button.dataset.assignmentId}/interview/complete`, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: '{}',
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Unable to close interview.');
            }
            showMessage(result.message || 'Interview closed.', 'success');
            await loadInterviews();
        } catch (error) {
            showMessage(error.message || 'Unable to close interview.');
        } finally {
            button.disabled = false;
        }
    }

    async function markResumeInterviewJoined(assignmentId) {
        if (!assignmentId) return;

        try {
            await fetch(`/api/company/resumes/${assignmentId}/interview/join`, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: '{}',
            });
            window.setTimeout(loadInterviews, 500);
        } catch (error) {
        }
    }

    async function updateResumeHiringStatus(button) {
        button.disabled = true;
        try {
            const response = await fetch(`/api/company/resumes/${button.dataset.assignmentId}/hiring-status`, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({ status: button.dataset.status }),
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Unable to update candidate status.');
            }
            showMessage(result.message || 'Candidate status updated.', 'success');
            await loadInterviews();
        } catch (error) {
            showMessage(error.message || 'Unable to update candidate status.');
        } finally {
            button.disabled = false;
        }
    }

    async function loadInterviews() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;
        const response = await fetch('/api/company/interviews', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load interviews.');
        }
        interviews = result.data.interviews || [];
        populateJobs();
        updateCounts();
        renderInterviews();
    }

    document.querySelectorAll('.interview-tab').forEach((tab) => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.interview-tab').forEach((item) => {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#24344f]');
            });
            tab.classList.remove('border-transparent', 'text-[#24344f]');
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            activeStatus = tab.dataset.status;
            renderInterviews();
        });
    });

    searchInput.addEventListener('input', renderInterviews);
    jobFilter.addEventListener('change', renderInterviews);
    editMode.addEventListener('change', toggleEditModeFields);
    editForm.addEventListener('submit', updateInterview);
    document.getElementById('closeEditInterview').addEventListener('click', closeEditInterview);
    document.getElementById('cancelEditInterview').addEventListener('click', closeEditInterview);
    editModal.addEventListener('click', (event) => {
        if (event.target === editModal) closeEditInterview();
    });
    document.getElementById('resetFilters').addEventListener('click', () => {
        searchInput.value = '';
        jobFilter.value = 'all';
        renderInterviews();
    });

    loadInterviews().catch((error) => {
        body.innerHTML = `<tr><td colspan="6" class="px-5 py-8 text-center text-sm text-[#ff3045]">${escapeHtml(error.message || 'Unable to load interviews.')}</td></tr>`;
        resultText.textContent = 'Unable to load interviews.';
    });
</script>
@endpush
