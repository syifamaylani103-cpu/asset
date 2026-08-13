<!DOCTYPE html>
<html>
<head>
    <title>Tambah Stock</title>
</head>
<body>

<h1>Tambah Stock Barang</h1>

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

<form action="{{ route('stock_barang.store') }}" method="POST">

    @csrf

    <label>Jenis Barang</label>
    <br>

    <select name="jenis_barang_id">
        <option value="">-- Pilih Jenis Barang --</option>

        @foreach($jenisBarang as $jenis)
            <option
                value="{{ $jenis->id }}"
                {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
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
        value="{{ old('nama_barang') }}">

    <br><br>

    <label>Jumlah</label>
    <br>

    <input
        type="number"
        name="jumlah"
        value="{{ old('jumlah') }}">

    <br><br>

    <label>Satuan</label>
    <br>

    <input
        type="text"
        name="satuan"
        placeholder="Contoh: pcs, unit, box"
        value="{{ old('satuan') }}">

    <br><br>

    <label>Harga</label>
    <br>

    <input
        type="number"
        name="harga"
        value="{{ old('harga') }}">

    <br><br>

    <label>Keterangan</label>
    <br>

    <textarea
        name="keterangan"
        rows="4"
        cols="40">{{ old('keterangan') }}</textarea>

    <br><br>

    <button type="submit">
        Simpan
    </button>

    <a href="{{ route('stock_barang.index') }}">
        Batal
    </a>

</form>

</body>
</html>