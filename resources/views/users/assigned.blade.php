@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assigned Users</h1>
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
