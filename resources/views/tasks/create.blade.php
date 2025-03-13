@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Create New Task</h2>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Task Name</label>
            <input type="text" name="name" required class="border border-gray-300 rounded-lg px-4 py-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Description</label>
            <textarea name="description" class="border border-gray-300 rounded-lg px-4 py-2 w-full"></textarea>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
            <input type="date" name="deadline" id="deadline"
                   class="mt-1 p-2 border rounded w-full"
                   required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Select Project</label>
            <select name="project_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
                <option value="">-- Select a Project --</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md">
            Create Task
        </button>
    </form>
</div>
@endsection
