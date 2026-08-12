@php
    $features = [
        ['title' => 'Verified Jobs', 'text' => 'Apply to trusted fresher openings', 'icon' => 'shield'],
        ['title' => 'Direct Applications', 'text' => 'Connect with companies faster', 'icon' => 'send'],
        ['title' => 'Profile Reviews', 'text' => 'Showcase your resume and skills', 'icon' => 'file'],
        ['title' => 'Career Growth', 'text' => 'Track applications in one place', 'icon' => 'trend'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Mode Login</title>
    <style>
        *{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;color:#071849;background:#fff;font-weight:500}a{text-decoration:none;color:inherit}.page{min-height:100vh;padding:14px 20px 10px;background:linear-gradient(135deg,#fff,#f4f8ff)}.topbar{height:48px;display:flex;align-items:center;justify-content:flex-start;gap:18px;margin-bottom:12px}.logo{display:flex;align-items:center}.logo img{width:205px;max-height:48px;display:block;object-fit:contain;object-position:left center}.logo-fallback{display:none;align-items:center;gap:10px;color:#075fe4;font-size:22px;font-weight:800}.logo-fallback b{display:grid;place-items:center;width:38px;height:38px;border-radius:10px;background:#075fe4;color:#fff;font-size:16px}.icon{width:30px;height:30px;border-radius:9px;background:#edf4ff;color:#075fe4;display:inline-flex;align-items:center;justify-content:center;flex:0 0 auto}.icon svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.auth-card{border:1px solid #d8e4fb;border-radius:8px;background:#fff;box-shadow:0 14px 34px rgba(6,25,66,.08);display:grid;grid-template-columns:39% 61%;overflow:hidden}.intro{padding:36px 42px 24px;background:linear-gradient(145deg,#fff,#f6f9ff)}.intro h1{margin:0 0 14px;font-size:28px;line-height:1.3;font-weight:800;letter-spacing:0}.intro h1 span{color:#075fe4}.intro p{margin:0;color:#41527d;font-size:13px;line-height:1.6;max-width:420px}.illustration{margin-top:20px;display:flex;justify-content:center}.illustration img{width:min(390px,100%);height:300px;object-fit:contain;object-position:center bottom}.form-wrap{padding:18px 30px 14px;display:flex;align-items:center}.form-panel{width:100%;border:1px solid #dfe6f5;border-radius:8px;padding:16px 20px 14px;background:#fff}.tabs{display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid #dfe6f5;margin-bottom:18px}.tab{height:36px;border:0;background:transparent;color:#657190;font-size:15px;font-weight:800;cursor:pointer}.tab.active{color:#075fe4;border-bottom:3px solid #075fe4}.login-box{max-width:500px;margin:0 auto}.field{margin-bottom:16px}label{display:block;margin-bottom:6px;font-size:11px;font-weight:800}label span{color:#ff2036}.control{height:38px;border:1px solid #cfd8eb;border-radius:6px;display:grid;grid-template-columns:42px 1fr;align-items:center;background:#fff;overflow:hidden}.control .input-icon{height:100%;border-right:1px solid #dfe6f5;display:flex;align-items:center;justify-content:center;color:#657190}.input-icon svg{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}input{width:100%;height:100%;border:0;outline:0;padding:0 12px;font-size:12px;color:#071849;background:transparent}input::placeholder{color:#6e7da2}.password{grid-template-columns:42px 1fr 42px}.eye{border:0;background:transparent;color:#657190;cursor:pointer;font-size:11px}.row{display:flex;align-items:center;justify-content:space-between;gap:14px;margin:0 0 14px;font-size:11px;color:#41527d}.row input{width:16px;height:16px}.row a{color:#075fe4;font-weight:800}.primary{width:100%;height:38px;border:0;border-radius:6px;background:#075fe4;color:#fff;font-size:13px;font-weight:800;cursor:pointer}.divider{display:flex;align-items:center;gap:16px;margin:14px auto 12px;max-width:260px;color:#657190;font-size:12px}.divider:before,.divider:after{content:"";height:1px;background:#e3e8f4;flex:1}.google{height:36px;width:100%;display:flex;align-items:center;justify-content:center;gap:12px;border:1px solid #d2dbea;border-radius:6px;background:#fff;font-size:12px;font-weight:800;cursor:pointer}.google span{color:#ea4335;font-size:16px}.switch{text-align:center;margin:12px 0 0;color:#657190;font-size:11px}.switch a{color:#075fe4;font-weight:800}.feature-bar{margin-top:14px;border:1px solid #dfe6f5;border-radius:8px;background:#fff;display:grid;grid-template-columns:repeat(4,1fr);gap:0;padding:10px 18px}.feature{display:flex;align-items:center;gap:12px;padding:0 16px;border-right:1px solid #eef2f8}.feature:last-child{border-right:0}.feature h3{margin:0 0 4px;font-size:12px}.feature p{margin:0;color:#41527d;font-size:10px}.copyright{text-align:center;color:#41527d;font-size:10px;margin:10px 0 0}@media(max-width:1100px){.auth-card{grid-template-columns:1fr}.intro{padding:28px}.illustration img{height:260px}.feature-bar{grid-template-columns:repeat(2,1fr);gap:14px}.feature{border-right:0}}@media(max-width:760px){.page{padding:12px}.topbar{height:auto;flex-direction:column;align-items:flex-start}.logo img{width:205px}.form-wrap{padding:14px}.form-panel{padding:16px}.intro h1{font-size:24px}.intro p{font-size:12px}.feature-bar{grid-template-columns:1fr}.feature{padding:8px 0}.row{align-items:flex-start;flex-direction:column}}
    html,body{min-height:100%;overflow-x:hidden}.page{min-height:100vh;display:grid;grid-template-rows:auto minmax(0,1fr) auto auto;gap:14px;padding:18px 22px 12px!important}.topbar{height:auto!important;min-height:52px;margin-bottom:0!important;max-width:1280px;width:100%;margin-left:auto;margin-right:auto}.auth-card{max-width:1280px;width:100%;margin:0 auto;grid-template-columns:minmax(360px,39%) minmax(0,1fr)!important;min-height:0}.intro{min-width:0;display:flex;flex-direction:column;justify-content:center;padding:32px 40px!important}.intro h1{max-width:430px}.illustration{min-height:0;margin-top:18px!important}.illustration img{width:min(360px,100%)!important;height:270px!important}.form-wrap{min-width:0;padding:18px 28px!important;align-items:center!important}.form-panel{min-width:0;padding:22px 22px!important}.login-box{width:100%;max-width:500px!important}.field{min-width:0}.control{min-width:0}.control input{min-width:0}.row label{min-width:0}.terms span{line-height:1.4}.feature-bar{max-width:1280px;width:100%;margin:0 auto!important;grid-template-columns:repeat(4,minmax(0,1fr))!important;padding:12px 18px!important}.feature{min-width:0}.feature div{min-width:0}.feature h3,.feature p{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.copyright{margin:0!important}@media(max-width:1120px){.page{display:block}.topbar{margin-bottom:14px!important}.auth-card{grid-template-columns:1fr!important}.intro{padding:26px 28px!important}.illustration img{height:230px!important}.feature-bar{grid-template-columns:repeat(2,minmax(0,1fr))!important;margin-top:14px!important}.feature:nth-child(2n){border-right:0}.feature{padding:8px 10px!important}}@media(max-width:760px){.page{padding:14px!important}.topbar{align-items:flex-start!important}.intro{padding:22px!important}.intro h1{font-size:24px!important}.illustration img{height:190px!important}.form-wrap{padding:14px!important}.form-panel{padding:16px!important}.feature-bar{grid-template-columns:1fr!important}.feature{border-right:0!important;border-bottom:1px solid #eef2f8}.feature:last-child{border-bottom:0}.row{flex-direction:row!important;align-items:center!important;flex-wrap:wrap}.google{width:100%!important;min-width:0!important}}
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

        <section class="auth-card">
            <div class="intro">
                <h1>Welcome Back to <span>OnlyFreshers</span></h1>
                <p>Login to continue applying for jobs, tracking applications and building your fresher profile.</p>
                <div class="illustration"><img src="/direct.svg" alt="Direct mode login"></div>
            </div>

            <div class="form-wrap">
                <div class="form-panel">
                    <div class="tabs">
                        <button class="tab active" type="button">Login</button>
                        <button class="tab" type="button" onclick="window.location.href='/direct-mode/register'">Register</button>
                    </div>

                    <form class="login-box">
                        <div class="field"><label>Email Address <span>*</span></label><div class="control"><span class="input-icon" data-icon="mail"></span><input type="email" placeholder="Enter your email"></div></div>
                        <div class="field"><label>Password <span>*</span></label><div class="control password"><span class="input-icon" data-icon="lock"></span><input type="password" placeholder="Enter your password"><button class="eye" type="button" data-toggle-password>Show</button></div></div>
                        <div class="row"><label style="margin:0;display:flex;align-items:center;gap:10px"><input type="checkbox"> Remember me</label><a href="#">Forgot password?</a></div>
                        <button class="primary" type="button">Login</button>
                        <div class="divider">OR</div>
                        <button class="google" type="button"><span>G</span> Continue with Google</button>
                        <p class="switch">Don't have an account? <a href="/direct-mode/register">Register</a></p>
                    </form>
                </div>
            </div>
        </section>

        <section class="feature-bar" id="features"></section>
        <p class="copyright">&copy; 2024 OnlyFreshers. All rights reserved.</p>
    </main>

    <script>
        const icons = {
            shield:'<svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-4"></path></svg>',
            send:'<svg viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>',
            file:'<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path></svg>',
            trend:'<svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-8"></path><path d="M14 7h7v7"></path></svg>',
            mail:'<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>',
            lock:'<svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V7a4 4 0 0 1 8 0v4"></path></svg>'
        };
        const features = @json($features);
        document.getElementById('features').innerHTML = features.map(item => `<article class="feature"><span class="icon">${icons[item.icon]}</span><div><h3>${item.title}</h3><p>${item.text}</p></div></article>`).join('');
        document.querySelectorAll('[data-icon]').forEach(item => item.innerHTML = icons[item.dataset.icon]);
        document.querySelectorAll('[data-toggle-password]').forEach(button => button.addEventListener('click', () => {
            const input = button.parentElement.querySelector('input');
            input.type = input.type === 'password' ? 'text' : 'password';
            button.textContent = input.type === 'password' ? 'Show' : 'Hide';
        }));
    </script>
</body>
</html>

