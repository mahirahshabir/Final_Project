@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit Phase</h2>

    <form method="POST" action="{{ route('phases.update', $phase->id) }}">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $phase->name }}" class="w-full border p-2 rounded focus:ring focus:ring-blue-300" required>

        <button type="submit" class="w-full bg-blue-500 text-white rounded py-2 mt-3 hover:bg-blue-600">
            Update Phase
        </button>
    </form>
</div>
@endsection
