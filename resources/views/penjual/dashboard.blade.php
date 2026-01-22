@extends('layouts.app')

@section('content')
<h2>Dashboard Penjual</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Produk</h5>
                <h2>{{ $totalProduk }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Transaksi</h5>
                <h2>{{ $totalTransaksi }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5>Pendapatan</h5>
                <h2>Rp {{ number_format($pendapatan, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ url('/admin/produk') }}" class="btn btn-primary">Kelola Produk</a>
    <a href="{{ url('/admin/transaksi') }}" class="btn btn-success">Kelola Transaksi</a>
</div>
@endsection
