<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class AdminEmployersController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['employer'])->latest()->get();
        return view('admin.pages.usermanagment.employerlist', compact('users'));
    }
}
