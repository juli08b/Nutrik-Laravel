@extends('layouts.app')

@section('title', 'Detalle de producto')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Producto #{{ data_get($producto, 'Id_producto') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nombre</dt><dd class="col-sm-8">{{ data_get($producto, 'Nombre_producto') }}</dd>
                    <dt class="col-sm-4">Precio</dt><dd class="col-sm-8">${{ number_format((float) data_get($producto, 'Precio'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Categoría</dt><dd class="col-sm-8">{{ data_get($producto, 'categoria.Nombre_categoria', '—') }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('productos.edit', data_get($producto, 'Id_producto')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
