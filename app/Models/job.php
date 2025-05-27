<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'employer_id',
        'title',
        'location',
        'description',
        'required_skills',
        'salary',
        'salary_structure',
        'job_type',
        'experience_level',
        'education',
        'status',
        'application_start_date',
        'application_deadline',
        'gender',
        'visa_sponsor',
        'agent_ids',
    ];

    protected $casts = [
        'required_skills'        => 'array',
        'agent_ids'              => 'array',
        'application_start_date' => 'date',
        'application_deadline'   => 'date',
        'visa_sponsor'           => 'boolean',
    ];

    // Relationship to the employer
    public function user()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    // (Remove the incorrect agent()—you’re handling agents in the controller)
}
