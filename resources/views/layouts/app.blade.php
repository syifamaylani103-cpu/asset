<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asset Management System')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6.5.2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --bs-body-font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --sidebar-width: 260px;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-canvas: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-color: #94a3b8;
            --sidebar-active-bg: rgba(99, 102, 241, 0.15);
            --sidebar-active-color: #818cf8;
            --card-border-radius: 16px;
        }

        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--bg-canvas);
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layout Architecture */
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(15, 23, 42, 0.08);
        }

        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-decoration: none;
            color: #fff;
        }

        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .sidebar-brand .brand-text {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .sidebar-brand .brand-subtext {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 1rem 0.85rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            font-weight: 700;
            padding: 0.75rem 0.75rem 0.35rem 0.75rem;
            margin-top: 0.5rem;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.7rem 0.9rem;
            color: var(--sidebar-color);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .sidebar-menu a i {
            font-size: 1.05rem;
            width: 22px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .sidebar-menu a:hover {
            color: #f8fafc;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a:hover i {
            transform: translateX(2px);
            color: #a5b4fc;
        }

        .sidebar-menu a.active {
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .sidebar-menu a.active i {
            color: #ffffff;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(15, 23, 42, 0.6);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .user-info {
            line-height: 1.2;
            overflow: hidden;
        }

        .user-info .name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #f1f5f9;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .user-info .role {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Main Content Wrapper */
        #content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Top Navbar Styling */
        .top-navbar {
            background: #ffffff;
            padding: 0.85rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .toggle-sidebar-btn {
            background: #f1f5f9;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toggle-sidebar-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .top-navbar-search {
            position: relative;
            max-width: 320px;
            width: 100%;
        }

        .top-navbar-search input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.45rem 0.85rem 0.45rem 2.25rem;
            font-size: 0.85rem;
            width: 100%;
            transition: all 0.2s ease;
        }

        .top-navbar-search input:focus {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .top-navbar-search i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-icon-nav {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            position: relative;
            transition: all 0.2s ease;
        }

        .btn-icon-nav:hover {
            background: #f8fafc;
            color: #4f46e5;
            border-color: #cbd5e1;
        }

        .btn-icon-nav .pulse-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        /* Content Area */
        .main-content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Card System Styling */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            border-top-left-radius: var(--card-border-radius) !important;
            border-top-right-radius: var(--card-border-radius) !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background-color: transparent;
            border-top: 1px solid #f1f5f9;
            padding: 1rem 1.5rem;
            border-bottom-left-radius: var(--card-border-radius) !important;
            border-bottom-right-radius: var(--card-border-radius) !important;
        }

        /* Stat Card */
        .stat-card {
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.primary { background: #e0e7ff; color: #4f46e5; }
        .stat-icon.success { background: #dcfce7; color: #16a34a; }
        .stat-icon.warning { background: #fef3c7; color: #d97706; }
        .stat-icon.danger { background: #ffe4e6; color: #e11d48; }
        .stat-icon.info { background: #e0f2fe; color: #0284c7; }

        .stat-card .stat-value {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* Buttons Styling */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.55rem 1.1rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #4338ca;
            border-color: #4338ca;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .btn-secondary {
            background-color: #f1f5f9;
            border-color: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
            border-color: #cbd5e1;
            color: #1e293b;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
            color: #334155;
        }

        .table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.95rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody td {
            padding: 0.95rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            padding: 0.4em 0.75em;
            font-weight: 600;
            font-size: 0.75rem;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }

        .badge-soft-primary { background: #e0e7ff; color: #4338ca; }
        .badge-soft-success { background: #dcfce7; color: #15803d; }
        .badge-soft-warning { background: #fef3c7; color: #b45309; }
        .badge-soft-danger { background: #ffe4e6; color: #be123c; }
        .badge-soft-secondary { background: #f1f5f9; color: #475569; }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            padding: 0.6rem 0.9rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background-color: #ffffff;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        /* Alert Box */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* Page Headers */
        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #64748b;
        }

        /* Mobile Overlay */
        @media (max-width: 991.88px) {
            #sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: -260px;
            }

            #sidebar.active {
                left: 0;
            }

            .main-content {
                padding: 1.25rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div id="wrapper">
        <!-- Sidebar Nav -->
        <nav id="sidebar">
            <a href="{{ url('/dashboard') }}" class="sidebar-brand">
                <div class="brand-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <div>
                    <div class="brand-text">AssetSystem</div>
                    <div class="brand-subtext">Management Portal</div>
                </div>
            </a>

            <div class="sidebar-menu">
                <div class="menu-header">Utama</div>
                <ul>
                    <li>
                        <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>

                @if(Auth::check() && Auth::user()->isAdmin())
                <div class="menu-header">Katalog & Stok</div>
                <ul>
                    <li>
                        <a href="{{ route('barangs.index') }}" class="{{ Request::is('barangs*') ? 'active' : '' }}">
                            <i class="fas fa-boxes-stacked"></i>
                            <span>Data Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="{{ Request::is('categories*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jenis_barang.index') }}" class="{{ Request::is('jenis_barang*') ? 'active' : '' }}">
                            <i class="fas fa-layer-group"></i>
                            <span>Jenis Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stock_barang.index') }}" class="{{ Request::is('stock_barang*') ? 'active' : '' }}">
                            <i class="fas fa-warehouse"></i>
                            <span>Stok Barang</span>
                        </a>
                    </li>
                </ul>

                <div class="menu-header">Sirkulasi</div>
                <ul>
                    <li>
                        <a href="{{ route('barang_masuk.index') }}" class="{{ Request::is('barang_masuk*') ? 'active' : '' }}">
                            <i class="fas fa-arrow-down-to-bracket"></i>
                            <span>Barang Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('barang_keluar.index') }}" class="{{ Request::is('barang_keluar*') ? 'active' : '' }}">
                            <i class="fas fa-arrow-up-from-bracket"></i>
                            <span>Barang Keluar</span>
                        </a>
                    </li>
                </ul>
                @else
                <div class="menu-header">Katalog</div>
                <ul>
                    <li>
                        <a href="{{ route('katalog.index') }}" class="{{ Request::is('katalog*') ? 'active' : '' }}">
                            <i class="fas fa-boxes-stacked"></i>
                            <span>Katalog Barang</span>
                        </a>
                    </li>
                </ul>
                @endif

                <div class="menu-header">Pengajuan</div>
                <ul>
                    <li>
                        <a href="{{ route('pengajuan.index') }}" class="{{ Request::is('pengajuan*') ? 'active' : '' }}">
                            <i class="fas fa-file-signature"></i>
                            <span>Pengajuan Barang</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-footer" style="flex-direction: column; align-items: stretch; gap: 1rem;">
                <div class="d-flex align-items-center gap-2">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-info">
                        <div class="name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                        <div class="role">{{ Auth::check() ? ucfirst(Auth::user()->role) : '' }}</div>
                    </div>
                </div>
                @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST" class="d-block m-0 p-0">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm w-100 d-flex justify-content-center align-items-center gap-2" style="background: rgba(255,255,255,0.1); color: #fff; border: none;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                @endif
            </div>
        </nav>

        <!-- Main Content Wrapper -->
        <div id-content-wrapper id="content-wrapper">
            <!-- Top Navbar -->
            <header class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" id="sidebarCollapse" class="toggle-sidebar-btn" title="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <form action="{{ route('search.index') }}" method="GET" class="top-navbar-search d-flex w-100 mx-3 mx-md-4">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari barang, transaksi, pengajuan..." required>
                    </form>
                </div>

                <div class="navbar-actions">
                    <a href="{{ route('pengajuan.index') }}" class="btn-icon-nav" title="Pengajuan Pending">
                        <i class="fas fa-bell"></i>
                        <span class="pulse-badge"></span>
                    </a>
                    @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="{{ route('barangs.create') }}" class="btn btn-primary btn-sm d-none d-sm-inline-flex">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                    @endif
                </div>
            </header>

            <!-- Main Body Content -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarBtn = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');

            if (sidebarBtn && sidebar) {
                sidebarBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>