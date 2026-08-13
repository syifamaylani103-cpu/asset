<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika user bukan admin, kembalikan ke halaman katalog
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('katalog.index');
        }

        // 1. Hitung Statistik Singkat (Stat Cards)
        $totalBarang = Barang::count();
        $totalBarangMasuk = BarangMasuk::sum('jumlah');
        $totalBarangKeluar = BarangKeluar::sum('jumlah');
        $pendingPengajuan = Pengajuan::where('status', 'pending')->count();

        // 2. Data Grafik 6 Bulan Terakhir
        $chartData = $this->getChartData();

        // 3. Aktivitas Terakhir (Pengajuan terbaru)
        $recentPengajuan = Pengajuan::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'pendingPengajuan',
            'chartData',
            'recentPengajuan'
        ));
    }

    private function getChartData()
    {
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->startOfMonth()->subMonths($i);
        });

        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];

        foreach ($months as $month) {
            $labels[] = $month->translatedFormat('M Y');
            
            $startOfMonth = $month->copy()->startOfMonth()->format('Y-m-d');
            $endOfMonth = $month->copy()->endOfMonth()->format('Y-m-d');

            $masuk = BarangMasuk::whereBetween('tanggal_masuk', [$startOfMonth, $endOfMonth])->sum('jumlah');
            $keluar = BarangKeluar::whereBetween('tanggal_keluar', [$startOfMonth, $endOfMonth])->sum('jumlah');

            $dataMasuk[] = (int) $masuk;
            $dataKeluar[] = (int) $keluar;
        }

        return [
            'labels' => $labels,
            'masuk' => $dataMasuk,
            'keluar' => $dataKeluar,
        ];
    }
}
