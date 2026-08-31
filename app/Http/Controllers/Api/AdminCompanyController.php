<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\CompanyResumeAssignment;
use App\Models\FresherProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminCompanyController extends Controller
{
    /**
     * Admin ko saari companies ki list return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin companies ko manage kar sakta hai.',
            ], 403);
        }

        $companies = CompanyProfile::query()
            ->with([
                'user:id,name,email,mobile,role,status',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Companies fetched successfully.',
            'data' => [
                'companies' => $companies,
            ],
        ]);
    }

    /**
     * Admin single company ki complete details dekhega.
     */
    public function show(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company details dekh sakta hai.',
            ], 403);
        }

        $companyProfile->load([
            'user',

            'resumeAssignments.fresherProfile.user:id,name,email,status',

            'jobs' => function ($query) {
                $query
                    ->withCount('applications')
                    ->latest();
            },

            'jobs.applications.fresherProfile.user',

            'jobs.applications.interview',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Company details fetched successfully.',
            'data' => [
                'company' => $companyProfile,
            ],
        ]);
    }

    /**
     * Admin company profile ko approve karega.
     */
    public function approve(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company ko approve kar sakta hai.',
            ], 403);
        }

        if ($companyProfile->approval_status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Company is already approved.',
                'data' => [
                    'company' => $companyProfile->load('user'),
                ],
            ], 422);
        }

        $companyProfile->update([
            'approval_status' => 'approved',
            'rejection_reason' => null,
        ]);

        $assignedResumeCount = 0;

        if ($companyProfile->hiring_intent === 'resume_only') {
            $this->ensureDummyResumePool(100);
            $assignedResumeCount = $this->assignResumePoolToCompany($companyProfile->fresh());
        }

        return response()->json([
            'success' => true,
            'message' => $assignedResumeCount > 0
                ? "Company approved successfully. {$assignedResumeCount} resumes assigned."
                : 'Company approved successfully.',
            'data' => [
                'assigned_resume_count' => $assignedResumeCount,
                'company' => $companyProfile
                    ->fresh()
                    ->load('user', 'resumeAssignments.fresherProfile.user'),
            ],
        ]);
    }

    /**
     * Admin company profile ko reject karega.
     */
    public function reject(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company ko reject kar sakta hai.',
            ], 403);
        }

        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $companyProfile->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Company rejected successfully.',
            'data' => [
                'company' => $companyProfile
                    ->fresh()
                    ->load('user'),
            ],
        ]);
    }

    /**
     * Company user account ko active ya blocked karega.
     */
    public function updateUserStatus(
        Request $request,
        CompanyProfile $companyProfile
    ): JsonResponse {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company user status update kar sakta hai.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'active',
                    'blocked',
                ]),
            ],
        ]);

        $companyUser = $companyProfile->user;

        if (!$companyUser) {
            return response()->json([
                'success' => false,
                'message' => 'Company user account not found.',
            ], 404);
        }

        if ($companyUser->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Linked user is not a company user.',
            ], 422);
        }

        if ($companyUser->status === $validated['status']) {
            return response()->json([
                'success' => true,
                'message' => "Company user is already {$validated['status']}.",
                'data' => [
                    'company' => $companyProfile->load('user'),
                ],
            ]);
        }

        $companyUser->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'blocked') {
            $companyUser->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $validated['status'] === 'active'
                ? 'Company user activated successfully.'
                : 'Company user blocked successfully.',
            'data' => [
                'company' => $companyProfile
                    ->fresh()
                    ->load('user'),
            ],
        ]);
    }

    public function assignResumes(Request $request, CompanyProfile $companyProfile): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company ko resumes assign kar sakta hai.',
            ], 403);
        }

        $validated = $request->validate([
            'fresher_profile_ids' => ['required', 'array', 'min:1'],
            'fresher_profile_ids.*' => ['integer', 'distinct', 'exists:fresher_profiles,id'],
        ]);

        $resumeProfileIds = FresherProfile::query()
            ->whereIn('id', $validated['fresher_profile_ids'])
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->pluck('id');

        $resumeProfileIds->each(function (int $fresherProfileId) use ($companyProfile) {
            CompanyResumeAssignment::firstOrCreate([
                'company_profile_id' => $companyProfile->id,
                'fresher_profile_id' => $fresherProfileId,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Resumes assigned successfully.',
            'data' => [
                'assigned_count' => $resumeProfileIds->count(),
                'company' => $companyProfile
                    ->fresh()
                    ->load('user', 'resumeAssignments.fresherProfile.user'),
            ],
        ]);
    }

    public function availableResumes(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin resumes dekh sakta hai.',
            ], 403);
        }

        $resumes = FresherProfile::query()
            ->with('user:id,name,email,status')
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->latest()
            ->limit(100)
            ->get()
            ->map(fn (FresherProfile $profile) => [
                'id' => $profile->id,
                'name' => $profile->user?->name ?? 'Candidate',
                'email' => $profile->user?->email,
                'category' => $profile->preferred_job_category,
                'qualification' => $profile->qualification,
                'city' => $profile->city,
                'resume_file' => basename((string) $profile->resume),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Available resumes fetched successfully.',
            'data' => [
                'resumes' => $resumes,
            ],
        ]);
    }

    public function resumeOverview(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin resume overview dekh sakta hai.',
            ], 403);
        }

        $companies = CompanyProfile::query()
            ->with([
                'user:id,name,email,mobile,role,status',
                'resumeAssignments.fresherProfile.user:id,name,email,status',
            ])
            ->latest()
            ->get()
            ->map(fn (CompanyProfile $company) => [
                'id' => $company->id,
                'company_name' => $company->company_name,
                'email' => $company->email ?? $company->user?->email,
                'phone' => $company->phone ?? $company->user?->mobile,
                'industry' => $company->industry,
                'approval_status' => $company->approval_status,
                'hiring_intent' => $company->hiring_intent,
                'job_credits' => (int) $company->job_credits,
                'credits_used' => (int) $company->total_job_credits_used,
                'user_status' => $company->user?->status,
                'resumes' => $company->resumeAssignments
                    ->map(fn (CompanyResumeAssignment $assignment) => $assignment->fresherProfile)
                    ->filter()
                    ->values()
                    ->map(fn (FresherProfile $profile) => [
                        'id' => $profile->id,
                        'name' => $profile->user?->name ?? 'Candidate',
                        'email' => $profile->user?->email,
                        'city' => $profile->city,
                        'qualification' => $profile->qualification,
                        'college_name' => $profile->college_name,
                        'passing_year' => $profile->passing_year,
                        'skills' => $profile->skills,
                        'preferred_job_category' => $profile->preferred_job_category,
                        'resume_file' => basename((string) $profile->resume),
                    ]),
            ]);

        $availableCount = FresherProfile::query()
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Company resume overview fetched successfully.',
            'data' => [
                'companies' => $companies,
                'available_resume_count' => $availableCount,
                'cost_per_resume' => 50,
            ],
        ]);
    }

    public function createDummyResumes(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin dummy resumes create kar sakta hai.',
            ], 403);
        }

        $count = (int) $request->input('count', 100);
        $count = max(1, min($count, 100));

        $created = $this->ensureDummyResumePool($count);

        return response()->json([
            'success' => true,
            'message' => "{$created} dummy resumes ready for admin assignment.",
            'data' => [
                'created_count' => $created,
            ],
        ]);
    }

    public function assignAllResumes(Request $request, CompanyProfile $companyProfile): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf admin company ko resumes assign kar sakta hai.',
            ], 403);
        }

        $assigned = $this->assignResumePoolToCompany($companyProfile);
        $totalAvailable = FresherProfile::query()
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->count();

        return response()->json([
            'success' => true,
            'message' => "{$assigned} resumes assigned to company.",
            'data' => [
                'assigned_count' => $assigned,
                'total_available' => $totalAvailable,
                'company' => $companyProfile
                    ->fresh()
                    ->load('user', 'resumeAssignments.fresherProfile.user'),
            ],
        ]);
    }

    private function ensureDummyResumePool(int $count = 100): int
    {
        $candidates = [
            ['Aarav Sharma', 'Software Developer', 'B.Tech CSE', 'Noida', 'PHP, Laravel, MySQL, JavaScript'],
            ['Priya Mehta', 'Data Analyst', 'B.Sc Statistics', 'Gurugram', 'Excel, SQL, Power BI, Python'],
            ['Rohan Verma', 'Frontend Developer', 'BCA', 'Delhi', 'HTML, CSS, React, Tailwind'],
            ['Sneha Kapoor', 'HR Executive', 'BBA', 'Faridabad', 'Recruitment, Screening, Excel'],
            ['Kunal Singh', 'Backend Developer', 'MCA', 'Ghaziabad', 'Laravel, APIs, MySQL, Git'],
            ['Neha Gupta', 'Digital Marketing', 'B.Com', 'Jaipur', 'SEO, Meta Ads, Analytics'],
            ['Aditya Jain', 'UI Designer', 'B.Des', 'Pune', 'Figma, Wireframes, Prototyping'],
            ['Simran Kaur', 'Business Analyst', 'MBA', 'Chandigarh', 'Documentation, SQL, Stakeholders'],
            ['Mohit Yadav', 'QA Tester', 'B.Tech IT', 'Lucknow', 'Manual Testing, Selenium, Jira'],
            ['Isha Agarwal', 'Content Writer', 'BA English', 'Indore', 'Blogs, SEO Writing, Research'],
            ['Dev Patel', 'Operations Executive', 'BBA', 'Ahmedabad', 'MIS, Coordination, Excel'],
            ['Ananya Roy', 'Full Stack Developer', 'B.Tech CSE', 'Kolkata', 'Laravel, Vue, MySQL, REST'],
        ];

        $created = 0;

        $firstNames = [
            'Aarav', 'Priya', 'Rohan', 'Sneha', 'Kunal', 'Neha', 'Aditya', 'Simran', 'Mohit', 'Isha',
            'Dev', 'Ananya', 'Rahul', 'Pooja', 'Nikhil', 'Meera', 'Varun', 'Kriti', 'Yash', 'Tanvi',
        ];
        $lastNames = [
            'Sharma', 'Mehta', 'Verma', 'Kapoor', 'Singh', 'Gupta', 'Jain', 'Kaur', 'Yadav', 'Agarwal',
            'Patel', 'Roy', 'Mishra', 'Bansal', 'Saxena', 'Rana', 'Chauhan', 'Malhotra', 'Joshi', 'Arora',
        ];

        collect(range(1, $count))
            ->each(function (int $number) use (&$created, $candidates, $firstNames, $lastNames) {
                $index = $number - 1;
                [, $category, $qualification, $city, $skills] = $candidates[$index % count($candidates)];
                $name = $firstNames[$index % count($firstNames)] . ' ' . $lastNames[(int) floor($index / count($firstNames)) % count($lastNames)];
                $email = 'dummy.fresher.' . ($index + 1) . '@onlyfreshers.test';
                $resumePath = 'fresher/resumes/dummy-resume-' . ($index + 1) . '.pdf';

                Storage::disk('public')->put(
                    $resumePath,
                    $this->dummyResumePdf($name, $category, $qualification, $city, $skills)
                );

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'mobile' => '90000000' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                        'password' => Hash::make('Password@123'),
                        'role' => 'fresher',
                        'status' => 'active',
                    ]
                );

                FresherProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone' => $user->mobile,
                        'city' => $city,
                        'qualification' => $qualification,
                        'college_name' => 'OnlyFreshers Demo College',
                        'passing_year' => 2026,
                        'skills' => $skills,
                        'preferred_job_category' => $category,
                        'resume' => $resumePath,
                        'profile_completion' => 100,
                    ]
                );

                $created++;
            });

        return $created;
    }

    private function assignResumePoolToCompany(CompanyProfile $companyProfile): int
    {
        $assigned = 0;

        FresherProfile::query()
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->pluck('id')
            ->each(function (int $fresherProfileId) use ($companyProfile, &$assigned) {
                $assignment = CompanyResumeAssignment::firstOrCreate([
                    'company_profile_id' => $companyProfile->id,
                    'fresher_profile_id' => $fresherProfileId,
                ]);

                if ($assignment->wasRecentlyCreated) {
                    $assigned++;
                }
            });

        return $assigned;
    }

    private function dummyResumePdf(
        string $name,
        string $category,
        string $qualification,
        string $city,
        string $skills
    ): string {
        $lines = [
            $name,
            $category,
            $qualification . ' | ' . $city,
            'Skills: ' . $skills,
            'Experience: Fresher',
            'Email: ' . strtolower(str_replace(' ', '.', $name)) . '@onlyfreshers.test',
        ];

        $content = implode('', array_map(function (string $line, int $index) {
            $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
            $y = 760 - ($index * 28);

            return "BT /F1 16 Tf 72 {$y} Td ({$safe}) Tj ET\n";
        }, $lines, array_keys($lines)));

        $stream = "<< /Length " . strlen($content) . " >>\nstream\n{$content}endstream";
        $objects = [
            "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n",
            "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n",
            "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj\n",
            "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n",
            "5 0 obj {$stream} endobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= str_pad((string) $offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }

        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF";

        return $pdf;
    }
}
