@extends('layouts.company')

@section('title', 'Hired Candidates - OnlyFreshers')
@section('pageTitle', 'Hired Candidates')
@section('pageSubtitle', 'View and manage all candidates you have hired.')

@php $activePage = 'hired'; @endphp

@push('styles')
<style>
    @media (max-width: 640px) {
        .company-hired-page {
            padding: 14px !important;
        }

        .company-hired-filters {
            gap: 10px !important;
            margin-bottom: 14px !important;
        }

        .company-hired-filters select,
        .company-hired-filters input,
        .company-hired-filters button {
            width: 100%;
        }

        .company-hired-table-wrap {
            overflow: visible !important;
            border: 0 !important;
        }

        .company-hired-table-wrap table,
        .company-hired-table-wrap thead,
        .company-hired-table-wrap tbody,
        .company-hired-table-wrap tr,
        .company-hired-table-wrap td {
            display: block;
            width: 100%;
        }

        .company-hired-table-wrap table {
            min-width: 0 !important;
        }

        .company-hired-table-wrap thead {
            display: none;
        }

        .company-hired-table-wrap tbody {
            display: grid;
            gap: 12px;
        }

        .company-hired-table-wrap tr {
            overflow: hidden;
            border: 1px solid #dce7f8 !important;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 10px 22px rgba(6, 25, 66, .05);
        }

        .company-hired-table-wrap td {
            display: grid;
            grid-template-columns: minmax(82px, 32%) minmax(0, 1fr);
            gap: 10px;
            align-items: start;
            border-bottom: 1px solid #edf2fb;
            padding: 10px 12px !important;
            font-size: 12px !important;
            line-height: 1.4;
            word-break: break-word;
        }

        .company-hired-table-wrap td:last-child {
            border-bottom: 0;
        }

        .company-hired-table-wrap td::before {
            content: attr(data-label);
            color: #52607a;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .company-hired-table-wrap td:first-child {
            display: block;
            padding: 12px !important;
        }

        .company-hired-table-wrap td:first-child::before,
        .company-hired-table-wrap td[colspan]::before {
            display: none;
        }

        .company-hired-table-wrap td[colspan] {
            display: block;
            text-align: center;
        }

        .company-hired-action {
            display: inline-flex;
            min-height: 34px;
            width: 100%;
            align-items: center;
            justify-content: center;
            border: 1px solid #075fe4;
            border-radius: 8px;
            color: #075fe4 !important;
            font-size: 0 !important;
            font-weight: 700;
        }

        .company-hired-action::after {
            content: 'View';
            font-size: 13px;
        }
    }
</style>
@endpush

@section('content')
    <section class="company-hired-page rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:p-[26px]">
        <div class="company-hired-filters mb-[26px] grid grid-cols-1 gap-[18px] lg:grid-cols-[minmax(0,1fr)_220px_120px]">
            <input id="searchInput" type="search" placeholder="Search by name, email, job or skills..." class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">

            <select id="jobFilter" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white px-4 text-[13px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="all">All Jobs</option>
            </select>

            <button id="resetFilters" type="button" class="h-[42px] rounded-lg border border-[#dce7f8] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Reset
            </button>
        </div>

        <div class="company-hired-table-wrap overflow-x-auto rounded-lg border border-[#dce7f8]">
            <table class="min-w-[900px] w-full border-collapse">
                <thead>
                    <tr class="border-b border-[#dce7f8]">
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Candidate</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Job Role</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Qualification</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Hired Date</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Hiring Mode</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Status</th>
                        <th class="h-[52px] px-4 text-left text-xs font-bold text-[#24344f]">Action</th>
                    </tr>
                </thead>
                <tbody id="hiredBody">
                    <tr><td colspan="7" class="px-5 py-8 text-center text-sm font-bold text-[#52607a]">Loading hired candidates...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="mt-[18px] flex flex-col gap-4 text-[13px] text-[#24344f] sm:flex-row sm:items-center sm:justify-between">
            <span id="resultText">Loading hired candidates...</span>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const searchInput = document.getElementById('searchInput');
    const jobFilter = document.getElementById('jobFilter');
    const hiredBody = document.getElementById('hiredBody');
    const resultText = document.getElementById('resultText');
    let hires = [];

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;'
    }[char]));
    const initials = (name) => String(name || 'C').split(' ').map((part) => part.charAt(0)).join('').slice(0, 2).toUpperCase();
    const formatDate = (value) => value ? new Date(value).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    const formatStatus = (status) => String(status || '').replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());

    async function guardCompanyFlow() {
        if (!token) {
            window.location.href = '/company/login';
            return false;
        }
        const response = await fetch('/api/company/profile', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            window.location.href = '/company/login';
            return false;
        }
        const result = await response.json();
        const profile = result.data?.profile;
        if (!profile) {
            window.location.href = '/company/profile/edit';
            return false;
        }
        localStorage.setItem('ofc_company_profile', JSON.stringify(profile));
        document.dispatchEvent(new CustomEvent('company-profile-loaded', { detail: profile }));
        if (profile.approval_status === 'pending') {
            window.location.href = '/company/approval/pending';
            return false;
        }
        if (profile.approval_status === 'rejected') {
            window.location.href = '/company/approval/rejected';
            return false;
        }
        return true;
    }

    function populateJobs() {
        const jobs = [...new Map(hires.map((app) => [app.job?.id, app.job]).filter(([id]) => id)).values()];
        jobFilter.innerHTML = '<option value="all">All Jobs</option>' + jobs.map((job) => `<option value="${job.id}">${escapeHtml(job.title)}</option>`).join('');
    }

    function renderHires() {
        const search = searchInput.value.trim().toLowerCase();
        const selectedJob = jobFilter.value;
        const filtered = hires.filter((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            const haystack = [user.name, user.email, job.title, profile.skills, profile.qualification, profile.city].join(' ').toLowerCase();
            return (selectedJob === 'all' || String(job.id) === selectedJob) && haystack.includes(search);
        });

        if (!filtered.length) {
            hiredBody.innerHTML = '<tr><td colspan="7" class="px-5 py-8 text-center text-sm text-[#52607a]">No hired candidates found.</td></tr>';
            resultText.textContent = `Showing 0 of ${hires.length} hired candidates`;
            return;
        }

        hiredBody.innerHTML = filtered.map((app) => {
            const user = app.fresher_profile?.user || {};
            const profile = app.fresher_profile || {};
            const job = app.job || {};
            return `
                <tr class="border-b border-[#edf2fb] last:border-b-0">
                    <td class="px-4 py-[18px] align-middle text-[13px]" data-label="Candidate">
                        <div class="flex items-center gap-3">
                            <div class="flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-full bg-[#eaf2ff] text-xs font-bold text-[#075fe4]">${escapeHtml(initials(user.name))}</div>
                            <div class="min-w-0">
                                <h3 class="mb-1.5 break-words text-[13px] font-bold text-[#061942]">${escapeHtml(user.name || 'Candidate')}</h3>
                                <p class="break-all text-xs text-[#52607a]">${escapeHtml(user.email || '-')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-[18px] align-middle text-[13px] text-[#061942]" data-label="Job Role">${escapeHtml(job.title || '-')}</td>
                    <td class="px-4 py-[18px] align-middle text-[13px] text-[#24344f]" data-label="Qualification">${escapeHtml(profile.qualification || '-')}</td>
                    <td class="px-4 py-[18px] align-middle text-[13px] text-[#24344f]" data-label="Hired Date">${formatDate(app.updated_at || app.applied_at)}</td>
                    <td class="px-4 py-[18px] align-middle text-[13px] text-[#061942]" data-label="Hiring Mode">${escapeHtml(formatStatus(job.hiring_mode))}</td>
                    <td class="px-4 py-[18px] align-middle text-[13px]" data-label="Status"><span class="inline-flex h-[30px] min-w-[62px] items-center justify-center rounded-lg bg-[#dbf8e9] px-3 text-xs font-bold text-[#00a65a]">Hired</span></td>
                    <td class="px-4 py-[18px] align-middle text-[13px]" data-label="Action"><a href="/company/applications/show" data-application-id="${app.id}" class="hired-link company-hired-action text-[22px] leading-none text-[#061942]" aria-label="View candidate details">&#8942;</a></td>
                </tr>
            `;
        }).join('');

        document.querySelectorAll('.hired-link').forEach((link) => {
            link.addEventListener('click', () => {
                localStorage.setItem('ofc_selected_company_application_id', link.dataset.applicationId);
            });
        });
        resultText.textContent = `Showing ${filtered.length} of ${hires.length} hired candidates`;
    }

    async function loadHires() {
        const canContinue = await guardCompanyFlow();
        if (!canContinue) return;
        const response = await fetch('/api/company/applications', {
            headers: { Accept: 'application/json', Authorization: `Bearer ${token}` },
        });
        const result = await response.json();
        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Unable to load hired candidates.');
        }
        hires = (result.data.applications || []).filter((app) => app.application_status === 'hired');
        populateJobs();
        renderHires();
    }

    searchInput.addEventListener('input', renderHires);
    jobFilter.addEventListener('change', renderHires);
    document.getElementById('resetFilters').addEventListener('click', () => {
        searchInput.value = '';
        jobFilter.value = 'all';
        renderHires();
    });

    loadHires().catch((error) => {
        hiredBody.innerHTML = `<tr><td colspan="7" class="px-5 py-8 text-center text-sm text-[#ff3045]">${escapeHtml(error.message || 'Unable to load hired candidates.')}</td></tr>`;
        resultText.textContent = 'Unable to load hired candidates.';
    });
</script>
@endpush
