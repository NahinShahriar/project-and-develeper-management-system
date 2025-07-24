@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')
    <div class="container mt-5">
        <h1 class="text-danger">403 - Unauthorized</h1>
        <p>You do not have permission to perform this action.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
    </div>
@endsection
