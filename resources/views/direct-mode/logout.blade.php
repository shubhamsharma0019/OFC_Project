@php
    $logoutPage = [
        'brandName' => config('app.name', 'OnlyFreshers'),
        'brandUrl' => url('/'),
        'logoUrl' => asset('ofclogo1.svg'),
        'loginUrl' => url('/direct-mode/login'),
        'homeUrl' => url('/'),
        'logoutEndpoint' => url('/api/auth/logout'),
        'redirectDelay' => 900,
        'tokenKeys' => ['onlyfreshers_token', 'ofc_fresher_token', 'ofc_auth_token'],
        'userKeys' => ['onlyfreshers_user', 'ofc_fresher_user', 'ofc_auth_user'],
        'clearKeys' => [
            'onlyfreshers_token',
            'onlyfreshers_user',
            'onlyfreshers_mode',
            'onlyfreshers_direct_profile_extra',
            'onlyfreshers_settings_prefs',
            'onlyfreshers_offer_statuses',
            'onlyfreshers_saved_jobs',
            'onlyfreshers_saved_searches',
            'ofc_auth_token',
            'ofc_auth_user',
            'ofc_fresher_token',
            'ofc_fresher_user',
            'fast_track_course_id',
        ],
        'messages' => [
            'initialTitle' => 'Logging you out',
            'initialCopy' => 'Please wait while we safely end your Direct Mode session.',
            'initialCopyWithName' => 'Please wait while we safely end {name} Direct Mode session.',
            'successTitle' => 'Logged out successfully',
            'successCopy' => 'Redirecting you to the Direct Mode login page.',
            'noSessionCopy' => 'Your session is already cleared. Redirecting you to login.',
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $logoutPage['messages']['initialTitle'] }} - {{ $logoutPage['brandName'] }}</title>
    @include('components.common.auth-storage')
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:Arial,Helvetica,sans-serif;color:#06123f;background:linear-gradient(135deg,#fff,#f2f7ff);display:grid;place-items:center;padding:24px}.card{width:min(440px,100%);border:1px solid #d8e4f7;border-radius:10px;background:#fff;box-shadow:0 18px 40px rgba(6,25,66,.08);padding:32px;text-align:center}.brand{display:flex;justify-content:center;margin-bottom:22px}.brand img{width:220px;max-width:100%;height:auto}.mark{width:58px;height:58px;margin:0 auto 18px;border-radius:16px;background:#eaf2ff;color:#075fe4;display:grid;place-items:center}.mark svg{width:28px;height:28px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.loader{width:36px;height:36px;margin:18px auto;border:4px solid #e4ecfb;border-top-color:#075fe4;border-radius:50%;animation:spin .8s linear infinite}h1{margin:0 0 8px;font-size:26px;line-height:1.2}p{margin:0;color:#41527d;font-size:14px;line-height:1.55}.actions{display:flex;gap:12px;justify-content:center;margin-top:22px;flex-wrap:wrap}.btn{height:40px;border-radius:7px;border:1px solid #075fe4;padding:0 18px;font-weight:800;font-size:13px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}.primary{background:#075fe4;color:#fff}.outline{background:#fff;color:#075fe4}@keyframes spin{to{transform:rotate(360deg)}}@media(max-width:520px){.card{padding:24px}.brand img{width:190px}h1{font-size:23px}}
    </style>
</head>
<body>
    <main class="card">
        <a class="brand" href="{{ $logoutPage['brandUrl'] }}"><img src="{{ $logoutPage['logoUrl'] }}" alt="{{ $logoutPage['brandName'] }}" onerror="this.style.display='none'"></a>
        <div class="mark"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><path d="m16 17 5-5-5-5"></path><path d="M21 12H9"></path></svg></div>
        <h1 data-title>{{ $logoutPage['messages']['initialTitle'] }}</h1>
        <p data-copy>{{ $logoutPage['messages']['initialCopy'] }}</p>
        <div class="loader" data-loader></div>
        <div class="actions" hidden data-actions>
            <a class="btn primary" href="{{ $logoutPage['loginUrl'] }}">Go to Login</a>
            <a class="btn outline" href="{{ $logoutPage['homeUrl'] }}">Go Home</a>
        </div>
    </main>

    <script>
        const logoutPage = @json($logoutPage);
        const parseJson = value => {
            try {
                return JSON.parse(value || 'null');
            } catch (error) {
                return null;
            }
        };
        const firstStoredValue = keys => keys.map(key => localStorage.getItem(key)).find(Boolean) || '';
        const token = firstStoredValue(logoutPage.tokenKeys);
        const user = logoutPage.userKeys.map(key => parseJson(localStorage.getItem(key))).find(Boolean) || {};
        const userName = String(user.name || '').trim();
        const titleEl = document.querySelector('[data-title]');
        const copyEl = document.querySelector('[data-copy]');
        const loaderEl = document.querySelector('[data-loader]');
        const actionsEl = document.querySelector('[data-actions]');

        if (userName && copyEl) {
            copyEl.textContent = logoutPage.messages.initialCopyWithName.replace('{name}', `${userName}'s`);
        }

        const clearSession = () => logoutPage.clearKeys.forEach(key => localStorage.removeItem(key));
        const finish = (message = logoutPage.messages.successCopy) => {
            clearSession();
            if (titleEl) titleEl.textContent = logoutPage.messages.successTitle;
            if (copyEl) copyEl.textContent = message;
            if (loaderEl) loaderEl.style.display = 'none';
            if (actionsEl) actionsEl.hidden = false;
            setTimeout(() => window.location.replace(logoutPage.loginUrl), Number(logoutPage.redirectDelay || 900));
        };

        (async () => {
            if (!token) {
                finish(logoutPage.messages.noSessionCopy);
                return;
            }
            try {
                await fetch(logoutPage.logoutEndpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
            } catch (error) {
            } finally {
                finish();
            }
        })();
    </script>
</body>
</html>
