<?php

return [
    'assessment' => [
        'direct_mode_threshold' => env('OFC_DIRECT_MODE_THRESHOLD', 50),
        'internship_eligibility_score' => env('OFC_INTERNSHIP_ELIGIBILITY_SCORE', 50),
        'initial_retake_cooldown_days' => env('OFC_INITIAL_ASSESSMENT_RETAKE_COOLDOWN_DAYS', 30),
    ],

    'direct_mode' => [
        'free_application_credits' => env('OFC_DIRECT_MODE_FREE_APPLICATION_CREDITS', 250),
        'application_credit_cost' => env('OFC_DIRECT_MODE_APPLICATION_CREDIT_COST', 50),
    ],

    'company' => [
        'free_job_postings' => env('OFC_COMPANY_FREE_JOB_POSTINGS', 3),
        'direct_mode_free_resumes_per_job' => env('OFC_COMPANY_DIRECT_MODE_FREE_RESUMES_PER_JOB', 5),
        'fast_track_free_resumes_per_job' => env('OFC_COMPANY_FAST_TRACK_FREE_RESUMES_PER_JOB', 2),
        'dashboard' => [
            'hero' => [
                'title_prefix' => 'Welcome back,',
                'status' => 'Find and hire the best fresher talent for your team.',
                'primary_action' => ['label' => 'Post Opportunity', 'href' => '/company/post-job'],
                'secondary_action' => ['label' => 'View Candidates', 'href' => '/company/applications'],
            ],
            'hiring_flow_title' => 'How Hiring Works on OnlyFreshers',
            'hiring_modes' => [
                'direct' => [
                    'title' => 'Direct Mode',
                    'items' => [
                        'Post a job or internship and get resumes of suitable freshers.',
                        'Get Initial Track Analysis with each resume.',
                        'Shortlist and connect with the best candidates.',
                    ],
                ],
                'fast_track' => [
                    'title' => 'Fast Track Mode',
                    'items' => [
                        'Get candidates trained by verified training partners.',
                        'Receive Initial & Final Assessment of each candidate.',
                        'Hire job-ready freshers with enhanced skills.',
                    ],
                ],
            ],
            'recent_jobs' => [
                'title' => 'Recent Opportunities',
                'view_all_label' => 'View All ->',
                'fallback' => [
                    [
                        'title' => 'Software Developer (Fresher)',
                        'category' => 'Engineering',
                        'job_type' => 'Full-time',
                        'location' => 'Bangalore, India',
                        'created_at' => '2024-05-10',
                        'applications_count' => 28,
                        'shortlisted_applications_count' => 8,
                    ],
                    [
                        'title' => 'Data Analyst (Fresher)',
                        'category' => 'Analytics',
                        'job_type' => 'Full-time',
                        'location' => 'Pune, India',
                        'created_at' => '2024-05-07',
                        'applications_count' => 18,
                        'shortlisted_applications_count' => 4,
                    ],
                ],
            ],
            'cta' => [
                'title' => "You've used all your free opportunity postings!",
                'available_title' => 'Free opportunity postings available',
                'text' => 'Your first company credits are finished. Choose a hiring plan, or use Custom when you only need resume access.',
                'available_text' => 'Use your free postings to reach verified fresher talent.',
                'button' => 'View Hiring Packages',
                'href' => '/company/billing',
            ],
            'hiring_packages' => [
                ['name' => 'Starter', 'desc' => 'Perfect for getting started', 'price' => '₹2', 'period' => '/month', 'button' => 'Choose Starter', 'popular' => false, 'items' => ['10 Job Postings', '50 Direct Mode Resumes (5 per job extra)', '20 Fast Track Mode Resumes (2 per job extra)', 'Candidate Contact Access', 'Email Support']],
                ['name' => 'Growth', 'desc' => 'Scale your hiring', 'price' => '₹3', 'period' => '/month', 'button' => 'Choose Growth', 'popular' => true, 'items' => ['25 Job Postings', '150 Direct Mode Resumes (6 per job extra)', '60 Fast Track Mode Resumes (2.5 per job extra)', 'Candidate Contact Access', 'Priority Support']],
                ['name' => 'Professional', 'desc' => 'For active hiring teams', 'price' => '₹4', 'period' => '/month', 'button' => 'Choose Professional', 'popular' => false, 'items' => ['60 Job Postings', '400 Direct Mode Resumes (7 per job extra)', '160 Fast Track Mode Resumes (2.5 per job extra)', 'Candidate Contact Access', 'Priority Support', 'Dedicated Account Manager']],
                ['name' => 'Customise Plan', 'desc' => 'Enterprise or resume-only access', 'price' => 'Custom', 'period' => '2 categories', 'button' => 'Customise Plan', 'popular' => false, 'items' => ['Enterprise Custom: Contact Sales', 'Resume Plan: 3 Months / 200 Resumes', 'Resume Plan: 6 Months / 500 Resumes', 'Resume Plan: 1 Year / Full Access']],
            ],
            'resume_packs' => [
                'title' => 'Additional Resume Packs',
                'text' => 'Need more resumes without upgrading your plan?',
                'button' => 'Buy Now',
                'href' => '/company/billing',
                'items' => [
                    ['title' => 'Direct Mode Resumes', 'price' => '₹300', 'quantity' => '/ 5 Resumes', 'icon' => 'file', 'classes' => 'bg-[#eaf2ff] text-[#075fe4]'],
                    ['title' => 'Fast Track Mode Resumes', 'price' => '₹400', 'quantity' => '/ 5 Resumes', 'icon' => 'users', 'classes' => 'bg-[#e8fbf3] text-[#00ad6f]'],
                ],
            ],
            'trust_items' => [
                ['icon' => 'shield', 'title' => '100% Verified Freshers', 'text' => 'All candidates are verified'],
                ['icon' => 'file', 'title' => 'Initial & Final Assessment', 'text' => 'Make data-driven hiring decisions'],
                ['icon' => 'users', 'title' => 'Trained & Job-Ready Talent', 'text' => 'Hire with confidence'],
                ['icon' => 'clock', 'title' => 'Save Time & Cost', 'text' => 'Streamlined hiring process'],
            ],
        ],
    ],

    'footer' => [
        'cta' => [
            'title' => 'Start Your Journey Today!',
            'text' => 'Whether you choose Direct Mode or Fast Track Mode, OnlyFreshers is here to help you get hired faster.',
            'icon' => 'rocket',
        ],
        'actions' => [
            [
                'title' => 'For Freshers',
                'subtitle' => 'Find Jobs & Programs',
                'href' => '/direct-mode/login',
            ],
            [
                'title' => 'For Companies',
                'subtitle' => 'Post Jobs & Hire Talent',
                'href' => '/company/login',
            ],
        ],
        'stats' => [
            ['value' => '5000+', 'label' => 'Jobs Listed'],
            ['value' => '10,000+', 'label' => 'Freshers Hired'],
            ['value' => '1000+', 'label' => 'Companies'],
            ['value' => '50+', 'label' => 'Training Partners'],
        ],
    ],
];
