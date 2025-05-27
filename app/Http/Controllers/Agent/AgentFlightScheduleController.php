<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\FlightSchedule;
use App\Models\VisaDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgentFlightScheduleController extends Controller
{
   public function index(Request $request)
{
    $agentId = Auth::id();

    $schedules = FlightSchedule::whereHas('visaDocument.contract.interview', function ($q) use ($agentId) {
            $q->where('agent_id', $agentId);
        })
        ->with('visaDocument.contract.interview.application.candidate')
        ->latest('departure_datetime')
        ->get();

    // default to “scheduled” if nobody passed ?status=
    $activeStatus = $request->query('status', 'scheduled');

    return view('agent.pages.flight.index', compact('schedules', 'activeStatus'));
}

    public function create(VisaDocument $visa)
    {
        abort_if($visa->contract->interview->agent_id !== Auth::id(), 403);

        return view('agent.pages.flight.create', compact('visa'));
    }

    public function show(VisaDocument $visa, FlightSchedule $schedule)
    {
        abort_if($schedule->visa_document_id !== $visa->id, 404);
        abort_if($visa->contract->interview->agent_id !== Auth::id(), 403);

        $visa->load('contract.interview.application.candidate');

        return view('agent.pages.flight.show', [
            'visa'     => $visa,
            'schedule' => $schedule,
        ]);
    }


    public function store(Request $request, VisaDocument $visa)
    {
        abort_if($visa->contract->interview->agent_id !== Auth::id(), 403);

        $data = $request->validate([
            'airline'               => 'required|string|max:255',
            'flight_number'         => 'nullable|string|max:255',
            'departure_airport'     => 'required|string|max:255',
            'arrival_airport'       => 'required|string|max:255',
            'departure_datetime'    => 'required|date',
            'arrival_datetime'      => 'required|date|after_or_equal:departure_datetime',
            'ticket'                => 'required|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'sponsorship_letter'    => 'required|file|mimes:pdf|max:5120',
            'travel_status'         => 'required|in:scheduled,ticket_uploaded,checked_in,boarding,in_flight,completed,cancelled,delayed,rescheduled',
        ]);

        $ticketPath  = $request->file('ticket')->store("flights/{$visa->id}/tickets", 'public');
        $sponsorPath = $request->file('sponsorship_letter')->store("flights/{$visa->id}/sponsors", 'public');

        $visa->flightSchedule()->create([
            'airline'                  => $data['airline'],
            'flight_number'            => $data['flight_number'],
            'departure_airport'        => $data['departure_airport'],
            'arrival_airport'          => $data['arrival_airport'],
            'departure_datetime'       => $data['departure_datetime'],
            'arrival_datetime'         => $data['arrival_datetime'],
            'ticket_path'              => $ticketPath,
            'sponsorship_letter_path'  => $sponsorPath,
            'travel_status'            => $data['travel_status'],
        ]);

        return redirect()
            ->route('visa.schedules')
            ->with('success', 'Flight scheduled successfully.');
    }

    public function edit(VisaDocument $visa, FlightSchedule $schedule)
    {
        abort_if($visa->contract->interview->agent_id !== Auth::id(), 403);
        abort_if($schedule->visa_document_id !== $visa->id, 404);

        return view('agent.pages.flight.create', compact('visa', 'schedule'));
    }

    public function update(Request $request, VisaDocument $visa, FlightSchedule $schedule)
    {
        abort_if($visa->contract->interview->agent_id !== Auth::id(), 403);
        abort_if($schedule->visa_document_id !== $visa->id, 404);

        $data = $request->validate([
            'airline'               => 'required|string|max:255',
            'flight_number'         => 'nullable|string|max:255',
            'departure_airport'     => 'required|string|max:255',
            'arrival_airport'       => 'required|string|max:255',
            'departure_datetime'    => 'required|date',
            'arrival_datetime'      => 'required|date|after_or_equal:departure_datetime',
            'ticket'                => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'sponsorship_letter'    => 'nullable|file|mimes:pdf|max:5120',
            'travel_status'         => 'required|in:scheduled,ticket_uploaded,checked_in,boarding,in_flight,completed,cancelled,delayed,rescheduled',
        ]);

        if ($request->hasFile('ticket')) {
            Storage::disk('public')->delete($schedule->ticket_path);
            $schedule->ticket_path = $request->file('ticket')->store("flights/{$visa->id}/tickets", 'public');
        }
        if ($request->hasFile('sponsorship_letter')) {
            Storage::disk('public')->delete($schedule->sponsorship_letter_path);
            $schedule->sponsorship_letter_path = $request->file('sponsorship_letter')
                ->store("flights/{$visa->id}/sponsors", 'public');
        }

        $schedule->update([
            'airline'             => $data['airline'],
            'flight_number'       => $data['flight_number'],
            'departure_airport'   => $data['departure_airport'],
            'arrival_airport'     => $data['arrival_airport'],
            'departure_datetime'  => $data['departure_datetime'],
            'arrival_datetime'    => $data['arrival_datetime'],
            'travel_status'       => $data['travel_status'],
        ] + $schedule->only(['ticket_path', 'sponsorship_letter_path']));

        return back()->with('success', 'Flight schedule updated.');
    }




    public function destroy(VisaDocument $visa, FlightSchedule $schedule)
{
    abort_if($visa->contract->interview->agent_id !== Auth::id(), 403);
    abort_if($schedule->visa_document_id !== $visa->id, 404);

    Storage::disk('public')->delete([$schedule->ticket_path, $schedule->sponsorship_letter_path]);
    $schedule->delete();

    return redirect()
        ->route('agent.visa.schedules', ['status' => $schedule->travel_status])
        ->with('success', 'Schedule deleted.');
}

}
