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
        Schema::create('insumos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre', 60)->unique();
            $table->string('TipoCantidad', 60);
            $table->integer('Medida');
            $table->double('Precio', 60);
            $table->integer('cantidad')->default(0);
            $table->integer('cantidadxMedida')->default(0);
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
