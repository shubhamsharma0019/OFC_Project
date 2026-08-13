<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track Register - OnlyFreshers</title>
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
                    <p class="m-0 max-w-[610px] text-lg leading-[1.45] text-[#34445e] lg:text-xl">Create your fresher account and begin your career journey.</p>
                    <div class="my-[22px] h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                </div>
            </div>
            @if (file_exists(public_path('student.svg')))
                <img class="absolute bottom-7 left-0 z-[1] hidden h-[230px] w-[430px] object-contain object-bottom sm:block lg:bottom-8 lg:h-[300px]" src="{{ asset('student.svg') }}" alt="Student learning">
            @endif
        </section>

        <section class="flex w-full items-center justify-center">
            <form class="w-full max-w-[486px] rounded-[22px] bg-white px-5 py-7 shadow-[0_22px_45px_rgba(6,25,66,.08)] sm:px-10 sm:py-8" id="fastTrackRegisterForm">
                <h2 class="m-0 text-center text-[28px] font-semibold leading-tight text-[#061942]">Fast Track Register</h2>
                <div class="mx-auto mb-4 mt-2.5 h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                <p class="mb-6 text-center text-sm font-semibold text-[#52607a]">Fill in your details to continue</p>
                <p id="registerError" class="mb-4 hidden rounded-lg border border-[#ffd7d7] bg-[#fff4f4] px-4 py-3 text-sm font-bold text-[#b42318]"></p>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="name">Full Name</label>
                <input class="mb-5 h-[46px] w-full rounded-lg border border-[#cddbf0] px-4 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="name" type="text" placeholder="Enter your full name" required>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="email">Email Address</label>
                <input class="mb-5 h-[46px] w-full rounded-lg border border-[#cddbf0] px-4 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="email" type="email" placeholder="Enter your email address" required>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password">Password</label>
                <input class="mb-5 h-[46px] w-full rounded-lg border border-[#cddbf0] px-4 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password" type="password" placeholder="Minimum 8 characters" required>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password_confirmation">Confirm Password</label>
                <input class="mb-7 h-[46px] w-full rounded-lg border border-[#cddbf0] px-4 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password_confirmation" type="password" placeholder="Confirm your password" required>

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
                window.location.href = '/direct-mode/profile';
            } catch (error) {
                showError(error.message || 'Register failed.');
                submitButton.disabled = false;
                submitButton.textContent = 'Register';
            }
        });
    </script>
</body>
</html>
