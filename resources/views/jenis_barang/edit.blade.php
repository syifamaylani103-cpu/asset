<!DOCTYPE html>
<html>
<head>
    <title>Edit Jenis Barang</title>
</head>
<body>

<h1>Edit Jenis Barang</h1>

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
    action="{{ route('jenis_barang.update', $jenisBarang->id) }}"
    method="POST">

    @csrf
    @method('PUT')

    <label>Nama Jenis</label>
    <br>

    <input
        type="text"
        name="nama_jenis"
        value="{{ old('nama_jenis', $jenisBarang->nama_jenis) }}">

    <br><br>

    <label>Keterangan</label>
    <br>

    <textarea
        name="keterangan"
        rows="4"
        cols="40">{{ old('keterangan', $jenisBarang->keterangan) }}</textarea>

    <br><br>

    <button type="submit">
        Update
    </button>

    <a href="{{ route('jenis_barang.index') }}">
        Batal
    </a>

</form>

</body>
</html>