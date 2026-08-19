@extends('layouts.training-partner')

@section('title', 'Enrollments')

@php
    $activePage = 'enrollments';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Enrollments</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View and manage student enrollments in your courses.</p>
            </div>
            <a href="/training-partner/training-progress" class="inline-flex h-10 items-center justify-center rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white">Training Progress</a>
        </div>

        <div id="enrollmentStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading enrollments...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="enrollmentSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search student or course...">
                <select id="trainingFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Training</option><option value="not_started">Not Started</option><option value="in_progress">In Progress</option><option value="completed">Completed</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1040px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Student</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Enrollment</th><th class="px-5 py-4">Payment</th><th class="px-5 py-4">Training</th><th class="px-5 py-4">Progress</th><th class="px-5 py-4">Action</th></tr></thead>
                    <tbody id="enrollmentTable" class="divide-y divide-[#e7ebf5] text-[#26375f]">
                        <tr><td class="px-5 py-5" colspan="7">Loading enrollments...</td></tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token')
        || localStorage.getItem('onlyfreshers_token')
        || localStorage.getItem('training_partner_token')
        || localStorage.getItem('auth_token')
        || localStorage.getItem('token');
    const enrollmentStats = document.getElementById('enrollmentStats');
    const enrollmentTable = document.getElementById('enrollmentTable');
    const enrollmentSearch = document.getElementById('enrollmentSearch');
    const trainingFilter = document.getElementById('trainingFilter');
    let enrollments = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(type, status) {
        if (status === 'paid' || status === 'completed' || status === 'enrolled') return 'bg-[#e2f9ea] text-[#05843e]';
        if (status === 'in_progress') return 'bg-[#eaf2ff] text-[#075fe4]';
        if (status === 'pending' || status === 'not_started') return 'bg-[#fff0de] text-[#d06d00]';
        return 'bg-[#fff4f4] text-[#b42318]';
    }
    function studentName(enrollment) { return enrollment.fresher_profile?.user?.name || 'Fresher #' + (enrollment.fresher_profile?.id || enrollment.id); }
    function studentEmail(enrollment) { return enrollment.fresher_profile?.user?.email || enrollment.fresher_profile?.phone || '-'; }
    function progressPercent(enrollment) { return enrollment.training_progress?.progress_percentage ?? (enrollment.training_status === 'completed' ? 100 : 0); }
    function avatarUrl(enrollment) {
        const photo = enrollment.fresher_profile?.profile_photo || enrollment.fresher_profile?.photo || enrollment.fresher_profile?.user?.avatar;
        if (!photo) return '/student.svg';
        if (/^(https?:)?\/\//.test(photo) || String(photo).startsWith('/')) return photo;
        return '/storage/' + String(photo).replace(/^\/?storage\//, '');
    }
    function statCard(label, value, icon) {
        return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-[#5b20e6]">${window.trainingPartnerMetricIcon(icon)}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`;
    }
    function filteredEnrollments() {
        const query = enrollmentSearch.value.trim().toLowerCase();
        const training = trainingFilter.value;
        return enrollments.filter((enrollment) => {
            const text = [studentName(enrollment), studentEmail(enrollment), enrollment.course?.course_name, enrollment.enrollment_status, enrollment.payment_status, enrollment.training_status].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (training === 'all' || enrollment.training_status === training);
        });
    }
    function renderStats() {
        enrollmentStats.innerHTML = [
            statCard('Total Enrollments', enrollments.length, 'TE'),
            statCard('In Progress', enrollments.filter((item) => item.training_status === 'in_progress').length, 'IP'),
            statCard('Completed', enrollments.filter((item) => item.training_status === 'completed').length, 'CP'),
            statCard('Not Started', enrollments.filter((item) => item.training_status === 'not_started').length, 'NS'),
        ].join('');
    }
    function renderEnrollments() {
        const visible = filteredEnrollments();
        renderStats();
        if (!visible.length) {
            enrollmentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No enrollments found.</td></tr>';
            return;
        }
        enrollmentTable.innerHTML = visible.map((enrollment) => {
            const progress = progressPercent(enrollment);
            return `
                <tr>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-[#dce7f8] bg-[#eef5ff]"><img class="h-full w-full object-cover" src="${escapeHtml(avatarUrl(enrollment))}" alt="${escapeHtml(studentName(enrollment))}"></span>
                            <span class="min-w-0"><strong class="block truncate text-[#071544]">${escapeHtml(studentName(enrollment))}</strong><span class="mt-1 block truncate text-xs text-[#526287]">${escapeHtml(studentEmail(enrollment))}</span></span>
                        </div>
                    </td>
                    <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(enrollment.course?.course_name || '-')}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(enrollment.course?.training_mode || '')}</span></td>
                    <td class="px-5 py-4"><span class="rounded-md ${badgeClass('enrollment', enrollment.enrollment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(enrollment.enrollment_status))}</span><span class="mt-2 block text-xs text-[#526287]">${formatDate(enrollment.enrollment_date)}</span></td>
                    <td class="px-5 py-4"><span class="rounded-md ${badgeClass('payment', enrollment.payment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(enrollment.payment_status))}</span></td>
                    <td class="px-5 py-4"><span class="rounded-md ${badgeClass('training', enrollment.training_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(enrollment.training_status))}</span></td>
                    <td class="px-5 py-4"><div class="mb-1 flex justify-between text-xs font-bold"><span>${progress}%</span></div><div class="h-2 w-28 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${progress}%"></div></div></td>
                    <td class="px-5 py-4"><div class="flex flex-wrap gap-2"><button class="view-enrollment rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button" data-id="${enrollment.id}">View</button><button class="progress-enrollment rounded-md border border-[#cfd8eb] px-3 py-2 text-xs font-bold text-[#26375f] disabled:cursor-not-allowed disabled:opacity-50" type="button" data-id="${enrollment.id}" data-payment="${escapeHtml(enrollment.payment_status)}" ${enrollment.payment_status !== 'paid' ? 'disabled title="Payment pending"' : ''}>Progress</button></div></td>
                </tr>
            `;
        }).join('');
    }
    async function loadEnrollments() {
        try {
            const response = await fetch('/api/training-partner/enrollments', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Enrollments load nahi ho paaye.');
            enrollments = payload.data?.enrollments || [];
            renderEnrollments();
        } catch (error) {
            enrollmentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Enrollments load nahi ho paaye.') + '</td></tr>';
        }
    }
    enrollmentSearch.addEventListener('input', renderEnrollments);
    trainingFilter.addEventListener('change', renderEnrollments);
    enrollmentTable.addEventListener('click', (event) => {
        const view = event.target.closest('.view-enrollment');
        const progress = event.target.closest('.progress-enrollment');
        const id = view?.dataset.id || progress?.dataset.id;
        if (!id) return;
        if (progress && progress.dataset.payment !== 'paid') {
            alert('Payment complete hone ke baad training progress update hoga.');
            return;
        }
        localStorage.setItem('ofc_selected_training_enrollment_id', id);
        window.location.href = view ? '/training-partner/enrollments/show' : '/training-partner/progress/edit';
    });
    loadEnrollments();
</script>
@endpush
