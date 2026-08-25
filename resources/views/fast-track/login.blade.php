<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track Login - OnlyFreshers</title>
    @include('components.common.auth-storage')
    @include('components.common.compiled-assets')
    <style>
        .fast-track-auth,
        .fast-track-auth * {
            font-family: Inter, Arial, Helvetica, sans-serif !important;
            font-weight: 500 !important;
        }
    </style>
</head>
<body class="min-h-screen bg-[#eaf3ff] font-sans font-medium text-[#061942] antialiased">
    <main class="fast-track-auth grid min-h-screen grid-cols-1 items-center gap-[30px] overflow-hidden bg-[radial-gradient(circle_at_38%_60%,rgba(7,95,228,0.12)_0_310px,transparent_312px),linear-gradient(130deg,#ffffff,#dfeeff)] px-[18px] py-[18px] lg:grid-cols-[1.05fr_.95fr] lg:gap-[42px] lg:px-[52px] lg:py-5">
        <section class="relative grid min-h-[520px] overflow-hidden rounded-[28px] lg:min-h-[570px] lg:grid-rows-[auto_1fr]">

            <div class="relative z-10 flex flex-col">
                <a href="/" class="inline-flex">
                    <img class="h-auto w-[225px] max-w-full lg:w-[238px]" src="/ofclogo1.svg" alt="OnlyFreshers">
                </a>

                <div class="relative z-20 mt-[56px] max-w-[520px] lg:mt-[72px]">
                    <h1 class="mb-4 text-[40px] leading-[1.12] text-[#061942] lg:text-[48px]">Welcome to <span class="text-[#075fe4]">OnlyFreshers</span></h1>
                    <p class="m-0 max-w-[560px] text-lg leading-[1.45] text-[#34445e] lg:text-xl">Login to continue your career journey.</p>
                    <div class="my-[22px] h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                </div>
            </div>

            <div class="relative z-[1] hidden min-h-[245px] items-end justify-end sm:flex lg:min-h-[285px]">
                <img class="block h-[238px] w-[510px] object-contain object-bottom lg:h-[282px] lg:w-[585px]" src="{{ asset('home-hero-students.png') }}" alt="OnlyFreshers students">
            </div>
        </section>

        <section class="flex w-full items-center justify-center">
            <form class="w-full max-w-[492px] rounded-[24px] bg-white px-5 py-7 shadow-[0_24px_52px_rgba(6,25,66,.12)] sm:px-10 sm:py-9" id="fastTrackLoginForm" autocomplete="off">
                <h2 class="m-0 text-center text-[29px] leading-tight text-[#061942]">Fast Track Login</h2>
                <div class="mx-auto mb-4 mt-2.5 h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                <p class="mb-6 text-center text-sm text-[#52607a]">Fill in your details to continue</p>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="email">Email Address</label>
                <div class="mb-5 grid min-h-[48px] grid-cols-[46px_minmax(0,1fr)] items-center overflow-hidden rounded-lg border border-[#cddbf0] bg-white focus-within:border-[#075fe4]">
                    <span class="flex items-center justify-center text-[#52668e]">
                        <svg class="h-[17px] w-[17px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v12H4z"></path><path d="m4 7 8 6 8-6"></path></svg>
                    </span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="email" type="email" placeholder="Enter your email address" autocomplete="off">
                </div>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password">Password</label>
                <div class="mb-5 grid min-h-[48px] grid-cols-[46px_minmax(0,1fr)_42px] items-center overflow-hidden rounded-lg border border-[#cddbf0] bg-white focus-within:border-[#075fe4]">
                    <span class="flex items-center justify-center text-[#52668e]">
                        <svg class="h-[17px] w-[17px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg>
                    </span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password" type="password" placeholder="Enter your password" autocomplete="new-password">
                    <button class="flex items-center justify-center text-[#52668e]" type="button" id="togglePassword" aria-label="Show password">
                        <svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>

                <div class="mb-7 flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                    <label class="flex items-center gap-3 text-[#071743]"><input class="h-[17px] w-[17px] accent-[#075fe4]" type="checkbox"> Remember me</label>
                    <a class="font-bold text-[#075fe4]" href="/direct-mode/forgot-password">Forgot Password?</a>
                </div>

                <button class="h-12 w-full rounded-lg bg-[#075fe4] text-base font-bold text-white shadow-[0_9px_18px_rgba(7,95,228,.2)] transition hover:bg-[#064fc0]" type="submit">Login</button>

                <p class="mt-6 text-center text-sm text-[#071743]">Fast Track access starts after completing the assessment.</p>
            </form>
        </section>
    </main>

    <script>
        const fastTrackPasswordToggle = document.getElementById('togglePassword');
        const fastTrackLoginForm = document.getElementById('fastTrackLoginForm');

        if (fastTrackPasswordToggle) {
            fastTrackPasswordToggle.addEventListener('click', function () {
                const password = document.getElementById('password');
                password.type = password.type === 'password' ? 'text' : 'password';
            });
        }

        if (fastTrackLoginForm) {
            fastTrackLoginForm.addEventListener('submit', async function (event) {
                event.preventDefault();
                const submitButton = fastTrackLoginForm.querySelector('[type="submit"]');
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;

                submitButton.disabled = true;
                submitButton.textContent = 'Logging in...';

                try {
                    const response = await fetch('/api/auth/login', {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ email, password }),
                    });
                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Login failed.');
                    }

                    const user = result.data && result.data.user;
                    if (user && user.role && user.role !== 'fresher') {
                        throw new Error('Fast Track flow fresher account ke liye hai.');
                    }

                    localStorage.setItem('ofc_auth_token', result.data.token);
                    localStorage.setItem('ofc_auth_user', JSON.stringify(user || {}));
                    localStorage.setItem('onlyfreshers_token', result.data.token);
                    localStorage.setItem('onlyfreshers_user', JSON.stringify(user || {}));
                    localStorage.setItem('onlyfreshers_intended_mode', 'fast_track');

                    const dashboardResponse = await fetch('/api/fresher/dashboard', {
                        headers: {
                            Accept: 'application/json',
                            Authorization: `Bearer ${result.data.token}`,
                        },
                    });
                    const dashboardPayload = await dashboardResponse.json().catch(() => ({}));
                    const assessment = dashboardPayload.data?.initial_assessment;

                    if (!dashboardResponse.ok) {
                        window.location.href = '/direct-mode/profile';
                        return;
                    }

                    if (!assessment || assessment.status !== 'submitted') {
                        localStorage.removeItem('onlyfreshers_selected_mode');
                        window.location.href = '/direct-mode/flow-selection';
                        return;
                    }

                    localStorage.setItem('onlyfreshers_selected_mode', 'fast_track');
                    window.location.href = '/fast-track/dashboard';
                } catch (error) {
                    alert(error.message || 'Login failed.');
                    submitButton.disabled = false;
                    submitButton.textContent = 'Login';
                }
            });
        }
    </script>
</body>
</html>
