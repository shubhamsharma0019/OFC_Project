@extends('layouts.admin')

@section('title', 'Reports - OnlyFreshers Admin')
@section('pageTitle', 'Reports')
@section('breadcrumb', 'Dashboard > Reports')

@php
    $activePage = 'reports';
    $rows = ['User Growth Report','Revenue Summary','Course Performance','Hiring Funnel'];
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="grid gap-4 sm:grid-cols-3">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><p class="text-xs font-bold text-[#52607a]">Total</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">42</h2></article>
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><p class="text-xs font-bold text-[#52607a]">Active</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">31</h2></article>
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><p class="text-xs font-bold text-[#52607a]">Updated</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">Today</h2></article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between"><input class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search..."><button class="h-10 rounded-md border border-[#075fe4] px-4 text-sm font-bold text-[#075fe4]" type="button">Filter</button></div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]"><tr><th class="px-5 py-4">Name</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Updated</th><th class="px-5 py-4">Action</th></tr></thead>
                    <tbody class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        @foreach ($rows as $row)
                            <tr><td class="px-5 py-4 font-bold text-[#061942]">{{ $row }}</td><td class="px-5 py-4"><span class="rounded-md bg-[#e8f8ef] px-3 py-1 text-xs font-bold text-[#078346]">Active</span></td><td class="px-5 py-4 text-[#52607a]">31 May 2025</td><td class="px-5 py-4"><button class="rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button">View</button></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
