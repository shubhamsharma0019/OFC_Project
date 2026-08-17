@php
    $isCompanyAuth = request()->is('company/*');
    $isTrainingPartnerAuth = request()->is('training-partner/*');

    $loginUrl = $isCompanyAuth
        ? '/company/login'
        : ($isTrainingPartnerAuth
            ? '/training-partner/login'
            : '/direct-mode/login');

    $roleLabel = $isCompanyAuth
        ? 'Company'
        : ($isTrainingPartnerAuth
            ? 'Training Partner'
            : 'Direct Mode');

    $pageTitle = $isCompanyAuth
        ? 'Company Register'
        : ($isTrainingPartnerAuth
            ? 'Training Partner Register'
            : 'Direct Mode Register');

    $registerRole = $isCompanyAuth
        ? 'company'
        : ($isTrainingPartnerAuth
            ? 'training_partner'
            : 'fresher');

    $nameLabel = $isCompanyAuth
        ? 'Company / Contact Name'
        : ($isTrainingPartnerAuth
            ? 'Institute / Contact Name'
            : 'Full Name');

    $secondaryLabel = $isTrainingPartnerAuth
        ? 'Institute Type'
        : ($isCompanyAuth
            ? 'Industry'
            : 'Qualification');

    $secondaryPlaceholder = $isTrainingPartnerAuth
        ? 'Enter institute type'
        : ($isCompanyAuth
            ? 'Enter industry'
            : 'Enter qualification');

    $categoryLabel = $isTrainingPartnerAuth
        ? 'Training Category'
        : ($isCompanyAuth
            ? 'Hiring Category'
            : 'Interested Role');

    $categoryPlaceholder = $isTrainingPartnerAuth
        ? 'Select training category'
        : ($isCompanyAuth
            ? 'Select hiring category'
            : 'Select interested role');

    $introTitle = $isCompanyAuth
        ? 'Hire Freshers with'
        : ($isTrainingPartnerAuth
            ? 'Train Freshers with'
            : 'Start Your Career with');

    $introText = $isCompanyAuth
        ? 'Create your company account, complete your profile, get admin approval and start posting fresher jobs.'
        : ($isTrainingPartnerAuth
            ? 'Create your training partner account, complete institute verification, publish courses and manage enrollments.'
            : 'Create your fresher profile, apply directly to verified jobs and track every application from one place.');

    $features = [
        [
            'title' => 'Verified Jobs',
            'text' => 'Apply to trusted fresher openings',
            'icon' => 'shield'
        ],
        [
            'title' => 'Direct Applications',
            'text' => 'Connect with companies faster',
            'icon' => 'send'
        ],
        [
            'title' => 'Profile Reviews',
            'text' => 'Showcase your resume and skills',
            'icon' => 'file'
        ],
        [
            'title' => 'Career Growth',
            'text' => 'Track applications in one place',
            'icon' => 'trend'
        ],
    ];
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
            display: grid;
            grid-template-rows: auto minmax(0, 1fr) auto auto;
            gap: 14px;
            padding: 18px 22px 12px;
            background: linear-gradient(
                135deg,
                #ffffff,
                #f4f8ff
            );
        }

        /* Header */

        .topbar {
            min-height: 52px;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 205px;
            max-height: 48px;
            display: block;
            object-fit: contain;
            object-position: left center;
        }

        .logo-fallback {
            display: none;
            align-items: center;
            gap: 10px;
            color: #075fe4;
            font-size: 22px;
            font-weight: 800;
        }

        .logo-fallback b {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #075fe4;
            color: #ffffff;
            font-size: 16px;
        }

        .role-badge {
            border: 1px solid #d8e4fb;
            border-radius: 7px;
            background: #f4f8ff;
            color: #075fe4;
            padding: 8px 13px;
            font-size: 11px;
            font-weight: 800;
        }

        /* Main */

        .auth-card {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            border: 1px solid #d8e4fb;
            border-radius: 8px;
            background: #ffffff;
            box-shadow:
                0 14px 34px
                rgba(6, 25, 66, .08);
            display: grid;
            grid-template-columns:
                minmax(360px, 39%)
                minmax(0, 1fr);
            overflow: hidden;
        }

        /* Intro */

        .intro {
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 32px 40px;
            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f6f9ff
                );
        }

        .intro h1 {
            max-width: 430px;
            margin: 0 0 14px;
            font-size: 28px;
            line-height: 1.3;
            font-weight: 800;
        }

        .intro h1 span {
            color: #075fe4;
        }

        .intro p {
            margin: 0;
            color: #41527d;
            font-size: 13px;
            line-height: 1.6;
            max-width: 420px;
        }

        .illustration {
            min-height: 0;
            margin-top: 18px;
            display: flex;
            justify-content: center;
        }

        .illustration img {
            width: min(360px, 100%);
            height: 270px;
            object-fit: contain;
            object-position: center bottom;
        }

        /* Form */

        .form-wrap {
            min-width: 0;
            padding: 18px 28px;
            display: flex;
            align-items: center;
        }

        .form-panel {
            min-width: 0;
            width: 100%;
            border: 1px solid #dfe6f5;
            border-radius: 8px;
            padding: 18px 20px;
            background: #ffffff;
        }

        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid #dfe6f5;
            margin-bottom: 16px;
        }

        .tab {
            height: 36px;
            border: 0;
            background: transparent;
            color: #657190;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
        }

        .tab.active {
            color: #075fe4;
            border-bottom:
                3px solid #075fe4;
        }

        /* Form Grid */

        .grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 14px 20px;
        }

        .field {
            min-width: 0;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 11px;
            font-weight: 800;
        }

        label span.required {
            color: #ff2036;
        }

        .control {
            min-width: 0;
            height: 38px;
            border: 1px solid #cfd8eb;
            border-radius: 6px;
            display: grid;
            grid-template-columns:
                42px 1fr;
            align-items: center;
            background: #ffffff;
            overflow: hidden;
        }

        .control:focus-within {
            border-color: #075fe4;
            box-shadow:
                0 0 0 3px
                rgba(7, 95, 228, .08);
        }

        .control.invalid {
            border-color: #ff8da0;
            background: #fff9fa;
        }

        .control.password {
            grid-template-columns:
                42px 1fr 42px;
        }

        .control.select-control {
            grid-template-columns:
                1fr 44px;
        }

        .input-icon {
            height: 100%;
            border-right:
                1px solid #dfe6f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #657190;
        }

        .select-control .input-icon {
            border-right: 0;
            border-left: 1px solid #dfe6f5;
        }

        .input-icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        input,
        select {
            min-width: 0;
            width: 100%;
            height: 100%;
            border: 0;
            outline: 0;
            padding: 0 12px;
            font-size: 12px;
            color: #071849;
            background: transparent;
        }

        input::placeholder {
            color: #6e7da2;
        }

        .eye {
            height: 100%;
            border: 0;
            background: transparent;
            color: #657190;
            cursor: pointer;
            font-size: 11px;
        }

        /* Errors */

        .form-alert {
            display: none;
            margin: 0 0 14px;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.45;
        }

        .form-alert.error {
            display: block;
            background: #fff1f2;
            color: #c8102e;
            border:
                1px solid #ffd0d7;
        }

        .form-alert.success {
            display: block;
            background: #ecfdf3;
            color: #087443;
            border:
                1px solid #baf0ce;
        }

        .field-error {
            min-height: 14px;
            margin-top: 4px;
            color: #c8102e;
            font-size: 10px;
            font-weight: 700;
        }

        /* Terms */

        .terms {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin: 12px 0 3px;
            font-size: 11px;
            color: #41527d;
        }

        .terms input {
            width: 16px;
            height: 16px;
            flex: 0 0 auto;
        }

        .terms span {
            line-height: 1.4;
        }

        .terms a {
            color: #075fe4;
            font-weight: 800;
        }

        /* Buttons */

        .primary {
            width: 100%;
            height: 38px;
            margin-top: 6px;
            border: 0;
            border-radius: 6px;
            background: #075fe4;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        .primary:disabled {
            opacity: .7;
            cursor: not-allowed;
        }

        /* Google */

        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 14px auto 12px;
            max-width: 260px;
            color: #657190;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            background: #e3e8f4;
            flex: 1;
        }

        .google {
            height: 36px;
            width: 46%;
            min-width: 240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border:
                1px solid #d2dbea;
            border-radius: 6px;
            background: #ffffff;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .google span {
            color: #ea4335;
            font-size: 16px;
        }

        .switch {
            text-align: center;
            margin: 12px 0 0;
            color: #657190;
            font-size: 11px;
        }

        .switch a {
            color: #075fe4;
            font-weight: 800;
        }

        /* Features */

        .feature-bar {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            border:
                1px solid #dfe6f5;
            border-radius: 8px;
            background: #ffffff;
            display: grid;
            grid-template-columns:
                repeat(4, minmax(0, 1fr));
            padding: 12px 18px;
        }

        .feature {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 16px;
            border-right:
                1px solid #eef2f8;
        }

        .feature:last-child {
            border-right: 0;
        }

        .feature .icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: #edf4ff;
            color: #075fe4;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .icon svg {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .feature div {
            min-width: 0;
        }

        .feature h3 {
            margin: 0 0 4px;
            font-size: 12px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .feature p {
            margin: 0;
            color: #41527d;
            font-size: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copyright {
            text-align: center;
            color: #41527d;
            font-size: 10px;
            margin: 0;
        }

        /* Responsive */

        @media (max-width: 1120px) {

            .page {
                display: block;
            }

            .topbar {
                margin-bottom: 14px;
            }

            .auth-card {
                grid-template-columns:
                    1fr;
            }

            .intro {
                padding: 26px 28px;
            }

            .illustration img {
                height: 230px;
            }

            .feature-bar {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
                margin-top: 14px;
            }

            .feature {
                padding: 8px 10px;
            }

            .feature:nth-child(2n) {
                border-right: 0;
            }
        }

        @media (max-width: 760px) {

            .page {
                padding: 14px;
            }

            .topbar {
                align-items: flex-start;
            }

            .role-badge {
                display: none;
            }

            .intro {
                padding: 22px;
            }

            .intro h1 {
                font-size: 24px;
            }

            .illustration img {
                height: 190px;
            }

            .form-wrap {
                padding: 14px;
            }

            .form-panel {
                padding: 16px;
            }

            .grid {
                grid-template-columns:
                    1fr;
            }

            .feature-bar {
                grid-template-columns:
                    1fr;
            }

            .feature {
                border-right: 0;
                border-bottom:
                    1px solid #eef2f8;
            }

            .feature:last-child {
                border-bottom: 0;
            }

            .google {
                width: 100%;
                min-width: 0;
            }
        }

        .topbar,
        .role-badge,
        .feature-bar,
        .copyright,
        .divider,
        .google {
            display: none;
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-rows: 1fr;
            gap: 0;
            padding: 18px 46px;
            background:
                radial-gradient(
                    circle at 34% 58%,
                    rgba(7, 95, 228, .08) 0 260px,
                    transparent 261px
                ),
                linear-gradient(
                    130deg,
                    #ffffff,
                    #dfeeff
                );
        }

        .auth-card {
            max-width: none;
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
            justify-content: flex-start;
            background: transparent;
        }

        .intro::before {
            content: "";
            display: block;
            width: 245px;
            height: 70px;
            margin-bottom: 62px;
            background:
                url('/build/assets/ofclogo1.png')
                left center / contain no-repeat;
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
            display: block;
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
            margin-top: 24px;
            justify-content: flex-start;
        }

        .illustration img {
            width: min(620px, 96%);
            max-width: 96%;
            height: 310px;
            object-fit: contain;
            object-position: left bottom;
            filter:
                drop-shadow(
                    0 20px 30px
                    rgba(6, 25, 66, .10)
                );
        }

        .form-wrap {
            padding: 0;
            justify-content: center;
        }

        .form-panel {
            max-width: 570px;
            padding: 28px 34px 30px;
            border: 1px solid rgba(207, 224, 255, .82);
            border-radius: 22px;
            background:
                linear-gradient(
                    180deg,
                    rgba(255,255,255,.98),
                    #ffffff
                );
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,.95),
                0 24px 56px rgba(6, 25, 66, .11);
        }

        .tabs {
            display: none;
        }

        .form-panel::before {
            content: "{{ $pageTitle }}";
            display: block;
            text-align: center;
            color: #061942;
            font-size: 25px;
            line-height: 1.1;
            font-weight: 600;
        }

        .form-panel::after {
            content: "";
            display: block;
            width: 48px;
            height: 2px;
            margin: 9px auto 28px;
            border-radius: 999px;
            background: #075fe4;
        }

        .form-panel form {
            margin-top: 0;
        }

        label {
            margin-bottom: 7px;
            color: #061942;
            font-size: 11.5px;
            letter-spacing: .01em;
        }

        .grid {
            gap: 10px 18px;
        }

        .register-role-company .form-panel::after {
            margin-bottom: 30px;
        }

        .control,
        .control.password,
        .control.select-control {
            height: 46px;
            border-color: #c7dafa;
            border-radius: 10px;
            background: #fbfdff;
            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .control:hover,
        .control:focus-within {
            background: #ffffff;
        }

        .control {
            grid-template-columns: 44px 1fr;
        }

        .control.password {
            grid-template-columns: 44px 1fr 44px;
        }

        .control.select-control {
            grid-template-columns: 1fr 44px;
        }

        input,
        select {
            padding: 0 13px;
            font-size: 13px;
        }

        .input-icon {
            border-right: 1px solid #dce7f8;
            color: #647596;
            background: rgba(238, 245, 255, .72);
        }

        .primary {
            margin-top: 10px;
            height: 48px;
            border-radius: 12px;
            font-size: 15px;
            box-shadow:
                0 13px 24px
                rgba(7, 95, 228, .24);
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .primary:hover {
            background: #064fc0;
            box-shadow:
                0 16px 30px
                rgba(7, 95, 228, .28);
            transform: translateY(-1px);
        }

        .switch {
            margin-top: 16px;
            font-size: 13px;
        }

        .terms {
            margin-top: 12px;
            margin-bottom: 2px;
            align-items: center;
            border-radius: 10px;
            background: #f7fbff;
            padding: 10px 12px;
        }

        .field-error {
            min-height: 10px;
            margin-top: 3px;
            font-size: 9.5px;
        }

        @media (max-width: 1120px) {

            .page {
                display: block;
                padding: 18px;
            }

            .auth-card {
                grid-template-columns:
                    1fr;
            }
        }

        @media (max-width: 760px) {

            .intro::before {
                width: 220px;
                margin-bottom: 34px;
            }

            .intro h1 {
                font-size: 38px;
            }

            .intro p {
                font-size: 17px;
            }

            .form-panel {
                padding: 28px 18px;
            }
        }

    </style>

</head>

<body class="register-role-{{ $registerRole }}">

<main class="page">

    {{-- Header --}}
    <header class="topbar">

        <a
            class="logo"
            href="/"
        >

            <img
                src="{{ asset('build/assets/ofclogo1.png') }}?v=2"
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

    {{-- Main Card --}}
    <section class="auth-card">

        {{-- Intro --}}
        <div class="intro">

            <h1>
                {{ $introTitle }}
                <span>OnlyFreshers</span>
            </h1>

            <p>
                {{ $introText }}
            </p>

            <div class="illustration">

                <img
                    src="{{ asset('home-hero-students.png') }}"
                    alt="OnlyFreshers students"
                >

            </div>

        </div>

        {{-- Form Side --}}
        <div class="form-wrap">

            <div class="form-panel">

                {{-- Tabs --}}
                <div class="tabs">

                    <button
                        class="tab"
                        type="button"
                        onclick="window.location.href='{{ $loginUrl }}'"
                    >
                        Login
                    </button>

                    <button
                        class="tab active"
                        type="button"
                    >
                        Register
                    </button>

                </div>

                {{-- Form --}}
                <form
                    id="registerForm"
                    data-role="{{ $registerRole }}"
                    @if ($isCompanyAuth) style="padding-top: 22px;" @endif
                    novalidate
                >

                    {{-- Alert --}}
                    <div
                        id="registerAlert"
                        class="form-alert"
                        role="alert"
                    ></div>

                    <div class="grid">

                        {{-- Name --}}
                        <div class="field">

                            <label>
                                {{ $nameLabel }}
                                <span class="required">*</span>
                            </label>

                            <div class="control">

                                <span
                                    class="input-icon"
                                    data-icon="user"
                                ></span>

                                <input
                                    name="name"
                                    type="text"
                                    placeholder="Enter {{ strtolower($nameLabel) }}"
                                    autocomplete="name"
                                    required
                                >

                            </div>

                            <div
                                class="field-error"
                                data-error-for="name"
                            ></div>

                        </div>

                        {{-- Email --}}
                        <div class="field">

                            <label>
                                Email Address
                                <span class="required">*</span>
                            </label>

                            <div class="control">

                                <span
                                    class="input-icon"
                                    data-icon="mail"
                                ></span>

                                <input
                                    name="email"
                                    type="email"
                                    placeholder="Enter your email"
                                    autocomplete="email"
                                    required
                                >

                            </div>

                            <div
                                class="field-error"
                                data-error-for="email"
                            ></div>

                        </div>

                        {{-- Mobile --}}
                        <div class="field">

                            <label>
                                Mobile Number
                                <span class="required">*</span>
                            </label>

                            <div class="control">

                                <span
                                    class="input-icon"
                                    data-icon="phone"
                                ></span>

                                <input
                                    name="phone"
                                    type="tel"
                                    placeholder="Enter mobile number"
                                    autocomplete="tel"
                                    required
                                >

                            </div>

                            <div
                                class="field-error"
                                data-error-for="phone"
                            ></div>

                        </div>

                        {{-- Qualification / Industry / Type --}}
                        <div class="field">

                            <label>
                                {{ $secondaryLabel }}
                                <span class="required">*</span>
                            </label>

                            <div class="control">

                                <span
                                    class="input-icon"
                                    data-icon="graduation"
                                ></span>

                                <input
                                    name="secondary_field"
                                    type="text"
                                    placeholder="{{ $secondaryPlaceholder }}"
                                    required
                                >

                            </div>

                            <div
                                class="field-error"
                                data-error-for="secondary_field"
                            ></div>

                        </div>

                        {{-- Password --}}
                        <div class="field">

                            <label>
                                Password
                                <span class="required">*</span>
                            </label>

                            <div class="control password">

                                <span
                                    class="input-icon"
                                    data-icon="lock"
                                ></span>

                                <input
                                    name="password"
                                    type="password"
                                    placeholder="Create a password"
                                    autocomplete="new-password"
                                    required
                                    minlength="8"
                                >

                                <button
                                    class="eye"
                                    type="button"
                                    data-toggle-password
                                >
                                    Show
                                </button>

                            </div>

                            <div
                                class="field-error"
                                data-error-for="password"
                            ></div>

                        </div>

                        {{-- Confirm Password --}}
                        <div class="field">

                            <label>
                                Confirm Password
                                <span class="required">*</span>
                            </label>

                            <div class="control password">

                                <span
                                    class="input-icon"
                                    data-icon="lock"
                                ></span>

                                <input
                                    name="password_confirmation"
                                    type="password"
                                    placeholder="Confirm your password"
                                    autocomplete="new-password"
                                    required
                                    minlength="8"
                                >

                                <button
                                    class="eye"
                                    type="button"
                                    data-toggle-password
                                >
                                    Show
                                </button>

                            </div>

                            <div
                                class="field-error"
                                data-error-for="password_confirmation"
                            ></div>

                        </div>

                        {{-- Category --}}
                        <div class="field full">

                            <label>
                                {{ $categoryLabel }}
                                <span class="required">*</span>
                            </label>

                            <div class="control select-control">

                                <select
                                    name="category"
                                    required
                                >

                                    <option value="">
                                        {{ $categoryPlaceholder }}
                                    </option>

                                    <option value="Software Developer">
                                        Software Developer
                                    </option>

                                    <option value="Data Analyst">
                                        Data Analyst
                                    </option>

                                    <option value="UI/UX Designer">
                                        UI/UX Designer
                                    </option>

                                    <option value="Digital Marketing">
                                        Digital Marketing
                                    </option>

                                </select>

                                <span
                                    class="input-icon"
                                    data-icon="chevron"
                                ></span>

                            </div>

                            <div
                                class="field-error"
                                data-error-for="category"
                            ></div>

                        </div>

                    </div>

                    {{-- Terms --}}
                    <label class="terms">

                        <input
                            name="terms"
                            type="checkbox"
                            required
                        >

                        <span>

                            I agree to the

                            <a href="#">
                                Terms & Conditions
                            </a>

                            and

                            <a href="#">
                                Privacy Policy
                            </a>

                        </span>

                    </label>

                    <div
                        class="field-error"
                        data-error-for="terms"
                    ></div>

                    {{-- Submit --}}
                    <button
                        class="primary"
                        type="submit"
                        id="registerButton"
                    >
                        Create Account
                    </button>

                    <p class="switch">

                        Already have an account?

                        <a href="{{ $loginUrl }}">
                            Login
                        </a>

                    </p>

                </form>

            </div>

        </div>

    </section>

    {{-- Features --}}
    <section
        class="feature-bar"
        id="features"
    ></section>

    <p class="copyright">
        &copy; {{ date('Y') }}
        OnlyFreshers.
        All rights reserved.
    </p>

</main>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const icons = {

            shield: `
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"
                    ></path>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
            `,

            send: `
                <svg viewBox="0 0 24 24">
                    <path d="m22 2-7 20-4-9-9-4Z"></path>
                    <path d="M22 2 11 13"></path>
                </svg>
            `,

            file: `
                <svg viewBox="0 0 24 24">
                    <path
                        d="M14 2H6a2 2 0 0 0-2 2v16
                           a2 2 0 0 0 2 2h12
                           a2 2 0 0 0 2-2V8Z"
                    ></path>
                    <path d="M14 2v6h6"></path>
                </svg>
            `,

            trend: `
                <svg viewBox="0 0 24 24">
                    <path d="M3 17 9 11l4 4 8-8"></path>
                    <path d="M14 7h7v7"></path>
                </svg>
            `,

            user: `
                <svg viewBox="0 0 24 24">
                    <path d="M20 21a8 8 0 0 0-16 0"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            `,

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

            phone: `
                <svg viewBox="0 0 24 24">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2
                           A19.8 19.8 0 0 1 3.08 5.18
                           2 2 0 0 1 5.06 3h3
                           a2 2 0 0 1 2 1.72
                           c.12.86.32 1.7.6 2.5
                           a2 2 0 0 1-.45 2.11
                           L9 10.5
                           a16 16 0 0 0 4.5 4.5
                           l1.17-1.17
                           a2 2 0 0 1 2.11-.45
                           c.8.28 1.64.48 2.5.6
                           A2 2 0 0 1 22 16.92Z"
                    ></path>
                </svg>
            `,

            graduation: `
                <svg viewBox="0 0 24 24">
                    <path
                        d="M22 10 12 5 2 10l10 5 10-5Z"
                    ></path>
                    <path
                        d="M6 12v5c3 2 9 2 12 0v-5"
                    ></path>
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
                    <path
                        d="M8 11V7a4 4 0 0 1 8 0v4"
                    ></path>
                </svg>
            `,

            chevron: `
                <svg viewBox="0 0 24 24">
                    <path d="m6 9 6 6 6-6"></path>
                </svg>
            `
        };

        const features = @json($features);

        document
            .getElementById('features')
            .innerHTML =
                features
                    .map(
                        function (item) {

                            return `
                                <article class="feature">

                                    <span class="icon">
                                        ${icons[item.icon] || ''}
                                    </span>

                                    <div>

                                        <h3>
                                            ${item.title}
                                        </h3>

                                        <p>
                                            ${item.text}
                                        </p>

                                    </div>

                                </article>
                            `;
                        }
                    )
                    .join('');

        document
            .querySelectorAll('[data-icon]')
            .forEach(
                function (item) {

                    item.innerHTML =
                        icons[item.dataset.icon] || '';
                }
            );

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

                            button.textContent =
                                input.type ===
                                'password'
                                    ? 'Show'
                                    : 'Hide';
                        }
                    );
                }
            );

        const form =
            document.getElementById(
                'registerForm'
            );

        const alertBox =
            document.getElementById(
                'registerAlert'
            );

        const submitButton =
            document.getElementById(
                'registerButton'
            );

        function setAlert(
            message,
            type = 'error'
        ) {

            alertBox.textContent =
                message || '';

            alertBox.className =
                message
                    ? `form-alert ${type}`
                    : 'form-alert';
        }

        function clearErrors() {

            setAlert('');

            form
                .querySelectorAll(
                    '[data-error-for]'
                )
                .forEach(
                    function (item) {

                        item.textContent =
                            '';
                    }
                );

            form
                .querySelectorAll(
                    '.control.invalid'
                )
                .forEach(
                    function (item) {

                        item.classList
                            .remove('invalid');
                    }
                );
        }

        function setFieldError(
            name,
            message
        ) {

            const error =
                form.querySelector(
                    `[data-error-for="${name}"]`
                );

            const field =
                form.elements[name];

            const control =
                field
                    ?.closest('.control');

            if (error) {

                error.textContent =
                    Array.isArray(message)
                        ? message[0]
                        : message;
            }

            if (control) {

                control
                    .classList
                    .add('invalid');
            }
        }

        function validateForm() {

            const values =
                Object.fromEntries(
                    new FormData(form)
                        .entries()
                );

            let valid =
                true;

            [
                'name',
                'email',
                'phone',
                'secondary_field',
                'password',
                'password_confirmation',
                'category'
            ]
            .forEach(
                function (name) {

                    if (
                        !String(
                            values[name] || ''
                        ).trim()
                    ) {

                        setFieldError(
                            name,
                            'This field is required.'
                        );

                        valid =
                            false;
                    }
                }
            );

            if (
                values.password &&
                values.password.length < 8
            ) {

                setFieldError(
                    'password',
                    'Password must be at least 8 characters.'
                );

                valid =
                    false;
            }

            if (
                values.password &&
                values.password_confirmation &&
                values.password !==
                values.password_confirmation
            ) {

                setFieldError(
                    'password_confirmation',
                    'Password confirmation does not match.'
                );

                valid =
                    false;
            }

            if (
                !form.elements.terms.checked
            ) {

                setFieldError(
                    'terms',
                    'Please accept the terms to continue.'
                );

                valid =
                    false;
            }

            return valid;
        }

        async function postJson(
            url,
            payload,
            token = null
        ) {

            const response =
                await fetch(
                    url,
                    {
                        method: 'POST',

                        headers: {

                            Accept:
                                'application/json',

                            'Content-Type':
                                'application/json',

                            ...(token
                                ? {
                                    Authorization:
                                        `Bearer ${token}`
                                }
                                : {})
                        },

                        body:
                            JSON.stringify(
                                payload
                            )
                    }
                );

            const data =
                await response
                    .json()
                    .catch(
                        function () {

                            return {};
                        }
                    );

            if (
                !response.ok ||
                data.success === false
            ) {

                const error =
                    new Error(
                        data.message ||
                        'Something went wrong. Please try again.'
                    );

                error.payload =
                    data;

                throw error;
            }

            return data;
        }

        form.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();

                clearErrors();

                if (
                    !validateForm()
                ) {

                    setAlert(
                        'Please fix the highlighted fields.'
                    );

                    return;
                }

                const formData =
                    new FormData(form);

                const payload =
                    Object.fromEntries(
                        formData.entries()
                    );

                submitButton.disabled =
                    true;

                submitButton.textContent =
                    'Creating Account...';

                try {

                    const registerResponse =
                        await postJson(
                            '/api/auth/register',
                            {
                                name:
                                    payload.name.trim(),

                                email:
                                    payload.email.trim(),

                                mobile:
                                    payload.phone.trim(),

                                password:
                                    payload.password,

                                password_confirmation:
                                    payload.password_confirmation,

                                role:
                                    form.dataset.role
                            }
                        );

                    const token =
                        registerResponse
                            ?.data
                            ?.token;

                    const user =
                        registerResponse
                            ?.data
                            ?.user;

                    if (
                        !token ||
                        !user
                    ) {

                        throw new Error(
                            'Registration response is incomplete.'
                        );
                    }

                    localStorage.setItem(
                        'ofc_auth_token',
                        token
                    );

                    localStorage.setItem(
                        'ofc_auth_user',
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

                    if (
                        form.dataset.role ===
                        'company'
                    ) {

                        localStorage.setItem(
                            'onlyfreshers_company_token',
                            token
                        );

                        localStorage.setItem(
                            'onlyfreshers_company_user',
                            JSON.stringify(user)
                        );

                        const companyProfileResponse =
                            await postJson(
                                '/api/company/profile',
                                {
                                    company_name:
                                        payload.name.trim(),

                                    email:
                                        payload.email.trim(),

                                    phone:
                                        payload.phone.trim(),

                                    industry:
                                        payload
                                            .secondary_field
                                            .trim()
                                },
                                token
                            );

                        localStorage.setItem(
                            'ofc_company_profile',
                            JSON.stringify(
                                companyProfileResponse
                                    ?.data
                                    ?.profile || null
                            )
                        );

                        setAlert(
                            'Company account created successfully. Redirecting...',
                            'success'
                        );

                        window.location.href =
                            '/company/profile';

                        return;
                    }

                    if (
                        form.dataset.role ===
                        'training_partner'
                    ) {

                        const trainingProfileResponse =
                            await postJson(
                                '/api/training-partner/profile',
                                {
                                    institute_name:
                                        payload.name.trim(),

                                    email:
                                        payload.email.trim(),

                                    phone:
                                        payload.phone.trim()
                                },
                                token
                            );

                        localStorage.setItem(
                            'ofc_training_partner_profile',
                            JSON.stringify(
                                trainingProfileResponse
                                    ?.data
                                    ?.profile || null
                            )
                        );

                        setAlert(
                            'Training partner account created successfully. Redirecting...',
                            'success'
                        );

                        window.location.href =
                            '/training-partner/profile/edit';

                        return;
                    }

                    localStorage.setItem(
                        'onlyfreshers_mode',
                        'direct'
                    );

                    localStorage.removeItem(
                        'onlyfreshers_selected_mode'
                    );

                    await postJson(
                        '/api/fresher/profile',
                        {
                            phone:
                                payload.phone.trim(),

                            qualification:
                                payload
                                    .secondary_field
                                    .trim(),

                            skills:
                                payload.category
                        },
                        token
                    );

                    setAlert(
                        'Account created successfully. Starting initial assessment...',
                        'success'
                    );

                    window.location.href =
                        '/direct-mode/flow-selection';

                } catch (error) {

                    const errors =
                        error
                            .payload
                            ?.errors || {};

                    Object
                        .entries(errors)
                        .forEach(
                            function ([
                                name,
                                messages
                            ]) {

                                if (
                                    name === 'mobile'
                                ) {

                                    setFieldError(
                                        'phone',
                                        messages
                                    );

                                    return;
                                }

                                setFieldError(
                                    name,
                                    messages
                                );
                            }
                        );

                    setAlert(
                        error.message ||
                        'Something went wrong.'
                    );

                } finally {

                    submitButton.disabled =
                        false;

                    submitButton.textContent =
                        'Create Account';
                }
            }
        );

    }
);

</script>

</body>
</html>