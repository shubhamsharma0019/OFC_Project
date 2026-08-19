@extends('layouts.training-partner')

@section('title', 'My Courses')

@php
    $activePage = 'courses';
@endphp

@push('styles')
<style>
    .course-card-list {
        display: grid;
        gap: 14px;
        padding: 16px;
    }

    .course-list-card {
        position: relative;
        display: grid;
        grid-template-columns: 82px minmax(0, 1fr) 240px;
        align-items: center;
        gap: 18px;
        min-height: 118px;
        border: 1px solid #e6e9f4;
        border-radius: 12px;
        background: #ffffff;
        padding: 17px 18px;
        box-shadow: 0 10px 26px rgba(36, 30, 86, 0.05);
        transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }

    .course-list-card:hover {
        transform: translateY(-1px);
        border-color: #d8cdfa;
        box-shadow: 0 16px 34px rgba(36, 30, 86, 0.09);
    }

    .course-card-icon {
        display: inline-flex;
        height: 72px;
        width: 72px;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: #f2eaff;
        color: #6334e8;
    }

    .course-card-title {
        margin: 0;
        color: #071544;
        font-size: 18px;
        line-height: 1.2;
        font-weight: 900 !important;
    }

    .course-card-meta {
        margin-top: 9px;
        color: #526287;
        font-size: 14px;
        line-height: 1.3;
        font-weight: 800 !important;
    }

    .course-card-numbers {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(3, minmax(110px, max-content));
        gap: 42px;
        color: #2d345f;
        font-size: 14px;
        font-weight: 900 !important;
    }

    .course-card-price {
        color: #071544;
        font-size: 16px;
        font-weight: 900 !important;
    }

    .course-card-side {
        display: flex;
        min-height: 94px;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
        gap: 10px;
    }

    .course-card-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 7px;
        width: 100%;
        opacity: 1;
        pointer-events: auto;
        transform: none;
    }

    @media (max-width: 900px) {
        .course-list-card {
            grid-template-columns: 72px minmax(0, 1fr);
        }

        .course-card-side {
            grid-column: 2;
            align-items: flex-start;
        }

        .course-card-actions {
            justify-content: flex-start;
        }

        .course-card-numbers {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }

    @media (max-width: 560px) {
        .course-list-card {
            grid-template-columns: 1fr;
        }

        .course-card-side {
            grid-column: auto;
        }
    }
</style>
@endpush

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
            <div id="courseTable" class="course-card-list">
                <article class="rounded-lg border border-[#e7ebf5] bg-white p-5 text-sm text-[#526287]">Loading courses...</article>
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
    function courseIcon() {
        return '<svg class="h-9 w-9 fill-none stroke-current stroke-[1.8] [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h9l4 4v14H6z"></path><path d="M15 3v5h5"></path><path d="M9 13l2 2 4-5"></path><path d="M9 18h6"></path></svg>';
    }
    function moduleText(course) {
        const modules = course.modules_count || course.lessons_count || course.total_modules;
        const duration = course.duration || '-';
        return (modules ? modules + ' Modules' : 'Course') + ' - ' + duration;
    }
    function enrollmentCount(course) {
        return course.enrollments_count ?? course.total_enrollments ?? 0;
    }
    function completedCount(course) {
        return course.completed_enrollments_count ?? course.completed_trainings_count ?? 0;
    }
    function statCard(label, value, icon) {
        return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-[#5b20e6]">${window.trainingPartnerMetricIcon(icon)}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`;
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
            courseTable.innerHTML = '<article class="rounded-lg border border-[#e7ebf5] bg-white p-5 text-sm text-[#526287]">No courses found.</article>';
            return;
        }
        courseTable.innerHTML = visible.map((course) => `
            <article class="course-list-card">
                <span class="course-card-icon">${courseIcon()}</span>
                <div class="min-w-0">
                    <h3 class="course-card-title truncate">${escapeHtml(course.course_name)}</h3>
                    <p class="course-card-meta">${escapeHtml(moduleText(course))}</p>
                    <div class="course-card-numbers">
                        <p>Enrolled: <span>${escapeHtml(enrollmentCount(course))}</span></p>
                        <p>Completed: <span>${escapeHtml(completedCount(course))}</span></p>
                        <p class="course-card-price">${escapeHtml(formatMoney(course.fees))}</p>
                    </div>
                </div>
                <div class="course-card-side">
                    <span class="inline-flex w-fit rounded-lg ${badgeClass(course.status)} px-4 py-2 text-xs font-black capitalize">${escapeHtml(course.status || '-')}</span>
                    <div class="course-card-actions">
                        <button class="view-course rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button" data-id="${course.id}">View</button>
                        <button class="edit-course rounded-md border border-[#cfd8eb] px-3 py-2 text-xs font-bold text-[#26375f]" type="button" data-id="${course.id}">Edit</button>
                        <select class="status-change h-9 rounded-md border border-[#cfd8eb] px-2 text-xs font-bold" data-id="${course.id}">
                            <option value="active" ${course.status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="inactive" ${course.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            <option value="removed" ${course.status === 'removed' ? 'selected' : ''}>Removed</option>
                        </select>
                    </div>
                </div>
            </article>
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
            courseTable.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm text-[#b42318]">' + escapeHtml(error.message || 'Courses load nahi ho paaye.') + '</article>';
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
        if (index >= 0) {
            courses[index] = {
                ...courses[index],
                ...payload.data.course,
            };
        }
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
