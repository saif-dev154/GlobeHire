<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileStatusesAndRemarksToVisaDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('visa_documents', function (Blueprint $table) {
            // map each base field to its status columns and remarks columns
            $map = [
                'passport_scan'           => [
                    'passport_scan_front_status',
                    'passport_scan_back_status',
                    'passport_scan_front_remarks',
                    'passport_scan_back_remarks',
                ],
                'national_id'             => [
                    'national_id_front_status',
                    'national_id_back_status',
                    'national_id_front_remarks',
                    'national_id_back_remarks',
                ],
                'passport_photo'          => [
                    'passport_photo_status',
                    'passport_photo_remarks',
                ],
                'education_certificates'  => [
                    'education_certificates_status',
                    'education_certificates_remarks',
                ],
                'experience_certificate'  => [
                    'experience_certificate_status',
                    'experience_certificate_remarks',
                ],
                'police_clearance'        => [
                    'police_clearance_status',
                    'police_clearance_remarks',
                ],
                'medical_certificate'     => [
                    'medical_certificate_status',
                    'medical_certificate_remarks',
                ],
                'visa_application_form'   => [
                    'visa_application_form_status',
                    'visa_application_form_remarks',
                ],
                'offer_letter'            => [
                    'offer_letter_status',
                    'offer_letter_remarks',
                ],
                'resume_cv'               => [
                    'resume_cv_status',
                    'resume_cv_remarks',
                ],
                'declaration_consent'     => [
                    'declaration_consent_status',
                    'declaration_consent_remarks',
                ],
                'noc'                     => [
                    'noc_status',
                    'noc_remarks',
                ],
            ];

            foreach ($map as $base => $extras) {
                foreach ($extras as $col) {
                    if (str_ends_with($col, '_status')) {
                        $table->enum($col, ['pending','approved','rejected'])
                              ->default('pending')
                              ->after($base)
                              ->comment("Status for {$base}");
                    } else {
                        $table->text($col)
                              ->nullable()
                              ->after($base)
                              ->comment("Remarks for {$base}");
                    }
                }
            }
        });
    }

    public function down()
    {
        Schema::table('visa_documents', function (Blueprint $table) {
            $cols = [
                // passport_scan
                'passport_scan_front_status',
                'passport_scan_back_status',
                'passport_scan_front_remarks',
                'passport_scan_back_remarks',
                // national_id
                'national_id_front_status',
                'national_id_back_status',
                'national_id_front_remarks',
                'national_id_back_remarks',
                // other single‐file fields
                'passport_photo_status',
                'passport_photo_remarks',
                'education_certificates_status',
                'education_certificates_remarks',
                'experience_certificate_status',
                'experience_certificate_remarks',
                'police_clearance_status',
                'police_clearance_remarks',
                'medical_certificate_status',
                'medical_certificate_remarks',
                'visa_application_form_status',
                'visa_application_form_remarks',
                'offer_letter_status',
                'offer_letter_remarks',
                'resume_cv_status',
                'resume_cv_remarks',
                'declaration_consent_status',
                'declaration_consent_remarks',
                'noc_status',
                'noc_remarks',
            ];
            foreach ($cols as $col) {
                $table->dropColumn($col);
            }
        });
    }
}
