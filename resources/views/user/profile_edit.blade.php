@extends('layouts.app')
@section('title', 'Update Profile')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Update Profile</h2>

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
    <form action="{{ route('profile.update',$user->id) }}" method="POST" style="width:400px">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">User Name <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{$user->name}}" 
                placeholder="Enter User name"
            
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">User Email <span class="text-danger">*</span></label>
           <!-- If user is admin, show editable field -->
            @if(auth()->user()->role === 'admin')
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            @else
                <!-- Regular users see email as readonly, and it still gets submitted -->
                <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                <input type="hidden" name="email" value="{{ $user->email }}">
            @endif

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

       

        <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
