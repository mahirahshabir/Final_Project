@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- Dashboard Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Dashboard</h1>
        <div>
            <select class="border p-2 rounded">
                <option>Select Assignee</option>
                <option>User 1</option>
                <option>User 2</option>
            </select>
            <select class="border p-2 rounded">
                <option>Select Project</option>
                <option>Project A</option>
                <option>Project B</option>
            </select>
        </div>
    </div>
    
    <!-- Kanban Board -->
    <div class="grid grid-cols-4 gap-4">
        @foreach(['To Do', 'Progress', 'Testing', 'Review'] as $status)
        <div class="bg-gray-100 p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-2">{{ $status }}</h2>
            <div class="space-y-2">
                <div class="bg-white p-2 rounded shadow">Task 1</div>
                <div class="bg-white p-2 rounded shadow">Task 2</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Task Details Section -->
    <div class="bg-white shadow-md rounded p-4 mt-6">
        <h2 class="text-lg font-bold">Task Details</h2>
        <input type="text" placeholder="Task Title" class="border p-2 w-full my-2 rounded">
        <textarea placeholder="Description" class="border p-2 w-full my-2 rounded"></textarea>
        
        <label class="block mt-2">Deadline:</label>
        <input type="date" class="border p-2 w-full rounded">
        
        <div class="flex items-center gap-4 mt-4">
            <label class="flex items-center">
                <input type="checkbox" class="mr-2"> Is Paid Work
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="mr-2"> Outside Dev
            </label>
            <label class="flex items-center">
                <input type="checkbox" class="mr-2"> Business Logic
            </label>
        </div>

        <div class="mt-4">
            <label>Is Completed?</label>
            <div class="flex gap-4">
                <label class="flex items-center">
                    <input type="radio" name="completed" value="yes" class="mr-2"> Yes
                </label>
                <label class="flex items-center">
                    <input type="radio" name="completed" value="no" class="mr-2"> No
                </label>
            </div>
        </div>

        <button class="bg-blue-500 text-white p-2 rounded mt-4 w-full">Save</button>
    </div>
</div>
@endsection
