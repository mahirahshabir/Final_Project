@extends('layouts.app')

@section('content')

<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Manage Phases</h2>

    {{-- Add Phase Form --}}
    <form id="addPhaseForm" class="flex gap-2 mb-4">
        @csrf
        <input type="text" id="phaseName" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" placeholder="Enter phase name" required>
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Add</button>
    </form>

    {{-- Phases List --}}
    <ul id="phaseList" class="space-y-2"></ul>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetchPhases();

    // Add new phase
    document.getElementById('addPhaseForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let phaseName = document.getElementById('phaseName').value;
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
        });
    });

    // Fetch Phases
    function fetchPhases() {
        fetch('/phases')
        .then(response => response.json())
        .then(data => {
            let list = document.getElementById('phaseList');
            list.innerHTML = '';
            data.forEach(phase => {
                let li = document.createElement('li');
                li.className = "p-3 bg-gray-100 rounded shadow flex justify-between items-center border-l-4 border-blue-500";
                li.dataset.id = phase.id;
                li.innerHTML = `
                    <span class="text-lg font-medium">${phase.name}</span>
                    <button onclick="deletePhase(${phase.id})" class="bg-red-600 text-white font-bold px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition-all duration-300">
                        ❌ Delete
                    </button>
                `;
                list.appendChild(li);
            });
        });
    }

    // Delete Phase
    function deletePhase(id) {
        if (!confirm("Are you sure you want to delete this phase?")) return;

        fetch(`/phases/${id}`, {
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
    }
});
</script>
