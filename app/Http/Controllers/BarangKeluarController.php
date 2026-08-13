<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluars = BarangKeluar::with('barang')
            ->latest()
            ->paginate(10);

        return view('barang_keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('barang_keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'tujuan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah' => 'Jumlah barang keluar melebihi stok yang tersedia.'
                ]);
        }

        BarangKeluar::create([
            'kode_transaksi' => 'BK-' . date('YmdHis'),
            'barang_id' => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah' => $request->jumlah,
            'tujuan' => $request->tujuan,
            'keterangan' => $request->keterangan,
        ]);

        $barang->decrement('stok', $request->jumlah);

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barangKeluar = BarangKeluar::with('barang')->findOrFail($id);

        return view('barang_keluar.show', compact('barangKeluar'));
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();

        return view(
            'barang_keluar.edit',
            compact('barangKeluar', 'barangs')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'tujuan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);

        $barangLama = Barang::findOrFail($barangKeluar->barang_id);

        // Kembalikan stok transaksi lama
        $barangLama->increment('stok', $barangKeluar->jumlah);

        $barangBaru = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barangBaru->stok) {
            // Batalkan perubahan stok lama
            $barangLama->decrement('stok', $barangKeluar->jumlah);

            return back()
                ->withInput()
                ->withErrors([
                    'jumlah' => 'Jumlah melebihi stok yang tersedia.'
                ]);
        }

        $barangBaru->decrement('stok', $request->jumlah);

        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah' => $request->jumlah,
            'tujuan' => $request->tujuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $barang = Barang::findOrFail($barangKeluar->barang_id);

        $barang->increment('stok', $barangKeluar->jumlah);

        $barangKeluar->delete();

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus.');
    }
}