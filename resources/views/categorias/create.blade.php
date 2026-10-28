@extends('layouts.app')

@section('title', 'Nueva categoría')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Nueva categoría</h1>
            <div class="card card-simple p-4">
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="Nombre_categoria" class="form-control" value="{{ old('Nombre_categoria') }}" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de producto *</label>
                        <input type="text" name="Tipo_producto" class="form-control" value="{{ old('Tipo_producto') }}" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="Descripccion" class="form-control" maxlength="400" rows="3">{{ old('Descripccion') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
