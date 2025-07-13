@extends('layouts.app')
@section('title','Add Task')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Add Task</h2>

    <form action="{{route('task.store')}}" method="POST" class="card p-4 shadow-sm" style="width: 40%;">
        @csrf
  

        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" id="title"  class="form-control" >
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" 
                      class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" >
        </div>
        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select name="project_id" id="project_id" class="form-select" required>
              
              @foreach($projects as $project)
              <option value="{{$project->id}}">{{$project->name}}</option>

              @endforeach
 
            </select>
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select name="assigned_to" id="assigned_to" class="form-select" required>
              
              @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->name}}</option>

              @endforeach
 
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="todo" >Todo</option>
                <option value="in_progress" >In Progress</option>
                <option value="done" >Done</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('task.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Save Task</button>
        </div>
    </form>
</div>

@endsection