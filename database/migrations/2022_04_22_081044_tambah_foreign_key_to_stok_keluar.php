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
            $table->unsignedInteger('id_stok')->change();
            $table->foreign('id_stok')
                  ->references('id_stok')
                  ->on('stok_keluar')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
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
            $table->unsignedInteger('id_stok')->change();
            $table->dropForeign('produk_id_stok_foreign2');
        });
    }
};
