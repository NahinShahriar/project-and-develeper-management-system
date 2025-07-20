@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Welcome, {{ session('user_name') ?? auth()->user()->name }}</h2>

    <div class="row g-4">
        <!-- Total Projects -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    Total Projects
                </div>
                <div class="card-body text-center">
                    <h3 class="display-5">{{ $projects }}</h3>
                    <p class="mb-0 text-muted">Active Projects</p>
                </div>
            </div>
        </div>

        <!-- Tasks Assigned -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    Tasks Assigned
                </div>
                <div class="card-body text-center">
                    <h3 class="display-5">{{ $task_assigned }}</h3>
                    <p class="mb-0 text-muted">Pending / Ongoing</p>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    Notifications
                </div>
                <div class="card-body text-center">
                    <h3 class="display-5">{{ $notifications_count ?? 0 }}</h3>
                    <p class="mb-0 text-muted">Unread Alerts</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tasks -->
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-header bg-secondary text-white">
            Recent Tasks
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($recent as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $task->title  }}
                        <span class="badge 
                            @if(strtolower($task->status) === 'todo') bg-info
                            @elseif(strtolower($task->status) === 'done') bg-success
                            @elseif(strtolower($task->status) === 'in_progress') bg-warning
                            @else bg-secondary
                            @endif
                        ">
                            {{ ucfirst($task->status) }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">No recent tasks found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
