@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pt-8 px-4">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold text-white tracking-tight">Portal Sign In</h2>
        <p class="mt-2 text-gray-400">Welcome back! Please select your portal and sign in.</p>
    </div>

    @if ($errors->any())
        <div class="mb-8 max-w-md mx-auto bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg text-sm text-center">
            <ul class="list-none">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-8 max-w-md mx-auto bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-lg text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Student Portal -->
        <div class="bg-gray-800 rounded-2xl p-8 shadow-2xl border border-gray-700 hover:border-indigo-500/50 transition-all group">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-white group-hover:text-indigo-400 transition-colors">Student Portal</h3>
                    <p class="text-gray-400 text-sm mt-1">Access your courses and join live sessions.</p>
                </div>
                <div class="p-3 bg-indigo-500/10 rounded-xl">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="role" value="student">
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Email Address</label>
                    <input name="email" type="email" required value="{{ old('role') == 'student' ? old('email') : '' }}"
                        class="block w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        placeholder="student@example.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Password</label>
                    <input name="password" type="password" required
                        class="block w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center pt-2">
                    <input id="remember-student" name="remember" type="checkbox"
                        class="h-4 w-4 rounded border-gray-600 text-indigo-600 focus:ring-indigo-500 bg-gray-900 transition">
                    <label for="remember-student" class="ml-2 block text-sm text-gray-400">Stay signed in</label>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-indigo-600/20 active:scale-[0.98]">
                    Student Sign In
                </button>
            </form>
        </div>

        <!-- Teacher Portal -->
        <div class="bg-gray-800 rounded-2xl p-8 shadow-2xl border border-gray-700 hover:border-emerald-500/50 transition-all group">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-white group-hover:text-emerald-400 transition-colors">Teacher Portal</h3>
                    <p class="text-gray-400 text-sm mt-1">Manage your classes and start new sessions.</p>
                </div>
                <div class="p-3 bg-emerald-500/10 rounded-xl">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9l-3 3 3 3m4 0l3-3-3-3" />
                    </svg>
                </div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="role" value="teacher">
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Professional Email</label>
                    <input name="email" type="email" required value="{{ old('role') == 'teacher' ? old('email') : '' }}"
                        class="block w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        placeholder="teacher@school.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Password</label>
                    <input name="password" type="password" required
                        class="block w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center pt-2">
                    <input id="remember-teacher" name="remember" type="checkbox"
                        class="h-4 w-4 rounded border-gray-600 text-emerald-600 focus:ring-emerald-500 bg-gray-900 transition">
                    <label for="remember-teacher" class="ml-2 block text-sm text-gray-400">Stay signed in</label>
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-emerald-600/20 active:scale-[0.98]">
                    Teacher Sign In
                </button>
            </form>
        </div>
    </div>

    <div class="mt-12 text-center space-y-4">
        <div class="text-gray-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-indigo-400 hover:text-indigo-300 transition underline underline-offset-4">Register here</a>
        </div>
        
        <div class="pt-8 border-t border-gray-800">
            <a href="{{ route('admin.login') }}" 
               class="text-xs text-gray-500 hover:text-gray-300 uppercase tracking-widest transition">
                Super Admin Access
            </a>
        </div>
    </div>
</div>
@endsection
