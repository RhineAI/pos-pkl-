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
        Schema::create('pengembalian_barang', function (Blueprint $table) {
            $table->increments('id_pengembalian_barang');
            $table->integer('invoice');
            $table->integer('id_produk');
            $table->integer('jumlah_asal');
            $table->integer('jumlah_kembali');
            
            $table->string('keterangan');
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
        Schema::dropIfExists('pengembalian_barangs');
    }
};
