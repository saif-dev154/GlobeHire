<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'contract_id',

        // file paths
        'passport_scan',
        'national_id',
        'passport_photo',
        'education_certificates',
        'experience_certificate',
        'police_clearance',
        'medical_certificate',
        'visa_application_form',
        'offer_letter',
        'resume_cv',
        'declaration_consent',
        'noc',

        // per-file statuses
        'passport_scan_front_status',
        'passport_scan_back_status',
        'national_id_front_status',
        'national_id_back_status',
        'passport_photo_status',
        'education_certificates_status',
        'experience_certificate_status',
        'police_clearance_status',
        'medical_certificate_status',
        'visa_application_form_status',
        'offer_letter_status',
        'resume_cv_status',
        'declaration_consent_status',
        'noc_status',

        // per-file remarks
        'passport_scan_front_remarks',
        'passport_scan_back_remarks',
        'national_id_front_remarks',
        'national_id_back_remarks',
        'passport_photo_remarks',
        'education_certificates_remarks',
        'experience_certificate_remarks',
        'police_clearance_remarks',
        'medical_certificate_remarks',
        'visa_application_form_remarks',
        'offer_letter_remarks',
        'resume_cv_remarks',
        'declaration_consent_remarks',
        'noc_remarks',

        // global status & remarks, if still needed
        'status',
        'remarks',
    ];

   protected $casts = [
    'passport_scan' => 'array',
    'national_id'   => 'array',
];

    /**
     * The candidate (user) who uploaded these documents.
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate');
    }

    /**
     * The contract this visa document is attached to.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
     public function flightSchedule()
    {
        return $this->hasOne(FlightSchedule::class);
    }
}
