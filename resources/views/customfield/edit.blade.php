@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit Custom Field</h2>

    <form method="POST" action="{{ route('custom-fields.update', $customField->id) }}">
        @csrf
        @method('PUT')

        <input type="text" name="name" class="w-full border p-2 rounded mb-2" value="{{ $customField->name }}" required>

        <select name="field_type" class="w-full border p-2 rounded mb-2">
            <option value="text" {{ $customField->field_type == 'text' ? 'selected' : '' }}>Text</option>
            <option value="number" {{ $customField->field_type == 'number' ? 'selected' : '' }}>Number</option>
            <option value="boolean" {{ $customField->field_type == 'boolean' ? 'selected' : '' }}>Boolean</option>
            <option value="date" {{ $customField->field_type == 'date' ? 'selected' : '' }}>Date</option>
        </select>

        <button type="submit" class="w-full bg-blue-500 text-white rounded py-2">💾 Update</button>
    </form>
</div>
@endsection
