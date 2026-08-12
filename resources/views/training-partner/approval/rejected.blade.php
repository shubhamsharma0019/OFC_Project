@extends('layouts.training-partner')

@section('title', 'Approval Rejected')

@php
    $activePage = 'dashboard';
@endphp

@section('content')
    <section class="grid gap-5">
        <div>
            <h1 class="mb-2 text-2xl font-bold text-[#071544]">Approval Rejected</h1>
            <p class="text-sm leading-relaxed text-[#526287]">Your approval needs changes before resubmission.</p>
        </div>

        <article class="rounded-lg border border-[#ffd7d7] bg-white p-6 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="min-w-0">
                    <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#fff4f4] text-sm font-black text-[#b42318]">RJ</span>
                    <h2 id="instituteName" class="mb-2 text-xl font-bold text-[#071544]">Loading...</h2>
                    <p class="max-w-2xl text-sm leading-7 text-[#526287]">Please review the reason below, update your profile, and submit again for approval.</p>
                </div>
                <span id="approvalBadge" class="inline-flex w-fit rounded-md bg-[#fff4f4] px-3 py-1 text-xs font-bold text-[#b42318]">Rejected</span>
            </div>

            <div class="mt-6 rounded-lg border border-[#ffd7d7] bg-[#fff8f8] p-4">
                <p class="mb-2 text-xs font-bold text-[#b42318]">Rejection Reason</p>
                <p id="rejectionReason" class="text-sm leading-7 text-[#26375f]">Loading...</p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-[#e7ebf5] p-4">
                    <p class="text-xs font-bold text-[#526287]">Email</p>
                    <strong id="email" class="mt-2 block break-words text-[#071544]">-</strong>
                </div>
                <div class="rounded-lg border border-[#e7ebf5] p-4">
                    <p class="text-xs font-bold text-[#526287]">Location</p>
                    <strong id="location" class="mt-2 block text-[#071544]">-</strong>
                </div>
                <div class="rounded-lg border border-[#e7ebf5] p-4">
                    <p class="text-xs font-bold text-[#526287]">Last Updated</p>
                    <strong id="updatedAt" class="mt-2 block text-[#071544]">-</strong>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="/training-partner/profile/edit" class="inline-flex h-10 items-center justify-center rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white">Update & Resubmit</a>
                <a href="/training-partner/profile" class="inline-flex h-10 items-center justify-center rounded-md border border-[#5b20e6] px-5 text-sm font-bold text-[#5b20e6]">View Profile</a>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');

    if (!token) {
        window.location.href = '/training-partner/login';
    }

    function setText(id, value) {
        const element = document.getElementById(id);
        if (element) element.textContent = value || '-';
    }

    async function loadRejectedStatus() {
        try {
            const response = await fetch('/api/training-partner/profile', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });

            if (response.status === 401) {
                window.location.href = '/training-partner/login';
                return;
            }

            const payload = await response.json();
            const profile = payload.data?.profile || null;
            localStorage.setItem('ofc_training_partner_profile', JSON.stringify(profile));

            if (!profile) {
                window.location.href = '/training-partner/profile/edit';
                return;
            }
            if (profile.approval_status === 'approved') {
                window.location.href = '/training-partner/dashboard';
                return;
            }
            if (profile.approval_status !== 'rejected') {
                window.location.href = '/training-partner/approval/pending';
                return;
            }

            document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: profile }));
            setText('instituteName', profile.institute_name);
            setText('email', profile.email);
            setText('location', profile.location);
            setText('updatedAt', profile.updated_at ? new Date(profile.updated_at).toLocaleDateString('en-IN') : '-');
            setText('rejectionReason', profile.rejection_reason || 'Admin ne specific reason add nahi kiya hai. Please profile details verify karke dobara submit karein.');
            document.getElementById('approvalBadge').textContent = profile.approval_status;
        } catch (error) {
            setText('rejectionReason', 'Approval status load nahi ho paaya. Please refresh karke check karein.');
        }
    }

    loadRejectedStatus();
</script>
@endpush
