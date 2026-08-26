<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FresherProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_photo',
        'phone',
        'city',
        'qualification',
        'college_name',
        'passing_year',
        'skills',
        'preferred_job_category',
        'preferred_min_package_lpa',
        'preferred_max_package_lpa',
        'resume',
        'profile_completion',
        'direct_mode_credits',
        'total_direct_mode_credits_used',
        'direct_mode_subscribed_at',
        'direct_mode_subscription_plan',
        'direct_mode_subscription_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'passing_year' => 'integer',
            'preferred_min_package_lpa' => 'decimal:2',
            'preferred_max_package_lpa' => 'decimal:2',
            'profile_completion' => 'integer',
            'direct_mode_credits' => 'integer',
            'total_direct_mode_credits_used' => 'integer',
            'direct_mode_subscribed_at' => 'datetime',
            'direct_mode_subscription_expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assessmentAttempts(): HasMany
    {
        return $this->hasMany(AssessmentAttempt::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function courseEnrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
