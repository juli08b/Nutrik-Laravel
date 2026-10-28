<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retos', function (Blueprint $table) {
            $table->id('Id_reto');
            $table->string('Nombre', 100);
            $table->text('Descripcion')->nullable();
            $table->string('Categoria', 50);
            $table->string('Icono', 10)->nullable();
            $table->integer('Puntos')->default(10);
            $table->boolean('Activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retos');
    }
};
