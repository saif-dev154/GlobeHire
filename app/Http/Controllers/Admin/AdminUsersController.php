<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    // Display all users (employer and agent only)
    public function index()
    {
       $users = User::whereIn('role', ['candidate'])->latest()->get();
        return view('admin.pages.usermanagment.index', compact('users'));
    }

    // Show create user form
    public function create()
    {
        return view('admin.pages.usermanagment.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:employer,agent',
        ]);

        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'status'            => 'active',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.create')->with('success', 'User created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.usermanagment.create', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:employer,agent',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
   public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return back()->with('success', 'User deleted successfully.');
}

public function toggleStatus($id)
{
    $user = User::findOrFail($id);

    $user->status = $user->status === 'active' ? 'inactive' : 'active';
    $user->save();

    return back()->with('success', 'User status updated successfully.');
}


}
