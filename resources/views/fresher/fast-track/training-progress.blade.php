@extends('layouts.fast-track')

@section('title', 'Training Progress')

@php
    $activePage = 'progress';
@endphp

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
            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 text-base font-bold text-[#061942]">Overall Progress</h2>
                <div id="overallProgress">Loading overall progress...</div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-6 flex items-center text-base font-bold text-[#061942]">Skill Progress <a class="ml-auto text-xs font-bold text-[#075fe4]" href="/fast-track/courses">View Courses</a></h2>
                <div id="skillProgress" class="space-y-5">Loading skill progress...</div>
            </article>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="mb-4 flex items-center justify-between gap-4">
                <h2 class="text-base font-bold text-[#061942]">Course Progress</h2>
                <a class="text-xs font-bold text-[#075fe4]" href="/fast-track/courses">View All Courses</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse text-sm">
                    <thead>
                        <tr class="text-left text-[#334b83]">
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Course Name</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Progress</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Percent</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Status</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold">Updated</th>
                            <th class="border-t border-[#e6eef8] px-3 py-3 font-semibold"></th>
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

    function isCompleted(item) {
        return item.training_status === 'completed' || item.enrollment_status === 'completed' || FastTrack.progress(item) >= 100;
    }
    function isInProgress(item) {
        const progress = FastTrack.progress(item);
        return progress > 0 && progress < 100;
    }
    function statCard(icon, label, value, href) {
        return `<article class="grid grid-cols-[62px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <span class="grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">${icon}</span>
            <div class="min-w-0"><h2 class="mb-1 text-2xl font-bold text-[#061942]">${FastTrack.esc(value)}</h2><p class="mb-2 text-sm font-medium text-[#334b83]">${FastTrack.esc(label)}</p><a class="text-xs font-bold text-[#075fe4]" href="${href}">View -></a></div>
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
            statCard('EC', 'Enrolled Courses', enrollments.length, '/fast-track/training'),
            statCard('CC', 'Courses Completed', completed, '/fast-track/certificate'),
            statCard('PE', 'Paid Enrollments', paid, '/fast-track/training'),
            statCard('OP', 'Overall Progress', avg + '%', '#'),
        ].join('');
    }
    function renderOverall(enrollments) {
        const total = enrollments.length;
        const completed = enrollments.filter(isCompleted).length;
        const inProgress = enrollments.filter(isInProgress).length;
        const notStarted = enrollments.filter((item) => FastTrack.progress(item) === 0).length;
        const avg = total ? Math.round(enrollments.reduce((sum, item) => sum + FastTrack.progress(item), 0) / total) : 0;
        overallProgress.innerHTML = `<div class="grid items-center gap-6 lg:grid-cols-[190px_minmax(0,1fr)]">
            <div class="flex h-40 w-40 items-center justify-center rounded-full" style="background:conic-gradient(#075fe4 0 ${avg}%, #e9edf5 ${avg}% 100%);">
                <div class="flex h-[118px] w-[118px] flex-col items-center justify-center rounded-full bg-white text-center"><strong class="text-[26px] font-black leading-none text-[#061942]">${avg}%</strong><small class="mt-2 text-sm font-medium text-[#334b83]">Overall</small></div>
            </div>
            <div class="grid gap-4 border-[#dce7f8] lg:border-l lg:pl-6">
                <div class="grid grid-cols-[28px_minmax(0,1fr)_auto] items-center gap-3 text-sm"><span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">CC</span><span class="font-medium text-[#334b83]">Completed</span><strong class="font-bold text-[#061942]">${completed}</strong></div>
                <div class="grid grid-cols-[28px_minmax(0,1fr)_auto] items-center gap-3 text-sm"><span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">IP</span><span class="font-medium text-[#334b83]">In Progress</span><strong class="font-bold text-[#061942]">${inProgress}</strong></div>
                <div class="grid grid-cols-[28px_minmax(0,1fr)_auto] items-center gap-3 text-sm"><span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">NS</span><span class="font-medium text-[#334b83]">Not Started</span><strong class="font-bold text-[#061942]">${notStarted}</strong></div>
                <div class="grid grid-cols-[28px_minmax(0,1fr)_auto] items-center gap-3 text-sm"><span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">TE</span><span class="font-medium text-[#334b83]">Total Enrollments</span><strong class="font-bold text-[#061942]">${total}</strong></div>
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
        skillProgress.innerHTML = rows.length ? rows.map((row) => `<div class="grid items-center gap-3 text-sm sm:grid-cols-[120px_minmax(0,1fr)_42px] sm:gap-5"><strong class="font-bold text-[#061942]">${FastTrack.esc(row[0])}</strong><div class="h-2 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#075fe4]" style="width:${row[1]}%;"></span></div><strong class="font-bold text-[#061942]">${row[1]}%</strong></div>`).join('') : '<p class="text-sm text-[#334b83]">No skill progress yet.</p>';
    }
    function renderTable(enrollments) {
        if (!enrollments.length) {
            progressTableBody.innerHTML = '<tr><td colspan="6" class="border-t border-[#e6eef8] px-3 py-8 text-center text-sm text-[#334b83]">No training progress yet.</td></tr>';
            return;
        }
        progressTableBody.innerHTML = enrollments.map(function (enrollment) {
            const course = FastTrack.course(enrollment);
            const progress = FastTrack.progress(enrollment);
            return `<tr>
                <td class="border-t border-[#e6eef8] px-3 py-3"><div class="flex items-center gap-4"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-lg bg-[#061942] text-[10px] font-black text-white">${FastTrack.initials(FastTrack.courseName(course))}</span><div><strong class="font-bold text-[#061942]">${FastTrack.esc(FastTrack.courseName(course))}</strong><br><span class="text-xs text-[#536484]">${FastTrack.esc(FastTrack.courseDuration(course))}</span></div></div></td>
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
