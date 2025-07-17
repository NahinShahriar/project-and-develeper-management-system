@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="bi bi-person-circle me-2"></i> My Profile</h4>
                </div>

                <div class="card-body">
                    <div class="mb-3 text-center">
                        <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d6efd;"></i>
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ Str::title(Auth::user()->name) }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Joined:</th>
                            <td>{{ Auth::user()->created_at->format('d M Y') }}</td>
                        </tr>
                        {{-- Optional, if you have role --}}
                    </table>
                </div>

                <div class="card-footer text-end">
                    {{-- Optional edit profile / change password --}}
                    <a href="{{route('profile.edit',Auth::user()->id)}}" class="btn btn-sm btn-outline-secondary">Edit Profile</a>
                    <a href="{{route('change_password')}}" class="btn btn-sm btn-outline-warning">Change Password</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
