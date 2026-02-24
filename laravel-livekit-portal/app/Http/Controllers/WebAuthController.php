<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class WebAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = (bool) $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            // Preserve the intended URL before session regeneration wipes it
            $intendedUrl = $request->session()->pull('url.intended');
            $request->session()->regenerate();

            $user = Auth::user();

            // Non-admin teachers/students must be approved before accessing the dashboard
            if (!$user->is_admin && $user->role !== null && !$user->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending admin approval.',
                ])->onlyInput('email');
            }

            if ($intendedUrl) {
                $request->session()->put('url.intended', $intendedUrl);
            }
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:teacher,student'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_approved' => false,
        ]);

        if ($validated['role'] === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        } else {
            Student::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('login')->with('status', 'Registration submitted. Please wait for admin approval before logging in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
