@extends('layouts.app')

@section('title', 'Detail Barang Masuk - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Detail Barang Masuk</h1>
            <p class="page-subtitle mb-0">Rincian informasi transaksi penerimaan barang ke gudang.</p>
        </div>
        <a href="{{ route('barang_masuk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-file-invoice me-2 text-info"></i> Transaksi {{ $barangMasuk->kode_transaksi }}</h6>
                    <span class="badge badge-soft-success">Penerimaan Masuk</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 align-middle">
                        <tbody>
                            <tr>
                                <th class="bg-light text-muted ps-4" width="35%">Kode Transaksi</th>
                                <td class="fw-bold text-primary font-monospace ps-3">{{ $barangMasuk->kode_transaksi }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Nama Barang</th>
                                <td class="fw-bold text-dark ps-3">{{ $barangMasuk->barang->nama_barang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Tanggal Masuk</th>
                                <td class="ps-3">
                                    <i class="far fa-calendar-alt text-muted me-2"></i>
                                    {{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Jumlah Masuk</th>
                                <td class="ps-3">
                                    <span class="badge badge-soft-success fs-6">
                                        +{{ $barangMasuk->jumlah }} Unit
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Supplier / Vendor</th>
                                <td class="ps-3 fw-medium text-dark">{{ $barangMasuk->supplier ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-muted ps-4">Keterangan / Catatan</th>
                                <td class="ps-3 text-muted">{{ $barangMasuk->keterangan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('barang_masuk.edit', $barangMasuk->id) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Transaksi Ini
                    </a>
                    <a href="{{ route('barang_masuk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection