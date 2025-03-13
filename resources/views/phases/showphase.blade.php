@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Manage Phases</h2>

    {{-- Success Message --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1000)" x-show="show"
             class="bg-green-500 text-white p-3 rounded-md mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Add Phase Form --}}
    <form method="POST" action="{{ route('phases.store') }}" class="flex flex-row gap-2 mb-4">
        @csrf
        <input type="text" name="name" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" placeholder="Enter phase name" required>
        <button type="submit" class="w-max font-bold bg-blue-500 text-white rounded hover:bg-blue-600 transition">➕ Add</button>
    </form>
</div>
{{-- List of Phases --}}
<div class="container mx-auto max-w-3xl mt-6 p-6  shadow-lg rounded-lg bg-gray-600">
  <ul class="space-y-2">
    @foreach($phases as $phase)
    <li class="flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md ">
        <span>{{ $phase->name }}</span>
        <div >
            <a href="{{ route('phases.edit', $phase->id) }}" class="text-blue-500 px-2">✏️</a>
            <form action="{{ route('phases.destroy', $phase->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 px-2">🗑️</button>
            </form>
        </div>
    </li>
    @endforeach
  </ul>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    const addPhaseForm = document.getElementById('addPhaseForm');

    addPhaseForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        const phaseName = document.getElementById('phaseName').value;
        const token = document.querySelector('input[name="_token"]').value;

        fetch('/phases', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name: phaseName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Phase added successfully!');
                location.reload(); // Reload the page to reflect new phase
            } else {
                alert('Error adding phase.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add phase. Please try again.');
        });
    });
});
// Delete Phase
function deletePhase(id) {
    if (!confirm("Are you sure you want to delete this phase?")) return;

    fetch(`/phases/${id}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Error deleting phase.");
        }
    })
    .catch(error => console.error("Error:", error));
}
// Edit Phase
function editPhase(id, name) {
    let newName = prompt("Edit Phase Name:", name);
    if (!newName) return;

    fetch(`/phases/${id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify({ name: newName }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload page to update UI
        } else {
            alert("Error updating phase.");
        }
    })
    .catch(error => console.error("Error:", error));
}
</script>
