<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobSeeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'current_company',
        'previous_company',
        'work_experience'
    ];

    public function job_applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
