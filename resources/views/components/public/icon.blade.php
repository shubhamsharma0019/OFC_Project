@php
    $name = $name ?? 'spark';
    $paths = [
        'check' => '<path d="M20 6 9 17l-5-5"></path>',
        'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><path d="M3 12h18"></path>',
        'certificate' => '<path d="M6 3h12v18l-6-3-6 3z"></path><path d="M9 8h6M9 12h6"></path>',
        'chart' => '<path d="M3 3v18h18"></path><path d="m7 15 4-4 3 3 5-7"></path>',
        'code' => '<path d="m10 9-3 3 3 3"></path><path d="m14 9 3 3-3 3"></path><path d="m13 5-2 14"></path>',
        'company' => '<path d="M3 21h18"></path><path d="M5 21V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v16"></path><path d="M19 21V9h-3"></path><path d="M9 7h2M9 11h2M9 15h2"></path>',
        'data' => '<ellipse cx="12" cy="5" rx="7" ry="3"></ellipse><path d="M5 5v6c0 1.7 3.1 3 7 3s7-1.3 7-3V5"></path><path d="M5 11v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"></path>',
        'document' => '<path d="M14 2H6a2 2 0 0 0-2 2v16h16V8z"></path><path d="M14 2v6h6"></path><path d="M8 13h8M8 17h5"></path>',
        'eye' => '<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"></path><circle cx="12" cy="12" r="3"></circle>',
        'growth' => '<path d="M4 19V5"></path><path d="M4 19h16"></path><path d="m8 15 4-4 3 3 5-7"></path>',
        'learn' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5z"></path>',
        'marketing' => '<path d="m3 11 18-5v12L3 13z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path>',
        'profile' => '<circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"></path>',
        'rocket' => '<path d="M4.5 16.5c-1 1-1.5 3-1.5 4.5 1.5 0 3.5-.5 4.5-1.5"></path><path d="M9 15 4 20"></path><path d="M15 9l-6 6"></path><path d="M14 4c2.5-.8 4.7-.7 6 0 .7 1.3.8 3.5 0 6l-4 4-6-6z"></path><circle cx="16" cy="8" r="1"></circle>',
        'search' => '<circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path>',
        'shield' => '<path d="M12 3 5 6v5c0 4.5 3 8.4 7 10 4-1.6 7-5.5 7-10V6z"></path><path d="m9.5 12 1.7 1.7 3.8-4"></path>',
        'spark' => '<path d="M12 2l2.6 6.4L21 11l-6.4 2.6L12 20l-2.6-6.4L3 11l6.4-2.6z"></path>',
        'star' => '<path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9z"></path>',
        'target' => '<circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="5"></circle><circle cx="12" cy="12" r="1"></circle>',
        'training' => '<path d="M2 7h20L12 2z"></path><path d="M5 10v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7"></path><path d="M9 14h6"></path>',
        'users' => '<circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><circle cx="17" cy="9" r="2.5"></circle><path d="M14 19c0-2.4 1.8-4 4-4"></path>',
    ];
@endphp

<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="0.95" stroke-linecap="round" stroke-linejoin="round">
    {!! $paths[$name] ?? $paths['spark'] !!}
</svg>
