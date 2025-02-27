@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Dashboard</h1>

    <!-- Assignee & Project Dropdowns -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <select class="border p-2 rounded">
                <option>Select Assignee</option>
                @foreach($users as $user)
                    <option>{{ $user->name ?? 'No Name' }}</option>
                @endforeach
            </select>

            <select class="border p-2 rounded">
                <option>Select Project</option>
                @foreach($projects as $project)
                    <option>{{ $project->name ?? 'No Project' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <!-- Kanban Board with Dynamic Phases -->
    <div class="flex overflow-x-auto space-x-4" x-data="taskDragDrop()">
        @foreach($phases as $phase)
        <div class="bg-gray-100 p-4 rounded shadow min-w-[250px]">
            <h2 class="text-lg font-bold mb-2 text-center">{{ $phase->name }}</h2>
            <div class="task-list min-h-[100px] bg-white p-2 rounded shadow"
                 :data-phase="{{ $phase->id }}"
                 id="phase-{{ $phase->id }}"
                 x-ref="phase{{ $phase->id }}">
                @foreach($phase->tasks as $task)
                    <div class="task bg-blue-100 p-2 rounded shadow mb-2 cursor-move"
                         data-task-id="{{ $task->id }}">
                        {{ $task->name }}
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function taskDragDrop() {
        return {
            init() {
                let taskLists = document.querySelectorAll(".task-list");

                taskLists.forEach((list) => {
                    new Sortable(list, {
                        group: "tasks",
                        animation: 150,
                        onEnd: (evt) => {
                            let taskId = evt.item.getAttribute("data-task-id");
                            let newPhaseId = evt.to.getAttribute("data-phase");

                            fetch("{{ route('update-task-phase') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({ task_id: taskId, phase_id: newPhaseId }),
                            }).then(response => response.json())
                              .then(data => console.log("Task updated:", data))
                              .catch(error => console.error("Error:", error));
                        },
                    });
                });
            }
        };
    }
</script>
@endsection
