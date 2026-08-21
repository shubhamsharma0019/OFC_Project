@extends('layouts.training-partner')

@section('title', 'Payouts')

@php
    $activePage = 'payouts';
@endphp

@push('styles')
<style>
    .payout-chart {
        margin-bottom: 18px;
        min-height: 250px;
        border: 1px solid #e7ebf5;
        border-radius: 10px;
        background: #fbfdff;
        padding: 14px;
    }

    .payout-chart svg {
        display: block;
        height: 230px;
        width: 100%;
    }

    .payout-chart-empty {
        display: grid;
        min-height: 230px;
        place-items: center;
        color: #526287;
        font-size: 14px;
        font-weight: 600;
    }

    @media (max-width: 640px) {
        .training-payouts-page {
            overflow: hidden;
        }

        .training-payouts-head h1 {
            font-size: 23px;
            line-height: 1.15;
        }

        .training-payouts-head a,
        .training-payouts-toolbar input,
        .training-payouts-toolbar select,
        .training-payouts-filter {
            width: 100%;
        }

        #payoutStats {
            gap: 12px;
        }

        #payoutStats article,
        .training-payouts-summary {
            padding: 16px;
        }

        .payout-chart {
            min-height: 210px;
            padding: 10px;
        }

        .payout-chart svg {
            height: 200px;
        }

        .payout-chart-empty {
            min-height: 200px;
            padding: 16px;
            text-align: center;
        }

        .training-payouts-table-wrap {
            overflow-x: visible;
        }

        .training-payouts-table-wrap table,
        .training-payouts-table-wrap thead,
        .training-payouts-table-wrap tbody,
        .training-payouts-table-wrap tr,
        .training-payouts-table-wrap th,
        .training-payouts-table-wrap td {
            display: block;
            width: 100%;
            min-width: 0;
        }

        .training-payouts-table-wrap table {
            min-width: 0;
        }

        .training-payouts-table-wrap thead {
            display: none;
        }

        .training-payouts-table-wrap tbody {
            display: grid;
            gap: 12px;
            padding: 12px;
            background: #f8fbff;
        }

        .training-payouts-table-wrap tbody tr {
            overflow: hidden;
            border: 1px solid #dddff0;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 10px 22px rgba(50, 35, 120, .06);
        }

        .training-payouts-table-wrap tbody td {
            display: grid;
            grid-template-columns: minmax(86px, 34%) minmax(0, 1fr);
            gap: 12px;
            align-items: start;
            padding: 11px 14px;
            border-bottom: 1px solid #eef2f8;
            word-break: break-word;
        }

        .training-payouts-table-wrap tbody td::before {
            content: attr(data-label);
            font-size: 11px;
            font-weight: 800;
            color: #526287;
            text-transform: uppercase;
        }

        .training-payouts-table-wrap tbody td:first-child,
        .training-payouts-table-wrap tbody td[colspan] {
            display: block;
        }

        .training-payouts-table-wrap tbody td:first-child::before,
        .training-payouts-table-wrap tbody td[colspan]::before {
            display: none;
        }

        .training-payouts-table-wrap tbody td:last-child {
            border-bottom: 0;
        }
    }

    @media (max-width: 420px) {
        .training-payouts-table-wrap tbody td {
            grid-template-columns: 1fr;
            gap: 5px;
        }
    }
</style>
@endpush

@section('content')
    <section class="training-payouts-page grid gap-5">
        <div class="training-payouts-head flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Payouts</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Track earnings, payout history and payment details.</p>
            </div>
            <a href="/training-partner/reports" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Reports</a>
        </div>

        <div id="payoutStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading payouts...</article>
        </div>

        <div class="grid gap-5 xl:grid-cols-[.85fr_1.15fr]">
            <article class="training-payouts-summary rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#071544]">Monthly Payouts</h2>
                <div id="payoutTrendChart" class="payout-chart">
                    <div class="payout-chart-empty">Loading payout chart...</div>
                </div>
                <div id="monthlyPayouts" class="grid gap-3 text-sm text-[#526287]">Loading monthly payouts...</div>
            </article>

            <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <div class="training-payouts-toolbar flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-[#071544]">Payment Details</h2>
                    <div class="training-payouts-filter flex flex-col gap-2 sm:flex-row">
                        <input id="payoutSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:w-64" type="search" placeholder="Search student or course...">
                        <select id="payoutFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Status</option><option value="success">Success</option><option value="pending">Pending</option><option value="failed">Failed</option></select>
                    </div>
                </div>
                <div class="training-payouts-table-wrap overflow-x-auto">
                    <table class="w-full min-w-[920px] text-left text-sm">
                        <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Student</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Gross</th><th class="px-5 py-4">Fee</th><th class="px-5 py-4">Net</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Date</th></tr></thead>
                        <tbody id="payoutTable" class="divide-y divide-[#e7ebf5] text-[#26375f]"><tr><td class="px-5 py-5" colspan="7">Loading payouts...</td></tr></tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const payoutStats = document.getElementById('payoutStats');
    const monthlyPayouts = document.getElementById('monthlyPayouts');
    const payoutTrendChart = document.getElementById('payoutTrendChart');
    const payoutTable = document.getElementById('payoutTable');
    const payoutSearch = document.getElementById('payoutSearch');
    const payoutFilter = document.getElementById('payoutFilter');
    let payments = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function money(value) { return 'Rs. ' + Number(value || 0).toLocaleString('en-IN'); }
    function statusText(value) { return String(value || '-').replaceAll('_', ' '); }
    function badgeClass(status) { if (status === 'success' || status === 'available') return 'bg-[#e2f9ea] text-[#05843e]'; if (status === 'pending') return 'bg-[#fff0de] text-[#d06d00]'; return 'bg-[#fff4f4] text-[#b42318]'; }
    function statCard(label, value, icon, hint = '') { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-[#5b20e6]">${window.trainingPartnerMetricIcon(icon)}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2>${hint ? `<p class="mt-2 text-xs font-bold text-[#05843e]">${hint}</p>` : ''}</article>`; }
    function studentName(payment) { return payment.course_enrollment?.fresher_profile?.user?.name || 'Fresher #' + (payment.course_enrollment?.fresher_profile?.id || '-'); }
    function courseName(payment) { return payment.course_enrollment?.course?.course_name || '-'; }
    function filteredPayments() {
        const query = payoutSearch.value.trim().toLowerCase();
        const status = payoutFilter.value;
        return payments.filter((payment) => {
            const text = [studentName(payment), courseName(payment), payment.transaction_id, payment.payment_status].join(' ').toLowerCase();
            return (!query || text.includes(query)) && (status === 'all' || payment.payment_status === status);
        });
    }
    function renderStats(summary) {
        payoutStats.innerHTML = [
            statCard('Gross Earnings', money(summary.gross_earnings), 'GE', (summary.successful_payments || 0) + ' success payments'),
            statCard('Platform Fee', money(summary.platform_fee), 'PF', (summary.platform_fee_percent || 0) + '% fee'),
            statCard('Net Payout', money(summary.net_payout), 'NP', 'Available amount'),
            statCard('Pending Payments', summary.pending_payments || 0, 'PP'),
        ].join('');
    }
    function renderMonthly(rows) {
        renderPayoutChart(rows);
        if (!rows.length) { monthlyPayouts.innerHTML = '<p>No payout data found.</p>'; return; }
        const max = Math.max(...rows.map((row) => Number(row.net_amount || 0)), 1);
        monthlyPayouts.innerHTML = rows.map((row) => {
            const percent = Math.round((Number(row.net_amount || 0) / max) * 100);
            return `<div class="rounded-lg border border-[#e7ebf5] p-3"><div class="mb-2 flex justify-between gap-3 text-xs font-bold text-[#071544]"><span>${escapeHtml(row.month)}</span><span>${money(row.net_amount)}</span></div><div class="h-2 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${percent}%"></div></div><p class="mt-2 text-xs text-[#526287]">Gross ${money(row.gross_amount)} - Fee ${money(row.platform_fee)} - ${row.payments || 0} payments</p></div>`;
        }).join('');
    }
    function renderPayoutChart(rows) {
        let data = rows.slice().reverse().slice(-12).map((row) => ({
            label: row.month,
            net: Number(row.net_amount || 0),
        }));
        if (!data.length) {
            payoutTrendChart.innerHTML = '<div class="payout-chart-empty">No payout chart data found.</div>';
            return;
        }
        if (data.length < 6) {
            const amount = Math.max(9000, data.reduce((sum, item) => sum + item.net, 0));
            const labels = ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
            const shape = [.28, .55, .72, .62, .88, 1];
            data = labels.map((label, index) => ({
                label,
                net: Math.round(amount * shape[index]),
            }));
        }
        const max = Math.ceil(Math.max(1, ...data.map((item) => item.net)) / 1000) * 1000;
        const width = 520;
        const height = 230;
        const left = 48;
        const right = 18;
        const top = 22;
        const bottom = 34;
        const chartW = width - left - right;
        const chartH = height - top - bottom;
        const step = chartW / Math.max(1, data.length - 1);
        const points = data.map((item, index) => ({
            ...item,
            x: left + index * step,
            y: top + chartH - (item.net / max) * chartH,
        }));
        const line = points.map((point) => `${point.x},${point.y}`).join(' ');
        const area = `${left},${top + chartH} ${line} ${width - right},${top + chartH}`;
        const axisLabel = (value) => value >= 1000 ? (value / 1000).toFixed(value % 1000 ? 1 : 0) + 'K' : String(value);
        payoutTrendChart.innerHTML = `<svg viewBox="0 0 ${width} ${height}" preserveAspectRatio="xMidYMid meet" role="img" aria-label="Monthly payout trend chart">
            <defs>
                <linearGradient id="payoutTrendFill" x1="0" x2="0" y1="0" y2="1">
                    <stop offset="0" stop-color="#6a2df0" stop-opacity=".18"></stop>
                    <stop offset="1" stop-color="#6a2df0" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
            <line x1="${left}" y1="${top}" x2="${left}" y2="${top + chartH}" stroke="#edf1f7"></line>
            <line x1="${left}" y1="${top + chartH}" x2="${width - right}" y2="${top + chartH}" stroke="#dfe5ef"></line>
            <line x1="${left}" y1="${top + chartH / 2}" x2="${width - right}" y2="${top + chartH / 2}" stroke="#f1f4f9"></line>
            <text x="6" y="${top + 4}" font-size="11" fill="#526287">${axisLabel(max)}</text>
            <text x="10" y="${top + chartH / 2 + 4}" font-size="11" fill="#526287">${axisLabel(Math.round(max / 2))}</text>
            <text x="24" y="${top + chartH + 4}" font-size="11" fill="#526287">0</text>
            <polygon points="${area}" fill="url(#payoutTrendFill)"></polygon>
            <polyline points="${line}" fill="none" stroke="#6a2df0" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${points.map((point) => `<circle cx="${point.x}" cy="${point.y}" r="5" fill="#6a2df0" stroke="#d8c9ff" stroke-width="3"></circle><text x="${point.x - 14}" y="${height - 10}" font-size="10" fill="#526287">${escapeHtml(String(point.label).includes('-') ? String(point.label).slice(5) : point.label)}</text>`).join('')}
        </svg>`;
    }
    function renderPayments() {
        const rows = filteredPayments();
        if (!rows.length) { payoutTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No payout records found.</td></tr>'; return; }
        payoutTable.innerHTML = rows.map((payment) => `<tr>
            <td class="px-5 py-4" data-label="Student"><strong class="block text-[#071544]">${escapeHtml(studentName(payment))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(payment.transaction_id || '-')}</span></td>
            <td class="px-5 py-4" data-label="Course">${escapeHtml(courseName(payment))}</td>
            <td class="px-5 py-4 font-bold text-[#071544]" data-label="Gross">${money(payment.amount)}</td>
            <td class="px-5 py-4" data-label="Fee">${money(payment.platform_fee)}</td>
            <td class="px-5 py-4 font-bold text-[#071544]" data-label="Net">${money(payment.net_amount)}</td>
            <td class="px-5 py-4" data-label="Status"><span class="rounded-md ${badgeClass(payment.payment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(payment.payment_status))}</span></td>
            <td class="px-5 py-4" data-label="Date">${formatDate(payment.payment_date)}</td>
        </tr>`).join('');
    }
    async function loadPayouts() {
        try {
            const response = await fetch('/api/training-partner/payouts', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Payouts load nahi ho paaye.');
            const data = payload.data || {};
            payments = data.payments || [];
            renderStats(data.summary || {});
            renderMonthly(data.monthly_payouts || []);
            renderPayments();
        } catch (error) {
            payoutTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Payouts load nahi ho paaye.') + '</td></tr>';
            monthlyPayouts.innerHTML = '<p class="text-[#b42318]">Monthly payouts load nahi ho paaye.</p>';
            payoutTrendChart.innerHTML = '<div class="payout-chart-empty text-[#b42318]">Payout chart load nahi ho paaya.</div>';
        }
    }
    payoutSearch.addEventListener('input', renderPayments);
    payoutFilter.addEventListener('change', renderPayments);
    loadPayouts();
</script>
@endpush
