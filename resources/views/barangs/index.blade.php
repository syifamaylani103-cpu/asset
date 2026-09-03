@extends('layouts.app')

@section('title', 'Data Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Title & Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Data Barang</h1>
            <p class="page-subtitle mb-0">Kelola daftar master aset, kategori, persediaan stok, dan harga.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-tags"></i> Data Kategori
            </a>
            <a href="{{ route('barangs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold text-dark">
                <i class="fas fa-boxes-stacked me-2 text-primary"></i> Daftar Master Barang
            </div>
            <span class="badge badge-soft-primary">Total: {{ $barangs->total() }} Barang</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="12%">Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th width="10%">Stok</th>
                            <th width="15%">Harga</th>
                            <th>Deskripsi</th>
                            <th class="pe-4 text-end" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                                <td>
                                    <span class="badge badge-soft-primary font-monospace">
                                        {{ $barang->kode_barang }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $barang->nama_barang }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-tag text-muted me-1"></i> {{ $barang->category->nama_category ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($barang->stok <= 5)
                                        <span class="badge badge-soft-danger">
                                            <i class="fas fa-triangle-exclamation me-1"></i> {{ $barang->stok }} (Kritis)
                                        </span>
                                    @else
                                        <span class="badge badge-soft-success">
                                            <i class="fas fa-check me-1"></i> {{ $barang->stok }}
                                        </span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-dark">
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ Str::limit($barang->deskripsi ?? '-', 40) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1 flex-wrap justify-content-end">
                                        <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Barang">
                                            <i class="fas fa-edit me-1"></i>
                                        </a>

                                        <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Barang">
                                                <i class="fas fa-trash me-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data barang terdaftar.</p>
                                    <a href="{{ route('barangs.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Tambah Barang Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($barangs->hasPages())
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 bg-white py-3">
                    <div class="text-muted small">
                        Menampilkan <strong>{{ $barangs->firstItem() }}</strong> sampai <strong>{{ $barangs->lastItem() }}</strong> dari total <strong>{{ $barangs->total() }}</strong> barang
                    </div>
                    <div>
                        {{ $barangs->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection