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

        $courseEnrollment->load(['course', 'trainingProgress']);

        if ($courseEnrollment->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Final assessment is available only after successful payment.',
            ], 422);
        }

        $hasCompletedTrainingProgress = $courseEnrollment->trainingProgress
            && $courseEnrollment->trainingProgress->progress_percentage >= 100;

        $hasCompletedTrainingStatus =
            $courseEnrollment->training_status === 'completed'
            && $courseEnrollment->enrollment_status === 'completed';

        if (!$hasCompletedTrainingProgress && !$hasCompletedTrainingStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Complete the training before starting the final assessment.',
            ], 422);
        }

        if ($hasCompletedTrainingProgress && !$hasCompletedTrainingStatus) {
            $courseEnrollment->update([
                'training_status' => 'completed',
                'enrollment_status' => 'completed',
            ]);
        }

        $activeQuestionsCount = $this
            ->activeFinalQuestions($this->assessmentTrack($courseEnrollment, $fresherProfile))
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

        $attempt->loadMissing(['courseEnrollment.course', 'fresherProfile']);

        $questions = $this->activeFinalQuestions(
            $this->assessmentTrack($attempt->courseEnrollment, $attempt->fresherProfile)
        )
            ->map
            ->only([
                'id',
                'category',
                'job_category',
                'question',
                'option_a',
                'option_b',
                'option_c',
                'option_d',
            ])
            ->values();

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

        $attempt->loadMissing(['courseEnrollment.course', 'fresherProfile']);

        $activeQuestions = $this->activeFinalQuestions(
            $this->assessmentTrack($attempt->courseEnrollment, $attempt->fresherProfile)
        );

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

    private function activeFinalQuestions(?string $jobCategory = null)
    {
        $this->ensureDefaultFinalQuestions();

        $baseQuery = AssessmentQuestion::query()
            ->where('assessment_type', 'final')
            ->where('is_active', true);

        if (filled($jobCategory)) {
            $preferredQuestions = (clone $baseQuery)
                ->where(function ($query) use ($jobCategory) {
                    $query
                        ->where('job_category', $jobCategory)
                        ->orWhereNull('job_category');
                })
                ->orderByRaw('job_category IS NULL')
                ->orderBy('category')
                ->orderBy('id')
                ->get();

            if ($preferredQuestions->isNotEmpty()) {
                return $this->preferRoleQuestionsByCategory($preferredQuestions);
            }
        }

        return $baseQuery
            ->whereNull('job_category')
            ->orderBy('category')
            ->orderBy('id')
            ->get();
    }

    private function assessmentTrack(
        ?CourseEnrollment $courseEnrollment,
        $fresherProfile
    ): ?string {
        $course = $courseEnrollment?->course;
        $text = strtolower(trim(implode(' ', array_filter([
            $fresherProfile?->preferred_job_category,
            $course?->course_name,
            $course?->category,
            $course?->skills_covered,
            $course?->description,
        ]))));

        return match (true) {
            str_contains($text, 'data') ||
                str_contains($text, 'sql') ||
                str_contains($text, 'excel') ||
                str_contains($text, 'analytics') ||
                str_contains($text, 'power bi') => 'Data Analyst',
            str_contains($text, 'ui') ||
                str_contains($text, 'ux') ||
                str_contains($text, 'figma') ||
                str_contains($text, 'designer') => 'UI/UX Designer',
            str_contains($text, 'marketing') ||
                str_contains($text, 'seo') ||
                str_contains($text, 'social media') => 'Digital Marketing',
            str_contains($text, 'software') ||
                str_contains($text, 'developer') ||
                str_contains($text, 'laravel') ||
                str_contains($text, 'react') ||
                str_contains($text, 'python') ||
                str_contains($text, 'php') => 'Software Developer',
            default => $fresherProfile?->preferred_job_category,
        };
    }

    private function preferRoleQuestionsByCategory($questions)
    {
        $roleCategories = $questions
            ->filter(fn ($question) => filled($question->job_category))
            ->pluck('category')
            ->unique();

        if ($roleCategories->isEmpty()) {
            return $questions;
        }

        return $questions
            ->reject(fn ($question) => blank($question->job_category) && $roleCategories->contains($question->category))
            ->values();
    }

    private function ensureDefaultFinalQuestions(): void
    {
        foreach ($this->defaultRoleFinalQuestions() as $question) {
            AssessmentQuestion::firstOrCreate(
                [
                    'assessment_type' => 'final',
                    'category' => $question['category'],
                    'job_category' => $question['job_category'],
                    'question' => $question['question'],
                ],
                [
                    'option_a' => $question['option_a'],
                    'option_b' => $question['option_b'],
                    'option_c' => $question['option_c'],
                    'option_d' => $question['option_d'],
                    'correct_option' => $question['correct_option'],
                    'is_active' => true,
                ]
            );
        }

        foreach ($this->defaultFinalQuestions() as $category => $questions) {
            $activeCount = AssessmentQuestion::query()
                ->where('assessment_type', 'final')
                ->where('category', $category)
                ->whereNull('job_category')
                ->where('is_active', true)
                ->count();

            if ($activeCount >= 3) {
                continue;
            }

            foreach ($questions as $question) {
                AssessmentQuestion::firstOrCreate(
                    [
                        'assessment_type' => 'final',
                        'category' => $category,
                        'job_category' => null,
                        'question' => $question['question'],
                    ],
                    [
                        'option_a' => $question['option_a'],
                        'option_b' => $question['option_b'],
                        'option_c' => $question['option_c'],
                        'option_d' => $question['option_d'],
                        'correct_option' => $question['correct_option'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function defaultFinalQuestions(): array
    {
        return [
            'technical' => [
                [
                    'question' => 'Which Laravel command is commonly used to run database migrations?',
                    'option_a' => 'php artisan migrate',
                    'option_b' => 'php artisan serve',
                    'option_c' => 'php artisan route:list',
                    'option_d' => 'php artisan cache:clear',
                    'correct_option' => 'A',
                ],
                [
                    'question' => 'In a relational database, what does a foreign key usually represent?',
                    'option_a' => 'A password field',
                    'option_b' => 'A relationship with another table',
                    'option_c' => 'A frontend component',
                    'option_d' => 'A browser cache value',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Which HTTP method is generally used to update an existing resource?',
                    'option_a' => 'GET',
                    'option_b' => 'POST',
                    'option_c' => 'PATCH',
                    'option_d' => 'HEAD',
                    'correct_option' => 'C',
                ],
            ],
            'aptitude' => [
                [
                    'question' => 'A course has 40 lessons. If 75% are completed, how many lessons are done?',
                    'option_a' => '20',
                    'option_b' => '25',
                    'option_c' => '30',
                    'option_d' => '35',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'If a task takes 6 hours for 3 people, how many person-hours are required?',
                    'option_a' => '9',
                    'option_b' => '12',
                    'option_c' => '18',
                    'option_d' => '24',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'Find the missing number: 3, 6, 12, 24, ?',
                    'option_a' => '30',
                    'option_b' => '36',
                    'option_c' => '42',
                    'option_d' => '48',
                    'correct_option' => 'D',
                ],
            ],
            'communication' => [
                [
                    'question' => 'Which response is most professional after receiving interview instructions?',
                    'option_a' => 'Ok',
                    'option_b' => 'I will try',
                    'option_c' => 'Thank you, I confirm my availability.',
                    'option_d' => 'Why so early?',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'What should a fresher do when they do not know an interview answer?',
                    'option_a' => 'Stay silent',
                    'option_b' => 'Guess confidently without logic',
                    'option_c' => 'Explain what they know and ask for clarification',
                    'option_d' => 'End the interview',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'Which email subject is clearer for sending a resume?',
                    'option_a' => 'Hi',
                    'option_b' => 'Resume - Web Developer Application - Your Name',
                    'option_c' => 'Please check',
                    'option_d' => 'Urgent',
                    'correct_option' => 'B',
                ],
            ],
        ];
    }

    private function defaultRoleFinalQuestions(): array
    {
        return [
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'In a sales dataset, which SQL function would you use to calculate total revenue?',
                'option_a' => 'COUNT',
                'option_b' => 'SUM',
                'option_c' => 'LOWER',
                'option_d' => 'ROUND',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which step should come before building a dashboard from raw data?',
                'option_a' => 'Ignore missing values',
                'option_b' => 'Clean and validate the data',
                'option_c' => 'Delete every column',
                'option_d' => 'Publish without review',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'What does a pivot table help you do?',
                'option_a' => 'Summarize and group data',
                'option_b' => 'Encrypt passwords',
                'option_c' => 'Write CSS styles',
                'option_d' => 'Deploy APIs',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which practice helps make code easier to maintain?',
                'option_a' => 'Clear naming and small functions',
                'option_b' => 'Duplicating every file',
                'option_c' => 'Removing all tests',
                'option_d' => 'Hardcoding every secret',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'What is the main purpose of a database transaction?',
                'option_a' => 'Group operations so they succeed or fail together',
                'option_b' => 'Change text color',
                'option_c' => 'Resize images',
                'option_d' => 'Clear browser history',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which response code commonly means validation failed in an API?',
                'option_a' => '200',
                'option_b' => '301',
                'option_c' => '422',
                'option_d' => '500',
                'correct_option' => 'C',
            ],
        ];
    }
}
