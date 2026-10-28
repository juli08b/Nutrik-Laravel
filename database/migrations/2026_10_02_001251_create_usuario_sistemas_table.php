<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios_sistemas', function (Blueprint $table) {
            $table->id('Id_usuario');
            $table->string('Tipo_usuario', 50);
            $table->string('NombreUno_usuario', 50);
            $table->string('NombreDos_usuario', 50)->nullable();
            $table->string('ApellidoDos_usuario', 50);
            $table->string('Telefono', 20)->nullable();
            $table->string('Email', 100)->unique();
            $table->string('Direccion', 50)->nullable();
            $table->date('Fecha_nacimiento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios_sistemas');
    }
};
