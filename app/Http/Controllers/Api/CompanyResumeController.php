<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyResumeAssignment;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyResumeController extends Controller
{
    private const RESUME_VIEW_CREDIT_COST = 50;

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Only companies can access resumes.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (! $companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile not found.',
            ], 422);
        }

        if ($companyProfile->approval_status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Admin approval required before accessing resumes.',
            ], 403);
        }

        if ($companyProfile->hiring_intent !== 'resume_only') {
            return response()->json([
                'success' => false,
                'message' => 'Resume access is available for resume-only companies.',
            ], 403);
        }

        $resumes = $companyProfile
            ->resumeAssignments()
            ->with([
                'fresherProfile:id,user_id,city,qualification,college_name,passing_year,skills,preferred_job_category,resume',
                'fresherProfile.user:id,name,email,status',
            ])
            ->latest()
            ->get()
            ->filter(fn ($assignment) => filled($assignment->fresherProfile?->resume))
            ->values()
            ->map(fn (CompanyResumeAssignment $assignment) => [
                'assignment_id' => $assignment->id,
                'status' => $assignment->status ?? 'assigned',
                'interview_link' => $assignment->interview_link,
                'interview_date' => $assignment->interview_date?->format('Y-m-d'),
                'interview_time' => $assignment->interview_time,
                'id' => $assignment->fresherProfile->id,
                'name' => $assignment->fresherProfile->user?->name ?? 'Candidate',
                'email' => $assignment->fresherProfile->user?->email,
                'city' => $assignment->fresherProfile->city,
                'qualification' => $assignment->fresherProfile->qualification,
                'college_name' => $assignment->fresherProfile->college_name,
                'passing_year' => $assignment->fresherProfile->passing_year,
                'skills' => $assignment->fresherProfile->skills,
                'preferred_job_category' => $assignment->fresherProfile->preferred_job_category,
                'resume_file' => basename((string) $assignment->fresherProfile->resume),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Resumes fetched successfully.',
            'data' => [
                'resumes' => $resumes,
                'credits' => [
                    'remaining' => (int) $companyProfile->job_credits,
                    'cost_per_resume' => self::RESUME_VIEW_CREDIT_COST,
                    'can_open' => $companyProfile->job_credits >= self::RESUME_VIEW_CREDIT_COST,
                ],
            ],
        ]);
    }

    public function shortlist(Request $request, CompanyResumeAssignment $assignment): JsonResponse
    {
        $companyProfile = $this->authorizedResumeCompany($request);

        if ($assignment->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot update this resume.',
            ], 403);
        }

        $assignment->update([
            'status' => 'shortlisted',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resume shortlisted successfully.',
            'data' => [
                'assignment' => $assignment->fresh('fresherProfile.user'),
            ],
        ]);
    }

    public function sendInterview(Request $request, CompanyResumeAssignment $assignment): JsonResponse
    {
        $companyProfile = $this->authorizedResumeCompany($request);

        if ($assignment->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot update this resume.',
            ], 403);
        }

        $validated = $request->validate([
            'interview_link' => ['required', 'url', 'max:500'],
            'interview_date' => ['required', 'date', 'after_or_equal:today'],
            'interview_time' => ['required', 'date_format:H:i'],
            'status' => ['nullable', Rule::in(['interview_sent'])],
        ]);

        $assignment->load('fresherProfile.user');
        $assignment->update([
            'status' => 'interview_sent',
            'interview_link' => $validated['interview_link'],
            'interview_date' => $validated['interview_date'],
            'interview_time' => $validated['interview_time'],
        ]);

        if ($assignment->fresherProfile?->user_id) {
            Notification::create([
                'user_id' => $assignment->fresherProfile->user_id,
                'type' => 'interview',
                'title' => 'Interview Link Received',
                'message' => "{$companyProfile->company_name} shortlisted your resume and sent an interview link: {$validated['interview_link']}",
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview link sent successfully.',
            'data' => [
                'assignment' => $assignment->fresh('fresherProfile.user'),
            ],
        ]);
    }

    private function authorizedResumeCompany(Request $request)
    {
        $user = $request->user();
        $companyProfile = $user?->companyProfile;

        abort_unless($user?->role === 'company' && $companyProfile, 403);
        abort_unless($companyProfile->approval_status === 'approved', 403);
        abort_unless($companyProfile->hiring_intent === 'resume_only', 403);

        return $companyProfile;
    }
}
