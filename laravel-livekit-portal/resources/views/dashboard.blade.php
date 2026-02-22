@extends('layouts.app')

@section('content')
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
@endsection
