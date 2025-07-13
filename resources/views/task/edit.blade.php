@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Task</h2>

    <form action="{{route('task.update',$task->id)}}" method="POST" class="card p-4 shadow-sm" style="width: 40%;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" id="title" 
                   value="{{  $task->title }}" 
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" 
                      class="form-control" rows="3">{{ $task->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date" 
                   value="{{  $task->due_date }}" 
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select name="assigned_to" id="assigned_to" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{  $task->assigned_to== $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="todo" {{  $task->status == 'todo' ? 'selected' : '' }}>Todo</option>
                <option value="in_progress" {{  $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done" {{  $task->status == 'done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('task.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </form>
</div>
@endsection
