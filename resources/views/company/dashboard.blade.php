@extends('layouts.company')

@section('title', 'Company Dashboard - OnlyFreshers')

@section('pageTitle', 'Company Dashboard')

@section(
    'pageSubtitle',
    'Overview of your hiring activities and company updates.'
)

@php
    $activePage = 'dashboard';
    $companyName = $companyName ?? 'TechNova Solutions';
    $todayMessage = $todayMessage ?? "Here's what's happening today.";
    $stats = $stats ?? [];
    $activities = $activities ?? [];
    $quickActions = $quickActions ?? [];
@endphp

@section('content')

    {{-- Welcome card --}}
    <section
        class="mb-5 min-h-[170px] rounded-lg border border-[#dce7f8]
               bg-white px-5 py-[30px]
               shadow-[0_10px_24px_rgba(6,25,66,0.04)]
               sm:px-8 sm:py-12"
    >
        <h2 class="mb-2.5 text-[22px] font-bold leading-tight text-[#061942]">
            Welcome back,

            <strong class="block text-[27px] font-bold sm:text-[28px]">
                <span data-company-dashboard-name>{{ $companyName }}</span>
            </strong>
        </h2>

        <p class="text-sm text-[#34445e]">
            {{ $todayMessage }}
        </p>
    </section>

    {{-- Statistics --}}
    <section
        class="mb-[22px] grid grid-cols-1 gap-5
               md:grid-cols-2
               xl:grid-cols-5"
    >
        @foreach ($stats as $stat)
            <article
                data-company-stat="{{ $stat['label'] }}"
                class="flex min-h-[142px] min-w-0 items-center justify-center gap-[18px]
                       rounded-lg border border-[#dce7f8] bg-white p-[22px]
                       shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
            >
                <div
                    class="flex h-[58px] w-[58px] shrink-0 items-center justify-center
                           rounded-full {{ $stat['iconClasses'] }}"
                >
                    <div
                        class="h-7 w-7
                               [&>svg]:h-full [&>svg]:w-full
                               [&>svg]:fill-none
                               [&>svg]:stroke-current
                               [&>svg]:stroke-2
                               [&>svg]:[stroke-linecap:round]
                               [&>svg]:[stroke-linejoin:round]"
                    >
                        @include('components.company.icon', [
                            'icon' => $stat['icon'],
                        ])
                    </div>
                </div>

                <div class="min-w-0">
                    <h3 class="mb-[5px] text-[25px] font-bold text-[#061942]">
                        {{ $stat['value'] }}
                    </h3>

                    <p class="mb-[15px] text-xs text-[#34445e]">
                        {{ $stat['label'] }}
                    </p>

                    <a
                        href="{{ $stat['href'] ?? '/company/dashboard' }}" class="text-xs font-bold text-[#075fe4]
                               hover:underline"
                    >
                        {{ $stat['link'] }}
                    </a>
                </div>
            </article>
        @endforeach
    </section>

    {{-- Bottom content --}}
    <section
        class="grid grid-cols-1 gap-5
               xl:grid-cols-[1.1fr_0.9fr]"
    >
        {{-- Recent activities --}}
        <div
            class="min-w-0 rounded-lg border border-[#dce7f8] bg-white p-6
                   shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
        >
            <h2 class="mb-[18px] text-lg font-bold text-[#061942]">
                Recent Activities
            </h2>

            <div>
                @foreach ($activities as $activity)
                    <div
                        class="grid grid-cols-[42px_minmax(0,1fr)] items-center gap-x-[18px]
                               border-b border-[#edf2fb] px-2 py-[11px]
                               last:border-b-0
                               sm:grid-cols-[48px_minmax(0,1fr)_auto]"
                    >
                        <div
                            class="flex h-[42px] w-[42px] items-center justify-center
                                   rounded-[9px] {{ $activity['iconClasses'] }}"
                        >
                            <div
                                class="h-5 w-5
                                       [&>svg]:h-full [&>svg]:w-full
                                       [&>svg]:fill-none
                                       [&>svg]:stroke-current
                                       [&>svg]:stroke-2
                                       [&>svg]:[stroke-linecap:round]
                                       [&>svg]:[stroke-linejoin:round]"
                            >
                                @include('components.company.icon', [
                                    'icon' => $activity['icon'],
                                ])
                            </div>
                        </div>

                        <h3 class="text-xs font-bold text-[#061942]">
                            {{ $activity['title'] }}
                        </h3>

                        <time
                            class="col-start-2 whitespace-nowrap text-xs text-[#34445e]
                                   sm:col-start-auto"
                        >
                            {{ $activity['time'] }}
                        </time>
                    </div>
                @endforeach
            </div>

            <a href="/company/notifications" class="mx-auto mt-[22px] flex h-[42px] w-[170px] items-center justify-center rounded-lg border border-[#bfd4f5] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">View All Activities</a>
        </div>

        {{-- Quick actions --}}
        <div
            class="min-w-0 rounded-lg border border-[#dce7f8] bg-white p-6
                   shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
        >
            <h2 class="mb-[18px] text-lg font-bold text-[#061942]">
                Quick Actions
            </h2>

            <div class="grid gap-3">
                @foreach ($quickActions as $action)
                    <a
                        href="{{ $action['href'] ?? '/company/dashboard' }}" class="grid min-h-[76px]
                               grid-cols-[52px_minmax(0,1fr)_auto]
                               items-center gap-4 rounded-lg
                               border border-[#dce7f8] bg-white
                               px-[18px] py-[13px]
                               shadow-[0_10px_24px_rgba(6,25,66,0.04)]
                               transition
                               hover:-translate-y-0.5
                               hover:border-[#bfd4f5]
                               hover:shadow-[0_12px_28px_rgba(6,25,66,0.08)]"
                    >
                        <div
                            class="flex h-[58px] w-[58px] shrink-0 items-center justify-center
                                   rounded-full {{ $action['iconClasses'] }}"
                        >
                            <div
                                class="h-7 w-7
                                       [&>svg]:h-full [&>svg]:w-full
                                       [&>svg]:fill-none
                                       [&>svg]:stroke-current
                                       [&>svg]:stroke-2
                                       [&>svg]:[stroke-linecap:round]
                                       [&>svg]:[stroke-linejoin:round]"
                            >
                                @include('components.company.icon', [
                                    'icon' => $action['icon'],
                                ])
                            </div>
                        </div>

                        <div class="min-w-0">
                            <h3 class="mb-[5px] text-[13px] font-bold text-[#061942]">
                                {{ $action['title'] }}
                            </h3>

                            <p class="text-xs text-[#34445e]">
                                {{ $action['text'] }}
                            </p>
                        </div>

                        <span class="text-[30px] leading-none text-[#061942]">
                            &#8250;
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    (function hydrateCompanyDashboard() {
        const token = localStorage.getItem('onlyfreshers_company_token');
        const storedUser = JSON.parse(localStorage.getItem('onlyfreshers_company_user') || 'null');

        function setCompanyName(name) {
            const el = document.querySelector('[data-company-dashboard-name]');
            if (el) el.textContent = name || storedUser?.name || 'Company';
        }

        function setStat(label, value, note) {
            const card = document.querySelector(`[data-company-stat="${label}"]`);
            if (!card) return;
            const valueEl = card.querySelector('h3');
            const noteEl = card.querySelector('p');
            if (valueEl) valueEl.textContent = value ?? 0;
            if (note && noteEl) noteEl.textContent = note;
        }

        setCompanyName(storedUser?.name);

        if (!token) return;

        fetch('/api/company/dashboard', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${token}`,
            },
        })
            .then(response => response.json())
            .then(result => {
                const data = result.data || {};
                const profile = data.company_profile || {};
                const stats = data.statistics || {};
                setCompanyName(profile.company_name || storedUser?.name);
                setStat('Jobs Posted', stats.total_jobs);
                setStat('Applications', stats.total_applications);
                setStat('Shortlisted', stats.shortlisted_applications);
                setStat('Interviews', stats.scheduled_interviews);
                setStat('Hired', stats.hired_applications);
            })
            .catch(() => setCompanyName(storedUser?.name));
    })();
</script>
@endpush


