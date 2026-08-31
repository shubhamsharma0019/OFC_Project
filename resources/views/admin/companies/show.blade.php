@extends('layouts.admin')

@section('title', 'Company Details - OnlyFreshers Admin')
@section('pageTitle', 'Company Details')
@section('breadcrumb', 'Companies / Details')

@php
    $activePage = 'companies';
@endphp

@section('topbarExtra')
    <a href="/admin/companies" class="inline-flex h-10 items-center justify-center rounded-md border border-[#dce7f8] px-4 text-sm font-bold text-[#075fe4]">Back</a>
@endsection

@section('content')
    <section class="grid gap-5">
        <div id="detailAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#ff1f2f]"></div>
        <div id="companyDetail" class="grid gap-5"><article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)]">Loading company details...</article></div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const companyId = localStorage.getItem('ofc_selected_admin_company_id');
    const companyDetail = document.getElementById('companyDetail');
    const detailAlert = document.getElementById('detailAlert');

    if (!token) window.location.href = '/admin/login';
    if (!companyId) window.location.href = '/admin/companies';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { if (status === 'approved' || status === 'active' || status === 'hired') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'rejected' || status === 'blocked') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
    function field(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><strong class="mt-2 block break-words text-sm text-[#061942]">${escapeHtml(value || '-')}</strong></div>`; }
    function miniStat(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#061942]">${number(value)}</h2></div>`; }
    function listItem(title, meta, status) { return `<div class="grid gap-2 rounded-lg border border-[#edf2fb] p-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center"><div><strong class="block text-sm text-[#061942]">${escapeHtml(title)}</strong><p class="mt-1 text-xs text-[#52607a]">${escapeHtml(meta)}</p></div><span class="w-max rounded-md ${badgeClass(status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(status))}</span></div>`; }
    function assignedResumeItem(assignment) {
        const profile = assignment.fresher_profile || {};
        return `<div class="rounded-lg border border-[#edf2fb] p-4"><strong class="block text-sm text-[#061942]">${escapeHtml(profile.user?.name || 'Candidate')}</strong><p class="mt-1 text-xs text-[#52607a]">${escapeHtml([profile.preferred_job_category, profile.qualification, profile.city].filter(Boolean).join(' - ') || profile.user?.email || 'Resume assigned')}</p></div>`;
    }
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadAvailableResumes() {
        const payload = await requestJson('/api/admin/companies/available-resumes');
        return payload?.data?.resumes || [];
    }
    function renderCompany(company) {
        const jobs = company.jobs || [];
        const applications = jobs.flatMap((job) => job.applications || []);
        const assignments = company.resume_assignments || [];
        const isResumeOnly = company.hiring_intent === 'resume_only';
        companyDetail.innerHTML = `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between"><div class="flex min-w-0 gap-4"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xl font-black text-[#075fe4]">${escapeHtml((company.company_name || 'C').slice(0, 1).toUpperCase())}</div><div class="min-w-0"><h2 class="text-2xl font-bold text-[#061942]">${escapeHtml(company.company_name || company.user?.name || 'Company')}</h2><p class="mt-1 text-sm text-[#52607a]">${escapeHtml(company.email || company.user?.email || '-')}</p><div class="mt-3 flex flex-wrap gap-2"><span class="rounded-md ${badgeClass(company.approval_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(company.approval_status)}</span><span class="rounded-md ${badgeClass(company.user?.status)} px-3 py-1 text-xs font-bold capitalize">User ${escapeHtml(company.user?.status || '-')}</span></div></div></div>
            <div class="flex flex-wrap gap-2"><button id="approveBtn" class="h-10 rounded-md border border-[#078346] px-4 text-sm font-bold text-[#078346]" type="button">Approve</button><button id="rejectBtn" class="h-10 rounded-md border border-[#ff1f2f] px-4 text-sm font-bold text-[#ff1f2f]" type="button">Reject</button><button id="userStatusBtn" class="h-10 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button" data-status="${company.user?.status === 'active' ? 'blocked' : 'active'}">${company.user?.status === 'active' ? 'Block User' : 'Activate User'}</button></div></div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${miniStat('Credits', company.job_credits)}${miniStat('Assigned Resumes', assignments.length)}${miniStat('Jobs', jobs.length)}${miniStat('Applications', applications.length)}</div>
        </article>
        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Profile</h2><div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${field('Industry', company.industry)}${field('Intent', statusText(company.hiring_intent || 'job_posting'))}${field('Phone', company.phone || company.user?.mobile)}${field('Website', company.website)}${field('Address', company.address)}${field('Joined', formatDate(company.created_at))}${field('Rejection Reason', company.rejection_reason)}${field('Description', company.description)}</div></article>
        ${isResumeOnly ? `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div><h2 class="text-lg font-bold text-[#061942]">Resume Access</h2><p class="mt-1 text-xs font-bold text-[#52607a]">Company can open assigned resumes at 50 credits per click.</p></div>
                <div class="flex flex-wrap gap-2"><button id="createDummyResumesBtn" class="h-10 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button">Create Dummy Resumes</button><button id="assignAllResumesBtn" class="h-10 rounded-md bg-[#075fe4] px-4 text-sm font-bold text-white" type="button">Assign All Resumes</button></div>
            </div>
            <div id="availableResumeBox" class="mb-4 rounded-lg border border-[#edf2fb] bg-[#f8fbff] p-4 text-sm font-bold text-[#52607a]">Loading resume pool...</div>
            <h3 class="mb-3 text-sm font-bold text-[#061942]">Assigned to Company</h3>
            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">${assignments.length ? assignments.map(assignedResumeItem).join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No resumes assigned yet.</div>'}</div>
        </article>` : ''}
        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Jobs</h2><div class="grid gap-3">${jobs.length ? jobs.map((job) => listItem(job.job_title || 'Job', (job.location || '-') + ' - ' + (job.applications_count || 0) + ' applications', job.status)).join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No jobs found.</div>'}</div></article>`;
        document.getElementById('approveBtn').onclick = () => action(`/api/admin/companies/${companyId}/approve`, { method: 'POST' });
        document.getElementById('rejectBtn').onclick = () => { const reason = prompt('Rejection reason?') || 'Rejected by admin.'; action(`/api/admin/companies/${companyId}/reject`, { method: 'POST', body: JSON.stringify({ rejection_reason: reason }) }); };
        document.getElementById('userStatusBtn').onclick = (event) => action(`/api/admin/companies/${companyId}/user-status`, { method: 'PATCH', body: JSON.stringify({ status: event.target.dataset.status }) });
        if (isResumeOnly) {
            wireResumeTools();
        }
    }
    async function wireResumeTools() {
        const availableBox = document.getElementById('availableResumeBox');
        const renderAvailable = async () => {
            const resumes = await loadAvailableResumes();
            availableBox.innerHTML = resumes.length
                ? `<div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-3">${resumes.slice(0, 12).map((resume) => `<label class="flex items-start gap-3 rounded-md border border-[#dce7f8] bg-white p-3 text-xs font-bold text-[#061942]"><input class="resume-pick mt-1" type="checkbox" value="${resume.id}"><span><span class="block">${escapeHtml(resume.name)}</span><span class="mt-1 block font-semibold text-[#52607a]">${escapeHtml(resume.category || resume.qualification || 'Resume')}</span></span></label>`).join('')}</div><button id="assignSelectedResumesBtn" class="mt-4 h-10 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button">Assign Selected</button>`
                : 'No resumes in pool. Click Create Dummy Resumes.';
            document.getElementById('assignSelectedResumesBtn')?.addEventListener('click', async () => {
                const ids = Array.from(document.querySelectorAll('.resume-pick:checked')).map((input) => Number(input.value));
                if (!ids.length) { alert('Select resumes first.'); return; }
                await action(`/api/admin/companies/${companyId}/resumes`, { method: 'POST', body: JSON.stringify({ fresher_profile_ids: ids }) });
            });
        };
        document.getElementById('createDummyResumesBtn').onclick = async () => {
            await requestJson('/api/admin/companies/dummy-resumes', { method: 'POST', body: JSON.stringify({ count: 100 }) });
            await renderAvailable();
        };
        document.getElementById('assignAllResumesBtn').onclick = () => action(`/api/admin/companies/${companyId}/resumes/assign-all`, { method: 'POST' });
        try { await renderAvailable(); } catch (error) { availableBox.textContent = error.message || 'Resume pool could not be loaded.'; }
    }
    async function action(url, options) { try { await requestJson(url, options); await loadCompany(); } catch (error) { alert(error.message || 'Action failed.'); } }
    async function loadCompany() {
        try {
            const payload = await requestJson(`/api/admin/companies/${companyId}`);
            if (!payload) return;
            renderCompany(payload.data.company);
        } catch (error) {
            detailAlert.textContent = error.message || 'Company details could not be loaded.';
            detailAlert.classList.remove('hidden');
            companyDetail.innerHTML = '';
        }
    }
    loadCompany();
</script>
@endpush
