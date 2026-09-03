<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        if (!$q) {
            return redirect()->back();
        }

        // Search Barang
        $barangs = Barang::with('category')
            ->where('nama_barang', 'like', "%{$q}%")
            ->orWhere('kode_barang', 'like', "%{$q}%")
            ->get();

        // Search Pengajuan
        $pengajuansQuery = Pengajuan::with(['user', 'barang'])
            ->where(function($query) use ($q) {
                $query->where('kode_pengajuan', 'like', "%{$q}%")
                      ->orWhereHas('barang', function($q2) use ($q) {
                          $q2->where('nama_barang', 'like', "%{$q}%");
                      });
            });

        // Restrict Pengajuan for standard users
        if (!Auth::user()->isAdmin()) {
            $pengajuansQuery->where('user_id', Auth::id());
        }
        $pengajuans = $pengajuansQuery->get();

        $barangMasuks = collect();
        $barangKeluars = collect();

        // Only admins can search through transactions
        if (Auth::user()->isAdmin()) {
            $barangMasuks = BarangMasuk::with('barang')
                ->where('kode_transaksi', 'like', "%{$q}%")
                ->orWhere('supplier', 'like', "%{$q}%")
                ->orWhereHas('barang', function($q2) use ($q) {
                    $q2->where('nama_barang', 'like', "%{$q}%");
                })->get();

            $barangKeluars = BarangKeluar::with('barang')
                ->where('kode_transaksi', 'like', "%{$q}%")
                ->orWhere('tujuan', 'like', "%{$q}%")
                ->orWhereHas('barang', function($q2) use ($q) {
                    $q2->where('nama_barang', 'like', "%{$q}%");
                })->get();
        }

        return view('search.index', compact('q', 'barangs', 'pengajuans', 'barangMasuks', 'barangKeluars'));
    }
}
