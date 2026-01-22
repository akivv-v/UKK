@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Produk</h2>
    <a href="{{ url('/admin/produk/create') }}" class="btn btn-primary">Tambah Produk</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $key => $produk)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if($produk->foto_produk)
                            <img src="{{ asset('storage/' . $produk->foto_produk) }}" width="50">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>
                        <a href="{{ url('/admin/produk/' . $produk->id_produk . '/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ url('/admin/produk/' . $produk->id_produk) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
