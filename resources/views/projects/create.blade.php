@extends('layouts.app')
@section('title', 'Create Project')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create New Project</h2>

    {{-- Show validation errors if any --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Project create form --}}
    <form action="{{ route('projects.store') }}" method="POST" style="width:400px">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Project Name <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                placeholder="Enter project name"
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea 
                name="description" 
                id="description" 
                class="form-control @error('description') is-invalid @enderror" 
                rows="3"
                placeholder="Enter project description">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label">Start Date</label>
                <input 
                    type="date" 
                    name="start_date" 
                    id="start_date" 
                    class="form-control @error('start_date') is-invalid @enderror" 
                    value="{{ old('start_date') }}"
                >
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="end_date" class="form-label">End Date</label>
                <input 
                    type="date" 
                    name="end_date" 
                    id="end_date" 
                    class="form-control @error('end_date') is-invalid @enderror" 
                    value="{{ old('end_date') }}"
                >
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to List</a>
            <button type="submit" class="btn btn-primary">Create Project</button>
        </div>
    </form>
</div>
@endsection
