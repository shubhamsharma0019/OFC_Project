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
                <div class="mb-5 flex items-center gap-4">
                    <div data-training-partner-initial class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#f3ecff] text-lg text-[#5b20e6]">TP</div>
                    <div class="min-w-0">
                        <h2 data-training-partner-name class="truncate text-lg text-[#071544]">Training Partner</h2>
                        <p class="mt-1 text-sm text-[#526287]">Training Partner Account</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-2 text-xs text-[#071544]">Institute Name
                        <input id="instituteName" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" value="Training Partner">
                    </label>
                    <label class="grid gap-2 text-xs text-[#071544]">Email
                        <input id="partnerEmail" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" value="trainingpartner@gmail.com">
                    </label>
                    <label class="grid gap-2 text-xs text-[#071544]">Phone
                        <input id="partnerPhone" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" value="1234567890">
                    </label>
                    <label class="grid gap-2 text-xs text-[#071544]">Location
                        <input id="partnerLocation" class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" value="Noida">
                    </label>
                </div>

                <div class="mt-5 border-t border-[#edf0f8] pt-5">
                    <h3 class="mb-4 text-base text-[#071544]">Change Password</h3>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <input class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="password" placeholder="Current password">
                        <input class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="password" placeholder="New password">
                        <input class="h-11 rounded-lg border border-[#dfe4f2] px-3 text-sm outline-none focus:border-[#5b20e6]" type="password" placeholder="Confirm password">
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap justify-end gap-3">
                    <button class="h-11 rounded-lg border border-[#dfe4f2] px-5 text-sm text-[#26375f]" type="button">Reset</button>
                    <button class="h-11 rounded-lg bg-[#5b20e6] px-6 text-sm text-white shadow-[0_12px_24px_rgba(91,32,230,0.18)]" type="button">Save Settings</button>
                </div>
            </article>

            <div class="grid gap-5">
                <article class="rounded-lg border border-[#dfe4f2] bg-white p-5 shadow-[0_12px_28px_rgba(34,23,91,0.05)]">
                    <h2 class="mb-4 text-lg text-[#071544]">Preferences</h2>
                    <div class="grid gap-3">
                        <div class="flex items-center justify-between rounded-lg border border-[#edf0f8] p-4">
                            <span class="text-sm text-[#071544]">Email Notifications</span>
                            <span class="rounded-md bg-[#e9fbf1] px-3 py-1 text-xs text-[#078346]">Enabled</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg border border-[#edf0f8] p-4">
                            <span class="text-sm text-[#071544]">Assessment Alerts</span>
                            <span class="rounded-md bg-[#e9fbf1] px-3 py-1 text-xs text-[#078346]">Enabled</span>
                        </div>
                        <div class="flex items-center justify-between rounded-lg border border-[#edf0f8] p-4">
                            <span class="text-sm text-[#071544]">Certificate Updates</span>
                            <span class="rounded-md bg-[#e9fbf1] px-3 py-1 text-xs text-[#078346]">Enabled</span>
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
    document.getElementById('settingsLogout')?.addEventListener('click', () => {
        document.getElementById('trainingPartnerLogout')?.click();
    });
</script>
@endpush
