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
        Schema::create('orden_detalles', function (Blueprint $table) {
            $table->id();          

            $table->integer('cantidad');
            $table->float('precio');
            $table->json('contenido')->nullable();            

            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('producto_id');

            $table->foreign('orden_id')->references('id')->on('ordens');
            $table->foreign('producto_id')->references('id')->on('productos');

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
        Schema::dropIfExists('orden_detalles');
    }
};
