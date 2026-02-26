@extends('layouts.app')

@section('content')
<div class="space-y-10">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="px-5 py-3 rounded-lg bg-green-500/20 border border-green-500/40 text-green-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Page header --}}
    @php
        $user = Auth::guard('web')->user() ?? Auth::guard('teacher')->user() ?? Auth::guard('student')->user();
        $isTeacher = Auth::guard('teacher')->check();
        $isApprovedTeacher = $isTeacher && $user->status === 'approved';
    @endphp
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">
                {{ $isTeacher ? 'My Teaching Dashboard' : 'Courses' }}
            </h1>
            <p class="text-gray-400 mt-1 text-sm">
                @if($isTeacher)
                    Create courses, attach them to categories, and launch live sessions for your students.
                @else
                    Browse and join live courses that are currently running.
                @endif
            </p>
        </div>
        @if($isApprovedTeacher)
            <a href="{{ route('courses.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-semibold transition shadow-lg shadow-indigo-500/20">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Course
            </a>
        @endif
    </div>

    {{-- ── MY COURSES (teacher dashboard) ── --}}
    @if($isTeacher)
        <section>
            <h2 class="text-lg font-bold uppercase tracking-wider text-indigo-400 mb-4 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-indigo-400 inline-block"></span>
                My Courses
            </h2>

            @if($myCourses->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-700 p-10 text-center text-gray-500">
                    You have no courses yet.
                    @if($isApprovedTeacher)
                        <a href="{{ route('courses.create') }}" class="text-indigo-400 hover:underline ml-1">Create one →</a>
                    @else
                        <span class="block text-xs text-gray-500 mt-2">Your teacher account is pending approval.</span>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($myCourses as $course)
                        <div class="flex flex-col justify-between rounded-xl bg-gray-800/60 border border-gray-700 p-6 hover:border-indigo-500/50 transition">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    @if($course->is_active)
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/20 text-green-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-400 animate-pulse"></span> Live
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-700 text-gray-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Not launched
                                        </span>
                                    @endif
                                    <span class="text-xs text-gray-500 font-mono">{{ $course->room_name }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-white mb-1">{{ $course->title }}</h3>
                                @if($course->category)
                                    <span class="inline-block px-2 py-1 bg-gray-700 text-gray-300 text-xs rounded mb-2">{{ $course->category->name }}</span>
                                @endif
                                @if($course->description)
                                    <p class="text-sm text-gray-400 line-clamp-2">{{ $course->description }}</p>
                                @endif
                            </div>

                            <div class="mt-5 flex flex-col gap-3">
                                <div class="flex gap-3">
                                    @if($course->is_active)
                                        {{-- Rejoin button --}}
                                        <form method="POST" action="{{ route('courses.launch', $course) }}" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="w-full flex justify-center items-center gap-2 py-2.5 bg-green-600 hover:bg-green-700 rounded-lg text-sm font-semibold transition">
                                                Join Session
                                            </button>
                                        </form>
                                        {{-- End button --}}
                                        <form method="POST" action="{{ route('courses.end', $course) }}" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="w-full flex justify-center items-center gap-2 py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-sm font-semibold transition">
                                                End
                                            </button>
                                        </form>
                                    @else
                                        {{-- Launch button --}}
                                        <form method="POST" action="{{ route('courses.launch', $course) }}" class="flex-1">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="w-full flex justify-center items-center gap-2 py-2.5 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-semibold transition">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.586-3.91A1 1 0 007 8.118v7.764a1 1 0 001.166.98l6.586-1.31A1 1 0 0016 14.572v-2.404a1 1 0 00-.248-.672z"/>
                                                </svg>
                                                Launch
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="flex gap-3">
                                    <a href="{{ route('courses.edit', $course) }}"
                                       class="flex-1 flex justify-center items-center py-2.5 px-4 rounded-lg border border-gray-600 hover:border-gray-500 text-sm font-semibold text-gray-300 hover:text-white transition">
                                        Edit
                                    </a>

                                    @if(!$course->is_active)
                                        <form method="POST" action="{{ route('courses.destroy', $course) }}" class="flex-1"
                                              onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full flex justify-center items-center gap-2 py-2.5 bg-gray-800 hover:bg-gray-900 rounded-lg text-sm font-semibold text-red-300 hover:text-red-200 border border-red-500/60">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    {{-- ── STUDENT COURSES ── --}}
    @if(!$isTeacher)
        <section>
            <h2 class="text-lg font-bold uppercase tracking-wider text-indigo-400 mb-6 flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-indigo-400 inline-block"></span>
                My Course Sessions
            </h2>
    
            @if($activeCourses->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-700 p-10 text-center text-gray-500">
                    You aren't enrolled in any courses with available sessions.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($activeCourses as $course)
                        <div class="flex flex-col justify-between rounded-xl bg-gray-800/60 border {{ $course->is_active ? 'border-green-500/40 shadow-lg shadow-green-500/5' : 'border-gray-700' }} p-6 transition-all duration-300 hover:scale-[1.01]">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    @if($course->is_active)
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-green-500/20 text-green-300 border border-green-500/30">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-400 animate-pulse"></span> Live Now
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-gray-700/50 text-gray-400 border border-gray-600/30">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span> Offline
                                        </span>
                                    @endif
                                    @if($course->category)
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ $course->category->name }}</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-white mb-0.5">{{ $course->title }}</h3>
                                <p class="text-sm text-indigo-400/80 font-mono mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4a1 1 0 011-1h2a1 1 0 011 1v3M12 7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Room: {{ $course->room_name }}
                                </p>

                                @if($course->description)
                                    <p class="text-sm text-gray-400 line-clamp-2 mb-4">{{ $course->description }}</p>
                                @endif
                                
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="h-6 w-6 rounded-full bg-indigo-900/50 border border-indigo-500/30 flex items-center justify-center text-[10px] text-indigo-300 font-bold">
                                        {{ substr($course->teacher->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs text-gray-400 italic">by {{ $course->teacher->name }}</span>
                                </div>

                                {{-- Enrollment Validity Info --}}
                                @if(isset($course->enrollment) && $course->enrollment->expires_at)
                                    @php
                                        $daysLeft = now()->diffInDays($course->enrollment->expires_at, false);
                                        $isExpiringSoon = $daysLeft <= 5;
                                    @endphp
                                    <div class="mt-4 pt-4 border-t border-gray-700/50">
                                        <div class="flex justify-between items-center mb-1.5">
                                            <span class="text-[10px] uppercase font-bold tracking-wider text-gray-500">Access Until</span>
                                            <span class="text-[10px] font-bold {{ $isExpiringSoon ? 'text-orange-400' : 'text-indigo-400' }}">
                                                {{ floor($daysLeft) }} Days Remaining
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-700/50 rounded-full h-1">
                                            @php
                                                $totalDays = $course->enrollment->validity_days > 0 ? $course->enrollment->validity_days : 1;
                                                $percentage = max(0, min(100, ($daysLeft / $totalDays) * 100));
                                            @endphp
                                            <div class="h-1 rounded-full {{ $isExpiringSoon ? 'bg-orange-500' : 'bg-indigo-500' }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
    
                            <div class="mt-6">
                                @if($course->is_active)
                                    <a href="{{ route('room.show', $course->room_name) }}"
                                       class="w-full flex justify-center items-center gap-2 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-bold transition shadow-lg shadow-green-900/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Join Live Session
                                    </a>
                                @else
                                    <button disabled
                                            class="w-full flex justify-center items-center gap-2 py-3 bg-gray-700/50 text-gray-500 cursor-not-allowed rounded-lg text-sm font-bold border border-gray-600/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Waiting for Teacher
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

</div>
@endsection
