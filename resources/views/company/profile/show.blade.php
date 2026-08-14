@extends('layouts.company')

@section('title', 'My Profile - OnlyFreshers')
@section('pageTitle', 'My Profile')
@section('pageSubtitle', 'Manage your company profile and details.')

@php
    $activePage = 'profile';
@endphp

@push('styles')
<style>
    .company-profile-page,
    .company-profile-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }

    .company-profile-page [data-company-profile-initial] {
        box-shadow: 0 18px 34px rgba(7, 95, 228, 0.18);
    }
</style>
@endpush

@section('content')

<section
    class="company-profile-page min-h-[690px] rounded-lg border border-[#dce7f8] bg-white px-4 py-5 shadow-[0_10px_24px_rgba(6,25,66,0.04)] sm:px-6 sm:py-7 xl:px-9 xl:py-8"
>

    {{-- =========================================================
        PROFILE HEADER
    ========================================================== --}}
    <div
        class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
    >

        <div>

            <h2
                class="text-lg font-bold text-[#061942]"
            >
                Company Profile
            </h2>

            <p
                id="approvalStatus"
                class="mt-2 hidden text-xs font-bold"
            ></p>

        </div>


        <a
            href="/company/profile/edit"
            class="inline-flex h-10 w-[118px] items-center justify-center rounded-lg border border-[#9fc0f5] bg-white text-[13px] font-bold text-[#075fe4] transition hover:bg-[#f5f9ff]"
        >
            Edit Profile
        </a>

    </div>



    {{-- =========================================================
        LOADING STATE
    ========================================================== --}}
    <div
        id="profileLoading"
        class="rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-5 text-sm font-bold text-[#52607a]"
    >
        Loading company profile...
    </div>



    {{-- =========================================================
        EMPTY PROFILE STATE
    ========================================================== --}}
    <div
        id="emptyProfile"
        class="hidden rounded-lg border border-[#dce7f8] bg-[#f8fbff] p-6"
    >

        <h3
            class="mb-2 text-lg font-bold text-[#061942]"
        >
            Complete your company profile
        </h3>


        <p
            class="mb-5 max-w-2xl text-sm leading-relaxed text-[#24344f]"
        >
            Documentation ke flow ke according company account create
            hone ke baad profile complete karni hoti hai. Uske baad
            profile admin approval ke liye pending rahegi.
        </p>


        <a
            href="/company/profile/edit"
            class="inline-flex h-11 items-center rounded-lg bg-[#075fe4] px-6 text-sm font-bold text-white"
        >
            Complete Profile
        </a>

    </div>



    {{-- =========================================================
        PROFILE CONTENT
    ========================================================== --}}
    <div
        id="profileContent"
        class="hidden grid gap-7 xl:grid-cols-[minmax(0,1.2fr)_minmax(300px,0.9fr)] xl:gap-[50px]"
    >

        {{-- LEFT SIDE --}}
        <div class="min-w-0 xl:pr-2">


            {{-- =====================================================
                COMPANY BASIC INFORMATION
            ====================================================== --}}
            <div
                class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-center lg:gap-9"
            >

                {{-- Company Initial --}}
                <div
                    id="companyInitial"
                    data-company-profile-initial
                    class="flex h-[110px] w-[110px] shrink-0 items-center justify-center rounded-full bg-[#075fe4] text-[50px] font-bold text-white sm:h-[145px] sm:w-[145px] sm:text-[68px]"
                >
                    C
                </div>



                {{-- Company Information --}}
                <div class="min-w-0">


                    {{-- Company Name --}}
                    <h3
                        id="companyName"
                        data-company-profile-name
                        class="mb-4 break-words text-xl font-bold text-[#061942]"
                    >
                        Company
                    </h3>



                    {{-- Email --}}
                    <div
                        class="my-3 flex items-center gap-4 text-sm text-[#24344f]"
                    >

                        <span
                            class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]"
                        >

                            <svg
                                class="h-[22px] w-[22px]"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M4 4h16v16H4z"></path>
                                <path d="M4 7l8 6 8-6"></path>
                            </svg>

                        </span>


                        <span
                            id="companyEmail"
                            data-company-profile-email
                            class="min-w-0 break-all"
                        >
                            -
                        </span>

                    </div>



                    {{-- Phone --}}
                    <div
                        class="my-3 flex items-center gap-4 text-sm text-[#24344f]"
                    >

                        <span
                            class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]"
                        >

                            <svg
                                class="h-[22px] w-[22px]"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.4 19.4 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.4 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"
                                ></path>

                            </svg>

                        </span>


                        <span
                            id="companyPhone"
                            data-company-profile-phone
                            class="min-w-0 break-words"
                        >
                            -
                        </span>

                    </div>



                    {{-- Website --}}
                    <div
                        class="my-3 flex items-center gap-4 text-sm text-[#24344f]"
                    >

                        <span
                            class="flex h-6 w-6 shrink-0 items-center justify-center text-[#52607a]"
                        >

                            <svg
                                class="h-[22px] w-[22px]"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="10"
                                ></circle>

                                <path
                                    d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"
                                ></path>

                            </svg>

                        </span>


                        <span
                            id="companyWebsite"
                            data-company-profile-website
                            class="min-w-0 break-all leading-relaxed"
                        >
                            -
                        </span>

                    </div>

                </div>

            </div>



            {{-- Divider --}}
            <div
                class="mb-8 h-px bg-[#dce7f8]"
            ></div>



            {{-- =====================================================
                ABOUT COMPANY
            ====================================================== --}}
            <div>

                <h3
                    class="mb-4 text-[17px] font-bold text-[#061942]"
                >
                    About Company
                </h3>


                <p
                    id="companyDescription"
                    data-company-profile-description
                    class="max-w-[680px] break-words text-sm leading-relaxed text-[#24344f]"
                >
                    -
                </p>

            </div>

        </div>



        {{-- =========================================================
            RIGHT SIDE DETAILS
        ========================================================== --}}
        <div
            class="grid gap-4 md:grid-cols-2 xl:grid-cols-1 xl:gap-[18px]"
        >


            {{-- Industry --}}
            <article
                class="min-h-[112px] rounded-lg border border-[#dce7f8] bg-white px-5 py-5 sm:px-[30px] sm:py-[26px]"
            >

                <h3
                    class="mb-4 text-[15px] font-bold text-[#061942]"
                >
                    Industry
                </h3>


                <p
                    id="companyIndustry"
                    class="break-words text-sm leading-relaxed text-[#24344f]"
                >
                    -
                </p>

            </article>



            {{-- Address --}}
            <article
                class="min-h-[112px] rounded-lg border border-[#dce7f8] bg-white px-5 py-5 sm:px-[30px] sm:py-[26px]"
            >

                <h3
                    class="mb-4 text-[15px] font-bold text-[#061942]"
                >
                    Address
                </h3>


                <p
                    id="companyAddress"
                    class="break-words text-sm leading-relaxed text-[#24344f]"
                >
                    -
                </p>

            </article>



            {{-- Approval Status --}}
            <article
                class="min-h-[112px] rounded-lg border border-[#dce7f8] bg-white px-5 py-5 sm:px-[30px] sm:py-[26px] md:col-span-2 xl:col-span-1"
            >

                <h3
                    class="mb-4 text-[15px] font-bold text-[#061942]"
                >
                    Approval Status
                </h3>


                <p
                    id="companyApproval"
                    class="text-sm font-bold text-[#24344f]"
                >
                    -
                </p>

            </article>

        </div>

    </div>

</section>

@endsection



@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const loading =
            document.getElementById(
                'profileLoading'
            );

        const emptyProfile =
            document.getElementById(
                'emptyProfile'
            );

        const profileContent =
            document.getElementById(
                'profileContent'
            );


        /*
        |--------------------------------------------------------------------------
        | Token
        |--------------------------------------------------------------------------
        |
        | New authentication key is checked first.
        | Old company-specific keys remain as fallback so collaborator
        | changes and existing sessions both continue to work.
        |
        */

        const token =
            localStorage.getItem(
                'ofc_auth_token'
            ) ||

            localStorage.getItem(
                'onlyfreshers_company_token'
            ) ||

            localStorage.getItem(
                'onlyfreshers_token'
            );


        /*
        |--------------------------------------------------------------------------
        | Stored User
        |--------------------------------------------------------------------------
        */

        function getStoredUser() {

            const keys = [

                'ofc_auth_user',

                'onlyfreshers_company_user',

                'onlyfreshers_user'
            ];


            for (
                const key of keys
            ) {

                try {

                    const value =
                        localStorage.getItem(
                            key
                        );


                    if (value) {

                        const parsed =
                            JSON.parse(
                                value
                            );


                        if (parsed) {
                            return parsed;
                        }
                    }

                } catch (error) {

                    /*
                    | Ignore invalid old localStorage data.
                    */
                }
            }


            return null;
        }


        const storedUser =
            getStoredUser();


        /*
        |--------------------------------------------------------------------------
        | Helpers
        |--------------------------------------------------------------------------
        */

        function valueOrDash(
            value,
            fallback = '-'
        ) {

            if (
                value === null ||
                value === undefined ||
                String(value).trim() === ''
            ) {

                return fallback;
            }


            return value;
        }


        function setText(
            id,
            value,
            fallback = '-'
        ) {

            const element =
                document.getElementById(
                    id
                );


            if (!element) {
                return;
            }


            element.textContent =
                valueOrDash(
                    value,
                    fallback
                );
        }


        function setProfileSelector(
            selector,
            value,
            fallback = '-'
        ) {

            document
                .querySelectorAll(
                    selector
                )
                .forEach(
                    function (element) {

                        element.textContent =
                            valueOrDash(
                                value,
                                fallback
                            );
                    }
                );
        }


        function formatStatus(
            status
        ) {

            const value =
                String(
                    status || 'pending'
                );


            return value
                .replaceAll(
                    '_',
                    ' '
                )
                .replace(
                    /\b\w/g,
                    function (letter) {

                        return letter
                            .toUpperCase();
                    }
                );
        }


        function approvalClass(
            status
        ) {

            const classes = {

                approved:
                    'text-[#138a43]',

                pending:
                    'text-[#b7791f]',

                rejected:
                    'text-[#ff3045]'
            };


            return (
                classes[status] ||
                'text-[#52607a]'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Render Profile
        |--------------------------------------------------------------------------
        */

        function renderProfile(
            profile
        ) {

            const name =
                profile.company_name ||

                storedUser?.name ||

                'Company';


            const email =
                profile.email ||

                storedUser?.email ||

                '-';


            const phone =
                profile.phone ||
                'Not added';


            const website =
                profile.website ||
                'Not added';


            const description =
                profile.description ||
                'Company profile details are not added yet.';


            const industry =
                profile.industry ||
                'Not added';


            const address =
                profile.address ||
                'Not added';


            const status =
                profile.approval_status ||
                'pending';


            const formattedStatus =
                formatStatus(
                    status
                );


            /*
            |--------------------------------------------------------------------------
            | Main Profile
            |--------------------------------------------------------------------------
            */

            setText(
                'companyName',
                name
            );


            setText(
                'companyEmail',
                email
            );


            setText(
                'companyPhone',
                phone
            );


            setText(
                'companyWebsite',
                website
            );


            setText(
                'companyDescription',
                description
            );


            setText(
                'companyIndustry',
                industry
            );


            setText(
                'companyAddress',
                address
            );


            setText(
                'companyApproval',
                formattedStatus
            );


            /*
            |--------------------------------------------------------------------------
            | Compatibility Selectors
            |--------------------------------------------------------------------------
            */

            setProfileSelector(
                '[data-company-profile-name]',
                name
            );


            setProfileSelector(
                '[data-company-profile-email]',
                email
            );


            setProfileSelector(
                '[data-company-profile-phone]',
                phone
            );


            setProfileSelector(
                '[data-company-profile-website]',
                website
            );


            setProfileSelector(
                '[data-company-profile-description]',
                description
            );


            /*
            |--------------------------------------------------------------------------
            | Company Initial
            |--------------------------------------------------------------------------
            */

            const initial =
                String(name)
                    .trim()
                    .charAt(0)
                    .toUpperCase() ||
                'C';


            const companyInitial =
                document.getElementById(
                    'companyInitial'
                );


            if (companyInitial) {

                companyInitial.textContent =
                    initial;
            }


            document
                .querySelectorAll(
                    '[data-company-profile-initial]'
                )
                .forEach(
                    function (element) {

                        element.textContent =
                            initial;
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Approval Status
            |--------------------------------------------------------------------------
            */

            const statusElement =
                document.getElementById(
                    'approvalStatus'
                );


            if (statusElement) {

                statusElement.textContent =
                    `Admin Approval: ${formattedStatus}`;


                statusElement.className =
                    `mt-2 text-xs font-bold ${approvalClass(status)}`;
            }


            /*
            |--------------------------------------------------------------------------
            | Store Profile
            |--------------------------------------------------------------------------
            */

            localStorage.setItem(
                'ofc_company_profile',
                JSON.stringify(
                    profile
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Notify Layout
            |--------------------------------------------------------------------------
            */

            document.dispatchEvent(
                new CustomEvent(
                    'company-profile-loaded',
                    {
                        detail:
                            profile
                    }
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Load Company Profile
        |--------------------------------------------------------------------------
        */

        async function loadCompanyProfile() {

            /*
            | No token = not logged in.
            */

            if (!token) {

                window.location.href =
                    '/company/login';

                return;
            }


            /*
            | API Request
            */

            const response =
                await fetch(
                    '/api/company/profile',
                    {

                        method:
                            'GET',

                        headers: {

                            Accept:
                                'application/json',

                            Authorization:
                                `Bearer ${token}`
                        }
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Unauthorized
            |--------------------------------------------------------------------------
            */

            if (
                response.status === 401 ||
                response.status === 403
            ) {

                localStorage.removeItem(
                    'ofc_auth_token'
                );

                localStorage.removeItem(
                    'ofc_auth_user'
                );

                localStorage.removeItem(
                    'onlyfreshers_company_token'
                );

                localStorage.removeItem(
                    'onlyfreshers_company_user'
                );

                localStorage.removeItem(
                    'onlyfreshers_token'
                );

                localStorage.removeItem(
                    'onlyfreshers_user'
                );


                window.location.href =
                    '/company/login';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Read JSON
            |--------------------------------------------------------------------------
            */

            let result;


            try {

                result =
                    await response.json();

            } catch (error) {

                throw new Error(
                    'Invalid server response.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | API Error
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok ||
                result.success === false
            ) {

                throw new Error(
                    result.message ||
                    'Unable to load company profile.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Profile
            |--------------------------------------------------------------------------
            */

            const profile =
                result?.data?.profile ||

                result?.data?.company_profile ||

                result?.profile ||

                null;


            /*
            | Loading finished
            */

            loading
                ?.classList
                .add(
                    'hidden'
                );


            /*
            |--------------------------------------------------------------------------
            | No Profile Yet
            |--------------------------------------------------------------------------
            */

            if (!profile) {

                emptyProfile
                    ?.classList
                    .remove(
                        'hidden'
                    );


                profileContent
                    ?.classList
                    .add(
                        'hidden'
                    );


                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Render
            |--------------------------------------------------------------------------
            */

            emptyProfile
                ?.classList
                .add(
                    'hidden'
                );


            renderProfile(
                profile
            );


            profileContent
                ?.classList
                .remove(
                    'hidden'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Start
        |--------------------------------------------------------------------------
        */

        loadCompanyProfile()
            .catch(
                function (error) {

                    console.error(
                        'Company profile error:',
                        error
                    );


                    if (loading) {

                        loading.textContent =
                            error.message ||
                            'Unable to load company profile.';


                        loading.className =
                            'rounded-lg border border-[#ffd1d7] bg-[#fff7f8] p-5 text-sm font-bold text-[#ff3045]';
                    }
                }
            );

    }
);

</script>

@endpush
