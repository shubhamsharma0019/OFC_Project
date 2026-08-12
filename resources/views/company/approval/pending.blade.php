@extends('layouts.company')
@section('title', 'Approval Pending - OnlyFreshers')
@section('pageTitle', 'Approval Pending')
@section('pageSubtitle', 'Your company profile is awaiting approval.')
@php $activePage = 'profile'; @endphp
@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-8 text-center shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-[#fff0d1] text-2xl font-bold text-[#c86b00]">!</div>
    <h2 class="mb-2 text-xl font-bold text-[#061942]">Approval is pending</h2>
    <p id="pendingMessage" class="mx-auto max-w-xl text-sm leading-relaxed text-[#24344f]">Loading approval status...</p>
    <a href="/company/profile" class="mt-6 inline-flex h-11 items-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">View Profile</a>
</section>
@endsection
@push('scripts')
<script>
    async function loadApprovalPending() {
        const token = localStorage.getItem('ofc_auth_token');
        const message = document.getElementById('pendingMessage');

        if (!token) {
            window.location.href = '/company/login';
            return;
        }

        const response = await fetch('/api/company/profile', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
        });

        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            window.location.href = '/company/login';
            return;
        }

        const result = await response.json();
        const profile = result.data?.profile;

        if (!profile) {
            window.location.href = '/company/profile/edit';
            return;
        }

        localStorage.setItem('ofc_company_profile', JSON.stringify(profile));

        if (profile.approval_status === 'approved') {
            window.location.href = '/company/dashboard';
            return;
        }

        if (profile.approval_status === 'rejected') {
            window.location.href = '/company/approval/rejected';
            return;
        }

        message.textContent = `${profile.company_name || 'Your company'} profile has been submitted. Our admin team will review your details and activate hiring tools shortly.`;
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));
    }

    loadApprovalPending().catch(() => {
        document.getElementById('pendingMessage').textContent = 'Unable to load approval status.';
    });
</script>
@endpush
