<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminAgentsController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['agent'])->latest()->get();
        return view('admin.pages.usermanagment.agentlist', compact('users'));
    }
}
