@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center pt-8">
    <div class="w-full max-w-md space-y-8 rounded-xl bg-gray-800 p-10 shadow-lg border border-gray-700">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-white">Create your account</h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Choose whether you are registering as a student or a teacher. Your account will be reviewed by an admin.
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <input name="name" type="text" required value="{{ old('name') }}"
                        class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Full Name">
                </div>
                <div>
                    <input name="email" type="email" required value="{{ old('email') }}"
                        class="relative block w-full appearance-none rounded-none border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Email address">
                </div>
                <div class="mb-3">
                    <label for="role" class="block text-sm font-medium text-gray-300 mb-1">
                        Register as
                    </label>
                    <select id="role" name="role" required
                        class="relative block w-full appearance-none rounded-md border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select role</option>
                        <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                    </select>
                </div>
                <div class="mt-3">
                    <input name="password" type="password" required
                        class="relative block w-full appearance-none rounded-none border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Password">
                </div>
                <div>
                    <input name="password_confirmation" type="password" required
                        class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Confirm Password">
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

            <div>
                <button type="submit"
                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Register
                </button>
            </div>

            <div class="text-center text-sm">
                <a href="{{ route('login') }}" class="font-medium text-indigo-500 hover:text-indigo-400">
                    Already have an account? Sign in here
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
