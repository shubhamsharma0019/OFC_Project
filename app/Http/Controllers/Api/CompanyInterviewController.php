<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\JobApplication;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyInterviewController extends Controller
{
    /**
     * Logged-in company ke saare interviews return karega.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company interviews dekh sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $interviews = Interview::query()
            ->whereHas(
                'jobApplication.job',
                function ($query) use ($companyProfile) {
                    $query->where(
                        'company_profile_id',
                        $companyProfile->id
                    );
                }
            )
            ->with([
                'jobApplication:id,job_id,fresher_profile_id,application_status',
                'jobApplication.job:id,company_profile_id,title',
                'jobApplication.fresherProfile:id,user_id,qualification,skills,resume',
                'jobApplication.fresherProfile.user:id,name,email',
            ])
            ->orderByDesc('interview_date')
            ->orderByDesc('interview_time')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Company interviews fetched successfully.',
            'data' => [
                'interviews' => $interviews,
            ],
        ]);
    }

    /**
     * Company shortlisted candidate ka interview schedule karegi.
     */
    public function store(
        Request $request,
        JobApplication $jobApplication
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company interview schedule kar sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $jobApplication->load([
            'job',
            'job.companyProfile',
            'fresherProfile.user',
            'interview',
        ]);

        if (
            $jobApplication->job->company_profile_id
            !== $companyProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is application ka interview schedule nahi kar sakte.',
            ], 403);
        }

        if ($jobApplication->application_status !== 'shortlisted') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf shortlisted candidate ka interview schedule ho sakta hai.',
            ], 422);
        }

        if ($jobApplication->interview) {
            return response()->json([
                'success' => false,
                'message' => 'Is application ka interview pehle se scheduled hai.',
            ], 422);
        }

        $validatedData = $request->validate([
            'interview_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'interview_time' => [
                'required',
                'date_format:H:i',
            ],

            'interview_mode' => [
                'required',
                Rule::in([
                    'online',
                    'offline',
                ]),
            ],

            'interview_location' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(
                    $request->input('interview_mode') === 'offline'
                ),
            ],

            'meeting_link' => [
                'nullable',
                'url',
                'max:500',
                'regex:/^https?:\/\/meet\.google\.com\/[a-z0-9-]+(?:[\/?#].*)?$/i',
                Rule::requiredIf(
                    $request->input('interview_mode') === 'online'
                ),
            ],
        ], [
            'meeting_link.required' => 'Online interview ke liye Google Meet link required hai.',
            'meeting_link.url' => 'Please paste a valid Google Meet link.',
            'meeting_link.regex' => 'Meeting link Google Meet ka hona chahiye, for example https://meet.google.com/abc-defg-hij.',
        ]);

        if ($validatedData['interview_mode'] === 'online') {
            $validatedData['interview_location'] = null;
        }

        if ($validatedData['interview_mode'] === 'offline') {
            $validatedData['meeting_link'] = null;
        }

        $validatedData['status'] = 'scheduled';

        $interview = $jobApplication
            ->interview()
            ->create($validatedData);

        $jobApplication->update([
            'application_status' => 'interview_scheduled',
        ]);

        if ($jobApplication->fresherProfile?->user_id) {
            $companyName = $jobApplication->job?->companyProfile?->company_name
                ?? 'Company';
            $jobTitle = $jobApplication->job?->title ?? 'your applied role';
            $scheduledFor = $interview->interview_date->format('d M Y')
                . ' at '
                . date('h:i A', strtotime($interview->interview_time));

            Notification::create([
                'user_id' => $jobApplication->fresherProfile->user_id,
                'type' => 'interview',
                'title' => 'Interview Scheduled',
                'message' => "{$companyName} scheduled your interview for {$jobTitle} on {$scheduledFor}. Join from your Interviews page.",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview scheduled successfully.',
            'data' => [
                'interview' => $interview,
                'application' => $jobApplication->fresh(),
            ],
        ], 201);
    }

    /**
     * Company interview ka status update karegi.
     */
    public function updateStatus(
        Request $request,
        Interview $interview
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'company') {
            return response()->json([
                'success' => false,
                'message' => 'Sirf company interview status update kar sakti hai.',
            ], 403);
        }

        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Company profile nahi mili.',
            ], 422);
        }

        $interview->load([
            'jobApplication.job',
        ]);

        if (
            $interview->jobApplication->job->company_profile_id
            !== $companyProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Aap is interview ka status update nahi kar sakte.',
            ], 403);
        }

        $validatedData = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'completed',
                    'cancelled',
                ]),
            ],

            'application_status' => [
                'nullable',
                Rule::in([
                    'hired',
                    'rejected',
                ]),
            ],
        ]);

        if (
            $validatedData['status'] === 'completed' &&
            empty($validatedData['application_status'])
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Completed interview ke saath hired ya rejected status dena required hai.',
            ], 422);
        }

        $interview->update([
            'status' => $validatedData['status'],
        ]);

        if ($validatedData['status'] === 'completed') {
            $interview->jobApplication->update([
                'application_status' =>
                    $validatedData['application_status'],
            ]);
        }

        if ($validatedData['status'] === 'cancelled') {
            $interview->jobApplication->update([
                'application_status' => 'shortlisted',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Interview status updated successfully.',
            'data' => [
                'interview' => $interview->fresh(),
                'application' =>
                    $interview->jobApplication->fresh(),
            ],
        ]);
    }
}
