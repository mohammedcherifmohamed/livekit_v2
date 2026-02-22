@extends('layouts.app')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500 mb-6 uppercase tracking-tighter">
            Real-time video for everyone
        </h1>
        <p class="text-xl text-gray-400 mb-10 leading-relaxed">
            Scalable, high-quality video conferencing built with Laravel and LiveKit. <br>
            Connect with your team instantly, no installation required.
        </p>

        <div class="flex justify-center gap-6">
            @auth
                <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-lg font-semibold transition shadow-lg shadow-indigo-500/20">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-lg font-semibold transition shadow-lg shadow-indigo-500/20">
                    Get Started for Free
                </a>
                <a href="{{ route('login') }}" class="px-8 py-3 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg text-lg font-semibold transition">
                    Sign In
                </a>
            @endauth
        </div>

        {{-- Features section --}}
        <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700">
                <div class="h-12 w-12 bg-indigo-500/20 rounded-lg flex items-center justify-center mb-4 text-indigo-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-lg font-bold mb-2 uppercase">HD Video</h3>
                <p class="text-gray-400 text-sm">Crystal clear video powered by LiveKit's advanced WebRTC stack.</p>
            </div>
            <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700">
                <div class="h-12 w-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4 text-purple-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <h3 class="text-lg font-bold mb-2 uppercase">Secure</h3>
                <p class="text-gray-400 text-sm">Encrypted communication and robust Laravel authentication.</p>
            </div>
            <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700">
                <div class="h-12 w-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-4 text-green-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-lg font-bold mb-2 uppercase">Fast</h3>
                <p class="text-gray-400 text-sm">Optimized for low latency and high participant counts.</p>
            </div>
        </div>
    </div>
</div>
@endsection
