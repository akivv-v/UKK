@extends('layouts.app')

@section('content')
<h2>Riwayat Belanja</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Detail Produk</th>
                    <th>Ongkir</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->tanggaltransaksi }}</td>
                    <td>
                        <ul>
                            @foreach($transaksi->detailTransaksi as $detail)
                                <li>{{ $detail->produk->nama_produk }} x {{ $detail->jumlah_produk }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @if($transaksi->ongkosKirim)
                            {{ $transaksi->ongkosKirim->daerah }} (Rp {{ number_format($transaksi->ongkosKirim->biaya, 0, ',', '.') }})
                        @else
                            -
                        @endif
                    </td>
                    <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $transaksi->keterangan == 'selesai' ? 'success' : ($transaksi->keterangan == 'dikirim' ? 'warning' : 'info') }}">
                            {{ ucfirst($transaksi->keterangan) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
