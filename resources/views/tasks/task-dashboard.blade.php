
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Task Details</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">{{ $task->name }}</h2>
        <p class="text-gray-600"><strong>Description:</strong> {{ $task->description }}</p>

        <p><strong>Assigned To:</strong></p>
        <form method="POST" action="{{ route('tasks.assignUser', $task->id) }}">
            @csrf
            <select name="assignee_id" class="border rounded px-3 py-1">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assignee_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Assign</button>
        </form>

        <p><strong>Phase(s):</strong></p>
        <form method="POST" action="{{ route('tasks.assignPhase', $task->id) }}">
            @csrf
            <select name="phase_id[]" class="border rounded px-3 py-1" multiple>
                @foreach($phases as $phase)
                    <option value="{{ $phase->id }}" {{ $task->phases->contains($phase->id) ? 'selected' : '' }}>
                        {{ $phase->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Update</button>
        </form>

        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800">Comments</h2>
            <div id="comments-section" class="mt-4 space-y-3 max-h-60 overflow-y-auto">
                @foreach($task->comments as $comment)
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-700"><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            <form id="comment-form" class="mt-4">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <textarea id="comment-content" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Add a comment..." required></textarea>
                <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition">Add Comment</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Comment Form AJAX
        document.getElementById("comment-form").addEventListener("submit", function(e) {
            e.preventDefault();
            let content = document.getElementById("comment-content").value;
            fetch("{{ route('comments.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ task_id: "{{ $task->id }}", content: content })
            })
            .then(response => response.json())
            .then(data => {
                let commentSection = document.getElementById("comments-section");
                let newComment = document.createElement("div");
                newComment.classList.add("bg-gray-100", "p-3", "rounded-lg", "shadow-sm");
                newComment.innerHTML = `<p class="text-sm text-gray-700"><strong>${data.user_name}:</strong> ${data.content}</p>`;
                commentSection.prepend(newComment);
                document.getElementById("comment-content").value = "";
            });
        });
    });
</script>
@endsection