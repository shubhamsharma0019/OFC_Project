@php
    $fastTrackMenuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => '<path d="M4 11l8-7 8 7"></path><path d="M6 10v10h12V10"></path><path d="M10 20v-6h4v6"></path>', 'url' => '/fast-track/dashboard'],
        ['key' => 'profile', 'title' => 'My Profile', 'icon' => '<circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path>', 'url' => '/fast-track/profile'],
        ['key' => 'assessment', 'title' => 'Initial Assessment', 'icon' => '<rect x="5" y="3" width="14" height="18" rx="2"></rect><path d="M9 8h6M9 13h6M9 17h3"></path>', 'url' => '/fast-track/assessment'],
        ['key' => 'courses', 'title' => 'Fast Track Courses', 'icon' => '<path d="M4 5h7a3 3 0 0 1 3 3v12a3 3 0 0 0-3-3H4z"></path><path d="M20 5h-7a3 3 0 0 0-3 3v12a3 3 0 0 1 3-3h7z"></path>', 'url' => '/fast-track/courses'],
        ['key' => 'details', 'title' => 'Course Details', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8M8 17h5"></path>', 'url' => '/fast-track/course-details'],
        ['key' => 'training', 'title' => 'My Training', 'icon' => '<rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3z"></path>', 'url' => '/fast-track/training'],
        ['key' => 'progress', 'title' => 'Training Progress', 'icon' => '<path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path>', 'url' => '/fast-track/training-progress'],
        ['key' => 'final', 'title' => 'Final Assessment', 'icon' => '<path d="M9 11l2 2 4-5"></path><rect x="4" y="3" width="16" height="18" rx="2"></rect><path d="M8 17h8"></path>', 'url' => '/fast-track/final-assessment'],
        ['key' => 'certificate', 'title' => 'Certificate', 'icon' => '<path d="M6 3h12v18l-6-3-6 3z"></path><path d="M9 8h6M9 12h6"></path>', 'url' => '/fast-track/certificate'],
        ['key' => 'jobs', 'title' => 'Job Recommendations', 'icon' => '<rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><path d="M12 12v1"></path>', 'url' => '/fast-track/job-recommendations'],
        ['key' => 'applications', 'title' => 'Applications', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M9 15l2 2 4-5"></path>', 'url' => '/fast-track/applications'],
        ['key' => 'settings', 'title' => 'Settings', 'icon' => '<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4 1.7 1.7 0 0 0 14 21h-4a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15 1.7 1.7 0 0 0 3 14v-4a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3h4a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9 1.7 1.7 0 0 0 21 10v4a1.7 1.7 0 0 0-1.6 1Z"></path>', 'url' => '#'],
        ['key' => 'logout', 'title' => 'Logout', 'icon' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5"></path><path d="M21 12H9"></path>', 'url' => '/fast-track/login'],
    ];
@endphp

<style>
    #fastTrackSidebarNav {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    #fastTrackSidebarNav::-webkit-scrollbar {
        width: 0;
        height: 0;
        display: none;
    }
</style>

<aside id="fastTrackSidebar" class="fixed inset-y-0 left-0 z-50 flex w-[286px] -translate-x-full flex-col border-r border-[#dce7f8] bg-white shadow-2xl transition-transform duration-300 lg:translate-x-0 lg:shadow-none">
    <div class="flex min-h-0 flex-1 flex-col px-5 py-5">
        <a href="/fast-track/dashboard" class="mb-5 flex h-14 items-center">
            <img src="/ofclogo1.svg" alt="OnlyFreshers" class="max-h-12 w-auto object-contain">
        </a>

        <nav id="fastTrackSidebarNav" class="min-h-0 flex-1 space-y-1.5 overflow-y-auto overflow-x-hidden pr-0">
            @foreach ($fastTrackMenuItems as $item)
                <a class="flex min-h-10 items-center gap-3 rounded-lg px-3 py-1.5 text-sm font-bold transition {{ ($activePage ?? '') === $item['key'] ? 'bg-[#eff5ff] text-[#075fe4]' : ($item['key'] === 'logout' ? 'text-[#061942] hover:bg-[#fff1f4] hover:text-[#ff335f]' : 'text-[#061942] hover:bg-[#f5f8ff] hover:text-[#075fe4]') }}" href="{{ $item['url'] }}">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg {{ ($activePage ?? '') === $item['key'] ? 'bg-white text-[#075fe4]' : 'bg-[#f1f5ff] text-[#5b2cff]' }}">
                        <svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true">{!! $item['icon'] !!}</svg>
                    </span>
                    <span class="min-w-0 flex-1 truncate">{{ $item['title'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</aside>
