<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #06d6a0;
            --info-color: #118ab2;
            --warning-color: #ffd166;
            --danger-color: #ef476f;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        /* ===== GLOBAL STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            color: #333;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR STYLING ===== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .sidebar-brand .logo-icon {
            background: white;
            color: var(--primary-color);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar-nav {
            padding: 20px 0;
            height: calc(100vh - 70px);
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
        }

        .nav-link i {
            width: 25px;
            font-size: 1.1rem;
            margin-right: 10px;
        }

        .nav-link .badge {
            margin-left: auto;
            background: var(--danger-color);
            font-size: 0.7rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ===== HEADER ===== */
        .header {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .header-left p {
            color: #6c757d;
            margin: 5px 0 0 0;
            font-size: 0.9rem;
        }

        /* ===== STATS CARDS ===== */
        .stats-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .stats-card .card-body {
            padding: 25px;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stats-icon.users { background: rgba(67, 97, 238, 0.1); color: var(--primary-color); }
        .stats-icon.products { background: rgba(6, 214, 160, 0.1); color: var(--success-color); }
        .stats-icon.categories { background: rgba(17, 138, 178, 0.1); color: var(--info-color); }
        .stats-icon.stock { background: rgba(239, 71, 111, 0.1); color: var(--danger-color); }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 10px 0;
        }

        .stats-text {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== DATA CARDS ===== */
        .data-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .data-card .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 20px 25px;
            border-radius: 15px 15px 0 0;
        }

        .data-card .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--dark-color);
        }

        .data-card .card-body {
            padding: 25px;
        }

        /* ===== TABLES ===== */
        .table {
            margin: 0;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            background: #f8f9fa;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.005);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-top: 1px solid #eee;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge.bg-primary { background: var(--primary-color) !important; }
        .badge.bg-success { background: var(--success-color) !important; }
        .badge.bg-danger { background: var(--danger-color) !important; }
        .badge.bg-warning { background: var(--warning-color) !important; color: #333; }
        .badge.bg-info { background: var(--info-color) !important; }

        /* ===== QUICK ACTIONS ===== */
        .quick-actions .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            height: 150px;
        }

        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .action-btn i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .action-btn span {
            font-size: 1rem;
            font-weight: 500;
        }

        /* ===== USER AVATAR ===== */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* ===== MOBILE RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-card {
                margin-bottom: 20px;
            }

            .action-btn {
                height: 120px;
                margin-bottom: 15px;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* ===== UTILITY CLASSES ===== */
        .cursor-pointer {
            cursor: pointer;
        }

        .text-gradient {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-menu-btn {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            font-size: 1.2rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon">
                <i class="fas fa-crown"></i>
            </div>
            <h3>Admin<span style="color: #ffd166;">Panel</span></h3>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                        <span class="badge">New</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        <span>Categories</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                        <span class="badge">{{ \App\Models\User::count() }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center">
                <div class="user-avatar me-3">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h6 class="mb-0" style="color: white;">{{ auth()->user()->name }}</h6>
                    <small style="color: rgba(255,255,255,0.7);">{{ auth()->user()->role }}</small>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-sm btn-light w-100 mb-2">
                    <i class="fas fa-store me-1"></i> Visit Store
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light w-100">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn mb-3" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Header -->
        <div class="header fade-in">
            <div class="header-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>Welcome back, {{ auth()->user()->name }}! Here's what's happening with your store today.</p>
            </div>
            <div class="header-right">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar me-2"></i>
                        {{ now()->format('d M, Y') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i> Notifications</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Main Content -->
        @yield('content')
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const mobileBtn = document.querySelector('.mobile-menu-btn');

            if (window.innerWidth <= 992 &&
                !sidebar.contains(event.target) &&
                !mobileBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Add animation to stats cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stats-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in');
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
