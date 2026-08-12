@extends('layouts.company')

@section('title', 'My Profile - OnlyFreshers')
@section('pageTitle', 'My Profile')
@section('pageSubtitle', 'Manage your company profile and details.')

@php
    $activePage = 'profile';

    $infoCards = [
        ['title' => 'Company Size', 'value' => '51-100 Employees'],
        ['title' => 'Industry', 'value' => 'IT Services & Consulting'],
        ['title' => 'Company Type', 'value' => 'Private'],
        ['title' => 'Founded In', 'value' => '2018'],
    ];
@endphp

@section('content')
    <section class="min-h-[690px] rounded-lg border border-[#dce7f8] bg-white px-5 py-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:px-9 sm:py-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-bold text-[#061942]">Company Profile</h2>

            <a href="/company/profile/edit" class="inline-flex h-10 w-[118px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Edit Profile
            </a>
        </div>

        <div class="grid gap-8 xl:grid-cols-[1.25fr_0.95fr] xl:gap-[50px]">
            <div class="min-w-0 xl:pr-2">
                <div class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-center lg:gap-9">
                    <div data-company-profile-initial class="flex h-[110px] w-[110px] shrink-0 items-center justify-center rounded-full bg-[#075fe4] text-[50px] font-bold text-white sm:h-[145px] sm:w-[145px] sm:text-[68px]">
                        T
                    </div>

                    <div class="min-w-0">
                        <h3 data-company-profile-name class="mb-4 text-xl font-bold text-[#061942]">TechNova Solutions</h3>

                        <div class="my-3 flex items-center gap-4 text-sm text-[#24344f]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"></path><path d="M4 7l8 6 8-6"></path></svg>
                            </span>
                            <span data-company-profile-email class="break-all">info@technova.com</span>
                        </div>

                        <div class="my-3 flex items-center gap-4 text-sm text-[#24344f]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.4 19.4 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"></path></svg>
                            </span>
                            <span data-company-profile-phone>+91 98765 43210</span>
                        </div>

                        <div class="my-3 flex items-center gap-4 text-sm text-[#24344f]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"></path></svg>
                            </span>
                            <span data-company-profile-website>www.technova.com</span>
                        </div>
                    </div>
                </div>

                <div class="mb-10 h-px bg-[#dce7f8]"></div>

                <div>
                    <h3 class="mb-4 text-[17px] font-bold text-[#061942]">About Company</h3>
                    <p data-company-profile-description class="max-w-[570px] text-sm leading-relaxed text-[#24344f]">
                        We are a product based company building innovative solutions for businesses worldwide.
                    </p>
                </div>
            </div>

            <div class="grid gap-[18px]">
                @foreach ($infoCards as $card)
                    <article class="min-h-[122px] rounded-lg border border-[#dce7f8] bg-white px-[30px] py-[26px]">
                        <h3 class="mb-4 text-[15px] font-bold text-[#061942]">{{ $card['title'] }}</h3>
                        <p class="text-sm text-[#24344f]">{{ $card['value'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function hydrateCompanyProfile() {
        const token = localStorage.getItem('onlyfreshers_company_token');
        const storedUser = JSON.parse(localStorage.getItem('onlyfreshers_company_user') || 'null');

        const setText = (selector, value, fallback = '-') => {
            const el = document.querySelector(selector);
            if (el) el.textContent = value || fallback;
        };

        function setProfile(profile = {}) {
            const name = profile.company_name || storedUser?.name || 'Company';
            setText('[data-company-profile-name]', name);
            setText('[data-company-profile-email]', profile.email || storedUser?.email);
            setText('[data-company-profile-phone]', profile.phone, 'Not added');
            setText('[data-company-profile-website]', profile.website, 'Not added');
            setText('[data-company-profile-description]', profile.description, 'Company profile details are not added yet.');
            const initial = document.querySelector('[data-company-profile-initial]');
            if (initial) initial.textContent = name.trim().charAt(0).toUpperCase() || 'C';
        }

        setProfile({});

        if (!token) return;

        fetch('/api/company/profile', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
        })
            .then(response => response.json())
            .then(result => setProfile(result.data?.profile || {}))
            .catch(() => setProfile({}));
    })();
</script>
@endpush
