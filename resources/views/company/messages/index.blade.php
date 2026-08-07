@extends('layouts.company')

@section('title', 'Messages - OnlyFreshers')
@section('pageTitle', 'Messages')
@section('pageSubtitle', 'Communicate with candidates and manage conversations.')

@php
    $activePage = 'messages';

    $conversations = [
        ['name' => 'Rohit Kumar', 'role' => 'Full Stack Developer', 'preview' => 'Thank you for considering my application. I am very interested...', 'time' => '10:30 AM', 'unread' => 2, 'starred' => true, 'avatar' => 'RK', 'date' => '05 Jun 2024', 'messages' => [
            ['from' => 'candidate', 'text' => 'Hi, I wanted to follow up on my application for the Full Stack Developer position.', 'time' => '10:15 AM'],
            ['from' => 'company', 'text' => 'Hi Rohit,<br><br>Thank you for your interest in the role. We are reviewing applications and will get back to you soon.', 'time' => '10:18 AM'],
            ['from' => 'candidate', 'text' => 'Thank you for the update. I am very interested in this opportunity and look forward to hearing from you.', 'time' => '10:20 AM'],
            ['from' => 'company', 'text' => 'Great! We will keep you updated on the next steps.', 'time' => '10:22 AM'],
        ]],
        ['name' => 'Priya Singh', 'role' => 'Full Stack Developer', 'preview' => 'I wanted to follow up on my application for the Full Stack...', 'time' => 'Yesterday', 'unread' => 1, 'starred' => false, 'avatar' => 'PS', 'date' => '04 Jun 2024', 'messages' => [
            ['from' => 'candidate', 'text' => 'Hello, I wanted to follow up on my application for the Full Stack Developer role.', 'time' => '09:40 AM'],
            ['from' => 'company', 'text' => 'Hi Priya, your profile is under review. We will update you shortly.', 'time' => '10:05 AM'],
        ]],
        ['name' => 'Aman Sharma', 'role' => 'React Developer', 'preview' => 'Can you please share more details about the next steps?', 'time' => '02 Jun', 'unread' => 0, 'starred' => false, 'avatar' => 'AS', 'date' => '02 Jun 2024', 'messages' => [
            ['from' => 'candidate', 'text' => 'Can you please share more details about the next steps?', 'time' => '03:25 PM'],
            ['from' => 'company', 'text' => 'Sure Aman, the next step is a technical interview. We will share a schedule soon.', 'time' => '03:40 PM'],
        ]],
        ['name' => 'Sneha Patel', 'role' => 'UI/UX Designer', 'preview' => 'Thank you! I look forward to hearing from you.', 'time' => '31 May', 'unread' => 0, 'starred' => false, 'avatar' => 'SP', 'date' => '31 May 2024', 'messages' => [
            ['from' => 'company', 'text' => 'Hi Sneha, thanks for sharing your portfolio.', 'time' => '12:05 PM'],
            ['from' => 'candidate', 'text' => 'Thank you! I look forward to hearing from you.', 'time' => '12:22 PM'],
        ]],
        ['name' => 'Karan Mehta', 'role' => 'Backend Developer', 'preview' => 'I have attached my updated resume for your reference.', 'time' => '30 May', 'unread' => 0, 'starred' => false, 'avatar' => 'KM', 'date' => '30 May 2024', 'messages' => [
            ['from' => 'candidate', 'text' => 'I have attached my updated resume for your reference.', 'time' => '05:15 PM'],
            ['from' => 'company', 'text' => 'Thanks Karan. Our team will review it.', 'time' => '05:28 PM'],
        ]],
    ];

    $unreadCount = collect($conversations)->where('unread', '>', 0)->count();
@endphp

@section('content')
    <section class="grid min-h-[760px] overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,0.04)] xl:grid-cols-[390px_minmax(0,1fr)]">
        <aside class="flex min-h-0 flex-col border-b border-[#dce7f8] xl:border-b-0 xl:border-r">
            <div class="px-[18px] pt-[22px]">
                <div class="mb-[18px] grid grid-cols-[minmax(0,1fr)_46px] gap-3">
                    <input id="searchInput" type="search" placeholder="Search messages..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-3.5 text-[13px] text-[#061942] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    <button type="button" class="rounded-lg border border-[#dce7f8] bg-white text-[#075fe4] transition hover:bg-[#f5f9ff]" aria-label="Filter messages">
                        <svg class="mx-auto h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M7 12h10"></path><path d="M10 18h4"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-3 border-b border-[#dce7f8]">
                    <button class="message-tab border-b-[3px] border-[#075fe4] px-2 py-[13px] text-[13px] font-bold text-[#075fe4]" type="button" data-filter="all">All</button>
                    <button class="message-tab border-b-[3px] border-transparent px-2 py-[13px] text-[13px] text-[#24344f]" type="button" data-filter="unread">Unread ({{ $unreadCount }})</button>
                    <button class="message-tab border-b-[3px] border-transparent px-2 py-[13px] text-[13px] text-[#24344f]" type="button" data-filter="starred">Starred</button>
                </div>
            </div>

            <div id="conversationList" class="min-h-0 overflow-y-auto">
                @foreach ($conversations as $conversation)
                    <button type="button" class="conversation grid w-full grid-cols-[58px_minmax(0,1fr)_auto] gap-3.5 border-b border-[#edf2fb] px-[18px] py-4 text-left {{ $loop->first ? 'active border-l-[3px] border-l-[#9fc0f5] bg-[#f5f8ff]' : '' }}" data-index="{{ $loop->index }}" data-name="{{ strtolower($conversation['name'].' '.$conversation['preview']) }}" data-unread="{{ $conversation['unread'] > 0 ? 'yes' : 'no' }}" data-starred="{{ $conversation['starred'] ? 'yes' : 'no' }}">
                        <span class="flex h-[52px] w-[52px] items-center justify-center rounded-full bg-[#eaf2ff] text-[13px] font-bold text-[#075fe4]">{{ $conversation['avatar'] }}</span>
                        <span class="min-w-0">
                            <span class="mb-2 block text-[13px] font-bold text-[#061942]">{{ $conversation['name'] }}</span>
                            <span class="line-clamp-2 text-xs leading-relaxed text-[#24344f]">{{ $conversation['preview'] }}</span>
                        </span>
                        <span class="text-right text-xs text-[#24344f]">
                            <span class="block">{{ $conversation['time'] }}</span>
                            @if ($conversation['unread'] > 0)
                                <span class="mt-[18px] inline-flex h-[22px] w-[22px] items-center justify-center rounded-full bg-[#075fe4] text-[11px] font-bold text-white">{{ $conversation['unread'] }}</span>
                            @endif
                        </span>
                    </button>
                @endforeach
            </div>

            <div id="inboxFooter" class="mt-auto border-t border-[#edf2fb] px-6 py-[18px] text-[13px] text-[#24344f]">Showing 1 to {{ count($conversations) }} of 12 conversations</div>
        </aside>

        <div class="grid min-h-0 grid-rows-[96px_minmax(0,1fr)_auto]">
            <div class="flex items-center justify-between gap-4 border-b border-[#dce7f8] px-6">
                <div class="flex min-w-0 items-center gap-4">
                    <div id="chatAvatar" class="flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-[13px] font-bold text-[#075fe4]">RK</div>
                    <div class="min-w-0">
                        <h2 id="chatName" class="mb-1.5 text-[15px] font-bold text-[#061942]">Rohit Kumar</h2>
                        <p id="chatRole" class="text-xs text-[#52607a]">Full Stack Developer</p>
                    </div>
                </div>
                <div class="flex gap-3 text-[#061942]">
                    <button type="button" aria-label="Star conversation" class="p-1 text-2xl leading-none">&#9734;</button>
                    <button type="button" aria-label="More actions" class="p-1 text-2xl leading-none">&#8942;</button>
                </div>
            </div>

            <div id="chatBody" class="min-h-0 overflow-y-auto px-6 py-[18px]"></div>

            <div class="grid gap-4 border-t border-[#dce7f8] px-6 py-[18px] sm:grid-cols-[minmax(0,1fr)_92px] sm:items-center">
                <div class="min-h-[72px] rounded-lg border border-[#dce7f8] p-3.5">
                    <textarea id="messageInput" placeholder="Type your message..." class="h-8 w-full resize-none border-0 p-0 text-[13px] text-[#061942] outline-none placeholder:text-[#8a96aa]"></textarea>
                    <div class="mt-2 flex gap-[18px] text-[#24344f]">
                        <button type="button" aria-label="Attach file">&#128206;</button>
                        <button type="button" aria-label="Emoji">&#9786;</button>
                        <button type="button" aria-label="Template">&#9636;</button>
                    </div>
                </div>
                <button id="sendMessage" type="button" class="h-[46px] rounded-lg bg-[#075fe4] text-[13px] font-bold text-white transition hover:bg-[#0554cc]">Send</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const conversations = @json($conversations);
    const rows = document.querySelectorAll('.conversation');
    const chatName = document.getElementById('chatName');
    const chatRole = document.getElementById('chatRole');
    const chatAvatar = document.getElementById('chatAvatar');
    const chatBody = document.getElementById('chatBody');
    const searchInput = document.getElementById('searchInput');
    const inboxFooter = document.getElementById('inboxFooter');
    let activeConversation = 0;
    let activeFilter = 'all';

    function renderMessages(index) {
        const item = conversations[index];
        chatBody.innerHTML = '<div class="mx-auto mb-[18px] w-max rounded-full border border-[#dce7f8] px-[18px] py-2 text-xs text-[#52607a]">' + item.date + '</div>';

        item.messages.forEach(function (message) {
            const bubble = document.createElement('div');
            const sent = message.from === 'company';
            bubble.className = (sent ? 'ml-auto bg-[#eaf2ff]' : 'bg-white') + ' mb-4 max-w-[460px] rounded-xl border border-[#dce7f8] px-[18px] py-4 text-[13px] leading-relaxed text-[#061942]';
            bubble.innerHTML = '<p class="mb-3">' + message.text + '</p><time class="text-xs text-[#52607a]">' + message.time + '</time>';
            chatBody.appendChild(bubble);
        });

        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function openConversation(index) {
        const item = conversations[index];
        activeConversation = index;
        chatName.textContent = item.name;
        chatRole.textContent = item.role;
        chatAvatar.textContent = item.avatar;
        rows.forEach(function (row) {
            row.classList.remove('active', 'border-l-[3px]', 'border-l-[#9fc0f5]', 'bg-[#f5f8ff]');
        });
        rows[index].classList.add('active', 'border-l-[3px]', 'border-l-[#9fc0f5]', 'bg-[#f5f8ff]');
        renderMessages(index);
    }

    rows.forEach(function (row) {
        row.addEventListener('click', function () {
            openConversation(Number(row.dataset.index));
        });
    });

    function filterConversations() {
        const search = searchInput.value.toLowerCase();
        let visibleCount = 0;
        rows.forEach(function (row) {
            const matchSearch = row.dataset.name.includes(search);
            const matchFilter = activeFilter === 'all' || row.dataset[activeFilter] === 'yes';
            const show = matchSearch && matchFilter;
            row.classList.toggle('hidden', !show);
            if (show) visibleCount++;
        });
        inboxFooter.textContent = 'Showing 1 to ' + visibleCount + ' of 12 conversations';
    }

    document.querySelectorAll('.message-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.message-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]', 'font-bold');
                item.classList.add('border-transparent', 'text-[#24344f]');
            });
            tab.classList.remove('border-transparent', 'text-[#24344f]');
            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]', 'font-bold');
            activeFilter = tab.dataset.filter;
            filterConversations();
        });
    });

    searchInput.addEventListener('input', filterConversations);

    document.getElementById('sendMessage').addEventListener('click', function () {
        const input = document.getElementById('messageInput');
        if (!input.value.trim()) return;
        conversations[activeConversation].messages.push({ from: 'company', text: input.value, time: 'Now' });
        input.value = '';
        renderMessages(activeConversation);
    });

    renderMessages(0);
</script>
@endpush
