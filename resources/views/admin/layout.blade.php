<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAN Network - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00ff88;
            --bg-dark: #0a0a0a;
            --bg-card: #151515;
            --text: #ffffff;
            --text-dim: #a0a0a0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: var(--bg-card);
            border-right: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }
        .main-content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 2rem;
        }
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar-header h4 {
            color: var(--primary);
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .nav-link {
            color: var(--text-dim);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            background-color: rgba(0, 255, 136, 0.05);
            border-left: 3px solid var(--primary);
        }
        .card {
            background-color: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
        }
        .card-header {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background-color: transparent;
            font-weight: 600;
        }
        .table {
            color: var(--text);
            margin-bottom: 0;
        }
        .table th {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: var(--text-dim);
            font-weight: 600;
        }
        .table td {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            vertical-align: middle;
        }
        .btn-primary {
            background-color: var(--primary);
            color: #000;
            border: none;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #fff;
            color: #000;
        }
        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: #000;
        }
        .badge.bg-primary {
            background-color: rgba(0, 255, 136, 0.2) !important;
            color: var(--primary) !important;
        }
        .badge.bg-danger {
            background-color: rgba(255, 77, 77, 0.2) !important;
            color: #ff4d4d !important;
        }
        .form-control {
            background-color: var(--bg-dark);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
        }
        .form-control:focus {
            background-color: var(--bg-dark);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 255, 136, 0.25);
        }
        .logout-btn {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-header">
            <h4>TAN Admin</h4>
        </div>
        <div class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a class="nav-link {{ request()->routeIs('admin.withdrawals') ? 'active' : '' }}" href="{{ route('admin.withdrawals') }}">
                <i class="bi bi-wallet2"></i> Withdrawals
            </a>
            <a class="nav-link {{ request()->routeIs('admin.config') ? 'active' : '' }}" href="{{ route('admin.config') }}">
                <i class="bi bi-gear"></i> System Config
            </a>
        </div>
        
        <div class="logout-btn p-3 mt-auto">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0" style="background-color: rgba(0, 255, 136, 0.2); color: var(--primary);" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
