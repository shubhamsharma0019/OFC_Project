@extends('layouts.fast-track')

@section('title', 'My Profile - Fast Track')

@php
    $activePage = 'profile';
    $editMode = $editMode ?? request()->is('fast-track/profile/edit');
@endphp

@section('content')
    <section class="space-y-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">{{ $editMode ? 'Edit Profile' : 'My Profile' }}</h1>
                <p class="mt-2 text-sm font-medium text-[#455a82]">{{ $editMode ? 'Update your personal, education, skills, and resume details.' : 'View and manage your personal, education, skills, and resume details.' }}</p>
            </div>
            @if (! $editMode)
                <a id="toggleEdit" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]" href="/fast-track/profile/edit">Edit Profile</a>
            @endif
        </div>

        <div id="profileMessage" class="hidden rounded-lg border px-4 py-3 text-sm font-bold"></div>

        <div class="grid items-start gap-6 xl:grid-cols-[340px_minmax(0,1fr)]">
            <article id="profileSidebar" class="rounded-lg border border-[#dce7f8] bg-white px-6 py-7 text-center shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <p class="text-sm text-[#455a82]">Loading profile...</p>
            </article>

            <div class="space-y-6">
                <div id="profileView" class="{{ $editMode ? 'hidden' : 'space-y-6' }}">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                        <p class="text-sm text-[#455a82]">Loading profile details...</p>
                    </article>
                </div>

                <article id="profileEditCard" class="{{ $editMode ? '' : 'hidden' }} rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
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
                            <span class="flex min-h-10 items-center gap-3 rounded-md border border-[#dce7f8] bg-white px-3 py-1.5 focus-within:border-[#075fe4] focus-within:ring-2 focus-within:ring-[#075fe433]">
                                <input name="profile_photo" type="file" accept=".jpg,.jpeg,.png,.webp" class="min-w-0 flex-1 border-0 p-0 text-sm outline-none">
                                <button id="removeProfilePhoto" type="button" class="h-8 shrink-0 rounded-md border border-[#ffb8bf] bg-[#fff5f6] px-3 text-xs font-bold text-[#c5162d]" style="display:none">Remove Photo</button>
                            </span>
                            <input name="remove_profile_photo" type="hidden" value="0">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942] lg:col-span-2">Skills
                            <textarea name="skills" class="min-h-24 rounded-md border border-[#dce7f8] p-3 text-sm outline-none" placeholder="React, Laravel, MySQL"></textarea>
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Career Interest
                            <select name="preferred_job_category" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none">
                                <option value="">Select job category</option>
                                <option value="Software Developer">Software Developer</option>
                                <option value="Data Analyst">Data Analyst</option>
                                <option value="UI/UX Designer">UI/UX Designer</option>
                                <option value="Digital Marketing">Digital Marketing</option>
                            </select>
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Preferred Min Package (LPA)
                            <input name="preferred_min_package_lpa" type="number" min="0" step="0.1" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none" placeholder="3">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942]">Preferred Max Package (LPA)
                            <input name="preferred_max_package_lpa" type="number" min="0" step="0.1" class="h-10 rounded-md border border-[#dce7f8] px-3 text-sm outline-none" placeholder="5">
                        </label>
                        <label class="grid gap-2 text-xs font-bold text-[#061942] lg:col-span-2">Resume
                            <input name="resume" type="file" accept=".pdf,.doc,.docx" class="rounded-md border-2 border-[#075fe4] bg-[#f3f8ff] px-3 py-2 text-sm font-bold text-[#061942] shadow-[0_8px_18px_rgba(7,95,228,0.10)] outline-none file:mr-4 file:rounded-md file:border-0 file:bg-[#075fe4] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:bg-[#eaf2ff] focus:ring-2 focus:ring-[#075fe433]">
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
    const removeProfilePhoto = document.getElementById('removeProfilePhoto');
    const isEditMode = @json($editMode);
    async function parseApiResponse(response) {
        const text = await response.text();
        try {
            return text ? JSON.parse(text) : {};
        } catch (error) {
            return {
                success: false,
                message: response.ok
                    ? 'The server returned an invalid response.'
                    : 'Unable to save profile. Please check the uploaded file and try again.',
            };
        }
    }
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
    const profileIcons = {
        education: '<svg viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5 10-5Z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path></svg>',
        skills: '<svg viewBox="0 0 24 24"><path d="M12 3 4 7v6c0 5 3.5 7.5 8 8 4.5-.5 8-3 8-8V7l-8-4Z"></path><path d="m9 12 2 2 4-5"></path></svg>',
        resume: '<svg viewBox="0 0 24 24"><path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9Z"></path><path d="M14 3v6h6"></path><path d="M8 13h8M8 17h5"></path></svg>',
        completion: '<svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>',
        summary: '<svg viewBox="0 0 24 24"><path d="M4 19V5"></path><path d="M4 19h16"></path><path d="M8 15l3-3 3 2 5-7"></path></svg>',
        applications: '<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2"></rect><path d="M8 5V3h8v2"></path><path d="M8 11h8M8 15h5"></path></svg>',
        shortlisted: '<svg viewBox="0 0 24 24"><path d="m9 11 2 2 4-5"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect></svg>',
        training: '<svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m10 9 5 3-5 3Z"></path></svg>',
        certificate: '<svg viewBox="0 0 24 24"><path d="M6 3h12v18l-6-3-6 3Z"></path><path d="M9 8h6M9 12h6"></path></svg>',
    };
    function profileIcon(name, size = 'h-9 w-9') {
        return `<span class="grid ${size} shrink-0 place-items-center rounded-lg bg-[#f0f5ff] text-[#075fe4] [&>svg]:h-5 [&>svg]:w-5 [&>svg]:fill-none [&>svg]:stroke-current [&>svg]:stroke-2 [&>svg]:[stroke-linecap:round] [&>svg]:[stroke-linejoin:round]">${profileIcons[name] || profileIcons.summary}</span>`;
    }
    function infoRow(label, value) {
        return `<div class="grid gap-1 border-b border-[#e5edf8] pb-3 last:border-b-0 sm:grid-cols-[110px_minmax(0,1fr)]"><span class="text-xs font-bold uppercase tracking-wide text-[#536484]">${FastTrack.esc(label)}</span><b class="min-w-0 break-words text-sm font-bold text-[#061942]">${FastTrack.esc(value || '-')}</b></div>`;
    }
    function summaryItem(icon, label, value) {
        return `<div class="grid grid-cols-[34px_minmax(0,1fr)_auto] items-center gap-3 text-sm">${profileIcon(icon, 'h-[34px] w-[34px]')}<span class="font-semibold text-[#24344f]">${FastTrack.esc(label)}</span><strong class="font-bold text-[#061942]">${FastTrack.esc(value)}</strong></div>`;
    }
    function packagePreferenceText() {
        const min = currentProfile.preferred_min_package_lpa;
        const max = currentProfile.preferred_max_package_lpa;
        if (min && max) return `${min} - ${max} LPA`;
        if (min) return `${min}+ LPA`;
        if (max) return `Up to ${max} LPA`;
        return 'Any package';
    }
    function fillForm() {
        profileForm.elements.phone.value = currentProfile.phone || currentUser.mobile || '';
        profileForm.elements.city.value = currentProfile.city || '';
        profileForm.elements.qualification.value = currentProfile.qualification || '';
        profileForm.elements.college_name.value = currentProfile.college_name || '';
        profileForm.elements.passing_year.value = currentProfile.passing_year || '';
        profileForm.elements.skills.value = currentProfile.skills || '';
        profileForm.elements.preferred_job_category.value = currentProfile.preferred_job_category || '';
        profileForm.elements.preferred_min_package_lpa.value = currentProfile.preferred_min_package_lpa || '';
        profileForm.elements.preferred_max_package_lpa.value = currentProfile.preferred_max_package_lpa || '';
        profileForm.elements.profile_photo.value = '';
        profileForm.elements.remove_profile_photo.value = '0';
        profileForm.elements.resume.value = '';
        if (removeProfilePhoto) {
            const hasUploadedPhoto = Boolean(String(currentProfile.profile_photo || '').trim());
            removeProfilePhoto.style.display = hasUploadedPhoto ? 'inline-flex' : 'none';
            removeProfilePhoto.textContent = 'Remove Photo';
        }
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
                ${infoRow('Career Interest', currentProfile.preferred_job_category)}
                ${infoRow('Package', packagePreferenceText())}
            </div>`;

        profileView.innerHTML = `
            <div class="grid gap-6 lg:grid-cols-2">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:col-span-2">
                    <div class="mb-4 flex items-center gap-3">${profileIcon('education')}<h3 class="text-lg font-bold text-[#061942]">Education</h3></div>
                    <p class="text-sm leading-7 text-[#24344f]">${FastTrack.esc([currentProfile.qualification, currentProfile.college_name, currentProfile.passing_year].filter(Boolean).join(' - ') || 'Education details not added yet.')}</p>
                </article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-4 flex items-center gap-3">${profileIcon('skills')}<h3 class="text-lg font-bold text-[#061942]">Skills</h3></div>
                    <div class="flex flex-wrap gap-3">${skills.length ? skills.map((skill) => `<span class="rounded-lg bg-[#f0f4ff] px-4 py-2.5 text-sm font-semibold text-[#075fe4]">${FastTrack.esc(skill)}</span>`).join('') : '<p class="text-sm text-[#455a82]">No skills added yet.</p>'}</div>
                    <p class="mt-5 text-sm font-bold text-[#061942]">Preferred Package: ${FastTrack.esc(packagePreferenceText())}</p>
                </article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-4 flex items-center gap-3">${profileIcon('resume')}<h3 class="text-lg font-bold text-[#061942]">Resume</h3></div>
                    ${resume ? `<a class="inline-flex h-[42px] w-full items-center justify-center rounded-lg border border-[#075fe4] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" href="${FastTrack.esc(resume)}" target="_blank" rel="noopener">View / Download Resume</a>` : '<p class="text-sm text-[#455a82]">Resume not uploaded yet.</p>'}
                </article>
            </div>
            <div class="mt-6 grid gap-6 lg:grid-cols-[1.25fr_1fr]">
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-5 flex items-center gap-3">${profileIcon('completion')}<h3 class="text-lg font-bold text-[#061942]">Profile Completion</h3></div>
                    <div class="mb-3 text-[34px] font-bold leading-none text-[#061942]">${completion}%</div>
                    <div class="mb-4 h-3 overflow-hidden rounded-full bg-[#e9edf5]"><span class="block h-full rounded-full bg-[#19a85b]" style="width:${completion}%;"></span></div>
                    <p class="text-sm leading-6 text-[#455a82]">Complete your profile to increase your chances of getting hired.</p>
                </article>
                <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                    <div class="mb-5 flex items-center gap-3">${profileIcon('summary')}<h3 class="text-lg font-bold text-[#061942]">Profile Summary</h3></div>
                    <div class="grid gap-4">
                        ${summaryItem('applications', 'Applications', dashboardStats.total_applications || 0)}
                        ${summaryItem('shortlisted', 'Shortlisted', dashboardStats.shortlisted_applications || 0)}
                        ${summaryItem('training', 'Training Enrolled', dashboardStats.total_course_enrollments || 0)}
                        ${summaryItem('certificate', 'Certificates', dashboardStats.total_certificates || 0)}
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
    toggleEdit?.addEventListener('click', function () {
        profileEditCard.classList.toggle('hidden');
        toggleEdit.textContent = profileEditCard.classList.contains('hidden') ? 'Edit Profile' : 'Close Edit';
    });
    cancelEdit.addEventListener('click', function () {
        if (isEditMode) {
            window.location.href = '/fast-track/profile';
            return;
        }
        profileEditCard.classList.add('hidden');
        if (toggleEdit) toggleEdit.textContent = 'Edit Profile';
        fillForm();
    });
    removeProfilePhoto?.addEventListener('click', function () {
        profileForm.elements.profile_photo.value = '';
        profileForm.elements.remove_profile_photo.value = '1';
        removeProfilePhoto.style.display = 'none';
        showMessage('Profile photo remove ho jayegi jab aap Save Profile karoge.');
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
            const payload = await parseApiResponse(response);
            if (!response.ok || !payload.success) {
                const validationMessage = payload.errors ? Object.values(payload.errors).flat()[0] : null;
                throw new Error(validationMessage || payload.message || 'Unable to save profile.');
            }
            showMessage(payload.message || 'Profile saved successfully.');
            if (isEditMode) {
                window.location.href = '/fast-track/profile';
                return;
            }
            profileEditCard.classList.add('hidden');
            if (toggleEdit) toggleEdit.textContent = 'Edit Profile';
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
