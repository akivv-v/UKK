@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5">
                    @if ($produk->foto_produk)
                        <img src="{{ asset('images/' . $produk->foto_produk) }}" class="img-fluid w-100 h-100"
                            style="object-fit: cover; min-height: 400px;" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="bg-light text-muted d-flex align-items-center justify-content-center"
                            style="min-height: 400px;">
                            <i class="bi bi-image fs-1 d-block"> No Image</i>
                        </div>
                    @endif
                </div>

                <div class="col-md-7 p-4 p-lg-5 d-flex flex-column justify-content-center">
                    <h1 class="fw-bold mb-2">{{ $produk->nama_produk }}</h1>
                    <h2 class="text-danger fw-bold mb-4">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>

                    <div class="mb-4">
                        <h6 class="fw-bold text-muted text-uppercase small">Deskripsi Produk</h6>
                        <p class="text-secondary" style="line-height: 1.6;">
                            {{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <span
                            class="badge {{ $produk->stok > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} p-2">
                            <i class="bi bi-box-seam me-1"></i> Stok: {{ $produk->stok }} tersedia
                        </span>
                    </div>

                    <hr class="my-4">

                    <form action="{{ url('/cart/' . $produk->id_produk) }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-danger btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm"
                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                            </button>
                            <a href="{{ url('/home') }}" class="btn btn-outline-secondary btn-lg px-4 py-3 rounded-pill">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Sedikit sentuhan visual agar lebih "mahal" */
        .breadcrumb-item+.breadcrumb-item::before {
            content: ">";
        }

        .card {
            transition: transform 0.3s ease;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            transform: translateY(-2px);
        }
    </style>
@endsection
