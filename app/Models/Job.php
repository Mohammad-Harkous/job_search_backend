<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'job_type',
        'job_location',
        'salary',
        'description',
        'application_deadline'
    ];


    public function job_application(): HasOne
    {
        return $this->hasOne(JobApplication::class);
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
