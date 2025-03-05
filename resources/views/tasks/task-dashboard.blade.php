@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
    
    <!-- Left Panel: Task Details -->
    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-lg">
        <div class="mb-6 border-b border-gray-200 pb-4 sticky top-0 bg-white z-10">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Task Details</h1>
            <h2 class="text-3xl font-semibold text-gray-800 mb-2">{{ $task->name }}</h2>
            <p class="text-gray-600">{{ $task->description }}</p>
        </div>
         <!-- Right Panel: Task Metadata -->
    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg sticky top-20 border border-gray-200">
        <p class="text-gray-700 font-semibold">Status:</p>
        <p class="bg-green-100 text-green-700 px-3 py-1 rounded-md inline-block">In Progress</p>
        <hr class="my-3">
        <p class="text-gray-700 font-semibold">Due Date:</p>
        <p class="text-gray-600">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not Set' }}</p>
        <hr class="my-3">
        <p class="text-gray-700 font-semibold">Created By:</p>
        
        <hr class="my-3">
        <p class="text-gray-700 font-semibold">Created At:</p>
        <p class="text-gray-600">{{ $task->created_at->format('M d, Y H:i') }}</p>
    </div>
</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Assignee Section -->
            <div class="pr-4">
                <p class="text-lg font-semibold text-gray-700 mb-2">Assigned To</p>
                <form id="assignee-form" method="POST" action="{{ route('tasks.assignUser', $task->id) }}" class="mt-2">
                    @csrf
                    @method('PUT')
                    <select name="assignee_id" id="assignee_id" class="border border-gray-300 rounded-lg px-4 py-2 bg-white w-full focus:ring-2 focus:ring-blue-400 hover:bg-gray-100 transition">
                        <option value="">Unassigned</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $task->assignee_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-lg shadow-md flex items-center justify-center gap-2 transition-all w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Assign
                    </button>
                </form>
                <p id="assignee-error" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>

            
            
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
            <div class="flex items-start gap-3 p-3 bg-white rounded-lg shadow-md hover:shadow-lg transition mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" alt="User Avatar" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-gray-700 font-semibold">{{ $comment->user->name }}</p>
                    <p class="text-gray-600 text-sm">{{ $comment->content }}</p>
                    <p class="text-gray-500 text-xs mt-1">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <form id="comment-form" action="{{ route('tasks.addComment', $task->id) }}" method="POST" class="mt-4 flex flex-col">
        @csrf
        <textarea name="content" id="comment-content" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 resize-none hover:border-blue-500 transition" placeholder="Write a comment..." required></textarea>
        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded-md shadow-md flex items-center justify-center gap-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            Add Comment
        </button>
    </form>
    <p id="comment-error" class="text-red-500 text-sm mt-2 hidden"></p>
</div>

<!-- JavaScript for Dynamic Functionality -->
<script>
    // Handle Assignee Form Submission
    document.getElementById('assignee-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const errorElement = document.getElementById('assignee-error');

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Assignee updated successfully!');
                errorElement.classList.add('hidden');
            } else {
                errorElement.textContent = data.message || 'Something went wrong.';
                errorElement.classList.remove('hidden');
            }
        })
        .catch(error => {
            errorElement.textContent = 'An error occurred. Please try again.';
            errorElement.classList.remove('hidden');
        });
    });

    // Handle Phase Form Submission
    document.getElementById('phase-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const errorElement = document.getElementById('phase-error');

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Phases updated successfully!');
                errorElement.classList.add('hidden');
            } else {
                errorElement.textContent = data.message || 'Something went wrong.';
                errorElement.classList.remove('hidden');
            }
        })
        .catch(error => {
            errorElement.textContent = 'An error occurred. Please try again.';
            errorElement.classList.remove('hidden');
        });
    });

    // Handle Comment Form Submission
    document.getElementById('comment-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const errorElement = document.getElementById('comment-error');

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Append the new comment to the comments section
                const commentsSection = document.getElementById('comments-section');
                const commentHtml = `
                    <div class="flex items-start gap-3 p-3 bg-white rounded-lg shadow-md hover:shadow-lg transition mb-3">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.comment.user.name)}&background=random" alt="User Avatar" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="text-gray-700 font-semibold">${data.comment.user.name}</p>
                            <p class="text-gray-600 text-sm">${data.comment.content}</p>
                            <p class="text-gray-500 text-xs mt-1">${new Date(data.comment.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                `;
                commentsSection.insertAdjacentHTML('afterbegin', commentHtml);
                form.reset();
                errorElement.classList.add('hidden');
            } else {
                errorElement.textContent = data.message || 'Something went wrong.';
                errorElement.classList.remove('hidden');
            }
        })
        .catch(error => {
            errorElement.textContent = 'An error occurred. Please try again.';
            errorElement.classList.remove('hidden');
        });
    });
</script>
@endsection