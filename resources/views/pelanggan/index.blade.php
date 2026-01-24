@extends('layouts.app')

@section('content')
    <div class="row mt-4">
        @foreach ($produks as $produk)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($produk->foto_produk)
                        <img src="{{ asset('images/' . $produk->foto_produk) }}" class="card-img-top"
                            alt="{{ $produk->nama_produk }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            No Image
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate" title="{{ $produk->nama_produk }}">
                            {{ $produk->nama_produk }}
                        </h5>

                        <p class="card-text text-muted small mb-2">
                            {{ Str::limit($produk->deskripsi, 60, '...') }}
                        </p>

                        <div class="mt-auto">
                            <p class="card-text text-primary fw-bold mb-1">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                            <p class="card-text text-muted small mb-3">Stok: {{ $produk->stok }}</p>

                            <div class="d-grid">
                                <a href="{{ url('/produk/' . $produk->id_produk) }}" class="btn btn-danger btn-sm py-2">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
