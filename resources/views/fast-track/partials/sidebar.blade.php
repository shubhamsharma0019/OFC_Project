@php
    $fastTrackMenuItems = $menuItems ?? [
        ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => 'DB', 'url' => '/fast-track/dashboard'],
        ['key' => 'profile', 'title' => 'My Profile', 'icon' => 'MP', 'url' => '/fast-track/profile'],
        ['key' => 'courses', 'title' => 'Fast Track Courses', 'icon' => 'FC', 'url' => '/fast-track/courses'],
        ['key' => 'details', 'title' => 'Course Details', 'icon' => 'CD', 'url' => '/fast-track/course-details'],
        ['key' => 'training', 'title' => 'My Training', 'icon' => 'MT', 'url' => '/fast-track/training'],
        ['key' => 'progress', 'title' => 'Training Progress', 'icon' => 'TP', 'url' => '/fast-track/training-progress'],
        ['key' => 'final', 'title' => 'Final Assessment', 'icon' => 'FA', 'url' => '/fast-track/final-assessment'],
        ['key' => 'certificate', 'title' => 'Certificate', 'icon' => 'CT', 'url' => '/fast-track/certificate'],
        ['key' => 'jobs', 'title' => 'Job Recommendations', 'icon' => 'JR', 'url' => '/fast-track/job-recommendations'],
        ['key' => 'applications', 'title' => 'Applications', 'icon' => 'AP', 'url' => '/fast-track/applications'],
    ];
@endphp

<aside id="fastTrackSidebar" class="fixed inset-y-0 left-0 z-50 flex w-[286px] -translate-x-full flex-col border-r border-[#dce7f8] bg-white shadow-2xl transition-transform duration-300 lg:translate-x-0 lg:shadow-none">
    <div class="flex min-h-0 flex-1 flex-col px-5 py-6">
        <a href="/fast-track/dashboard" class="mb-7 flex h-14 items-center">
            <img src="/ofclogo1.svg" alt="OnlyFreshers" class="max-h-12 w-auto object-contain">
        </a>

        <nav class="min-h-0 flex-1 space-y-2 overflow-y-auto pr-1 [scrollbar-width:thin]">
            @foreach ($fastTrackMenuItems as $item)
                <a class="flex min-h-11 items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-bold transition {{ ($activePage ?? '') === $item['key'] ? 'bg-[#eff5ff] text-[#075fe4]' : 'text-[#061942] hover:bg-[#f5f8ff] hover:text-[#075fe4]' }}" href="{{ $item['url'] }}">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg text-xs font-black {{ ($activePage ?? '') === $item['key'] ? 'bg-white text-[#075fe4]' : 'bg-[#f1f5ff] text-[#5b2cff]' }}">{{ $item['icon'] }}</span>
                    <span class="min-w-0 flex-1 truncate">{{ $item['title'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-5 shrink-0 space-y-2 border-t border-[#dce7f8] pt-4">
            <a class="flex min-h-11 items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-bold text-[#061942] transition hover:bg-[#f5f8ff] hover:text-[#075fe4]" href="#">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-[#f1f5ff] text-xs font-black text-[#5b2cff]">ST</span>
                <span>Settings</span>
            </a>
            <a class="flex min-h-11 items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-bold text-[#061942] transition hover:bg-[#fff1f4] hover:text-[#ff335f]" href="/fast-track/login">
                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-[#f1f5ff] text-xs font-black text-[#5b2cff]">LO</span>
                <span>Logout</span>
            </a>
        </div>
    </div>
</aside>
