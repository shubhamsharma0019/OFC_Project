<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicJobController extends Controller
{
    /**
     * Active jobs list for the public website and freshers.
     */
    public function index(Request $request): JsonResponse
    {
        $jobs = Job::query()
            ->with('companyProfile:id,company_name,company_logo,industry')
            ->withCount([
                'applications as hired_applications_count' => function ($query) {
                    $query->where('application_status', 'hired');
                },
            ])
            ->where('status', 'active')
            ->where(function ($query) {
                $query
                    ->whereNull('application_last_date')
                    ->orWhereDate('application_last_date', '>=', now()->toDateString());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('openings')
                    ->orWhereRaw(
                        "openings > (
                            SELECT COUNT(*)
                            FROM job_applications
                            WHERE job_applications.job_id = jobs.id
                            AND job_applications.application_status = 'hired'
                        )"
                    );
            })
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->string('search')->toString();

                    $query->where(function ($jobQuery) use ($search) {
                        $jobQuery
                            ->where('title', 'like', "%{$search}%")
                            ->orWhere('required_skills', 'like', "%{$search}%")
                            ->orWhere('qualification', 'like', "%{$search}%")
                            ->orWhereHas('companyProfile', function ($companyQuery) use ($search) {
                                $companyQuery
                                    ->where('company_name', 'like', "%{$search}%")
                                    ->orWhere('industry', 'like', "%{$search}%");
                            });
                    });
                }
            )
            ->when(
                $request->filled('location'),
                function ($query) use ($request) {
                    $query->where(
                        'location',
                        'like',
                        '%' . $request->string('location')->toString() . '%'
                    );
                }
            )
            ->when(
                $request->filled('hiring_mode'),
                function ($query) use ($request) {
                    $query->where(
                        'hiring_mode',
                        $request->string('hiring_mode')->toString()
                    );
                }
            )
            ->when(
                $request->filled('job_category'),
                function ($query) use ($request) {
                    $terms = $this->categoryTerms(
                        $request->string('job_category')->toString()
                    );

                    $query->where(function ($jobQuery) use ($terms) {
                        foreach ($terms as $term) {
                            $jobQuery
                                ->orWhere('title', 'like', "%{$term}%")
                                ->orWhere('required_skills', 'like', "%{$term}%")
                                ->orWhere('description', 'like', "%{$term}%")
                                ->orWhereHas('companyProfile', function ($companyQuery) use ($term) {
                                    $companyQuery->where('industry', 'like', "%{$term}%");
                                });
                        }
                    });
                }
            )
            ->when(
                $request->filled('job_type'),
                function ($query) use ($request) {
                    $jobType = strtolower(
                        str_replace(
                            ['_', '-'],
                            ' ',
                            $request->string('job_type')->toString()
                        )
                    );

                    $query->whereRaw(
                        'LOWER(REPLACE(job_type, ?, ?)) = ?',
                        ['_', ' ', $jobType]
                    );
                }
            )
            ->latest()
            ->get();

        $minPackage = $request->filled('min_package')
            ? (float) $request->query('min_package')
            : null;
        $maxPackage = $request->filled('max_package')
            ? (float) $request->query('max_package')
            : null;

        if ($minPackage !== null || $maxPackage !== null) {
            $jobs = $jobs
                ->filter(function (Job $job) use ($minPackage, $maxPackage) {
                    [$salaryMin, $salaryMax] = $this->salaryBounds($job->salary);

                    if ($salaryMin === null && $salaryMax === null) {
                        return false;
                    }

                    if ($minPackage !== null && $salaryMax !== null && $salaryMax < $minPackage) {
                        return false;
                    }

                    if ($maxPackage !== null && $salaryMin !== null && $salaryMin > $maxPackage) {
                        return false;
                    }

                    return true;
                })
                ->values();
        }

        return response()->json([
            'success' => true,
            'message' => 'Active jobs fetched successfully.',
            'data' => [
                'jobs' => $jobs,
            ],
        ]);
    }

    /**
     * Public active job ki complete details return karega.
     */
    public function show(Job $job): JsonResponse
    {
        if ($job->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'This job is not available.',
            ], 404);
        }

        if (
            $job->application_last_date &&
            $job->application_last_date->lt(now()->startOfDay())
        ) {
            return response()->json([
                'success' => false,
                'message' => 'The application date for this job has expired.',
            ], 404);
        }

        $job->load(
            'companyProfile:id,company_name,company_logo,industry,website,address,description'
        );
        $job->loadCount([
            'applications as hired_applications_count' => function ($query) {
                $query->where('application_status', 'hired');
            },
        ]);

        if (
            $job->openings !== null &&
            $job->hired_applications_count >= $job->openings
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Hiring for this job has been completed.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Job details fetched successfully.',
            'data' => [
                'job' => $job,
            ],
        ]);
    }

    private function salaryBounds(?string $salary): array
    {
        if (! $salary) {
            return [null, null];
        }

        preg_match_all('/\d+(?:,\d+)*(?:\.\d+)?/', $salary, $matches);

        $numbers = collect($matches[0] ?? [])
            ->map(fn (string $value) => (float) str_replace(',', '', $value))
            ->filter(fn (float $value) => $value > 0)
            ->values();

        if ($numbers->isEmpty()) {
            return [null, null];
        }

        $normalized = $numbers->map(function (float $value) use ($salary) {
            $text = strtolower($salary);

            if (str_contains($text, 'month') || str_contains($text, 'pm')) {
                return ($value * 12) / 100000;
            }

            if ($value >= 100000) {
                return $value / 100000;
            }

            return $value;
        });

        return [$normalized->min(), $normalized->max()];
    }

    private function categoryTerms(string $category): array
    {
        $normalized = strtolower($category);

        return match (true) {
            str_contains($normalized, 'data') => ['data analyst', 'data', 'sql', 'excel', 'power bi', 'analytics'],
            str_contains($normalized, 'software') || str_contains($normalized, 'developer') => [
                'software',
                'developer',
                'development',
                'programmer',
                'engineer',
                'laravel',
                'php',
                'react',
                'javascript',
                'python',
                'java',
                'web',
                'frontend',
                'backend',
                'full stack',
                'devops',
                'tester',
                'testing',
                'qa',
                'automation',
                'selenium',
            ],
            str_contains($normalized, 'ui') || str_contains($normalized, 'ux') || str_contains($normalized, 'design') => ['ui', 'ux', 'designer', 'figma', 'wireframe'],
            str_contains($normalized, 'marketing') => ['marketing', 'seo', 'social media', 'content', 'analytics'],
            default => [$category],
        };
    }
}
