<?php

use App\Http\Controllers\Web\CarritoController;
use App\Http\Controllers\Web\CategoriaController;
use App\Http\Controllers\Web\DescuentoController;
use App\Http\Controllers\Web\DetalleCompraController;
use App\Http\Controllers\Web\PedidoController;
use App\Http\Controllers\Web\ProductoController;
use App\Http\Controllers\Web\UsuarioController;
use App\Http\Middleware\EnsureLocalEnvironment;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Capa cliente web de Nutrik
|--------------------------------------------------------------------------
| Estas vistas administrativas solo están disponibles en entorno local y
| consultan la base de datos directamente desde sus controladores web.
*/

Route::middleware(EnsureLocalEnvironment::class)->group(function () {
    // Página de inicio: menú principal de administración
    Route::view('/', 'home')->name('home');

    // ==========================================
    // USUARIOS DEL SISTEMA
    // ==========================================
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // ==========================================
    // CATEGORÍAS
    // ==========================================
    Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::get('categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    // ==========================================
    // PRODUCTOS
    // ==========================================
    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::get('productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
    Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // ==========================================
    // DESCUENTOS
    // ==========================================
    Route::get('descuentos', [DescuentoController::class, 'index'])->name('descuentos.index');
    Route::get('descuentos/create', [DescuentoController::class, 'create'])->name('descuentos.create');
    Route::get('descuentos/{id}', [DescuentoController::class, 'show'])->name('descuentos.show');
    Route::post('descuentos', [DescuentoController::class, 'store'])->name('descuentos.store');
    Route::get('descuentos/{id}/edit', [DescuentoController::class, 'edit'])->name('descuentos.edit');
    Route::put('descuentos/{id}', [DescuentoController::class, 'update'])->name('descuentos.update');
    Route::delete('descuentos/{id}', [DescuentoController::class, 'destroy'])->name('descuentos.destroy');

    // ==========================================
    // CARRITO DE COMPRAS
    // ==========================================
    Route::get('carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::get('carrito/create', [CarritoController::class, 'create'])->name('carrito.create');
    Route::get('carrito/{id}', [CarritoController::class, 'show'])->name('carrito.show');
    Route::post('carrito', [CarritoController::class, 'store'])->name('carrito.store');
    Route::get('carrito/{id}/edit', [CarritoController::class, 'edit'])->name('carrito.edit');
    Route::put('carrito/{id}', [CarritoController::class, 'update'])->name('carrito.update');
    Route::delete('carrito/{id}', [CarritoController::class, 'destroy'])->name('carrito.destroy');

    // ==========================================
    // PEDIDOS
    // ==========================================
    Route::get('pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::get('pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::post('pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('pedidos/{id}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('pedidos/{id}', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('pedidos/{id}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

    // ==========================================
    // DETALLE DE COMPRAS
    // ==========================================
    Route::get('detalle-compras', [DetalleCompraController::class, 'index'])->name('detalle-compras.index');
    Route::get('detalle-compras/create', [DetalleCompraController::class, 'create'])->name('detalle-compras.create');
    Route::get('detalle-compras/{id}', [DetalleCompraController::class, 'show'])->name('detalle-compras.show');
    Route::post('detalle-compras', [DetalleCompraController::class, 'store'])->name('detalle-compras.store');
    Route::get('detalle-compras/{id}/edit', [DetalleCompraController::class, 'edit'])->name('detalle-compras.edit');
    Route::put('detalle-compras/{id}', [DetalleCompraController::class, 'update'])->name('detalle-compras.update');
    Route::delete('detalle-compras/{id}', [DetalleCompraController::class, 'destroy'])->name('detalle-compras.destroy');
});
