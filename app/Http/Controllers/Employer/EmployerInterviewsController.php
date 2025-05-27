<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerInterviewsController extends Controller
{
    /** Show all passed interviews */
   public function passed()
{
    $passed = Interview::where('status', 'pass')
    ->whereHas('application', function ($query) {
        $query->where('status', 'approved'); // Only include applications with status "approved"
    })
    ->with(['application.job'])
    ->get();


    return view('employer.pages.interviews.index', compact('passed'));
}


    /** Mark the application as shortlisted */
    public function shortlist(int $id)
    {
        $iv  = Interview::with('application')->findOrFail($id);
        $app = $iv->application;
        $app->status = 'shortlisted';
        $app->save();

        return redirect()
            ->route('employer.interviews.passed')
            ->with('success','Candidate shortlisted.');
    }

    /** Mark the application as rejected */
    

public function reject(Request $request, int $id)
{
    // Validate that remarks were provided
    $data = $request->validate([
        'remarks' => 'required|string|max:500',
    ]);

    $iv  = Interview::with('application')->findOrFail($id);
    $app = $iv->application;

    // Update application status and save remarks
    $app->status  = 'rejected';
    $app->remarks = $data['remarks'];
    $app->save();

    return redirect()
        ->route('employer.interviews.passed')
        ->with('success','Candidate rejected with remarks.');
}




public function shortlisted()
{
    $shortlisted = Interview::where('status', 'pass')
        ->whereHas('application', function ($q) {
            $q->where('status', 'shortlisted');
        })
        ->with(['application.job', 'contract']) // now valid
        ->get();

    return view('employer.pages.interviews.shortlisted', compact('shortlisted'));
}




}
