@extends('layouts.fast-track')

@section('title', 'Applications')

@php
    $activePage = 'applications';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];
@endphp

@section('content')
    <section class="space-y-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Applications</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">Track Fast Track job applications and interview status.</p>
            </div>
            <a class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white" href="/fast-track/job-recommendations">Browse Jobs</a>
        </div>

        <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] border-collapse text-sm">
                    <thead>
                        <tr class="text-left text-[#334b83]">
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Job</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Company</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Applied On</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Status</th>
                            <th class="border-b border-[#e6eef8] px-4 py-4 font-semibold">Mode</th>
                        </tr>
                    </thead>
                    <tbody id="fastTrackApplicationsBody">
                        <tr><td colspan="5" class="px-4 py-8 text-center text-sm text-[#334b83]">Loading applications...</td></tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const applicationsBody = document.getElementById('fastTrackApplicationsBody');

    function renderApplications(applications) {
        if (!applicationsBody) return;
        const fastTrackApps = applications.filter(function (item) {
            const job = item.job || {};
            return String(job.hiring_mode || job.mode || '').toLowerCase().includes('fast') || true;
        });

        if (!fastTrackApps.length) {
            applicationsBody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-sm text-[#334b83]">No applications yet. Apply to a Fast Track job to see it here.</td></tr>';
            return;
        }

        applicationsBody.innerHTML = fastTrackApps.map(function (application) {
            const job = application.job || {};
            const company = job.company_profile || job.company || {};
            return `<tr>
                <td class="border-b border-[#e6eef8] px-4 py-4"><strong class="font-bold text-[#061942]">${FastTrack.esc(job.title || application.job_title || 'Fast Track Job')}</strong><br><span class="text-xs text-[#536484]">${FastTrack.esc(job.location || '')}</span></td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">${FastTrack.esc(company.company_name || company.name || application.company_name || 'Company')}</td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">${FastTrack.date(application.created_at || application.applied_at)}</td>
                <td class="border-b border-[#e6eef8] px-4 py-4"><span class="inline-flex rounded-md bg-[#eaf2ff] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${FastTrack.esc(FastTrack.statusText(application.status || 'applied'))}</span></td>
                <td class="border-b border-[#e6eef8] px-4 py-4 text-[#334b83]">Fast Track</td>
            </tr>`;
        }).join('');
    }

    FastTrack.getJson('/api/fresher/applications')
        .then(function (result) {
            renderApplications(FastTrack.apiData(result, 'applications') || []);
        })
        .catch(function () {
            if (applicationsBody) applicationsBody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-sm text-[#8a5200]">Applications data nahi aa pa raha. Please login and retry.</td></tr>';
        });
</script>
@endpush
