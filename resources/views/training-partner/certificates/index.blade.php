@extends('layouts.training-partner')

@section('title', 'Certificates')

@php
    $activePage = 'certificates';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Certificates</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Manage and view certificates issued by your institute.</p>
            </div>
            <a href="/training-partner/assessments" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Assessments</a>
        </div>

        <div id="certificateStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 text-sm text-[#526287] shadow-[0_12px_26px_rgba(50,35,120,.05)] sm:col-span-2 xl:col-span-4">Loading certificates...</article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="certificateSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search student, course or certificate...">
                <select id="certificateFilter" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option value="all">All Certificates</option><option value="eligible">Ready to Generate</option><option value="generated">Generated</option><option value="pass">Passed</option><option value="high_score">High Score 80+</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1040px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Certificate</th><th class="px-5 py-4">Student</th><th class="px-5 py-4">Course</th><th class="px-5 py-4">Score</th><th class="px-5 py-4">Completion</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Action</th></tr></thead>
                    <tbody id="certificateTable" class="divide-y divide-[#e7ebf5] text-[#26375f]"><tr><td class="px-5 py-5" colspan="7">Loading certificates...</td></tr></tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_training_partner_token') || localStorage.getItem('ofc_auth_token');
    const certificateStats = document.getElementById('certificateStats');
    const certificateTable = document.getElementById('certificateTable');
    const certificateSearch = document.getElementById('certificateSearch');
    const certificateFilter = document.getElementById('certificateFilter');
    let certificates = [];
    let eligibleAssessments = [];

    if (!token) window.location.href = '/training-partner/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function formatDate(value) { return value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'; }
    function isGenerated(item) { return item.row_type === 'generated'; }
    function resultData(item) { return item.final_assessment_result || item.result || {}; }
    function enrollment(item) { return item.course_enrollment || {}; }
    function profile(item) { return item.fresher_profile || enrollment(item).fresher_profile || {}; }
    function studentName(item) { return profile(item)?.user?.name || 'Fresher #' + (profile(item)?.id || item.id); }
    function studentEmail(item) { return profile(item)?.user?.email || profile(item)?.phone || '-'; }
    function courseName(item) { return enrollment(item)?.course?.course_name || '-'; }
    function score(item) { return Number(resultData(item)?.overall_score || 0); }
    function statCard(label, value, icon) { return `<article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]"><span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">${icon}</span><p class="mt-4 text-xs font-bold text-[#526287]">${label}</p><h2 class="mt-2 text-2xl font-bold text-[#071544]">${value}</h2></article>`; }
    function filteredCertificates() {
        const query = certificateSearch.value.trim().toLowerCase();
        const filter = certificateFilter.value;
        const rows = [...eligibleAssessments, ...certificates];
        return rows.filter((item) => {
            const text = [item.certificate_number, studentName(item), studentEmail(item), courseName(item), resultData(item)?.result, item.row_type].join(' ').toLowerCase();
            const filterOk = filter === 'all'
                || (filter === 'eligible' && !isGenerated(item))
                || (filter === 'generated' && isGenerated(item))
                || (filter === 'pass' && resultData(item)?.result === 'pass')
                || (filter === 'high_score' && score(item) >= 80);
            return (!query || text.includes(query)) && filterOk;
        });
    }
    function renderStats() {
        const rows = [...eligibleAssessments, ...certificates];
        const avg = rows.length ? Math.round(rows.reduce((sum, item) => sum + score(item), 0) / rows.length) : 0;
        certificateStats.innerHTML = [
            statCard('Total Certificates', certificates.length, 'TC'),
            statCard('Ready to Generate', eligibleAssessments.length, 'RG'),
            statCard('High Score 80+', rows.filter((item) => score(item) >= 80).length, 'HS'),
            statCard('Average Score', avg + '%', 'AS'),
        ].join('');
    }
    function renderCertificates() {
        const rows = filteredCertificates();
        renderStats();
        if (!rows.length) { certificateTable.innerHTML = '<tr><td class="px-5 py-5 text-[#526287]" colspan="7">No certificates found.</td></tr>'; return; }
        certificateTable.innerHTML = rows.map((item) => `<tr>
            <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(item.certificate_number || 'Ready to generate')}</strong><span class="mt-1 block text-xs text-[#526287]">${isGenerated(item) ? `Issued ${formatDate(item.created_at)}` : 'Final assessment passed'}</span></td>
            <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(studentName(item))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(studentEmail(item))}</span></td>
            <td class="px-5 py-4"><strong class="block text-[#071544]">${escapeHtml(courseName(item))}</strong><span class="mt-1 block text-xs text-[#526287]">${escapeHtml(enrollment(item)?.course?.training_mode || '')}</span></td>
            <td class="px-5 py-4"><strong class="text-[#071544]">${resultData(item)?.overall_score ?? '-'}</strong><span class="text-xs text-[#526287]"> / 100</span></td>
            <td class="px-5 py-4">${formatDate(item.completion_date || enrollment(item)?.training_progress?.completion_date)}</td>
            <td class="px-5 py-4"><span class="rounded-md ${isGenerated(item) ? 'bg-[#e2f9ea] text-[#05843e]' : 'bg-[#fff0de] text-[#d06d00]'} px-3 py-1 text-xs font-bold">${isGenerated(item) ? 'Generated' : 'Pending'}</span></td>
            <td class="px-5 py-4"><div class="flex flex-wrap gap-2">${isGenerated(item) ? `<button class="view-certificate rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button" data-id="${item.id}">View</button>${item.certificate_url ? `<a class="rounded-md border border-[#cfd8eb] px-3 py-2 text-xs font-bold text-[#26375f]" href="${escapeHtml(item.certificate_url)}" target="_blank" rel="noopener">Open File</a>` : ''}` : `<button class="generate-certificate rounded-md bg-[#5b20e6] px-3 py-2 text-xs font-bold text-white disabled:opacity-60" type="button" data-enrollment-id="${enrollment(item)?.id || item.course_enrollment_id || ''}">Generate</button>`}</div></td>
        </tr>`).join('');
    }
    async function loadCertificates() {
        try {
            const response = await fetch('/api/training-partner/certificates', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (response.status === 403) { window.location.href = '/training-partner/approval/pending'; return; }
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Certificates load nahi ho paaye.');
            certificates = (payload.data?.certificates || []).map((item) => ({ ...item, row_type: 'generated' }));
            const assessmentResponse = await fetch('/api/training-partner/assessments', { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
            const assessmentPayload = await assessmentResponse.json();
            const assessments = assessmentPayload.data?.assessments || [];
            eligibleAssessments = assessments
                .filter((item) => item.result?.result === 'pass' && !item.course_enrollment?.certificate)
                .map((item) => ({
                    ...item,
                    row_type: 'eligible',
                    course_enrollment: item.course_enrollment || {},
                    fresher_profile: item.fresher_profile || item.course_enrollment?.fresher_profile || {},
                }));
            renderCertificates();
        } catch (error) {
            certificateTable.innerHTML = '<tr><td class="px-5 py-5 text-[#b42318]" colspan="7">' + escapeHtml(error.message || 'Certificates load nahi ho paaye.') + '</td></tr>';
        }
    }
    certificateSearch.addEventListener('input', renderCertificates);
    certificateFilter.addEventListener('change', renderCertificates);
    certificateTable.addEventListener('click', (event) => {
        const generate = event.target.closest('.generate-certificate');
        if (generate?.dataset.enrollmentId) {
            generateCertificate(generate);
            return;
        }
        const button = event.target.closest('.view-certificate');
        if (!button?.dataset.id) return;
        localStorage.setItem('ofc_selected_training_certificate_id', button.dataset.id);
        window.location.href = '/training-partner/certificates/show';
    });

    async function generateCertificate(button) {
        button.disabled = true;
        button.textContent = 'Generating...';
        try {
            const response = await fetch(`/api/training-partner/enrollments/${button.dataset.enrollmentId}/certificate`, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
            });
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Certificate generate nahi ho paaya.');
            await loadCertificates();
        } catch (error) {
            alert(error.message || 'Certificate generate nahi ho paaya.');
            button.disabled = false;
            button.textContent = 'Generate';
        }
    }
    loadCertificates();
</script>
@endpush
