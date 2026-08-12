@extends('layouts.training-partner')

@section('title', 'Add Course')

@php
    $activePage = 'add-course';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Add Course</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Create a new course for freshers.</p>
            </div>
            <a href="/training-partner/courses" class="inline-flex h-10 items-center justify-center rounded-md border border-[#5b20e6] px-5 text-sm font-bold text-[#5b20e6]">My Courses</a>
        </div>

        <div id="courseMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <form id="courseForm" class="grid gap-4 lg:grid-cols-2">
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Course Name <span class="text-[#ff3045]">*</span><input name="course_name" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Category<input name="category" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" placeholder="Development, Data Science, Marketing"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Duration <span class="text-[#ff3045]">*</span><input name="duration" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" placeholder="8 Weeks" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Fees <span class="text-[#ff3045]">*</span><input name="fees" type="number" min="0" step="0.01" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" placeholder="4999" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Training Mode <span class="text-[#ff3045]">*</span><select name="training_mode" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required><option value="online">Online</option><option value="offline">Offline</option><option value="hybrid">Hybrid</option></select></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Start Date<input name="start_date" type="date" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Status<select name="status" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"><option value="active">Active</option><option value="inactive">Inactive</option></select></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">Skills Covered<textarea name="skills_covered" class="min-h-24 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none" placeholder="HTML, CSS, JavaScript, React"></textarea></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">Description <span class="text-[#ff3045]">*</span><textarea name="description" class="min-h-32 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none" required></textarea></label>

                <div class="flex justify-end gap-3 lg:col-span-2">
                    <a href="/training-partner/courses" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Cancel</a>
                    <button id="createButton" class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="submit">Create Course</button>
                </div>
            </form>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const form = document.getElementById('courseForm');
    const messageBox = document.getElementById('courseMessage');
    const createButton = document.getElementById('createButton');

    if (!token) window.location.href = '/training-partner/login';

    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }

    async function checkProfileStatus() {
        const response = await fetch('/api/training-partner/profile', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
        const payload = await response.json();
        const profile = payload.data?.profile || null;
        localStorage.setItem('ofc_training_partner_profile', JSON.stringify(profile));
        if (!profile) { window.location.href = '/training-partner/profile/edit'; return; }
        document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: profile }));
        if (profile.approval_status === 'rejected') { window.location.href = '/training-partner/approval/rejected'; return; }
        if (profile.approval_status !== 'approved') { window.location.href = '/training-partner/approval/pending'; }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        createButton.disabled = true;
        createButton.textContent = 'Creating...';

        const payload = Object.fromEntries(new FormData(form).entries());
        if (!payload.start_date) delete payload.start_date;
        payload.fees = Number(payload.fees || 0);

        try {
            const response = await fetch('/api/training-partner/courses', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify(payload),
            });
            const result = await response.json();
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            if (response.status === 403) { window.location.href = result.data?.approval_status === 'rejected' ? '/training-partner/approval/rejected' : '/training-partner/approval/pending'; return; }
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Course create nahi ho paaya.');
            }
            localStorage.setItem('ofc_selected_training_course_id', result.data.course.id);
            showMessage(result.message || 'Course created successfully.');
            setTimeout(() => { window.location.href = '/training-partner/courses'; }, 700);
        } catch (error) {
            showMessage(error.message || 'Course create nahi ho paaya.', 'error');
        } finally {
            createButton.disabled = false;
            createButton.textContent = 'Create Course';
        }
    });

    checkProfileStatus();
</script>
@endpush
