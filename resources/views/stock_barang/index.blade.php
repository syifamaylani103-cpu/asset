@extends('layouts.app')

@section('title', 'Stok Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Data Stok Barang</h1>
            <p class="page-subtitle mb-0">Pantau ketersediaan persediaan barang di gudang secara akurat.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">
                <i class="fas fa-layer-group"></i> Jenis Barang
            </a>
            <a href="{{ route('stock_barang.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Stok
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
                <i class="fas fa-warehouse me-2 text-primary"></i> Daftar Stok Gudang
            </div>
            <span class="badge badge-soft-primary">Total: {{ count($stock) }} Item Stok</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th width="12%">Jumlah</th>
                            <th width="10%">Satuan</th>
                            <th width="15%">Harga</th>
                            <th>Keterangan</th>
                            <th class="pe-4 text-end" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stock as $data)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-layer-group me-1 text-muted"></i> {{ $data->jenisBarang->nama_jenis ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $data->nama_barang }}</div>
                                </td>
                                <td>
                                    @if($data->jumlah <= 5)
                                        <span class="badge badge-soft-danger fs-6">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $data->jumlah }}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-success fs-6">
                                            {{ $data->jumlah }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-soft-secondary">{{ $data->satuan }}</span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    Rp {{ number_format($data->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $data->keterangan ?? '-' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('stock_barang.edit', $data->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Stok">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('stock_barang.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Stok">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data stok barang terdaftar.</p>
                                    <a href="{{ route('stock_barang.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Tambah Stok Pertama
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