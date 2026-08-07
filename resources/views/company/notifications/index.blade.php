@extends('layouts.company')

@section('title', 'Notifications - OnlyFreshers')
@section('pageTitle', 'Notifications')
@section('pageSubtitle', 'Stay updated with the latest activities and alerts.')

@php
    $activePage = 'notifications';
    $notifications = [
        ['title' => 'New application received', 'text' => 'Ananya Gupta has applied for Full Stack Developer position.', 'type' => 'applications', 'time' => '2 min ago', 'read' => false, 'icon' => 'AP'],
        ['title' => 'New job application', 'text' => 'Rohit Kumar applied for React Developer position.', 'type' => 'applications', 'time' => '18 min ago', 'read' => false, 'icon' => 'AP'],
        ['title' => 'Interview scheduled', 'text' => 'Interview for Priya Singh is scheduled on 25 May 2024.', 'type' => 'interviews', 'time' => '1 hour ago', 'read' => false, 'icon' => 'IN'],
        ['title' => 'Candidate shortlisted', 'text' => 'Aman Sharma has been shortlisted for React Developer position.', 'type' => 'applications', 'time' => '3 hours ago', 'read' => true, 'icon' => 'SH'],
        ['title' => 'New message received', 'text' => 'You have received a new message from Sneha Patel.', 'type' => 'system', 'time' => '1 day ago', 'read' => true, 'icon' => 'MS'],
        ['title' => 'Package expiring soon', 'text' => 'Your Premium Plan package will expire in 5 days.', 'type' => 'system', 'time' => '2 days ago', 'read' => true, 'icon' => 'PK'],
        ['title' => 'System update', 'text' => 'System maintenance scheduled on 28 May 2024 from 02:00 AM to 04:00 AM.', 'type' => 'system', 'time' => '3 days ago', 'read' => true, 'icon' => 'SY'],
        ['title' => 'Interview reminder', 'text' => 'Backend Developer interview starts tomorrow at 11:00 AM.', 'type' => 'interviews', 'time' => '4 days ago', 'read' => true, 'icon' => 'IN'],
    ];
    $unread = collect($notifications)->where('read', false)->count();
    $applications = collect($notifications)->where('type', 'applications')->count();
    $interviews = collect($notifications)->where('type', 'interviews')->count();
    $system = collect($notifications)->where('type', 'system')->count();

    $typeClasses = [
        'applications' => ['icon' => 'bg-[#eaf2ff] text-[#075fe4]', 'tag' => 'bg-[#eaf2ff] text-[#075fe4]'],
        'interviews' => ['icon' => 'bg-[#eef9f2] text-[#00a65a]', 'tag' => 'bg-[#e9f9ef] text-[#00a65a]'],
        'system' => ['icon' => 'bg-[#fff4df] text-[#ff9800]', 'tag' => 'bg-[#fff1dc] text-[#ff9800]'],
    ];
@endphp

@section('content')
    <section class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <div class="flex flex-wrap items-center gap-x-5 gap-y-3 border-b border-[#dce7f8] px-[22px] pt-4">
            <button class="notification-tab border-b-[3px] border-[#075fe4] pb-3.5 text-[13px] font-bold text-[#075fe4]" type="button" data-filter="all">All ({{ count($notifications) }})</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="unread">Unread ({{ $unread }})</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="applications">Applications ({{ $applications }})</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="interviews">Interviews ({{ $interviews }})</button>
            <button class="notification-tab border-b-[3px] border-transparent pb-3.5 text-[13px] text-[#24344f]" type="button" data-filter="system">System ({{ $system }})</button>

            <button id="markRead" class="mb-4 h-[38px] rounded-lg bg-[#075fe4] px-[18px] text-xs font-bold text-white transition hover:bg-[#0554cc] sm:ml-auto" type="button">
                Mark all as read
            </button>
        </div>

        <div id="notificationList">
            @foreach ($notifications as $notice)
                <article class="notification-row grid grid-cols-[12px_44px_minmax(0,1fr)] gap-3.5 border-b border-[#edf2fb] px-[22px] py-[18px] last:border-b-0 md:grid-cols-[16px_58px_minmax(0,1fr)_110px_28px] md:items-center" data-type="{{ $notice['type'] }}" data-read="{{ $notice['read'] ? 'true' : 'false' }}">
                    <span class="mt-5 h-[9px] w-[9px] rounded-full {{ $notice['read'] ? 'bg-transparent' : 'bg-[#075fe4]' }} md:mt-0"></span>

                    <span class="flex h-12 w-12 items-center justify-center rounded-full text-[11px] font-extrabold {{ $typeClasses[$notice['type']]['icon'] }}">
                        {{ $notice['icon'] }}
                    </span>

                    <div class="min-w-0">
                        <h3 class="mb-1.5 text-[13px] font-bold text-[#061942]">{{ $notice['title'] }}</h3>
                        <p class="mb-1.5 text-xs leading-relaxed text-[#334b83]">{{ $notice['text'] }}</p>
                        <span class="inline-flex rounded-md px-2.5 py-1 text-[11px] capitalize {{ $typeClasses[$notice['type']]['tag'] }}">{{ $notice['type'] }}</span>
                    </div>

                    <span class="hidden text-right text-xs text-[#334b83] md:block">{{ $notice['time'] }}</span>
                    <button class="hidden text-xl leading-none text-[#075fe4] md:block" type="button" aria-label="Notification actions">...</button>
                </article>
            @endforeach
        </div>

        <div class="flex flex-col gap-4 border-t border-[#edf2fb] px-[22px] py-4 text-xs text-[#334b83] sm:flex-row sm:items-center sm:justify-between">
            <span id="showingText">Showing 1 to {{ count($notifications) }} of {{ count($notifications) }} notifications</span>
            <div class="flex gap-2.5">
                <button class="h-[34px] w-[34px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#061942]" type="button">&lt;</button>
                <button class="h-[34px] w-[34px] rounded-lg border border-[#075fe4] bg-[#075fe4] font-bold text-white" type="button">1</button>
                <button class="h-[34px] w-[34px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#061942]" type="button">2</button>
                <button class="h-[34px] w-[34px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#061942]" type="button">3</button>
                <button class="h-[34px] w-[34px] rounded-lg border border-[#dce7f8] bg-white font-bold text-[#061942]" type="button">&gt;</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const tabs = document.querySelectorAll('.notification-tab');
    const notices = document.querySelectorAll('.notification-row');
    const showingText = document.getElementById('showingText');

    function applyFilter(filter) {
        let count = 0;
        notices.forEach(function (notice) {
            const match = filter === 'all' || notice.dataset.type === filter || (filter === 'unread' && notice.dataset.read === 'false');
            notice.classList.toggle('hidden', !match);
            if (match) count++;
        });
        showingText.textContent = 'Showing 1 to ' + count + ' of ' + count + ' notifications';
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]', 'font-bold');
                item.classList.add('border-transparent', 'text-[#24344f]');
            });
            tab.classList.remove('border-transparent', 'text-[#24344f]');
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]', 'font-bold');
            applyFilter(tab.dataset.filter);
        });
    });

    document.getElementById('markRead').addEventListener('click', function () {
        notices.forEach(function (notice) {
            notice.dataset.read = 'true';
            notice.querySelector('span').classList.remove('bg-[#075fe4]');
            notice.querySelector('span').classList.add('bg-transparent');
        });
        applyFilter(document.querySelector('.notification-tab.border-[#075fe4]').dataset.filter);
    });
</script>
@endpush
