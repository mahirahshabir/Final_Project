@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-2xl p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-4 text-center">Create New Project</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                 class="bg-green-500 text-white p-3 rounded-md mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Project Creation Form --}}
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Project Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Status</label>
                <select name="status" class="w-full border p-2 rounded focus:ring focus:ring-blue-300">
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Project Manager</label>
                <select name="manager_id" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" required>
                    <option value="">Select Manager</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Create Project</button>
        </form>
    </div>
@endsection

