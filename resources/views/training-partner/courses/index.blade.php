@extends('layouts.training-partner')

@section('title', 'My Courses')

@php
    $activePage = 'courses';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">My Courses</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Manage and organize all your published courses.</p>
            </div>
            <a href="/training-partner/add-course" class="inline-flex h-10 items-center justify-center rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white">Add Course</a>
        </div>

        <div id="courseStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading courses...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="courseSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search courses...">
                <select id="statusFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Status</option><option value="active">Active</option><option value="inactive">Inactive</option><option value="removed">Removed</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[980px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Course</th><th class="px-5 py-4">Category</th><th class="px-5 py-4">Mode</th><th class="px-5 py-4">Fees</th><th class="px-5 py-4">Start Date</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Action</th></tr></thead>
                    <tbody id="courseTable" class="divide-y divide-[#e7ebf5] text-[#26375f]">
                        <tr><td class="px-5 py-5" colspan="7">Loading courses...</td></tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const courseStats = document.getElementById('courseStats');
    const courseTable = document.getElementById('courseTable');
    const courseSearch = document.getElementById('courseSearch');
    const statusFilter = document.getElementById('statusFilter');
    let courses = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"']/g, (character) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[character]);
    }
    function formatMoney(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function badgeClass(status) {
        if (status === 'active') return 'bg-[#e2f9ea] text-[#05843e]';
        if (status === 'inactive') return 'bg-[#fff0de] text-[#d06d00]';
        return 'bg-[#f2f4f7] text-[#344054]';
    }
    function statCard(label, value, icon) {
        return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">${icon}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`;
    }
    function filteredCourses() {
        const query = courseSearch.value.trim().toLowerCase();
        const status = statusFilter.value;
        return courses.filter((course) => {
            const text = [course.course_name, course.category, course.training_mode, course.status, course.skills_covered].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (status === 'all' || course.status === status);
        });
    }
    function renderStats() {
        courseStats.innerHTML = [
            statCard('Total Courses', courses.length, 'TC'),
            statCard('Active', courses.filter((course) => course.status === 'active').length, 'AC'),
            statCard('Inactive', courses.filter((course) => course.status === 'inactive').length, 'IN'),
            statCard('Removed', courses.filter((course) => course.status === 'removed').length, 'RM'),
        ].join('');
    }
    function renderCourses() {
        const visible = filteredCourses();
        renderStats();
        if (!visible.length) {
            courseTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No courses found.</td></tr>';
            return;
        }
        courseTable.innerHTML = visible.map((course) => `
            <tr>
                <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(course.course_name)}</strong><span class="mt-1 block max-w-[300px] truncate text-xs text-[#526287]">${escapeHtml(course.description)}</span></td>
                <td class="px-5 py-4">${escapeHtml(course.category || '-')}</td>
                <td class="px-5 py-4 capitalize">${escapeHtml(course.training_mode || '-')}</td>
                <td class="px-5 py-4 font-bold text-[#071544]">${formatMoney(course.fees)}</td>
                <td class="px-5 py-4">${formatDate(course.start_date)}</td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(course.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(course.status)}</span></td>
                <td class="px-5 py-4">
                    <div class="flex flex-wrap gap-2">
                        <button class="view-course rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button" data-id="${course.id}">View</button>
                        <button class="edit-course rounded-md border border-[#cfd8eb] px-3 py-2 text-xs font-bold text-[#26375f]" type="button" data-id="${course.id}">Edit</button>
                        <select class="status-change rounded-md border border-[#cfd8eb] px-2 py-2 text-xs font-bold" data-id="${course.id}">
                            <option value="active" ${course.status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="inactive" ${course.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            <option value="removed" ${course.status === 'removed' ? 'selected' : ''}>Removed</option>
                        </select>
                    </div>
                </td>
            </tr>
        `).join('');
    }
    async function loadCourses() {
        try {
            const response = await fetch('/api/training-partner/courses', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = payload.data?.approval_status === 'rejected' ? '/training-partner/approval/rejected' : '/training-partner/approval/pending'; return; }
            if (response.status === 422) { window.location.href = '/training-partner/profile/edit'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Courses load nahi ho paaye.');
            courses = payload.data?.courses || [];
            renderCourses();
        } catch (error) {
            courseTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Courses load nahi ho paaye.') + '</td></tr>';
        }
    }
    async function updateStatus(id, status) {
        const response = await fetch('/api/training-partner/courses/' + id + '/status', {
            method: 'PATCH',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
            body: JSON.stringify({ status }),
        });
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Status update nahi ho paaya.');
        const index = courses.findIndex((course) => String(course.id) === String(id));
        if (index >= 0) courses[index] = payload.data.course;
        renderCourses();
    }
    courseSearch.addEventListener('input', renderCourses);
    statusFilter.addEventListener('change', renderCourses);
    courseTable.addEventListener('click', (event) => {
        const viewButton = event.target.closest('.view-course');
        const editButton = event.target.closest('.edit-course');
        if (viewButton) { localStorage.setItem('ofc_selected_training_course_id', viewButton.dataset.id); window.location.href = '/training-partner/courses/show'; }
        if (editButton) { localStorage.setItem('ofc_selected_training_course_id', editButton.dataset.id); window.location.href = '/training-partner/courses/edit'; }
    });
    courseTable.addEventListener('change', async (event) => {
        const select = event.target.closest('.status-change');
        if (!select) return;
        select.disabled = true;
        try { await updateStatus(select.dataset.id, select.value); } catch (error) { alert(error.message); loadCourses(); }
        finally { select.disabled = false; }
    });
    loadCourses();
</script>
@endpush
