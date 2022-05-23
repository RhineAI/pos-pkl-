<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public function pengembalianBarang() {
        return $this->belongsTo(PengembalianBarang::class, 'id_produk', 'id_produk');
    }
    
    public function supplier() {
        return $this->belongsToMany(Supplier::class, 'produk_supplier', 'id_supplier', 'id_produk');
    }
}
