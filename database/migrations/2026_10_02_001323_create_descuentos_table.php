<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id('Id_descuento');
            $table->decimal('Valor_descuento', 10, 2);
            $table->date('Fecha_inicio');
            $table->date('Fecha_fin');

            // Llave foránea hacia usuarios_sistemas
            $table->unsignedBigInteger('Id_usuario');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
