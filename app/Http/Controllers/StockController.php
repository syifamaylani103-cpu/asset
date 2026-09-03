<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Menampilkan data stock dengan paginasi (10 - 20 data per halaman).
     */
    public function index(Request $request)
    {
        $perPage = (int)$request->get('per_page', 10);
        if (!in_array($perPage, [10, 15, 20, 50, 100])) {
            $perPage = 10;
        }

        $stock = Stock::with('jenisBarang')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('stock_barang.index', compact('stock', 'perPage'));
    }

    /**
     * Menampilkan form tambah stock.
     */
    public function create()
    {
        $jenisBarang = JenisBarang::all();

        return view('stock_barang.create', compact('jenisBarang'));
    }

    /**
     * Menyimpan stock baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'nama_barang' => 'required|max:255',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|max:50',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        Stock::create([
            'jenis_barang_id' => $request->jenis_barang_id,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('stock_barang.index')
            ->with('success', 'Stock berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail stock.
     */
    public function show($id)
    {
        $stock = Stock::with('jenisBarang')->findOrFail($id);

        return view('stock_barang.show', compact('stock'));
    }

    /**
     * Menampilkan form edit stock.
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        $jenisBarang = JenisBarang::all();

        return view(
            'stock_barang.edit',
            compact('stock', 'jenisBarang')
        );
    }

    /**
     * Mengupdate stock.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_barang_id' => 'required|exists:jenis_barang,id',
            'nama_barang' => 'required|max:255',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|max:50',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable'
        ]);

        $stock = Stock::findOrFail($id);

        $stock->update([
            'jenis_barang_id' => $request->jenis_barang_id,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('stock_barang.index')
            ->with('success', 'Stock berhasil diperbarui.');
    }

    /**
     * Menghapus stock.
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);

        $stock->delete();

        return redirect()
            ->route('stock_barang.index')
            ->with('success', 'Stock berhasil dihapus.');
    }

    /**
     * Memperbarui banyak stock sekaligus dari form tabel.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'stocks' => 'required|array',
            'stocks.*.id' => 'required|exists:stock,id',
            'stocks.*.jumlah' => 'required|integer|min:0',
            'stocks.*.harga' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->stocks as $item) {
                $data = [
                    'jumlah' => $item['jumlah']
                ];
                if (isset($item['harga'])) {
                    $data['harga'] = $item['harga'];
                }
                Stock::where('id', $item['id'])->update($data);
            }
        });

        $count = count($request->stocks);

        return redirect()
            ->route('stock_barang.index', array_filter([
                'page' => $request->get('page'),
                'per_page' => $request->get('per_page'),
            ]))
            ->with('success', "Berhasil memperbarui {$count} data stok barang sekaligus.");
    }

    /**
     * Mengunduh file template CSV (berisi data stok saat ini) untuk diedit di Excel.
     */
    public function exportTemplate()
    {
        $stocks = Stock::with('jenisBarang')->orderBy('nama_barang')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_stok_barang.csv"',
        ];

        return response()->stream(function () use ($stocks) {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 agar karakter rapi di Microsoft Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header CSV
            fputcsv($handle, ['id', 'nama_barang', 'jenis_barang', 'satuan', 'jumlah', 'harga']);

            if ($stocks->count() > 0) {
                foreach ($stocks as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->nama_barang,
                        $item->jenisBarang->nama_jenis ?? '',
                        $item->satuan,
                        $item->jumlah,
                        $item->harga,
                    ]);
                }
            } else {
                fputcsv($handle, ['1', 'Contoh Nama Barang A', 'Elektronik', 'Pcs', '100', '150000']);
                fputcsv($handle, ['2', 'Contoh Nama Barang B', 'Alat Tulis', 'Pcs', '50', '25000']);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Mengimpor dan mengupdate data stok barang secara massal dari file CSV.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        // Deteksi pemisah / delimiter (koma atau titik koma)
        $firstLine = fgets(fopen($filePath, 'r'));
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return redirect()
                ->route('stock_barang.index')
                ->with('error', 'Gagal membuka file CSV.');
        }

        // Baca baris header
        $rawHeader = fgetcsv($handle, 1000, $delimiter);
        if (!$rawHeader) {
            fclose($handle);
            return redirect()
                ->route('stock_barang.index')
                ->with('error', 'File CSV kosong atau tidak terbaca.');
        }

        // Normalisasi header (hilangkan BOM, karakter non-alfanumerik, lowercase)
        $header = array_map(function ($col) {
            $cleaned = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $col);
            return strtolower(trim($cleaned));
        }, $rawHeader);

        $idIndex = array_search('id', $header);
        $namaIndex = array_search('nama_barang', $header);
        $jumlahIndex = array_search('jumlah', $header);
        $hargaIndex = array_search('harga', $header);
        $jenisIndex = array_search('jenis_barang', $header);
        $satuanIndex = array_search('satuan', $header);

        if ($jumlahIndex === false && $namaIndex === false && $idIndex === false) {
            fclose($handle);
            return redirect()
                ->route('stock_barang.index')
                ->with('error', 'Format CSV tidak valid. Pastikan kolom memuat "id" atau "nama_barang", dan "jumlah".');
        }

        $updatedCount = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (empty(array_filter($row))) {
                    continue;
                }

                $id = ($idIndex !== false && isset($row[$idIndex])) ? trim($row[$idIndex]) : null;
                $namaBarang = ($namaIndex !== false && isset($row[$namaIndex])) ? trim($row[$namaIndex]) : null;
                $jumlah = ($jumlahIndex !== false && isset($row[$jumlahIndex])) ? trim($row[$jumlahIndex]) : null;
                $harga = ($hargaIndex !== false && isset($row[$hargaIndex])) ? trim($row[$hargaIndex]) : null;

                // Cari barang berdasarkan id, jika gagal cari berdasarkan nama_barang
                $stockItem = null;
                if (!empty($id) && is_numeric($id)) {
                    $stockItem = Stock::find($id);
                }
                if (!$stockItem && !empty($namaBarang)) {
                    $stockItem = Stock::where('nama_barang', $namaBarang)->first();
                }

                if ($stockItem) {
                    $updateData = [];
                    if ($jumlah !== null && is_numeric($jumlah)) {
                        $updateData['jumlah'] = (int)$jumlah;
                    }
                    if ($harga !== null && is_numeric($harga)) {
                        $updateData['harga'] = (float)$harga;
                    }

                    if (!empty($updateData)) {
                        $stockItem->update($updateData);
                        $updatedCount++;
                    }
                } elseif (!empty($namaBarang)) {
                    // Jika data belum ada (misal di laptop teman), otomatis buat baru
                    $namaJenis = ($jenisIndex !== false && isset($row[$jenisIndex]) && !empty(trim($row[$jenisIndex]))) 
                        ? trim($row[$jenisIndex]) 
                        : 'Elektronik';
                    
                    $jenisBarang = JenisBarang::firstOrCreate(['nama_jenis' => $namaJenis]);
                    $satuan = ($satuanIndex !== false && isset($row[$satuanIndex]) && !empty(trim($row[$satuanIndex]))) 
                        ? trim($row[$satuanIndex]) 
                        : 'Unit';

                    Stock::create([
                        'jenis_barang_id' => $jenisBarang->id,
                        'nama_barang' => $namaBarang,
                        'jumlah' => ($jumlah !== null && is_numeric($jumlah)) ? (int)$jumlah : 0,
                        'satuan' => $satuan,
                        'harga' => ($harga !== null && is_numeric($harga)) ? (float)$harga : 0,
                    ]);
                    $updatedCount++;
                }
            }

            DB::commit();
            fclose($handle);

            return redirect()
                ->route('stock_barang.index', array_filter([
                    'page' => $request->get('page'),
                    'per_page' => $request->get('per_page'),
                ]))
                ->with('success', "Berhasil memperbarui {$updatedCount} data stok barang dari file CSV.");
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return redirect()
                ->route('stock_barang.index')
                ->with('error', 'Terjadi kesalahan saat memproses CSV: ' . $e->getMessage());
        }
    }
}