<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\OngkosKirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PelangganController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('pelanggan.index', compact('produks'));
    }

    public function showProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return view('pelanggan.detail', compact('produk'));
    }

    public function addToCart(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $produk->nama_produk,
                "quantity" => 1,
                "price" => $produk->harga,
                "photo" => $produk->foto_produk
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function showCart()
    {
        $ongkirs = OngkosKirim::all();
        return view('pelanggan.cart', compact('ongkirs'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'id_ongkir' => 'required',
            'metode_pembayaran' => 'required',
            'bukti_pembayaran' => 'nullable|image'
        ]);

        $cart = session('cart');
        if (!$cart) return back();

        // Hitung Total
        $totalBelanja = 0;
        foreach ($cart as $details) {
            $totalBelanja += $details['price'] * $details['quantity'];
        }
        $ongkir = OngkosKirim::find($request->id_ongkir);
        $totalBayar = $totalBelanja + ($ongkir ? $ongkir->biaya : 0);

        // 1. Simpan Transaksi Utama
        $transaksi = Transaksi::create([
            'tanggaltransaksi' => now(),
            'id_pelanggan' => session('id_pelanggan'),
            'id_ongkir' => $request->id_ongkir,
            'total_bayar' => $totalBayar,
            'keterangan' => 'diproses'
        ]);

        // 2. Simpan Detail & Kurangi Stok
        foreach ($cart as $id => $details) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk' => $id,
                'harga_produk' => $details['price'],
                'jumlah_produk' => $details['quantity'],
                'subtotal' => $details['price'] * $details['quantity']
            ]);
            Produk::find($id)->decrement('stok', $details['quantity']);
        }

        // 3. LOGIKA TABEL PEMBAYARAN (Sesuai database kamu)
        $nama_file = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $nama_file = time() . '.' . $file->extension();
            $file->move(public_path('images'), $nama_file);
        }

        // Buat data di tabel pembayarans melalui relasi
        $transaksi->pembayaran()->create([
            'waktu_pembayaran' => now(),
            'total' => $totalBayar,
            'metode' => $request->metode_pembayaran,
            'bukti_pembayaran' => $nama_file
        ]);

        session()->forget('cart');
        return redirect('/history')->with('success', 'Transaksi berhasil!');
    }

    public function history()
    {
        $transaksis = Transaksi::where('id_pelanggan', session('id_pelanggan'))
            ->with(['detailTransaksi.produk', 'ongkosKirim'])
            ->latest()
            ->get();
        return view('pelanggan.history', compact('transaksis'));
    }
}
