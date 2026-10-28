@extends('layouts.app')

@section('title', 'Nuevo descuento')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Nuevo descuento</h1>
            <div class="card card-simple p-4">
                <form action="{{ route('descuentos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Valor del descuento *</label>
                        <input type="number" step="0.01" min="0" name="Valor_descuento" class="form-control" value="{{ old('Valor_descuento') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha inicio *</label>
                            <input type="date" name="Fecha_inicio" class="form-control" value="{{ old('Fecha_inicio') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha fin *</label>
                            <input type="date" name="Fecha_fin" class="form-control" value="{{ old('Fecha_fin') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usuario *</label>
                        <select name="Id_usuario" class="form-select" required>
                            <option value="">Seleccione un usuario</option>
                            @foreach ($usuarios as $u)
                                <option value="{{ data_get($u, 'Id_usuario') }}" @selected(old('Id_usuario') == data_get($u, 'Id_usuario'))>
                                    {{ data_get($u, 'NombreUno_usuario') }} {{ data_get($u, 'ApellidoDos_usuario') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('descuentos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
