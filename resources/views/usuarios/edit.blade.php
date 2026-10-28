@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h4 mb-3">Editar usuario <span class="text-muted">#{{ data_get($usuario, 'Id_usuario') }}</span></h1>
            <div class="card card-simple p-4">
                <form action="{{ route('usuarios.update', data_get($usuario, 'Id_usuario')) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de usuario *</label>
                            <input type="text" name="Tipo_usuario" class="form-control" value="{{ old('Tipo_usuario', data_get($usuario, 'Tipo_usuario')) }}" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="Email" class="form-control" value="{{ old('Email', data_get($usuario, 'Email')) }}" maxlength="100" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primer nombre *</label>
                            <input type="text" name="NombreUno_usuario" class="form-control" value="{{ old('NombreUno_usuario', data_get($usuario, 'NombreUno_usuario')) }}" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Segundo nombre</label>
                            <input type="text" name="NombreDos_usuario" class="form-control" value="{{ old('NombreDos_usuario', data_get($usuario, 'NombreDos_usuario')) }}" maxlength="50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="ApellidoDos_usuario" class="form-control" value="{{ old('ApellidoDos_usuario', data_get($usuario, 'ApellidoDos_usuario')) }}" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="Telefono" class="form-control" value="{{ old('Telefono', data_get($usuario, 'Telefono')) }}" maxlength="20">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="Direccion" class="form-control" value="{{ old('Direccion', data_get($usuario, 'Direccion')) }}" maxlength="50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="Fecha_nacimiento" class="form-control" value="{{ old('Fecha_nacimiento', data_get($usuario, 'Fecha_nacimiento')) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
