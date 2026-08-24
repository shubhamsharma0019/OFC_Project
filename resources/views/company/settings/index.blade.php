@extends('layouts.company')

@section('title', 'Account Settings - OnlyFreshers')
@section('pageTitle', 'Account Settings')
@section('pageSubtitle', 'Manage your account, preferences and security settings.')

@php
    $activePage = 'settings';
    $settingTabs = [
        ['key' => 'profile', 'title' => 'Company Profile', 'code' => 'CP'],
        ['key' => 'account', 'title' => 'Account Information', 'code' => 'AI'],
        ['key' => 'security', 'title' => 'Security', 'code' => 'SC'],
        ['key' => 'notifications', 'title' => 'Notifications', 'code' => 'NT'],
    ];
@endphp

@section('content')
    <section class="grid min-h-[620px] overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)] xl:grid-cols-[240px_minmax(0,1fr)]">
        <aside class="border-b border-[#dce7f8] p-[18px] xl:border-b-0 xl:border-r xl:p-6 xl:px-[18px]">
            <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-1">
                @foreach ($settingTabs as $tab)
                    <button class="settings-tab flex min-h-11 w-full items-center gap-3.5 rounded-lg px-3.5 text-left text-[13px] {{ $loop->first ? 'active border-l-[3px] border-l-[#075fe4] bg-[#eaf2ff] font-bold text-[#075fe4]' : 'text-[#24344f]' }}" type="button" data-tab="{{ $tab['key'] }}">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#edf4ff] text-[9px] font-extrabold text-[#075fe4]">{{ $tab['code'] }}</span>
                        {{ $tab['title'] }}
                    </button>
                @endforeach
            </div>
        </aside>

        <div class="p-5 sm:p-7 xl:px-[34px]">
            <div id="statusMessage" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm"></div>

            <div class="settings-panel" data-panel="profile">
                <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="mb-2.5 text-lg font-bold text-[#061942]">Company Profile</h2>
                        <p class="text-xs text-[#24344f]">Update company details used across your company dashboard.</p>
                    </div>
                    <a href="/company/profile" class="inline-flex h-10 w-[190px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">View Company Page</a>
                </div>

                <div class="mb-7 grid grid-cols-1 gap-4 xl:grid-cols-[170px_minmax(0,1fr)] xl:gap-x-7">
                    <div class="flex min-h-[150px] items-center justify-center rounded-lg border border-[#dce7f8] text-center">
                        <div>
                            <div id="companyLogoInitial" class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-lg bg-[#075fe4] text-xl font-bold text-white">C</div>
                            <strong id="companyLogoName" class="block max-w-[150px] truncate text-xl text-[#075fe4]">Company</strong>
                            <span id="companyApprovalStatus" class="mt-2 inline-flex rounded-md bg-[#fff4df] px-2.5 py-1 text-[11px] font-bold text-[#b76b00]">Loading</span>
                        </div>
                    </div>

                    <div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5">
                        <h3 class="mb-2 text-sm font-bold text-[#061942]">Profile edit rule</h3>
                        <p id="profileRuleText" class="text-xs leading-relaxed text-[#334b83]">Loading profile status...</p>
                    </div>
                </div>

                <form id="settingsForm">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-[18px] md:grid-cols-2">
                        <div>
                            <label for="companyName" class="mb-2 block text-xs font-bold text-[#061942]">Company Name</label>
                            <input id="companyName" name="company_name" class="settings-input h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        </div>
                        <div>
                            <label for="industry" class="mb-2 block text-xs font-bold text-[#061942]">Industry</label>
                            <input id="industry" name="industry" class="settings-input h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        </div>
                        <div>
                            <label for="email" class="mb-2 block text-xs font-bold text-[#061942]">Company Email</label>
                            <input id="email" name="email" type="email" class="settings-input h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        </div>
                        <div>
                            <label for="phone" class="mb-2 block text-xs font-bold text-[#061942]">Company Phone</label>
                            <input id="phone" name="phone" class="settings-input h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        </div>
                        <div>
                            <label for="website" class="mb-2 block text-xs font-bold text-[#061942]">Company Website</label>
                            <input id="website" name="website" class="settings-input h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        </div>
                        <div>
                            <label for="description" class="mb-2 block text-xs font-bold text-[#061942]">About Company</label>
                            <input id="description" name="description" class="settings-input h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="mb-2 block text-xs font-bold text-[#061942]">Company Address</label>
                            <textarea id="address" name="address" class="settings-input min-h-[78px] w-full resize-y rounded-lg border border-[#dce7f8] p-3.5 text-[13px] leading-relaxed text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]"></textarea>
                        </div>
                    </div>

                    <div class="mt-[18px] flex justify-end gap-[18px]">
                        <a href="/company/profile" class="inline-flex h-[42px] w-[130px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4]">Cancel</a>
                        <button id="saveButton" class="h-[42px] w-[130px] rounded-lg bg-[#075fe4] text-[13px] font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>

            <div class="settings-panel hidden" data-panel="account">
                <h2 class="mb-2.5 text-lg font-bold text-[#061942]">Account Information</h2>
                <p class="mb-6 text-xs text-[#24344f]">Logged-in account details from your current session.</p>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-lg border border-[#dce7f8] p-5">
                        <p class="mb-2 text-xs font-bold text-[#52607a]">Name</p>
                        <h3 id="accountName" class="text-base font-bold text-[#061942]">-</h3>
                    </div>
                    <div class="rounded-lg border border-[#dce7f8] p-5">
                        <p class="mb-2 text-xs font-bold text-[#52607a]">Email</p>
                        <h3 id="accountEmail" class="break-words text-base font-bold text-[#061942]">-</h3>
                    </div>
                    <div class="rounded-lg border border-[#dce7f8] p-5">
                        <p class="mb-2 text-xs font-bold text-[#52607a]">Role</p>
                        <h3 id="accountRole" class="capitalize text-base font-bold text-[#061942]">-</h3>
                    </div>
                    <div class="rounded-lg border border-[#dce7f8] p-5">
                        <p class="mb-2 text-xs font-bold text-[#52607a]">Account Status</p>
                        <h3 id="accountStatus" class="capitalize text-base font-bold text-[#061942]">-</h3>
                    </div>
                </div>
            </div>

            <div class="settings-panel hidden" data-panel="security">
                <h2 class="mb-2.5 text-lg font-bold text-[#061942]">Security</h2>
                <p class="mb-6 text-xs text-[#24344f]">Manage active session for this device.</p>
                <button id="logoutButton" class="h-[42px] rounded-lg bg-[#075fe4] px-6 text-[13px] font-bold text-white" type="button">Logout This Device</button>
                <button id="logoutAllButton" class="ml-3 h-[42px] rounded-lg border border-[#dce7f8] px-6 text-[13px] font-bold text-[#075fe4]" type="button">Logout All Devices</button>
            </div>

            <div class="settings-panel hidden" data-panel="notifications">
                <h2 class="mb-2.5 text-lg font-bold text-[#061942]">Notifications</h2>
                <p class="mb-6 text-xs text-[#24344f]">Unread notifications are fetched from the live notification API.</p>
                <div class="rounded-lg border border-[#dce7f8] p-5">
                    <p class="mb-2 text-xs font-bold text-[#52607a]">Unread Notifications</p>
                    <h3 id="unreadCount" class="text-2xl font-bold text-[#075fe4]">0</h3>
                    <a href="/company/notifications" class="mt-4 inline-flex h-10 items-center rounded-lg border border-[#dce7f8] px-4 text-[13px] font-bold text-[#075fe4]">Open Notifications</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const storedUser = JSON.parse(localStorage.getItem('ofc_auth_user') || 'null');
    const statusMessage = document.getElementById('statusMessage');
    const saveButton = document.getElementById('saveButton');

    if (!token) {
        window.location.href = '/company/login';
    }

    function headers() {
        return {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token,
        };
    }

    function showMessage(message, type = 'success') {
        statusMessage.textContent = message;
        statusMessage.className = 'mb-5 rounded-lg border px-4 py-3 text-sm ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#ccebd8] bg-[#f0fff5] text-[#087443]');
    }

    function setValue(id, value) {
        const input = document.getElementById(id);
        if (input) input.value = value || '';
    }

    function fillAccount(user) {
        document.getElementById('accountName').textContent = user?.name || '-';
        document.getElementById('accountEmail').textContent = user?.email || '-';
        document.getElementById('accountRole').textContent = user?.role || '-';
        document.getElementById('accountStatus').textContent = user?.status || '-';
    }

    function fillProfile(profile) {
        setValue('companyName', profile?.company_name || storedUser?.name || '');
        setValue('industry', profile?.industry || '');
        setValue('email', profile?.email || storedUser?.email || '');
        setValue('phone', profile?.phone || '');
        setValue('website', profile?.website || '');
        setValue('description', profile?.description || '');
        setValue('address', profile?.address || '');

        const name = profile?.company_name || storedUser?.name || 'Company';
        document.getElementById('companyLogoInitial').textContent = name.charAt(0).toUpperCase();
        document.getElementById('companyLogoName').textContent = name;

        const status = profile?.approval_status || 'not submitted';
        document.getElementById('companyApprovalStatus').textContent = status;
        localStorage.setItem('ofc_company_profile', JSON.stringify(profile || null));
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));

        document.querySelectorAll('.settings-input').forEach((input) => {
            input.disabled = false;
            input.classList.remove('bg-[#f5f7fb]');
        });
        saveButton.disabled = false;
        document.getElementById('profileRuleText').textContent = status === 'approved'
            ? 'Your profile is approved. You can still update your company details.'
            : 'You can save changes. New or rejected profiles will be sent for admin review.';
    }

    async function loadSettings() {
        try {
            const [profileResponse, userResponse, unreadResponse] = await Promise.all([
                fetch('/api/company/profile', { headers: headers() }),
                fetch('/api/auth/profile', { headers: headers() }),
                fetch('/api/notifications/unread-count', { headers: headers() }),
            ]);

            if ([profileResponse, userResponse, unreadResponse].some((response) => response.status === 401)) {
                window.location.href = '/company/login';
                return;
            }

            const profilePayload = await profileResponse.json();
            const userPayload = await userResponse.json();
            const unreadPayload = await unreadResponse.json();

            const user = userPayload.data?.user || storedUser;
            localStorage.setItem('ofc_auth_user', JSON.stringify(user));
            fillAccount(user);
            fillProfile(profilePayload.data?.profile || null);
            document.getElementById('unreadCount').textContent = unreadPayload.data?.unread_count || 0;
        } catch (error) {
            showMessage('Settings load nahi ho paayi. Please refresh karke check karein.', 'error');
        }
    }

    document.querySelectorAll('.settings-tab').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.settings-tab').forEach((item) => {
                item.classList.remove('active', 'border-l-[3px]', 'border-l-[#075fe4]', 'bg-[#eaf2ff]', 'font-bold', 'text-[#075fe4]');
                item.classList.add('text-[#24344f]');
            });
            button.classList.add('active', 'border-l-[3px]', 'border-l-[#075fe4]', 'bg-[#eaf2ff]', 'font-bold', 'text-[#075fe4]');
            button.classList.remove('text-[#24344f]');
            document.querySelectorAll('.settings-panel').forEach((panel) => panel.classList.toggle('hidden', panel.dataset.panel !== button.dataset.tab));
        });
    });

    document.getElementById('settingsForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        saveButton.disabled = true;

        const form = new FormData(event.currentTarget);
        const website = form.get('website');
        if (website && !/^https?:\/\//i.test(website)) {
            form.set('website', 'https://' + website);
        }

        try {
            const response = await fetch('/api/company/profile', {
                method: 'POST',
                headers: headers(),
                body: form,
            });
            const payload = await response.json();
            if (!response.ok || !payload.success) {
                throw new Error(payload.message || 'Settings save nahi ho paayi.');
            }
            fillProfile(payload.data?.profile || null);
            showMessage(payload.message || 'Settings saved successfully.');
        } catch (error) {
            showMessage(error.message, 'error');
            saveButton.disabled = false;
        }
    });

    async function logout(endpoint) {
        await fetch(endpoint, {
            method: 'POST',
            headers: headers(),
        });
        localStorage.removeItem('ofc_auth_token');
        localStorage.removeItem('ofc_auth_user');
        localStorage.removeItem('ofc_company_profile');
        window.location.href = '/company/login';
    }

    document.getElementById('logoutButton').addEventListener('click', () => logout('/api/auth/logout'));
    document.getElementById('logoutAllButton').addEventListener('click', () => logout('/api/auth/logout-all'));

    fillAccount(storedUser);
    loadSettings();
</script>
@endpush
