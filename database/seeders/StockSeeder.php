<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBarang;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Pastikan Jenis Barang Ada
        $elektronik = JenisBarang::firstOrCreate(
            ['nama_jenis' => 'Elektronik'],
            ['keterangan' => 'Peralatan dan perangkat elektronik']
        );

        // 2. Daftar 11 Data Stok Barang
        $dataStock = [
            [
                'nama_barang' => 'Laptop Lenovo Thinkpad',
                'jumlah' => 18,
                'satuan' => 'Unit',
                'harga' => 5000000,
                'keterangan' => null,
            ],
            [
                'nama_barang' => 'Monitor Dell 24 Inch',
                'jumlah' => 99,
                'satuan' => 'Unit',
                'harga' => 1950000,
                'keterangan' => null,
            ],
            [
                'nama_barang' => 'kipas',
                'jumlah' => 111,
                'satuan' => 'Unit',
                'harga' => 120000,
                'keterangan' => 'ytju',
            ],
            [
                'nama_barang' => 'Ac',
                'jumlah' => 200,
                'satuan' => 'Unit',
                'harga' => 5000000,
                'keterangan' => 'jkjk',
            ],
            [
                'nama_barang' => 'cctv',
                'jumlah' => 40,
                'satuan' => 'Unit',
                'harga' => 10000000,
                'keterangan' => 'jykuyr',
            ],
            [
                'nama_barang' => 'tv',
                'jumlah' => 100,
                'satuan' => 'Unit',
                'harga' => 100000000,
                'keterangan' => 'djty',
            ],
            [
                'nama_barang' => 'pc',
                'jumlah' => 80,
                'satuan' => 'Unit',
                'harga' => 12000000,
                'keterangan' => 'hk6io',
            ],
            [
                'nama_barang' => 'cdfhgdf',
                'jumlah' => 342,
                'satuan' => 'Unit',
                'harga' => 5000000,
                'keterangan' => 'asder',
            ],
            [
                'nama_barang' => 'dfrrg',
                'jumlah' => 222,
                'satuan' => 'Unit',
                'harga' => 233000,
                'keterangan' => 'jklui',
            ],
            [
                'nama_barang' => 'asfef',
                'jumlah' => 453,
                'satuan' => 'Unit',
                'harga' => 222000,
                'keterangan' => 'fgjghn',
            ],
            [
                'nama_barang' => 'fggfh',
                'jumlah' => 555,
                'satuan' => 'Unit',
                'harga' => 6564000,
                'keterangan' => 'uk u',
            ],
        ];

        foreach ($dataStock as $item) {
            Stock::updateOrCreate(
                ['nama_barang' => $item['nama_barang']],
                [
                    'jenis_barang_id' => $elektronik->id,
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                    'harga' => $item['harga'],
                    'keterangan' => $item['keterangan'],
                ]
            );
        }
    }
}
