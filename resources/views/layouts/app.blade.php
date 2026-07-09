<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMRS RS Ar Bunda - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --primary-color: #0d6efd; --sidebar-bg: #1a1d21; --sidebar-hover: #2c3035; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; overflow-x: hidden; }
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: var(--sidebar-bg); color: #fff; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 100; transition: all 0.3s; }
        .sidebar-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-header h5 { color: #fff; margin: 0; font-size: 15px; font-weight: 600; }
        .sidebar-header small { color: #6c757d; font-size: 11px; }
        .sidebar .nav-section { padding: 10px 20px 5px; font-size: 11px; text-transform: uppercase; color: #6c757d; letter-spacing: 1px; font-weight: 600; }
        .sidebar .nav-item { padding: 8px 20px; display: flex; align-items: center; color: #a0a8b5; text-decoration: none; transition: all 0.2s; font-size: 14px; cursor: pointer; border: none; background: none; width: 100%; text-align: left; }
        .sidebar .nav-item:hover, .sidebar .nav-item.active { background: var(--sidebar-hover); color: #fff; }
        .sidebar .nav-item i { width: 22px; margin-right: 10px; font-size: 14px; }
        .sidebar .nav-item .arrow { margin-left: auto; transition: transform 0.3s; }
        .sidebar .nav-item .arrow.rotated { transform: rotate(90deg); }
        .sidebar .sub-menu { display: none; }
        .sidebar .sub-menu.show { display: block; }
        .sidebar .sub-menu .nav-item { padding-left: 52px; font-size: 13px; }
        .main-content { margin-left: var(--sidebar-width); flex: 1; padding: 20px; min-height: 100vh; }
        .top-bar { background: #fff; padding: 12px 25px; margin: -20px -20px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; }
        .top-bar h4 { margin: 0; font-size: 18px; font-weight: 600; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.08); margin-bottom: 20px; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; padding: 15px 20px; font-weight: 600; }
        .stat-card { padding: 20px; border-radius: 10px; color: #fff; }
        .stat-card i { font-size: 40px; opacity: .3; position: absolute; right: 20px; top: 20px; }
        .stat-card .number { font-size: 28px; font-weight: 700; }
        .stat-card .label { font-size: 13px; opacity: .8; }
        .table th { background: #f8f9fa; font-size: 13px; font-weight: 600; }
        .table td { font-size: 13px; vertical-align: middle; }
        .btn-sm { font-size: 12px; }
        .badge { font-size: 11px; }
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 12px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .search-box { width: 280px; }
        @media (max-width: 768px) { .sidebar { left: -260px; } .sidebar.show { left: 0; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5><i class="fas fa-hospital me-2"></i>RS Ar Bunda</h5>
                <small>Sistem Informasi Manajemen RS</small>
            </div>
            <div class="nav-section">Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>

            <div class="nav-section">Registrasi</div>
            <a href="{{ route('registrations.index') }}" class="nav-item {{ request()->routeIs('registrations*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Pendaftaran
            </a>
            <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Pasien
            </a>

            <div class="nav-section">Pelayanan</div>
            <a href="{{ route('outpatient-visits.index') }}" class="nav-item {{ request()->routeIs('outpatient-visits*') ? 'active' : '' }}">
                <i class="fas fa-walking"></i> Rawat Jalan
            </a>
            <a href="{{ route('inpatient-admissions.index') }}" class="nav-item {{ request()->routeIs('inpatient-admissions*') ? 'active' : '' }}">
                <i class="fas fa-procedures"></i> Rawat Inap
            </a>
            <a href="{{ route('emergency-visits.index') }}" class="nav-item {{ request()->routeIs('emergency-visits*') ? 'active' : '' }}">
                <i class="fas fa-ambulance"></i> IGD
            </a>

            <div class="nav-section">Penunjang</div>
            <a href="{{ route('prescriptions.index') }}" class="nav-item {{ request()->routeIs('prescriptions*') ? 'active' : '' }}">
                <i class="fas fa-prescription"></i> Resep Obat
            </a>
            <a href="{{ route('lab-requests.index') }}" class="nav-item {{ request()->routeIs('lab-requests*') ? 'active' : '' }}">
                <i class="fas fa-flask"></i> Laboratorium
            </a>
            <a href="{{ route('radiology-requests.index') }}" class="nav-item {{ request()->routeIs('radiology-requests*') ? 'active' : '' }}">
                <i class="fas fa-x-ray"></i> Radiologi
            </a>

            <div class="nav-section">Keuangan</div>
            <a href="{{ route('patient-bills.index') }}" class="nav-item {{ request()->routeIs('patient-bills*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> Tagihan
            </a>
            <a href="{{ route('payments.index') }}" class="nav-item {{ request()->routeIs('payments*') ? 'active' : '' }}">
                <i class="fas fa-cash-register"></i> Pembayaran
            </a>

            <div class="nav-section">Master Data</div>
            <button class="nav-item" onclick="toggleSubmenu(this)">
                <i class="fas fa-database"></i> Master Data <i class="fas fa-chevron-right arrow"></i>
            </button>
            <div class="sub-menu">
                <a href="{{ route('doctors.index') }}" class="nav-item">Dokter</a>
                <a href="{{ route('polyclinics.index') }}" class="nav-item">Poli</a>
                <a href="{{ route('rooms.index') }}" class="nav-item">Kamar</a>
                <a href="{{ route('room-categories.index') }}" class="nav-item">Kelas Kamar</a>
                <a href="{{ route('medicines.index') }}" class="nav-item">Obat</a>
                <a href="{{ route('medicine-categories.index') }}" class="nav-item">Kategori Obat</a>
                <a href="{{ route('lab-tests.index') }}" class="nav-item">Tes Lab</a>
                <a href="{{ route('radiology-tests.index') }}" class="nav-item">Tes Radiologi</a>
                <a href="{{ route('medical-services.index') }}" class="nav-item">Layanan Medis</a>
                <a href="{{ route('insurances.index') }}" class="nav-item">Asuransi</a>
                <a href="{{ route('diagnoses.index') }}" class="nav-item">Diagnosa</a>
                <a href="{{ route('suppliers.index') }}" class="nav-item">Supplier</a>
                <a href="{{ route('schedules.index') }}" class="nav-item">Jadwal Dokter</a>
                <a href="{{ route('referrals.index') }}" class="nav-item">Rujukan</a>
            </div>

            <div class="nav-section">Laporan</div>
            <a href="{{ route('reports.daily') }}" class="nav-item {{ request()->routeIs('reports.daily') ? 'active' : '' }}">
                <i class="fas fa-calendar-day"></i> Laporan Harian
            </a>
            <a href="{{ route('reports.financial') }}" class="nav-item {{ request()->routeIs('reports.financial') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan Keuangan
            </a>
        </nav>

        <div class="main-content">
            <div class="top-bar">
                <div>
                    <button class="btn btn-sm btn-outline-secondary d-md-none me-2" onclick="document.getElementById('sidebar').classList.toggle('show')">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4>@yield('title', 'Dashboard')</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small"><i class="fas fa-user me-1"></i>{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
            
            <div class="footer">
                &copy; {{ date('Y') }} RS Ar Bunda Lubuklinggau. All rights reserved.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSubmenu(btn) {
            btn.nextElementSibling.classList.toggle('show');
            btn.querySelector('.arrow').classList.toggle('rotated');
        }
        @stack('scripts')
    </script>
</body>
</html>