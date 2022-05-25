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
        Schema::table('produk_supplier', function (Blueprint $table) {
            // $table->increments('id_produk_supplier');
            $table->unsignedInteger('id_supplier')->nullable()->after('id_produk_supplier');
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
        Schema::table('produk_supplier', function (Blueprint $table) {
            //
        });
    }
};
