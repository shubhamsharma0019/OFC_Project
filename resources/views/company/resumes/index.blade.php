@extends('layouts.company')

@section('title', 'Resumes - OnlyFreshers')
@section('pageTitle', 'Resumes')
@section('pageSubtitle', 'Access resumes shared by admin for your company.')

@php
    $activePage = 'resumes';
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white px-6 py-8 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-[#061942]">Admin Shared Resumes</h2>
                <p class="mt-2 text-sm font-semibold text-[#52607a]">Each resume open or download uses 50 credits.</p>
            </div>
            <div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] px-5 py-3 text-right">
                <p class="text-xs font-bold uppercase text-[#52607a]">Credits</p>
                <p class="text-2xl font-black text-[#075fe4]"><span id="resumeCredits">500</span></p>
                <p class="text-xs font-semibold text-[#52607a]">50 credits per resume</p>
            </div>
        </div>

        <div id="resumeMessage" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <div id="resumeList" class="overflow-hidden rounded-lg border border-[#dce7f8]">
            <div class="bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]">Loading resumes...</div>
        </div>

        <div id="emptyResumeState" class="mx-auto hidden max-w-3xl text-center">
            <span class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#eaf2ff] text-[#075fe4]">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M7 3h8l4 4v14H7z"></path>
                    <path d="M15 3v5h5M10 12h6M10 16h6"></path>
                </svg>
            </span>
            <h2 class="text-2xl font-bold text-[#061942]">Admin shared resumes will appear here</h2>
            <p class="mt-3 text-sm font-semibold leading-6 text-[#52607a]">
                Your company is registered for resume access. Once admin approves and assigns resumes in bulk, this page will show those candidates.
            </p>
        </div>

        <div id="interviewModal" class="fixed inset-0 z-[2000] hidden items-center justify-center bg-[#06194266] p-4">
            <form id="interviewForm" class="w-full max-w-lg rounded-lg bg-white p-5 shadow-[0_20px_60px_rgba(6,25,66,.2)]">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#061942]">Send Interview Link</h2>
                        <p id="interviewCandidateName" class="mt-1 text-sm font-semibold text-[#52607a]"></p>
                    </div>
                    <button id="closeInterviewModal" class="h-9 w-9 rounded-md border border-[#dce7f8] text-xl leading-none text-[#061942]" type="button">&times;</button>
                </div>
                <input id="interviewAssignmentId" type="hidden">
                <div class="grid gap-4">
                    <label class="grid gap-2 text-sm font-bold text-[#061942]">
                        Interview Link
                        <input id="interviewLink" class="h-11 rounded-lg border border-[#dce7f8] px-3 font-semibold outline-none" type="url" placeholder="https://meet.google.com/abc-defg-hij" required>
                    </label>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="grid gap-2 text-sm font-bold text-[#061942]">
                            Date
                            <input id="interviewDate" class="h-11 rounded-lg border border-[#dce7f8] px-3 font-semibold outline-none" type="date" required>
                        </label>
                        <label class="grid gap-2 text-sm font-bold text-[#061942]">
                            Time
                            <input id="interviewTime" class="h-11 rounded-lg border border-[#dce7f8] px-3 font-semibold outline-none" type="time" required>
                        </label>
                    </div>
                    <button class="h-11 rounded-lg bg-[#075fe4] text-sm font-bold text-white" type="submit">Send Link</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (() => {
        const token =
            localStorage.getItem('ofc_company_token') ||
            localStorage.getItem('onlyfreshers_company_token') ||
            localStorage.getItem('ofc_auth_token');
        const resumeList = document.getElementById('resumeList');
        const emptyResumeState = document.getElementById('emptyResumeState');
        const resumeCredits = document.getElementById('resumeCredits');
        const resumeMessage = document.getElementById('resumeMessage');
        const interviewModal = document.getElementById('interviewModal');
        const interviewForm = document.getElementById('interviewForm');
        const interviewAssignmentId = document.getElementById('interviewAssignmentId');
        const interviewCandidateName = document.getElementById('interviewCandidateName');
        const interviewLink = document.getElementById('interviewLink');
        const interviewDate = document.getElementById('interviewDate');
        const interviewTime = document.getElementById('interviewTime');
        let resumesCache = [];

        const escapeHtml = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        const showMessage = (message, type = 'error') => {
            resumeMessage.textContent = message;
            resumeMessage.className = `mb-5 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
        };

        const resumeUrl = (profileId, download = false) => {
            const path = download ? '/company/resumes/download-assigned' : '/company/resumes/open-assigned';
            return `${path}?fresher_profile_id=${encodeURIComponent(profileId)}&token=${encodeURIComponent(token)}`;
        };

        const statusBadge = (status) => {
            const label = String(status || 'assigned').replaceAll('_', ' ');
            const tone = status === 'hired'
                ? 'bg-[#e8f8ef] text-[#078346]'
                : status === 'not_selected'
                    ? 'bg-[#ffe8eb] text-[#c81e3a]'
                    : status === 'interview_completed'
                        ? 'bg-[#dbf8e9] text-[#00a65a]'
                        : status === 'interview_sent'
                ? 'bg-[#eaf2ff] text-[#075fe4]'
                : status === 'shortlisted'
                    ? 'bg-[#e8f8ef] text-[#078346]'
                    : 'bg-[#fff4df] text-[#b86500]';

            return `<span class="rounded-md px-2.5 py-1 text-xs font-bold capitalize ${tone}">${escapeHtml(label)}</span>`;
        };

        const authPost = async (url, payload = {}) => {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(payload),
            });
            const result = await response.json().catch(() => ({}));

            if (!response.ok || result.success === false) {
                throw new Error(result.message || 'Action failed.');
            }

            return result;
        };

        const syncActionCredits = (result) => {
            const remaining = result?.data?.credits?.remaining;
            if (remaining !== undefined && remaining !== null) {
                resumeCredits.textContent = Number(remaining).toLocaleString('en-IN');
            }
        };

        const pipelineActions = (resume) => {
            const join = resume.interview_link && resume.status === 'interview_sent'
                ? `<a href="${escapeHtml(resume.interview_link)}" target="_blank" rel="noopener" data-assignment-id="${resume.assignment_id}" class="join-meet-action inline-flex h-9 items-center justify-center rounded-md bg-[#075fe4] px-4 text-xs font-bold text-white">Join Meet</a>`
                : '';
            const close = resume.status === 'interview_sent'
                ? `<button class="complete-interview inline-flex h-9 items-center justify-center rounded-md border border-[#078346] bg-white px-4 text-xs font-bold text-[#078346] disabled:cursor-not-allowed disabled:opacity-50" type="button" data-assignment-id="${resume.assignment_id}" ${resume.both_joined ? '' : 'disabled'}>Close Interview</button>
                   <span class="inline-flex min-h-9 items-center text-xs font-bold text-[#52607a]">${resume.company_joined_at ? 'Company joined' : 'Company pending'} / ${resume.fresher_joined_at ? 'Fresher joined' : 'Fresher pending'}</span>`
                : '';
            const final = resume.status === 'interview_completed'
                ? `<button class="final-status inline-flex h-9 items-center justify-center rounded-md border border-[#078346] bg-white px-4 text-xs font-bold text-[#078346]" type="button" data-status="hired" data-assignment-id="${resume.assignment_id}">Hired</button>
                   <button class="final-status inline-flex h-9 items-center justify-center rounded-md border border-[#ffd1d7] bg-white px-4 text-xs font-bold text-[#ff3045]" type="button" data-status="not_selected" data-assignment-id="${resume.assignment_id}">Not Selected</button>`
                : '';

            return `${join}${close}${final}`;
        };

        const renderResumes = (resumes, credits) => {
            resumesCache = resumes;
            resumeCredits.textContent = Number(credits.remaining || 0).toLocaleString('en-IN');

            if (!credits.can_open) {
                showMessage('Your free resume credits are over. Please choose a resume plan to continue.');
            }

            if (!resumes.length) {
                resumeList.classList.add('hidden');
                emptyResumeState.classList.remove('hidden');
                return;
            }

            emptyResumeState.classList.add('hidden');
            resumeList.classList.remove('hidden');
            resumeList.innerHTML = `
                <div class="hidden overflow-x-auto lg:block">
                    <table class="w-full min-w-[980px] border-collapse text-left text-sm">
                        <thead class="bg-[#f8fbff] text-xs font-bold uppercase text-[#52607a]">
                            <tr>
                                <th class="px-5 py-4">Candidate</th>
                                <th class="px-5 py-4">Category</th>
                                <th class="px-5 py-4">Qualification</th>
                                <th class="px-5 py-4">City</th>
                                <th class="px-5 py-4">Resume File</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4">Cost</th>
                                <th class="px-5 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#edf2fb] bg-white text-[#061942]">
                            ${resumes.map((resume) => `
                                <tr>
                                    <td class="px-5 py-4">
                                        <strong class="block font-bold">${escapeHtml(resume.name)}</strong>
                                        <span class="mt-1 block text-xs font-semibold text-[#52607a]">${escapeHtml(resume.email || '-')}</span>
                                    </td>
                                    <td class="px-5 py-4">${escapeHtml(resume.preferred_job_category || '-')}</td>
                                    <td class="px-5 py-4">
                                        <span class="block">${escapeHtml(resume.qualification || '-')}</span>
                                        <span class="mt-1 block text-xs text-[#52607a]">${escapeHtml(resume.college_name || '')}</span>
                                    </td>
                                    <td class="px-5 py-4">${escapeHtml(resume.city || '-')}</td>
                                    <td class="px-5 py-4 text-xs font-semibold text-[#34445e]">${escapeHtml(resume.resume_file || 'Resume uploaded')}</td>
                                    <td class="px-5 py-4">${statusBadge(resume.status)}</td>
                                    <td class="px-5 py-4 font-bold text-[#075fe4]">50 credits</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            ${credits.can_open
                                                ? `<a href="${resumeUrl(resume.id)}" target="_blank" rel="noopener" class="inline-flex h-9 items-center justify-center rounded-md bg-[#075fe4] px-4 text-xs font-bold text-white">Open</a>
                                                   <a href="${resumeUrl(resume.id, true)}" class="inline-flex h-9 items-center justify-center rounded-md border border-[#075fe4] bg-white px-4 text-xs font-bold text-[#075fe4]">Download</a>`
                                                : `<a href="/company/billing?reason=resume-credits-over" class="inline-flex h-9 items-center justify-center rounded-md bg-[#075fe4] px-4 text-xs font-bold text-white">Buy Plan</a>`
                                            }
                                            <button class="shortlist-resume inline-flex h-9 items-center justify-center rounded-md border border-[#078346] bg-white px-4 text-xs font-bold text-[#078346]" type="button" data-assignment-id="${resume.assignment_id}">Shortlist</button>
                                            <button class="interview-resume inline-flex h-9 items-center justify-center rounded-md border border-[#dce7f8] bg-white px-4 text-xs font-bold text-[#061942]" type="button" data-assignment-id="${resume.assignment_id}">Interview Link</button>
                                            ${pipelineActions(resume)}
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                <div class="grid gap-3 bg-white p-3 lg:hidden">
                    ${resumes.map((resume) => `
                        <article class="rounded-lg border border-[#edf2fb] p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="break-words text-base font-bold text-[#061942]">${escapeHtml(resume.name)}</h3>
                                    <p class="mt-1 text-xs font-semibold text-[#52607a]">${escapeHtml(resume.email || '-')}</p>
                                </div>
                                <span class="shrink-0 rounded-md bg-[#eaf2ff] px-2.5 py-1 text-xs font-bold text-[#075fe4]">50 credits</span>
                            </div>
                            <div class="mt-4 grid gap-2 text-xs font-semibold text-[#34445e]">
                                <p><span class="text-[#52607a]">Category:</span> ${escapeHtml(resume.preferred_job_category || '-')}</p>
                                <p><span class="text-[#52607a]">Qualification:</span> ${escapeHtml(resume.qualification || '-')}</p>
                                <p><span class="text-[#52607a]">City:</span> ${escapeHtml(resume.city || '-')}</p>
                                <p><span class="text-[#52607a]">File:</span> ${escapeHtml(resume.resume_file || 'Resume uploaded')}</p>
                                <p><span class="text-[#52607a]">Status:</span> ${statusBadge(resume.status)}</p>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                ${credits.can_open
                                    ? `<a href="${resumeUrl(resume.id)}" target="_blank" rel="noopener" class="inline-flex h-9 items-center justify-center rounded-md bg-[#075fe4] px-4 text-xs font-bold text-white">Open</a>
                                       <a href="${resumeUrl(resume.id, true)}" class="inline-flex h-9 items-center justify-center rounded-md border border-[#075fe4] bg-white px-4 text-xs font-bold text-[#075fe4]">Download</a>`
                                    : `<a href="/company/billing?reason=resume-credits-over" class="inline-flex h-9 items-center justify-center rounded-md bg-[#075fe4] px-4 text-xs font-bold text-white">Buy Resume Plan</a>`
                                }
                                <button class="shortlist-resume inline-flex h-9 items-center justify-center rounded-md border border-[#078346] bg-white px-4 text-xs font-bold text-[#078346]" type="button" data-assignment-id="${resume.assignment_id}">Shortlist</button>
                                <button class="interview-resume inline-flex h-9 items-center justify-center rounded-md border border-[#dce7f8] bg-white px-4 text-xs font-bold text-[#061942]" type="button" data-assignment-id="${resume.assignment_id}">Interview Link</button>
                                ${pipelineActions(resume)}
                            </div>
                        </article>
                    `).join('')}
                </div>
            `;
        };

        resumeList.addEventListener('click', async (event) => {
            const shortlistButton = event.target.closest('.shortlist-resume');
            const interviewButton = event.target.closest('.interview-resume');
            const completeButton = event.target.closest('.complete-interview');
            const finalButton = event.target.closest('.final-status');
            const joinLink = event.target.closest('.join-meet-action');

            if (shortlistButton) {
                shortlistButton.disabled = true;

                try {
                    const result = await authPost(`/api/company/resumes/${shortlistButton.dataset.assignmentId}/shortlist`);
                    syncActionCredits(result);
                    showMessage('Candidate shortlisted successfully.', 'success');
                    await loadResumes();
                } catch (error) {
                    showMessage(error.message || 'Unable to shortlist resume.');
                    shortlistButton.disabled = false;
                }
            }

            if (interviewButton) {
                const resume = resumesCache.find((item) => Number(item.assignment_id) === Number(interviewButton.dataset.assignmentId));
                interviewAssignmentId.value = interviewButton.dataset.assignmentId;
                interviewCandidateName.textContent = resume?.name || 'Candidate';
                interviewLink.value = resume?.interview_link || '';
                interviewDate.value = resume?.interview_date || '';
                interviewTime.value = resume?.interview_time || '';
                interviewModal.classList.remove('hidden');
                interviewModal.classList.add('flex');
            }

            if (completeButton) {
                completeButton.disabled = true;

                try {
                    const result = await authPost(`/api/company/resumes/${completeButton.dataset.assignmentId}/interview/complete`);
                    syncActionCredits(result);
                    showMessage('Interview marked as completed.', 'success');
                    await loadResumes();
                } catch (error) {
                    showMessage(error.message || 'Unable to close interview.');
                    completeButton.disabled = false;
                }
            }

            if (finalButton) {
                finalButton.disabled = true;

                try {
                    const result = await authPost(`/api/company/resumes/${finalButton.dataset.assignmentId}/hiring-status`, {
                        status: finalButton.dataset.status,
                    });
                    syncActionCredits(result);
                    showMessage('Candidate status updated successfully.', 'success');
                    await loadResumes();
                } catch (error) {
                    showMessage(error.message || 'Unable to update candidate status.');
                    finalButton.disabled = false;
                }
            }

            if (joinLink) {
                try {
                    await authPost(`/api/company/resumes/${joinLink.dataset.assignmentId}/interview/join`);
                    window.setTimeout(loadResumes, 500);
                } catch (error) {
                }
            }
        });

        document.getElementById('closeInterviewModal').addEventListener('click', () => {
            interviewModal.classList.add('hidden');
            interviewModal.classList.remove('flex');
        });

        interviewForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            try {
                const result = await authPost(`/api/company/resumes/${interviewAssignmentId.value}/interview`, {
                    interview_link: interviewLink.value.trim(),
                    interview_date: interviewDate.value,
                    interview_time: interviewTime.value,
                });
                syncActionCredits(result);
                interviewModal.classList.add('hidden');
                interviewModal.classList.remove('flex');
                showMessage('Interview link sent successfully.', 'success');
                await loadResumes();
            } catch (error) {
                showMessage(error.message || 'Unable to send interview link.');
            }
        });

        const loadResumes = async () => {
            if (!token) {
                window.location.href = '/company/login';
                return;
            }

            try {
                const response = await fetch('/api/company/resumes', {
                    headers: {
                        Accept: 'application/json',
                        Authorization: `Bearer ${token}`,
                    },
                });
                const result = await response.json();

                if (!response.ok || result.success === false) {
                    throw new Error(result.message || 'Unable to load resumes.');
                }

                renderResumes(result.data?.resumes || [], result.data?.credits || {});
            } catch (error) {
                resumeList.innerHTML = '';
                showMessage(error.message || 'Unable to load resumes.');
            }
        };

        loadResumes();
    })();
</script>
@endpush
