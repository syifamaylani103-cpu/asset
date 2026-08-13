@extends('layouts.app')

@section('title', 'Jenis Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Data Jenis Barang</h1>
            <p class="page-subtitle mb-0">Kelola klasifikasi dan jenis aset yang tersedia di gudang.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('stock_barang.index') }}" class="btn btn-secondary">
                <i class="fas fa-warehouse"></i> Stok Barang
            </a>
            <a href="{{ route('jenis_barang.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jenis Barang
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
                <i class="fas fa-layer-group me-2 text-primary"></i> Daftar Jenis Barang
            </div>
            <span class="badge badge-soft-primary">Total: {{ count($jenisBarang) }} Jenis</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" width="8%">No</th>
                            <th width="30%">Nama Jenis</th>
                            <th>Keterangan</th>
                            <th class="pe-4 text-end" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenisBarang as $data)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="badge bg-light text-primary border p-2">
                                            <i class="fas fa-shapes"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $data->nama_jenis }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $data->keterangan ?? '-' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('jenis_barang.edit', $data->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Jenis">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('jenis_barang.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Jenis">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data jenis barang terdaftar.</p>
                                    <a href="{{ route('jenis_barang.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Tambah Jenis Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection