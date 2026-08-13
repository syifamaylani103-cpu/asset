<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Data Barang</h2>

    <a href="{{ route('barangs.create') }}"
       class="btn btn-primary mb-3">
        + Tambah Barang
    </a>

    <a href="{{ route('categories.index') }}"
       class="btn btn-secondary mb-3">
        Data Kategori
    </a>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <table class="table table-bordered table-striped">

        <thead>

        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        </thead>

        <tbody>

        @forelse($barangs as $barang)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $barang->kode_barang }}
                </td>

                <td>
                    {{ $barang->nama_barang }}
                </td>

                <td>
                    {{ $barang->category->nama_category }}
                </td>

                <td>
                    {{ $barang->stok }}
                </td>

                <td>
                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                </td>

                <td>
                    {{ $barang->deskripsi ?? '-' }}
                </td>

                <td>

                    <a href="{{ route('barangs.edit', $barang->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('barangs.destroy', $barang->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus barang ini?')">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8"
                    class="text-center">

                    Belum ada data barang.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</body>
</html>