<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',        // ← add this
        'employer_id',
        'contract_date',
        'start_date',
        'deadline',
        'salary',
        'working_hours',
        'leave_entitlement',
        'termination_terms',
        'notice_period',
        'jurisdiction',
        'body',
        'signature_path',
        'status',
        'remarks',
    ];

    protected $casts = [
        'contract_date' => 'date',
        'start_date'    => 'date',
        'deadline'      => 'date',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }
    

    public function application()
    {
        return $this->hasOneThrough(
            Application::class,
            Interview::class,
            'id',
            'id',
            'interview_id',
            'application_id'
        );
    }

    public function getCandidateSignatureUrlAttribute(): ?string
    {
        return $this->signature_path
            ? Storage::disk('public')->url($this->signature_path)
            : null;
    }


    
}
