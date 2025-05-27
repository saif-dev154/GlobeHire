<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\VisaDocument;
use App\Models\FlightSchedule;
use Illuminate\Support\Facades\Auth;

class CandidateFlightScheduleController extends Controller
{
    public function index(VisaDocument $visa)
    {
        // Ensure this candidate owns the visa
        abort_if($visa->candidate_id !== Auth::id(), 403);

        // Load all schedules
        $schedules = $visa->flightSchedule()->latest('departure_datetime')->get();

        return view('candidate.pages.flight.index', compact('visa', 'schedules'));
    }

    public function show(VisaDocument $visa, FlightSchedule $schedule)
    {
        // Ensure both visa ownership and that this schedule belongs to that visa
        abort_if($visa->candidate_id !== Auth::id(), 403);
        abort_if($schedule->visa_document_id !== $visa->id, 404);

        return view('candidate.pages.flight.show', compact('visa', 'schedule'));
    }
}
