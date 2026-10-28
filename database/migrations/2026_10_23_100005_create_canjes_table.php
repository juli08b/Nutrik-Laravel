<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canjes', function (Blueprint $table) {
            $table->id('Id_canje');
            $table->unsignedBigInteger('Id_usuario');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');
            $table->unsignedBigInteger('Id_recompensa');
            $table->foreign('Id_recompensa')->references('Id_recompensa')->on('recompensas')->onDelete('cascade');
            $table->integer('Puntos_usados');
            $table->string('Estado', 20)->default('activo');
            $table->date('Fecha');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canjes');
    }
};
