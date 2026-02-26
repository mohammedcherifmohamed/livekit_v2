<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEnrollmentValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('student')->check()) {
            $student = auth()->guard('student')->user();
            
            // Check if student has any approved enrollment that is not expired
            $hasValidEnrollment = \App\Models\Enrollment::where('student_id', $student->id)
                ->where('status', 'approved')
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->exists();

            if (!$hasValidEnrollment) {
                // If they have enrollments but all are expired or pending
                $message = 'Your enrollment has expired or is pending approval. Please contact the administrator.';
                
                // If they are trying to access the dashboard, redirect them back or to a specific page
                return redirect()->route('home.load')->with('error', $message);
            }
        }

        return $next($request);
    }
}
