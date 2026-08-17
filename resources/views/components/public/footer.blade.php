<footer class="bg-white px-4 py-3">
    <div class="mx-auto flex w-full max-w-[1680px] flex-col gap-3 rounded-md bg-[#075fe4] px-5 py-3 text-white shadow-[0_10px_24px_rgba(7,95,228,0.22)] lg:flex-row lg:items-center lg:gap-6">

        <div class="flex min-w-0 flex-1 items-center gap-4">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center text-white [&>svg]:h-8 [&>svg]:w-8">
                @include('components.public.icon', ['name' => 'rocket'])
            </span>

            <span class="min-w-0">
                <strong class="block font-['Inter'] text-sm font-semibold leading-tight">
                    Start Your Journey Today!
                </strong>

                <small class="mt-1 block max-w-[420px] text-[11px] font-medium leading-4 text-white/90">
                    Whether you choose Direct Mode or Fast Track Mode, OnlyFreshers is here to help you get hired faster.
                </small>
            </span>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 lg:w-[430px]">

            <a
                href="/direct-mode/register"
                class="flex h-12 items-center justify-center rounded-md bg-white px-5 text-center font-['Inter'] text-sm font-semibold text-[#061942] shadow-[0_6px_14px_rgba(0,0,0,0.12)] transition hover:bg-[#eef5ff]"
            >
                <span>
                    <strong class="block leading-tight">
                        For Freshers
                    </strong>

                    <small class="mt-0.5 block text-[10px] font-medium text-[#34445e]">
                        Find Jobs & Programs
                    </small>
                </span>
            </a>

            <a
                href="/company/register"
                class="flex h-12 items-center justify-center rounded-md bg-white px-5 text-center font-['Inter'] text-sm font-semibold text-[#061942] shadow-[0_6px_14px_rgba(0,0,0,0.12)] transition hover:bg-[#eef5ff]"
            >
                <span>
                    <strong class="block leading-tight">
                        For Companies
                    </strong>

                    <small class="mt-0.5 block text-[10px] font-medium text-[#34445e]">
                        Post Jobs & Hire Talent
                    </small>
                </span>
            </a>

        </div>

        <div class="grid flex-1 grid-cols-2 divide-x divide-white/30 border-t border-white/25 pt-3 text-center sm:grid-cols-4 lg:border-l lg:border-t-0 lg:pt-0">

            <span class="px-4">
                <strong class="block font-['Inter'] text-lg font-semibold leading-tight">
                    5000+
                </strong>

                <small class="block text-[10px] font-medium text-white/90">
                    Jobs Listed
                </small>
            </span>

            <span class="px-4">
                <strong class="block font-['Inter'] text-lg font-semibold leading-tight">
                    10,000+
                </strong>

                <small class="block text-[10px] font-medium text-white/90">
                    Fresher Hired
                </small>
            </span>

            <span class="px-4">
                <strong class="block font-['Inter'] text-lg font-semibold leading-tight">
                    1000+
                </strong>

                <small class="block text-[10px] font-medium text-white/90">
                    Companies
                </small>
            </span>

            <span class="px-4">
                <strong class="block font-['Inter'] text-lg font-semibold leading-tight">
                    50+
                </strong>

                <small class="block text-[10px] font-medium text-white/90">
                    Training Partners
                </small>
            </span>

        </div>

    </div>
</footer>