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
        Schema::table('produk', function (Blueprint $table) {
            $table->unsignedInteger('id_kategori')->change();
            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');

            $table->unsignedInteger('id_satuan')->change();
            $table->foreign('id_satuan')
                  ->references('id_satuan')
                  ->on('satuan')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');

            // $table->unsignedInteger('id_stok')->change();
            // $table->foreign('id_stok')
            //       ->references('id_stok')
            //       ->on('stok_masuk')
            //       ->onUpdate('restrict')
            //       ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->unsignedInteger('id_kategori')->change();
            $table->dropForeign('produk_id_kategori_foreign');

            $table->unsignedInteger('id_satuan')->change();
            $table->dropForeign('produk_id_satuan_foreign');
        });
    }
};
