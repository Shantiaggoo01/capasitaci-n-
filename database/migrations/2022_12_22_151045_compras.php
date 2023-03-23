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
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nFactura')->Unique();
            $table->bigInteger('id_proveedor')->unsigned();
            $table->bigInteger('id_insumo')->unsigned();
            $table->date('FechaCompra');
            $table->double('Total', 60);
            $table->unsignedBigInteger('user_id'); // <!--<--- agregue esto para guardar el usuario que creo la compra  -->

            $table->foreign('id_proveedor')->references('id')->on('Proveedores');
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
