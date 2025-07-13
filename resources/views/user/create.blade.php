@extends('layouts.app')
@section('title', 'Create User')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create New User</h2>

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

      @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Project create form --}}
    <form action="{{ route('users.store') }}" method="POST" style="width:400px">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">User Name <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="" 
                placeholder="Enter User name"
            
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">User Email <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="email" 
                id="name" 
                class="form-control @error('email') is-invalid @enderror" 
                value="" 
                placeholder="Enter User email"
               
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

       

        <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
            <button type="submit" class="btn btn-primary">Add User</button>
        </div>
    </form>
</div>
@endsection
