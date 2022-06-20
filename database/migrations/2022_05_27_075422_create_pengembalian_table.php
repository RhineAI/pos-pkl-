<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->increments('id_pengembalian');
            $table->string('kode_pembelian');
            $table->integer('id_produk');
            // $table->integer('id_satuan');
            // $table->integer('total_harga');
            $table->integer('jumlah_awal');
            $table->integer('jumlah_retur');
            // $table->float('diskon')->default(0);  
            // $table->integer('bayar')->default(0);  
            // $table->integer('diterima')->default(0);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
};
