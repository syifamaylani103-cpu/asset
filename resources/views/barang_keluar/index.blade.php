@extends('layouts.app')

@section('title', 'Barang Keluar - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Transaksi Barang Keluar</h1>
            <p class="page-subtitle mb-0">Catatan pendistribusian dan pengeluaran barang dari gudang.</p>
        </div>
        <a href="{{ route('barang_keluar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Barang Keluar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="fw-bold text-dark">
                <i class="fas fa-arrow-up-from-bracket me-2 text-danger"></i> Riwayat Barang Keluar
            </div>
            <span class="badge badge-soft-danger">Sirkulasi Keluar</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="15%">Kode Transaksi</th>
                            <th>Barang</th>
                            <th width="12%">Tanggal</th>
                            <th width="10%">Jumlah</th>
                            <th width="18%">Tujuan / Ruang</th>
                            <th class="pe-4 text-end" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangKeluars as $item)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">
                                    {{ $loop->iteration + ($barangKeluars->currentPage() - 1) * $barangKeluars->perPage() }}
                                </td>
                                <td>
                                    <span class="badge badge-soft-danger font-monospace fs-6">
                                        {{ $item->kode_transaksi }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->barang->nama_barang ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-soft-danger fs-6">
                                        -{{ $item->jumlah }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-location-dot text-muted me-1"></i> {{ $item->tujuan ?? '-' }}
                                    </span>
                                </td>
                              <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('barang_keluar.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('barang_keluar.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('barang_keluar.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data barang keluar.</p>
                                    <a href="{{ route('barang_keluar.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Tambah Transaksi Keluar
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($barangKeluars->hasPages())
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 bg-white py-3">
                    <div class="text-muted small">
                        Menampilkan <strong>{{ $barangKeluars->firstItem() }}</strong> sampai <strong>{{ $barangKeluars->lastItem() }}</strong> dari total <strong>{{ $barangKeluars->total() }}</strong> transaksi
                    </div>
                    <div>
                        {{ $barangKeluars->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection