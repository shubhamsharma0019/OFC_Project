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
    private const QUESTIONS_PER_CATEGORY = 10;

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

        $assessmentTrack = $this->assessmentTrack($fresherProfile);

        $activeQuestionsCount = $this
            ->activeInitialQuestions($assessmentTrack)
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
                    'assessment_track' => $assessmentTrack,
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
                'assessment_track' => $assessmentTrack,
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

        $fresherProfile = $request->user()?->fresherProfile;
        $assessmentTrack = $this->assessmentTrack($fresherProfile);

        $questions = $this
            ->activeInitialQuestions($assessmentTrack)
            ->map
            ->only(['id', 'category', 'job_category', 'question', 'option_a', 'option_b', 'option_c', 'option_d'])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Initial assessment questions fetched successfully.',
            'data' => [
                'attempt' => $attempt,
                'total_questions' => $questions->count(),
                'assessment_track' => $assessmentTrack,
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

        $activeQuestions = $this
            ->activeInitialQuestions($this->assessmentTrack($request->user()?->fresherProfile));

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

    private function activeInitialQuestions(?string $jobCategory = null)
    {
        $this->ensureDefaultInitialQuestions();

        $jobCategory = $this->canonicalAssessmentTrack($jobCategory);

        $baseQuery = AssessmentQuestion::query()
            ->where('assessment_type', 'initial')
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
                $questions = $preferredQuestions;
            }
        }

        $questions ??= $baseQuery
            ->whereNull('job_category')
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        $questions = $this->limitInitialQuestionSet($questions, $jobCategory);

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

    private function limitInitialQuestionSet($questions, ?string $jobCategory)
    {
        return collect(['technical', 'aptitude', 'communication'])
            ->flatMap(function (string $category) use ($questions, $jobCategory) {
                $categoryQuestions = $questions->where('category', $category);

                if ($category === 'technical' && filled($jobCategory)) {
                    $roleQuestions = $categoryQuestions
                        ->where('job_category', $jobCategory)
                        ->take(self::QUESTIONS_PER_CATEGORY);

                    if ($roleQuestions->count() >= self::QUESTIONS_PER_CATEGORY) {
                        return $roleQuestions;
                    }

                    return $roleQuestions
                        ->merge($categoryQuestions->whereNull('job_category'))
                        ->take(self::QUESTIONS_PER_CATEGORY);
                }

                return $categoryQuestions
                    ->whereNull('job_category')
                    ->take(self::QUESTIONS_PER_CATEGORY);
            })
            ->values();
    }

    private function normalizeQuestionText(string $question): string
    {
        return trim(preg_replace('/\s+/', ' ', strtolower($question)));
    }

    private function assessmentTrack($fresherProfile): ?string
    {
        $latestEnrollment = $fresherProfile?->courseEnrollments()
            ->with('course')
            ->latest()
            ->first();

        $course = $latestEnrollment?->course;

        foreach ([
            implode(' ', array_filter([
                $course?->course_name,
                $course?->category,
                $course?->skills_covered,
                $course?->description,
            ])),
            $fresherProfile?->preferred_job_category,
            $fresherProfile?->skills,
        ] as $trackSource) {
            $track = $this->canonicalAssessmentTrack($trackSource);

            if (filled($track)) {
                return $track;
            }
        }

        return null;
    }

    private function canonicalAssessmentTrack(?string $value): ?string
    {
        $text = strtolower(trim((string) $value));

        if ($text === '') {
            return null;
        }

        return match (true) {
            str_contains($text, 'data') ||
                str_contains($text, 'analytics') ||
                str_contains($text, 'analyst') ||
                str_contains($text, 'sql') ||
                str_contains($text, 'excel') ||
                str_contains($text, 'power bi') ||
                str_contains($text, 'dashboard') => 'Data Analyst',
            str_contains($text, 'tester') ||
                str_contains($text, 'testing') ||
                str_contains($text, 'qa') ||
                str_contains($text, 'quality assurance') => 'Software Tester / QA',
            str_contains($text, 'software') ||
                str_contains($text, 'developer') ||
                str_contains($text, 'development') ||
                str_contains($text, 'full stack') ||
                str_contains($text, 'frontend') ||
                str_contains($text, 'backend') ||
                str_contains($text, 'web dev') ||
                str_contains($text, 'laravel') ||
                str_contains($text, 'react') ||
                str_contains($text, 'php') ||
                str_contains($text, 'python') ||
                str_contains($text, 'java') => 'Software Developer',
            str_contains($text, 'ui') ||
                str_contains($text, 'ux') ||
                str_contains($text, 'figma') ||
                str_contains($text, 'designer') => 'UI/UX Designer',
            str_contains($text, 'marketing') ||
                str_contains($text, 'seo') ||
                str_contains($text, 'social media') => 'Digital Marketing',
            default => trim((string) $value),
        };
    }

    private function ensureDefaultInitialQuestions(): void
    {
        foreach ($this->defaultRoleInitialQuestions() as $question) {
            AssessmentQuestion::firstOrCreate(
                [
                    'assessment_type' => 'initial',
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

        foreach ($this->defaultInitialQuestions() as $category => $questions) {
            $activeCount = AssessmentQuestion::query()
                ->where('assessment_type', 'initial')
                ->where('category', $category)
                ->whereNull('job_category')
                ->where('is_active', true)
                ->count();

            if ($activeCount >= self::QUESTIONS_PER_CATEGORY) {
                continue;
            }

            foreach ($questions as $question) {
                AssessmentQuestion::firstOrCreate(
                    [
                        'assessment_type' => 'initial',
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
                [
                    'question' => 'What is 20% of 250?',
                    'option_a' => '25',
                    'option_b' => '40',
                    'option_c' => '50',
                    'option_d' => '60',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'The ratio of boys to girls is 3:2. If there are 30 boys, how many girls are there?',
                    'option_a' => '10',
                    'option_b' => '15',
                    'option_c' => '20',
                    'option_d' => '25',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'Find the average of 12, 18, 24, and 30.',
                    'option_a' => '18',
                    'option_b' => '20',
                    'option_c' => '21',
                    'option_d' => '24',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'A shopkeeper buys an item for 500 and sells it for 600. What is the profit percentage?',
                    'option_a' => '10%',
                    'option_b' => '15%',
                    'option_c' => '20%',
                    'option_d' => '25%',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'A car travels 120 km in 3 hours. What is its speed?',
                    'option_a' => '30 km/h',
                    'option_b' => '40 km/h',
                    'option_c' => '50 km/h',
                    'option_d' => '60 km/h',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Simple interest on 1000 at 5% per annum for 2 years is:',
                    'option_a' => '50',
                    'option_b' => '100',
                    'option_c' => '150',
                    'option_d' => '200',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'What is 15 multiplied by 12?',
                    'option_a' => '160',
                    'option_b' => '170',
                    'option_c' => '180',
                    'option_d' => '190',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'If x = 5, what is the value of 2x + 3?',
                    'option_a' => '8',
                    'option_b' => '10',
                    'option_c' => '13',
                    'option_d' => '15',
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
                [
                    'question' => 'Choose the synonym of "brief".',
                    'option_a' => 'Long',
                    'option_b' => 'Short',
                    'option_c' => 'Heavy',
                    'option_d' => 'Complex',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Choose the antonym of "polite".',
                    'option_a' => 'Respectful',
                    'option_b' => 'Kind',
                    'option_c' => 'Rude',
                    'option_d' => 'Gentle',
                    'correct_option' => 'C',
                ],
                [
                    'question' => 'Which is the most professional email greeting?',
                    'option_a' => 'Hey bro',
                    'option_b' => 'Dear Mr. Sharma',
                    'option_c' => 'Yo',
                    'option_d' => 'Listen',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Which body language shows confidence in a meeting?',
                    'option_a' => 'Avoiding eye contact always',
                    'option_b' => 'Standing straight and maintaining appropriate eye contact',
                    'option_c' => 'Looking at the phone constantly',
                    'option_d' => 'Speaking with your back turned',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Choose the correct sentence.',
                    'option_a' => 'They is working on the project.',
                    'option_b' => 'They are working on the project.',
                    'option_c' => 'They am working on the project.',
                    'option_d' => 'They be working on the project.',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'If you do not understand a task, what should you do?',
                    'option_a' => 'Guess and submit anything',
                    'option_b' => 'Ask for clarification politely',
                    'option_c' => 'Ignore the task',
                    'option_d' => 'Blame others',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Which closing is most appropriate for a professional email?',
                    'option_a' => 'Bye forever',
                    'option_b' => 'Regards',
                    'option_c' => 'See ya',
                    'option_d' => 'Later',
                    'correct_option' => 'B',
                ],
                [
                    'question' => 'Choose the correct word: The manager gave us useful ____.',
                    'option_a' => 'advise',
                    'option_b' => 'advice',
                    'option_c' => 'advices',
                    'option_d' => 'advising',
                    'correct_option' => 'B',
                ],
            ],
        ];
    }

    private function defaultRoleInitialQuestions(): array
    {
        return [
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which SQL clause is used to group rows for aggregate analysis?',
                'option_a' => 'ORDER BY',
                'option_b' => 'GROUP BY',
                'option_c' => 'WHERE',
                'option_d' => 'LIMIT',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which chart is best suited to show a trend over time?',
                'option_a' => 'Line chart',
                'option_b' => 'Pie chart',
                'option_c' => 'Donut chart',
                'option_d' => 'Treemap',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'What does data cleaning mainly help with?',
                'option_a' => 'Adding duplicate rows',
                'option_b' => 'Improving data quality before analysis',
                'option_c' => 'Removing every numeric value',
                'option_d' => 'Changing database passwords',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which Excel function is used to calculate the average of numbers?',
                'option_a' => 'SUM',
                'option_b' => 'COUNT',
                'option_c' => 'AVERAGE',
                'option_d' => 'MAX',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which SQL clause is used to sort query results?',
                'option_a' => 'GROUP BY',
                'option_b' => 'ORDER BY',
                'option_c' => 'WHERE',
                'option_d' => 'HAVING',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'In SQL, NULL usually represents what?',
                'option_a' => 'Zero',
                'option_b' => 'Empty string only',
                'option_c' => 'Missing or unknown value',
                'option_d' => 'Negative value',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'What does KPI stand for?',
                'option_a' => 'Key Performance Indicator',
                'option_b' => 'Known Project Input',
                'option_c' => 'Key Process Integration',
                'option_d' => 'Knowledge Performance Index',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which SQL aggregate function counts rows?',
                'option_a' => 'SUM',
                'option_b' => 'COUNT',
                'option_c' => 'AVG',
                'option_d' => 'MIN',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which chart is best for comparing values across categories?',
                'option_a' => 'Bar chart',
                'option_b' => 'Pie chart',
                'option_c' => 'Gauge only',
                'option_d' => 'Word cloud only',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'technical',
                'question' => 'Which SQL function returns the mean value of a numeric column?',
                'option_a' => 'AVG',
                'option_b' => 'COUNT',
                'option_c' => 'MAX',
                'option_d' => 'ROUND',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'aptitude',
                'question' => 'A report shows 240 applicants and 25% were shortlisted. How many applicants were shortlisted?',
                'option_a' => '40',
                'option_b' => '50',
                'option_c' => '60',
                'option_d' => '80',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'aptitude',
                'question' => 'If sales increase from 80 to 100 units, what is the percentage increase?',
                'option_a' => '15%',
                'option_b' => '20%',
                'option_c' => '25%',
                'option_d' => '30%',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'communication',
                'question' => 'Which sentence best explains an insight from a dashboard?',
                'option_a' => 'Numbers are there.',
                'option_b' => 'Sales increased by 12% in March, mainly from repeat customers.',
                'option_c' => 'The chart looks nice.',
                'option_d' => 'Data is confusing.',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Data Analyst',
                'category' => 'communication',
                'question' => 'What should an analyst do before sharing a surprising result?',
                'option_a' => 'Share it immediately without checking',
                'option_b' => 'Validate the data and mention assumptions',
                'option_c' => 'Hide the result',
                'option_d' => 'Change the numbers',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'What is the purpose of version control in software development?',
                'option_a' => 'Track and manage code changes',
                'option_b' => 'Design image banners only',
                'option_c' => 'Increase monitor brightness',
                'option_d' => 'Compress database backups only',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which HTTP method is commonly used to create a new resource?',
                'option_a' => 'GET',
                'option_b' => 'POST',
                'option_c' => 'HEAD',
                'option_d' => 'TRACE',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'What does an API allow two software systems to do?',
                'option_a' => 'Communicate and exchange data',
                'option_b' => 'Replace all databases',
                'option_c' => 'Delete source code automatically',
                'option_d' => 'Disable user login',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which data structure follows the LIFO principle?',
                'option_a' => 'Queue',
                'option_b' => 'Stack',
                'option_c' => 'Array',
                'option_d' => 'Linked List',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which Git command saves staged changes to the local repository?',
                'option_a' => 'git push',
                'option_b' => 'git commit',
                'option_c' => 'git pull',
                'option_d' => 'git clone',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which HTTP status code means Not Found?',
                'option_a' => '200',
                'option_b' => '201',
                'option_c' => '404',
                'option_d' => '500',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which SQL command is used to fetch data from a database table?',
                'option_a' => 'INSERT',
                'option_b' => 'SELECT',
                'option_c' => 'UPDATE',
                'option_d' => 'DELETE',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'What is the main purpose of a function in programming?',
                'option_a' => 'To repeat code manually',
                'option_b' => 'To store only text data',
                'option_c' => 'To group reusable code',
                'option_d' => 'To delete variables',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which concept allows a child class to use properties of a parent class?',
                'option_a' => 'Encapsulation',
                'option_b' => 'Abstraction',
                'option_c' => 'Inheritance',
                'option_d' => 'Compilation',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'technical',
                'question' => 'Which of the following is used to style a web page?',
                'option_a' => 'HTML',
                'option_b' => 'CSS',
                'option_c' => 'SQL',
                'option_d' => 'Git',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'What is software testing mainly used for?',
                'option_a' => 'To design logos',
                'option_b' => 'To find defects in software',
                'option_c' => 'To increase hardware speed',
                'option_d' => 'To write database queries only',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'What is a test case?',
                'option_a' => 'A document describing steps, input, and expected result',
                'option_b' => 'A programming language',
                'option_c' => 'A server configuration file',
                'option_d' => 'A type of database',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'Smoke testing is usually performed to check what?',
                'option_a' => 'Whether the build is stable enough for further testing',
                'option_b' => 'Whether the app has perfect UI',
                'option_c' => 'Whether users like the product',
                'option_d' => 'Whether the server is expensive',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'Regression testing verifies what?',
                'option_a' => 'New code has not broken existing functionality',
                'option_b' => 'Only spelling mistakes',
                'option_c' => 'Only database backup',
                'option_d' => 'Only user passwords',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'Which tool is commonly used for API testing?',
                'option_a' => 'Photoshop',
                'option_b' => 'Postman',
                'option_c' => 'Figma',
                'option_d' => 'Excel',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'Load testing checks application behavior under what?',
                'option_a' => 'Expected user traffic',
                'option_b' => 'UI color combinations',
                'option_c' => 'Grammar in content',
                'option_d' => 'Code indentation only',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'Static testing is performed in which way?',
                'option_a' => 'Without executing the code',
                'option_b' => 'Only after deployment',
                'option_c' => 'Only by end users',
                'option_d' => 'By running automation scripts only',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'UAT stands for what?',
                'option_a' => 'User Acceptance Testing',
                'option_b' => 'Universal API Testing',
                'option_c' => 'User Automation Tool',
                'option_d' => 'Unified Application Tracking',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'In API testing, which status code usually indicates a successful request?',
                'option_a' => '200',
                'option_b' => '404',
                'option_c' => '500',
                'option_d' => '403',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Tester / QA',
                'category' => 'technical',
                'question' => 'A bug report should clearly include what?',
                'option_a' => 'Steps to reproduce and expected result',
                'option_b' => 'Only the tester name',
                'option_c' => 'Only the release date',
                'option_d' => 'Only a design color',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'What does UI mainly focus on?',
                'option_a' => 'User interface visuals and layout',
                'option_b' => 'Server speed',
                'option_c' => 'Database security',
                'option_d' => 'API response time',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'What does UX mainly focus on?',
                'option_a' => 'User overall experience while using a product',
                'option_b' => 'Only button colors',
                'option_c' => 'Only logo design',
                'option_d' => 'Only backend code',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'Which tool is commonly used for UI/UX design?',
                'option_a' => 'Figma',
                'option_b' => 'Postman',
                'option_c' => 'MySQL',
                'option_d' => 'Git Bash',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'What is a wireframe?',
                'option_a' => 'A basic layout showing structure of a screen',
                'option_b' => 'A final coded website',
                'option_c' => 'A database table',
                'option_d' => 'A software testing report',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'What is a prototype?',
                'option_a' => 'An interactive model of a design',
                'option_b' => 'A server backup',
                'option_c' => 'A spreadsheet formula',
                'option_d' => 'A programming loop',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'Responsive design means what?',
                'option_a' => 'Design adjusts properly across different screen sizes',
                'option_b' => 'Design uses only one color',
                'option_c' => 'Design works only on desktop',
                'option_d' => 'Design has no images',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'User research helps designers to do what?',
                'option_a' => 'Understand user needs and behavior',
                'option_b' => 'Write backend code faster',
                'option_c' => 'Remove all testing',
                'option_d' => 'Increase file size',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'Visual hierarchy is used to do what?',
                'option_a' => 'Guide users attention to important elements',
                'option_b' => 'Hide all content',
                'option_c' => 'Make all text the same size',
                'option_d' => 'Remove navigation',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'Typography refers to what?',
                'option_a' => 'Selection and arrangement of text styles',
                'option_b' => 'Database indexing',
                'option_c' => 'API response format',
                'option_d' => 'Software installation',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'UI/UX Designer',
                'category' => 'technical',
                'question' => 'Whitespace in design helps with what?',
                'option_a' => 'Improve readability and reduce clutter',
                'option_b' => 'Waste screen space only',
                'option_c' => 'Hide important buttons',
                'option_d' => 'Slow down the website',
                'correct_option' => 'A',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'aptitude',
                'question' => 'A feature has 8 tasks and 5 are completed. What percentage of tasks are completed?',
                'option_a' => '50%',
                'option_b' => '62.5%',
                'option_c' => '70%',
                'option_d' => '80%',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'aptitude',
                'question' => 'If a loop runs 4 times and each run creates 3 records, how many records are created?',
                'option_a' => '7',
                'option_b' => '9',
                'option_c' => '12',
                'option_d' => '16',
                'correct_option' => 'C',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'communication',
                'question' => 'Which message is best when a developer needs more details for a bug?',
                'option_a' => 'This is not working.',
                'option_b' => 'Please share the steps, expected result, and screenshot so I can reproduce it.',
                'option_c' => 'Send everything again.',
                'option_d' => 'I cannot do it.',
                'correct_option' => 'B',
            ],
            [
                'job_category' => 'Software Developer',
                'category' => 'communication',
                'question' => 'What should a developer mention in a clear status update?',
                'option_a' => 'Only that work is going on',
                'option_b' => 'Completed work, blockers, and next step',
                'option_c' => 'Nothing until the deadline',
                'option_d' => 'Only technical terms',
                'correct_option' => 'B',
            ],
        ];
    }
}
