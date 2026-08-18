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
    const applicationIcons = {
        total: '<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 5V3h8v2"></path><path d="M8 11h8M8 15h5"></path></svg>',
        applied: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect></svg>',
        interview: '<svg viewBox="0 0 24 24"><rect x="3" y="6" width="14" height="12" rx="2"></rect><path d="m17 10 4-2v8l-4-2"></path></svg>',
        shortlisted: '<svg viewBox="0 0 24 24"><path d="M12 3 4 7v6c0 5 3.5 7.5 8 8 4.5-.5 8-3 8-8V7l-8-4Z"></path><path d="m9 12 2 2 4-5"></path></svg>',
    };

    function applicationIcon(name) {
        return `<span class="grid h-[52px] w-[52px] shrink-0 place-items-center rounded-xl bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${applicationIcons[name] || applicationIcons.total}</span>`;
    }

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

    function interviewPlace(interview) {
        if (!interview?.id) return '';
        return interview.interview_mode === 'online'
            ? interview.meeting_link
            : interview.interview_location;
    }

    function interviewDetails(application) {
        const interview = application.interview || {};
        if (!interview.id) return '';

        const place = interviewPlace(interview);
        return `<div class="mt-2 grid gap-1 text-xs text-[#536484]">
            <span><strong class="text-[#334b83]">Interview:</strong> ${FastTrack.esc(FastTrack.date(interview.interview_date))} ${FastTrack.esc(interview.interview_time || '')}</span>
            <span><strong class="text-[#334b83]">Mode:</strong> ${FastTrack.esc(FastTrack.statusText(interview.interview_mode || '-'))}</span>
            ${place ? `<span class="max-w-[280px] break-all"><strong class="text-[#334b83]">${interview.interview_mode === 'online' ? 'Meet' : 'Location'}:</strong> ${FastTrack.esc(place)}</span>` : ''}
        </div>`;
    }

    function applicationActions(application, jobId) {
        const interview = application.interview || {};
        const status = applicationStatus(application);
        const buttons = [];

        if (status === 'interview_scheduled' && interview.status === 'scheduled' && interview.interview_mode === 'online' && interview.meeting_link) {
            buttons.push(`<a class="inline-flex h-9 items-center justify-center rounded-md bg-[#075fe4] px-4 text-xs font-bold text-white" href="${FastTrack.esc(interview.meeting_link)}" target="_blank" rel="noopener noreferrer">Join Meet</a>`);
        }

        if (jobId) {
            buttons.push(`<a class="inline-flex h-9 items-center justify-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]" href="/jobs/show?job=${FastTrack.esc(jobId)}">View Job</a>`);
        }

        return buttons.length ? `<div class="flex flex-wrap gap-2">${buttons.join('')}</div>` : '-';
    }

    function statCard(icon, label, value, hint) {
        return `<article class="grid grid-cols-[58px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            ${applicationIcon(icon)}
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
            statCard('total', 'Total Applications', applicationRows.length, 'All submitted jobs'),
            statCard('applied', 'Applied', statuses.filter((status) => status === 'applied').length, 'Waiting for review'),
            statCard('interview', 'Interviews', statuses.filter((status) => String(status).includes('interview')).length, 'Interview stage'),
            statCard('shortlisted', 'Shortlisted', statuses.filter((status) => String(status).includes('shortlist')).length, 'Company shortlisted'),
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
                <td class="border-b border-[#e6eef8] px-4 py-4">
                    <span class="inline-flex rounded-md ${statusBadgeClass(status)} px-3 py-1.5 text-xs font-bold">${FastTrack.esc(FastTrack.statusText(status))}</span>
                    ${interviewDetails(application)}
                </td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">${FastTrack.esc(FastTrack.statusText(mode))}</td>
                <td class="border-b border-[#e6eef8] px-4 py-4">${applicationActions(application, jobId)}</td>
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
