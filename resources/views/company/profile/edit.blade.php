@extends('layouts.company')

@section('title', 'Edit Profile - OnlyFreshers')
@section('pageTitle', 'Edit Profile')
@section('pageSubtitle', 'Complete or update your company profile for admin approval.')

@php $activePage = 'profile'; @endphp

@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-6 xl:p-8">
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div id="companyInitial" class="flex h-20 w-20 items-center justify-center rounded-full bg-[#075fe4] text-3xl font-bold text-white">C</div>
            <div>
                <h2 id="formTitle" class="text-lg font-bold text-[#061942]">Company Profile</h2>
                <p id="formSubtitle" class="mt-1 text-sm text-[#52607a]">Submit details for admin approval</p>
            </div>
        </div>
    </div>

    <p id="authMessage" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm font-bold"></p>

    <form id="companyProfileForm" class="grid gap-4 sm:gap-5 md:grid-cols-2">
        <label class="block">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Company / Contact Name</span>
            <input name="company_name" class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]" required>
        </label>
        <label class="block">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Email Address</span>
            <input name="email" type="email" class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">
        </label>
        <label class="block">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Mobile Number</span>
            <input name="phone" class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">
        </label>
        <label class="block">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Industry</span>
            <input name="industry" class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">
        </label>
        <label class="block md:col-span-2">
            <span class="mb-2 block text-xs font-bold text-[#061942]">What are you here for?</span>
            <select name="hiring_intent" class="h-[46px] w-full rounded-lg border border-[#dce7f8] bg-white px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">
                <option value="job_posting">Job posting and hiring tools</option>
                <option value="resume_only">Resume access only</option>
            </select>
        </label>
        <label class="block">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Website</span>
            <input name="website" type="text" placeholder="https://example.com" class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">
        </label>
        <label class="block">
            <span class="mb-2 block text-xs font-bold text-[#061942]">Address</span>
            <input name="address" class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">
        </label>
        <label class="block md:col-span-2">
            <span class="mb-2 block text-xs font-bold text-[#061942]">About Company</span>
            <textarea name="description" class="min-h-28 w-full rounded-lg border border-[#dce7f8] p-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]"></textarea>
        </label>
        <div class="flex justify-end gap-3 md:col-span-2">
            <a href="/company/profile" class="inline-flex h-11 items-center rounded-lg border border-[#dce7f8] px-6 text-sm font-bold text-[#075fe4]">Cancel</a>
            <button class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-70" type="submit">Save Changes</button>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const form = document.getElementById('companyProfileForm');
    const message = document.getElementById('authMessage');
    const submitButton = form.querySelector('button[type="submit"]');

    const showMessage = (text, type = 'error') => {
        message.textContent = text;
        message.className = `mb-5 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff5f6] text-[#ff3045]'}`;
    };

    const fillForm = (profile, user = {}) => {
        const fallbackUser = JSON.parse(localStorage.getItem('ofc_auth_user') || '{}');
        const account = { ...fallbackUser, ...user };
        const values = {
            company_name: profile?.company_name || account.name || '',
            industry: profile?.industry || '',
            email: profile?.email || account.email || '',
            phone: profile?.phone || account.mobile || '',
            hiring_intent: profile?.hiring_intent || 'job_posting',
            website: profile?.website || '',
            address: profile?.address || '',
            description: profile?.description || '',
        };

        for (const field of ['company_name', 'industry', 'email', 'phone', 'hiring_intent', 'website', 'address', 'description']) {
            form[field].value = values[field] || '';
        }
        const name = values.company_name || 'Company';
        document.getElementById('companyInitial').textContent = name.charAt(0).toUpperCase();
        document.getElementById('formTitle').textContent = name;
        document.getElementById('formSubtitle').textContent = `Approval status: ${profile?.approval_status || 'pending'}`;
    };

    async function loadProfile() {
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
        if (result.data?.user) {
            localStorage.setItem('ofc_auth_user', JSON.stringify(result.data.user));
        }
        fillForm(result.data?.profile, result.data?.user);
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';

        try {
            const website = form.website.value.trim();
            const normalizedWebsite = website && !/^https?:\/\//i.test(website) ? `https://${website}` : website;
            const response = await fetch('/api/company/profile', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify({
                    company_name: form.company_name.value.trim(),
                    industry: form.industry.value.trim(),
                    email: form.email.value.trim(),
                    phone: form.phone.value.trim(),
                    hiring_intent: form.hiring_intent.value,
                    website: normalizedWebsite,
                    address: form.address.value.trim(),
                    description: form.description.value.trim(),
                }),
            });
            const result = await response.json();

            if (!response.ok || !result.success) {
                const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                throw new Error(validationMessage || result.message || 'Profile save failed.');
            }

            const profile = result.data.profile;
            if (result.data?.user) {
                localStorage.setItem('ofc_auth_user', JSON.stringify(result.data.user));
                localStorage.setItem('onlyfreshers_company_user', JSON.stringify(result.data.user));
                localStorage.setItem('onlyfreshers_user', JSON.stringify(result.data.user));
            }
            localStorage.setItem('ofc_company_profile', JSON.stringify(profile));
            showMessage(profile?.approval_status === 'approved' ? 'Profile saved successfully.' : 'Profile saved and submitted for admin approval.', 'success');
            setTimeout(() => window.location.href = '/company/profile', 700);
        } catch (error) {
            showMessage(error.message || 'Something went wrong.');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Save Changes';
        }
    });

    loadProfile().catch(() => showMessage('Unable to load company profile.'));
</script>
@endpush
