<div id="phasesModal" class=" fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Manage Phases</h2>

        <!-- Phases List -->
        <ul id="phasesList" class="space-y-2">
            @foreach($phases as $phase)
            <li class="flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md">
                <span>{{ $phase->name }}</span>
                <div>
                    <button onclick="editPhase({{ $phase->id }}, '{{ $phase->name }}')" class="text-blue-500 px-2">✏️</button>
                    <button onclick="deletePhase({{ $phase->id }})" class="text-red-500 px-2">🗑️</button>
                </div>
            </li>
            @endforeach
        </ul>

        <!-- Add New Phase -->
        <div class="mt-4 flex">
            <input type="text" id="newPhaseName" class="border rounded p-2 flex-1" placeholder="New phase name">
            <button onclick="addPhase()" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Add</button>
        </div>

        <!-- Close Button -->
        <button onclick="closePhasesModal()" class="mt-4 w-full bg-gray-300 text-black px-4 py-2 rounded">Close</button>
    </div>
</div>

<script>
function openPhasesModal() {
    document.getElementById("phasesModal").classList.remove("hidden");
}

function closePhasesModal() {
    document.getElementById("phasesModal").classList.add("hidden");
}

// Add a new phase
// function addPhase() {
//     let phaseName = document.getElementById("newPhaseName").value;
//     if (!phaseName) {
//         alert("Please enter a phase name.");
//         return;
//     }

//     fetch("{{ route('phases.store') }}", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": "{{ csrf_token() }}",
//         },
//         body: JSON.stringify({ name: phaseName }),
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             location.reload(); // Reload page to show new phase
//         } else {
//             alert("Error adding phase.");
//         }
//     })
//     .catch(error => console.error("Error:", error));
// }

// Edit Phase


// Delete Phase

</script>
