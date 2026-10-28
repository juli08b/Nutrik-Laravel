@extends('layouts.app')

@section('title', 'Detalle de compras')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Detalle de compras <span class="text-muted">({{ $detalles->count() }})</span></h1>
        <a href="{{ route('detalle-compras.create') }}" class="btn btn-success">+ Nuevo detalle</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Pedido</th>
                        <th>Producto</th>
                        <th>Precio unit.</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detalles as $d)
                        <tr>
                            <td>{{ data_get($d, 'Id_Detalle') }}</td>
                            <td>#{{ data_get($d, 'Id_pedido') }}</td>
                            <td class="fw-semibold">{{ data_get($d, 'producto.Nombre_producto', 'Producto '.data_get($d, 'Id_producto')) }}</td>
                            <td>${{ number_format((float) data_get($d, 'Precio_unitario'), 0, ',', '.') }}</td>
                            <td>{{ data_get($d, 'Cantidad') }}</td>
                            <td>${{ number_format((float) data_get($d, 'Subtotal'), 0, ',', '.') }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'detalle-compras', 'id' => data_get($d, 'Id_Detalle')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No hay detalles registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
