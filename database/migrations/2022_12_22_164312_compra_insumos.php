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
        //
        Schema::create('compra_insumos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_compra')->unsigned();
            $table->bigInteger('id_insumo')->unsigned();
            $table->bigInteger('cantidad',);   
            
            $table->foreign('id_compra')->references('id')->on('compras');
            $table->foreign('id_insumo')->references('id')->on('insumos');

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
        //
    }
};
