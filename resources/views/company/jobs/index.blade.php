@extends('layouts.company')

@section('title', 'Jobs and Internships - OnlyFreshers')
@section('pageTitle', 'Jobs and Internships')
@section('pageSubtitle', 'Manage and view all your posted jobs and internships.')

@php $activePage = 'jobs'; @endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
        <div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-x-6 gap-y-2 sm:gap-x-9" role="tablist" aria-label="Job status tabs">
                <button class="job-tab border-b-[3px] border-[#075fe4] px-4 py-3 text-sm font-semibold text-[#075fe4]" data-status="active" type="button">
                    Active (<span id="activeCount">0</span>)
                </button>
                <button class="job-tab border-b-[3px] border-transparent px-4 py-3 text-sm font-semibold text-[#24344f]" data-status="draft" type="button">
                    Draft (<span id="draftCount">0</span>)
                </button>
                <button class="job-tab border-b-[3px] border-transparent px-4 py-3 text-sm font-semibold text-[#24344f]" data-status="inactive" type="button">
                    Inactive (<span id="inactiveCount">0</span>)
                </button>
                <button class="job-tab border-b-[3px] border-transparent px-4 py-3 text-sm font-semibold text-[#24344f]" data-status="removed" type="button">
                    Removed (<span id="removedCount">0</span>)
                </button>
            </div>

            <a href="/company/post-job" class="inline-flex h-[42px] w-[148px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                + Post New Job
            </a>
        </div>

        <div id="jobList" class="overflow-hidden rounded-lg border border-[#dce7f8]">
            <div class="p-8 text-center text-sm font-bold text-[#52607a]">Loading jobs...</div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const jobList = document.getElementById('jobList');
    let allJobs = [];
    let activeStatus = 'active';

    const statusClasses = {
        active: 'bg-[#dbf8e9] text-[#00a65a]',
        draft: 'bg-[#eaf2ff] text-[#075fe4]',
        inactive: 'bg-[#edf2fb] text-[#52607a]',
        removed: 'bg-[#ffe8eb] text-[#ff3045]',
    };

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

    function formatStatus(status) {
        return String(status || '').replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
    }

    function formatDate(value) {
        return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    }

    function updateCounts() {
        for (const status of ['active', 'draft', 'inactive', 'removed']) {
            const element = document.getElementById(`${status}Count`);
            if (element) {
                element.textContent = allJobs.filter((job) => job.status === status).length;
            }
        }
    }

    function renderJobs(status) {
        activeStatus = status;
        jobList.innerHTML = '';

        const filteredJobs = allJobs.filter((job) => job.status === status);

        if (!filteredJobs.length) {
            jobList.innerHTML = '<div class="p-8 text-center text-sm text-[#52607a]">No jobs found.</div>';
            return;
        }

        for (const job of filteredJobs) {
            const row = document.createElement('div');
            const skills = job.required_skills ? String(job.required_skills).split(',').map((skill) => skill.trim()).filter(Boolean).slice(0, 3) : [];

            row.className = 'grid grid-cols-1 gap-4 border-b border-[#dce7f8] px-[18px] py-5 last:border-b-0 sm:grid-cols-[minmax(0,1fr)_auto_36px] sm:items-center sm:gap-[22px]';
            row.innerHTML = `
                <div class="min-w-0">
                    <h3 class="mb-2.5 break-words text-base font-bold text-[#061942]">${escapeHtml(job.title)}</h3>
                    <div class="mb-2 flex flex-wrap gap-2.5 text-[13px] text-[#24344f]">
                        <span>${escapeHtml(job.job_type || 'Job')}</span>
                        <span>&bull;</span>
                        <span>${escapeHtml(job.location || 'Location not added')}</span>
                        <span>&bull;</span>
                        <span>${escapeHtml(formatStatus(job.hiring_mode))}</span>
                    </div>
                    <div class="mb-2 flex flex-wrap gap-2">${skills.map((skill) => `<span class="rounded-lg bg-[#eaf2ff] px-2.5 py-1 text-xs font-bold text-[#075fe4]">${escapeHtml(skill)}</span>`).join('')}</div>
                    <div class="text-[13px] text-[#061942]">${Number(job.applications_count || 0)} Applications</div>
                </div>
                <div class="sm:text-right">
                    <div class="mb-3 inline-flex h-[34px] min-w-16 items-center justify-center rounded-[10px] px-3 text-xs font-bold ${statusClasses[job.status] || statusClasses.inactive}">${escapeHtml(formatStatus(job.status))}</div>
                    <div class="text-[13px] text-[#24344f]">Posted on ${formatDate(job.created_at)}</div>
                    <div class="mt-1 text-[13px] text-[#52607a]">${job.application_last_date ? `Last date ${formatDate(job.application_last_date)}` : ''}</div>
                </div>
                <a href="/company/jobs/show" data-job-id="${job.id}" class="job-view-link text-2xl leading-none text-[#061942] sm:justify-self-center" aria-label="View job details">&#8942;</a>
            `;
            jobList.appendChild(row);
        }

        document.querySelectorAll('.job-view-link').forEach((link) => {
            link.addEventListener('click', () => {
                localStorage.setItem('ofc_selected_company_job_id', link.dataset.jobId);
            });
        });
    }

    function setActiveTab(selectedTab) {
        document.querySelectorAll('.job-tab').forEach(function (item) {
            item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
            item.classList.add('border-transparent', 'text-[#24344f]');
        });

        selectedTab.classList.remove('border-transparent', 'text-[#24344f]');
        selectedTab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
    }

    async function guardCompanyFlow() {
        if (!token) {
            window.location.href = '/company/login';
            return false;
        }

        const response = await fetch('/api/company/profile', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
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

    async function loadJobs() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;

        const response = await fetch('/api/company/jobs', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load jobs.');
        }

        allJobs = result.data.jobs || [];
        updateCounts();
        renderJobs(activeStatus);
    }

    document.querySelectorAll('.job-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            setActiveTab(tab);
            renderJobs(tab.dataset.status);
        });
    });

    loadJobs().catch((error) => {
        jobList.innerHTML = `<div class="p-8 text-center text-sm text-[#ff3045]">${escapeHtml(error.message || 'Unable to load jobs.')}</div>`;
    });
</script>
@endpush
