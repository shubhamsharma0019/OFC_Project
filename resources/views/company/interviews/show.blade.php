@extends('layouts.company')
@section('title', 'Interview Details - OnlyFreshers')
@section('pageTitle', 'Interview Details')
@section('pageSubtitle', 'View interview schedule and candidate details.')
@php $activePage = 'interviews'; @endphp
@section('content')
<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
    <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <div class="mb-6 flex items-center gap-4"><div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#eaf2ff] text-lg font-bold text-[#075fe4]">RK</div><div><h2 class="text-xl font-bold text-[#061942]">Rohit Kumar</h2><p class="text-sm text-[#52607a]">Full Stack Developer</p></div></div>
        <div class="grid gap-4 md:grid-cols-2"><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="text-sm">Interview Type</b><p class="mt-1 text-sm text-[#24344f]">Technical</p></div><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="text-sm">Interviewer</b><p class="mt-1 text-sm text-[#24344f]">Amit Sharma</p></div><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="text-sm">Date</b><p class="mt-1 text-sm text-[#24344f]">05 Jun 2024</p></div><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="text-sm">Time</b><p class="mt-1 text-sm text-[#24344f]">11:00 AM</p></div></div>
        <h3 class="mb-2 mt-6 font-bold text-[#061942]">Notes</h3><p class="text-sm leading-relaxed text-[#24344f]">Focus on Laravel, React fundamentals, database design and problem solving.</p>
    </div>
    <aside class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)]"><h3 class="mb-4 font-bold">Status</h3><span class="inline-flex h-8 rounded-lg bg-[#fff0d1] px-3 text-xs font-bold text-[#c86b00] items-center">Scheduled</span><div class="mt-5 grid gap-3"><a href="https://meet.google.com/" target="_blank" class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white">Join Meeting</a><a href="/company/interviews/create" class="inline-flex h-10 items-center justify-center rounded-lg border border-[#9fc0f5] text-sm font-bold text-[#075fe4]">Reschedule</a></div></aside>
</section>
@endsection

