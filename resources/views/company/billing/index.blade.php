@extends('layouts.company')

@section('title', 'Purchase Package - OnlyFreshers')
@section('pageTitle', 'Purchase Package')

@push('styles')
<style>
    .custom-plan-overlay {
        background: rgba(6, 25, 66, 0.22);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        bottom: 0 !important;
        left: 0 !important;
        position: fixed !important;
        right: 0 !important;
        top: 0 !important;
        width: 100vw !important;
    }

    .custom-plan-card {
        background: #ffffff;
        border: 1px solid #dce7f8;
        box-shadow: 0 24px 70px rgba(6, 25, 66, 0.18);
    }

    .custom-plan-body {
        max-height: calc(100vh - 230px);
        overflow-y: auto;
    }

    .custom-plan-footer {
        background: #ffffff;
    }

    .custom-plan-header,
    .custom-plan-summary {
        background: #ffffff;
    }

    .custom-plan-field,
    .custom-plan-feature,
    .custom-plan-summary-box {
        background: #ffffff;
        border-color: #dce7f8;
    }

    .custom-pay-button {
        align-items: center;
        background: #0d6efd !important;
        border: 1px solid #5aa2ff;
        border-radius: 12px;
        box-shadow: 0 14px 30px rgba(13, 110, 253, 0.28);
        color: #ffffff !important;
        cursor: pointer;
        display: inline-flex;
        font-size: 15px;
        font-weight: 800;
        height: 50px;
        justify-content: center;
        min-width: 220px;
        padding: 0 28px;
        transition: transform 0.16s ease, background 0.16s ease, box-shadow 0.16s ease;
    }

    .custom-pay-button:hover {
        background: #2b7fff !important;
        box-shadow: 0 18px 38px rgba(13, 110, 253, 0.36);
        transform: translateY(-1px);
    }

    .custom-pay-button:disabled {
        cursor: not-allowed;
        opacity: 0.7;
        transform: none;
    }

</style>
@endpush

@php
    $activePage = 'billing';

    $customResumePlans = [
        ['key' => 'resume_3_months', 'name' => '3 Months', 'price' => 10, 'credits' => 200, 'label' => '200 resumes', 'note' => 'Admin will provide 200 candidate resumes.'],
        ['key' => 'resume_6_months', 'name' => '6 Months', 'price' => 18, 'credits' => 500, 'label' => '500 resumes', 'note' => 'Admin will provide 500 candidate resumes.'],
        ['key' => 'resume_1_year', 'name' => '1 Year', 'price' => 30, 'credits' => 1000000, 'label' => 'Full resume access', 'note' => 'Full resume access for the complete year.'],
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
    <section class="mb-10">
        <div class="mb-6 text-center">
            <h2 class="text-[26px] font-bold text-[#061942]">Customise Plan</h2>
            <p class="mt-2 text-[15px] font-semibold text-[#34445e]">Choose Enterprise customisation or resume-only access.</p>
        </div>

        <div class="grid grid-cols-1 items-stretch gap-[18px] xl:grid-cols-2">
            <article class="relative rounded-2xl border border-[#dce7f8] bg-white px-8 pb-8 pt-10 text-[#061942] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                <h2 class="mb-3 text-center text-[23px] font-bold">Enterprise</h2>
                <p class="mb-7 text-center text-[13px] font-medium text-[#061942]">For large scale hiring</p>
                <div class="mb-9 text-center text-[44px] font-bold leading-none">
                    Custom <span class="text-[15px] font-medium">Contact Sales</span>
                </div>

                <div class="mb-7 h-px bg-[#dce7f8]"></div>

                <div class="space-y-6">
                    @foreach (['Unlimited Job Postings', 'Custom Resume Access', 'Dedicated Account Manager', 'Bulk Hiring Solutions', 'API Access', 'Custom Integrations'] as $feature)
                        <div class="flex items-center gap-4 text-[15px]">
                            <span class="flex h-[34px] w-[34px] shrink-0 items-center justify-center rounded-full bg-[#dbf8e9] font-bold text-[#00a65a]">&#10003;</span>
                            <span>{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="enterpriseContactButton" class="mt-8 h-[58px] w-full rounded-lg border border-[#075fe4] bg-white text-lg font-bold text-[#075fe4] transition hover:shadow-[0_10px_20px_rgba(7,95,228,0.14)]">
                    Contact Sales
                </button>
            </article>

            <article class="relative rounded-2xl border border-[#dce7f8] bg-white px-8 pb-8 pt-10 text-[#061942] shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
                <h2 class="mb-3 text-center text-[23px] font-bold">Resume Access</h2>
                <p class="mb-7 text-center text-[13px] font-medium text-[#061942]">No job posting required</p>
                <div class="mb-9 text-center text-[44px] font-bold leading-none">
                    Custom <span class="text-[15px] font-medium">3 plans</span>
                </div>

                <div class="mb-7 h-px bg-[#dce7f8]"></div>

                <div class="space-y-4">
                    @foreach ($customResumePlans as $plan)
                        <label class="flex cursor-pointer items-start gap-4 rounded-xl border border-[#dce7f8] bg-white p-4 transition hover:border-[#075fe4] hover:bg-[#f8fbff]">
                            <input
                                type="radio"
                                name="inline_custom_resume_plan"
                                class="inline-custom-resume-plan mt-1 h-4 w-4 shrink-0 accent-[#075fe4]"
                                value="{{ $plan['key'] }}"
                                data-amount="{{ $plan['price'] }}"
                                data-credits="{{ $plan['credits'] }}"
                                data-label="{{ $plan['label'] }}"
                                data-name="{{ $plan['name'] }}"
                                @checked($loop->first)
                            >
                            <span class="min-w-0 flex-1">
                                <span class="flex items-start justify-between gap-3">
                                    <strong class="text-[15px] text-[#061942]">{{ $plan['name'] }}</strong>
                                    <strong class="shrink-0 text-[17px] text-[#075fe4]">Rs. {{ $plan['price'] }}</strong>
                                </span>
                                <span class="mt-1 block text-[14px] font-bold text-[#061942]">{{ $plan['label'] }}</span>
                                <span class="mt-1 block text-[12px] font-semibold text-[#52607a]">{{ $plan['note'] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                <button type="button" id="resumePlanButton" class="mt-8 h-[58px] w-full rounded-lg border border-[#075fe4] bg-white text-lg font-bold text-[#075fe4] transition hover:shadow-[0_10px_20px_rgba(7,95,228,0.14)]">
                    Buy Resume Plan
                </button>
            </article>
        </div>
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

    <div id="customPlanModal" class="custom-plan-overlay fixed left-0 top-0 z-[9999] hidden h-screen w-screen px-4 py-4">
        <form id="customPlanForm" class="custom-plan-card mx-auto flex h-full w-full max-w-[980px] flex-col overflow-hidden rounded-2xl text-[#061942]">
            <div class="custom-plan-header flex items-start justify-between gap-4 border-b border-[#dce7f8] px-5 py-4 sm:px-6">
                <div>
                    <div class="mb-2 inline-flex rounded-full bg-[#edf5ff] px-3 py-1 text-xs font-bold text-[#075fe4]">Custom hiring package</div>
                    <h2 class="text-2xl font-bold text-[#061942]">Enterprise custom plan</h2>
                    <p class="mt-1 text-sm font-semibold text-[#34445e]">Amount set karo, job credits auto calculate honge.</p>
                </div>
                <button id="closeCustomPlan" type="button" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-xl font-bold text-[#061942] transition hover:bg-[#f8fbff]" aria-label="Close custom plan">&times;</button>
            </div>

            <div class="custom-plan-body grid flex-1 gap-0 md:grid-cols-[1fr_320px]">
                <div class="p-5 sm:p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="grid gap-2 text-sm font-bold text-[#061942]">
                            Amount (Rs.)
                            <input id="customAmount" type="number" min="1" value="10" required class="custom-plan-field h-12 rounded-lg border px-4 text-base font-bold text-[#061942] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe433]">
                        </label>
                        <label class="grid gap-2 text-sm font-bold text-[#061942]">
                            Job Credits
                            <input id="customCredits" type="number" min="1" value="10000" readonly required class="custom-plan-field h-12 rounded-lg border px-4 text-base font-bold text-[#075fe4] outline-none">
                        </label>
                    </div>
                    <p id="customCreditNote" class="mt-3 text-xs font-semibold text-[#52607a]">Rs. 10 gives 10,000 job credits.</p>

                    <div class="mt-6">
                        <h3 class="mb-3 text-sm font-bold text-[#061942]">Included Facilities</h3>
                        <div class="grid gap-3 text-sm text-[#061942] sm:grid-cols-2">
                            @foreach (['Unlimited Job Postings', 'Custom Resume Access', 'Dedicated Account Manager', 'Bulk Hiring Solutions', 'API Access', 'Custom Integrations'] as $feature)
                                <label class="custom-plan-feature flex min-h-[58px] items-center gap-3 rounded-lg border p-3 transition hover:border-[#4f8cff]">
                                    <input type="checkbox" class="custom-facility h-4 w-4 shrink-0 accent-[#38bdf8]" value="{{ $feature }}" checked>
                                    <span>{{ $feature }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="custom-plan-summary border-t border-[#dce7f8] p-5 md:border-l md:border-t-0 sm:p-6">
                    <p class="text-xs font-bold uppercase text-[#52607a]">Payment Summary</p>
                    <div class="custom-plan-summary-box mt-4 rounded-xl border p-4">
                        <div class="flex items-end justify-between gap-3">
                            <span class="text-sm text-[#52607a]">Payable</span>
                            <strong id="customPayableAmount" class="text-3xl font-black text-[#061942]">Rs. 10</strong>
                        </div>
                        <div class="mt-4 flex items-center justify-between border-t border-[#dce7f8] pt-4 text-sm">
                            <span class="text-[#52607a]">Job Credits</span>
                            <strong id="customSummaryCredits" class="text-[#075fe4]">10,000</strong>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-[#52607a]">Facilities</span>
                            <strong id="customFacilityCount" class="text-[#075fe4]">4 selected</strong>
                        </div>
                    </div>
                    <p id="customSummaryNote" class="mt-3 text-center text-xs text-[#52607a]">Secure checkout through Razorpay</p>
                </aside>
            </div>

            <div class="custom-plan-footer flex flex-col gap-3 border-t border-[#dce7f8] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <p class="text-xs font-bold uppercase text-[#52607a]">Total Payable</p>
                    <p id="customFooterAmount" class="text-2xl font-black text-[#061942]">Rs. 10</p>
                </div>
                <button id="customSubmitButton" type="submit" class="custom-pay-button w-full sm:w-auto">Pay With Razorpay</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const customPlanModal = document.getElementById('customPlanModal');
    const customPlanForm = document.getElementById('customPlanForm');
    const resumePlanButton = document.getElementById('resumePlanButton');
    const enterpriseContactButton = document.getElementById('enterpriseContactButton');
    const customAmount = document.getElementById('customAmount');
    const customCredits = document.getElementById('customCredits');
    const customCreditNote = document.getElementById('customCreditNote');
    const customPayableAmount = document.getElementById('customPayableAmount');
    const customSummaryCredits = document.getElementById('customSummaryCredits');
    const customFacilityCount = document.getElementById('customFacilityCount');
    const customFooterAmount = document.getElementById('customFooterAmount');
    const customSummaryNote = document.getElementById('customSummaryNote');
    const customSubmitButton = document.getElementById('customSubmitButton');
    let activeCustomButton = null;
    const creditsPerRupee = 1000;

    document.body.appendChild(customPlanModal);

    function syncCustomCredits() {
        const amount = Math.max(1, Number(customAmount.value || 1));
        const credits = Math.round(amount * creditsPerRupee);
        const selectedFacilities = document.querySelectorAll('.custom-facility:checked').length;
        customCredits.value = credits;
        customCreditNote.textContent = `Rs. ${amount.toLocaleString('en-IN')} gives ${credits.toLocaleString('en-IN')} job credits.`;
        customPayableAmount.textContent = `Rs. ${amount.toLocaleString('en-IN')}`;
        customFooterAmount.textContent = `Rs. ${amount.toLocaleString('en-IN')}`;
        customSummaryCredits.textContent = credits.toLocaleString('en-IN');
        customFacilityCount.textContent = `${selectedFacilities} selected`;
        customSummaryNote.textContent = 'Secure checkout through Razorpay';
        customSubmitButton.textContent = 'Pay With Razorpay';
    }

    function openCustomPlanModal(button) {
        activeCustomButton = button;
        customPlanModal.classList.remove('hidden');
        customPlanModal.classList.add('flex');
        syncCustomCredits();
        setTimeout(() => customAmount.focus(), 50);
    }

    function closeCustomPlanModal() {
        customPlanModal.classList.add('hidden');
        customPlanModal.classList.remove('flex');
    }

    async function createCompanyOrder(payload, token) {
        const response = await fetch('/api/payments/razorpay/order', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(payload),
        });
        const result = await response.json();

        if (!response.ok || result.success === false) {
            throw new Error(result.message || 'Unable to create payment order.');
        }

        return result.data || {};
    }

    async function openRazorpayCheckout(order, token, button, originalText) {
        if (!window.Razorpay) {
            throw new Error('Razorpay checkout could not be loaded. Please refresh and try again.');
        }

        const checkout = new Razorpay({
            key: order.key,
            amount: order.amount,
            currency: order.currency,
            order_id: order.razorpay_order_id,
            name: order.name,
            description: order.description,
            prefill: order.prefill || {},
            method: {
                card: true,
                netbanking: true,
                wallet: true,
                upi: true,
            },
            handler: async function (response) {
                button.textContent = 'Verifying...';
                try {
                    const verifyResponse = await fetch('/api/payments/razorpay/verify', {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${token}`,
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                        }),
                    });
                    const verifyResult = await verifyResponse.json();

                    if (!verifyResponse.ok || verifyResult.success === false) {
                        throw new Error(verifyResult.message || 'Payment verification failed.');
                    }

                    alert(verifyResult.message || 'Plan activated.');
                    window.location.href = verifyResult.data?.redirect_to || '/company/post-job';
                } catch (error) {
                    alert(error.message || 'Payment verification failed.');
                    button.disabled = false;
                    button.textContent = originalText;
                }
            },
            modal: {
                ondismiss: function () {
                    alert('Payment was cancelled. You can retry anytime.');
                    button.disabled = false;
                    button.textContent = originalText;
                },
            },
        });

        checkout.open();
    }

    enterpriseContactButton?.addEventListener('click', function () {
        openCustomPlanModal(enterpriseContactButton);
    });

    resumePlanButton?.addEventListener('click', async function () {
        const token =
            localStorage.getItem('ofc_auth_token') ||
            localStorage.getItem('onlyfreshers_company_token');

        if (!token) {
            window.location.href = '/company/login';
            return;
        }

        const selectedPlan = document.querySelector('.inline-custom-resume-plan:checked');
        if (!selectedPlan) {
            alert('Please choose a resume plan.');
            return;
        }

        const originalText = resumePlanButton.textContent;
        resumePlanButton.disabled = true;
        resumePlanButton.textContent = 'Opening Razorpay...';

        try {
            const order = await createCompanyOrder({
                purpose: 'company_subscription',
                plan: 'custom',
                custom_category: 'resume',
                custom_amount: Number(selectedPlan.dataset.amount),
                custom_credits: Number(selectedPlan.dataset.credits),
                custom_resume_plan: selectedPlan.value,
                custom_facilities: [
                    'Resume-only access',
                    'Direct + Fast Track Candidates',
                    'Initial & Final Assessment Scores',
                    'Advanced Candidate Filters',
                ],
            }, token);

            await openRazorpayCheckout(order, token, resumePlanButton, originalText);
        } catch (error) {
            alert(error.message || 'Something went wrong.');
            resumePlanButton.disabled = false;
            resumePlanButton.textContent = originalText;
        }
    });

    document.getElementById('closeCustomPlan').addEventListener('click', closeCustomPlanModal);

    customPlanModal.addEventListener('click', function (event) {
        if (event.target === customPlanModal) closeCustomPlanModal();
    });

    customPlanForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const token =
            localStorage.getItem('ofc_auth_token') ||
            localStorage.getItem('onlyfreshers_company_token');

        if (!token) {
            window.location.href = '/company/login';
            return;
        }

        const button = activeCustomButton || document.querySelector('[data-plan="custom"]');
        const originalText = button.textContent;
        const submitButton = customPlanForm.querySelector('[type="submit"]');
        const originalSubmitText = submitButton.textContent;
        const facilities = [...document.querySelectorAll('.custom-facility:checked')].map((input) => input.value);

        button.disabled = true;
        submitButton.disabled = true;
        button.textContent = 'Processing...';
        submitButton.textContent = 'Opening Razorpay...';

        try {
            const order = await createCompanyOrder({
                purpose: 'company_subscription',
                plan: 'custom',
                custom_category: 'enterprise',
                custom_amount: Number(customAmount.value),
                custom_credits: Number(customCredits.value),
                custom_facilities: facilities,
            }, token);

            closeCustomPlanModal();
            await openRazorpayCheckout(order, token, button, originalText);
        } catch (error) {
            alert(error.message || 'Something went wrong.');
            button.disabled = false;
            button.textContent = originalText;
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = originalSubmitText;
        }
    });

    customAmount.addEventListener('input', syncCustomCredits);
    customAmount.addEventListener('change', syncCustomCredits);
    document.querySelectorAll('.custom-facility').forEach((input) => {
        input.addEventListener('change', syncCustomCredits);
    });
    syncCustomCredits();
</script>
@endpush
