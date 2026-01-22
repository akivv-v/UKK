@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Edit Produk</div>
    <div class="card-body">
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
                <label>Foto Produk (Biarkan kosong jika tidak diganti)</label>
                <input type="file" name="foto_produk" class="form-control">
                @if($produk->foto_produk)
                    <small>Ada foto saat ini</small>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url('/admin/produk') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
