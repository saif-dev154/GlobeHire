<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentApplicationsController extends Controller
{
    /**
     * Display a list of applications assigned to the logged-in agent.
     */
    public function index()
    {
        $apps = Application::where('assigned_agent_id', Auth::id())
            ->with(['job', 'candidate'])
            ->latest()
            ->get();

        return view('agent.pages.AssignedApplications.index', compact('apps'));
    }

    /**
     * Display a specific application assigned to the logged-in agent.
     */
    public function show($id)
    {
        $app = Application::where('id', $id)
            ->where('assigned_agent_id', Auth::id())
            ->with(['job', 'candidate'])
            ->firstOrFail();

        return view('agent.pages.AssignedApplications.show', compact('app'));
    }

    /**
     * Reject the application with remarks.
     */
    public function reject(Request $request, $id)
    {
        $app = Application::where('id', $id)
            ->where('assigned_agent_id', Auth::id())
            ->firstOrFail();

        // Validate input
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        // Update status
        $app->update([
            'status' => 'rejected',
            'remarks' => $request->input('remarks'),
        ]);

        return redirect()
            ->route('agent.applications.show', $app->id)
            ->with('success', 'Application rejected with your remarks.');
    }
}
