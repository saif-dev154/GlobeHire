<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Interview;
use App\Models\VisaDocument;
use App\Models\FlightSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index()
    {
        $agentId = Auth::id();
        $now     = now();

        // ── Applications ───────────────────────────────────────────
        $totalAssigned = Application::where('assigned_agent_id', $agentId)->count();
        $pendingCount  = Application::where('assigned_agent_id', $agentId)->where('status', 'pending')->count();

        $recentApplications = Application::where('assigned_agent_id', $agentId)
            ->with(['job', 'candidate'])
            ->latest()
            ->take(6)
            ->get();

        // ── Interviews (reusing AgentInterviewsController logic) ───
        $all = Interview::where('agent_id', $agentId)
            ->with(['application.job', 'application.candidate'])
            ->get()
            ->map(fn($iv) => $this->formatInterviewData($iv, $now));

        $upcomingInterviews = $all->filter(
            fn($d) => $this->isUpcoming($d, $now) && $d['model']->status === 'pending'
        )->take(3)->values();

        $upcomingCount  = $all->filter(fn($d) => $this->isUpcoming($d, $now) && $d['model']->status === 'pending')->count();
        $passCount      = $all->filter(fn($d) => $d['model']->status === 'pass')->count();
        $failCount      = $all->filter(fn($d) => $d['model']->status === 'fail')->count();
        $postponedCount = $all->filter(fn($d) => $d['model']->status === 'postponed')->count();

        // ── Visa Documents ─────────────────────────────────────────
        $recentVisas = VisaDocument::whereHas('contract.interview', fn($q) => $q->where('agent_id', $agentId))
            ->with('contract.interview.application.candidate')
            ->latest()
            ->take(4)
            ->get();

        $visaInReview = VisaDocument::whereHas('contract.interview', fn($q) => $q->where('agent_id', $agentId))
            ->where('status', 'inreview')
            ->count();

        // ── Flight Schedules ───────────────────────────────────────
        $recentFlights = FlightSchedule::whereHas('visaDocument.contract.interview', fn($q) => $q->where('agent_id', $agentId))
            ->with('visaDocument.contract.interview.application.candidate')
            ->latest('departure_datetime')
            ->take(4)
            ->get();

        return view('agent.Dashboard', compact(
            'totalAssigned',
            'pendingCount',
            'recentApplications',
            'upcomingInterviews',
            'upcomingCount',
            'passCount',
            'failCount',
            'postponedCount',
            'recentVisas',
            'visaInReview',
            'recentFlights',
        ));
    }

    // ── Helpers (copied from AgentInterviewsController) ────────────

    private function formatInterviewData(Interview $iv, Carbon $now): array
    {
        $date  = $iv->interview_date;
        $start = Carbon::parse("{$date->format('Y-m-d')} {$iv->start_time}");
        $end   = Carbon::parse("{$date->format('Y-m-d')} {$iv->end_time}");
        $p     = $this->getInterviewProgress($start, $end, $now);

        return [
            'model'         => $iv,
            'startFmt'      => $start->format('g:i A'),
            'endFmt'        => $end->format('g:i A'),
            'start'         => $start,
            'end'           => $end,
            'progress'      => $p['progress'],
            'progressBadge' => $p['progressBadge'],
        ];
    }

    private function isUpcoming(array $d, Carbon $now): bool
    {
        $end = $d['model']->interview_date->format('Y-m-d') . ' ' . $d['model']->end_time;
        return $end >= $now->format('Y-m-d H:i');
    }

    private function getInterviewProgress(Carbon $start, Carbon $end, Carbon $now): array
    {
        if ($now->lt($start)) {
            return ['progress' => 'Pending',     'progressBadge' => 'bg-secondary'];
        } elseif ($now->between($start, $end)) {
            return ['progress' => 'In Progress', 'progressBadge' => 'bg-info'];
        }
        return ['progress' => 'Ended',       'progressBadge' => 'bg-danger'];
    }
}