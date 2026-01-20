<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Diks Store</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #2d3436, #636e72);
            padding: 20px 0;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 15px 25px;
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-brand span {
            color: #ffeaa7;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #dfe6e9;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(108, 92, 231, 0.3);
            color: white;
            border-left: 4px solid var(--primary-color);
        }
        
        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .sidebar-menu .menu-header {
            padding: 15px 25px 10px;
            color: #b2bec3;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-weight: 600;
            color: #2d3436;
            margin: 0;
        }
        
        .user-dropdown img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-card .stat-icon.bg-primary { background: linear-gradient(135deg, #6c5ce7, #a29bfe); }
        .stat-card .stat-icon.bg-success { background: linear-gradient(135deg, #00b894, #55efc4); }
        .stat-card .stat-icon.bg-warning { background: linear-gradient(135deg, #fdcb6e, #ffeaa7); }
        .stat-card .stat-icon.bg-danger { background: linear-gradient(135deg, #d63031, #ff7675); }
        .stat-card .stat-icon.bg-info { background: linear-gradient(135deg, #0984e3, #74b9ff); }
        
        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3436;
        }
        
        .stat-card .stat-label {
            color: #636e72;
            font-size: 0.9rem;
        }
        
        /* Tables */
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .table-card .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 20px 25px;
        }
        
        .table-card .table {
            margin: 0;
        }
        
        .table-card .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2d3436;
            border-bottom: none;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5b4cdb, #9187fc);
        }
        
        /* Forms */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
        }
        
        /* Alert */
        .alert-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Status Badges */
        .badge-available { background: #d4edda; color: #155724; }
        .badge-sold { background: #f8d7da; color: #721c24; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-processing { background: #cce5ff; color: #004085; }
        .badge-completed { background: #d4edda; color: #155724; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block !important;
            }
        }
        
        .mobile-toggle {
            display: none;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-controller"></i> Diks <span>Store</span>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="menu-header">Manajemen</li>
            
            <li>
                <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Kategori
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="bi bi-box"></i> Produk
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="bi bi-bag"></i> Pesanan Akun
                </a>
            </li>
            
            <li class="menu-header">Top Up</li>
            
            <li>
                <a href="{{ route('admin.topups') }}" class="{{ request()->routeIs('admin.topups*') ? 'active' : '' }}">
                    <i class="bi bi-gem"></i> Paket Top Up
                </a>
            </li>
            <li>
                <a href="{{ route('admin.topup-orders') }}" class="{{ request()->routeIs('admin.topup-orders*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Order Top Up
                </a>
            </li>
            
            <li class="menu-header">User</li>
            
            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.admin-list') }}" class="{{ request()->routeIs('admin.admin-list') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> Daftar Admin
                </a>
            </li>
            
            <li class="menu-header">Lainnya</li>
            
            <li>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-globe"></i> Lihat Website
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <a href="#" onclick="this.closest('form').submit(); return false;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link mobile-toggle me-3" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="page-title">@yield('page-title', 'Dashboard')</h5>
            </div>
            
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6c5ce7&color=fff" alt="Avatar" class="me-2">
                    <span class="d-none d-md-block text-dark">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-globe"></i> Lihat Website</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-floating alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-floating alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert-floating').forEach(function(alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
