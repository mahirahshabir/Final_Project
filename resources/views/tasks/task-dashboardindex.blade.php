@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Dashboard</h2>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 text-left">Task</th>
                <th class="p-2 text-left">Status</th>
                <th class="p-2 text-left">Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr class="border-b">
                <td class="p-2">{{ $task->name }}</td>
                <td class="p-2 text-blue-700" id="task-status-{{ $task->id }}">
                    {{ $task->phase ? $task->phase->status : 'Not Set' }}
                </td>
                <td class="p-2">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not Set' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
