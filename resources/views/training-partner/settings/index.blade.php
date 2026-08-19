@extends('layouts.training-partner')

@section('title', 'Settings - Training Partner')

@php
    $activePage = 'settings';
@endphp

@section('content')
    <div class="grid gap-5">
        <div>
            <h1 class="mb-2 text-[30px] leading-tight text-[#071544]">Settings</h1>
            <p class="m-0 text-sm text-[#526287]">Manage your account, profile preferences and security options.</p>
        </div>

        <div class="grid gap-5 xl:grid-cols-[1.1fr_.9fr]">
            <article class="rounded-lg border border-[#dfe4f2] bg-white p-5 shadow-[0_12px_28px_rgba(34,23,91,0.05)]">
                <div id="settingsMessage" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>
                <div class="mb-5 flex items-center gap-4">
                    <div data-training-partner-initial class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#f3ecff] text-lg text-[#5b20e6]">TP</div>
                    <div class="min-w-0">
                        <h2 data-training-partner-name class="truncate text-lg text-[#071544]">Training Partner</h2>
                        <p class="mt-1 text-sm text-[#526287]">Training Partner Account</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-2 text-xs text-[#071544]">Institute Name
                        <input id="instituteName" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]">
                    </label>
                    <label class="grid gap-2 text-xs text-[#071544]">Email
                        <input id="partnerEmail" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="email">
                    </label>
                    <label class="grid gap-2 text-xs text-[#071544]">Phone
                        <input id="partnerPhone" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]">
                    </label>
                    <label class="grid gap-2 text-xs text-[#071544]">Location
                        <input id="partnerLocation" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]">
                    </label>
                </div>

                <div class="mt-5 border-t border-[#edf0f8] pt-5">
                    <h3 class="mb-4 text-base text-[#071544]">Change Password</h3>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <input id="currentPassword" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="password" placeholder="Current password" autocomplete="current-password">
                        <input id="newPassword" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="password" placeholder="New password" autocomplete="new-password">
                        <input id="confirmPassword" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="password" placeholder="Confirm password" autocomplete="new-password">
                    </div>
                    <p class="mt-3 text-xs text-[#526287]">Password fields are optional. Fill all three only when you want to change password.</p>
                </div>

                <div class="mt-6 flex flex-wrap justify-end gap-3">
                    <button id="resetSettings" class="h-11 rounded-lg border border-[#dfe4f2] px-5 text-sm text-[#26375f]" type="button">Reset</button>
                    <button id="saveSettings" class="h-11 rounded-lg bg-[#5b20e6] px-6 text-sm text-white shadow-[0_12px_24px_rgba(91,32,230,0.18)]" type="button">Save Settings</button>
                </div>
            </article>

            <div class="grid gap-5">
                <article class="rounded-lg border border-[#dfe4f2] bg-white p-5 shadow-[0_12px_28px_rgba(34,23,91,0.05)]">
                    <h2 class="mb-4 text-lg text-[#071544]">Preferences</h2>
                    <div class="grid gap-3">
                        <div class="flex items-center justify-between rounded-lg border border-[#edf0f8] p-4">
                            <span class="text-sm text-[#071544]">Email Notifications</span>
                            <button class="preference-toggle rounded-md px-3 py-1 text-xs" type="button" data-key="email_notifications">Enabled</button>
                        </div>
                        <div class="flex items-center justify-between rounded-lg border border-[#edf0f8] p-4">
                            <span class="text-sm text-[#071544]">Assessment Alerts</span>
                            <button class="preference-toggle rounded-md px-3 py-1 text-xs" type="button" data-key="assessment_alerts">Enabled</button>
                        </div>
                        <div class="flex items-center justify-between rounded-lg border border-[#edf0f8] p-4">
                            <span class="text-sm text-[#071544]">Certificate Updates</span>
                            <button class="preference-toggle rounded-md px-3 py-1 text-xs" type="button" data-key="certificate_updates">Enabled</button>
                        </div>
                    </div>
                </article>

                <article class="rounded-lg border border-[#dfe4f2] bg-white p-5 shadow-[0_12px_28px_rgba(34,23,91,0.05)]">
                    <h2 class="mb-4 text-lg text-[#071544]">Account Actions</h2>
                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                        <a href="/training-partner/profile" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#dfe4f2] text-sm text-[#5b20e6]">View Profile</a>
                        <button id="settingsLogout" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#ffd1d7] text-sm text-[#ff3045]" type="button">Logout</button>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const settingsMessage = document.getElementById('settingsMessage');
    const fields = {
        instituteName: document.getElementById('instituteName'),
        partnerEmail: document.getElementById('partnerEmail'),
        partnerPhone: document.getElementById('partnerPhone'),
        partnerLocation: document.getElementById('partnerLocation'),
        currentPassword: document.getElementById('currentPassword'),
        newPassword: document.getElementById('newPassword'),
        confirmPassword: document.getElementById('confirmPassword'),
    };
    const saveSettings = document.getElementById('saveSettings');
    const resetSettings = document.getElementById('resetSettings');
    let loadedUser = {};
    let loadedProfile = {};

    if (!token) window.location.href = '/training-partner/login';

    function showSettingsMessage(message, type = 'success') {
        settingsMessage.textContent = message;
        settingsMessage.className = 'mb-5 rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }
    function initials(value) {
        return String(value || 'TP').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'TP';
    }
    function setFieldValues() {
        fields.instituteName.value = loadedProfile.institute_name || loadedUser.name || '';
        fields.partnerEmail.value = loadedProfile.email || loadedUser.email || '';
        fields.partnerPhone.value = loadedProfile.phone || '';
        fields.partnerLocation.value = loadedProfile.location || '';
        fields.currentPassword.value = '';
        fields.newPassword.value = '';
        fields.confirmPassword.value = '';
        document.querySelectorAll('[data-training-partner-name]').forEach((item) => item.textContent = fields.instituteName.value || 'Training Partner');
        document.querySelectorAll('[data-training-partner-initial]').forEach((item) => item.textContent = initials(fields.instituteName.value || loadedUser.name));
    }
    function loadPreferences() {
        const defaults = { email_notifications: true, assessment_alerts: true, certificate_updates: true };
        try {
            return { ...defaults, ...JSON.parse(localStorage.getItem('ofc_training_partner_preferences') || '{}') };
        } catch (error) {
            return defaults;
        }
    }
    function savePreferences(preferences) {
        localStorage.setItem('ofc_training_partner_preferences', JSON.stringify(preferences));
        renderPreferences(preferences);
    }
    function renderPreferences(preferences = loadPreferences()) {
        document.querySelectorAll('.preference-toggle').forEach((button) => {
            const enabled = Boolean(preferences[button.dataset.key]);
            button.textContent = enabled ? 'Enabled' : 'Disabled';
            button.className = 'preference-toggle rounded-md px-3 py-1 text-xs ' + (enabled
                ? 'bg-[#e9fbf1] text-[#078346]'
                : 'bg-[#f2f4f7] text-[#526287]');
        });
    }
    async function loadSettings() {
        try {
            const response = await fetch('/api/training-partner/profile', {
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
            });
            if (response.status === 401) { window.location.href = '/training-partner/login'; return; }
            const payload = await response.json();
            if (!response.ok || !payload.success) throw new Error(payload.message || 'Settings load nahi ho paayi.');
            loadedUser = payload.data?.user || {};
            loadedProfile = payload.data?.profile || {};
            localStorage.setItem('ofc_auth_user', JSON.stringify(loadedUser));
            localStorage.setItem('ofc_training_partner_profile', JSON.stringify(loadedProfile || null));
            setFieldValues();
            renderPreferences();
            document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: loadedProfile }));
        } catch (error) {
            showSettingsMessage(error.message || 'Settings load nahi ho paayi.', 'error');
            renderPreferences();
        }
    }
    async function saveProfileSettings() {
        saveSettings.disabled = true;
        saveSettings.textContent = 'Saving...';
        const data = new FormData();
        data.set('institute_name', fields.instituteName.value.trim() || loadedUser.name || 'Training Partner');
        data.set('email', fields.partnerEmail.value.trim());
        data.set('phone', fields.partnerPhone.value.trim());
        data.set('location', fields.partnerLocation.value.trim());
        if (loadedProfile.website) data.set('website', loadedProfile.website);
        if (loadedProfile.about_institute) data.set('about_institute', loadedProfile.about_institute);

        try {
            const response = await fetch('/api/training-partner/profile', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token },
                body: data,
            });
            const payload = await response.json();
            if (!response.ok || !payload.success) {
                const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
                throw new Error(validationMessage || payload.message || 'Settings save nahi ho paayi.');
            }
            loadedProfile = payload.data?.profile || {};
            localStorage.setItem('ofc_training_partner_profile', JSON.stringify(loadedProfile));
            setFieldValues();
            await savePasswordIfNeeded();
            showSettingsMessage('Settings saved successfully.');
            document.dispatchEvent(new CustomEvent('training-partner-profile-loaded', { detail: loadedProfile }));
        } catch (error) {
            showSettingsMessage(error.message || 'Settings save nahi ho paayi.', 'error');
        } finally {
            saveSettings.disabled = false;
            saveSettings.textContent = 'Save Settings';
        }
    }
    async function savePasswordIfNeeded() {
        const current = fields.currentPassword.value.trim();
        const password = fields.newPassword.value.trim();
        const confirmation = fields.confirmPassword.value.trim();

        if (!current && !password && !confirmation) return;
        if (!current || !password || !confirmation) throw new Error('Password change ke liye teeno password fields fill karo.');
        if (password.length < 8) throw new Error('New password minimum 8 characters ka hona chahiye.');
        if (password !== confirmation) throw new Error('New password aur confirm password match nahi kar rahe.');

        const response = await fetch('/api/auth/password', {
            method: 'PATCH',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
            },
            body: JSON.stringify({
                current_password: current,
                password,
                password_confirmation: confirmation,
            }),
        });
        const payload = await response.json();
        if (!response.ok || !payload.success) {
            const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
            throw new Error(validationMessage || payload.message || 'Password update nahi ho paaya.');
        }
        fields.currentPassword.value = '';
        fields.newPassword.value = '';
        fields.confirmPassword.value = '';
    }

    saveSettings.addEventListener('click', saveProfileSettings);
    resetSettings.addEventListener('click', setFieldValues);
    document.querySelectorAll('.preference-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const preferences = loadPreferences();
            preferences[button.dataset.key] = !preferences[button.dataset.key];
            savePreferences(preferences);
            showSettingsMessage('Preference updated.');
        });
    });
    document.getElementById('settingsLogout')?.addEventListener('click', () => {
        document.getElementById('trainingPartnerLogout')?.click();
    });
    loadSettings();
</script>
@endpush
