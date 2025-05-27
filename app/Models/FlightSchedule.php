<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'visa_document_id',
        'airline',
        'flight_number',
        'departure_airport',
        'arrival_airport',
        'departure_datetime',
        'arrival_datetime',
        'ticket_path',
        'sponsorship_letter_path',
        'travel_status',
    ];
 protected $casts = [
        'departure_datetime' => 'datetime',
        'arrival_datetime'   => 'datetime',
    ];
    /**
     * The visa document this schedule belongs to.
     */
    public function visaDocument()
    {
        return $this->belongsTo(VisaDocument::class);
    }
    
}
