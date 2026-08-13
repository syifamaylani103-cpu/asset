@extends('layouts.app')

@section('title', 'Edit Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Edit Data Barang</h1>
            <p class="page-subtitle mb-0">Perbarui rincian informasi dan stok aset terdaftar.</p>
        </div>
        <a href="{{ route('barangs.index') }}" class="btn btn-secondary">
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
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-edit me-2 text-warning"></i> Form Edit Barang: {{ $barang->nama_barang }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-barcode text-muted"></i></span>
                                    <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-box text-muted"></i></span>
                                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tags text-muted"></i></span>
                                    <select name="category_id" class="form-select" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('category_id', $barang->category_id) == $category->id) ? 'selected' : '' }}>
                                                {{ $category->nama_category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-cubes text-muted"></i></span>
                                    <input type="number" name="stok" class="form-control" value="{{ old('stok', $barang->stok) }}" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Harga Barang (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                    <input type="number" name="harga" class="form-control" value="{{ old('harga', $barang->harga) }}" min="0" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Deskripsi Barang</label>
                                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('barangs.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-1"></i> Update Data Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection