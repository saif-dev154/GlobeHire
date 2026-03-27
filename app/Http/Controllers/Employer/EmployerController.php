<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Contract;
use App\Models\Interview;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function index()
    {
        $employerId = Auth::id();

        // ── Jobs ──────────────────────────────────────────────────
        $jobs = Job::where('employer_id', $employerId)
            ->withCount('applications')
            ->oldest()
            ->take(6)
            ->get();

        $totalJobs        = Job::where('employer_id', $employerId)->count();
        $totalApplications = Application::whereHas('job', fn($q) => $q->where('employer_id', $employerId))->count();

        // ── Interviews (passed = status 'pass', from EmployerInterviewsController logic) ──
        $passedInterviews = Interview::where('status', 'pass')
            ->whereHas('application', fn($q) => $q->where('status', 'approved'))
            ->whereHas('application.job', fn($q) => $q->where('employer_id', $employerId))
            ->count();

        // ── Shortlisted ───────────────────────────────────────────
        $shortlistedInterviews = Interview::where('status', 'pass')
            ->whereHas('application', fn($q) => $q->where('status', 'shortlisted'))
            ->whereHas('application.job', fn($q) => $q->where('employer_id', $employerId))
            ->with(['application.candidate', 'application.job'])
            ->latest()
            ->take(5)
            ->get();

        $shortlistedCount = Interview::where('status', 'pass')
            ->whereHas('application', fn($q) => $q->where('status', 'shortlisted'))
            ->whereHas('application.job', fn($q) => $q->where('employer_id', $employerId))
            ->count();

        // ── Contracts (using EmployerContractsController logic) ───
        $baseContracts = Contract::whereHas('interview.application.job', fn($q) => $q->where('employer_id', $employerId));

        $totalContracts    = (clone $baseContracts)->count();
        $createdContracts  = (clone $baseContracts)->where('status', 'created')->count();
        $signedContracts   = (clone $baseContracts)->where('status', 'signed')->count();
        $approvedContracts = (clone $baseContracts)->where('status', 'approved')->count();
        $rejectedContracts = (clone $baseContracts)->where('status', 'rejected')->count();

        $recentContracts = (clone $baseContracts)
            ->with(['interview.application.candidate', 'interview.application.job'])
            ->latest()
            ->take(4)
            ->get();

        return view('employer.Dashboard', compact(
            'jobs',
            'totalJobs',
            'totalApplications',
            'passedInterviews',
            'shortlistedInterviews',
            'shortlistedCount',
            'totalContracts',
            'createdContracts',
            'signedContracts',
            'approvedContracts',
            'rejectedContracts',
            'recentContracts',
        ));
    }
}