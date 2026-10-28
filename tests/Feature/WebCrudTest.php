<?php

namespace Tests\Feature;

use App\Models\CarritoCompra;
use App\Models\Categoria;
use App\Models\Descuento;
use App\Models\DetalleCompra;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\UsuarioSistema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WebCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_crud_reads_and_writes_directly_to_the_database(): void
    {
        config(['app.env' => 'local']);
        Http::fake();

        $this->post(route('usuarios.store'), [
            'Tipo_usuario' => 'Cliente',
            'NombreUno_usuario' => 'Maria',
            'ApellidoDos_usuario' => 'Lopez',
            'Email' => 'maria@example.test',
        ])->assertRedirect(route('usuarios.index'));

        $usuario = UsuarioSistema::where('Email', 'maria@example.test')->firstOrFail();
        $this->assertDatabaseHas('usuarios_sistemas', [
            'Id_usuario' => $usuario->Id_usuario,
            'NombreUno_usuario' => 'Maria',
        ]);

        $this->post(route('categorias.store'), [
            'Nombre_categoria' => 'Frutas',
            'Descripccion' => 'Frutas frescas',
            'Tipo_producto' => 'Alimento',
        ])->assertRedirect(route('categorias.index'));

        $categoria = Categoria::where('Nombre_categoria', 'Frutas')->firstOrFail();
        $this->post(route('productos.store'), [
            'Nombre_producto' => 'Manzana',
            'Precio' => 10.50,
            'Id_categoria' => $categoria->Id_categoria,
            'Stock' => 8,
        ])->assertRedirect(route('productos.index'));

        $producto = Producto::where('Nombre_producto', 'Manzana')->firstOrFail();
        $this->post(route('descuentos.store'), [
            'Valor_descuento' => 10,
            'Fecha_inicio' => '2026-10-01',
            'Fecha_fin' => '2026-10-31',
            'Id_usuario' => $usuario->Id_usuario,
        ])->assertRedirect(route('descuentos.index'));

        $descuento = Descuento::firstOrFail();
        $this->post(route('carrito.store'), [
            'Cantidad' => 2,
            'Total' => 21,
            'Id_usuario' => $usuario->Id_usuario,
        ])->assertRedirect(route('carrito.index'));

        $carrito = CarritoCompra::firstOrFail();
        $this->post(route('pedidos.store'), [
            'Estado' => 'Pendiente',
            'Fecha_salida' => '2026-10-01',
            'Fecha_Llegada' => '2026-10-05',
            'Metodo_pago' => 'Tarjeta',
            'Subtotal' => 21,
            'Costo_envio' => 0,
            'Total_pedido' => 21,
            'Direccion_envio' => 'Calle 1',
            'Ciudad_envio' => 'Bogota',
            'Id_usuario' => $usuario->Id_usuario,
        ])->assertRedirect(route('pedidos.index'));

        $pedido = Pedido::firstOrFail();
        $this->post(route('detalle-compras.store'), [
            'Precio_unitario' => 10.50,
            'Subtotal' => 21,
            'Cantidad' => 2,
            'Id_pedido' => $pedido->Id_pedido,
            'Id_producto' => $producto->Id_producto,
        ])->assertRedirect(route('detalle-compras.index'));

        $detalle = DetalleCompra::firstOrFail();

        $this->put(route('usuarios.update', $usuario->Id_usuario), [
            'NombreUno_usuario' => 'Maria Elena',
        ])->assertRedirect(route('usuarios.index'));
        $this->put(route('categorias.update', $categoria->Id_categoria), [
            'Nombre_categoria' => 'Frutas frescas',
        ])->assertRedirect(route('categorias.index'));
        $this->put(route('productos.update', $producto->Id_producto), [
            'Precio' => 12,
        ])->assertRedirect(route('productos.index'));
        $this->put(route('descuentos.update', $descuento->Id_descuento), [
            'Valor_descuento' => 12,
        ])->assertRedirect(route('descuentos.index'));
        $this->put(route('carrito.update', $carrito->Id_carrite), [
            'Cantidad' => 3,
        ])->assertRedirect(route('carrito.index'));
        $this->put(route('pedidos.update', $pedido->Id_pedido), [
            'Estado' => 'Enviado',
        ])->assertRedirect(route('pedidos.index'));
        $this->put(route('detalle-compras.update', $detalle->Id_Detalle), [
            'Cantidad' => 3,
        ])->assertRedirect(route('detalle-compras.index'));

        foreach ([
            'usuarios' => $usuario->Id_usuario,
            'categorias' => $categoria->Id_categoria,
            'productos' => $producto->Id_producto,
            'descuentos' => $descuento->Id_descuento,
            'carrito' => $carrito->Id_carrite,
            'pedidos' => $pedido->Id_pedido,
            'detalle-compras' => $detalle->Id_Detalle,
        ] as $resource => $id) {
            $this->get(route($resource.'.index'))->assertOk();
            $this->get(route($resource.'.create'))->assertOk();
            $this->get(route($resource.'.show', $id))->assertOk();
            $this->get(route($resource.'.edit', $id))->assertOk();
        }

        foreach ([
            ['detalle-compras.destroy', $detalle->Id_Detalle, 'detalle_compras', 'Id_Detalle'],
            ['carrito.destroy', $carrito->Id_carrite, 'carrito_compras', 'Id_carrite'],
            ['descuentos.destroy', $descuento->Id_descuento, 'descuentos', 'Id_descuento'],
            ['pedidos.destroy', $pedido->Id_pedido, 'pedidos', 'Id_pedido'],
            ['productos.destroy', $producto->Id_producto, 'productos', 'Id_producto'],
            ['categorias.destroy', $categoria->Id_categoria, 'categorias', 'Id_categoria'],
            ['usuarios.destroy', $usuario->Id_usuario, 'usuarios_sistemas', 'Id_usuario'],
        ] as [$route, $id, $table, $primaryKey]) {
            $this->delete(route($route, $id))->assertRedirect();
            $this->assertDatabaseMissing($table, [$primaryKey => $id]);
        }

        Http::assertNothingSent();
    }
}
