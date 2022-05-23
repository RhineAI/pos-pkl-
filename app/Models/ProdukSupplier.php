<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSupplier extends Model
{
    use HasFactory;

    protected $table = 'produk_supplier';
    protected $primaryKey = 'id_produk_supplier';
    protected $guarded = [];

    public function produk() 
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
