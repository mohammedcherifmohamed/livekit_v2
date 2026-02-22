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
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Courses</h1>
            <p class="text-gray-400 mt-1 text-sm">Manage your courses or join a live session.</p>
        </div>
        <a href="{{ route('courses.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-semibold transition shadow-lg shadow-indigo-500/20">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Course
        </a>
    </div>

    {{-- ── MY COURSES (inactive / not yet launched) ── --}}
    <section>
        <h2 class="text-lg font-bold uppercase tracking-wider text-indigo-400 mb-4 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-indigo-400 inline-block"></span>
            My Courses
        </h2>

        @if($myCourses->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-700 p-10 text-center text-gray-500">
                You have no pending courses.
                <a href="{{ route('courses.create') }}" class="text-indigo-400 hover:underline ml-1">Create one →</a>
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
                            @if($course->description)
                                <p class="text-sm text-gray-400 line-clamp-2">{{ $course->description }}</p>
                            @endif
                        </div>

                        <div class="mt-5 flex gap-3">
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
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ── LIVE NOW (active courses from other users) ── --}}
    <section>
        <h2 class="text-lg font-bold uppercase tracking-wider text-green-400 mb-4 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-green-400 inline-block animate-pulse"></span>
            Live Now
        </h2>

        @if($activeCourses->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-700 p-10 text-center text-gray-500">
                No live sessions right now. Check back later.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($activeCourses as $course)
                    <div class="flex flex-col justify-between rounded-xl bg-gray-800/60 border border-green-500/30 p-6 hover:border-green-400/60 transition">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/20 text-green-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-400 animate-pulse"></span> Live
                                </span>
                                <span class="text-xs text-gray-500 font-mono">{{ $course->room_name }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-1">{{ $course->title }}</h3>
                            @if($course->description)
                                <p class="text-sm text-gray-400 line-clamp-2">{{ $course->description }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-2">by {{ $course->user->name }}</p>
                        </div>

                        <div class="mt-5">
                            <a href="{{ route('room.show', $course->room_name) }}"
                               class="w-full flex justify-center items-center gap-2 py-2.5 bg-green-600 hover:bg-green-700 rounded-lg text-sm font-semibold transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Join Session
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>
@endsection
