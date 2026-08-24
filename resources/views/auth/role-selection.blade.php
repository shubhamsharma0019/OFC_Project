@php
    $mode = ($mode ?? request('mode', 'login')) === 'register' ? 'register' : 'login';
    $isRegister = $mode === 'register';
    $title = $isRegister ? 'Register as' : 'Login as';
    $actionText = $isRegister ? 'Create account' : 'Continue';
    $switchText = $isRegister ? 'Already have an account?' : 'New to OnlyFreshers?';
    $switchUrl = $isRegister ? '/login' : '/register';
    $switchLabel = $isRegister ? 'Login' : 'Register';
    $roles = [
        [
            'label' => 'Company',
            'text' => 'Post fresher jobs, review candidates and manage hiring.',
            'icon' => 'briefcase',
            'href' => '/company/' . $mode,
        ],
        [
            'label' => 'Fresher',
            'text' => 'Apply to jobs, complete assessments and track applications.',
            'icon' => 'user',
            'href' => '/fresher/' . $mode,
        ],
        [
            'label' => 'Training Partner',
            'text' => 'Publish courses, manage students and track training progress.',
            'icon' => 'book',
            'href' => '/training-partner/' . $mode,
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - OnlyFreshers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; font-family: Arial, Helvetica, sans-serif; color: #061942; background: linear-gradient(130deg, #ffffff, #dfeeff); }
        a { color: inherit; text-decoration: none; }
        .page { min-height: 100vh; display: grid; place-items: center; padding: 28px; }
        .shell { width: min(1040px, 100%); }
        .brand { display: inline-flex; margin-bottom: 42px; }
        .brand img { width: min(255px, 72vw); height: 64px; object-fit: contain; object-position: left center; }
        .panel { border-radius: 22px; background: #ffffff; box-shadow: 0 24px 58px rgba(6, 25, 66, .10); padding: 34px; }
        .head { text-align: center; margin-bottom: 28px; }
        .head h1 { margin: 0; font-size: 34px; font-weight: 700; line-height: 1.15; }
        .head h1 span { color: #075fe4; }
        .head p { margin: 12px auto 0; max-width: 560px; color: #52607a; font-size: 15px; line-height: 1.5; font-weight: 600; }
        .roles { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .role { min-height: 228px; border: 1px solid #d8e4fb; border-radius: 12px; background: #fbfdff; padding: 22px; display: flex; flex-direction: column; gap: 18px; transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease; }
        .role:hover { transform: translateY(-4px); border-color: #075fe4; box-shadow: 0 18px 34px rgba(7, 95, 228, .12); }
        .icon { width: 48px; height: 48px; border-radius: 12px; display: grid; place-items: center; background: #eaf2ff; color: #075fe4; }
        .icon svg { width: 25px; height: 25px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .role h2 { margin: 0; font-size: 21px; font-weight: 800; }
        .role p { margin: 0; color: #4d5d7a; font-size: 14px; line-height: 1.55; }
        .cta { margin-top: auto; height: 42px; border-radius: 9px; display: inline-flex; align-items: center; justify-content: center; background: #075fe4; color: #ffffff; font-size: 14px; font-weight: 800; }
        .switch { margin: 22px 0 0; text-align: center; color: #52607a; font-size: 14px; font-weight: 600; }
        .switch a { color: #075fe4; font-weight: 800; }
        @media (max-width: 860px) { .roles { grid-template-columns: 1fr; } .panel { padding: 24px; } .brand { margin-bottom: 24px; } .head h1 { font-size: 28px; } .role { min-height: 0; } }
    </style>
</head>
<body>
    <main class="page">
        <section class="shell">
            <a class="brand" href="/">
                <img src="/ofclogo1.svg" alt="OnlyFreshers Logo">
            </a>

            <div class="panel">
                <div class="head">
                    <h1>{{ $title }} <span>OnlyFreshers</span></h1>
                    <p>Select your account type to open the right {{ $mode }} page.</p>
                </div>

                <div class="roles">
                    @foreach ($roles as $role)
                        <a class="role" href="{{ $role['href'] }}">
                            <span class="icon" data-icon="{{ $role['icon'] }}"></span>
                            <h2>As a {{ $role['label'] }}</h2>
                            <p>{{ $role['text'] }}</p>
                            <span class="cta">{{ $actionText }}</span>
                        </a>
                    @endforeach
                </div>

                <p class="switch">{{ $switchText }} <a href="{{ $switchUrl }}">{{ $switchLabel }}</a></p>
            </div>
        </section>
    </main>

    <script>
        const icons = {
            briefcase: '<svg viewBox="0 0 24 24"><path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"></path><rect x="3" y="6" width="18" height="14" rx="2"></rect><path d="M3 12h18"></path></svg>',
            user: '<svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"></path><circle cx="12" cy="7" r="4"></circle></svg>',
            book: '<svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"></path></svg>'
        };

        document.querySelectorAll('[data-icon]').forEach((item) => {
            item.innerHTML = icons[item.dataset.icon] || '';
        });
    </script>
</body>
</html>
