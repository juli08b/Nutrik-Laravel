@extends('layouts.app')

@section('title', 'Carrito')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Carrito de compras <span class="text-muted">({{ $carrito->count() }})</span></h1>
        <a href="{{ route('carrito.create') }}" class="btn btn-success">+ Agregar ítem</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Usuario</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($carrito as $c)
                        <tr>
                            <td>{{ data_get($c, 'Id_carrite') }}</td>
                            <td class="fw-semibold">{{ data_get($c, 'Cantidad') }}</td>
                            <td>${{ number_format((float) data_get($c, 'Total'), 0, ',', '.') }}</td>
                            <td>{{ data_get($c, 'usuario.NombreUno_usuario', '—') }} {{ data_get($c, 'usuario.ApellidoDos_usuario', '') }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'carrito', 'id' => data_get($c, 'Id_carrite')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">El carrito está vacío.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
