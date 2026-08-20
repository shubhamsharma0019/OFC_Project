@extends('layouts.admin')

@section('title', 'Admin Dashboard - OnlyFreshers')
@section('pageTitle', 'Admin Dashboard')
@section('breadcrumb', 'Platform overview and approvals')

@php
    $activePage = 'dashboard';
@endphp

@push('styles')
<style>
    .admin-dashboard-page,
    .admin-dashboard-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
    .admin-dashboard-page h2,
    .admin-dashboard-page h3,
    .admin-dashboard-page strong {
        font-weight: 600 !important;
    }
    .admin-hero-card {
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
    .admin-hero-card h2 {
        margin: 0 0 8px;
        color: #061942;
        font-size: 17px;
        line-height: 1.2;
    }
    .admin-hero-card p {
        margin: 0 0 17px;
        color: #34445e;
        font-size: 12px;
        font-weight: 600 !important;
    }
    .admin-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    .admin-hero-actions a {
        display: inline-flex;
        height: 34px;
        min-width: 118px;
        align-items: center;
        justify-content: center;
        border: 1px solid #075fe4;
        border-radius: 4px;
        padding: 0 18px;
        font-size: 10px;
        font-weight: 600 !important;
        text-decoration: none;
    }
    .admin-hero-actions a:first-child {
        background: #075fe4;
        color: #fff;
    }
    .admin-hero-actions a:last-child {
        background: #fff;
        color: #075fe4;
    }
    .admin-top-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0;
        border-radius: 9px;
        background: rgba(255, 255, 255, .88);
        padding: 14px 12px;
    }
    .admin-top-stat {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 42px;
        align-items: center;
        gap: 10px;
        min-height: 72px;
        padding: 0 16px;
        border-right: 1px solid #dce7f8;
    }
    .admin-top-stat:last-child {
        border-right: 0;
    }
    .admin-top-stat small {
        display: block;
        margin-bottom: 7px;
        color: #061942;
        font-size: 8px;
        font-weight: 600 !important;
        line-height: 1.1;
        text-transform: uppercase;
    }
    .admin-top-stat strong {
        display: block;
        margin-bottom: 4px;
        color: #061942;
        font-size: 24px;
        line-height: .9;
    }
    .admin-top-stat span {
        display: block;
        color: #34445e;
        font-size: 9px;
        font-weight: 600 !important;
        line-height: 1.25;
    }
    .admin-stat-icon,
    .admin-summary-icon,
    .admin-card-icon {
        display: grid;
        place-items: center;
        border-radius: 50%;
    }
    .admin-stat-icon {
        width: 42px;
        height: 42px;
    }
    .admin-stat-icon svg,
    .admin-summary-icon svg,
    .admin-card-icon svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .admin-section {
        margin-bottom: 20px;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        box-shadow: 0 12px 30px rgba(6, 25, 66, 0.055);
        overflow: hidden;
    }
    .admin-section-pad {
        padding: 24px 26px;
    }
    .admin-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid #e7eef8;
        background: linear-gradient(135deg, #ffffff 0%, #f7fbff 100%);
        padding: 22px 26px 18px;
    }
    .admin-section-head h2,
    .admin-section-title {
        margin: 0;
        color: #061942;
        font-size: 21px;
        line-height: 1.2;
    }
    .admin-section-head p {
        margin: 6px 0 0;
        color: #526287;
        font-size: 11px;
        font-weight: 600 !important;
    }
    .admin-section-head a {
        color: #075fe4;
        font-size: 12px;
        font-weight: 600 !important;
        text-decoration: none;
    }
    .admin-mode-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }
    .admin-mode-card {
        display: grid;
        grid-template-columns: 82px minmax(0, 1fr);
        align-items: center;
        gap: 18px;
        min-height: 148px;
        border: 1px solid #dce7f8;
        border-radius: 10px;
        background: #fff;
        padding: 20px 22px;
    }
    .admin-card-icon {
        width: 66px;
        height: 66px;
    }
    .admin-card-icon svg {
        width: 32px;
        height: 32px;
    }
    .admin-mode-card h3 {
        margin: 0 0 12px;
        color: #061942;
        font-size: 16px;
        text-transform: uppercase;
    }
    .admin-mode-card ul {
        display: grid;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .admin-mode-card li {
        display: flex;
        gap: 8px;
        color: #34445e;
        font-size: 12px;
        font-weight: 600 !important;
        line-height: 1.35;
    }
    .admin-mode-card li b {
        color: #0b8b67;
    }
    .admin-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 18px;
        margin-top: 22px;
    }
    .admin-summary-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 52px;
        align-items: center;
        gap: 12px;
        min-height: 126px;
        border: 1px solid #dce7f8;
        border-radius: 9px;
        background: #fff;
        padding: 20px 18px;
    }
    .admin-summary-card p {
        margin: 0 0 14px;
        color: #34445e;
        font-size: 12px;
        font-weight: 600 !important;
    }
    .admin-summary-card strong {
        display: block;
        margin-bottom: 10px;
        color: #061942;
        font-size: 32px;
        line-height: .8;
    }
    .admin-summary-card span {
        display: block;
        color: #34445e;
        font-size: 12px;
        font-weight: 600 !important;
    }
    .admin-summary-icon {
        width: 52px;
        height: 52px;
    }
    .admin-grid-two {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(360px, .8fr);
        gap: 20px;
    }
    .admin-chart {
        display: grid;
        min-height: 300px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        align-items: stretch;
        gap: 16px;
        padding: 24px 26px;
    }
    .admin-bar-item {
        display: grid;
        min-height: 132px;
        grid-template-rows: auto 1fr auto;
        gap: 14px;
        border: 1px solid #dce7f8;
        border-radius: 10px;
        background: #fff;
        padding: 16px;
        box-shadow: 0 8px 20px rgba(6, 25, 66, 0.035);
    }
    .admin-bar-bg {
        display: flex;
        align-items: center;
        min-height: 10px;
        border-radius: 999px;
        background: #eef5ff;
        overflow: hidden;
    }
    .admin-bar-fill {
        height: 100%;
        min-height: 10px;
        border-radius: 999px;
        background: linear-gradient(90deg, #075fe4, #4d93ff);
        box-shadow: 0 10px 20px rgba(7, 95, 228, .18);
    }
    .admin-bar-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .admin-bar-top span {
        color: #526287;
        font-size: 11px;
        font-weight: 600 !important;
    }
    .admin-bar-top strong {
        color: #061942;
        font-size: 24px;
        line-height: 1;
    }
    .admin-bar-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #526287;
        font-size: 11px;
        font-weight: 600 !important;
    }
    .admin-list {
        display: grid;
        gap: 12px;
        padding: 20px 22px;
    }
    .admin-list-row {
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr) auto;
        align-items: center;
        gap: 14px;
        min-height: 76px;
        border: 1px solid #edf2fb;
        border-radius: 10px;
        background: linear-gradient(135deg, #ffffff 0%, #fbfdff 100%);
        padding: 14px 16px;
        text-decoration: none;
        box-shadow: 0 8px 18px rgba(6, 25, 66, 0.03);
        transition: transform .16s ease, border-color .16s ease, box-shadow .16s ease;
    }
    .admin-list-row:hover {
        transform: translateY(-1px);
        border-color: #bfd4f5;
        background: #fbfdff;
        box-shadow: 0 14px 26px rgba(6, 25, 66, 0.07);
    }
    .admin-list-row .avatar {
        display: grid;
        width: 44px;
        height: 44px;
        place-items: center;
        border-radius: 11px;
        background: #eaf2ff;
        color: #075fe4;
        font-size: 12px;
        font-weight: 600 !important;
    }
    .admin-list-row h3 {
        margin: 0 0 5px;
        overflow: hidden;
        color: #061942;
        font-size: 13px;
        line-height: 1.2;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .admin-list-row p {
        margin: 0;
        overflow: hidden;
        color: #526287;
        font-size: 11px;
        font-weight: 600 !important;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .admin-pill {
        display: inline-flex;
        min-width: 74px;
        min-height: 28px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 10px;
        font-weight: 600 !important;
        line-height: 1;
        text-transform: capitalize;
        white-space: nowrap;
    }
    .admin-empty-state {
        border: 1px dashed #c7d9f4;
        border-radius: 10px;
        background: #fbfdff;
        padding: 20px;
        color: #526287;
        font-size: 13px;
        text-align: center;
    }
    .admin-feed {
        display: grid;
        gap: 0;
        padding: 18px 22px 22px;
    }
    .admin-feed-row {
        position: relative;
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr) minmax(82px, auto);
        gap: 14px;
        align-items: center;
        padding: 14px 0 14px;
        text-decoration: none;
    }
    .admin-feed-row:before {
        content: "";
        position: absolute;
        left: 20px;
        top: 56px;
        bottom: -8px;
        width: 1px;
        background: #dce7f8;
    }
    .admin-feed-row:last-child:before {
        display: none;
    }
    .admin-feed-icon {
        position: relative;
        z-index: 1;
        display: grid;
        width: 42px;
        height: 42px;
        place-items: center;
        border: 1px solid #dce7f8;
        border-radius: 12px;
        background: #fff;
    }
    .admin-feed-icon svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .admin-feed-card {
        min-width: 0;
        border: 1px solid #edf2fb;
        border-radius: 10px;
        background: linear-gradient(135deg, #fff 0%, #fbfdff 100%);
        padding: 14px 16px;
        box-shadow: 0 8px 18px rgba(6, 25, 66, .03);
    }
    .admin-feed-card h3 {
        margin: 0 0 6px;
        overflow: hidden;
        color: #061942;
        font-size: 14px;
        line-height: 1.25;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .admin-feed-card p {
        margin: 0;
        color: #526287;
        font-size: 12px;
        line-height: 1.45;
    }
    .admin-enrollment-grid {
        display: grid;
        gap: 12px;
        padding: 20px 22px;
    }
    .admin-enrollment-card {
        display: grid;
        gap: 12px;
        border: 1px solid #edf2fb;
        border-radius: 10px;
        background: #fff;
        padding: 16px;
        box-shadow: 0 8px 18px rgba(6, 25, 66, .03);
        text-decoration: none;
    }
    .admin-enrollment-top {
        display: grid;
        grid-template-columns: 44px minmax(0, 1fr) minmax(82px, auto);
        align-items: center;
        gap: 12px;
    }
    .admin-enrollment-avatar {
        display: grid;
        width: 44px;
        height: 44px;
        place-items: center;
        border-radius: 50%;
        background: #eaf2ff;
        color: #075fe4;
        font-size: 13px;
        font-weight: 600 !important;
    }
    .admin-enrollment-card h3 {
        margin: 0 0 5px;
        overflow: hidden;
        color: #061942;
        font-size: 14px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .admin-enrollment-card p {
        margin: 0;
        overflow: hidden;
        color: #526287;
        font-size: 12px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .admin-mini-progress {
        height: 8px;
        overflow: hidden;
        border-radius: 999px;
        background: #eef5ff;
    }
    .admin-mini-progress span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #075fe4, #00ad6f);
    }
    @media (max-width: 1200px) {
        .admin-hero-card,
        .admin-grid-two,
        .admin-mode-grid,
        .admin-summary-grid {
            grid-template-columns: 1fr;
        }
        .admin-top-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .admin-top-stat:nth-child(2) {
            border-right: 0;
        }
        .admin-top-stat:nth-child(-n + 2) {
            border-bottom: 1px solid #dce7f8;
            margin-bottom: 14px;
            padding-bottom: 14px;
        }
    }
    @media (max-width: 700px) {
        .admin-top-stats,
        .admin-chart {
            grid-template-columns: 1fr;
        }
        .admin-top-stat {
            border-right: 0;
            border-bottom: 1px solid #dce7f8;
            padding: 14px 0;
        }
        .admin-top-stat:last-child {
            border-bottom: 0;
        }
        .admin-mode-card {
            grid-template-columns: 1fr;
        }
        .admin-section-head {
            align-items: flex-start;
            flex-direction: column;
        }
        .admin-feed-row,
        .admin-enrollment-top,
        .admin-list-row {
            grid-template-columns: 42px minmax(0, 1fr);
        }
        .admin-feed-row .admin-pill,
        .admin-enrollment-top .admin-pill,
        .admin-list-row .admin-pill {
            grid-column: 2;
            justify-self: start;
        }
    }
</style>
@endpush

@section('content')
<section class="admin-dashboard-page">
    <section class="admin-hero-card">
        <div>
            <h2>Welcome back, <strong id="adminName">Admin</strong>!</h2>
            <p id="adminStatus">Monitor users, approvals, jobs, courses and platform revenue.</p>
            <div class="admin-hero-actions">
                <a href="/admin/companies">Review Companies</a>
                <a href="/admin/training-partners">Review Partners</a>
            </div>
        </div>

        <div id="adminTopStats" class="admin-top-stats">
            <article class="admin-top-stat">
                <div><small>Status</small><strong>...</strong><span>Loading dashboard</span></div>
                <div class="admin-stat-icon bg-[#eaf2ff] text-[#075fe4]"></div>
            </article>
        </div>
    </section>

    <section class="admin-section">
        <div class="admin-section-pad">
            <div class="admin-mode-grid">
                <article class="admin-mode-card">
                    <span class="admin-card-icon bg-[#eaf2ff] text-[#075fe4]" data-admin-icon="building"></span>
                    <div>
                        <h3>Company Control</h3>
                        <ul id="companyControlList">
                            <li><b>&#10003;</b>Loading company approval data...</li>
                        </ul>
                    </div>
                </article>
                <article class="admin-mode-card">
                    <span class="admin-card-icon bg-[#e8fbf3] text-[#00ad6f]" data-admin-icon="training"></span>
                    <div>
                        <h3>Training Partner Control</h3>
                        <ul id="partnerControlList">
                            <li><b>&#10003;</b>Loading partner approval data...</li>
                        </ul>
                    </div>
                </article>
            </div>

            <h2 class="admin-section-title" style="margin-top:24px;text-align:center;">Platform Summary</h2>
            <div id="adminSummaryGrid" class="admin-summary-grid"></div>
        </div>
    </section>

    <section class="admin-grid-two">
        <article class="admin-section">
            <div class="admin-section-head">
                <div>
                    <h2>Platform Overview</h2>
                    <p>Live admin metrics from users, jobs, courses and revenue</p>
                </div>
                <span id="totalRevenue" class="admin-pill bg-[#eaf2ff] text-[#075fe4]">Rs. 0 Revenue</span>
            </div>
            <div id="platformOverview" class="admin-chart">
                <div class="text-sm text-[#52607a]">Loading overview...</div>
            </div>
        </article>

        <article class="admin-section">
            <div class="admin-section-head">
                <div>
                    <h2>Approval Queue</h2>
                    <p>Profiles that need admin action</p>
                </div>
                <a href="/admin/companies">View Queue -></a>
            </div>
            <div id="approvalQueue" class="admin-list">
                <div class="rounded-lg border border-[#edf2fb] p-4 text-sm text-[#52607a]">Loading approvals...</div>
            </div>
        </article>
    </section>

    <section class="admin-grid-two">
        <article class="admin-section">
            <div class="admin-section-head">
                <div>
                    <h2>Recent Activity</h2>
                    <p>Latest companies, partners and jobs</p>
                </div>
                <a href="/admin/notifications">View Notifications -></a>
            </div>
            <div id="recentActivity" class="admin-feed">
                <div class="rounded-lg border border-[#edf2fb] p-4 text-sm text-[#52607a]">Loading activity...</div>
            </div>
        </article>

        <article class="admin-section">
            <div class="admin-section-head">
                <div>
                    <h2>Recent Enrollments</h2>
                    <p>Fresh course enrollment activity</p>
                </div>
                <a href="/admin/enrollments">View Enrollments -></a>
            </div>
            <div id="recentEnrollments" class="admin-enrollment-grid">
                <div class="rounded-lg border border-[#edf2fb] p-4 text-sm text-[#52607a]">Loading enrollments...</div>
            </div>
        </article>
    </section>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('ofc_auth_token');
    const storedUser = JSON.parse(localStorage.getItem('ofc_auth_user') || 'null');
    const adminName = document.getElementById('adminName');
    const adminStatus = document.getElementById('adminStatus');
    const adminTopStats = document.getElementById('adminTopStats');
    const companyControlList = document.getElementById('companyControlList');
    const partnerControlList = document.getElementById('partnerControlList');
    const adminSummaryGrid = document.getElementById('adminSummaryGrid');
    const platformOverview = document.getElementById('platformOverview');
    const approvalQueue = document.getElementById('approvalQueue');
    const recentActivity = document.getElementById('recentActivity');
    const recentEnrollments = document.getElementById('recentEnrollments');
    const totalRevenue = document.getElementById('totalRevenue');

    if (!token) {
        window.location.href = '/admin/login';
        return;
    }

    if (storedUser?.name && adminName) {
        adminName.textContent = storedUser.name;
    }

    const icons = {
        users: '<svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"></circle><path d="M3 19c0-3 2.5-5 6-5"></path><circle cx="17" cy="9" r="2.5"></circle><path d="M14 19c0-2.4 1.8-4 4-4"></path></svg>',
        building: '<svg viewBox="0 0 24 24"><path d="M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16"></path><path d="M15 9h4a1 1 0 0 1 1 1v11"></path><path d="M8 8h3M8 12h3M8 16h3"></path></svg>',
        briefcase: '<svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="12" rx="2"></rect><path d="M9 7V5h6v2M4 12h16"></path></svg>',
        training: '<svg viewBox="0 0 24 24"><path d="M3 8l9-4 9 4-9 4-9-4z"></path><path d="M7 10v5c0 1.5 2.3 3 5 3s5-1.5 5-3v-5"></path></svg>',
        course: '<svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5Z"></path></svg>',
        revenue: '<svg viewBox="0 0 24 24"><path d="M12 3c4 4 7 8 7 12a7 7 0 0 1-14 0c0-4 3-8 7-12Z"></path><path d="M9 14h6M12 11v6"></path></svg>',
        check: '<svg viewBox="0 0 24 24"><path d="m20 6-11 11-5-5"></path></svg>',
        calendar: '<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 3v4M16 3v4M4 10h16"></path></svg>',
    };

    document.querySelectorAll('[data-admin-icon]').forEach(element => {
        element.innerHTML = icons[element.dataset.adminIcon] || '';
    });

    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
    const number = value => Number(value || 0).toLocaleString('en-IN');
    const money = value => 'Rs. ' + Number(value || 0).toLocaleString('en-IN');
    const statusText = value => String(value || '-').replaceAll('_', ' ');
    const statusTone = status => {
        const value = String(status || '').toLowerCase();
        if (value.includes('approved') || value.includes('active') || value.includes('completed') || value.includes('paid')) return 'bg-[#e8fbf3] text-[#067a4f]';
        if (value.includes('reject') || value.includes('failed') || value.includes('blocked')) return 'bg-[#fff1f2] text-[#c8102e]';
        return 'bg-[#eaf2ff] text-[#075fe4]';
    };
    const timeAgo = value => {
        if (!value) return 'Recently';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return 'Recently';
        const days = Math.floor((Date.now() - date.getTime()) / 86400000);
        if (days <= 0) return 'Today';
        if (days === 1) return '1 day ago';
        return `${days} days ago`;
    };

    function topStat(title, value, note, icon, classes) {
        return `<article class="admin-top-stat">
            <div class="min-w-0">
                <small>${esc(title)}</small>
                <strong>${esc(value)}</strong>
                <span>${esc(note)}</span>
            </div>
            <div class="admin-stat-icon ${classes}">${icons[icon] || ''}</div>
        </article>`;
    }

    function summaryCard(title, value, note, icon, classes) {
        return `<article class="admin-summary-card">
            <div>
                <p>${esc(title)}</p>
                <strong>${esc(value)}</strong>
                <span>${esc(note)}</span>
            </div>
            <div class="admin-summary-icon ${classes}">${icons[icon] || ''}</div>
        </article>`;
    }

    function listRow(title, meta, status, href = '#') {
        return `<a class="admin-list-row" href="${href}">
            <span class="avatar">${esc(String(title || 'OF').slice(0, 2).toUpperCase())}</span>
            <span class="min-w-0">
                <h3>${esc(title || 'Item')}</h3>
                <p>${esc(meta || '')}</p>
            </span>
            <span class="admin-pill ${statusTone(status)}">${esc(statusText(status))}</span>
        </a>`;
    }

    function feedRow(title, meta, status, icon, href = '#') {
        return `<a class="admin-feed-row" href="${href}">
            <span class="admin-feed-icon ${statusTone(status)}">${icons[icon] || icons.check}</span>
            <span class="admin-feed-card">
                <h3>${esc(title || 'Activity')}</h3>
                <p>${esc(meta || '')}</p>
            </span>
            <span class="admin-pill ${statusTone(status)}">${esc(statusText(status))}</span>
        </a>`;
    }

    function enrollmentCard(item) {
        const name = item.fresher_profile?.user?.name || 'Fresher';
        const course = item.course?.course_name || item.course?.title || 'Course';
        const status = item.enrollment_status || item.payment_status || 'pending';
        const progress = statusText(status).toLowerCase().includes('completed') ? 100 : (statusText(status).toLowerCase().includes('paid') ? 65 : 35);

        return `<a class="admin-enrollment-card" href="/admin/enrollments">
            <span class="admin-enrollment-top">
                <span class="admin-enrollment-avatar">${esc(String(name).slice(0, 1).toUpperCase())}</span>
                <span class="min-w-0">
                    <h3>${esc(name)}</h3>
                    <p>${esc(course)} - ${esc(timeAgo(item.enrollment_date || item.created_at))}</p>
                </span>
                <span class="admin-pill ${statusTone(status)}">${esc(statusText(status))}</span>
            </span>
            <span class="admin-mini-progress"><span style="width:${progress}%"></span></span>
        </a>`;
    }

    function renderTop(stats) {
        const pendingApprovals = Number(stats.pending_companies || 0) + Number(stats.pending_training_partners || 0);
        adminTopStats.innerHTML = [
            topStat('Total Users', number(stats.total_users), `${number(stats.active_users)} active users`, 'users', 'bg-[#eaf2ff] text-[#075fe4]'),
            topStat('Pending Approvals', number(pendingApprovals), 'Companies and partners', 'check', 'bg-[#fff4df] text-[#b86500]'),
            topStat('Active Jobs', number(stats.active_jobs), `${number(stats.total_jobs)} total jobs`, 'briefcase', 'bg-[#e8fbf3] text-[#067a4f]'),
            topStat('Revenue', money(stats.total_payment_amount), `${number(stats.successful_payments)} successful payments`, 'revenue', 'bg-[#f0edff] text-[#6c50ff]'),
        ].join('');

        adminStatus.textContent = `${number(stats.total_users)} users, ${number(stats.total_jobs)} jobs, ${number(stats.total_courses)} courses and ${money(stats.total_payment_amount)} revenue on the platform.`;
    }

    function renderControl(stats) {
        companyControlList.innerHTML = [
            `<li><b>&#10003;</b>${number(stats.pending_companies)} companies pending approval.</li>`,
            `<li><b>&#10003;</b>${number(stats.approved_companies)} approved company profiles.</li>`,
            `<li><b>&#10003;</b>${number(stats.rejected_companies)} rejected company profiles tracked.</li>`,
        ].join('');
        partnerControlList.innerHTML = [
            `<li><b>&#10003;</b>${number(stats.pending_training_partners)} training partners pending approval.</li>`,
            `<li><b>&#10003;</b>${number(stats.approved_training_partners)} approved partner profiles.</li>`,
            `<li><b>&#10003;</b>${number(stats.total_courses)} total courses created.</li>`,
        ].join('');
    }

    function renderSummary(stats) {
        adminSummaryGrid.innerHTML = [
            summaryCard('Freshers', number(stats.total_freshers), 'Registered fresher accounts', 'users', 'bg-[#eaf2ff] text-[#075fe4]'),
            summaryCard('Companies', number(stats.total_companies), `${number(stats.pending_companies)} pending`, 'building', 'bg-[#e8fbf3] text-[#067a4f]'),
            summaryCard('Training Partners', number(stats.total_training_partners), `${number(stats.pending_training_partners)} pending`, 'training', 'bg-[#f0edff] text-[#6c50ff]'),
            summaryCard('Applications', number(stats.total_job_applications), `${number(stats.hired_applications)} hired`, 'briefcase', 'bg-[#fff4df] text-[#b86500]'),
            summaryCard('Enrollments', number(stats.total_course_enrollments), `${number(stats.completed_enrollments)} completed`, 'course', 'bg-[#eaf2ff] text-[#075fe4]'),
        ].join('');
    }

    function renderOverview(stats) {
        const rows = [
            ['Users', stats.total_users, 'Active users', stats.active_users],
            ['Jobs', stats.total_jobs, 'Active jobs', stats.active_jobs],
            ['Courses', stats.total_courses, 'Active courses', stats.active_courses],
            ['Applications', stats.total_job_applications, 'Hired', stats.hired_applications],
            ['Enrollments', stats.total_course_enrollments, 'Completed', stats.completed_enrollments],
            ['Certificates', stats.total_certificates, 'Issued certificates', stats.total_certificates],
        ];
        const max = Math.max(1, ...rows.map(row => Number(row[1] || 0)));
        totalRevenue.textContent = `${money(stats.total_payment_amount)} Revenue`;
        platformOverview.innerHTML = rows.map(([label, value, metaLabel, metaValue]) => {
            const height = Math.max(10, Math.round((Number(value || 0) / max) * 100));
            return `<div class="admin-bar-item">
                <div class="admin-bar-top">
                    <span>${esc(label)}</span>
                    <strong>${number(value)}</strong>
                </div>
                <div class="admin-bar-bg"><div class="admin-bar-fill" style="width:${height}%"></div></div>
                <div class="admin-bar-meta">
                    <span>${esc(metaLabel)}</span>
                    <strong>${number(metaValue)}</strong>
                </div>
            </div>`;
        }).join('');
    }

    function renderApprovals(stats) {
        approvalQueue.innerHTML = [
            listRow('Pending Companies', `${number(stats.pending_companies)} company profiles waiting`, 'pending', '/admin/companies'),
            listRow('Pending Training Partners', `${number(stats.pending_training_partners)} partner profiles waiting`, 'pending', '/admin/training-partners'),
            listRow('Rejected Companies', `${number(stats.rejected_companies)} rejected profiles`, 'rejected', '/admin/companies'),
            listRow('Rejected Partners', `${number(stats.rejected_training_partners)} rejected profiles`, 'rejected', '/admin/training-partners'),
        ].join('');
    }

    function renderActivity(data) {
        const companies = (data.recent_companies || []).map(item => feedRow(
            item.company_name || item.user?.name || 'Company',
            `Company profile - ${timeAgo(item.created_at)}`,
            item.approval_status,
            'building',
            '/admin/companies'
        ));
        const partners = (data.recent_training_partners || []).map(item => feedRow(
            item.institute_name || item.user?.name || 'Training Partner',
            `Training partner - ${timeAgo(item.created_at)}`,
            item.approval_status,
            'training',
            '/admin/training-partners'
        ));
        const jobs = (data.recent_jobs || []).map(item => feedRow(
            item.title || item.job_title || 'Job',
            `${item.company_profile?.company_name || 'Company'} - ${number(item.applications_count)} applications`,
            item.status,
            'briefcase',
            '/admin/jobs'
        ));
        const rows = [...companies, ...partners, ...jobs].slice(0, 7);
        recentActivity.innerHTML = rows.length ? rows.join('') : '<div class="admin-empty-state">No recent activity found.</div>';
    }

    function renderEnrollments(rows) {
        recentEnrollments.innerHTML = rows.length
            ? rows.map(item => enrollmentCard(item)).join('')
            : '<div class="admin-empty-state">No enrollments found.</div>';
    }

    async function loadDashboard() {
        try {
            const response = await fetch('/api/admin/dashboard', {
                headers: {
                    Accept: 'application/json',
                    Authorization: `Bearer ${token}`,
                },
            });

            const payload = await response.json().catch(() => ({}));

            if (response.status === 401) {
                window.location.href = '/admin/login';
                return;
            }

            if (!response.ok || !payload.success) {
                throw new Error(payload.message || 'Dashboard load nahi ho paaya.');
            }

            const data = payload.data || {};
            const stats = data.statistics || {};

            if (data.admin?.name && adminName) {
                adminName.textContent = data.admin.name;
            }

            renderTop(stats);
            renderControl(stats);
            renderSummary(stats);
            renderOverview(stats);
            renderApprovals(stats);
            renderActivity(data);
            renderEnrollments(data.recent_enrollments || []);
        } catch (error) {
            adminTopStats.innerHTML = `<article class="admin-top-stat" style="grid-column:1/-1;"><div><small>Error</small><strong>!</strong><span>${esc(error.message || 'Dashboard load nahi ho paaya.')}</span></div><div class="admin-stat-icon bg-[#fff1f2] text-[#c8102e]">${icons.briefcase}</div></article>`;
        }
    }

    loadDashboard();
});
</script>
@endpush
