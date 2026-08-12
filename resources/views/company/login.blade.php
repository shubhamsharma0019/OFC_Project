<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login</title>
    <style>
        *{box-sizing:border-box}html,body{min-height:100%;overflow-x:hidden}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#071849;background:#fff;font-weight:500}a{text-decoration:none;color:inherit}.page{min-height:100vh;background:linear-gradient(135deg,#fff,#f7fbff);display:grid;grid-template-rows:auto 1fr auto}.topbar{height:86px;border-bottom:1px solid #dbe5f5;background:rgba(255,255,255,.86);display:flex;align-items:center;padding:0 36px}.logo{display:inline-flex;align-items:center}.logo img{width:255px;max-height:58px;object-fit:contain;object-position:left center}.logo-fallback{display:none;align-items:center;gap:12px;color:#075fe4;font-size:24px;font-weight:900}.logo-fallback b{display:grid;place-items:center;width:44px;height:44px;border-radius:12px;background:#075fe4;color:#fff;font-size:17px}.main-wrap{width:100%;max-width:1320px;margin:0 auto;padding:42px 28px 28px}.auth-card{min-height:630px;border:1px solid #d9e5f7;border-radius:18px;background:#fff;box-shadow:0 18px 44px rgba(6,25,66,.08);display:grid;grid-template-columns:minmax(420px,43%) minmax(0,57%);overflow:hidden}.intro{position:relative;overflow:hidden;background:linear-gradient(145deg,#f5f9ff,#eef6ff)}.intro:before,.intro:after{content:"";position:absolute;border-radius:999px;background:rgba(255,255,255,.58)}.intro:before{width:140px;height:140px;right:-45px;top:36px}.intro:after{width:235px;height:235px;right:-58px;bottom:85px;background:rgba(218,235,255,.72)}.illustration{display:flex;align-items:center;justify-content:center}.illustration img{width:100%;height:100%;object-fit:contain;object-position:center center}.form-side{padding:48px 52px;display:flex;align-items:center}.form-shell{width:100%;max-width:600px;margin:0 auto}.form-shell h2{margin:0 0 10px;font-size:25px;line-height:1.2;font-weight:900}.form-shell>p{margin:0 0 34px;color:#566891;font-size:15px}.tabs{display:grid;grid-template-columns:1fr 1fr;height:56px;border:1px solid #d8e2f4;border-radius:7px;overflow:hidden;margin-bottom:36px}.tab{border:0;background:#fff;color:#4c5d83;font-size:14px;font-weight:900;display:flex;align-items:center;justify-content:center;gap:10px;cursor:pointer}.tab svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}.tab.active{color:#075fe4;border-bottom:3px solid #075fe4}.login-alert{display:none;margin:-14px 0 18px;border:1px solid #ffc9d2;border-radius:8px;background:#fff1f3;color:#c8102e;padding:11px 14px;font-size:13px;font-weight:800;line-height:1.45}.login-alert.show{display:flex;align-items:center;gap:10px}.login-alert svg{width:18px;height:18px;flex:0 0 auto;fill:none;stroke:currentColor;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}.field{margin-bottom:22px}label{display:block;margin-bottom:10px;font-size:13px;font-weight:900}.control{height:54px;border:1px solid #d4def0;border-radius:8px;background:#fff;display:grid;grid-template-columns:50px 1fr;align-items:center;overflow:hidden}.control:focus-within{border-color:#075fe4;box-shadow:0 0 0 3px rgba(7,95,228,.08)}.control.password{grid-template-columns:50px 1fr 50px}.input-icon{height:100%;display:flex;align-items:center;justify-content:center;color:#657493}.input-icon svg{width:21px;height:21px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}input{width:100%;height:100%;border:0;outline:0;background:transparent;color:#071849;font-size:14px;padding:0 8px}input::placeholder{color:#7d8caf}.eye{border:0;background:transparent;color:#657493;display:flex;align-items:center;justify-content:center;cursor:pointer}.eye svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.row{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:-2px 0 24px;color:#4a5c83;font-size:14px}.row label{margin:0;display:flex;align-items:center;gap:10px;font-weight:500}.row input{width:17px;height:17px}.row a{color:#075fe4;font-weight:800}.primary{width:100%;height:50px;border:0;border-radius:8px;background:#075fe4;color:#fff;font-size:16px;font-weight:900;cursor:pointer;box-shadow:0 10px 20px rgba(7,95,228,.18)}.primary:disabled{opacity:.7;cursor:not-allowed}.divider{display:flex;align-items:center;gap:24px;margin:30px 0 20px;color:#5d6d90;font-size:13px}.divider:before,.divider:after{content:"";height:1px;background:#dfe6f2;flex:1}.social-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.social{height:54px;border:1px solid #d8e2f4;border-radius:8px;background:#fff;display:flex;align-items:center;justify-content:center;gap:12px;font-size:14px;font-weight:900;cursor:pointer}.social span{font-size:22px}.google span{color:#ea4335}.linkedin span{display:grid;place-items:center;width:20px;height:20px;border-radius:3px;background:#0a66c2;color:#fff;font-size:15px}.facebook span{display:grid;place-items:center;width:22px;height:22px;border-radius:50%;background:#1877f2;color:#fff;font-size:16px}.safe-note{margin-top:34px;min-height:52px;border-radius:8px;background:#eef5ff;color:#41527d;display:flex;align-items:center;gap:13px;padding:13px 16px;font-size:13px}.safe-note svg{width:22px;height:22px;color:#075fe4;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.footer{display:flex;align-items:center;justify-content:center;gap:26px;flex-wrap:wrap;color:#526283;font-size:13px;padding:15px 20px 26px}.footer span{color:#9aa8bf}@media(min-width:1051px){html,body{height:100%;overflow:hidden}.page{height:100vh;min-height:0;grid-template-rows:88px minmax(0,1fr) 54px}.topbar{height:88px;padding:0 32px}.logo img{width:265px;max-height:60px}.main-wrap{height:100%;padding:38px 28px 20px;display:flex;align-items:center}.auth-card{width:100%;max-width:1320px;min-height:0;height:100%;max-height:780px;margin:0 auto;grid-template-columns:minmax(420px,43%) minmax(0,57%)}.intro{display:flex;align-items:center;justify-content:center;padding:42px 44px 70px}.illustration{position:relative;width:100%;height:100%;min-height:0}.illustration img{max-height:calc(100% - 34px)}.form-side{padding:48px 58px}.form-shell h2{font-size:26px}.form-shell>p{margin-bottom:34px}.tabs{height:58px;margin-bottom:36px}.control{height:55px}.primary{height:51px}.social{height:55px}.footer{height:54px;padding:0 20px 10px;font-size:13px}}@media(min-width:1051px) and (max-height:880px){.page{grid-template-rows:76px minmax(0,1fr) 42px}.topbar{height:76px}.logo img{width:238px;max-height:52px}.main-wrap{padding:22px 28px 14px}.intro{padding:28px 40px 56px}.illustration img{max-height:calc(100% - 28px)}.form-side{padding:32px 54px}.form-shell h2{font-size:24px}.form-shell>p{margin-bottom:24px}.tabs{height:52px;margin-bottom:24px}.field{margin-bottom:16px}label{margin-bottom:8px}.control{height:48px}.row{margin:0 0 18px}.primary{height:48px}.divider{margin:22px 0 16px}.social{height:48px}.safe-note{margin-top:22px;min-height:46px}.footer{height:42px;padding:0 20px 6px;font-size:12px}}@media(max-width:1050px){.auth-card{grid-template-columns:1fr}.intro{min-height:420px;padding:26px 20px 46px}.illustration{height:330px}.form-side{padding:38px 32px}}@media(max-width:720px){.topbar{height:auto;padding:20px}.logo img{width:230px}.main-wrap{padding:24px 14px}.auth-card{border-radius:14px}.intro{min-height:auto}.illustration{height:300px}.form-side{padding:30px 18px}.tabs{margin-bottom:24px}.social-grid{grid-template-columns:1fr}.row{align-items:flex-start;flex-direction:column}.footer{gap:14px}}
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <a class="logo" href="/">
                <img src="/ofclogo1.svg" alt="OnlyFreshers Logo" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <span class="logo-fallback"><b>OF</b>OnlyFreshers</span>
            </a>
        </header>

        <div class="main-wrap">
            <section class="auth-card">
                <aside class="intro">
                    <div class="illustration">
                        <img src="/study.svg" alt="Company hiring freshers" onerror="this.src='/direct.svg'">
                    </div>
                </aside>

                <section class="form-side">
                    <div class="form-shell">
                        <h2>Login to Your Account</h2>
                        <p>Enter your credentials to access your company account</p>

                        <div class="tabs">
                            <button class="tab" type="button" onclick="window.location.href='/company/register'">
                                <span data-icon="user-plus"></span>
                                Register
                            </button>
                            <button class="tab active" type="button">
                                <span data-icon="login"></span>
                                Login
                            </button>
                        </div>

                        <form id="companyLoginForm">
                            <div class="login-alert" id="companyLoginAlert" role="alert">
                                <span data-icon="alert"></span>
                                <span id="companyLoginAlertText"></span>
                            </div>

                            <div class="field">
                                <label>Email Address</label>
                                <div class="control">
                                    <span class="input-icon" data-icon="mail"></span>
                                    <input id="email" name="email" type="email" value="demo.company@onlyfreshers.test" placeholder="Enter your email address" required>
                                </div>
                            </div>

                            <div class="field">
                                <label>Password</label>
                                <div class="control password">
                                    <span class="input-icon" data-icon="lock"></span>
                                    <input id="password" name="password" type="password" value="Company@123" placeholder="Enter your password" required>
                                    <button class="eye" type="button" data-toggle-password aria-label="Show password">
                                        <span data-icon="eye"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <label><input type="checkbox" checked> Remember me</label>
                                <a href="#">Forgot Password?</a>
                            </div>

                            <button class="primary" type="submit" id="companyLoginButton">Login</button>

                            <div class="divider">or continue with</div>

                            <div class="social-grid">
                                <button class="social google" type="button"><span>G</span> Google</button>
                                <button class="social linkedin" type="button"><span>in</span> LinkedIn</button>
                                <button class="social facebook" type="button"><span>f</span> Facebook</button>
                            </div>

                            <div class="safe-note">
                                <span data-icon="shield-check"></span>
                                Your company data is safe with us. We never share your information.
                            </div>
                        </form>
                    </div>
                </section>
            </section>
        </div>

        <footer class="footer">
            <p>&copy; 2024 OnlyFreshers. All rights reserved.</p>
            <span>|</span>
            <a href="#">Privacy Policy</a>
            <span>|</span>
            <a href="#">Terms & Conditions</a>
            <span>|</span>
            <a href="#">Contact Us</a>
        </footer>
    </main>

    <script>
        const icons = {
            'shield-check':'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-4"></path></svg>',
            'user-plus':'<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M19 8v6"></path><path d="M22 11h-6"></path></svg>',
            login:'<svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><path d="m10 17 5-5-5-5"></path><path d="M15 12H3"></path></svg>',
            mail:'<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>',
            lock:'<svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V7a4 4 0 0 1 8 0v4"></path></svg>',
            eye:'<svg viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
            alert:'<svg viewBox="0 0 24 24"><path d="M12 9v4"></path><path d="M12 17h.01"></path><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"></path></svg>'
        };

        document.querySelectorAll('[data-icon]').forEach(item => {
            item.innerHTML = icons[item.dataset.icon] || '';
        });

        document.querySelectorAll('[data-toggle-password]').forEach(button => button.addEventListener('click', () => {
            const input = button.parentElement.querySelector('input');
            input.type = input.type === 'password' ? 'text' : 'password';
        }));

        document.getElementById('companyLoginForm').addEventListener('submit', async event => {
            event.preventDefault();

            const button = document.getElementById('companyLoginButton');
            const alertBox = document.getElementById('companyLoginAlert');
            const alertText = document.getElementById('companyLoginAlertText');
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            alertBox.classList.remove('show');
            alertText.textContent = '';
            button.disabled = true;
            button.textContent = 'Logging in...';

            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email, password }),
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Login failed. Please try again.');
                }

                if (result.data.user.role !== 'company') {
                    throw new Error('Please login with a company account.');
                }

                [
                    'ofc_auth_token',
                    'ofc_auth_user',
                    'ofc_company_profile',
                    'onlyfreshers_company_token',
                    'onlyfreshers_company_user',
                    'onlyfreshers_token',
                    'onlyfreshers_user'
                ].forEach(key => localStorage.removeItem(key));

                localStorage.setItem('onlyfreshers_company_token', result.data.token);
                localStorage.setItem('onlyfreshers_company_user', JSON.stringify(result.data.user));
                window.location.href = '/company/dashboard';
            } catch (error) {
                alertText.textContent = error.message;
                alertBox.classList.add('show');
                button.disabled = false;
                button.textContent = 'Login';
            }
        });
    </script>
</body>
</html>
