@extends('layouts.app')

@section('title', 'Detalle del carrito')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Ítem del carrito #{{ data_get($item, 'Id_carrite') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Cantidad</dt><dd class="col-sm-8">{{ data_get($item, 'Cantidad') }}</dd>
                    <dt class="col-sm-4">Total</dt><dd class="col-sm-8">${{ number_format((float) data_get($item, 'Total'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Usuario</dt><dd class="col-sm-8">{{ data_get($item, 'usuario.NombreUno_usuario', '—') }} {{ data_get($item, 'usuario.ApellidoDos_usuario', '') }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('carrito.edit', data_get($item, 'Id_carrite')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('carrito.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
