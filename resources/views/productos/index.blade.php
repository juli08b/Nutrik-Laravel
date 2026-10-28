@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Productos <span class="text-muted">({{ $productos->count() }})</span></h1>
        <a href="{{ route('productos.create') }}" class="btn btn-success">+ Nuevo producto</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $p)
                        <tr>
                            <td>{{ data_get($p, 'Id_producto') }}</td>
                            <td class="fw-semibold">{{ data_get($p, 'Nombre_producto') }}</td>
                            <td>${{ number_format((float) data_get($p, 'Precio'), 0, ',', '.') }}</td>
                            <td>{{ data_get($p, 'categoria.Nombre_categoria', '—') }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'productos', 'id' => data_get($p, 'Id_producto')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No hay productos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
