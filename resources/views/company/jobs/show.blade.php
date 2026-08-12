@extends('layouts.company')

@section('title', 'Job Details - OnlyFreshers')
@section('pageTitle', 'Job Details')
@section('pageSubtitle', 'View job posting details and activity.')

@php
    $activePage = 'jobs';
@endphp


@section('content')

<section class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">

    {{-- Main Job Details --}}
    <div
        class="rounded-lg border border-[#dce7f8]
               bg-white p-5
               shadow-[0_10px_24px_rgba(6,25,66,0.04)]
               sm:p-6"
    >

        {{-- Loading --}}
        <div
            id="jobLoading"
            class="rounded-lg border border-[#dce7f8]
                   bg-[#f8fbff]
                   p-5
                   text-sm font-bold
                   text-[#52607a]"
        >
            Loading job details...
        </div>


        {{-- Job Content --}}
        <div
            id="jobContent"
            class="hidden"
        >

            {{-- Header --}}
            <div
                class="mb-5 flex flex-col gap-3
                       sm:flex-row
                       sm:items-start
                       sm:justify-between"
            >

                <div class="min-w-0">

                    <h2
                        id="jobTitle"
                        class="break-words text-xl font-bold text-[#061942]"
                    >
                        Job
                    </h2>

                    <p
                        id="jobMeta"
                        class="mt-2 break-words text-sm text-[#24344f]"
                    >
                        -
                    </p>

                </div>


                <span
                    id="jobStatus"
                    class="inline-flex h-8 items-center rounded-lg px-3 text-xs font-bold"
                >
                    -
                </span>

            </div>


            {{-- Statistics --}}
            <div class="mb-6 grid gap-4 sm:grid-cols-3">

                <div class="rounded-lg bg-[#f4f8ff] p-4">

                    <b
                        id="applicationCount"
                        class="block text-lg text-[#061942]"
                    >
                        0
                    </b>

                    <span class="text-xs text-[#52607a]">
                        Applications
                    </span>

                </div>


                <div class="rounded-lg bg-[#f4f8ff] p-4">

                    <b
                        id="openingCount"
                        class="block text-lg text-[#061942]"
                    >
                        0
                    </b>

                    <span class="text-xs text-[#52607a]">
                        Openings
                    </span>

                </div>


                <div class="rounded-lg bg-[#f4f8ff] p-4">

                    <b
                        id="lastDate"
                        class="block text-lg text-[#061942]"
                    >
                        -
                    </b>

                    <span class="text-xs text-[#52607a]">
                        Last Date
                    </span>

                </div>

            </div>


            {{-- Description --}}
            <h3 class="mb-3 text-base font-bold text-[#061942]">
                Job Description
            </h3>

            <p
                id="jobDescription"
                class="whitespace-pre-line break-words text-sm leading-relaxed text-[#24344f]"
            >
                -
            </p>


            {{-- Skills --}}
            <h3 class="mb-3 mt-6 text-base font-bold text-[#061942]">
                Required Skills
            </h3>

            <div
                id="jobSkills"
                class="flex flex-wrap gap-2"
            ></div>


            {{-- Extra Details --}}
            <h3 class="mb-3 mt-6 text-base font-bold text-[#061942]">
                Salary / Qualification
            </h3>

            <p
                id="jobExtra"
                class="break-words text-sm leading-relaxed text-[#24344f]"
            >
                -
            </p>

        </div>

    </div>


    {{-- Actions --}}
    <aside
        class="rounded-lg border border-[#dce7f8]
               bg-white p-5
               shadow-[0_10px_24px_rgba(6,25,66,0.04)]"
    >

        <h3 class="mb-4 text-base font-bold text-[#061942]">
            Actions
        </h3>


        <div class="grid gap-3">

            <a
                id="editJobLink"
                href="/company/jobs/edit"
                class="inline-flex h-10
                       items-center justify-center
                       rounded-lg
                       bg-[#075fe4]
                       text-sm font-bold
                       text-white
                       transition
                       hover:bg-[#0554cc]"
            >
                Edit Job
            </a>


            <a
                href="/company/jobs/preview"
                class="inline-flex h-10
                       items-center justify-center
                       rounded-lg
                       border border-[#9fc0f5]
                       text-sm font-bold
                       text-[#075fe4]
                       transition
                       hover:bg-[#f5f9ff]"
            >
                Preview
            </a>


            <a
                href="/company/applications"
                class="inline-flex h-10
                       items-center justify-center
                       rounded-lg
                       border border-[#dce7f8]
                       text-sm font-bold
                       text-[#24344f]
                       transition
                       hover:bg-[#f8fbff]"
            >
                View Applications
            </a>


            <a
                href="/company/jobs"
                class="inline-flex h-10
                       items-center justify-center
                       rounded-lg
                       border border-[#dce7f8]
                       text-sm font-bold
                       text-[#24344f]
                       transition
                       hover:bg-[#f8fbff]"
            >
                Back to Jobs
            </a>

        </div>

    </aside>

</section>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    const token =
        localStorage.getItem('ofc_auth_token') ||
        localStorage.getItem('onlyfreshers_company_token');


    const jobId =
        localStorage.getItem('ofc_selected_company_job_id');


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const loading =
        document.getElementById('jobLoading');

    const content =
        document.getElementById('jobContent');


    /*
    |--------------------------------------------------------------------------
    | Status Styles
    |--------------------------------------------------------------------------
    */

    const statusClasses = {

        active:
            'bg-[#dbf8e9] text-[#00a65a]',

        draft:
            'bg-[#eaf2ff] text-[#075fe4]',

        inactive:
            'bg-[#edf2fb] text-[#52607a]',

        removed:
            'bg-[#ffe8eb] text-[#ff3045]'
    };


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        return String(value ?? '')
            .replace(
                /[&<>'"]/g,
                function (char) {

                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        "'": '&#039;',
                        '"': '&quot;'
                    }[char];
                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Format Status
    |--------------------------------------------------------------------------
    */

    function formatStatus(status) {

        if (!status) {
            return '-';
        }

        return String(status)
            .replaceAll('_', ' ')
            .replace(
                /\b\w/g,
                letter => letter.toUpperCase()
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    function formatDate(value) {

        if (!value) {
            return '-';
        }

        const date =
            new Date(value);


        if (
            Number.isNaN(
                date.getTime()
            )
        ) {
            return value;
        }


        return date.toLocaleDateString(
            'en-IN',
            {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Set Text
    |--------------------------------------------------------------------------
    */

    function setText(id, value) {

        const element =
            document.getElementById(id);


        if (!element) {
            return;
        }


        element.textContent =
            value === null ||
            value === undefined ||
            value === ''
                ? '-'
                : value;
    }


    /*
    |--------------------------------------------------------------------------
    | Clear Auth
    |--------------------------------------------------------------------------
    */

    function clearCompanyAuthentication() {

        localStorage.removeItem(
            'ofc_auth_token'
        );

        localStorage.removeItem(
            'onlyfreshers_company_token'
        );

        localStorage.removeItem(
            'ofc_company_profile'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Company Flow Guard
    |--------------------------------------------------------------------------
    */

    async function guardCompanyFlow() {

        /*
        | Not Logged In
        */

        if (!token) {

            window.location.href =
                '/company/login';

            return false;
        }


        /*
        | Profile API
        */

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
        | Unauthorized
        */

        if (
            response.status === 401 ||
            response.status === 403
        ) {

            clearCompanyAuthentication();

            window.location.href =
                '/company/login';

            return false;
        }


        /*
        | Response Parse
        */

        let result;

        try {

            result =
                await response.json();

        } catch (error) {

            throw new Error(
                'Invalid company profile response.'
            );
        }


        /*
        | Profile
        |
        | Supporting both API structures.
        */

        const profile =
            result?.data?.profile ||
            result?.data?.company_profile ||
            result?.profile ||
            null;


        /*
        | Profile Missing
        */

        if (!profile) {

            window.location.href =
                '/company/profile/edit';

            return false;
        }


        /*
        | Store Profile
        */

        localStorage.setItem(
            'ofc_company_profile',
            JSON.stringify(profile)
        );


        /*
        | Notify Layout
        */

        document.dispatchEvent(
            new CustomEvent(
                'company-profile-loaded',
                {
                    detail: profile
                }
            )
        );


        /*
        | Approval Pending
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
        | Approval Rejected
        */

        if (
            profile.approval_status ===
            'rejected'
        ) {

            window.location.href =
                '/company/approval/rejected';

            return false;
        }


        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | Load Job
    |--------------------------------------------------------------------------
    */

    async function loadJobDetails() {

        /*
        | Validate Company
        */

        const canContinue =
            await guardCompanyFlow();


        if (!canContinue) {
            return;
        }


        /*
        | No Selected Job
        */

        if (!jobId) {

            window.location.href =
                '/company/jobs';

            return;
        }


        /*
        | Job API
        */

        const response =
            await fetch(
                `/api/company/jobs/${jobId}`,
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
        | Unauthorized
        */

        if (
            response.status === 401 ||
            response.status === 403
        ) {

            clearCompanyAuthentication();

            window.location.href =
                '/company/login';

            return;
        }


        /*
        | Parse Response
        */

        let result;

        try {

            result =
                await response.json();

        } catch (error) {

            throw new Error(
                'Invalid job response received.'
            );
        }


        /*
        | API Error
        */

        if (
            !response.ok ||
            result.success === false
        ) {

            throw new Error(
                result.message ||
                'Unable to load job details.'
            );
        }


        /*
        | Job
        */

        const job =
            result?.data?.job ||
            result?.job ||
            null;


        if (!job) {

            throw new Error(
                'Job details not found.'
            );
        }


        /*
        | Skills
        */

        let skills = [];


        if (
            Array.isArray(
                job.required_skills
            )
        ) {

            skills =
                job.required_skills;

        } else if (
            job.required_skills
        ) {

            skills =
                String(
                    job.required_skills
                )
                .split(',')
                .map(
                    skill =>
                        skill.trim()
                )
                .filter(Boolean);
        }


        /*
        | Job Main Data
        */

        setText(
            'jobTitle',
            job.title
        );


        setText(
            'jobMeta',
            [
                job.location,
                job.job_type,
                formatStatus(
                    job.hiring_mode
                )
            ]
            .filter(Boolean)
            .join(' • ')
        );


        setText(
            'applicationCount',
            Number(
                job.applications_count || 0
            )
        );


        setText(
            'openingCount',
            Number(
                job.openings || 0
            )
        );


        setText(
            'lastDate',
            formatDate(
                job.application_last_date
            )
        );


        setText(
            'jobDescription',
            job.description
        );


        /*
        | Salary / Qualification
        */

        const extraDetails = [

            job.salary
                ? `Salary: ${job.salary}`
                : '',

            job.qualification
                ? `Qualification: ${job.qualification}`
                : ''

        ]
        .filter(Boolean)
        .join(' • ');


        setText(
            'jobExtra',
            extraDetails || '-'
        );


        /*
        | Status
        */

        const statusElement =
            document.getElementById(
                'jobStatus'
            );


        const jobStatus =
            job.status || 'inactive';


        statusElement.textContent =
            formatStatus(jobStatus);


        statusElement.className =
            `inline-flex h-8 items-center rounded-lg px-3 text-xs font-bold ${
                statusClasses[jobStatus] ||
                statusClasses.inactive
            }`;


        /*
        | Skills Render
        */

        const skillsElement =
            document.getElementById(
                'jobSkills'
            );


        if (skills.length) {

            skillsElement.innerHTML =
                skills
                    .map(
                        skill => `
                            <span
                                class="rounded-lg
                                       bg-[#eaf2ff]
                                       px-3 py-2
                                       text-xs font-bold
                                       text-[#075fe4]"
                            >
                                ${escapeHtml(skill)}
                            </span>
                        `
                    )
                    .join('');

        } else {

            skillsElement.innerHTML = `
                <span class="text-sm text-[#52607a]">
                    No skills added.
                </span>
            `;
        }


        /*
        | Edit Job
        */

        const editJobLink =
            document.getElementById(
                'editJobLink'
            );


        editJobLink.addEventListener(
            'click',
            function () {

                localStorage.setItem(
                    'ofc_selected_company_job_id',
                    job.id
                );
            }
        );


        /*
        | Show Content
        */

        loading.classList.add(
            'hidden'
        );

        content.classList.remove(
            'hidden'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Start
    |--------------------------------------------------------------------------
    */

    loadJobDetails()
        .catch(
            function (error) {

                console.error(
                    'Load job details error:',
                    error
                );


                loading.textContent =
                    error.message ||
                    'Unable to load job details.';


                loading.className =
                    'rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm font-bold text-[#ff3045]';
            }
        );

});
</script>

@endpush