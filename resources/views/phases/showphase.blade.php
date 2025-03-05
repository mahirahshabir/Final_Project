@extends('layouts.app')

@section('content')

<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Manage Phases</h2>

    {{-- Add Phase Form --}}
    <form id="addPhaseForm" class="flex gap-2 mb-4">
        @csrf
        <input type="text" id="phaseName" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" placeholder="Enter phase name" required>
        <button type="submit" class="bg-blue-700 text-white  rounded hover:bg-blue-600 transition">Add Phase</button>
    </form>

    {{-- Phases Dropdown --}}
    <div class="mb-4 flex gap-2">
        <select id="phaseDropdown" class="w-full border p-2 rounded focus:ring focus:ring-blue-300">
            <option value="">-- Select a Phase --</option>
        </select>
        <button id="deletePhaseBtn" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition" disabled>Delete</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetchPhases();

    // Enable Delete Button Only if a Phase is Selected
    document.getElementById('phaseDropdown').addEventListener('change', function() {
        document.getElementById('deletePhaseBtn').disabled = !this.value;
    });

    // Add new phase
    document.getElementById('addPhaseForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let phaseName = document.getElementById('phaseName').value.trim();

        if (!phaseName) {
            alert("Phase name cannot be empty!");
            return;
        }

        fetch('/phases', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name: phaseName })
        })
        .then(response => response.json())
        .then(() => {
            fetchPhases();
            document.getElementById('phaseName').value = '';
        })
        .catch(error => alert("Error adding phase: " + error.message));
    });

    // Fetch Phases and Update Dropdown
    function fetchPhases() {
        fetch('/phases')
        .then(response => response.json())
        .then(data => {
            let dropdown = document.getElementById('phaseDropdown');
            dropdown.innerHTML = '<option value="">-- Select a Phase --</option>';

            data.forEach(phase => {
                let option = document.createElement('option');
                option.value = phase.id;
                option.textContent = phase.name;
                dropdown.appendChild(option);
            });

            document.getElementById('deletePhaseBtn').disabled = true; // Disable delete button by default
        })
        .catch(error => alert("Error fetching phases: " + error.message));
    }

    // Delete Selected Phase
    document.getElementById('deletePhaseBtn').addEventListener('click', function() {
        let selectedPhaseId = document.getElementById('phaseDropdown').value;
        if (!selectedPhaseId) {
            alert("Please select a phase to delete.");
            return;
        }

        if (!confirm("Are you sure you want to delete this phase?")) return;

        fetch(`/phases/${selectedPhaseId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message) });
            }
            return response.json();
        })
        .then(() => fetchPhases())
        .catch(error => alert("Error deleting phase: " + error.message));
    });
});
</script>




