@extends('layouts.fast-track')

@section('title', 'My Profile - Fast Track')

@php
    $activePage = 'profile';
    $student = [
        'name' => 'Ananya Gupta',
        'notifications' => 3,
        'role' => 'Fresher',
        'email' => 'ananya@example.com',
        'phone' => '9876543210',
        'location' => 'Bangalore, Karnataka',
        'qualification' => 'B.Tech (Computer Science)',
        'college' => 'RV College of Engineering',
        'passing_year' => '2024',
        'completion' => 75,
        'resume' => 'Ananya_Gupta_Resume.pdf',
        'resume_size' => '512 KB',
        'about' => 'I am a proactive and motivated Computer Science graduate with a strong foundation in web development and problem solving. I am passionate about learning new technologies and building real world applications.',
    ];

    $skills = ['React.js', 'JavaScript', 'Node.js', 'HTML', 'CSS', 'MongoDB', 'Git & GitHub', 'Problem Solving'];

    $summary = [
        ['label' => 'Profile Views', 'value' => '128', 'icon' => 'PV'],
        ['label' => 'Applications', 'value' => '5', 'icon' => 'AP'],
        ['label' => 'Shortlisted', 'value' => '2', 'icon' => 'SH'],
        ['label' => 'Training Enrolled', 'value' => '1', 'icon' => 'TE'],
    ];

    $details = [
        ['label' => 'Email', 'value' => $student['email']],
        ['label' => 'Phone', 'value' => $student['phone']],
        ['label' => 'Location', 'value' => $student['location']],
        ['label' => 'Qualification', 'value' => $student['qualification']],
        ['label' => 'College', 'value' => $student['college']],
        ['label' => 'Passing Year', 'value' => $student['passing_year']],
    ];
@endphp

@section('content')
    <section class="space-y-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-[27px] font-bold leading-tight text-[#061942]">My Profile</h1>
                <p class="mt-2 text-sm font-medium text-[#455a82]">View and manage your personal information</p>
            </div>
            <button class="edit-btn inline-flex h-11 items-center justify-center rounded-lg bg-[#075fe4] px-5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(7,95,228,.18)] transition hover:bg-[#064fc0]" type="button">Edit Profile</button>
        </div>

        <div class="grid items-start gap-6 xl:grid-cols-[340px_minmax(0,1fr)]">
            <article class="rounded-lg border border-[#dce7f8] bg-white px-6 py-7 text-center shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <div class="relative mx-auto mb-5 h-[118px] w-[118px]">
                    @if (file_exists(public_path('student.svg')))
                        <div class="h-[118px] w-[118px] rounded-full border-[10px] border-[#eaf2ff] bg-cover bg-[position:16%_20%]" style="background-image: url('{{ asset('student.svg') }}'); background-size: 470px auto;"></div>
                    @else
                        <div class="grid h-[118px] w-[118px] place-items-center rounded-full border-[10px] border-[#eaf2ff] bg-[#eff5ff] text-3xl font-black text-[#075fe4]">AG</div>
                    @endif
                    <span class="absolute bottom-1 right-1 grid h-9 w-9 place-items-center rounded-full border-4 border-white bg-[#075fe4] text-xs font-black text-white">C</span>
                </div>

                <h2 class="mb-3 text-xl font-bold text-[#061942]">{{ $student['name'] }}</h2>
                <span class="mb-5 inline-flex rounded-lg bg-[#eaf2ff] px-3 py-1.5 text-xs font-bold text-[#075fe4]">{{ $student['role'] }}</span>

                <div class="mt-2 grid gap-4 text-left">
                    @foreach ($details as $detail)
                        <div class="grid gap-1 border-b border-[#e5edf8] pb-3 last:border-b-0 sm:grid-cols-[110px_minmax(0,1fr)]">
                            <span class="text-xs font-bold uppercase tracking-wide text-[#536484]">{{ $detail['label'] }}</span>
                            <b class="min-w-0 break-words text-sm font-bold text-[#061942]">{{ $detail['value'] }}</b>
                        </div>
                    @endforeach
                </div>
            </article>

            <div class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-2">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)] lg:col-span-2">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">AB</span>
                            <h3 class="text-lg font-bold text-[#061942]">About Me</h3>
                        </div>
                        <p class="text-sm leading-7 text-[#24344f]">{{ $student['about'] }}</p>
                    </article>

                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">SK</span>
                            <h3 class="text-lg font-bold text-[#061942]">Skills</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($skills as $skill)
                                <span class="rounded-lg bg-[#f0f4ff] px-4 py-2.5 text-sm font-semibold text-[#075fe4]">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </article>

                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">RS</span>
                            <h3 class="text-lg font-bold text-[#061942]">Resume</h3>
                        </div>
                        <div class="mb-5 flex items-center gap-4 rounded-lg border border-[#dce7f8] p-4">
                            <span class="grid h-[42px] w-[42px] shrink-0 place-items-center rounded-lg bg-[#fff0f0] text-xs font-black text-[#ff2b2b]">PDF</span>
                            <div class="min-w-0">
                                <h4 class="truncate text-sm font-bold text-[#061942]">{{ $student['resume'] }}</h4>
                                <p class="mt-1 text-xs font-medium text-[#536484]">{{ $student['resume_size'] }}</p>
                            </div>
                        </div>
                        <button class="download inline-flex h-[42px] w-full items-center justify-center rounded-lg border border-[#075fe4] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" type="button">Download Resume</button>
                    </article>
                </div>

                <div class="grid gap-6 lg:grid-cols-[1.25fr_1fr]">
                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                        <div class="mb-5 flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">75</span>
                            <h3 class="text-lg font-bold text-[#061942]">Profile Completion</h3>
                        </div>
                        <div class="mb-3 text-[34px] font-bold leading-none text-[#061942]">{{ $student['completion'] }}%</div>
                        <div class="mb-4 h-3 overflow-hidden rounded-full bg-[#e9edf5]">
                            <span class="block h-full rounded-full bg-[#19a85b]" style="width: {{ $student['completion'] }}%;"></span>
                        </div>
                        <p class="text-sm leading-6 text-[#455a82]">Complete your profile to increase your chances of getting hired.</p>
                    </article>

                    <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                        <div class="mb-5 flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">SM</span>
                            <h3 class="text-lg font-bold text-[#061942]">Profile Summary</h3>
                        </div>
                        <div class="grid gap-4">
                            @foreach ($summary as $item)
                                <div class="grid grid-cols-[34px_minmax(0,1fr)_auto] items-center gap-3 text-sm">
                                    <span class="grid h-[34px] w-[34px] place-items-center rounded-lg bg-[#f0f5ff] text-[9px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                                    <span class="font-semibold text-[#24344f]">{{ $item['label'] }}</span>
                                    <strong class="font-bold text-[#061942]">{{ $item['value'] }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const editButton = document.querySelector('.edit-btn');
    const downloadButton = document.querySelector('.download');

    if (editButton) {
        editButton.addEventListener('click', function () {
            alert('Edit profile form will open here.');
        });
    }

    if (downloadButton) {
        downloadButton.addEventListener('click', function () {
            alert('Resume download started.');
        });
    }
</script>
@endpush
