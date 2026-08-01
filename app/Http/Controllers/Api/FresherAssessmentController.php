<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssessmentQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FresherAssessmentController extends Controller
{
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
}