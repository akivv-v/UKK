@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($produks as $produk)
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            @if($produk->foto_produk)
                <img src="{{ asset('images/' . $produk->foto_produk) }}" class="card-img-top" alt="{{ $produk->nama_produk }}">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                    No Image
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                <p class="card-text text-primary fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                <p class="card-text text-muted small">Stok: {{ $produk->stok }}</p>
                <a href="{{ url('/produk/' . $produk->id_produk) }}" class="btn btn-danger w-100 mb-1">Lihat Detail</a>
                <a href="{{ url('/produk/' . $produk->id_produk) }}" class="btn btn-danger w-100 mt-1">Beli Sekarang</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
