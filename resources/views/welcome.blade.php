<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Project Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-card {
            background: rgba(255,255,255,0.95);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            padding: 3rem 2.5rem;
            text-align: center;
        }
        .login-card {
            background: rgba(255,255,255,0.98);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            padding: 3rem 2.5rem;
        }
        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2575fc;
            margin-bottom: 0.5rem;
        }
        .welcome-icon {
            font-size: 3rem;
            color: #6a11cb;
            margin-bottom: 1rem;
        }
        .lead {
            color: #444;
            font-size: 1.25rem;
        }
        .btn-primary {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            font-size: 1.1rem;
            padding: 0.75rem 2.5rem;
            border-radius: 2rem;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #2575fc 0%, #6a11cb 100%);
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <div class="welcome-card mb-4">
                   @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
            @endif

            @if (session('msg'))
                <div class="alert alert-info text-center mb-3" role="alert">
                    <i class="fas fa-info-circle me-2"></i>{{ session('msg') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.querySelector('.alert-info').style.display = 'none';
                    }, 10000);
                </script>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


                    <div class="welcome-icon mb-2">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h1 class="welcome-title">Welcome to Project Management System </h1>
                    <p class="lead mb-0">Manage your projects efficiently and effectively.</p>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <div class="login-card">
                    <h2 class="mb-4 text-center" style="font-weight:600; color:#2575fc;">Login</h2>
                     @error('error')
                            <div class="text-danger text-center mb-2">{{ $message }}</div>
                        @enderror
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="text" name="email" class="form-control" style="max-width: 260px;" placeholder="Email" autofocus value="{{ old('email', request()->cookie('remembered_email')) }}">
                        </div>
                        @error('email')
                            <div class="text-danger text-center mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-3 d-flex justify-content-center">
                            <input type="password" name="password" class="form-control" style="max-width: 260px;" placeholder="Password"  value="{{ old('email', request()->cookie('remembered_password')) }}">
                        </div>
                        @error('password')
                            <div class="text-danger text-center mb-2">{{ $message }}</div>
                        @enderror
                        @php
                        $rememberedEmail = request()->cookie('remembered_email');
                        @endphp

                        <div class="mb-3 d-flex justify-content-center align-items-center">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" style="margin-top: 0.3rem;" {{ old('remember') || $rememberedEmail ? 'checked' : '' }}>
                        <label class="form-check-label ms-2 mb-0" for="remember">Remember Me</label>
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                        Forgot Password?
                        </a>
                        </div>

                        <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg w-100" style="max-width: 160px;">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                        </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>