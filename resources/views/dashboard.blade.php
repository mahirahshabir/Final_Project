@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Task Board</h1>

    <!-- Kanban Board -->
    <div class="flex overflow-x-auto gap-6 p-4 bg-gray-100 rounded-lg shadow-lg">
        @foreach($phases as $phase)
        <div class="w-80 bg-gray-50 p-4 rounded-lg shadow-md flex-shrink-0">
            <!-- Phase Title -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">{{ $phase->name }}</h2>
                <button class="text-xl">⋮</button> <!-- Options Menu Placeholder -->
            </div>

            <!-- Task List -->
            <div class="task-list min-h-[300px] bg-white p-4 rounded-lg shadow-inner space-y-6 border border-gray-200"
                 data-phase="{{ $phase->id }}"
                 id="phase-{{ $phase->id }}">
                @foreach($phase->tasks as $task)
               <div class="task bg-white p-4 rounded-lg shadow cursor-pointer border border-gray-300 hover:shadow-lg hover:bg-gray-100 transition-transform transform hover:scale-105"
     data-task-id="{{ $task->id }}">
    <p class="text-gray-800 font-medium text-sm">{{ $task->name }}</p>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.task').forEach(task => {
        task.addEventListener('click', function () {
            let taskId = this.getAttribute('data-task-id');
            console.log("Redirecting to task ID:", taskId); // Debugging
            if (taskId) {
                window.location.href = `/tasks/${taskId}`;
            }
        });
    });
});
</script>



                @endforeach
            </div>

            <!-- Add New Task Button -->
            <button class="add-task-btn w-full mt-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 rounded-lg"
                    data-phase-id="{{ $phase->id }}">
                + New Task
            </button>
        </div>
        @endforeach
    </div>
</div>

<!-- Include SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const taskLists = document.querySelectorAll(".task-list");

        // Initialize Drag & Drop for Tasks
        taskLists.forEach((list) => {
            new Sortable(list, {
                group: "tasks",
                animation: 250,
                ghostClass: "bg-gray-300",
                onEnd: async (evt) => {
                    const taskId = evt.item.dataset.taskId;
                    const newPhaseId = evt.to.getAttribute("data-phase");

                    if (!taskId || !newPhaseId) return;

                    evt.item.dataset.phase = newPhaseId;

                    try {
                        await fetch("{{ route('update-task-phase') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({ task_id: taskId, phase_id: newPhaseId }),
                        });
                    } catch (error) {
                        console.error("Error updating task:", error);
                    }
                },
            });
        });

        // Add New Task Functionality
        document.querySelectorAll(".add-task-btn").forEach((button) => {
            button.addEventListener("click", async () => {
                const phaseId = button.getAttribute("data-phase-id");
                const taskName = prompt("Enter Task Name:");

                if (!taskName) return;

                try {
                    const response = await fetch("{{ route('store-task') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ name: taskName, phase_id: phaseId }),
                    });

                    const newTask = await response.json();

                    if (newTask.success) {
                        const taskHTML = `
                            <div class="task bg-white p-4 rounded-lg shadow cursor-move border border-gray-300 hover:shadow-lg hover:bg-gray-100 transition-transform transform hover:scale-105"
                                 data-task-id="${newTask.task.id}"
                                 data-phase="${phaseId}">
                                <p class="text-gray-800 font-medium text-sm">${newTask.task.name}</p>
                            </div>
                        `;

                        document.getElementById(`phase-${phaseId}`).insertAdjacentHTML("beforeend", taskHTML);
                    } else {
                        alert("Error creating task.");
                    }
                } catch (error) {
                    console.error("Error adding task:", error);
                }
            });
        });
    });
</script>
@endsection
