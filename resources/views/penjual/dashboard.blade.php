@extends('layouts.app')

@section('content')

        <div class="d-flex justify-content-center" >
            <div class="row w-100 g-4">
                <div class="col-md-4">
                    <div class="card bg-danger text-white border-0 shadow-sm h-100 py-4">
                        <div class="card-body text-center">
                            <h5 class="text-uppercase small fw-bold opacity-75">Total Produk</h5>
                            <h1 class="display-4 fw-bold my-3">{{ $totalProduk }}</h1>
                            <p class="mb-0">Produk Terdaftar</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-secondary text-white border-0 shadow-sm h-100 py-4">
                        <div class="card-body text-center">
                            <h5 class="text-uppercase small fw-bold opacity-75">Total Transaksi</h5>
                            <h1 class="display-4 fw-bold my-3">{{ $totalTransaksi }}</h1>
                            <p class="mb-0">Pesanan Masuk</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-danger text-white border-0 shadow-sm h-100 py-4">
                        <div class="card-body text-center">
                            <h5 class="text-uppercase small fw-bold opacity-75">Pendapatan</h5>
                            <h2 class="fw-bold my-3">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h2>
                            <p class="mb-0">Total Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
