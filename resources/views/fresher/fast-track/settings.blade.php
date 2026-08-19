@extends('layouts.fast-track')

@section('title', 'Settings')

@php
    $activePage = 'settings';
@endphp

@push('styles')
<style>
    .settings-panel {
        border: 1px solid #dce7f8;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(6, 25, 66, .045);
    }

    .settings-select {
        height: 46px;
        width: 100%;
        border: 1px solid #cfe0ff;
        border-radius: 8px;
        background: #fff;
        padding: 0 14px;
        color: #061942;
        font-size: 14px;
        font-weight: 700;
        outline: none;
    }

    .field label {
        display: block;
        margin-bottom: 8px;
        color: #334b83;
        font-size: 12px;
        font-weight: 700;
    }

    .field input,
    .field textarea {
        width: 100%;
        border: 1px solid #cfe0ff;
        border-radius: 8px;
        background: #fff;
        padding: 11px 13px;
        color: #061942;
        font-size: 14px;
        outline: none;
    }

    .field textarea {
        min-height: 92px;
        resize: vertical;
    }

    .field input:disabled,
    .field textarea:disabled {
        background: #f4f7fb;
        color: #6f7ea0;
    }

    .toggle-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 48px;
        gap: 16px;
        align-items: center;
        border-bottom: 1px solid #edf2fa;
        padding: 15px 0;
    }

    .toggle-row:last-child {
        border-bottom: 0;
    }

    .switch {
        position: relative;
        height: 25px;
        width: 46px;
        border-radius: 999px;
        background: #dfe7f5;
    }

    .switch::before {
        content: "";
        position: absolute;
        top: 3px;
        left: 3px;
        height: 19px;
        width: 19px;
        border-radius: 999px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(6, 25, 66, .14);
        transition: left .16s ease;
    }

    .switch.on {
        background: #075fe4;
    }

    .switch.on::before {
        left: 24px;
    }
</style>
@endpush

@section('content')
    <section class="space-y-6">
        <div>
            <h1 class="text-[27px] font-bold leading-tight text-[#061942]">Settings</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Manage your Fast Track profile, notifications and account security.</p>
        </div>

        <div id="settingsAlert" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <article class="settings-panel p-6">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 id="settingsTitle" class="text-lg font-bold text-[#061942]">Profile Settings</h2>
                        <p id="settingsCopy" class="mt-1 text-sm text-[#334b83]">Update your personal details used across Fast Track.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:w-[230px]">
                        <select id="settingsSectionSelect" class="settings-select">
                            <option value="profile">Profile Settings</option>
                            <option value="notifications">Notifications</option>
                            <option value="password">Password</option>
                        </select>
                        <button id="editProfileBtn" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#075fe4] px-5 text-sm font-bold text-[#075fe4]" type="button">Edit</button>
                    </div>
                </div>
                <div id="settingsPanel">Loading settings...</div>
            </article>

            <aside class="settings-panel p-6">
                <h2 class="mb-4 text-lg font-bold text-[#061942]">Account Status</h2>
                <div class="mb-4 h-2.5 overflow-hidden rounded-full bg-[#e9edf5]">
                    <span id="profileCompletionBar" class="block h-full rounded-full bg-[#075fe4]" style="width:0%"></span>
                </div>
                <p id="profileCompletionText" class="mb-5 text-sm font-bold text-[#334b83]">0% Completed</p>
                <div id="settingsQuickLinks" class="grid gap-3 text-sm"></div>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const settingsPanel = document.getElementById('settingsPanel');
    const settingsTitle = document.getElementById('settingsTitle');
    const settingsCopy = document.getElementById('settingsCopy');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const settingsAlert = document.getElementById('settingsAlert');
    const profileCompletionBar = document.getElementById('profileCompletionBar');
    const profileCompletionText = document.getElementById('profileCompletionText');
    const settingsQuickLinks = document.getElementById('settingsQuickLinks');
    const settingsSectionSelect = document.getElementById('settingsSectionSelect');
    let activeSettingsTab = 'profile';
    let editingProfile = false;
    let profile = {};
    let user = FastTrack.user() || {};
    let prefs = JSON.parse(localStorage.getItem('fast_track_settings_prefs') || '{}');

    function showSettingsAlert(message, type = 'success') {
        settingsAlert.textContent = message;
        settingsAlert.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }

    function inputField(label, key, value, disabled = false) {
        return `<div class="field"><label>${label}</label><input data-setting-input="${key}" value="${FastTrack.esc(value || '')}" ${disabled ? 'disabled' : ''}></div>`;
    }

    function renderProfile() {
        settingsTitle.textContent = 'Profile Settings';
        settingsCopy.textContent = 'Update your personal details used across Fast Track.';
        editProfileBtn.style.display = 'inline-flex';
        editProfileBtn.textContent = editingProfile ? 'Cancel' : 'Edit';
        settingsPanel.innerHTML = `
            <div class="grid gap-5 md:grid-cols-2">
                ${inputField('Full Name', 'name', user.name, true)}
                ${inputField('Email', 'email', user.email, true)}
                ${inputField('Phone', 'phone', profile.phone || user.mobile, !editingProfile)}
                ${inputField('City', 'city', profile.city, !editingProfile)}
                ${inputField('Qualification', 'qualification', profile.qualification, !editingProfile)}
                ${inputField('College Name', 'college_name', profile.college_name, !editingProfile)}
                <div class="field md:col-span-2"><label>Skills</label><textarea data-setting-input="skills" ${editingProfile ? '' : 'disabled'}>${FastTrack.esc(profile.skills || '')}</textarea></div>
                <div class="md:col-span-2 flex justify-end">
                    <button id="saveProfileSettings" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white disabled:opacity-60" type="button" ${editingProfile ? '' : 'disabled'}>Save Changes</button>
                </div>
            </div>`;
        document.getElementById('saveProfileSettings')?.addEventListener('click', saveProfile);
    }

    function renderNotifications() {
        settingsTitle.textContent = 'Notifications';
        settingsCopy.textContent = 'Choose which Fast Track updates you want to receive.';
        editProfileBtn.style.display = 'none';
        const rows = [
            ['training_updates', 'Training Updates', 'Progress changes from training partner records'],
            ['certificate_updates', 'Certificate Updates', 'Certificate issue and verification updates'],
            ['job_alerts', 'Job Alerts', 'Recommended jobs after certification'],
            ['application_updates', 'Application Updates', 'Application and interview status changes'],
        ];
        settingsPanel.innerHTML = rows.map(([key, title, text]) => `<div class="toggle-row"><div><h3 class="font-bold text-[#061942]">${title}</h3><p class="mt-1 text-sm text-[#334b83]">${text}</p></div><button class="switch ${prefs[key] ?? true ? 'on' : ''}" data-pref="${key}" type="button"></button></div>`).join('');
        settingsPanel.querySelectorAll('[data-pref]').forEach((button) => button.addEventListener('click', function () {
            prefs[this.dataset.pref] = !(prefs[this.dataset.pref] ?? true);
            localStorage.setItem('fast_track_settings_prefs', JSON.stringify(prefs));
            render();
        }));
    }

    function renderPassword() {
        settingsTitle.textContent = 'Password';
        settingsCopy.textContent = 'Update your login password securely.';
        editProfileBtn.style.display = 'none';
        settingsPanel.innerHTML = `
            <div class="grid gap-5 md:grid-cols-2">
                ${inputField('Current Password', 'current_password', '')}
                ${inputField('New Password', 'password', '')}
                ${inputField('Confirm Password', 'password_confirmation', '')}
                <div class="md:col-span-2 flex justify-end">
                    <button id="savePasswordSettings" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white" type="button">Update Password</button>
                </div>
            </div>`;
        document.getElementById('savePasswordSettings')?.addEventListener('click', savePassword);
    }

    function renderSide() {
        const completion = Math.max(0, Math.min(100, Number(profile.profile_completion || 0)));
        profileCompletionBar.style.width = completion + '%';
        profileCompletionText.textContent = completion + '% Completed';
        settingsQuickLinks.innerHTML = [
            ['My Profile', '/fast-track/profile'],
            ['My Training', '/fast-track/training'],
            ['Certificate', '/fast-track/certificate'],
        ].map(([label, href]) => `<a class="rounded-lg border border-[#dce7f8] px-4 py-3 font-bold text-[#075fe4] hover:bg-[#eff5ff]" href="${href}">${label}</a>`).join('');
    }

    function render() {
        settingsSectionSelect.value = activeSettingsTab;
        ({ profile: renderProfile, notifications: renderNotifications, password: renderPassword })[activeSettingsTab]();
        renderSide();
    }

    function readSettingsInputs() {
        const data = {};
        settingsPanel.querySelectorAll('[data-setting-input]').forEach((input) => data[input.dataset.settingInput] = input.value);
        return data;
    }

    async function saveProfile() {
        const data = readSettingsInputs();
        try {
            const result = await FastTrack.postJson('/api/fresher/profile', {
                phone: data.phone,
                city: data.city,
                qualification: data.qualification,
                college_name: data.college_name,
                skills: data.skills,
            });
            profile = FastTrack.apiData(result, 'profile') || profile;
            editingProfile = false;
            showSettingsAlert('Settings saved successfully.');
            render();
        } catch (error) {
            showSettingsAlert(error.message || 'Settings save nahi ho paayi.', 'error');
        }
    }

    async function savePassword() {
        const data = readSettingsInputs();
        try {
            const response = await fetch('/api/auth/password', {
                method: 'PATCH',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    ...(FastTrack.token() ? { Authorization: 'Bearer ' + FastTrack.token() } : {}),
                },
                body: JSON.stringify(data),
            });
            const result = await response.json().catch(() => ({}));
            if (!response.ok || result.success === false) {
                throw new Error(result.message || 'Password update nahi ho paaya.');
            }
            showSettingsAlert('Password updated successfully.');
            renderPassword();
        } catch (error) {
            showSettingsAlert(error.message || 'Password update nahi ho paaya.', 'error');
        }
    }

    settingsSectionSelect.addEventListener('change', function () {
        activeSettingsTab = this.value;
        editingProfile = false;
        render();
    });

    editProfileBtn.addEventListener('click', function () {
        editingProfile = !editingProfile;
        render();
    });

    FastTrack.getJson('/api/fresher/profile')
        .then((result) => {
            profile = FastTrack.apiData(result, 'profile') || FastTrack.apiData(result, 'fresher_profile') || {};
            user = FastTrack.apiData(result, 'user') || user;
            render();
        })
        .catch(() => render());
</script>
@endpush
