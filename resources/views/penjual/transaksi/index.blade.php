@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <h2>Daftar Transaksi</h2>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Bukti Bayar</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td>#{{ $transaksi->id_transaksi }}</td>
                        <td>{{ $transaksi->tanggaltransaksi }}</td>
                        <td>{{ $transaksi->pelanggan->nama_pelanggan }}</td>
                        <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            @if ($transaksi->pembayaran && $transaksi->pembayaran->bukti_pembayaran)
                                <a href="{{ asset('images/' . $transaksi->pembayaran->bukti_pembayaran) }}" target="_blank">
                                    <img src="{{ asset('images/' . $transaksi->pembayaran->bukti_pembayaran) }}"
                                        width="50" height="50" style="object-fit: cover;">
                                </a>
                            @else
                                <small class="text-muted">Belum bayar</small>
                            @endif
                        </td>
                        <td>
                            <span
                                class="badge bg-{{ $transaksi->keterangan == 'selesai' ? 'success' : ($transaksi->keterangan == 'dikirim' ? 'warning' : 'info') }}">
                                {{ ucfirst($transaksi->keterangan) }}
                            </span>
                        </td>
                        <td>
                            <ul>
                                @foreach ($transaksi->detailTransaksi as $detail)
                                    <li>{{ $detail->produk->nama_produk }} x {{ $detail->jumlah_produk }}</li>
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
