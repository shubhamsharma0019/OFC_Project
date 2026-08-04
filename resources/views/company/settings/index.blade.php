@extends('layouts.company')

@section('title', 'Account Settings - OnlyFreshers')
@section('pageTitle', 'Account Settings')
@section('pageSubtitle', 'Manage your account, preferences and security settings.')

@php
    $activePage = 'settings';

    $settingTabs = [
        ['key' => 'profile', 'title' => 'Company Profile', 'code' => 'CP'],
        ['key' => 'account', 'title' => 'Account Information', 'code' => 'AI'],
        ['key' => 'password', 'title' => 'Change Password', 'code' => 'PW'],
        ['key' => 'notifications', 'title' => 'Notification Preferences', 'code' => 'NP'],
        ['key' => 'privacy', 'title' => 'Privacy Settings', 'code' => 'PS'],
        ['key' => 'team', 'title' => 'Team Members', 'code' => 'TM'],
        ['key' => 'api', 'title' => 'API & Integrations', 'code' => 'API'],
        ['key' => 'delete', 'title' => 'Delete Account', 'code' => 'DL'],
    ];

    $company = [
        'name' => 'TechNova Solutions',
        'email' => 'hr@technovasolutions.com',
        'phone' => '+91 98765 43210',
        'website' => 'https://www.technovasolutions.com',
        'industry' => 'IT Services & Consulting',
        'size' => '51 - 200 Employees',
        'address' => '123, Business Park, Sector 62, Noida, Uttar Pradesh - 201309, India',
    ];

    $industries = ['IT Services & Consulting', 'Software Development', 'FinTech', 'Healthcare'];
    $sizes = ['1 - 10 Employees', '11 - 50 Employees', '51 - 200 Employees', '200+ Employees'];
@endphp

@section('content')
    <section class="grid min-h-[720px] overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)] xl:grid-cols-[240px_minmax(0,1fr)]">
        <aside class="border-b border-[#dce7f8] p-[18px] xl:border-b-0 xl:border-r xl:p-6 xl:px-[18px]">
            <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-1">
                @foreach ($settingTabs as $tab)
                    <button class="settings-tab flex min-h-11 w-full items-center gap-3.5 rounded-lg px-3.5 text-left text-[13px] {{ $loop->first ? 'active border-l-[3px] border-l-[#075fe4] bg-[#eaf2ff] font-bold text-[#075fe4]' : 'text-[#24344f]' }}" type="button" data-title="{{ $tab['title'] }}">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#edf4ff] text-[9px] font-extrabold text-[#075fe4]">{{ $tab['code'] }}</span>
                        {{ $tab['title'] }}
                    </button>
                @endforeach
            </div>
        </aside>

        <div class="p-5 sm:p-7 xl:px-[34px]">
            <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 id="settingTitle" class="mb-2.5 text-lg font-bold text-[#061942]">Company Profile</h2>
                    <p id="settingText" class="text-xs text-[#24344f]">Update your company details and branding.</p>
                </div>
                <a href="/company/profile" class="inline-flex h-10 w-[190px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">View Company Page &#8599;</a>
            </div>

            <div class="mb-7 grid grid-cols-1 gap-4 xl:grid-cols-[170px_170px_minmax(0,1fr)] xl:gap-x-7">
                <div class="text-xs font-bold text-[#061942] xl:col-span-2">Company Logo</div>
                <div class="text-xs font-bold text-[#061942]">Cover Image (Optional)</div>

                <div class="flex min-h-[150px] items-center justify-center rounded-lg border border-[#dce7f8] text-center">
                    <div>
                        <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-[#eaf2ff] text-[#075fe4]">OF</div>
                        <strong class="block text-xl text-[#075fe4]">TechNova</strong>
                        <span class="block text-[11px] tracking-[5px] text-[#52607a]">SOLUTIONS</span>
                    </div>
                </div>

                <button type="button" class="min-h-[150px] rounded-lg border border-dashed border-[#dce7f8] text-center text-xs text-[#24344f] transition hover:bg-[#f5f9ff]">
                    <span class="block text-2xl text-[#075fe4]">&#9729;</span>
                    <b class="my-2 block text-[13px] text-[#061942]">Upload New Logo</b>
                    <span>PNG, JPG up to 2MB</span>
                </button>

                <div class="relative min-h-[150px] rounded-lg border border-[#dce7f8] bg-gradient-to-br from-[#eef5ff] to-[#cfe1ff]">
                    <button class="absolute right-3.5 top-3.5 flex h-[38px] w-[38px] items-center justify-center rounded-full bg-white text-[#075fe4]" type="button" aria-label="Edit cover">&#9998;</button>
                </div>
            </div>

            <form id="settingsForm">
                <div class="grid grid-cols-1 gap-x-6 gap-y-[18px] md:grid-cols-2">
                    <div>
                        <label for="companyName" class="mb-2 block text-xs font-bold text-[#061942]">Company Name</label>
                        <input id="companyName" value="{{ $company['name'] }}" class="h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    </div>
                    <div>
                        <label for="industry" class="mb-2 block text-xs font-bold text-[#061942]">Industry</label>
                        <select id="industry" class="h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                            @foreach ($industries as $industry)
                                <option {{ $industry === $company['industry'] ? 'selected' : '' }}>{{ $industry }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-xs font-bold text-[#061942]">Company Email</label>
                        <input id="email" value="{{ $company['email'] }}" class="h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    </div>
                    <div>
                        <label for="phone" class="mb-2 block text-xs font-bold text-[#061942]">Company Phone</label>
                        <input id="phone" value="{{ $company['phone'] }}" class="h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    </div>
                    <div>
                        <label for="website" class="mb-2 block text-xs font-bold text-[#061942]">Company Website</label>
                        <input id="website" value="{{ $company['website'] }}" class="h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    </div>
                    <div>
                        <label for="size" class="mb-2 block text-xs font-bold text-[#061942]">Company Size</label>
                        <select id="size" class="h-[42px] w-full rounded-lg border border-[#dce7f8] px-3.5 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                            @foreach ($sizes as $size)
                                <option {{ $size === $company['size'] ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-xs font-bold text-[#061942]">Company Address</label>
                        <textarea id="address" class="min-h-[78px] w-full resize-y rounded-lg border border-[#dce7f8] p-3.5 text-[13px] leading-relaxed text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">{{ $company['address'] }}</textarea>
                    </div>
                </div>

                <div class="mt-[18px] flex justify-end gap-[18px]">
                    <a href="/company/profile" class="inline-flex h-[42px] w-[130px] items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4]">Cancel</a>
                    <button class="h-[42px] w-[130px] rounded-lg bg-[#075fe4] text-[13px] font-bold text-white" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const settingText = {
        'Company Profile': 'Update your company details and branding.',
        'Account Information': 'Manage login email and account ownership.',
        'Change Password': 'Update your account password securely.',
        'Notification Preferences': 'Control email and platform alerts.',
        'Privacy Settings': 'Manage profile visibility and data settings.',
        'Team Members': 'Invite and manage your hiring team.',
        'API & Integrations': 'Connect external tools and integrations.',
        'Delete Account': 'Permanently delete your company account.'
    };

    document.querySelectorAll('.settings-tab').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('.settings-tab').forEach(function (item) {
                item.classList.remove('active', 'border-l-[3px]', 'border-l-[#075fe4]', 'bg-[#eaf2ff]', 'font-bold', 'text-[#075fe4]');
                item.classList.add('text-[#24344f]');
            });
            button.classList.add('active', 'border-l-[3px]', 'border-l-[#075fe4]', 'bg-[#eaf2ff]', 'font-bold', 'text-[#075fe4]');
            button.classList.remove('text-[#24344f]');
            document.getElementById('settingTitle').textContent = button.dataset.title;
            document.getElementById('settingText').textContent = settingText[button.dataset.title];
        });
    });

    document.getElementById('settingsForm').addEventListener('submit', function (event) {
        event.preventDefault();
        alert('Settings saved.');
    });
</script>
@endpush


