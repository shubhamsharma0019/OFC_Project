@extends('layouts.company')

@section('title', 'Applications - OnlyFreshers')
@section('pageTitle', 'Applications')
@section('pageSubtitle', 'Review all applications received for your posted jobs.')

@php $activePage = 'applications'; @endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div class="mb-[26px] grid grid-cols-1 gap-[18px] lg:grid-cols-[170px_170px_minmax(0,1fr)_120px]">
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

            <input id="searchInput" type="search" placeholder="Search by name, email, job or skills..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <button id="resetFilters" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#24344f] transition hover:bg-[#f5f9ff]">
                Reset
            </button>
        </div>

        <div class="overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[900px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Profile</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Status</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Applied Date</th>
                        <th class="h-[58px] px-5 text-left text-[13px] font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody id="applicationBody">
                    <tr><td colspan="6" class="px-5 py-8 text-center text-sm font-bold text-[#52607a]">Loading applications...</td></tr>
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
    const searchInput = document.getElementById('searchInput');
    const applicationBody = document.getElementById('applicationBody');
    const resultText = document.getElementById('resultText');
    let applications = [];

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

    function populateJobs() {
        const jobs = [...new Map(applications.map((app) => [app.job?.id, app.job]).filter(([id]) => id)).values()];
        jobFilter.innerHTML = '<option value="all">All Jobs</option>' + jobs.map((job) => `<option value="${job.id}">${escapeHtml(job.title)}</option>`).join('');
    }

    function renderApplications() {
        const selectedJob = jobFilter.value;
        const selectedStatus = statusFilter.value;
        const search = searchInput.value.trim().toLowerCase();

        const filtered = applications.filter((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const haystack = [user.name, user.email, profile.skills, profile.qualification, profile.city, job.title].join(' ').toLowerCase();

            return (selectedJob === 'all' || String(job.id) === selectedJob)
                && (selectedStatus === 'all' || app.application_status === selectedStatus)
                && haystack.includes(search);
        });

        if (!filtered.length) {
            applicationBody.innerHTML = '<tr><td colspan="6" class="px-5 py-8 text-center text-sm text-[#52607a]">No applications found.</td></tr>';
            resultText.textContent = `Showing 0 of ${applications.length} applications`;
            return;
        }

        applicationBody.innerHTML = filtered.map((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const status = app.application_status || 'applied';

            return `
                <tr class="border-b border-[#edf2fb] last:border-b-0">
                    <td class="px-5 py-[18px] align-middle text-[13px]">
                        <div class="flex items-center gap-3.5">
                            <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">${escapeHtml(initials(user.name))}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h3>
                                <p class="break-all text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px]">
                        <div>
                            <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(job.title || '-')}</h3>
                            <p class="text-xs text-[#52607a]">${escapeHtml(formatStatus(job.hiring_mode))}</p>
                        </div>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px] text-[#24344f]">
                        <div class="break-words">${escapeHtml(profile.qualification || '-')}</div>
                        <div class="mt-1 text-xs text-[#52607a]">${escapeHtml(profile.city || '')}</div>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px]">
                        <span class="inline-flex h-[30px] min-w-[68px] items-center justify-center rounded-lg px-3 text-xs font-bold ${statusClasses[status] || statusClasses.applied}">${escapeHtml(formatStatus(status))}</span>
                    </td>
                    <td class="px-5 py-[18px] align-middle text-[13px] text-[#24344f]">${formatDate(app.applied_at || app.created_at)}</td>
                    <td class="px-5 py-[18px] align-middle text-[13px]">
                        <a href="/company/applications/show" data-application-id="${app.id}" class="application-link text-[22px] leading-none text-[#061942]" aria-label="View application details">&#8942;</a>
                    </td>
                </tr>
            `;
        }).join('');

        document.querySelectorAll('.application-link').forEach((link) => {
            link.addEventListener('click', () => {
                localStorage.setItem('ofc_selected_company_application_id', link.dataset.applicationId);
            });
        });

        resultText.textContent = `Showing ${filtered.length} of ${applications.length} applications`;
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
    document.getElementById('resetFilters').addEventListener('click', () => {
        jobFilter.value = 'all';
        statusFilter.value = 'all';
        searchInput.value = '';
        renderApplications();
    });

    loadApplications().catch((error) => {
        applicationBody.innerHTML = `<tr><td colspan="6" class="px-5 py-8 text-center text-sm text-[#ff3045]">${escapeHtml(error.message || 'Unable to load applications.')}</td></tr>`;
        resultText.textContent = 'Unable to load applications.';
    });
</script>
@endpush
