@extends('layouts.admin')

@section('title', 'Courses - OnlyFreshers Admin')
@section('pageTitle', 'Courses')
@section('breadcrumb', 'Dashboard > Courses')

@php
    $activePage = 'courses';
@endphp

@push('styles')
<style>
    .admin-courses-page,
    .admin-courses-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }

    @media (max-width: 640px) {
        .admin-courses-page {
            gap: 14px;
        }

        .admin-courses-page #courseStats {
            gap: 12px;
        }

        .admin-courses-page #courseStats article {
            padding: 16px !important;
        }

        .admin-courses-page #courseStats h2 {
            font-size: 24px !important;
            line-height: 1.15 !important;
        }

        .admin-courses-page .admin-courses-toolbar {
            padding: 14px !important;
        }

        .admin-courses-page .admin-courses-filters,
        .admin-courses-page .admin-courses-filters select {
            width: 100%;
        }

        .admin-courses-page .admin-courses-table-wrap {
            overflow: visible !important;
        }

        .admin-courses-page table,
        .admin-courses-page thead,
        .admin-courses-page tbody,
        .admin-courses-page tr,
        .admin-courses-page td {
            display: block;
            width: 100%;
        }

        .admin-courses-page table {
            min-width: 0 !important;
        }

        .admin-courses-page thead {
            display: none;
        }

        .admin-courses-page tbody {
            padding: 10px;
            background: #f7fbff;
        }

        .admin-courses-page tbody tr {
            border: 1px solid #d9e6f8;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 8px 18px rgba(6, 25, 66, .06);
            overflow: hidden;
        }

        .admin-courses-page tbody tr + tr {
            margin-top: 10px;
        }

        .admin-courses-page tbody td {
            display: grid;
            grid-template-columns: minmax(72px, 30%) minmax(0, 1fr);
            gap: 8px;
            align-items: start;
            border-bottom: 0;
            padding: 3px 12px !important;
            color: #1b315b;
            font-size: 10.5px !important;
            line-height: 1.35;
            word-break: break-word;
        }

        .admin-courses-page tbody td:first-child {
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr) auto;
            align-items: center;
            gap: 9px;
            padding-top: 12px !important;
            padding-bottom: 7px !important;
        }

        .admin-courses-page tbody td::before {
            content: attr(data-label);
            color: #061942;
            font-size: 10px;
            font-weight: 600 !important;
            letter-spacing: 0;
            text-transform: none;
        }

        .admin-courses-page tbody td:first-child::before,
        .admin-courses-page tbody td[data-label="Actions"]::before {
            display: none;
        }

        .admin-courses-page .admin-course-avatar {
            display: grid;
            width: 28px;
            height: 28px;
            place-items: center;
            border-radius: 999px;
            background: #eef5ff;
            color: #075fe4;
            font-size: 11px;
            font-weight: 600 !important;
            text-transform: uppercase;
        }

        .admin-courses-page .admin-course-title {
            min-width: 0;
        }

        .admin-courses-page .admin-course-title strong {
            overflow: hidden;
            font-size: 12px !important;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-courses-page .admin-course-title span,
        .admin-courses-page .admin-course-muted {
            overflow: hidden;
            color: #52607a;
            font-size: 9px !important;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-courses-page .admin-course-status {
            border-radius: 4px;
            padding: 4px 7px !important;
            font-size: 9px !important;
            line-height: 1;
        }

        .admin-courses-page tbody td[colspan] {
            display: block;
            padding: 14px !important;
            font-size: 12px !important;
        }

        .admin-courses-page tbody td[colspan]::before {
            display: none;
        }

        .admin-courses-page tbody td[data-label="Actions"] {
            display: block;
            padding: 10px 12px 12px !important;
        }

        .admin-courses-page .admin-course-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            width: 100%;
        }

        .admin-courses-page .admin-course-actions button {
            min-height: 32px;
            width: 100%;
            padding: 7px 8px !important;
            font-size: 10px !important;
        }

        .admin-courses-page .admin-course-actions button:first-child {
            grid-column: 1 / -1;
        }

        .admin-courses-page #pagination {
            gap: 10px;
            padding: 12px !important;
        }

        .admin-courses-page #pagination button {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
    }
</style>
@endpush

@section('content')
    <section class="admin-courses-page grid gap-5">
        <div id="courseStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"><article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading courses...</article></div>
        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="admin-courses-toolbar flex flex-col gap-3 border-b border-[#edf2fb] p-4 lg:flex-row lg:items-center lg:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none lg:max-w-xs" type="search" placeholder="Search course...">
                <div class="admin-courses-filters flex flex-col gap-2 sm:flex-row"><select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Status</option><option value="active">Active</option><option value="inactive">Inactive</option><option value="removed">Removed</option></select><select id="modeFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Modes</option><option value="online">Online</option><option value="offline">Offline</option><option value="hybrid">Hybrid</option></select></div>
            </div>
            <div class="admin-courses-table-wrap overflow-x-auto"><table class="w-full min-w-[1040px] border-collapse text-left text-sm"><thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Course</th><th class="px-5 py-4">Partner</th><th class="px-5 py-4">Mode</th><th class="px-5 py-4">Fee</th><th class="px-5 py-4">Enrollments</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr></thead><tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="7">Loading courses...</td></tr></tbody></table></div>
            <div id="pagination" class="hidden items-center justify-between border-t border-[#edf2fb] p-4 text-sm text-[#52607a]"><button id="prevPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Previous</button><span id="pageInfo" class="font-bold text-[#061942]"></span><button id="nextPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Next</button></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
const token = localStorage.getItem('ofc_auth_token');
const courseStats = document.getElementById('courseStats');
const adminRows = document.getElementById('adminRows');
const adminSearch = document.getElementById('adminSearch');
const statusFilter = document.getElementById('statusFilter');
const modeFilter = document.getElementById('modeFilter');
const pagination = document.getElementById('pagination');
const prevPage = document.getElementById('prevPage');
const nextPage = document.getElementById('nextPage');
const pageInfo = document.getElementById('pageInfo');
let courses = [];
let currentPage = 1;
let lastPage = 1;
let searchTimer = null;
if (!token) window.location.href = '/admin/login';
function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
function money(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
function badgeClass(status) { if (status === 'active') return 'bg-[#e8f8ef] text-[#078346]'; if (status === 'removed') return 'bg-[#fff0f1] text-[#ff1f2f]'; return 'bg-[#fff4df] text-[#b86500]'; }
const statIcons = {
    page: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16h16V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8M8 17h5"></path></svg>',
    active: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h7a3 3 0 0 1 3 3v11a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v11a3 3 0 0 1 3-3h7z"></path><path d="m15 12 2 2 4-5"></path></svg>',
    inactive: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>',
    removed: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 15H6L5 6"></path><path d="M10 11v6M14 11v6"></path></svg>',
};
function statCard(label, value, tone) { const key = label === 'This Page' ? 'page' : label.toLowerCase(); return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[key] || statIcons.page}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`; }
function renderStats() { courseStats.innerHTML = [statCard('This Page', number(courses.length), 'bg-[#eaf2ff] text-[#075fe4]'), statCard('Active', number(courses.filter((i) => i.status === 'active').length), 'bg-[#e8f8ef] text-[#078346]'), statCard('Inactive', number(courses.filter((i) => i.status === 'inactive').length), 'bg-[#fff4df] text-[#b86500]'), statCard('Removed', number(courses.filter((i) => i.status === 'removed').length), 'bg-[#fff0f1] text-[#ff1f2f]')].join(''); }
function renderRows() { renderStats(); if (!courses.length) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="7">No courses found.</td></tr>'; return; } adminRows.innerHTML = courses.map((course) => `<tr><td class="px-5 py-4" data-label="Course"><span class="admin-course-avatar">${escapeHtml(String(course.course_name || 'C').slice(0, 1))}</span><span class="admin-course-title"><strong class="block text-[#061942]">${escapeHtml(course.course_name)}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(course.training_partner_profile?.user?.email || course.category || '-')}</span></span><span class="admin-course-status rounded-md ${badgeClass(course.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(course.status))}</span></td><td class="px-5 py-4" data-label="Partner">${escapeHtml(course.training_partner_profile?.institute_name || '-')}<span class="admin-course-muted mt-1 block text-xs text-[#52607a]">${escapeHtml(course.category || '-')}</span></td><td class="px-5 py-4 capitalize" data-label="Mode">${escapeHtml(statusText(course.training_mode))}<span class="admin-course-muted mt-1 block text-xs text-[#52607a]">${escapeHtml(course.duration || '')}</span></td><td class="px-5 py-4 font-bold text-[#061942]" data-label="Fee">${money(course.fees)}</td><td class="px-5 py-4 font-bold text-[#061942]" data-label="Enrollments">${number(course.enrollments_count)}</td><td class="px-5 py-4" data-label="Starts">${escapeHtml(course.start_date || '-')}</td><td class="px-5 py-4" data-label="Actions"><div class="admin-course-actions flex flex-wrap gap-2"><button class="view-course rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${course.id}">View</button><button class="status-course rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${course.id}" data-status="active">Activate</button><button class="status-course rounded-md border border-[#ff1f2f] px-3 py-2 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${course.id}" data-status="removed">Remove</button></div></td></tr>`).join(''); }
function setPagination(paginator) { currentPage = paginator.current_page || 1; lastPage = paginator.last_page || 1; pageInfo.textContent = 'Page ' + currentPage + ' of ' + lastPage; prevPage.disabled = currentPage <= 1; nextPage.disabled = currentPage >= lastPage; pagination.classList.toggle('hidden', lastPage <= 1); pagination.classList.toggle('flex', lastPage > 1); }
async function requestJson(url, options = {}) { const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } }); if (response.status === 401) { window.location.href = '/admin/login'; return null; } const payload = await response.json(); if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.'); return payload; }
async function loadCourses(page = 1) { try { const params = new URLSearchParams({ page, per_page: 10 }); if (adminSearch.value.trim()) params.set('search', adminSearch.value.trim()); if (statusFilter.value) params.set('status', statusFilter.value); if (modeFilter.value) params.set('training_mode', modeFilter.value); const payload = await requestJson('/api/admin/courses?' + params.toString()); if (!payload) return; const paginator = payload.data?.courses || {}; courses = paginator.data || []; setPagination(paginator); renderRows(); } catch (error) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="7">' + escapeHtml(error.message || 'Courses load nahi ho paaye.') + '</td></tr>'; } }
adminSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadCourses(1), 350); });
statusFilter.addEventListener('change', () => loadCourses(1));
modeFilter.addEventListener('change', () => loadCourses(1));
prevPage.addEventListener('click', () => loadCourses(Math.max(1, currentPage - 1)));
nextPage.addEventListener('click', () => loadCourses(Math.min(lastPage, currentPage + 1)));
adminRows.addEventListener('click', async (event) => { const view = event.target.closest('.view-course'); const status = event.target.closest('.status-course'); if (view?.dataset.id) { localStorage.setItem('ofc_selected_admin_course_id', view.dataset.id); window.location.href = '/admin/courses/show'; return; } if (!status?.dataset.id) return; status.disabled = true; try { await requestJson(`/api/admin/courses/${status.dataset.id}/status`, { method: 'PATCH', body: JSON.stringify({ status: status.dataset.status }) }); await loadCourses(currentPage); } catch (error) { alert(error.message || 'Status update nahi ho paaya.'); status.disabled = false; } });
loadCourses();
</script>
@endpush
