@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @if($produk->foto_produk)
                    <img src="{{ asset('images/' . $produk->foto_produk) }}" class="img-fluid rounded">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 300px;">
                        No Image
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h2>{{ $produk->nama_produk }}</h2>
                <h3 class="text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h3>
                <p class="mt-3">Stok Tersedia: {{ $produk->stok }}</p>
                <hr>
                <form action="{{ url('/cart/' . $produk->id_produk) }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-lg">Tambah ke Keranjang</button>
                    <a href="{{ url('/home') }}" class="btn btn-secondary btn-lg">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
