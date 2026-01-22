<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JABVIS - UKK</title>
    <!-- Gunakan Bootstrap Offline: Download file bootstrap dan simpan di folder public -->
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->

    <!-- CDN untuk development (Hapus jika offline) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
        <a class="navbar-brand ms-5 fw-bold" href="#">JabVis's</a>
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Session::has('is_login'))
                        @if (Session::get('role') == 'Pembeli')
                            <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Beranda</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/cart') }}">Keranjang</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/history') }}">Riwayat</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/dashboard') }}">Beranda</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/produk') }}">Produk</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/admin/transaksi') }}">Transaksi</a>
                            </li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}">Keluar</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link " href="{{ url('/login') }}">Masuk</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Daftar</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Script JS -->
    <!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
