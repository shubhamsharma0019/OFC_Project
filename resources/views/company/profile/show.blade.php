@extends('layouts.company')

@section('title', 'My Profile - OnlyFreshers')
@section('pageTitle', 'My Profile')
@section('pageSubtitle', 'Manage your company profile and details.')

@php $activePage = 'profile'; @endphp

@section('content')
    <section class="min-h-[690px] rounded-lg border border-[#dce7f8] bg-white px-4 py-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:px-6 sm:py-7 xl:px-9 xl:py-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-[#061942]">Company Profile</h2>
                <p id="approvalStatus" class="mt-2 hidden text-xs font-bold"></p>
            </div>

            <a href="/company/profile/edit" class="inline-flex h-10 w-[118px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Edit Profile
            </a>
        </div>

        <div id="profileLoading" class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]">
            Loading company profile...
        </div>

        <div id="emptyProfile" class="hidden rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-6">
            <h3 class="mb-2 text-lg font-bold text-[#061942]">Complete your company profile</h3>
            <p class="mb-5 max-w-2xl text-sm leading-relaxed text-[#24344f]">
                Documentation ke flow ke according company account create hone ke baad profile complete karni hoti hai. Uske baad profile admin approval ke liye pending rahegi.
            </p>
            <a href="/company/profile/edit" class="inline-flex h-11 items-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">Complete Profile</a>
        </div>

        <div id="profileContent" class="hidden grid gap-7 xl:grid-cols-[minmax(0,1.2fr)_minmax(300px,0.9fr)] xl:gap-[50px]">
            <div class="min-w-0 xl:pr-2">
                <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center lg:gap-8">
                    <div id="companyInitial" class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full bg-[#075fe4] text-[44px] font-bold text-white sm:h-[132px] sm:w-[132px] sm:text-[62px] xl:h-[145px] xl:w-[145px] xl:text-[68px]">
                        C
                    </div>

                    <div class="min-w-0">
                        <h3 id="companyName" class="mb-4 break-words text-xl font-bold text-[#061942]">Company</h3>

                        <div class="my-3 flex items-center gap-4 text-sm text-[#24344f]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"></path><path d="M4 7l8 6 8-6"></path></svg>
                            </span>
                            <span id="companyEmail" class="min-w-0 break-all">-</span>
                        </div>

                        <div class="my-3 flex items-center gap-4 text-sm text-[#24344f]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.4 19.4 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"></path></svg>
                            </span>
                            <span id="companyPhone" class="min-w-0 break-words">-</span>
                        </div>

                        <div class="my-3 flex items-center gap-4 text-sm text-[#24344f]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"></path></svg>
                            </span>
                            <span id="companyWebsite" class="min-w-0 break-all leading-relaxed">-</span>
                        </div>
                    </div>
                </div>

                <div class="mb-8 h-px bg-[#dce7f8]"></div>

                <div>
                    <h3 class="mb-4 text-[17px] font-bold text-[#061942]">About Company</h3>
                    <p id="companyDescription" class="max-w-[680px] break-words text-sm leading-relaxed text-[#24344f]">-</p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-1 xl:gap-[18px]">
                <article class="min-h-[112px] rounded-lg border border-[#dce7f8] bg-white px-5 py-5 sm:px-[30px] sm:py-[26px]">
                    <h3 class="mb-4 text-[15px] font-bold text-[#061942]">Industry</h3>
                    <p id="companyIndustry" class="break-words text-sm leading-relaxed text-[#24344f]">-</p>
                </article>
                <article class="min-h-[112px] rounded-lg border border-[#dce7f8] bg-white px-5 py-5 sm:px-[30px] sm:py-[26px]">
                    <h3 class="mb-4 text-[15px] font-bold text-[#061942]">Address</h3>
                    <p id="companyAddress" class="break-words text-sm leading-relaxed text-[#24344f]">-</p>
                </article>
                <article class="min-h-[112px] rounded-lg border border-[#dce7f8] bg-white px-5 py-5 sm:px-[30px] sm:py-[26px] md:col-span-2 xl:col-span-1">
                    <h3 class="mb-4 text-[15px] font-bold text-[#061942]">Approval Status</h3>
                    <p id="companyApproval" class="text-sm font-bold text-[#24344f]">-</p>
                </article>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const loading = document.getElementById('profileLoading');
    const empty = document.getElementById('emptyProfile');
    const content = document.getElementById('profileContent');

    const valueOrDash = (value) => value || '-';
    const setText = (id, value) => document.getElementById(id).textContent = valueOrDash(value);
    const approvalClass = (status) => ({
        approved: 'text-[#138a43]',
        pending: 'text-[#b7791f]',
        rejected: 'text-[#ff3045]',
    }[status] || 'text-[#52607a]');

    async function loadCompanyProfile() {
        if (!token) {
            window.location.href = '/company/login';
            return;
        }

        const response = await fetch('/api/company/profile', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
        });

        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            window.location.href = '/company/login';
            return;
        }

        const result = await response.json();
        const profile = result.data?.profile;
        loading.classList.add('hidden');

        if (!profile) {
            empty.classList.remove('hidden');
            return;
        }

        localStorage.setItem('ofc_company_profile', JSON.stringify(profile));
        const name = profile.company_name || 'Company';
        const status = profile.approval_status || 'pending';

        document.getElementById('companyInitial').textContent = name.charAt(0).toUpperCase();
        setText('companyName', name);
        setText('companyEmail', profile.email);
        setText('companyPhone', profile.phone);
        setText('companyWebsite', profile.website);
        setText('companyDescription', profile.description);
        setText('companyIndustry', profile.industry);
        setText('companyAddress', profile.address);
        setText('companyApproval', status.charAt(0).toUpperCase() + status.slice(1));

        const statusEl = document.getElementById('approvalStatus');
        statusEl.textContent = `Admin Approval: ${status.charAt(0).toUpperCase() + status.slice(1)}`;
        statusEl.className = `mt-2 text-xs font-bold ${approvalClass(status)}`;

        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));
        content.classList.remove('hidden');
    }

    loadCompanyProfile().catch(() => {
        loading.textContent = 'Unable to load company profile.';
    });
</script>
@endpush
