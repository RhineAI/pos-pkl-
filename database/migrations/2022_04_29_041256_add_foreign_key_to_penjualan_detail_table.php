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
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->unsignedInteger('id_penjualan')->change();
            $table->foreign('id_penjualan')
                ->references('id_penjualan')
                ->on('penjualan')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            // $table->unsignedInteger('id_produk')->change();
            // $table->foreign('id_produk')
            //     ->references('id_produk')
            //     ->on('produk')
            //     ->onUpdate('restrict')
            //     ->onDelete('restrict');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->unsignedInteger('id_penjualan')->change();
            $table->dropForeign('penjualan_detail_id_penjualan_foreign');

            // $table->unsignedInteger('id_produk')->change();
            // $table->dropForeign('produ_id_produk_foreign');
        });
    }
};
