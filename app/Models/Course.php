<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_partner_profile_id',
        'course_name',
        'category',
        'description',
        'duration',
        'fees',
        'training_mode',
        'start_date',
        'skills_covered',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'fees' => 'decimal:2',
            'start_date' => 'date',
        ];
    }

    public function trainingPartnerProfile(): BelongsTo
    {
        return $this->belongsTo(TrainingPartnerProfile::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }
}