<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_retos', function (Blueprint $table) {
            $table->id('Id_usuario_reto');
            $table->unsignedBigInteger('Id_usuario');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');
            $table->unsignedBigInteger('Id_reto');
            $table->foreign('Id_reto')->references('Id_reto')->on('retos')->onDelete('cascade');
            $table->date('Fecha');
            $table->boolean('Completado')->default(false);
            $table->timestamp('Completado_en')->nullable();
            $table->integer('Puntos_obtenidos')->default(0);
            $table->timestamps();

            $table->unique(['Id_usuario', 'Id_reto', 'Fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_retos');
    }
};
