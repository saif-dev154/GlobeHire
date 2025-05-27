<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show Register Page
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

       $user=User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'candidate', // default role
            'status'   => 'active',    // default status
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        // Redirect based on role
    return match ($user->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'employer'  => redirect()->route('employer.dashboard'),
        'agent'     => redirect()->route('agent.dashboard'),
        default     => redirect()->route('candidate.dashboard'),
    };
    }

    // Show Login Page
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'inactive') {
            return back()->withErrors(['email' => 'Your account is deactivated.']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'employer':
                    return redirect()->route('employer.dashboard');
                case 'agent':
                    return redirect()->route('agent.dashboard');
                case 'candidate':
                    return redirect()->route('candidate.dashboard');
                default:
                    return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ]);
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
