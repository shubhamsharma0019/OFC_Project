@extends('layouts.company')

@section('title', 'Shortlisted Candidates - OnlyFreshers')
@section('pageTitle', 'Shortlisted Candidates')
@section('pageSubtitle', 'View and manage all candidates you have shortlisted.')

@php $activePage = 'shortlisted'; @endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div class="mb-[26px] grid grid-cols-1 gap-[18px] lg:grid-cols-[minmax(0,1fr)_240px_120px_190px]">
            <input id="searchInput" type="search" placeholder="Search by name, email, job or skills..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Jobs</option>
            </select>

            <button id="resetFilters" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Reset
            </button>

            <a id="allItemsLink" href="/company/applications" class="inline-flex h-[42px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                All Applications
            </a>
        </div>

        <div id="candidateList" class="grid gap-3">
            <div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-8 text-center text-sm font-bold text-[#52607a]">Loading shortlisted candidates...</div>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Loading shortlisted candidates...</span>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const candidateList = document.getElementById('candidateList');
    const resultText = document.getElementById('resultText');
    const allItemsLink = document.getElementById('allItemsLink');
    let shortlisted = [];
    let companyProfile = null;

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
    }[char]));
    const initials = (name) => String(name || 'C').split(' ').map((part) => part.charAt(0)).join('').slice(0, 2).toUpperCase();
    const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';

    async function guardCompanyFlow() {
        if (!token) {
            window.location.href = '/company/login';
            return false;
        }
        const response = await fetch('/api/company/profile', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            window.location.href = '/company/login';
            return false;
        }
        const result = await response.json();
        const profile = result.data?.profile;
        if (!profile) {
            window.location.href = '/company/profile/edit';
            return false;
        }
        localStorage.setItem('ofc_company_profile', JSON.stringify(profile));
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));
        companyProfile = profile;
        if (profile.approval_status === 'pending') {
            window.location.href = '/company/approval/pending';
            return false;
        }
        if (profile.approval_status === 'rejected') {
            window.location.href = '/company/approval/rejected';
            return false;
        }
        return true;
    }

    function populateJobs() {
        if (companyProfile?.hiring_intent === 'resume_only') {
            jobFilter.innerHTML = '<option value="all">All Resume Status</option><option value="shortlisted">Shortlisted</option><option value="interview_sent">Interview Sent</option>';
            allItemsLink.href = '/company/resumes';
            allItemsLink.textContent = 'All Resumes';
            searchInput.placeholder = 'Search by name, email, role or skills...';
            return;
        }

        const jobs = [...new Map(shortlisted.map((app) => [app.job?.id, app.job]).filter(([id]) => id)).values()];
        jobFilter.innerHTML = '<option value="all">All Jobs</option>' + jobs.map((job) => `<option value="${job.id}">${escapeHtml(job.title)}</option>`).join('');
    }

    function renderResumeShortlist() {
        const search = searchInput.value.trim().toLowerCase();
        const selectedStatus = jobFilter.value;
        const filtered = shortlisted.filter((resume) => {
            const haystack = [resume.name, resume.email, resume.preferred_job_category, resume.skills, resume.qualification, resume.city, resume.status].join(' ').toLowerCase();
            return (selectedStatus === 'all' || resume.status === selectedStatus) && haystack.includes(search);
        });

        if (!filtered.length) {
            candidateList.innerHTML = '<div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-8 text-center text-sm text-[#52607a]">No resume shortlisted candidates found.</div>';
            resultText.textContent = `Showing 0 of ${shortlisted.length} shortlisted resumes`;
            return;
        }

        candidateList.innerHTML = `
            <div class="overflow-x-auto rounded-lg border border-[#dce7f8]">
                <table class="w-full min-w-[980px] border-collapse text-left text-sm">
                    <thead class="bg-[#f8fbff] text-xs font-bold uppercase text-[#52607a]">
                        <tr>
                            <th class="px-5 py-4">Candidate</th>
                            <th class="px-5 py-4">Role</th>
                            <th class="px-5 py-4">Qualification</th>
                            <th class="px-5 py-4">Skills</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Interview</th>
                            <th class="px-5 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2fb] bg-white text-[#061942]">
                        ${filtered.map((resume) => `
                            <tr>
                                <td class="px-5 py-4"><strong class="block font-bold">${escapeHtml(resume.name || 'Candidate')}</strong><span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(resume.email || '-')}</span></td>
                                <td class="px-5 py-4">${escapeHtml(resume.preferred_job_category || '-')}</td>
                                <td class="px-5 py-4">${escapeHtml([resume.qualification, resume.city].filter(Boolean).join(' - ') || '-')}</td>
                                <td class="px-5 py-4 text-xs">${escapeHtml(resume.skills || '-')}</td>
                                <td class="px-5 py-4"><span class="rounded-md ${resume.status === 'interview_sent' ? 'bg-[#eaf2ff] text-[#075fe4]' : 'bg-[#e8f8ef] text-[#078346]'} px-2.5 py-1 text-xs font-bold capitalize">${escapeHtml(String(resume.status || 'shortlisted').replaceAll('_', ' '))}</span></td>
                                <td class="px-5 py-4 text-xs">${resume.interview_link ? `<a class="font-bold text-[#075fe4]" href="${escapeHtml(resume.interview_link)}" target="_blank" rel="noopener">${escapeHtml(resume.interview_date || 'Open link')}</a><span class="mt-1 block text-[#52607a]">${escapeHtml(resume.interview_time || '')}</span>` : '-'}</td>
                                <td class="px-5 py-4 text-right"><a href="/company/resumes" class="inline-flex h-9 items-center rounded-md border border-[#075fe4] px-4 text-xs font-bold text-[#075fe4]">Manage</a></td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
        resultText.textContent = `Showing ${filtered.length} of ${shortlisted.length} shortlisted resumes`;
    }

    function renderCandidates() {
        if (companyProfile?.hiring_intent === 'resume_only') {
            renderResumeShortlist();
            return;
        }

        const search = searchInput.value.trim().toLowerCase();
        const selectedJob = jobFilter.value;
        const filtered = shortlisted.filter((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const haystack = [user.name, user.email, job.title, profile.skills, profile.qualification, profile.city].join(' ').toLowerCase();
            return (selectedJob === 'all' || String(job.id) === selectedJob) && haystack.includes(search);
        });

        if (!filtered.length) {
            candidateList.innerHTML = '<div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-8 text-center text-sm text-[#52607a]">No shortlisted candidates found.</div>';
            resultText.textContent = `Showing 0 of ${shortlisted.length} shortlisted candidates`;
            return;
        }

        candidateList.innerHTML = filtered.map((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const score = Number(profile.profile_completion || 0);
            const ring = score < 50 ? 'bg-[conic-gradient(#ff4d57_0deg,#ff4d57_var(--score),#ffd9dc_var(--score),#ffd9dc_360deg)]' : 'bg-[conic-gradient(#33c477_0deg,#33c477_var(--score),#d9f2e5_var(--score),#d9f2e5_360deg)]';

            return `
                <article class="grid min-h-[126px] grid-cols-1 gap-5 rounded-lg border border-[#dce7f8] p-5 lg:grid-cols-[minmax(0,1fr)_180px_170px] lg:items-center lg:gap-6">
                    <div class="flex items-center gap-5 sm:gap-[22px]">
                        <div class="flex h-[72px] w-[72px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-base font-bold text-[#075fe4] sm:h-[86px] sm:w-[86px] sm:text-lg">${escapeHtml(initials(user.name))}</div>
                        <div class="min-w-0">
                            <h3 class="mb-2 break-words text-base font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h3>
                            <p class="mb-2 break-words text-sm text-[#24344f]">${escapeHtml(job.title || '-')}</p>
                            <div class="flex flex-wrap gap-3 text-[13px] text-[#24344f]">
                                <span>${escapeHtml(profile.qualification || '-')}</span>
                                <span>&bull;</span>
                                <span>${escapeHtml(profile.city || '-')}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="mb-2 text-xs font-bold text-[#061942]">Profile Score</p>
                        <div style="--score:${Math.min(score, 100) * 3.6}deg" class="relative flex h-[82px] w-[82px] items-center justify-center rounded-full text-base font-bold ${ring}">
                            <span class="absolute inset-[7px] rounded-full bg-white"></span>
                            <span class="relative z-10">${score}%</span>
                        </div>
                    </div>

                    <div class="text-[13px] leading-relaxed text-[#061942]">
                        Shortlisted on<br>
                        ${formatDate(app.updated_at || app.applied_at)}
                        <a href="/company/applications/show" data-application-id="${app.id}" class="mt-3 inline-flex h-9 items-center rounded-lg border border-[#9fc0f5] px-4 text-xs font-bold text-[#075fe4]">View</a>
                    </div>
                </article>
            `;
        }).join('');

        document.querySelectorAll('[data-application-id]').forEach((link) => {
            link.addEventListener('click', () => {
                localStorage.setItem('ofc_selected_company_application_id', link.dataset.applicationId);
            });
        });
        resultText.textContent = `Showing ${filtered.length} of ${shortlisted.length} shortlisted candidates`;
    }

    async function loadShortlisted() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;

        if (companyProfile?.hiring_intent === 'resume_only') {
            const response = await fetch('/api/company/resumes', {
                headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Unable to load shortlisted resumes.');
            }
            shortlisted = (result.data?.resumes || []).filter((resume) => ['shortlisted', 'interview_sent'].includes(resume.status));
            populateJobs();
            renderResumeShortlist();
            return;
        }

        const response = await fetch('/api/company/applications', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load shortlisted candidates.');
        }
        shortlisted = (result.data.applications || []).filter((app) => app.application_status === 'shortlisted' || app.application_status === 'interview_scheduled');
        populateJobs();
        renderCandidates();
    }

    searchInput.addEventListener('input', renderCandidates);
    jobFilter.addEventListener('change', renderCandidates);
    document.getElementById('resetFilters').addEventListener('click', () => {
        searchInput.value = '';
        jobFilter.value = 'all';
        renderCandidates();
    });

    loadShortlisted().catch((error) => {
        candidateList.innerHTML = `<div class="rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-8 text-center text-sm text-[#ff3045]">${escapeHtml(error.message || 'Unable to load shortlisted candidates.')}</div>`;
        resultText.textContent = 'Unable to load shortlisted candidates.';
    });
</script>
@endpush
