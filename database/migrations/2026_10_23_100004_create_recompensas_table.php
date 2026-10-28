<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recompensas', function (Blueprint $table) {
            $table->id('Id_recompensa');
            $table->string('Nombre', 100);
            $table->string('Descripcion', 255)->nullable();
            $table->integer('Costo_puntos');
            $table->string('Tipo', 30)->default('descuento');
            $table->decimal('Valor', 10, 2)->nullable();
            $table->string('Icono', 10)->nullable();
            $table->boolean('Repetible')->default(false);
            $table->boolean('Activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recompensas');
    }
};
