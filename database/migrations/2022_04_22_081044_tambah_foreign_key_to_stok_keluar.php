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
            // $table->unsignedInteger('id_produk')->change();
            // $table->foreign('id_produk')
            //       ->references('id_produk')
            //       ->on('stok_keluar')
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
        Schema::table('stok_keluar', function (Blueprint $table) {
            $table->unsignedInteger('id_produk')->change();
            $table->dropForeign('produk_id_produk_foreign');
        });
    }
};
