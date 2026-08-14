@extends('layouts.admin')

@section('title', 'Settings - OnlyFreshers Admin')
@section('pageTitle', 'Settings')
@section('breadcrumb', 'Dashboard > Settings')

@php
    $activePage = 'settings';
@endphp

@push('styles')
<style>
    .admin-settings-page,
    .admin-settings-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-settings-page grid gap-5">
        <div id="settingsStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading settings...</article>
        </div>

        <div id="settingsMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <div class="grid gap-5 xl:grid-cols-[1.1fr_.9fr]">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="text-lg font-bold text-[#061942]">Admin Account</h2>
                <p class="mt-1 text-sm text-[#52607a]">Account details API se load aur update honge.</p>

                <form id="settingsForm" class="mt-5 grid gap-4">
                    <label class="grid gap-2 text-xs font-bold text-[#061942]">Name
                        <input name="name" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none" required>
                    </label>
                    <label class="grid gap-2 text-xs font-bold text-[#061942]">Email
                        <input name="email" type="email" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none" required>
                    </label>
                    <label class="grid gap-2 text-xs font-bold text-[#061942]">Mobile
                        <input name="mobile" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                    </label>

                    <div class="mt-2 border-t border-[#edf2fb] pt-4">
                        <h3 class="mb-3 text-sm font-bold text-[#061942]">Change Password</h3>
                        <div class="grid gap-4 lg:grid-cols-3">
                            <label class="grid gap-2 text-xs font-bold text-[#061942]">Current Password
                                <input name="current_password" type="password" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                            </label>
                            <label class="grid gap-2 text-xs font-bold text-[#061942]">New Password
                                <input name="password" type="password" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                            </label>
                            <label class="grid gap-2 text-xs font-bold text-[#061942]">Confirm Password
                                <input name="password_confirmation" type="password" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button id="resetForm" class="h-10 rounded-md border border-[#dce7f8] px-5 text-sm font-bold text-[#24344f]" type="button">Reset</button>
                        <button id="saveSettings" class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="submit">Save Settings</button>
                    </div>
                </form>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                <h2 class="text-lg font-bold text-[#061942]">Security & Preferences</h2>
                <div id="preferenceList" class="mt-5 grid gap-3">
                    <p class="text-sm text-[#52607a]">Loading preferences...</p>
                </div>
                <button id="logoutAllDevices" class="mt-5 h-10 rounded-md border border-[#ff1f2f] px-5 text-sm font-bold text-[#ff1f2f] disabled:cursor-not-allowed disabled:opacity-60" type="button">Logout All Devices</button>
            </article>
        </div>

        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <h2 class="text-lg font-bold text-[#061942]">Platform Controls</h2>
            <div id="platformControls" class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <p class="text-sm text-[#52607a] sm:col-span-2 xl:col-span-4">Loading platform controls...</p>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const form = document.getElementById('settingsForm');
    const settingsStats = document.getElementById('settingsStats');
    const settingsMessage = document.getElementById('settingsMessage');
    const preferenceList = document.getElementById('preferenceList');
    const platformControls = document.getElementById('platformControls');
    const saveSettings = document.getElementById('saveSettings');
    const resetForm = document.getElementById('resetForm');
    const logoutAllDevices = document.getElementById('logoutAllDevices');
    let adminUser = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function formatDate(value) { if (!value) return '-'; const date = new Date(value); return Number.isNaN(date.getTime()) ? value : date.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }); }
    const statIcons = {
        'Admin Status': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/><path d="M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5z"/></svg>',
        'Total Users': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'Pending Approvals': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/><path d="M8 3 6 5"/><path d="m18 5-2-2"/></svg>',
        Updated: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-2.64-6.36"/><path d="M21 3v6h-6"/><path d="M12 7v5l3 2"/></svg>',
    };
    function statCard(label, value, tone) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[label] || statIcons['Admin Status']}</span><p class="mt-4 text-xs text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function showMessage(message, type = 'success') {
        settingsMessage.textContent = message;
        settingsMessage.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }
    function setForm(user) {
        form.elements.name.value = user?.name || '';
        form.elements.email.value = user?.email || '';
        form.elements.mobile.value = user?.mobile || '';
        form.elements.current_password.value = '';
        form.elements.password.value = '';
        form.elements.password_confirmation.value = '';
    }
    function preferenceItem(label, active) {
        return `<div class="flex items-center justify-between rounded-lg border border-[#e4ecf8] p-4"><span class="font-bold text-[#061942]">${escapeHtml(label)}</span><span class="rounded-md ${active ? 'bg-[#e8f8ef] text-[#078346]' : 'bg-[#eef2f8] text-[#24344f]'} px-3 py-1 text-xs font-bold">${active ? 'Enabled' : 'Disabled'}</span></div>`;
    }
    function controlItem(label, value, href) {
        return `<a href="${href}" class="rounded-lg border border-[#e4ecf8] p-4 transition hover:border-[#075fe4]"><p class="text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h3 class="mt-2 text-2xl font-bold text-[#061942]">${escapeHtml(value)}</h3></a>`;
    }
    async function requestJson(url, options = {}) {
        const response = await fetch(url, { ...options, headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, ...(options.headers || {}) } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) {
            const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
            throw new Error(validationMessage || payload.message || 'Request failed.');
        }
        return payload;
    }
    async function loadSettings() {
        try {
            const [settingsPayload, dashboardPayload] = await Promise.all([
                requestJson('/api/admin/settings'),
                requestJson('/api/admin/dashboard'),
            ]);
            if (!settingsPayload || !dashboardPayload) return;
            adminUser = settingsPayload.data?.admin || {};
            const prefs = settingsPayload.data?.preferences || {};
            const stats = dashboardPayload.data?.statistics || {};
            localStorage.setItem('ofc_auth_user', JSON.stringify(adminUser));
            setForm(adminUser);

            settingsStats.innerHTML = [
                statCard('Admin Status', adminUser.status || '-', 'bg-[#e8f8ef] text-[#078346]'),
                statCard('Total Users', number(stats.total_users), 'bg-[#eaf2ff] text-[#075fe4]'),
                statCard('Pending Approvals', number(Number(stats.pending_companies || 0) + Number(stats.pending_training_partners || 0)), 'bg-[#fff4df] text-[#b86500]'),
                statCard('Updated', formatDate(adminUser.updated_at), 'bg-[#f3ecff] text-[#5b20e6]'),
            ].join('');

            preferenceList.innerHTML = [
                preferenceItem('Email Notifications', prefs.email_notifications),
                preferenceItem('Security Alerts', prefs.security_alerts),
                preferenceItem('Approval Alerts', prefs.approval_alerts),
            ].join('');

            platformControls.innerHTML = [
                controlItem('Freshers', number(stats.total_freshers), '/admin/freshers'),
                controlItem('Companies', number(stats.total_companies), '/admin/companies'),
                controlItem('Training Partners', number(stats.total_training_partners), '/admin/training-partners'),
                controlItem('Active Jobs', number(stats.active_jobs), '/admin/jobs'),
            ].join('');
        } catch (error) {
            showMessage(error.message || 'Settings load nahi ho paayi.', 'error');
            settingsStats.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-2 xl:col-span-4">Settings load nahi ho paayi.</article>';
        }
    }
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        saveSettings.disabled = true;
        saveSettings.textContent = 'Saving...';
        try {
            const data = Object.fromEntries(new FormData(form).entries());
            if (!data.password) {
                delete data.current_password;
                delete data.password;
                delete data.password_confirmation;
            }
            const payload = await requestJson('/api/admin/settings', { method: 'PUT', body: JSON.stringify(data) });
            adminUser = payload.data?.admin || adminUser;
            localStorage.setItem('ofc_auth_user', JSON.stringify(adminUser));
            setForm(adminUser);
            showMessage(payload.message || 'Settings saved successfully.');
            await loadSettings();
        } catch (error) {
            showMessage(error.message || 'Settings save nahi ho paayi.', 'error');
        } finally {
            saveSettings.disabled = false;
            saveSettings.textContent = 'Save Settings';
        }
    });
    resetForm.addEventListener('click', () => setForm(adminUser));
    logoutAllDevices.addEventListener('click', async () => {
        logoutAllDevices.disabled = true;
        try {
            await requestJson('/api/auth/logout-all', { method: 'POST' });
            localStorage.removeItem('ofc_auth_token');
            localStorage.removeItem('ofc_auth_user');
            localStorage.removeItem('onlyFreshersAdminLogin');
            window.location.href = '/admin/login';
        } catch (error) {
            showMessage(error.message || 'Logout all devices nahi ho paaya.', 'error');
            logoutAllDevices.disabled = false;
        }
    });
    loadSettings();
</script>
@endpush
