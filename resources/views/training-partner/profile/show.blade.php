@extends('layouts.training-partner')

@section('title', 'My Profile')

@php
    $activePage = 'profile';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">My Profile</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View and manage your institute profile details.</p>
            </div>
            <a href="/training-partner/profile/edit" class="inline-flex h-10 items-center justify-center rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white">Edit Profile</a>
        </div>

        <div id="profileStatus" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start">
                <div id="profileInitial" class="flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-[#f3ecff] text-3xl font-black text-[#5b20e6]">TP</div>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h2 id="instituteName" class="truncate text-2xl font-bold text-[#071544]">Loading...</h2>
                            <p id="instituteEmail" class="mt-2 text-sm text-[#526287]">Fetching profile details...</p>
                        </div>
                        <span id="approvalBadge" class="inline-flex w-fit rounded-md bg-[#fff0de] px-3 py-1 text-xs font-bold text-[#d06d00]">Loading</span>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">Phone</p><strong id="phone" class="mt-2 block break-words text-[#071544]">-</strong></div>
                        <div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">Location</p><strong id="location" class="mt-2 block break-words text-[#071544]">-</strong></div>
                        <div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">Website</p><a id="website" class="mt-2 block break-words font-bold text-[#5b20e6]" href="#">-</a></div>
                    </div>
                </div>
            </div>
        </article>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <h2 class="mb-4 text-lg font-bold text-[#071544]">About Institute</h2>
            <p id="aboutInstitute" class="text-sm leading-7 text-[#26375f]">Loading...</p>
        </article>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <h2 class="mb-4 text-lg font-bold text-[#071544]">Verification</h2>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-[#e7ebf5] p-4">
                    <p class="text-xs font-bold text-[#526287]">Document</p>
                    <strong id="documentStatus" class="mt-2 block text-[#071544]">-</strong>
                </div>
                <div class="rounded-lg border border-[#e7ebf5] p-4">
                    <p class="text-xs font-bold text-[#526287]">Last Updated</p>
                    <strong id="updatedAt" class="mt-2 block text-[#071544]">-</strong>
                </div>
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

    function showStatus(message, type = 'info') {
        const box = document.getElementById('profileStatus');
        box.textContent = message;
        box.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#dddff0] bg-white text-[#26375f]');
    }

    function badgeClass(status) {
        if (status === 'approved') return 'inline-flex w-fit rounded-md bg-[#e2f9ea] px-3 py-1 text-xs font-bold text-[#05843e]';
        if (status === 'rejected') return 'inline-flex w-fit rounded-md bg-[#fff4f4] px-3 py-1 text-xs font-bold text-[#b42318]';
        if (status === 'blocked') return 'inline-flex w-fit rounded-md bg-[#f2f4f7] px-3 py-1 text-xs font-bold text-[#344054]';
        return 'inline-flex w-fit rounded-md bg-[#fff0de] px-3 py-1 text-xs font-bold text-[#d06d00]';
    }

    async function loadProfile() {
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
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Profile load nahi ho paayi.');

            const user = payload.data?.user || {};
            const profile = payload.data?.profile || null;
            localStorage.setItem('ofc_auth_user', JSON.stringify(user));
            localStorage.setItem('ofc_training_partner_profile', JSON.stringify(profile));

            if (!profile) {
                showStatus('Training partner profile abhi complete nahi hai. Please profile complete karein.');
                setText('instituteName', user.name || 'Training Partner');
                setText('instituteEmail', user.email || '-');
                document.getElementById('profileInitial').textContent = (user.name || 'TP').slice(0, 2).toUpperCase();
                return;
            }

            const name = profile.institute_name || user.name || 'Training Partner';
            document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: profile }));
            setText('instituteName', name);
            setText('instituteEmail', profile.email || user.email);
            setText('phone', profile.phone);
            setText('location', profile.location);
            setText('aboutInstitute', profile.about_institute || 'No institute description added.');
            setText('documentStatus', profile.verification_document ? 'Uploaded' : 'Not uploaded');
            setText('updatedAt', profile.updated_at ? new Date(profile.updated_at).toLocaleDateString('en-IN') : '-');
            document.getElementById('profileInitial').textContent = name.split(/\s+/).map((word) => word[0]).join('').slice(0, 2).toUpperCase();

            const badge = document.getElementById('approvalBadge');
            badge.textContent = profile.approval_status || 'pending';
            badge.className = badgeClass(profile.approval_status);

            const website = document.getElementById('website');
            if (profile.website) {
                website.href = profile.website;
                website.textContent = profile.website;
            } else {
                website.removeAttribute('href');
                website.textContent = '-';
            }
        } catch (error) {
            showStatus(error.message || 'Profile load nahi ho paayi.', 'error');
        }
    }

    loadProfile();
</script>
@endpush
