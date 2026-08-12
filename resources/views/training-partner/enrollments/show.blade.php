@extends('layouts.training-partner')

@section('title', 'Enrollment Details')

@php
    $activePage = 'enrollments';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Enrollment Details</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Track learner progress and enrollment activity.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="/training-partner/enrollments" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Back</a>
                <button id="updateProgressBtn" class="hidden h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white" type="button">Update Progress</button>
            </div>
        </div>

        <div id="detailAlert" class="hidden rounded-lg border border-[#ffd8d8] bg-[#fff4f4] p-4 text-sm font-bold text-[#b42318]"></div>

        <div id="detailContent" class="grid gap-5">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)]">Loading enrollment details...</article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const selectedEnrollmentId = localStorage.getItem('ofc_selected_training_enrollment_id');
    const detailContent = document.getElementById('detailContent');
    const detailAlert = document.getElementById('detailAlert');
    const updateProgressBtn = document.getElementById('updateProgressBtn');

    if (!token) window.location.href = '/training-partner/login';
    if (!selectedEnrollmentId) window.location.href = '/training-partner/enrollments';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function badgeClass(status) {
        if (status === 'paid' || status === 'completed' || status === 'enrolled') return 'bg-[#e2f9ea] text-[#05843e]';
        if (status === 'in_progress') return 'bg-[#eaf2ff] text-[#075fe4]';
        if (status === 'pending' || status === 'not_started') return 'bg-[#fff0de] text-[#d06d00]';
        return 'bg-[#fff4f4] text-[#b42318]';
    }
    function field(label, value) {
        return `<div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">${label}</p><strong class="mt-2 block break-words text-sm text-[#071544]">${escapeHtml(value || '-')}</strong></div>`;
    }
    function studentName(enrollment) { return enrollment.fresher_profile?.user?.name || 'Fresher #' + (enrollment.fresher_profile?.id || enrollment.id); }
    function studentEmail(enrollment) { return enrollment.fresher_profile?.user?.email || enrollment.fresher_profile?.email || '-'; }
    function progressPercent(enrollment) { return enrollment.training_progress?.progress_percentage ?? (enrollment.training_status === 'completed' ? 100 : 0); }

    function renderDetail(enrollment) {
        const progress = progressPercent(enrollment);
        const course = enrollment.course || {};
        const fresher = enrollment.fresher_profile || {};
        detailContent.innerHTML = `
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Enrollment</p><span class="mt-3 inline-flex rounded-md ${badgeClass(enrollment.enrollment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(enrollment.enrollment_status))}</span></article>
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Payment</p><span class="mt-3 inline-flex rounded-md ${badgeClass(enrollment.payment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(enrollment.payment_status))}</span></article>
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Training</p><span class="mt-3 inline-flex rounded-md ${badgeClass(enrollment.training_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(enrollment.training_status))}</span></article>
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><p class="text-xs font-bold text-[#526287]">Progress</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${progress}%</h2><div class="mt-3 h-2 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${progress}%"></div></div></article>
            </div>
            <div class="grid gap-5 xl:grid-cols-[1.2fr_.8fr]">
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                    <h2 class="mb-4 text-lg font-bold text-[#071544]">Student</h2>
                    <div class="grid gap-4 md:grid-cols-2">
                        ${field('Name', studentName(enrollment))}
                        ${field('Email', studentEmail(enrollment))}
                        ${field('Phone', fresher.phone || fresher.mobile)}
                        ${field('Qualification', fresher.qualification)}
                        ${field('City', fresher.city)}
                        ${field('Skills', fresher.skills)}
                    </div>
                </article>
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                    <h2 class="mb-4 text-lg font-bold text-[#071544]">Course</h2>
                    <div class="grid gap-4">
                        ${field('Course Name', course.course_name)}
                        ${field('Mode', course.training_mode)}
                        ${field('Duration', course.duration)}
                        ${field('Enrollment Date', formatDate(enrollment.enrollment_date))}
                    </div>
                </article>
            </div>
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <h2 class="mb-3 text-lg font-bold text-[#071544]">Progress Remark</h2>
                <p class="text-sm leading-relaxed text-[#526287]">${escapeHtml(enrollment.training_progress?.short_remark || 'No progress remark added yet.')}</p>
            </article>
        `;
        updateProgressBtn.classList.remove('hidden');
    }

    async function loadDetail() {
        try {
            const response = await fetch(`/api/training-partner/enrollments/${selectedEnrollmentId}/progress`, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Enrollment detail load nahi ho paayi.');
            renderDetail(payload.data.enrollment);
        } catch (error) {
            detailAlert.textContent = error.message || 'Enrollment detail load nahi ho paayi.';
            detailAlert.classList.remove('hidden');
            detailContent.innerHTML = '';
        }
    }

    updateProgressBtn.addEventListener('click', () => {
        localStorage.setItem('ofc_selected_training_enrollment_id', selectedEnrollmentId);
        window.location.href = '/training-partner/progress/edit';
    });

    loadDetail();
</script>
@endpush
