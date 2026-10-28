@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Editar producto <span class="text-muted">#{{ data_get($producto, 'Id_producto') }}</span></h1>
            <div class="card card-simple p-4">
                <form action="{{ route('productos.update', data_get($producto, 'Id_producto')) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="Nombre_producto" class="form-control" value="{{ old('Nombre_producto', data_get($producto, 'Nombre_producto')) }}" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio *</label>
                        <input type="number" step="0.01" min="0" name="Precio" class="form-control" value="{{ old('Precio', data_get($producto, 'Precio')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría *</label>
                        <select name="Id_categoria" class="form-select" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ data_get($cat, 'Id_categoria') }}" @selected(old('Id_categoria', data_get($producto, 'Id_categoria')) == data_get($cat, 'Id_categoria'))>
                                    {{ data_get($cat, 'Nombre_categoria') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
