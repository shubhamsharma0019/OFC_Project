<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OnlyFreshers')</title>

    @include('components.common.auth-storage')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (max-width: 640px) {
            html,
            body {
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
            }

            body {
                position: relative;
            }

            #public-site {
                width: 100% !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }

            #public-site,
            #public-site * {
                max-width: 100vw !important;
                min-width: 0;
                box-sizing: border-box;
            }

            #public-site > *,
            #public-site main,
            #public-site main > *,
            #public-site section,
            #public-site section > div {
                width: 100% !important;
                max-width: 100vw !important;
                overflow-x: clip !important;
            }

            #public-site img,
            #public-site video,
            #public-site svg {
                max-width: 100%;
            }

            #public-site header > div {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) 40px !important;
                height: 64px;
                gap: 10px;
                padding-left: 14px;
                padding-right: 14px;
                overflow: hidden;
            }

            #public-site header a:first-child {
                min-width: 0 !important;
                overflow: hidden;
            }

            #public-site header img[alt="OnlyFreshers Logo"] {
                width: clamp(118px, 54vw, 178px) !important;
                height: 44px !important;
                object-fit: contain !important;
                object-position: left center !important;
            }

            #public-site header button[aria-label="Open menu"] {
                width: 40px !important;
                min-width: 40px !important;
                margin-left: 0 !important;
            }

            #public-site h1 {
                font-size: clamp(28px, 9vw, 34px) !important;
                line-height: 1.08 !important;
            }

            #public-site h2 {
                font-size: clamp(20px, 7vw, 26px) !important;
                line-height: 1.15 !important;
            }

            #public-site h3 {
                line-height: 1.2 !important;
            }

            #public-site section {
                overflow-x: clip !important;
            }

            #public-site main > section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #public-site main > section > div,
            #public-site footer > div {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }

            #public-site [class*="min-w-["] {
                min-width: 0 !important;
            }

            #public-site [class*="max-w-["] {
                max-width: 100vw !important;
            }

            #public-site [class*="-mr-"],
            #public-site [class*="-ml-"] {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            #public-site [class*="grid-cols-["] {
                grid-template-columns: minmax(0, 1fr) !important;
            }

            #public-site .overflow-x-auto {
                overflow-x: visible !important;
            }

            #public-site a,
            #public-site button {
                white-space: normal;
            }

            #public-site a[class*="h-"],
            #public-site button[class*="h-"] {
                min-height: 40px;
                height: auto;
            }

            #public-site form,
            #public-site label,
            #public-site input,
            #public-site select,
            #public-site textarea {
                width: 100%;
            }

            #public-site footer .divide-x > * {
                border-left-width: 0 !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen overflow-x-hidden bg-white font-sans text-[#061942] antialiased">
    <div id="public-site" class="flex min-h-screen flex-col">
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
