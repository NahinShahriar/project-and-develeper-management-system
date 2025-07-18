@extends('layouts.app')
@section('title','User List')
@section('content')
<div class="container mt-4">
    @if(Auth::user()->role=='admin')
    <a href="{{route('user.create')}}" class="btn btn-success mb-3">+ Add New User</a>
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
                <th style="text-align: center;">Joined</th>
                <th colspan="3" style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
    @foreach($users as $index => $user)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d M Y') }}</td>
            <td>
                <form action="{{ route('users.edit', $user->id) }}" method="get">
                    <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                </form>
            </td>
            <td>
                <form action="{{ route('users.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
            <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#sendMailModal{{ $user->id }}">
                    Send Mail
                </button>
            </td>
        </tr>

        <!-- Modal -->
        <div class="modal fade" id="sendMailModal{{ $user->id }}" tabindex="-1" aria-labelledby="sendMailModalLabel{{ $user->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.sendMail', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendMailModalLabel{{ $user->id }}">Send Mail to {{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subject{{ $user->id }}" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject{{ $user->id }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="message{{ $user->id }}" class="form-label">Message</label>
                            <textarea class="form-control" name="message" id="message{{ $user->id }}" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
    @endforeach
</tbody>

    </table>

    <div style="display: flex; justify-content: center;">
   {{ $users->links('pagination::bootstrap-4') }}

    </div>

</div>

@endsection
