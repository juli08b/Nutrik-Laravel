@extends('layouts.app')

@section('title', 'Detalle de categoría')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h4 mb-3">Categoría #{{ data_get($categoria, 'Id_categoria') }}</h1>
            <div class="card card-simple p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nombre</dt><dd class="col-sm-8">{{ data_get($categoria, 'Nombre_categoria') }}</dd>
                    <dt class="col-sm-4">Tipo de producto</dt><dd class="col-sm-8">{{ data_get($categoria, 'Tipo_producto') }}</dd>
                    <dt class="col-sm-4">Descripción</dt><dd class="col-sm-8">{{ data_get($categoria, 'Descripccion') ?: '—' }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('categorias.edit', data_get($categoria, 'Id_categoria')) }}" class="btn btn-success">Editar</a>
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
