@php
    $student = array_merge(['name' => 'Ananya Gupta', 'notifications' => 3], $student ?? []);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Fast Track')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #fastTrackLayout,
        #fastTrackLayout * {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
            font-weight: 500 !important;
        }

        #fastTrackLayout h1,
        #fastTrackLayout h2,
        #fastTrackLayout h3,
        #fastTrackLayout strong,
        #fastTrackLayout .font-bold,
        #fastTrackLayout .font-extrabold,
        #fastTrackLayout .font-black {
            font-weight: 700 !important;
        }

        #fastTrackLayout h1 {
            font-weight: 800 !important;
        }

        #fastTrackSidebar .fast-track-sidebar-link,
        #fastTrackSidebar .fast-track-sidebar-link span {
            font-weight: 650 !important;
        }

        #fastTrackSidebar .fast-track-sidebar-link.bg-\[\#eff5ff\],
        #fastTrackSidebar .fast-track-sidebar-link.bg-\[\#eff5ff\] span {
            font-weight: 750 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen overflow-x-hidden bg-[#f5f8ff] font-sans text-[#061942] antialiased">
    <div id="fastTrackLayout" class="min-h-screen lg:grid lg:grid-cols-[286px_minmax(0,1fr)]">
        @include('fast-track.partials.sidebar')

        <button id="fastTrackBackdrop" class="fixed inset-0 z-40 hidden border-0 bg-[#061942]/35 lg:hidden" type="button" onclick="toggleFastTrackSidebar()" aria-label="Close menu"></button>

        <main class="min-w-0 lg:col-start-2">
            <header class="sticky top-0 z-30 flex min-h-[76px] items-center justify-between border-b border-[#dce7f8] bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">
                <button id="fastTrackMenuButton" class="inline-flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[#061942] shadow-sm lg:hidden" type="button" onclick="toggleFastTrackSidebar()" aria-label="Open menu">
                    <svg class="h-5 w-5 fill-none stroke-current stroke-2 [stroke-linecap:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16"></path><path d="M4 12h16"></path><path d="M4 17h16"></path></svg>
                </button>

                <div class="ml-auto flex items-center gap-3">
                    <button class="relative inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#dce7f8] bg-white text-[#061942] shadow-sm" type="button" data-ofc-notification-trigger aria-label="Notifications">
                        <svg class="h-5 w-5 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path></svg>
                        <span id="fastTrackNotificationCount" data-ofc-notification-badge class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#ff335f] px-1 text-xs font-bold text-white">{{ $student['notifications'] }}</span>
                    </button>

                    <div class="relative flex items-center gap-3">
                        <div id="fastTrackAvatar" class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-full bg-gradient-to-br from-[#1769ff] to-[#17a6a8] bg-cover bg-center text-sm font-black text-white"></div>
                        <h3 id="fastTrackStudentName" class="hidden max-w-[160px] truncate text-sm font-bold text-[#061942] sm:block">{{ $student['name'] }}</h3>
                        <button id="fastTrackUserMenuBtn" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-[#455a82] hover:bg-[#eff5ff]" type="button" aria-label="Open account menu">
                            <svg class="h-5 w-5 fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>

                        <div id="fastTrackUserMenu" class="absolute right-0 top-[calc(100%+12px)] hidden w-44 rounded-lg border border-[#dce7f8] bg-white py-2 shadow-xl">
                            <a class="block px-4 py-2 text-sm font-semibold text-[#061942] hover:bg-[#eff5ff]" href="/fast-track/profile">My Profile</a>
                            <a id="fastTrackLogout" class="block px-4 py-2 text-sm font-semibold text-[#061942] hover:bg-[#eff5ff]" href="/fast-track/login">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <div class="px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        (function guardFastTrackSession() {
            const token = localStorage.getItem('onlyfreshers_token') || localStorage.getItem('ofc_fresher_token') || localStorage.getItem('ofc_auth_token');
            let user = null;

            try {
                user = JSON.parse(localStorage.getItem('onlyfreshers_user') || localStorage.getItem('ofc_fresher_user') || localStorage.getItem('ofc_auth_user') || 'null');
            } catch (error) {
                user = null;
            }

            if (!token || user?.role !== 'fresher') {
                ['ofc_auth_token', 'ofc_auth_user', 'onlyfreshers_token', 'onlyfreshers_user', 'fast_track_course_id'].forEach((key) => localStorage.removeItem(key));
                window.location.href = '/fast-track/login';
            }
        })();

        window.addEventListener('pageshow', function () {
            const token = localStorage.getItem('onlyfreshers_token') || localStorage.getItem('ofc_fresher_token') || localStorage.getItem('ofc_auth_token');
            let user = null;
            try {
                user = JSON.parse(localStorage.getItem('onlyfreshers_user') || localStorage.getItem('ofc_fresher_user') || localStorage.getItem('ofc_auth_user') || 'null');
            } catch (error) {}
            if (!token || user?.role !== 'fresher') {
                ['ofc_auth_token', 'ofc_auth_user', 'ofc_fresher_token', 'ofc_fresher_user', 'onlyfreshers_token', 'onlyfreshers_user', 'fast_track_course_id'].forEach((key) => localStorage.removeItem(key));
                window.location.replace('/fast-track/login');
            }
        });

        document.getElementById('fastTrackLogout')?.addEventListener('click', function (event) {
            event.preventDefault();
            ['ofc_auth_token', 'ofc_auth_user', 'ofc_fresher_token', 'ofc_fresher_user', 'onlyfreshers_token', 'onlyfreshers_user', 'fast_track_course_id'].forEach((key) => localStorage.removeItem(key));
            window.location.replace('/fast-track/login');
        });

        function toggleFastTrackSidebar() {
            const sidebar = document.getElementById('fastTrackSidebar');
            const backdrop = document.getElementById('fastTrackBackdrop');

            if (!sidebar || !backdrop) return;

            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        const fastTrackUserMenuBtn = document.getElementById('fastTrackUserMenuBtn');
        const fastTrackUserMenu = document.getElementById('fastTrackUserMenu');

        if (fastTrackUserMenuBtn && fastTrackUserMenu) {
            fastTrackUserMenuBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                fastTrackUserMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!event.target.closest('#fastTrackUserMenu')) {
                    fastTrackUserMenu.classList.add('hidden');
                }
            });
        }
    </script>
    @include('components.common.notification-popup')
    <script src="/js/fast-track-dynamic.js"></script>
    @stack('scripts')
</body>
</html>
