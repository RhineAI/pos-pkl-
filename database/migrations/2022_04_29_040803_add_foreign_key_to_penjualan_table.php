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
        Schema::table('penjualan', function (Blueprint $table) {
            // $table->unsignedInteger('id_penjualan')->change();
            // $table->foreign('id_penjualan')
            //     ->references('id_penjualan')
            //     ->on('penjualan_detail')
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
        Schema::table('penjualan', function (Blueprint $table) {
            // $table->unsignedInteger('id_penjualan')->change();
            // $table->dropForeign('penjualan_id_penjualan_foreign');
        });
    }
};
