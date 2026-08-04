@extends('layouts.company')
@section('title', 'Schedule Interview - OnlyFreshers')
@section('pageTitle', 'Schedule Interview')
@section('pageSubtitle', 'Create a new interview schedule.')
@php $activePage = 'interviews'; @endphp
@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
    <form class="grid gap-5 md:grid-cols-2">
        <label><span class="mb-2 block text-xs font-bold text-[#061942]">Candidate</span><select class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm"><option>Rohit Kumar</option><option>Priya Singh</option></select></label>
        <label><span class="mb-2 block text-xs font-bold text-[#061942]">Job Role</span><select class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm"><option>Full Stack Developer</option><option>React Developer</option></select></label>
        <label><span class="mb-2 block text-xs font-bold text-[#061942]">Interview Type</span><select class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm"><option>Technical</option><option>HR Round</option><option>Design Test</option></select></label>
        <label><span class="mb-2 block text-xs font-bold text-[#061942]">Interviewer</span><select class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm"><option>Amit Sharma</option><option>Ritika Verma</option></select></label>
        <label><span class="mb-2 block text-xs font-bold text-[#061942]">Date</span><input type="date" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm"></label>
        <label><span class="mb-2 block text-xs font-bold text-[#061942]">Time</span><input type="time" class="h-12 w-full rounded-lg border border-[#dce7f8] px-4 text-sm"></label>
        <label class="md:col-span-2"><span class="mb-2 block text-xs font-bold text-[#061942]">Meeting Link / Notes</span><textarea class="min-h-28 w-full rounded-lg border border-[#dce7f8] p-4 text-sm" placeholder="Add interview notes or meeting link"></textarea></label>
        <div class="flex justify-end gap-3 md:col-span-2"><a href="/company/interviews" class="inline-flex h-11 items-center rounded-lg border border-[#dce7f8] px-6 text-sm font-bold text-[#075fe4]">Cancel</a><button class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">Schedule</button></div>
    </form>
</section>
@endsection
@push('scripts')
<script>document.querySelector('form').addEventListener('submit', function (event) { event.preventDefault(); window.location.href = '/company/interviews/show'; });</script>
@endpush

