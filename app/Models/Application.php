<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'job_id',
        'candidate_id',
        'assigned_agent_id',
        'status',
        'skills',
        'full_name',
        'date_of_birth',
        'gender',
        'nationality',
        'email',
        'phone',
        'address',
        'country',
        'highest_degree',
        'institution',
        'field_of_study',
        'graduation_date',
        'years_experience',
        'last_employer',
        'last_position',
        'employment_duration',
        'cover_letter',
        'linkedin',
        'portfolio',
        'resume_path',
        'other_docs_paths',
    ];

    protected $casts = [
        'date_of_birth'       => 'date',
        'graduation_date'     => 'date',
        'years_experience'    => 'integer',
        'other_docs_paths'    => 'array',
        'skills'              => 'array',
        'status'              => 'string',
        
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

   public function candidate()
{
    return $this->belongsTo(\App\Models\User::class, 'candidate_id');
}

}
