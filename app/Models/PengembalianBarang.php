<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianBarang extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_barang';
    protected $primaryKey = 'id_pengembalian_barang';
    protected $guarded = [];

    public function produk() 
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
}
