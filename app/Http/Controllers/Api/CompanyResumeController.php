<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyResumeAssignment;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        DB::transaction(function () use ($assignment, $companyProfile) {
            $this->chargeResumeActionCredits($companyProfile, $assignment, 'shortlisted_at');

            $assignment->update([
                'status' => 'shortlisted',
                'shortlisted_at' => $assignment->shortlisted_at ?? now(),
            ]);
        });

        $assignment->load('fresherProfile.user');

        if ($assignment->fresherProfile?->user_id) {
            Notification::create([
                'user_id' => $assignment->fresherProfile->user_id,
                'type' => 'application',
                'title' => 'Resume Shortlisted',
                'message' => "{$companyProfile->company_name} shortlisted your resume. Interview details will be shared if selected for the next round.",
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Resume shortlisted successfully.',
            'data' => [
                'assignment' => $assignment->fresh('fresherProfile.user'),
                'credits' => $this->resumeCredits($companyProfile->fresh()),
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

        DB::transaction(function () use ($assignment, $companyProfile, $validated) {
            $this->chargeResumeActionCredits($companyProfile, $assignment, 'interview_sent_at');

            $assignment->update([
                'status' => 'interview_sent',
                'interview_link' => $validated['interview_link'],
                'interview_date' => $validated['interview_date'],
                'interview_time' => $validated['interview_time'],
                'interview_sent_at' => $assignment->interview_sent_at ?? now(),
                'company_joined_at' => null,
                'fresher_joined_at' => null,
            ]);
        });

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
                'credits' => $this->resumeCredits($companyProfile->fresh()),
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

        $assignment->load(['companyProfile', 'fresherProfile.user']);

        if ($user->role === 'company') {
            abort_unless($user->companyProfile?->id === $assignment->company_profile_id, 403);

            if (! $assignment->company_joined_at) {
                $assignment->update(['company_joined_at' => now()]);
                $assignment->company_joined_at = $assignment->fresh()->company_joined_at;
            }
        } elseif ($user->role === 'fresher') {
            abort_unless($user->fresherProfile?->id === $assignment->fresher_profile_id, 403);

            if (! $assignment->fresher_joined_at) {
                $assignment->update(['fresher_joined_at' => now()]);
                $assignment->fresher_joined_at = $assignment->fresh()->fresher_joined_at;
            }
        } else {
            abort(403);
        }

        if (
            $assignment->status === 'interview_sent' &&
            $assignment->company_joined_at &&
            $assignment->fresher_joined_at
        ) {
            $assignment->update([
                'status' => 'interview_completed',
            ]);

            if ($assignment->fresherProfile?->user_id) {
                Notification::create([
                    'user_id' => $assignment->fresherProfile->user_id,
                    'type' => 'interview',
                    'title' => 'Interview Completed',
                    'message' => "{$assignment->companyProfile->company_name} marked your interview as completed. Final status will be shared soon.",
                    'is_read' => false,
                ]);
            }
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

        DB::transaction(function () use ($assignment, $companyProfile) {
            $this->chargeResumeActionCredits($companyProfile, $assignment, 'interview_completed_at');

            $assignment->update([
                'status' => 'interview_completed',
                'interview_completed_at' => $assignment->interview_completed_at ?? now(),
            ]);
        });

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
                'credits' => $this->resumeCredits($companyProfile->fresh()),
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

        DB::transaction(function () use ($assignment, $companyProfile, $validated) {
            $this->chargeResumeActionCredits($companyProfile, $assignment, 'final_status_sent_at');

            $assignment->update([
                'status' => $validated['status'],
                'final_status_sent_at' => $assignment->final_status_sent_at ?? now(),
            ]);
        });

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
                'credits' => $this->resumeCredits($companyProfile->fresh()),
            ],
        ]);
    }

    private function chargeResumeActionCredits(
        $companyProfile,
        CompanyResumeAssignment $assignment,
        string $chargedAtColumn
    ): void
    {
        $lockedAssignment = $assignment->newQuery()
            ->whereKey($assignment->id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($this->hasResumeActionCharge($lockedAssignment)) {
            if (! $lockedAssignment->{$chargedAtColumn}) {
                $lockedAssignment->forceFill([
                    $chargedAtColumn => now(),
                ])->save();
            }

            $assignment->setAttribute($chargedAtColumn, $lockedAssignment->{$chargedAtColumn});

            return;
        }

        $lockedProfile = $companyProfile->newQuery()
            ->whereKey($companyProfile->id)
            ->lockForUpdate()
            ->firstOrFail();

        abort_if(
            (int) $lockedProfile->job_credits < self::RESUME_VIEW_CREDIT_COST,
            402,
            'Resume credits are over.'
        );

        $lockedProfile->decrement('job_credits', self::RESUME_VIEW_CREDIT_COST);
        $lockedProfile->increment('total_job_credits_used', self::RESUME_VIEW_CREDIT_COST);

        $lockedAssignment->forceFill([
            $chargedAtColumn => now(),
        ])->save();

        $assignment->setAttribute($chargedAtColumn, $lockedAssignment->{$chargedAtColumn});
    }

    private function hasResumeActionCharge(CompanyResumeAssignment $assignment): bool
    {
        return collect([
            'resume_opened_at',
            'resume_downloaded_at',
            'shortlisted_at',
            'interview_sent_at',
            'interview_completed_at',
            'final_status_sent_at',
        ])->contains(fn (string $column) => filled($assignment->{$column}));
    }

    private function resumeCredits($companyProfile): array
    {
        return [
            'remaining' => (int) $companyProfile->job_credits,
            'cost_per_action' => self::RESUME_VIEW_CREDIT_COST,
            'can_continue' => $companyProfile->job_credits >= self::RESUME_VIEW_CREDIT_COST,
        ];
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
