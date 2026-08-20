@extends('layouts.company')

@section('title', 'Company Dashboard - OnlyFreshers')
@section('pageTitle', 'Company Dashboard')
@section('pageSubtitle', 'Overview of your hiring activities and company updates.')

@php
    $activePage = 'dashboard';
    $dashboardHiringPackages = [
        ['name' => 'Starter', 'desc' => 'Perfect for getting started', 'price' => '₹1,999', 'period' => '/month', 'button' => 'Choose Starter', 'popular' => false, 'items' => ['10 Job Postings', '50 Direct Mode Resumes (5 per job extra)', '20 Fast Track Mode Resumes (2 per job extra)', 'Candidate Contact Access', 'Email Support']],
        ['name' => 'Growth', 'desc' => 'Scale your hiring', 'price' => '₹4,999', 'period' => '/month', 'button' => 'Choose Growth', 'popular' => true, 'items' => ['25 Job Postings', '150 Direct Mode Resumes (6 per job extra)', '60 Fast Track Mode Resumes (2.5 per job extra)', 'Candidate Contact Access', 'Priority Support']],
        ['name' => 'Professional', 'desc' => 'For active hiring teams', 'price' => '₹9,999', 'period' => '/month', 'button' => 'Choose Professional', 'popular' => false, 'items' => ['60 Job Postings', '400 Direct Mode Resumes (7 per job extra)', '160 Fast Track Mode Resumes (2.5 per job extra)', 'Candidate Contact Access', 'Priority Support', 'Dedicated Account Manager']],
        ['name' => 'Enterprise', 'desc' => 'For large scale hiring', 'price' => 'Custom', 'period' => 'Contact Sales', 'button' => 'Contact Sales', 'popular' => false, 'items' => ['Unlimited Job Postings', 'Custom Resume Access', 'Dedicated Account Manager', 'Bulk Hiring Solutions', 'API Access', 'Custom Integrations']],
    ];
@endphp

@php
    $dashboardConfig = $dashboardConfig ?? config('onlyfreshers.company.dashboard', []);
    $dashboardHero = $dashboardConfig['hero'] ?? [];
    $dashboardHiringModes = $dashboardConfig['hiring_modes'] ?? [];
    $dashboardRecentJobsConfig = $dashboardConfig['recent_jobs'] ?? [];
    $dashboardCta = $dashboardConfig['cta'] ?? [];
    $dashboardHiringPackages = $dashboardConfig['hiring_packages'] ?? $dashboardHiringPackages;
    $dashboardResumePacks = $dashboardConfig['resume_packs'] ?? [];
    $dashboardTrustItems = $dashboardConfig['trust_items'] ?? [];
@endphp

@push('styles')
<style>
    .company-dashboard-page,
    .company-dashboard-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
    }
    .company-dashboard-page h1,
    .company-dashboard-page h2,
    .company-dashboard-page h3 {
        font-weight: 700;
    }
    .company-hero-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(620px, 1.45fr);
        align-items: center;
        gap: 18px;
        margin-bottom: 20px;
        border: 1px solid #dbe8fb;
        border-radius: 10px;
        background: #fff;
        padding: 18px 22px;
        box-shadow: 0 8px 24px rgba(7, 95, 228, 0.08);
    }
    .company-hero-card h2 {
        margin: 0 0 8px;
        font-size: 17px;
        line-height: 1.2;
        color: #061942;
    }
    .company-hero-card p {
        margin: 0 0 17px;
        font-size: 12px;
        font-weight: 600;
        color: #34445e;
    }
    .company-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    .company-hero-actions a {
        display: inline-flex;
        height: 34px;
        min-width: 112px;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        border: 1px solid #075fe4;
        padding: 0 18px;
        font-size: 10px;
        font-weight: 800;
        text-decoration: none;
    }
    .company-hero-actions a:first-child {
        background: #075fe4;
        color: #fff;
    }
    .company-hero-actions a:last-child {
        background: #fff;
        color: #075fe4;
    }
    .company-free-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        align-items: stretch;
        gap: 0;
        border-radius: 9px;
        background: rgba(255, 255, 255, .88);
        padding: 14px 12px;
    }
    .company-free-stat {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 42px;
        align-items: center;
        gap: 10px;
        min-height: 72px;
        padding: 0 16px;
        border-right: 1px solid #dce7f8;
    }
    .company-free-stat:last-child {
        border-right: 0;
    }
    .company-free-stat small {
        display: block;
        margin-bottom: 7px;
        font-size: 8px;
        font-weight: 800;
        line-height: 1.1;
        color: #061942;
    }
    .company-free-stat strong {
        display: block;
        margin-bottom: 4px;
        font-size: 24px;
        line-height: .9;
        color: #061942;
    }
    .company-free-stat span {
        display: block;
        font-size: 9px;
        font-weight: 700;
        line-height: 1.25;
        color: #34445e;
    }
    .company-free-stat a {
        display: inline-flex;
        margin-top: 8px;
        color: #075fe4;
        font-size: 9px;
        font-weight: 800;
        text-decoration: none;
    }
    .company-free-icon {
        display: grid;
        width: 42px;
        height: 42px;
        place-items: center;
        border-radius: 50%;
    }
    .company-free-icon svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    @media (max-width: 1200px) {
        .company-hero-card {
            grid-template-columns: 1fr;
        }
        .company-free-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .company-free-stat:nth-child(2) {
            border-right: 0;
        }
        .company-free-stat:nth-child(-n + 2) {
            border-bottom: 1px solid #dce7f8;
            padding-bottom: 14px;
            margin-bottom: 14px;
        }
    }
    @media (max-width: 640px) {
        .company-free-stats {
            grid-template-columns: 1fr;
        }
        .company-free-stat {
            border-right: 0;
            border-bottom: 1px solid #dce7f8;
            padding: 14px 0;
        }
        .company-free-stat:last-child {
            border-bottom: 0;
        }
    }
    .company-hiring-flow {
        margin-bottom: 20px;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #fff;
        padding: 26px 26px 24px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, 0.035);
    }
    .company-section-title {
        margin: 0 0 26px;
        text-align: center;
        color: #061942;
        font-size: 26px;
        line-height: 1.15;
        font-weight: 800;
    }
    .company-section-title:after {
        content: "";
        display: block;
        width: 34px;
        height: 3px;
        margin: 14px auto 0;
        border-radius: 999px;
        background: #075fe4;
    }
    .hiring-mode-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        max-width: 1260px;
        margin: 0 auto 32px;
    }
    .hiring-mode-card {
        display: grid;
        grid-template-columns: 138px minmax(0, 1fr);
        gap: 22px;
        align-items: center;
        min-height: 210px;
        border: 1px solid #dce7f8;
        border-radius: 10px;
        background: #fff;
        padding: 24px 28px;
        box-shadow: 0 8px 20px rgba(6, 25, 66, 0.025);
    }
    .hiring-mode-art {
        display: grid;
        width: 118px;
        height: 118px;
        place-items: center;
        border-radius: 50%;
    }
    .hiring-mode-art svg {
        width: 92px;
        height: 92px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.6;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .hiring-mode-card.direct {
        color: #075fe4;
    }
    .hiring-mode-card.fast {
        color: #0b9f65;
    }
    .hiring-mode-card.direct .hiring-mode-art {
        background: #eaf2ff;
    }
    .hiring-mode-card.fast .hiring-mode-art {
        background: #e8fbf3;
    }
    .hiring-mode-card h3 {
        margin: 0 0 14px;
        font-size: 19px;
        line-height: 1.2;
        text-transform: uppercase;
    }
    .hiring-mode-card ul {
        display: grid;
        gap: 10px;
        margin: 0 0 18px;
        padding: 0;
        list-style: none;
        color: #061942;
    }
    .hiring-mode-card li {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
    }
    .hiring-mode-card li b {
        display: grid;
        width: 16px;
        height: 16px;
        flex: 0 0 auto;
        place-items: center;
        border-radius: 50%;
        border: 1px solid currentColor;
        font-size: 9px;
    }
    .hiring-free-note {
        font-size: 14px;
        font-weight: 900;
    }
    .hiring-summary-title {
        margin: 0 0 22px;
        text-align: center;
        color: #061942;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 800;
    }
    .hiring-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
    }
    .hiring-summary-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 52px;
        align-items: center;
        gap: 12px;
        min-height: 138px;
        border: 1px solid #dce7f8;
        border-radius: 9px;
        background: #fff;
        padding: 22px 18px;
        box-shadow: 0 8px 20px rgba(6, 25, 66, 0.025);
    }
    .hiring-summary-card p {
        margin: 0 0 16px;
        color: #34445e;
        font-size: 12px;
        font-weight: 800;
    }
    .hiring-summary-card strong {
        display: block;
        margin-bottom: 12px;
        color: #061942;
        font-size: 34px;
        line-height: .8;
    }
    .hiring-summary-card span {
        display: block;
        color: #34445e;
        font-size: 13px;
        font-weight: 700;
    }
    .hiring-summary-icon {
        display: grid;
        width: 52px;
        height: 52px;
        place-items: center;
        border-radius: 50%;
    }
    .hiring-summary-icon svg {
        width: 28px;
        height: 28px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    @media (max-width: 1200px) {
        .hiring-mode-grid,
        .hiring-summary-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        .hiring-mode-card {
            grid-template-columns: 1fr;
        }
        .hiring-summary-card {
            min-height: 110px;
        }
    }
    .recent-job-postings {
        margin-bottom: 20px;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(6, 25, 66, 0.035);
        overflow: hidden;
    }
    .recent-job-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 24px 26px 18px;
    }
    .recent-job-head h2 {
        margin: 0;
        color: #061942;
        font-size: 21px;
        line-height: 1.2;
        font-weight: 800;
    }
    .recent-job-head a {
        color: #075fe4;
        font-size: 12px;
        font-weight: 900;
        text-decoration: none;
    }
    .recent-job-list {
        display: grid;
    }
    .recent-job-row {
        display: grid;
        grid-template-columns: 76px minmax(0, 1.25fr) 130px 130px 255px 160px 28px;
        align-items: center;
        gap: 0;
        min-height: 118px;
        padding: 20px 26px;
        border-top: 1px solid #e7eef8;
    }
    .recent-job-logo {
        display: grid;
        width: 58px;
        height: 58px;
        place-items: center;
        border-radius: 9px;
        color: #fff;
    }
    .recent-job-logo svg {
        width: 30px;
        height: 30px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.4;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .recent-job-logo.purple {
        background: linear-gradient(135deg, #8d38ff, #5d2dd6);
    }
    .recent-job-logo.green {
        background: linear-gradient(135deg, #19b973, #0b8b67);
    }
    .recent-job-title h3 {
        margin: 0 0 8px;
        color: #061942;
        font-size: 15px;
        line-height: 1.2;
    }
    .recent-job-title p {
        margin: 0 0 8px;
        color: #526287;
        font-size: 11px;
        font-weight: 800;
    }
    .recent-job-title span {
        color: #526287;
        font-size: 11px;
        font-weight: 800;
    }
    .recent-job-metric,
    .recent-resume-block,
    .recent-action-block {
        min-height: 64px;
        border-left: 1px solid #dce7f8;
        padding-left: 26px;
    }
    .recent-job-metric small,
    .recent-resume-mode small {
        display: block;
        margin-bottom: 8px;
        color: #526287;
        font-size: 10px;
        font-weight: 800;
    }
    .recent-job-metric strong {
        color: #061942;
        font-size: 20px;
        line-height: 1;
    }
    .recent-resume-block {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }
    .recent-resume-block > small {
        grid-column: 1 / -1;
        margin-bottom: -6px;
        color: #061942;
        font-size: 11px;
        font-weight: 900;
        text-align: center;
    }
    .recent-resume-mode strong {
        color: #061942;
        font-size: 18px;
        line-height: 1;
    }
    .recent-resume-mode em {
        color: #0b8b67;
        font-size: 11px;
        font-style: normal;
        font-weight: 900;
    }
    .recent-action-block {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .recent-action-block a {
        display: inline-flex;
        height: 40px;
        min-width: 132px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 5px;
        background: #fff;
        color: #075fe4;
        font-size: 11px;
        font-weight: 900;
        text-decoration: none;
    }
    .recent-menu-dots {
        display: grid;
        gap: 4px;
        justify-items: center;
        color: #526287;
    }
    .recent-menu-dots i {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: currentColor;
    }
    .hiring-package-cta {
        display: grid;
        grid-template-columns: 46px minmax(0, 1fr) auto;
        align-items: center;
        gap: 18px;
        margin: 20px 0;
        border: 1px dashed #075fe4;
        border-radius: 9px;
        background: #fff;
        padding: 18px 24px;
    }
    .hiring-package-cta .cta-icon {
        display: grid;
        width: 34px;
        height: 34px;
        place-items: center;
        color: #075fe4;
    }
    .hiring-package-cta h3 {
        margin: 0 0 6px;
        color: #075fe4;
        font-size: 14px;
        line-height: 1.2;
    }
    .hiring-package-cta p {
        margin: 0;
        color: #526287;
        font-size: 12px;
        font-weight: 700;
    }
    .hiring-package-cta a {
        display: inline-flex;
        height: 44px;
        min-width: 220px;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        background: #075fe4;
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        text-decoration: none;
    }
    @media (max-width: 1200px) {
        .recent-job-row {
            grid-template-columns: 64px minmax(0, 1fr);
            gap: 14px;
        }
        .recent-job-metric,
        .recent-resume-block,
        .recent-action-block {
            border-left: 0;
            padding-left: 0;
        }
        .recent-menu-dots {
            display: none;
        }
        .hiring-package-cta {
            grid-template-columns: 42px minmax(0, 1fr);
        }
        .hiring-package-cta a {
            grid-column: 1 / -1;
            justify-self: start;
        }
    }
    .dashboard-hiring-packages {
        margin-bottom: 20px;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #f8fbff;
        padding: 24px 26px;
        box-shadow: 0 10px 24px rgba(6, 25, 66, 0.035);
    }
    .dashboard-hiring-packages .package-head {
        margin-bottom: 24px;
        text-align: center;
    }
    .dashboard-hiring-packages .package-head h2 {
        margin: 0 0 10px;
        color: #061942;
        font-size: 18px;
        line-height: 1.2;
        font-weight: 800;
    }
    .dashboard-hiring-packages .package-head p {
        margin: 0;
        color: #34445e;
        font-size: 11px;
        font-weight: 700;
    }
    .dashboard-package-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 28px;
        padding: 0 28px;
    }
    .dashboard-package-card {
        position: relative;
        border: 1px solid #dce7f8;
        border-radius: 9px;
        background: #fff;
        padding: 24px 24px 22px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(6, 25, 66, 0.025);
    }
    .dashboard-package-card.popular {
        border-color: #075fe4;
        box-shadow: inset 0 0 0 1px #075fe4, 0 12px 24px rgba(7, 95, 228, 0.08);
    }
    .dashboard-package-card .popular-pill {
        position: absolute;
        left: 50%;
        top: -13px;
        display: inline-flex;
        min-width: 118px;
        height: 24px;
        transform: translateX(-50%);
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #075fe4;
        color: #fff;
        font-size: 10px;
        font-weight: 900;
    }
    .dashboard-package-card h3 {
        margin: 0 0 8px;
        color: #061942;
        font-size: 14px;
    }
    .dashboard-package-card .package-desc {
        margin: 0 0 20px;
        color: #34445e;
        font-size: 9px;
        font-weight: 700;
    }
    .dashboard-package-card .package-price {
        color: #061942;
        font-size: 32px;
        line-height: .9;
        font-weight: 900;
    }
    .dashboard-package-card .package-period {
        margin: 8px 0 24px;
        color: #34445e;
        font-size: 10px;
        font-weight: 700;
    }
    .dashboard-package-card ul {
        display: grid;
        gap: 13px;
        min-height: 164px;
        margin: 0 0 24px;
        padding: 0;
        list-style: none;
        text-align: left;
    }
    .dashboard-package-card li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #061942;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.3;
    }
    .dashboard-package-card li b {
        color: #0b8b67;
        font-size: 12px;
        line-height: 1;
    }
    .dashboard-package-card a {
        display: inline-flex;
        width: 100%;
        height: 38px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 5px;
        background: #fff;
        color: #075fe4;
        font-size: 11px;
        font-weight: 900;
        text-decoration: none;
    }
    .dashboard-package-card.popular a {
        background: #075fe4;
        color: #fff;
    }
    .resume-pack-strip {
        margin-top: 26px;
        border: 1px solid #dce7f8;
        border-radius: 9px;
        background: #fff;
        padding: 18px 24px;
    }
    .resume-pack-strip-inner {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 250px 1px 250px 170px;
        align-items: center;
        gap: 22px;
    }
    .resume-pack-strip h3 {
        margin: 0 0 8px;
        color: #061942;
        font-size: 14px;
    }
    .resume-pack-strip p {
        margin: 0;
        color: #34445e;
        font-size: 10px;
        font-weight: 700;
    }
    .resume-pack-item {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .resume-pack-item .pack-icon {
        display: grid;
        width: 42px;
        height: 42px;
        place-items: center;
        border-radius: 50%;
    }
    .resume-pack-item .pack-icon svg,
    .hiring-package-cta .cta-icon svg {
        width: 22px;
        height: 22px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .resume-pack-item strong {
        display: block;
        color: #061942;
        font-size: 11px;
    }
    .resume-pack-item b {
        color: #061942;
        font-size: 20px;
    }
    .resume-pack-item span {
        color: #34445e;
        font-size: 11px;
        font-weight: 700;
    }
    .resume-pack-divider {
        width: 1px;
        height: 42px;
        background: #cfdceb;
    }
    .resume-pack-strip .buy-pack {
        display: inline-flex;
        height: 34px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 5px;
        color: #075fe4;
        font-size: 11px;
        font-weight: 900;
        text-decoration: none;
    }
    .company-trust-strip {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0;
        margin-top: 26px;
        border-radius: 9px;
        background: #f8fbff;
        padding: 20px 18px;
    }
    .company-trust-item {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        align-items: center;
        gap: 14px;
        min-height: 54px;
        padding: 0 24px;
        border-right: 1px solid #dce7f8;
    }
    .company-trust-item:last-child {
        border-right: 0;
    }
    .company-trust-icon {
        display: grid;
        width: 38px;
        height: 38px;
        place-items: center;
        border-radius: 50%;
        background: #edf5ff;
        color: #075fe4;
    }
    .company-trust-icon svg {
        width: 21px;
        height: 21px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .company-trust-item strong {
        display: block;
        margin-bottom: 5px;
        color: #061942;
        font-size: 12px;
    }
    .company-trust-item span {
        display: block;
        color: #34445e;
        font-size: 10px;
        font-weight: 700;
    }
    @media (max-width: 1200px) {
        .dashboard-package-grid,
        .resume-pack-strip-inner {
            grid-template-columns: 1fr;
            padding: 0;
        }
        .resume-pack-divider {
            display: none;
        }
        .company-trust-strip {
            grid-template-columns: 1fr;
        }
        .company-trust-item {
            border-right: 0;
            border-bottom: 1px solid #dce7f8;
            padding: 14px 0;
        }
        .company-trust-item:last-child {
            border-bottom: 0;
        }
    }
</style>
@endpush

@section('content')
<div class="company-dashboard-page">

    {{-- Welcome + Statistics --}}
    <section class="company-hero-card">
        <div>
            <h2>Welcome back, <strong id="welcomeCompanyName">Company</strong>! <span aria-hidden="true">👋</span></h2>
            <p id="dashboardStatus">{{ $dashboardHero['status'] ?? 'Find and hire the best fresher talent for your team.' }}</p>
            <div class="company-hero-actions">
                <a href="{{ $dashboardHero['primary_action']['href'] ?? '/company/post-job' }}">{{ $dashboardHero['primary_action']['label'] ?? 'Post Opportunity' }}</a>
                <a href="{{ $dashboardHero['secondary_action']['href'] ?? '/company/applications' }}">{{ $dashboardHero['secondary_action']['label'] ?? 'View Candidates' }}</a>
            </div>
        </div>

        <div id="statsGrid" class="company-free-stats">
            {{-- Stats inserted through JavaScript --}}
        </div>
    </section>

    <section class="company-hiring-flow">
        <h2 class="company-section-title">{{ $dashboardConfig['hiring_flow_title'] ?? 'How Hiring Works on OnlyFreshers' }}</h2>
        <div class="hiring-mode-grid">
            <article class="hiring-mode-card direct">
                <div class="hiring-mode-art">
                    <svg viewBox="0 0 100 100" aria-hidden="true">
                        <circle cx="42" cy="42" r="31"></circle>
                        <path d="m64 64 20 20"></path>
                        <rect x="28" y="32" width="28" height="22" rx="3"></rect>
                        <path d="M36 32v-6h12v6"></path>
                        <path d="M28 43h28"></path>
                        <path d="M70 79v-17"></path>
                        <path d="M78 79V67"></path>
                        <path d="M86 79V58"></path>
                    </svg>
                </div>
                <div>
                    <h3>{{ $dashboardHiringModes['direct']['title'] ?? 'Direct Mode' }}</h3>
                    <ul>
                        @foreach (($dashboardHiringModes['direct']['items'] ?? []) as $item)
                            <li><b>&#10003;</b>{{ $item }}</li>
                        @endforeach
                    </ul>
                    <div class="hiring-free-note" data-direct-free-note>Free resumes per job posting</div>
                </div>
            </article>
            <article class="hiring-mode-card fast">
                <div class="hiring-mode-art">
                    <svg viewBox="0 0 100 100" aria-hidden="true">
                        <circle cx="34" cy="26" r="12" fill="currentColor" stroke="none"></circle>
                        <path d="M26 43h16l12 14v24H18V55a12 12 0 0 1 8-12Z" fill="currentColor" stroke="none"></path>
                        <rect x="56" y="22" width="31" height="42" rx="4"></rect>
                        <path d="M63 34h17"></path>
                        <path d="M63 44h12"></path>
                        <path d="M63 54h18"></path>
                        <path d="M50 43h11"></path>
                    </svg>
                </div>
                <div>
                    <h3>{{ $dashboardHiringModes['fast_track']['title'] ?? 'Fast Track Mode' }}</h3>
                    <ul>
                        @foreach (($dashboardHiringModes['fast_track']['items'] ?? []) as $item)
                            <li><b>&#10003;</b>{{ $item }}</li>
                        @endforeach
                    </ul>
                    <div class="hiring-free-note" data-fast-free-note>Free resumes per job posting</div>
                </div>
            </article>
        </div>

        <h2 class="hiring-summary-title">Your Hiring Summary</h2>
        <div class="hiring-summary-grid" id="hiringSummaryGrid">
            {{-- Summary inserted through JavaScript --}}
        </div>
    </section>

    <section class="recent-job-postings">
        <div class="recent-job-head">
            <h2>{{ $dashboardRecentJobsConfig['title'] ?? 'Recent Opportunities' }}</h2>
            <a href="/company/jobs">{{ $dashboardRecentJobsConfig['view_all_label'] ?? 'View All ->' }}</a>
        </div>
        <div class="recent-job-list" id="recentJobPostings">
            <p class="p-5 text-sm text-[#52607a]">Loading recent jobs...</p>
        </div>
    </section>

    <section class="hiring-package-cta">
        <span class="cta-icon" data-company-icon="users"></span>
        <div>
            <h3 data-company-cta-title>{{ $dashboardCta['title'] ?? "You've used all your free opportunity postings!" }}</h3>
            <p data-company-cta-text>{{ $dashboardCta['text'] ?? 'Post more jobs or internships and connect with more talented freshers.' }}</p>
        </div>
        <a href="{{ $dashboardCta['href'] ?? '/company/billing' }}">{{ $dashboardCta['button'] ?? 'View Hiring Packages' }}</a>
    </section>

    <section class="dashboard-hiring-packages">
        <div class="package-head">
            <h2>Choose a Hiring Package</h2>
            <p>Post more jobs or internships and access more resumes to hire the best talent.</p>
        </div>

        <div class="dashboard-package-grid">
            @foreach ($dashboardHiringPackages as $package)
                <article class="dashboard-package-card {{ $package['popular'] ? 'popular' : '' }}">
                    @if ($package['popular'])
                        <span class="popular-pill">Most Popular</span>
                    @endif
                    <h3>{{ $package['name'] }}</h3>
                    <p class="package-desc">{{ $package['desc'] }}</p>
                    <div class="package-price">{{ $package['price'] }}</div>
                    <div class="package-period">{{ $package['period'] }}</div>
                    <ul>
                        @foreach ($package['items'] as $item)
                            <li><b>&#10003;</b><span>{{ $item }}</span></li>
                        @endforeach
                    </ul>
                    <a href="/company/billing">{{ $package['button'] }}</a>
                </article>
            @endforeach
        </div>

        <div class="resume-pack-strip">
            <div class="resume-pack-strip-inner">
                <div>
                    <h3>{{ $dashboardResumePacks['title'] ?? 'Additional Resume Packs' }}</h3>
                    <p>{{ $dashboardResumePacks['text'] ?? 'Need more resumes without upgrading your plan?' }}</p>
                </div>
                <div class="resume-pack-item">
                    <span class="pack-icon bg-[#eaf2ff] text-[#075fe4]" data-company-icon="file"></span>
                    <span>
                        <strong>Direct Mode Resumes</strong>
                        <b>₹300</b>
                        <span>/ 5 Resumes</span>
                    </span>
                </div>
                <span class="resume-pack-divider"></span>
                <div class="resume-pack-item">
                    <span class="pack-icon bg-[#e8fbf3] text-[#00ad6f]" data-company-icon="users"></span>
                    <span>
                        <strong>Fast Track Mode Resumes</strong>
                        <b>₹400</b>
                        <span>/ 5 Resumes</span>
                    </span>
                </div>
                <a class="buy-pack" href="/company/billing">Buy Now</a>
            </div>
        </div>
        <div class="company-trust-strip">
            @foreach ($dashboardTrustItems as $trustItem)
                <article class="company-trust-item">
                    <span class="company-trust-icon" data-company-icon="{{ $trustItem['icon'] ?? 'shield' }}"></span>
                    <span><strong>{{ $trustItem['title'] ?? '' }}</strong><span>{{ $trustItem['text'] ?? '' }}</span></span>
                </article>
            @endforeach
        </div>
    </section>

</div>
@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | Support both token names so old + collaborator login flow works.
    |
    */

    const token =
        localStorage.getItem('onlyfreshers_company_token') ||
        localStorage.getItem('ofc_auth_token');

    const statsGrid = document.getElementById('statsGrid');
    const recentActivities = document.getElementById('recentActivities');
    const recentJobPostings = document.getElementById('recentJobPostings');
    const quickActions = document.getElementById('quickActions');
    const hiringSummaryGrid = document.getElementById('hiringSummaryGrid');
    const welcomeCompanyName = document.getElementById('welcomeCompanyName');
    const dashboardStatus = document.getElementById('dashboardStatus');
    let dashboardConfig = @json($dashboardConfig);


    /*
    |--------------------------------------------------------------------------
    | Icons
    |--------------------------------------------------------------------------
    */

    const iconSvg = {

        briefcase: `
            <svg viewBox="0 0 24 24">
                <rect
                    x="3"
                    y="7"
                    width="18"
                    height="13"
                    rx="2"
                ></rect>

                <path d="M8 7V5h8v2"></path>
            </svg>
        `,

        users: `
            <svg viewBox="0 0 24 24">
                <path d="M16 21v-2a4 4 0 0 0-8 0v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
            </svg>
        `,

        star: `
            <svg viewBox="0 0 24 24">
                <path
                    d="M12 3l2.7 5.4 6 .9-4.3 4.2
                       1 6-5.4-2.8-5.4 2.8
                       1-6-4.3-4.2 6-.9z"
                ></path>
            </svg>
        `,

        calendar: `
            <svg viewBox="0 0 24 24">
                <rect
                    x="4"
                    y="5"
                    width="16"
                    height="15"
                    rx="2"
                ></rect>

                <path d="M8 3v4M16 3v4M4 10h16"></path>
            </svg>
        `,

        userCheck: `
            <svg viewBox="0 0 24 24">
                <path d="M8 21v-2a4 4 0 0 1 8 0v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <path d="M17 11l2 2 4-5"></path>
            </svg>
        `,

        file: `
            <svg viewBox="0 0 24 24">
                <path
                    d="M14 2H6a2 2 0 0 0-2 2v16
                       a2 2 0 0 0 2 2h12
                       a2 2 0 0 0 2-2V8Z"
                ></path>

                <path d="M14 2v6h6"></path>
            </svg>
        `,

        code: `
            <svg viewBox="0 0 24 24">
                <path d="m8 9-4 3 4 3"></path>
                <path d="m16 9 4 3-4 3"></path>
                <path d="m14 5-4 14"></path>
            </svg>
        `,

        chart: `
            <svg viewBox="0 0 24 24">
                <path d="M5 19V9"></path>
                <path d="M10 19V5"></path>
                <path d="M15 19v-7"></path>
                <path d="M20 19V7"></path>
                <path d="M3 19h19"></path>
            </svg>
        `,

        shield: `
            <svg viewBox="0 0 24 24">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path>
                <path d="m9 12 2 2 4-5"></path>
            </svg>
        `,

        clock: `
            <svg viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
            </svg>
        `
    };


    /*
    |--------------------------------------------------------------------------
    | Statistics Configuration
    |--------------------------------------------------------------------------
    */

    const statMeta = [

        [
            'Jobs Posted',
            'total_jobs',
            '/company/jobs',
            'briefcase',
            'bg-[#eaf2ff] text-[#075fe4]'
        ],

        [
            'Applications',
            'total_applications',
            '/company/applications',
            'users',
            'bg-[#e8fbf3] text-[#00ad6f]'
        ],

        [
            'Shortlisted',
            'shortlisted_applications',
            '/company/shortlisted',
            'star',
            'bg-[#fff5e6] text-[#ff9c22]'
        ],

        [
            'Interviews',
            'scheduled_interviews',
            '/company/interviews',
            'calendar',
            'bg-[#f0edff] text-[#6c50ff]'
        ],

        [
            'Hired',
            'hired_applications',
            '/company/hired',
            'userCheck',
            'bg-[#e8fbf3] text-[#00ad6f]'
        ]

    ];


    /*
    |--------------------------------------------------------------------------
    | Quick Actions
    |--------------------------------------------------------------------------
    */

    const actions = [

        [
            'Post Opportunity',
            'Post a job or internship for freshers',
            '/company/post-job',
            'briefcase',
            'bg-[#eaf2ff] text-[#075fe4]'
        ],

        [
            'View Applications',
            'Review candidates who applied',
            '/company/applications',
            'users',
            'bg-[#e8fbf3] text-[#00ad6f]'
        ],

        [
            'Shortlist Candidates',
            'Pick the best matches',
            '/company/shortlisted',
            'star',
            'bg-[#f0edff] text-[#6c50ff]'
        ],

        [
            'Schedule Interview',
            'Connect with candidates',
            '/company/interviews/create',
            'calendar',
            'bg-[#fff5e6] text-[#ff9c22]'
        ]

    ];


    /*
    |--------------------------------------------------------------------------
    | Icon Wrapper
    |--------------------------------------------------------------------------
    */

    function iconWrap(icon, classes) {

        return `
            <div
                class="flex h-10 w-10 shrink-0
                       items-center justify-center
                       rounded-full ${classes}"
            >
                <div
                    class="h-5 w-5
                           [&>svg]:h-full
                           [&>svg]:w-full
                           [&>svg]:fill-none
                           [&>svg]:stroke-current
                           [&>svg]:stroke-2
                           [&>svg]:[stroke-linecap:round]
                           [&>svg]:[stroke-linejoin:round]"
                >
                    ${iconSvg[icon] || ''}
                </div>
            </div>
        `;
    }


    /*
    |--------------------------------------------------------------------------
    | Format Status
    |--------------------------------------------------------------------------
    */

    function formatStatus(status) {

        if (!status) {
            return '';
        }

        return status
            .replaceAll('_', ' ')
            .replace(
                /\b\w/g,
                letter => letter.toUpperCase()
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    function formatDate(value) {

        if (!value) {
            return '';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleDateString(
            'en-IN',
            {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Render Statistics
    |--------------------------------------------------------------------------
    */

    function renderStats(statistics = {}, limits = {}) {

        const jobPostings =
            limits.job_postings || {};

        const directMode =
            limits.direct_mode_resumes_per_job || {};

        const fastTrack =
            limits.fast_track_resumes_per_job || {};

        const cards = [
            {
                title: 'Free Opportunity Postings',
                value: `${jobPostings.used ?? statistics.total_jobs ?? 0} / ${jobPostings.total ?? 0}`,
                note: 'Used',
                sub: jobPostings.recent_on ? `Recent on ${jobPostings.recent_on}` : 'No recent posting',
                icon: 'file',
                classes: 'bg-[#eaf2ff] text-[#075fe4]',
                href: '/company/jobs',
                link: ''
            },
            {
                title: 'Direct Mode',
                value: `${directMode.remaining ?? directMode.total ?? 0} / ${directMode.total ?? 0}`,
                note: 'Free Resumes',
                sub: 'Per Job Posting',
                icon: 'users',
                classes: 'bg-[#eef5ff] text-[#075fe4]',
                href: '/company/applications',
                link: ''
            },
            {
                title: 'Fast Track Mode',
                value: `${fastTrack.remaining ?? fastTrack.total ?? 0} / ${fastTrack.total ?? 0}`,
                note: 'Free Resumes',
                sub: 'Per Job Posting',
                icon: 'users',
                classes: 'bg-[#e8fbf3] text-[#00ad6f]',
                href: '/fast-track/dashboard',
                link: ''
            },
            {
                title: 'Total Active Opportunities',
                value: statistics.active_jobs ?? 0,
                note: '',
                sub: '',
                icon: 'briefcase',
                classes: 'bg-[#f0edff] text-[#6c50ff]',
                href: '/company/jobs',
                link: 'View All ->'
            }
        ];

        statsGrid.innerHTML = cards
            .map(card => `
                <article class="company-free-stat">
                    <div class="min-w-0">
                        <small>${card.title}</small>
                        <strong>${card.value}</strong>
                        ${card.note ? `<span>${card.note}</span>` : ''}
                        ${card.sub ? `<span>${card.sub}</span>` : ''}
                        ${card.link ? `<a href="${card.href}">${card.link}</a>` : ''}
                    </div>
                    <div class="company-free-icon ${card.classes}">
                        <div>${iconSvg[card.icon] || ''}</div>
                    </div>
                </article>
            `)
            .join('');
    }

    function renderHiringSummary(statistics = {}) {

        if (!hiringSummaryGrid) {
            return;
        }

        const cards = [
            ['Total Jobs Posted', statistics.total_jobs ?? 0, 'Active Jobs', 'briefcase', 'bg-[#eaf2ff] text-[#075fe4]'],
            ['Total Applicants', statistics.total_applications ?? 0, 'Across all jobs', 'users', 'bg-[#eaf2ff] text-[#075fe4]'],
            ['Shortlisted Candidates', statistics.shortlisted_applications ?? 0, 'Across all jobs', 'userCheck', 'bg-[#e8fbf3] text-[#00ad6f]'],
            ['Interviews Scheduled', statistics.scheduled_interviews ?? 0, 'Upcoming interviews', 'calendar', 'bg-[#f0edff] text-[#6c50ff]'],
            ['Hires Made', statistics.hired_applications ?? 0, 'Congrats! 🎉', 'users', 'bg-[#f0edff] text-[#6c50ff]'],
        ];

        hiringSummaryGrid.innerHTML = cards.map(([title, value, note, icon, classes]) => `
            <article class="hiring-summary-card">
                <div>
                    <p>${title}</p>
                    <strong>${value}</strong>
                    <span>${note}</span>
                </div>
                <div class="hiring-summary-icon ${classes}">
                    ${iconSvg[icon] || ''}
                </div>
            </article>
        `).join('');
    }

    function renderHiringFreeNotes(limits = {}) {

        const direct =
            limits.direct_mode_resumes_per_job || {};

        const fast =
            limits.fast_track_resumes_per_job || {};

        const directNote =
            document.querySelector('[data-direct-free-note]');

        const fastNote =
            document.querySelector('[data-fast-free-note]');

        if (directNote) {
            directNote.textContent =
                `${direct.total ?? 0} Free Resumes per Job Posting`;
        }

        if (fastNote) {
            fastNote.textContent =
                `${fast.total ?? 0} Free Resumes per Job Posting`;
        }
    }

    function renderConfigDrivenContent(limits = {}) {

        const cta =
            dashboardConfig?.cta || {};

        const remainingFreePosts =
            limits?.job_postings?.remaining ?? 0;

        const ctaTitle =
            document.querySelector('[data-company-cta-title]');

        const ctaText =
            document.querySelector('[data-company-cta-text]');

        if (ctaTitle) {
            ctaTitle.textContent =
                remainingFreePosts > 0
                    ? (cta.available_title || 'Free opportunity postings available')
                    : (cta.title || "You've used all your free opportunity postings!");
        }

        if (ctaText) {
            ctaText.textContent =
                remainingFreePosts > 0
                    ? (cta.available_text || 'Use your free postings to reach verified fresher talent.')
                    : (cta.text || 'Post more jobs or internships and connect with more talented freshers.');
        }

        const resumePacks =
            dashboardConfig?.resume_packs?.items || [];

        document
            .querySelectorAll('.resume-pack-item')
            .forEach((element, index) => {
                const pack = resumePacks[index];

                if (!pack) {
                    return;
                }

                const icon = element.querySelector('[data-company-icon]');
                const title = element.querySelector('strong');
                const price = element.querySelector('b');
                const quantity = element.querySelector('span span');

                if (icon) {
                    icon.dataset.companyIcon = pack.icon || icon.dataset.companyIcon;
                    icon.className = `pack-icon ${pack.classes || ''}`;
                    icon.innerHTML = iconSvg[icon.dataset.companyIcon] || '';
                }

                if (title) title.textContent = pack.title || '';
                if (price) price.textContent = pack.price || '';
                if (quantity) quantity.textContent = pack.quantity || '';
            });
    }

    function renderRecentJobPostings(data = {}, limits = {}) {

        if (!recentJobPostings) {
            return;
        }

        const fallbackJobs =
            dashboardConfig?.recent_jobs?.fallback || [];

        const jobs =
            ((data.recent_jobs || []).length ? data.recent_jobs : fallbackJobs)
                .slice(0, 2);

        const directTotal =
            limits?.direct_mode_resumes_per_job?.total ?? 0;

        const fastTotal =
            limits?.fast_track_resumes_per_job?.total ?? 0;

        recentJobPostings.innerHTML = jobs
            .map((job, index) => {

                const applications =
                    job.applications_count ?? 0;

                const shortlisted =
                    job.shortlisted_applications_count ??
                    job.shortlisted_count ??
                    0;

                return `
                    <article class="recent-job-row">
                        <span class="recent-job-logo ${index % 2 ? 'green' : 'purple'}">
                            ${iconSvg[index % 2 ? 'chart' : 'code']}
                        </span>

                        <div class="recent-job-title">
                            <h3>${job.title || 'Job Role'}</h3>
                            <p>
                                ${job.category || job.department || 'Engineering'}
                                <span>&nbsp;•&nbsp;</span>
                                ${job.job_type || 'Full-time'}
                                <span>&nbsp;•&nbsp;</span>
                                ${job.location || 'Location not added'}
                            </p>
                            <span>Posted on ${formatDate(job.created_at || job.updated_at) || 'Recently'}</span>
                        </div>

                        <div class="recent-job-metric">
                            <small>Applications</small>
                            <strong>${applications}</strong>
                        </div>

                        <div class="recent-job-metric">
                            <small>Shortlisted</small>
                            <strong>${shortlisted}</strong>
                        </div>

                        <div class="recent-resume-block">
                            <small>Free Resumes</small>
                            <div class="recent-resume-mode">
                                <small>Direct Mode</small>
                                <strong>${directTotal} / ${directTotal}</strong>
                                <em>Used</em>
                            </div>
                            <div class="recent-resume-mode">
                                <small>Fast Track Mode</small>
                                <strong>${fastTotal} / ${fastTotal}</strong>
                                <em>Used</em>
                            </div>
                        </div>

                        <div class="recent-action-block">
                            <a href="/company/applications?job=${job.id || ''}">View Applicants</a>
                        </div>

                        <span class="recent-menu-dots" aria-hidden="true">
                            <i></i><i></i><i></i>
                        </span>
                    </article>
                `;
            })
            .join('');
    }


    /*
    |--------------------------------------------------------------------------
    | Render Recent Activities
    |--------------------------------------------------------------------------
    */

    function renderActivities(data = {}) {

        if (!recentActivities) {
            return;
        }

        const activities = [];


        /*
        | Recent Applications
        */

        for (
            const application
            of (data.recent_applications || [])
        ) {

            const candidate =
                application?.fresher_profile?.user?.name ||
                application?.fresher?.user?.name ||
                application?.user?.name ||
                'Candidate';

            const job =
                application?.job?.title ||
                'job';

            activities.push({

                title:
                    `${candidate} applied for ${job}`,

                time:
                    formatDate(
                        application.applied_at ||
                        application.created_at
                    ),

                icon:
                    'users',

                classes:
                    'bg-[#e8fbf3] text-[#00ad6f]'

            });
        }


        /*
        | Recent Jobs
        */

        for (
            const job
            of (data.recent_jobs || [])
        ) {

            activities.push({

                title:
                    `${job.title || 'Job'} has ${job.applications_count || 0} applications`,

                time:
                    formatDate(job.created_at),

                icon:
                    'briefcase',

                classes:
                    'bg-[#eaf2ff] text-[#075fe4]'

            });
        }


        /*
        | Upcoming Interviews
        */

        for (
            const interview
            of (data.upcoming_interviews || [])
        ) {

            const candidate =
                interview?.job_application
                    ?.fresher_profile
                    ?.user
                    ?.name ||

                interview?.application
                    ?.fresher_profile
                    ?.user
                    ?.name ||

                'Candidate';

            activities.push({

                title:
                    `Interview scheduled with ${candidate}`,

                time:
                    [
                        interview.interview_date,
                        interview.interview_time
                    ]
                    .filter(Boolean)
                    .join(' '),

                icon:
                    'calendar',

                classes:
                    'bg-[#f0edff] text-[#6c50ff]'

            });
        }


        /*
        | No Activity
        */

        if (!activities.length) {

            recentActivities.innerHTML = `
                <p
                    class="rounded-lg
                           border border-[#dce7f8]
                           bg-[#f8fbff]
                           p-4
                           text-sm
                           text-[#52607a]"
                >
                    No recent activity yet.
                </p>
            `;

            return;
        }


        /*
        | Activity List
        */

        recentActivities.innerHTML =
            activities
                .slice(0, 7)
                .map(activity => {

                    return `
                        <div
                            class="grid
                                   grid-cols-[38px_minmax(0,1fr)]
                                   items-center
                                   gap-x-3
                                   border-b
                                   border-[#edf2fb]
                                   px-1
                                   py-3
                                   last:border-b-0
                                   sm:grid-cols-[42px_minmax(0,1fr)_auto]"
                        >

                            <div
                                class="flex
                                       h-9
                                       w-9
                                       items-center
                                       justify-center
                                       rounded-[9px]
                                       ${activity.classes}"
                            >

                                <div
                                    class="h-5 w-5
                                           [&>svg]:h-full
                                           [&>svg]:w-full
                                           [&>svg]:fill-none
                                           [&>svg]:stroke-current
                                           [&>svg]:stroke-2
                                           [&>svg]:[stroke-linecap:round]
                                           [&>svg]:[stroke-linejoin:round]"
                                >
                                    ${iconSvg[activity.icon] || ''}
                                </div>

                            </div>


                            <h3
                                class="min-w-0
                                       break-words
                                       text-[12px]
                                       font-bold
                                       text-[#061942]"
                            >
                                ${activity.title}
                            </h3>


                            <time
                                class="col-start-2
                                       whitespace-nowrap
                                       text-[11px]
                                       text-[#34445e]
                                       sm:col-start-auto"
                            >
                                ${activity.time || ''}
                            </time>

                        </div>
                    `;
                })
                .join('');
    }


    /*
    |--------------------------------------------------------------------------
    | Render Quick Actions
    |--------------------------------------------------------------------------
    */

    function renderActions() {

        if (!quickActions) {
            return;
        }

        quickActions.innerHTML =
            actions
                .map(
                    ([
                        title,
                        text,
                        url,
                        icon,
                        classes
                    ]) => {

                        return `
                            <a
                                href="${url}"
                                class="grid min-h-[72px]
                                       grid-cols-[42px_minmax(0,1fr)_auto]
                                       items-center
                                       gap-3
                                       rounded-lg
                                       border border-[#dce7f8]
                                       bg-[#f8fbff]
                                       px-4
                                       py-3
                                       shadow-[0_10px_24px_rgba(6,25,66,0.04)]
                                       transition
                                       hover:-translate-y-0.5
                                       hover:border-[#bfd4f5]
                                       hover:shadow-[0_12px_28px_rgba(6,25,66,0.08)]"
                            >

                                ${iconWrap(icon, classes)}

                                <div class="min-w-0">

                                    <h3
                                        class="mb-[5px]
                                               text-[12px]
                                               font-bold
                                               text-[#061942]"
                                    >
                                        ${title}
                                    </h3>

                                    <p
                                        class="text-[11px]
                                               text-[#34445e]"
                                    >
                                        ${text}
                                    </p>

                                </div>


                                <span
                                    class="text-[24px]
                                           leading-none
                                           text-[#061942]"
                                >
                                    &#8250;
                                </span>

                            </a>
                        `;
                    }
                )
                .join('');
    }


    /*
    |--------------------------------------------------------------------------
    | Clear Authentication
    |--------------------------------------------------------------------------
    */

    function clearCompanyAuthentication() {

        localStorage.removeItem('ofc_auth_token');
        localStorage.removeItem('onlyfreshers_company_token');

        localStorage.removeItem('ofc_company_profile');
        localStorage.removeItem('onlyfreshers_company_user');
    }


    /*
    |--------------------------------------------------------------------------
    | Load Dashboard
    |--------------------------------------------------------------------------
    */

    async function loadDashboard() {

        /*
        | User not logged in
        */

        if (!token) {

            window.location.href =
                '/company/login';

            return;
        }


        dashboardStatus.textContent =
            'Loading dashboard...';


        /*
        | API Call
        */

        const response =
            await fetch(
                '/api/company/dashboard',
                {
                    method: 'GET',

                    headers: {
                        Accept:
                            'application/json',

                        Authorization:
                            `Bearer ${token}`
                    }
                }
            );


        /*
        | Unauthorized / Forbidden
        */

        if (
            response.status === 401 ||
            response.status === 403
        ) {

            clearCompanyAuthentication();

            window.location.href =
                '/company/login';

            return;
        }


        /*
        | Profile Missing
        */

        if (response.status === 404) {

            window.location.href =
                '/company/profile/edit';

            return;
        }


        /*
        | Parse API Response
        */

        let result;

        try {

            result =
                await response.json();

        } catch (error) {

            throw new Error(
                'Invalid response received from server.'
            );
        }


        /*
        | API Error
        */

        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ||
                'Unable to load dashboard.'
            );
        }


        const data =
            result.data || {};

        dashboardConfig =
            data.dashboard_config ||
            dashboardConfig ||
            {};

        const profile =
            data.company_profile || {};


        /*
        | Save company profile
        */

        localStorage.setItem(
            'ofc_company_profile',
            JSON.stringify(profile)
        );


        /*
        | Approval Pending
        */

        if (
            profile.approval_status ===
            'pending'
        ) {

            window.location.href =
                '/company/approval/pending';

            return;
        }


        /*
        | Approval Rejected
        */

        if (
            profile.approval_status ===
            'rejected'
        ) {

            window.location.href =
                '/company/approval/rejected';

            return;
        }


        /*
        | Company Name
        */

        const companyName =
            profile.company_name ||
            data?.user?.name ||
            'Company';

        welcomeCompanyName.textContent =
            companyName;


        /*
        | Dashboard Status
        */

        dashboardStatus.textContent =
            profile.approval_status &&
            profile.approval_status !== 'approved'
                ? `Approval: ${formatStatus(profile.approval_status)}. Find and hire the best fresher talent for your team.`
                : 'Find and hire the best fresher talent for your team.';


        /*
        | Notify Layout
        */

        document.dispatchEvent(
            new CustomEvent(
                'company-profile-loaded',
                {
                    detail: profile
                }
            )
        );


        /*
        | Render Dashboard
        */

        renderStats(
            data.statistics || {},
            data.free_limits || {}
        );

        renderHiringFreeNotes(
            data.free_limits || {}
        );

        renderConfigDrivenContent(
            data.free_limits || {}
        );

        renderHiringSummary(
            data.statistics || {}
        );

        renderRecentJobPostings(
            data,
            data.free_limits || {}
        );

        renderActivities(data);
    }


    /*
    |--------------------------------------------------------------------------
    | Initial Render
    |--------------------------------------------------------------------------
    */

    renderStats({});
    renderHiringFreeNotes({});
    renderConfigDrivenContent({});
    renderHiringSummary({});
    renderRecentJobPostings({});
    renderActions();

    document
        .querySelectorAll('[data-company-icon]')
        .forEach(element => {
            element.innerHTML =
                iconSvg[element.dataset.companyIcon] || '';
        });


    /*
    |--------------------------------------------------------------------------
    | Start Dashboard
    |--------------------------------------------------------------------------
    */

    loadDashboard()
        .catch(error => {

            console.error(
                'Company dashboard error:',
                error
            );

            dashboardStatus.textContent =
                error.message ||
                'Unable to load dashboard.';

            if (recentActivities) {
                recentActivities.innerHTML = `
                    <p
                        class="rounded-lg
                               border border-[#ffd1d7]
                               bg-[#fff7f8]
                               p-4
                               text-sm
                               text-[#ff3045]"
                    >
                        Unable to load recent activity.
                    </p>
                `;
            }
        });

});
</script>

@endpush
