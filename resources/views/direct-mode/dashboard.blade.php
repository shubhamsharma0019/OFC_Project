@php
    $activePage = 'dashboard';
    $stats = [
        ['title' => 'Applied Jobs', 'value' => 12, 'note' => '+2 this week', 'tone' => 'blue-soft', 'icon' => 'briefcase'],
        ['title' => 'Assessments', 'value' => 3, 'note' => '1 Completed', 'tone' => 'green-soft', 'icon' => 'users'],
        ['title' => 'Interviews', 'value' => 2, 'note' => 'Upcoming', 'tone' => 'purple-soft', 'icon' => 'calendar'],
        ['title' => 'Offers', 'value' => 1, 'note' => 'Congratulations!', 'tone' => 'orange-soft', 'icon' => 'trophy'],
    ];
    $profileItems = [
        ['label' => 'Basic Information', 'done' => true],
        ['label' => 'Education', 'done' => true],
        ['label' => 'Skills', 'done' => true],
        ['label' => 'Resume Upload', 'done' => true],
        ['label' => 'Certifications', 'done' => false],
        ['label' => 'Work Experience', 'done' => false],
    ];
    $skills = [
        ['name' => 'Technical Skills', 'score' => 60],
        ['name' => 'Aptitude', 'score' => 70],
        ['name' => 'Communication', 'score' => 50],
    ];
    $notifications = [
        ['title' => 'New job matches found', 'text' => '14 new jobs match your profile', 'time' => '10m ago', 'icon' => 'briefcase', 'tone' => 'green-soft'],
        ['title' => 'Interview Scheduled', 'text' => 'TechNova Solutions', 'time' => '1h ago', 'icon' => 'calendar', 'tone' => 'purple-soft'],
        ['title' => 'Assessment Completed', 'text' => 'You scored 60% in Assessment', 'time' => '2h ago', 'icon' => 'file', 'tone' => 'orange-soft'],
        ['title' => 'Application Update', 'text' => 'Your application is under review', 'time' => '1d ago', 'icon' => 'bell', 'tone' => 'blue-soft'],
    ];
    $appliedJobs = [
        ['title' => 'Frontend Developer', 'company' => 'TechNova Solutions', 'location' => 'Bangalore, Karnataka', 'experience' => '0 - 1 Year', 'salary' => 'Rs 4 - 7 LPA', 'status' => 'Under Review', 'statusTone' => 'blue', 'logo' => 'TN', 'applied' => 'Applied 2d ago'],
        ['title' => 'Software Engineer', 'company' => 'InfoByte', 'location' => 'Hyderabad, Telangana', 'experience' => '0 - 2 Years', 'salary' => 'Rs 3 - 6 LPA', 'status' => 'Shortlisted', 'statusTone' => 'purple', 'logo' => 'IB', 'applied' => 'Applied 5d ago'],
        ['title' => 'React Developer', 'company' => 'CodeWave', 'location' => 'Pune, Maharashtra', 'experience' => '0 - 2 Years', 'salary' => 'Rs 4 - 6 LPA', 'status' => 'Interview Scheduled', 'statusTone' => 'orange', 'logo' => 'CW', 'applied' => 'Applied 1w ago'],
    ];
    $actions = [
        ['title' => 'Complete Profile', 'icon' => 'user', 'url' => '/direct-mode/profile'],
        ['title' => 'Take Assessment', 'icon' => 'clipboard', 'url' => '/direct-mode/assessments'],
        ['title' => 'Browse Jobs', 'icon' => 'briefcase', 'url' => '/direct-mode/jobs'],
        ['title' => 'My Applications', 'icon' => 'file', 'url' => '/direct-mode/applications'],
        ['title' => 'Interview Schedule', 'icon' => 'calendar', 'url' => '/direct-mode/interviews'],
        ['title' => 'Offers', 'icon' => 'trophy', 'url' => '/direct-mode/offers'],
    ];
@endphp

@extends('layouts.direct-mode')

@section('title', 'Dashboard - Direct Mode')

@push('styles')
<style>
    .dashboard{padding:20px 24px 28px}.dash-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:16px}.card{background:#fff;border:1px solid #dce7f8;border-radius:12px;box-shadow:0 10px 24px rgba(6,25,66,.04)}.stat-card{min-height:112px;padding:20px;display:grid;grid-template-columns:54px 1fr;gap:16px;align-items:center}.stat-icon,.dash-icon{width:52px;height:52px;border-radius:14px;display:grid;place-items:center}.blue-soft{background:#eaf2ff;color:#075fe4}.green-soft{background:#e1f8ec;color:#17a85d}.purple-soft{background:#efe7ff;color:#6d42e8}.orange-soft{background:#fff0dc;color:#f59b18}.stat-card h2{margin:0 0 5px;font-size:13px}.stat-card strong{display:block;font-size:28px;line-height:1}.stat-card small{display:block;margin-top:9px;color:#07883f;font-size:12px;font-weight:800}.middle{display:grid;grid-template-columns:1.15fr 1fr 1.08fr;gap:14px;margin-bottom:16px}.section{padding:22px}.section h2{margin:0 0 18px;font-size:16px}.profile-box{display:grid;grid-template-columns:155px 1fr;gap:24px;align-items:center}.ring{width:132px;height:132px;border-radius:50%;display:grid;place-items:center;position:relative;background:conic-gradient(#075fe4 0 75%,#e8edf6 75%)}.ring.score{width:104px;height:104px;background:conic-gradient(#075fe4 0 60%,#e8edf6 60%)}.ring:before{content:"";position:absolute;inset:17px;background:#fff;border-radius:50%}.ring span{position:relative;font-size:29px}.ring.score span{font-size:20px}.check-list{display:grid;gap:12px}.check-row{display:flex;align-items:center;gap:10px;color:#44577e;font-size:12px}.check{width:16px;height:16px;border-radius:50%;border:1px solid #9cafcd;display:grid;place-items:center;font-size:11px}.check.done{border:0;background:#19a85e;color:#fff}.score-wrap{display:grid;grid-template-columns:120px 1fr;align-items:center;gap:18px}.skill-row{display:grid;grid-template-columns:95px 1fr 36px;gap:10px;align-items:center;margin:13px 0;font-size:12px;font-weight:700}.bar{height:7px;border-radius:20px;background:#e8edf6;overflow:hidden}.bar span{display:block;height:100%;background:#075fe4}.notif-list{display:grid;gap:16px}.notif{display:grid;grid-template-columns:38px 1fr auto;gap:12px;align-items:center}.notif .dash-icon{width:38px;height:38px;border-radius:10px}.notif h3{margin:0 0 5px;font-size:13px}.notif p,.notif time{margin:0;color:#44577e;font-size:12px}.view{float:right;color:#075fe4;font-size:12px;font-weight:800}.bottom{display:grid;grid-template-columns:1.45fr .75fr;gap:14px}.job-list{display:grid}.job-row{display:grid;grid-template-columns:52px 1fr auto;gap:16px;align-items:center;padding:16px 0;border-bottom:1px solid #e6eef8}.job-row:last-child{border-bottom:0}.logo{width:48px;height:48px;border-radius:7px;background:#06356f;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px}.job-row h3{margin:0 0 5px;font-size:14px}.job-row p{margin:0 0 10px;color:#44577e;font-size:12px}.meta{display:flex;gap:18px;flex-wrap:wrap;color:#44577e;font-size:12px}.status{display:inline-flex;padding:8px 12px;border-radius:7px;font-size:12px;font-weight:800;background:#eaf2ff;color:#075fe4}.status.purple{background:#efe7ff;color:#6d42e8}.status.orange{background:#fff0dc;color:#f04b20}.job-side{text-align:right;color:#44577e;font-size:12px}.jobs-footer{text-align:center;padding-top:12px}.jobs-footer a{color:#075fe4;font-weight:800;font-size:13px}.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}.quick{height:78px;border:1px solid #dce7f8;border-radius:9px;background:#fff;display:grid;place-items:center;text-align:center;color:#075fe4;font-size:11px;font-weight:800;padding:8px}.boost-panel{margin-top:14px;min-height:150px;border-radius:10px;background:#eaf2ff;display:flex;align-items:center;justify-content:space-between;padding:24px;overflow:hidden}.boost-panel h3{margin:0 0 8px;color:#075fe4;font-size:17px;line-height:1.4}.boost-panel p{margin:0 0 16px;font-size:12px;color:#44577e}.rocket-mark{width:72px;height:72px;background:linear-gradient(135deg,#0d67ff,#163ade);clip-path:polygon(50% 0,82% 23%,68% 68%,100% 82%,65% 88%,50% 100%,35% 88%,0 82%,32% 68%,18% 23%);transform:rotate(35deg);flex:0 0 auto}@media(max-width:1200px){.middle,.bottom{grid-template-columns:1fr}.dash-stats{grid-template-columns:repeat(2,1fr)}}@media(max-width:720px){.dashboard{padding:14px}.dash-stats{grid-template-columns:1fr}.profile-box,.score-wrap{grid-template-columns:1fr}.quick-grid{grid-template-columns:repeat(2,1fr)}.job-row{grid-template-columns:1fr}.job-side{text-align:left}}
</style>
@endpush

@section('content')
<section class="dashboard">
    <div class="dash-stats">
        @foreach ($stats as $item)
            <article class="card stat-card"><span class="stat-icon {{ $item['tone'] }}" data-icon="{{ $item['icon'] }}"></span><div><h2>{{ $item['title'] }}</h2><strong>{{ $item['value'] }}</strong><small>{{ $item['note'] }}</small></div></article>
        @endforeach
    </div>
    <div class="middle">
        <article class="card section">
            <h2>Profile Completion</h2>
            <div class="profile-box"><div><div class="ring"><span>75%</span></div><a class="primary" href="/direct-mode/profile" style="margin-top:22px;background:#fff;color:#075fe4;border:1px solid #075fe4;display:inline-flex;align-items:center">Update Profile</a></div><div class="check-list"><strong style="font-size:12px">Great! Your profile is almost complete.</strong>@foreach ($profileItems as $item)<div class="check-row"><span class="check {{ $item['done'] ? 'done' : '' }}">{!! $item['done'] ? '&#10003;' : '' !!}</span><span>{{ $item['label'] }}</span></div>@endforeach</div></div>
        </article>
        <article class="card section">
            <h2>Assessment Score</h2>
            <div class="score-wrap"><div class="ring score"><span>60%</span></div><div><strong>Good job!</strong><p style="margin:8px 0 16px;color:#44577e;font-size:12px">Keep improving.</p></div></div>
            @foreach ($skills as $skill)<div class="skill-row"><span>{{ $skill['name'] }}</span><div class="bar"><span style="width:{{ $skill['score'] }}%"></span></div><strong>{{ $skill['score'] }}%</strong></div>@endforeach
            <a class="primary" href="/direct-mode/assessments" style="margin-top:12px;background:#fff;color:#075fe4;border:1px solid #075fe4;display:inline-flex;align-items:center">View Assessment</a>
        </article>
        <article class="card section">
            <h2>Latest Notifications <a class="view" href="#">View All</a></h2>
            <div class="notif-list">@foreach ($notifications as $item)<div class="notif"><span class="dash-icon {{ $item['tone'] }}" data-icon="{{ $item['icon'] }}"></span><div><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></div><time>{{ $item['time'] }}</time></div>@endforeach</div>
        </article>
    </div>
    <div class="bottom">
        <article class="card section">
            <h2>Recently Applied Jobs <a class="view" href="/direct-mode/applications">View All</a></h2>
            <div class="job-list">@foreach ($appliedJobs as $job)<div class="job-row"><span class="logo">{{ $job['logo'] }}</span><div><h3>{{ $job['title'] }}</h3><p>{{ $job['company'] }}</p><div class="meta"><span>{{ $job['location'] }}</span><span>{{ $job['experience'] }}</span><span>{{ $job['salary'] }}</span></div></div><div class="job-side"><p>{{ $job['applied'] }}</p><span class="status {{ $job['statusTone'] }}">{{ $job['status'] }}</span></div></div>@endforeach</div>
            <div class="jobs-footer"><a href="/direct-mode/applications">View All Applications</a></div>
        </article>
        <aside>
            <article class="card section"><h2>Quick Actions</h2><div class="quick-grid">@foreach ($actions as $item)<a class="quick" href="{{ $item['url'] }}"><span data-icon="{{ $item['icon'] }}"></span><span>{{ $item['title'] }}</span></a>@endforeach</div></article>
            <article class="boost-panel"><div><h3>Boost your profile &<br>get hired faster!</h3><p>Complete your profile and increase your chances.</p><a class="primary" href="/direct-mode/profile" style="display:inline-flex;align-items:center">Complete Profile</a></div><span class="rocket-mark"></span></article>
        </aside>
    </div>
</section>
@endsection



