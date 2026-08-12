<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track Register - OnlyFreshers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-[#071743] antialiased">
    <main class="grid min-h-screen lg:grid-cols-[40%_60%]">
        <section class="relative min-h-[380px] overflow-hidden bg-[radial-gradient(circle_at_82%_45%,#1046b6_0,#062a78_34%,#061c56_72%)] px-6 py-7 text-white sm:px-9 lg:min-h-screen lg:px-10 lg:pt-8">
            <div class="absolute inset-0 opacity-40 [background-image:radial-gradient(circle,rgba(255,255,255,.18)_1px,transparent_2px)] [background-size:68px_68px]"></div>
            <div class="relative z-10 flex min-h-[330px] flex-col lg:min-h-screen">
                <img class="h-auto w-[250px] max-w-full brightness-0 invert" src="/ofclogo1.svg" alt="OnlyFreshers">
                <div class="mt-12 max-w-[320px] lg:mt-20">
                    <h1 class="mb-3 text-[32px] font-bold leading-tight lg:text-[30px]">Start Fast Track</h1>
                    <p class="text-lg leading-7 font-normal">Create your fresher account and begin your career journey.</p>
                </div>
            </div>
            @if (file_exists(public_path('student.svg')))
                <img class="absolute bottom-7 left-1/2 z-[1] hidden h-[230px] w-[360px] -translate-x-1/2 object-contain object-bottom sm:block lg:bottom-8 lg:h-[330px] lg:w-[min(410px,82%)]" src="{{ asset('student.svg') }}" alt="Student learning">
            @endif
        </section>

        <section class="flex min-h-screen items-center justify-center px-3 py-5 sm:px-6 lg:px-8">
            <form class="w-full max-w-[500px] rounded-[14px] border border-[#dce7f8] bg-white px-5 py-7 shadow-[0_12px_34px_rgba(6,25,66,.08)] sm:px-10 sm:py-8" id="fastTrackRegisterForm">
                <h2 class="mb-6 text-center text-[22px] font-bold leading-tight text-[#071743]">Create Your Account</h2>
                <p id="registerError" class="mb-4 hidden rounded-lg border border-[#ffd7d7] bg-[#fff4f4] px-4 py-3 text-sm font-bold text-[#b42318]"></p>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="name">Full Name</label>
                <input class="mb-5 h-[46px] w-full rounded-lg border border-[#cddbf0] px-3 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="name" type="text" placeholder="Enter your full name" required>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="email">Email Address</label>
                <input class="mb-5 h-[46px] w-full rounded-lg border border-[#cddbf0] px-3 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="email" type="email" placeholder="Enter your email address" required>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password">Password</label>
                <input class="mb-5 h-[46px] w-full rounded-lg border border-[#cddbf0] px-3 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password" type="password" placeholder="Minimum 8 characters" required>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password_confirmation">Confirm Password</label>
                <input class="mb-7 h-[46px] w-full rounded-lg border border-[#cddbf0] px-3 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password_confirmation" type="password" placeholder="Confirm your password" required>

                <button class="h-12 w-full rounded-lg bg-[#075fe4] text-base font-bold text-white shadow-[0_9px_18px_rgba(7,95,228,.2)] transition hover:bg-[#064fc0]" type="submit">Register</button>
                <p class="mt-6 text-center text-sm text-[#071743]">Already have an account? <a class="font-bold text-[#075fe4]" href="/fast-track/login">Login</a></p>
            </form>
        </section>
    </main>

    <script>
        const form = document.getElementById('fastTrackRegisterForm');
        const errorBox = document.getElementById('registerError');

        function showError(message) {
            errorBox.textContent = message || 'Register nahi ho paaya.';
            errorBox.classList.remove('hidden');
        }

        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            errorBox.classList.add('hidden');
            const submitButton = form.querySelector('[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Registering...';

            try {
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: document.getElementById('name').value.trim(),
                        email: document.getElementById('email').value.trim(),
                        password: document.getElementById('password').value,
                        password_confirmation: document.getElementById('password_confirmation').value,
                        role: 'fresher',
                    }),
                });
                const result = await response.json();
                if (!response.ok || !result.success) {
                    const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : null;
                    throw new Error(validationMessage || result.message || 'Register failed.');
                }
                const user = result.data?.user || {};
                localStorage.setItem('ofc_auth_token', result.data.token);
                localStorage.setItem('ofc_auth_user', JSON.stringify(user));
                localStorage.setItem('onlyfreshers_token', result.data.token);
                localStorage.setItem('onlyfreshers_user', JSON.stringify(user));
                window.location.href = '/fast-track/dashboard';
            } catch (error) {
                showError(error.message || 'Register failed.');
                submitButton.disabled = false;
                submitButton.textContent = 'Register';
            }
        });
    </script>
</body>
</html>
