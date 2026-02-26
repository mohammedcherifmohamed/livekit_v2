@extends('layouts.app')

@section('content')
<div class="space-y-8">
    {{-- Meeting Section --}}
    {{-- Meeting Section --}}
    <div class="bg-gray-800 rounded-xl p-8 shadow-lg border border-gray-700">
        <div class="max-w-2xl mx-auto text-center">
            <h1 class="text-4xl font-extrabold mb-4">Welcome to LiveKit Meet</h1>
            <p class="text-gray-400 mb-8">Start or join a secure, high-quality video conference.</p>

            <form onsubmit="event.preventDefault(); window.location.href='/meet/' + document.getElementById('roomName').value" class="space-y-4">
                <div>
                    <input type="text" id="roomName" required
                        class="block w-full rounded-md border-gray-600 bg-gray-700 px-4 py-3 text-white placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg"
                        placeholder="Enter Room Name (e.g. my-awesome-meeting)">
                </div>
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Join Meeting
                </button>
            </form>
        </div>
    </div>

    {{-- Student Enrolled Courses Section --}}
    @if(auth()->guard('student')->check())
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                My Enrolled Courses
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($enrollments as $enrollment)
                    @php
                        $daysLeft = now()->diffInDays($enrollment->expires_at, false);
                        $isExpiringSoon = $daysLeft <= 5;
                    @endphp
                    <div class="bg-gray-800 rounded-xl overflow-hidden border {{ $isExpiringSoon ? 'border-orange-500/50' : 'border-gray-700' }} shadow-lg transition hover:scale-[1.02]">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-white leading-tight">
                                    {{ $enrollment->category->name ?? 'Course Name' }}
                                </h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-400">Time remaining:</span>
                                        <span class="font-bold {{ $isExpiringSoon ? 'text-orange-400' : 'text-indigo-400' }}">
                                            {{ floor($daysLeft) }} Days
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        @php
                                            $totalDays = $enrollment->validity_days > 0 ? $enrollment->validity_days : 1;
                                            $percentage = max(0, min(100, ($daysLeft / $totalDays) * 100));
                                        @endphp
                                        <div class="h-2 rounded-full {{ $isExpiringSoon ? 'bg-orange-500' : 'bg-indigo-600' }}" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>

                                <div class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Expires on {{ $enrollment->expires_at->format('M d, Y') }}
                                </div>

                                <a href="{{ route('categories.show', $enrollment->category->slug ?? $enrollment->category_id) }}" 
                                   class="block w-full text-center py-2 px-4 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-sm font-semibold transition">
                                    View Course Content
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-800 rounded-xl p-10 text-center border border-dashed border-gray-700">
                        <p class="text-gray-500">You haven't enrolled in any approved courses yet.</p>
                        <a href="{{ route('home.load') }}" class="mt-4 inline-block text-indigo-400 hover:text-indigo-300 font-semibold text-sm">
                            Browse available courses &rarr;
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
@endsection
