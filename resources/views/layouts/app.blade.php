<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Project Management System')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
 <header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
       @if(Auth::check() && (Auth::user()->role=='admin'||Auth::user()->role=='pm'))
      <a class="navbar-brand" href="{{route('dashboard')}}">Project Management</a>
      @else
      <a class="navbar-brand" href="{{route('task.index')}}">Project Management</a>
      @endif
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          @can('can_view_admin')
          <li class="nav-item">
            <a class="nav-link active" href="{{route('dashboard')}}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('projects.index')}}">Projects</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="{{route('users.index')}}">Users</a>
          </li>
           @endcan

            @if(Auth::check())
             <li class="nav-item">
            <a class="nav-link" href="{{route('task.index')}}">Tasks</a>
          </li>
           @endif
        </ul>
        <!-- Right Side -->
          @if(Auth::check())
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li>
            <img src="{{ asset('images/' . Auth::user()->images) }}" alt="Profile" width="47" height="40" class="rounded-circle"> 
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i> {{ ucfirst( Auth::user()->name)}}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
            </ul>
          </li>
        </ul>
        @endif
      </div>
    </div>
  </nav>
</header>


  <!-- Main Content -->
  <main class="flex-fill">
    <div class="container my-4">
      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3 mt-auto">
    &copy; {{ date('Y') }} Project Manager. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
