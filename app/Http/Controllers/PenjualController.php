<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        $pendapatan = Transaksi::where('keterangan', 'selesai')->sum('total_bayar');

        return view('penjual.dashboard', compact('totalProduk', 'totalTransaksi', 'pendapatan'));
    }

    // --- PRODUK ---

    public function indexProduk()
    {
        $produks = Produk::all();
        return view('penjual.produk.index', compact('produks'));
    }

    public function createProduk()
    {
        return view('penjual.produk.create');
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto_produk' => 'nullable|image'
        ]);

        $input = $request->all();

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . '.' . $file->extension();
            $file->move(public_path('images'), $nama_file);
            $input['foto_produk'] = $nama_file;
        }

        Produk::create($input);
        return redirect('/admin/produk');
    }

    public function editProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return view('penjual.produk.edit', compact('produk'));
    }

    public function updateProduk(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $input = $request->all();

        if ($request->hasFile('foto_produk')) {
            // Hapus foto lama jika ada
            if ($produk->foto_produk && file_exists(public_path('images/' . $produk->foto_produk))) {
                unlink(public_path('images/' . $produk->foto_produk));
            }

            $file = $request->file('foto_produk');
            $nama_file = time() . '.' . $file->extension();
            $file->move(public_path('images'), $nama_file);
            $input['foto_produk'] = $nama_file;
        }

        $produk->update($input);
        return redirect('/admin/produk');
    }

    public function deleteProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect('/admin/produk')->with('success', 'Produk berhasil dihapus');
    }

    // --- TRANSAKSI ---

    public function indexTransaksi()
    {
        $transaksis = Transaksi::with(['pelanggan', 'detailTransaksi.produk'])->latest()->get();
        return view('penjual.transaksi.index', compact('transaksis'));
    }

    public function updateStatusTransaksi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Status transaksi diperbarui');
    }
}
