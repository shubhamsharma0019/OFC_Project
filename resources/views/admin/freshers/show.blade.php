@extends('layouts.admin')

@section('title', 'Fresher Details - OnlyFreshers Admin')
@section('pageTitle', 'Fresher Details')
@section('breadcrumb', 'Freshers / Details')

@php
    $activePage = 'freshers';
@endphp

@section('topbarExtra')
    <a href="/admin/freshers" class="inline-flex h-10 items-center justify-center rounded-md border border-[#dce7f8] px-4 text-sm font-bold text-[#075fe4]">Back</a>
@endsection

@section('content')
    <section class="grid gap-5">
        <div id="detailAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#ff1f2f]"></div>
        <div id="fresherDetail" class="grid gap-5">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)]">Loading fresher details...</article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const fresherId = localStorage.getItem('ofc_selected_admin_fresher_id');
    const fresherDetail = document.getElementById('fresherDetail');
    const detailAlert = document.getElementById('detailAlert');

    if (!token) window.location.href = '/admin/login';
    if (!fresherId) window.location.href = '/admin/freshers';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { return ['active', 'hired', 'selected', 'completed', 'pass', 'paid'].includes(status) ? 'bg-[#e8f8ef] text-[#078346]' : ['blocked', 'rejected', 'failed', 'fail'].includes(status) ? 'bg-[#fff0f1] text-[#ff1f2f]' : 'bg-[#fff4df] text-[#b86500]'; }
    function field(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><strong class="mt-2 block break-words text-sm text-[#061942]">${escapeHtml(value || '-')}</strong></div>`; }
    function miniStat(label, value) { return `<div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4"><p class="text-xs font-bold text-[#52607a]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#061942]">${number(value)}</h2></div>`; }
    function listItem(title, meta, status) { return `<div class="grid gap-2 rounded-lg border border-[#edf2fb] p-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center"><div><strong class="block text-sm text-[#061942]">${escapeHtml(title)}</strong><p class="mt-1 text-xs text-[#52607a]">${escapeHtml(meta)}</p></div><span class="w-max rounded-md ${badgeClass(status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(status))}</span></div>`; }
    function emptyText(text) { return `<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">${escapeHtml(text)}</div>`; }
    function renderDetail(fresher) {
        const profile = fresher.fresher_profile || {};
        const applications = profile.job_applications || [];
        const enrollments = profile.course_enrollments || [];
        const assessments = profile.assessment_attempts || [];
        const certificates = profile.certificates || [];
        fresherDetail.innerHTML = `
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex min-w-0 gap-4"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xl font-black text-[#075fe4]">${escapeHtml((fresher.name || 'F').slice(0, 1).toUpperCase())}</div><div class="min-w-0"><h2 class="text-2xl font-bold text-[#061942]">${escapeHtml(fresher.name)}</h2><p class="mt-1 text-sm text-[#52607a]">${escapeHtml(fresher.email || fresher.mobile || '-')}</p><span class="mt-3 inline-flex rounded-md ${badgeClass(fresher.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(fresher.status)}</span></div></div>
                    <button id="statusButton" class="h-10 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button" data-status="${fresher.status === 'active' ? 'blocked' : 'active'}">${fresher.status === 'active' ? 'Block Fresher' : 'Activate Fresher'}</button>
                </div>
                <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${miniStat('Applications', applications.length)}${miniStat('Enrollments', enrollments.length)}${miniStat('Assessments', assessments.length)}${miniStat('Certificates', certificates.length)}</div>
            </article>
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Profile</h2><div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">${field('Phone', profile.phone || fresher.mobile)}${field('City', profile.city)}${field('Qualification', profile.qualification)}${field('College', profile.college_name)}${field('Passing Year', profile.passing_year)}${field('Skills', profile.skills)}${field('Profile Completion', (profile.profile_completion || 0) + '%')}${field('Joined', formatDate(fresher.created_at))}</div></article>
            <div class="grid gap-5 xl:grid-cols-2">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Job Applications</h2><div class="grid gap-3">${applications.length ? applications.map((item) => listItem(item.job?.job_title || 'Job', item.job?.company_profile?.company_name || 'Company', item.application_status)).join('') : emptyText('No job applications found.')}</div></article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Course Enrollments</h2><div class="grid gap-3">${enrollments.length ? enrollments.map((item) => listItem(item.course?.course_name || 'Course', item.course?.training_partner_profile?.institute_name || 'Training Partner', item.enrollment_status)).join('') : emptyText('No course enrollments found.')}</div></article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Assessments</h2><div class="grid gap-3">${assessments.length ? assessments.map((item) => listItem(statusText(item.assessment_type) + ' Assessment', 'Score: ' + (item.result?.overall_score ?? '-') + ' / 100', item.result?.result || item.status)).join('') : emptyText('No assessments found.')}</div></article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><h2 class="mb-4 text-lg font-bold text-[#061942]">Certificates</h2><div class="grid gap-3">${certificates.length ? certificates.map((item) => listItem(item.certificate_number || 'Certificate', 'Completed on ' + formatDate(item.completion_date), item.final_assessment_result?.result || 'generated')).join('') : emptyText('No certificates found.')}</div></article>
            </div>
        `;
        document.getElementById('statusButton').addEventListener('click', async (event) => {
            event.target.disabled = true;
            try { await updateStatus(event.target.dataset.status); await loadFresher(); } catch (error) { alert(error.message || 'Status update nahi ho paaya.'); event.target.disabled = false; }
        });
    }
    async function updateStatus(status) {
        const response = await fetch(`/api/admin/freshers/${fresherId}/status`, { method: 'PATCH', headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token }, body: JSON.stringify({ status }) });
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Status update nahi ho paaya.');
    }
    async function loadFresher() {
        try {
            const response = await fetch(`/api/admin/freshers/${fresherId}`, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/admin/login'; return; }
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Fresher detail load nahi ho paayi.');
            renderDetail(payload.data.fresher);
        } catch (error) {
            detailAlert.textContent = error.message || 'Fresher detail load nahi ho paayi.';
            detailAlert.classList.remove('hidden');
            fresherDetail.innerHTML = '';
        }
    }
    loadFresher();
</script>
@endpush
