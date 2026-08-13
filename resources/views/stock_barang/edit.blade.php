<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock</title>
</head>
<body>

<h1>Edit Stock Barang</h1>

@if($errors->any())
    <div>
        <strong>Terjadi kesalahan:</strong>

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form
    action="{{ route('stock_barang.update', $stock->id) }}"
    method="POST">

    @csrf
    @method('PUT')

    <label>Jenis Barang</label>
    <br>

    <select name="jenis_barang_id">

        @foreach($jenisBarang as $jenis)
            <option
                value="{{ $jenis->id }}"
                {{ $stock->jenis_barang_id == $jenis->id ? 'selected' : '' }}>
                {{ $jenis->nama_jenis }}
            </option>
        @endforeach

    </select>

    <br><br>

    <label>Nama Barang</label>
    <br>

    <input
        type="text"
        name="nama_barang"
        value="{{ old('nama_barang', $stock->nama_barang) }}">

    <br><br>

    <label>Jumlah</label>
    <br>

    <input
        type="number"
        name="jumlah"
        value="{{ old('jumlah', $stock->jumlah) }}">

    <br><br>

    <label>Satuan</label>
    <br>

    <input
        type="text"
        name="satuan"
        value="{{ old('satuan', $stock->satuan) }}">

    <br><br>

    <label>Harga</label>
    <br>

    <input
        type="number"
        name="harga"
        value="{{ old('harga', $stock->harga) }}">

    <br><br>

    <label>Keterangan</label>
    <br>

    <textarea
        name="keterangan"
        rows="4"
        cols="40">{{ old('keterangan', $stock->keterangan) }}</textarea>

    <br><br>

    <button type="submit">
        Update
    </button>

    <a href="{{ route('stock_barang.index') }}">
        Batal
    </a>

</form>

</body>
</html>