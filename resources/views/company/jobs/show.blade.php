@extends('layouts.company')
@section('title', 'Job Details - OnlyFreshers')
@section('pageTitle', 'Job Details')
@section('pageSubtitle', 'View job posting details and activity.')
@php $activePage = 'jobs'; @endphp

@section('content')
<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
    <div class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
        <div id="jobLoading" class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]">Loading job details...</div>

        <div id="jobContent" class="hidden">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0">
                    <h2 id="jobTitle" class="break-words text-xl font-bold text-[#061942]">Job</h2>
                    <p id="jobMeta" class="mt-2 break-words text-sm text-[#24344f]">-</p>
                </div>
                <span id="jobStatus" class="inline-flex h-8 items-center rounded-lg px-3 text-xs font-bold">-</span>
            </div>

            <div class="mb-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-[#f4f8ff] p-4"><b id="applicationCount" class="block text-lg text-[#061942]">0</b><span class="text-xs text-[#52607a]">Applications</span></div>
                <div class="rounded-lg bg-[#f4f8ff] p-4"><b id="openingCount" class="block text-lg text-[#061942]">0</b><span class="text-xs text-[#52607a]">Openings</span></div>
                <div class="rounded-lg bg-[#f4f8ff] p-4"><b id="lastDate" class="block text-lg text-[#061942]">-</b><span class="text-xs text-[#52607a]">Last Date</span></div>
            </div>

            <h3 class="mb-3 text-base font-bold text-[#061942]">Job Description</h3>
            <p id="jobDescription" class="break-words text-sm leading-relaxed text-[#24344f]">-</p>

            <h3 class="mb-3 mt-6 text-base font-bold text-[#061942]">Required Skills</h3>
            <div id="jobSkills" class="flex flex-wrap gap-2"></div>

            <h3 class="mb-3 mt-6 text-base font-bold text-[#061942]">Salary / Qualification</h3>
            <p id="jobExtra" class="break-words text-sm leading-relaxed text-[#24344f]">-</p>
        </div>
    </div>

    <aside class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <h3 class="mb-4 text-base font-bold text-[#061942]">Actions</h3>
        <div class="grid gap-3">
            <a id="editJobLink" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white" href="/company/jobs/edit">Edit Job</a>
            <a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#9fc0f5] text-sm font-bold text-[#075fe4]" href="/company/jobs/preview">Preview</a>
            <a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#dce7f8] text-sm font-bold text-[#24344f]" href="/company/applications">View Applications</a>
            <a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#dce7f8] text-sm font-bold text-[#24344f]" href="/company/jobs">Back to Jobs</a>
        </div>
    </aside>
</section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const jobId = localStorage.getItem('ofc_selected_company_job_id');
    const loading = document.getElementById('jobLoading');
    const content = document.getElementById('jobContent');

    const statusClasses = {
        active: 'bg-[#dbf8e9] text-[#00a65a]',
        draft: 'bg-[#eaf2ff] text-[#075fe4]',
        inactive: 'bg-[#edf2fb] text-[#52607a]',
        removed: 'bg-[#ffe8eb] text-[#ff3045]',
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

    function setText(id, value) {
        document.getElementById(id).textContent = value || '-';
    }

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

    async function loadJobDetails() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;

        if (!jobId) {
            window.location.href = '/company/jobs';
            return;
        }

        const response = await fetch(`/api/company/jobs/${jobId}`, {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load job details.');
        }

        const job = result.data.job;
        const skills = job.required_skills ? String(job.required_skills).split(',').map((skill) => skill.trim()).filter(Boolean) : [];

        setText('jobTitle', job.title);
        setText('jobMeta', [job.location, job.job_type, formatStatus(job.hiring_mode)].filter(Boolean).join(' • '));
        setText('applicationCount', Number(job.applications_count || 0));
        setText('openingCount', Number(job.openings || 0));
        setText('lastDate', formatDate(job.application_last_date));
        setText('jobDescription', job.description);
        setText('jobExtra', [job.salary ? `Salary: ${job.salary}` : '', job.qualification ? `Qualification: ${job.qualification}` : ''].filter(Boolean).join(' • '));

        const status = document.getElementById('jobStatus');
        status.textContent = formatStatus(job.status);
        status.className = `inline-flex h-8 items-center rounded-lg px-3 text-xs font-bold ${statusClasses[job.status] || statusClasses.inactive}`;

        document.getElementById('jobSkills').innerHTML = skills.length
            ? skills.map((skill) => `<span class="rounded-lg bg-[#eaf2ff] px-3 py-2 text-xs font-bold text-[#075fe4]">${escapeHtml(skill)}</span>`).join('')
            : '<span class="text-sm text-[#52607a]">No skills added.</span>';

        document.getElementById('editJobLink').addEventListener('click', () => {
            localStorage.setItem('ofc_selected_company_job_id', job.id);
        });

        loading.classList.add('hidden');
        content.classList.remove('hidden');
    }

    loadJobDetails().catch((error) => {
        loading.textContent = error.message || 'Unable to load job details.';
        loading.className = 'rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm font-bold text-[#ff3045]';
    });
</script>
@endpush
