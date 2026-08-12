@extends('layouts.training-partner')

@section('title', 'Payouts')

@php
    $activePage = 'payouts';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
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
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#071544]">Monthly Payouts</h2>
                <div id="monthlyPayouts" class="grid gap-3 text-sm text-[#526287]">Loading monthly payouts...</div>
            </article>

            <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-[#071544]">Payment Details</h2>
                    <div class="flex flex-col gap-2 sm:flex-row">
                        <input id="payoutSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:w-64" type="search" placeholder="Search student or course...">
                        <select id="payoutFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Status</option><option value="success">Success</option><option value="pending">Pending</option><option value="failed">Failed</option></select>
                    </div>
                </div>
                <div class="overflow-x-auto">
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
    function statCard(label, value, icon, hint = '') { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">${icon}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2>${hint ? `<p class="mt-2 text-xs font-bold text-[#05843e]">${hint}</p>` : ''}</article>`; }
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
        if (!rows.length) { monthlyPayouts.innerHTML = '<p>No payout data found.</p>'; return; }
        const max = Math.max(...rows.map((row) => Number(row.net_amount || 0)), 1);
        monthlyPayouts.innerHTML = rows.map((row) => {
            const percent = Math.round((Number(row.net_amount || 0) / max) * 100);
            return `<div class="rounded-lg border border-[#e7ebf5] p-3"><div class="mb-2 flex justify-between gap-3 text-xs font-bold text-[#071544]"><span>${escapeHtml(row.month)}</span><span>${money(row.net_amount)}</span></div><div class="h-2 overflow-hidden rounded-full bg-[#f0eaff]"><div class="h-full rounded-full bg-[#6a2df0]" style="width:${percent}%"></div></div><p class="mt-2 text-xs text-[#526287]">Gross ${money(row.gross_amount)} - Fee ${money(row.platform_fee)} - ${row.payments || 0} payments</p></div>`;
        }).join('');
    }
    function renderPayments() {
        const rows = filteredPayments();
        if (!rows.length) { payoutTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No payout records found.</td></tr>'; return; }
        payoutTable.innerHTML = rows.map((payment) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(studentName(payment))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(payment.transaction_id || '-')}</span></td>
            <td class="px-5 py-4">${escapeHtml(courseName(payment))}</td>
            <td class="px-5 py-4 font-bold text-[#071544]">${money(payment.amount)}</td>
            <td class="px-5 py-4">${money(payment.platform_fee)}</td>
            <td class="px-5 py-4 font-bold text-[#071544]">${money(payment.net_amount)}</td>
            <td class="px-5 py-4"><span class="rounded-md ${badgeClass(payment.payment_status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(payment.payment_status))}</span></td>
            <td class="px-5 py-4">${formatDate(payment.payment_date)}</td>
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
        }
    }
    payoutSearch.addEventListener('input', renderPayments);
    payoutFilter.addEventListener('change', renderPayments);
    loadPayouts();
</script>
@endpush
