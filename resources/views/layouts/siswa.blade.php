<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SIPAYU SPP System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="text-center py-4">
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h5 class="mt-2">SIPAYU</h5>
            <small>Portal Siswa</small>
        </div>
        <hr class="mx-3 my-2 bg-secondary">
        <nav class="nav flex-column mt-3">
            <a class="nav-link" href="/siswa/dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link" href="/siswa/profil">
                <i class="fas fa-user"></i> Profil Saya
            </a>
            <a class="nav-link" href="/siswa/tagihan">
                <i class="fas fa-file-invoice"></i> Tagihan SPP
            </a>
            <a class="nav-link" href="/siswa/riwayat">
                <i class="fas fa-history"></i> Riwayat Pembayaran
            </a>
            <hr class="mx-3 my-2 bg-secondary">
            <a class="nav-link" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <div class="content">
        <div class="navbar-top d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-bars menu-toggle me-3" style="cursor: pointer;" onclick="toggleSidebar()"></i>
                <span>@yield('header')</span>
            </div>
            <div class="d-flex align-items-center">
                <i class="fas fa-moon me-3" style="cursor: pointer;" onclick="toggleDarkMode()"></i>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-decoration-none text-dark" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-lg"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #F8FAFC;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: #1E293B;
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #CBD5E1;
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 10px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-link i {
            width: 25px;
            margin-right: 10px;
        }

        .sidebar .nav-link:hover {
            background: #2563EB;
            color: white;
            transform: translateX(5px);
        }

        /* Content Styles */
        .content {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
        }

        /* Navbar Top */
        .navbar-top {
            background: white;
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .stat-card h6 {
            color: #64748B;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .stat-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-card .icon {
            position: absolute;
            right: 20px;
            bottom: 20px;
            font-size: 2.5rem;
            opacity: 0.15;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            background: white;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #E2E8F0;
            padding: 15px 20px;
            font-weight: 600;
            border-radius: 15px 15px 0 0;
        }

        /* Dark Mode */
        .dark-mode {
            background: #0F172A;
        }

        .dark-mode .navbar-top,
        .dark-mode .card,
        .dark-mode .stat-card {
            background: #1E293B;
            color: white;
        }

        .dark-mode .card-header {
            background: #1E293B;
            border-bottom-color: #334155;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -280px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .content {
                margin-left: 0;
            }
            .menu-toggle {
                display: inline-block;
                cursor: pointer;
            }
        }

        .menu-toggle {
            cursor: pointer;
            font-size: 1.2rem;
        }

        .dropdown-toggle {
            cursor: pointer;
            text-decoration: none;
        }

        .text-dark {
            color: #1e293b !important;
        }

        .dark-mode .text-dark {
            color: white !important;
        }
    </style>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
        
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        }
        
        if(localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>