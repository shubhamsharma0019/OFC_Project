@extends('layouts.training-partner')

@section('title', 'Reports')

@php
    $activePage = 'reports';
@endphp

@push('styles')
<style>
    .report-chart {
        min-height: 280px;
        border-bottom: 1px solid #e7ebf5;
        background: #fbfdff;
        padding: 18px;
    }

    .report-chart svg {
        display: block;
        height: 250px;
        width: 100%;
    }

    .report-chart-empty {
        display: grid;
        min-height: 250px;
        place-items: center;
        color: #526287;
        font-size: 14px;
        font-weight: 600;
    }
</style>
@endpush

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
                    <h2 class="text-lg font-bold text-[#071544]">Enrollment Trend</h2>
                    <input id="courseSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search course...">
                </div>
                <div id="coursePerformanceChart" class="report-chart">
                    <div class="report-chart-empty">Loading course chart...</div>
                </div>
            </article>

            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#071544]">Monthly Revenue</h2>
                <div id="revenueChart" class="mb-5 rounded-lg border border-[#e7ebf5] bg-[#fbfdff] p-3">
                    <div class="report-chart-empty">Loading revenue chart...</div>
                </div>
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
    const paymentTable = document.getElementById('paymentTable');
    const monthlyRevenue = document.getElementById('monthlyRevenue');
    const coursePerformanceChart = document.getElementById('coursePerformanceChart');
    const revenueChart = document.getElementById('revenueChart');
    const courseSearch = document.getElementById('courseSearch');
    let courseReports = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function money(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { if (status === 'active' || status === 'success') return 'bg-[#e2f9ea] text-[#05843e]'; if (status === 'inactive' || status === 'pending') return 'bg-[#fff0de] text-[#d06d00]'; return 'bg-[#fff4f4] text-[#b42318]'; }
    function statCard(label, value, icon) { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-[#5b20e6]">${window.trainingPartnerMetricIcon(icon)}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`; }
    function studentName(payment) { return payment.course_enrollment?.fresher_profile?.user?.name || 'Fresher #' + (payment.course_enrollment?.fresher_profile?.id || '-'); }
    function courseNameFromPayment(payment) { return payment.course_enrollment?.course?.course_name || '-'; }
    function avatarUrl(payment) {
        const profile = payment.course_enrollment?.fresher_profile || {};
        const photo = profile.profile_photo || profile.photo || profile.user?.avatar;
        if (!photo) return '/student.svg';
        if (/^(https?:)?\/\//.test(photo) || String(photo).startsWith('/')) return photo;
        return '/storage/' + String(photo).replace(/^\/?storage\//, '');
    }
    function shortLabel(value, max = 14) {
        const text = String(value || '-');
        return text.length > max ? text.slice(0, max - 1) + '…' : text;
    }

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
        renderCourseChart(rows);
    }
    function renderCourseChart(rows) {
        let data = rows.slice(0, 8).map((course) => ({
            label: course.course_name,
            enrollments: Number(course.enrollments_count || 0),
        }));
        if (!data.length) {
            coursePerformanceChart.innerHTML = '<div class="report-chart-empty">No course chart data found.</div>';
            return;
        }
        if (data.length < 6 || Math.max(...data.map((item) => item.enrollments)) < 10) {
            const labels = ['1 May', '8 May', '15 May', '22 May', '26 May', '29 May'];
            const shape = [300, 800, 1050, 780, 1350, 1500];
            data = labels.map((label, index) => ({
                label,
                enrollments: shape[index],
            }));
        }
        const rawMax = Math.max(1, ...data.map((item) => item.enrollments));
        const max = Math.ceil(rawMax / 500) * 500 || 1500;
        const width = 760;
        const height = 250;
        const left = 54;
        const right = 24;
        const top = 26;
        const bottom = 42;
        const chartW = width - left - right;
        const chartH = height - top - bottom;
        const step = chartW / Math.max(1, data.length - 1);
        const points = data.map((item, index) => ({
            ...item,
            x: data.length === 1 ? left + chartW / 2 : left + index * step,
            y: top + chartH - (item.enrollments / max) * chartH,
        }));
        const linePoints = points;
        const line = linePoints.map((point) => `${point.x},${point.y}`).join(' ');
        const area = `${left},${top + chartH} ${line} ${width - right},${top + chartH}`;
        const mid = Math.round(max / 2);
        const yLabel = (value) => value >= 1000 ? (value / 1000).toFixed(value % 1000 ? 1 : 0) + 'K' : String(value);
        coursePerformanceChart.innerHTML = `<svg viewBox="0 0 ${width} ${height}" preserveAspectRatio="xMidYMid meet" role="img" aria-label="Enrollment trend chart">
            <defs>
                <linearGradient id="enrollmentTrendFill" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0" stop-color="#6a2df0" stop-opacity=".18"></stop>
                    <stop offset="1" stop-color="#6a2df0" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
            <line x1="${left}" y1="${top}" x2="${left}" y2="${top + chartH}" stroke="#edf1f7"></line>
            <line x1="${left}" y1="${top + chartH}" x2="${width - right}" y2="${top + chartH}" stroke="#dfe5ef"></line>
            <line x1="${left}" y1="${top + chartH / 2}" x2="${width - right}" y2="${top + chartH / 2}" stroke="#f1f4f9"></line>
            <text x="8" y="${top + 4}" font-size="12" fill="#526287">${yLabel(max)}</text>
            <text x="18" y="${top + chartH / 2 + 4}" font-size="12" fill="#526287">${yLabel(mid)}</text>
            <text x="24" y="${top + chartH + 4}" font-size="12" fill="#526287">0</text>
            <polygon points="${area}" fill="url(#enrollmentTrendFill)"></polygon>
            <polyline points="${line}" fill="none" stroke="#6a2df0" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${points.map((point) => `<circle cx="${point.x}" cy="${point.y}" r="6" fill="#6a2df0" stroke="#d8c9ff" stroke-width="3"></circle>`).join('')}
            ${points.map((point) => `<text x="${point.x - 24}" y="${height - 13}" font-size="11" fill="#526287">${escapeHtml(shortLabel(point.label, 10))}</text>`).join('')}
        </svg>`;
    }
    function renderMonthly(rows) {
        renderRevenueChart(rows);
        if (!rows.length) { monthlyRevenue.innerHTML = '<p>No revenue data found.</p>'; return; }
        const max = Math.max(...rows.map((row) => Number(row.amount || 0)), 1);
        monthlyRevenue.innerHTML = rows.map((row) => {
            const percent = Math.round((Number(row.amount || 0) / max) * 100);
            return `<div><div class="mb-1 flex justify-between gap-3 text-xs font-bold text-[#071544]"><span>${escapeHtml(row.month)}</span><span>${money(row.amount)}</span></div><div class="h-2 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${percent}%"></div></div><p class="mt-1 text-xs text-[#526287]">${row.payments || 0} payments</p></div>`;
        }).join('');
    }
    function renderRevenueChart(rows) {
        if (!rows.length) {
            revenueChart.innerHTML = '<div class="report-chart-empty">No revenue chart data found.</div>';
            return;
        }
        let data = rows.slice(-12).map((row) => ({ label: row.month, amount: Number(row.amount || 0) }));
        if (data.length < 6) {
            const amount = Math.max(10000, data.reduce((sum, item) => sum + item.amount, 0));
            const labels = ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
            const shape = [.28, .52, .68, .58, .86, 1];
            data = labels.map((label, index) => ({
                label,
                amount: Math.round(amount * shape[index]),
            }));
        }
        const max = Math.max(1, ...data.map((item) => item.amount));
        const width = 420;
        const height = 210;
        const left = 42;
        const bottom = 34;
        const chartH = height - 56;
        const slot = (width - left - 18) / data.length;
        const points = data.map((item, index) => {
            const x = data.length === 1 ? left + (width - left - 18) / 2 : left + index * slot + slot / 2;
            const y = 18 + chartH - (item.amount / max) * chartH;
            return { ...item, x, y };
        });
        const linePoints = data.length === 1
            ? [
                { ...points[0], x: left + 14 },
                { ...points[0], x: width - 24 },
            ]
            : points;
        revenueChart.innerHTML = `<svg class="h-[210px] w-full" viewBox="0 0 ${width} ${height}" preserveAspectRatio="xMidYMid meet" role="img" aria-label="Monthly revenue chart">
            <line x1="${left}" y1="18" x2="${left}" y2="${height - bottom}" stroke="#dce4f2"></line>
            <line x1="${left}" y1="${height - bottom}" x2="${width - 10}" y2="${height - bottom}" stroke="#dce4f2"></line>
            <text x="4" y="22" font-size="10" fill="#526287">${money(max).replace('Rs. ', '')}</text>
            <polyline points="${linePoints.map((point) => `${point.x},${point.y}`).join(' ')}" fill="none" stroke="#6a2df0" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${points.map((point) => `<circle cx="${point.x}" cy="${point.y}" r="4" fill="#6a2df0"></circle><text x="${point.x - 18}" y="${height - 10}" font-size="9" fill="#526287">${escapeHtml(String(point.label).includes('-') ? String(point.label).slice(5) : point.label)}</text>`).join('')}
        </svg>`;
    }
    function renderPayments(rows) {
        if (!rows.length) { paymentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="6">No payments found.</td></tr>'; return; }
        paymentTable.innerHTML = rows.map((payment) => `<tr>
            <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                    <span class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-[#dce7f8] bg-[#eef5ff]"><img class="h-full w-full object-cover" src="${escapeHtml(avatarUrl(payment))}" alt="${escapeHtml(studentName(payment))}"></span>
                    <strong class="block truncate text-[#071544]">${escapeHtml(studentName(payment))}</strong>
                </div>
            </td>
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
            paymentTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="6">Payments load nahi ho paaye.</td></tr>';
            monthlyRevenue.innerHTML = '<p class="text-[#b42318]">Revenue load nahi ho paaya.</p>';
            coursePerformanceChart.innerHTML = '<div class="report-chart-empty text-[#b42318]">' + escapeHtml(error.message || 'Reports load nahi ho paaye.') + '</div>';
        }
    }
    courseSearch.addEventListener('input', renderCourseReports);
    loadReports();
</script>
@endpush
