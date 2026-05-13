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
            --primary: #00ffa3;
            --primary-rgb: 0, 255, 163;
            --bg-dark: #050505;
            --bg-sidebar: #0c0c0e;
            --bg-card: #111113;
            --text: #f8f9fa;
            --text-dim: #8e8e93;
            --border: rgba(255, 255, 255, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        .sidebar {
            width: 260px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: var(--transition);
        }

        .main-content {
            flex-grow: 1;
            margin-left: 260px;
            padding: 2.5rem;
            max-width: calc(100vw - 260px);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: left;
        }
        
        .sidebar-header h4 {
            color: var(--primary);
            font-weight: 800;
            margin: 0;
            font-size: 1.4rem;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h4::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary);
        }

        .nav-link {
            color: var(--text-dim);
            padding: 0.85rem 1.5rem;
            margin: 0.2rem 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link i {
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--text);
            background-color: rgba(255, 255, 255, 0.03);
        }

        .nav-link.active {
            color: #000;
            background-color: var(--primary);
            box-shadow: 0 4px 15px rgba(0, 255, 163, 0.3);
        }

        .nav-link.active i {
            color: #000;
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            border-color: rgba(var(--primary-rgb), 0.2);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border);
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .table {
            color: var(--text);
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid var(--border);
            color: var(--text-dim);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1.25rem 1rem;
        }

        .table tbody td {
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1rem;
            font-size: 0.9rem;
        }

        .btn {
            border-radius: 12px;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #000;
            border: none;
        }

        .btn-primary:hover {
            background-color: #fff;
            color: #000;
            transform: scale(1.02);
        }

        .badge {
            padding: 0.5em 0.8em;
            border-radius: 6px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            color: white;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .btn-outline-warning {
            border-color: rgba(255, 193, 7, 0.5);
            color: #ffc107;
        }
        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
            border-color: #ffc107;
        }
        .btn-outline-danger {
            border-color: rgba(255, 77, 77, 0.5);
            color: #ff4d4d;
        }
        .btn-outline-danger:hover {
            background-color: #ff4d4d;
            color: #fff;
            border-color: #ff4d4d;
        }
        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        .btn-outline-light:hover {
            background-color: #fff;
            color: #000;
        }
        
        .logout-section {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .text-dim { color: var(--text-dim); }
        .text-primary { color: var(--primary) !important; }
        .break-all { word-break: break-all; }
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
        
        <div class="logout-section mt-auto">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger border-0 bg-danger bg-opacity-10 w-100 d-flex align-items-center justify-content-center gap-2">
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
