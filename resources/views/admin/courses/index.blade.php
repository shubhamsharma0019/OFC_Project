@extends('layouts.admin')

@section('title', 'Courses - OnlyFreshers Admin')
@section('pageTitle', 'Courses')
@section('breadcrumb', 'Dashboard > Courses')

@php
    $activePage = 'courses';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="courseStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"><article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading courses...</article></div>
        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 lg:flex-row lg:items-center lg:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none lg:max-w-xs" type="search" placeholder="Search course...">
                <div class="flex flex-col gap-2 sm:flex-row"><select id="statusFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Status</option><option value="active">Active</option><option value="inactive">Inactive</option><option value="removed">Removed</option></select><select id="modeFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">All Modes</option><option value="online">Online</option><option value="offline">Offline</option><option value="hybrid">Hybrid</option></select></div>
            </div>
            <div class="overflow-x-auto"><table class="w-full min-w-[1040px] border-collapse text-left text-sm"><thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Course</th><th class="px-5 py-4">Partner</th><th class="px-5 py-4">Mode</th><th class="px-5 py-4">Fee</th><th class="px-5 py-4">Enrollments</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr></thead><tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]"><tr><td class="px-5 py-5" colspan="7">Loading courses...</td></tr></tbody></table></div>
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
function statCard(label, value, tone) { return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-xs font-black ${tone}">${escapeHtml(label.slice(0, 2).toUpperCase())}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`; }
function renderStats() { courseStats.innerHTML = [statCard('This Page', number(courses.length), 'bg-[#eaf2ff] text-[#075fe4]'), statCard('Active', number(courses.filter((i) => i.status === 'active').length), 'bg-[#e8f8ef] text-[#078346]'), statCard('Inactive', number(courses.filter((i) => i.status === 'inactive').length), 'bg-[#fff4df] text-[#b86500]'), statCard('Removed', number(courses.filter((i) => i.status === 'removed').length), 'bg-[#fff0f1] text-[#ff1f2f]')].join(''); }
function renderRows() { renderStats(); if (!courses.length) { adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="7">No courses found.</td></tr>'; return; } adminRows.innerHTML = courses.map((course) => `<tr><td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(course.course_name)}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(course.category || '-')} - Starts ${escapeHtml(course.start_date || '-')}</span></td><td class="px-5 py-4">${escapeHtml(course.training_partner_profile?.institute_name || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(course.training_partner_profile?.user?.email || '')}</span></td><td class="px-5 py-4 capitalize">${escapeHtml(statusText(course.training_mode))}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(course.duration || '')}</span></td><td class="px-5 py-4 font-bold text-[#061942]">${money(course.fees)}</td><td class="px-5 py-4 font-bold text-[#061942]">${number(course.enrollments_count)}</td><td class="px-5 py-4"><span class="rounded-md ${badgeClass(course.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(course.status))}</span></td><td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-course rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${course.id}">View</button><button class="status-course rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${course.id}" data-status="active">Activate</button><button class="status-course rounded-md border border-[#ff1f2f] px-3 py-2 text-xs font-bold text-[#ff1f2f]" type="button" data-id="${course.id}" data-status="removed">Remove</button></div></td></tr>`).join(''); }
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
