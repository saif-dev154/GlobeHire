<?php

namespace App\Http\Controllers\Agent;

use Carbon\Carbon;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Http\Controllers\Controller;

class AgentInterviewsController extends Controller
{
    // Show the list of interviews
    public function index()
    {
        $agentId = Auth::id();
        $now     = now();

        // fetch & format everything
        $all = Interview::where('agent_id', $agentId)
            ->with(['application.job'])
            ->get()
            ->map(fn($iv) => $this->formatInterviewData($iv, $now));

        // Upcoming: not ended & still pending
        $upcoming = $all->filter(
            fn($d) =>
            $this->isUpcoming($d, $now) && $d['model']->status === 'pending'
        );

        // Past: ended & still pending
        $past = $all->filter(
            fn($d) =>
            $this->isPast($d, $now) && $d['model']->status === 'pending'
        );

        // Pass: status == pass
        $pass = $all->filter(
            fn($d) =>
            $d['model']->status === 'pass'
        );

        // Fail: status == fail
        $fail = $all->filter(
            fn($d) =>
            $d['model']->status === 'fail'
        );

        $postponed = $all->filter(
            fn($d) =>
            $d['model']->status === 'postponed'
        );

        return view('agent.pages.interviews.index', [
            'interviews' => [
                'upcoming' => $upcoming,
                'past'     => $past,
                'pass'     => $pass,
                'fail'     => $fail,
                'postponed' => $postponed,
            ]
        ]);
    }



public function store(Request $request, $applicationId)
{
    $request->validate([
        'interview_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'meeting_link' => 'required|url',
    ]);

    // Store the interview
    Interview::create([
        'application_id' => $applicationId,
        'agent_id' => auth::id(),
        'interview_date' => $request->interview_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'meeting_link' => $request->meeting_link,
        'status' => 'pending',
    ]);

    // Update the application status to 'pass'
    $application = Application::findOrFail($applicationId);
    $application->status = 'approved';
    $application->save();

    return redirect()->back()->with('success', 'Interview scheduled and application status updated to pass.');
}
















    
    private function formatInterviewData(Interview $iv, Carbon $now): array
    {
        $date  = $iv->interview_date;
        $start = Carbon::parse("{$date->format('Y-m-d')} {$iv->start_time}");
        $end   = Carbon::parse("{$date->format('Y-m-d')} {$iv->end_time}");

        return [
            'model'         => $iv,
            'label'         => $this->getInterviewLabel($date),
            'startFmt'      => $start->format('g:i A'),
            'start'         => $start,
            'end'           => $end,
            'endFmt'        => $end->format('g:i A'),
            'progress'      => ($p = $this->getInterviewProgress($start, $end, $now))['progress'],
            'progressBadge' => $p['progressBadge'],
            'statusBadge'   => $this->getStatusBadge($iv->status),
        ];
    }

    private function isUpcoming(array $d, Carbon $now): bool
    {
        $endDateTime = $d['model']->interview_date->format('Y-m-d') . ' ' . $d['model']->end_time;
        return $endDateTime >= $now->format('Y-m-d H:i');
    }

    private function isPast(array $d, Carbon $now): bool
    {
        $endDateTime = $d['model']->interview_date->format('Y-m-d') . ' ' . $d['model']->end_time;
        return $endDateTime < $now->format('Y-m-d H:i');
    }

    private function getInterviewLabel($date): string
    {
        if ($date->isToday()) {
            return 'Today';
        } elseif ($date->isYesterday()) {
            return 'Yesterday';
        }

        return $date->diffForHumans([
            'parts'  => 1,
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
        ]);
    }

    private function getInterviewProgress(Carbon $start, Carbon $end, Carbon $now): array
    {
        if ($now->lt($start)) {
            return ['progress' => 'Pending', 'progressBadge' => 'bg-secondary'];
        } elseif ($now->between($start, $end)) {
            return ['progress' => 'In Progress', 'progressBadge' => 'bg-info'];
        }

        return ['progress' => 'Ended', 'progressBadge' => 'bg-danger'];
    }

    private function getStatusBadge(string $status): string
    {
        return match ($status) {
            'accepted'  => 'bg-success',
            'rejected'  => 'bg-danger',
            'postponed' => 'bg-warning',
            default     => 'bg-secondary',
        };
    }

    public function edit(int $id)
    {
        $iv = Interview::with(['application.job', 'agent'])
            ->where('agent_id', Auth::id())
            ->findOrFail($id);

        return view('agent.pages.interviews.create', ['iv' => $iv]);
    }

    public function update(Request $request, int $id)
    {

        // dd($request->all());
        // 1) Validate all inputs
        $data = $request->validate([
            'interview_date' => 'required|date',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
            'meeting_link'   => 'required|url',
            'status'         => 'required|in:accepted,rejected,postponed,pending',
            'remarks'        => 'nullable|string|max:500',
        ]);

        // 2) Extra check: require remarks on “fail”
        if ($data['status'] === 'rejected' && empty($data['remarks'])) {
            return back()->withErrors(['remarks' => 'Remarks are required when rejecting.']);
        }

        // 3) Load the Interview (ensure agent owns it)
        $iv = Interview::where('agent_id', Auth::id())->findOrFail($id);

        // 4) Update the schedule & meeting link
        $iv->interview_date = Carbon::parse($data['interview_date']);
        $iv->start_time     = $data['start_time'];
        $iv->end_time       = $data['end_time'];
        $iv->meeting_link   = $data['meeting_link'];

        // 5) Map and update status & remarks
        $iv->status  = match ($data['status']) {
            'accepted'  => 'pass',
            'rejected'  => 'fail',
            default     => $data['status'],
        };
        $iv->remarks = $data['remarks'] ?? null;

        // 6) Persist all changes in one save()
        $iv->save();

        return redirect()
            ->route('agent.interviews.index')
            ->with('success', 'Interview updated successfully.');
    }


    public function destroy(int $id)
    {
        Interview::where('agent_id', Auth::id())
            ->findOrFail($id)
            ->delete();

        return back()->with('success', 'Interview deleted.');
    }

    // AJAX status endpoint
    public function status(int $id)
    {
        $iv    = Interview::findOrFail($id);
        $date  = $iv->interview_date;
        $start = Carbon::parse("{$date->format('Y-m-d')} {$iv->start_time}");
        $end   = Carbon::parse("{$date->format('Y-m-d')} {$iv->end_time}");
        $now   = now();

        $pData = $this->getInterviewProgress($start, $end, $now);

        return response()->json([
            'progress'      => $pData['progress'],
            'progressBadge' => $pData['progressBadge'],
            'status'        => $iv->status,
            'statusBadge'   => $this->getStatusBadge($iv->status),
        ]);
    }



    public function updateStatus(Request $request, int $id)
{
    $data = $request->validate([
        'status'  => 'required|in:accepted,rejected,postponed',
        'remarks' => 'required_if:status,rejected|string|max:500',
    ]);

    $iv = Interview::where('agent_id', Auth::id())->findOrFail($id);
    $iv->status  = $data['status'] === 'accepted' ? 'pass'
                    : ($data['status'] === 'rejected' ? 'fail'
                    : 'postponed');
    $iv->remarks = $data['remarks'] ?? null;
    $iv->save();

    return back()->with('success','Status updated.');
}

}
