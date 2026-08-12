@extends('layouts.fast-track')

@section('title', 'My Profile - Fast Track')

@php
    $activePage = 'profile';
@endphp

@section('content')
    <section class="space-y-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">My Profile</h1>
                <p class="mt-2 text-sm font-medium text-[#455a82]">View and manage your personal, education, skills, and resume details.</p>
            </div>
            <button id="toggleEdit" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]" type="button">Edit Profile</button>
        </div>

        <div id="profileMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <div class="grid items-start gap-6 xl:grid-cols-[340px_minmax(0,1fr)]">
            <article id="profileSidebar" class="rounded-lg border border-[#dce7f8] bg-white px-6 py-7 text-center shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <p class="text-sm text-[#455a82]">Loading profile...</p>
            </article>

            <div class="space-y-6">
                <div id="profileView" class="space-y-6">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                        <p class="text-sm text-[#455a82]">Loading profile details...</p>
                    </article>
                </div>

                <article id="profileEditCard" class="hidden rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <h3 class="mb-5 text-lg font-bold text-[#061942]">Edit Profile</h3>
                    <form id="profileForm" class="grid gap-4 lg:grid-cols-2">
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Phone
                            <input name="phone" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">City
                            <input name="city" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Qualification
                            <input name="qualification" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">College Name
                            <input name="college_name" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Passing Year
                            <input name="passing_year" type="number" min="1900" max="2100" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Profile Photo
                            <input name="profile_photo" type="file" accept=".jpg,.jpeg,.png,.webp" class="rounded-md border border-[#dce7f8] px-3 py-2 text-sm outline-none">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942] lg:col-span-2">Skills
                            <textarea name="skills" class="min-h-24 rounded-md border border-[#dce7f8] p-3 text-sm outline-none" placeholder="React, Laravel, MySQL"></textarea>
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942] lg:col-span-2">Resume
                            <input name="resume" type="file" accept=".pdf,.doc,.docx" class="rounded-md border border-[#dce7f8] px-3 py-2 text-sm outline-none">
                        </label>
                        <div class="flex justify-end gap-3 lg:col-span-2">
                            <button id="cancelEdit" class="h-10 rounded-md border border-[#dce7f8] px-5 text-sm font-bold text-[#24344f]" type="button">Cancel</button>
                            <button id="saveProfile" class="h-10 rounded-md bg-[#075fe4] px-5 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-60" type="submit">Save Profile</button>
                        </div>
                    </form>
                </article>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const profileSidebar = document.getElementById('profileSidebar');
    const profileView = document.getElementById('profileView');
    const profileEditCard = document.getElementById('profileEditCard');
    const toggleEdit = document.getElementById('toggleEdit');
    const cancelEdit = document.getElementById('cancelEdit');
    const profileForm = document.getElementById('profileForm');
    const saveProfile = document.getElementById('saveProfile');
    const profileMessage = document.getElementById('profileMessage');
    let currentUser = {};
    let currentProfile = {};
    let dashboardStats = {};

    function showMessage(message, type = 'success') {
        profileMessage.textContent = message;
        profileMessage.className = 'rounded-lg border px-4 py-3 text-sm font-bold ' + (type === 'error'
            ? 'border-[#ffd7d7] bg-[#fff4f4] text-[#b42318]'
            : 'border-[#d4f8df] bg-[#f0fff5] text-[#05843e]');
    }
    function asset(path) { return path ? '/storage/' + String(path).replace(/^\/?storage\//, '') : ''; }
    function splitSkills(value) { return String(value || '').split(/,|\n/).map((item) => item.trim()).filter(Boolean); }
    function infoRow(label, value) {
        return `<div class="grid gap-1 border-b border-[#e5edf8] pb-3 last:border-b-0 sm:grid-cols-[110px_minmax(0,1fr)]"><span class="text-xs font-bold uppercase tracking-wide text-[#536484]">${FastTrack.esc(label)}</span><b class="min-w-0 break-words text-sm font-bold text-[#061942]">${FastTrack.esc(value || '-')}</b></div>`;
    }
    function summaryItem(icon, label, value) {
        return `<div class="grid grid-cols-[34px_minmax(0,1fr)_auto] items-center gap-3 text-sm"><span class="grid h-[34px] w-[34px] place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">${icon}</span><span class="font-semibold text-[#24344f]">${FastTrack.esc(label)}</span><strong class="font-bold text-[#061942]">${FastTrack.esc(value)}</strong></div>`;
    }
    function fillForm() {
        profileForm.elements.phone.value = currentProfile.phone || currentUser.mobile || '';
        profileForm.elements.city.value = currentProfile.city || '';
        profileForm.elements.qualification.value = currentProfile.qualification || '';
        profileForm.elements.college_name.value = currentProfile.college_name || '';
        profileForm.elements.passing_year.value = currentProfile.passing_year || '';
        profileForm.elements.skills.value = currentProfile.skills || '';
        profileForm.elements.profile_photo.value = '';
        profileForm.elements.resume.value = '';
    }
    function renderProfile() {
        const completion = Number(currentProfile.profile_completion || 0);
        const photo = asset(currentProfile.profile_photo);
        const resume = asset(currentProfile.resume);
        const skills = splitSkills(currentProfile.skills);
        const initials = FastTrack.initials(currentUser.name || currentUser.email);

        profileSidebar.innerHTML = `
            <div class="relative mx-auto mb-5 h-[118px] w-[118px]">
                ${photo ? `<img class="h-[118px] w-[118px] rounded-full border-[10px] border-[#eaf2ff] object-cover" src="${FastTrack.esc(photo)}" alt="Profile photo">` : `<div class="grid h-[118px] w-[118px] place-items-center rounded-full border-[10px] border-[#eaf2ff] bg-[#eff5ff] text-3xl font-black text-[#075fe4]">${FastTrack.esc(initials)}</div>`}
                <span class="absolute bottom-1 right-1 grid h-9 w-9 place-items-center rounded-full border-4 border-white bg-[#075fe4] text-xs font-black text-white">${completion}</span>
            </div>
            <h2 class="mb-3 text-xl font-bold text-[#061942]">${FastTrack.esc(currentUser.name || 'Fresher')}</h2>
            <span class="mb-5 inline-flex rounded-lg bg-[#eaf2ff] px-3 py-1.5 text-xs font-bold text-[#075fe4]">Fresher</span>
            <div class="mt-2 grid gap-4 text-left">
                ${infoRow('Email', currentUser.email)}
                ${infoRow('Phone', currentProfile.phone || currentUser.mobile)}
                ${infoRow('City', currentProfile.city)}
                ${infoRow('Qualification', currentProfile.qualification)}
                ${infoRow('College', currentProfile.college_name)}
                ${infoRow('Passing Year', currentProfile.passing_year)}
            </div>`;

        profileView.innerHTML = `
            <div class="grid gap-6 lg:grid-cols-2">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:col-span-2">
                    <div class="mb-4 flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">ED</span><h3 class="text-lg font-bold text-[#061942]">Education</h3></div>
                    <p class="text-sm leading-7 text-[#24344f]">${FastTrack.esc([currentProfile.qualification, currentProfile.college_name, currentProfile.passing_year].filter(Boolean).join(' - ') || 'Education details not added yet.')}</p>
                </article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-4 flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">SK</span><h3 class="text-lg font-bold text-[#061942]">Skills</h3></div>
                    <div class="flex flex-wrap gap-3">${skills.length ? skills.map((skill) => `<span class="rounded-lg bg-[#f0f4ff] px-4 py-2.5 text-sm font-semibold text-[#075fe4]">${FastTrack.esc(skill)}</span>`).join('') : '<p class="text-sm text-[#455a82]">No skills added yet.</p>'}</div>
                </article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-4 flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">RS</span><h3 class="text-lg font-bold text-[#061942]">Resume</h3></div>
                    ${resume ? `<a class="inline-flex h-[42px] w-full items-center justify-center rounded-lg border border-[#075fe4] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" href="${FastTrack.esc(resume)}" target="_blank" rel="noopener">View / Download Resume</a>` : '<p class="text-sm text-[#455a82]">Resume not uploaded yet.</p>'}
                </article>
            </div>
            <div class="mt-6 grid gap-6 lg:grid-cols-[1.25fr_1fr]">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-5 flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">${completion}</span><h3 class="text-lg font-bold text-[#061942]">Profile Completion</h3></div>
                    <div class="mb-3 text-[34px] font-bold leading-none text-[#061942]">${completion}%</div>
                    <div class="mb-4 h-3 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#19a85b]" style="width:${completion}%;"></span></div>
                    <p class="text-sm leading-6 text-[#455a82]">Complete your profile to increase your chances of getting hired.</p>
                </article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-5 flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">SM</span><h3 class="text-lg font-bold text-[#061942]">Profile Summary</h3></div>
                    <div class="grid gap-4">
                        ${summaryItem('AP', 'Applications', dashboardStats.total_applications || 0)}
                        ${summaryItem('SH', 'Shortlisted', dashboardStats.shortlisted_applications || 0)}
                        ${summaryItem('TE', 'Training Enrolled', dashboardStats.total_course_enrollments || 0)}
                        ${summaryItem('CE', 'Certificates', dashboardStats.total_certificates || 0)}
                    </div>
                </article>
            </div>`;
        fillForm();
    }
    async function loadProfile() {
        try {
            const [profileResult, dashboardResult] = await Promise.all([
                FastTrack.getJson('/api/fresher/profile'),
                FastTrack.getJson('/api/fresher/dashboard').catch(() => ({ data: { statistics: {} } })),
            ]);
            currentUser = FastTrack.apiData(profileResult, 'user') || {};
            currentProfile = FastTrack.apiData(profileResult, 'profile') || {};
            dashboardStats = FastTrack.apiData(dashboardResult, 'statistics') || {};
            localStorage.setItem('ofc_auth_user', JSON.stringify(currentUser));
            renderProfile();
        } catch (error) {
            profileSidebar.innerHTML = '<p class="text-sm font-bold text-[#b42318]">Profile load nahi ho paayi.</p>';
            profileView.innerHTML = '<article class="rounded-lg border border-[#ffd7d7] bg-[#fff4f4] p-6 text-sm font-bold text-[#b42318]">' + FastTrack.esc(error.message || 'Profile load nahi ho paayi.') + '</article>';
        }
    }
    toggleEdit.addEventListener('click', function () {
        profileEditCard.classList.toggle('hidden');
        toggleEdit.textContent = profileEditCard.classList.contains('hidden') ? 'Edit Profile' : 'Close Edit';
    });
    cancelEdit.addEventListener('click', function () {
        profileEditCard.classList.add('hidden');
        toggleEdit.textContent = 'Edit Profile';
        fillForm();
    });
    profileForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        saveProfile.disabled = true;
        saveProfile.textContent = 'Saving...';
        try {
            const response = await fetch('/api/fresher/profile', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    Authorization: 'Bearer ' + FastTrack.token(),
                },
                body: new FormData(profileForm),
            });
            const payload = await response.json();
            if (!response.ok || !payload.success) {
                const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
                throw new Error(validationMessage || payload.message || 'Profile save nahi ho paayi.');
            }
            showMessage(payload.message || 'Profile saved successfully.');
            profileEditCard.classList.add('hidden');
            toggleEdit.textContent = 'Edit Profile';
            await loadProfile();
        } catch (error) {
            showMessage(error.message || 'Profile save nahi ho paayi.', 'error');
        } finally {
            saveProfile.disabled = false;
            saveProfile.textContent = 'Save Profile';
        }
    });
    loadProfile();
</script>
@endpush
