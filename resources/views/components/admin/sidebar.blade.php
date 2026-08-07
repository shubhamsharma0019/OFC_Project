@php
    $adminMenuItems = [
        ['title' => 'Dashboard', 'icon' => '<path d="M4 11l8-7 8 7"></path><path d="M6 10v9h5v-5h2v5h5v-9"></path>', 'url' => '/admin/dashboard', 'key' => 'dashboard'],
        ['title' => 'Freshers', 'icon' => '<circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><circle cx="17" cy="9" r="2.5"></circle><path d="M14 19c0-2.4 1.8-4 4-4"></path>', 'url' => '/admin/freshers', 'key' => 'freshers'],
        ['title' => 'Companies', 'icon' => '<path d="M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16"></path><path d="M15 9h4a1 1 0 0 1 1 1v11"></path><path d="M8 8h3M8 12h3M8 16h3M18 13h.01M18 17h.01"></path>', 'url' => '/admin/companies', 'key' => 'companies'],
        ['title' => 'Training Partners', 'icon' => '<path d="M3 8l9-4 9 4-9 4-9-4z"></path><path d="M7 10v5c0 1.5 2.3 3 5 3s5-1.5 5-3v-5"></path>', 'url' => '/admin/training-partners', 'key' => 'training-partners'],
        ['title' => 'Jobs', 'icon' => '<rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5h6v2M4 12h16"></path>', 'url' => '/admin/jobs', 'key' => 'jobs'],
        ['title' => 'Courses', 'icon' => '<path d="M4 5h7a3 3 0 0 1 3 3v11a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v11a3 3 0 0 1 3-3h7z"></path>', 'url' => '/admin/courses', 'key' => 'courses'],
        ['title' => 'Assessments', 'icon' => '<rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 12l2 2 4-4"></path>', 'url' => '/admin/assessments', 'key' => 'assessments'],
        ['title' => 'Reports', 'icon' => '<path d="M5 19V9"></path><path d="M12 19V5"></path><path d="M19 19v-7"></path><path d="M3 19h18"></path>', 'url' => '/admin/reports', 'key' => 'reports'],
        ['title' => 'Notifications', 'icon' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path><path d="M10 21h4"></path>', 'url' => '/admin/notifications', 'key' => 'notifications'],
        ['title' => 'Settings', 'icon' => '<circle cx="12" cy="12" r="3"></circle><path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.5-2.4 1a7 7 0 0 0-1.7-1L14.5 3h-5l-.4 3a7 7 0 0 0-1.7 1L5 6 3 9.5 5 11a7 7 0 0 0 0 2l-2 1.5L5 18l2.4-1a7 7 0 0 0 1.7 1l.4 3h5l.4-3a7 7 0 0 0 1.7-1L19 18l2-3.5-2-1.5a7 7 0 0 0 .1-1z"></path>', 'url' => '/admin/settings', 'key' => 'settings'],
        ['title' => 'System Logs', 'icon' => '<path d="M12 3l8 4v6c0 5-3.5 8-8 8s-8-3-8-8V7l8-4z"></path><path d="M9 12h6"></path>', 'url' => '/admin/system-logs', 'key' => 'logs'],
    ];
@endphp

<div>
    <a href="/admin/dashboard" class="mb-6 flex h-12 items-center">
        @if (file_exists(public_path('ofclogo1.svg')))
            <img src="/ofclogo1.svg" alt="OnlyFreshers Logo" class="block max-h-11 w-[190px] object-contain object-left">
        @else
            <span class="flex items-center gap-2 text-[#075fe4]">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#075fe4] text-base font-bold text-white">OF</span>
                <span class="text-xl font-bold leading-none">OnlyFreshers</span>
            </span>
        @endif
    </a>

    <nav class="grid gap-2">
        @foreach ($adminMenuItems as $item)
            <a href="{{ $item['url'] }}" class="flex min-h-[42px] items-center gap-3.5 rounded-lg px-3 text-sm font-bold {{ ($activePage ?? '') === $item['key'] ? 'border-l-4 border-[#075fe4] bg-[#eaf2ff] text-[#075fe4]' : 'text-[#24344f]' }}">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#eaf2ff] text-[#075fe4]">
                    <svg class="h-[17px] w-[17px]" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['icon'] !!}</svg>
                </span>
                <span class="truncate">{{ $item['title'] }}</span>
            </a>
        @endforeach
    </nav>
</div>

<div class="relative flex items-center gap-3 px-0.5 pt-3">
    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-[#075fe4]">
        <svg class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg>
    </div>
    <div class="min-w-0">
        <h3 class="mb-1 truncate text-[15px] font-semibold text-[#061942]">Admin Panel</h3>
        <p class="truncate text-[13px] text-[#52607a]">Super Admin</p>
    </div>
    <button id="profileMenuButton" type="button" class="ml-auto flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-white text-[#075fe4]" aria-label="Open admin menu">
        <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"></path></svg>
    </button>
    <div id="profileMenu" class="absolute bottom-[58px] right-0 z-20 hidden w-[168px] rounded-lg border border-[#dce7f8] bg-white p-2 shadow-[0_12px_28px_rgba(6,25,66,.12)]">
        <div class="mb-1.5 border-b border-[#edf2fb] px-2.5 py-2 text-xs text-[#52607a]">admin@ofc.com</div>
        <a href="/admin/login" id="adminLogout" class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[13px] font-bold text-[#ff1f2f] hover:bg-[#fff0f1]">
            <svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="M16 17l5-5-5-5"></path><path d="M21 12H9"></path></svg>
            Logout
        </a>
    </div>
</div>

@push('scripts')
<script>
    if (localStorage.getItem('onlyFreshersAdminLogin') !== 'yes' && !window.location.pathname.includes('/admin/login')) {
        window.location.href = '/admin/login';
    }

    const profileMenuButton = document.getElementById('profileMenuButton');
    const profileMenu = document.getElementById('profileMenu');
    const adminLogout = document.getElementById('adminLogout');

    if (profileMenuButton && profileMenu) {
        profileMenuButton.addEventListener('click', function () {
            profileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!event.target.closest('#profileMenuButton') && !event.target.closest('#profileMenu')) {
                profileMenu.classList.add('hidden');
            }
        });
    }

    if (adminLogout) {
        adminLogout.addEventListener('click', function () {
            localStorage.removeItem('onlyFreshersAdminLogin');
        });
    }
</script>
@endpush
