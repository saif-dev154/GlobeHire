<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Support\Carbon;
use App\Models\Interview;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CandidateInterviewController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = now();

        $interviews = Interview::whereHas('application', fn ($q) =>
            $q->where('candidate_id', $userId)
        )
            ->with(['application.job'])
            ->get();

        $upcomingInterviews = $interviews->filter(fn ($iv) =>
            $iv->interview_date->format('Y-m-d') . ' ' . $iv->end_time >= $now->format('Y-m-d H:i')
        )->map(fn ($iv) => $this->formatInterview($iv));

        $pastInterviews = $interviews->filter(fn ($iv) =>
            $iv->interview_date->format('Y-m-d') . ' ' . $iv->end_time < $now->format('Y-m-d H:i')
        )->map(fn ($iv) => $this->formatInterview($iv));

        return view('candidate.pages.interviews.index', compact(
            'upcomingInterviews',
            'pastInterviews'
        ));
    }

    public function show($id)
    {
        $interview = Interview::where('id', $id)
            ->whereHas('application', fn ($q) => $q->where('candidate_id', Auth::id()))
            ->with(['application.job', 'agent'])
            ->firstOrFail();

        $app   = $interview->application;
        $job   = $app->job;
        $agent = $interview->agent;

        $date  = $interview->interview_date;
        $start = Carbon::parse("{$date->format('Y-m-d')} {$interview->start_time}");
        $end   = Carbon::parse("{$date->format('Y-m-d')} {$interview->end_time}");
        $now   = now();

        $label = $this->formatLabel($date);
        $startFmt = $start->format('g:i A');
        $endFmt   = $end->format('g:i A');

        if ($now->lt($start)) {
            $progress      = 'Pending';
            $progressBadge = 'bg-secondary';
        } elseif ($now->between($start, $end)) {
            $progress      = 'In Progress';
            $progressBadge = 'bg-info';
        } else {
            $progress      = 'Ended';
            $progressBadge = 'bg-danger';
        }

        $result      = ucfirst($interview->status);
        $resultBadge = $interview->status === 'pass' ? 'bg-success' : 'bg-danger';

        return view('candidate.pages.interviews.show', compact(
            'interview', 'app', 'job', 'agent',
            'label', 'startFmt', 'endFmt',
            'progress', 'progressBadge',
            'result', 'resultBadge'
        ));
    }

    public function status($id)
    {
        $interview = Interview::with('application.job', 'agent')
            ->where('id', $id)
            ->whereHas('application', fn ($q) => $q->where('candidate_id', Auth::id()))
            ->firstOrFail();

        $date  = Carbon::parse($interview->interview_date);
        $start = Carbon::parse("{$date->format('Y-m-d')} {$interview->start_time}");
        $end   = Carbon::parse("{$date->format('Y-m-d')} {$interview->end_time}");
        $now   = now();

        $label = $this->formatLabel($date);
        $startFmt = $start->format('g:i A');
        $endFmt   = $end->format('g:i A');

        if ($now->lt($start)) {
            $progress      = 'Pending';
            $progressBadge = 'bg-secondary';
        } elseif ($now->between($start, $end)) {
            $progress      = 'In Progress';
            $progressBadge = 'bg-info';
        } else {
            $progress      = 'Ended';
            $progressBadge = 'bg-danger';
        }

        $result      = ucfirst($interview->status);
        $resultBadge = $interview->status === 'pass' ? 'bg-success' : 'bg-danger';

        return response()->json([
            'label'         => $label,
            'date'          => $date->format('d M Y'),
            'start'         => $startFmt,
            'end'           => $endFmt,
            'progress'      => $progress,
            'progressBadge' => $progressBadge,
            'result'        => $result,
            'resultBadge'   => $resultBadge,
            'meeting'       => $interview->meeting_link,
        ]);
    }

    // --------------------
    // 🔧 Helper Functions
    // --------------------

    private function formatInterview($iv)
    {
        return (object) [
            'id'              => $iv->id,
            'candidate_name'  => $iv->application->full_name,
            'job_title'       => $iv->application->job->title,
            'date_label'      => $this->formatLabel($iv->interview_date),
            'date_formatted'  => $iv->interview_date->format('d M Y'),
            'start_time'      => Carbon::parse($iv->start_time)->format('g:i A'),
            'end_time'        => Carbon::parse($iv->end_time)->format('g:i A'),
            'status_text'     => ucfirst(str_replace('_', ' ', $iv->status)),
            'status_badge'    => $this->getBadgeClass($iv->status),
        ];
    }

    private function formatLabel(Carbon $date)
    {
        if ($date->isToday()) return 'Today';
        if ($date->isYesterday()) return 'Yesterday';
        if ($date->isFuture()) return $date->diffForHumans(['parts' => 1, 'syntax' => Carbon::DIFF_RELATIVE_TO_NOW]);
        return $date->diffForHumans(['parts' => 1]);
    }

    private function getBadgeClass(string $status): string
    {
        return match ($status) {
            'pending'   => 'bg-secondary',
            'in_review'=> 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default     => 'bg-warning',
        };
    }
}
