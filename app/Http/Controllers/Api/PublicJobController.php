<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicJobController extends Controller
{
    /**
     * Public website aur freshers ke liye active jobs list.
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
            ->whereRaw(
                "openings IS NULL OR openings > (
                    SELECT COUNT(*)
                    FROM job_applications
                    WHERE job_applications.job_id = jobs.id
                    AND job_applications.application_status = 'hired'
                )"
            )
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
            ->latest()
            ->get();

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
                'message' => 'Job available nahi hai.',
            ], 404);
        }

        if (
            $job->application_last_date &&
            $job->application_last_date->lt(now()->startOfDay())
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Is job ki application date expire ho chuki hai.',
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
                'message' => 'Is job ki hiring complete ho chuki hai.',
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
}
