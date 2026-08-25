@php
    $activePage = $activePage ?? 'home';
    $navItems = [
        ['key' => 'home', 'label' => 'Home', 'url' => '/'],
        ['key' => 'companies', 'label' => 'Companies', 'url' => '/job'],
        ['key' => 'direct-mode', 'label' => 'Direct Mode', 'url' => '/direct-mode'],
        ['key' => 'fast-track', 'label' => 'Fast Track Program', 'url' => '/fast-track'],
        ['key' => 'training-partners', 'label' => 'Training Partners', 'url' => '/training-partners'],
        ['key' => 'about', 'label' => 'About Us', 'url' => '/about'],
    ];
@endphp

<style>
    #publicHeader {
        overflow-x: clip;
    }

    #publicHeaderInner {
        min-width: 0;
    }

    #publicHeaderLogo {
        min-width: 0;
        overflow: hidden;
    }

    #publicHeaderLogo img {
        max-width: min(250px, 48vw);
    }

    @media (max-width: 1279px) {
        #publicHeaderInner {
            height: 64px !important;
            max-width: 100% !important;
            padding-left: 14px !important;
            padding-right: 14px !important;
            gap: 10px !important;
        }

        #publicHeaderLogo img {
            width: clamp(132px, 46vw, 210px) !important;
            height: 46px !important;
            object-fit: contain !important;
            object-position: left center !important;
        }

        .public-desktop-nav,
        .public-desktop-actions {
            display: none !important;
        }

        .public-menu-button {
            display: inline-flex !important;
        }

        #mobileSidebar {
            display: none;
        }

        #mobileSidebar.flex {
            display: flex !important;
        }
    }

    @media (min-width: 1280px) {
        #publicHeaderInner {
            max-width: 1280px !important;
        }

        .public-menu-button,
        #mobileSidebar {
            display: none !important;
        }

        .public-desktop-nav,
        .public-desktop-actions {
            display: flex !important;
        }
    }
</style>

<header id="publicHeader" class="sticky top-0 z-40 border-b border-[#dce7f8] bg-white/95 backdrop-blur">
    <div id="publicHeaderInner" class="mx-auto flex h-[74px] w-full max-w-7xl items-center gap-5 px-5 sm:px-6 lg:px-8">
        <a id="publicHeaderLogo" href="/" class="inline-flex shrink-0 items-center gap-3 text-[#075fe4]">
            @if (file_exists(public_path('ofclogo1.svg')))
                <img src="/ofclogo1.svg" alt="OnlyFreshers Logo" class="block h-[54px] w-[230px] object-contain object-left sm:w-[250px]">
            @else
                <span class="flex items-center gap-2 text-[#075fe4]">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#075fe4] text-base font-bold text-white">OF</span>
                    <span class="text-[22px] font-bold leading-none">OnlyFreshers</span>
                </span>
            @endif
        </a>

        <button class="public-menu-button ml-auto inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#dce7f8] text-2xl leading-none text-[#061942] xl:hidden" type="button" onclick="toggleMobileMenu()" aria-label="Open menu">&#9776;</button>

        <nav class="public-desktop-nav ml-auto hidden items-center gap-6 xl:flex">
            @foreach ($navItems as $item)
                <a href="{{ $item['url'] }}" class="text-sm font-bold transition {{ $activePage === $item['key'] ? 'text-[#075fe4]' : 'text-[#24344f] hover:text-[#075fe4]' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="public-desktop-actions hidden items-center gap-3 xl:flex" data-public-auth-actions>
            <a href="/login" data-public-login class="inline-flex h-10 items-center justify-center rounded-lg border border-[#bcd2f2] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">Login</a>
            <a href="/register" data-public-register class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_8px_18px_rgba(7,95,228,0.18)] transition hover:bg-[#0554cc]">Register</a>
        </div>
    </div>
</header>

<div id="mobileSidebar" class="fixed inset-0 z-50 hidden bg-[#061942]/40 xl:hidden">
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

        <div class="mt-auto grid gap-3 border-t border-[#dce7f8] px-5 py-5" data-public-auth-actions>
            <a href="/login" data-public-login class="inline-flex h-11 items-center justify-center rounded-lg border border-[#bcd2f2] bg-white px-5 text-sm font-bold text-[#075fe4]">Login</a>
            <a href="/register" data-public-register class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white">Register</a>
        </div>
    </div>
</div>

<script>
    (() => {
        const parseJson = value => {
            try {
                return JSON.parse(value || 'null');
            } catch (error) {
                return null;
            }
        };

        if (localStorage.getItem('ofc_logged_out') || sessionStorage.getItem('ofc_logged_out') || localStorage.getItem('ofc_fresher_logged_out') || sessionStorage.getItem('ofc_fresher_logged_out')) {
            [
                'onlyfreshers_token',
                'onlyfreshers_user',
                'ofc_fresher_token',
                'ofc_fresher_user',
                'onlyfreshers_company_token',
                'onlyfreshers_company_user',
                'ofc_company_token',
                'ofc_company_user',
                'ofc_company_profile',
                'ofc_training_partner_token',
                'ofc_training_partner_user',
                'ofc_training_partner_profile',
                'ofc_auth_token',
                'ofc_auth_user',
                'onlyFreshersAdminLogin',
            ].forEach(key => localStorage.removeItem(key));
        }

        const sessions = [
            {
                role: 'company',
                token: localStorage.getItem('ofc_company_token') || localStorage.getItem('onlyfreshers_company_token'),
                user: parseJson(localStorage.getItem('ofc_company_user')) || parseJson(localStorage.getItem('onlyfreshers_company_user')),
                href: '/company/profile',
                fallback: 'Company Profile',
            },
            {
                role: 'training_partner',
                token: localStorage.getItem('ofc_training_partner_token'),
                user: parseJson(localStorage.getItem('ofc_training_partner_user')),
                href: '/training-partner/profile',
                fallback: 'Profile',
            },
            {
                role: 'fresher',
                token: localStorage.getItem('ofc_fresher_token') || localStorage.getItem('onlyfreshers_token'),
                user: parseJson(localStorage.getItem('ofc_fresher_user')) || parseJson(localStorage.getItem('onlyfreshers_user')),
                href: '/direct-mode/profile',
                fallback: 'Profile',
            },
        ];

        const sharedUser = parseJson(localStorage.getItem('ofc_auth_user'));
        const sharedToken = localStorage.getItem('ofc_auth_token');
        const session = sessions.find(item => item.token && item.user?.role === item.role) ||
            (sharedToken && sharedUser ? sessions.find(item => item.role === sharedUser.role) : null);

        if (!session) return;

        const name = String((session.user || sharedUser || {}).name || '').trim();
        const label = name ? name.split(/\s+/)[0] : session.fallback;

        document.querySelectorAll('[data-public-login]').forEach(link => {
            link.href = session.href;
            link.textContent = label;
        });

        document.querySelectorAll('[data-public-register]').forEach(link => {
            link.href = session.role === 'company' ? '/company/dashboard' : (session.role === 'training_partner' ? '/training-partner/dashboard' : '/direct-mode/dashboard');
            link.textContent = 'Dashboard';
        });
    })();
</script>
