<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Menampilkan semua data stock.
     */
    public function index()
    {
        $stock = Stock::with('jenisBarang')->latest()->get();

        return view('stock_barang.index', compact('stock'));
    }

    /**
     * Menampilkan form tambah stock.
     */
    public function create()
    {
        $jenisBarang = JenisBarang::all();

        return view('stock_barang.create', compact('jenisBarang'));
    }

    /**
     * Menyimpan stock baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'nama_barang' => 'required|max:255',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|max:50',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        Stock::create([
            'jenis_barang_id' => $request->jenis_barang_id,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('stock_barang.index')
            ->with('success', 'Stock berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail stock.
     */
    public function show($id)
    {
        $stock = Stock::with('jenisBarang')->findOrFail($id);

        return view('stock_barang.show', compact('stock'));
    }

    /**
     * Menampilkan form edit stock.
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        $jenisBarang = JenisBarang::all();

        return view(
            'stock_barang.edit',
            compact('stock', 'jenisBarang')
        );
    }

    /**
     * Mengupdate stock.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'nama_barang' => 'required|max:255',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|max:50',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        $stock = Stock::findOrFail($id);

        $stock->update([
            'jenis_barang_id' => $request->jenis_barang_id,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('stock_barang.index')
            ->with('success', 'Stock berhasil diperbarui.');
    }

    /**
     * Menghapus stock.
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);

        $stock->delete();

        return redirect()
            ->route('stock_barang.index')
            ->with('success', 'Stock berhasil dihapus.');
    }
}