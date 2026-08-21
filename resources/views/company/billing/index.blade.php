@extends('layouts.company')

@section('title', 'Purchase Package - OnlyFreshers')
@section('pageTitle', 'Purchase Package')

@php
    $activePage = 'billing';

    $plans = [
        ['name' => 'Basic', 'monthly' => 'Rs. 1,999', 'yearly' => 'Rs. 19,999', 'popular' => false, 'features' => ['10 Job Postings', 'Basic Search Access', 'Email Support']],
        ['name' => 'Premium', 'monthly' => 'Rs. 4,999', 'yearly' => 'Rs. 49,999', 'popular' => true, 'features' => ['Unlimited Job Postings', 'Access to Fresh Candidates', 'Priority Support']],
        ['name' => 'Enterprise', 'monthly' => 'Rs. 9,999', 'yearly' => 'Rs. 99,999', 'popular' => false, 'features' => ['50 Job Postings', 'Dedicated Account Manager', 'Custom Reports']],
    ];

    $benefits = [
        ['title' => 'Secure Payment', 'text' => '100% secure and encrypted', 'icon' => 'lock'],
        ['title' => 'Instant Activation', 'text' => 'Plan activates immediately', 'icon' => 'bolt'],
        ['title' => 'Cancel Anytime', 'text' => 'No questions asked', 'icon' => 'smile'],
    ];
@endphp

@section('topbarExtra')
    <span class="hidden h-[54px] w-[54px] items-center justify-center rounded-lg bg-[#075fe4] text-white lg:inline-flex" aria-hidden="true">
        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h8.78a2 2 0 0 0 1.95-1.57L21 7H5.12"></path></svg>
    </span>
@endsection

@section('content')
    <section class="mb-9 grid grid-cols-1 items-center gap-5 xl:grid-cols-[1fr_auto_1fr]">
        <div class="flex items-center gap-3.5 text-[15px] font-bold text-[#061942]">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#075fe4] text-sm font-bold text-white">1</span>
            CHOOSE PLAN
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-5">
            <strong class="text-[15px] text-[#061942]">Choose Tenure</strong>
            <div class="grid overflow-hidden rounded-3xl border border-[#dce7f8] bg-white sm:grid-cols-[130px_130px_110px]">
                <button class="tenure-button active h-12 rounded-3xl text-sm font-bold text-[#075fe4] shadow-[inset_0_0_0_1px_#dce7f8]" type="button" data-tenure="monthly">Monthly</button>
                <button class="tenure-button h-12 text-sm font-bold text-[#061942]" type="button" data-tenure="yearly">Yearly</button>
                <span class="flex h-12 items-center justify-center bg-[#dbf8e9] text-sm font-bold text-[#00a65a]">Save 20%</span>
            </div>
        </div>

        <div></div>
    </section>

    <section class="mb-10 grid grid-cols-1 items-stretch gap-[18px] xl:grid-cols-3">
        @foreach ($plans as $plan)
            <article class="relative rounded-2xl border border-[#dce7f8] px-8 pb-8 pt-10 shadow-[0_10px_24px_rgba(6,25,66,0.04)] {{ $plan['popular'] ? 'bg-gradient-to-br from-[#7b35e8] to-[#4b2be8] text-white xl:-translate-y-0.5' : 'bg-white text-[#061942]' }}">
                @if ($plan['popular'])
                    <div class="absolute left-1/2 top-[-26px] flex h-[46px] min-w-[128px] -translate-x-1/2 items-center justify-center rounded-xl bg-[#7b35e8] px-5 text-[15px] font-bold text-white shadow-[0_10px_24px_rgba(75,43,232,.2)]">Popular</div>
                @endif

                <h2 class="mb-7 text-center text-[23px] font-bold">{{ $plan['name'] }}</h2>
                <div class="mb-9 text-center text-[34px] font-bold">
                    <span class="price-value" data-monthly="{{ $plan['monthly'] }}" data-yearly="{{ $plan['yearly'] }}">{{ $plan['monthly'] }}</span>
                    <span class="period text-[15px] font-medium">/month</span>
                </div>

                <div class="mb-7 h-px {{ $plan['popular'] ? 'bg-white/25' : 'bg-[#dce7f8]' }}"></div>

                <div class="space-y-6">
                    @foreach ($plan['features'] as $feature)
                        <div class="flex items-center gap-4 text-[15px]">
                            <span class="flex h-[34px] w-[34px] shrink-0 items-center justify-center rounded-full {{ $plan['popular'] ? 'bg-white/15 text-white' : 'bg-[#dbf8e9] text-[#00a65a]' }} font-bold">&#10003;</span>
                            <span>{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>

                <button type="button" data-plan="{{ strtolower($plan['name']) }}" class="choose mt-8 h-[58px] w-full rounded-lg {{ $plan['popular'] ? 'border-0 bg-white text-[#075fe4]' : 'border border-[#075fe4] bg-white text-[#075fe4]' }} text-lg font-bold transition hover:shadow-[0_10px_20px_rgba(7,95,228,0.14)]">
                    Choose Plan
                </button>
            </article>
        @endforeach
    </section>

    <section class="grid grid-cols-1 gap-6 rounded-xl border border-[#dce7f8] bg-white px-6 py-[30px] sm:px-[42px] xl:grid-cols-3">
        @foreach ($benefits as $benefit)
            <div class="flex items-center gap-[18px] xl:justify-center xl:border-r xl:border-[#dce7f8] xl:last:border-r-0">
                <div class="flex h-[58px] w-[58px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-[#061942]">
                    @if ($benefit['icon'] === 'lock')
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    @elseif ($benefit['icon'] === 'bolt')
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h8l-1 8 10-12h-8l1-8Z"></path></svg>
                    @else
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><path d="M9 9h.01"></path><path d="M15 9h.01"></path></svg>
                    @endif
                </div>
                <div>
                    <h3 class="mb-1.5 text-[15px] font-bold text-[#061942]">{{ $benefit['title'] }}</h3>
                    <p class="text-[13px] text-[#24344f]">{{ $benefit['text'] }}</p>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-tenure]').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('[data-tenure]').forEach(function (item) {
                item.classList.remove('active', 'text-[#075fe4]', 'shadow-[inset_0_0_0_1px_#dce7f8]');
                item.classList.add('text-[#061942]');
            });

            button.classList.add('active', 'text-[#075fe4]', 'shadow-[inset_0_0_0_1px_#dce7f8]');
            button.classList.remove('text-[#061942]');

            const tenure = button.dataset.tenure;
            document.querySelectorAll('.price-value').forEach(function (price) {
                price.textContent = price.dataset[tenure];
            });
            document.querySelectorAll('.period').forEach(function (period) {
                period.textContent = tenure === 'monthly' ? '/month' : '/year';
            });
        });
    });

    document.querySelectorAll('.choose').forEach(function (button) {
        button.addEventListener('click', async function () {
            const token =
                localStorage.getItem('ofc_auth_token') ||
                localStorage.getItem('onlyfreshers_company_token');

            if (!token) {
                window.location.href = '/company/login';
                return;
            }

            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Activating...';

            try {
                const response = await fetch('/api/company/subscribe', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify({
                        plan: button.dataset.plan,
                    }),
                });

                const result = await response.json();

                if (!response.ok || result.success === false) {
                    throw new Error(result.message || 'Unable to activate plan.');
                }

                if (result.data?.profile) {
                    localStorage.setItem(
                        'ofc_company_profile',
                        JSON.stringify(result.data.profile)
                    );
                }

                alert(result.message || 'Plan activated.');
                window.location.href = result.data?.redirect_to || '/company/post-job';
            } catch (error) {
                alert(error.message || 'Something went wrong.');
            } finally {
                button.disabled = false;
                button.textContent = originalText;
            }
        });
    });
</script>
@endpush
