@extends('layouts.app')

@section('title', 'Katalog Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3 mb-4">
        <div>
            <h1 class="page-title">Katalog Barang</h1>
            <p class="page-subtitle mb-0">Lihat daftar barang yang tersedia untuk diajukan.</p>
        </div>
        <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">
            <i class="fas fa-file-signature me-2"></i> Ajukan Barang
        </a>
    </div>

    <div class="row g-4">
        @forelse($barangs as $barang)
            <div class="col-md-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; transition: transform 0.2s ease;">
                    <div class="card-body p-4 d-flex flex-column text-center position-relative">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge {{ $barang->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                Stok: {{ $barang->stok }}
                            </span>
                        </div>
                        <div class="mb-3 mt-2 d-flex justify-content-center">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 2rem;">
                                <i class="fas fa-box-open"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $barang->nama_barang }}</h5>
                        <p class="text-muted small mb-3">{{ $barang->kode_barang }}</p>
                        
                        <div class="mt-auto pt-3 border-top w-100 text-start">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Kategori:</span>
                                <span class="fw-semibold small">{{ $barang->category->nama_category ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Harga:</span>
                                <span class="fw-bold text-primary small">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada barang tersedia.</h5>
            </div>
        @endforelse
    </div>

    @if($barangs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $barangs->links() }}
        </div>
    @endif
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
