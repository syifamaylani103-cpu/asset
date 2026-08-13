<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Tambah Barang</h2>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('barangs.store') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Kode Barang
            </label>

            <input type="text"
                   name="kode_barang"
                   class="form-control"
                   value="{{ old('kode_barang') }}"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Nama Barang
            </label>

            <input type="text"
                   name="nama_barang"
                   class="form-control"
                   value="{{ old('nama_barang') }}"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Kategori
            </label>

            <select name="category_id"
                    class="form-select"
                    required>

                <option value="">
                    -- Pilih Kategori --
                </option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>

                        {{ $category->nama_category }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Stok
            </label>

            <input type="number"
                   name="stok"
                   class="form-control"
                   value="{{ old('stok', 0) }}"
                   min="0"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Harga
            </label>

            <input type="number"
                   name="harga"
                   class="form-control"
                   value="{{ old('harga', 0) }}"
                   min="0"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Deskripsi
            </label>

            <textarea name="deskripsi"
                      class="form-control"
                      rows="4">{{ old('deskripsi') }}</textarea>

        </div>

        <button class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('barangs.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>