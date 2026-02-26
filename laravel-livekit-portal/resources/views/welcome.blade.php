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

        {{-- Categories Section --}}
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-white mb-10 text-center uppercase tracking-widest">Explore Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($categories as $category)
                    <div class="group bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 hover:border-indigo-500/50 transition-all duration-300 shadow-xl flex flex-col">
                        {{-- Category Image --}}
                        <div class="relative h-32 overflow-hidden">
                            <img src="{{ $category->image ?? 'https://via.placeholder.com/800x400?text=' . urlencode($category->name) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-50 h-50 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-tighter shadow-lg">
                                    ${{ number_format($category->price, 2) }}
                                </span>
                            </div>
                        </div>

                        {{-- Category Content --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-indigo-400 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">
                                {{ $category->description ?? 'No description available for this category yet.' }}
                            </p>
                            
                            <div class="mt-auto flex items-center justify-between">
                                <a href="{{ route('categories.show', $category) }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-semibold text-sm transition group-hover:translate-x-1 duration-200">
                                    View Courses
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                                <span class="text-gray-600 text-xs font-mono uppercase">
                                    {{ $category->courses_count ?? $category->courses()->count() }} Sessions
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
