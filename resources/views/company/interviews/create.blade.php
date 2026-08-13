@extends('layouts.company')
@section('title', 'Schedule Interview - OnlyFreshers')
@section('pageTitle', 'Schedule Interview')
@section('pageSubtitle', 'Create a new interview schedule.')
@php $activePage = 'interviews'; @endphp

@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6">
    <p id="formMessage" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm font-bold"></p>

    <div id="candidateSummary" class="mb-6 rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-4 text-sm text-[#52607a]">
        Loading selected application...
    </div>

    <form id="interviewForm" class="grid gap-5 md:grid-cols-2">
        <label>
            <span class="mb-2 block text-xs font-bold text-[#061942]">Interview Mode</span>
            <select id="interviewMode" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm" required>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
        </label>
        <label>
            <span class="mb-2 block text-xs font-bold text-[#061942]">Date</span>
            <input id="interviewDate" type="date" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm" required>
        </label>
        <label>
            <span class="mb-2 block text-xs font-bold text-[#061942]">Time</span>
            <input id="interviewTime" type="time" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm" required>
        </label>
        <label id="meetingLinkWrap">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Google Meet Link</span>
            <input id="meetingLink" type="url" placeholder="https://meet.google.com/abc-defg-hij" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm">
            <span class="mt-2 block text-xs font-semibold text-[#52607a]">Create the meeting in Google Meet, paste that link here, then schedule.</span>
        </label>
        <label id="locationWrap" class="hidden md:col-span-2">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Interview Location</span>
            <input id="interviewLocation" type="text" placeholder="Office address / venue" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm">
        </label>
        <div class="flex justify-end gap-3 md:col-span-2">
            <a href="/company/applications/show" class="inline-flex h-11 items-center rounded-lg border border-[#dce7f8] px-6 text-sm font-bold text-[#075fe4]">Cancel</a>
            <button class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white disabled:opacity-70" type="submit">Schedule</button>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const applicationId = localStorage.getItem('ofc_selected_company_application_id');
    const form = document.getElementById('interviewForm');
    const message = document.getElementById('formMessage');
    const summary = document.getElementById('candidateSummary');
    const mode = document.getElementById('interviewMode');
    const submitButton = form.querySelector('button[type="submit"]');

    function showMessage(text, type = 'error') {
        message.textContent = text;
        message.className = `mb-5 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
    }

    const normalizeUrl = (value) => {
        const trimmed = value.trim();
        return trimmed && !/^https?:\/\//i.test(trimmed) ? `https://${trimmed}` : trimmed;
    };

    const isGoogleMeetLink = (value) => /^https?:\/\/meet\.google\.com\/[a-z0-9-]+(?:[\/?#].*)?$/i.test(value);

    async function guardCompanyFlow() {
        if (!token) {
            window.location.href = '/company/login';
            return false;
        }
        const response = await fetch('/api/company/profile', { headers: { Accept: 'application/json', Authorization: `Bearer ${token}` } });
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
            throw new Error(result.message || 'Unable to load selected application.');
        }

        const app = result.data.application;
        const user = app.fresher_profile?.user || {};
        const job = app.job || {};
        summary.innerHTML = `<strong class="text-[#061942]">${user.name || 'Candidate'}</strong><br><span>${user.email || '-'}</span><br><span>${job.title || '-'}</span>`;

        if (app.application_status !== 'shortlisted') {
            showMessage('Interview can be scheduled only after the candidate is shortlisted.');
            submitButton.disabled = true;
        }
    }

    mode.addEventListener('change', () => {
        const online = mode.value === 'online';
        document.getElementById('meetingLinkWrap').classList.toggle('hidden', !online);
        document.getElementById('locationWrap').classList.toggle('hidden', online);
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = 'Scheduling...';

        try {
            const payload = {
                interview_date: document.getElementById('interviewDate').value,
                interview_time: document.getElementById('interviewTime').value,
                interview_mode: mode.value,
                meeting_link: mode.value === 'online' ? normalizeUrl(document.getElementById('meetingLink').value) : null,
                interview_location: mode.value === 'offline' ? document.getElementById('interviewLocation').value.trim() : null,
            };

            if (payload.interview_mode === 'online' && !isGoogleMeetLink(payload.meeting_link || '')) {
                throw new Error('Please paste a valid Google Meet link, for example https://meet.google.com/abc-defg-hij.');
            }

            const response = await fetch(`/api/company/applications/${applicationId}/interview`, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(payload),
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Unable to schedule interview.');
            }
            showMessage(result.message || 'Interview scheduled successfully.', 'success');
            setTimeout(() => window.location.href = '/company/interviews', 700);
        } catch (error) {
            showMessage(error.message || 'Something went wrong.');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Schedule';
        }
    });

    loadApplication().catch((error) => showMessage(error.message || 'Unable to load selected application.'));
</script>
@endpush
