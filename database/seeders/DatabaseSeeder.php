<?php

namespace Database\Seeders;

use App\Models\CarritoCompra;
use App\Models\Categoria;
use App\Models\Descuento;
use App\Models\DetalleCompra;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Models\UsuarioSistema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario para el login de la API (POST /api/login)
        User::updateOrCreate(
            ['email' => 'admin@nutrik.test'],
            ['name' => 'Admin Nutrik', 'password' => Hash::make('password')],
        );

        // ── Datos demo de Nutrik ──
        $categorias = collect([
            ['Nombre_categoria' => 'Frutas', 'Descripccion' => 'Frutas frescas', 'Tipo_producto' => 'Alimento'],
            ['Nombre_categoria' => 'Verduras', 'Descripccion' => 'Verduras de huerta', 'Tipo_producto' => 'Alimento'],
            ['Nombre_categoria' => 'Suplementos', 'Descripccion' => 'Proteínas y vitaminas', 'Tipo_producto' => 'Suplemento'],
        ])->map(fn ($data) => Categoria::updateOrCreate(['Nombre_categoria' => $data['Nombre_categoria']], $data));

        $productos = collect([
            ['Nombre_producto' => 'Manzana roja', 'Precio' => 3500, 'Id_categoria' => $categorias[0]->Id_categoria],
            ['Nombre_producto' => 'Banano', 'Precio' => 2000, 'Id_categoria' => $categorias[0]->Id_categoria],
            ['Nombre_producto' => 'Lechuga', 'Precio' => 1800, 'Id_categoria' => $categorias[1]->Id_categoria],
            ['Nombre_producto' => 'Proteína whey', 'Precio' => 85000, 'Id_categoria' => $categorias[2]->Id_categoria],
        ])->map(fn ($data) => Producto::updateOrCreate(['Nombre_producto' => $data['Nombre_producto']], $data));

        $usuarios = collect([
            ['Tipo_usuario' => 'Cliente', 'NombreUno_usuario' => 'Ana', 'ApellidoDos_usuario' => 'Gómez', 'Email' => 'ana@nutrik.test', 'Telefono' => '3001112233', 'Direccion' => 'Calle 1 # 2-3', 'Fecha_nacimiento' => '1995-04-12'],
            ['Tipo_usuario' => 'Cliente', 'NombreUno_usuario' => 'Luis', 'ApellidoDos_usuario' => 'Pérez', 'Email' => 'luis@nutrik.test', 'Telefono' => '3004445566', 'Direccion' => 'Carrera 4 # 5-6', 'Fecha_nacimiento' => '1990-09-30'],
        ])->map(fn ($data) => UsuarioSistema::updateOrCreate(['Email' => $data['Email']], $data));

        $descuentos = collect([
            ['Valor_descuento' => 10, 'Fecha_inicio' => '2026-01-01', 'Fecha_fin' => '2026-12-31', 'Id_usuario' => $usuarios[0]->Id_usuario],
        ])->map(fn ($data) => Descuento::updateOrCreate(
            ['Id_usuario' => $data['Id_usuario'], 'Fecha_inicio' => $data['Fecha_inicio']],
            $data,
        ));

        $carritos = collect([
            ['Cantidad' => 2, 'Total' => 7000, 'Id_usuario' => $usuarios[0]->Id_usuario],
            ['Cantidad' => 1, 'Total' => 85000, 'Id_usuario' => $usuarios[1]->Id_usuario],
        ])->map(fn ($data) => CarritoCompra::updateOrCreate(
            ['Id_usuario' => $data['Id_usuario']],
            $data,
        ));

        $pedidos = collect([
            [
                'Estado' => 'Pendiente', 'Fecha_salida' => '2026-02-01', 'Fecha_Llegada' => '2026-02-03',
                'Metodo_pago' => 'Tarjeta', 'Subtotal' => 5000, 'Costo_envio' => 2000, 'Total_pedido' => 7000,
                'Direccion_envio' => 'Calle 1 # 2-3', 'Ciudad_envio' => 'Bogotá', 'Id_usuario' => $usuarios[0]->Id_usuario,
            ],
            [
                'Estado' => 'Enviado', 'Fecha_salida' => '2026-02-05', 'Fecha_Llegada' => '2026-02-07',
                'Metodo_pago' => 'Efectivo', 'Subtotal' => 85000, 'Costo_envio' => 0, 'Total_pedido' => 85000,
                'Direccion_envio' => 'Carrera 4 # 5-6', 'Ciudad_envio' => 'Medellín', 'Id_usuario' => $usuarios[1]->Id_usuario,
            ],
        ])->map(fn ($data) => Pedido::updateOrCreate(
            ['Id_usuario' => $data['Id_usuario'], 'Fecha_salida' => $data['Fecha_salida']],
            $data,
        ));

        DetalleCompra::updateOrCreate(
            ['Id_pedido' => $pedidos[0]->Id_pedido, 'Id_producto' => $productos[0]->Id_producto],
            ['Precio_unitario' => 3500, 'Subtotal' => 3500, 'Cantidad' => 1],
        );
        DetalleCompra::updateOrCreate(
            ['Id_pedido' => $pedidos[1]->Id_pedido, 'Id_producto' => $productos[3]->Id_producto],
            ['Precio_unitario' => 85000, 'Subtotal' => 85000, 'Cantidad' => 1],
        );

        $this->call([
            GamificacionSeeder::class,
        ]);
    }
}
