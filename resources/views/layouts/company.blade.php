@php
    $pageTitle = $pageTitle ?? trim($__env->yieldContent('pageTitle')) ?: 'Company Dashboard';
    $pageSubtitle = $pageSubtitle ?? trim($__env->yieldContent('pageSubtitle'));
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Company Dashboard - OnlyFreshers')</title>
    @include('components.common.auth-storage')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #company-layout,
        #company-layout * {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
            font-weight: 500 !important;
        }

        #company-layout .company-soft-card {
            border: 1px solid #dce7f8;
            background: #fff;
            box-shadow: 0 12px 28px rgba(6, 25, 66, 0.05);
        }

        #company-layout [data-company-initial],
        #company-layout [data-company-profile-initial],
        #company-layout #companyInitial,
        #company-layout #candidateInitials,
        #company-layout #chatAvatar {
            box-shadow: 0 14px 28px rgba(7, 95, 228, 0.16);
        }

        @media (max-width: 640px) {
            #company-layout .company-topbar-header {
                position: relative;
                grid-template-columns: auto minmax(0, 1fr) auto;
                align-items: center;
                min-height: 64px;
            }

            #company-layout .company-page-title {
                grid-column: 1 / -1;
                grid-row: 2;
                padding-top: 4px;
            }

            #company-layout .company-topbar-actions {
                grid-column: 3;
                grid-row: 1;
                width: auto !important;
                justify-content: flex-end !important;
                gap: 8px;
            }

            #company-layout .company-notification-link {
                order: 3;
            }

            #company-layout .company-topbar-profile {
                order: 2;
                border-left: 0 !important;
                padding-left: 0 !important;
            }

            #company-layout #company-topbar-name,
            #company-layout .company-topbar-profile p {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="h-screen overflow-hidden bg-[#f4f8ff] font-sans font-medium text-[#061942] antialiased">
    <div id="company-layout" class="h-screen lg:grid lg:grid-cols-[250px_minmax(0,1fr)]">
        <aside
            id="company-sidebar"
            class="fixed inset-y-0 left-0 z-[1000] flex h-screen w-[280px] max-w-[86vw] -translate-x-[105%] flex-col justify-between overflow-y-auto overflow-x-hidden border-r border-[#dce7f8] bg-white px-[18px] pb-7 shadow-[18px_0_36px_rgba(6,25,66,.16)] transition-transform duration-200 ease-out lg:static lg:z-auto lg:w-auto lg:max-w-none lg:translate-x-0 lg:shadow-none"
        >
            @include('components.company.sidebar')
        </aside>

        <button
            id="company-sidebar-backdrop"
            class="fixed inset-0 z-[900] hidden bg-[#06194259]"
            type="button"
            onclick="toggleCompanySidebar()"
            aria-label="Close menu"
        ></button>

        <main class="h-screen min-w-0 overflow-y-auto px-3 pb-6 sm:px-[18px] sm:pb-[30px] lg:px-[38px] lg:pb-[38px]">
            <header class="company-topbar-header mb-[22px] grid min-h-[78px] grid-cols-[auto_minmax(0,1fr)] items-start gap-3 pt-3 sm:grid-cols-[auto_minmax(0,1fr)_auto] sm:items-center sm:gap-[14px] sm:pt-0 lg:mb-7 lg:grid lg:min-h-[100px] lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center lg:gap-6">
                <button
                    class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[#061942] lg:hidden"
                    type="button"
                    onclick="toggleCompanySidebar()"
                    aria-label="Open menu"
                >
                    <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7h16"></path>
                        <path d="M4 12h16"></path>
                        <path d="M4 17h16"></path>
                    </svg>
                </button>

                <div class="company-page-title min-w-0 lg:col-start-1">
                    <h1 class="mb-1 text-[22px] font-bold leading-tight text-[#061942] sm:text-2xl lg:mb-2.5 lg:text-[26px]">
                        {{ $pageTitle }}
                    </h1>

                    @if ($pageSubtitle)
                        <p class="text-[13px] leading-relaxed text-[#24344f] lg:text-sm">
                            {{ $pageSubtitle }}
                        </p>
                    @endif
                </div>

                <div class="company-topbar-actions col-span-2 flex w-full items-center justify-between gap-2 sm:col-auto sm:w-auto sm:justify-end lg:col-start-2 lg:w-[260px] lg:justify-end lg:gap-[18px]">
                    <a
                        href="/company/notifications"
                        data-ofc-notification-trigger
                        class="company-notification-link relative inline-flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-full bg-white text-[#061942] shadow-[0_8px_18px_rgba(6,25,66,.05)] lg:h-[42px] lg:w-[42px]"
                        aria-label="Notifications"
                    >
                        <svg class="h-[23px] w-[23px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
                            <path d="M10 21h4"></path>
                        </svg>

                        <span
                            data-company-notification-count
                            data-ofc-notification-badge
                            class="absolute right-[5px] top-1 hidden h-[17px] w-[17px] items-center justify-center rounded-full bg-[#ff3045] text-[11px] font-bold text-white"
                        ></span>
                    </a>

                    <div class="company-topbar-profile relative flex items-center gap-2.5 sm:border-l sm:border-[#dce7f8] sm:pl-3 lg:gap-[14px] lg:pl-[22px]">
                        <div
                            id="company-topbar-initial"
                            data-company-initial
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#075fe4] text-[17px] font-bold text-white lg:h-[46px] lg:w-[46px] lg:text-xl"
                        >C</div>

                        <div class="min-w-0">
                            <h3
                                id="company-topbar-name"
                                data-company-name
                                class="max-w-[128px] truncate text-sm font-bold text-[#061942] sm:max-w-[180px] lg:max-w-[150px]"
                            >Company</h3>
                            <p class="hidden text-xs text-[#52607a] sm:block">Company</p>
                        </div>

                        <button
                            id="company-topbar-menu-button"
                            type="button"
                            class="text-xl"
                            aria-label="User menu"
                            aria-expanded="false"
                        >&#8942;</button>

                        <div
                            id="company-topbar-menu"
                            class="absolute right-0 top-[calc(100%+12px)] z-[1200] hidden min-w-[180px] overflow-hidden rounded-lg border border-[#dce7f8] bg-white py-2 shadow-[0_12px_30px_rgba(6,25,66,.12)]"
                        >
                            <a href="/company/profile" class="block px-4 py-2.5 text-sm font-bold text-[#24344f] hover:bg-[#f5f9ff]">Profile</a>
                            <a href="/company/settings" class="block px-4 py-2.5 text-sm font-bold text-[#24344f] hover:bg-[#f5f9ff]">Settings</a>
                            <button id="company-topbar-logout" type="button" class="block w-full px-4 py-2.5 text-left text-sm font-bold text-[#ff3045] hover:bg-[#fff5f6]">Logout</button>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script>
        function toggleCompanySidebar() {
            const sidebar = document.getElementById('company-sidebar');
            const backdrop = document.getElementById('company-sidebar-backdrop');

            if (!sidebar || !backdrop) {
                return;
            }

            sidebar.classList.toggle('-translate-x-[105%]');
            sidebar.classList.toggle('translate-x-0');
            backdrop.classList.toggle('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            function getCompanyToken() {
                return localStorage.getItem('ofc_company_token') ||
                    localStorage.getItem('onlyfreshers_company_token') ||
                    localStorage.getItem('ofc_auth_token');
            }

            function parseLocalStorage(key) {
                try {
                    return JSON.parse(localStorage.getItem(key) || 'null');
                } catch (error) {
                    return null;
                }
            }

            function syncCompanyChrome(profile = null) {
                const storedUser = parseLocalStorage('onlyfreshers_company_user') ||
                    parseLocalStorage('ofc_company_user') ||
                    parseLocalStorage('ofc_auth_user');

                const storedProfile = profile || parseLocalStorage('ofc_company_profile');
                const name = storedProfile?.company_name || storedUser?.name || 'Company';
                const initial = String(name).trim().charAt(0).toUpperCase() || 'C';

                document.querySelectorAll('[data-company-name]').forEach(item => {
                    item.textContent = name;
                });

                document.querySelectorAll('[data-company-initial]').forEach(item => {
                    item.textContent = initial;
                });
            }

            async function refreshCompanyProfile() {
                const token = getCompanyToken();

                if (!token) {
                    return;
                }

                localStorage.setItem('ofc_auth_token', token);
                const companyUser = parseLocalStorage('ofc_company_user') || parseLocalStorage('onlyfreshers_company_user');
                if (companyUser) {
                    localStorage.setItem('ofc_auth_user', JSON.stringify(companyUser));
                }

                try {
                    const response = await fetch('/api/company/profile', {
                        headers: {
                            Accept: 'application/json',
                            Authorization: `Bearer ${token}`
                        }
                    });

                    if (!response.ok) {
                        return;
                    }

                    const result = await response.json();
                    const profile = result?.data?.profile || result?.data?.company_profile || result?.profile || null;

                    if (!profile) {
                        return;
                    }

                    localStorage.setItem('ofc_company_profile', JSON.stringify(profile));
                    syncCompanyChrome(profile);
                } catch (error) {
                    console.warn('Unable to refresh company profile:', error);
                }
            }

            async function syncCompanyNotificationCount() {
                const token = getCompanyToken();

                if (!token) {
                    return;
                }

                try {
                    const response = await fetch('/api/notifications/unread-count', {
                        headers: {
                            Accept: 'application/json',
                            Authorization: `Bearer ${token}`
                        }
                    });

                    if (!response.ok) {
                        return;
                    }

                    const payload = await response.json();
                    const count = Number(payload?.data?.unread_count || 0);

                    document.querySelectorAll('[data-company-notification-count]').forEach(badge => {
                        badge.textContent = count > 0 ? count : '';
                        badge.style.display = count > 0 ? 'flex' : 'none';
                        badge.classList.toggle('hidden', count === 0);
                    });
                } catch (error) {
                    console.warn('Unable to load notifications:', error);
                }
            }

            async function logoutCompany() {
                const token = getCompanyToken();
                [
                    'ofc_auth_token',
                    'ofc_auth_user',
                    'ofc_company_token',
                    'ofc_company_user',
                    'ofc_company_profile',
                    'onlyfreshers_company_token',
                    'onlyfreshers_company_user'
                ].forEach(key => localStorage.removeItem(key));
                sessionStorage.setItem('ofc_logged_out', '1');
                localStorage.setItem('ofc_logged_out', '1');

                window.location.replace('/');

                if (token) {
                    try {
                        await fetch('/api/auth/logout', {
                            method: 'POST',
                            headers: {
                                Accept: 'application/json',
                                Authorization: `Bearer ${token}`
                            }
                        });
                    } catch (error) {
                    }
                }
            }

            function guardCompanySession() {
                const token = getCompanyToken();
                const user = parseLocalStorage('onlyfreshers_company_user') ||
                    parseLocalStorage('ofc_company_user') ||
                    parseLocalStorage('ofc_auth_user');

                if (!token || user?.role !== 'company') {
                    [
                        'ofc_auth_token',
                        'ofc_auth_user',
                        'ofc_company_token',
                        'ofc_company_user',
                        'ofc_company_profile',
                        'onlyfreshers_company_token',
                        'onlyfreshers_company_user'
                    ].forEach(key => localStorage.removeItem(key));
                    window.location.replace('/company/login');
                }
            }

            function bindMenu(buttonId, menuId) {
                const button = document.getElementById(buttonId);
                const menu = document.getElementById(menuId);

                button?.addEventListener('click', function (event) {
                    event.stopPropagation();
                    menu?.classList.toggle('hidden');
                });

                document.addEventListener('click', function (event) {
                    if (!menu || menu.classList.contains('hidden')) {
                        return;
                    }

                    if (menu.contains(event.target) || button?.contains(event.target)) {
                        return;
                    }

                    menu.classList.add('hidden');
                });
            }

            bindMenu('company-topbar-menu-button', 'company-topbar-menu');
            bindMenu('company-account-menu-button', 'company-account-menu');

            document.getElementById('company-topbar-logout')?.addEventListener('click', logoutCompany);
            document.getElementById('company-sidebar-logout')?.addEventListener('click', logoutCompany);
            window.addEventListener('pageshow', guardCompanySession);

            document.addEventListener('company-profile-loaded', function (event) {
                syncCompanyChrome(event.detail);
            });

            syncCompanyChrome();
            refreshCompanyProfile();
            syncCompanyNotificationCount();
        });
    </script>

    @include('components.common.notification-popup')
    @stack('scripts')
</body>

</html>
