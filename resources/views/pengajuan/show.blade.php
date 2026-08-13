@extends('layouts.app')

@section('title', 'Detail Pengajuan - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Detail Pengajuan Barang</h1>
            <p class="page-subtitle mb-0">Rincian status dan informasi lengkap permohonan pengajuan barang.</p>
        </div>
        <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-file-signature me-2 text-primary"></i> Detail Pengajuan {{ $pengajuan->kode_pengajuan }}</h6>
                    @if($pengajuan->status == 'pending')
                        <span class="badge badge-soft-warning fs-6">
                            <i class="fas fa-clock me-1"></i> Pending
                        </span>
                    @elseif($pengajuan->status == 'disetujui')
                        <span class="badge badge-soft-success fs-6">
                            <i class="fas fa-check-circle me-1"></i> Disetujui
                        </span>
                    @else
                        <span class="badge badge-soft-danger fs-6">
                            <i class="fas fa-times-circle me-1"></i> Ditolak
                        </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 align-middle">
                        <tbody>
                            <tr>
                                <th class="bg-light text-muted ps-4" width="35%">Kode Pengajuan</th>
                                <td class="fw-bold text-primary font-monospace ps-3">{{ $pengajuan->kode_pengajuan }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Pemohon</th>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar text-white" style="width: 28px; height: 28px; font-size: 0.75rem; background: #6366f1;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $pengajuan->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Barang yang Diminta</th>
                                <td class="fw-bold text-dark ps-3">{{ $pengajuan->barang->nama_barang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Tanggal Pengajuan</th>
                                <td class="ps-3">
                                    <i class="far fa-calendar-alt text-muted me-2"></i>
                                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d-m-Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Jumlah Permintaan</th>
                                <td class="ps-3">
                                    <span class="badge bg-light text-dark border font-monospace fs-6">
                                        {{ $pengajuan->jumlah }} Unit
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Alasan Pengajuan</th>
                                <td class="ps-3 text-dark">{{ $pengajuan->alasan }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Keterangan / Alasan Penolakan</th>
                                <td class="ps-3 text-muted">{{ $pengajuan->keterangan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    @if($pengajuan->status == 'pending')
                        <div class="d-flex gap-2">
                            <form action="{{ route('pengajuan.approve', $pengajuan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui pengajuan ini?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check me-1"></i> Setujui Pengajuan
                                </button>
                            </form>
                            <a href="{{ route('pengajuan.edit', $pengajuan->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    @else
                        <div></div>
                    @endif
                    <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection