<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
     
    protected $fillable = [
    'application_id',
    'agent_id',
    'interview_date',
    'start_time',
    'end_time',
    'meeting_link',
    'status',
    'remarks',
];


    protected $casts = [
        'interview_date' => 'date',
        'start_time'     => 'string',
        'end_time'       => 'string',
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
 
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function contract()
{
    return $this->hasOne(Contract::class);
}

}
