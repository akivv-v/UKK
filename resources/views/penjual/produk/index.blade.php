@extends('penjual.layouts.sidebar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 d-print-none">
        <h2>Daftar Produk</h2>
        <div>
            <button onclick="window.print()" class="btn btn-secondary me-2">
                <i class="bi bi-printer"></i> Cetak Laporan
            </button>
            <a href="{{ url('/admin/produk/create') }}" class="btn btn-danger">Tambah Produk</a>
        </div>
    </div>

    <div class="card mb-4 d-print-none border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ url('/admin/produk') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-none d-print-block text-center mb-4">
                <h3 class="fw-bold">LAPORAN DATA PRODUK EYLENS</h3>
                <p>Tanggal: {{ date('d-m-Y') }}</p>
                <hr>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produks as $key => $produk)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if ($produk->foto_produk)
                                    <img src="{{ asset('images/' . $produk->foto_produk) }}" width="50" height="50"
                                        style="object-fit: cover;">
                                @else
                                    <small class="text-muted">No Image</small>
                                @endif
                            </td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td><small>{{ $produk->deskripsi ?? '-' }}</small></td>
                            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>
                                <a href="{{ url('/admin/produk/' . $produk->id_produk . '/edit') }}"
                                    class="btn btn-danger btn-sm">Edit</a>
                                <form action="{{ url('/admin/produk/' . $produk->id_produk) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-secondary btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
