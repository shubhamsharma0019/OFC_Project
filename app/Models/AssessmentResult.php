<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'technical_score',
        'aptitude_score',
        'communication_score',
        'overall_score',
        'recommended_track',
        'result',
    ];

    protected function casts(): array
    {
        return [
            'technical_score' => 'decimal:2',
            'aptitude_score' => 'decimal:2',
            'communication_score' => 'decimal:2',
            'overall_score' => 'decimal:2',
        ];
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(
            AssessmentAttempt::class,
            'attempt_id'
        );
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(
            Certificate::class,
            'final_assessment_result_id'
        );
    }
}