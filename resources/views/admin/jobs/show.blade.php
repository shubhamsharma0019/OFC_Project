@extends('layouts.admin')

@section('title', 'Job Details - OnlyFreshers Admin')
@section('pageTitle', 'Job Details')
@section('breadcrumb', 'Jobs / Details')

@php
    $activePage = 'jobs';
@endphp

@section('topbarExtra')
    <a href="/admin/jobs" class="inline-flex h-10 items-center justify-center rounded-md border border-[#dce7f8] px-4 text-sm font-bold text-[#075fe4]">Back</a>
@endsection

@section('content')
    <section class="grid gap-5">
        <div id="detailAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#ff1f2f]"></div>
        <div id="jobDetail" class="grid gap-5"><article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)]">Loading job details...</article></div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const jobId = localStorage.getItem('ofc_selected_admin_job_id');
    const jobDetail = document.getElementById('jobDetail');
    const detailAlert = document.getElementById('detailAlert');

    if (!token) window.location.href = '/admin/login';
    if (!jobId) window.location.href = '/admin/jobs';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function badgeClass(status) { if (status === 'active' || status === 'hired' || status === 'shortlisted') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'removed' || status === 'rejected') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    function field(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><strong class="mt-2 block break-words text-sm text-[#061942]">${escapeHtml(value || '-')}</strong></div>`; }
    function miniStat(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#061942]">${number(value)}</h2></div>`; }
    function listItem(title, meta, status) { return `<div class="grid gap-2 rounded-lg border border-[#edf2fb] p-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center"><div><strong class="block text-sm text-[#061942]">${escapeHtml(title)}</strong><p class="mt-1 text-xs text-[#52607a]">${escapeHtml(meta)}</p></div><span class="w-max rounded-md ${badgeClass(status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(status))}</span></div>`; }
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    function renderJob(job) {
        const applications = job.applications || [];
        jobDetail.innerHTML = `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between"><div class="min-w-0"><h2 class="text-2xl font-bold text-[#061942]">${escapeHtml(job.title)}</h2><p class="mt-1 text-sm text-[#52607a]">${escapeHtml(job.company_profile?.company_name || 'Company')} - ${escapeHtml(job.location || '-')}</p><div class="mt-3 flex flex-wrap gap-2"><span class="rounded-md ${badgeClass(job.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(job.status))}</span><span class="rounded-md bg-[#eaf2ff] px-3 py-1 text-xs font-bold capitalize text-[#075fe4]">${escapeHtml(statusText(job.hiring_mode))}</span></div></div><div class="flex flex-wrap gap-2"><button class="statusBtn h-10 rounded-md border border-[#078346] px-4 text-sm font-bold text-[#078346]" type="button" data-status="active">Activate</button><button class="statusBtn h-10 rounded-md border border-[#ff1f2f] px-4 text-sm font-bold text-[#ff1f2f]" type="button" data-status="removed">Remove</button></div></div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${miniStat('Applications', job.applications_count || applications.length)}${miniStat('Openings', job.openings)}${miniStat('Shortlisted', applications.filter((a) => a.application_status === 'shortlisted').length)}${miniStat('Hired', applications.filter((a) => a.application_status === 'hired').length)}</div>
        </article>
        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Job Information</h2><div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${field('Job Type', statusText(job.job_type))}${field('Salary', job.salary)}${field('Qualification', job.qualification)}${field('Last Date', formatDate(job.application_last_date))}${field('Required Skills', job.required_skills)}${field('Description', job.description)}</div></article>
        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Applications</h2><div class="grid gap-3">${applications.length ? applications.map((app) => listItem(app.fresher_profile?.user?.name || 'Fresher', app.fresher_profile?.user?.email || 'Application', app.application_status)).join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No applications found.</div>'}</div></article>`;
        document.querySelectorAll('.statusBtn').forEach((button) => button.addEventListener('click', async () => { button.disabled = true; try { await requestJson(`/api/admin/jobs/${jobId}/status`, { method: 'PATCH', body: JSON.stringify({ status: button.dataset.status }) }); await loadJob(); } catch (error) { alert(error.message || 'Status update nahi ho paaya.'); button.disabled = false; } }));
    }
    async function loadJob() {
        try {
            const payload = await requestJson(`/api/admin/jobs/${jobId}`);
            if (!payload) return;
            renderJob(payload.data.job);
        } catch (error) {
            detailAlert.textContent = error.message || 'Job detail load nahi ho paayi.';
            detailAlert.classList.remove('hidden');
            jobDetail.innerHTML = '';
        }
    }
    loadJob();
</script>
@endpush
