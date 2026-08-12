@extends('layouts.training-partner')

@section('title', 'Course Details')

@php
    $activePage = 'courses';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Course Details</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View course information and publishing details.</p>
            </div>
            <div class="flex gap-3">
                <a href="/training-partner/courses" class="inline-flex h-10 items-center justify-center rounded-md border border-[#5b20e6] px-5 text-sm font-bold text-[#5b20e6]">Back</a>
                <button id="editButton" class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white" type="button">Edit Course</button>
            </div>
        </div>

        <article id="courseCard" class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <p class="text-sm text-[#526287]">Loading course details...</p>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const courseId = localStorage.getItem('ofc_selected_training_course_id');
    const courseCard = document.getElementById('courseCard');

    if (!token) window.location.href = '/training-partner/login';
    if (!courseId) window.location.href = '/training-partner/courses';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatMoney(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function badgeClass(status) { return status === 'active' ? 'bg-[#e2f9ea] text-[#05843e]' : (status === 'inactive' ? 'bg-[#fff0de] text-[#d06d00]' : 'bg-[#f2f4f7] text-[#344054]'); }
    function row(label, value) { return `<div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">${escapeHtml(label)}</p><strong class="mt-2 block break-words text-[#071544]">${escapeHtml(value || '-')}</strong></div>`; }

    async function loadCourse() {
        try {
            const response = await fetch('/api/training-partner/courses/' + courseId, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = payload.data?.approval_status === 'rejected' ? '/training-partner/approval/rejected' : '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Course details load nahi ho paayi.');
            const course = payload.data.course;
            localStorage.setItem('ofc_selected_training_course_id', course.id);
            courseCard.innerHTML = `
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0"><h2 class="text-2xl font-bold text-[#071544]">${escapeHtml(course.course_name)}</h2><p class="mt-2 text-sm leading-7 text-[#526287]">${escapeHtml(course.description)}</p></div>
                    <span class="inline-flex w-fit rounded-md ${badgeClass(course.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(course.status)}</span>
                </div>
                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    ${row('Category', course.category)}
                    ${row('Training Mode', course.training_mode)}
                    ${row('Duration', course.duration)}
                    ${row('Fees', formatMoney(course.fees))}
                    ${row('Start Date', formatDate(course.start_date))}
                    ${row('Created', formatDate(course.created_at))}
                    ${row('Updated', formatDate(course.updated_at))}
                </div>
                <div class="mt-6 rounded-lg border border-[#e7ebf5] p-4"><p class="mb-3 text-xs font-bold text-[#526287]">Skills Covered</p><div class="flex flex-wrap gap-2">${String(course.skills_covered || '').split(',').map(s => s.trim()).filter(Boolean).map(skill => `<span class="rounded-md bg-[#f3ecff] px-3 py-1.5 text-xs font-bold text-[#5b20e6]">${escapeHtml(skill)}</span>`).join('') || '<span class="text-sm text-[#526287]">No skills added.</span>'}</div></div>
            `;
        } catch (error) {
            courseCard.innerHTML = '<p class="text-sm font-bold text-[#b42318]">' + escapeHtml(error.message || 'Course details load nahi ho paayi.') + '</p>';
        }
    }
    document.getElementById('editButton').addEventListener('click', () => { window.location.href = '/training-partner/courses/edit'; });
    loadCourse();
</script>
@endpush
