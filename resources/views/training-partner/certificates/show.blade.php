@extends('layouts.training-partner')

@section('title', 'Certificate Details')

@php
    $activePage = 'certificates';
    $stats = [
        ['label' => 'Total', 'value' => '124', 'icon' => 'TT'],
        ['label' => 'Active', 'value' => '86', 'icon' => 'AC'],
        ['label' => 'Pending', 'value' => '18', 'icon' => 'PN'],
        ['label' => 'Updated', 'value' => 'Today', 'icon' => 'UP'],
    ];
    $rows = [
        ['name' => 'Full Stack Development', 'type' => 'Course', 'status' => 'Active', 'date' => '10 May 2024'],
        ['name' => 'Data Science & Analytics', 'type' => 'Course', 'status' => 'Active', 'date' => '09 May 2024'],
        ['name' => 'React for Beginners', 'type' => 'Course', 'status' => 'Pending', 'date' => '08 May 2024'],
        ['name' => 'Python Programming', 'type' => 'Course', 'status' => 'Active', 'date' => '07 May 2024'],
    ];
@endphp

@section('content')
    <section class="grid gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="mb-2 text-2xl font-bold text-[#071544]">Certificate Details</h1>
                <p class="text-sm leading-relaxed text-[#526287]">View certificate information and verification status.</p>
            </div>
            @if ('detail' === 'form')
                <button class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white" type="button">Save Changes</button>
            @elseif ('certificates' === 'add-course')
                <button class="h-10 rounded-md bg-[#5b20e6] px-5 text-sm font-bold text-white" type="button">Create Course</button>
            @endif
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3ecff] text-xs font-black text-[#5b20e6]">{{ $stat['icon'] }}</span>
                    <p class="mt-4 text-xs font-bold text-[#526287]">{{ $stat['label'] }}</p>
                    <h2 class="mt-2 text-2xl font-bold text-[#071544]">{{ $stat['value'] }}</h2>
                </article>
            @endforeach
        </div>

        @if ('detail' === 'form')
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <div class="grid gap-4 lg:grid-cols-2">
                    <label class="grid gap-2 text-xs font-bold text-[#071544]">Title<input class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none" value="Certificate Details"></label>
                    <label class="grid gap-2 text-xs font-bold text-[#071544]">Category<select class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm font-medium outline-none"><option>Development</option><option>Data Science</option></select></label>
                    <label class="grid gap-2 text-xs font-bold text-[#071544] lg:col-span-2">Description<textarea class="min-h-28 rounded-md border border-[#cfd8eb] p-3 text-sm font-medium outline-none">View certificate information and verification status.</textarea></label>
                </div>
            </article>
        @elseif ('detail' === 'detail')
            <article class="rounded-lg border border-[#dddff0] bg-white p-5 shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <h2 class="mb-4 text-lg font-bold text-[#071544]">Overview</h2>
                <div class="grid gap-4 lg:grid-cols-3">
                    <div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">Name</p><strong class="mt-2 block text-[#071544]">Certificate Details</strong></div>
                    <div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">Status</p><span class="mt-2 inline-flex rounded-md bg-[#e2f9ea] px-3 py-1 text-xs font-bold text-[#05843e]">Active</span></div>
                    <div class="rounded-lg border border-[#e7ebf5] p-4"><p class="text-xs font-bold text-[#526287]">Updated</p><strong class="mt-2 block text-[#071544]">Today</strong></div>
                </div>
            </article>
        @else
            <article class="overflow-hidden rounded-lg border border-[#dddff0] bg-white shadow-[0_12px_26px_rgba(50,35,120,.05)]">
                <div class="flex flex-col gap-3 border-b border-[#e7ebf5] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <input id="tpSearch" class="h-10 w-full rounded-md border border-[#cfd8eb] px-3 text-sm outline-none sm:max-w-xs" type="search" placeholder="Search...">
                    <select class="h-10 rounded-md border border-[#cfd8eb] px-3 text-sm"><option>All Status</option><option>Active</option><option>Pending</option></select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[820px] text-left text-sm">
                        <thead class="bg-[#fbfdff] text-xs font-bold text-[#071544]"><tr><th class="px-5 py-4">Name</th><th class="px-5 py-4">Type</th><th class="px-5 py-4">Date</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Action</th></tr></thead>
                        <tbody class="divide-y divide-[#e7ebf5] text-[#26375f]">
                            @foreach ($rows as $row)
                                <tr class="tp-row" data-name="{{ strtolower($row['name'].' '.$row['type'].' '.$row['status']) }}"><td class="px-5 py-4 font-bold text-[#071544]">{{ $row['name'] }}</td><td class="px-5 py-4">{{ $row['type'] }}</td><td class="px-5 py-4">{{ $row['date'] }}</td><td class="px-5 py-4"><span class="rounded-md {{ $row['status'] === 'Pending' ? 'bg-[#fff0de] text-[#d06d00]' : 'bg-[#e2f9ea] text-[#05843e]' }} px-3 py-1 text-xs font-bold">{{ $row['status'] }}</span></td><td class="px-5 py-4"><button class="rounded-md border border-[#5b20e6] px-3 py-2 text-xs font-bold text-[#5b20e6]" type="button">View</button></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>
        @endif
    </section>
@endsection

@push('scripts')
<script>
    const tpSearch = document.getElementById('tpSearch');
    tpSearch?.addEventListener('input', () => {
        const query = tpSearch.value.toLowerCase();
        document.querySelectorAll('.tp-row').forEach(row => row.classList.toggle('hidden', !row.dataset.name.includes(query)));
    });
</script>
@endpush
