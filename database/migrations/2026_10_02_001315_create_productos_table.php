<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('Id_producto');
            $table->string('Nombre_producto', 100);
            $table->decimal('Precio', 10, 2);

            // Llave foránea hacia categorias
            $table->unsignedBigInteger('Id_categoria');
            $table->foreign('Id_categoria')->references('Id_categoria')->on('categorias')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
