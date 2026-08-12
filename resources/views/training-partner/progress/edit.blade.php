@extends('layouts.training-partner')

@section('title', 'Edit Progress')

@php
    $activePage = 'progress';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Edit Progress</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Update progress records and learning milestones.</p>
            </div>
            <a href="/training-partner/training-progress" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Back</a>
        </div>

        <div id="progressMessage" class="hidden rounded-lg p-4 text-sm font-bold"></div>

        <article id="progressSummary" class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)]">Loading progress...</article>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <form id="progressForm" class="grid gap-5">
                <label class="grid gap-2 text-xs font-bold text-[#071544]">
                    Progress Percentage
                    <input id="progressPercentage" class="h-11 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" type="number" min="0" max="100" value="0" required>
                </label>
                <div>
                    <div class="mb-2 flex items-center justify-between text-xs font-bold text-[#071544]"><span>Progress Bar</span><span id="progressValue">0%</span></div>
                    <div class="h-3 overflow-hidden rounded-full bg-[#f0eaff]"><div id="progressBar" class="h-full rounded-full bg-[#6a2df0]" style="width:0%"></div></div>
                </div>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">
                    Short Remark
                    <textarea id="shortRemark" class="min-h-28 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none" maxlength="500" placeholder="Add learner progress remark..."></textarea>
                </label>
                <div class="flex flex-wrap gap-3">
                    <button id="saveProgressBtn" class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white" type="submit">Save Changes</button>
                    <a href="/training-partner/progress/show" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">View Details</a>
                </div>
            </form>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const selectedEnrollmentId = localStorage.getItem('ofc_selected_training_enrollment_id');
    const progressSummary = document.getElementById('progressSummary');
    const progressMessage = document.getElementById('progressMessage');
    const progressForm = document.getElementById('progressForm');
    const progressPercentage = document.getElementById('progressPercentage');
    const shortRemark = document.getElementById('shortRemark');
    const progressValue = document.getElementById('progressValue');
    const progressBar = document.getElementById('progressBar');
    const saveProgressBtn = document.getElementById('saveProgressBtn');

    if (!token) window.location.href = '/training-partner/login';
    if (!selectedEnrollmentId) window.location.href = '/training-partner/training-progress';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function studentName(item) { return item.fresher_profile?.user?.name || 'Fresher #' + (item.fresher_profile?.id || item.id); }
    function studentEmail(item) { return item.fresher_profile?.user?.email || item.fresher_profile?.phone || '-'; }
    function progressPercent(item) { return item.training_progress?.progress_percentage ?? (item.training_status === 'completed' ? 100 : 0); }
    function showMessage(message, type = 'success') {
        progressMessage.textContent = message;
        progressMessage.className = 'rounded-lg p-4 text-sm font-bold ' + (type === 'success' ? 'border border-[#b8edc9] bg-[#f0fff5] text-[#05843e]' : 'border border-[#ffd8d8] bg-[#fff4f4] text-[#b42318]');
    }
    function syncBar() {
        const value = Math.max(0, Math.min(100, Number(progressPercentage.value || 0)));
        progressPercentage.value = value;
        progressValue.textContent = value + '%';
        progressBar.style.width = value + '%';
    }
    function renderSummary(item) {
        progressSummary.innerHTML = `<div class="grid gap-4 md:grid-cols-3">
            <div><p class="text-xs font-bold text-[#526287]">Student</p><strong class="mt-1 block text-[#071544]">${escapeHtml(studentName(item))}</strong><span class="text-xs text-[#526287]">${escapeHtml(studentEmail(item))}</span></div>
            <div><p class="text-xs font-bold text-[#526287]">Course</p><strong class="mt-1 block text-[#071544]">${escapeHtml(item.course?.course_name || '-')}</strong><span class="text-xs text-[#526287]">${escapeHtml(item.course?.training_mode || '')}</span></div>
            <div><p class="text-xs font-bold text-[#526287]">Current Status</p><strong class="mt-1 block capitalize text-[#071544]">${escapeHtml(statusText(item.training_status))}</strong></div>
        </div>`;
    }
    async function loadProgress() {
        try {
            const response = await fetch(`/api/training-partner/enrollments/${selectedEnrollmentId}/progress`, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Progress load nahi ho paaya.');
            const enrollment = payload.data.enrollment;
            renderSummary(enrollment);
            progressPercentage.value = progressPercent(enrollment);
            shortRemark.value = enrollment.training_progress?.short_remark || '';
            syncBar();
        } catch (error) {
            showMessage(error.message || 'Progress load nahi ho paaya.', 'error');
            progressSummary.textContent = 'Progress unavailable.';
        }
    }
    progressPercentage.addEventListener('input', syncBar);
    progressForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        saveProgressBtn.disabled = true;
        saveProgressBtn.textContent = 'Saving...';
        try {
            const response = await fetch(`/api/training-partner/enrollments/${selectedEnrollmentId}/progress`, {
                method: 'PATCH',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
                body: JSON.stringify({ progress_percentage: Number(progressPercentage.value), short_remark: shortRemark.value.trim() })
            });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Progress save nahi ho paaya.');
            showMessage(payload.message || 'Progress updated successfully.');
            if (payload.data?.enrollment) renderSummary(payload.data.enrollment);
        } catch (error) {
            showMessage(error.message || 'Progress save nahi ho paaya.', 'error');
        } finally {
            saveProgressBtn.disabled = false;
            saveProgressBtn.textContent = 'Save Changes';
        }
    });
    loadProgress();
</script>
@endpush
