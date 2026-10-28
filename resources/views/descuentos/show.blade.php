@extends('layouts.app')

@section('title', 'Detalle de descuento')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Descuento #{{ data_get($descuento, 'Id_descuento') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Valor</dt><dd class="col-sm-8">${{ number_format((float) data_get($descuento, 'Valor_descuento'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Fecha inicio</dt><dd class="col-sm-8">{{ data_get($descuento, 'Fecha_inicio') }}</dd>
                    <dt class="col-sm-4">Fecha fin</dt><dd class="col-sm-8">{{ data_get($descuento, 'Fecha_fin') }}</dd>
                    <dt class="col-sm-4">Usuario</dt><dd class="col-sm-8">{{ data_get($descuento, 'usuario.NombreUno_usuario', '—') }} {{ data_get($descuento, 'usuario.ApellidoDos_usuario', '') }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('descuentos.edit', data_get($descuento, 'Id_descuento')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('descuentos.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
