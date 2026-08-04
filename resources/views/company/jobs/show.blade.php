@extends('layouts.company')
@section('title', 'Job Details - OnlyFreshers')
@section('pageTitle', 'Job Details')
@section('pageSubtitle', 'View job posting details and activity.')
@php $activePage = 'jobs'; @endphp
@section('content')
<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
    <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)]">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"><div><h2 class="text-xl font-bold text-[#061942]">Full Stack Developer</h2><p class="mt-2 text-sm text-[#24344f]">Bangalore • Full Time • 0 - 1 Year</p></div><span class="inline-flex h-8 items-center rounded-lg bg-[#dbf8e9] px-3 text-xs font-bold text-[#00a65a]">Active</span></div>
        <div class="mb-6 grid gap-4 sm:grid-cols-3"><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="block text-lg text-[#061942]">56</b><span class="text-xs text-[#52607a]">Applications</span></div><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="block text-lg text-[#061942]">12</b><span class="text-xs text-[#52607a]">Shortlisted</span></div><div class="rounded-lg bg-[#f4f8ff] p-4"><b class="block text-lg text-[#061942]">5</b><span class="text-xs text-[#52607a]">Interviews</span></div></div>
        <h3 class="mb-3 text-base font-bold text-[#061942]">Job Description</h3><p class="text-sm leading-relaxed text-[#24344f]">We are looking for a passionate full stack developer with strong fundamentals in frontend, backend and database development.</p>
        <h3 class="mb-3 mt-6 text-base font-bold text-[#061942]">Required Skills</h3><div class="flex flex-wrap gap-2"><span class="rounded-lg bg-[#eaf2ff] px-3 py-2 text-xs font-bold text-[#075fe4]">React</span><span class="rounded-lg bg-[#eaf2ff] px-3 py-2 text-xs font-bold text-[#075fe4]">Laravel</span><span class="rounded-lg bg-[#eaf2ff] px-3 py-2 text-xs font-bold text-[#075fe4]">MySQL</span></div>
    </div>
    <aside class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)]"><h3 class="mb-4 text-base font-bold text-[#061942]">Actions</h3><div class="grid gap-3"><a class="inline-flex h-10 items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white" href="/company/jobs/edit">Edit Job</a><a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#9fc0f5] text-sm font-bold text-[#075fe4]" href="/company/jobs/preview">Preview</a><a class="inline-flex h-10 items-center justify-center rounded-lg border border-[#dce7f8] text-sm font-bold text-[#24344f]" href="/company/applications">View Applications</a></div></aside>
</section>
@endsection
