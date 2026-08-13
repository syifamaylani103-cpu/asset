@extends('layouts.app')

@section('title', 'Edit Pengajuan - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Edit Pengajuan Barang</h1>
            <p class="page-subtitle mb-0">Perbarui rincian draf permohonan pengajuan barang.</p>
        </div>
        <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
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
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-edit me-2 text-warning"></i> Form Edit Pengajuan: {{ $pengajuan->kode_pengajuan }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-box text-muted"></i></span>
                                    <select name="barang_id" class="form-select" required>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" {{ ($pengajuan->barang_id == $barang->id) ? 'selected' : '' }}>
                                                {{ $barang->kode_barang ?? '' }} - {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $pengajuan->tanggal_pengajuan) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Permintaan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-layer-group text-muted"></i></span>
                                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah', $pengajuan->jumlah) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Alasan & Keperluan Pengajuan <span class="text-danger">*</span></label>
                                <textarea name="alasan" rows="5" class="form-control" required>{{ old('alasan', $pengajuan->alasan) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-1"></i> Update Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection