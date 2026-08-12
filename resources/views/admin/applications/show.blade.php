@extends('layouts.admin')

@section('title', 'Application Details - OnlyFreshers Admin')
@section('pageTitle', 'Application Details')
@section('breadcrumb', 'Dashboard > Applications > Details')

@php
    $activePage = 'applications';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="applicationDetails" class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)]">Loading application details...</div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const applicationId = localStorage.getItem('ofc_selected_admin_application_id');
    const applicationDetails = document.getElementById('applicationDetails');

    if (!token) window.location.href = '/admin/login';
    if (!applicationId) window.location.href = '/admin/applications';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function label(value) { return String(value || '-').replaceAll('_', ' '); }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }); }
    function initials(name) { return String(name || 'OF').trim().split(/\s+/).slice(0, 2).map((part) => part[0] || '').join('').toUpperCase() || 'OF'; }
    function badgeClass(status) {
        if (status === 'hired' || status === 'shortlisted') return 'bg-[#e8f8ef] text-[#078346]';
        if (status === 'rejected') return 'bg-[#fff0f1] text-[#ff1f2f]';
        if (status === 'interview_scheduled') return 'bg-[#eaf2ff] text-[#075fe4]';
        return 'bg-[#fff4df] text-[#b86500]';
    }
    function infoRow(labelText, value) {
        return `<div class="rounded-lg border border-[#e4ecf8] bg-[#fbfdff] p-4"><p class="text-xs font-bold text-[#52607a]">${escapeHtml(labelText)}</p><p class="mt-2 font-bold text-[#061942]">${escapeHtml(value || '-')}</p></div>`;
    }
    async function requestJson(url) {
        const response = await fetch(url, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    function renderApplication(application) {
        const profile = application.fresher_profile || {};
        const user = profile.user || {};
        const job = application.job || {};
        const company = job.company_profile || {};
        const companyUser = company.user || {};
        const interview = application.interview || {};
        const skills = Array.isArray(profile.skills) ? profile.skills : String(profile.skills || '').split(',').filter(Boolean);

        applicationDetails.innerHTML = `
            <div class="flex flex-col gap-4 border-b border-[#edf2fb] pb-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex gap-4">
                    <span class="inline-flex h-16 w-16 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-xl font-black text-[#075fe4]">${escapeHtml(initials(user.name))}</span>
                    <div>
                        <h2 class="text-2xl font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h2>
                        <p class="mt-1 text-sm text-[#52607a]">${escapeHtml(user.email || '-')} ${user.mobile ? '- ' + escapeHtml(user.mobile) : ''}</p>
                        <span class="mt-3 inline-flex rounded-md ${badgeClass(application.application_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(application.application_status))}</span>
                    </div>
                </div>
                <a href="/admin/applications" class="inline-flex h-10 w-max items-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]">Back to Applications</a>
            </div>

            <div class="mt-5 grid gap-4 lg:grid-cols-3">
                ${infoRow('Applied Date', formatDate(application.applied_at || application.created_at))}
                ${infoRow('Job Title', job.title)}
                ${infoRow('Company', company.company_name)}
                ${infoRow('Location', job.location)}
                ${infoRow('Job Type', label(job.job_type))}
                ${infoRow('Hiring Mode', label(job.hiring_mode))}
            </div>

            <div class="mt-5 grid gap-5 xl:grid-cols-[1.15fr_.85fr]">
                <article class="rounded-lg border border-[#e4ecf8] p-5">
                    <h3 class="mb-4 text-lg font-bold text-[#061942]">Candidate Profile</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        ${infoRow('Qualification', profile.highest_qualification || profile.qualification)}
                        ${infoRow('Experience', profile.experience || profile.experience_level)}
                        ${infoRow('City', profile.city)}
                        ${infoRow('Profile Status', label(user.status))}
                    </div>
                    <div class="mt-4">
                        <p class="mb-2 text-xs font-bold text-[#52607a]">Skills</p>
                        <div class="flex flex-wrap gap-2">${skills.length ? skills.map((skill) => `<span class="rounded-md bg-[#eaf2ff] px-3 py-1 text-xs font-bold text-[#075fe4]">${escapeHtml(skill)}</span>`).join('') : '<span class="text-sm text-[#52607a]">No skills added.</span>'}</div>
                    </div>
                </article>

                <article class="rounded-lg border border-[#e4ecf8] p-5">
                    <h3 class="mb-4 text-lg font-bold text-[#061942]">Review Details</h3>
                    <div class="grid gap-4">
                        ${infoRow('Interview Status', interview.id ? label(interview.interview_status || interview.status) : 'Not scheduled')}
                        ${infoRow('Interview Date', formatDate(interview.scheduled_at || interview.interview_date))}
                        ${infoRow('Company Email', companyUser.email)}
                        ${infoRow('Company Phone', companyUser.mobile)}
                    </div>
                </article>
            </div>

            <article class="mt-5 rounded-lg border border-[#e4ecf8] p-5">
                <h3 class="mb-3 text-lg font-bold text-[#061942]">Job Description</h3>
                <p class="whitespace-pre-line leading-relaxed text-[#24344f]">${escapeHtml(job.description || 'No description added.')}</p>
            </article>
        `;
    }
    async function loadApplication() {
        try {
            const payload = await requestJson('/api/admin/applications/' + applicationId);
            if (!payload) return;
            renderApplication(payload.data?.application || {});
        } catch (error) {
            applicationDetails.innerHTML = '<p class="text-[#ff1f2f]">' + escapeHtml(error.message || 'Application details load nahi ho paayi.') + '</p><a href="/admin/applications" class="mt-4 inline-flex h-10 items-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]">Back to Applications</a>';
        }
    }
    loadApplication();
</script>
@endpush
