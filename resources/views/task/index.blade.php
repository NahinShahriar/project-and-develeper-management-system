@extends('layouts.app')
@section('title','Task List')
@section('content')
<div class="container mt-4">
    @if(Auth::user()->role=='admin')
    <a href="{{route('task.create')}}" class="btn btn-success mb-3">+ Add New Task</a>
    @endif
          @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h2 class="mb-4">Assigned Task List</h2>
    <form action="{{ route('task.search') }}" method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Search tasks..." class="form-control mb-6" id="searchInput" style="width: 30%;">
    </form>
    <div style="display: flex; justify-content: flex-end;">
  <div style="display: flex;">
    <div style="background-color: red; color: white; padding: 2px 6px; margin-left: 4px;">Deadline</div>
    <div style="background-color: yellow; color: black; padding: 2px 6px; margin-left: 4px;">Today Plan</div>
    <div style="background-color: green; color: white; padding: 2px 6px; margin-left: 4px;">Upcoming</div>
  </div>
</div>


    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;">SL</th>
                <th style="text-align: center;">Task Id</th>
                <th style="text-align: center;">Title</th>
                <th style="text-align: center;">Description</th>
                 <th style="text-align: center;">Assigned By</th>
                 @if(Auth::user()->role=='admin')
                    <th>Assigned</th>
                 @endif
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Due Date</th>
                <th colspan="2" style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->assignbyUser ? $task->assignbyUser->name : 'N/A' }}</td>
                     @if(Auth::user()->role=='admin')
                        <td>{{ $task->assignedUser ? $task->assignedUser->name : 'N/A' }}</td>
                     @endif
                    <td>
                        @if(Auth::user()->role=='admin')
                            <span class="badge 
                                @if($task->status == 'done') bg-success 
                                @elseif($task->status == 'in_progress') bg-warning 
                                @else bg-secondary @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        @else
                            <form action="{{ route('status.update', $task->id) }}" method="POST">
                                @csrf
                                <select name="status">
                                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Todo</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                                @endif
                    </td>
                        @php
                            $today = date('Y-m-d');
                        @endphp

                        @if($task->due_date == $today)
                            <td style="background-color: yellow; color: black;">
                                {{ $task->due_date }}
                                <span class="badge bg-dark">Today</span>
                            </td>
                        @elseif($task->due_date < $today)
                            <td style="background-color: red; color: white;">
                                {{ $task->due_date }}
                                <span class="badge bg-warning text-dark">Overdue</span>
                            </td>
                        @else
                            <td style="background-color: green; color: white;">
                                {{ $task->due_date }}
                                <span class="badge bg-light text-dark">Upcoming</span>
                            </td>
                        @endif


                    @if(Auth::user()->role=='user')
                    <td>
                        
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </td>
                            </form>
                        @endif

                        @if(Auth::user()->role == 'admin')
                    <td> <form action="{{route('task.edit',$task->id)}}" method="get">
                            <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                        </form></td>
                    <td>
                        <form action="{{route('task.delete',$task->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                     </td>
                        @endif

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No tasks found.</td>
                </tr>
            @endforelse
            
        </tbody>
    </table>

    <div style="display: flex; justify-content: center;">
   {{ $tasks->links('pagination::bootstrap-4') }}

    </div>

</div>

@endsection
