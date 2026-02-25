@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Student Requests</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-700">
            @forelse($students as $student)
                <li>
                    <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                        <div class="text-white">
                            <h2 class="text-lg font-medium">
                                {{ $student->user->name ?? $student->name ?? 'N/A' }}
                            </h2>
                            <p class="text-sm text-gray-400">
                                {{ $student->user->email ?? $student->email ?? 'No email' }}
                            </p>
                            <p class="text-sm mt-1">
                                Status:
                                <span class="font-semibold">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            @if($student->status === 'pending')
                                {{-- Approve --}}
                                <form action="{{ route('admin.students.approve', $student) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Approve
                                    </button>
                                </form>
                                {{-- Disapprove (soft cancel) --}}
                                <form action="{{ route('admin.students.reject', $student) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Disapprove
                                    </button>
                                </form>
                            @elseif($student->status === 'approved')
                                {{-- Disapprove / deactivate an approved student --}}
                                <form action="{{ route('admin.students.reject', $student) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Disapprove
                                    </button>
                                </form>
                            @endif

                            {{-- Hard delete for any status --}}
                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to permanently delete this student account?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-gray-800 hover:bg-gray-900 text-red-300 hover:text-red-200 font-bold py-1 px-3 rounded text-sm border border-red-500/60">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-4 text-gray-400">No student requests found.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

