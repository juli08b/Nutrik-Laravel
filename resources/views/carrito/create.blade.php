@extends('layouts.app')

@section('title', 'Agregar al carrito')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Agregar ítem al carrito</h1>
            <div class="card card-simple p-4">
                <form action="{{ route('carrito.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cantidad *</label>
                            <input type="number" min="1" name="Cantidad" class="form-control" value="{{ old('Cantidad') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total *</label>
                            <input type="number" step="0.01" min="0" name="Total" class="form-control" value="{{ old('Total') }}" required>
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
                    <a href="{{ route('carrito.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
