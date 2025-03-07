@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Task Details</h1>

        <p class="text-gray-700 font-semibold">Task Name:</p>
        <p class="bg-green-100 text-green-700 px-3 py-1 rounded-md inline-block">{{ $task->name }}</p>

        <p class="text-gray-700 font-semibold">Description:</p>
        <p class="bg-green-100 text-green-700 px-3 py-1 rounded-md inline-block mb-2">{{ $task->description }}</p>

       <p class="text-gray-700 font-semibold">Status:</p>
  @php
    $latestPhase = $task->phases->sortByDesc('created_at')->first();
  @endphp
    <p class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md inline-block">
    {{ $latestPhase ? $latestPhase->status : 'Not Set' }}
     </p>
        

        <p class="text-gray-700 font-semibold">Due Date:</p>
        <p class="text-gray-600">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not Set' }}</p>

        <p class="text-gray-700 font-semibold">Created By:</p>
        <p class="text-gray-600">{{ $task->user->name ?? 'Unknown' }}</p>

        <p class="text-gray-700 font-semibold">Created At:</p>
        <p class="text-gray-600">{{ $task->created_at->format('M d, Y H:i') }}</p>
    </div>
</div>



    <!-- Assignee Section -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <p class="text-lg font-semibold text-gray-700 mb-2">Assigned To</p>
        <form id="assignee-form" method="POST" action="{{ route('tasks.assignUser', $task->id) }}">
            @csrf
            @method('PUT')
            <select name="assignee_id" class="border border-gray-300 rounded-lg px-4 py-2 bg-white w-full focus:ring-2 focus:ring-blue-400">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assignee_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-800 px-4 py-2 rounded-lg shadow-md w-full">Assign</button>
        </form>
    </div>
</div>

<!-- Comments Section -->
<div class="container mx-auto p-6 bg-white rounded-xl shadow-lg mt-6 border border-gray-200">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Comments</h2>
    <div id="comments-section" class="max-h-[60vh] overflow-y-auto bg-gray-50 p-4 rounded-lg shadow-sm">
        @if($task->comments->isEmpty())
            <p class="text-gray-600 text-center">No comments yet.</p>
        @else
            @foreach($task->comments as $comment)
            <div class="flex items-start gap-3 p-3 bg-white rounded-lg shadow-md hover:shadow-lg mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-gray-700 font-semibold">{{ $comment->user->name }}</p>
                    <p class="text-gray-600 text-sm">{{ $comment->content }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <form id="comment-form" action="{{ route('tasks.addComment', $task->id) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="content" class="w-full p-3 border border-gray-300 rounded-md resize-none focus:ring focus:ring-blue-300" placeholder="Write a comment..." required></textarea>
        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md shadow-md w-full">Add Comment</button>
    </form>
</div>
@endsection
