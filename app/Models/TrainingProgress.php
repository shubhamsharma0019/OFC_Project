<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingProgress extends Model
{
    use HasFactory;

    protected $table = 'training_progress';

    protected $fillable = [
        'course_enrollment_id',
        'progress_percentage',
        'current_status',
        'short_remark',
        'completion_date',
    ];

    protected function casts(): array
    {
        return [
            'progress_percentage' => 'integer',
            'completion_date' => 'date',
        ];
    }

    public function courseEnrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class);
    }
}