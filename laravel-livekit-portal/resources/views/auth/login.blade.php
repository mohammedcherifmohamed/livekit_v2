@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center pt-8">
    <div class="w-full max-w-md space-y-8 rounded-xl bg-gray-800 p-10 shadow-lg border border-gray-700">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-white">Sign in to your account</h2>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <input name="email" type="email" required value="{{ old('email') }}"
                        class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Email address">
                </div>
                <div>
                    <input name="password" type="password" required
                        class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Password">
                </div>
            </div>

            @if ($errors->any())
                <div class="text-red-500 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="text-green-500 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 rounded border-gray-600 text-indigo-600 focus:ring-indigo-500 bg-gray-700">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Sign in
                </button>
            </div>

            <div class="text-center text-sm">
                <a href="{{ route('register') }}" class="font-medium text-indigo-500 hover:text-indigo-400">
                    Don't have an account? Register here
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
