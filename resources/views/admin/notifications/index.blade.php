@extends('layouts.admin')

@section('title', 'Notifications - OnlyFreshers Admin')
@section('pageTitle', 'Notifications')
@section('breadcrumb', 'Dashboard > Notifications')
@section('topbarExtra')
    <button class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" type="button">+ New Notification</button>
@endsection

@php
    $activePage = 'notifications';
    $notifications = [
        ['title' => 'New Courses Added', 'send_to' => 'All Users', 'sent_on' => '31 May 2025, 10:30 AM', 'status' => 'Sent'],
        ['title' => 'Maintenance Update', 'send_to' => 'All Users', 'sent_on' => '30 May 2025, 09:15 AM', 'status' => 'Sent'],
        ['title' => 'Upcoming Webinar', 'send_to' => 'Active Users', 'sent_on' => '29 May 2025, 04:45 PM', 'status' => 'Sent'],
        ['title' => 'System Update', 'send_to' => 'Admin Only', 'sent_on' => '27 May 2025, 08:30 PM', 'status' => 'Draft'],
    ];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
        <div class="border-b border-[#edf2fb] p-4"><input id="notificationSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search notification..."></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px] border-collapse text-left text-sm">
                <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">#</th><th class="px-5 py-4">Title</th><th class="px-5 py-4">Send To</th><th class="px-5 py-4">Sent On</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr></thead>
                <tbody class="divide-y divide-[#edf2fb] text-[#1b315b]">
                    @foreach ($notifications as $index => $notification)
                        <tr class="notification-row" data-title="{{ strtolower($notification['title'].' '.$notification['send_to'].' '.$notification['status']) }}"><td class="px-5 py-4">{{ $index + 1 }}</td><td class="px-5 py-4 font-bold text-[#061942]">{{ $notification['title'] }}</td><td class="px-5 py-4">{{ $notification['send_to'] }}</td><td class="px-5 py-4">{{ $notification['sent_on'] }}</td><td class="px-5 py-4"><span class="rounded-md {{ $notification['status'] === 'Draft' ? 'bg-[#eef2f8] text-[#24344f]' : 'bg-[#dff8ed] text-[#009b52]' }} px-3 py-1 text-xs font-bold">{{ $notification['status'] }}</span></td><td class="px-5 py-4"><button class="rounded-md bg-[#eef5ff] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button">View</button></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="resultText" class="px-5 py-4 text-sm text-[#52607a]">Showing {{ count($notifications) }} notifications</div>
    </section>
@endsection

@push('scripts')
<script>
    const notificationSearch = document.getElementById('notificationSearch');
    notificationSearch?.addEventListener('input', () => { const q = notificationSearch.value.toLowerCase(); document.querySelectorAll('.notification-row').forEach(row => row.classList.toggle('hidden', !row.dataset.title.includes(q))); });
</script>
@endpush
