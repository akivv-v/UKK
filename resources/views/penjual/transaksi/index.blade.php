@extends('penjual.layouts.sidebar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 d-print-none">
        <h2>Daftar Transaksi</h2>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
    </div>

    <div class="card mb-4 d-print-none border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ url('/admin/transaksi') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Filter Tanggal Transaksi</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Cari</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url('/admin/transaksi') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-none d-print-block text-center mb-4">
                <h3 class="fw-bold">LAPORAN TRANSAKSI EYLENS</h3>
                @if (request('tanggal'))
                    <p>Periode Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}</p>
                @else
                    <p>Semua Periode Transaksi</p>
                @endif
                <hr>
            </div>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Bukti Bayar</th>
                        <th>Status</th>
                        <th>Detail Produk</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr>
                            <td class="fw-bold">#{{ $transaksi->id_transaksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggaltransaksi)->format('d/m/Y') }}</td>
                            <td>{{ $transaksi->pelanggan->nama_pelanggan }}</td>
                            <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>

                            <td>
                                @if ($transaksi->pembayaran)
                                    <span class="badge border text-dark bg-light">
                                        {{ $transaksi->pembayaran->metode }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <td>
                                @if ($transaksi->pembayaran && $transaksi->pembayaran->bukti_pembayaran)
                                    <a href="{{ asset('images/' . $transaksi->pembayaran->bukti_pembayaran) }}"
                                        target="_blank">
                                        <img src="{{ asset('images/' . $transaksi->pembayaran->bukti_pembayaran) }}"
                                            width="50" height="50" style="object-fit: cover;"
                                            class="rounded border shadow-sm">
                                    </a>
                                @else
                                    @if ($transaksi->pembayaran && $transaksi->pembayaran->metode == 'Tunai')
                                        <small class="text-success fw-bold">Bayar di Tempat</small>
                                    @else
                                        <small class="text-muted small">Tidak ada bukti</small>
                                    @endif
                                @endif
                            </td>

                            <td>
                                <span
                                    class="badge bg-{{ $transaksi->keterangan == 'selesai' ? 'success' : ($transaksi->keterangan == 'dikirim' ? 'warning' : 'info') }}">
                                    {{ ucfirst($transaksi->keterangan) }}
                                </span>
                            </td>

                            <td>
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($transaksi->detailTransaksi as $detail)
                                        <li>{{ $detail->produk->nama_produk }} <span
                                                class="text-muted">x{{ $detail->jumlah_produk }}</span></li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <form action="{{ url('/admin/transaksi/' . $transaksi->id_transaksi . '/status') }}"
                                    method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select name="keterangan" class="form-select">
                                            <option value="diproses"
                                                {{ $transaksi->keterangan == 'diproses' ? 'selected' : '' }}>Diproses
                                            </option>
                                            <option value="dikirim"
                                                {{ $transaksi->keterangan == 'dikirim' ? 'selected' : '' }}>Dikirim
                                            </option>
                                            <option value="selesai"
                                                {{ $transaksi->keterangan == 'selesai' ? 'selected' : '' }}>Selesai
                                            </option>
                                            <option value="dibatalkan"
                                                {{ $transaksi->keterangan == 'dibatalkan' ? 'selected' : '' }}>Batalkan
                                            </option>
                                        </select>
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
