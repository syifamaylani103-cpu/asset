<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $fillable = [
        'jenis_barang_id',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga',
        'keterangan'
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(
            JenisBarang::class,
            'jenis_barang_id'
        );
    }
}