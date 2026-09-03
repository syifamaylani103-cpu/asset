@extends('layouts.app')

@section('title', 'Stok Barang - Asset Management System')

@push('styles')
<style>
    .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.4rem 0.75rem;
    }
    .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(79, 70, 229, 0.3);
    }
    .page-item.disabled .page-link {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
    }
    .dropdown-menu {
        border-radius: 12px;
        min-width: 210px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- Header Title & Clean Actions Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-header gap-3">
        <div>
            <h1 class="page-title">Data Stok Barang</h1>
            <p class="page-subtitle mb-0">Pantau ketersediaan persediaan barang di gudang secara akurat.</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('jenis_barang.index') }}" class="btn btn-secondary">
                <i class="fas fa-layer-group me-1"></i> Jenis Barang
            </a>

            <!-- Dropdown Aksi CSV (Rapi & Terpadu) -->
            <div class="dropdown">
                <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownCsv" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-excel me-1"></i> Aksi CSV
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownCsv">
                    <li>
                        <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                            <i class="fas fa-file-upload text-success me-2"></i> Update via CSV
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('stock_barang.export_template') }}">
                            <i class="fas fa-file-download text-primary me-2"></i> Unduh Data Stok (CSV)
                        </a>
                    </li>
                </ul>
            </div>

            @if($stock->count() > 0)
                <button type="button" id="toggleQuickEditBtn" class="btn btn-outline-primary" onclick="toggleQuickEdit()">
                    <i class="fas fa-edit me-1"></i> Edit Cepat
                </button>
            @endif

            <a href="{{ route('stock_barang.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Stok
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <strong>Ada kesalahan data:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Banner Bar untuk Mode Edit Cepat -->
    <div id="quickEditBar" class="alert alert-primary d-none shadow-sm mb-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-lg me-2 text-primary"></i>
                <div>
                    <strong>Mode Edit Cepat Aktif:</strong>
                    Anda dapat langsung mengubah angka pada kolom
                    <strong>Jumlah</strong> dan <strong>Harga</strong>
                    untuk baris di halaman ini.
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-secondary" onclick="toggleQuickEdit()">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" form="bulkUpdateForm" class="btn btn-sm btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Semua Perubahan
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <!-- Card Header dengan Selector Jumlah Baris per Halaman -->
        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <div class="fw-bold text-dark fs-6 d-flex align-items-center">
                <i class="fas fa-warehouse me-2 text-primary"></i> Daftar Stok Gudang
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPageSelect" class="text-muted small fw-semibold text-nowrap mb-0">Tampilkan:</label>
                    <select id="perPageSelect" class="form-select form-select-sm py-1" style="width: auto;" onchange="changePerPage(this.value)">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / halaman</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 / halaman</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 / halaman</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / halaman</option>
                    </select>
                </div>
                <span class="badge badge-soft-primary px-3 py-2">Total: {{ $stock->total() }} Item Stok</span>
            </div>
        </div>

        <div class="card-body p-0">
            <form action="{{ route('stock_barang.bulk_update') }}" method="POST" id="bulkUpdateForm">
                @csrf
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4" width="5%">No</th>
                                <th>Jenis Barang</th>
                                <th>Nama Barang</th>
                                <th width="14%">Jumlah</th>
                                <th width="10%">Satuan</th>
                                <th width="18%">Harga</th>
                                <th>Keterangan</th>
                                <th class="pe-4 text-end" width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock as $data)
                                <tr>
                                    <td class="ps-4 fw-semibold text-muted">{{ $stock->firstItem() ? ($stock->firstItem() + $loop->index) : $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-layer-group me-1 text-muted"></i> {{ $data->jenisBarang->nama_jenis ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $data->nama_barang }}</div>
                                    </td>
                                    <td>
                                        <!-- Mode Tampilan Normal -->
                                        <div class="view-mode">
                                            @if($data->jumlah <= 5)
                                                <span class="badge badge-soft-danger fs-6">
                                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $data->jumlah }}
                                                </span>
                                            @else
                                                <span class="badge badge-soft-success fs-6">
                                                    {{ $data->jumlah }}
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Mode Edit Cepat -->
                                        <div class="edit-mode d-none">
                                            <input type="hidden" name="stocks[{{ $loop->index }}][id]" value="{{ $data->id }}">
                                            <input type="number" min="0" name="stocks[{{ $loop->index }}][jumlah]" value="{{ $data->jumlah }}" class="form-control form-control-sm text-center fw-bold text-primary" style="max-width: 110px;">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-secondary">{{ $data->satuan }}</span>
                                    </td>
                                    <td>
                                        <!-- Mode Tampilan Normal -->
                                        <div class="view-mode fw-semibold text-dark">
                                            Rp {{ number_format($data->harga, 0, ',', '.') }}
                                        </div>
                                        <!-- Mode Edit Cepat -->
                                        <div class="edit-mode d-none">
                                            <div class="input-group input-group-sm" style="max-width: 160px;">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" min="0" step="any" name="stocks[{{ $loop->index }}][harga]" value="{{ (int)$data->harga }}" class="form-control">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">
                                            {{ $data->keterangan ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('stock_barang.edit', $data->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Stok">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Stok" onclick="if(confirm('Yakin ingin menghapus data ini?')) { document.getElementById('delete-form-{{ $data->id }}').submit(); }">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">Belum ada data stok barang terdaftar.</p>
                                        <a href="{{ route('stock_barang.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-plus"></i> Tambah Stok Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stock->count() > 0)
                    <div id="quickEditFooter" class="card-footer d-none justify-content-end gap-2 bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleQuickEdit()">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i> Simpan Semua Perubahan
                        </button>
                    </div>
                @endif
            </form>

            <!-- Form hapus terpisah agar tidak nested di dalam bulkUpdateForm -->
            @foreach($stock as $data)
                <form id="delete-form-{{ $data->id }}" action="{{ route('stock_barang.destroy', $data->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>

        <!-- Paginasi & Informasi Data -->
        @if($stock->total() > 0)
            <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 bg-white py-3">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $stock->firstItem() ?? 0 }}</strong> - <strong>{{ $stock->lastItem() ?? 0 }}</strong> dari total <strong>{{ $stock->total() }}</strong> data stok
                </div>
                <div>
                    {{ $stock->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Import CSV -->
<div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fs-6 fw-bold" id="importCsvModalLabel">
                    <i class="fas fa-file-excel me-2"></i> Update Stok Massal via CSV / Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stock_barang.import_csv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <div class="modal-body p-4">
                    <div class="alert alert-info py-2 px-3 mb-3 small">
                        <div class="fw-bold mb-1"><i class="fas fa-lightbulb me-1"></i> Cara Mudah Update 50+ Barang:</div>
                        <ol class="ps-3 mb-1">
                            <li>Klik tombol <strong>"Unduh Data Stok Saat Ini (CSV)"</strong> di bawah.</li>
                            <li>Buka file tersebut di Microsoft Excel atau Google Sheets.</li>
                            <li>Ubah angka pada kolom <strong>jumlah</strong> atau <strong>harga</strong> sesuai stok terbaru.</li>
                            <li>Simpan file (tetap sebagai <code>.csv</code>), lalu upload di bawah ini.</li>
                        </ol>
                    </div>

                    <div class="mb-3 text-center">
                        <a href="{{ route('stock_barang.export_template') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file-download me-1"></i> Unduh Data Stok Saat Ini (CSV)
                        </a>
                    </div>

                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Pilih File CSV <span class="text-danger">*</span></label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv, .txt" required>
                        <div class="form-text small">Mendukung format file <code>.csv</code> (pemisah koma <code>,</code> atau titik-koma <code>;</code> otomatis terdeteksi).</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-cloud-upload-alt me-1"></i> Upload & Perbarui Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let isQuickEdit = false;

    function toggleQuickEdit() {
        isQuickEdit = !isQuickEdit;
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');
        const quickEditBar = document.getElementById('quickEditBar');
        const quickEditFooter = document.getElementById('quickEditFooter');
        const toggleBtn = document.getElementById('toggleQuickEditBtn');

        if (isQuickEdit) {
            viewElements.forEach(el => el.classList.add('d-none'));
            editElements.forEach(el => el.classList.remove('d-none'));
            if (quickEditBar) quickEditBar.classList.remove('d-none');
            if (quickEditFooter) {
                quickEditFooter.classList.remove('d-none');
                quickEditFooter.classList.add('d-flex');
            }
            if (toggleBtn) {
                toggleBtn.classList.remove('btn-outline-primary');
                toggleBtn.classList.add('btn-primary');
                toggleBtn.innerHTML = '<i class="fas fa-times me-1"></i> Keluar Mode Edit';
            }
        } else {
            viewElements.forEach(el => el.classList.remove('d-none'));
            editElements.forEach(el => el.classList.add('d-none'));
            if (quickEditBar) quickEditBar.classList.add('d-none');
            if (quickEditFooter) {
                quickEditFooter.classList.add('d-none');
                quickEditFooter.classList.remove('d-flex');
            }
            if (toggleBtn) {
                toggleBtn.classList.add('btn-outline-primary');
                toggleBtn.classList.remove('btn-primary');
                toggleBtn.innerHTML = '<i class="fas fa-edit me-1"></i> Edit Cepat';
            }
        }
    }

    function changePerPage(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', val);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
</script>
@endpush