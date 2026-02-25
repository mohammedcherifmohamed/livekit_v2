<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('teacher')->check() || auth()->guard('teacher')->user()->status !== 'approved') {
            abort(403, 'Only approved teachers can access this section.');
        }

        return $next($request);
    }
}

