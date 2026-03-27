<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers      = User::count();
        $totalEmployers  = User::where('role', 'employer')->count();
        $totalAgents     = User::where('role', 'agent')->count();
        $totalCandidates = User::where('role', 'candidate')->count();
        $recentUsers     = User::latest()->take(5)->get();

        return view('admin.Dashboard', compact(
            'totalUsers',
            'totalEmployers',
            'totalAgents',
            'totalCandidates',
            'recentUsers',
        ));
    }
}