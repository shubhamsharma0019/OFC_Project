@extends('layouts.company')

@section('title', 'Interviews - OnlyFreshers')
@section('pageTitle', 'Interviews')
@section('pageSubtitle', 'Schedule and manage interviews with candidates.')

@php $activePage = 'interviews'; @endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
        <div class="mb-[22px] flex flex-col gap-[18px] border-b border-[#dce7f8] pb-3.5 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-wrap gap-x-6 gap-y-2 xl:gap-x-[34px]" role="tablist" aria-label="Interview status tabs">
                <button class="interview-tab border-b-[3px] border-[#075fe4] px-3.5 py-2.5 text-[13px] font-semibold text-[#075fe4]" data-status="all" type="button">All Interviews (<span id="allCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="scheduled" type="button">Scheduled (<span id="scheduledCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="completed" type="button">Completed (<span id="completedCount">0</span>)</button>
                <button class="interview-tab border-b-[3px] border-transparent px-3.5 py-2.5 text-[13px] font-semibold text-[#24344f]" data-status="cancelled" type="button">Cancelled (<span id="cancelledCount">0</span>)</button>
            </div>

            <a href="/company/applications" class="inline-flex h-[42px] w-[180px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">Applications</a>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1fr)_190px_120px]">
            <input id="searchInput" type="search" placeholder="Search by candidate name or job role..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Jobs</option>
            </select>
            <button id="resetFilters" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">Reset</button>
        </div>

        <p id="interviewMessage" class="mb-4 hidden rounded-lg border px-4 py-3 text-sm font-bold"></p>

        <div class="overflow-x-auto rounded-lg border border-[#dce7f8]">
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
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const body = document.getElementById('interviewBody');
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const resultText = document.getElementById('resultText');
    const message = document.getElementById('interviewMessage');
    let interviews = [];
    let activeStatus = 'all';

    const statusClasses = {
        scheduled: 'bg-[#fff0d1] text-[#c86b00]',
        completed: 'bg-[#dbf8e9] text-[#00a65a]',
        cancelled: 'bg-[#ffe8eb] text-[#ff3045]',
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

    function showMessage(text, type = 'error') {
        message.textContent = text;
        message.className = `mb-4 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
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
        for (const status of ['scheduled', 'completed', 'cancelled']) {
            document.getElementById(`${status}Count`).textContent = interviews.filter((interview) => interview.status === status).length;
        }
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
            return (activeStatus === 'all' || interview.status === activeStatus)
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
            const place = interview.interview_mode === 'online' ? interview.meeting_link : interview.interview_location;
            const joinButton = interview.interview_mode === 'online' && interview.meeting_link
                ? `<a href="${escapeAttr(interview.meeting_link)}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-lg border border-[#075fe4] bg-[#075fe4] px-3 py-2 text-xs font-bold text-white" title="Open Google Meet">Join Meet</a>`
                : '';

            return `
                <tr class="border-b border-[#edf2fb] last:border-b-0">
                    <td class="px-4 py-4 align-middle text-[13px]">
                        <div class="flex items-center gap-3">
                            <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">${escapeHtml(initials(user.name))}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h3>
                                <p class="break-all text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 align-middle text-[13px] text-[#061942]">${escapeHtml(job.title || '-')}</td>
                    <td class="px-4 py-4 align-middle text-[13px]"><div class="font-bold text-[#061942]">${escapeHtml(formatStatus(interview.interview_mode))}</div><div class="mt-1 max-w-[220px] break-all text-xs text-[#52607a]">${escapeHtml(place || '-')}</div></td>
                    <td class="px-4 py-4 align-middle text-[13px] text-[#061942]"><div class="mb-1.5">${formatDate(interview.interview_date)}</div><span>${escapeHtml(interview.interview_time || '-')}</span></td>
                    <td class="px-4 py-4 align-middle text-[13px]"><span class="inline-flex h-[30px] min-w-[72px] items-center justify-center rounded-lg px-2.5 text-xs font-bold ${statusClasses[interview.status] || statusClasses.scheduled}">${escapeHtml(formatStatus(interview.status))}</span></td>
                    <td class="px-4 py-4 align-middle text-[13px]">
                        ${interview.status === 'scheduled' ? `
                            <div class="flex flex-wrap gap-2">
                                ${joinButton}
                                <button data-id="${interview.id}" data-status="completed" data-application-status="hired" class="status-action rounded-lg border border-[#b9e7c9] px-3 py-2 text-xs font-bold text-[#138a43]" type="button">Hire</button>
                                <button data-id="${interview.id}" data-status="completed" data-application-status="rejected" class="status-action rounded-lg border border-[#ffd1d7] px-3 py-2 text-xs font-bold text-[#ff3045]" type="button">Reject</button>
                                <button data-id="${interview.id}" data-status="cancelled" class="status-action rounded-lg border border-[#dce7f8] px-3 py-2 text-xs font-bold text-[#52607a]" type="button">Cancel</button>
                            </div>
                        ` : (joinButton || '-')}
                    </td>
                </tr>
            `;
        }).join('');

        document.querySelectorAll('.status-action').forEach((button) => {
            button.addEventListener('click', () => updateInterviewStatus(button));
        });
        resultText.textContent = `Showing ${filtered.length} of ${interviews.length} interviews`;
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
