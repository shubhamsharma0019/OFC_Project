@extends('layouts.public')

@section('title', 'Training Partner Details - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@section('content')
    <main class="bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-12 lg:pb-[60px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <a href="/training-partners" class="mb-[22px] inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Back to Partners</a>
            <div id="partnerDetailContent" class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,0.04)]">Loading partner details...</div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    const partnerDetailContent = document.getElementById('partnerDetailContent');
    const partnerId = new URLSearchParams(window.location.search).get('partner') || new URLSearchParams(window.location.search).get('id');

    function esc(value) {
        return String(value ?? '').replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char]);
    }

    function dataOf(result, key) {
        return result && result.data ? (key ? result.data[key] : result.data) : result;
    }

    function initials(value) {
        return String(value || 'TP').split(/\s+/).filter(Boolean).map((word) => word[0]).join('').slice(0, 2).toUpperCase() || 'TP';
    }

    async function getJson(url) {
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Request failed');
        return result;
    }

    function statRow(label, value) {
        return `<div class="flex justify-between gap-5 border-b border-[#dce7f8] py-4 text-sm font-bold text-[#24344f] last:border-b-0"><span>${esc(label)}</span><span class="text-right text-lg font-extrabold text-[#061942]">${esc(value || '-')}</span></div>`;
    }

    function courseCard(course) {
        return `<article class="rounded-lg border border-[#dce7f8] p-4">
            <div class="mb-3 flex h-[50px] w-[50px] items-center justify-center rounded-[10px] bg-[#eff5ff] font-extrabold text-[#075fe4]">${esc(initials(course.course_name))}</div>
            <h3 class="mb-2 text-base font-semibold text-[#061942]">${esc(course.course_name || 'Course')}</h3>
            <p class="line-clamp-3 text-sm font-medium leading-[1.7] text-[#34445e]">${esc(course.description || 'Industry-ready course.')}</p>
            <div class="mt-3.5 text-[13px] font-semibold leading-[1.8] text-[#24344f]">${esc(course.duration || 'Flexible')}<br>${esc(course.training_mode || 'Online')}</div>
            <a href="/courses/show?course=${esc(course.id)}" class="mt-3 inline-flex h-9 items-center justify-center rounded-md border border-[#a9c5f6] px-3 text-xs font-bold text-[#075fe4]">View Course</a>
        </article>`;
    }

    function whyItem(icon, title, text) {
        return `<div class="mb-5 flex gap-3.5 last:mb-0"><div class="flex h-[42px] w-[42px] shrink-0 items-center justify-center rounded-full bg-[#eff5ff] text-[13px] font-extrabold text-[#075fe4]">${icon}</div><div><h3 class="mb-2 text-base font-semibold text-[#061942]">${esc(title)}</h3><p class="text-sm font-medium leading-[1.7] text-[#34445e]">${esc(text)}</p></div></div>`;
    }

    function renderDetail(partner) {
        const courses = partner.courses || [];
        partnerDetailContent.className = '';
        partnerDetailContent.innerHTML = `<div class="mb-[22px] grid gap-8 rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:grid-cols-[minmax(0,1fr)_360px] lg:gap-[45px] lg:p-7">
            <div class="flex flex-col gap-6 sm:flex-row sm:gap-8">
                <div class="flex h-[135px] w-40 shrink-0 items-center justify-center rounded-lg border border-[#dce7f8] bg-[#f8fbff] text-[46px] font-extrabold text-[#075fe4]">${esc(initials(partner.institute_name))}</div>
                <div>
                    <h1 class="mb-3.5 text-[30px] font-semibold text-[#061942] sm:text-[34px]">${esc(partner.institute_name || 'Training Partner')}</h1>
                    <div class="mb-[18px] flex flex-wrap gap-[18px] text-[15px] font-bold text-[#075fe4]"><span>Approved Partner</span><span>${esc(partner.active_courses_count || courses.length)} Courses</span></div>
                    <div class="mb-5 text-base font-medium text-[#34445e]">${esc(partner.location || 'India')}</div>
                    <p class="mb-[22px] max-w-[560px] text-base font-medium leading-[1.8] text-[#24344f]">${esc(partner.about_institute || 'Verified training partner dedicated to helping freshers build practical skills.')}</p>
                    ${partner.website ? `<a href="${esc(partner.website)}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]">Visit Website</a>` : ''}
                </div>
            </div>
            <div class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-[18px]">
                ${statRow('Active Courses', partner.active_courses_count || courses.length)}
                ${statRow('Location', partner.location)}
                ${statRow('Phone', partner.phone || partner.user?.mobile)}
                ${statRow('Email', partner.email || partner.user?.email)}
            </div>
        </div>
        <div class="grid gap-[22px] lg:grid-cols-[1.3fr_1fr]">
            <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Popular Courses</h2>
                <div class="grid gap-3 md:grid-cols-3">${courses.length ? courses.slice(0, 6).map(courseCard).join('') : '<p class="text-sm font-medium text-[#34445e]">No active courses found.</p>'}</div>
            </div>
            <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Why Learn Here?</h2>
                ${whyItem('TR', 'Industry-relevant Training', 'Curriculum aligned with active courses and practical skills.')}
                ${whyItem('EX', 'Verified Partner', 'Only approved training partners are visible publicly.')}
                ${whyItem('CT', 'Certificate Path', 'Complete training and final assessment to earn certificates.')}
            </div>
        </div>`;
    }

    async function loadPartner() {
        if (!partnerId) {
            partnerDetailContent.textContent = 'Partner id missing.';
            return;
        }
        try {
            const result = await getJson('/api/training-partners/' + partnerId);
            renderDetail(dataOf(result, 'training_partner'));
        } catch (error) {
            partnerDetailContent.className = 'rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm text-[#b42318]';
            partnerDetailContent.textContent = error.message || 'Partner details load nahi ho paaye.';
        }
    }

    loadPartner();
</script>
@endpush
