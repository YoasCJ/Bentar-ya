@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Portfolio</h2>
        <form action="{{ route('portfolio.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection