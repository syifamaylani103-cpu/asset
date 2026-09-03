<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    /**
     * Menampilkan semua jenis barang.
     */
    public function index()
    {
        $jenisBarang = JenisBarang::latest()->paginate(10);

        return view('jenis_barang.index', compact('jenisBarang'));
    }

    /**
     * Menampilkan form tambah jenis barang.
     */
    public function create()
    {
        return view('jenis_barang.create');
    }

    /**
     * Menyimpan jenis barang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|max:255',
            'keterangan' => 'nullable'
        ]);

        JenisBarang::create([
            'nama_jenis' => $request->nama_jenis,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('jenis_barang.index')
            ->with('success', 'Jenis barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail jenis barang.
     */
    public function show($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        return view('jenis_barang.show', compact('jenisBarang'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        return view('jenis_barang.edit', compact('jenisBarang'));
    }

    /**
     * Mengupdate jenis barang.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|max:255',
            'keterangan' => 'nullable'
        ]);

        $jenisBarang = JenisBarang::findOrFail($id);

        $jenisBarang->update([
            'nama_jenis' => $request->nama_jenis,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('jenis_barang.index')
            ->with('success', 'Jenis barang berhasil diperbarui.');
    }

    /**
     * Menghapus jenis barang.
     */
    public function destroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        $jenisBarang->delete();

        return redirect()
            ->route('jenis_barang.index')
            ->with('success', 'Jenis barang berhasil dihapus.');
    }
}