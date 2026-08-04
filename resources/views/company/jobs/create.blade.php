@extends('layouts.company')

@section('title', 'Post a Job - OnlyFreshers')
@section('pageTitle', 'Post a Job')
@section('pageSubtitle', 'Fill in the details to post a new job.')

@php
    $activePage = 'post-job';

    $experienceLevels = ['0 - 1 Year', '1 - 3 Years', '3 - 5 Years', '5+ Years'];
    $employmentTypes = ['Full Time', 'Part Time', 'Internship', 'Contract'];
    $skills = [];
@endphp

@section('content')
    <section class="rounded-lg border border-[#dce7f8] bg-white px-5 py-6 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:px-[30px] sm:py-7">
        <div class="mb-3 flex justify-end">
            <button id="saveDraft" type="button" class="inline-flex h-10 w-[118px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                Save Draft
            </button>
        </div>

        <form id="postJobForm" class="grid grid-cols-1 gap-x-7 gap-y-6 md:grid-cols-2">
            <div>
                <label for="jobTitle" class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Job Title <span class="text-[#ff3045]">*</span>
                </label>
                <input id="jobTitle" type="text" placeholder="Enter job title" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none transition placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
            </div>

            <div>
                <label for="jobRole" class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Job Role <span class="text-[#ff3045]">*</span>
                </label>
                <input id="jobRole" type="text" placeholder="Enter job role" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none transition placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
            </div>

            <div>
                <label for="experience" class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Experience Level <span class="text-[#ff3045]">*</span>
                </label>
                <select id="experience" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none transition focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    <option value="">Select experience level</option>
                    @foreach ($experienceLevels as $level)
                        <option>{{ $level }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="employmentType" class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Employment Type <span class="text-[#ff3045]">*</span>
                </label>
                <select id="employmentType" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none transition focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
                    <option value="">Select employment type</option>
                    @foreach ($employmentTypes as $type)
                        <option>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="location" class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Location <span class="text-[#ff3045]">*</span>
                </label>
                <input id="location" type="text" placeholder="Enter job location" class="h-[50px] w-full rounded-lg border border-[#dce7f8] bg-white px-[18px] text-[15px] text-[#24344f] outline-none transition placeholder:text-[#8a96aa] focus:border-[#075fe4] focus:ring-2 focus:ring-[#075fe41f]">
            </div>

            <div class="md:col-span-2">
                <label class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Skills <span class="font-medium text-[#24344f]">(Add up to 10 skills)</span>
                </label>
                <div id="skillsList" class="flex flex-wrap items-center gap-x-[18px] gap-y-3.5">
                    @foreach ($skills as $skill)
                        <span class="skill-tag inline-flex h-[42px] min-w-[104px] items-center justify-center gap-3.5 rounded-lg bg-[#eef3ff] px-4 text-sm text-[#061942]">
                            {{ $skill }}
                            <button type="button" class="text-lg leading-none text-[#061942]">&times;</button>
                        </span>
                    @endforeach

                    <button id="addSkill" type="button" class="h-[42px] w-[122px] rounded-lg border border-dashed border-[#9fc0f5] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]">
                        + Add Skill
                    </button>
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="mb-2 block text-[13px] font-bold text-[#061942]">
                    Job Description <span class="text-[#ff3045]">*</span>
                </label>
                <div class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white focus-within:border-[#075fe4] focus-within:ring-2 focus-within:ring-[#075fe41f]">
                    <div class="flex h-12 items-center gap-[18px] border-b border-[#dce7f8] px-5">
                        <button type="button" class="text-[17px] font-bold text-[#24344f]">B</button>
                        <button type="button" class="text-[17px] font-bold italic text-[#24344f]">I</button>
                        <button type="button" class="text-[17px] font-bold underline text-[#24344f]">U</button>
                        <button type="button" class="text-[17px] font-bold text-[#24344f]">&#9776;</button>
                        <button type="button" class="text-[17px] font-bold text-[#24344f]">&#9776;</button>
                        <button type="button" class="text-[17px] font-bold text-[#24344f]">&#128279;</button>
                    </div>
                    <textarea id="description" placeholder="Write job description" class="min-h-[120px] w-full resize-y border-0 bg-white px-[18px] py-[18px] text-[15px] leading-relaxed text-[#24344f] outline-none placeholder:text-[#8a96aa]"></textarea>
                </div>
            </div>

            <button type="submit" class="md:col-span-2 h-[52px] rounded-lg bg-[#075fe4] text-base font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,0.16)] transition hover:bg-[#0554cc]">
                Publish Job
            </button>
        </form>
    </section>
@endsection

@push('scripts')
<script>
    function attachSkillRemove(button) {
        button.addEventListener('click', function () {
            button.closest('.skill-tag').remove();
        });
    }

    document.querySelectorAll('.skill-tag button').forEach(attachSkillRemove);

    document.getElementById('addSkill').addEventListener('click', function () {
        const skillName = prompt('Enter skill name');
        if (!skillName) return;

        const tag = document.createElement('span');
        tag.className = 'skill-tag inline-flex h-[42px] min-w-[104px] items-center justify-center gap-3.5 rounded-lg bg-[#eef3ff] px-4 text-sm text-[#061942]';
        tag.innerHTML = skillName + ' <button type="button" class="text-lg leading-none text-[#061942]">&times;</button>';
        attachSkillRemove(tag.querySelector('button'));
        document.getElementById('skillsList').insertBefore(tag, document.getElementById('addSkill'));
    });

    function getSkills() {
        const skills = [];
        document.querySelectorAll('.skill-tag').forEach(function (tag) {
            skills.push(tag.firstChild.textContent.trim());
        });
        return skills;
    }

    function saveCompanyJob(status) {
        const jobs = JSON.parse(localStorage.getItem('companyJobs') || '[]');
        const today = new Date();
        const dateText = today.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

        jobs.unshift({
            title: document.getElementById('jobTitle').value || 'Untitled Job',
            role: document.getElementById('jobRole').value,
            experience: document.getElementById('experience').value || '0 - 1 Year',
            type: document.getElementById('employmentType').value || 'Full Time',
            location: document.getElementById('location').value || 'Not added',
            description: document.getElementById('description').value,
            skills: getSkills(),
            applications: 0,
            status: status,
            date: dateText
        });

        localStorage.setItem('companyJobs', JSON.stringify(jobs));
        window.location.href = '/company/jobs';
    }

    document.getElementById('saveDraft').addEventListener('click', function () {
        saveCompanyJob('Draft');
    });

    document.getElementById('postJobForm').addEventListener('submit', function (event) {
        event.preventDefault();
        saveCompanyJob('Active');
    });
</script>
@endpush
