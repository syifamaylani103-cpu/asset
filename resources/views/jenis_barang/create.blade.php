@extends('layouts.app')

@section('title', 'Tambah Jenis Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Tambah Jenis Barang</h1>
            <p class="page-subtitle mb-0">Tambahkan jenis barang baru untuk pengelompokan stok.</p>
        </div>
        <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">
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
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-layer-group me-2 text-primary"></i> Form Jenis Barang</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis_barang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Jenis Barang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-shapes text-muted"></i></span>
                                <input type="text" name="nama_jenis" class="form-control" value="{{ old('nama_jenis') }}" placeholder="Contoh: Barang Habis Pakai, Aset Tetap..." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="4" placeholder="Tuliskan deskripsi jenis barang ini">{{ old('keterangan') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Jenis Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection