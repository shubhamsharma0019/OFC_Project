@extends('layouts.company')
@section('title', 'Approval Rejected - OnlyFreshers')
@section('pageTitle', 'Approval Rejected')
@section('pageSubtitle', 'Review the reason and update your company profile.')
@php $activePage = 'profile'; @endphp
@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-8 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
    <div class="mb-5 flex items-center gap-4"><div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#ffe8eb] text-xl font-bold text-[#ff3045]">X</div><div><h2 class="text-xl font-bold text-[#061942]">Profile needs updates</h2><p id="rejectedSubtitle" class="text-sm text-[#24344f]">Loading rejection details...</p></div></div>
    <div id="rejectionReason" class="rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm text-[#24344f]">Loading...</div>
    <a href="/company/profile/edit" class="mt-6 inline-flex h-11 items-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">Update Profile</a>
</section>
@endsection
@push('scripts')
<script>
    async function loadApprovalRejected() {
        const token = localStorage.getItem('ofc_auth_token');
        const subtitle = document.getElementById('rejectedSubtitle');
        const reason = document.getElementById('rejectionReason');

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

        if (profile.approval_status === 'pending') {
            window.location.href = '/company/approval/pending';
            return;
        }

        subtitle.textContent = `${profile.company_name || 'Your company'} profile was rejected. Please correct the details and resubmit.`;
        reason.textContent = profile.rejection_reason || 'Admin has requested corrections. Please update your company profile and submit it again.';
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));
    }

    loadApprovalRejected().catch(() => {
        document.getElementById('rejectedSubtitle').textContent = 'Unable to load rejection details.';
        document.getElementById('rejectionReason').textContent = 'Please try again after refreshing the page.';
    });
</script>
@endpush
