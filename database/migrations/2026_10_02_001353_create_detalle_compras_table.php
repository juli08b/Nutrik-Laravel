<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id('Id_Detalle');
            $table->decimal('Precio_unitario', 10, 2);
            $table->decimal('Subtotal', 10, 2);
            $table->integer('Cantidad');

            // Llave foránea hacia pedidos
            $table->unsignedBigInteger('Id_pedido');
            $table->foreign('Id_pedido')->references('Id_pedido')->on('pedidos')->onDelete('cascade');

            // Llave foránea hacia productos
            $table->unsignedBigInteger('Id_producto');
            $table->foreign('Id_producto')->references('Id_producto')->on('productos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_compras');
    }
};
