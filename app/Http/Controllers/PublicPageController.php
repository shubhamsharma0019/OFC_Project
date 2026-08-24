<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Course;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\TrainingPartnerProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PublicPageController extends Controller
{
    public function home(): View
    {
        $fallbackStats = [
            'jobs_listed' => 0,
            'freshers_hired' => 0,
            'partner_companies' => 0,
            'top_brands' => 'Trusted',
        ];

        try {
            $partnerCompanies = CompanyProfile::query()
                ->where('approval_status', 'approved')
                ->count();

            $trainingPartners = $this->approvedTrainingPartners()
                ->take(6)
                ->get();

            $homeStats = [
                'jobs_listed' => $this->activeJobs()->count(),
                'freshers_hired' => JobApplication::query()
                    ->where('application_status', 'hired')
                    ->count(),
                'partner_companies' => $partnerCompanies,
                'top_brands' => $partnerCompanies > 0 ? 'Trusted' : 'Verified',
            ];
        } catch (QueryException) {
            $trainingPartners = collect();
            $homeStats = $fallbackStats;
        }

        return view('public.home', [
            'hero' => [
                'title' => 'Bridging Fresh Talent With',
                'highlight' => 'Great Opportunities',
                'text' => 'OnlyFreshers connects companies with skilled, confident and job-ready freshers. Hire directly or through our Fast Track Program.',
                'primary' => ['label' => "I'm a Fresher", 'href' => '/direct-mode/login', 'icon' => 'users'],
                'secondary' => ['label' => "I'm a Company", 'href' => '/company/login', 'icon' => 'briefcase'],
                'image' => 'home-hero-students.png',
            ],
            'homeStats' => $homeStats,
            'directModePoints' => [
                'Browse & apply to jobs',
                'Companies receive your resume with Initial Track Analysis',
                'Companies shortlist & hire suitable candidates',
            ],
            'directAnalysis' => [
                ['label' => 'Technical Skills', 'value' => 75],
                ['label' => 'Aptitude', 'value' => 68],
                ['label' => 'Communication', 'value' => 72],
                ['label' => 'Learning Ability', 'value' => 80],
            ],
            'fastTrackPoints' => [
                'Initial Assessment & Profile Analysis',
                'Training by Verified Training Partners',
                'Final Assessment & Certification',
                'Companies get candidates with Initial & Final Assessment',
            ],
            'fastTrackOverview' => [
                ['label' => 'Technical Skills', 'initial' => '56%', 'final' => '82%'],
                ['label' => 'Aptitude', 'initial' => '50%', 'final' => '78%'],
                ['label' => 'Communication', 'initial' => '58%', 'final' => '80%'],
                ['label' => 'Overall Match', 'initial' => '***--', 'final' => '*****'],
            ],
            'candidateReport' => [
                'name' => 'Ananya Gupta',
                'course' => 'B.Tech - IT',
                'rows' => [
                    ['Technical Skills', '55%', '82%', 'label' => 'Technical Skills', 'initial' => '55%', 'final' => '82%'],
                    ['Aptitude', '52%', '78%', 'label' => 'Aptitude', 'initial' => '52%', 'final' => '78%'],
                    ['Communication', '60%', '83%', 'label' => 'Communication', 'initial' => '60%', 'final' => '83%'],
                    ['Attitude', '58%', '85%', 'label' => 'Attitude', 'initial' => '58%', 'final' => '85%'],
                ],
                'initial_fit' => 'Average Fit',
                'final_fit' => 'Strong Fit',
            ],
            'companyCta' => [
                'title' => 'Hire Freshers with Confidence',
                'text' => 'Post jobs or internships, review applications, shortlist candidates, and hire top talent.',
                'button' => 'Post Opportunity',
                'href' => '/company/post-job',
            ],
            'fastTrackSteps' => [
                ['icon' => 'document', 'title' => '1. Enroll', 'text' => 'Student enrolls for Fast Track Program'],
                ['icon' => 'check', 'title' => '2. Initial Assessment', 'text' => 'Students are assessed on skills, aptitude, attitude & communication'],
                ['icon' => 'training', 'title' => '3. Training by Partners', 'text' => 'Training by verified training entities listed on OnlyFreshers'],
                ['icon' => 'document', 'title' => '4. Final Assessment', 'text' => 'Students appear for final assessment & practical evaluations'],
                ['icon' => 'certificate', 'title' => '5. Get Certified', 'text' => 'Students get certified based on performance'],
                ['icon' => 'briefcase', 'title' => '6. Get Hired', 'text' => 'Companies get candidates with Initial & Final Assessment'],
            ],
            'companyBenefits' => [
                'Pre-assessment & profile insights',
                'Training by industry experts',
                'Final assessment & certification',
                'Job-ready candidates with improved skills & attitude',
            ],
            'trainingPartnerLogos' => $this->partnerNames($trainingPartners),
        ]);
    }

    public function about(): View
    {
        return view('public.about', [
            'aboutMeta' => [
                'page_title' => 'About Us - OnlyFreshers',
                'active_page' => 'about',
            ],
            'aboutDecor' => [
                'help_divider' => 'h-[3px] w-[70px]',
                'trust_divider' => 'h-[2px] w-[56px]',
                'divider_color' => 'bg-[#075fe4]',
            ],
            'aboutHero' => [
                'title' => 'About',
                'highlight' => 'OnlyFreshers',
                'text' => 'OnlyFreshers connects freshers, companies, and training partners in one place.',
                'image' => 'home-hero-students.png',
            ],
            'infoCards' => [
                ['icon' => 'target', 'title' => 'Our Mission', 'text' => 'To empower freshers by connecting them with the right opportunities, career-focused training, and industry partners.'],
                ['icon' => 'eye', 'title' => 'Our Vision', 'text' => 'To be the most trusted platform for freshers, enabling them to build successful and meaningful careers.'],
                ['icon' => 'briefcase', 'title' => 'What We Do', 'text' => 'We bridge the gap between talent and opportunity through jobs, training programs, and trusted partnerships.'],
            ],
            'helpTitle' => 'How OnlyFreshers Helps',
            'helpCards' => [
                [
                    'icon' => 'briefcase',
                    'title' => 'Direct Mode',
                    'classes' => 'border-[#dce7f8] bg-white',
                    'iconClasses' => 'bg-[#eff5ff] text-[#075fe4]',
                    'points' => [
                        'Browse and apply to verified job openings.',
                        'Create your profile and showcase your skills.',
                        'Connect directly with top companies hiring freshers.',
                    ],
                ],
                [
                    'icon' => 'rocket',
                    'title' => 'Fast Track Program',
                    'classes' => 'border-[#f5d4ba] bg-[#fffaf5]',
                    'iconClasses' => 'bg-[#fff0e2] text-[#f37a22]',
                    'points' => [
                        'Get industry-aligned training from trusted partners.',
                        'Improve your skills with practical learning.',
                        'Get recommended for jobs and career opportunities.',
                    ],
                ],
            ],
            'trustTitle' => 'Why Freshers Trust OnlyFreshers',
            'trustCards' => [
                ['icon' => 'shield', 'title' => 'Verified Opportunities', 'text' => 'All job listings are verified to ensure legitimacy and trust.'],
                ['icon' => 'training', 'title' => 'Industry-Aligned Training', 'text' => 'Learn the most in-demand skills from trusted training partners.'],
                ['icon' => 'growth', 'title' => 'Career Growth', 'text' => 'We help you build a strong foundation for a successful career.'],
            ],
        ]);
    }

    public function companies(): View
    {
        try {
            $recentJobs = $this->activeJobs()
                ->with('companyProfile:id,company_name,industry')
                ->withCount('applications')
                ->latest()
                ->take(4)
                ->get()
                ->map(fn (Job $job) => [
                    'icon' => $this->jobIcon($job),
                    'title' => $job->title,
                    'meta' => collect([
                        $job->companyProfile?->industry,
                        $this->titleCase($job->job_type),
                        $job->location,
                    ])->filter()->join(' · '),
                    'date' => 'Posted ' . optional($job->created_at)->diffForHumans(),
                    'applications' => (string) $job->applications_count,
                    'shortlisted' => (string) $job->applications()
                        ->where('application_status', 'shortlisted')
                        ->count(),
                    'direct' => '5 Free',
                    'fast' => '2 Free',
                ]);
        } catch (QueryException) {
            $recentJobs = collect();
        }

        return view('public.jobs.index', [
            'hiringModes' => [
                [
                    'icon' => 'briefcase',
                    'title' => 'Direct Mode',
                    'color' => '#075fe4',
                    'iconClasses' => 'border-2 border-[#075fe4] bg-[#edf5ff] text-[#075fe4]',
                    'points' => [
                        'Post a job and get resumes of suitable freshers.',
                        'Get Initial Track Analysis with each resume.',
                        'Shortlist and connect with the best candidates.',
                    ],
                    'note' => '5 Free Resumes per Job Posting',
                ],
                [
                    'icon' => 'users',
                    'title' => 'Fast Track Mode',
                    'color' => '#0b9b6b',
                    'iconClasses' => 'bg-[#dff6ef] text-[#0b9b6b]',
                    'points' => [
                        'Get candidates trained by verified training partners.',
                        'Receive Initial & Final Assessment of each candidate.',
                        'Hire job-ready freshers with enhanced skills.',
                    ],
                    'note' => '2 Free Resumes per Job Posting',
                ],
            ],
            'recentJobs' => $recentJobs->isNotEmpty()
                ? $recentJobs->all()
                : $this->fallbackCompanyJobs(),
            'hiringPackages' => $this->hiringPackages(),
            'resumePacks' => [
                ['icon' => 'document', 'title' => 'Direct Mode Resumes', 'price' => '₹300', 'unit' => '/ 5 Resumes', 'classes' => 'bg-[#edf5ff] text-[#075fe4]'],
                ['icon' => 'users', 'title' => 'Fast Track Mode Resumes', 'price' => '₹400', 'unit' => '/ 5 Resumes', 'classes' => 'bg-[#e4f8ef] text-[#0b9b6b]'],
            ],
            'companyTrustItems' => [
                ['icon' => 'shield', 'title' => '100% Verified Freshers', 'text' => 'All candidates are verified'],
                ['icon' => 'document', 'title' => 'Initial & Final Assessment', 'text' => 'Make data-driven hiring decisions'],
                ['icon' => 'users', 'title' => 'Trained & Job-Ready Talent', 'text' => 'Hire with confidence'],
                ['icon' => 'target', 'title' => 'Save Time & Cost', 'text' => 'Streamlined hiring process'],
            ],
        ]);
    }

    public function directMode(): View
    {
        try {
            $jobs = $this->activeJobs()
                ->with('companyProfile:id,company_name,company_logo,industry')
                ->latest()
                ->take(8)
                ->get();

            $locations = $jobs->pluck('location')->filter()->unique()->values();
        } catch (QueryException) {
            $jobs = collect();
            $locations = collect();
        }

        return view('public.direct-mode.index', [
            'hero' => [
                'eyebrow' => 'Direct Mode',
                'title' => 'Apply to Jobs Directly',
                'text' => 'Get 250 free application credits and apply to fresher jobs with your profile and initial assessment.',
                'button' => 'Apply Now',
                'href' => '/direct-mode/register',
                'image' => 'direct-mode-hero.png',
            ],
            'jobsHeader' => [
                'title' => 'Apply Jobs (Direct Mode)',
                'text' => 'Companies receive your resume along with Initial Track Analysis to find the right match.',
                'button' => 'How Direct Mode Works',
                'href' => '/direct-mode',
            ],
            'directStats' => [
                ['icon' => 'users', 'value' => '250', 'label' => 'Free Credits Available'],
                ['icon' => 'chart', 'value' => '0', 'label' => 'Applications Used'],
                ['icon' => 'chart', 'value' => '250', 'label' => 'Credits Remaining'],
                ['icon' => 'plus', 'value' => '', 'label' => 'Purchase Credits To Apply More'],
            ],
            'directJobs' => $jobs->isNotEmpty()
                ? $jobs->map(fn (Job $job) => [
                    'logo' => $this->initials($job->companyProfile?->company_name ?? 'OF'),
                    'company' => $job->companyProfile?->company_name ?? 'Company',
                    'title' => $job->title,
                    'location' => $job->location ?? 'India',
                    'type' => $this->titleCase($job->job_type) ?: 'Full-time',
                    'exp' => $job->qualification ?: 'Fresher',
                    'posted' => 'Posted ' . optional($job->created_at)->diffForHumans(),
                    'fit' => 'Good Fit',
                    'fitClass' => 'bg-[#dff6ef] text-[#0b8b67]',
                ])->all()
                : $this->fallbackDirectJobs(),
            'directLocations' => $locations->isNotEmpty() ? $locations->all() : ['Delhi, India', 'Bangalore, India', 'Mumbai, India'],
            'filterLabels' => [
                'search' => 'Search job title, keyword or company',
                'locations' => 'All Locations',
                'roles' => 'All Job Roles',
                'button' => 'Filters',
                'load_more' => 'Load More Jobs',
            ],
            'jobLabels' => [
                'match' => 'Initial Track Match',
                'apply' => 'Apply Now',
                'credit' => '50 Credits',
                'apply_href' => '/direct-mode/login',
            ],
            'tipsPanel' => [
                'title' => 'Application Tips',
                'button' => 'View All Tips',
                'href' => '/direct-mode',
            ],
            'applicationTips' => [
                'Fill your profile completely',
                'Upload an updated resume',
                'Check your Initial Track Analysis',
                'Apply to jobs that match your skills',
            ],
            'analysisPanel' => [
                'title' => 'Your Initial Track Analysis',
                'labels' => ['Technical Skills', 'Aptitude', 'Communication', 'Learning Ability', 'Attitude'],
                'match_label' => 'Overall Match',
                'rating' => '****-',
                'fit' => 'Good Fit',
                'text' => 'Improve your score with Fast Track Program',
                'button' => 'Explore Fast Track Program',
                'href' => '/fast-track',
            ],
            'creditsHeader' => [
                'title' => 'Apply More Jobs with Additional Credits',
                'text' => 'You get 250 FREE credits to apply for jobs under Direct Mode. Each application uses 50 credits. Need more? Choose a plan that suits you.',
            ],
            'planLabels' => [
                'popular' => 'Popular',
                'credits' => 'Credits',
                'buy_href' => '/direct-mode/register',
            ],
            'creditTrustItems' => ['Secure Payments', 'Instant Credit', 'No Auto Renewal', 'Use Anytime'],
            'creditPlans' => $this->creditPlans(),
        ]);
    }

    public function fastTrack(): View
    {
        try {
            $courses = Course::query()
                ->where('status', 'active')
                ->whereHas('trainingPartnerProfile', fn ($query) => $query->where('approval_status', 'approved'))
                ->with('trainingPartnerProfile:id,institute_name,location')
                ->latest()
                ->take(5)
                ->get();

            $partners = $this->approvedTrainingPartners()->take(6)->get();
        } catch (QueryException) {
            $courses = collect();
            $partners = collect();
        }

        return view('public.fast-track.index', [
            'hero' => [
                'eyebrow' => 'Fast Track Program',
                'title' => 'Get Trained. Get Assessed. Get Hired.',
                'text' => 'Build the right skills with verified training partners, complete assessments, and unlock better fresher opportunities.',
                'button' => 'How Fast Track Works',
                'href' => '/fast-track/how-it-works',
                'image' => 'fast-track-program-hero.png',
            ],
            'programHeader' => [
                'title' => 'Fast Track Program',
                'text' => 'Get trained by our verified training partners, improve your skills and get access to better job opportunities.',
            ],
            'trackHeader' => [
                'title' => 'Explore Career Tracks',
                'text' => 'Choose a career track that matches your interest and career goals.',
                'button' => 'View All Tracks',
                'href' => '/fast-track/courses',
            ],
            'trackLabels' => [
                'skills' => 'Key Skills',
                'details' => 'View Details',
                'href' => '/fast-track/courses',
            ],
            'assessmentHeader' => [
                'title' => 'Assessment Summary',
                'text' => 'Improve your skills and see your growth with initial and final assessments.',
                'button' => 'View Detailed Report',
                'href' => '/fast-track/final-assessment',
            ],
            'assessmentCards' => [
                'initial' => [
                    'title' => 'Initial Assessment',
                    'subtitle' => '(Before Training)',
                    'date' => 'Completed on 01-Jun 2024',
                    'score' => '40%',
                    'score_label' => 'Overall Score',
                ],
                'final' => [
                    'title' => 'Final Assessment',
                    'subtitle' => '(After Training)',
                    'date' => 'To be taken after course completion',
                    'score' => '--%',
                    'score_label' => 'Overall Score',
                    'empty_value' => '--',
                ],
            ],
            'companyProfileBox' => [
                'title' => 'Companies Get You With',
                'button' => 'Know More',
                'href' => '/fast-track/how-it-works',
                'items' => [
                    ['title' => 'Initial Assessment', 'text' => '(Your Current Skills)'],
                    ['title' => 'Final Assessment', 'text' => '(Your Improved Skills)'],
                    ['title' => 'Training Completion Certificate', 'text' => ''],
                    ['title' => 'Industry Ready Profile', 'text' => ''],
                ],
            ],
            'partnersHeader' => [
                'title' => 'Our Trusted Training Partners',
                'text' => 'Learn from the best. Get Certified. Get hired.',
                'button' => 'View All Partners',
                'href' => '/training-partners',
            ],
            'plansHeader' => [
                'title' => 'Choose a Fast Track Program Plan',
                'text' => 'Select a plan that suits your learning needs.',
                'emi' => 'EMI options available',
            ],
            'planLabels' => [
                'popular' => 'Popular',
                'taxes' => '+ Taxes',
                'button' => 'Enroll Now',
                'href' => '/fast-track/register',
            ],
            'faqHeader' => [
                'title' => 'Frequently Asked Questions',
                'button' => 'View All FAQs',
                'href' => '/fast-track/how-it-works',
            ],
            'points' => [
                ['icon' => 'learn', 'text' => 'Industry-relevant learning'],
                ['icon' => 'users', 'text' => 'Expert training partners'],
                ['icon' => 'certificate', 'text' => 'Final assessment & certificate'],
                ['icon' => 'briefcase', 'text' => 'Better job opportunities'],
            ],
            'fastTrackSteps' => [
                ['step' => '1', 'title' => 'Enroll', 'text' => 'Choose your track', 'icon' => 'learn', 'color' => '#25ad82'],
                ['step' => '2', 'title' => 'Initial Assessment', 'text' => 'Evaluate your current skills', 'icon' => 'target', 'color' => '#075fe4'],
                ['step' => '3', 'title' => 'Training', 'text' => 'Learn from our training partners', 'icon' => 'training', 'color' => '#cbd5e1'],
                ['step' => '4', 'title' => 'Final Assessment', 'text' => 'Showcase your improved skills', 'icon' => 'chart', 'color' => '#cbd5e1'],
                ['step' => '5', 'title' => 'Certification', 'text' => 'Get certified & job ready', 'icon' => 'certificate', 'color' => '#cbd5e1'],
                ['step' => '6', 'title' => 'Get Hired', 'text' => 'Companies get your profile', 'icon' => 'users', 'color' => '#cbd5e1'],
            ],
            'careerTracks' => $courses->isNotEmpty()
                ? $courses->map(fn (Course $course) => [
                    'title' => $course->course_name,
                    'text' => $course->description ?: 'Build job-ready skills with guided training.',
                    'icon' => $this->courseIcon($course->category),
                    'color' => $this->courseColor($course->category),
                    'skills' => $this->skills($course->skills_covered),
                ])->all()
                : $this->fallbackCareerTracks(),
            'partners' => $partners->isNotEmpty()
                ? $partners->map(fn (TrainingPartnerProfile $partner, int $index) => [
                    'name' => $partner->institute_name ?: 'Partner',
                    'sub' => $partner->location ?: 'Approved Partner',
                    'score' => number_format(4.4 + (($index % 4) / 10), 1),
                    'color' => ['#176aa6', '#111827', '#2f64b2', '#d98728'][$index % 4],
                ])->all()
                : $this->fallbackPartners(),
            'fastTrackPlans' => $this->fastTrackPlans(),
            'fastTrackFaqs' => [
                'What is the Fast Track Program?',
                'How does the Fast Track Program work?',
                'Who can enroll in the program?',
                'Will I get a certificate?',
                'How will companies see my profile?',
            ],
            'assessmentLabels' => [
                'Technical Skills',
                'Aptitude',
                'Communication',
                'Attitude',
                'Problem Solving',
            ],
            'initialScores' => [
                ['label' => 'Technical Skills', 'value' => 42],
                ['label' => 'Aptitude', 'value' => 38],
                ['label' => 'Communication', 'value' => 45],
                ['label' => 'Attitude', 'value' => 40],
                ['label' => 'Problem Solving', 'value' => 35],
            ],
            'partnerBenefits' => [
                ['icon' => 'shield', 'title' => 'Verified Training Partners', 'text' => 'Industry-aligned curriculum'],
                ['icon' => 'training', 'title' => 'Live Interactive Sessions', 'text' => 'Learn from industry experts'],
                ['icon' => 'users', 'title' => 'Hands-on Projects', 'text' => 'Build real-world experience'],
                ['icon' => 'briefcase', 'title' => 'Placement Assistance', 'text' => 'Get placed in top companies'],
            ],
        ]);
    }

    public function trainingPartners(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'location' => trim((string) $request->query('location', '')),
            'category' => trim((string) $request->query('category', '')),
            'level' => trim((string) $request->query('level', '')),
        ];

        try {
            $baseCourses = Course::query()
                ->where('status', 'active')
                ->whereHas('trainingPartnerProfile', fn ($query) => $query->where('approval_status', 'approved'))
                ->with('trainingPartnerProfile:id,institute_name,location');

            $filterOptionsSource = (clone $baseCourses)->get();

            $coursesQuery = (clone $baseCourses)
                ->when($filters['q'] !== '', function ($query) use ($filters) {
                    $search = $filters['q'];
                    $query->where(function ($inner) use ($search) {
                        $inner
                            ->where('course_name', 'like', "%{$search}%")
                            ->orWhere('category', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('skills_covered', 'like', "%{$search}%")
                            ->orWhereHas('trainingPartnerProfile', function ($partnerQuery) use ($search) {
                                $partnerQuery
                                    ->where('institute_name', 'like', "%{$search}%")
                                    ->orWhere('location', 'like', "%{$search}%");
                            });
                    });
                })
                ->when($filters['location'] !== '', fn ($query) => $query->whereHas(
                    'trainingPartnerProfile',
                    fn ($partnerQuery) => $partnerQuery->where('location', $filters['location'])
                ))
                ->when($filters['category'] !== '', fn ($query) => $query->where('category', $filters['category']))
                ->when($filters['level'] !== '', fn ($query) => $query->where('training_mode', $filters['level']));

            $courses = $coursesQuery
                ->latest()
                ->take(12)
                ->get();

            $partnerCount = $this->approvedTrainingPartners()->count();
        } catch (QueryException) {
            $courses = collect();
            $filterOptionsSource = collect();
            $partnerCount = 0;
        }

        $courseRows = $courses->isNotEmpty()
            ? $courses->map(fn (Course $course, int $index) => [
                'logo' => $course->trainingPartnerProfile?->institute_name ?: 'Partner',
                'sub' => $course->trainingPartnerProfile?->location ?: 'Approved Partner',
                'rating' => number_format(4.4 + (($index % 4) / 10), 1),
                'reviews' => (string) (700 + ($index * 140)),
                'title' => $course->course_name,
                'city' => $course->trainingPartnerProfile?->location ?: 'India',
                'mode' => $this->titleCase($course->training_mode) ?: 'Live Online',
                'text' => $course->description ?: 'Build practical, job-ready skills with guided training.',
                'join' => '999',
                'fee' => number_format((float) $course->fees),
                'tags' => $this->skills($course->skills_covered),
                'features' => [
                    $course->duration ?: 'Live Training',
                    'Hands-on Projects',
                    'Certificate of Completion',
                    'Placement Assistance',
                ],
            ])->all()
            : $this->fallbackTrainingCourseRows();

        $filterOptionsSource = $filterOptionsSource->isNotEmpty()
            ? $filterOptionsSource
            : collect($courseRows)->map(fn ($row) => (object) [
                'category' => $row['tags'][0] ?? '',
                'training_mode' => $row['mode'] ?? '',
                'trainingPartnerProfile' => (object) ['location' => $row['city'] ?? ''],
            ]);

        $filterOptions = [
            'locations' => $filterOptionsSource
                ->map(fn ($course) => $course->trainingPartnerProfile?->location)
                ->filter()
                ->unique()
                ->values()
                ->all(),
            'categories' => $filterOptionsSource
                ->pluck('category')
                ->filter()
                ->unique()
                ->values()
                ->all(),
            'levels' => $filterOptionsSource
                ->pluck('training_mode')
                ->filter()
                ->unique()
                ->values()
                ->all(),
        ];

        return view('public.training-partners.index', [
            'partnerCount' => count($courseRows),
            'totalPartnerCount' => $partnerCount ?: count($courseRows),
            'currentFilters' => $filters,
            'filterOptions' => $filterOptions,
            'trainingHero' => [
                'title' => 'Our Trusted Training Partners',
                'text' => 'Learn, grow and get hired. Choose from industry-aligned courses offered by our verified training partners under Fast Track Program.',
                'search' => 'Search training partner or course',
                'location' => 'All Locations',
                'image' => 'training-partners-banner.png',
            ],
            'trainingFilters' => [
                'count_prefix' => 'Showing',
                'count_suffix' => 'Training Partners',
                'category' => 'All Categories',
                'level' => 'All Course Levels',
                'button' => 'Filters',
            ],
            'courseLabels' => [
                'reviews' => 'Reviews',
                'joining_fee' => 'Joining Fee',
                'package_fee' => 'Package Fee (Per Course)',
                'details' => 'View Details',
                'details_href' => '/courses',
                'load_more' => 'Load More Partners',
                'load_more_href' => '/courses',
                'empty' => 'No training partners found.',
                'currency' => '₹',
                'rating_symbol' => '★',
                'check_symbol' => '✓',
                'arrow' => '->',
            ],
            'trainingHeroBenefits' => [
                ['icon' => 'shield', 'title' => 'Verified Partners', 'text' => 'Quality training you can trust'],
                ['icon' => 'briefcase', 'title' => 'Industry Relevant Courses', 'text' => 'Designed for job roles'],
                ['icon' => 'users', 'title' => 'Expert Trainers', 'text' => 'Learn from industry experts'],
                ['icon' => 'chart', 'title' => 'Placement Support', 'text' => 'Better training, better jobs'],
            ],
            'courseRows' => $courseRows,
            'fastTrackReasons' => [
                'Industry aligned training',
                'Initial & Final assessment',
                'Certification on completion',
                'Enhanced job opportunities',
                'Dedicated placement support',
            ],
            'sidebarLabels' => [
                'reasons_title' => 'Why Join Fast Track Program?',
                'popular_title' => 'Popular Courses',
                'popular_button' => 'View All Courses',
                'popular_href' => '/courses',
                'steps_title' => 'How It Works?',
                'help_title' => 'Need Help Choosing?',
                'help_text' => 'Talk to our experts and find the right course for your career.',
                'help_button' => 'Talk to Expert',
                'help_href' => '/fast-track/register',
            ],
            'popularCourses' => collect($courseRows)
                ->take(5)
                ->map(fn ($row) => [$row['title'], 'Starting at ₹' . $row['fee']])
                ->all(),
            'popularCourseColors' => ['bg-[#35b99b]', 'bg-[#8239d7]', 'bg-[#2563eb]', 'bg-[#f59a23]', 'bg-[#21a391]'],
            'trainingSteps' => [
                ['Choose a Course', 'Select a course that matches your career goals.'],
                ['Enroll & Pay', 'Pay joining fee and course package fee to enroll.'],
                ['Learn & Grow', 'Attend sessions, complete assignments and projects.'],
                ['Get Certified', 'Complete the course and get certified.'],
                ['Get Hired', 'Companies hire job-ready candidates like you.'],
            ],
            'trainingBenefits' => [
                ['users', '100% Verified Trainers', 'Learn from industry experts'],
                ['training', 'Live Interactive Sessions', 'Real-time doubt solving'],
                ['learn', 'Hands-on Projects', 'Work on real-world projects'],
                ['briefcase', 'Placement Assistance', 'Get hired with confidence'],
                ['location', 'Flexible Learning', 'Classroom & Online options'],
            ],
        ]);
    }

    public function courses(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'category' => trim((string) $request->query('category', '')),
            'mode' => trim((string) $request->query('mode', '')),
        ];

        try {
            $baseCourses = Course::query()
                ->where('status', 'active')
                ->whereHas('trainingPartnerProfile', fn ($query) => $query->where('approval_status', 'approved'))
                ->with('trainingPartnerProfile:id,institute_name,location');

            $optionSource = (clone $baseCourses)->get();

            $courses = (clone $baseCourses)
                ->when($filters['q'] !== '', function ($query) use ($filters) {
                    $search = $filters['q'];
                    $query->where(function ($inner) use ($search) {
                        $inner
                            ->where('course_name', 'like', "%{$search}%")
                            ->orWhere('category', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('skills_covered', 'like', "%{$search}%")
                            ->orWhereHas('trainingPartnerProfile', fn ($partnerQuery) => $partnerQuery->where('institute_name', 'like', "%{$search}%"));
                    });
                })
                ->when($filters['category'] !== '', fn ($query) => $query->where('category', $filters['category']))
                ->when($filters['mode'] !== '', fn ($query) => $query->where('training_mode', $filters['mode']))
                ->latest()
                ->take(12)
                ->get();
        } catch (QueryException) {
            $courses = collect();
            $optionSource = collect();
        }

        $courseCards = $courses->isNotEmpty()
            ? $courses->map(fn (Course $course) => $this->courseCard($course))->all()
            : $this->fallbackCourseCards();

        $optionSource = $optionSource->isNotEmpty()
            ? $optionSource
            : collect($courseCards)->map(fn ($card) => (object) [
                'category' => $card['category'],
                'training_mode' => $card['mode'],
            ]);

        return view('public.courses.index', [
            'currentFilters' => $filters,
            'courseCards' => $courseCards,
            'courseCount' => count($courseCards),
            'courseHero' => [
                'title' => 'Explore Fast Track Courses',
                'text' => 'Choose industry-aligned courses from verified training partners and build job-ready skills.',
                'search' => 'Search course, skill or partner',
            ],
            'courseFilters' => [
                'count_prefix' => 'Showing',
                'count_suffix' => 'Courses',
                'category' => 'All Categories',
                'mode' => 'All Learning Modes',
                'button' => 'Filters',
                'empty' => 'No active courses found.',
            ],
            'courseOptions' => [
                'categories' => $optionSource->pluck('category')->filter()->unique()->values()->all(),
                'modes' => $optionSource->pluck('training_mode')->filter()->unique()->values()->all(),
            ],
            'courseLabels' => [
                'duration' => 'Duration',
                'mode' => 'Mode',
                'partner' => 'Training Partner',
                'fee' => 'Course Fee',
                'currency' => '₹',
                'details' => 'View Details',
                'details_href' => '/courses/show',
            ],
        ]);
    }

    public function courseShow(Request $request): View
    {
        $courseId = $request->query('course') ?: $request->query('id');

        try {
            $course = $courseId
                ? Course::query()
                    ->where('status', 'active')
                    ->whereHas('trainingPartnerProfile', fn ($query) => $query->where('approval_status', 'approved'))
                    ->with('trainingPartnerProfile:id,institute_name,location,email,phone,website,about_institute')
                    ->find($courseId)
                : null;
        } catch (QueryException) {
            $course = null;
        }

        $card = $course ? $this->courseCard($course) : $this->fallbackCourseCards()[0];

        return view('public.courses.show', [
            'course' => $card,
            'detailLabels' => [
                'overview' => 'Course Overview',
                'skills' => 'Skills Covered',
                'partner' => 'Training Partner',
                'fee' => 'Course Fee',
                'duration' => 'Duration',
                'mode' => 'Mode',
                'enroll' => 'Enroll Now',
                'back' => 'Back to Courses',
                'currency' => '₹',
            ],
        ]);
    }

    private function activeJobs()
    {
        return Job::query()
            ->where('status', 'active')
            ->where(function ($query) {
                $query
                    ->whereNull('application_last_date')
                    ->orWhereDate('application_last_date', '>=', now()->toDateString());
            });
    }

    private function approvedTrainingPartners()
    {
        return TrainingPartnerProfile::query()
            ->where('approval_status', 'approved')
            ->withCount(['courses' => fn ($query) => $query->where('status', 'active')])
            ->latest();
    }

    private function partnerNames(Collection $partners): array
    {
        return $partners->isNotEmpty()
            ? $partners->map(fn ($partner) => $partner->institute_name ?: 'Partner')->values()->all()
            : ['EXCELR', 'ENLITE', 'TecnMinds', 'iNeuron', 'Besant', 'TTA'];
    }

    private function skills(?string $value): array
    {
        $skills = collect(preg_split('/[,|]/', (string) $value))
            ->map(fn ($skill) => trim($skill))
            ->filter()
            ->take(4)
            ->values()
            ->all();

        return $skills ?: ['Job Skills', 'Projects', 'Assessment'];
    }

    private function initials(string $value): string
    {
        return collect(preg_split('/\s+/', trim($value)))
            ->filter()
            ->take(2)
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
    }

    private function titleCase(?string $value): string
    {
        return $value ? str($value)->replace(['_', '-'], ' ')->title()->toString() : '';
    }

    private function jobIcon(Job $job): string
    {
        $text = strtolower($job->title . ' ' . $job->required_skills);

        return str_contains($text, 'data') || str_contains($text, 'analyst')
            ? 'chart'
            : 'code';
    }

    private function courseIcon(?string $category): string
    {
        $category = strtolower((string) $category);

        return match (true) {
            str_contains($category, 'data') => 'data',
            str_contains($category, 'market') => 'marketing',
            str_contains($category, 'cloud') => 'cloud',
            str_contains($category, 'business'), str_contains($category, 'finance') => 'briefcase',
            default => 'code',
        };
    }

    private function courseColor(?string $category): string
    {
        $category = strtolower((string) $category);

        return match (true) {
            str_contains($category, 'data') => '#2fbf9b',
            str_contains($category, 'market') => '#f59a23',
            str_contains($category, 'cloud') => '#1f73ea',
            str_contains($category, 'business'), str_contains($category, 'finance') => '#8239d7',
            default => '#2563eb',
        };
    }

    private function fallbackCompanyJobs(): array
    {
        return [
            ['icon' => 'code', 'title' => 'Software Developer (Fresher)', 'meta' => 'Engineering · Full-time · Bangalore, India', 'date' => 'Posted recently', 'applications' => '0', 'shortlisted' => '0', 'direct' => '5 Free', 'fast' => '2 Free'],
            ['icon' => 'chart', 'title' => 'Data Analyst (Fresher)', 'meta' => 'Analytics · Full-time · Pune, India', 'date' => 'Posted recently', 'applications' => '0', 'shortlisted' => '0', 'direct' => '5 Free', 'fast' => '2 Free'],
        ];
    }

    private function fallbackDirectJobs(): array
    {
        return [
            ['logo' => 'TCS', 'company' => 'Tata Consultancy Services', 'title' => 'Software Engineer', 'location' => 'Mumbai, India', 'type' => 'Full-time', 'exp' => '0 - 1 Year', 'posted' => 'Posted recently', 'fit' => 'Good Fit', 'fitClass' => 'bg-[#dff6ef] text-[#0b8b67]'],
            ['logo' => 'INF', 'company' => 'Infosys', 'title' => 'Associate Developer', 'location' => 'Bangalore, India', 'type' => 'Full-time', 'exp' => '0 - 1 Year', 'posted' => 'Posted recently', 'fit' => 'Good Fit', 'fitClass' => 'bg-[#dff6ef] text-[#0b8b67]'],
        ];
    }

    private function fallbackCareerTracks(): array
    {
        return [
            ['title' => 'Software Development', 'text' => 'Build your career in coding and software development.', 'icon' => 'code', 'color' => '#2563eb', 'skills' => ['Python', 'DSA', 'SQL', 'Git']],
            ['title' => 'Data Science & Analytics', 'text' => 'Become a data expert and work with real-world data.', 'icon' => 'data', 'color' => '#2fbf9b', 'skills' => ['Python', 'SQL', 'Excel', 'Power BI']],
            ['title' => 'Digital Marketing', 'text' => 'Learn digital strategies and grow brands online.', 'icon' => 'marketing', 'color' => '#f59a23', 'skills' => ['SEO', 'SEM', 'SMM', 'Google Analytics']],
            ['title' => 'Business & Finance', 'text' => 'Build a career in finance, analytics and management.', 'icon' => 'briefcase', 'color' => '#8239d7', 'skills' => ['Accounting', 'Excel', 'Financial Modeling']],
            ['title' => 'Cloud Computing', 'text' => 'Learn cloud technologies and services.', 'icon' => 'cloud', 'color' => '#1f73ea', 'skills' => ['AWS', 'Azure', 'Linux', 'DevOps']],
        ];
    }

    private function fallbackPartners(): array
    {
        return [
            ['name' => 'EXCELR', 'sub' => 'Raising Excellence', 'score' => '4.6', 'color' => '#176aa6'],
            ['name' => 'ENLITE', 'sub' => 'INSTITUTE', 'score' => '4.5', 'color' => '#111827'],
            ['name' => 'iNeuron', 'sub' => 'Intelligence Pathway', 'score' => '4.7', 'color' => '#2f64b2'],
            ['name' => 'Besant', 'sub' => 'Technologies', 'score' => '4.5', 'color' => '#176aa6'],
        ];
    }

    private function fallbackTrainingCourseRows(): array
    {
        return [
            ['logo' => 'EXCELR', 'sub' => 'Raising Excellence', 'rating' => '4.6', 'reviews' => '1280', 'title' => 'Data Science & Analytics', 'city' => 'Bangalore, Karnataka', 'mode' => 'Classroom | Live Online', 'text' => 'Become a data expert and work with real-world data, analytics tools and dashboards.', 'join' => '999', 'fee' => '12,999', 'tags' => ['Python', 'SQL', 'Machine Learning', 'Power BI'], 'features' => ['60 Hours of Training', 'Hands-on Projects', 'Certificate of Completion', 'Placement Assistance']],
            ['logo' => 'ENLITE', 'sub' => 'INSTITUTE', 'rating' => '4.5', 'reviews' => '980', 'title' => 'Full Stack Development', 'city' => 'Pune, Maharashtra', 'mode' => 'Classroom | Live Online', 'text' => 'Learn full stack web development from basics to deployment.', 'join' => '799', 'fee' => '10,999', 'tags' => ['HTML', 'CSS', 'JavaScript', 'React'], 'features' => ['80 Hours of Training', 'Live Projects', 'Certificate of Completion', 'Placement Assistance']],
            ['logo' => 'iNeuron', 'sub' => 'Intelligence Pathway', 'rating' => '4.7', 'reviews' => '1640', 'title' => 'Cloud Computing (AWS)', 'city' => 'Online', 'mode' => 'Live Online', 'text' => 'Master AWS cloud services and build scalable cloud solutions.', 'join' => '999', 'fee' => '13,999', 'tags' => ['AWS', 'DevOps', 'Linux', 'Docker'], 'features' => ['50 Hours of Training', 'Real-time Labs', 'Certificate of Completion', 'Placement Assistance']],
        ];
    }

    private function courseCard(Course $course): array
    {
        return [
            'id' => $course->id,
            'title' => $course->course_name,
            'category' => $course->category ?: 'Fast Track',
            'text' => $course->description ?: 'Build practical, job-ready skills with guided training.',
            'duration' => $course->duration ?: 'Flexible Duration',
            'mode' => $this->titleCase($course->training_mode) ?: 'Online',
            'fee' => number_format((float) $course->fees),
            'partner' => $course->trainingPartnerProfile?->institute_name ?: 'Training Partner',
            'location' => $course->trainingPartnerProfile?->location ?: 'India',
            'skills' => $this->skills($course->skills_covered),
            'icon' => $this->courseIcon($course->category),
            'color' => $this->courseColor($course->category),
        ];
    }

    private function fallbackCourseCards(): array
    {
        return [
            ['id' => '', 'title' => 'Data Science & Analytics', 'category' => 'Data Science', 'text' => 'Become a data expert and work with real-world data, analytics tools and dashboards.', 'duration' => '60 Hours', 'mode' => 'Live Online', 'fee' => '12,999', 'partner' => 'EXCELR', 'location' => 'Bangalore, Karnataka', 'skills' => ['Python', 'SQL', 'Power BI', 'Machine Learning'], 'icon' => 'data', 'color' => '#2fbf9b'],
            ['id' => '', 'title' => 'Full Stack Development', 'category' => 'Development', 'text' => 'Learn full stack web development from basics to deployment.', 'duration' => '80 Hours', 'mode' => 'Live Online', 'fee' => '10,999', 'partner' => 'ENLITE', 'location' => 'Pune, Maharashtra', 'skills' => ['HTML', 'CSS', 'JavaScript', 'React'], 'icon' => 'code', 'color' => '#2563eb'],
            ['id' => '', 'title' => 'Cloud Computing', 'category' => 'Cloud', 'text' => 'Master cloud services and build scalable cloud solutions.', 'duration' => '50 Hours', 'mode' => 'Online', 'fee' => '13,999', 'partner' => 'iNeuron', 'location' => 'Online', 'skills' => ['AWS', 'Linux', 'Docker', 'DevOps'], 'icon' => 'cloud', 'color' => '#1f73ea'],
        ];
    }

    private function hiringPackages(): array
    {
        return [
            ['name' => 'Starter', 'desc' => 'Perfect for getting started', 'price' => '₹499', 'period' => '/month', 'button' => 'Choose Starter', 'popular' => false, 'items' => ['10 Job Postings', '50 Direct Mode Resumes', '20 Fast Track Mode Resumes', 'Candidate Contact Access', 'Email Support']],
            ['name' => 'Growth', 'desc' => 'Scale your hiring', 'price' => '₹799', 'period' => '/month', 'button' => 'Choose Growth', 'popular' => true, 'items' => ['25 Job Postings', '150 Direct Mode Resumes', '60 Fast Track Mode Resumes', 'Candidate Contact Access', 'Priority Support']],
            ['name' => 'Professional', 'desc' => 'For active hiring teams', 'price' => '₹999', 'period' => '/month', 'button' => 'Choose Professional', 'popular' => false, 'items' => ['60 Job Postings', '400 Direct Mode Resumes', '160 Fast Track Mode Resumes', 'Candidate Contact Access', 'Priority Support', 'Dedicated Account Manager']],
            ['name' => 'Enterprise', 'desc' => 'For large scale hiring', 'price' => 'Custom', 'period' => 'Contact Sales', 'button' => 'Contact Sales', 'popular' => false, 'items' => ['Unlimited Job Postings', 'Custom Resume Access', 'Dedicated Account Manager', 'Bulk Hiring Solutions', 'API Access', 'Custom Integrations']],
        ];
    }

    private function creditPlans(): array
    {
        return [
            ['name' => 'Starter', 'credits' => '250', 'price' => '₹0', 'period' => 'FREE', 'button' => 'Current Plan', 'popular' => false, 'items' => ['Apply to 5 jobs', '50 credits per application', 'For Direct Mode only']],
            ['name' => 'Basic', 'credits' => '1,000', 'price' => '₹249', 'period' => 'Valid for 60 days', 'button' => 'Buy Now', 'popular' => false, 'items' => ['Apply to 20 jobs', 'Valid for 60 days', 'For Direct Mode only']],
            ['name' => 'Pro', 'credits' => '2,500', 'price' => '₹499', 'period' => 'Valid for 90 days', 'button' => 'Buy Now', 'popular' => true, 'items' => ['Apply to 50 jobs', 'Valid for 90 days', 'For Direct Mode only', 'Priority Support']],
            ['name' => 'Premium', 'credits' => '5,000', 'price' => '₹899', 'period' => 'Valid for 120 days', 'button' => 'Buy Now', 'popular' => false, 'items' => ['Apply to 100 jobs', 'Valid for 120 days', 'For Direct Mode only', 'Priority Support']],
            ['name' => 'Ultimate', 'credits' => '10,000', 'price' => '₹1,499', 'period' => 'Valid for 180 days', 'button' => 'Buy Now', 'popular' => false, 'items' => ['Apply to 200 jobs', 'Valid for 180 days', 'For Direct Mode only', 'Priority Support']],
        ];
    }

    private function fastTrackPlans(): array
    {
        return [
            ['name' => 'Basic', 'desc' => 'Access to training content & assessments', 'price' => '4,999', 'items' => ['Live Training Sessions', 'Study Materials', 'Initial & Final Assessment'], 'popular' => false],
            ['name' => 'Standard', 'desc' => 'Includes projects & doubt clearing sessions', 'price' => '8,999', 'items' => ['All in Basic', 'Hands-on Projects', 'Doubt Clearing Sessions'], 'popular' => false],
            ['name' => 'Premium', 'desc' => 'Placement assistance & interview preparation', 'price' => '14,999', 'items' => ['All in Standard', 'Interview Preparation', 'Placement Assistance'], 'popular' => true],
            ['name' => 'Pro', 'desc' => 'One-to-one mentoring & personalized support', 'price' => '19,999', 'items' => ['All in Premium', '1:1 Mentoring', 'Priority Placement Support'], 'popular' => false],
        ];
    }
}
