@php
    $partner = $partner ?? ['name' => 'CodeAcademy', 'role' => 'Training Partner', 'notifications' => 3];
    $menuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => '<path d="M4 11l8-7 8 7"></path><path d="M6 10v9h5v-5h2v5h5v-9"></path>', 'url' => '/training-partner/dashboard'],
        ['key' => 'profile', 'title' => 'My Profile', 'icon' => '<circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path>', 'url' => '/training-partner/profile'],
        ['key' => 'add-course', 'title' => 'Add Course', 'icon' => '<path d="M4 5h7a3 3 0 0 1 3 3v11a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v11a3 3 0 0 1 3-3h7z"></path><path d="M12 9v6M9 12h6"></path>', 'url' => '/training-partner/add-course'],
        ['key' => 'courses', 'title' => 'My Courses', 'icon' => '<path d="M4 5h7a3 3 0 0 1 3 3v11a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v11a3 3 0 0 1 3-3h7z"></path>', 'url' => '/training-partner/courses'],
        ['key' => 'enrollments', 'title' => 'Enrollments', 'icon' => '<circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><circle cx="17" cy="9" r="2.5"></circle><path d="M14 19c0-2.4 1.8-4 4-4"></path>', 'url' => '/training-partner/enrollments'],
        ['key' => 'progress', 'title' => 'Training Progress', 'icon' => '<path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path>', 'url' => '/training-partner/training-progress'],
        ['key' => 'assessments', 'title' => 'Assessments', 'icon' => '<rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 13h6M9 17h4"></path>', 'url' => '/training-partner/assessments'],
        ['key' => 'certificates', 'title' => 'Certificates', 'icon' => '<path d="M6 3h12v18l-6-3-6 3z"></path><path d="M9 8h6M9 12h6"></path>', 'url' => '/training-partner/certificates'],
        ['key' => 'reports', 'title' => 'Reports', 'icon' => '<path d="M3 3v18h18"></path><path d="M7 15l4-4 3 3 5-7"></path>', 'url' => '/training-partner/reports'],
        ['key' => 'payouts', 'title' => 'Payouts', 'icon' => '<rect x="3" y="6" width="18" height="15" rx="2"></rect><path d="M3 10h18M7 15h4"></path>', 'url' => '/training-partner/payouts'],
        ['key' => 'notifications', 'title' => 'Notifications', 'icon' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path>', 'url' => '/training-partner/notifications'],
    ];
    $activePage = $activePage ?? '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Training Partner')</title>
    @include('components.common.auth-storage')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-auto min-h-screen overflow-x-hidden bg-[#f8faff] font-sans font-medium text-[#071544] md:h-screen md:overflow-hidden">
    <div class="layout group min-h-screen overflow-visible md:grid md:h-screen md:grid-cols-[270px_minmax(0,1fr)] md:overflow-hidden">
        <aside class="fixed left-0 top-0 z-[1000] flex h-screen w-[286px] max-w-[86vw] -translate-x-[105%] flex-col overflow-y-auto overflow-x-hidden border-r border-[#dfe4f2] bg-white shadow-[18px_0_38px_rgba(34,23,91,0.18)] transition-transform duration-200 group-[.sidebar-open]:translate-x-0 md:static md:z-auto md:w-[270px] md:max-w-none md:translate-x-0 md:shadow-none">
            <a class="flex h-[70px] shrink-0 items-center border-b border-[#dfe4f2] px-5" href="/training-partner/dashboard">
                @if (file_exists(public_path('ofclogo1.svg')))
                    <img src="/ofclogo1.svg" alt="OnlyFreshers" class="block max-h-[52px] w-[205px] object-contain object-left">
                @else
                    <span class="flex min-w-0 items-center gap-2.5 text-xl font-black text-[#5b20e6]">
                        <span class="flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-[10px] bg-[#5b20e6] text-sm text-white">OF</span>
                        <span>OnlyFreshers</span>
                    </span>
                @endif
            </a>

            <nav class="grid min-h-0 shrink gap-2 overflow-hidden px-3.5 py-3 content-start">
                @foreach($menuItems as $item)
                    <a class="relative flex min-h-[42px] items-center gap-3 rounded-lg px-3 py-1.5 text-[13px] font-bold leading-[1.18] {{ $activePage === $item['key'] ? 'bg-[#f2eaff] text-[#5b20e6]' : 'text-[#26375f] hover:bg-[#f8f4ff] hover:text-[#5b20e6]' }}" href="{{ $item['url'] }}">
                        <span class="flex h-[32px] w-[32px] shrink-0 items-center justify-center rounded-lg bg-[#f3ecff] text-[#5b20e6]" style="display:flex;width:32px;height:32px;align-items:center;justify-content:center;flex:0 0 32px;border-radius:8px;background:#f3ecff;color:#5b20e6;">
                            <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;width:18px;height:18px;">{!! $item['icon'] !!}</svg>
                        </span>
                        <span class="min-w-0 truncate">{{ $item['title'] }}</span>
                        @if(!empty($item['dot']))
                            <span class="ml-auto h-2 w-2 rounded-full bg-[#8a4fff]"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            @hasSection('sidebarExtra')
                <div class="mt-auto shrink-0 px-3.5 pb-2.5 pt-1">
                    @yield('sidebarExtra')
                </div>
            @endif
        </aside>

        <button class="fixed inset-0 z-[900] hidden border-0 bg-[#07154459] group-[.sidebar-open]:block md:!hidden" type="button" onclick="toggleTrainingSidebar()" aria-label="Close menu"></button>

        <main class="flex min-h-screen min-w-0 flex-col overflow-visible md:h-screen md:min-h-0 md:overflow-hidden">
            <header class="flex min-h-[68px] shrink-0 items-center gap-2.5 border-b border-[#dfe4f2] bg-white px-3 py-2.5 md:h-[78px] md:px-7 md:py-0">
                <button class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-lg border border-[#dfe4f2] bg-white text-[#071544] md:hidden [&>svg]:h-[21px] [&>svg]:w-[21px] [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]" type="button" onclick="toggleTrainingSidebar()" aria-label="Open menu">
                    <svg viewBox="0 0 24 24"><path d="M4 7h16"></path><path d="M4 12h16"></path><path d="M4 17h16"></path></svg>
                </button>

                <div class="relative ml-auto flex min-w-0 items-center gap-2.5">
                    <button class="relative h-[34px] w-[34px] text-[#071544] [&>svg]:h-[21px] [&>svg]:w-[21px] [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]" type="button" aria-label="Notifications">
                        <svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>
                        <span class="absolute -right-0 -top-0 flex h-4 w-4 items-center justify-center rounded-full bg-[#5b20e6] text-[10px] font-extrabold text-white">{{ $partner['notifications'] }}</span>
                    </button>
                    <div data-training-partner-initial class="flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-full bg-[#e9edf8] text-[11px] font-black text-[#5b20e6] md:h-10 md:w-10 md:text-[13px]">TP</div>
                    <div class="min-w-0">
                        <h3 data-training-partner-name class="max-w-[118px] truncate text-xs font-bold text-[#071544] md:max-w-[150px]">{{ $partner['name'] }}</h3>
                        <small class="hidden text-[#526287] sm:block">Training Partner</small>
                    </div>
                    <button class="inline-flex h-[34px] w-[34px] items-center justify-center text-[#071544] [&>svg]:h-[21px] [&>svg]:w-[21px] [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]" id="userMenuBtn" type="button" aria-label="Open profile menu">
                        <svg viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    <div class="absolute right-0 top-[54px] z-10 hidden w-40 rounded-lg border border-[#dddff0] bg-white shadow-[0_14px_30px_rgba(34,23,91,0.13)]" id="userMenu">
                        <a class="block px-3.5 py-3 text-[13px] hover:bg-[#f8f4ff]" href="/training-partner/profile">Profile</a>
                        <button id="trainingPartnerLogout" class="block w-full px-3.5 py-3 text-left text-[13px] hover:bg-[#f8f4ff]" type="button">Logout</button>
                    </div>
                </div>
            </header>

            <section class="min-w-0 flex-1 overflow-visible px-3 py-5 md:min-h-0 md:overflow-y-auto md:overflow-x-hidden md:px-7 md:py-[26px]">
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        (function guardTrainingPartnerSession() {
            if (window.location.pathname === '/training-partner/login' || window.location.pathname === '/training-partner/register') return;

            const token = localStorage.getItem('ofc_training_partner_token') || localStorage.getItem('ofc_auth_token');
            let user = null;

            try {
                user = JSON.parse(localStorage.getItem('ofc_training_partner_user') || localStorage.getItem('ofc_auth_user') || 'null');
            } catch (error) {
                user = null;
            }

            if (!token || user?.role !== 'training_partner') {
                localStorage.removeItem('ofc_auth_token');
                localStorage.removeItem('ofc_auth_user');
                localStorage.removeItem('ofc_training_partner_profile');
                window.location.href = '/training-partner/login';
            }

            localStorage.setItem('ofc_auth_token', token);
            localStorage.setItem('ofc_auth_user', JSON.stringify(user));
        })();

        function toggleTrainingSidebar() {
            document.querySelector('.layout').classList.toggle('sidebar-open');
        }

        const userMenuBtn = document.getElementById('userMenuBtn');
        if (userMenuBtn) {
            userMenuBtn.addEventListener('click', function () {
                document.getElementById('userMenu').classList.toggle('hidden');
            });
        }

        function syncTrainingPartnerChrome(profile = null) {
            const storedUser = JSON.parse(localStorage.getItem('ofc_training_partner_user') || localStorage.getItem('ofc_auth_user') || 'null');
            const storedProfile = profile || JSON.parse(localStorage.getItem('ofc_training_partner_profile') || 'null');
            const name = storedProfile?.institute_name || storedUser?.name || 'Training Partner';
            const initial = name.split(/\s+/).map((word) => word[0]).join('').slice(0, 2).toUpperCase();

            document.querySelectorAll('[data-training-partner-name]').forEach((item) => item.textContent = name);
            document.querySelectorAll('[data-training-partner-initial]').forEach((item) => item.textContent = initial);
        }

        document.getElementById('trainingPartnerLogout')?.addEventListener('click', async () => {
            const token = localStorage.getItem('ofc_training_partner_token') || localStorage.getItem('ofc_auth_token');
            if (token) {
                try {
                    await fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + token,
                        },
                    });
                } catch (error) {}
            }
            localStorage.removeItem('ofc_auth_token');
            localStorage.removeItem('ofc_auth_user');
            localStorage.removeItem('ofc_training_partner_token');
            localStorage.removeItem('ofc_training_partner_user');
            localStorage.removeItem('ofc_training_partner_profile');
            window.location.href = '/training-partner/login';
        });

        syncTrainingPartnerChrome();
        document.addEventListener('training-partner-profile-loaded', (event) => syncTrainingPartnerChrome(event.detail));
    </script>
    @stack('scripts')
</body>
</html>
