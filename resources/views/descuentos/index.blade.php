@extends('layouts.app')

@section('title', 'Descuentos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Descuentos <span class="text-muted">({{ $descuentos->count() }})</span></h1>
        <a href="{{ route('descuentos.create') }}" class="btn btn-success">+ Nuevo descuento</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Usuario</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($descuentos as $d)
                        <tr>
                            <td>{{ data_get($d, 'Id_descuento') }}</td>
                            <td class="fw-semibold">${{ number_format((float) data_get($d, 'Valor_descuento'), 0, ',', '.') }}</td>
                            <td>{{ data_get($d, 'Fecha_inicio') }}</td>
                            <td>{{ data_get($d, 'Fecha_fin') }}</td>
                            <td>{{ data_get($d, 'usuario.NombreUno_usuario', '—') }} {{ data_get($d, 'usuario.ApellidoDos_usuario', '') }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'descuentos', 'id' => data_get($d, 'Id_descuento')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay descuentos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
