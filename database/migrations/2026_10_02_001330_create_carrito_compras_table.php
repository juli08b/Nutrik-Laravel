<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carrito_compras', function (Blueprint $table) {
            $table->id('Id_carrite'); // Respetando el nombre de tu diagrama
            $table->integer('Cantidad');
            $table->decimal('Total', 10, 2);

            // Llave foránea hacia usuarios_sistemas
            $table->unsignedBigInteger('Id_usuario');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_compras');
    }
};
