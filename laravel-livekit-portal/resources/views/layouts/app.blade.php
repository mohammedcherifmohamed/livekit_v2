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
                                    <a href="{{ route('admin.students.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                         Students
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

            @yield('content')
        </div>
    </main>
</body>
</html>
