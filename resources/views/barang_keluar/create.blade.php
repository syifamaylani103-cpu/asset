@extends('layouts.app')

@section('title', 'Tambah Barang Keluar - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Tambah Barang Keluar</h1>
            <p class="page-subtitle mb-0">Catat pengeluaran persediaan barang dari gudang ke unit pemohon.</p>
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
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-arrow-up-from-bracket me-2 text-danger"></i> Form Transaksi Barang Keluar</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang_keluar.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-box text-muted"></i></span>
                                    <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                                {{ $barang->kode_barang ?? '' }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('barang_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="far fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', date('Y-m-d')) }}" class="form-control @error('tanggal_keluar') is-invalid @enderror" required>
                                </div>
                                @error('tanggal_keluar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Keluar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-minus text-danger"></i></span>
                                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" class="form-control @error('jumlah') is-invalid @enderror" placeholder="Masukkan jumlah barang" required>
                                </div>
                                @error('jumlah')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tujuan / Ruangan / Unit</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-location-dot text-muted"></i></span>
                                    <input type="text" name="tujuan" value="{{ old('tujuan') }}" class="form-control @error('tujuan') is-invalid @enderror" placeholder="Contoh: Ruang TU, Lab Komputer">
                                </div>
                                @error('tujuan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Keterangan Catatan</label>
                                <textarea name="keterangan" rows="4" class="form-control" placeholder="Tuliskan alasan pengeluaran barang atau nama penerima">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('barang_keluar.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-1"></i> Simpan Transaksi Keluar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection