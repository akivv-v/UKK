@extends('layouts.app')

@section('content')
        <h3 class="text-center mt-4 fw-bold">Tambah Data Barang</h3>
        <div class="card-body fw-bold">
            <form action="{{ url('/admin/produk') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control"
                        placeholder="Tulis nama kacamata, contoh : Kacamata cat eye..." required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" placeholder="Tulis harga kacamata..."
                        required>
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" placeholder="Tulis stok yang tersedia..."
                        required>
                </div>
                <div class="mb-3">
                    <label>Foto Produk</label>
                    <input type="file" name="foto_produk" placeholder="Tambahkan foto yang sesuai..."
                        class="form-control">
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                    <button type="submit" class="btn btn-danger w-100">Simpan</button>
                    <a href="{{ url('/admin/produk') }}" class="btn btn-secondary w-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
