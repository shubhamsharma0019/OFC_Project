@extends('layouts.public')

@section('title', 'Training Partners - OnlyFreshers')

@php
    $activePage = 'training-partners';
@endphp

@section('content')
    <main class="bg-[linear-gradient(120deg,#ffffff,#f8fbff)] py-12 lg:pb-[60px]">
        <div class="mx-auto w-full max-w-7xl px-5 sm:px-6 lg:px-8">
            <div id="partnerListing">
                <h1 class="m-0 text-[32px] font-semibold leading-tight text-[#061942] sm:text-[42px]">Our Trusted <span class="text-[#075fe4]">Training Partners</span></h1>
                <p class="mb-6 mt-2.5 max-w-3xl text-base font-medium text-[#34445e]">Explore verified and industry-aligned training partners who help freshers build job-ready skills.</p>

                <div class="mb-6 grid gap-3.5 rounded-lg border border-[#dce7f8] bg-white p-4 shadow-[0_10px_24px_rgba(6,25,66,0.04)] lg:grid-cols-[1.3fr_1fr_1fr_160px] lg:gap-6">
                    <input id="partnerSearch" class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none placeholder:text-[#74839d] focus:border-[#075fe4]" type="text" placeholder="Search by partner or course">
                    <select id="courseFilter" class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4]"><option value="">All Categories</option></select>
                    <select id="locationFilter" class="h-[46px] rounded-lg border border-[#dce7f8] bg-white px-4 text-sm font-medium text-[#52607a] outline-none focus:border-[#075fe4]"><option value="">All Locations</option></select>
                    <button id="partnerSearchButton" class="h-[46px] rounded-lg border border-[#075fe4] bg-[#075fe4] px-6 text-sm font-bold text-white transition hover:bg-[#003f9e]" type="button">Search</button>
                </div>

                <div class="mb-4 flex items-center justify-between text-sm font-bold text-[#061942]">
                    <span id="partnerCount">Loading partners...</span>
                    <button id="clearPartnerFilters" class="text-[#075fe4]" type="button">Clear Filters</button>
                </div>

                <div id="partnerGrid" class="grid gap-[22px] lg:grid-cols-3">
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
            return `<article class="rounded-lg border border-[#dce7f8] bg-white px-6 pb-[22px] pt-7 shadow-[0_12px_26px_rgba(6,25,66,0.04)]">
                <div class="mb-[18px] flex flex-col gap-[18px] sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-center gap-[13px]">
                        <div class="flex h-[58px] w-[58px] shrink-0 items-center justify-center rounded-[10px] text-xl font-extrabold ${iconClass}">${esc(initials(partner.institute_name))}</div>
                        <h2 class="m-0 text-[22px] font-semibold leading-tight text-[#061942]">${esc(partner.institute_name || 'Training Partner')}<small class="mt-1 block text-[11px] font-medium uppercase tracking-[2px] text-[#24344f]">${esc((partner.user && partner.user.name) || 'Approved Partner')}</small></h2>
                    </div>
                    <div class="text-sm font-medium text-[#34445e] sm:text-right">
                        <div class="font-bold text-[#061942]">${esc(partner.active_courses_count || courses.length)} Courses</div>
                        <div class="mt-2">${esc(partner.location || 'India')}</div>
                    </div>
                </div>
                <div class="mb-4 flex flex-wrap gap-2">${tags.length ? tags.map((tag) => `<span class="rounded-md border border-[#a9c5f6] bg-[#f8fbff] px-3 py-1.5 text-xs font-bold text-[#075fe4]">${esc(tag)}</span>`).join('') : '<span class="rounded-md border border-[#a9c5f6] bg-[#f8fbff] px-3 py-1.5 text-xs font-bold text-[#075fe4]">Fast Track</span>'}</div>
                <p class="mb-[18px] line-clamp-3 text-sm font-medium leading-[1.7] text-[#34445e]">${esc(partner.about_institute || 'Verified training partner offering industry-ready courses for freshers.')}</p>
                <button class="view-partner mx-auto block h-10 w-[170px] rounded-lg border border-[#a9c5f6] bg-white px-5 text-sm font-bold text-[#075fe4] transition hover:bg-[#075fe4] hover:text-white" type="button" data-id="${esc(partner.id)}">View Details</button>
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
            setOptions();
            renderPartners();
            if (initialPartnerId) showPartnerDetail(initialPartnerId);
        }).catch((error) => {
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
