@extends('layouts.training-partner')

@section('title', 'Certificate Details')

@php
    $activePage = 'certificates';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Certificate Details</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View certificate information and verification status.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="/training-partner/certificates" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Back</a>
                <a id="certificateFileLink" href="#" target="_blank" rel="noopener" class="hidden h-10 items-center justify-center rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white">Open File</a>
            </div>
        </div>

        <div id="certificateAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#b42318]"></div>
        <div id="certificateDetail" class="grid gap-5"><article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)]">Loading certificate...</article></div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const certificateId = localStorage.getItem('ofc_selected_training_certificate_id');
    const certificateAlert = document.getElementById('certificateAlert');
    const certificateDetail = document.getElementById('certificateDetail');
    const certificateFileLink = document.getElementById('certificateFileLink');

    if (!token) window.location.href = '/training-partner/login';
    if (!certificateId) window.location.href = '/training-partner/certificates';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function studentName(item) { return item.fresher_profile?.user?.name || 'Fresher #' + (item.fresher_profile?.id || item.id); }
    function studentEmail(item) { return item.fresher_profile?.user?.email || item.fresher_profile?.phone || '-'; }
    function courseName(item) { return item.course_enrollment?.course?.course_name || '-'; }
    function field(label, value) { return `<div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">${label}</p><strong class="mt-2 block break-words text-sm text-[#071544]">${escapeHtml(value || '-')}</strong></div>`; }
    function renderCertificate(item, url) {
        if (url) {
            certificateFileLink.href = url;
            certificateFileLink.classList.remove('hidden');
            certificateFileLink.classList.add('inline-flex');
        }
        certificateDetail.innerHTML = `<article class="rounded-lg border border-[#dddff0] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="rounded-lg border-4 border-[#071544] bg-[#fbfdff] p-8 text-center">
                <p class="text-xs font-bold uppercase tracking-[.18em] text-[#526287]">Certificate of Completion</p>
                <h2 class="mt-4 text-2xl font-bold text-[#071544]">${escapeHtml(studentName(item))}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-[#526287]">Successfully completed <strong class="text-[#071544]">${escapeHtml(courseName(item))}</strong> with final assessment score <strong class="text-[#071544]">${escapeHtml(item.final_assessment_result?.overall_score ?? '-')}%</strong>.</p>
                <p class="mt-5 text-xs font-bold text-[#526287]">${escapeHtml(item.certificate_number)}</p>
            </div>
        </article>
        <div class="grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><h2 class="mb-4 text-lg font-bold text-[#071544]">Student</h2><div class="grid gap-4 md:grid-cols-2">${field('Name', studentName(item))}${field('Email', studentEmail(item))}${field('Issued On', formatDate(item.created_at))}${field('Completion Date', formatDate(item.completion_date))}</div></article>
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><h2 class="mb-4 text-lg font-bold text-[#071544]">Course & Result</h2><div class="grid gap-4 md:grid-cols-2">${field('Course', courseName(item))}${field('Mode', item.course_enrollment?.course?.training_mode)}${field('Score', (item.final_assessment_result?.overall_score ?? '-') + ' / 100')}${field('Result', item.final_assessment_result?.result || '-')}</div></article>
        </div>
        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><h2 class="mb-4 text-lg font-bold text-[#071544]">Verification</h2><div class="grid gap-4 md:grid-cols-3">${field('Certificate Number', item.certificate_number)}${field('File Path', item.certificate_file)}${field('Status', 'Generated')}</div></article>`;
    }
    async function loadCertificate() {
        try {
            const response = await fetch(`/api/training-partner/certificates/${certificateId}`, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Certificate load nahi ho paaya.');
            renderCertificate(payload.data.certificate, payload.data.certificate_url);
        } catch (error) {
            certificateAlert.textContent = error.message || 'Certificate load nahi ho paaya.';
            certificateAlert.classList.remove('hidden');
            certificateDetail.innerHTML = '';
        }
    }
    loadCertificate();
</script>
@endpush
