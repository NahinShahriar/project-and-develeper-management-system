@extends('layouts.app')
@section('title','Project List')
@section('content')
<div class="container mt-4">
    @if(Auth::user()->role=='admin')
    <a href="{{route('projects.create')}}" class="btn btn-success mb-3">+ Add New Project</a>
    @endif

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <h2 class="mb-4">Projects List</h2>

    <form action="{{route('projects.index')}}" method="GET" class="mb-3">
        <input type="text" name="search" placeholder="Search projects..." class="form-control mb-6" id="searchInput" style="width: 30%;">
    </form>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;">SL</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Description</th>
                 <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Start Date</th>
                <th style="text-align: center;">End Date</th>
                <th style="text-align: center;">Created By</th>
                <th style="text-align: center;">Created Date</th>
                <th style="text-align: center;">Update Date</th>
                <th colspan="2" style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $index => $project)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$project->name}}</td>
                    <td>{{$project->description}}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $project->status)) }}</td>
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    <td>{{$project->creator->name}}</td>
                    <td>{{$project->created_at}}</td>
                    <td>{{$project->updated_at}}</td>
                     <td> <form action="{{route('projects.edit',$project->id)}}" method="get">
                            <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                        </form></td>
                    <td>
                        <form action="{{route('projects.destroy',$project->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                     </td>
                    

                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No Projects found.</td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
  <div style="display: flex; justify-content: center;">
    {{$projects->links('pagination::bootstrap-4')}}

</div>

</div>
@endsection