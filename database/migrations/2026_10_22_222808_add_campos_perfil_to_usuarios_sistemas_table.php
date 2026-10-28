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
        Schema::table('usuarios_sistemas', function (Blueprint $table) {
            $table->string('Contrasena', 255)->nullable()->after('Email');
            $table->string('SegundoApellido', 50)->nullable()->after('ApellidoDos_usuario');
            $table->string('Genero', 30)->nullable();
            $table->string('Estatura', 10)->nullable();
            $table->string('Peso', 10)->nullable();
            $table->string('Actividad', 30)->nullable();
            $table->string('Objetivo', 30)->nullable();
            $table->string('Alergia', 100)->nullable();
            $table->string('Dieta', 50)->nullable();
            $table->text('Restricciones')->nullable();
            $table->string('NombreNegocio', 100)->nullable();
            $table->string('Nit', 30)->nullable();
            $table->string('Ciudad', 50)->nullable();
            $table->string('TipoProductos', 100)->nullable();
            $table->text('DescripcionNegocio')->nullable();
            $table->longText('Foto')->nullable();
            $table->string('FotoPosicion', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios_sistemas', function (Blueprint $table) {
            $table->dropColumn([
                'Contrasena',
                'SegundoApellido',
                'Genero',
                'Estatura',
                'Peso',
                'Actividad',
                'Objetivo',
                'Alergia',
                'Dieta',
                'Restricciones',
                'NombreNegocio',
                'Nit',
                'Ciudad',
                'TipoProductos',
                'DescripcionNegocio',
                'Foto',
                'FotoPosicion',
            ]);
        });
    }
};
