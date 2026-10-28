<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_logros', function (Blueprint $table) {
            $table->id('Id_usuario_logro');
            $table->unsignedBigInteger('Id_usuario');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');
            $table->unsignedBigInteger('Id_logro');
            $table->foreign('Id_logro')->references('Id_logro')->on('logros')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['Id_usuario', 'Id_logro']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_logros');
    }
};
