@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-white tracking-tight">
            Admin Access Portal
        </h2>
        <p class="mt-2 text-center text-sm text-gray-400">
            Secure authentication for system administrators
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-gray-800 py-8 px-4 shadow-2xl border border-gray-700 sm:rounded-2xl sm:px-10">
            @if ($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-lg text-xs">
                    <ul class="list-none text-center">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="admin">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">
                        Administrator Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="appearance-none block w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl shadow-sm placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition sm:text-sm"
                            placeholder="admin@portal.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="appearance-none block w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl shadow-sm placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition sm:text-sm"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                            class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-600 bg-gray-900 rounded transition">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-400">
                            Remember session
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200">
                        Authenticate Securely
                    </button>
                </div>
            </form>

            <div class="mt-6 border-t border-gray-700 pt-6">
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-xs font-medium text-gray-500 hover:text-indigo-400 transition uppercase tracking-widest">
                        Return to Public Portals
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
