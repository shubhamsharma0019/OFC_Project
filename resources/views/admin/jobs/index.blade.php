@extends('layouts.admin')

@section('title', 'Jobs - OnlyFreshers Admin')
@section('pageTitle', 'Jobs')
@section('breadcrumb', 'Dashboard > Jobs')

@php
    $activePage = 'jobs';
    $stats = [
        ['label' => 'Total Jobs', 'value' => '248', 'tone' => 'bg-[#eaf2ff] text-[#075fe4]'],
        ['label' => 'Active', 'value' => '186', 'tone' => 'bg-[#e8f8ef] text-[#078346]'],
        ['label' => 'Pending Review', 'value' => '34', 'tone' => 'bg-[#fff4df] text-[#b86500]'],
        ['label' => 'Updated Today', 'value' => '18', 'tone' => 'bg-[#f3ecff] text-[#5b20e6]'],
    ];
    $rows = [
        ['name' => 'UI/UX Designer', 'category' => 'Job', 'owner' => 'OnlyFreshers Team', 'status' => 'Open'],
        ['name' => 'Data Science Track', 'category' => 'Job', 'owner' => 'Admin Team', 'status' => 'Active'],
        ['name' => 'Review Queue Item', 'category' => 'Job', 'owner' => 'Operations', 'status' => 'Pending'],
        ['name' => 'Monthly Highlight', 'category' => 'Job', 'owner' => 'Platform', 'status' => 'Active'],
    ];
@endphp

@section('topbarExtra')
    <button class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)]" type="button">+ Add New</button>
@endsection

@section('content')
    <section class="grid gap-5">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-xs font-black {{ $stat['tone'] }}">{{ substr($stat['label'], 0, 2) }}</span>
                    <p class="mt-4 text-xs font-bold text-[#52607a]">{{ $stat['label'] }}</p>
                    <h2 class="mt-2 text-3xl font-bold text-[#061942]">{{ $stat['value'] }}</h2>
                </article>
            @endforeach
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 sm:flex-row sm:items-center sm:justify-between">
                <input id="adminSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search...">
                <select class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option>All Status</option><option>Active</option><option>Pending</option></select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] border-collapse text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">Name</th><th class="px-5 py-4">Category</th><th class="px-5 py-4">Owner</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Actions</th></tr>
                    </thead>
                    <tbody id="adminRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        @foreach ($rows as $row)
                            <tr class="admin-row" data-name="{{ strtolower($row['name'].' '.$row['category'].' '.$row['status']) }}">
                                <td class="px-5 py-4 font-bold text-[#061942]">{{ $row['name'] }}</td>
                                <td class="px-5 py-4">{{ $row['category'] }}</td>
                                <td class="px-5 py-4">{{ $row['owner'] }}</td>
                                <td class="px-5 py-4"><span class="rounded-md {{ $row['status'] === 'Pending' ? 'bg-[#fff4df] text-[#b86500]' : 'bg-[#e8f8ef] text-[#078346]' }} px-3 py-1 text-xs font-bold">{{ $row['status'] }}</span></td>
                                <td class="px-5 py-4"><button class="rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button">View</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const adminSearch = document.getElementById('adminSearch');
    adminSearch?.addEventListener('input', () => {
        const query = adminSearch.value.toLowerCase();
        document.querySelectorAll('.admin-row').forEach(row => row.classList.toggle('hidden', !row.dataset.name.includes(query)));
    });
</script>
@endpush
