@php
    $footerCta = $footerCta ?? config('onlyfreshers.footer.cta', []);
    $footerActions = $footerActions ?? config('onlyfreshers.footer.actions', []);
    $footerStats = $footerStats ?? config('onlyfreshers.footer.stats', []);
@endphp

<footer class="bg-white px-4 py-3">
    <div class="mx-auto flex w-full max-w-[1680px] flex-col gap-3 rounded-md bg-[#075fe4] px-5 py-3 text-white shadow-[0_10px_24px_rgba(7,95,228,0.22)] lg:flex-row lg:items-center lg:gap-6">
        <div class="flex min-w-0 flex-1 items-center gap-4">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center text-white [&>svg]:h-8 [&>svg]:w-8">
                @include('components.public.icon', ['name' => $footerCta['icon'] ?? 'rocket'])
            </span>
            <span class="min-w-0">
                <strong class="block font-['Inter'] text-sm font-semibold leading-tight">{{ $footerCta['title'] ?? 'Start Your Journey Today!' }}</strong>
                <small class="mt-1 block max-w-[420px] text-[11px] font-medium leading-4 text-white/90">{{ $footerCta['text'] ?? '' }}</small>
            </span>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 lg:w-[430px]">
            @foreach ($footerActions as $action)
                <a href="{{ $action['href'] ?? '#' }}" class="flex h-12 items-center justify-center rounded-md bg-white px-5 text-center font-['Inter'] text-sm font-semibold text-[#061942] shadow-[0_6px_14px_rgba(0,0,0,0.12)]">
                    <span>
                        {{ $action['title'] ?? '' }}
                        <small class="mt-0.5 block text-[10px] font-medium text-[#34445e]">{{ $action['subtitle'] ?? '' }}</small>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="grid flex-1 grid-cols-2 divide-x divide-white/30 border-t border-white/25 pt-3 text-center sm:grid-cols-4 lg:border-l lg:border-t-0 lg:pt-0">
            @foreach ($footerStats as $stat)
                <span class="px-4">
                    <strong class="block font-['Inter'] text-lg font-semibold leading-tight">{{ $stat['value'] ?? '0+' }}</strong>
                    <small class="block text-[10px] font-medium text-white/90">{{ $stat['label'] ?? '' }}</small>
                </span>
            @endforeach
        </div>
    </div>
</footer>
