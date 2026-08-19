@extends('layouts.fast-track')

@section('title', 'Training Progress')

@php
    $activePage = 'progress';
@endphp

@push('styles')
<style>
    .progress-panel {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
    }

    .progress-stat-card {
        position: relative;
        overflow: hidden;
        min-height: 132px;
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
    }

    .progress-stat-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 4px;
        background: #075fe4;
    }

    .progress-summary-row {
        display: grid;
        grid-template-columns: 32px minmax(0, 1fr) auto;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #edf2fa;
        padding-bottom: 12px;
        font-size: 14px;
    }

    .progress-summary-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .skill-progress-card {
        display: grid;
        gap: 10px;
        border-radius: 8px;
        background: #f7faff;
        padding: 14px;
    }

    .progress-table-row {
        transition: background .18s ease;
    }

    .progress-table-row:hover {
        background: #f8fbff;
    }
</style>
@endpush

@section('content')
    <section class="space-y-6">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Training Progress</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Track your learning journey and monitor your progress.</p>
        </div>

        <div id="progressStats" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#334b83] shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:col-span-2 xl:col-span-4">Loading progress...</article>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <article class="progress-panel p-6">
                <h2 class="mb-6 text-base font-bold text-[#061942]">Overall Progress</h2>
                <div id="overallProgress">Loading overall progress...</div>
            </article>

            <article class="progress-panel p-6">
                <h2 class="mb-6 flex items-center text-base font-bold text-[#061942]">Skill Progress <a class="ml-auto text-xs font-bold text-[#075fe4]" href="/fast-track/courses">View Courses</a></h2>
                <div id="skillProgress" class="space-y-5">Loading skill progress...</div>
            </article>
        </div>

        <article class="progress-panel overflow-hidden p-6">
            <div class="mb-4 flex items-center justify-between gap-4">
                <h2 class="text-base font-bold text-[#061942]">Course Progress</h2>
                <a class="text-xs font-bold text-[#075fe4]" href="/fast-track/courses">View All Courses</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#f8fbff] text-left text-[#334b83]">
                            <th class="border-y border-[#e6eef8] px-3 py-3 font-bold">Course Name</th>
                            <th class="border-y border-[#e6eef8] px-3 py-3 font-bold">Progress</th>
                            <th class="border-y border-[#e6eef8] px-3 py-3 font-bold">Percent</th>
                            <th class="border-y border-[#e6eef8] px-3 py-3 font-bold">Status</th>
                            <th class="border-y border-[#e6eef8] px-3 py-3 font-bold">Updated</th>
                            <th class="border-y border-[#e6eef8] px-3 py-3 font-bold"></th>
                        </tr>
                    </thead>
                    <tbody id="progressTableBody">
                        <tr><td colspan="6" class="border-t border-[#e6eef8] px-3 py-8 text-center text-sm text-[#334b83]">Loading progress...</td></tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const progressStats = document.getElementById('progressStats');
    const overallProgress = document.getElementById('overallProgress');
    const skillProgress = document.getElementById('skillProgress');
    const progressTableBody = document.getElementById('progressTableBody');
    const progressIcons = {
        enrolled: '<svg viewBox="0 0 24 24"><path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4Z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7Z"></path></svg>',
        completed: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>',
        paid: '<svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"></rect><path d="M3 10h18"></path><path d="M7 15h3"></path></svg>',
        progress: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',
        inProgress: '<svg viewBox="0 0 24 24"><path d="M12 8v5l3 2"></path><circle cx="12" cy="12" r="9"></circle></svg>',
        notStarted: '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>',
        course: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3Z"></path></svg>',
    };

    function progressIcon(name, size = 'h-[54px] w-[54px]') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-xl bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${progressIcons[name] || progressIcons.progress}</span>`;
    }

    function isCompleted(item) {
        return item.training_status === 'completed' || item.enrollment_status === 'completed' || FastTrack.progress(item) >= 100;
    }
    function isInProgress(item) {
        const progress = FastTrack.progress(item);
        return progress > 0 && progress < 100;
    }
    function statCard(icon, label, value, href) {
        return `<article class="progress-stat-card grid grid-cols-[62px_minmax(0,1fr)] items-center gap-4">
            ${progressIcon(icon)}
            <div class="min-w-0"><h2 class="mb-1 text-[28px] font-bold leading-none text-[#061942]">${FastTrack.esc(value)}</h2><p class="mb-2 text-sm font-bold text-[#334b83]">${FastTrack.esc(label)}</p><a class="text-xs font-bold text-[#075fe4]" href="${href}">View -></a></div>
        </article>`;
    }
    function statusBadge(item) {
        const progress = FastTrack.progress(item);
        const status = FastTrack.statusText(item.training_status || item.enrollment_status);
        const cls = isCompleted(item) ? 'bg-[#e6fff0] text-[#05843e]' : (progress > 0 ? 'bg-[#eaf2ff] text-[#075fe4]' : 'bg-[#eef2f8] text-[#334b83]');
        return `<span class="inline-flex rounded-md px-3 py-1.5 text-xs font-bold ${cls}">${FastTrack.esc(status)}</span>`;
    }
    function renderStats(enrollments) {
        const completed = enrollments.filter(isCompleted).length;
        const avg = enrollments.length ? Math.round(enrollments.reduce((sum, item) => sum + FastTrack.progress(item), 0) / enrollments.length) : 0;
        const paid = enrollments.filter((item) => item.payment_status === 'paid').length;
        progressStats.innerHTML = [
            statCard('enrolled', 'Enrolled Courses', enrollments.length, '/fast-track/training'),
            statCard('completed', 'Courses Completed', completed, '/fast-track/certificate'),
            statCard('paid', 'Paid Enrollments', paid, '/fast-track/training'),
            statCard('progress', 'Overall Progress', avg + '%', '#'),
        ].join('');
    }
    function renderOverall(enrollments) {
        const total = enrollments.length;
        const completed = enrollments.filter(isCompleted).length;
        const inProgress = enrollments.filter(isInProgress).length;
        const notStarted = enrollments.filter((item) => FastTrack.progress(item) === 0).length;
        const avg = total ? Math.round(enrollments.reduce((sum, item) => sum + FastTrack.progress(item), 0) / total) : 0;
        overallProgress.innerHTML = `<div class="grid items-center gap-6 lg:grid-cols-[190px_minmax(0,1fr)]">
            <div class="mx-auto flex h-40 w-40 items-center justify-center rounded-full shadow-[inset_0_0_0_1px_rgba(220,231,248,.8)]" style="background:conic-gradient(#075fe4 0 ${avg}%, #e9edf5 ${avg}% 100%);">
                <div class="flex h-[118px] w-[118px] flex-col items-center justify-center rounded-full bg-white text-center shadow-[0_8px_20px_rgba(6,25,66,.05)]"><strong class="text-[26px] font-black leading-none text-[#061942]">${avg}%</strong><small class="mt-2 text-sm font-bold text-[#334b83]">Overall</small></div>
            </div>
            <div class="grid gap-4 border-[#dce7f8] lg:border-l lg:pl-6">
                <div class="progress-summary-row">${progressIcon('completed', 'h-8 w-8 rounded-lg')}<span class="font-bold text-[#334b83]">Completed</span><strong class="font-bold text-[#061942]">${completed}</strong></div>
                <div class="progress-summary-row">${progressIcon('inProgress', 'h-8 w-8 rounded-lg')}<span class="font-bold text-[#334b83]">In Progress</span><strong class="font-bold text-[#061942]">${inProgress}</strong></div>
                <div class="progress-summary-row">${progressIcon('notStarted', 'h-8 w-8 rounded-lg')}<span class="font-bold text-[#334b83]">Not Started</span><strong class="font-bold text-[#061942]">${notStarted}</strong></div>
                <div class="progress-summary-row">${progressIcon('enrolled', 'h-8 w-8 rounded-lg')}<span class="font-bold text-[#334b83]">Total Enrollments</span><strong class="font-bold text-[#061942]">${total}</strong></div>
            </div>
        </div><div class="mt-5 rounded-lg bg-[#eef5ff] p-4 text-sm font-medium text-[#334b83]">${total ? 'Progress updates are synced from training partner records.' : 'Enroll in a course to begin progress tracking.'}</div>`;
    }
    function renderSkills(enrollments) {
        const skillMap = new Map();
        enrollments.forEach(function (enrollment) {
            const course = FastTrack.course(enrollment);
            const progress = FastTrack.progress(enrollment);
            String(course.skills_covered || course.skills || course.category || FastTrack.courseName(course))
                .split(/,|\n/)
                .map((skill) => skill.trim())
                .filter(Boolean)
                .slice(0, 8)
                .forEach(function (skill) {
                    const current = skillMap.get(skill) || { total: 0, count: 0 };
                    current.total += progress;
                    current.count += 1;
                    skillMap.set(skill, current);
                });
        });
        const rows = Array.from(skillMap.entries()).slice(0, 8).map(([name, data]) => [name, Math.round(data.total / data.count)]);
        skillProgress.innerHTML = rows.length ? rows.map((row) => `<div class="skill-progress-card text-sm"><div class="flex items-center justify-between gap-4"><strong class="min-w-0 truncate font-bold text-[#061942]">${FastTrack.esc(row[0])}</strong><strong class="font-bold text-[#061942]">${row[1]}%</strong></div><div class="h-2.5 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[linear-gradient(90deg,#075fe4,#17a6a8)]" style="width:${row[1]}%;"></span></div></div>`).join('') : '<p class="text-sm text-[#334b83]">No skill progress yet.</p>';
    }
    function renderTable(enrollments) {
        if (!enrollments.length) {
            progressTableBody.innerHTML = '<tr><td colspan="6" class="border-t border-[#e6eef8] px-3 py-8 text-center text-sm text-[#334b83]">No training progress yet.</td></tr>';
            return;
        }
        progressTableBody.innerHTML = enrollments.map(function (enrollment) {
            const course = FastTrack.course(enrollment);
            const progress = FastTrack.progress(enrollment);
            return `<tr class="progress-table-row">
                <td class="border-t border-[#e6eef8] px-3 py-3"><div class="flex items-center gap-4"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-[#061942] text-white [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${progressIcons.course}</span><div><strong class="font-bold text-[#061942]">${FastTrack.esc(FastTrack.courseName(course))}</strong><br><span class="text-xs text-[#536484]">${FastTrack.esc(FastTrack.courseDuration(course))}</span></div></div></td>
                <td class="border-t border-[#e6eef8] px-3 py-3"><div class="h-2 min-w-[130px] overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#075fe4]" style="width:${progress}%;"></span></div></td>
                <td class="border-t border-[#e6eef8] px-3 py-3 font-bold text-[#061942]">${progress}%</td>
                <td class="border-t border-[#e6eef8] px-3 py-3">${statusBadge(enrollment)}</td>
                <td class="border-t border-[#e6eef8] px-3 py-3 text-[#536484]">${FastTrack.date(enrollment.training_progress?.updated_at || enrollment.updated_at || enrollment.enrollment_date)}</td>
                <td class="border-t border-[#e6eef8] px-3 py-3 text-right"><a class="font-bold text-[#075fe4]" href="/fast-track/course-details?course=${encodeURIComponent(course.id || '')}">Open</a></td>
            </tr>`;
        }).join('');
    }
    function renderProgressPage(enrollments) {
        renderStats(enrollments);
        renderOverall(enrollments);
        renderSkills(enrollments);
        renderTable(enrollments);
    }
    FastTrack.enrollments()
        .then((enrollments) => renderProgressPage(enrollments || []))
        .catch(function (error) {
            progressStats.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-2 xl:col-span-4">Training progress load nahi ho paaya.</article>';
            overallProgress.innerHTML = '<p class="text-sm text-[#b42318]">' + FastTrack.esc(error.message || 'Progress load failed.') + '</p>';
            skillProgress.innerHTML = '<p class="text-sm text-[#b42318]">Skill progress load nahi ho paaya.</p>';
            progressTableBody.innerHTML = '<tr><td colspan="6" class="border-t border-[#e6eef8] px-3 py-8 text-center text-sm text-[#b42318]">Training progress load nahi ho paaya.</td></tr>';
        });
</script>
@endpush
