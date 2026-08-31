<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_logo',
        'email',
        'phone',
        'industry',
        'website',
        'address',
        'description',
        'approval_status',
        'hiring_intent',
        'rejection_reason',
        'job_credits',
        'total_job_credits_used',
        'subscribed_at',
        'subscription_plan',
    ];

    protected $casts = [
        'job_credits' => 'integer',
        'total_job_credits_used' => 'integer',
        'subscribed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function resumeAssignments(): HasMany
    {
        return $this->hasMany(CompanyResumeAssignment::class);
    }
}
