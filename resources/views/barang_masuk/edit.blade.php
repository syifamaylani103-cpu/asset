@extends('layouts.app')

@section('title', 'Edit Barang Masuk - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Edit Barang Masuk</h1>
            <p class="page-subtitle mb-0">Perbarui catatan transaksi penerimaan barang.</p>
        </div>
        <a href="{{ route('barang_masuk.index') }}" class="btn btn-secondary">
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
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-edit me-2 text-warning"></i> Form Edit Transaksi: {{ $barangMasuk->kode_transaksi }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang_masuk.update', $barangMasuk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-box text-muted"></i></span>
                                    <select name="barang_id" class="form-select" required>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" {{ ($barangMasuk->barang_id == $barang->id) ? 'selected' : '' }}>
                                                {{ $barang->kode_barang ?? '' }} - {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $barangMasuk->tanggal_masuk) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-plus text-success"></i></span>
                                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah', $barangMasuk->jumlah) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Supplier / Vendor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-truck text-muted"></i></span>
                                    <input type="text" name="supplier" value="{{ old('supplier', $barangMasuk->supplier) }}" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Keterangan Catatan</label>
                                <textarea name="keterangan" rows="4" class="form-control">{{ old('keterangan', $barangMasuk->keterangan) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('barang_masuk.index') }}" class="btn btn-secondary">Batal</a>
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