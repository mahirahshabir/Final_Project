@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Create Custom Field</h2>

    {{-- Success Message --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1000)" x-show="show"
             class="bg-green-500 text-white p-3 rounded-md mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Custom Field Form --}}
    <form method="POST" action="{{ route('custom-fields.store') }}" class="mb-4">
        @csrf
        <input type="text" name="name" class="w-full border p-2 rounded mb-2" placeholder="Enter field name" required>

        <select name="field_type" class="w-full border p-2 rounded mb-2">
            <option value="text">Text</option>
            <option value="number">Number</option>
            <option value="boolean">Boolean (Yes/No)</option>
            <option value="date">Date</option>
        </select>

        <button type="submit" class="w-full bg-blue-500 text-white rounded py-2">➕ Add</button>
    </form>

    {{-- Manage Existing Fields --}}
    <h2 class="text-xl font-bold mb-2">Manage Custom Fields</h2>
    <ul class="space-y-2">
        @foreach($customFields as $field)
        <li class="flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md">
            <span>{{ $field->name }} ({{ ucfirst($field->field_type) }})</span>
            <div>
                <a href="{{ route('custom-fields.edit', $field->id) }}" class="text-blue-500 px-2">✏️</a>
                <form action="{{ route('custom-fields.destroy', $field->id) }}" method="POST" class="inline">
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
