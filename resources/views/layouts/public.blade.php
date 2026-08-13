<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OnlyFreshers')</title>

    @include('components.common.auth-storage')
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen overflow-x-hidden bg-white font-sans text-[#061942] antialiased">
    <div class="flex min-h-screen flex-col">
        @include('components.public.header')

        <main class="min-w-0 flex-1">
            @yield('content')
        </main>

        @include('components.public.footer')
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileSidebar = document.getElementById('mobileSidebar');
            if (!mobileSidebar) return;
            mobileSidebar.classList.toggle('hidden');
            mobileSidebar.classList.toggle('flex');
        }
    </script>
    @stack('scripts')
</body>
</html>
