@extends('layouts.fast-track')

@section('title', 'Certificate')

@php
    $activePage = 'certificate';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $stats = [
        ['label' => 'Certificates Earned', 'value' => '1', 'hint' => 'Keep learning and earn more', 'icon' => 'CE'],
        ['label' => 'Lessons Completed', 'value' => '28/74', 'hint' => 'Across All Courses', 'icon' => 'LC'],
        ['label' => 'Total Study Time', 'value' => '12h 45m', 'hint' => 'Keep it up!', 'icon' => 'ST'],
        ['label' => 'Overall Progress', 'value' => '38%', 'hint' => 'You are doing great!', 'icon' => 'OP'],
    ];

    $certificates = [
        [
            'student' => 'Ananya Gupta',
            'course' => 'Full Stack Development',
            'description' => 'Build modern web applications from scratch and become a full stack developer.',
            'badge' => 'Most Popular',
            'date' => '20 May 2026',
            'duration' => '12 Months',
            'certificateId' => 'OF-2026-05-0001',
            'credentialId' => '9f3c7b2e-8a4d-4f91-bc1a-2e7b8c9d0123',
            'status' => 'Verified',
        ],
    ];
@endphp

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Certificate</h1>
                <p class="mt-2 text-sm font-medium text-[#334b83]">View and download your earned certificates.</p>
            </div>
            <button class="inline-flex h-[42px] items-center justify-center rounded-md border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" type="button">Download All Certificates</button>
        </div>

        <div id="certificateStats" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $item)
                <article class="grid grid-cols-[60px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <span class="grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                    <div class="min-w-0">
                        <h2 class="mb-1 text-2xl font-bold text-[#061942]">{{ $item['value'] }}</h2>
                        <p class="mb-1 text-sm font-medium text-[#334b83]">{{ $item['label'] }}</p>
                        <small class="text-xs text-[#334b83]">{{ $item['hint'] }}</small>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="flex gap-8 overflow-x-auto border-b border-[#dce7f8]">
            <button class="shrink-0 border-b-[3px] border-[#075fe4] px-6 pb-3 text-sm font-bold text-[#075fe4]" type="button">Earned Certificates</button>
            <button class="shrink-0 border-b-[3px] border-transparent px-6 pb-3 text-sm font-bold text-[#334b83]" type="button">In Progress</button>
        </div>

        <div id="certificateList" class="space-y-5">
            @foreach ($certificates as $cert)
                <article class="grid gap-7 rounded-lg border border-[#dce7f8] bg-white p-2 shadow-[0_10px_24px_rgba(6,25,66,.04)] xl:grid-cols-[1.08fr_1fr]">
                    <div class="relative min-h-[350px] overflow-hidden border border-[#d7b15f] bg-white p-7 text-center">
                        <div class="absolute -right-24 -top-24 h-[170px] w-[170px] rotate-45 border-[28px] border-b-transparent border-l-transparent border-r-[#d7a63b] border-t-[#07306e]"></div>
                        <div class="absolute -bottom-24 -left-24 h-[170px] w-[170px] rotate-45 border-[28px] border-b-[#d7a63b] border-l-[#07306e] border-r-transparent border-t-transparent"></div>

                        @if (file_exists(public_path('ofclogo1.svg')))
                            <img class="mx-auto mb-4 w-[170px]" src="/ofclogo1.svg" alt="OnlyFreshers">
                        @else
                            <div class="mx-auto mb-4 text-lg font-black text-[#075fe4]">OnlyFreshers</div>
                        @endif

                        <h2 class="my-2 font-serif text-[30px] tracking-[5px] text-[#061942]">CERTIFICATE</h2>
                        <h3 class="mb-5 font-serif text-lg tracking-[4px] text-[#061942]">OF COMPLETION</h3>
                        <p class="text-sm text-[#334b83]">This is to certify that</p>
                        <div class="my-4 inline-block border-b border-[#d7a63b] px-10 pb-2 font-serif text-[36px] italic text-[#061942]">{{ $cert['student'] }}</div>
                        <p class="text-sm text-[#334b83]">has successfully completed the course</p>
                        <div class="my-3 text-lg font-black text-[#061942]">{{ $cert['course'] }}</div>
                        <p class="text-sm text-[#334b83]">and has demonstrated the required skills and knowledge.</p>
                        <div class="mx-auto mt-5 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#d7a63b] text-lg font-black text-white">OF</div>
                        <div class="mt-7 flex justify-around gap-4 text-xs text-[#334b83]"><span>{{ $cert['date'] }}<br>Date</span><span>Authorized Signatory<br>OnlyFreshers</span></div>
                    </div>

                    <div class="p-5">
                        <span class="inline-flex rounded-md bg-[#e2f9ea] px-3 py-1.5 text-xs font-bold text-[#05843e]">{{ $cert['status'] }}</span>
                        <h2 class="mt-5 flex flex-wrap items-center gap-2 text-[22px] font-bold text-[#061942]">
                            <span>{{ $cert['course'] }}</span>
                            <span class="rounded-md bg-[#efeaff] px-2.5 py-1 text-[11px] font-bold text-[#673de6]">{{ $cert['badge'] }}</span>
                        </h2>
                        <p class="mt-2 max-w-xl text-sm leading-7 text-[#334b83]">{{ $cert['description'] }}</p>

                        <div class="my-6 grid gap-4">
                            @foreach ([['DE', 'Date Earned', $cert['date']], ['DU', 'Duration', $cert['duration']], ['CI', 'Certificate ID', $cert['certificateId']], ['CR', 'Credential ID', $cert['credentialId']]] as $row)
                                <div class="grid grid-cols-[28px_150px_minmax(0,1fr)] items-center gap-3 text-sm text-[#334b83] max-sm:grid-cols-[28px_minmax(0,1fr)]">
                                    <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">{{ $row[0] }}</span>
                                    <span>{{ $row[1] }}</span>
                                    <strong class="break-words font-semibold text-[#061942] max-sm:col-start-2">{{ $row[2] }}</strong>
                                </div>
                            @endforeach
                        </div>

                        <div class="grid gap-3">
                            <button class="h-[42px] rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white hover:bg-[#064fc0]" type="button">Download Certificate</button>
                            <button class="h-[42px] rounded-md border border-[#075fe4] bg-white px-5 text-sm font-bold text-[#075fe4] hover:bg-[#eff5ff]" type="button">Share Certificate</button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <article class="flex flex-col gap-5 rounded-lg border border-[#cfe0ff] bg-[#eaf2ff] p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-5">
                <span class="grid h-[62px] w-[62px] shrink-0 place-items-center rounded-xl bg-white text-xl font-black text-[#075fe4]">CT</span>
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

    function renderCertificateStats(certificates) {
        if (!certificateStats) return;
        const rows = [
            ['CE', 'Certificates Earned', certificates.length, 'Keep learning and earn more'],
            ['LC', 'Courses Certified', certificates.length, 'Fast Track completions'],
            ['ST', 'Latest Certificate', certificates[0] ? FastTrack.date(certificates[0].issued_at || certificates[0].created_at) : '-', 'Auto generated after passing'],
            ['OP', 'Verification', certificates.length ? 'Ready' : 'Locked', 'Certificate status'],
        ];
        certificateStats.innerHTML = rows.map(function (row) {
            return `<article class="grid grid-cols-[60px_minmax(0,1fr)] items-center gap-4 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)]"><span class="grid h-[54px] w-[54px] place-items-center rounded-xl bg-[#f0f5ff] text-[11px] font-black text-[#075fe4]">${row[0]}</span><div class="min-w-0"><h2 class="mb-1 text-2xl font-bold text-[#061942]">${FastTrack.esc(row[2])}</h2><p class="mb-1 text-sm font-medium text-[#334b83]">${row[1]}</p><small class="text-xs text-[#334b83]">${row[3]}</small></div></article>`;
        }).join('');
    }

    function renderCertificates(certificates) {
        if (!certificateList) return;
        if (!certificates.length) {
            certificateList.innerHTML = FastTrack.emptyState('Certificate not generated yet', 'Complete training and pass the final assessment to generate your Fast Track certificate.', '/fast-track/final-assessment', 'Final Assessment');
            return;
        }
        certificateList.innerHTML = certificates.map(function (certificate) {
            const course = certificate.course || (certificate.enrollment && certificate.enrollment.course) || {};
            const title = FastTrack.courseName(course);
            return `<article class="grid gap-7 rounded-lg border border-[#dce7f8] bg-white p-2 shadow-[0_10px_24px_rgba(6,25,66,.04)] xl:grid-cols-[1.08fr_1fr]">
                <div class="relative min-h-[350px] overflow-hidden border border-[#d7b15f] bg-white p-7 text-center">
                    <div class="mx-auto mb-4 text-lg font-black text-[#075fe4]">OnlyFreshers</div>
                    <h2 class="my-2 font-serif text-[30px] tracking-[5px] text-[#061942]">CERTIFICATE</h2>
                    <h3 class="mb-5 font-serif text-lg tracking-[4px] text-[#061942]">OF COMPLETION</h3>
                    <p class="text-sm text-[#334b83]">This is to certify that</p>
                    <div class="my-4 inline-block border-b border-[#d7a63b] px-10 pb-2 font-serif text-[32px] italic text-[#061942]">${FastTrack.esc(certificate.student_name || (FastTrack.user().name || 'Student'))}</div>
                    <p class="text-sm text-[#334b83]">has successfully completed the course</p>
                    <div class="my-3 text-lg font-black text-[#061942]">${FastTrack.esc(title)}</div>
                    <div class="mx-auto mt-5 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#d7a63b] text-lg font-black text-white">OF</div>
                    <div class="mt-7 flex justify-around gap-4 text-xs text-[#334b83]"><span>${FastTrack.date(certificate.issued_at || certificate.created_at)}<br>Date</span><span>Authorized Signatory<br>OnlyFreshers</span></div>
                </div>
                <div class="p-5">
                    <span class="inline-flex rounded-md bg-[#e2f9ea] px-3 py-1.5 text-xs font-bold text-[#05843e]">${FastTrack.esc(FastTrack.statusText(certificate.status || 'verified'))}</span>
                    <h2 class="mt-5 text-[22px] font-bold text-[#061942]">${FastTrack.esc(title)}</h2>
                    <p class="mt-2 max-w-xl text-sm leading-7 text-[#334b83]">${FastTrack.esc(FastTrack.courseText(course))}</p>
                    <div class="my-6 grid gap-4">
                        <div class="grid grid-cols-[28px_150px_minmax(0,1fr)] items-center gap-3 text-sm text-[#334b83] max-sm:grid-cols-[28px_minmax(0,1fr)]"><span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">DE</span><span>Date Earned</span><strong class="font-semibold text-[#061942] max-sm:col-start-2">${FastTrack.date(certificate.issued_at || certificate.created_at)}</strong></div>
                        <div class="grid grid-cols-[28px_150px_minmax(0,1fr)] items-center gap-3 text-sm text-[#334b83] max-sm:grid-cols-[28px_minmax(0,1fr)]"><span class="grid h-7 w-7 place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">CI</span><span>Certificate ID</span><strong class="break-words font-semibold text-[#061942] max-sm:col-start-2">${FastTrack.esc(certificate.certificate_number || certificate.id)}</strong></div>
                    </div>
                    <button class="download-certificate h-[42px] rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white hover:bg-[#064fc0]" type="button" data-certificate-id="${FastTrack.esc(certificate.id)}">Download Certificate</button>
                </div>
            </article>`;
        }).join('');

        certificateList.querySelectorAll('.download-certificate').forEach(function (button) {
            button.addEventListener('click', async function () {
                const response = await fetch('/api/fresher/certificates/' + button.dataset.certificateId + '/download', { headers: { Authorization: 'Bearer ' + FastTrack.token(), Accept: 'application/pdf' } });
                if (!response.ok) return;
                const blob = await response.blob();
                const url = URL.createObjectURL(blob);
                window.open(url, '_blank');
            });
        });
    }

    FastTrack.getJson('/api/fresher/certificates')
        .then(function (result) {
            const certificates = FastTrack.apiData(result, 'certificates') || [];
            renderCertificateStats(certificates);
            renderCertificates(certificates);
        })
        .catch(function () {});
</script>
@endpush
