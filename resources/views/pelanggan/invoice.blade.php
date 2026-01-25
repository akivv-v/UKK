@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success d-print-none border-0 shadow-sm mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> 
                Pembayaran Anda telah berhasil diterima dan sedang diproses!
            </div>

            <div class="card border-0 shadow-sm p-4 p-md-5" id="areaInvoice">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h1 class="fw-bold text-danger mb-0">EYLENS</h1>
                        <p class="text-muted">Kacamata Berkualitas & Terpercaya</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h4 class="fw-bold">INVOICE</h4>
                        <p class="mb-0">#TRX-{{ $transaksi->id_transaksi }}</p>
                        <p class="text-muted small">{{ $transaksi->tanggaltransaksi }}</p>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="text-muted small text-uppercase fw-bold">Tujuan Pengiriman:</h6>
                        <p class="mb-0 fw-bold">{{ session('nama_user') }}</p>
                        <p class="mb-0">{{ session('no_hp') }}</p>
                        <p class="text-muted mb-0">{{ session('alamat') }}</p>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="text-muted small text-uppercase fw-bold">Metode Pembayaran:</h6>
                        <p class="mb-0">{{ $transaksi->pembayaran->metode }}</p>
                        <span class="badge bg-success-subtle text-success mt-1">LUNAS</span>
                    </div>
                </div>

                <table class="table table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->detailTransaksi as $detail)
                        <tr>
                            <td>{{ $detail->produk->nama_produk }}</td>
                            <td class="text-center">{{ $detail->jumlah_produk }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_produk, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="4"><hr></td></tr>
                        <tr>
                            <td colspan="3" class="text-end text-muted">Ongkos Kirim ({{ $transaksi->ongkosKirim->daerah }})</td>
                            <td class="text-end fw-bold">Rp {{ number_format($transaksi->ongkosKirim->biaya, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold h5">Total Pembayaran</td>
                            <td class="text-end fw-bold h5 text-danger">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-5 text-center d-none d-print-block">
                    <p class="small text-muted italic">Terima kasih telah berbelanja di EYLENS Store!</p>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2 justify-content-center d-print-none">
                <button onclick="window.print()" class="btn btn-dark px-4 py-2 fw-bold">
                    <i class="bi bi-printer me-2"></i> Cetak Struk
                </button>
                <a href="{{ url('/history') }}" class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-list-ul me-2"></i> Lihat Riwayat Belanja
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body { background-color: white !important; }
        .navbar, .d-print-none, footer { display: none !important; }
        .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>
@endsection