<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->text('Descripcion')->nullable()->after('Id_categoria');
            $table->integer('Stock')->default(0)->after('Descripcion');
            $table->string('Imagen', 500)->nullable()->after('Stock');
            $table->string('Estado', 20)->default('Activo')->after('Imagen');
            $table->string('Vendedor', 100)->nullable()->after('Estado');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['Descripcion', 'Stock', 'Imagen', 'Estado', 'Vendedor']);
        });
    }
};
