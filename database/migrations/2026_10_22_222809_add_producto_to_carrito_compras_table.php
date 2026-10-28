<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carrito_compras', function (Blueprint $table) {
            // La vitrina de React usa un catálogo propio; guardamos también el
            // nombre y el precio para no depender de la tabla productos.
            $table->unsignedBigInteger('Id_producto')->nullable()->after('Id_carrite');
            $table->string('Nombre_producto', 100)->nullable()->after('Id_producto');
            $table->decimal('Precio_unitario', 10, 2)->nullable()->after('Nombre_producto');
            $table->string('Imagen', 500)->nullable()->after('Precio_unitario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrito_compras', function (Blueprint $table) {
            $table->dropColumn(['Id_producto', 'Nombre_producto', 'Precio_unitario', 'Imagen']);
        });
    }
};
