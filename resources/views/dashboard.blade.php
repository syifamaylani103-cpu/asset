@extends('layouts.app')

@section('title', 'Dashboard - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="page-header mb-4">
        <h1 class="page-title">Dashboard Overview</h1>
        <p class="page-subtitle mb-0">Selamat datang kembali, {{ Auth::user()->name }}! Berikut ringkasan aktivitas sistem hari ini.</p>
    </div>

    <!-- Stat Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-boxes"></i>
                </div>
                <div>
                    <div class="stat-label">Total Barang</div>
                    <div class="stat-value">{{ number_format($totalBarang) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-arrow-down-to-bracket"></i>
                </div>
                <div>
                    <div class="stat-label">Total Barang Masuk</div>
                    <div class="stat-value">{{ number_format($totalBarangMasuk) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-arrow-up-from-bracket"></i>
                </div>
                <div>
                    <div class="stat-label">Total Barang Keluar</div>
                    <div class="stat-value">{{ number_format($totalBarangKeluar) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <div class="stat-label">Pengajuan Tertunda</div>
                    <div class="stat-value">{{ number_format($pendingPengajuan) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Chart Section -->
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-chart-line text-primary me-2"></i> Grafik Sirkulasi 6 Bulan Terakhir</h6>
                </div>
                <div class="card-body">
                    <div style="height: 350px; width: 100%;">
                        <canvas id="sirkulasiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-clock text-primary me-2"></i> Pengajuan Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($recentPengajuan as $item)
                            <div class="list-group-item p-3 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark fs-6">{{ $item->kode_pengajuan }}</span>
                                    @if($item->status == 'pending')
                                        <span class="badge badge-soft-warning"><i class="fas fa-clock me-1"></i>Pending</span>
                                    @elseif($item->status == 'disetujui')
                                        <span class="badge badge-soft-success"><i class="fas fa-check me-1"></i>Approve</span>
                                    @else
                                        <span class="badge badge-soft-danger"><i class="fas fa-times me-1"></i>Reject</span>
                                    @endif
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="fas fa-user text-primary opacity-75 me-1"></i> {{ $item->user->name ?? 'Unknown' }}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="text-dark small"><i class="fas fa-box me-1"></i> {{ $item->barang->nama_barang ?? '-' }}</span>
                                    <span class="badge bg-light text-dark border">Qty: {{ $item->jumlah }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-file-invoice text-muted fa-2x mb-3"></i>
                                <p class="text-muted mb-0 small">Belum ada pengajuan terbaru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if(count($recentPengajuan) > 0)
                <div class="card-footer text-center bg-transparent border-top">
                    <a href="{{ route('pengajuan.index') }}" class="text-primary fw-semibold small text-decoration-none">
                        Lihat Semua Pengajuan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('sirkulasiChart').getContext('2d');
        
        // Data passed from controller
        const chartData = @json($chartData);
        
        // Chart configuration
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: chartData.masuk,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    },
                    {
                        label: 'Barang Keluar',
                        data: chartData.keluar,
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: '#ef4444',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 13
                        },
                        bodyFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif"
                            },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
