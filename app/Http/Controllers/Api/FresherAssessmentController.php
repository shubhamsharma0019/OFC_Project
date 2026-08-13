<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentAttempt;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FresherAssessmentController extends Controller
{
    private const PASS_PERCENTAGE = 60;

    /**
     * Admin ke liye assessment questions ki list.
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'assessment_type' => [
                'nullable',
                Rule::in(['initial', 'final']),
            ],

            'category' => [
                'nullable',
                Rule::in([
                    'technical',
                    'aptitude',
                    'communication',
                ]),
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $questions = AssessmentQuestion::query()
            ->when(
                isset($validated['assessment_type']),
                fn ($query) => $query->where(
                    'assessment_type',
                    $validated['assessment_type']
                )
            )
            ->when(
                isset($validated['category']),
                fn ($query) => $query->where(
                    'category',
                    $validated['category']
                )
            )
            ->when(
                array_key_exists('is_active', $validated),
                fn ($query) => $query->where(
                    'is_active',
                    $validated['is_active']
                )
            )
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Assessment questions fetched successfully.',
            'data' => [
                'questions' => $questions,
            ],
        ]);
    }

    /**
     * Naya assessment question create karega.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'assessment_type' => [
                'required',
                'string',
                Rule::in(['initial', 'final']),
            ],

            'category' => [
                'required',
                'string',
                Rule::in([
                    'technical',
                    'aptitude',
                    'communication',
                ]),
            ],

            'question' => [
                'required',
                'string',
                'max:1000',
            ],

            'option_a' => [
                'required',
                'string',
                'max:500',
            ],

            'option_b' => [
                'required',
                'string',
                'max:500',
            ],

            'option_c' => [
                'required',
                'string',
                'max:500',
            ],

            'option_d' => [
                'required',
                'string',
                'max:500',
            ],

            'correct_option' => [
                'required',
                'string',
                Rule::in(['A', 'B', 'C', 'D']),
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        $question = AssessmentQuestion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Assessment question created successfully.',
            'data' => [
                'question' => $question,
            ],
        ], 201);
    }

    /**
     * Existing assessment question update karega.
     */
    public function update(
        Request $request,
        AssessmentQuestion $question
    ): JsonResponse {
        $validated = $request->validate([
            'assessment_type' => [
                'sometimes',
                'string',
                Rule::in(['initial', 'final']),
            ],

            'category' => [
                'sometimes',
                'string',
                Rule::in([
                    'technical',
                    'aptitude',
                    'communication',
                ]),
            ],

            'question' => [
                'sometimes',
                'string',
                'max:1000',
            ],

            'option_a' => [
                'sometimes',
                'string',
                'max:500',
            ],

            'option_b' => [
                'sometimes',
                'string',
                'max:500',
            ],

            'option_c' => [
                'sometimes',
                'string',
                'max:500',
            ],

            'option_d' => [
                'sometimes',
                'string',
                'max:500',
            ],

            'correct_option' => [
                'sometimes',
                'string',
                Rule::in(['A', 'B', 'C', 'D']),
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        if (empty($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide at least one field to update.',
            ], 422);
        }

        $question->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Assessment question updated successfully.',
            'data' => [
                'question' => $question->fresh(),
            ],
        ]);
    }

    public function start(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user || $user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can start the assessment.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your fresher profile first.',
            ], 422);
        }

        $activeQuestionsCount = AssessmentQuestion::query()
            ->whereIn('id', $this->activeInitialQuestions()->pluck('id'))
            ->count();

        if ($activeQuestionsCount === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No active initial assessment questions are available.',
            ], 422);
        }

        $inProgressAttempt = AssessmentAttempt::query()
            ->where('fresher_profile_id', $fresherProfile->id)
            ->where('assessment_type', 'initial')
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if ($inProgressAttempt) {
            return response()->json([
                'success' => true,
                'message' => 'Your assessment is already in progress.',
                'data' => [
                    'attempt' => $inProgressAttempt,
                    'total_questions' => $activeQuestionsCount,
                    'pass_percentage' => self::PASS_PERCENTAGE,
                ],
            ]);
        }

        $attempt = AssessmentAttempt::create([
            'fresher_profile_id' => $fresherProfile->id,
            'assessment_type' => 'initial',
            'started_at' => now(),
            'submitted_at' => null,
            'status' => 'in_progress',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Initial assessment started successfully.',
            'data' => [
                'attempt' => $attempt,
                'total_questions' => $activeQuestionsCount,
                'pass_percentage' => self::PASS_PERCENTAGE,
            ],
        ], 201);
    }

    public function questions(Request $request, AssessmentAttempt $attempt): JsonResponse
    {
        $ownershipError = $this->validateAttemptOwnership($request, $attempt);

        if ($ownershipError) {
            return $ownershipError;
        }

        if ($attempt->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'This assessment has already been submitted.',
            ], 422);
        }

        $questions = $this->activeInitialQuestions()
            ->map
            ->only(['id', 'category', 'question', 'option_a', 'option_b', 'option_c', 'option_d'])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Initial assessment questions fetched successfully.',
            'data' => [
                'attempt' => $attempt,
                'total_questions' => $questions->count(),
                'questions' => $questions,
            ],
        ]);
    }

    public function submit(Request $request, AssessmentAttempt $attempt): JsonResponse
    {
        $ownershipError = $this->validateAttemptOwnership($request, $attempt);

        if ($ownershipError) {
            return $ownershipError;
        }

        if ($attempt->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'This assessment has already been submitted.',
            ], 422);
        }

        $validated = $request->validate([
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.question_id' => ['required', 'integer', 'distinct', 'exists:assessment_questions,id'],
            'answers.*.selected_option' => ['required', 'string', Rule::in(['A', 'B', 'C', 'D'])],
        ]);

        $activeQuestions = $this->activeInitialQuestions();

        $activeQuestionIds = $activeQuestions->pluck('id')->sort()->values();
        $submittedQuestionIds = collect($validated['answers'])->pluck('question_id')->sort()->values();

        if ($activeQuestionIds->all() !== $submittedQuestionIds->all()) {
            return response()->json([
                'success' => false,
                'message' => 'Please answer all active assessment questions.',
            ], 422);
        }

        $submittedAnswers = collect($validated['answers'])->keyBy('question_id');

        $resultData = DB::transaction(function () use ($attempt, $activeQuestions, $submittedAnswers) {
            $categoryTotals = ['technical' => 0, 'aptitude' => 0, 'communication' => 0];
            $categoryCorrect = ['technical' => 0, 'aptitude' => 0, 'communication' => 0];
            $totalCorrect = 0;

            foreach ($activeQuestions as $question) {
                $selectedOption = strtoupper($submittedAnswers[$question->id]['selected_option']);
                $isCorrect = $selectedOption === strtoupper($question->correct_option);

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

            $technicalScore = $this->calculateCategoryScore($categoryCorrect['technical'], $categoryTotals['technical']);
            $aptitudeScore = $this->calculateCategoryScore($categoryCorrect['aptitude'], $categoryTotals['aptitude']);
            $communicationScore = $this->calculateCategoryScore($categoryCorrect['communication'], $categoryTotals['communication']);
            $overallScore = round(($totalCorrect / max(1, $activeQuestions->count())) * 100, 2);

            $result = AssessmentResult::create([
                'attempt_id' => $attempt->id,
                'technical_score' => $technicalScore,
                'aptitude_score' => $aptitudeScore,
                'communication_score' => $communicationScore,
                'overall_score' => $overallScore,
                'recommended_track' => $this->recommendedTrack($technicalScore, $aptitudeScore, $communicationScore),
                'result' => $overallScore >= self::PASS_PERCENTAGE ? 'pass' : 'fail',
            ]);

            $attempt->update([
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);

            return [
                'attempt' => $attempt->fresh(),
                'result' => $result,
                'summary' => [
                    'total_questions' => $activeQuestions->count(),
                    'correct_answers' => $totalCorrect,
                    'wrong_answers' => $activeQuestions->count() - $totalCorrect,
                    'pass_percentage' => self::PASS_PERCENTAGE,
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Initial assessment submitted successfully.',
            'data' => $resultData,
        ]);
    }

    public function result(Request $request, AssessmentAttempt $attempt): JsonResponse
    {
        $ownershipError = $this->validateAttemptOwnership($request, $attempt);

        if ($ownershipError) {
            return $ownershipError;
        }

        if ($attempt->status !== 'submitted') {
            return response()->json([
                'success' => false,
                'message' => 'Submit the assessment before viewing result.',
            ], 422);
        }

        $attempt->load(['result', 'answers.question']);

        return response()->json([
            'success' => true,
            'message' => 'Initial assessment result fetched successfully.',
            'data' => [
                'attempt' => $attempt,
                'result' => $attempt->result,
                'answers' => $attempt->answers,
            ],
        ]);
    }

    private function validateAttemptOwnership(Request $request, AssessmentAttempt $attempt): ?JsonResponse
    {
        $user = $request->user();
        $fresherProfile = $user?->fresherProfile;

        if (!$user || $user->role !== 'fresher' || !$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access this assessment.',
            ], 403);
        }

        if ($attempt->fresher_profile_id !== $fresherProfile->id || $attempt->assessment_type !== 'initial') {
            return response()->json([
                'success' => false,
                'message' => 'This assessment attempt does not belong to you.',
            ], 403);
        }

        return null;
    }

    private function calculateCategoryScore(int $correct, int $total): float
    {
        if ($total === 0) {
            return 0;
        }

        return round(($correct / $total) * 100, 2);
    }

    private function recommendedTrack(float $technical, float $aptitude, float $communication): string
    {
        $lowest = min($technical, $aptitude, $communication);

        return match ($lowest) {
            $technical => 'Full Stack Development',
            $aptitude => 'Aptitude Booster',
            default => 'Communication Skills',
        };
    }

    private function activeInitialQuestions()
    {
        $this->ensureDefaultInitialQuestions();

        $questions = AssessmentQuestion::query()
            ->where('assessment_type', 'initial')
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        $duplicateTexts = $questions
            ->groupBy(fn ($question) => $this->normalizeQuestionText($question->question))
            ->filter(fn ($group) => $group->pluck('category')->unique()->count() > 1)
            ->keys();

        if ($duplicateTexts->isEmpty()) {
            return $questions;
        }

        return $questions
            ->reject(fn ($question) => $duplicateTexts->contains($this->normalizeQuestionText($question->question)))
            ->values();
    }

    private function normalizeQuestionText(string $question): string
    {
        return trim(preg_replace('/\s+/', ' ', strtolower($question)));
    }

    private function ensureDefaultInitialQuestions(): void
    {
        foreach ($this->defaultInitialQuestions() as $category => $questions) {
            $activeCount = AssessmentQuestion::query()
                ->where('assessment_type', 'initial')
                ->where('category', $category)
                ->where('is_active', true)
                ->count();

            if ($activeCount >= 3) {
                continue;
            }

            foreach ($questions as $question) {
                AssessmentQuestion::firstOrCreate(
                    [
                        'assessment_type' => 'initial',
                        'category' => $category,
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

    private function defaultInitialQuestions(): array
    {
        return [
            'technical' => [
                [
                    'question' => 'Which HTML tag is used to create a hyperlink?',
                    'option_a' => '<a>',
                    'option_b' => '<link>',
                    'option_c' => '<href>',
                    'option_d' => '<url>',
                    'correct_option' => 'A',
                ],
                [
                    'question' => 'Which SQL command is used to fetch records from a table?',
                    'option_a' => 'INSERT',
                    'option_b' => 'SELECT',
                    'option_c' => 'UPDATE',
                    'option_d' => 'DELETE',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'What does CSS mainly control on a web page?',
                    'option_a' => 'Database queries',
                    'option_b' => 'Server routing',
                    'option_c' => 'Visual styling',
                    'option_d' => 'Password hashing',
                    'correct_option' => 'C',
                ],
            ],
            'aptitude' => [
                [
                    'question' => 'If 5 workers finish a task in 10 days, how many worker-days are needed?',
                    'option_a' => '15',
                    'option_b' => '25',
                    'option_c' => '50',
                    'option_d' => '100',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'Find the next number in the series: 2, 4, 8, 16, ?',
                    'option_a' => '20',
                    'option_b' => '24',
                    'option_c' => '30',
                    'option_d' => '32',
                    'correct_option' => 'D',
                ],
                [
                    'question' => 'A product marked at 1000 is sold at 10% discount. What is the selling price?',
                    'option_a' => '800',
                    'option_b' => '850',
                    'option_c' => '900',
                    'option_d' => '950',
                    'correct_option' => 'C',
                ],
            ],
            'communication' => [
                [
                    'question' => 'Choose the correctly written sentence.',
                    'option_a' => 'She go to office daily.',
                    'option_b' => 'She goes to office daily.',
                    'option_c' => 'She going office daily.',
                    'option_d' => 'She gone to office daily.',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Which phrase is best for a polite professional email closing?',
                    'option_a' => 'Reply fast',
                    'option_b' => 'Do it now',
                    'option_c' => 'Thanks and regards',
                    'option_d' => 'Whatever',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'What is the main purpose of active listening?',
                    'option_a' => 'To interrupt quickly',
                    'option_b' => 'To understand the speaker clearly',
                    'option_c' => 'To avoid responding',
                    'option_d' => 'To change the topic',
                    'correct_option' => 'B',
                ],
            ],
        ];
    }
}
