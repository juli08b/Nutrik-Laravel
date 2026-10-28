<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_rachas', function (Blueprint $table) {
            $table->id('Id_racha');
            $table->unsignedBigInteger('Id_usuario')->unique();
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');
            $table->integer('Racha_actual')->default(0);
            $table->integer('Mejor_racha')->default(0);
            $table->integer('Dias_completados')->default(0);
            $table->date('Ultima_fecha')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_rachas');
    }
};
