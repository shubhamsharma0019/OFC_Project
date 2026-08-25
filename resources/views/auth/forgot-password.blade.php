@php
    $role = $role ?? 'fresher';
    $loginUrl = $loginUrl ?? '/direct-mode/login';
    $roleLabels = [
        'fresher' => 'Direct Mode',
        'company' => 'Company',
        'training_partner' => 'Training Partner',
    ];
    $roleLabel = $roleLabels[$role] ?? 'Account';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - OnlyFreshers</title>
    @include('components.common.auth-storage')
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:Arial,Helvetica,sans-serif;color:#071849;background:linear-gradient(135deg,#fff,#eaf3ff);display:grid;place-items:center;padding:20px}.card{width:min(620px,100%);border-radius:24px;background:#fff;padding:42px 44px;box-shadow:0 24px 60px rgba(6,25,66,.12)}.logo{display:flex;justify-content:center;margin-bottom:18px}.logo img{width:220px;max-width:100%}h1{margin:0;text-align:center;font-size:34px;line-height:1.15}.line{width:70px;height:3px;background:#0b66e4;border-radius:99px;margin:16px auto 18px}p{margin:0 0 24px;text-align:center;color:#526287;font-size:16px;font-weight:700}.alert{display:none;margin-bottom:18px;border-radius:9px;padding:12px 14px;font-size:14px;font-weight:800;line-height:1.45}.alert.show{display:block}.alert.error{border:1px solid #ffc9d2;background:#fff1f3;color:#c8102e}.alert.success{border:1px solid #b9e7c9;background:#f1fff5;color:#138a43}.field{margin-bottom:18px}label{display:block;margin-bottom:8px;font-size:14px;font-weight:900}.control{height:56px;border:1px solid #cbd8ee;border-radius:10px;background:#fff;display:flex;align-items:center;padding:0 16px}.control:focus-within{border-color:#0b66e4;box-shadow:0 0 0 3px rgba(11,102,228,.1)}input{width:100%;height:100%;border:0;outline:0;background:transparent;font-size:15px;color:#071849}.primary{width:100%;height:56px;border:0;border-radius:10px;background:#0b66e4;color:#fff;font-size:17px;font-weight:900;cursor:pointer;box-shadow:0 14px 28px rgba(11,102,228,.2)}.primary:disabled{opacity:.7;cursor:not-allowed}.back{display:block;margin-top:22px;text-align:center;color:#0b66e4;font-weight:900;text-decoration:none}@media(max-width:560px){.card{padding:30px 20px}h1{font-size:28px}}
    </style>
</head>
<body>
    <main class="card">
        <a class="logo" href="/"><img src="/ofclogo1.svg" alt="OnlyFreshers"></a>
        <h1>Reset Password</h1>
        <div class="line"></div>
        <p>{{ $roleLabel }} account password reset</p>

        <div class="alert" id="resetAlert"></div>

        <form id="resetForm" data-role="{{ $role }}" data-login-url="{{ $loginUrl }}">
            <div class="field">
                <label for="email">Email Address</label>
                <div class="control"><input id="email" name="email" type="email" placeholder="Enter your registered email" required></div>
            </div>
            <div class="field">
                <label for="password">New Password</label>
                <div class="control"><input id="password" name="password" type="password" placeholder="Example: Password@123" required></div>
            </div>
            <div class="field">
                <label for="password_confirmation">Confirm New Password</label>
                <div class="control"><input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password" required></div>
            </div>
            <button class="primary" id="resetButton" type="submit">Reset Password</button>
        </form>

        <a class="back" href="{{ $loginUrl }}">Back to Login</a>
    </main>

    <script>
        const form = document.getElementById('resetForm');
        const alertBox = document.getElementById('resetAlert');
        const button = document.getElementById('resetButton');

        function showAlert(message, type = 'error') {
            alertBox.textContent = message || '';
            alertBox.className = message ? `alert show ${type}` : 'alert';
        }

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            showAlert('');
            button.disabled = true;
            button.textContent = 'Resetting...';

            try {
                const response = await fetch('/api/auth/forgot-password', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        role: form.dataset.role,
                        email: form.email.value.trim(),
                        password: form.password.value,
                        password_confirmation: form.password_confirmation.value,
                    }),
                });
                const payload = await response.json().catch(() => ({}));
                if (!response.ok || payload.success === false) {
                    const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
                    throw new Error(validationMessage || payload.message || 'Password could not be reset.');
                }
                showAlert(payload.message || 'Password reset successfully.', 'success');
                setTimeout(() => {
                    window.location.href = payload.data?.login_url || form.dataset.loginUrl;
                }, 1200);
            } catch (error) {
                showAlert(error.message);
            } finally {
                button.disabled = false;
                button.textContent = 'Reset Password';
            }
        });
    </script>
</body>
</html>
