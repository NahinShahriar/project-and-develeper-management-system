@extends('layouts.app')
@section('title', 'Project Details')
@section('content')
<div class="container mt-4">
    <h2>{{ $project->name }}</h2>
    <p><strong>Description:</strong> {{ $project->description }}</p>

    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Task List</a>
</div>
@endsection
