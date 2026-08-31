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
                'company_joined_at' => optional($assignment->company_joined_at)->toIso8601String(),
                'fresher_joined_at' => optional($assignment->fresher_joined_at)->toIso8601String(),
                'both_joined' => filled($assignment->company_joined_at) && filled($assignment->fresher_joined_at),
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
            'company_joined_at' => null,
            'fresher_joined_at' => null,
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

    public function markInterviewJoined(Request $request, CompanyResumeAssignment $assignment): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Login required.',
            ], 401);
        }

        if ($assignment->status !== 'interview_sent') {
            return response()->json([
                'success' => false,
                'message' => 'This interview is not open for joining.',
            ], 422);
        }

        $assignment->load(['companyProfile', 'fresherProfile']);

        if ($user->role === 'company') {
            abort_unless($user->companyProfile?->id === $assignment->company_profile_id, 403);

            if (! $assignment->company_joined_at) {
                $assignment->update(['company_joined_at' => now()]);
            }
        } elseif ($user->role === 'fresher') {
            abort_unless($user->fresherProfile?->id === $assignment->fresher_profile_id, 403);

            if (! $assignment->fresher_joined_at) {
                $assignment->update(['fresher_joined_at' => now()]);
            }
        } else {
            abort(403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview join recorded.',
            'data' => [
                'assignment' => $assignment->fresh(),
            ],
        ]);
    }

    public function completeInterview(Request $request, CompanyResumeAssignment $assignment): JsonResponse
    {
        $companyProfile = $this->authorizedResumeCompany($request);

        if ($assignment->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot update this resume.',
            ], 403);
        }

        if ($assignment->status !== 'interview_sent') {
            return response()->json([
                'success' => false,
                'message' => 'Only scheduled interviews can be closed.',
            ], 422);
        }

        if (! $assignment->company_joined_at || ! $assignment->fresher_joined_at) {
            return response()->json([
                'success' => false,
                'message' => 'Interview can be closed only after company and fresher both join the meeting.',
            ], 422);
        }

        $assignment->load('fresherProfile.user');
        $assignment->update([
            'status' => 'interview_completed',
        ]);

        if ($assignment->fresherProfile?->user_id) {
            Notification::create([
                'user_id' => $assignment->fresherProfile->user_id,
                'type' => 'interview',
                'title' => 'Interview Completed',
                'message' => "{$companyProfile->company_name} marked your interview as completed. Final status will be shared soon.",
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview marked as completed.',
            'data' => [
                'assignment' => $assignment->fresh('fresherProfile.user'),
            ],
        ]);
    }

    public function updateHiringStatus(Request $request, CompanyResumeAssignment $assignment): JsonResponse
    {
        $companyProfile = $this->authorizedResumeCompany($request);

        if ($assignment->company_profile_id !== $companyProfile->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot update this resume.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['hired', 'not_selected'])],
        ]);

        if (! in_array($assignment->status, ['interview_completed', 'hired', 'not_selected'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Close the interview before sending final status.',
            ], 422);
        }

        $assignment->load('fresherProfile.user');
        $assignment->update([
            'status' => $validated['status'],
        ]);

        if ($assignment->fresherProfile?->user_id) {
            $title = $validated['status'] === 'hired' ? 'You Are Hired' : 'Not Selected';
            $message = $validated['status'] === 'hired'
                ? "{$companyProfile->company_name} marked your interview result as hired."
                : "{$companyProfile->company_name} marked your interview result as not selected.";

            Notification::create([
                'user_id' => $assignment->fresherProfile->user_id,
                'type' => 'interview',
                'title' => $title,
                'message' => $message,
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Candidate status updated successfully.',
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
