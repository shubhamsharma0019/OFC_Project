@extends('layouts.fast-track')

@section('title', 'Course Details')

@php
    $activePage = 'details';
    $student = ['name' => 'Ananya Gupta', 'notifications' => 3];

    $course = [
        'title' => 'Full Stack Development',
        'tag' => 'Most Popular',
        'description' => 'Build modern web applications from scratch and become a full stack developer.',
        'duration' => '12 Months',
        'fees' => 'Rs.14,999',
        'mode' => 'Online Live',
        'level' => 'Beginner to Advanced',
        'certificate' => 'Yes',
        'rating' => '4.8',
        'reviews' => '2,540 reviews',
    ];

    $learn = ['HTML, CSS, JavaScript', 'React.js', 'Node.js & Express.js', 'MongoDB', 'REST APIs', 'Git & GitHub', 'Authentication & Authorization', 'Deployment', 'Project Building', 'And much more...'];

    $highlights = [
        ['title' => 'Industry Expert Mentors', 'text' => 'Learn from 10+ years of experienced professionals', 'icon' => 'IM'],
        ['title' => 'Live Interactive Sessions', 'text' => 'Live classes with doubt clearing sessions', 'icon' => 'LS'],
        ['title' => 'Real-world Projects', 'text' => 'Build projects for your portfolio', 'icon' => 'RP'],
        ['title' => 'Industry Recognized Certificate', 'text' => 'Boost your resume and career opportunities', 'icon' => 'IC'],
        ['title' => 'Placement Assistance', 'text' => 'Get resume reviews, mock interviews and job support', 'icon' => 'PA'],
    ];

    $audience = ['Freshers', 'Engineering Students', 'Career Switchers', 'Working Professionals'];

    $meta = [
        ['label' => 'Duration', 'value' => $course['duration']],
        ['label' => 'Fees', 'value' => $course['fees']],
        ['label' => 'Mode', 'value' => $course['mode']],
        ['label' => 'Level', 'value' => $course['level']],
        ['label' => 'Certificate', 'value' => $course['certificate']],
    ];
@endphp

@section('content')
    <section class="space-y-5">
        <a class="inline-flex text-sm font-bold text-[#075fe4] hover:text-[#064fc0]" href="/fast-track/courses">&lt; Back to Courses</a>

        <div>
            <h1 class="text-[26px] font-bold leading-tight text-[#061942]">Course Details</h1>
            <p class="mt-2 text-sm font-medium text-[#334b83]">Explore course details, curriculum, and other important information.</p>
        </div>

        <article class="grid gap-7 rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] xl:grid-cols-[140px_minmax(0,1fr)_300px] xl:items-center">
            <div class="grid h-[126px] w-[126px] place-items-center rounded-lg bg-[#071743] text-3xl font-black text-white">FS</div>

            <div class="min-w-0">
                <h2 class="mb-3 flex flex-wrap items-center gap-2 text-xl font-bold text-[#061942]">
                    <span>{{ $course['title'] }}</span>
                    <span class="inline-flex rounded-md bg-[#eee7ff] px-2.5 py-1 text-[11px] font-bold text-[#7744eb]">{{ $course['tag'] }}</span>
                </h2>
                <p class="mb-6 text-sm leading-6 text-[#334b83]">{{ $course['description'] }}</p>

                <div class="grid gap-4 text-xs text-[#334b83] sm:grid-cols-2 lg:grid-cols-5">
                    @foreach ($meta as $item)
                        <span>
                            {{ $item['label'] }}
                            <b class="mt-2 block text-sm font-bold text-[#061942]">{{ $item['value'] }}</b>
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-[#dce7f8] pt-5 text-center xl:border-l xl:border-t-0 xl:pl-6 xl:pt-0">
                <div class="mb-5 text-sm font-medium text-[#334b83]">Star <strong class="mx-1 text-base font-bold text-[#061942]">{{ $course['rating'] }}</strong> ({{ $course['reviews'] }})</div>
                <button class="mb-3 inline-flex h-[42px] w-full items-center justify-center rounded-lg bg-[#075fe4] text-sm font-bold text-white transition hover:bg-[#064fc0]" type="button">Enroll Now</button>
                <button class="inline-flex h-[42px] w-full items-center justify-center rounded-lg border border-[#075fe4] bg-white text-sm font-bold text-[#075fe4] transition hover:bg-[#eff5ff]" type="button">Download Brochure</button>
            </div>
        </article>

        <div class="grid gap-5 xl:grid-cols-[1.25fr_1fr]">
            <article class="overflow-hidden rounded-lg border border-[#dce7f8] bg-white shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <div class="flex gap-7 overflow-x-auto border-b border-[#dce7f8] px-5">
                    @foreach (['about' => 'About Course', 'curriculum' => 'Curriculum', 'mentors' => 'Mentors', 'reviews' => 'Reviews', 'faqs' => 'FAQs'] as $key => $label)
                        <button class="course-tab shrink-0 border-b-[3px] px-0 py-4 text-sm font-bold {{ $loop->first ? 'border-[#075fe4] text-[#075fe4]' : 'border-transparent text-[#334b83]' }}" type="button" data-tab="{{ $key }}">{{ $label }}</button>
                    @endforeach
                </div>

                <div class="min-h-[270px] p-6">
                    <div class="course-panel" data-panel="about">
                        <h3 class="mb-3 text-base font-bold text-[#061942]">About this Course</h3>
                        <p class="mb-5 text-sm leading-7 text-[#061942]">This Full Stack Development course is designed to make you job-ready by teaching front-end, back-end, databases, version control, and deployment. You will build real-world projects and gain industry-level skills.</p>
                        <h3 class="mb-4 text-base font-bold text-[#061942]">What You Will Learn</h3>
                        <div class="grid gap-x-9 gap-y-3 sm:grid-cols-2">
                            @foreach ($learn as $item)
                                <div class="flex items-center gap-2 text-sm font-medium text-[#061942]"><span class="font-black text-[#0a8f3f]">✓</span><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="course-panel hidden" data-panel="curriculum"><h3 class="mb-3 text-base font-bold text-[#061942]">Curriculum</h3><p class="text-sm leading-7 text-[#061942]">HTML basics, CSS layouts, JavaScript, React.js, Node.js, Express.js, MongoDB, APIs, authentication, deployment, and final project.</p></div>
                    <div class="course-panel hidden" data-panel="mentors"><h3 class="mb-3 text-base font-bold text-[#061942]">Mentors</h3><p class="text-sm leading-7 text-[#061942]">Learn from experienced full stack developers, project mentors, and interview preparation experts.</p></div>
                    <div class="course-panel hidden" data-panel="reviews"><h3 class="mb-3 text-base font-bold text-[#061942]">Reviews</h3><p class="text-sm leading-7 text-[#061942]">Students rate this course 4.8 for practical projects, mentor support, and placement preparation.</p></div>
                    <div class="course-panel hidden" data-panel="faqs"><h3 class="mb-3 text-base font-bold text-[#061942]">FAQs</h3><p class="text-sm leading-7 text-[#061942]">This course is beginner friendly. Live classes, recordings, projects, certificate, and placement support are included.</p></div>
                </div>
            </article>

            <article class="rounded-lg border border-[#dce7f8] bg-white p-6 shadow-[0_10px_24px_rgba(6,25,66,.04)]">
                <h2 class="mb-4 text-base font-bold text-[#061942]">Course Highlights</h2>
                <div>
                    @foreach ($highlights as $item)
                        <div class="grid grid-cols-[40px_minmax(0,1fr)] gap-4 border-b border-[#e6eef8] py-4 last:border-b-0">
                            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#f0f5ff] text-[10px] font-black text-[#075fe4]">{{ $item['icon'] }}</span>
                            <div>
                                <h3 class="mb-1.5 text-sm font-bold text-[#061942]">{{ $item['title'] }}</h3>
                                <p class="text-xs leading-5 text-[#536484]">{{ $item['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>

        <article class="rounded-lg border border-[#dce7f8] bg-white p-5 shadow-[0_10px_24px_rgba(6,25,66,.04)] sm:p-6">
            <h2 class="mb-5 text-base font-bold text-[#061942]">Who Should Enroll?</h2>
            <div class="flex flex-wrap gap-4 sm:gap-5">
                @foreach ($audience as $item)
                    <span class="inline-flex min-h-[42px] min-w-[160px] items-center justify-center rounded-lg border border-[#dce7f8] px-4 text-sm font-bold text-[#075fe4]">{{ $item }}</span>
                @endforeach
            </div>
        </article>
    </section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.course-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.course-tab').forEach(function (item) {
                item.classList.remove('border-[#075fe4]', 'text-[#075fe4]');
                item.classList.add('border-transparent', 'text-[#334b83]');
            });

            document.querySelectorAll('.course-panel').forEach(function (panel) {
                panel.classList.add('hidden');
            });

            tab.classList.add('border-[#075fe4]', 'text-[#075fe4]');
            tab.classList.remove('border-transparent', 'text-[#334b83]');
            document.querySelector('[data-panel="' + tab.dataset.tab + '"]').classList.remove('hidden');
        });
    });
</script>
@endpush
