<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_profile_id',
        'title',
        'description',
        'required_skills',
        'qualification',
        'location',
        'salary',
        'job_type',
        'immediate_joiner',
        'openings',
        'hiring_mode',
        'application_last_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'openings' => 'integer',
            'immediate_joiner' => 'boolean',
            'application_last_date' => 'date',
        ];
    }

    public function companyProfile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
