<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'jenis_barang';

    protected $fillable = [
        'nama_jenis',
        'keterangan'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'jenis_barang_id');
    }
}