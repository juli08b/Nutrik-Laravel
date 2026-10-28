@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-2">Panel de Administración - Nutrik</h1>
        <p class="text-muted mb-0">Selecciona la tabla que deseas gestionar:</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-3">
        <div class="col">
            <a href="{{ route('usuarios.index') }}" class="card card-simple h-100 text-decoration-none border-start border-primary border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">👥 Usuarios</h2>
                    <p class="text-muted small mb-0">Gestionar usuarios del sistema</p>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('categorias.index') }}" class="card card-simple h-100 text-decoration-none border-start border-success border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">📂 Categorías</h2>
                    <p class="text-muted small mb-0">Gestionar categorías de productos</p>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('productos.index') }}" class="card card-simple h-100 text-decoration-none border-start border-secondary border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">🛍️ Productos</h2>
                    <p class="text-muted small mb-0">Gestionar catálogo y stock</p>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('descuentos.index') }}" class="card card-simple h-100 text-decoration-none border-start border-warning border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">🏷️ Descuentos</h2>
                    <p class="text-muted small mb-0">Gestionar cupones y rebajas</p>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('carrito.index') }}" class="card card-simple h-100 text-decoration-none border-start border-danger border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">🛒 Carrito de Compras</h2>
                    <p class="text-muted small mb-0">Ver y editar carritos activos</p>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('pedidos.index') }}" class="card card-simple h-100 text-decoration-none border-start border-info border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">📦 Pedidos</h2>
                    <p class="text-muted small mb-0">Gestionar órdenes de compra</p>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('detalle-compras.index') }}" class="card card-simple h-100 text-decoration-none border-start border-dark border-4">
                <div class="card-body">
                    <h2 class="h5 text-dark">📋 Detalle de Compras</h2>
                    <p class="text-muted small mb-0">Ver los detalles internos de los pedidos</p>
                </div>
            </a>
        </div>
    </div>
@endsection
