@extends('layouts.app')

@section('title', 'Editar pedido')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="h4 mb-3">Editar pedido <span class="text-muted">#{{ data_get($pedido, 'Id_pedido') }}</span></h1>
            <div class="card card-simple p-4">
                <form action="{{ route('pedidos.update', data_get($pedido, 'Id_pedido')) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado *</label>
                            <input type="text" name="Estado" class="form-control" value="{{ old('Estado', data_get($pedido, 'Estado')) }}" maxlength="50" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Método de pago *</label>
                            <input type="text" name="Metodo_pago" class="form-control" value="{{ old('Metodo_pago', data_get($pedido, 'Metodo_pago')) }}" maxlength="50" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Usuario *</label>
                            <select name="Id_usuario" class="form-select" required>
                                <option value="">Seleccione un usuario</option>
                                @foreach ($usuarios as $u)
                                    <option value="{{ data_get($u, 'Id_usuario') }}" @selected(old('Id_usuario', data_get($pedido, 'Id_usuario')) == data_get($u, 'Id_usuario'))>
                                        {{ data_get($u, 'NombreUno_usuario') }} {{ data_get($u, 'ApellidoDos_usuario') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha salida *</label>
                            <input type="date" name="Fecha_salida" class="form-control" value="{{ old('Fecha_salida', data_get($pedido, 'Fecha_salida')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha llegada *</label>
                            <input type="date" name="Fecha_Llegada" class="form-control" value="{{ old('Fecha_Llegada', data_get($pedido, 'Fecha_Llegada')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Subtotal *</label>
                            <input type="number" step="0.01" min="0" name="Subtotal" class="form-control" value="{{ old('Subtotal', data_get($pedido, 'Subtotal')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Costo envío *</label>
                            <input type="number" step="0.01" min="0" name="Costo_envio" class="form-control" value="{{ old('Costo_envio', data_get($pedido, 'Costo_envio')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total del pedido *</label>
                            <input type="number" step="0.01" min="0" name="Total_pedido" class="form-control" value="{{ old('Total_pedido', data_get($pedido, 'Total_pedido')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección de envío *</label>
                            <input type="text" name="Direccion_envio" class="form-control" value="{{ old('Direccion_envio', data_get($pedido, 'Direccion_envio')) }}" maxlength="255" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ciudad de envío *</label>
                            <input type="text" name="Ciudad_envio" class="form-control" value="{{ old('Ciudad_envio', data_get($pedido, 'Ciudad_envio')) }}" maxlength="100" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
