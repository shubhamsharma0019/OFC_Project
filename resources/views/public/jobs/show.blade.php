@extends('layouts.public')

@section('title', 'Job Details - OnlyFreshers')

@php
    $activePage = 'jobs';
@endphp

@section('content')
    <main class="bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-10 lg:py-[55px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <a href="/job" class="mb-6 inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Back to Jobs</a>
            <div id="publicJobDetail" class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-medium text-[#52607a] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">Loading job details...</div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    const publicJobDetail = document.getElementById('publicJobDetail');
    const jobId = new URLSearchParams(window.location.search).get('job') || new URLSearchParams(window.location.search).get('id');

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"']/g, (character) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[character]);
    }

    function initials(text) {
        return String(text || 'CO').split(/\s+/).map((word) => word[0]).join('').slice(0, 2).toUpperCase();
    }

    function splitSkills(value) {
        return String(value || '').split(',').map((item) => item.trim()).filter(Boolean);
    }

    function humanDate(dateValue) {
        if (!dateValue) return 'Recently posted';
        const days = Math.floor(Math.max(1, (Date.now() - new Date(dateValue).getTime()) / 1000) / 86400);
        if (days === 0) return 'Posted today';
        if (days === 1) return 'Posted 1 day ago';
        if (days < 30) return 'Posted ' + days + ' days ago';
        return new Date(dateValue).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function normalizeMode(value) {
        return String(value || '').toLowerCase().replace(/\s+/g, '_');
    }

    function labelMode(value) {
        return normalizeMode(value) === 'fast_track' ? 'Fast Track' : 'Direct';
    }

    function applyLink(job) {
        return normalizeMode(job.hiring_mode) === 'fast_track' ? '/fast-track/login' : '/direct-mode/login';
    }

    function openingsLeft(job) {
        const total = Number(job.openings || 0);
        const hired = Number(job.hired_applications_count || 0);
        return total ? Math.max(0, total - hired) : 'Open';
    }

    function overviewRow(label, value) {
        return '<div class="flex items-center justify-between gap-4 border-b border-[#dce7f8] py-3.5 text-sm font-medium text-[#24344f] last:border-b-0"><span>' + escapeHtml(label) + '</span><strong class="text-right font-bold text-[#061942]">' + escapeHtml(value || '-') + '</strong></div>';
    }

    function renderJob(job) {
        const company = job.company_profile || {};
        const skills = splitSkills(job.required_skills);
        const descriptionItems = String(job.description || '').split(/\r?\n/).map((line) => line.trim()).filter(Boolean);
        publicJobDetail.className = '';
        publicJobDetail.innerHTML = `
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

                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Job Description</h2>
                        ${descriptionItems.length ? '<ul class="list-disc space-y-1 pl-5 text-[15px] font-medium leading-[1.8] text-[#24344f] marker:text-[#075fe4]">' + descriptionItems.map((item) => '<li>' + escapeHtml(item) + '</li>').join('') + '</ul>' : '<p class="text-[15px] font-medium leading-[1.8] text-[#24344f]">No description added.</p>'}
                    </article>

                    <article class="mt-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Requirements</h2>
                        <p class="text-[15px] font-medium leading-[1.8] text-[#24344f]">${escapeHtml(job.qualification || 'No qualification added.')}</p>
                    </article>

                    <article class="mt-5 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-3 text-[19px] font-semibold text-[#061942]">Key Skills</h2>
                        <div class="flex flex-wrap gap-2.5">
                            ${skills.length ? skills.map((skill) => '<span class="rounded-lg border border-[#a9c5f6] bg-white px-[18px] py-2 text-sm font-bold text-[#075fe4]">' + escapeHtml(skill) + '</span>').join('') : '<span class="text-sm font-medium text-[#52607a]">No skills added.</span>'}
                        </div>
                    </article>
                </div>

                <aside class="min-w-0">
                    <div class="mb-[22px] rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <a href="${escapeHtml(applyLink(job))}" class="flex h-11 w-full items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#003f9e]">Apply Now</a>
                    </div>

                    <div class="rounded-lg border border-[#dce7f8] bg-white p-[22px] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                        <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Job Overview</h2>
                        ${overviewRow('Job Type', job.job_type)}
                        ${overviewRow('Hiring Mode', labelMode(job.hiring_mode))}
                        ${overviewRow('Location', job.location)}
                        ${overviewRow('Industry', company.industry)}
                        ${overviewRow('Salary', job.salary)}
                        ${overviewRow('Immediate Joiner', job.immediate_joiner ? 'Yes' : 'No')}
                        ${overviewRow('Openings Left', openingsLeft(job))}
                        ${overviewRow('Last Date', job.application_last_date ? new Date(job.application_last_date).toLocaleDateString('en-IN') : '-')}
                    </div>
                </aside>
            </div>
        `;
    }

    async function loadJob() {
        if (!jobId) {
            publicJobDetail.textContent = 'Job id missing.';
            return;
        }

        try {
            const response = await fetch('/api/jobs/' + jobId, { headers: { Accept: 'application/json' } });
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Job details load nahi ho paayi.');
            renderJob(payload.data.job);
        } catch (error) {
            publicJobDetail.className = 'rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm text-[#b42318]';
            publicJobDetail.textContent = error.message || 'Job details load nahi ho paayi.';
        }
    }

    loadJob();
</script>
@endpush
