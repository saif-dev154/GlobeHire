<?php
// app/Http/Controllers/Employer/EmployerJobsController.php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployerJobsController extends Controller
{
    public function index()
    {
        $jobs = Job::where('employer_id', Auth::id())
                   ->oldest()
                   ->get();

        return view('employer.pages.JobManagement.index', compact('jobs'));
    }

    public function create()
    {
        $agents = User::where('role', 'agent')->get();

        // ensure $job is defined in the view
        $job = null;

        return view('employer.pages.JobManagement.create', compact('agents', 'job'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                    => 'required|string|max:255',
            'location'                 => 'required|string|max:255',
            'description'              => 'required|string',
            'required_skills'          => 'required|array|min:1',
            'required_skills.*'        => 'string|max:100',
            'salary'                   => 'required|numeric',
            'salary_structure'         => 'required|string|in:hourly,daily,weekly,monthly,yearly,project',
            'job_type'                 => 'required|string|in:full-time,part-time,contract,temporary,internship,freelance',
            'experience_level'         => 'required|string|in:entry,mid,senior,manager,executive',
            'education'                => 'required|string|in:high_school,diploma,associate,bachelor,master,phd',
            'status'                   => 'required|in:pending,active,closed',
            'application_start_date'   => 'required|date',
            'application_deadline'     => 'required|date|after_or_equal:application_start_date',
            'gender'                   => 'required|in:male,female,any,other',
            'visa_sponsor'             => 'required|boolean',
            'agent_ids'                => 'required|array|min:1',
            'agent_ids.*'              => 'exists:users,id',
        ]);

        Job::create([
            'employer_id'             => Auth::id(),
            'title'                   => $request->title,
            'location'                => $request->location,
            'description'             => $request->description,
            'required_skills'         => json_encode($request->required_skills),
            'salary'                  => $request->salary,
            'salary_structure'        => $request->salary_structure,
            'job_type'                => $request->job_type,
            'experience_level'        => $request->experience_level,
            'education'               => $request->education,
            'status'                  => $request->status,
            'application_start_date'  => $request->application_start_date,
            'application_deadline'    => $request->application_deadline,
            'gender'                  => $request->gender,
            'visa_sponsor'            => $request->visa_sponsor,
            'agent_ids'              => array_map('intval', $request->agent_ids),
        ]);

        return redirect()
               ->route('employer.jobs.index')
               ->with('success', 'Job posted successfully.');
    }

    public function edit($id)
    {
        $job = Job::where('id', $id)
                  ->where('employer_id', Auth::id())
                  ->firstOrFail();

        // decode JSON fields
        $job->required_skills = json_decode($job->required_skills, true) ?: [];
        $job->agent_ids       = json_decode($job->agent_ids, true) ?: [];

        $agents = User::where('role', 'agent')->get();

        return view('employer.pages.JobManagement.create', compact('job', 'agents'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::where('id', $id)
                  ->where('employer_id', Auth::id())
                  ->firstOrFail();

        $request->validate([
            'title'                    => 'required|string|max:255',
            'location'                 => 'required|string|max:255',
            'description'              => 'required|string',
            'required_skills'          => 'required|array|min:1',
            'required_skills.*'        => 'string|max:100',
            'salary'                   => 'required|numeric',
            'salary_structure'         => 'required|string|in:hourly,daily,weekly,monthly,yearly,project',
            'job_type'                 => 'required|string|in:full-time,part-time,contract,temporary,internship,freelance',
            'experience_level'         => 'required|string|in:entry,mid,senior,manager,executive',
            'education'                => 'required|string|in:high_school,diploma,associate,bachelor,master,phd',
            'status'                   => 'required|in:pending,active,closed',
            'application_start_date'   => 'required|date',
            'application_deadline'     => 'required|date|after_or_equal:application_start_date',
            'gender'                   => 'required|in:male,female,any,other',
            'visa_sponsor'             => 'required|boolean',
            'agent_ids'                => 'required|array|min:1',
            'agent_ids.*'              => 'exists:users,id',
        ]);

        $job->update([
            'title'                   => $request->title,
            'location'                => $request->location,
            'description'             => $request->description,
            'required_skills'         => json_encode($request->required_skills),
            'salary'                  => $request->salary,
            'salary_structure'        => $request->salary_structure,
            'job_type'                => $request->job_type,
            'experience_level'        => $request->experience_level,
            'education'               => $request->education,
            'status'                  => $request->status,
            'application_start_date'  => $request->application_start_date,
            'application_deadline'    => $request->application_deadline,
            'gender'                  => $request->gender,
            'visa_sponsor'            => $request->visa_sponsor,
            'agent_ids'              => array_map('intval', $request->agent_ids),
        ]);

        return redirect()
               ->route('employer.jobs.index')
               ->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $job = Job::where('id', $id)
                  ->where('employer_id', Auth::id())
                  ->firstOrFail();

        $job->delete();

        return redirect()
               ->route('employer.jobs.index')
               ->with('success', 'Job deleted successfully.');
    }

 public function show($id)
{
    $job = Job::where('id', $id)
              ->where('employer_id', Auth::id())
              ->firstOrFail();

    // Auto-close if past deadline
    if ($job->application_deadline && $job->application_deadline->lt(now()) && $job->status !== 'closed') {
        $job->update(['status' => 'closed']);
    }

    // Ensure required_skills is an array (decode if it's a JSON string)
    if (is_string($job->required_skills)) {
        $job->required_skills = json_decode($job->required_skills, true) ?: [];
    }

    // Ensure agent_ids is an array (decode if it's a JSON string)
    if (is_string($job->agent_ids)) {
        $job->agent_ids = json_decode($job->agent_ids, true) ?: [];
    }

    $agents = User::whereIn('id', $job->agent_ids)->get();

    return view('employer.pages.JobManagement.show', compact('job', 'agents'));
}



}
