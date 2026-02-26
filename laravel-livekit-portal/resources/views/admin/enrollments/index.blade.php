@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Course Enrollments</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-800 shadow overflow-hidden sm:rounded-md border border-gray-700">
        <ul class="divide-y divide-gray-700">
            @forelse($enrollments as $enrollment)
                <li>
                    <div class="px-6 py-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="text-white flex-1">
                            <h2 class="text-xl font-semibold text-indigo-400">
                                {{ $enrollment->student->name ?? 'Unknown Student' }}
                            </h2>
                            <p class="text-sm text-gray-400 flex items-center mt-1">
                                <span class="bg-gray-700 px-2 py-0.5 rounded mr-2 text-gray-300">Course:</span>
                                {{ $enrollment->category->name ?? 'N/A' }}
                            </p>
                            <div class="mt-2 flex items-center gap-3">
                                <span class="text-xs px-2 py-1 rounded font-bold uppercase tracking-wider {{ 
                                    $enrollment->status === 'approved' ? 'bg-green-900/50 text-green-400 border border-green-500/30' : 
                                    ($enrollment->status === 'rejected' ? 'bg-red-900/50 text-red-400 border border-red-500/30' : 'bg-yellow-900/50 text-yellow-400 border border-yellow-500/30') 
                                }}">
                                    {{ $enrollment->status }}
                                </span>
                                @if($enrollment->expires_at)
                                    <span class="text-xs text-gray-500 italic">
                                        Expires: {{ \Carbon\Carbon::parse($enrollment->expires_at)->format('M d, Y') }} 
                                        ({{ \Carbon\Carbon::parse($enrollment->expires_at)->diffForHumans() }})
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                            @if($enrollment->status === 'pending')
                                <form action="{{ route('admin.enrollments.approve', $enrollment) }}" method="POST" class="flex items-center bg-gray-900 p-2 rounded-lg border border-gray-700 shadow-inner">
                                    @csrf
                                    <input type="number" name="validity_days" placeholder="Days" required min="1" 
                                           class="w-20 bg-gray-800 border-gray-700 text-white rounded px-2 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500 mr-2">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1.5 px-4 rounded text-sm transition shadow-lg">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.enrollments.reject', $enrollment) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-1.5 px-4 rounded text-sm transition">
                                        Reject
                                    </button>
                                </form>
                            @elseif($enrollment->status === 'approved')
                                <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST" class="flex items-center bg-gray-800 p-2 rounded-lg border border-gray-700 shadow-inner">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="validity_days" value="{{ $enrollment->validity_days }}" required min="1" 
                                           class="w-20 bg-gray-700 border-gray-600 text-white rounded px-2 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500 mr-2">
                                    <button type="submit" class="flex items-center text-sm font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Update
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST"
                                  onsubmit="return confirm('Delete this enrollment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-10 text-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    No enrollments found.
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
