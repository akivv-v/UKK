<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EYLENS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { overflow-x: hidden; }
        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #212529;
            color: white;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #dc3545; /* Warna merah sesuai tema JabVis */
            color: white;
        }
        .main-content { width: 100%; background-color: #f8f9fa; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar d-flex flex-column flex-shrink-0">
        <div class="p-3 text-center">
            <h4 class="fw-bold text-white">EYLENS ADMIN</h4>
            <small class="text-secondary">{{ Session::get('role') }}</small>
            <hr>
        </div>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/produk') }}" class="nav-link {{ Request::is('admin/produk*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam me-2"></i> Data Barang
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/transaksi') }}" class="nav-link {{ Request::is('admin/transaksi*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check me-2"></i> Data Transaksi
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/ongkir') }}" class="nav-link {{ Request::is('admin/ongkir*') ? 'active' : '' }}">
                    <i class="bi bi-truck me-2"></i> Data Ongkir
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/laporan') }}" class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Pembayaran
                </a>
            </li>
        </ul>
        <hr>
        <div class="p-3">
            <a href="{{ url('/logout') }}" class="btn btn-outline-light w-100 btn-sm">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
        </div>
    </div>

    <div class="main-content p-4">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>