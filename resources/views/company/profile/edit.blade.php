@extends('layouts.company')

@section('title', 'Edit Profile - OnlyFreshers')
@section('pageTitle', 'Edit Profile')
@section('pageSubtitle', 'Update your company profile details.')

@php $activePage = 'profile'; @endphp

@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-8">
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#075fe4] text-3xl font-bold text-white">T</div>
            <div>
                <h2 class="text-lg font-bold text-[#061942]">TechNova Solutions</h2>
                <p class="mt-1 text-sm text-[#52607a]">Company profile information</p>
            </div>
        </div>
        <button class="h-10 rounded-lg border border-[#9fc0f5] px-5 text-sm font-bold text-[#075fe4]" type="button">Upload Logo</button>
    </div>
    <form class="grid gap-5 md:grid-cols-2">
        @foreach ([['Company Name','TechNova Solutions'],['Industry','IT Services & Consulting'],['Email','info@technova.com'],['Phone','+91 98765 43210'],['Website','www.technova.com'],['Company Size','51-100 Employees']] as $field)
            <label class="block"><span class="mb-2 block text-xs font-bold text-[#061942]">{{ $field[0] }}</span><input class="h-[46px] w-full rounded-lg border border-[#dce7f8] px-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]" value="{{ $field[1] }}"></label>
        @endforeach
        <label class="block md:col-span-2"><span class="mb-2 block text-xs font-bold text-[#061942]">About Company</span><textarea class="min-h-28 w-full rounded-lg border border-[#dce7f8] p-4 text-sm text-[#24344f] outline-none focus:border-[#075fe4]">We are a product based company building innovative solutions for businesses worldwide.</textarea></label>
        <div class="flex justify-end gap-3 md:col-span-2"><a href="/company/profile" class="inline-flex h-11 items-center rounded-lg border border-[#dce7f8] px-6 text-sm font-bold text-[#075fe4]">Cancel</a><button class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white" type="submit">Save Changes</button></div>
    </form>
</section>
@endsection
@push('scripts')
<script>document.querySelector('form').addEventListener('submit', function (event) { event.preventDefault(); window.location.href = '/company/profile'; });</script>
@endpush

