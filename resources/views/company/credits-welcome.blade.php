<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Credits - OnlyFreshers</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:Arial,Helvetica,sans-serif;color:#061942;background:linear-gradient(135deg,#f8fbff 0%,#eef6ff 48%,#ffffff 100%);display:grid;place-items:center;padding:24px}.page{width:min(980px,100%)}.logo{display:inline-flex;align-items:center;margin-bottom:22px}.logo img{width:230px;max-height:56px;object-fit:contain}.card{position:relative;overflow:hidden;border:1px solid #d7e5f8;border-radius:18px;background:#fff;box-shadow:0 24px 70px rgba(6,25,66,.13);display:grid;grid-template-columns:minmax(0,1fr) 360px}.card:before{content:"";position:absolute;right:-80px;top:-90px;width:260px;height:260px;border-radius:50%;background:rgba(7,95,228,.08)}.content{position:relative;padding:46px 50px}.eyebrow{display:inline-flex;height:32px;align-items:center;border:1px solid #bcd4ff;border-radius:999px;background:#f1f7ff;color:#075fe4;padding:0 14px;font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.04em}.content h1{margin:20px 0 12px;font-size:38px;line-height:1.08;font-weight:900;color:#061942}.content p{margin:0;color:#3f506e;font-size:16px;line-height:1.65;max-width:560px}.credit-panel{margin:28px 0;display:grid;grid-template-columns:1fr 1fr;gap:14px}.credit-box{border:1px solid #dce8f8;border-radius:12px;background:#fbfdff;padding:18px}.credit-box strong{display:block;margin-bottom:7px;font-size:34px;line-height:1;color:#075fe4}.credit-box span{display:block;color:#52607a;font-size:13px;font-weight:800}.actions{display:flex;flex-wrap:wrap;gap:12px}.primary,.secondary{height:48px;border-radius:9px;padding:0 22px;font-size:14px;font-weight:900;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}.primary{border:1px solid #075fe4;background:#075fe4;color:#fff;box-shadow:0 12px 22px rgba(7,95,228,.18)}.secondary{border:1px solid #b8c9e2;background:#fff;color:#075fe4}.side{position:relative;min-height:100%;padding:34px 30px;background:linear-gradient(160deg,#075fe4,#043d9c);color:#fff;display:flex;flex-direction:column;justify-content:center}.coin{width:132px;height:132px;border-radius:50%;background:linear-gradient(145deg,#fff7c2,#ffc857);color:#061942;display:grid;place-items:center;margin:0 auto 24px;box-shadow:0 20px 40px rgba(0,0,0,.18);font-size:42px;font-weight:900}.side h2{margin:0 0 12px;font-size:24px;line-height:1.2}.side ul{margin:0;padding:0;list-style:none;display:grid;gap:12px}.side li{display:flex;gap:10px;align-items:flex-start;font-size:14px;line-height:1.45;color:#edf5ff}.side li:before{content:"✓";display:grid;place-items:center;flex:0 0 22px;width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,.18);font-weight:900}@media(max-width:820px){body{padding:16px}.card{grid-template-columns:1fr}.content{padding:34px 24px}.content h1{font-size:31px}.credit-panel{grid-template-columns:1fr}.side{padding:30px 24px}.logo img{width:205px}}
    </style>
</head>
<body>
    <main class="page">
        <a class="logo" href="/">
            <img src="/ofclogo1.svg" alt="OnlyFreshers">
        </a>

        <section class="card" role="dialog" aria-labelledby="creditsTitle" aria-describedby="creditsCopy">
            <div class="content">
                <span class="eyebrow">Company Welcome Bonus</span>
                <h1 id="creditsTitle">You have received 500 free credits.</h1>
                <p id="creditsCopy">
                    Your company account is ready to begin hiring. Use these credits to publish jobs and internships on OnlyFreshers. Each published job post will use 50 credits from your balance.
                </p>

                <div class="credit-panel" aria-label="Credit summary">
                    <div class="credit-box">
                        <strong>500</strong>
                        <span>Free credits added</span>
                    </div>
                    <div class="credit-box">
                        <strong>50</strong>
                        <span>Credits per job post</span>
                    </div>
                </div>

                <div class="actions">
                    <a class="primary" href="/company/profile/edit">Complete Company Profile</a>
                    <a class="secondary" href="/company/dashboard">Go to Dashboard</a>
                </div>
            </div>

            <aside class="side" aria-label="How credits work">
                <div class="coin">500</div>
                <h2>How your credits work</h2>
                <ul>
                    <li>Credits are available immediately after registration.</li>
                    <li>Publishing one job or internship deducts 50 credits.</li>
                    <li>When credits run out, choose a subscription plan to continue posting.</li>
                </ul>
            </aside>
        </section>
    </main>

    <script>
        localStorage.setItem('ofc_company_credits_welcome_seen', '1');
    </script>
</body>
</html>
