@extends('layouts.app')
@section('title','User List')
@section('content')
<div class="container mt-4">
    @if(Auth::user()->role=='admin')
    <a href="{{route('users.create')}}" class="btn btn-success mb-3">+ Add New User</a>
    @endif
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h2 class="mb-4">All User List</h2>
    <form action="{{ route('users.index') }}" method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Search users..." class="form-control mb-6" id="searchInput" style="width: 30%;">
    </form>
  


    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;">SL</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Email</th>
                <th colspan="2" style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td> <form action="{{route('users.edit',$user->id)}}" method="get">
                            <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                        </form></td>
                    <td>
                        <form action="{{route('users.destroy',$user->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                     </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No User found.</td>
                </tr>
            @endforelse
            
        </tbody>
    </table>

    <div style="display: flex; justify-content: center;">
   {{ $users->links('pagination::bootstrap-4') }}

    </div>

</div>

@endsection
