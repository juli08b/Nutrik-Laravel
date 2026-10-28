@extends('layouts.app')

@section('title', 'Detalle de usuario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h4 mb-3">Usuario #{{ data_get($usuario, 'Id_usuario') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Tipo</dt><dd class="col-sm-8">{{ data_get($usuario, 'Tipo_usuario') }}</dd>
                    <dt class="col-sm-4">Primer nombre</dt><dd class="col-sm-8">{{ data_get($usuario, 'NombreUno_usuario') }}</dd>
                    <dt class="col-sm-4">Segundo nombre</dt><dd class="col-sm-8">{{ data_get($usuario, 'NombreDos_usuario') ?: '—' }}</dd>
                    <dt class="col-sm-4">Apellido</dt><dd class="col-sm-8">{{ data_get($usuario, 'ApellidoDos_usuario') }}</dd>
                    <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ data_get($usuario, 'Email') }}</dd>
                    <dt class="col-sm-4">Teléfono</dt><dd class="col-sm-8">{{ data_get($usuario, 'Telefono') ?: '—' }}</dd>
                    <dt class="col-sm-4">Dirección</dt><dd class="col-sm-8">{{ data_get($usuario, 'Direccion') ?: '—' }}</dd>
                    <dt class="col-sm-4">Nacimiento</dt><dd class="col-sm-8">{{ data_get($usuario, 'Fecha_nacimiento') ?: '—' }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('usuarios.edit', data_get($usuario, 'Id_usuario')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
