@php
    $isCompanyAuth = request()->is('company/*');
    $isTrainingPartnerAuth = request()->is('training-partner/*');

    $registerUrl = $isCompanyAuth
        ? '/company/register'
        : ($isTrainingPartnerAuth
            ? '/training-partner/register'
            : '/direct-mode/register');

    $roleLabel = $isCompanyAuth
        ? 'Company'
        : ($isTrainingPartnerAuth
            ? 'Training Partner'
            : 'Direct Mode');

    $pageTitle = $isCompanyAuth
        ? 'Company Login'
        : ($isTrainingPartnerAuth
            ? 'Training Partner Login'
            : 'Direct Mode Login');

    $introText = $isCompanyAuth
        ? 'Login to manage your company profile, post jobs, review applications and hire freshers.'
        : ($isTrainingPartnerAuth
            ? 'Login to manage your institute profile, courses, enrollments, training progress and certificates.'
            : 'Login to continue applying for jobs, tracking applications and building your fresher profile.');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $pageTitle }} - OnlyFreshers</title>

    @include('components.common.auth-storage')
    <script>
        (() => {
            const parseJson = value => {
                try {
                    return JSON.parse(value || 'null');
                } catch (error) {
                    return null;
                }
            };
            const sessions = [
                {
                    role: 'company',
                    token: localStorage.getItem('ofc_company_token') || localStorage.getItem('onlyfreshers_company_token'),
                    user: parseJson(localStorage.getItem('ofc_company_user')) || parseJson(localStorage.getItem('onlyfreshers_company_user')),
                    url: '/company/dashboard',
                },
                {
                    role: 'training_partner',
                    token: localStorage.getItem('ofc_training_partner_token'),
                    user: parseJson(localStorage.getItem('ofc_training_partner_user')),
                    url: '/training-partner/dashboard',
                },
                {
                    role: 'fresher',
                    token: localStorage.getItem('ofc_fresher_token') || localStorage.getItem('onlyfreshers_token'),
                    user: parseJson(localStorage.getItem('ofc_fresher_user')) || parseJson(localStorage.getItem('onlyfreshers_user')),
                    url: '/direct-mode/dashboard',
                },
            ];
            const sharedToken = localStorage.getItem('ofc_auth_token');
            const sharedUser = parseJson(localStorage.getItem('ofc_auth_user'));
            const activeSession = sessions.find(item => item.token && item.user?.role === item.role) ||
                (sharedToken && sharedUser ? sessions.find(item => item.role === sharedUser.role) : null);

            if (activeSession) {
                window.location.replace(activeSession.url);
            }
        })();
    </script>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            overflow-x: hidden;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #071849;
            background: #ffffff;
            font-weight: 500;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .page {
            min-height: 100vh;
            background: linear-gradient(
                135deg,
                #ffffff,
                #f7fbff
            );

            display: grid;
            grid-template-rows: auto 1fr auto;
        }


        /* Header */

        .topbar {
            height: 86px;
            border-bottom: 1px solid #dbe5f5;
            background: rgba(255, 255, 255, .90);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 36px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
        }

        .logo img {
            width: 255px;
            max-height: 58px;
            object-fit: contain;
            object-position: left center;
        }

        .logo-fallback {
            display: none;
            align-items: center;
            gap: 12px;

            color: #075fe4;
            font-size: 24px;
            font-weight: 900;
        }

        .logo-fallback b {
            display: grid;
            place-items: center;

            width: 44px;
            height: 44px;

            border-radius: 12px;

            background: #075fe4;
            color: #ffffff;

            font-size: 17px;
        }

        .role-badge {
            border: 1px solid #dbe5f5;
            border-radius: 8px;

            background: #f5f9ff;
            color: #075fe4;

            padding: 9px 14px;

            font-size: 12px;
            font-weight: 900;
        }


        /* Main */

        .main-wrap {
            width: 100%;
            max-width: 1320px;

            margin: 0 auto;

            padding: 42px 28px 28px;
        }

        .auth-card {
            min-height: 630px;

            border: 1px solid #d9e5f7;
            border-radius: 18px;

            background: #ffffff;

            box-shadow:
                0 18px 44px rgba(6, 25, 66, .08);

            display: grid;

            grid-template-columns:
                minmax(420px, 43%)
                minmax(0, 57%);

            overflow: hidden;
        }


        /* Left */

        .intro {
            position: relative;
            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #f5f9ff,
                    #eef6ff
                );

            padding: 34px 46px 26px;
        }

        .intro::before,
        .intro::after {
            content: "";

            position: absolute;

            border-radius: 999px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .58
                );
        }

        .intro::before {
            width: 140px;
            height: 140px;

            right: -45px;
            top: 36px;
        }

        .intro::after {
            width: 235px;
            height: 235px;

            right: -58px;
            bottom: 85px;

            background:
                rgba(
                    218,
                    235,
                    255,
                    .72
                );
        }

        .intro-content {
            position: relative;
            z-index: 2;
        }

        .intro h1 {
            margin: 0 0 13px;

            font-size: 31px;
            line-height: 1.28;

            font-weight: 900;
        }

        .intro h1 span {
            display: block;
            color: #075fe4;
        }

        .intro p {
            margin: 0;

            max-width: 430px;

            color: #40527d;

            font-size: 15px;
            line-height: 1.55;
        }

        .illustration {
            position: absolute;

            z-index: 1;

            left: 44px;
            right: 32px;
            bottom: 20px;

            height: 340px;

            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .illustration img {
            max-width: 520px;
            width: 100%;
            height: 100%;

            object-fit: contain;
            object-position: center bottom;
        }


        /* Right */

        .form-side {
            padding: 48px 52px;

            display: flex;
            align-items: center;
        }

        .form-shell {
            width: 100%;
            max-width: 600px;

            margin: 0 auto;
        }

        .form-shell h2 {
            margin: 0 0 10px;

            font-size: 25px;
            line-height: 1.2;

            font-weight: 900;
        }

        .form-shell > p {
            margin: 0 0 34px;

            color: #566891;
            font-size: 15px;
        }


        /* Tabs */

        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;

            height: 56px;

            border: 1px solid #d8e2f4;
            border-radius: 7px;

            overflow: hidden;

            margin-bottom: 36px;
        }

        .tab {
            border: 0;

            background: #ffffff;
            color: #4c5d83;

            font-size: 14px;
            font-weight: 900;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            cursor: pointer;
        }

        .tab.active {
            color: #075fe4;
            border-bottom: 3px solid #075fe4;
        }


        /* Alert */

        .login-alert {
            display: none;

            margin: -14px 0 18px;

            border: 1px solid #ffc9d2;
            border-radius: 8px;

            background: #fff1f3;

            color: #c8102e;

            padding: 11px 14px;

            font-size: 13px;
            font-weight: 800;
            line-height: 1.45;
        }

        .login-alert.show {
            display: block;
        }

        .login-alert.success {
            border-color: #b9e7c9;

            background: #f1fff5;

            color: #138a43;
        }


        /* Fields */

        .field {
            margin-bottom: 22px;
        }

        label {
            display: block;

            margin-bottom: 10px;

            font-size: 13px;
            font-weight: 900;
        }

        .control {
            height: 54px;

            border: 1px solid #d4def0;
            border-radius: 8px;

            background: #ffffff;

            display: grid;
            grid-template-columns: 50px 1fr;

            align-items: center;

            overflow: hidden;
        }

        .control:focus-within {
            border-color: #075fe4;

            box-shadow:
                0 0 0 3px rgba(7, 95, 228, .08);
        }

        .control.password {
            grid-template-columns:
                50px 1fr 50px;
        }

        .input-icon {
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #657493;
        }

        .input-icon svg {
            width: 21px;
            height: 21px;

            fill: none;
            stroke: currentColor;
            stroke-width: 2;

            stroke-linecap: round;
            stroke-linejoin: round;
        }

        input {
            width: 100%;
            height: 100%;

            border: 0;
            outline: 0;

            background: transparent;

            color: #071849;

            font-size: 14px;

            padding: 0 8px;
        }

        input::placeholder {
            color: #7d8caf;
        }

        .eye {
            height: 100%;

            border: 0;

            background: transparent;

            color: #657493;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;
        }

        .eye svg {
            width: 22px;
            height: 22px;

            fill: none;
            stroke: currentColor;

            stroke-width: 2;

            stroke-linecap: round;
            stroke-linejoin: round;
        }


        /* Options */

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin: -2px 0 24px;

            color: #4a5c83;

            font-size: 14px;
        }

        .row label {
            margin: 0;

            display: flex;
            align-items: center;

            gap: 10px;

            font-weight: 500;
        }

        .row input {
            width: 17px;
            height: 17px;
        }

        .row a {
            color: #075fe4;
            font-weight: 800;
        }


        /* Button */

        .primary {
            width: 100%;
            height: 50px;

            border: 0;
            border-radius: 8px;

            background: #075fe4;
            color: #ffffff;

            font-size: 16px;
            font-weight: 900;

            cursor: pointer;

            box-shadow:
                0 10px 20px
                rgba(7, 95, 228, .18);
        }

        .primary:disabled {
            opacity: .7;
            cursor: not-allowed;
        }


        /* Social */

        .divider {
            display: flex;
            align-items: center;

            gap: 24px;

            margin: 30px 0 20px;

            color: #5d6d90;

            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: "";

            height: 1px;

            background: #dfe6f2;

            flex: 1;
        }

        .social-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;
        }

        .social {
            height: 54px;

            border: 1px solid #d8e2f4;
            border-radius: 8px;

            background: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 12px;

            font-size: 14px;
            font-weight: 900;

            cursor: pointer;
        }

        .google span {
            color: #ea4335;
        }

        .linkedin span {
            display: grid;
            place-items: center;

            width: 20px;
            height: 20px;

            border-radius: 3px;

            background: #0a66c2;
            color: #ffffff;

            font-size: 15px;
        }

        .facebook span {
            display: grid;
            place-items: center;

            width: 22px;
            height: 22px;

            border-radius: 50%;

            background: #1877f2;
            color: #ffffff;

            font-size: 16px;
        }


        /* Security */

        .safe-note {
            margin-top: 34px;

            min-height: 52px;

            border-radius: 8px;

            background: #eef5ff;

            color: #41527d;

            display: flex;
            align-items: center;

            gap: 13px;

            padding: 13px 16px;

            font-size: 13px;
        }


        /* Footer */

        .footer {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 26px;

            flex-wrap: wrap;

            color: #526283;

            font-size: 13px;

            padding: 15px 20px 26px;
        }

        .footer span {
            color: #9aa8bf;
        }


        /* Responsive */

        @media (max-width: 1050px) {

            .auth-card {
                grid-template-columns: 1fr;
            }

            .intro {
                min-height: 500px;
            }

            .form-side {
                padding: 38px 32px;
            }
        }

        @media (max-width: 720px) {

            .topbar {
                height: auto;
                padding: 20px;
            }

            .logo img {
                width: 220px;
            }

            .role-badge {
                display: none;
            }

            .main-wrap {
                padding: 24px 14px;
            }

            .auth-card {
                border-radius: 14px;
            }

            .intro {
                min-height: 420px;
                padding: 28px 22px;
            }

            .intro h1 {
                font-size: 27px;
            }

            .illustration {
                left: 18px;
                right: 18px;

                height: 260px;
            }

            .form-side {
                padding: 30px 18px;
            }

            .tabs {
                margin-bottom: 24px;
            }

            .social-grid {
                grid-template-columns: 1fr;
            }

            .row {
                align-items: flex-start;
                flex-direction: column;
            }

            .footer {
                gap: 14px;
            }
        }

        .topbar,
        .footer,
        .role-badge,
        .divider,
        .social-grid,
        .safe-note {
            display: none;
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-rows: 1fr;
            background: radial-gradient(circle at 34% 58%, rgba(7, 95, 228, .08) 0 260px, transparent 261px), linear-gradient(130deg, #ffffff, #dfeeff);
        }

        .main-wrap {
            max-width: none;
            padding: 18px 46px;
            display: flex;
            align-items: center;
        }

        .auth-card {
            width: 100%;
            min-height: calc(100vh - 36px);
            border: 0;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            grid-template-columns: 1fr 1.08fr;
            gap: 34px;
            overflow: visible;
        }

        .intro {
            min-height: 540px;
            padding: 28px 0 0;
            background: transparent;
        }

        .intro::before,
        .intro::after {
            display: none;
        }

        .intro-content::before {
            content: "";
            display: block;
            width: 245px;
            height: 70px;
            margin-bottom: 62px;
            background: url('/ofclogo1.svg') left center / contain no-repeat;
        }

        .intro h1 {
            max-width: 520px;
            margin-bottom: 16px;
            color: #061942;
            font-size: 46px;
            line-height: 1.12;
            font-weight: 600;
        }

        .intro h1 span {
            color: #075fe4;
        }

        .intro p {
            max-width: 610px;
            color: #34445e;
            font-size: 20px;
            line-height: 1.45;
        }

        .intro p::after {
            content: "";
            display: block;
            width: 58px;
            height: 3px;
            margin-top: 22px;
            border-radius: 999px;
            background: #075fe4;
        }

        .illustration {
            left: 0;
            right: 0;
            bottom: 18px;
            height: 270px;
            justify-content: flex-start;
        }

        .illustration img {
            width: 430px;
            max-width: 82%;
        }

        .form-side {
            padding: 0;
            justify-content: center;
        }

        .form-shell {
            max-width: 486px;
            min-height: 450px;
            padding: 26px 34px 34px;
            border-radius: 22px;
            background: #ffffff;
            box-shadow: 0 22px 45px rgba(6, 25, 66, .08);
        }

        .form-shell h2 {
            margin: 0;
            text-align: center;
            color: #061942;
            font-size: 28px;
            font-weight: 600;
        }

        .form-shell h2::after {
            content: "";
            display: block;
            width: 58px;
            height: 3px;
            margin: 10px auto 12px;
            border-radius: 999px;
            background: #075fe4;
        }

        .form-shell > p {
            margin: 0 0 24px;
            text-align: center;
            color: #52607a;
            font-size: 15px;
            font-weight: 600;
        }

        .tabs {
            display: none;
        }

        .field {
            margin-bottom: 15px;
        }

        label {
            margin-bottom: 7px;
            color: #061942;
            font-size: 13px;
        }

        .control,
        .control.password {
            height: 46px;
            border-color: #bcd2f2;
            border-radius: 12px;
        }

        .input-icon {
            border-right: 1px solid #dce7f8;
        }

        .primary {
            height: 46px;
            border-radius: 11px;
            font-size: 15px;
            box-shadow: 0 8px 18px rgba(7, 95, 228, .24);
        }

        .switch {
            margin: 16px 0 0;
            text-align: center;
            color: #52607a;
            font-size: 13px;
            font-weight: 600;
        }

        .switch a {
            color: #075fe4;
            font-weight: 800;
        }

        @media (max-width: 1050px) {
            .main-wrap {
                padding: 18px;
            }

            .auth-card {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .intro-content::before {
                width: 220px;
                margin-bottom: 34px;
            }

            .intro h1 {
                font-size: 38px;
            }

            .intro p {
                font-size: 17px;
            }

            .form-shell {
                padding: 28px 22px;
            }
        }

    </style>

</head>


<body>

<main class="page">


    {{-- Header --}}
    <header class="topbar">

        <a
            class="logo"
            href="/"
        >

            <img
                src="/ofclogo1.svg"
                alt="OnlyFreshers Logo"
                onerror="
                    this.style.display='none';
                    this.nextElementSibling.style.display='flex';
                "
            >

            <span class="logo-fallback">
                <b>OF</b>
                OnlyFreshers
            </span>

        </a>


        <div class="role-badge">
            {{ $roleLabel }}
        </div>

    </header>


    {{-- Main --}}
    <div class="main-wrap">

        <section class="auth-card">


            {{-- Intro --}}
            <aside class="intro">

                <div class="intro-content">

                    <h1>
                        Welcome Back to
                        <span>OnlyFreshers</span>
                    </h1>

                    <p>
                        {{ $introText }}
                    </p>

                </div>


                <div class="illustration">

                    <img
                        src="{{ asset('home-hero-students.png') }}"
                        alt="OnlyFreshers students"
                        onerror="this.src='/direct.svg'"
                    >

                </div>

            </aside>


            {{-- Form --}}
            <section class="form-side">

                <div class="form-shell">

                    <h2>
                        Login to Your Account
                    </h2>

                    <p>
                        Enter your credentials to access your account
                    </p>


                    {{-- Tabs --}}
                    <div class="tabs">

                        <button
                            class="tab"
                            type="button"
                            onclick="window.location.href='{{ $registerUrl }}'"
                        >
                            Register
                        </button>


                        <button
                            class="tab active"
                            type="button"
                        >
                            Login
                        </button>

                    </div>


                    {{-- Login Form --}}
                    <form
                        id="loginForm"
                        data-company-auth="{{ $isCompanyAuth ? '1' : '0' }}"
                        data-training-partner-auth="{{ $isTrainingPartnerAuth ? '1' : '0' }}"
                    >


                        {{-- Alert --}}
                        <div
                            id="loginAlert"
                            class="login-alert"
                            role="alert"
                        ></div>


                        {{-- Email --}}
                        <div class="field">

                            <label for="email">
                                Email Address
                            </label>


                            <div class="control">

                                <span
                                    class="input-icon"
                                    data-icon="mail"
                                ></span>


                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="Enter your email address"
                                    autocomplete="email"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Password --}}
                        <div class="field">

                            <label for="password">
                                Password
                            </label>


                            <div class="control password">

                                <span
                                    class="input-icon"
                                    data-icon="lock"
                                ></span>


                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    required
                                >


                                <button
                                    class="eye"
                                    type="button"
                                    data-toggle-password
                                    aria-label="Show password"
                                >

                                    <span data-icon="eye"></span>

                                </button>

                            </div>

                        </div>


                        {{-- Remember --}}
                        <div class="row">

                            <label>

                                <input
                                    type="checkbox"
                                    id="rememberMe"
                                >

                                Remember me

                            </label>


                            <a href="#">
                                Forgot Password?
                            </a>

                        </div>


                        {{-- Login Button --}}
                        <button
                            class="primary"
                            type="submit"
                            id="loginButton"
                        >
                            Login
                        </button>

                        <p class="switch">
                            Don't have an account?
                            <a href="{{ $registerUrl }}">Register</a>
                        </p>

                    </form>

                </div>

            </section>

        </section>

    </div>


    {{-- Footer --}}
    <footer class="footer">

        <p>
            &copy; {{ date('Y') }} OnlyFreshers.
            All rights reserved.
        </p>

        <span>|</span>

        <a href="#">
            Privacy Policy
        </a>

        <span>|</span>

        <a href="#">
            Terms & Conditions
        </a>

        <span>|</span>

        <a href="#">
            Contact Us
        </a>

    </footer>

</main>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Icons
        |--------------------------------------------------------------------------
        */

        const icons = {

            mail: `
                <svg viewBox="0 0 24 24">
                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="14"
                        rx="2"
                    ></rect>

                    <path d="m3 7 9 6 9-6"></path>
                </svg>
            `,

            lock: `
                <svg viewBox="0 0 24 24">
                    <rect
                        x="5"
                        y="11"
                        width="14"
                        height="10"
                        rx="2"
                    ></rect>

                    <path d="M8 11V7a4 4 0 0 1 8 0v4"></path>
                </svg>
            `,

            eye: `
                <svg viewBox="0 0 24 24">
                    <path
                        d="M2 12s3.5-7 10-7
                           10 7 10 7
                           -3.5 7-10 7
                           -10-7-10-7Z"
                    ></path>

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                    ></circle>
                </svg>
            `
        };


        document
            .querySelectorAll('[data-icon]')
            .forEach(
                function (item) {

                    item.innerHTML =
                        icons[item.dataset.icon] || '';
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const loginForm =
            document.getElementById('loginForm');

        const loginButton =
            document.getElementById('loginButton');

        const loginAlert =
            document.getElementById('loginAlert');

        const emailInput =
            document.getElementById('email');

        const passwordInput =
            document.getElementById('password');


        /*
        |--------------------------------------------------------------------------
        | Password Toggle
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '[data-toggle-password]'
            )
            .forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const input =
                                button
                                    .parentElement
                                    .querySelector(
                                        'input'
                                    );


                            input.type =
                                input.type ===
                                'password'
                                    ? 'text'
                                    : 'password';
                        }
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

        function showMessage(
            message,
            type = 'error'
        ) {

            loginAlert.textContent =
                message;


            loginAlert.className =
                type === 'success'
                    ? 'login-alert show success'
                    : 'login-alert show';
        }


        function clearMessage() {

            loginAlert.textContent =
                '';

            loginAlert.className =
                'login-alert';
        }


        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        loginForm.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                clearMessage();


                const email =
                    emailInput.value.trim();

                const password =
                    passwordInput.value;


                if (
                    !email ||
                    !password
                ) {

                    showMessage(
                        'Email and password are required.'
                    );

                    return;
                }


                loginButton.disabled =
                    true;

                loginButton.textContent =
                    'Logging in...';


                try {

                    /*
                    | Login API
                    */

                    const response =
                        await fetch(
                            '/api/auth/login',
                            {
                                method: 'POST',

                                headers: {

                                    Accept:
                                        'application/json',

                                    'Content-Type':
                                        'application/json'
                                },

                                body:
                                    JSON.stringify({
                                        email,
                                        password
                                    })
                            }
                        );


                    /*
                    | Parse Response
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
                    | API Error
                    */

                    if (
                        !response.ok ||
                        result.success === false
                    ) {

                        throw new Error(
                            result.message ||
                            'Login failed.'
                        );
                    }


                    const token =
                        result?.data?.token;


                    const user =
                        result?.data?.user;


                    if (
                        !token ||
                        !user
                    ) {

                        throw new Error(
                            'Login response is incomplete.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Role Validation
                    |--------------------------------------------------------------------------
                    */

                    if (
                        loginForm
                            .dataset
                            .companyAuth ===
                            '1' &&
                        user.role !==
                            'company'
                    ) {

                        throw new Error(
                            'Please login with a company account.'
                        );
                    }


                    if (
                        loginForm
                            .dataset
                            .trainingPartnerAuth ===
                            '1' &&
                        user.role !==
                            'training_partner'
                    ) {

                        throw new Error(
                            'Please login with a training partner account.'
                        );
                    }


                    if (
                        loginForm
                            .dataset
                            .companyAuth !==
                            '1' &&
                        loginForm
                            .dataset
                            .trainingPartnerAuth !==
                            '1' &&
                        user.role !==
                            'fresher'
                    ) {

                        throw new Error(
                            'Please login with a fresher account.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Save Authentication
                    |--------------------------------------------------------------------------
                    */

                    const saveSharedAuth = () => {
                        localStorage.setItem('ofc_auth_token', token);
                        localStorage.setItem('ofc_auth_user', JSON.stringify(user));
                    };


                    /*
                    | Company-specific compatibility
                    */

                    if (
                        user.role ===
                        'company'
                    ) {

                        localStorage.setItem(
                            'ofc_company_token',
                            token
                        );

                        localStorage.setItem(
                            'ofc_company_user',
                            JSON.stringify(user)
                        );

                        localStorage.setItem(
                            'onlyfreshers_company_token',
                            token
                        );


                        localStorage.setItem(
                            'onlyfreshers_company_user',
                            JSON.stringify(user)
                        );

                        saveSharedAuth();
                    }


                    /*
                    | Fresher-specific compatibility
                    */

                    if (
                        user.role ===
                        'fresher'
                    ) {

                        localStorage.setItem(
                            'ofc_fresher_token',
                            token
                        );

                        localStorage.setItem(
                            'ofc_fresher_user',
                            JSON.stringify(user)
                        );

                        localStorage.setItem(
                            'onlyfreshers_token',
                            token
                        );

                        localStorage.setItem(
                            'onlyfreshers_user',
                            JSON.stringify(user)
                        );

                        saveSharedAuth();
                    }


                    /*
                    | Training-partner-specific compatibility
                    */

                    if (
                        user.role ===
                        'training_partner'
                    ) {

                        localStorage.setItem(
                            'ofc_training_partner_token',
                            token
                        );

                        localStorage.setItem(
                            'ofc_training_partner_user',
                            JSON.stringify(user)
                        );

                        saveSharedAuth();
                    }


                    showMessage(
                        'Login successful. Redirecting...',
                        'success'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Company
                    |--------------------------------------------------------------------------
                    */

                    if (
                        user.role ===
                        'company'
                    ) {

                        window.location.href =
                            '/company/profile';

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Training Partner
                    |--------------------------------------------------------------------------
                    */

                    if (
                        user.role ===
                        'training_partner'
                    ) {

                        const profileResponse =
                            await fetch(
                                '/api/training-partner/profile',
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


                        if (
                            profileResponse.status ===
                            401 ||
                            profileResponse.status ===
                            403
                        ) {

                            throw new Error(
                                'Unable to verify training partner profile.'
                            );
                        }


                        let profileResult;

                        try {

                            profileResult =
                                await profileResponse
                                    .json();

                        } catch (error) {

                            throw new Error(
                                'Invalid training partner profile response.'
                            );
                        }


                        const profile =
                            profileResult
                                ?.data
                                ?.profile ||

                            profileResult
                                ?.data
                                ?.training_partner_profile ||

                            null;


                        localStorage.setItem(
                            'ofc_training_partner_profile',
                            JSON.stringify(profile)
                        );


                        /*
                        | No profile
                        */

                        if (!profile) {

                            window.location.href =
                                '/training-partner/profile/edit';

                            return;
                        }


                        /*
                        | Approved
                        */

                        if (
                            profile
                                .approval_status ===
                            'approved'
                        ) {

                            window.location.href =
                                '/training-partner/dashboard';

                            return;
                        }


                        /*
                        | Rejected
                        */

                        if (
                            profile
                                .approval_status ===
                            'rejected'
                        ) {

                            window.location.href =
                                '/training-partner/approval/rejected';

                            return;
                        }


                        /*
                        | Pending
                        */

                        window.location.href =
                            '/training-partner/approval/pending';

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Fresher / Direct Mode
                    |--------------------------------------------------------------------------
                    */

                    const dashboardResponse =
                        await fetch(
                            '/api/fresher/dashboard',
                            {
                                headers: {
                                    Accept:
                                        'application/json',

                                    Authorization:
                                        `Bearer ${token}`
                                }
                            }
                        );


                    const dashboardPayload =
                        await dashboardResponse
                            .json()
                            .catch(
                                function () {
                                    return {};
                                }
                            );


                    const assessment =
                        dashboardPayload
                            ?.data
                            ?.initial_assessment;


                    if (
                        !dashboardResponse.ok
                    ) {

                        window.location.href =
                            '/direct-mode/flow-selection';

                        return;
                    }


                    if (
                        !assessment ||
                        assessment.status !==
                            'submitted'
                    ) {

                        localStorage.removeItem(
                            'onlyfreshers_selected_mode'
                        );

                        window.location.href =
                            '/direct-mode/flow-selection';

                        return;
                    }


                    const selectedMode =
                        localStorage.getItem(
                            'onlyfreshers_selected_mode'
                        );


                    if (
                        assessment.recommended_mode ===
                        'fast_track'
                    ) {

                        localStorage.setItem(
                            'onlyfreshers_selected_mode',
                            'fast_track'
                        );


                        window.location.href =
                            '/fast-track/dashboard';

                        return;
                    }


                    if (
                        selectedMode ===
                        'fast_track'
                    ) {

                        window.location.href =
                            '/fast-track/dashboard';

                        return;
                    }


                    if (
                        selectedMode !==
                        'direct'
                    ) {

                        window.location.href =
                            '/direct-mode/flow-selection';

                        return;
                    }


                    window.location.href =
                        '/direct-mode/dashboard';


                } catch (error) {

                    console.error(
                        'Login error:',
                        error
                    );


                    showMessage(
                        error.message ||
                        'Something went wrong.'
                    );


                } finally {

                    loginButton.disabled =
                        false;

                    loginButton.textContent =
                        'Login';
                }
            }
        );

    }
);

</script>

</body>
</html>
