<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class CandidateApplicationController extends Controller
{
    
    public function index()
    {
        // fetch only the current user's applications, latest first
        $applications = Application::where('candidate_id', Auth::id())
                                   ->with('job')
                                   ->latest()
                                   ->get();

        return view('candidate.pages.candidateapplications.index', compact('applications'));
    }





    public function create($jobId)
    {
        $job = Job::where('id', $jobId)
                  ->where('status', 'active')
                  ->firstOrFail();

        // ensure required_skills is array
        if (is_string($job->required_skills)) {
            $decoded = json_decode($job->required_skills, true);
            $job->required_skills = is_array($decoded) ? $decoded : [];
        }

        return view('candidate.pages.candidateapplications.create', compact('job'));
    }

    /**
     * Handle the submission of a job application.
     */
    public function store(Request $request, $jobId)
    {
        $job = Job::where('id', $jobId)
              ->where('status', 'active')
              ->firstOrFail();

    // ←─── Prevent duplicate applications ────←
    if (Application::where('job_id', $job->id)
                   ->where('candidate_id', Auth::id())
                   ->exists()) {
        return redirect()
               ->route('candidate.applications.index')
               ->with('error', 'You have already applied for this job.');
    }

        $request->validate([
            'skills'               => 'required|array|min:1',
            'skills.*'             => 'string|max:100',
            'full_name'            => 'required|string|max:255',
            'date_of_birth'        => 'required|date|before:today',
            'gender'               => 'required|in:male,female,other',
            'nationality'          => 'required|string|max:100',
            'email'                => 'required|email|max:255',
            'phone'                => 'required|string|max:20',
            'address'              => 'required|string',
            'country'              => 'required|string|max:100',
            'highest_degree'       => 'required|string|max:50',
            'institution'          => 'required|string|max:255',
            'field_of_study'       => 'required|string|max:100',
            'graduation_date'      => 'nullable|date|before_or_equal:today',
            'years_experience'     => 'required|integer|min:0',
            'last_employer'        => 'nullable|string|max:255',
            'last_position'        => 'nullable|string|max:255',
            'employment_duration'  => 'nullable|string|max:100',
            'cover_letter'         => 'nullable|string',
            'linkedin'             => 'nullable|url|max:255',
            'portfolio'            => 'nullable|url|max:255',
            'resume'               => 'required|file|mimes:pdf,doc,docx|max:2048',
            'other_docs.*'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // randomly assign one of the job's agents
        $agentIds = $job->agent_ids ?: [];
        $assignedAgentId = !empty($agentIds)
            ? collect($agentIds)->random()
            : null;

        // build data
        $data = [
            'job_id'              => $job->id,
            'candidate_id'             => Auth::id(),
            'assigned_agent_id'   => $assignedAgentId,
            'status'              => 'pending',
            'skills'              => $request->skills,
            'full_name'           => $request->full_name,
            'date_of_birth'       => $request->date_of_birth,
            'gender'              => $request->gender,
            'nationality'         => $request->nationality,
            'email'               => $request->email,
            'phone'               => $request->phone,
            'address'             => $request->address,
            'country'             => $request->country,
            'highest_degree'      => $request->highest_degree,
            'institution'         => $request->institution,
            'field_of_study'      => $request->field_of_study,
            'graduation_date'     => $request->graduation_date,
            'years_experience'    => $request->years_experience,
            'last_employer'       => $request->last_employer,
            'last_position'       => $request->last_position,
            'employment_duration' => $request->employment_duration,
            'cover_letter'        => $request->cover_letter,
            'linkedin'            => $request->linkedin,
            'portfolio'           => $request->portfolio,
        ];

        // store attachments
        $data['resume_path'] = $request->file('resume')->store('resumes', 'public');
        $otherPaths = [];
        if ($request->hasFile('other_docs')) {
            foreach ($request->file('other_docs') as $doc) {
                $otherPaths[] = $doc->store('applications/other_docs', 'public');
            }
        }
        $data['other_docs_paths'] = $otherPaths;

        // create application
        Application::create($data);

        return redirect()
               ->route('candidate.jobs.index')
               ->with('success', 'Your application has been submitted successfully.');
    }





     public function show($id)
    {
        $application = Application::where('id', $id)
                                  ->where('candidate_id', Auth::id())
                                  ->with('job', 'assignedAgent')
                                  ->firstOrFail();

        return view('candidate.pages.candidateapplications.show', compact('application'));
    }
}
