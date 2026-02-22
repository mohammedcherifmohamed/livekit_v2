@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('courses.index') }}" class="text-gray-400 hover:text-white transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-extrabold tracking-tight">Create New Course</h1>
    </div>

    <div class="rounded-xl bg-gray-800/60 border border-gray-700 p-8">
        <form method="POST" action="{{ route('courses.store') }}" class="space-y-6">
            @csrf

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-1.5">
                    Course Title <span class="text-red-400">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                       placeholder="e.g. Introduction to Mathematics"
                       class="block w-full rounded-lg border @error('title') border-red-500 @else border-gray-600 @enderror bg-gray-700 px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition">
                @error('title')
                    <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">
                    Description <span class="text-gray-500 font-normal">(optional)</span>
                </label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Briefly describe what this course covers…"
                          class="block w-full rounded-lg border @error('description') border-red-500 @else border-gray-600 @enderror bg-gray-700 px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Room Name --}}
            <div>
                <label for="room_name" class="block text-sm font-medium text-gray-300 mb-1.5">
                    Room Name (slug) <span class="text-red-400">*</span>
                </label>
                <div class="flex items-center rounded-lg border @error('room_name') border-red-500 @else border-gray-600 @enderror bg-gray-700 overflow-hidden focus-within:border-indigo-500 transition">
                    <span class="px-3 py-3 text-gray-500 text-sm select-none">/rooms/</span>
                    <input type="text" id="room_name" name="room_name" value="{{ old('room_name') }}"
                           placeholder="my-course-room"
                           class="flex-1 bg-transparent py-3 pr-4 text-white placeholder-gray-500 text-sm focus:outline-none">
                </div>
                <p class="mt-1.5 text-xs text-gray-500">Letters, numbers and hyphens only. Must be unique.</p>
                @error('room_name')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 pt-2">
                <button type="submit"
                        class="flex-1 flex justify-center py-3 px-4 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-sm font-semibold text-white transition shadow-lg shadow-indigo-500/20">
                    Create Course
                </button>
                <a href="{{ route('courses.index') }}"
                   class="flex-1 flex justify-center py-3 px-4 rounded-lg border border-gray-600 hover:border-gray-500 text-sm font-semibold text-gray-300 hover:text-white transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
