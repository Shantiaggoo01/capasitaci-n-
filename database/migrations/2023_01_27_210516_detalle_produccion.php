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
        Schema::create('detalle_produccion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_produccion')->unsigned();
            $table->bigInteger('id_producto')->unsigned();
            $table->bigInteger('cantidad',);   
            
            $table->foreign('id_produccion')->references('id')->on('produccion');
            $table->foreign('id_producto')->references('id')->on('productos');

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
