@php
    $pageTitle = 'Admin Login - OnlyFreshers';
    $brandName = 'OnlyFreshers';
    $logoPath = 'ofclogo1.svg';
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
            'value' => 'admin@onlyfreshers.com',
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
    @include('components.common.auth-storage')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eaf3ff] font-sans font-medium text-[#061942]">
    <main class="grid min-h-screen grid-cols-1 items-center gap-[30px] bg-[radial-gradient(circle_at_34%_58%,rgba(7,95,228,0.08)_0_260px,transparent_261px),linear-gradient(130deg,#ffffff,#dfeeff)] px-[18px] py-[18px] lg:grid-cols-[1fr_1.08fr] lg:gap-[34px] lg:px-[46px] lg:py-4">
        <section class="relative min-h-[520px] overflow-hidden lg:min-h-[540px]">
            <a href="{{ url('/') }}" class="inline-flex items-center no-underline">
                @if (file_exists(public_path($logoPath)))
                    <img src="{{ asset($logoPath) }}" alt="{{ $brandName }} Logo" class="block h-auto w-[230px] lg:w-[245px]">
                @else
                    <span class="inline-flex items-center gap-3 text-[28px] font-bold leading-none text-[#075fe4]">
                        <span class="flex h-[46px] w-[46px] items-center justify-center rounded-[13px] bg-[#075fe4] text-lg text-white">OF</span>
                        <span>{{ $brandName }}</span>
                    </span>
                @endif
            </a>

            <div class="mt-[55px] max-w-[520px] lg:mt-[62px]">
                <h1 class="mb-4 text-[40px] font-semibold leading-[1.12] text-[#061942] lg:text-[46px]">
                    Welcome to <span class="text-[#075fe4]">{{ $brandName }}</span>
                </h1>

                <p class="m-0 max-w-[610px] text-lg leading-[1.45] text-[#34445e] lg:text-xl">
                    Manage jobs, review candidates, and build a strong fresher hiring pipeline with ease.
                </p>

                <div class="my-[22px] h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
            </div>

            <div class="relative z-[5] mb-0 hidden flex-wrap gap-3.5 sm:flex">
                @foreach ($stats as $stat)
                    <div class="flex min-w-[116px] items-center gap-3 rounded-2xl bg-[#dbeafe]/90 px-3.5 py-2.5">
                        <div class="flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white">
                            {{ $stat['icon'] }}
                        </div>

                        <div>
                            <strong class="block text-xl font-bold leading-none text-[#075fe4]">{{ $stat['value'] }}</strong>
                            <span class="text-[13px] font-medium text-[#061942]">{{ $stat['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="relative z-[1] mx-auto mt-[38px] h-[210px] w-full max-w-[560px]" aria-hidden="true">
                <img src="{{ asset('home-hero-students.png') }}" alt="" class="h-full w-full object-contain object-bottom">
            </div>
        </section>

        <section class="w-full max-w-[540px] rounded-[22px] bg-white px-6 pb-[26px] pt-[34px] shadow-[0_22px_45px_rgba(6,25,66,0.08)] lg:min-h-[500px] lg:rounded-3xl lg:px-[38px] lg:pb-5 lg:pt-[26px]">
            <div class="mb-[22px] text-center">
                <h2 class="m-0 text-[32px] font-semibold leading-[1.1] text-[#061942] lg:text-[28px]">Admin Login</h2>
                <div class="mx-auto mb-3 mt-2.5 h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                <p class="m-0 text-base font-medium text-[#52607a]">Fill in your details to continue</p>
            </div>

            <form id="adminLoginForm" method="POST" action="{{ $dashboardUrl }}">
                @csrf
                <p class="mb-3.5 hidden rounded-lg bg-[#fff0f1] px-3 py-2.5 text-sm font-semibold text-[#ff1f2f]" id="loginError">Email ya password galat hai.</p>

                @foreach ($loginFields as $field)
                    <div class="mb-[15px]">
                        <label for="{{ $field['id'] }}" class="mb-[7px] block text-base font-semibold text-[#061942] lg:text-sm">{{ $field['label'] }}</label>

                        <div class="flex items-center overflow-hidden rounded-xl border border-[#bcd2f2] bg-white">
                            <div class="flex h-[52px] w-[52px] shrink-0 items-center justify-center border-r border-[#dce7f8] text-[22px] text-[#52607a] lg:h-[46px]">
                                {{ $field['icon'] }}
                            </div>

                            <input
                                type="{{ $field['type'] }}"
                                id="{{ $field['id'] }}"
                                name="{{ $field['id'] }}"
                                placeholder="{{ $field['placeholder'] }}"
                                value="{{ old($field['id'], $field['value']) }}"
                                class="h-[52px] w-full border-0 px-[18px] text-base font-medium text-[#061942] outline-none placeholder:text-[#74839d] lg:h-[46px]"
                            >

                            @if (!empty($field['toggle']))
                                <button class="px-[18px] text-sm font-medium text-[#52607a]" type="button" id="passwordToggle">Show</button>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="mb-[18px] mt-1 flex flex-col items-start gap-3 text-base font-semibold sm:flex-row sm:items-center sm:justify-between lg:text-sm">
                    <label class="flex items-center gap-3.5 text-[#061942]">
                        <input type="checkbox" name="remember" checked class="h-5 w-5 accent-[#075fe4]">
                        Remember me
                    </label>
                    <a href="#" class="font-semibold text-[#075fe4] no-underline">Forgot password?</a>
                </div>

                <button type="submit" id="loginButton" class="h-[46px] w-full rounded-[11px] bg-[#075fe4] text-lg font-semibold text-white shadow-[0_8px_18px_rgba(7,95,228,0.24)] transition hover:bg-[#003f9e]">Login</button>
            </form>

            <p class="mt-4 text-center text-sm font-medium text-[#52607a]"><span class="mr-2.5 font-bold text-[#075fe4]">SH</span>Protected by enterprise-grade authentication</p>
        </section>
    </main>

    <script>
        const adminLoginForm = document.getElementById('adminLoginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginError = document.getElementById('loginError');
        const loginButton = document.getElementById('loginButton');
        const passwordToggle = document.getElementById('passwordToggle');
        const dashboardUrl = @json($dashboardUrl);

        function showError(message) {
            loginError.textContent = message || 'Email ya password galat hai.';
            loginError.classList.remove('hidden');
        }

        adminLoginForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            loginError.classList.add('hidden');
            loginButton.disabled = true;
            loginButton.textContent = 'Logging in...';

            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: emailInput.value.trim(),
                        password: passwordInput.value,
                    }),
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Email ya password galat hai.');
                }

                if (result.data?.user?.role !== 'admin') {
                    throw new Error('Please login with an admin account.');
                }

                localStorage.setItem('ofc_auth_token', result.data.token);
                localStorage.setItem('ofc_auth_user', JSON.stringify(result.data.user));
                localStorage.setItem('onlyFreshersAdminLogin', 'yes');
                window.location.href = dashboardUrl;
            } catch (error) {
                localStorage.removeItem('ofc_auth_token');
                localStorage.removeItem('ofc_auth_user');
                localStorage.removeItem('onlyFreshersAdminLogin');
                showError(error.message || 'Login nahi ho paaya.');
            } finally {
                loginButton.disabled = false;
                loginButton.textContent = 'Login';
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
