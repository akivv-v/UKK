@extends('penjual.layouts.sidebar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 d-print-none">
        <h2>Laporan Pembayaran</h2>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
    </div>

    <div class="card mb-4 d-print-none border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ url('/admin/laporan') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Pilih Metode Pembayaran</label>
                    <select name="metode" class="form-select">
                        <option value="">Semua Metode</option>
                        <option value="Tunai" {{ request('metode') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Transfer" {{ request('metode') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="Dana" {{ request('metode') == 'Dana' ? 'selected' : '' }}>Dana</option>
                        <option value="Gopay" {{ request('metode') == 'Gopay' ? 'selected' : '' }}>Gopay</option>
                        <option value="QRIS" {{ request('metode') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">Filter Data</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/admin/laporan') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
            <form action="{{ url('/admin/laporan') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Filter Tanggal Awal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Filter Tanggal Akhir</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">Cari</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/admin/laporan') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-none d-print-block text-center mb-4">
                <h3 class="fw-bold">LAPORAN REALISASI PEMBAYARAN JABVIS</h3>
                <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
                <hr>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Waktu Bayar</th>
                        <th>Metode</th>
                        <th class="text-end">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $key => $laporan)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>#{{ $laporan->id_transaksi }}</td>
                            <td>{{ $laporan->waktu_pembayaran }}</td>
                            <td><span class="badge bg-info text-dark">{{ $laporan->metode }}</span></td>
                            <td class="text-end">Rp {{ number_format($laporan->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-secondary fw-bold">
                        <td colspan="4" class="text-center">TOTAL PENDAPATAN</td>
                        <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-none d-print-block mt-5">
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4 text-center">
                        <p>Mengetahui,</p>
                        <br><br><br>
                        <p class="fw-bold">Admin JABVIS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .sidebar,
            .d-print-none {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
            }

            body {
                background-color: white !important;
            }
        }
    </style>
@endsection
