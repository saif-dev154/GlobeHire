<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;

class CandidateJobsController extends Controller
{
    /**
     * Display a listing of active jobs.
     */
    public function index()
    {
        $jobs = Job::where('status', 'active')
                   ->latest()
                   ->get();

        return view('candidate.pages.jobs.index', compact('jobs'));
    }

    /**
     * Display the specified job (only if active).
     * Route-model binding will auto-inject the Job.
     */
    public function show(Job $job)
    {
        // ensure only active jobs are viewable
        if ($job->status !== 'active') {
            abort(404);
        }

        $agents = $job->agent_ids
            ? User::whereIn('id', $job->agent_ids)->get()
            : collect();

        return view('candidate.pages.jobs.show', compact('job', 'agents'));
    }
}
