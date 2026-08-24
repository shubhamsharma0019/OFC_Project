@extends('layouts.company')

@section('title', 'Edit Job - OnlyFreshers')
@section('pageTitle', 'Edit Job')
@section('pageSubtitle', 'Update the selected job posting.')

@php
    $activePage = 'jobs';
    $experienceLevels = ['0 - 1 Year', '1 - 3 Years', '3 - 5 Years', '5+ Years'];
    $employmentTypes = ['Full Time', 'Part Time', 'Internship', 'Contract'];
    $hiringModes = ['direct' => 'Direct Hiring', 'fast_track' => 'Fast Track'];
@endphp

@section('content')
<section class="rounded-lg border border-[#dce7f8] bg-white px-5 py-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:px-[30px] sm:py-7">
    <p id="jobMessage" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm font-bold"></p>

    <form id="editJobForm" class="grid grid-cols-1 gap-x-7 gap-y-6 md:grid-cols-2">
        <div>
            <label for="jobTitle" class="mb-2 block text-[13px] font-bold text-[#061942]">Opportunity Title <span class="text-[#ff3045]">*</span></label>
            <input id="jobTitle" name="title" required class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
        </div>

        <div>
            <label for="qualification" class="mb-2 block text-[13px] font-bold text-[#061942]">Qualification</label>
            <input id="qualification" name="qualification" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
        </div>

        <div>
            <label for="experience" class="mb-2 block text-[13px] font-bold text-[#061942]">Experience Level</label>
            <select id="experience" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($experienceLevels as $level)
                    <option value="{{ $level }}">{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="employmentType" class="mb-2 block text-[13px] font-bold text-[#061942]">Employment Type <span class="text-[#ff3045]">*</span></label>
            <select id="employmentType" name="job_type" required class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($employmentTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="hiringMode" class="mb-2 block text-[13px] font-bold text-[#061942]">Hiring Mode <span class="text-[#ff3045]">*</span></label>
            <select id="hiringMode" name="hiring_mode" required class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                @foreach ($hiringModes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" class="mb-2 block text-[13px] font-bold text-[#061942]">Status <span class="text-[#ff3045]">*</span></label>
            <select id="status" name="status" required class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                <option value="draft">Draft</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="location" class="mb-2 block text-[13px] font-bold text-[#061942]">Location <span class="text-[#ff3045]">*</span></label>
            <input id="location" name="location" required class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
        </div>

        <div>
            <label for="salary" class="mb-2 block text-[13px] font-bold text-[#061942]">Salary</label>
            <input id="salary" name="salary" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
        </div>

        <div>
            <label for="openings" class="mb-2 block text-[13px] font-bold text-[#061942]">Openings <span class="text-[#ff3045]">*</span></label>
            <input id="openings" name="openings" type="number" min="1" max="10000" required class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
        </div>

        <div class="md:col-span-2">
            <label for="applicationLastDate" class="mb-2 block text-[13px] font-bold text-[#061942]">Application Last Date</label>
            <input id="applicationLastDate" name="application_last_date" type="date" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-[13px] font-bold text-[#061942]">Skills <span class="font-medium text-[#24344f]">(Add up to 10 skills)</span></label>
            <div id="skillsList" class="flex flex-wrap items-center gap-x-[18px] gap-y-3.5">
                <button id="addSkill" type="button" class="h-[42px] w-[122px] rounded-lg border border-dashed border-[#9fc0f5] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">+ Add Skill</button>
            </div>
        </div>

        <div class="md:col-span-2">
            <label for="description" class="mb-2 block text-[13px] font-bold text-[#061942]">Job Description <span class="text-[#ff3045]">*</span></label>
            <textarea id="description" name="description" required class="min-h-[140px] w-full resize-y rounded-lg border border-[#dce7f8] bg-white px-[18px] py-[18px] text-[15px] leading-relaxed text-[#24344f] outline-none focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]"></textarea>
        </div>

        <div class="flex justify-end gap-3 md:col-span-2">
            <a href="/company/jobs/show" class="inline-flex h-11 items-center rounded-lg border border-[#dce7f8] px-6 text-sm font-bold text-[#075fe4]">Cancel</a>
            <button id="saveJob" type="submit" class="h-11 rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-70">Save Job</button>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('ofc_auth_token') || localStorage.getItem('onlyfreshers_company_token');
    const jobId = localStorage.getItem('ofc_selected_company_job_id');
    const form = document.getElementById('editJobForm');
    const message = document.getElementById('jobMessage');
    const saveButton = document.getElementById('saveJob');
    const skillsList = document.getElementById('skillsList');
    const addSkillButton = document.getElementById('addSkill');

    function showMessage(text, type = 'error') {
        message.textContent = text;
        message.className = `mb-5 rounded-lg border px-4 py-3 text-sm font-bold ${type === 'success' ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]' : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'}`;
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value || '';
        return div.innerHTML;
    }

    function addSkill(name) {
        const skill = String(name || '').trim();
        if (!skill) return;
        const existing = Array.from(skillsList.querySelectorAll('.skill-tag')).some(tag => tag.dataset.skill.toLowerCase() === skill.toLowerCase());
        if (existing) return;
        const tag = document.createElement('span');
        tag.className = 'skill-tag inline-flex h-[42px] min-w-[104px] items-center justify-center gap-3.5 rounded-lg bg-[#eef3ff] px-4 text-sm text-[#061942]';
        tag.dataset.skill = skill;
        tag.innerHTML = `<span>${escapeHtml(skill)}</span><button type="button" class="text-lg leading-none text-[#061942]">&times;</button>`;
        tag.querySelector('button').addEventListener('click', () => tag.remove());
        skillsList.insertBefore(tag, addSkillButton);
    }

    function getSkills() {
        return Array.from(skillsList.querySelectorAll('.skill-tag')).map(tag => tag.dataset.skill).filter(Boolean);
    }

    function splitSkills(value) {
        return String(value || '').split(/[,|]/).map(item => item.trim()).filter(Boolean);
    }

    function setSelectValue(select, value, fallback = '') {
        const normalized = String(value || '').trim();
        const option = Array.from(select.options).find(item => item.value.toLowerCase() === normalized.toLowerCase());
        select.value = option ? option.value : fallback;
    }

    function fillJob(job) {
        form.title.value = job.title || '';
        form.qualification.value = job.qualification || '';
        setSelectValue(document.getElementById('experience'), job.qualification, '0 - 1 Year');
        setSelectValue(document.getElementById('employmentType'), job.job_type, 'Full Time');
        document.getElementById('hiringMode').value = job.hiring_mode || 'direct';
        document.getElementById('status').value = ['draft', 'active', 'inactive'].includes(job.status) ? job.status : 'active';
        form.location.value = job.location || '';
        form.salary.value = job.salary || '';
        form.openings.value = job.openings || 1;
        form.application_last_date.value = job.application_last_date || '';
        form.description.value = job.description || '';
        skillsList.querySelectorAll('.skill-tag').forEach(tag => tag.remove());
        splitSkills(job.required_skills).forEach(addSkill);
    }

    function buildPayload() {
        return {
            title: form.title.value.trim(),
            description: form.description.value.trim(),
            required_skills: getSkills().join(', '),
            qualification: form.qualification.value.trim() || document.getElementById('experience').value,
            location: form.location.value.trim(),
            salary: form.salary.value.trim(),
            job_type: document.getElementById('employmentType').value,
            openings: Number(form.openings.value || 1),
            hiring_mode: document.getElementById('hiringMode').value,
            application_last_date: form.application_last_date.value || null,
            status: document.getElementById('status').value,
        };
    }

    async function requestJson(url, options = {}) {
        const response = await fetch(url, {
            ...options,
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
                ...(options.headers || {}),
            },
        });
        const payload = await response.json().catch(() => ({}));
        if (response.status === 401 || response.status === 403) {
            localStorage.removeItem('ofc_auth_token');
            localStorage.removeItem('onlyfreshers_company_token');
            window.location.href = '/company/login';
            return null;
        }
        if (!response.ok || payload.success === false) {
            const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
            throw new Error(validationMessage || payload.message || 'Unable to update job.');
        }
        return payload;
    }

    addSkillButton.addEventListener('click', function () {
        if (skillsList.querySelectorAll('.skill-tag').length >= 10) {
            showMessage('Maximum 10 skills can be added.');
            return;
        }
        addSkill(prompt('Enter skill name'));
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';
        try {
            const result = await requestJson(`/api/company/jobs/${jobId}`, {
                method: 'PUT',
                body: JSON.stringify(buildPayload()),
            });
            if (!result) return;
            showMessage(result.message || 'Job updated successfully.', 'success');
            setTimeout(() => window.location.href = '/company/jobs/show', 700);
        } catch (error) {
            showMessage(error.message || 'Unable to update job.');
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Job';
        }
    });

    async function loadJob() {
        if (!token) {
            window.location.href = '/company/login';
            return;
        }
        if (!jobId) {
            showMessage('Please select a job to edit.');
            setTimeout(() => window.location.href = '/company/jobs', 900);
            return;
        }
        const result = await requestJson(`/api/company/jobs/${jobId}`);
        if (result?.data?.job) fillJob(result.data.job);
    }

    loadJob().catch(error => showMessage(error.message || 'Unable to load selected job.'));
});
</script>
@endpush
