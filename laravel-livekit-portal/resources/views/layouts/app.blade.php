<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LiveKit Meet - Blade</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0">
                        <img src="/images/livekit-meet-home.svg" alt="LiveKit Meet" class="h-8 w-auto">
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">Courses</a>
                        <span class="text-gray-400 text-sm">Hi, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium text-white transition duration-150 ease-in-out">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>
