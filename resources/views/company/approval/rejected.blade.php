@extends('layouts.company')
@section('title', 'Approval Rejected - OnlyFreshers')
@section('pageTitle', 'Approval Rejected')
@section('pageSubtitle', 'Review the reason and update your company profile.')
@php $activePage = 'profile'; @endphp
@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-8 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
    <div class="mb-5 flex items-center gap-4"><div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#ffe8eb] text-xl font-bold text-[#ff3045]">X</div><div><h2 class="text-xl font-bold text-[#061942]">Profile needs updates</h2><p class="text-sm text-[#24344f]">Please correct the highlighted information and resubmit.</p></div></div>
    <div class="rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm text-[#24344f]">Company registration document is unclear. Upload a sharper copy and verify company address.</div>
    <a href="/company/profile/edit" class="mt-6 inline-flex h-11 items-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">Update Profile</a>
</section>
@endsection
