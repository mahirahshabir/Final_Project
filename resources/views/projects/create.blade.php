@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create a New Project</h1>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <label for="name">Project Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit">Create Project</button>
        </form>
    </div>
@endsection
