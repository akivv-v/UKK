<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EYLENS - UKK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ !Session::has('is_login') ? url('/register-admin') : url('/') }}">
                {{ Session::has('is_login') ? "JabVis's" : 'JabVis' }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Session::has('is_login'))
                        @if (Session::get('role') == 'Pembeli')
                            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/cart') }}">Keranjang</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/history') }}">Riwayat</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/dashboard') }}">Beranda
                                    Admin</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/produk') }}">Kelola Produk</a>
                            </li>
                        @endif
                        <li class="nav-item"><a class="nav-link btn btn-outline-light ms-lg-2"
                                href="{{ url('/logout') }}">Keluar</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Masuk</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-light text-danger ms-lg-2 px-3 fw-bold"
                                href="{{ url('/register') }}">Daftar</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
