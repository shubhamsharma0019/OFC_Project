@extends('layouts.training-partner')

@section('title', 'Edit Profile')

@php
    $activePage = 'profile';
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Edit Profile</h1>
                <p class="text-sm leading-relaxed text-[#526287]">Update institute information and verification details.</p>
            </div>
            <a href="/training-partner/profile" class="inline-flex h-10 items-center justify-center rounded-md border border-[#5b20e6] px-5 text-sm font-bold text-[#5b20e6]">View Profile</a>
        </div>

        <div id="profileMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
            <form id="profileForm" class="grid gap-4 lg:grid-cols-2">
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Institute Name <span class="text-[#ff3045]">*</span><input name="institute_name" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" required></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Email<input name="email" type="email" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Phone<input name="phone" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Location<input name="location" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">Website<input name="website" class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" placeholder="https://example.com"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Institute Logo<input name="institute_logo" type="file" accept=".jpg,.jpeg,.png,.webp" class="rounded-md border border-[#cfd8eb] px-3 py-2 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544]">Verification Document<input name="verification_document" type="file" accept=".pdf,.jpg,.jpeg,.png" class="rounded-md border border-[#cfd8eb] px-3 py-2 text-sm font-medium outline-none"></label>
                <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">About Institute<textarea name="about_institute" class="min-h-32 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none"></textarea></label>

                <div class="flex justify-end gap-3 lg:col-span-2">
                    <a href="/training-partner/profile" class="inline-flex h-10 items-center justify-center rounded-md border border-[#cfd8eb] px-5 text-sm font-bold text-[#26375f]">Cancel</a>
                    <button id="saveButton" class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="submit">Save Changes</button>
                </div>
            </form>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const form = document.getElementById('profileForm');
    const messageBox = document.getElementById('profileMessage');
    const saveButton = document.getElementById('saveButton');

    if (!token) {
        window.location.href = '/training-partner/login';
    }

    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }

    function setField(name, value) {
        const field = form.elements[name];
        if (field && field.type !== 'file') field.value = value || '';
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
            const profile = payload.data?.profile || {};
            localStorage.setItem('ofc_auth_user', JSON.stringify(user));
            localStorage.setItem('ofc_training_partner_profile', JSON.stringify(profile || null));

            setField('institute_name', profile.institute_name || user.name || '');
            setField('email', profile.email || user.email || '');
            setField('phone', profile.phone || '');
            setField('location', profile.location || '');
            setField('website', profile.website || '');
            setField('about_institute', profile.about_institute || '');
            document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: profile }));
        } catch (error) {
            showMessage(error.message || 'Profile load nahi ho paayi.', 'error');
        }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        const data = new FormData(form);
        const website = data.get('website');
        if (website && !/^https?:\/\//i.test(website)) {
            data.set('website', 'https://' + website);
        }

        try {
            const response = await fetch('/api/training-partner/profile', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: data,
            });
            const payload = await response.json();
            if (!response.ok || !payload.success) {
                const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
                throw new Error(validationMessage || payload.message || 'Profile save nahi ho paayi.');
            }
            localStorage.setItem('ofc_training_partner_profile', JSON.stringify(payload.data?.profile || null));
            showMessage(payload.message || 'Profile saved successfully.');
            setTimeout(() => {
                window.location.href = '/training-partner/approval/pending';
            }, 700);
        } catch (error) {
            showMessage(error.message || 'Profile save nahi ho paayi.', 'error');
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Changes';
        }
    });

    loadProfile();
</script>
@endpush
