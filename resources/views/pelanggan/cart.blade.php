@extends('layouts.app')

@section('content')
<h2>Keranjang Belanja</h2>

@if(session('cart'))
<div class="row">
    <div class="col-md-8">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                    <td>{{ $details['quantity'] }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total Belanja</td>
                    <td class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Checkout</div>
            <div class="card-body">
                <form action="{{ url('/checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Pilih Ongkir</label>
                        <select name="id_ongkir" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($ongkirs as $ongkir)
                                <option value="{{ $ongkir->id_ongkir }}">{{ $ongkir->daerah }} - Rp {{ number_format($ongkir->biaya, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Dana">Dana</option>
                            <option value="Gopay">Gopay</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center mt-5">
    <h4>Keranjang masih kosong</h4>
    <a href="{{ url('/home') }}" class="btn btn-primary mt-3">Belanja Sekarang</a>
</div>
@endif
@endsection
