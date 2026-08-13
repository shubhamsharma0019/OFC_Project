@extends('layouts.fast-track')

@section('title', 'Certificate')

@php
    $activePage = 'certificate';
@endphp

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Certificate</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">View and download your earned certificates.</p>
            </div>
            <a class="inline-flex h-[42px] items-center justify-center rounded-md border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" href="/fast-track/courses">Browse Courses</a>
        </div>

        <div id="certificateStats" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-semibold text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2 xl:col-span-4">Loading certificates...</article>
        </div>

        <div class="flex gap-8 overflow-x-auto border-b border-[#dce7f8]">
            <button id="earnedTab" class="shrink-0 border-b-[3px] border-[#075fe4] px-6 pb-3 text-sm font-bold text-[#075fe4]" type="button" data-filter="earned">Earned Certificates</button>
            <button id="progressTab" class="shrink-0 border-b-[3px] border-transparent px-6 pb-3 text-sm font-bold text-[#334b83]" type="button" data-filter="progress">In Progress</button>
        </div>

        <div id="certificateList" class="space-y-5">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center text-sm font-semibold text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)]">Loading certificates...</article>
        </div>

        <article class="flex flex-col gap-5 rounded-lg border border-[#cfe0ff] bg-[#eaf2ff] p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-5">
                <span class="grid h-[62px] w-[62px] shrink-0 place-items-center rounded-xl bg-white text-[#075fe4] [&>svg]:h-7 [&>svg]:w-7 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]"><svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3Z"></path><path d="M9 8h6M9 12h6"></path></svg></span>
                <div>
                    <h3 class="mb-2 text-lg font-bold text-[#061942]">Complete more courses to earn more certificates!</h3>
                    <p class="text-sm text-[#334b83]">Enhance your skills and boost your career opportunities.</p>
                </div>
            </div>
            <a class="inline-flex h-[42px] items-center justify-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" href="/fast-track/courses">Browse Courses &gt;</a>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const certificateStats = document.getElementById('certificateStats');
    const certificateList = document.getElementById('certificateList');
    const earnedTab = document.getElementById('earnedTab');
    const progressTab = document.getElementById('progressTab');
    let certificateRows = [];
    let enrollmentRows = [];
    let activeFilter = 'earned';
    const certificateIcons = {
        certificate: '<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3Z"></path><path d="M9 8h6M9 12h6"></path></svg>',
        completed: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>',
        latest: '<svg viewBox="0 0 24 24"><path d="M12 8v5l3 2"></path><circle cx="12" cy="12" r="9"></circle></svg>',
        progress: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',
        date: '<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"></rect><path d="M8 2v4M16 2v4M3 10h18"></path></svg>',
        id: '<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="14" rx="2"></rect><path d="M8 10h8M8 14h5"></path></svg>',
        score: '<svg viewBox="0 0 24 24"><path d="M12 3 4 7v6c0 5 3.5 7.5 8 8 4.5-.5 8-3 8-8V7l-8-4Z"></path><path d="m9 12 2 2 4-5"></path></svg>',
        seal: '<svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"></circle><path d="M8.5 13 7 22l5-3 5 3-1.5-9"></path></svg>',
    };

    function certificateIcon(name, size = 'h-[54px] w-[54px]') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-xl bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${certificateIcons[name] || certificateIcons.certificate}</span>`;
    }

    function certificateCourse(certificate) {
        return certificate.course || certificate.course_enrollment?.course || certificate.enrollment?.course || {};
    }

    function certificateProgress(certificate) {
        return certificate.course_enrollment?.training_progress || certificate.enrollment?.training_progress || {};
    }

    function renderStatCard(icon, label, value, hint) {
        return `<article class="grid grid-cols-[60px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            ${certificateIcon(icon)}
            <div class="min-w-0">
                <h2 class="mb-1 text-2xl font-bold text-[#061942]">${FastTrack.esc(value)}</h2>
                <p class="mb-1 text-sm font-medium text-[#334b83]">${FastTrack.esc(label)}</p>
                <small class="text-xs text-[#334b83]">${FastTrack.esc(hint)}</small>
            </div>
        </article>`;
    }

    function renderStats() {
        const completedEnrollments = enrollmentRows.filter((item) => String(item.enrollment_status || '').toLowerCase() === 'completed').length;
        const progressAverage = enrollmentRows.length
            ? Math.round(enrollmentRows.reduce((sum, item) => sum + FastTrack.progress(item), 0) / enrollmentRows.length)
            : 0;
        const latestCertificate = certificateRows[0] ? FastTrack.date(certificateRows[0].issued_at || certificateRows[0].created_at) : '-';

        certificateStats.innerHTML = [
            renderStatCard('certificate', 'Certificates Earned', certificateRows.length, 'Generated after final assessment'),
            renderStatCard('completed', 'Courses Completed', completedEnrollments, 'Fast Track completions'),
            renderStatCard('latest', 'Latest Certificate', latestCertificate, 'Most recent issue date'),
            renderStatCard('progress', 'Overall Progress', progressAverage + '%', 'Across enrolled courses'),
        ].join('');
    }

    function renderTabs() {
        const activeClasses = 'border-[#075fe4] text-[#075fe4]';
        const inactiveClasses = 'border-transparent text-[#334b83]';
        earnedTab.className = `shrink-0 border-b-[3px] px-6 pb-3 text-sm font-bold ${activeFilter === 'earned' ? activeClasses : inactiveClasses}`;
        progressTab.className = `shrink-0 border-b-[3px] px-6 pb-3 text-sm font-bold ${activeFilter === 'progress' ? activeClasses : inactiveClasses}`;
    }

    function renderCertificateCard(certificate) {
        const course = certificateCourse(certificate);
        const progress = certificateProgress(certificate);
        const courseName = FastTrack.courseName(course);
        const studentName = certificate.fresher_profile?.user?.name || FastTrack.user().name || 'Student';
        const issueDate = certificate.issued_at || certificate.created_at;
        const score = certificate.final_assessment_result?.overall_score || certificate.final_assessment_result?.score || '-';
        const certificateUrl = certificate.certificate_url || certificate.file_url || '';

        return `<article class="grid gap-7 rounded-lg border border-[#dce7f8] bg-white p-2 shadow-[0_10px_24px_rgba(6,25,66,.04)] xl:grid-cols-[1.08fr_1fr]">
            <div class="relative min-h-[350px] overflow-hidden border border-[#d7b15f] bg-white p-7 text-center">
                <div class="absolute -right-24 -top-24 h-[170px] w-[170px] rotate-45 border-[28px] border-b-transparent border-l-transparent border-r-[#d7a63b] border-t-[#07306e]"></div>
                <div class="absolute -bottom-24 -left-24 h-[170px] w-[170px] rotate-45 border-[28px] border-b-[#d7a63b] border-l-[#07306e] border-r-transparent border-t-transparent"></div>
                <div class="mx-auto mb-4 text-lg font-black text-[#075fe4]">OnlyFreshers</div>
                <h2 class="my-2 font-serif text-[30px] tracking-[5px] text-[#061942]">CERTIFICATE</h2>
                <h3 class="mb-5 font-serif text-lg tracking-[4px] text-[#061942]">OF COMPLETION</h3>
                <p class="text-sm text-[#334b83]">This is to certify that</p>
                <div class="my-4 inline-block max-w-full border-b border-[#d7a63b] px-10 pb-2 font-serif text-[32px] italic text-[#061942] max-sm:px-4 max-sm:text-2xl">${FastTrack.esc(studentName)}</div>
                <p class="text-sm text-[#334b83]">has successfully completed the course</p>
                <div class="my-3 text-lg font-black text-[#061942]">${FastTrack.esc(courseName)}</div>
                <p class="text-sm text-[#334b83]">and has demonstrated the required skills and knowledge.</p>
                <div class="mx-auto mt-5 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#d7a63b] text-white [&>svg]:h-8 [&>svg]:w-8 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${certificateIcons.seal}</div>
                <div class="mt-7 flex justify-around gap-4 text-xs text-[#334b83]"><span>${FastTrack.date(issueDate)}<br>Date</span><span>Authorized Signatory<br>OnlyFreshers</span></div>
            </div>
            <div class="p-5">
                <span class="inline-flex rounded-md bg-[#e2f9ea] px-3 py-1.5 text-xs font-bold text-[#05843e]">Verified</span>
                <h2 class="mt-5 text-[22px] font-bold text-[#061942]">${FastTrack.esc(courseName)}</h2>
                <p class="mt-2 max-w-xl text-sm leading-7 text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                <div class="my-6 grid gap-4">
                    ${infoRow('date', 'Date Earned', FastTrack.date(issueDate))}
                    ${infoRow('id', 'Certificate ID', certificate.certificate_number || certificate.id)}
                    ${infoRow('score', 'Final Score', score === '-' ? '-' : score + '%')}
                    ${infoRow('progress', 'Training Progress', (progress.progress_percentage || 100) + '%')}
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <button class="download-certificate h-[42px] rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white hover:bg-[#064fc0]" type="button" data-certificate-id="${FastTrack.esc(certificate.id)}">Download</button>
                    ${certificateUrl ? `<a class="inline-flex h-[42px] items-center justify-center rounded-md border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" href="${FastTrack.esc(certificateUrl)}" target="_blank" rel="noopener">Open</a>` : ''}
                </div>
            </div>
        </article>`;
    }

    function infoRow(icon, label, value) {
        return `<div class="grid grid-cols-[28px_150px_minmax(0,1fr)] items-center gap-3 text-sm text-[#334b83] max-sm:grid-cols-[28px_minmax(0,1fr)]">
            ${certificateIcon(icon, 'h-7 w-7 rounded-lg')}
            <span>${FastTrack.esc(label)}</span>
            <strong class="break-words font-semibold text-[#061942] max-sm:col-start-2">${FastTrack.esc(value || '-')}</strong>
        </div>`;
    }

    function renderProgressCard(enrollment) {
        const course = enrollment.course || {};
        const progress = FastTrack.progress(enrollment);
        const isCompleted = String(enrollment.enrollment_status || '').toLowerCase() === 'completed';

        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="min-w-0">
                    <span class="mb-3 inline-flex rounded-md ${isCompleted ? 'bg-[#e2f9ea] text-[#05843e]' : 'bg-[#fff0de] text-[#d06d00]'} px-3 py-1.5 text-xs font-bold">${isCompleted ? 'Ready For Certificate' : 'In Progress'}</span>
                    <h2 class="text-xl font-bold text-[#061942]">${FastTrack.esc(FastTrack.courseName(course))}</h2>
                    <p class="mt-2 text-sm leading-7 text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                </div>
                <a class="inline-flex h-10 shrink-0 items-center justify-center rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" href="${isCompleted ? '/fast-track/final-assessment' : '/fast-track/training-progress'}">${isCompleted ? 'Final Assessment' : 'Continue Training'}</a>
            </div>
            <div class="mt-5 h-3 overflow-hidden rounded-full bg-[#eaf2ff]"><div class="h-full rounded-full bg-[#075fe4]" style="width:${Math.max(0, Math.min(100, progress))}%"></div></div>
            <p class="mt-2 text-xs font-bold text-[#334b83]">${progress}% completed</p>
        </article>`;
    }

    function renderList() {
        renderTabs();
        if (activeFilter === 'progress') {
            const pending = enrollmentRows.filter((item) => !certificateRows.some((certificate) => Number(certificate.course_enrollment_id) === Number(item.id)));
            certificateList.innerHTML = pending.length
                ? pending.map(renderProgressCard).join('')
                : FastTrack.emptyState('No courses in progress', 'Enroll in a Fast Track course to start working toward a certificate.', '/fast-track/courses', 'Browse Courses');
            return;
        }

        certificateList.innerHTML = certificateRows.length
            ? certificateRows.map(renderCertificateCard).join('')
            : FastTrack.emptyState('Certificate not generated yet', 'Complete training and pass the final assessment to generate your Fast Track certificate.', '/fast-track/final-assessment', 'Final Assessment');

        certificateList.querySelectorAll('.download-certificate').forEach(function (button) {
            button.addEventListener('click', downloadCertificate);
        });
    }

    async function downloadCertificate(event) {
        const button = event.currentTarget;
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Downloading...';
        try {
            const response = await fetch('/api/fresher/certificates/' + button.dataset.certificateId + '/download', {
                headers: { Authorization: 'Bearer ' + FastTrack.token(), Accept: '*/*' },
            });
            if (!response.ok) throw new Error('Certificate download nahi ho paaya.');
            const blob = await response.blob();
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'certificate';
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(url);
        } catch (error) {
            alert(error.message || 'Certificate download nahi ho paaya.');
        } finally {
            button.disabled = false;
            button.textContent = originalText;
        }
    }

    function loadCertificates() {
        Promise.all([
            FastTrack.getJson('/api/fresher/certificates'),
            FastTrack.enrollments().catch(function () { return []; }),
        ]).then(function ([certificateResult, enrollments]) {
            certificateRows = FastTrack.apiData(certificateResult, 'certificates') || [];
            enrollmentRows = Array.isArray(enrollments) ? enrollments : [];
            renderStats();
            renderList();
        }).catch(function (error) {
            certificateStats.innerHTML = '';
            certificateList.innerHTML = FastTrack.emptyState('Certificates load nahi ho paaye', error.message || 'Please login again and try.', '/fast-track/login', 'Login');
        });
    }

    earnedTab.addEventListener('click', function () {
        activeFilter = 'earned';
        renderList();
    });

    progressTab.addEventListener('click', function () {
        activeFilter = 'progress';
        renderList();
    });

    loadCertificates();
</script>
@endpush
