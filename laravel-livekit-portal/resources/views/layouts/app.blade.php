<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LiveKit Meet - Blade</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen">
    @php
        $currentUser = Auth::guard('web')->user() ?? Auth::guard('teacher')->user() ?? Auth::guard('student')->user();
    @endphp
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="flex-shrink-0">
                        <img src="/images/livekit-meet-home.svg" alt="LiveKit Meet" class="h-8 w-auto">
                    </a>
                    @if($currentUser)
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                Courses
                            </a>
                            @if(Auth::guard('web')->check() && $currentUser->is_admin)
                                <div class="flex items-center space-x-2 border-l border-gray-700 pl-4">
                                    <span class="text-xs uppercase tracking-wide text-gray-400">Admin</span>
                                    <a href="{{ route('admin.categories.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                        Categories
                                    </a>
                                    <a href="{{ route('admin.teachers.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                        Teachers
                                    </a>


                                     </a>
                                     <a href="{{ route('admin.enrollments.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                         Enrollments
                                     </a>
                                 </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-4">
                    @if($currentUser)
                        <span class="text-gray-400 text-sm">Hi, {{ $currentUser->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium text-white transition duration-150 ease-in-out">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 bg-green-500/10 border border-green-500/50 text-green-400 p-4 rounded-lg flex items-center shadow-lg">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-lg flex items-center shadow-lg">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @php
                $isStudentPage = Auth::guard('student')->check() && (Route::currentRouteName() === 'dashboard' || Route::currentRouteName() === 'courses.index');
                $studentEnrollments = [];
                if ($isStudentPage) {
                    $studentEnrollments = \App\Models\Enrollment::where('student_id', Auth::guard('student')->id())
                        ->with('category')
                        ->where('status', 'approved')
                        ->where(function ($query) {
                            $query->whereNull('expires_at')
                                  ->orWhere('expires_at', '>', now());
                        })
                        ->get();
                }
            @endphp

            <div class="{{ $isStudentPage ? 'flex flex-col lg:flex-row gap-8' : '' }}">
                @if($isStudentPage && $studentEnrollments->isNotEmpty())
                    {{-- Student Sidebar --}}
                    <aside class="lg:w-80 flex-shrink-0">
                        <div class="sticky top-10 space-y-6">
                            <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden shadow-xl">
                                <div class="bg-indigo-600 px-6 py-4">
                                    <h3 class="text-sm font-bold uppercase tracking-widest text-white flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        My Academy Access
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-6">
                                        @foreach($studentEnrollments as $enrollment)
                                            @php
                                                $daysLeft = now()->diffInDays($enrollment->expires_at, false);
                                                $isExpiringSoon = $daysLeft <= 5;
                                                $totalDays = $enrollment->validity_days > 0 ? $enrollment->validity_days : 1;
                                                $percentage = max(0, min(100, ($daysLeft / $totalDays) * 100));
                                            @endphp
                                            <div class="group">
                                                <div class="flex justify-between items-start mb-2">
                                                    <h4 class="text-sm font-bold text-white group-hover:text-indigo-400 transition">{{ $enrollment->category->name }}</h4>
                                                </div>
                                                <div class="flex justify-between items-center mb-1.5">
                                                    <span class="text-[10px] uppercase font-semibold text-gray-500">Days Left</span>
                                                    <span class="text-xs font-bold {{ $isExpiringSoon ? 'text-orange-400' : 'text-indigo-400' }}">
                                                        {{ floor($daysLeft) }}
                                                    </span>
                                                </div>
                                                <div class="w-full bg-gray-700/50 rounded-full h-1.5 mb-2">
                                                    <div class="h-1.5 rounded-full {{ $isExpiringSoon ? 'bg-orange-500' : 'bg-indigo-500' }} transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <p class="text-[10px] text-gray-500 italic">
                                                    Ends {{ $enrollment->expires_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            @if(!$loop->last)
                                                <hr class="border-gray-700/50">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="bg-gray-900/50 px-6 py-4 border-t border-gray-700">
                                    <a href="{{ route('home.load') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition flex items-center justify-center">
                                        Browse More Courses
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </aside>
                @endif

                <div class="flex-1">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</body>
</html>
