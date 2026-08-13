@extends('layouts.app')

@section('title', 'Edit Barang Keluar - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Edit Barang Keluar</h1>
            <p class="page-subtitle mb-0">Perbarui catatan transaksi pengeluaran barang.</p>
        </div>
        <a href="{{ route('barang_keluar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <div class="fw-bold mb-1"><i class="fas fa-exclamation-triangle me-1"></i> Terdapat kesalahan input:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-edit me-2 text-warning"></i> Form Edit Transaksi: {{ $barangKeluar->kode_transaksi }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang_keluar.update', $barangKeluar->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-box text-muted"></i></span>
                                    <select name="barang_id" class="form-select" required>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" {{ ($barangKeluar->barang_id == $barang->id) ? 'selected' : '' }}>
                                                {{ $barang->kode_barang ?? '' }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', $barangKeluar->tanggal_keluar) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-minus text-danger"></i></span>
                                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah', $barangKeluar->jumlah) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tujuan / Ruangan / Unit</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-location-dot text-muted"></i></span>
                                    <input type="text" name="tujuan" value="{{ old('tujuan', $barangKeluar->tujuan) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Keterangan Catatan</label>
                                <textarea name="keterangan" rows="4" class="form-control">{{ old('keterangan', $barangKeluar->keterangan) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('barang_keluar.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-1"></i> Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection