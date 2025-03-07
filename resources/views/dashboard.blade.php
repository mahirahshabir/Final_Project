@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Task Board</h1>

    <!-- Kanban Board -->
    <div id="kanbanBoard" class="flex overflow-x-auto gap-6 p-4 bg-gray-100 rounded-lg shadow-lg">
        @foreach($phases as $phase)
        <div id="phase-{{ $phase->id }}" class="w-80 bg-gray-50 p-4 rounded-lg shadow-md flex-shrink-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">{{ $phase->name }}</h2>
            </div>

            <!-- Task List -->
            <div class="task-list min-h-[300px] bg-white p-4 rounded-lg shadow-inner space-y-6 border border-gray-200"
                data-phase="{{ $phase->id }}">
                @foreach($phase->tasks as $task)
                <div class="task bg-white p-4 rounded-lg shadow cursor-move border border-gray-300 hover:shadow-lg hover:bg-gray-100 transition-transform transform hover:scale-105"
                    data-task-id="{{ $task->id }}" data-phase="{{ $phase->id }}">
                    <a href="{{ route('tasks.show', $task->id) }}" class="text-black " onclick="window.location.href=this.href; return false;">
                            {{ $task->name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>



<!-- Include SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const addPhaseContainer = document.getElementById("addPhaseContainer");

        document.querySelectorAll(".task-list").forEach(taskList => {
        new Sortable(taskList, {
            group: "tasks",
            animation: 150,
            onEnd: function (evt) {
             let taskId = evt.item.dataset.taskId;
            let newPhaseId = evt.to.dataset.phase;

            console.log(`Task ${taskId} moved to Phase ${newPhaseId}`); // Debugging

            fetch("{{ route('update-task-phase') }}", {
              method: "POST",
               headers: {
               "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
            body: JSON.stringify({
             task_id: taskId,
             phase_id: newPhaseId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Task updated successfully!");
        } else {
            alert("Error updating task: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong. Please try again.");
    });
}

        });
    });





    });
</script>
@endsection
