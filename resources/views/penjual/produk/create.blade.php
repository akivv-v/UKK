@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Tambah Produk Baru</div>
    <div class="card-body">
        <form action="{{ url('/admin/produk') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Foto Produk</label>
                <input type="file" name="foto_produk" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('/admin/produk') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
