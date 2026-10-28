@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Usuarios del sistema <span class="text-muted">({{ $usuarios->count() }})</span></h1>
        <a href="{{ route('usuarios.create') }}" class="btn btn-success">+ Nuevo usuario</a>
    </div>

    <div class="card card-simple">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $u)
                        <tr>
                            <td>{{ data_get($u, 'Id_usuario') }}</td>
                            <td class="fw-semibold">{{ data_get($u, 'NombreUno_usuario') }} {{ data_get($u, 'ApellidoDos_usuario') }}</td>
                            <td>{{ data_get($u, 'Tipo_usuario') }}</td>
                            <td>{{ data_get($u, 'Email') }}</td>
                            <td>{{ data_get($u, 'Telefono') }}</td>
                            <td class="text-end">
                                @include('includes.acciones', ['prefix' => 'usuarios', 'id' => data_get($u, 'Id_usuario')])
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay usuarios registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
