<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'fresher_profile_id',
        'course_enrollment_id',
        'final_assessment_result_id',
        'certificate_number',
        'certificate_file',
        'completion_date',
    ];

    protected function casts(): array
    {
        return [
            'completion_date' => 'date',
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

    public function finalAssessmentResult(): BelongsTo
    {
        return $this->belongsTo(
            AssessmentResult::class,
            'final_assessment_result_id'
        );
    }
}