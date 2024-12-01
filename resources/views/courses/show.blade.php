@extends('layouts.profiluser')

@section('content')
<div class="container">
    <h1>{{ $project->title }}</h1>
    <p>{{ $project->description }}</p>
    <p>Goal Amount: {{ $project->goal_amount }}</p>
    <p>Current Amount: {{ $project->current_amount }}</p>

    <h2>Add a Part</h2>
    <form action="{{ route('parts.store', $project) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Part</button>
    </form>

    <h2>Parts</h2>
    <ul>
        @foreach ($project->parts as $part)
        <li>
            {{ $part->amount }} 
            <form action="{{ route('parts.destroy', $part) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection
