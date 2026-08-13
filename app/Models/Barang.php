<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'category_id',
        'stok',
        'harga',
        'deskripsi',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}