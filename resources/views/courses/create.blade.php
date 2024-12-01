@extends('layouts.profiluser')

@section('content')
<div class="container">
    <h1>Create Project</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="goal_amount">Goal Amount</label>
            <input type="number" class="form-control" id="goal_amount" name="goal_amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
