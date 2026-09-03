<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanController extends Controller
{
    public function index()
    {
        $query = Pengajuan::with(['barang', 'user'])->latest();

        if (Auth::check() && !Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $pengajuans = $query->paginate(10);

        return view('pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('pengajuan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_pengajuan' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'required|string',
        ]);

        Pengajuan::create([
            'kode_pengajuan' => 'PG-' . date('YmdHis'),
            'barang_id' => $request->barang_id,
            'user_id' => Auth::id(),
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jumlah' => $request->jumlah,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['barang', 'user'])
            ->findOrFail($id);

        return view('pengajuan.show', compact('pengajuan'));
    }

    public function edit($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status != 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan yang sudah diproses tidak dapat diedit.'
            ]);
        }

        $barangs = Barang::orderBy('nama_barang')->get();

        return view(
            'pengajuan.edit',
            compact('pengajuan', 'barangs')
        );
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status != 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan sudah diproses.'
            ]);
        }

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_pengajuan' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'alasan' => 'required|string',
        ]);

        $pengajuan->update([
            'barang_id' => $request->barang_id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jumlah' => $request->jumlah,
            'alasan' => $request->alasan,
        ]);

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status != 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan yang sudah diproses tidak dapat dihapus.'
            ]);
        }

        $pengajuan->delete();

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function approve($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status != 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan sudah diproses.'
            ]);
        }

        $barang = Barang::findOrFail($pengajuan->barang_id);

        if ($pengajuan->jumlah > $barang->stok) {
            return back()->withErrors([
                'jumlah' => 'Stok barang tidak mencukupi.'
            ]);
        }

        BarangKeluar::create([
            'kode_transaksi' => 'BK-' . date('YmdHis'),
            'barang_id' => $pengajuan->barang_id,
            'tanggal_keluar' => now()->format('Y-m-d'),
            'jumlah' => $pengajuan->jumlah,
            'tujuan' => 'Pengajuan ' . $pengajuan->kode_pengajuan,
            'keterangan' => $pengajuan->alasan,
        ]);

        $barang->decrement('stok', $pengajuan->jumlah);

        $pengajuan->update([
            'status' => 'disetujui',
            'keterangan' => 'Pengajuan disetujui.',
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status != 'pending') {
            return back()->withErrors([
                'status' => 'Pengajuan sudah diproses.'
            ]);
        }

        $pengajuan->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }

    public function cetakPdf($id)
    {
        $pengajuan = Pengajuan::with(['user', 'barang.category'])->findOrFail($id);

        if (!Auth::user()->isAdmin() && $pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($pengajuan->status !== 'disetujui') {
            abort(403, 'Hanya pengajuan yang disetujui yang dapat dicetak.');
        }

        $pdf = Pdf::loadView('pengajuan.cetak', compact('pengajuan'));
        return $pdf->download('Pengajuan_'.$pengajuan->kode_pengajuan.'.pdf');
    }

    public function cetakExcel($id)
    {
        $pengajuan = Pengajuan::with(['user', 'barang.category'])->findOrFail($id);

        if (!Auth::user()->isAdmin() && $pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($pengajuan->status !== 'disetujui') {
            abort(403, 'Hanya pengajuan yang disetujui yang dapat dicetak.');
        }

        $html = view('pengajuan.cetak', compact('pengajuan'))->render();
        $filename = 'Pengajuan_'.$pengajuan->kode_pengajuan.'.xls';
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}