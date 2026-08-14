@extends('layouts.public')

@section('title', 'Training Partners - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@push('styles')
<style>
    .partner-filter-panel {
        border: 1px solid #cfe0ff;
        border-radius: 18px;
        background: linear-gradient(145deg, #ffffff, #f3f8ff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .08);
    }
    .partner-card {
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-height: 292px;
        border: 1px solid #cfe0ff;
        border-radius: 20px;
        background: linear-gradient(145deg, #ffffff, #f7fbff);
        box-shadow: 0 18px 38px rgba(7, 95, 228, .09);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .partner-card:hover {
        transform: translateY(-6px);
        border-color: #9fc0f8;
        box-shadow: 0 26px 52px rgba(7, 95, 228, .15);
    }
    .partner-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #075fe4, #17a6a8);
    }
    .partner-card:after {
        content: "";
        position: absolute;
        right: -52px;
        top: -58px;
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background: rgba(220, 236, 255, .86);
        filter: blur(22px);
        pointer-events: none;
    }
    .partner-badge {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        font-size: 23px;
        font-weight: 900;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .75), 0 12px 24px rgba(7, 95, 228, .08);
    }
    .partner-chip {
        border: 1px solid #cfe0ff;
        border-radius: 999px;
        background: #fff;
        padding: 7px 12px;
        color: #075fe4;
        font-size: 12px;
        font-weight: 800;
    }
    .partner-meta {
        border: 1px solid #dce7f8;
        border-radius: 14px;
        background: rgba(255, 255, 255, .78);
        padding: 12px 14px;
        color: #34445e;
        font-size: 13px;
        font-weight: 700;
        text-align: right;
    }
    .partner-card-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .partner-card-button {
        display: inline-flex;
        width: 100%;
        height: 44px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 12px;
        background: #075fe4;
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(7, 95, 228, .18);
        transition: background .2s ease;
    }
    .partner-card-button:hover { background: #0554cc; }
</style>
@endpush

@section('content')
    <main class="bg-white">
        <section class="relative overflow-hidden bg-[linear-gradient(120deg,#ffffff,#f4f8ff)] py-10 lg:py-[55px]">
            <div class="pointer-events-none absolute -left-24 top-1/2 hidden h-[300px] w-[430px] -translate-y-1/2 rounded-full bg-[#dcecff]/65 blur-3xl lg:block"></div>
            <div class="pointer-events-none absolute left-0 top-0 hidden h-full w-[46%] bg-[radial-gradient(circle_at_14%_28%,rgba(207,228,255,0.48)_0%,rgba(244,249,255,0.42)_34%,rgba(255,255,255,0)_72%)] lg:block"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-[54%] bg-[radial-gradient(circle_at_80%_28%,rgba(207,228,255,0.56)_0%,rgba(244,248,255,0.48)_38%,rgba(255,255,255,0)_76%)] lg:block"></div>
            <div class="relative mx-auto grid w-full max-w-7xl items-center gap-10 px-5 sm:px-6 lg:grid-cols-[0.95fr_1.05fr] lg:gap-[52px] lg:px-8">
                <div>
                    <h1 class="m-0 text-[38px] font-semibold leading-tight text-[#061942] sm:text-[52px]">Our Trusted <span class="text-[#075fe4]">Training Partners</span></h1>
                    <p class="mt-4 max-w-2xl text-lg font-medium leading-[1.7] text-[#34445e]">Explore verified and industry-aligned training partners who help freshers build practical, job-ready skills.</p>
                    <div class="mt-7 grid max-w-[620px] grid-cols-3 gap-3">
                        <div class="rounded-xl border border-[#cfe0ff] bg-white/72 p-4 shadow-[0_14px_30px_rgba(7,95,228,0.09)]">
                            <strong id="partnerHeroCount" class="block font-['Inter'] text-3xl font-semibold text-[#061942]">...</strong>
                            <span class="text-xs font-semibold text-[#34445e]">Partners</span>
                        </div>
                        <div class="rounded-xl border border-[#cfe0ff] bg-white/72 p-4 shadow-[0_14px_30px_rgba(7,95,228,0.09)]">
                            <strong class="block font-['Inter'] text-3xl font-semibold text-[#061942]">100%</strong>
                            <span class="text-xs font-semibold text-[#34445e]">Verified</span>
                        </div>
                        <div class="rounded-xl border border-[#cfe0ff] bg-white/72 p-4 shadow-[0_14px_30px_rgba(7,95,228,0.09)]">
                            <strong class="block font-['Inter'] text-3xl font-semibold text-[#061942]">Job</strong>
                            <span class="text-xs font-semibold text-[#34445e]">Ready Skills</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="{{ asset('training-partner-hero.png') }}" alt="Training partner mentoring freshers" class="block h-[280px] w-full rounded-2xl object-cover object-center shadow-[0_22px_48px_rgba(6,25,66,0.12)] sm:h-[340px] lg:h-[380px]">
                </div>
            </div>
        </section>

        <div class="mx-auto w-full max-w-7xl px-5 py-10 sm:px-6 lg:px-8 lg:pb-[60px]">
            <div id="partnerListing">
                <div class="partner-filter-panel mb-6 grid gap-4 p-5 lg:grid-cols-[1.35fr_1fr_1fr_170px]">
                    <input id="partnerSearch" class="h-12 rounded-xl border border-[#cfe0ff] bg-white px-4 text-sm font-semibold text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4] focus:shadow-[0_0_0_3px_rgba(7,95,228,0.08)]" type="text" placeholder="Search by partner or course">
                    <select id="courseFilter" class="h-12 rounded-xl border border-[#cfe0ff] bg-white px-4 text-sm font-semibold text-[#52607a] outline-none focus:border-[#075fe4] focus:shadow-[0_0_0_3px_rgba(7,95,228,0.08)]"><option value="">All Categories</option></select>
                    <select id="locationFilter" class="h-12 rounded-xl border border-[#cfe0ff] bg-white px-4 text-sm font-semibold text-[#52607a] outline-none focus:border-[#075fe4] focus:shadow-[0_0_0_3px_rgba(7,95,228,0.08)]"><option value="">All Locations</option></select>
                    <button id="partnerSearchButton" class="h-12 rounded-xl border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white shadow-[0_10px_22px_rgba(7,95,228,0.18)] transition hover:-translate-y-0.5 hover:bg-[#003f9e]" type="button">Search</button>
                </div>

                <div class="mb-5 flex items-center justify-between rounded-xl border border-[#e5eefc] bg-white px-4 py-3 text-sm font-bold text-[#061942] shadow-[0_10px_22px_rgba(6,25,66,0.035)]">
                    <span id="partnerCount">Loading partners...</span>
                    <button id="clearPartnerFilters" class="text-[#075fe4]" type="button">Clear Filters</button>
                </div>

                <div id="partnerGrid" class="grid gap-7 md:grid-cols-2 xl:grid-cols-3">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">Loading training partners...</article>
                </div>
            </div>

            <div id="partnerDetail" class="hidden">
                <button class="mb-[22px] inline-flex h-10 items-center justify-center rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" onclick="showPartnerListing()">Back to Partners</button>
                <div id="partnerDetailContent" class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,0.04)]">Loading partner details...</div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    const partnerListing = document.getElementById('partnerListing');
    const partnerDetail = document.getElementById('partnerDetail');
    const partnerGrid = document.getElementById('partnerGrid');
    const partnerDetailContent = document.getElementById('partnerDetailContent');
    const partnerCount = document.getElementById('partnerCount');
    const partnerHeroCount = document.getElementById('partnerHeroCount');
    const partnerSearch = document.getElementById('partnerSearch');
    const courseFilter = document.getElementById('courseFilter');
    const locationFilter = document.getElementById('locationFilter');
    const initialPartnerId = new URLSearchParams(window.location.search).get('partner');
    let partners = [];

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

    function coursesOf(partner) {
        return partner.courses || [];
    }

    function partnerText(partner) {
        return [
            partner.institute_name,
            partner.location,
            partner.about_institute,
            coursesOf(partner).map((course) => [course.course_name, course.category, course.skills_covered].join(' ')).join(' '),
        ].join(' ').toLowerCase();
    }

    function setOptions() {
        const categories = [...new Set(partners.flatMap((partner) => coursesOf(partner).map((course) => course.category)).filter(Boolean))].sort();
        const locations = [...new Set(partners.map((partner) => partner.location).filter(Boolean))].sort();
        courseFilter.innerHTML = '<option value="">All Categories</option>' + categories.map((item) => `<option value="${esc(item)}">${esc(item)}</option>`).join('');
        locationFilter.innerHTML = '<option value="">All Locations</option>' + locations.map((item) => `<option value="${esc(item)}">${esc(item)}</option>`).join('');
    }

    function filteredPartners() {
        const query = partnerSearch.value.trim().toLowerCase();
        const category = courseFilter.value;
        const location = locationFilter.value;
        return partners.filter((partner) => {
            const queryOk = !query || partnerText(partner).includes(query);
            const categoryOk = !category || coursesOf(partner).some((course) => course.category === category);
            const locationOk = !location || partner.location === location;
            return queryOk && categoryOk && locationOk;
        });
    }

    function renderPartners() {
        const rows = filteredPartners();
        partnerCount.textContent = rows.length + ' Training Partners Found';
        if (!rows.length) {
            partnerGrid.innerHTML = '<article class="rounded-lg border border-[#dce7f8] bg-white p-6 text-sm font-semibold text-[#34445e] shadow-[0_12px_26px_rgba(6,25,66,0.04)] lg:col-span-3">No approved training partners found.</article>';
            return;
        }
        partnerGrid.innerHTML = rows.map((partner, index) => {
            const courses = coursesOf(partner);
            const tags = courses.flatMap((course) => [course.course_name, course.category]).filter(Boolean).slice(0, 4);
            const iconClass = ['bg-[#eff5ff] text-[#075fe4]', 'bg-[#eafaf8] text-[#17a078]', 'bg-[#f1efff] text-[#5142b9]', 'bg-[#fff0e2] text-[#f37a22]'][index % 4];
            return `<article class="partner-card px-5 pb-5 pt-6">
                <div class="relative z-10 mb-5 grid grid-cols-[minmax(0,1fr)_96px] gap-4">
                    <div class="flex min-w-0 items-start gap-4">
                        <div class="partner-badge shrink-0 ${iconClass}">${esc(initials(partner.institute_name))}</div>
                        <h2 class="partner-card-title m-0 min-w-0 font-['Inter'] text-[22px] font-semibold leading-tight text-[#061942]">${esc(partner.institute_name || 'Training Partner')}<small class="mt-1.5 block text-[11px] font-semibold uppercase tracking-[2px] text-[#075fe4]">${esc((partner.user && partner.user.name) || 'Approved Partner')}</small></h2>
                    </div>
                    <div class="partner-meta self-start">
                        <div class="font-bold text-[#061942]">${esc(partner.active_courses_count || courses.length)} Courses</div>
                        <div class="mt-1.5">${esc(partner.location || 'India')}</div>
                    </div>
                </div>
                <div class="relative z-10 mb-4 flex flex-wrap gap-2">${tags.length ? tags.map((tag) => `<span class="partner-chip">${esc(tag)}</span>`).join('') : '<span class="partner-chip">Fast Track</span>'}</div>
                <p class="relative z-10 mb-5 line-clamp-3 text-sm font-semibold leading-[1.75] text-[#34445e]">${esc(partner.about_institute || 'Verified training partner offering industry-ready courses for freshers.')}</p>
                <button class="view-partner partner-card-button relative z-10 mt-auto" type="button" data-id="${esc(partner.id)}">View Details</button>
            </article>`;
        }).join('');
    }

    function renderDetail(partner) {
        const courses = coursesOf(partner);
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
                ${statRow('Location', partner.location || '-')}
                ${statRow('Phone', partner.phone || partner.user?.mobile || '-')}
                ${statRow('Email', partner.email || partner.user?.email || '-')}
            </div>
        </div>
        <div class="grid gap-[22px] lg:grid-cols-[1.3fr_1fr]">
            <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Popular Courses</h2>
                <div class="grid gap-3 md:grid-cols-3">
                    ${courses.length ? courses.slice(0, 6).map(courseCard).join('') : '<p class="text-sm font-medium text-[#34445e]">No active courses found.</p>'}
                </div>
                <a href="/courses" class="mx-auto mt-[18px] flex h-10 w-[220px] items-center justify-center rounded-lg border border-[#a9c5f6] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white">Explore All Courses</a>
            </div>
            <div class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <h2 class="mb-[18px] text-xl font-semibold text-[#061942]">Why Learn Here?</h2>
                ${whyItem('TR', 'Industry-relevant Training', 'Curriculum aligned with active courses and practical skills.')}
                ${whyItem('EX', 'Verified Partner', 'Only approved training partners are visible publicly.')}
                ${whyItem('CT', 'Certificate Path', 'Complete training and final assessment to earn certificates.')}
            </div>
        </div>`;
    }

    function statRow(label, value) {
        return `<div class="flex justify-between gap-5 border-b border-[#dce7f8] py-4 text-sm font-bold text-[#24344f] last:border-b-0"><span>${esc(label)}</span><span class="text-right text-lg font-extrabold text-[#061942]">${esc(value)}</span></div>`;
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

    async function showPartnerDetail(id) {
        partnerListing.classList.add('hidden');
        partnerDetail.classList.remove('hidden');
        partnerDetailContent.className = 'rounded-lg border border-[#dce7f8] bg-white p-6 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,0.04)]';
        partnerDetailContent.textContent = 'Loading partner details...';
        window.scrollTo(0, 0);
        try {
            const result = await getJson('/api/training-partners/' + id);
            renderDetail(dataOf(result, 'training_partner'));
            history.replaceState(null, '', '/training-partners/show?partner=' + id);
        } catch (error) {
            partnerDetailContent.className = 'rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm text-[#b42318]';
            partnerDetailContent.textContent = error.message || 'Partner details load nahi ho paaye.';
        }
    }

    function showPartnerListing() {
        partnerListing.classList.remove('hidden');
        partnerDetail.classList.add('hidden');
        history.replaceState(null, '', '/training-partners');
        window.scrollTo(0, 0);
    }
    window.showPartnerListing = showPartnerListing;

    function loadPartners() {
        getJson('/api/training-partners?per_page=100').then((result) => {
            const page = dataOf(result, 'training_partners') || {};
            partners = Array.isArray(page) ? page : (page.data || []);
            partnerHeroCount.textContent = partners.length;
            setOptions();
            renderPartners();
            if (initialPartnerId) showPartnerDetail(initialPartnerId);
        }).catch((error) => {
            partnerHeroCount.textContent = '0';
            partnerCount.textContent = '0 Training Partners Found';
            partnerGrid.innerHTML = `<article class="rounded-lg border border-[#ffd6a8] bg-[#fff8ef] p-6 text-sm font-semibold text-[#8a5200] lg:col-span-3">${esc(error.message || 'Partners load nahi ho paaye.')}</article>`;
        });
    }

    document.getElementById('partnerSearchButton').addEventListener('click', renderPartners);
    document.getElementById('clearPartnerFilters').addEventListener('click', () => {
        partnerSearch.value = '';
        courseFilter.value = '';
        locationFilter.value = '';
        renderPartners();
    });
    [partnerSearch, courseFilter, locationFilter].forEach((input) => {
        input.addEventListener('input', renderPartners);
        input.addEventListener('change', renderPartners);
    });
    partnerGrid.addEventListener('click', (event) => {
        const button = event.target.closest('.view-partner');
        if (button) showPartnerDetail(button.dataset.id);
    });

    loadPartners();
</script>
@endpush
