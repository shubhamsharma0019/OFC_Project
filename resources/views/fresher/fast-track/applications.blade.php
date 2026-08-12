@extends('layouts.fast-track')

@section('title', 'Applications')

@php
    $activePage = 'applications';
@endphp

@section('content')
    <section class="space-y-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Applications</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">Track Fast Track job applications and interview status.</p>
            </div>
            <a class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white" href="/fast-track/job-recommendations">Browse Jobs</a>
        </div>

        <div id="applicationStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-semibold text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2 xl:col-span-4">Loading applications...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="flex flex-col gap-3 border-b border-[#e6eef8] p-4 lg:flex-row lg:items-center lg:justify-between">
                <input id="applicationSearch" class="h-10 w-full rounded-md border border-[#cfe0ff] bg-white px-4 text-sm text-[#334b83] outline-none placeholder:text-[#6f7ea0] lg:max-w-sm" type="search" placeholder="Search job, company or location...">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <select id="applicationModeFilter" class="h-10 rounded-md border border-[#cfe0ff] bg-white px-3 text-sm text-[#334b83]">
                        <option value="">All Modes</option>
                    </select>
                    <select id="applicationStatusFilter" class="h-10 rounded-md border border-[#cfe0ff] bg-white px-3 text-sm text-[#334b83]">
                        <option value="">All Status</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] border-collapse text-sm">
                    <thead>
                        <tr class="text-left text-[#334b83]">
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Job</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Company</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Applied On</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Status</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Mode</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody id="fastTrackApplicationsBody">
                        <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-[#334b83]">Loading applications...</td></tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const applicationsBody = document.getElementById('fastTrackApplicationsBody');
    const applicationStats = document.getElementById('applicationStats');
    const applicationSearch = document.getElementById('applicationSearch');
    const applicationModeFilter = document.getElementById('applicationModeFilter');
    const applicationStatusFilter = document.getElementById('applicationStatusFilter');
    let applicationRows = [];

    function companyName(application) {
        const job = application.job || {};
        const company = job.company_profile || job.company || {};
        return company.company_name || company.name || application.company_name || 'Company';
    }

    function applicationStatus(application) {
        return application.application_status || application.status || 'applied';
    }

    function applicationMode(application) {
        return application.job?.hiring_mode || application.job?.mode || 'fast_track';
    }

    function rowText(application) {
        const job = application.job || {};
        return [job.title, job.location, job.job_type, companyName(application), applicationStatus(application), applicationMode(application)].join(' ').toLowerCase();
    }

    function unique(values) {
        return [...new Set(values.filter(Boolean).map((value) => String(value)))].sort();
    }

    function setOptions(select, values, label) {
        const selected = select.value;
        select.innerHTML = `<option value="">${FastTrack.esc(label)}</option>` + values.map((value) => `<option value="${FastTrack.esc(value)}">${FastTrack.esc(FastTrack.statusText(value))}</option>`).join('');
        if (values.includes(selected)) select.value = selected;
    }

    function statusBadgeClass(status) {
        const value = String(status || '').toLowerCase();
        if (value.includes('shortlist') || value.includes('selected') || value.includes('hired')) return 'bg-[#e2f9ea] text-[#05843e]';
        if (value.includes('reject')) return 'bg-[#fff4f4] text-[#b42318]';
        if (value.includes('interview') || value.includes('review')) return 'bg-[#fff0de] text-[#d06d00]';
        return 'bg-[#eaf2ff] text-[#075fe4]';
    }

    function statCard(icon, label, value, hint) {
        return `<article class="grid grid-cols-[58px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <span class="grid h-[52px] w-[52px] place-items-center rounded-xl bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">${FastTrack.esc(icon)}</span>
            <div class="min-w-0">
                <h2 class="mb-1 text-2xl font-bold text-[#061942]">${FastTrack.esc(value)}</h2>
                <p class="mb-1 text-sm font-medium text-[#334b83]">${FastTrack.esc(label)}</p>
                <small class="text-xs text-[#334b83]">${FastTrack.esc(hint)}</small>
            </div>
        </article>`;
    }

    function renderStats() {
        const statuses = applicationRows.map(applicationStatus);
        applicationStats.innerHTML = [
            statCard('TA', 'Total Applications', applicationRows.length, 'All submitted jobs'),
            statCard('AP', 'Applied', statuses.filter((status) => status === 'applied').length, 'Waiting for review'),
            statCard('IN', 'Interviews', statuses.filter((status) => String(status).includes('interview')).length, 'Interview stage'),
            statCard('SH', 'Shortlisted', statuses.filter((status) => String(status).includes('shortlist')).length, 'Company shortlisted'),
        ].join('');
    }

    function filteredApplications() {
        const query = applicationSearch.value.trim().toLowerCase();
        const mode = applicationModeFilter.value;
        const status = applicationStatusFilter.value;
        return applicationRows.filter((application) => {
            return (!query || rowText(application).includes(query))
                && (!mode || applicationMode(application) === mode)
                && (!status || applicationStatus(application) === status);
        });
    }

    function renderApplications() {
        if (!applicationsBody) return;
        const rows = filteredApplications();

        if (!rows.length) {
            applicationsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-sm text-[#334b83]">No applications found. Apply to a Fast Track job to see it here.</td></tr>';
            return;
        }

        applicationsBody.innerHTML = rows.map(function (application) {
            const job = application.job || {};
            const status = applicationStatus(application);
            const mode = applicationMode(application);
            const jobId = job.id || application.job_id || '';
            return `<tr>
                <td class="border-b border-[#e6eef8] px-4 py-4">
                    <strong class="font-bold text-[#061942]">${FastTrack.esc(job.title || application.job_title || 'Fast Track Job')}</strong>
                    <br><span class="text-xs text-[#536484]">${FastTrack.esc(job.location || '-')} ${job.salary ? ' - ' + FastTrack.esc(job.salary) : ''}</span>
                </td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">${FastTrack.esc(companyName(application))}</td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">${FastTrack.date(application.applied_at || application.created_at)}</td>
                <td class="border-b border-[#e6eef8] px-4 py-4"><span class="inline-flex rounded-md ${statusBadgeClass(status)} px-3 py-1.5 text-xs font-bold">${FastTrack.esc(FastTrack.statusText(status))}</span></td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">${FastTrack.esc(FastTrack.statusText(mode))}</td>
                <td class="border-b border-[#e6eef8] px-4 py-4">${jobId ? `<a class="inline-flex h-9 items-center justify-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]" href="/jobs/show?job=${FastTrack.esc(jobId)}">View Job</a>` : '-'}</td>
            </tr>`;
        }).join('');
    }

    function loadApplications() {
        FastTrack.getJson('/api/fresher/applications')
            .then(function (result) {
                applicationRows = FastTrack.apiData(result, 'applications') || [];
                setOptions(applicationModeFilter, unique(applicationRows.map(applicationMode)), 'All Modes');
                setOptions(applicationStatusFilter, unique(applicationRows.map(applicationStatus)), 'All Status');
                renderStats();
                renderApplications();
            })
            .catch(function (error) {
                applicationStats.innerHTML = '';
                applicationsBody.innerHTML = `<tr><td colspan="6" class="px-4 py-8 text-center text-sm text-[#8a5200]">${FastTrack.esc(error.message || 'Applications data nahi aa pa raha. Please login and retry.')}</td></tr>`;
            });
    }

    [applicationSearch, applicationModeFilter, applicationStatusFilter].forEach((input) => {
        input.addEventListener('input', renderApplications);
        input.addEventListener('change', renderApplications);
    });

    loadApplications();
</script>
@endpush
