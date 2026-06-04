<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TAN Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0a0a0a;
            color: #fff;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            background-color: #151515;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand h2 {
            color: #00ff88;
            font-weight: 700;
        }
        .form-control {
            background-color: #0a0a0a;
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 0.8rem;
        }
        .form-control:focus {
            background-color: #0a0a0a;
            color: white;
            border-color: #00ff88;
            box-shadow: 0 0 0 0.25rem rgba(0, 255, 136, 0.25);
        }
        .btn-primary {
            background-color: #00ff88;
            color: #000;
            border: none;
            font-weight: 600;
            padding: 0.8rem;
            width: 100%;
            margin-top: 1rem;
        }
        .btn-primary:hover {
            background-color: #fff;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <h2>TAN Admin</h2>
            <p class="text-secondary">Login to manage TAN Network</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="background-color: rgba(255, 77, 77, 0.1); border: none; color: #ff4d4d;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-secondary">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label text-secondary">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>
</body>
</html>
