@extends('layouts.company')
@section('title', 'Edit Job - OnlyFreshers')
@section('pageTitle', 'Edit Job')
@section('pageSubtitle', 'Update an existing job posting.')
@php $activePage = 'jobs'; @endphp
@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
<form class="grid gap-5 md:grid-cols-2"><label><span class="mb-2 block text-xs font-bold">Job Title</span><input class="h-12 w-full rounded-lg border border-[#dce7f8] px-4" value="Full Stack Developer"></label><label><span class="mb-2 block text-xs font-bold">Job Role</span><input class="h-12 w-full rounded-lg border border-[#dce7f8] px-4" value="Software Engineer"></label><label><span class="mb-2 block text-xs font-bold">Experience</span><select class="h-12 w-full rounded-lg border border-[#dce7f8] px-4"><option>0 - 1 Year</option><option>1 - 3 Years</option></select></label><label><span class="mb-2 block text-xs font-bold">Employment Type</span><select class="h-12 w-full rounded-lg border border-[#dce7f8] px-4"><option>Full Time</option><option>Internship</option></select></label><label class="md:col-span-2"><span class="mb-2 block text-xs font-bold">Description</span><textarea class="min-h-32 w-full rounded-lg border border-[#dce7f8] p-4">We are looking for a passionate full stack developer.</textarea></label><div class="flex justify-end gap-3 md:col-span-2"><a href="/company/jobs" class="inline-flex h-11 items-center rounded-lg border px-6 text-sm font-bold text-[#075fe4]">Cancel</a><button class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white">Save Job</button></div></form>
</section>
@endsection
@push('scripts')
<script>document.querySelector('form').addEventListener('submit', function (event) { event.preventDefault(); window.location.href = '/company/jobs/show'; });</script>
@endpush

