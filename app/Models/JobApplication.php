<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_seeker_id',
    ];

    public function job():  BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    

    public function job_seeker():  BelongsTo
    {
        return $this->belongsTo(JobSeeker::class);
    }


}
