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
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('NIT');
            $table->string('Nombre', 60);
            $table->string('Apellido', 60);
            $table->bigInteger('idTipoCliente')->unsigned();
            $table->foreign('idTipoCliente')->references('id')->on('tipo_clientes');
            $table->string('Telefono', 60);
            $table->string('Direccion', 60);
            $table->boolean('Estado')->default(1);
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
