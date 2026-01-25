@extends('penjual.layouts.sidebar')

@section('content')
    <h3 class="text-center mt-4 fw-bold">Edit Data Barang</h3>
    <div class="card-body fw-bold">
        <form action="{{ url('/admin/produk/' . $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi Produk</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $produk->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label>Foto Produk (Biarkan kosong jika tidak diganti)</label>
                <input type="file" name="foto_produk" class="form-control">
                @if ($produk->foto_produk)
                    <small>Ada foto saat ini</small>
                @endif
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                <button type="submit" class="btn btn-danger w-100">Update</button>
                <a href="{{ url('/admin/produk') }}" class="btn btn-secondary w-100">Batal</a>
            </div>
        </form>
    </div>
    </div>
@endsection
