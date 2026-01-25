<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\OngkosKirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk database transaction

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

        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk sedang habis!');
        }

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

    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $produk = Produk::find($request->id);

            if ($request->quantity > $produk->stok) {
                return response()->json(['status' => 'error', 'message' => 'Stok tidak mencukupi']);
            }

            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['status' => 'success']);
        }
    }

    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['status' => 'success']);
        }
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
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $cart = session('cart');
        if (!$cart) return redirect('/home')->with('error', 'Keranjang kosong!');

        // Gunakan Database Transaction agar jika satu error, semua dibatalkan (lebih aman)
        DB::beginTransaction();

        try {
            $totalBelanja = 0;
            foreach ($cart as $details) {
                $totalBelanja += $details['price'] * $details['quantity'];
            }

            $ongkir = OngkosKirim::findOrFail($request->id_ongkir);
            $totalBayar = $totalBelanja + $ongkir->biaya;

            // 1. Simpan Transaksi
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

                Produk::where('id_produk', $id)->decrement('stok', $details['quantity']);
            }

            // 3. Simpan Pembayaran
            $nama_file = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $nama_file = time() . '_' . session('id_pelanggan') . '.' . $file->extension();
                $file->move(public_path('images'), $nama_file);
            }

            $transaksi->pembayaran()->create([
                'waktu_pembayaran' => now(),
                'total' => $totalBayar,
                'metode' => $request->metode_pembayaran,
                'bukti_pembayaran' => $nama_file
            ]);

            DB::commit(); 
            session()->forget('cart');

            return redirect('/invoice/' . $transaksi->id_transaksi);
        } catch (\Exception $e) {
            DB::rollback(); 
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // TAMPILKAN INVOICE SETELAH BAYAR
    public function showInvoice($id)
    {
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'ongkosKirim', 'pembayaran'])
            ->where('id_transaksi', $id)
            ->where('id_pelanggan', session('id_pelanggan')) 
            ->firstOrFail();

        return view('pelanggan.invoice', compact('transaksi'));
    }

    public function history()
    {
        $transaksis = Transaksi::where('id_pelanggan', session('id_pelanggan'))
            ->with(['detailTransaksi.produk', 'ongkosKirim', 'pembayaran'])
            ->latest()
            ->get();

        return view('pelanggan.history', compact('transaksis'));
    }
}
