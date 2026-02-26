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

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,teacher,student'],
        ]);

        $remember = (bool) $request->input('remember', false);
        $role = $credentials['role'];
        unset($credentials['role']);

        // Determine which guard to use
        $guard = match($role) {
            'teacher' => 'teacher',
            'student' => 'student',
            default => 'web',
        };

        // If it's teacher or student, check if they are approved
        if ($role === 'teacher') {
            $teacher = Teacher::where('email', $credentials['email'])->first();
            if ($teacher && $teacher->status !== 'approved') {
                return back()->withErrors([
                    'email' => 'Your teacher account is pending admin approval.',
                ])->onlyInput('email');
            }
        } elseif ($role === 'student') {
            // Students can always login to see their name/browse, 
            // the 'check_enrollment' middleware handles dashboard access.
        }

        \Log::info("Login attempt for role: {$role} with email: {$credentials['email']}");

        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            \Log::info("Login successful for guard: {$guard}");
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        \Log::warning("Login failed for guard: {$guard} and email: {$credentials['email']}");
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records for the selected role.',
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

        // Ensure email is not already used in pending teacher/student records
        if (Teacher::where('email', $validated['email'])->exists() || Student::where('email', $validated['email'])->exists()) {
            return back()->withErrors([
                'email' => 'This email is already registered and awaiting approval.',
            ])->onlyInput('email');
        }

        if ($validated['role'] === 'teacher') {
            Teacher::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => 'pending',
            ]);
        } else {
            Student::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => 'approved', // Auto-approved
            ]);
        }

        return redirect()->route('login')->with('success', 'Registration successful. You can now log in and enroll in courses.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('teacher')->logout();
        Auth::guard('student')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
