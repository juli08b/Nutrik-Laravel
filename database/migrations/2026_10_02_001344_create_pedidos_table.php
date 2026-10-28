<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('Id_pedido');
            $table->string('Estado', 50);
            $table->date('Fecha_salida');
            $table->date('Fecha_Llegada');
            $table->string('Metodo_pago', 50);
            $table->decimal('Subtotal', 10, 2);
            $table->decimal('Costo_envio', 10, 2);
            $table->decimal('Total_pedido', 10, 2);
            $table->string('Direccion_envio', 255);
            $table->string('Ciudad_envio', 100);

            // Llave foránea hacia usuarios_sistemas
            $table->unsignedBigInteger('Id_usuario');
            $table->foreign('Id_usuario')->references('Id_usuario')->on('usuarios_sistemas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
