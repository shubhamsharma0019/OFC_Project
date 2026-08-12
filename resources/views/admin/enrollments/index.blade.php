@extends('layouts.admin')

@section('title', 'Enrollments - OnlyFreshers Admin')
@section('pageTitle', 'Enrollments')
@section('breadcrumb', 'Dashboard > Enrollments')

@php
    $activePage = 'courses';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="enrollmentStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading enrollments...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 xl:flex-row xl:items-center xl:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none xl:max-w-xs" type="search" placeholder="Search learner, course or partner...">
                <div class="grid gap-2 sm:grid-cols-3">
                    <select id="enrollmentFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">Enrollment Status</option><option value="pending">Pending</option><option value="enrolled">Enrolled</option><option value="completed">Completed</option><option value="cancelled">Cancelled</option></select>
                    <select id="paymentFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">Payment Status</option><option value="pending">Pending</option><option value="paid">Paid</option><option value="failed">Failed</option></select>
                    <select id="trainingFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">Training Status</option><option value="not_started">Not Started</option><option value="in_progress">In Progress</option><option value="completed">Completed</option></select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1120px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">Learner</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Partner</th><th class="px-5 py-4">Enrollment</th><th class="px-5 py-4">Payment</th><th class="px-5 py-4">Training</th><th class="px-5 py-4">Action</th></tr>
                    </thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        <tr><td class="px-5 py-5" colspan="7">Loading enrollments...</td></tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination" class="hidden items-center justify-between border-t border-[#edf2fb] p-4 text-sm text-[#52607a]">
                <button id="prevPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Previous</button>
                <span id="pageInfo" class="font-bold text-[#061942]"></span>
                <button id="nextPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Next</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const enrollmentStats = document.getElementById('enrollmentStats');
    const adminRows = document.getElementById('adminRows');
    const adminSearch = document.getElementById('adminSearch');
    const enrollmentFilter = document.getElementById('enrollmentFilter');
    const paymentFilter = document.getElementById('paymentFilter');
    const trainingFilter = document.getElementById('trainingFilter');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let enrollments = [];
    let currentPage = 1;
    let lastPage = 1;
    let searchTimer = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function label(value) { return String(value || '-').replaceAll('_', ' '); }
    function initials(name) { return String(name || 'OF').trim().split(/\s+/).slice(0, 2).map((part) => part[0] || '').join('').toUpperCase() || 'OF'; }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }); }
    function badgeClass(status) {
        if (status === 'completed' || status === 'paid' || status === 'enrolled') return 'bg-[#e8f8ef] text-[#078346]';
        if (status === 'cancelled' || status === 'failed') return 'bg-[#fff0f1] text-[#ff1f2f]';
        if (status === 'in_progress') return 'bg-[#eaf2ff] text-[#075fe4]';
        return 'bg-[#fff4df] text-[#b86500]';
    }
    function statCard(labelText, value, tone) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-xs font-black ${tone}">${escapeHtml(labelText.slice(0, 2).toUpperCase())}</span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(labelText)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function renderStats() {
        enrollmentStats.innerHTML = [
            statCard('This Page', number(enrollments.length), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Enrolled', number(enrollments.filter((item) => item.enrollment_status === 'enrolled').length), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Completed', number(enrollments.filter((item) => item.training_status === 'completed' || item.enrollment_status === 'completed').length), 'bg-[#f2e9ff] text-[#6f34ff]'),
            statCard('Paid', number(enrollments.filter((item) => item.payment_status === 'paid').length), 'bg-[#e8f8ef] text-[#078346]'),
        ].join('');
    }
    function renderRows() {
        renderStats();
        if (!enrollments.length) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="7">No enrollments found.</td></tr>';
            return;
        }
        adminRows.innerHTML = enrollments.map((enrollment) => {
            const user = enrollment.fresher_profile?.user || {};
            const course = enrollment.course || {};
            const partner = course.training_partner_profile || {};
            return `<tr>
                <td class="px-5 py-4"><div class="flex items-center gap-3"><span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-sm font-black text-[#075fe4]">${escapeHtml(initials(user.name))}</span><div><strong class="block text-[#061942]">${escapeHtml(user.name || 'Learner')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</span></div></div></td>
                <td class="px-5 py-4"><strong class="block text-[#061942]">${escapeHtml(course.course_name || '-')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(course.category || '-')}</span></td>
                <td class="px-5 py-4">${escapeHtml(partner.institute_name || '-')}<span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(partner.user?.email || '')}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(enrollment.enrollment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(enrollment.enrollment_status))}</span><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(formatDate(enrollment.enrollment_date || enrollment.created_at))}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(enrollment.payment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(enrollment.payment_status))}</span></td>
                <td class="px-5 py-4"><span class="rounded-md ${badgeClass(enrollment.training_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(enrollment.training_status))}</span></td>
                <td class="px-5 py-4"><button class="view-enrollment rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${enrollment.id}">View</button></td>
            </tr>`;
        }).join('');
    }
    function setPagination(paginator) {
        currentPage = paginator.current_page || 1;
        lastPage = paginator.last_page || 1;
        pageInfo.textContent = 'Page ' + currentPage + ' of ' + lastPage;
        prevPage.disabled = currentPage <= 1;
        nextPage.disabled = currentPage >= lastPage;
        pagination.classList.toggle('hidden', lastPage <= 1);
        pagination.classList.toggle('flex', lastPage > 1);
    }
    async function requestJson(url) {
        const response = await fetch(url, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadEnrollments(page = 1) {
        try {
            const params = new URLSearchParams({ page, per_page: 10 });
            if (adminSearch.value.trim()) params.set('search', adminSearch.value.trim());
            if (enrollmentFilter.value) params.set('enrollment_status', enrollmentFilter.value);
            if (paymentFilter.value) params.set('payment_status', paymentFilter.value);
            if (trainingFilter.value) params.set('training_status', trainingFilter.value);
            const payload = await requestJson('/api/admin/enrollments?' + params.toString());
            if (!payload) return;
            const paginator = payload.data?.enrollments || {};
            enrollments = paginator.data || [];
            setPagination(paginator);
            renderRows();
        } catch (error) {
            adminRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="7">' + escapeHtml(error.message || 'Enrollments load nahi ho paaye.') + '</td></tr>';
        }
    }
    adminSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadEnrollments(1), 350); });
    [enrollmentFilter, paymentFilter, trainingFilter].forEach((filter) => filter.addEventListener('change', () => loadEnrollments(1)));
    prevPage.addEventListener('click', () => loadEnrollments(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadEnrollments(Math.min(lastPage, currentPage + 1)));
    adminRows.addEventListener('click', (event) => {
        const view = event.target.closest('.view-enrollment');
        if (!view?.dataset.id) return;
        localStorage.setItem('ofc_selected_admin_enrollment_id', view.dataset.id);
        window.location.href = '/admin/enrollments/show';
    });
    loadEnrollments();
</script>
@endpush
