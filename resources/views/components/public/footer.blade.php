<footer class="border-t border-[#dce7f8] bg-[#061942] text-white">
    <div class="mx-auto w-full max-w-7xl px-5 py-10 sm:px-6 lg:px-8 lg:py-12">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-[1.25fr_repeat(4,minmax(0,1fr))]">
            <div class="min-w-0">
                <a href="/" class="mb-4 inline-flex items-center gap-3 rounded-lg bg-white px-3 py-2 text-white">
                    @if (file_exists(public_path('ofclogo1.svg')))
                        <img src="/ofclogo1.svg" alt="OnlyFreshers Logo" class="block h-[54px] w-[240px] object-contain object-left">
                    @else
                        <span class="flex items-center gap-2 text-[#075fe4]">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#075fe4] text-base font-bold text-white">OF</span>
                            <span class="text-[22px] font-bold leading-none">OnlyFreshers</span>
                        </span>
                    @endif
        </a>

                <p class="max-w-[290px] text-sm leading-6 text-[#c8d4ea]">
                    Connecting fresh talent with the right opportunities through jobs and training.
                </p>
            </div>

            <div class="min-w-0">
                <h3 class="mb-4 text-sm font-bold text-white">Quick Links</h3>
                <nav class="grid gap-2.5 text-sm text-[#c8d4ea]">
                    <a href="/job" class="transition hover:text-white">Jobs</a>
                    <a href="/fast-track" class="transition hover:text-white">Fast Track Program</a>
                    <a href="/training-partners" class="transition hover:text-white">Training Partners</a>
                    <a href="/about" class="transition hover:text-white">About Us</a>
                </nav>
            </div>

            <div class="min-w-0">
                <h3 class="mb-4 text-sm font-bold text-white">For Freshers</h3>
                <nav class="grid gap-2.5 text-sm text-[#c8d4ea]">
                    <a href="/job" class="transition hover:text-white">Browse Jobs</a>
                    <a href="/fast-track" class="transition hover:text-white">Fast Track Program</a>
                    <a href="/training-partners" class="transition hover:text-white">Training Partners</a>
                    <a href="/direct-mode/register" class="transition hover:text-white">Create Profile</a>
                </nav>
            </div>

            <div class="min-w-0">
                <h3 class="mb-4 text-sm font-bold text-white">For Companies</h3>
                <nav class="grid gap-2.5 text-sm text-[#c8d4ea]">
                    <a href="/company/post-job" class="transition hover:text-white">Post a Job</a>
                    <a href="/company/applications" class="transition hover:text-white">Find Fresh Talent</a>
                    <a href="#" class="transition hover:text-white">Why OnlyFreshers?</a>
                    <a href="#" class="transition hover:text-white">Partner With Us</a>
                </nav>
            </div>

            <div class="min-w-0">
                <h3 class="mb-4 text-sm font-bold text-white">Support</h3>
                <address class="not-italic text-sm leading-7 text-[#c8d4ea]">
                    <a href="mailto:support@onlyfreshers.com" class="transition hover:text-white">support@onlyfreshers.com</a><br>
                    <a href="tel:+9163616361669" class="transition hover:text-white">+91 6361 6361 669</a><br>
                    <span>Mon - Sat: 9:00 AM - 6:00 PM</span>
                </address>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-4 border-t border-white/10 pt-5 text-sm text-[#c8d4ea] sm:flex-row sm:items-center sm:justify-between">
            <span>© 2025 OnlyFreshers. All rights reserved.</span>
            <div class="flex flex-wrap gap-x-5 gap-y-2">
                <a href="#" class="transition hover:text-white">Privacy Policy</a>
                <a href="#" class="transition hover:text-white">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>
