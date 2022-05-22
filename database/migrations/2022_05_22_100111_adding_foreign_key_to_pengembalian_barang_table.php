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
        Schema::table('pengembalian_barang', function (Blueprint $table) {
            $table->unsignedInteger('id_supplier')->change();
            $table->foreign('id_supplier')
                ->references('id_supplier')
                ->on('supplier')
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
        Schema::table('pengembalian_barang', function (Blueprint $table) {
                $table->unsignedInteger('id_supplier')->change();
                $table->dropForeign('supplier_id_supplier_foreign');
        });
    }
};
