<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentAttempt;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use App\Models\CourseEnrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FresherFinalAssessmentController extends Controller
{
    private const PASS_PERCENTAGE = 60;

    private const MAX_ATTEMPTS = 3;

    /**
     * Completed training ke liye final assessment attempt start karega.
     */
    public function start(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can start the final assessment.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if (
            $courseEnrollment->fresher_profile_id
            !== $fresherProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this enrollment.',
            ], 403);
        }

        if ($courseEnrollment->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Final assessment is available only after successful payment.',
            ], 422);
        }

        if (
            $courseEnrollment->training_status !== 'completed'
            || $courseEnrollment->enrollment_status !== 'completed'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Complete the training before starting the final assessment.',
            ], 422);
        }

        $activeQuestionsCount = AssessmentQuestion::query()
            ->where('assessment_type', 'final')
            ->where('is_active', true)
            ->count();

        if ($activeQuestionsCount === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No active final assessment questions are available.',
            ], 422);
        }

        $passedAttempt = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('course_enrollment_id', $courseEnrollment->id)
            ->where('assessment_type', 'final')
            ->whereHas('result', function ($query) {
                $query->where('result', 'pass');
            })
            ->with('result')
            ->first();

        if ($passedAttempt) {
            return response()->json([
                'success' => false,
                'message' => 'You have already passed this final assessment.',
                'data' => [
                    'attempt' => $passedAttempt,
                ],
            ], 422);
        }

        $inProgressAttempt = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('course_enrollment_id', $courseEnrollment->id)
            ->where('assessment_type', 'final')
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if ($inProgressAttempt) {
            return response()->json([
                'success' => true,
                'message' => 'Your final assessment is already in progress.',
                'data' => [
                    'attempt' => $inProgressAttempt,
                    'total_questions' => $activeQuestionsCount,
                    'pass_percentage' => self::PASS_PERCENTAGE,
                    'maximum_attempts' => self::MAX_ATTEMPTS,
                ],
            ]);
        }

        $attemptsUsed = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('course_enrollment_id', $courseEnrollment->id)
            ->where('assessment_type', 'final')
            ->count();

        if ($attemptsUsed >= self::MAX_ATTEMPTS) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum final assessment attempts have been used.',
                'data' => [
                    'attempts_used' => $attemptsUsed,
                    'maximum_attempts' => self::MAX_ATTEMPTS,
                ],
            ], 422);
        }

        $attempt = AssessmentAttempt::create([
            'fresher_profile_id' => $fresherProfile->id,
            'course_enrollment_id' => $courseEnrollment->id,
            'assessment_type' => 'final',
            'started_at' => now(),
            'submitted_at' => null,
            'status' => 'in_progress',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Final assessment started successfully.',
            'data' => [
                'attempt' => $attempt,
                'attempt_number' => $attemptsUsed + 1,
                'total_questions' => $activeQuestionsCount,
                'pass_percentage' => self::PASS_PERCENTAGE,
                'maximum_attempts' => self::MAX_ATTEMPTS,
            ],
        ], 201);
    }

    /**
     * Final assessment ke active questions fetch karega.
     */
    public function questions(
        Request $request,
        AssessmentAttempt $attempt
    ): JsonResponse {
        $ownershipError = $this->validateAttemptOwnership(
            $request,
            $attempt
        );

        if ($ownershipError) {
            return $ownershipError;
        }

        if ($attempt->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'This final assessment has already been submitted.',
            ], 422);
        }

        $questions = AssessmentQuestion::query()
            ->where('assessment_type', 'final')
            ->where('is_active', true)
            ->select([
                'id',
                'category',
                'question',
                'option_a',
                'option_b',
                'option_c',
                'option_d',
            ])
            ->orderBy('id')
            ->get();

        if ($questions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No active final assessment questions are available.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Final assessment questions fetched successfully.',
            'data' => [
                'attempt' => $attempt,
                'total_questions' => $questions->count(),
                'questions' => $questions,
            ],
        ]);
    }

    /**
     * Answers submit karke score aur pass/fail result generate karega.
     */
    public function submit(
        Request $request,
        AssessmentAttempt $attempt
    ): JsonResponse {
        $ownershipError = $this->validateAttemptOwnership(
            $request,
            $attempt
        );

        if ($ownershipError) {
            return $ownershipError;
        }

        if ($attempt->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'This final assessment has already been submitted.',
            ], 422);
        }

        $validated = $request->validate([
            'answers' => [
                'required',
                'array',
                'min:1',
            ],
            'answers.*.question_id' => [
                'required',
                'integer',
                'distinct',
                'exists:assessment_questions,id',
            ],
            'answers.*.selected_option' => [
                'required',
                'string',
                Rule::in([
                    'A',
                    'B',
                    'C',
                    'D',
                ]),
            ],
        ]);

        $activeQuestions = AssessmentQuestion::query()
            ->where('assessment_type', 'final')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        if ($activeQuestions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No active final assessment questions are available.',
            ], 422);
        }

        $activeQuestionIds = $activeQuestions
            ->pluck('id')
            ->sort()
            ->values();

        $submittedQuestionIds = collect($validated['answers'])
            ->pluck('question_id')
            ->sort()
            ->values();

        if (
            $activeQuestionIds->all()
            !== $submittedQuestionIds->all()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Please answer all active final assessment questions.',
                'data' => [
                    'required_question_ids' => $activeQuestionIds,
                    'submitted_question_ids' => $submittedQuestionIds,
                ],
            ], 422);
        }

        $submittedAnswers = collect($validated['answers'])
            ->keyBy('question_id');

        $resultData = DB::transaction(function () use (
            $attempt,
            $activeQuestions,
            $submittedAnswers
        ) {
            $categoryTotals = [
                'technical' => 0,
                'aptitude' => 0,
                'communication' => 0,
            ];

            $categoryCorrect = [
                'technical' => 0,
                'aptitude' => 0,
                'communication' => 0,
            ];

            $totalCorrect = 0;

            foreach ($activeQuestions as $question) {
                $selectedOption = strtoupper(
                    $submittedAnswers[$question->id]['selected_option']
                );

                $isCorrect = $selectedOption
                    === strtoupper($question->correct_option);

                AssessmentAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_option' => $selectedOption,
                    'is_correct' => $isCorrect,
                ]);

                $categoryTotals[$question->category]++;

                if ($isCorrect) {
                    $categoryCorrect[$question->category]++;
                    $totalCorrect++;
                }
            }

            $technicalScore = $this->calculateCategoryScore(
                $categoryCorrect['technical'],
                $categoryTotals['technical']
            );

            $aptitudeScore = $this->calculateCategoryScore(
                $categoryCorrect['aptitude'],
                $categoryTotals['aptitude']
            );

            $communicationScore = $this->calculateCategoryScore(
                $categoryCorrect['communication'],
                $categoryTotals['communication']
            );

            $totalQuestions = $activeQuestions->count();

            $overallScore = round(
                ($totalCorrect / $totalQuestions) * 100,
                2
            );

            $resultStatus = $overallScore
                >= self::PASS_PERCENTAGE
                ? 'pass'
                : 'fail';

            $assessmentResult = AssessmentResult::create([
                'attempt_id' => $attempt->id,
                'technical_score' => $technicalScore,
                'aptitude_score' => $aptitudeScore,
                'communication_score' => $communicationScore,
                'overall_score' => $overallScore,
                'recommended_track' => null,
                'result' => $resultStatus,
            ]);

            $attempt->update([
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);

            return [
                'attempt' => $attempt->fresh(),
                'result' => $assessmentResult,
                'summary' => [
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $totalCorrect,
                    'wrong_answers' => $totalQuestions - $totalCorrect,
                    'pass_percentage' => self::PASS_PERCENTAGE,
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'message' => $resultData['result']->result === 'pass'
                ? 'Final assessment submitted successfully. You have passed.'
                : 'Final assessment submitted successfully. You did not pass.',
            'data' => $resultData,
        ]);
    }

    /**
     * Submitted final assessment ka result fetch karega.
     */
    public function result(
        Request $request,
        AssessmentAttempt $attempt
    ): JsonResponse {
        $ownershipError = $this->validateAttemptOwnership(
            $request,
            $attempt
        );

        if ($ownershipError) {
            return $ownershipError;
        }

        if ($attempt->status !== 'submitted') {
            return response()->json([
                'success' => false,
                'message' => 'Submit the final assessment before viewing the result.',
            ], 422);
        }

        $attempt->load([
            'result',
            'courseEnrollment.course.trainingPartnerProfile',
        ]);

        if (!$attempt->result) {
            return response()->json([
                'success' => false,
                'message' => 'Final assessment result not found.',
            ], 404);
        }

        $totalQuestions = $attempt->answers()->count();

        $correctAnswers = $attempt->answers()
            ->where('is_correct', true)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'Final assessment result fetched successfully.',
            'data' => [
                'attempt' => $attempt,
                'summary' => [
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correctAnswers,
                    'wrong_answers' => $totalQuestions - $correctAnswers,
                    'pass_percentage' => self::PASS_PERCENTAGE,
                    'attempt_result' => $attempt->result->result,
                ],
            ],
        ]);
    }

    /**
     * Attempt logged-in fresher ka hai ya nahi verify karega.
     */
    private function validateAttemptOwnership(
        Request $request,
        AssessmentAttempt $attempt
    ): ?JsonResponse {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access the final assessment.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if (
            $attempt->fresher_profile_id
            !== $fresherProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this assessment attempt.',
            ], 403);
        }

        if ($attempt->assessment_type !== 'final') {
            return response()->json([
                'success' => false,
                'message' => 'This is not a final assessment attempt.',
            ], 422);
        }

        if (!$attempt->course_enrollment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Final assessment is not linked to a course enrollment.',
            ], 422);
        }

        return null;
    }

    /**
     * Individual category ka percentage calculate karega.
     */
    private function calculateCategoryScore(
        int $correctAnswers,
        int $totalQuestions
    ): float {
        if ($totalQuestions === 0) {
            return 0;
        }

        return round(
            ($correctAnswers / $totalQuestions) * 100,
            2
        );
    }
}