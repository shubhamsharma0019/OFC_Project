<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'OnlyFreshers') }}</title>
    @include('components.common.compiled-assets')
</head>
<body class="min-h-screen bg-[#f8faff] font-sans text-[#061942]">
    <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col items-center justify-center px-6 py-16 text-center">
        <a href="{{ url('/') }}" class="mb-8 inline-flex items-center gap-3 text-[#075fe4]">
            @if (file_exists(public_path('ofclogo1.svg')))
                <img src="/ofclogo1.svg" alt="OnlyFreshers" class="block max-h-12 w-[205px] object-contain object-left">
            @else
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#075fe4] text-lg font-bold text-white">OF</span>
                <span class="text-3xl font-bold">OnlyFreshers</span>
            @endif
        </a>

        <section class="w-full rounded-lg border border-[#dce7f8] bg-white px-6 py-12 shadow-[0_18px_40px_rgba(6,25,66,0.08)] sm:px-10">
            <p class="mb-3 text-sm font-bold uppercase tracking-wide text-[#075fe4]">Laravel Application</p>
            <h1 class="mx-auto max-w-3xl text-3xl font-bold leading-tight sm:text-5xl">Welcome to OnlyFreshers</h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-[#34445e] sm:text-lg">Choose a workspace to preview the current dashboards and pages.</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <a href="/admin/dashboard" class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] px-5 py-4 text-sm font-bold text-[#075fe4] transition hover:border-[#075fe4] hover:bg-white">Admin Dashboard</a>
                <a href="/training-partner/dashboard" class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] px-5 py-4 text-sm font-bold text-[#5b20e6] transition hover:border-[#5b20e6] hover:bg-white">Training Partner</a>
                <a href="/company/dashboard" class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] px-5 py-4 text-sm font-bold text-[#075fe4] transition hover:border-[#075fe4] hover:bg-white">Company Dashboard</a>
            </div>
        </section>
    </main>
</body>
</html>