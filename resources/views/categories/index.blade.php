@extends('layouts.app')

@section('title', 'Kategori Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Data Kategori Barang</h1>
            <p class="page-subtitle mb-0">Kelola pengelompokan dan kategori untuk pengorganisasian aset.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('barangs.index') }}" class="btn btn-secondary">
                <i class="fas fa-boxes-stacked"></i> Data Barang
            </a>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold text-dark">
                <i class="fas fa-tags me-2 text-primary"></i> Daftar Kategori
            </div>
            <span class="badge badge-soft-primary">Total: {{ $categories->total() }} Kategori</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" width="8%">No</th>
                            <th width="30%">Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="pe-4 text-end" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="badge bg-light text-primary border p-2">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $category->nama_category }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $category->deskripsi ?? '-' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Kategori">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data kategori terdaftar.</p>
                                    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Tambah Kategori Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 bg-white py-3">
                    <div class="text-muted small">
                        Menampilkan <strong>{{ $categories->firstItem() }}</strong> sampai <strong>{{ $categories->lastItem() }}</strong> dari total <strong>{{ $categories->total() }}</strong> kategori
                    </div>
                    <div>
                        {{ $categories->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection