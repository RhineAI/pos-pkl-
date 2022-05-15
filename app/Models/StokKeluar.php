<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $table = 'stok_keluar';
    protected $primaryKey = 'id_stok';
    protected $guarded = [];

    public function produk() 
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
