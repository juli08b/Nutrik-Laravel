<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logros', function (Blueprint $table) {
            $table->id('Id_logro');
            $table->string('Nombre', 100);
            $table->string('Descripcion', 255);
            $table->string('Icono', 10)->nullable();
            $table->string('Condicion', 50);
            $table->integer('Meta')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logros');
    }
};
