<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Dokumen Pengajuan - {{ $pengajuan->kode_pengajuan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            color: #666;
        }
        .document-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-info td {
            padding: 5px;
            vertical-align: top;
        }
        .table-info td:first-child {
            width: 30%;
            font-weight: bold;
        }
        .table-info td:nth-child(2) {
            width: 5%;
            text-align: center;
        }
        .signature-section {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            width: 40%;
            float: right;
            text-align: center;
        }
        .signature-space {
            height: 80px;
        }
        .clear {
            clear: both;
        }
        /* Style specifically for table grid if needed later */
        .table-grid th, .table-grid td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table-grid th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SISTEM MANAJEMEN ASET</h2>
            <p>Bukti Persetujuan Pengajuan Barang</p>
        </div>

        <div class="document-title">
            DOKUMEN PENGAJUAN BARANG
        </div>

        <table class="table-info">
            <tr>
                <td>Kode Pengajuan</td>
                <td>:</td>
                <td>{{ $pengajuan->kode_pengajuan }}</td>
            </tr>
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><strong>DISETUJUI</strong></td>
            </tr>
        </table>

        <h3>A. Detail Pemohon</h3>
        <table class="table-info">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $pengajuan->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $pengajuan->user->email ?? '-' }}</td>
            </tr>
        </table>

        <h3>B. Detail Barang</h3>
        <table class="table-info">
            <tr>
                <td>Nama Barang</td>
                <td>:</td>
                <td>{{ $pengajuan->barang->nama_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>:</td>
                <td>{{ $pengajuan->barang->category->nama_category ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jumlah Disetujui</td>
                <td>:</td>
                <td>{{ $pengajuan->jumlah }} Unit</td>
            </tr>
            <tr>
                <td>Tujuan Penggunaan</td>
                <td>:</td>
                <td>{{ $pengajuan->tujuan }}</td>
            </tr>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <p>Mengetahui/Menyetujui,<br>Admin Sistem Asset</p>
                <div class="signature-space"></div>
                <p><strong>( ______________________ )</strong></p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>
