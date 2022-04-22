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
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->string('barcode')->unique();
            $table->string('nama_produk')->unique();
            $table->integer('id_kategori');
            $table->integer('id_satuan');
            $table->integer('harga_beli');
            $table->integer('diskon');
            $table->integer('harga_jual');
            $table->integer('id_stok');
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
        Schema::dropIfExists('produk');
    }
};
