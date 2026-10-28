@extends('layouts.app')

@section('title', 'Nuevo detalle de compra')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h4 mb-3">Nuevo detalle de compra</h1>
            <div class="card card-simple p-4">
                <form action="{{ route('detalle-compras.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pedido *</label>
                            <select name="Id_pedido" class="form-select" required>
                                <option value="">Seleccione un pedido</option>
                                @foreach ($pedidos as $p)
                                    <option value="{{ data_get($p, 'Id_pedido') }}" @selected(old('Id_pedido') == data_get($p, 'Id_pedido'))>
                                        #{{ data_get($p, 'Id_pedido') }} · {{ data_get($p, 'Estado') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Producto *</label>
                            <select name="Id_producto" class="form-select" required>
                                <option value="">Seleccione un producto</option>
                                @foreach ($productos as $prod)
                                    <option value="{{ data_get($prod, 'Id_producto') }}" @selected(old('Id_producto') == data_get($prod, 'Id_producto'))>
                                        {{ data_get($prod, 'Nombre_producto') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio unitario *</label>
                            <input type="number" step="0.01" min="0" name="Precio_unitario" class="form-control" value="{{ old('Precio_unitario') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cantidad *</label>
                            <input type="number" min="1" name="Cantidad" class="form-control" value="{{ old('Cantidad') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Subtotal *</label>
                            <input type="number" step="0.01" min="0" name="Subtotal" class="form-control" value="{{ old('Subtotal') }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('detalle-compras.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
