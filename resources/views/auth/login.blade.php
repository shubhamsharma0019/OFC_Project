@php
    $pageTitle = 'Admin Login - OnlyFreshers';
    $brandName = 'OnlyFreshers';
    $logoPath = 'ofclogo1.png';
    $dashboardUrl = url('/admin/dashboard');

    $stats = [
        ['icon' => 'JB', 'value' => '12k+', 'label' => 'Jobs'],
        ['icon' => 'CD', 'value' => '8k+', 'label' => 'Candidates'],
        ['icon' => 'CO', 'value' => '320+', 'label' => 'Companies'],
    ];

    $loginFields = [
        [
            'label' => 'Email Address',
            'type' => 'email',
            'id' => 'email',
            'icon' => '@',
            'placeholder' => 'Enter email address',
            'value' => 'admin@ofc.com',
        ],
        [
            'label' => 'Password',
            'type' => 'password',
            'id' => 'password',
            'icon' => '#',
            'placeholder' => 'Enter password',
            'value' => 'password',
            'toggle' => true,
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: #061942;
            background: #eaf3ff;
            font-weight: 500;
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1.08fr;
            gap: 34px;
            align-items: center;
            padding: 16px 46px;
            box-sizing: border-box;
            background:
                radial-gradient(circle at 34% 58%, rgba(7, 95, 228, 0.08) 0 260px, transparent 261px),
                linear-gradient(130deg, #ffffff, #dfeeff);
        }

        .left-panel {
            min-height: 540px;
            position: relative;
            overflow: hidden;
        }

        .logo img {
            width: 245px;
            height: auto;
            display: block;
        }

        .logo-fallback {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #075fe4;
            font-size: 28px;
            line-height: 1;
            font-weight: 700;
            text-decoration: none;
        }

        .logo-fallback span:first-child {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: #075fe4;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .welcome-text {
            margin-top: 62px;
            max-width: 520px;
        }

        .welcome-text h1 {
            margin: 0 0 16px;
            font-size: 46px;
            line-height: 1.12;
            font-weight: 600;
        }

        .welcome-text h1 span {
            color: #075fe4;
        }

        .welcome-text p {
            max-width: 610px;
            margin: 0;
            color: #34445e;
            font-size: 20px;
            line-height: 1.45;
            font-weight: 500;
        }

        .blue-line {
            width: 58px;
            height: 3px;
            border-radius: 20px;
            background: #075fe4;
            margin: 20px 0 22px;
        }

        .stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 0;
            position: relative;
            z-index: 5;
        }

        .stat-pill {
            min-width: 116px;
            padding: 10px 14px;
            border-radius: 16px;
            background: rgba(219, 234, 254, 0.9);
            display: flex;
            align-items: center;
            gap: 12px;
            box-sizing: border-box;
        }

        .stat-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            color: white;
            background: #075fe4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
        }

        .stat-pill strong {
            display: block;
            color: #075fe4;
            font-size: 20px;
            line-height: 1;
            font-weight: 700;
        }

        .stat-pill span {
            color: #061942;
            font-size: 13px;
            font-weight: 500;
        }

        .illustration {
            position: relative;
            left: auto;
            bottom: auto;
            width: 430px;
            height: 150px;
            margin: 38px auto 0;
            z-index: 1;
        }

        .table {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 24px;
            height: 10px;
            background: #b9cceb;
            border-radius: 20px;
        }

        .person {
            position: absolute;
            bottom: 34px;
            width: 116px;
            height: 136px;
            border-radius: 70px 70px 10px 10px;
            background: linear-gradient(#ffd4b7 0 32%, #ffffff 32% 52%, #075fe4 52%);
        }

        .person::before {
            content: "";
            position: absolute;
            width: 62px;
            height: 48px;
            border-radius: 45px 45px 25px 25px;
            top: -22px;
            left: 27px;
            background: #10204a;
        }

        .person.one {
            left: 120px;
        }

        .person.two {
            left: 285px;
            width: 106px;
            height: 126px;
        }

        .laptop {
            position: absolute;
            left: 205px;
            bottom: 34px;
            width: 165px;
            height: 74px;
            border-radius: 9px;
            background: linear-gradient(145deg, #e5edf9, #aebbd0);
            box-shadow: 0 8px 18px rgba(6, 25, 66, 0.14);
            z-index: 3;
        }

        .laptop::after {
            content: "";
            position: absolute;
            left: 74px;
            top: 31px;
            width: 19px;
            height: 19px;
            border-radius: 50%;
            background: white;
        }

        .login-card {
            width: 100%;
            max-width: 540px;
            min-height: 500px;
            border-radius: 24px;
            background: white;
            padding: 26px 38px 20px;
            box-sizing: border-box;
            box-shadow: 0 22px 45px rgba(6, 25, 66, 0.08);
        }

        .form-title {
            text-align: center;
            margin-bottom: 22px;
        }

        .form-title h2 {
            margin: 0;
            font-size: 28px;
            line-height: 1.1;
            font-weight: 600;
        }

        .title-line {
            width: 58px;
            height: 3px;
            border-radius: 20px;
            background: #075fe4;
            margin: 10px auto 12px;
        }

        .form-title p {
            margin: 0;
            color: #52607a;
            font-size: 16px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
        }

        .input-box {
            display: flex;
            align-items: center;
            border: 1px solid #bcd2f2;
            border-radius: 12px;
            background: white;
            overflow: hidden;
        }

        .input-icon {
            width: 52px;
            height: 46px;
            border-right: 1px solid #dce7f8;
            color: #52607a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        input {
            width: 100%;
            height: 46px;
            border: 0;
            outline: none;
            padding: 0 18px;
            color: #061942;
            font-size: 16px;
            font-weight: 500;
            box-sizing: border-box;
        }

        input::placeholder {
            color: #74839d;
        }

        .password-eye {
            padding: 0 18px;
            border: 0;
            background: transparent;
            color: #52607a;
            font-size: 14px;
            cursor: pointer;
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 18px;
            font-size: 14px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #061942;
            font-weight: 600;
        }

        .remember input {
            width: 20px;
            height: 20px;
            padding: 0;
            accent-color: #075fe4;
        }

        a {
            color: #075fe4;
            text-decoration: none;
            font-weight: 600;
        }

        .login-button {
            width: 100%;
            height: 46px;
            border: 0;
            border-radius: 11px;
            background: #075fe4;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 18px rgba(7, 95, 228, 0.24);
        }

        .login-button:hover {
            background: #003f9e;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 22px;
            margin: 16px 10px;
            color: #52607a;
            font-size: 14px;
        }

        .divider span {
            height: 1px;
            background: #cddbf0;
            flex: 1;
        }

        .google-button {
            width: 100%;
            height: 44px;
            border: 1px solid #cddbf0;
            border-radius: 11px;
            background: white;
            color: #061942;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .google-button span {
            color: #075fe4;
            font-size: 22px;
            margin-right: 14px;
            vertical-align: middle;
        }

        .secure-text {
            margin: 16px 0 0;
            text-align: center;
            color: #52607a;
            font-size: 14px;
            font-weight: 500;
        }

        .secure-text span {
            color: #075fe4;
            margin-right: 10px;
            font-weight: 700;
        }

        .login-error {
            display: none;
            margin: 0 0 14px;
            padding: 10px 12px;
            border-radius: 7px;
            background: #fff0f1;
            color: #ff1f2f;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 1100px) {
            .page {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .left-panel {
                min-height: 520px;
            }

            .login-card {
                max-width: 100%;
            }
        }

        @media (max-width: 700px) {
            .page {
                padding: 18px;
            }

            .logo img {
                width: 230px;
            }

            .welcome-text {
                margin-top: 55px;
            }

            .welcome-text h1 {
                font-size: 40px;
            }

            .welcome-text p {
                font-size: 18px;
            }

            .stats-row {
                display: none;
            }

            .illustration {
                transform: scale(0.65);
                left: -70px;
                bottom: -10px;
            }

            .login-card {
                border-radius: 22px;
                padding: 34px 24px 26px;
            }

            .form-title h2 {
                font-size: 32px;
            }

            .form-title p,
            label,
            input,
            .login-options,
            .google-button {
                font-size: 16px;
            }

            .input-icon,
            input {
                height: 52px;
            }

            .login-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="left-panel">
            <a href="{{ url('/') }}" class="logo">
                @if (file_exists(public_path($logoPath)))
                    <img src="{{ asset($logoPath) }}" alt="{{ $brandName }} Logo">
                @else
                    <span class="logo-fallback"><span>OF</span><span>{{ $brandName }}</span></span>
                @endif
            </a>

            <div class="welcome-text">
                <h1>Welcome to <span>{{ $brandName }}</span></h1>
                <p>Manage jobs, review candidates, and build a strong fresher hiring pipeline with ease.</p>
                <div class="blue-line"></div>
            </div>

            <div class="stats-row">
                @foreach ($stats as $stat)
                    <div class="stat-pill">
                        <div class="stat-icon">{{ $stat['icon'] }}</div>
                        <div>
                            <strong>{{ $stat['value'] }}</strong>
                            <span>{{ $stat['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="illustration" aria-hidden="true">
                <div class="person one"></div>
                <div class="person two"></div>
                <div class="laptop"></div>
                <div class="table"></div>
            </div>
        </section>

        <section class="login-card">
            <div class="form-title">
                <h2>Admin Login</h2>
                <div class="title-line"></div>
                <p>Fill in your details to continue</p>
            </div>

            <form id="adminLoginForm" method="POST" action="{{ $dashboardUrl }}">
                @csrf
                <p class="login-error" id="loginError">Email ya password galat hai.</p>

                @foreach ($loginFields as $field)
                    <div class="form-group">
                        <label for="{{ $field['id'] }}">{{ $field['label'] }}</label>
                        <div class="input-box">
                            <div class="input-icon">{{ $field['icon'] }}</div>
                            <input
                                type="{{ $field['type'] }}"
                                id="{{ $field['id'] }}"
                                name="{{ $field['id'] }}"
                                placeholder="{{ $field['placeholder'] }}"
                                value="{{ old($field['id'], $field['value']) }}"
                            >
                            @if (!empty($field['toggle']))
                                <button class="password-eye" type="button" id="passwordToggle">Show</button>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="login-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" checked>
                        Remember me
                    </label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="divider">
                <span></span>
                <p>or</p>
                <span></span>
            </div>

            <button class="google-button" type="button"><span>G</span>Continue with Google</button>

            <p class="secure-text"><span>SH</span>Protected by enterprise-grade authentication</p>
        </section>
    </main>

    <script>
        const adminLoginForm = document.getElementById('adminLoginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginError = document.getElementById('loginError');
        const passwordToggle = document.getElementById('passwordToggle');
        const dashboardUrl = @json($dashboardUrl);

        adminLoginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            if (emailInput.value === 'admin@ofc.com' && passwordInput.value === 'password') {
                localStorage.setItem('onlyFreshersAdminLogin', 'yes');
                window.location.href = dashboardUrl;
            } else {
                loginError.style.display = 'block';
            }
        });

        passwordToggle.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                passwordToggle.textContent = 'Show';
            }
        });
    </script>
</body>
</html>
