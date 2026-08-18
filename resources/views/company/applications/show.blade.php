@extends('layouts.company')
@section('title', 'Application Details - OnlyFreshers')
@section('pageTitle', 'Application Details')
@section('pageSubtitle', 'Review candidate application details.')
@php $activePage = 'applications'; @endphp

@section('content')
<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
    <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <div id="applicationLoading" class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]">Loading application details...</div>

        <div id="applicationContent" class="hidden">
            <div class="mb-6 flex items-center gap-4">
                <div id="candidateInitials" class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xl font-bold text-[#075fe4]">C</div>
                <div class="min-w-0">
                    <h2 id="candidateName" class="break-words text-xl font-bold text-[#061942]">Candidate</h2>
                    <p id="candidateEmail" class="break-all text-sm text-[#52607a]">-</p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div><b class="text-sm">Applied For</b><p id="appliedFor" class="mt-1 break-words text-sm text-[#24344f]">-</p></div>
                <div><b class="text-sm">Qualification</b><p id="qualification" class="mt-1 break-words text-sm text-[#24344f]">-</p></div>
                <div><b class="text-sm">Applied Date</b><p id="appliedDate" class="mt-1 text-sm text-[#24344f]">-</p></div>
                <div><b class="mb-2 block text-sm">Status</b><p id="applicationStatus" class="inline-flex rounded-lg px-3 py-1 text-xs font-bold">-</p></div>
                <div><b class="text-sm">City</b><p id="candidateCity" class="mt-1 break-words text-sm text-[#24344f]">-</p></div>
                <div><b class="text-sm">Phone</b><p id="candidatePhone" class="mt-1 break-words text-sm text-[#24344f]">-</p></div>
            </div>

            <h3 class="mb-2 mt-6 font-bold">Skills</h3>
            <div id="candidateSkills" class="flex flex-wrap gap-2"></div>

            <h3 class="mb-2 mt-6 font-bold">Profile Completion</h3>
            <p id="profileCompletion" class="text-sm leading-relaxed text-[#24344f]">-</p>
        </div>
    </div>

    <aside class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <h3 class="mb-4 font-bold">Actions</h3>
        <p id="actionMessage" class="mb-3 hidden rounded-lg border px-3 py-2 text-xs font-bold"></p>
        <div class="grid gap-3">
            <button id="underReviewButton" type="button" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#9fc0f5] text-sm font-bold text-[#075fe4]">Mark Under Review</button>
            <button id="shortlistButton" type="button" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white">Shortlist</button>
            <a id="scheduleInterviewLink" href="/company/interviews/create" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#9fc0f5] text-sm font-bold text-[#075fe4]">Schedule Interview</a>
            <button id="rejectButton" type="button" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#ffd1d7] text-sm font-bold text-[#ff3045]">Reject</button>
            <p id="finalStatusNote" class="hidden rounded-lg border border-[#b9e7c9] bg-[#f1fff5] px-3 py-2 text-xs font-bold text-[#138a43]"></p>
            <a href="/company/applications" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#dce7f8] text-sm font-bold text-[#24344f]">Back to Applications</a>
        </div>
    </aside>
</section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const applicationId = localStorage.getItem('ofc_selected_company_application_id');
    const loading = document.getElementById('applicationLoading');
    const content = document.getElementById('applicationContent');
    const actionMessage = document.getElementById('actionMessage');
    let currentApplication = null;
    const actionControls = {
        underReview: document.getElementById('underReviewButton'),
        shortlist: document.getElementById('shortlistButton'),
        schedule: document.getElementById('scheduleInterviewLink'),
        reject: document.getElementById('rejectButton'),
        finalNote: document.getElementById('finalStatusNote'),
    };

    const statusClasses = {
        applied: 'bg-[#eaf2ff] text-[#075fe4]',
        under_review: 'bg-[#eaf2ff] text-[#075fe4]',
        shortlisted: 'bg-[#dbf8e9] text-[#00a65a]',
        interview_scheduled: 'bg-[#f0edff] text-[#6c50ff]',
        hired: 'bg-[#e8fbf3] text-[#00ad6f]',
        rejected: 'bg-[#ffe8eb] text-[#ff3045]',
    };

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
    }[char]));
    const formatStatus = (status) => String(status || '').replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
    const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    const initials = (name) => String(name || 'C').split(' ').map((part) => part.charAt(0)).join('').slice(0, 2).toUpperCase();
    const setText = (id, value) => document.getElementById(id).textContent = value || '-';

    function showActionMessage(text, type = 'error') {
        actionMessage.textContent = text;
        actionMessage.className = `mb-3 rounded-lg border px-3 py-2 text-xs font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
    }

    function clearActionMessage() {
        actionMessage.textContent = '';
        actionMessage.className = 'mb-3 hidden rounded-lg border px-3 py-2 text-xs font-bold';
    }

    function setActionVisible(element, visible) {
        element.style.display = visible ? '' : 'none';
    }

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

    function renderApplication(application) {
        currentApplication = application;
        const user = application.fresher_profile?.user || {};
        const profile = application.fresher_profile || {};
        const job = application.job || {};
        const status = application.application_status || 'applied';
        const skills = profile.skills ? String(profile.skills).split(',').map((skill) => skill.trim()).filter(Boolean) : [];

        setText('candidateInitials', initials(user.name));
        setText('candidateName', user.name || 'Candidate');
        setText('candidateEmail', user.email);
        setText('appliedFor', job.title);
        setText('qualification', profile.qualification);
        setText('appliedDate', formatDate(application.applied_at || application.created_at));
        setText('candidateCity', profile.city);
        setText('candidatePhone', profile.phone);
        setText('profileCompletion', profile.profile_completion !== null && profile.profile_completion !== undefined ? `${profile.profile_completion}% complete` : '-');

        const statusEl = document.getElementById('applicationStatus');
        statusEl.textContent = formatStatus(status);
        statusEl.className = `inline-flex rounded-lg px-3 py-1 text-xs font-bold ${statusClasses[status] || statusClasses.applied}`;

        document.getElementById('candidateSkills').innerHTML = skills.length
            ? skills.map((skill) => `<span class="rounded-lg bg-[#eaf2ff] px-3 py-2 text-xs font-bold text-[#075fe4]">${escapeHtml(skill)}</span>`).join('')
            : '<span class="text-sm text-[#52607a]">No skills added.</span>';

        renderActions(status, application);
    }

    function renderActions(status, application) {
        const finalStatus = ['hired', 'rejected'].includes(status);
        const interviewScheduled = status === 'interview_scheduled' || Boolean(application.interview?.id);

        setActionVisible(actionControls.underReview, !finalStatus);
        setActionVisible(actionControls.shortlist, !finalStatus);
        setActionVisible(actionControls.schedule, !finalStatus && !interviewScheduled && status === 'shortlisted');
        setActionVisible(actionControls.reject, !finalStatus);
        setActionVisible(actionControls.finalNote, finalStatus);

        if (status === 'hired') {
            clearActionMessage();
            actionControls.finalNote.textContent = 'Candidate already hired. Further application actions are closed.';
        } else if (status === 'rejected') {
            clearActionMessage();
            actionControls.finalNote.textContent = 'Candidate already rejected. Further application actions are closed.';
        } else {
            actionControls.finalNote.textContent = '';
        }
    }

    async function loadApplication() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;

        if (!applicationId) {
            window.location.href = '/company/applications';
            return;
        }

        const response = await fetch(`/api/company/applications/${applicationId}`, {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load application details.');
        }

        renderApplication(result.data.application);
        loading.classList.add('hidden');
        content.classList.remove('hidden');
    }

    async function updateStatus(status) {
        if (!currentApplication) return;

        const response = await fetch(`/api/company/applications/${currentApplication.id}/status`, {
            method: 'PATCH',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({ application_status: status }),
        });
        const result = await response.json();

        if (!response.ok || !result.success) {
            const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
            throw new Error(validationMessage || result.message || 'Unable to update status.');
        }

        currentApplication.application_status = result.data.application.application_status;
        renderApplication(currentApplication);
        showActionMessage(result.message || 'Application status updated.', 'success');
    }

    document.getElementById('underReviewButton').addEventListener('click', () => updateStatus('under_review').catch((error) => showActionMessage(error.message)));
    document.getElementById('shortlistButton').addEventListener('click', () => updateStatus('shortlisted').catch((error) => showActionMessage(error.message)));
    document.getElementById('scheduleInterviewLink').addEventListener('click', () => {
        if (currentApplication) localStorage.setItem('ofc_selected_company_application_id', currentApplication.id);
    });
    document.getElementById('rejectButton').addEventListener('click', () => updateStatus('rejected').catch((error) => showActionMessage(error.message)));

    loadApplication().catch((error) => {
        loading.textContent = error.message || 'Unable to load application details.';
        loading.className = 'rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm font-bold text-[#ff3045]';
    });
</script>
@endpush
