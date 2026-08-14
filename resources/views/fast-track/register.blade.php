<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Track Register - OnlyFreshers</title>
    @include('components.common.auth-storage')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <img class="h-auto w-[225px] max-w-full lg:w-[238px]" src="/ofclogo1.svg" alt="OnlyFreshers">
                <div class="relative z-20 mt-[56px] max-w-[520px] lg:mt-[72px]">
                    <h1 class="mb-4 text-[40px] leading-[1.12] text-[#061942] lg:text-[48px]">Welcome to <span class="text-[#075fe4]">OnlyFreshers</span></h1>
                    <p class="m-0 max-w-[560px] text-lg leading-[1.45] text-[#34445e] lg:text-xl">Create your fresher account and begin your career journey.</p>
                    <div class="my-[22px] h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                </div>
            </div>
            <div class="relative z-[1] hidden min-h-[245px] items-end justify-end sm:flex lg:min-h-[285px]">
                <img class="block h-[238px] w-[510px] object-contain object-bottom lg:h-[282px] lg:w-[585px]" src="{{ asset('home-hero-students.png') }}" alt="OnlyFreshers students">
            </div>
        </section>

        <section class="flex w-full items-center justify-center">
            <form class="w-full max-w-[492px] rounded-[24px] bg-white px-5 py-7 shadow-[0_24px_52px_rgba(6,25,66,.12)] sm:px-10 sm:py-9" id="fastTrackRegisterForm">
                <h2 class="m-0 text-center text-[29px] leading-tight text-[#061942]">Fast Track Register</h2>
                <div class="mx-auto mb-4 mt-2.5 h-[3px] w-[58px] rounded-full bg-[#075fe4]"></div>
                <p class="mb-6 text-center text-sm text-[#52607a]">Fill in your details to continue</p>
                <p id="registerError" class="mb-4 hidden rounded-lg border border-[#ffd7d7] bg-[#fff4f4] px-4 py-3 text-sm font-bold text-[#b42318]"></p>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="name">Full Name</label>
                <div class="mb-5 grid min-h-[48px] grid-cols-[46px_minmax(0,1fr)] items-center overflow-hidden rounded-lg border border-[#cddbf0] bg-white focus-within:border-[#075fe4]">
                    <span class="flex items-center justify-center text-[#52668e]"><svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path></svg></span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="name" type="text" placeholder="Enter your full name" required>
                </div>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="email">Email Address</label>
                <div class="mb-5 grid min-h-[48px] grid-cols-[46px_minmax(0,1fr)] items-center overflow-hidden rounded-lg border border-[#cddbf0] bg-white focus-within:border-[#075fe4]">
                    <span class="flex items-center justify-center text-[#52668e]"><svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><path d="M4 6h16v12H4z"></path><path d="m4 7 8 6 8-6"></path></svg></span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="email" type="email" placeholder="Enter your email address" required>
                </div>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password">Password</label>
                <div class="mb-5 grid min-h-[48px] grid-cols-[46px_minmax(0,1fr)] items-center overflow-hidden rounded-lg border border-[#cddbf0] bg-white focus-within:border-[#075fe4]">
                    <span class="flex items-center justify-center text-[#52668e]"><svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="10" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg></span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password" type="password" placeholder="Minimum 8 characters" required>
                </div>

                <label class="mb-2 block text-sm font-medium text-[#071743]" for="password_confirmation">Confirm Password</label>
                <div class="mb-7 grid min-h-[48px] grid-cols-[46px_minmax(0,1fr)] items-center overflow-hidden rounded-lg border border-[#cddbf0] bg-white focus-within:border-[#075fe4]">
                    <span class="flex items-center justify-center text-[#52668e]"><svg class="h-[18px] w-[18px] fill-none stroke-current stroke-2 [stroke-linecap:round] [stroke-linejoin:round]" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="10" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg></span>
                    <input class="h-full w-full border-0 px-2.5 text-sm text-[#071743] outline-none placeholder:text-[#6f7ea0]" id="password_confirmation" type="password" placeholder="Confirm your password" required>
                </div>

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
                localStorage.setItem('onlyfreshers_intended_mode', 'fast_track');
                localStorage.removeItem('onlyfreshers_selected_mode');
                window.location.href = '/direct-mode/flow-selection';
            } catch (error) {
                showError(error.message || 'Register failed.');
                submitButton.disabled = false;
                submitButton.textContent = 'Register';
            }
        });
    </script>
</body>
</html>
