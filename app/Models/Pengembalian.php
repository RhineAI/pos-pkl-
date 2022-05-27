<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';
    protected $guarded = [];

    public function produk() 
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
