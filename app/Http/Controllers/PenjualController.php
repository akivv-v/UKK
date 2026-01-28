<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\OngkosKirim;
use App\Models\Pembayaran;
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

    public function indexProduk(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks = $query->get();
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
            'deskripsi' => 'nullable',
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

    public function indexTransaksi(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'detailTransaksi.produk', 'pembayaran']);

        // Cari berdasarkan tanggal transaksi jika ada input
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggaltransaksi', $request->tanggal);
        }

        $transaksis = $query->latest()->get();

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

    // Tambahkan di bagian atas: use App\Models\Ongkir;

    public function indexOngkir(Request $request)
    {
        $query = OngkosKirim::query();

        if ($request->has('search')) {
            $query->where('daerah', 'like', '%' . $request->search . '%');
        }

        $ongkirs = $query->get();
        return view('penjual.ongkir.index', compact('ongkirs'));
    }

    public function storeOngkir(Request $request)
    {
        $request->validate([
            'daerah' => 'required',
            'biaya' => 'required|numeric'
        ]);

        OngkosKirim::create($request->all());
        return back()->with('success', 'Data ongkir berhasil ditambahkan');
    }

    public function updateOngkir(Request $request, $id)
    {
        $ongkir = OngkosKirim::findOrFail($id);
        $ongkir->update($request->all());
        return back()->with('success', 'Data ongkir berhasil diperbarui');
    }

    public function deleteOngkir($id)
    {
        $ongkir = OngkosKirim::findOrFail($id);
        $ongkir->delete();
        return back()->with('success', 'Data ongkir berhasil dihapus');
    }

    public function indexLaporan(Request $request)
{
    $query = Pembayaran::query();

    if ($request->filled('metode')) {
        $query->where('metode', $request->metode);
    }

    if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
        $query->whereBetween('waktu_pembayaran', [$request->tgl_mulai, $request->tgl_selesai]);
    } elseif ($request->filled('tgl_mulai')) {
        $query->whereDate('waktu_pembayaran', '>=', $request->tgl_mulai);
    } elseif ($request->filled('tgl_selesai')) { 
        $query->whereDate('waktu_pembayaran', '<=', $request->tgl_selesai);
    }

    $laporans = $query->latest()->get();
    $totalPendapatan = $laporans->sum('total');

    return view('penjual.laporan.index', compact('laporans', 'totalPendapatan'));
}
}
