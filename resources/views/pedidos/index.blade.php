@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pedidos <span class="text-muted">({{ $pedidos->count() }})</span></h1>
        <a href="{{ route('pedidos.create') }}" class="btn btn-success">+ Nuevo pedido</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Estado</th>
                        <th>Salida</th>
                        <th>Llegada</th>
                        <th>Pago</th>
                        <th>Total</th>
                        <th>Usuario</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $p)
                        <tr>
                            <td>{{ data_get($p, 'Id_pedido') }}</td>
                            <td class="fw-semibold">{{ data_get($p, 'Estado') }}</td>
                            <td>{{ data_get($p, 'Fecha_salida') }}</td>
                            <td>{{ data_get($p, 'Fecha_Llegada') }}</td>
                            <td>{{ data_get($p, 'Metodo_pago') }}</td>
                            <td>${{ number_format((float) data_get($p, 'Total_pedido'), 0, ',', '.') }}</td>
                            <td>{{ data_get($p, 'usuario.NombreUno_usuario', '—') }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'pedidos', 'id' => data_get($p, 'Id_pedido')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No hay pedidos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
