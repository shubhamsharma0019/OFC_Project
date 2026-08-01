<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingPartnerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'institute_name',
        'institute_logo',
        'email',
        'phone',
        'location',
        'website',
        'about_institute',
        'verification_document',
        'approval_status',
        'rejection_reason',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}