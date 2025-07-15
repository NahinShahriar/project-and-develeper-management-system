@extends('layouts.app')
@section('title', 'Task Details')
@section('content')
<div class="container mt-4">
    <h2>{{ $task->title }}</h2>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Assigned By:</strong> {{ $task->assignbyUser ? $task->assignbyUser->name : 'N/A' }}</p>
    <p><strong>Assigned To:</strong> {{ $task->assignedUser ? $task->assignedUser->name : 'N/A' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>

    <a href="{{ route('task.index') }}" class="btn btn-secondary">Back to Task List</a>
</div>
@endsection
