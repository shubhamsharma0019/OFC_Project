<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssessmentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'fresher_profile_id',
        'course_enrollment_id',
        'assessment_type',
        'started_at',
        'submitted_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function fresherProfile(): BelongsTo
    {
        return $this->belongsTo(FresherProfile::class);
    }

    public function courseEnrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(
            AssessmentAnswer::class,
            'attempt_id'
        );
    }

    public function result(): HasOne
    {
        return $this->hasOne(
            AssessmentResult::class,
            'attempt_id'
        );
    }
}