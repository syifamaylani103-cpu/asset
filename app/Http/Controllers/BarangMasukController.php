<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')
            ->latest()
            ->paginate(10);

        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $barangMasuk = BarangMasuk::create([
            'kode_transaksi' => 'BM-' . date('YmdHis'),
            'barang_id' => $request->barang_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $barang->increment('stok', $request->jumlah);

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::with('barang')->findOrFail($id);

        return view('barang_masuk.show', compact('barangMasuk'));
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();

        return view(
            'barang_masuk.edit',
            compact('barangMasuk', 'barangs')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);

        $barangLama = Barang::findOrFail($barangMasuk->barang_id);

        // Kembalikan stok transaksi lama
        $barangLama->decrement('stok', $barangMasuk->jumlah);

        // Tambahkan stok transaksi baru
        $barangBaru = Barang::findOrFail($request->barang_id);
        $barangBaru->increment('stok', $request->jumlah);

        $barangMasuk->update([
            'barang_id' => $request->barang_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah' => $request->jumlah,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barang = Barang::findOrFail($barangMasuk->barang_id);

        $barang->decrement('stok', $barangMasuk->jumlah);

        $barangMasuk->delete();

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus.');
    }
}