<?php

namespace Database\Seeders;

use App\Models\Logro;
use App\Models\Recompensa;
use App\Models\Reto;
use Illuminate\Database\Seeder;

class GamificacionSeeder extends Seeder
{
    public function run(): void
    {
        $retos = [
            ['Nombre' => 'Tomar 2L de agua', 'Descripcion' => 'Hidrátate durante el día con agua.', 'Categoria' => 'hidratacion', 'Icono' => '💧', 'Puntos' => 15],
            ['Nombre' => 'Incluir vegetales', 'Descripcion' => 'Agrega vegetales a una de tus comidas.', 'Categoria' => 'alimentacion', 'Icono' => '🥬', 'Puntos' => 15],
            ['Nombre' => 'Consumir fruta', 'Descripcion' => 'Disfruta una fruta como parte de tu día.', 'Categoria' => 'alimentacion', 'Icono' => '🍎', 'Puntos' => 10],
            ['Nombre' => 'Caminar 20 minutos', 'Descripcion' => 'Da una caminata moderada para mover tu cuerpo.', 'Categoria' => 'movimiento', 'Icono' => '🚶', 'Puntos' => 20],
            ['Nombre' => 'Respirar y relajarte', 'Descripcion' => 'Toma 3 minutos para respirar profundo y relajarte.', 'Categoria' => 'bienestar', 'Icono' => '🧘', 'Puntos' => 10],
            ['Nombre' => 'Cuidar tu descanso', 'Descripcion' => 'Prioriza desconectar y cuidar tu descanso hoy.', 'Categoria' => 'bienestar', 'Icono' => '😴', 'Puntos' => 15],
        ];

        foreach ($retos as $reto) {
            Reto::firstOrCreate(['Nombre' => $reto['Nombre']], array_merge($reto, ['Activo' => true]));
        }

        $recompensas = [
            ['Nombre' => '5% de descuento', 'Descripcion' => 'Descuento del 5% en tu compra', 'Costo_puntos' => 100, 'Tipo' => 'descuento', 'Valor' => 5, 'Icono' => '🏷️'],
            ['Nombre' => '10% de descuento', 'Descripcion' => 'Descuento del 10% en tu compra', 'Costo_puntos' => 200, 'Tipo' => 'descuento', 'Valor' => 10, 'Icono' => '🎟️'],
            ['Nombre' => 'Recompensa especial Nutrik', 'Descripcion' => 'Recompensa especial por tu constancia', 'Costo_puntos' => 300, 'Tipo' => 'especial', 'Valor' => 0, 'Icono' => '💚'],
        ];

        foreach ($recompensas as $r) {
            Recompensa::firstOrCreate(['Nombre' => $r['Nombre']], array_merge($r, ['Activo' => true, 'Repetible' => false]));
        }

        $logros = [
            ['Nombre' => 'Primer paso', 'Descripcion' => 'Completa tu primer reto', 'Icono' => '🎯', 'Condicion' => 'primer_reto', 'Meta' => 1],
            ['Nombre' => 'Nuevo hábito', 'Descripcion' => 'Completa 5 retos', 'Icono' => '🌱', 'Condicion' => 'retos_completados', 'Meta' => 5],
            ['Nombre' => 'Constante', 'Descripcion' => 'Mantén una racha de 7 días', 'Icono' => '🔥', 'Condicion' => 'racha_dias', 'Meta' => 7],
            ['Nombre' => 'Cliente Nutrik', 'Descripcion' => 'Realiza tu primera compra', 'Icono' => '🛍️', 'Condicion' => 'primera_compra', 'Meta' => 1],
            ['Nombre' => 'Campeón de constancia', 'Descripcion' => 'Completa 20 retos', 'Icono' => '🏆', 'Condicion' => 'retos_completados', 'Meta' => 20],
        ];

        foreach ($logros as $l) {
            Logro::firstOrCreate(['Nombre' => $l['Nombre']], $l);
        }
    }
}
