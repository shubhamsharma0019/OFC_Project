@php
    $activePage = $activePage ?? 'home';
    $navItems = [
        ['key' => 'home', 'label' => 'Home', 'url' => '/'],
        ['key' => 'jobs', 'label' => 'Jobs', 'url' => '/job'],
        ['key' => 'fast-track', 'label' => 'Fast Track Program', 'url' => '/fast-track'],
        ['key' => 'training-partners', 'label' => 'Training Partners', 'url' => '/training-partners'],
        ['key' => 'about', 'label' => 'About Us', 'url' => '/about'],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-[#dce7f8] bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-[74px] w-full max-w-7xl items-center gap-5 px-5 sm:px-6 lg:px-8">
        <a href="/" class="inline-flex shrink-0 items-center gap-3 text-[#075fe4]">
            @if (file_exists(public_path('ofclogo1.svg')))
                <img src="/ofclogo1.svg" alt="OnlyFreshers Logo" class="block h-[54px] w-[230px] object-contain object-left sm:w-[250px]">
            @else
                <span class="flex items-center gap-2 text-[#075fe4]">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#075fe4] text-base font-bold text-white">OF</span>
                    <span class="text-[22px] font-bold leading-none">OnlyFreshers</span>
                </span>
            @endif
        </a>

        <button class="ml-auto inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#dce7f8] text-2xl leading-none text-[#061942] lg:hidden" type="button" onclick="toggleMobileMenu()" aria-label="Open menu">&#9776;</button>

        <nav class="ml-auto hidden items-center gap-7 lg:flex">
            @foreach ($navItems as $item)
                <a href="{{ $item['url'] }}" class="text-sm font-bold transition {{ $activePage === $item['key'] ? 'text-[#075fe4]' : 'text-[#24344f] hover:text-[#075fe4]' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="/direct-mode/login" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#bcd2f2] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">Login</a>
            <a href="/direct-mode/register" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">Register</a>
        </div>
    </div>
</header>

<div id="mobileSidebar" class="fixed inset-0 z-50 hidden bg-[#061942]/40 lg:hidden">
    <div class="ml-auto flex h-full w-[310px] max-w-[86vw] flex-col bg-white shadow-[-18px_0_38px_rgba(6,25,66,0.18)]">
        <div class="flex h-[74px] items-center justify-between border-b border-[#dce7f8] px-5">
            <span class="text-lg font-bold text-[#061942]">Menu</span>
            <button class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#dce7f8] text-3xl leading-none text-[#061942]" type="button" onclick="toggleMobileMenu()" aria-label="Close menu">
                ×
            </button>
        </div>

        <nav class="grid gap-1 px-5 py-5">
            @foreach ($navItems as $item)
                <a href="{{ $item['url'] }}" class="rounded-lg px-4 py-3 text-sm font-bold transition {{ $activePage === $item['key'] ? 'bg-[#eaf2ff] text-[#075fe4]' : 'text-[#24344f] hover:bg-[#f5f9ff] hover:text-[#075fe4]' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto grid gap-3 border-t border-[#dce7f8] px-5 py-5">
            <a href="/direct-mode/login" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#bcd2f2] bg-white px-5 text-sm font-bold text-[#075fe4]">Login</a>
            <a href="/direct-mode/register" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white">Register</a>
        </div>
    </div>
</div>
