@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumbs --}}
    <nav class="flex mb-8 text-sm text-gray-500 uppercase tracking-widest font-mono">
        <a href="{{ url('/') }}" class="hover:text-white transition">Home</a>
        <span class="mx-3">/</span>
        <span class="text-indigo-400">Category Details</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        {{-- Left Column: Image and Description --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="relative h-[250px] w-full rounded-3xl overflow-hidden shadow-2xl border border-gray-700">
                <img src="{{ $category->image ?? 'https://via.placeholder.com/1200x600?text=' . urlencode($category->name) }}" 
                     alt="{{ $category->name }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 left-8">
                    <h1 class="text-5xl font-extrabold text-white tracking-tighter">{{ $category->name }}</h1>
                    <div class="mt-4 flex items-center gap-4">
                        <span class="px-4 py-1.5 bg-indigo-600 rounded-full text-sm font-bold shadow-lg shadow-indigo-600/40">
                            ${{ number_format($category->price, 2) }}
                        </span>
                        <span class="text-gray-300 text-sm font-medium">
                            {{ $courses->count() }} Live Sessions Available
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/40 rounded-3xl p-8 border border-gray-700/50 backdrop-blur-sm">
                <h2 class="text-2xl font-bold text-white mb-6 uppercase tracking-tight">About this Category</h2>
                <p class="text-gray-300 text-lg leading-relaxed">
                    {{ $category->description ?? 'Explore deep insights and practical knowledge in the field of ' . $category->name . '. This category is designed to provide comprehensive coverage of industry-standard practices and cutting-edge techniques.' }}
                </p>
            </div>

            <div class="bg-gray-800/40 rounded-3xl p-8 border border-gray-700/50 backdrop-blur-sm">
                <h2 class="text-2xl font-bold text-white mb-6 uppercase tracking-tight italic">Live Sessions Now</h2>
                @if($courses->isEmpty())
                    <div class="text-center py-12 border border-dashed border-gray-700 rounded-2xl">
                        <p class="text-gray-500 italic">No active sessions for this category at the moment. Enroll to get notified when new sessions launch!</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($courses as $course)
                            <div class="bg-gray-900/60 p-5 rounded-2xl border border-gray-700 hover:border-indigo-500/50 transition">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-2 py-0.5 rounded-full bg-green-500/20 text-green-300 uppercase tracking-widest">
                                        <span class="h-1 w-1 rounded-full bg-green-400 animate-pulse"></span> Live
                                    </span>
                                </div>
                                <h4 class="font-bold text-white mb-1">{{ $course->title }}</h4>
                                <p class="text-xs text-gray-500 uppercase tracking-tighter">Instructor: {{ $course->teacher->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Enrollment Card --}}
        <div class="lg:col-span-1">
            <div class="sticky top-24 bg-gray-800 rounded-3xl p-8 border border-indigo-500/30 shadow-2xl shadow-indigo-500/10">
                <div class="mb-8">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Investment</div>
                    <div class="text-5xl font-black text-white">${{ number_format($category->price, 2) }}</div>
                </div>

                <div class="space-y-6 mb-10">
                    <div class="flex items-start gap-4 text-gray-300">
                        <div class="mt-1 p-1 bg-green-500/10 rounded-full">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm">Full access to all live sessions in this category</span>
                    </div>
                    <div class="flex items-start gap-4 text-gray-300">
                        <div class="mt-1 p-1 bg-green-500/10 rounded-full">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm">Direct engagement with certified instructors</span>
                    </div>
                    <div class="flex items-start gap-4 text-gray-300">
                        <div class="mt-1 p-1 bg-green-500/10 rounded-full">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm">Real-time collaboration tools & HD video</span>
                    </div>
                </div>

                @if($isEnrolled)
                    <div class="w-full bg-green-500/20 text-green-400 font-bold py-4 rounded-2xl text-center border border-green-500/30">
                        ✓ Enrolled Successfully
                    </div>
                    <a href="{{ route('courses.index') }}" class="block text-center mt-4 text-indigo-400 hover:text-indigo-300 text-sm font-medium transition">
                        Go to My Learning Dashboard →
                    </a>
                @else
                    <form action="{{ route('categories.enroll', $category) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-5 rounded-2xl transition duration-300 shadow-xl shadow-indigo-600/30 active:scale-[0.98]">
                            Enroll Now
                        </button>
                    </form>
                    <p class="mt-4 text-[10px] text-gray-500 text-center uppercase tracking-widest leading-relaxed">
                        By enrolling, you agree to our Terms of Academy Access.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
