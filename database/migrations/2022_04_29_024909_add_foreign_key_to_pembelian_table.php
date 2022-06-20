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
        Schema::table('pembelian', function (Blueprint $table) {
            // $table->increments('id_pembelian');
            $table->unsignedInteger('id_supplier')->nullable()->after('id_pembelian');
            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('supplier')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->unsignedInteger('id_supplier')->change();
            $table->dropForeign('pembelian_id_supplier_foreign');
        });
    }
};
