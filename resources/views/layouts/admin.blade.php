<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SIPAYU SPP System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>

<style>
    <style>
    * { font-family: 'Poppins', sans-serif; }
    body { background: #F8FAFC; margin: 0; padding: 0; }
    
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: #1E293B;
        color: white;
        overflow-y: auto;
        transition: all 0.3s;
        z-index: 1000;
    }
    
    .sidebar .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 12px 20px;
        margin: 5px 15px;
        border-radius: 10px;
        transition: all 0.3s;
        display: block;
        text-decoration: none;
    }
    
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: #2563EB;
        color: white;
        transform: translateX(5px);
    }
    
    .sidebar .nav-link i {
        width: 25px;
        margin-right: 10px;
    }
    
    .content {
        margin-left: 280px;
        padding: 20px;
        min-height: 100vh;
    }
    
    .navbar-top {
        background: white;
        border-radius: 15px;
        padding: 15px 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .stat-card .icon {
        font-size: 2.5rem;
        opacity: 0.2;
        position: absolute;
        right: 20px;
        bottom: 20px;
    }
    
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        background: white;
    }
    
    .card-header {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 15px 20px;
        font-weight: 600;
        border-radius: 15px 15px 0 0;
    }
    
    .btn-primary {
        background: #2563EB;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
    }
    
    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }
    
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
    
    .dark-mode {
        background: #1a1a2e;
        color: white;
    }
    
    .dark-mode .card,
    .dark-mode .stat-card,
    .dark-mode .navbar-top {
        background: #16213e;
        color: white;
    }
    
    .table {
        color: inherit;
    }
    
    .menu-toggle {
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    .dropdown-toggle {
        cursor: pointer;
    }
    
    .text-dark {
        color: #1e293b !important;
    }
    
    .dark-mode .text-dark {
        color: white !important;
    }
    
    .bg-white {
        background: white;
    }
    
    .dark-mode .bg-white {
        background: #16213e;
    }

    /* SweetAlert Custom - Global */
.swal2-popup {
    border-radius: 16px !important;
    padding: 30px 25px !important;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
}

.swal2-title {
    font-size: 1.4rem !important;
    font-weight: 700 !important;
    color: #1E293B !important;
}

.swal2-html-container {
    font-size: 1rem !important;
    color: #475569 !important;
    line-height: 1.7 !important;
    margin-top: 8px !important;
}

.swal2-confirm {
    padding: 10px 35px !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    min-width: 120px !important;
}

.swal2-cancel {
    padding: 10px 35px !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    font-size: 0.95rem !important;
    min-width: 120px !important;
}

.swal2-actions {
    gap: 14px !important;
    margin-top: 10px !important;
}

.swal2-icon {
    margin-bottom: 10px !important;
}
</style>
</style>

<body>
    <div class="sidebar">
        <div class="text-center py-4">
            <i class="fas fa-graduation-cap fa-2x"></i>
            <h5 class="mt-2">SIPAYU</h5>
            <small>Sistem Pembayaran SPP</small>
        </div>
        <hr class="mx-3 my-2 bg-secondary">
        <nav class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
               href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}" 
               href="{{ route('admin.siswa.index') }}">
                <i class="fas fa-users"></i> Data Siswa
            </a>
            <a class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}" 
               href="{{ route('admin.kelas.index') }}">
                <i class="fas fa-building"></i> Kelas
            </a>
            <a class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}" 
               href="{{ route('admin.jurusan.index') }}">
                <i class="fas fa-book"></i> Jurusan
            </a>
            <a class="nav-link {{ request()->routeIs('admin.spp.*') ? 'active' : '' }}" 
               href="{{ route('admin.spp.index') }}">
                <i class="fas fa-file-invoice-dollar"></i> SPP
            </a>
            <a class="nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}" 
               href="{{ route('admin.pembayaran.index') }}">
                <i class="fas fa-credit-card"></i> Pembayaran
            </a>
            <a class="nav-link {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}" 
               href="{{ route('admin.verifikasi.index') }}">
                <i class="fas fa-check-circle"></i> Verifikasi
            </a>
            <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" 
               href="{{ route('admin.laporan.index') }}">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            @if(Auth::user()->role == 'admin')
            <a class="nav-link {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}" 
               href="{{ route('admin.pengguna.index') }}">
                <i class="fas fa-user-shield"></i> Pengguna
            </a>
             <a class="nav-link" href="{{ route('tagihan.bulk') }}">
    <i class="fas fa-calendar-plus me-2"></i> Buat Tagihan Massal
</a>
            @endif
            <hr class="mx-3 my-2 bg-secondary">
            <a class="nav-link" href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
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
        <i class="fas fa-user-circle fa-lg"></i> {{ Auth::user()->name ?? 'Admin' }}
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="#" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')

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
<script>
// Global function untuk SweetAlert Delete
function confirmDelete(url, name, callback) {
    Swal.fire({
        title: 'Hapus Data?',
        html: `Yakin ingin menghapus <strong>${name}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            if (callback) {
                callback();
            } else {
                window.location.href = url;
            }
        }
    });
}
</script>
</body>
</html>