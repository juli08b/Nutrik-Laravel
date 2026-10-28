@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Categorías <span class="text-muted">({{ $categorias->count() }})</span></h1>
        <a href="{{ route('categorias.create') }}" class="btn btn-success">+ Nueva categoría</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Tipo de producto</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $c)
                        <tr>
                            <td>{{ data_get($c, 'Id_categoria') }}</td>
                            <td class="fw-semibold">{{ data_get($c, 'Nombre_categoria') }}</td>
                            <td>{{ data_get($c, 'Tipo_producto') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit(data_get($c, 'Descripccion'), 60) }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'categorias', 'id' => data_get($c, 'Id_categoria')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No hay categorías registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
