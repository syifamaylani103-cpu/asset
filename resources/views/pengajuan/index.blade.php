@extends('layouts.app')

@section('title', 'Pengajuan Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Pengajuan Barang</h1>
            <p class="page-subtitle mb-0">Kelola dan verifikasi permohonan pengajuan barang dari pengguna.</p>
        </div>
        <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Pengajuan Baru
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
                <i class="fas fa-file-signature me-2 text-primary"></i> Daftar Pengajuan Permohonan
            </div>
            <span class="badge badge-soft-primary">Total: {{ count($pengajuans) }} Pengajuan</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="12%">Kode</th>
                            <th>Pemohon</th>
                            <th>Barang</th>
                            <th width="8%">Jumlah</th>
                            <th width="12%">Tanggal</th>
                            <th width="12%">Status</th>
                            <th class="pe-4 text-end" width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuans as $item)
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">
                                    {{ $loop->iteration + ($pengajuans->currentPage() - 1) * $pengajuans->perPage() }}
                                </td>
                                <td>
                                    <span class="badge badge-soft-primary font-monospace fs-6">
                                        {{ $item->kode_pengajuan }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar text-white" style="width: 28px; height: 28px; font-size: 0.75rem; background: #6366f1;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $item->user->name ?? 'Pengguna' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->barang->nama_barang ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fs-6">
                                        {{ $item->jumlah }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status == 'pending')
                                        <span class="badge badge-soft-warning">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    @elseif($item->status == 'disetujui')
                                        <span class="badge badge-soft-success">
                                            <i class="fas fa-check-circle me-1"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger">
                                            <i class="fas fa-times-circle me-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($item->status == 'pending')
                                            <a href="{{ route('pengajuan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if(Auth::check() && Auth::user()->isAdmin())
                                            <!-- Form Approve -->
                                            <form action="{{ route('pengajuan.approve', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui pengajuan ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui Pengajuan">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <!-- Reject Modal Trigger -->
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}" title="Tolak Pengajuan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @endif

                                            <!-- Modal Reject -->
                                            <div class="modal fade text-start" id="rejectModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <form action="{{ route('pengajuan.reject', $item->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title fw-bold">
                                                                    <i class="fas fa-ban me-2"></i> Tolak Pengajuan {{ $item->kode_pengajuan }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                <label class="form-label fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                <textarea name="keterangan" class="form-control" rows="4" placeholder="Tuliskan alasan penolakan permohonan ini..." required></textarea>
                                                            </div>
                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengajuan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-file-signature fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada pengajuan barang terdaftar.</p>
                                    <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Buat Pengajuan Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pengajuans->hasPages())
                <div class="card-footer">
                    {{ $pengajuans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection