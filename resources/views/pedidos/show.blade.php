@extends('layouts.app')

@section('title', 'Detalle de pedido')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="h4 mb-3">Pedido #{{ data_get($pedido, 'Id_pedido') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Estado</dt><dd class="col-sm-8">{{ data_get($pedido, 'Estado') }}</dd>
                    <dt class="col-sm-4">Fecha salida</dt><dd class="col-sm-8">{{ data_get($pedido, 'Fecha_salida') }}</dd>
                    <dt class="col-sm-4">Fecha llegada</dt><dd class="col-sm-8">{{ data_get($pedido, 'Fecha_Llegada') }}</dd>
                    <dt class="col-sm-4">Método de pago</dt><dd class="col-sm-8">{{ data_get($pedido, 'Metodo_pago') }}</dd>
                    <dt class="col-sm-4">Subtotal</dt><dd class="col-sm-8">${{ number_format((float) data_get($pedido, 'Subtotal'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Costo envío</dt><dd class="col-sm-8">${{ number_format((float) data_get($pedido, 'Costo_envio'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Total</dt><dd class="col-sm-8 fw-semibold">${{ number_format((float) data_get($pedido, 'Total_pedido'), 0, ',', '.') }}</dd>
                    <dt class="col-sm-4">Dirección envío</dt><dd class="col-sm-8">{{ data_get($pedido, 'Direccion_envio') }}</dd>
                    <dt class="col-sm-4">Ciudad envío</dt><dd class="col-sm-8">{{ data_get($pedido, 'Ciudad_envio') }}</dd>
                    <dt class="col-sm-4">Usuario</dt><dd class="col-sm-8">{{ data_get($pedido, 'usuario.NombreUno_usuario', '—') }} {{ data_get($pedido, 'usuario.ApellidoDos_usuario', '') }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('pedidos.edit', data_get($pedido, 'Id_pedido')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
