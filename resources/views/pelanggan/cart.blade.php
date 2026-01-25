@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 fw-bold">Keranjang Belanja</h2>

        @if (session('cart'))
            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th width="150">Jumlah</th>
                                        <th>Subtotal</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_belanja = 0; @endphp
                                    @foreach (session('cart') as $id => $details)
                                        @php
                                            $subtotal = $details['price'] * $details['quantity'];
                                            $total_belanja += $subtotal;
                                        @endphp
                                        <tr data-id="{{ $id }}">
                                            <td>{{ $details['name'] }}</td>
                                            <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary update-cart"
                                                        data-action="minus">-</button>

                                                    <input type="number" value="{{ $details['quantity'] }}"
                                                        class="form-control text-center quantity" readonly>

                                                    <button class="btn btn-outline-secondary update-cart"
                                                        data-action="plus">+</button>
                                                </div>
                                            </td>
                                            <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-link text-danger remove-from-cart">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="bi bi-geo-alt-fill text-danger"></i> Alamat Pengiriman</h5>
                            <p class="text-muted mb-0">
                                <strong>{{ session('nama_user') }}</strong> | {{ session('no_hp') }}<br>
                                {{ session('alamat') ?? 'Alamat belum diisi. Silakan lengkapi profil Anda.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-dark text-white fw-bold">Ringkasan Pembayaran</div>
                        <div class="card-body">
                            <form action="{{ url('/checkout') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pilih Wilayah (Ongkir)</label>
                                    <select name="id_ongkir" id="pilihOngkir" class="form-select" required>
                                        <option value="" data-biaya="0">-- Pilih Wilayah --</option>
                                        @foreach ($ongkirs as $ongkir)
                                            <option value="{{ $ongkir->id_ongkir }}" data-biaya="{{ $ongkir->biaya }}">
                                                {{ $ongkir->daerah }} - Rp
                                                {{ number_format($ongkir->biaya, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal Belanja</span>
                                    <span class="fw-bold">Rp {{ number_format($total_belanja, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Biaya Kirim</span>
                                    <span id="tampilOngkir" class="fw-bold">Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="h5 fw-bold">Total Bayar</span>
                                    <span id="totalAkhir" class="h5 fw-bold text-danger">Rp
                                        {{ number_format($total_belanja, 0, ',', '.') }}</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metodePembayaran" class="form-select" required>
                                        <option value="Tunai">Tunai / COD</option>
                                        <option value="Transfer">Transfer Bank (BCA)</option>
                                        <option value="Dana">Dana</option>
                                        <option value="Gopay">Gopay</option>
                                        <option value="QRIS">QRIS</option>
                                    </select>
                                </div>

                                <div id="infoPembayaran" class="mb-3 d-none">
                                    <div class="alert alert-warning py-2 small">
                                        <strong>Instruksi Pembayaran:</strong><br>
                                        BCA: 1234-5678-90 a/n EYLENS<br>
                                        Dana/Gopay/QRIS : 0812-3456-7890 (EYLENS STORE)
                                    </div>
                                    <label class="form-label small fw-bold">Upload Bukti Pembayaran</label>
                                    <input type="file" name="bukti_pembayaran" class="form-control">
                                </div>

                                <button class="btn btn-danger w-100 fw-bold py-2 shadow-sm">Proses Bayar Sekarang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center mt-5">
                <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                <h4 class="mt-3">Keranjang masih kosong</h4>
                <a href="{{ url('/home') }}" class="btn btn-primary mt-3">Belanja Sekarang</a>
            </div>
        @endif
    </div>

    <script>
        // Script Hitung Total Otomatis
        const subtotal = {{ $total_belanja }};
        const pilihOngkir = document.getElementById('pilihOngkir');
        const tampilOngkir = document.getElementById('tampilOngkir');
        const totalAkhir = document.getElementById('totalAkhir');

        pilihOngkir.addEventListener('change', function() {
            // Ambil atribut data-biaya dari option yang dipilih
            const biaya = parseInt(this.options[this.selectedIndex].getAttribute('data-biaya')) || 0;
            const total = subtotal + biaya;

            // Tampilkan biaya ongkir & total akhir (format rupiah sederhana)
            tampilOngkir.innerText = 'Rp ' + biaya.toLocaleString('id-ID');
            totalAkhir.innerText = 'Rp ' + total.toLocaleString('id-ID');
        });

        // Script Munculkan Bukti Pembayaran
        document.getElementById('metodePembayaran').addEventListener('change', function() {
            const info = document.getElementById('infoPembayaran');
            if (this.value !== 'Tunai') {
                info.classList.remove('d-none');
            } else {
                info.classList.add('d-none');
            }
        });

        // Script untuk Update Kuantitas dan Hapus Produk
        document.querySelectorAll('.update-cart').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = row.getAttribute('data-id');
                const action = this.getAttribute('data-action');
                let qtyInput = row.querySelector('.quantity');
                let currentQty = parseInt(qtyInput.value);

                if (action === 'plus') {
                    currentQty++;
                } else if (action === 'minus' && currentQty > 1) {
                    currentQty--;
                }

                // Kirim perubahan ke server menggunakan fetch
                updateCartServer(id, currentQty);
            });
        });

        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm("Hapus produk ini dari keranjang?")) {
                    const id = this.closest('tr').getAttribute('data-id');
                    removeCartServer(id);
                }
            });
        });

        function updateCartServer(id, qty) {
            fetch("{{ url('/update-cart') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: id,
                    quantity: qty
                })
            }).then(() => window.location.reload());
        }

        function removeCartServer(id) {
            fetch("{{ url('/remove-from-cart') }}", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: id
                })
            }).then(() => window.location.reload());
        }
    </script>
@endsection
