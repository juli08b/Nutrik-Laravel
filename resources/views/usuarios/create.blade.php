@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h4 mb-3">Nuevo usuario</h1>
            <div class="card card-simple p-4">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de usuario *</label>
                            <input type="text" name="Tipo_usuario" class="form-control" value="{{ old('Tipo_usuario') }}" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="Email" class="form-control" value="{{ old('Email') }}" maxlength="100" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primer nombre *</label>
                            <input type="text" name="NombreUno_usuario" class="form-control" value="{{ old('NombreUno_usuario') }}" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Segundo nombre</label>
                            <input type="text" name="NombreDos_usuario" class="form-control" value="{{ old('NombreDos_usuario') }}" maxlength="50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="ApellidoDos_usuario" class="form-control" value="{{ old('ApellidoDos_usuario') }}" maxlength="50" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="Telefono" class="form-control" value="{{ old('Telefono') }}" maxlength="20">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="Direccion" class="form-control" value="{{ old('Direccion') }}" maxlength="50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de nacimiento</label>
                            <input type="date" name="Fecha_nacimiento" class="form-control" value="{{ old('Fecha_nacimiento') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
