@extends('layouts.training-partner')

@section('title', 'Edit Course')

@php
    $activePage = 'courses';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Edit Course</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Update course details and publishing settings.</p>
            </div>
            <a href="/training-partner/courses" class="inline-flex h-10 items-center justify-center rounded-md border border-[#5b20e6] px-5 text-sm font-bold text-[#5b20e6]">My Courses</a>
        </div>

        <div id="courseMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <form id="courseForm" class="grid gap-4 lg:grid-cols-2">
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Course Name <span class="text-[#ff3045]">*</span><input name="course_name" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Category<input name="category" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Duration <span class="text-[#ff3045]">*</span><input name="duration" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Fees <span class="text-[#ff3045]">*</span><input name="fees" type="number" min="0" step="0.01" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Training Mode <span class="text-[#ff3045]">*</span><select name="training_mode" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required><option value="online">Online</option><option value="offline">Offline</option><option value="hybrid">Hybrid</option></select></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Start Date<input name="start_date" type="date" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Status<select name="status" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"><option value="active">Active</option><option value="inactive">Inactive</option><option value="removed">Removed</option></select></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">Skills Covered<textarea name="skills_covered" class="min-h-24 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none"></textarea></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">Description <span class="text-[#ff3045]">*</span><textarea name="description" class="min-h-32 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none" required></textarea></label>

                <div class="flex justify-end gap-3 lg:col-span-2">
                    <a href="/training-partner/courses/show" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Cancel</a>
                    <button id="saveButton" class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="submit">Save Changes</button>
                </div>
            </form>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const courseId = localStorage.getItem('ofc_selected_training_course_id');
    const form = document.getElementById('courseForm');
    const messageBox = document.getElementById('courseMessage');
    const saveButton = document.getElementById('saveButton');

    if (!token) window.location.href = '/training-partner/login';
    if (!courseId) window.location.href = '/training-partner/courses';

    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error' ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]' : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }
    function setField(name, value) { if (form.elements[name]) form.elements[name].value = value || ''; }
    async function loadCourse() {
        try {
            const response = await fetch('/api/training-partner/courses/' + courseId, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = payload.data?.approval_status === 'rejected' ? '/training-partner/approval/rejected' : '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Course load nahi ho paaya.');
            const course = payload.data.course;
            setField('course_name', course.course_name);
            setField('category', course.category);
            setField('duration', course.duration);
            setField('fees', course.fees);
            setField('training_mode', course.training_mode);
            setField('start_date', course.start_date ? String(course.start_date).slice(0, 10) : '');
            setField('status', course.status);
            setField('skills_covered', course.skills_covered);
            setField('description', course.description);
        } catch (error) {
            showMessage(error.message || 'Course load nahi ho paaya.', 'error');
        }
    }
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';
        const payload = Object.fromEntries(new FormData(form).entries());
        if (!payload.start_date) payload.start_date = null;
        payload.fees = Number(payload.fees || 0);
        try {
            const response = await fetch('/api/training-partner/courses/' + courseId, {
                method: 'PUT',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
                body: JSON.stringify(payload),
            });
            const result = await response.json();
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            if (response.status === 403) { window.location.href = result.data?.approval_status === 'rejected' ? '/training-partner/approval/rejected' : '/training-partner/approval/pending'; return; }
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Course update nahi ho paaya.');
            }
            localStorage.setItem('ofc_selected_training_course_id', result.data.course.id);
            showMessage(result.message || 'Course updated successfully.');
            setTimeout(() => { window.location.href = '/training-partner/courses/show'; }, 700);
        } catch (error) {
            showMessage(error.message || 'Course update nahi ho paaya.', 'error');
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Changes';
        }
    });
    loadCourse();
</script>
@endpush
