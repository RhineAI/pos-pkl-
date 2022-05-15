<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $table = 'stok_masuk';
    protected $primaryKey = 'id_stok';
    protected $guarded = [];
    protected $fillable = ['jumlah', 'keterangan'];


    public function produk() 
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
