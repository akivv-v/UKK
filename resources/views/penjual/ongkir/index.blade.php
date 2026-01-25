@extends('penjual.layouts.sidebar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 d-print-none">
    <h2>Data Ongkos Kirim</h2>
    <div>
        <button onclick="window.print()" class="btn btn-secondary me-2"><i class="bi bi-printer"></i> Cetak Laporan</button>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle"></i> Tambah Daerah</button>
    </div>
</div>

<div class="card mb-4 d-print-none border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ url('/admin/ongkir') }}" method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari nama daerah..." value="{{ request('search') }}">
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
            <h3 class="fw-bold">DAFTAR ONGKOS KIRIM JABVIS</h3>
            <hr>
        </div>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th>Nama Daerah / Wilayah</th>
                    <th>Biaya Ongkir</th>
                    <th class="d-print-none" width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ongkirs as $key => $o)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $o->daerah }}</td>
                    <td>Rp {{ number_format($o->biaya, 0, ',', '.') }}</td>
                    <td class="d-print-none">
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $o->id_ongkir }}">Edit</button>
                        
                        <form action="{{ url('/admin/ongkir/' . $o->id_ongkir) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus daerah ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-secondary">Hapus</button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit{{ $o->id_ongkir }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ url('/admin/ongkir/' . $o->id_ongkir) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header"><h5>Edit Ongkir</h5></div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Daerah</label>
                                        <input type="text" name="daerah" class="form-control" value="{{ $o->daerah }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Biaya</label>
                                        <input type="number" name="biaya" class="form-control" value="{{ $o->biaya }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="4" class="text-center">Data kosong</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ url('/admin/ongkir') }}" method="POST">
            @csrf
            <div class="modal-content text-dark">
                <div class="modal-header"><h5 class="fw-bold">Tambah Daerah & Ongkir</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Daerah</label>
                        <input type="text" name="daerah" class="form-control" placeholder="Contoh: Jakarta Selatan" required>
                    </div>
                    <div class="mb-3">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" placeholder="Contoh: 15000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    @media print {
        .sidebar, .d-print-none, .btn-close, .modal { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
    }
</style>
@endsection