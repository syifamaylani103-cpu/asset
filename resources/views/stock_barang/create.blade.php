@extends('layouts.app')

@section('title', 'Tambah Stok Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Tambah Stok Barang</h1>
            <p class="page-subtitle mb-0">Input persediaan stok barang baru ke dalam gudang.</p>
        </div>
        <a href="{{ route('stock_barang.index') }}" class="btn btn-secondary">
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
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-warehouse me-2 text-primary"></i> Form Stok Barang</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('stock_barang.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-layer-group text-muted"></i></span>
                                    <select name="jenis_barang_id" class="form-select" required>
                                        <option value="">-- Pilih Jenis Barang --</option>
                                        @foreach($jenisBarang as $jenis)
                                            <option value="{{ $jenis->id }}" {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-box text-muted"></i></span>
                                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" placeholder="Masukkan nama barang" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-cubes text-muted"></i></span>
                                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}" placeholder="0" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Satuan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-ruler-vertical text-muted"></i></span>
                                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="Contoh: pcs, unit, box" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                    <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" placeholder="0" min="0" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="4" placeholder="Keterangan tambahan stok barang">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('stock_barang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Stok Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection