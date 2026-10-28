@php
    $prefix = $prefix ?? '';
    $id = $id ?? null;
@endphp
<div class="d-inline-flex gap-1">
    <a href="{{ route($prefix.'.show', $id) }}" class="btn btn-sm btn-outline-success">Ver</a>
    <a href="{{ route($prefix.'.edit', $id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
    <form action="{{ route($prefix.'.destroy', $id) }}" method="POST" class="d-inline"
          onsubmit="return confirm('¿Eliminar este registro?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
    </form>
</div>
