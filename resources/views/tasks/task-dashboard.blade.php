@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Task Dashboard</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <p><strong>Task Name:</strong> {{ $task->name }}</p>
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p><strong>Assigned To:</strong> {{ $task->assignee->name ?? 'Unassigned' }}</p>
        <p><strong>Phase(s):</strong> 
    {{ $task->phases->isNotEmpty() ? $task->phases->pluck('name')->join(', ') : 'No phase assigned' }}
</p>


        <p><strong>Deadline:</strong> {{ $task->deadline ?? 'No deadline' }}</p>
    </div>
</div>
        
        <!-- Comments Section -->
        <h2 class="text-lg font-semibold mt-4">Comments</h2>
        <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $task->name }}</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <p><strong>Description:</strong> {{ $task->description }}</p>
        
        <h2 class="text-lg font-semibold mt-4">Comments</h2>
        <div class="mt-2">
            @foreach($task->comments as $comment)
                <div class="bg-gray-100 p-2 rounded mb-2">
                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                </div>
            @endforeach
        </div>

        
        <!-- Add Comment Form -->
        <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <textarea name="content" class="w-full p-2 border rounded" placeholder="Add a comment" required></textarea>

            <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add Comment</button>
        </form>
    </div>
</div>
@endsection
