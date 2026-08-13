<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Tambah Kategori</h2>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form action="{{ route('categories.store') }}" method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Nama Kategori
            </label>

            <input type="text"
                   name="nama_category"
                   class="form-control"
                   value="{{ old('nama_category') }}"
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

        <a href="{{ route('categories.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>