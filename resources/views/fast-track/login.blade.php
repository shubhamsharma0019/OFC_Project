<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track Login - OnlyFreshers</title>
    @include('components.common.auth-storage')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eaf3ff] font-sans font-medium text-[#061942] antialiased">
    <main class="grid min-h-screen grid-cols-1 items-center gap-[30px] bg-[radial-gradient(circle_at_34%_58%,rgba(7,95,228,0.08)_0_260px,transparent_261px),linear-gradient(130deg,#ffffff,#dfeeff)] px-[18px] py-[18px] lg:grid-cols-[1fr_1.08fr] lg:gap-[34px] lg:px-[46px] lg:py-4">
        <section class="relative min-h-[520px] overflow-hidden lg:min-h-[540px]">

            <div class="relative z-10 flex min-h-[330px] flex-col lg:min-h-[540px]">
                <img class="h-auto w-[230px] max-w-full lg:w-[245px]" src="/ofclogo1.svg" alt="OnlyFreshers">

                <div class="mt-[55px] max-w-[520px] lg:mt-[62px]">
                    <h1 class="mb-4 text-[40px] font-semibold leading-[1.12] text-[#061942] lg:text-[46px]">Welcome to <span class="text-[#075fe4]">OnlyFreshers</span></h1>
                    <p class="m-0 max-w-[610px] text-lg leading-[1.45] text-[#34445e] lg:text-xl">Login to continue your career journey.</p>
                    <div class="my-[22px] h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                </div>
            </div>

            @if (file_exists(public_path('student.svg')))
                <img class="absolute bottom-7 left-0 z-[1] hidden h-[230px] w-[430px] object-contain object-bottom sm:block lg:bottom-8 lg:h-[300px]" src="{{ asset('student.svg') }}" alt="Student learning">
            @endif
        </section>

        <section class="flex w-full items-center justify-center">
            <form class="w-full max-w-[486px] rounded-[22px] bg-white px-5 py-7 shadow-[0_22px_45px_rgba(6,25,66,.08)] sm:px-10 sm:py-8" id="fastTrackLoginForm">
                <h2 class="m-0 text-center text-[28px] font-semibold leading-tight text-[#061942]">Fast Track Login</h2>
                <div class="mx-auto mb-4 mt-2.5 h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                <p class="mb-6 text-center text-sm font-semibold text-[#52607a]">Fill in your details to continue</p>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="email">Email Address</label>
                <div class="mb-5 grid min-h-[46px] grid-cols-[44px_minmax(0,1fr)] items-center overflow-hidden rounded-lg border border-[#cddbf0]">
                    <span class="flex items-center justify-center text-[#52668e]">
                        <svg class="h-[17px] w-[17px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16v12H4z"></path><path d="m4 7 8 6 8-6"></path></svg>
                    </span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="email" type="email" placeholder="Enter your email address">
                </div>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password">Password</label>
                <div class="mb-5 grid min-h-[46px] grid-cols-[44px_minmax(0,1fr)_42px] items-center overflow-hidden rounded-lg border border-[#cddbf0]">
                    <span class="flex items-center justify-center text-[#52668e]">
                        <svg class="h-[17px] w-[17px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg>
                    </span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password" type="password" placeholder="Enter your password">
                    <button class="flex items-center justify-center text-[#52668e]" type="button" id="togglePassword" aria-label="Show password">
                        <svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>

                <div class="mb-7 flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                    <label class="flex items-center gap-3 text-[#071743]"><input class="h-[17px] w-[17px] accent-[#075fe4]" type="checkbox"> Remember me</label>
                    <a class="font-bold text-[#075fe4]" href="#">Forgot Password?</a>
                </div>

                <button class="h-12 w-full rounded-lg bg-[#075fe4] text-base font-bold text-white shadow-[0_9px_18px_rgba(7,95,228,.2)] transition hover:bg-[#064fc0]" type="submit">Login</button>

                <p class="mt-6 text-center text-sm text-[#071743]">Don't have an account? <a class="font-bold text-[#075fe4]" href="/fast-track/register">Register</a></p>
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
                        window.location.href = '/direct-mode/assessments';
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
