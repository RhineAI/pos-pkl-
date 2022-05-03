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
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->unsignedInteger('id_pembelian')->change();
            $table->foreign('id_pembelian')
                ->references('id_pembelian')
                ->on('pembelian')
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
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->unsignedInteger('id_pembelian')->change();
            $table->dropForeign('pembelian_id_pembelian_foreign');
        });
    }
};
