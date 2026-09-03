@extends('layouts.app')

@section('title', 'Hasil Pencarian - Asset Management System')

@section('content')
<div class="container-fluid p-0">
    <div class="page-header mb-4">
        <h1 class="page-title">Hasil Pencarian</h1>
        <p class="page-subtitle mb-0">Menampilkan hasil pencarian untuk: <strong class="text-primary">"{{ $q }}"</strong></p>
    </div>

    @if(Auth::user()->isAdmin() || count($barangs) > 0)
    <div class="card mb-4">
        <div class="card-header fw-bold text-dark">
            <i class="fas fa-boxes-stacked me-2 text-primary"></i> Data Barang ({{ count($barangs) }})
        </div>
        <div class="card-body p-0">
            @if(count($barangs) > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="15%">Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th width="15%">Stok</th>
                            @if(Auth::user()->isAdmin())
                            <th class="pe-4 text-end" width="10%">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $barang)
                        <tr>
                            <td class="ps-4"><span class="badge badge-soft-primary font-monospace">{{ $barang->kode_barang }}</span></td>
                            <td class="fw-bold text-dark">{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->category->nama_category ?? '-' }}</td>
                            <td>
                                @if($barang->stok <= 5)
                                    <span class="badge badge-soft-danger">{{ $barang->stok }} (Kritis)</span>
                                @else
                                    <span class="badge badge-soft-success">{{ $barang->stok }}</span>
                                @endif
                            </td>
                            @if(Auth::user()->isAdmin())
                            <td class="pe-4 text-end">
                                <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-4 text-center text-muted">
                <i class="fas fa-search fa-2x mb-2 opacity-50"></i>
                <p class="mb-0">Tidak ada barang yang cocok dengan kata kunci.</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header fw-bold text-dark">
            <i class="fas fa-file-signature me-2 text-primary"></i> Data Pengajuan ({{ count($pengajuans) }})
        </div>
        <div class="card-body p-0">
            @if(count($pengajuans) > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="15%">Kode</th>
                            <th>Barang</th>
                            <th>Pemohon</th>
                            <th width="15%">Status</th>
                            <th class="pe-4 text-end" width="10%">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuans as $pengajuan)
                        <tr>
                            <td class="ps-4"><span class="badge badge-soft-primary font-monospace">{{ $pengajuan->kode_pengajuan }}</span></td>
                            <td class="fw-bold text-dark">{{ $pengajuan->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $pengajuan->user->name ?? '-' }}</td>
                            <td>
                                @if($pengajuan->status == 'pending')
                                    <span class="badge badge-soft-warning">Pending</span>
                                @elseif($pengajuan->status == 'disetujui')
                                    <span class="badge badge-soft-success">Disetujui</span>
                                @else
                                    <span class="badge badge-soft-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-4 text-center text-muted">
                <i class="fas fa-search fa-2x mb-2 opacity-50"></i>
                <p class="mb-0">Tidak ada pengajuan yang cocok dengan kata kunci.</p>
            </div>
            @endif
        </div>
    </div>

    @if(Auth::user()->isAdmin())
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold text-dark">
                    <i class="fas fa-arrow-down-to-bracket me-2 text-success"></i> Transaksi Masuk ({{ count($barangMasuks) }})
                </div>
                <div class="card-body p-0">
                    @if(count($barangMasuks) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Kode</th>
                                    <th>Barang</th>
                                    <th class="pe-4 text-end">Jml</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barangMasuks as $masuk)
                                <tr>
                                    <td class="ps-4"><span class="badge badge-soft-success font-monospace">{{ $masuk->kode_transaksi }}</span></td>
                                    <td>{{ $masuk->barang->nama_barang ?? '-' }}</td>
                                    <td class="pe-4 text-end">{{ $masuk->jumlah }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">
                        <p class="mb-0 small">Tidak ada data.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold text-dark">
                    <i class="fas fa-arrow-up-from-bracket me-2 text-danger"></i> Transaksi Keluar ({{ count($barangKeluars) }})
                </div>
                <div class="card-body p-0">
                    @if(count($barangKeluars) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Kode</th>
                                    <th>Barang</th>
                                    <th class="pe-4 text-end">Jml</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barangKeluars as $keluar)
                                <tr>
                                    <td class="ps-4"><span class="badge badge-soft-danger font-monospace">{{ $keluar->kode_transaksi }}</span></td>
                                    <td>{{ $keluar->barang->nama_barang ?? '-' }}</td>
                                    <td class="pe-4 text-end">{{ $keluar->jumlah }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">
                        <p class="mb-0 small">Tidak ada data.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
