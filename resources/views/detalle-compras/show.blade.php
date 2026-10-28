@extends('layouts.app')

@section('title', 'Detalle de compra')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h4 mb-3">Detalle de compra #{{ data_get($detalle, 'Id_Detalle') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Pedido</dt><dd class="col-sm-8">#{{ data_get($detalle, 'Id_pedido') }}</dd>
                    <dt class="col-sm-4">Producto</dt><dd class="col-sm-8">{{ data_get($detalle, 'producto.Nombre_producto', 'Producto '.data_get($detalle, 'Id_producto')) }}</dd>
                    <dt class="col-sm-4">Precio unitario</dt><dd class="col-sm-8">${{ number_format((float) data_get($detalle, 'Precio_unitario'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Cantidad</dt><dd class="col-sm-8">{{ data_get($detalle, 'Cantidad') }}</dd>
                    <dt class="col-sm-4">Subtotal</dt><dd class="col-sm-8 fw-semibold">${{ number_format((float) data_get($detalle, 'Subtotal'), 0, ',', '.') }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('detalle-compras.edit', data_get($detalle, 'Id_Detalle')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('detalle-compras.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
