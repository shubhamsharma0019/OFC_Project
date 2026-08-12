@extends('layouts.training-partner')

@section('title', 'Progress Details')

@php
    $activePage = 'progress';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Progress Details</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View detailed learner progress and module completion.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="/training-partner/training-progress" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Back</a>
                <a href="/training-partner/progress/edit" class="inline-flex h-10 items-center justify-center rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white">Update Progress</a>
            </div>
        </div>

        <div id="progressAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#b42318]"></div>
        <div id="progressDetail" class="grid gap-5"><article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)]">Loading progress details...</article></div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const selectedEnrollmentId = localStorage.getItem('ofc_selected_training_enrollment_id');
    const progressAlert = document.getElementById('progressAlert');
    const progressDetail = document.getElementById('progressDetail');

    if (!token) window.location.href = '/training-partner/login';
    if (!selectedEnrollmentId) window.location.href = '/training-partner/training-progress';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function badgeClass(status) { if (status === 'completed') return 'bg-[#e2f9ea] text-[#05843e]'; if (status === 'in_progress') return 'bg-[#eaf2ff] text-[#075fe4]'; return 'bg-[#fff0de] text-[#d06d00]'; }
    function studentName(item) { return item.fresher_profile?.user?.name || 'Fresher #' + (item.fresher_profile?.id || item.id); }
    function studentEmail(item) { return item.fresher_profile?.user?.email || item.fresher_profile?.phone || '-'; }
    function progressPercent(item) { return item.training_progress?.progress_percentage ?? (item.training_status === 'completed' ? 100 : 0); }
    function field(label, value) { return `<div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">${label}</p><strong class="mt-2 block break-words text-sm text-[#071544]">${escapeHtml(value || '-')}</strong></div>`; }
    function renderDetail(item) {
        const progress = progressPercent(item);
        progressDetail.innerHTML = `<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Progress</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${progress}%</h2><div class="mt-3 h-2 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${progress}%"></div></div></article>
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Training Status</p><span class="mt-3 inline-flex rounded-md ${badgeClass(item.training_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(item.training_status))}</span></article>
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Enrollment</p><strong class="mt-2 block capitalize text-[#071544]">${escapeHtml(statusText(item.enrollment_status))}</strong></article>
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Completed On</p><strong class="mt-2 block text-[#071544]">${formatDate(item.training_progress?.completion_date)}</strong></article>
        </div>
        <div class="grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><h2 class="mb-4 text-lg font-bold text-[#071544]">Learner</h2><div class="grid gap-4 md:grid-cols-2">${field('Name', studentName(item))}${field('Email', studentEmail(item))}${field('Phone', item.fresher_profile?.phone)}${field('Qualification', item.fresher_profile?.qualification)}</div></article>
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><h2 class="mb-4 text-lg font-bold text-[#071544]">Course</h2><div class="grid gap-4 md:grid-cols-2">${field('Course', item.course?.course_name)}${field('Mode', item.course?.training_mode)}${field('Duration', item.course?.duration)}${field('Enrolled On', formatDate(item.enrollment_date))}</div></article>
        </div>
        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><h2 class="mb-3 text-lg font-bold text-[#071544]">Remark</h2><p class="text-sm leading-relaxed text-[#526287]">${escapeHtml(item.training_progress?.short_remark || 'No progress remark added yet.')}</p></article>`;
    }
    async function loadDetail() {
        try {
            const response = await fetch(`/api/training-partner/enrollments/${selectedEnrollmentId}/progress`, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Progress detail load nahi ho paaya.');
            renderDetail(payload.data.enrollment);
        } catch (error) {
            progressAlert.textContent = error.message || 'Progress detail load nahi ho paaya.';
            progressAlert.classList.remove('hidden');
            progressDetail.innerHTML = '';
        }
    }
    loadDetail();
</script>
@endpush
