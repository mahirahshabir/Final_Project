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

                <!-- Dropdown Menu -->
                <div class="relative">
                    <button onclick="toggleDropdown({{ $phase->id }})"
                        class="text-xl p-2 rounded-full hover:bg-gray-200 focus:outline-none">
                        ⋮
                    </button>
                    <div id="dropdown-{{ $phase->id }}"
                        class="absolute right-0 mt-0 w-20 bg-white border rounded-lg shadow-lg hidden">
                        <button onclick="deletePhase({{ $phase->id }})"
                            class="block w-full text-left px-1 py-1 text-sm text-red-600 hover:bg-red-100">
                            ❌ Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Task List -->
            <div class="task-list min-h-[300px] bg-white p-4 rounded-lg shadow-inner space-y-6 border border-gray-200"
                data-phase="{{ $phase->id }}">
                @foreach($phase->tasks as $task)
                <div class="task bg-white p-4 rounded-lg shadow cursor-move border border-gray-300 hover:shadow-lg hover:bg-gray-100 transition-transform transform hover:scale-105"
                    data-task-id="{{ $task->id }}" data-phase="{{ $phase->id }}">
                    <p class="text-gray-800 font-medium text-sm">{{ $task->name }}</p>
                </div>
                @endforeach

                <button class="add-task-btn w-full mt-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 rounded-lg"
                    data-phase-id="{{ $phase->id }}">
                    + Create Task
                </button>
            </div>
        </div>
        @endforeach

        <!-- Add Phase Button -->
        <div id="addPhaseContainer"
            class="w-80 bg-white p-4 rounded-lg shadow-md flex-shrink-0 flex items-center justify-center">
            <button onclick="openPhaseModal()"
                class="bg-blue-600 text-white px-4 py-2 font-semibold rounded-md shadow-md hover:bg-blue-500 transition">
                ➕ Add Phase
            </button>
        </div>
    </div>
</div>

<!-- Modal for Adding Phase -->
<div id="phaseModal" class=" fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">Add New Phase</h2>
        <input type="text" id="phaseName"
            class="w-full border p-2 rounded focus:ring focus:ring-blue-300"
            placeholder="Enter phase name" required>
        <div class="flex justify-end mt-4">
            <button onclick="closePhaseModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Cancel
            </button>
            <button onclick="addPhase()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 ml-2">
                Add
            </button>
        </div>
    </div>
</div>

<!-- Include SortableJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const addPhaseContainer = document.getElementById("addPhaseContainer");

        // Open & Close Phase Modal
        window.openPhaseModal = function () {
            document.getElementById("phaseModal").classList.remove("hidden");
        }
        window.closePhaseModal = function () {
            document.getElementById("phaseModal").classList.add("hidden");
        }

        // Add New Phase
        window.addPhase = function () {
            let phaseName = document.getElementById("phaseName").value;
            if (!phaseName) {
                alert("Please enter a phase name.");
                return;
            }

            fetch("{{ route('phases.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ name: phaseName }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addPhaseToBoard(data.phase);
                    closePhaseModal();
                } else {
                    alert("Error adding phase: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong. Please try again.");
            });
        }

        // Add Phase Without Refresh
        function addPhaseToBoard(phase) {
            let phaseHTML = `
                <div id="phase-${phase.id}" class="w-80 bg-gray-50 p-4 rounded-lg shadow-md flex-shrink-0">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">${phase.name}</h2>
                        <div class="relative">
                            <button onclick="toggleDropdown(${phase.id})" class="text-xl p-2 rounded-full hover:bg-gray-200">
                                ⋮
                            </button>
                            <div id="dropdown-${phase.id}" class="absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg hidden">
                                <button onclick="deletePhase(${phase.id})"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                    ❌ Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="task-list min-h-[300px] bg-white p-4 rounded-lg shadow-inner space-y-6 border border-gray-200"
                        data-phase="${phase.id}">
                    </div>
                </div>
            `;
            addPhaseContainer.insertAdjacentHTML("beforebegin", phaseHTML);
        }

        // Toggle Dropdown
        window.toggleDropdown = function (phaseId) {
            document.getElementById(`dropdown-${phaseId}`).classList.toggle("hidden");
        }

        // Delete Phase
        window.deletePhase = function (phaseId) {
            if (!confirm("Are you sure you want to delete this phase?")) return;

            fetch(`/phases/${phaseId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`phase-${phaseId}`).remove();
                } else {
                    alert("Error deleting phase: " + data.message);
                }
            })
            .catch(error => alert("Error deleting phase: " + error.message));
        }

        // Close dropdown when clicking outside
        document.addEventListener("click", function(event) {
            document.querySelectorAll("[id^='dropdown-']").forEach(dropdown => {
                if (!dropdown.contains(event.target) && !event.target.closest("button")) {
                    dropdown.classList.add("hidden");
                }
            });
        });
    });
</script>
@endsection
