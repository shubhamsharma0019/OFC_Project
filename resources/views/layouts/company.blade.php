<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Company Dashboard - OnlyFreshers')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="h-screen overflow-hidden bg-[#f4f8ff] font-sans font-medium text-[#061942] antialiased">
    <div id="company-layout" class="h-screen lg:grid lg:grid-cols-[250px_minmax(0,1fr)]">
        <aside id="company-sidebar"
            class="fixed inset-y-0 left-0 z-[1000] flex h-screen w-[280px] max-w-[86vw] -translate-x-[105%] flex-col justify-between overflow-hidden border-r border-[#dce7f8] bg-white px-[18px] pb-7 shadow-[18px_0_36px_rgba(6,25,66,.16)] transition-transform duration-200 ease-out lg:static lg:z-auto lg:w-auto lg:max-w-none lg:translate-x-0 lg:shadow-none">
            @include('components.company.sidebar')
        </aside>

        <button id="company-sidebar-backdrop" class="fixed inset-0 z-[900] hidden bg-[#06194259]" type="button"
            onclick="toggleCompanySidebar()" aria-label="Close menu"></button>

        <main class="h-screen min-w-0 overflow-y-auto px-3 pb-6 sm:px-[18px] sm:pb-[30px] lg:px-[38px] lg:pb-[38px]">
            <header
                class="mb-[22px] grid min-h-[78px] grid-cols-[auto_minmax(0,1fr)] items-start gap-3 pt-3 sm:grid-cols-[auto_minmax(0,1fr)_auto] sm:items-center sm:gap-[14px] sm:pt-0 lg:mb-7 lg:flex lg:min-h-[100px] lg:items-center lg:justify-between lg:gap-6">
                <button
                    class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[#061942] lg:hidden"
                    type="button" onclick="toggleCompanySidebar()" aria-label="Open menu">
                    <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7h16"></path>
                        <path d="M4 12h16"></path>
                        <path d="M4 17h16"></path>
                    </svg>
                </button>

                <div class="min-w-0">
                    <h1
                        class="mb-1 text-[22px] font-bold leading-tight text-[#061942] sm:text-2xl lg:mb-2.5 lg:text-[26px]">
                        @yield('pageTitle')</h1>
                    @hasSection('pageSubtitle')
                        <p class="text-[13px] leading-relaxed text-[#24344f] lg:text-sm">@yield('pageSubtitle')</p>
                    @endif
                </div>

                <div
                    class="col-span-2 flex w-full items-center justify-between gap-2 sm:col-auto sm:w-auto sm:justify-end lg:gap-[18px]">
                    @yield('topbarExtra')

                    <button
                        class="relative inline-flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-full bg-white text-[#061942] shadow-[0_8px_18px_rgba(6,25,66,.05)] lg:h-[42px] lg:w-[42px]"
                        type="button" aria-label="Notifications">
                        <svg class="h-[23px] w-[23px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
                            <path d="M10 21h4"></path>
                        </svg>
                        <span
                            class="absolute right-[5px] top-1 flex h-[17px] w-[17px] items-center justify-center rounded-full bg-[#ff3045] text-[11px] font-bold text-white">3</span>
                    </button>

                    <div
                        class="flex items-center gap-2.5 sm:border-l sm:border-[#dce7f8] sm:pl-3 lg:gap-[14px] lg:pl-[22px]">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#075fe4] text-[17px] font-bold text-white lg:h-[46px] lg:w-[46px] lg:text-xl">
                            T</div>
                        <div class="min-w-0">
                            <h3
                                class="max-w-[128px] truncate text-sm font-bold text-[#061942] sm:max-w-[180px] lg:max-w-[150px]">
                                TechNova Solutions</h3>
                            <p class="hidden text-xs text-[#52607a] sm:block">Company</p>
                        </div>
                        <button class="text-xl" type="button" aria-label="User menu"></button>
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
    </script>
    @stack('scripts')
</body>

</html>
