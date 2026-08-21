@extends('layouts.company')

@section('title', 'Post Opportunity - OnlyFreshers')
@section('pageTitle', 'Post Opportunity')
@section('pageSubtitle', 'Fill in the details to post a job or internship.')

@php
    $activePage = 'post-job';

    $experienceLevels = [
        '0 - 1 Year',
        '1 - 3 Years',
        '3 - 5 Years',
        '5+ Years'
    ];

    $employmentTypes = [
        'Full Time',
        'Part Time',
        'Internship',
        'Contract'
    ];

    $hiringModes = [
        'direct' => 'Direct Hiring',
        'fast_track' => 'Fast Track'
    ];

    $skills = [];
@endphp


@section('content')

<section
    class="rounded-lg border border-[#dce7f8]
           bg-white px-5 py-6
           shadow-[0_10px_24px_rgba(6,25,66,0.04)]
           sm:px-[30px] sm:py-7"
>

    {{-- Save Draft Button --}}
    <div class="mb-3 flex justify-end">

        <button
            id="saveDraft"
            type="button"
            class="inline-flex h-10 w-[118px]
                   items-center justify-center
                   rounded-lg
                   border border-[#9fc0f5]
                   bg-white
                   text-[13px]
                   font-bold
                   text-[#075fe4]
                   transition
                   hover:bg-[#f5f9ff]"
        >
            Save Draft
        </button>

    </div>


    {{-- General Message --}}
    <div
        id="postJobAlert"
        class="mb-4 hidden rounded-lg border px-4 py-3 text-sm font-bold"
    ></div>

    <div
        id="creditNotice"
        class="mb-5 rounded-lg border border-[#cfe0ff] bg-[#f4f8ff] px-4 py-3 text-sm font-bold text-[#075fe4]"
    >
        You get 500 free company credits. Publishing one opportunity uses 50 credits.
        <span id="creditBalanceText">Checking balance...</span>
    </div>


    {{-- Job Form --}}
    <form
        id="postJobForm"
        class="grid grid-cols-1 gap-x-7 gap-y-6 md:grid-cols-2"
    >

        <p
            id="jobMessage"
            class="hidden rounded-lg border px-4 py-3
                   text-sm font-bold md:col-span-2"
        ></p>


        {{-- Job Title --}}
        <div>

            <label
                for="jobTitle"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Opportunity Title
                <span class="text-[#ff3045]">*</span>
            </label>

            <input
                id="jobTitle"
                name="title"
                type="text"
                placeholder="Enter job or internship title"
                required
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       placeholder:text-[#8a96aa]
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

        </div>


        {{-- Qualification --}}
        <div>

            <label
                for="qualification"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Qualification
            </label>

            <input
                id="qualification"
                name="qualification"
                type="text"
                placeholder="Example: B.Tech, BCA, MCA"
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       placeholder:text-[#8a96aa]
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

        </div>


        {{-- Experience --}}
        <div>

            <label
                for="experience"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Experience Level
                <span class="text-[#ff3045]">*</span>
            </label>

            <select
                id="experience"
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

                <option value="">
                    Select experience level
                </option>

                @foreach ($experienceLevels as $level)

                    <option value="{{ $level }}">
                        {{ $level }}
                    </option>

                @endforeach

            </select>
            <p
                id="internshipHint"
                class="mt-2 hidden rounded-lg border border-[#cfe0ff] bg-[#f4f8ff] px-3 py-2 text-[12px] font-medium text-[#075fe4]"
            >
                Internship selected: candidates will apply after Initial Assessment. Scores above 50 can access both jobs and internships.
            </p>

        </div>


        {{-- Employment Type --}}
        <div>

            <label
                for="employmentType"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Employment Type
                <span class="text-[#ff3045]">*</span>
            </label>

            <select
                id="employmentType"
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

                <option value="">
                    Select employment type
                </option>

                @foreach ($employmentTypes as $type)

                    <option value="{{ $type }}">
                        {{ $type }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Hiring Mode --}}
        <div>

            <label
                for="hiringMode"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Hiring Mode
                <span class="text-[#ff3045]">*</span>
            </label>

            <select
                id="hiringMode"
                name="hiring_mode"
                required
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

                @foreach ($hiringModes as $value => $label)

                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Location --}}
        <div class="md:col-span-2">

            <label
                for="location"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Location
                <span class="text-[#ff3045]">*</span>
            </label>

            <input
                id="location"
                name="location"
                type="text"
                placeholder="Enter job location"
                required
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       placeholder:text-[#8a96aa]
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

        </div>


        {{-- Salary --}}
        <div>

            <label
                for="salary"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Salary
            </label>

            <input
                id="salary"
                name="salary"
                type="text"
                placeholder="Example: 3-5 LPA"
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       placeholder:text-[#8a96aa]
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

        </div>


        {{-- Openings --}}
        <div>

            <label
                for="openings"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Openings
                <span class="text-[#ff3045]">*</span>
            </label>

            <input
                id="openings"
                name="openings"
                type="number"
                min="1"
                max="10000"
                value="1"
                required
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

        </div>


        {{-- Last Date --}}
        <div class="md:col-span-2">

            <label
                for="applicationLastDate"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Application Last Date
            </label>

            <input
                id="applicationLastDate"
                name="application_last_date"
                type="date"
                class="h-[50px] w-full
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       px-[18px]
                       text-[15px]
                       text-[#24344f]
                       outline-none
                       transition
                       focus:border-[#075fe4]
                       focus:ring-2
                       focus:ring-[#075fe41f]"
            >

        </div>


        {{-- Skills --}}
        <div class="md:col-span-2">

            <label
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Skills

                <span class="font-medium text-[#24344f]">
                    (Add up to 10 skills)
                </span>
            </label>


            <div
                id="skillsList"
                class="flex flex-wrap items-center
                       gap-x-[18px] gap-y-3.5"
            >

                @foreach ($skills as $skill)

                    <span
                        class="skill-tag
                               inline-flex h-[42px]
                               min-w-[104px]
                               items-center
                               justify-center
                               gap-3.5
                               rounded-lg
                               bg-[#eef3ff]
                               px-4
                               text-sm
                               text-[#061942]"
                    >
                        {{ $skill }}

                        <button
                            type="button"
                            class="text-lg leading-none text-[#061942]"
                        >
                            &times;
                        </button>

                    </span>

                @endforeach


                <button
                    id="addSkill"
                    type="button"
                    class="h-[42px] w-[122px]
                           rounded-lg
                           border border-dashed
                           border-[#9fc0f5]
                           bg-white
                           text-sm
                           font-bold
                           text-[#075fe4]
                           transition
                           hover:bg-[#f5f9ff]"
                >
                    + Add Skill
                </button>

            </div>

        </div>


        {{-- Description --}}
        <div class="md:col-span-2">

            <label
                for="description"
                class="mb-2 block text-[13px] font-bold text-[#061942]"
            >
                Job Description
                <span class="text-[#ff3045]">*</span>
            </label>


            <div
                class="overflow-hidden
                       rounded-lg
                       border border-[#dce7f8]
                       bg-white
                       focus-within:border-[#075fe4]
                       focus-within:ring-2
                       focus-within:ring-[#075fe41f]"
            >

                <div
                    class="flex h-12 items-center
                           gap-[18px]
                           border-b border-[#dce7f8]
                           px-5"
                >

                    <button
                        type="button"
                        class="text-[17px] font-bold text-[#24344f]"
                    >
                        B
                    </button>

                    <button
                        type="button"
                        class="text-[17px] font-bold italic text-[#24344f]"
                    >
                        I
                    </button>

                    <button
                        type="button"
                        class="text-[17px] font-bold underline text-[#24344f]"
                    >
                        U
                    </button>

                    <button
                        type="button"
                        class="text-[17px] font-bold text-[#24344f]"
                    >
                        &#9776;
                    </button>

                    <button
                        type="button"
                        class="text-[17px] font-bold text-[#24344f]"
                    >
                        &#9776;
                    </button>

                    <button
                        type="button"
                        class="text-[17px] font-bold text-[#24344f]"
                    >
                        &#128279;
                    </button>

                </div>


                <textarea
                    id="description"
                    name="description"
                    placeholder="Write job description"
                    required
                    class="min-h-[120px] w-full
                           resize-y
                           border-0
                           bg-white
                           px-[18px]
                           py-[18px]
                           text-[15px]
                           leading-relaxed
                           text-[#24344f]
                           outline-none
                           placeholder:text-[#8a96aa]"
                ></textarea>

            </div>

        </div>


        {{-- Publish --}}
        <button
            type="submit"
            class="h-[52px]
                   rounded-lg
                   bg-[#075fe4]
                   text-base
                   font-bold
                   text-white
                   shadow-[0_10px_20px_rgba(7,95,228,0.16)]
                   transition
                   hover:bg-[#0554cc]
                   md:col-span-2"
        >
            Publish Opportunity
        </button>

    </form>

</section>

@endsection



@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const token =
        localStorage.getItem('ofc_auth_token') ||
        localStorage.getItem('onlyfreshers_company_token');

    const form =
        document.getElementById('postJobForm');

    const message =
        document.getElementById('jobMessage');

    const publishButton =
        form.querySelector('button[type="submit"]');

    const draftButton =
        document.getElementById('saveDraft');

    const addSkillButton =
        document.getElementById('addSkill');

    const skillsList =
        document.getElementById('skillsList');

    const employmentTypeSelect =
        document.getElementById('employmentType');

    const jobTitleInput =
        document.getElementById('jobTitle');

    const locationInput =
        document.getElementById('location');

    const salaryInput =
        document.getElementById('salary');

    const internshipHint =
        document.getElementById('internshipHint');

    const creditBalanceText =
        document.getElementById('creditBalanceText');


    /*
    |--------------------------------------------------------------------------
    | Skill Remove
    |--------------------------------------------------------------------------
    */

    function attachSkillRemove(button) {

        button.addEventListener(
            'click',
            function () {

                const tag =
                    button.closest('.skill-tag');

                if (tag) {
                    tag.remove();
                }
            }
        );
    }


    document
        .querySelectorAll('.skill-tag button')
        .forEach(attachSkillRemove);


    /*
    |--------------------------------------------------------------------------
    | Add Skill
    |--------------------------------------------------------------------------
    */

    addSkillButton.addEventListener(
        'click',
        function () {

            const currentSkills =
                document.querySelectorAll(
                    '.skill-tag'
                );

            if (currentSkills.length >= 10) {

                showMessage(
                    'Maximum 10 skills can be added.'
                );

                return;
            }


            const skillName =
                prompt('Enter skill name');


            if (
                !skillName ||
                !skillName.trim()
            ) {
                return;
            }


            const duplicate =
                Array.from(currentSkills)
                    .some(
                        tag =>
                            tag.dataset.skill
                                ?.toLowerCase() ===
                            skillName
                                .trim()
                                .toLowerCase()
                    );


            if (duplicate) {

                showMessage(
                    'This skill is already added.'
                );

                return;
            }


            const tag =
                document.createElement('span');


            tag.className =
                'skill-tag inline-flex h-[42px] min-w-[104px] items-center justify-center gap-3.5 rounded-lg bg-[#eef3ff] px-4 text-sm text-[#061942]';


            tag.dataset.skill =
                skillName.trim();


            tag.innerHTML = `
                <span>${escapeHtml(skillName.trim())}</span>

                <button
                    type="button"
                    class="text-lg leading-none text-[#061942]"
                >
                    &times;
                </button>
            `;


            attachSkillRemove(
                tag.querySelector('button')
            );


            skillsList.insertBefore(
                tag,
                addSkillButton
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            value;

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Skills
    |--------------------------------------------------------------------------
    */

    function getSkills() {

        return Array
            .from(
                document.querySelectorAll(
                    '.skill-tag'
                )
            )
            .map(tag => {

                if (tag.dataset.skill) {
                    return tag.dataset.skill.trim();
                }


                const textElement =
                    tag.querySelector('span');

                if (textElement) {
                    return textElement.textContent.trim();
                }


                return tag.textContent
                    .replace('×', '')
                    .trim();
            })
            .filter(Boolean);
    }


    /*
    |--------------------------------------------------------------------------
    | Message
    |--------------------------------------------------------------------------
    */

    function showMessage(
        text,
        type = 'error'
    ) {

        message.textContent =
            text;


        message.className =
            `rounded-lg border px-4 py-3 text-sm font-bold md:col-span-2 ${
                type === 'success'
                    ? 'border-[#b9e7c9] bg-[#f1fff5] text-[#138a43]'
                    : 'border-[#ffd1d7] bg-[#fff7f8] text-[#ff3045]'
            }`;
    }

    function redirectToBilling(message) {

        showMessage(
            message ||
            'Your credits are over. Please choose a subscription plan to post more opportunities.'
        );

        setTimeout(
            () => {
                window.location.href =
                    '/company/billing';
            },
            900
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Build Payload
    |--------------------------------------------------------------------------
    */

    function buildPayload(status) {

        const experience =
            document
                .getElementById('experience')
                .value;


        const employmentType =
            document
                .getElementById('employmentType')
                .value;


        const skills =
            getSkills();


        return {

            title:
                document
                    .getElementById('jobTitle')
                    .value
                    .trim(),

            description:
                document
                    .getElementById('description')
                    .value
                    .trim(),

            required_skills:
                skills.join(', '),

            qualification:
                document
                    .getElementById('qualification')
                    .value
                    .trim() ||
                experience,

            location:
                document
                    .getElementById('location')
                    .value
                    .trim(),

            salary:
                document
                    .getElementById('salary')
                    .value
                    .trim(),

            job_type:
                employmentType,

            openings:
                Number(
                    document
                        .getElementById('openings')
                        .value || 1
                ),

            hiring_mode:
                document
                    .getElementById('hiringMode')
                    .value,

            application_last_date:
                document
                    .getElementById(
                        'applicationLastDate'
                    )
                    .value || null,

            status:
                status
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Form
    |--------------------------------------------------------------------------
    */

    function validateJobForm(status) {

        const title =
            document
                .getElementById('jobTitle')
                .value
                .trim();


        const description =
            document
                .getElementById('description')
                .value
                .trim();


        const location =
            document
                .getElementById('location')
                .value
                .trim();


        const employmentType =
            document
                .getElementById('employmentType')
                .value;


        if (status === 'active') {

            if (!title) {

                showMessage(
                    'Job title is required.'
                );

                return false;
            }


            if (!location) {

                showMessage(
                    'Job location is required.'
                );

                return false;
            }


            if (!employmentType) {

                showMessage(
                    'Employment type is required.'
                );

                return false;
            }


            if (!description) {

                showMessage(
                    'Job description is required.'
                );

                return false;
            }
        }


        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | Internship UI Mode
    |--------------------------------------------------------------------------
    */

    function isInternshipSelected() {

        return String(employmentTypeSelect?.value || '')
            .toLowerCase()
            .includes('internship');
    }

    function updateInternshipMode() {

        const internship =
            isInternshipSelected();

        if (jobTitleInput) {
            jobTitleInput.placeholder =
                internship
                    ? 'Example: Frontend Developer Intern'
                    : 'Example: Software Developer';
        }

        if (locationInput) {
            locationInput.placeholder =
                internship
                    ? 'Example: Remote / Noida / Hybrid'
                    : 'Enter job location';
        }

        if (salaryInput) {
            salaryInput.placeholder =
                internship
                    ? 'Example: ₹8,000 - ₹15,000 stipend'
                    : 'Example: 3-5 LPA';
        }

        if (internshipHint) {
            internshipHint.classList.toggle(
                'hidden',
                !internship
            );
        }

        if (publishButton) {
            publishButton.textContent =
                internship
                    ? 'Post Internship'
                    : 'Publish Opportunity';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Company Permission
    |--------------------------------------------------------------------------
    */

    async function ensureCompanyCanPost() {

        if (!token) {

            window.location.href =
                '/company/login';

            return false;
        }


        const response =
            await fetch(
                '/api/company/profile',
                {
                    method: 'GET',

                    headers: {
                        Accept:
                            'application/json',

                        Authorization:
                            `Bearer ${token}`
                    }
                }
            );


        /*
        | Invalid Token
        */

        if (
            response.status === 401 ||
            response.status === 403
        ) {

            localStorage.removeItem(
                'ofc_auth_token'
            );

            localStorage.removeItem(
                'onlyfreshers_company_token'
            );

            window.location.href =
                '/company/login';

            return false;
        }


        let result;

        try {

            result =
                await response.json();

        } catch (error) {

            showMessage(
                'Invalid server response.'
            );

            return false;
        }


        /*
        | Support possible response structures
        */

        const profile =
            result?.data?.profile ||
            result?.data?.company_profile ||
            result?.profile ||
            null;


        if (!profile) {

            window.location.href =
                '/company/profile/edit';

            return false;
        }


        localStorage.setItem(
            'ofc_company_profile',
            JSON.stringify(profile)
        );

        const remainingCredits =
            Number(profile.job_credits ?? 500);

        if (creditBalanceText) {
            creditBalanceText.textContent =
                `Current balance: ${remainingCredits} credits.`;
        }


        document.dispatchEvent(
            new CustomEvent(
                'company-profile-loaded',
                {
                    detail: profile
                }
            )
        );


        /*
        | Pending
        */

        if (
            profile.approval_status ===
            'pending'
        ) {

            window.location.href =
                '/company/approval/pending';

            return false;
        }


        /*
        | Rejected
        */

        if (
            profile.approval_status ===
            'rejected'
        ) {

            window.location.href =
                '/company/approval/rejected';

            return false;
        }

        if (remainingCredits < 50) {
            if (publishButton) {
                publishButton.disabled = true;
                publishButton.textContent = 'Upgrade to Post';
            }

            redirectToBilling(
                'Your free credits are over. Choose a subscription plan to post more opportunities.'
            );

            return false;
        }


        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | Save Job
    |--------------------------------------------------------------------------
    */

    async function saveCompanyJob(status) {

        if (
            !validateJobForm(status)
        ) {
            return;
        }


        const canPost =
            await ensureCompanyCanPost();


        if (!canPost) {
            return;
        }


        const activeButton =
            status === 'active'
                ? publishButton
                : draftButton;


        activeButton.disabled =
            true;


        activeButton.textContent =
            status === 'active'
                ? 'Publishing...'
                : 'Saving...';


        try {

            const response =
                await fetch(
                    '/api/company/jobs',
                    {
                        method: 'POST',

                        headers: {

                            Accept:
                                'application/json',

                            'Content-Type':
                                'application/json',

                            Authorization:
                                `Bearer ${token}`
                        },

                        body:
                            JSON.stringify(
                                buildPayload(status)
                            )
                    }
                );


            let result;

            try {

                result =
                    await response.json();

            } catch (error) {

                throw new Error(
                    'Invalid response received from server.'
                );
            }


            if (
                response.status === 401 ||
                response.status === 403
            ) {

                localStorage.removeItem(
                    'ofc_auth_token'
                );

                localStorage.removeItem(
                    'onlyfreshers_company_token'
                );

                window.location.href =
                    '/company/login';

                return;
            }

            if (response.status === 402) {
                redirectToBilling(
                    result?.message ||
                    'Your credits are over. Please choose a subscription plan.'
                );

                return;
            }


            if (
                !response.ok ||
                result.success === false
            ) {

                const validationMessage =
                    result.errors
                        ? Object
                            .values(result.errors)
                            .flat()[0]
                        : null;


                throw new Error(
                    validationMessage ||
                    result.message ||
                    'Unable to save opportunity.'
                );
            }


            showMessage(
                result.message ||
                'Opportunity saved successfully.',
                'success'
            );


            setTimeout(
                () => {

                    window.location.href =
                        '/company/jobs';

                },
                700
            );

        } catch (error) {

            console.error(
                'Post opportunity error:',
                error
            );


            showMessage(
                error.message ||
                'Something went wrong.'
            );

        } finally {

            activeButton.disabled =
                false;


            draftButton.textContent =
                'Save Draft';


            publishButton.textContent =
                'Publish Opportunity';

            updateInternshipMode();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Draft Button
    |--------------------------------------------------------------------------
    */

    draftButton.addEventListener(
        'click',
        function () {

            saveCompanyJob(
                'draft'
            );
        }
    );

    employmentTypeSelect?.addEventListener(
        'change',
        updateInternshipMode
    );

    updateInternshipMode();


    /*
    |--------------------------------------------------------------------------
    | Publish
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        function (event) {

            event.preventDefault();

            saveCompanyJob(
                'active'
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Company Check
    |--------------------------------------------------------------------------
    */

    ensureCompanyCanPost()
        .catch(error => {

            console.error(
                'Company profile check error:',
                error
            );

            showMessage(
                'Unable to verify company profile.'
            );
        });

});
</script>

@endpush
