@extends('layouts.admin')

@section('title', 'System Logs - OnlyFreshers Admin')
@section('pageTitle', 'System Logs')
@section('breadcrumb', 'Dashboard > System Logs')

@php
    $activePage = 'logs';
@endphp

@push('styles')
<style>
    .admin-system-logs-page,
    .admin-system-logs-page * {
        font-family: Inter, Arial, Helvetica, sans-serif !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
    <section class="admin-system-logs-page grid gap-5">
        <div id="logStats" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-lg border border-[#dce7f8] bg-white p-5 text-sm text-[#52607a] shadow-[0_12px_26px_rgba(6,25,66,.05)] sm:col-span-2 xl:col-span-4">Loading system logs...</article>
        </div>

        <div class="rounded-lg border border-[#dce7f8] bg-white shadow-[0_12px_26px_rgba(6,25,66,.05)]">
            <div class="grid gap-3 border-b border-[#edf2fb] p-4 lg:grid-cols-[minmax(0,1fr)_220px_180px_auto] lg:items-center">
                <input id="logSearch" class="h-10 w-full rounded-md border border-[#dce7f8] px-3 text-sm outline-none" type="search" placeholder="Search logs...">
                <select id="fileFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]"><option value="">Loading files...</option></select>
                <select id="levelFilter" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm text-[#24344f]">
                    <option value="">All Levels</option>
                    <option value="error">Error</option>
                    <option value="warning">Warning</option>
                    <option value="info">Info</option>
                    <option value="debug">Debug</option>
                    <option value="critical">Critical</option>
                </select>
                <button id="refreshLogs" class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white" type="button">Refresh</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1040px] text-left text-sm">
                    <thead class="bg-[#fbfdff] text-xs font-bold text-[#24344f]">
                        <tr><th class="px-5 py-4">Time</th><th class="px-5 py-4">Level</th><th class="px-5 py-4">File</th><th class="px-5 py-4">Message</th><th class="px-5 py-4">Action</th></tr>
                    </thead>
                    <tbody id="logRows" class="divide-y divide-[#edf2fb] text-[#1b315b]">
                        <tr><td class="px-5 py-5" colspan="5">Loading system logs...</td></tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination" class="hidden items-center justify-between border-t border-[#edf2fb] p-4 text-sm text-[#52607a]">
                <button id="prevPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Previous</button>
                <span id="pageInfo" class="font-bold text-[#061942]"></span>
                <button id="nextPage" class="rounded-md border border-[#dce7f8] px-4 py-2 text-xs font-bold text-[#075fe4]" type="button">Next</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const token = localStorage.getItem('ofc_auth_token');
    const logStats = document.getElementById('logStats');
    const logRows = document.getElementById('logRows');
    const logSearch = document.getElementById('logSearch');
    const fileFilter = document.getElementById('fileFilter');
    const levelFilter = document.getElementById('levelFilter');
    const refreshLogs = document.getElementById('refreshLogs');
    const pagination = document.getElementById('pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    let filesLoaded = false;
    let currentPage = 1;
    let lastPage = 1;
    let searchTimer = null;

    if (!token) window.location.href = '/admin/login';

    function escapeHtml(value) { return String(value || '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[c]); }
    function number(value) { return Number(value || 0).toLocaleString('en-IN'); }
    function levelClass(level) {
        if (['error', 'critical', 'alert', 'emergency'].includes(level)) return 'bg-[#fff0f1] text-[#ff1f2f]';
        if (level === 'warning') return 'bg-[#fff4df] text-[#b86500]';
        if (level === 'debug') return 'bg-[#eef2f8] text-[#24344f]';
        return 'bg-[#e8f8ef] text-[#078346]';
    }
    const statIcons = {
        'Log Files': '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h6"/></svg>',
        Entries: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>',
        Errors: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>',
        Warnings: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v6"/><path d="M12 17h.01"/></svg>',
    };
    function statCard(label, value, tone) {
        return `<article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_12px_26px_rgba(6,25,66,.05)]"><span class="inline-flex h-10 w-10 items-center justify-center rounded-lg ${tone} [&>svg]:h-5 [&>svg]:w-5">${statIcons[label] || statIcons.Entries}</span><p class="mt-4 text-xs text-[#52607a]">${escapeHtml(label)}</p><h2 class="mt-2 text-3xl text-[#061942]">${escapeHtml(value)}</h2></article>`;
    }
    function renderStats(stats, selectedFile) {
        logStats.innerHTML = [
            statCard('Log Files', number(stats.total_files), 'bg-[#eaf2ff] text-[#075fe4]'),
            statCard('Entries', number(stats.total_entries), 'bg-[#e8f8ef] text-[#078346]'),
            statCard('Errors', number(stats.errors), 'bg-[#fff0f1] text-[#ff1f2f]'),
            statCard('Warnings', number(stats.warnings), 'bg-[#fff4df] text-[#b86500]'),
        ].join('');
        if (selectedFile && !fileFilter.value) fileFilter.value = selectedFile;
    }
    function renderFiles(files, selectedFile) {
        if (filesLoaded) return;
        fileFilter.innerHTML = files.length
            ? files.map((file) => `<option value="${escapeHtml(file.name)}">${escapeHtml(file.name)}</option>`).join('')
            : '<option value="">No log files</option>';
        fileFilter.value = selectedFile || files[0]?.name || '';
        filesLoaded = true;
    }
    function renderRows(logs) {
        const rows = logs.data || [];
        if (!rows.length) {
            logRows.innerHTML = '<tr><td class="px-5 py-5 text-[#52607a]" colspan="5">No logs found.</td></tr>';
            return;
        }
        logRows.innerHTML = rows.map((log, index) => `<tr>
            <td class="px-5 py-4 text-xs text-[#52607a]">${escapeHtml(log.timestamp || '-')}</td>
            <td class="px-5 py-4"><span class="rounded-md ${levelClass(log.level)} px-3 py-1 text-xs font-bold uppercase">${escapeHtml(log.level)}</span></td>
            <td class="px-5 py-4">${escapeHtml(log.file)}</td>
            <td class="px-5 py-4"><strong class="block max-w-[520px] truncate text-[#061942]">${escapeHtml(log.message)}</strong><span id="context-${index}" class="mt-2 hidden whitespace-pre-wrap rounded-md bg-[#f8fbff] p-3 text-xs text-[#52607a]">${escapeHtml(log.context || 'No extra context.')}</span></td>
            <td class="px-5 py-4"><button class="toggle-context rounded-md border border-[#075fe4] px-3 py-2 text-xs font-bold text-[#075fe4]" type="button" data-target="context-${index}">View</button></td>
        </tr>`).join('');
    }
    function setPagination(logs) {
        currentPage = logs.current_page || 1;
        lastPage = logs.last_page || 1;
        pageInfo.textContent = 'Page ' + currentPage + ' of ' + lastPage + ' - ' + number(logs.total) + ' entries';
        prevPage.disabled = currentPage <= 1;
        nextPage.disabled = currentPage >= lastPage;
        pagination.classList.toggle('hidden', lastPage <= 1);
        pagination.classList.toggle('flex', lastPage > 1);
    }
    async function requestJson(url) {
        const response = await fetch(url, { headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token } });
        if (response.status === 401) { window.location.href = '/admin/login'; return null; }
        const payload = await response.json();
        if (!response.ok || !payload.success) throw new Error(payload.message || 'Request failed.');
        return payload;
    }
    async function loadLogs(page = 1) {
        try {
            refreshLogs.disabled = true;
            const params = new URLSearchParams({ page, per_page: 20 });
            if (fileFilter.value) params.set('file', fileFilter.value);
            if (levelFilter.value) params.set('level', levelFilter.value);
            if (logSearch.value.trim()) params.set('search', logSearch.value.trim());
            const payload = await requestJson('/api/admin/system-logs?' + params.toString());
            if (!payload) return;
            renderFiles(payload.data?.files || [], payload.data?.selected_file);
            renderStats(payload.data?.stats || {}, payload.data?.selected_file);
            renderRows(payload.data?.logs || {});
            setPagination(payload.data?.logs || {});
        } catch (error) {
            logStats.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-5 text-sm font-bold text-[#b42318] sm:col-span-2 xl:col-span-4">' + escapeHtml(error.message || 'System logs load nahi ho paaye.') + '</article>';
            logRows.innerHTML = '<tr><td class="px-5 py-5 text-[#ff1f2f]" colspan="5">System logs load nahi ho paaye.</td></tr>';
        } finally {
            refreshLogs.disabled = false;
        }
    }
    logSearch.addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadLogs(1), 350); });
    fileFilter.addEventListener('change', () => loadLogs(1));
    levelFilter.addEventListener('change', () => loadLogs(1));
    refreshLogs.addEventListener('click', () => loadLogs(currentPage));
    prevPage.addEventListener('click', () => loadLogs(Math.max(1, currentPage - 1)));
    nextPage.addEventListener('click', () => loadLogs(Math.min(lastPage, currentPage + 1)));
    logRows.addEventListener('click', (event) => {
        const button = event.target.closest('.toggle-context');
        if (!button?.dataset.target) return;
        const target = document.getElementById(button.dataset.target);
        target?.classList.toggle('hidden');
        button.textContent = target?.classList.contains('hidden') ? 'View' : 'Hide';
    });
    loadLogs();
</script>
@endpush
