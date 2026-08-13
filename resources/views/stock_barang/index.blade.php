<!DOCTYPE html>
<html>
<head>
    <title>Stock Barang</title>
</head>
<body>

<h1>Data Stock Barang</h1>

<a href="{{ route('stock_barang.create') }}">
    + Tambah Stock
</a>

<br><br>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Jenis Barang</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    @forelse($stock as $data)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $data->jenisBarang->nama_jenis }}</td>
        <td>{{ $data->nama_barang }}</td>
        <td>{{ $data->jumlah }}</td>
        <td>{{ $data->satuan }}</td>
        <td>Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
        <td>{{ $data->keterangan ?? '-' }}</td>

        <td>
            <a href="{{ route('stock_barang.show', $data->id) }}">
                Detail
            </a>

            |

            <a href="{{ route('stock_barang.edit', $data->id) }}">
                Edit
            </a>

            |

            <form
                action="{{ route('stock_barang.destroy', $data->id) }}"
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
        <td colspan="8">
            Belum ada data stock.
        </td>
    </tr>
    @endforelse

</table>

<br>

<a href="{{ route('jenis_barang.index') }}">
    Kelola Jenis Barang
</a>

</body>
</html>