<!DOCTYPE html>
<html>
<head>
    <title>Jenis Barang</title>
</head>
<body>

<h1>Data Jenis Barang</h1>

<a href="{{ route('jenis_barang.create') }}">
    + Tambah Jenis Barang
</a>

<br><br>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">

    <tr>
        <th>No</th>
        <th>Nama Jenis</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    @forelse($jenisBarang as $data)

    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $data->nama_jenis }}</td>
        <td>{{ $data->keterangan }}</td>

        <td>

            <a href="{{ route('jenis_barang.show', $data->id) }}">
                Detail
            </a>

            |

            <a href="{{ route('jenis_barang.edit', $data->id) }}">
                Edit
            </a>

            |

            <form
                action="{{ route('jenis_barang.destroy', $data->id) }}"
                method="POST"
                style="display:inline;">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Yakin ingin menghapus data ini?')">

                    Hapus

                </button>

            </form>

        </td>
    </tr>

    @empty

    <tr>
        <td colspan="4">
            Belum ada data jenis barang.
        </td>
    </tr>

    @endforelse

</table>

<br>

<a href="{{ route('stock_barang.index') }}">
    Lihat Stock Barang
</a>

</body>
</html>