@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Teacher Requests</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-700">
            @forelse($teachers as $teacher)
                <li>
                    <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                        <div class="text-white">
                            <h2 class="text-lg font-medium">
                                {{ $teacher->user->name ?? 'N/A' }}
                            </h2>
                            <p class="text-sm text-gray-400">
                                {{ $teacher->user->email ?? 'No email' }}
                            </p>
                            <p class="text-sm mt-1">
                                Status:
                                <span class="font-semibold">
                                    {{ ucfirst($teacher->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            @if($teacher->status === 'pending')
                                <form action="{{ route('admin.teachers.approve', $teacher) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.teachers.reject', $teacher) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Reject
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">
                                    No actions available
                                </span>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-4 text-gray-400">No teacher requests found.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

