@extends('layouts.app')

@section('title', 'Edit Jenis Barang - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center page-header">
        <div>
            <h1 class="page-title">Edit Jenis Barang</h1>
            <p class="page-subtitle mb-0">Perbarui rincian jenis barang yang terdaftar.</p>
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
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-edit me-2 text-warning"></i> Form Edit Jenis: {{ $jenisBarang->nama_jenis }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis_barang.update', $jenisBarang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Jenis Barang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-shapes text-muted"></i></span>
                                <input type="text" name="nama_jenis" class="form-control" value="{{ old('nama_jenis', $jenisBarang->nama_jenis) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan', $jenisBarang->keterangan) }}</textarea>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-1"></i> Update Jenis Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection