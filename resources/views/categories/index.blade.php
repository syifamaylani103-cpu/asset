<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Data Kategori</h2>

    <a href="{{ route('categories.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Kategori
    </a>

    <a href="{{ route('barangs.index') }}"
       class="btn btn-secondary mb-3">
        Data Barang
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">

        <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        </thead>

        <tbody>

        @forelse($categories as $category)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ $category->nama_category }}
                </td>

                <td>
                    {{ $category->deskripsi ?? '-' }}
                </td>

                <td>

                    <a href="{{ route('categories.edit', $category->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('categories.destroy', $category->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                            Hapus
                        </button>

                    </form>

                </td>
            </tr>

        @empty

            <tr>
                <td colspan="4" class="text-center">
                    Belum ada data kategori.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</body>
</html>