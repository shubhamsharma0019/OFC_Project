<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyResumeAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_profile_id',
        'fresher_profile_id',
        'status',
        'interview_link',
        'interview_date',
        'interview_time',
        'company_joined_at',
        'fresher_joined_at',
    ];

    protected function casts(): array
    {
        return [
            'interview_date' => 'date',
            'company_joined_at' => 'datetime',
            'fresher_joined_at' => 'datetime',
        ];
    }

    public function companyProfile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    public function fresherProfile(): BelongsTo
    {
        return $this->belongsTo(FresherProfile::class);
    }
}
