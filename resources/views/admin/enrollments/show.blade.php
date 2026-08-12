@extends('layouts.admin')

@section('title', 'Enrollment Details - OnlyFreshers Admin')
@section('pageTitle', 'Enrollment Details')
@section('breadcrumb', 'Dashboard > Enrollments > Details')

@php
    $activePage = 'courses';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="enrollmentDetails" class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)]">Loading enrollment details...</div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const enrollmentId = localStorage.getItem('ofc_selected_admin_enrollment_id');
    const enrollmentDetails = document.getElementById('enrollmentDetails');

    if (!token) window.location.href = '/admin/login';
    if (!enrollmentId) window.location.href = '/admin/enrollments';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function label(value) { return String(value || '-').replaceAll('_', ' '); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function currency(value) { return '₹' + number(value); }
    function initials(name) { return String(name || 'OF').trim().split(/\s+/).slice(0, 2).map((part) => part[0] || '').join('').toUpperCase() || 'OF'; }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }); }
    function badgeClass(status) {
        if (status === 'completed' || status === 'paid' || status === 'enrolled') return 'bg-[#e8f8ef] text-[#078346]';
        if (status === 'cancelled' || status === 'failed') return 'bg-[#fff0f1] text-[#ff1f2f]';
        if (status === 'in_progress') return 'bg-[#eaf2ff] text-[#075fe4]';
        return 'bg-[#fff4df] text-[#b86500]';
    }
    function infoRow(labelText, value) {
        return `<div class="rounded-lg border border-[#e4ecf8] bg-[#fbfdff] p-4"><p class="text-xs font-bold text-[#52607a]">${escapeHtml(labelText)}</p><p class="mt-2 font-bold text-[#061942]">${escapeHtml(value || '-')}</p></div>`;
    }
    function statusBadge(status) {
        return `<span class="inline-flex rounded-md ${badgeClass(status)} px-3 py-1 text-xs font-bold capitalize">${escapeHtml(label(status))}</span>`;
    }
    async function requestJson(url) {
        const response = await fetch(url, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    function paymentRows(payments) {
        if (!payments?.length) return '<tr><td class="px-4 py-4 text-[#52607a]" colspan="4">No payment records found.</td></tr>';
        return payments.map((payment) => `<tr>
            <td class="px-4 py-3">${escapeHtml(payment.transaction_id || payment.payment_reference || '-')}</td>
            <td class="px-4 py-3 font-bold text-[#061942]">${escapeHtml(currency(payment.amount || 0))}</td>
            <td class="px-4 py-3">${statusBadge(payment.payment_status || payment.status)}</td>
            <td class="px-4 py-3">${escapeHtml(formatDate(payment.created_at || payment.payment_date))}</td>
        </tr>`).join('');
    }
    function renderEnrollment(enrollment) {
        const profile = enrollment.fresher_profile || {};
        const user = profile.user || {};
        const course = enrollment.course || {};
        const partner = course.training_partner_profile || {};
        const partnerUser = partner.user || {};
        const progress = enrollment.training_progress || {};
        const certificate = enrollment.certificate || {};
        const progressValue = Math.max(0, Math.min(100, Number(progress.progress_percentage || progress.completion_percentage || 0)));

        enrollmentDetails.innerHTML = `
            <div class="flex flex-col gap-4 border-b border-[#edf2fb] pb-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex gap-4">
                    <span class="inline-flex h-16 w-16 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-xl font-black text-[#075fe4]">${escapeHtml(initials(user.name))}</span>
                    <div>
                        <h2 class="text-2xl font-bold text-[#061942]">${escapeHtml(user.name || 'Learner')}</h2>
                        <p class="mt-1 text-sm text-[#52607a]">${escapeHtml(user.email || '-')} ${user.mobile ? '- ' + escapeHtml(user.mobile) : ''}</p>
                        <div class="mt-3 flex flex-wrap gap-2">${statusBadge(enrollment.enrollment_status)} ${statusBadge(enrollment.payment_status)} ${statusBadge(enrollment.training_status)}</div>
                    </div>
                </div>
                <a href="/admin/enrollments" class="inline-flex h-10 w-max items-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]">Back to Enrollments</a>
            </div>

            <div class="mt-5 grid gap-4 lg:grid-cols-4">
                ${infoRow('Enrollment Date', formatDate(enrollment.enrollment_date || enrollment.created_at))}
                ${infoRow('Course Fee', currency(course.fees || 0))}
                ${infoRow('Duration', course.duration)}
                ${infoRow('Training Mode', label(course.training_mode))}
            </div>

            <div class="mt-5 grid gap-5 xl:grid-cols-[1fr_1fr]">
                <article class="rounded-lg border border-[#e4ecf8] p-5">
                    <h3 class="mb-4 text-lg font-bold text-[#061942]">Course & Partner</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        ${infoRow('Course Name', course.course_name)}
                        ${infoRow('Category', course.category)}
                        ${infoRow('Institute', partner.institute_name)}
                        ${infoRow('Partner Email', partnerUser.email)}
                    </div>
                    <p class="mt-4 whitespace-pre-line leading-relaxed text-[#24344f]">${escapeHtml(course.description || 'No course description added.')}</p>
                </article>

                <article class="rounded-lg border border-[#e4ecf8] p-5">
                    <h3 class="mb-4 text-lg font-bold text-[#061942]">Training Progress</h3>
                    <div class="h-3 overflow-hidden rounded-full bg-[#eaf2ff]"><div class="h-full rounded-full bg-[#075fe4]" style="width: ${progressValue}%"></div></div>
                    <p class="mt-2 text-sm font-bold text-[#061942]">${progressValue}% Completed</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        ${infoRow('Current Module', progress.current_module || progress.module_name)}
                        ${infoRow('Last Updated', formatDate(progress.updated_at))}
                        ${infoRow('Certificate', certificate.id ? 'Issued' : 'Not issued')}
                        ${infoRow('Certificate No.', certificate.certificate_number)}
                    </div>
                </article>
            </div>

            <article class="mt-5 overflow-hidden rounded-lg border border-[#e4ecf8]">
                <div class="border-b border-[#edf2fb] p-5"><h3 class="text-lg font-bold text-[#061942]">Payments</h3></div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] border-collapse text-left text-sm">
                        <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-4 py-3">Reference</th><th class="px-4 py-3">Amount</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Date</th></tr></thead>
                        <tbody class="divide-y divide-[#edf2fb]">${paymentRows(enrollment.payments || [])}</tbody>
                    </table>
                </div>
            </article>
        `;
    }
    async function loadEnrollment() {
        try {
            const payload = await requestJson('/api/admin/enrollments/' + enrollmentId);
            if (!payload) return;
            renderEnrollment(payload.data?.enrollment || {});
        } catch (error) {
            enrollmentDetails.innerHTML = '<p class="text-[#ff1f2f]">' + escapeHtml(error.message || 'Enrollment details load nahi ho paayi.') + '</p><a href="/admin/enrollments" class="mt-4 inline-flex h-10 items-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]">Back to Enrollments</a>';
        }
    }
    loadEnrollment();
</script>
@endpush
