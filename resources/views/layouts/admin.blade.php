<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OnlyFreshers Admin')</title>
    @include('components.common.auth-storage')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #admin-layout,
        #admin-layout * {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
            font-weight: 500 !important;
        }

        #admin-layout h1,
        #admin-layout h2,
        #admin-layout h3,
        #admin-layout strong,
        #admin-layout .font-bold,
        #admin-layout .font-semibold,
        #admin-layout .font-black {
            font-weight: 600 !important;
        }
    </style>
    @stack('styles')
    <style>
        #admin-layout,
        #admin-layout *,
        #admin-sidebar,
        #admin-sidebar * {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
            font-weight: 500 !important;
        }

        #admin-layout table,
        #admin-layout thead,
        #admin-layout tbody,
        #admin-layout tr,
        #admin-layout th,
        #admin-layout td,
        #admin-layout input,
        #admin-layout select,
        #admin-layout textarea,
        #admin-layout a,
        #admin-layout p,
        #admin-layout span,
        #admin-layout div {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
        }

        #admin-layout h1,
        #admin-layout h2,
        #admin-layout h3,
        #admin-layout h4,
        #admin-layout b,
        #admin-layout button,
        #admin-layout thead,
        #admin-layout th,
        #admin-layout .font-bold,
        #admin-layout .font-semibold,
        #admin-layout .font-black,
        #admin-sidebar .font-bold,
        #admin-sidebar .font-semibold,
        #admin-sidebar .font-black {
            font-weight: 600 !important;
        }

        #admin-layout tbody,
        #admin-layout tbody *,
        #admin-layout td,
        #admin-layout td *,
        #admin-layout td strong,
        #admin-layout .admin-rows,
        #admin-layout #adminRows,
        #admin-layout #adminRows *,
        #admin-layout .divide-y,
        #admin-layout .divide-y * {
            font-weight: 500 !important;
        }

        #admin-layout td .font-bold,
        #admin-layout td .font-semibold,
        #admin-layout td .font-black,
        #admin-layout td strong,
        #admin-layout td b {
            font-weight: 500 !important;
        }

        #admin-layout th,
        #admin-layout button,
        #admin-layout .rounded-md[class*="bg-"],
        #admin-layout .rounded-full[class*="bg-"],
        #admin-layout .admin-pill,
        #admin-layout .admin-list-row h3,
        #admin-layout .admin-feed-card h3,
        #admin-layout .admin-enrollment-card h3 {
            font-weight: 600 !important;
        }
    </style>
</head>
<body class="h-screen overflow-hidden bg-[#f4f8ff] font-sans font-medium text-[#061942] antialiased">
    <div id="admin-layout" class="h-screen lg:grid lg:grid-cols-[220px_minmax(0,1fr)]">
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-[1000] flex h-screen w-[260px] max-w-[86vw] -translate-x-[105%] flex-col justify-between overflow-hidden border-r border-[#dce7f8] bg-white px-3 pb-[22px] pt-3.5 shadow-[18px_0_38px_rgba(6,25,66,.16)] transition-transform duration-200 ease-out lg:static lg:z-auto lg:w-auto lg:max-w-none lg:translate-x-0 lg:shadow-none">
            @include('components.admin.sidebar')
        </aside>

        <button id="admin-sidebar-backdrop" class="fixed inset-0 z-[900] hidden border-0 bg-[#06194259]" type="button" onclick="toggleAdminSidebar()" aria-label="Close menu"></button>

        <main class="h-screen min-w-0 overflow-y-auto px-3 py-[18px] sm:px-4 sm:py-[22px] lg:px-7 lg:py-9">
            @hasSection('customTop')
                @yield('customTop')
            @else
                <div class="mb-[22px] grid w-full grid-cols-[auto_minmax(0,1fr)] items-start gap-[14px] sm:grid-cols-[auto_minmax(0,1fr)_auto] sm:items-center lg:mb-[26px] lg:flex lg:justify-between">
                    <button class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[#075fe4] lg:hidden" type="button" onclick="toggleAdminSidebar()" aria-label="Open menu">
                        <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"></path><path d="M4 12h16"></path><path d="M4 17h16"></path></svg>
                    </button>

                    <div class="min-w-0">
                        <h1 class="mb-2 text-[21px] font-semibold leading-tight text-[#061942] sm:text-[23px] lg:text-[30px]">@yield('pageTitle')</h1>
                        @hasSection('breadcrumb')
                            <div class="text-[13px] text-[#52607a] lg:text-[15px]">@yield('breadcrumb')</div>
                        @endif
                    </div>

                    <div class="col-span-2 flex min-w-0 items-center justify-between gap-2.5 sm:col-auto sm:justify-end lg:gap-4">
                        @yield('topbarExtra')
                        <div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-[#075fe4] lg:h-[46px] lg:w-[46px]" aria-hidden="true">
                            <svg class="h-[23px] w-[23px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        (function guardAdminSession() {
            if (window.location.pathname === '/admin/login') return;

            const token = localStorage.getItem('ofc_auth_token');
            const adminLogin = localStorage.getItem('onlyFreshersAdminLogin');
            let user = null;

            try {
                user = JSON.parse(localStorage.getItem('ofc_auth_user') || 'null');
            } catch (error) {
                user = null;
            }

            if (!token || adminLogin !== 'yes' || user?.role !== 'admin') {
                localStorage.removeItem('ofc_auth_token');
                localStorage.removeItem('ofc_auth_user');
                localStorage.removeItem('onlyFreshersAdminLogin');
                window.location.href = '/admin/login';
            }
        })();

        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('admin-sidebar-backdrop');

            if (!sidebar || !backdrop) return;

            sidebar.classList.toggle('-translate-x-[105%]');
            sidebar.classList.toggle('translate-x-0');
            backdrop.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
