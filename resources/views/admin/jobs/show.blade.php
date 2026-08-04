@extends('layouts.admin')

@section('title', 'Job Details - OnlyFreshers Admin')
@section('pageTitle', 'Job Details')
@section('breadcrumb', 'Jobs / Details')

@php
    $activePage = 'jobs';
    $stats = [
        ['label' => 'Total Records', 'value' => '128'],
        ['label' => 'Active', 'value' => '96'],
        ['label' => 'Pending', 'value' => '18'],
        ['label' => 'Updated Today', 'value' => '14'],
    ];
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <p class="mb-5 text-sm leading-relaxed text-[#52607a]">Review job posting, company details and application activity.</p>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="rounded-lg border border-[#e4ecf8] bg-[#f8fbff] p-4">
                        <p class="text-xs font-bold text-[#52607a]">{{ $stat['label'] }}</p>
                        <h2 class="mt-2 text-2xl font-bold text-[#061942]">{{ $stat['value'] }}</h2>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="grid min-w-[760px] grid-cols-[1.4fr_.9fr_.9fr_.8fr] border-b border-[#e4ecf8] px-5 py-4 text-sm font-bold text-[#061942]">
                <span>Name</span><span>Status</span><span>Owner</span><span>Action</span>
            </div>
            @foreach (['Primary Record', 'Secondary Record', 'Review Queue'] as $row)
                <div class="grid min-w-[760px] grid-cols-[1.4fr_.9fr_.9fr_.8fr] items-center border-b border-[#eef3fb] px-5 py-4 text-sm last:border-b-0">
                    <strong>{{ $row }}</strong>
                    <span class="w-max rounded-md bg-[#e8f8ef] px-3 py-1 text-xs font-bold text-[#078346]">Active</span>
                    <span class="text-[#52607a]">Admin Team</span>
                    <button class="w-max rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button">View</button>
                </div>
            @endforeach
        </div>
    </section>
@endsection
