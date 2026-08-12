<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track Login - OnlyFreshers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-[#071743] antialiased">
    <main class="grid min-h-screen lg:grid-cols-[40%_60%]">
        <section class="relative min-h-[380px] overflow-hidden bg-[radial-gradient(circle_at_82%_45%,#1046b6_0,#062a78_34%,#061c56_72%)] px-6 py-7 text-white sm:px-9 lg:min-h-screen lg:px-10 lg:pt-8">
            <div class="absolute inset-0 opacity-40 [background-image:radial-gradient(circle,rgba(255,255,255,.18)_1px,transparent_2px)] [background-size:68px_68px]"></div>

            <div class="relative z-10 flex min-h-[330px] flex-col lg:min-h-screen">
                <img class="h-auto w-[250px] max-w-full brightness-0 invert" src="/ofclogo1.svg" alt="OnlyFreshers">

                <div class="mt-12 max-w-[300px] lg:mt-20">
                    <h1 class="mb-3 text-[32px] font-bold leading-tight lg:text-[30px]">Welcome Back!</h1>
                    <p class="text-lg leading-7 font-normal">Login to continue your career journey.</p>
                </div>
            </div>

            <span class="absolute bottom-[37%] right-[70px] z-[1] hidden h-[60px] w-[60px] items-center justify-center rounded-full border border-white/10 bg-white/15 text-[22px] sm:flex">&gt;</span>
            <span class="absolute bottom-[24%] right-[60px] z-[1] hidden h-[60px] w-[60px] items-center justify-center rounded-full border border-white/10 bg-white/15 text-[22px] sm:flex">^</span>
            <span class="absolute bottom-[30%] left-[46px] z-[1] hidden h-[60px] w-[60px] items-center justify-center rounded-full border border-white/10 bg-white/15 text-[22px] sm:flex">!</span>

            @if (file_exists(public_path('student.svg')))
                <img class="absolute bottom-7 left-1/2 z-[1] hidden h-[230px] w-[360px] -translate-x-1/2 object-contain object-bottom sm:block lg:bottom-8 lg:h-[330px] lg:w-[min(410px,82%)]" src="{{ asset('student.svg') }}" alt="Student learning">
            @endif
        </section>

        <section class="flex min-h-screen items-center justify-center px-3 py-5 sm:px-6 lg:px-8">
            <form class="w-full max-w-[500px] rounded-[14px] border border-[#dce7f8] bg-white px-5 py-7 shadow-[0_12px_34px_rgba(6,25,66,.08)] sm:px-10 sm:py-8" id="fastTrackLoginForm">
                <h2 class="mb-6 text-center text-[22px] font-bold leading-tight text-[#071743]">Login to Your Account</h2>

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

                <div class="my-6 grid grid-cols-[1fr_auto_1fr] items-center gap-5 text-xs uppercase text-[#52668e] before:h-px before:bg-[#dce7f8] after:h-px after:bg-[#dce7f8]">or</div>

                <button class="flex h-11 w-full items-center justify-center gap-3 rounded-lg border border-[#dce7f8] bg-white text-sm font-semibold text-[#071743] transition hover:bg-[#f6f9ff]" type="button"><span class="text-[17px] font-black text-[#075fe4]">G</span> Continue with Google</button>

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
