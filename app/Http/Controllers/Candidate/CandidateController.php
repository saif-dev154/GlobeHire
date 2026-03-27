<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Contract;
use App\Models\Interview;
use App\Models\VisaDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function index()
    {
        $candidateId = Auth::id();
        $now         = now();

        // ── Applications (CandidateApplicationController logic) ────
        $totalApplications = Application::where('candidate_id', $candidateId)->count();
        $pendingCount      = Application::where('candidate_id', $candidateId)->where('status', 'pending')->count();

        $recentApplications = Application::where('candidate_id', $candidateId)
            ->with('job')
            ->latest()
            ->take(6)
            ->get();

        // ── Interviews (CandidateInterviewController logic) ────────
        $interviews = Interview::whereHas('application', fn($q) =>
            $q->where('candidate_id', $candidateId)
        )->with(['application.job'])->get();

        $upcomingInterviews = $interviews->filter(fn($iv) =>
            $iv->interview_date->format('Y-m-d') . ' ' . $iv->end_time >= $now->format('Y-m-d H:i')
        )->sortBy('interview_date')->take(3)->values();

        $upcomingInterviewCount = $interviews->filter(fn($iv) =>
            $iv->interview_date->format('Y-m-d') . ' ' . $iv->end_time >= $now->format('Y-m-d H:i')
        )->count();

        $pastInterviewCount = $interviews->filter(fn($iv) =>
            $iv->interview_date->format('Y-m-d') . ' ' . $iv->end_time < $now->format('Y-m-d H:i')
        )->count();

        $interviewCount = $interviews->count();

        // ── Contracts (CandidateContractsController logic) ─────────
        $contractQuery = Contract::whereHas('interview.application', fn($q) =>
            $q->where('candidate_id', $candidateId)
        );

        $contractCount = $contractQuery->count();
        $signedCount   = (clone $contractQuery)->where('status', 'signed')->count();

        $recentContracts = (clone $contractQuery)
            ->with(['interview.application.job'])
            ->orderBy('contract_date', 'desc')
            ->take(4)
            ->get();

        // ── Visa Documents (CandidateVisaController logic) ─────────
        $recentVisas = VisaDocument::where('candidate_id', $candidateId)
            ->latest()
            ->take(3)
            ->get();

        return view('Candidate.Dashboard', compact(
            'totalApplications',
            'pendingCount',
            'recentApplications',
            'upcomingInterviews',
            'upcomingInterviewCount',
            'pastInterviewCount',
            'interviewCount',
            'contractCount',
            'signedCount',
            'recentContracts',
            'recentVisas',
        ));
    }
}