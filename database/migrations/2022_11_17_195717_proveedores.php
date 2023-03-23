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
        Schema::create('Proveedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nit');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('banco');
            $table->string('cuenta');
            $table->string('razon_social');
            $table->string('NombreContacto');
            $table->bigInteger('TelefonoContacto');
            $table->boolean('estado')->default('1');
            $table->bigInteger('cuenta_id')->unsigned();
            $table->bigInteger('regimen_id')->unsigned();
            $table->bigInteger('idtipo_proveedor')->unsigned();
            $table->foreign('idtipo_proveedor')->references('id')->on('tipo_proveedor');
            $table->foreign('cuenta_id')->references('id')->on('tiposcuentas');
            $table->foreign('regimen_id')->references('id')->on('regimen');
            $table->unsignedBigInteger('user_id');
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
