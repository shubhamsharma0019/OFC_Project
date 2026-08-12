@extends('layouts.training-partner')

@section('title', 'Reports')

@php
    $activePage = 'reports';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Reports</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Track and analyze performance of courses, learners and revenue.</p>
            </div>
            <a href="/training-partner/certificates" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Certificates</a>
        </div>

        <div id="reportStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading reports...</article>
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.25fr_.75fr]">
            <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-[#071544]">Course Performance</h2>
                    <input id="courseSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search course...">
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[940px] text-left text-sm">
                        <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Course</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Enrollments</th><th class="px-5 py-4">Paid</th><th class="px-5 py-4">Completed</th><th class="px-5 py-4">Certificates</th><th class="px-5 py-4">Revenue</th></tr></thead>
                        <tbody id="courseReportTable" class="divide-y divide-[#e7ebf5] text-[#26375f]"><tr><td class="px-5 py-5" colspan="7">Loading course reports...</td></tr></tbody>
                    </table>
                </div>
            </article>

            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#071544]">Monthly Revenue</h2>
                <div id="monthlyRevenue" class="grid gap-3 text-sm text-[#526287]">Loading revenue...</div>
            </article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="border-b border-[#e7ebf5] p-4"><h2 class="text-lg font-bold text-[#071544]">Recent Payments</h2></div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Student</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Transaction</th><th class="px-5 py-4">Amount</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Date</th></tr></thead>
                    <tbody id="paymentTable" class="divide-y divide-[#e7ebf5] text-[#26375f]"><tr><td class="px-5 py-5" colspan="6">Loading payments...</td></tr></tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const reportStats = document.getElementById('reportStats');
    const courseReportTable = document.getElementById('courseReportTable');
    const paymentTable = document.getElementById('paymentTable');
    const monthlyRevenue = document.getElementById('monthlyRevenue');
    const courseSearch = document.getElementById('courseSearch');
    let courseReports = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function money(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { if (status === 'active' || status === 'success') return 'bg-[#e2f9ea] text-[#05843e]'; if (status === 'inactive' || status === 'pending') return 'bg-[#fff0de] text-[#d06d00]'; return 'bg-[#fff4f4] text-[#b42318]'; }
    function statCard(label, value, icon) { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">${icon}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`; }
    function studentName(payment) { return payment.course_enrollment?.fresher_profile?.user?.name || 'Fresher #' + (payment.course_enrollment?.fresher_profile?.id || '-'); }
    function courseNameFromPayment(payment) { return payment.course_enrollment?.course?.course_name || '-'; }

    function renderStats(summary) {
        reportStats.innerHTML = [
            statCard('Total Revenue', money(summary.total_revenue), 'TR'),
            statCard('Total Enrollments', summary.total_enrollments || 0, 'TE'),
            statCard('Completed Trainings', summary.completed_trainings || 0, 'CT'),
            statCard('Certificates', summary.certificates || 0, 'CF'),
        ].join('');
    }
    function renderCourseReports() {
        const query = courseSearch.value.trim().toLowerCase();
        const rows = courseReports.filter((course) => !query || [course.course_name, course.category, course.status].join(' ').toLowerCase().includes(query));
        if (!rows.length) { courseReportTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No course reports found.</td></tr>'; return; }
        courseReportTable.innerHTML = rows.map((course) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(course.course_name)}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(course.category || course.training_mode || '')}</span></td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(course.status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(course.status))}</span></td>
            <td class="px-5 py-4 font-bold text-[#071544]">${course.enrollments_count || 0}</td>
            <td class="px-5 py-4">${course.paid_enrollments_count || 0}</td>
            <td class="px-5 py-4">${course.completed_trainings_count || 0}</td>
            <td class="px-5 py-4">${course.certificates_count || 0}</td>
            <td class="px-5 py-4 font-bold text-[#071544]">${money(course.revenue)}</td>
        </tr>`).join('');
    }
    function renderMonthly(rows) {
        if (!rows.length) { monthlyRevenue.innerHTML = '<p>No revenue data found.</p>'; return; }
        const max = Math.max(...rows.map((row) => Number(row.amount || 0)), 1);
        monthlyRevenue.innerHTML = rows.map((row) => {
            const percent = Math.round((Number(row.amount || 0) / max) * 100);
            return `<div><div class="mb-1 flex justify-between gap-3 text-xs font-bold text-[#071544]"><span>${escapeHtml(row.month)}</span><span>${money(row.amount)}</span></div><div class="h-2 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${percent}%"></div></div><p class="mt-1 text-xs text-[#526287]">${row.payments || 0} payments</p></div>`;
        }).join('');
    }
    function renderPayments(rows) {
        if (!rows.length) { paymentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="6">No payments found.</td></tr>'; return; }
        paymentTable.innerHTML = rows.map((payment) => `<tr>
            <td class="px-5 py-4 font-bold text-[#071544]">${escapeHtml(studentName(payment))}</td>
            <td class="px-5 py-4">${escapeHtml(courseNameFromPayment(payment))}</td>
            <td class="px-5 py-4 text-xs text-[#526287]">${escapeHtml(payment.transaction_id || '-')}</td>
            <td class="px-5 py-4 font-bold text-[#071544]">${money(payment.amount)}</td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(payment.payment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(payment.payment_status))}</span></td>
            <td class="px-5 py-4">${formatDate(payment.payment_date)}</td>
        </tr>`).join('');
    }
    async function loadReports() {
        try {
            const response = await fetch('/api/training-partner/reports', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Reports load nahi ho paaye.');
            const data = payload.data || {};
            courseReports = data.course_reports || [];
            renderStats(data.summary || {});
            renderCourseReports();
            renderMonthly(data.monthly_revenue || []);
            renderPayments(data.recent_payments || []);
        } catch (error) {
            courseReportTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Reports load nahi ho paaye.') + '</td></tr>';
            paymentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="6">Payments load nahi ho paaye.</td></tr>';
            monthlyRevenue.innerHTML = '<p class="text-[#b42318]">Revenue load nahi ho paaya.</p>';
        }
    }
    courseSearch.addEventListener('input', renderCourseReports);
    loadReports();
</script>
@endpush
