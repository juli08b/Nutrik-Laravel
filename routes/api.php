<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoCompraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\GamificacionController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioSistemaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API NUTRIK (JSON)
|--------------------------------------------------------------------------
| Laravel antepone "/api" automáticamente (bootstrap/app.php),
| así que todas las URLs quedan como: /api/v1/...
| Los nombres de ruta quedan como: v1.productos.index, v1.usuarios.login, etc.
*/

Route::prefix('v1')->name('v1.')->group(function () {

    // ── Públicas: autenticación (con límite de intentos) ──
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('login', [AuthController::class, 'apiLogin'])->name('login');
        Route::post('usuarios/login', [UsuarioSistemaController::class, 'login'])->name('usuarios.login');
        Route::post('usuarios/verificar', [UsuarioSistemaController::class, 'verificar'])->name('usuarios.verificar');
        Route::post('usuarios/restablecer', [UsuarioSistemaController::class, 'restablecer'])->name('usuarios.restablecer');
    });

    // Registro de usuarios nuevos (público)
    Route::post('usuarios', [UsuarioSistemaController::class, 'store'])->name('usuarios.store');

    // ── Públicas: catálogo (solo lectura) y contacto ──
    Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);
    Route::apiResource('productos', ProductoController::class)->only(['index', 'show']);
    Route::apiResource('descuentos', DescuentoController::class)->only(['index', 'show']);
    Route::post('contactos', [ContactoController::class, 'store'])->name('contactos.store');

    // ── Protegidas por token (Sanctum) ──
    Route::middleware('auth:sanctum')->group(function () {

        // Sesión
        Route::post('logout', [AuthController::class, 'apiLogout'])->name('logout');
        Route::get('user', [AuthController::class, 'apiUser'])->name('user');

        // Usuarios (el registro público ya está arriba)
        Route::apiResource('usuarios', UsuarioSistemaController::class)->except(['store']);

        // Escritura del catálogo (ideal: restringir a rol administrador)
        Route::apiResource('categorias', CategoriaController::class)->except(['index', 'show']);
        Route::apiResource('productos', ProductoController::class)->except(['index', 'show']);
        Route::apiResource('descuentos', DescuentoController::class)->except(['index', 'show']);
        Route::get('contactos', [ContactoController::class, 'index'])->name('contactos.index');

        // Compras
        Route::apiResource('carrito', CarritoCompraController::class);
        Route::apiResource('pedidos', PedidoController::class);
        Route::apiResource('detalle-compras', DetalleCompraController::class);

        // Gamificación (cliente)
        Route::prefix('gamificacion/{idUsuario}')
            ->whereNumber('idUsuario')
            ->name('gamificacion.')
            ->controller(GamificacionController::class)
            ->group(function () {
                Route::get('dashboard', 'dashboard')->name('dashboard');
                Route::get('retos', 'retos')->name('retos');
                Route::post('retos/{idUsuarioReto}/completar', 'completarReto')
                    ->whereNumber('idUsuarioReto')->name('retos.completar');
                Route::get('puntos', 'puntos')->name('puntos');
                Route::get('recompensas', 'recompensas')->name('recompensas');
                Route::post('recompensas/canjear', 'canjear')->name('recompensas.canjear');
                Route::get('logros', 'logros')->name('logros');
                Route::get('racha', 'racha')->name('racha');
                Route::get('perfil', 'perfilIntegrado')->name('perfil');
            });
    });
});
