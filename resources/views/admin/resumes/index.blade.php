@extends('layouts.admin')

@section('title', 'Resume Assignments - OnlyFreshers Admin')
@section('pageTitle', 'Resumes')
@section('breadcrumb', 'Dashboard > Resumes')

@php
    $activePage = 'resumes';
@endphp

@section('content')
    <section class="grid gap-5">
        <div id="resumeStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm font-bold text-[#52607a]">Loading resume overview...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="flex flex-col gap-3 border-b border-[#edf2fb] p-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row">
                    <input id="resumeSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none sm:w-[340px]" type="search" placeholder="Search company or candidate...">
                    <select id="intentFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]">
                        <option value="">All Companies</option>
                        <option value="resume_only">Resume Only</option>
                        <option value="job_posting">Job Posting</option>
                    </select>
                </div>
                <button id="createDummyBtn" class="h-10 rounded-md bg-[#075fe4] px-4 text-sm font-bold text-white" type="button">Create Dummy Resumes</button>
            </div>

            <div id="resumeOverviewRows" class="grid gap-4 p-4">
                <article class="rounded-lg border border-[#edf2fb] bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]">Loading companies...</article>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (() => {
        const token = localStorage.getItem('ofc_auth_token');
        const resumeStats = document.getElementById('resumeStats');
        const rowsBox = document.getElementById('resumeOverviewRows');
        const searchInput = document.getElementById('resumeSearch');
        const intentFilter = document.getElementById('intentFilter');
        const createDummyBtn = document.getElementById('createDummyBtn');
        let companies = [];
        let availableResumeCount = 0;
        let costPerResume = 50;

        if (!token) window.location.href = '/admin/login';

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]);
        const number = (value) => Number(value || 0).toLocaleString('en-IN');
        const statusText = (value) => String(value || '-').replaceAll('_', ' ');
        const badgeClass = (status) => {
            if (status === 'approved' || status === 'active') return 'bg-[#e8f8ef] text-[#078346]';
            if (status === 'rejected' || status === 'blocked') return 'bg-[#fff0f1] text-[#ff1f2f]';
            return 'bg-[#fff4df] text-[#b86500]';
        };

        async function requestJson(url, options = {}) {
            const response = await fetch(url, {
                ...options,
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    Authorization: 'Bearer ' + token,
                    ...(options.headers || {}),
                },
            });
            if (response.status === 401) {
                window.location.href = '/admin/login';
                return null;
            }
            const payload = await response.json();
            if (!response.ok || payload.success === false) throw new Error(payload.message || 'Request failed.');
            return payload;
        }

        function statCard(label, value, tone) {
            return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone}"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 3h8l4 4v14H7z"></path><path d="M15 3v5h5"></path><path d="M10 12h6"></path><path d="M10 16h6"></path></svg></span><p class="mt-4 text-xs font-bold text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl font-bold text-[#061942]">${escapeHtml(value)}</h2></article>`;
        }

        function filteredCompanies() {
            const query = searchInput.value.trim().toLowerCase();
            const intent = intentFilter.value;

            return companies.filter((company) => {
                const resumeText = (company.resumes || []).map((resume) => [resume.name, resume.email, resume.preferred_job_category, resume.skills].join(' ')).join(' ');
                const text = [company.company_name, company.email, company.phone, company.industry, company.approval_status, company.hiring_intent, resumeText].join(' ').toLowerCase();
                return (!intent || company.hiring_intent === intent) && (!query || text.includes(query));
            });
        }

        function renderStats() {
            const assignedCount = companies.reduce((total, company) => total + (company.resumes || []).length, 0);
            const resumeOnlyCount = companies.filter((company) => company.hiring_intent === 'resume_only').length;
            const lowCreditCount = companies.filter((company) => company.hiring_intent === 'resume_only' && Number(company.job_credits || 0) < costPerResume).length;

            resumeStats.innerHTML = [
                statCard('Resume Pool', number(availableResumeCount), 'bg-[#eaf2ff] text-[#075fe4]'),
                statCard('Assigned Resumes', number(assignedCount), 'bg-[#e8f8ef] text-[#078346]'),
                statCard('Resume Companies', number(resumeOnlyCount), 'bg-[#fff4df] text-[#b86500]'),
                statCard('Low Credits', number(lowCreditCount), 'bg-[#fff0f1] text-[#ff1f2f]'),
            ].join('');
        }

        function resumeCard(resume) {
            return `<div class="rounded-lg border border-[#edf2fb] bg-[#f8fbff] p-4"><strong class="block text-sm text-[#061942]">${escapeHtml(resume.name)}</strong><p class="mt-1 text-xs font-semibold text-[#52607a]">${escapeHtml(resume.email || '-')}</p><div class="mt-3 grid gap-1 text-xs text-[#34445e]"><span>${escapeHtml(resume.preferred_job_category || 'Candidate')}</span><span>${escapeHtml([resume.qualification, resume.city].filter(Boolean).join(' - ') || '-')}</span><span>${escapeHtml(resume.skills || '-')}</span><span class="font-bold text-[#075fe4]">${escapeHtml(resume.resume_file || 'Resume uploaded')}</span></div></div>`;
        }

        function renderRows() {
            renderStats();
            const rows = filteredCompanies();

            if (!rows.length) {
                rowsBox.innerHTML = '<article class="rounded-lg border border-[#edf2fb] bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]">No companies found.</article>';
                return;
            }

            rowsBox.innerHTML = rows.map((company) => {
                const resumes = company.resumes || [];
                const canOpen = Number(company.job_credits || 0) >= costPerResume;

                return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_22px_rgba(6,25,66,.04)]">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-lg font-bold text-[#061942]">${escapeHtml(company.company_name || 'Company')}</h2>
                                <span class="rounded-md ${badgeClass(company.approval_status)} px-2.5 py-1 text-xs font-bold capitalize">${escapeHtml(statusText(company.approval_status))}</span>
                                <span class="rounded-md bg-[#eaf2ff] px-2.5 py-1 text-xs font-bold capitalize text-[#075fe4]">${escapeHtml(statusText(company.hiring_intent))}</span>
                            </div>
                            <p class="mt-1 text-sm font-semibold text-[#52607a]">${escapeHtml(company.email || '-')} ${company.phone ? ' | ' + escapeHtml(company.phone) : ''}</p>
                            <p class="mt-1 text-xs font-semibold text-[#52607a]">${escapeHtml(company.industry || '-')}</p>
                        </div>
                        <div class="grid gap-2 sm:grid-cols-3 xl:w-[440px]">
                            <div class="rounded-lg border border-[#edf2fb] p-3"><p class="text-xs font-bold text-[#52607a]">Credits</p><strong class="mt-1 block text-xl text-[#061942]">${number(company.job_credits)}</strong></div>
                            <div class="rounded-lg border border-[#edf2fb] p-3"><p class="text-xs font-bold text-[#52607a]">Used</p><strong class="mt-1 block text-xl text-[#061942]">${number(company.credits_used)}</strong></div>
                            <div class="rounded-lg border border-[#edf2fb] p-3"><p class="text-xs font-bold text-[#52607a]">Assigned</p><strong class="mt-1 block text-xl text-[#061942]">${number(resumes.length)}</strong></div>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <button class="view-company rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-id="${company.id}">Company Details</button>
                        <button class="approve-company rounded-md border border-[#078346] px-3 py-2 text-xs font-bold text-[#078346]" type="button" data-id="${company.id}">Approve + Assign</button>
                        <button class="assign-all rounded-md bg-[#075fe4] px-3 py-2 text-xs font-bold text-white" type="button" data-id="${company.id}">Assign All Resumes</button>
                    </div>
                    <div class="mt-4 rounded-lg border ${canOpen ? 'border-[#dce7f8] bg-white' : 'border-[#ffd1d7] bg-[#fff7f8]'} p-3 text-xs font-bold ${canOpen ? 'text-[#52607a]' : 'text-[#ff3045]'}">
                        ${canOpen ? `Company can open ${Math.floor(Number(company.job_credits || 0) / costPerResume)} resume(s) right now.` : 'Credits over. Company should buy Resume Access plan from billing.'}
                    </div>
                    <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                        ${resumes.length ? resumes.map(resumeCard).join('') : '<div class="rounded-lg border border-[#edf2fb] p-4 text-sm font-semibold text-[#52607a]">No resumes assigned yet.</div>'}
                    </div>
                </article>`;
            }).join('');
        }

        async function loadOverview() {
            try {
                const payload = await requestJson('/api/admin/companies/resume-overview');
                if (!payload) return;
                companies = payload.data?.companies || [];
                availableResumeCount = payload.data?.available_resume_count || 0;
                costPerResume = payload.data?.cost_per_resume || 50;
                renderRows();
            } catch (error) {
                rowsBox.innerHTML = `<article class="rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm font-bold text-[#ff3045]">${escapeHtml(error.message || 'Resume overview could not be loaded.')}</article>`;
            }
        }

        async function handleAction(event) {
            const view = event.target.closest('.view-company');
            const approve = event.target.closest('.approve-company');
            const assignAll = event.target.closest('.assign-all');
            const id = view?.dataset.id || approve?.dataset.id || assignAll?.dataset.id;
            if (!id) return;

            if (view) {
                localStorage.setItem('ofc_selected_admin_company_id', id);
                window.location.href = '/admin/companies/show';
                return;
            }

            event.target.disabled = true;

            try {
                if (approve) await requestJson(`/api/admin/companies/${id}/approve`, { method: 'POST' });
                if (assignAll) await requestJson(`/api/admin/companies/${id}/resumes/assign-all`, { method: 'POST' });
                await loadOverview();
            } catch (error) {
                alert(error.message || 'Action failed.');
                event.target.disabled = false;
            }
        }

        createDummyBtn.addEventListener('click', async () => {
            createDummyBtn.disabled = true;
            createDummyBtn.textContent = 'Creating...';

            try {
                await requestJson('/api/admin/companies/dummy-resumes', { method: 'POST', body: JSON.stringify({ count: 100 }) });
                await loadOverview();
            } catch (error) {
                alert(error.message || 'Dummy resumes could not be created.');
            } finally {
                createDummyBtn.disabled = false;
                createDummyBtn.textContent = 'Create Dummy Resumes';
            }
        });

        searchInput.addEventListener('input', renderRows);
        intentFilter.addEventListener('change', renderRows);
        rowsBox.addEventListener('click', handleAction);
        loadOverview();
    })();
</script>
@endpush
